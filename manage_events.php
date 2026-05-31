<?php 
require_once 'layout.php'; 
renderAdminHeader('Manage Events'); 

// Delete Event
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $pdo->query("DELETE FROM events WHERE id = $id");
    echo '<div class="alert alert-success" style="margin-bottom: 20px;">Event deleted successfully.</div>';
}

// Add Event
if (isset($_POST['add_event'])) {
    $title = trim($_POST['title']);
    $date = trim($_POST['date']);
    $desc = trim($_POST['description']);
    
    $stmt = $pdo->prepare("INSERT INTO events (title, date, description) VALUES (?, ?, ?)");
    if ($stmt->execute([$title, $date, $desc])) {
        echo '<div class="alert alert-success" style="margin-bottom: 20px;">Event scheduled successfully.</div>';
    }
}
?>

<div class="admin-header">
    <h1 style="color: var(--primary-blue);">Manage Events & Programs</h1>
</div>

<div class="grid-2" style="grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Add Form -->
    <div class="card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-plus-circle"></i> Schedule Event</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label>Event Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Date & Time</label>
                <input type="datetime-local" name="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" name="add_event" class="btn btn-primary" style="width: 100%;">Schedule Event</button>
        </form>
    </div>

    <!-- Events List -->
    <div>
        <div class="table-responsive">
            <table>
                <tr>
                    <th>Event Date</th>
                    <th>Title & Desc</th>
                    <th>Action</th>
                </tr>
                <?php
                $stmt = $pdo->query("SELECT * FROM events ORDER BY date ASC");
                while ($row = $stmt->fetch()):
                    $formattedDate = date('M j, Y - g:i A', strtotime($row['date']));
                ?>
                <tr>
                    <td style="white-space: nowrap;"><strong><?= htmlspecialchars($formattedDate) ?></strong></td>
                    <td>
                        <strong style="color: var(--primary-blue); font-size: 1.1rem;"><?= htmlspecialchars($row['title']) ?></strong>
                        <p style="margin-top: 5px; font-size: 0.9rem; color: #64748b;"><?= htmlspecialchars(substr($row['description'], 0, 80)) . '...' ?></p>
                    </td>
                    <td>
                        <a href="?del=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Cancel this event?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</div>

<?php renderAdminFooter(); ?>
