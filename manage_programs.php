<?php 
require_once 'layout.php'; 
renderAdminHeader('Manage Weekly Programs'); 

// Delete Program
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $pdo->query("DELETE FROM programs WHERE id = $id");
    echo '<div class="alert alert-success mt-3" style="margin-bottom: 20px;">Program deleted successfully.</div>';
}

// Add Program
if (isset($_POST['add_program'])) {
    $day = $_POST['day'];
    $time = $_POST['time'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $speaker = $_POST['speaker'];
    
    $stmt = $pdo->prepare("INSERT INTO programs (day, time, title, description, speaker) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$day, $time, $title, $desc, $speaker])) {
        echo '<div class="alert alert-success" style="margin-bottom: 20px;">Program added successfully.</div>';
    }
}
?>

<div class="admin-header">
    <h1 style="color: var(--primary-blue);">Manage Weekly Programs</h1>
</div>

<div class="grid-2" style="grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Add Form -->
    <div class="card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-plus-circle"></i> Add New Program</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label>Day of the Week</label>
                <select name="day" class="form-control" required>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                </select>
            </div>
            <div class="form-group">
                <label>Time (e.g., 09:00 AM)</label>
                <input type="text" name="time" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Speaker (Optional)</label>
                <input type="text" name="speaker" class="form-control">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" name="add_program" class="btn btn-primary" style="width: 100%;">Add Program</button>
        </form>
    </div>

    <!-- Programs List -->
    <div>
        <div class="table-responsive">
            <table>
                <tr>
                    <th>Day & Time</th>
                    <th>Title</th>
                    <th>Speaker</th>
                    <th>Action</th>
                </tr>
                <?php
                $stmt = $pdo->query("SELECT * FROM programs ORDER BY FIELD(day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), time ASC");
                while ($row = $stmt->fetch()):
                ?>
                <tr>
                    <td><strong><?= htmlspecialchars($row['day']) ?></strong><br><small><?= htmlspecialchars($row['time']) ?></small></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['speaker']) ?></td>
                    <td>
                        <a href="?del=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this program?');"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</div>

<?php renderAdminFooter(); ?>
