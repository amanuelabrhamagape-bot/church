<?php 
require_once 'layout.php'; 
renderAdminHeader('Manage Sermons'); 

// Delete Sermon
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $pdo->query("DELETE FROM sermons WHERE id = $id");
    echo '<div class="alert alert-success" style="margin-bottom: 20px;">Sermon deleted successfully.</div>';
}

// Add Sermon
if (isset($_POST['add_sermon'])) {
    $title = trim($_POST['title']);
    $video = trim($_POST['video_url']);
    $speaker = trim($_POST['speaker']);
    $date = trim($_POST['date']);
    $desc = trim($_POST['description']);
    
    $stmt = $pdo->prepare("INSERT INTO sermons (title, video_url, speaker, date, description) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$title, $video, $speaker, $date, $desc])) {
        echo '<div class="alert alert-success" style="margin-bottom: 20px;">Sermon added successfully.</div>';
    }
}
?>

<div class="admin-header">
    <h1 style="color: var(--primary-blue);">Manage Video Sermons</h1>
</div>

<div class="grid-2" style="grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Add Form -->
    <div class="card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-plus-circle"></i> Add New Sermon</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label>Sermon Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>YouTube Video URL</label>
                <input type="url" name="video_url" class="form-control" required placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <div class="form-group">
                <label>Preacher / Speaker</label>
                <input type="text" name="speaker" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Date Preached</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Brief Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" name="add_sermon" class="btn btn-primary" style="width: 100%;">Add Sermon</button>
        </form>
    </div>

    <!-- Sermons List -->
    <div>
        <div class="table-responsive">
            <table>
                <tr>
                    <th>Date</th>
                    <th>Title & Speaker</th>
                    <th>Video Link</th>
                    <th>Action</th>
                </tr>
                <?php
                $stmt = $pdo->query("SELECT * FROM sermons ORDER BY date DESC");
                while ($row = $stmt->fetch()):
                ?>
                <tr>
                    <td style="white-space: nowrap;"><?= htmlspecialchars($row['date']) ?></td>
                    <td><strong><?= htmlspecialchars($row['title']) ?></strong><br><small><?= htmlspecialchars($row['speaker']) ?></small></td>
                    <td><a href="<?= htmlspecialchars($row['video_url']) ?>" target="_blank" style="color: var(--primary-blue);"><i class="fab fa-youtube" style="color: red;"></i> Watch</a></td>
                    <td>
                        <a href="?del=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Delete this sermon?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</div>

<?php renderAdminFooter(); ?>
