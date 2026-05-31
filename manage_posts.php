<?php 
require_once 'layout.php'; 
renderAdminHeader('Manage Blog Posts'); 

// Delete Post
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $pdo->query("DELETE FROM posts WHERE id = $id");
    echo '<div class="alert alert-success" style="margin-bottom: 20px;">Post deleted successfully.</div>';
}

// Add Post
if (isset($_POST['add_post'])) {
    $title = trim($_POST['title']);
    $date = date('Y-m-d');
    $content = trim($_POST['content']);
    
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, date) VALUES (?, ?, ?)");
    if ($stmt->execute([$title, $content, $date])) {
        echo '<div class="alert alert-success" style="margin-bottom: 20px;">Post published successfully.</div>';
    }
}
?>

<div class="admin-header">
    <h1 style="color: var(--primary-blue);">Manage Blog Posts</h1>
</div>

<div class="grid-2" style="grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Add Form -->
    <div class="card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-plus-circle"></i> Write New Post</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label>Post Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="10" required></textarea>
            </div>
            <button type="submit" name="add_post" class="btn btn-primary" style="width: 100%;">Publish Post</button>
        </form>
    </div>

    <!-- Posts List -->
    <div>
        <div class="table-responsive">
            <table>
                <tr>
                    <th>Date Published</th>
                    <th>Title & Preview</th>
                    <th>Action</th>
                </tr>
                <?php
                $stmt = $pdo->query("SELECT * FROM posts ORDER BY date DESC");
                while ($row = $stmt->fetch()):
                ?>
                <tr>
                    <td style="white-space: nowrap;"><?= htmlspecialchars($row['date']) ?></td>
                    <td>
                        <strong style="color: var(--primary-blue); font-size: 1.1rem;"><?= htmlspecialchars($row['title']) ?></strong>
                        <p style="margin-top: 5px; font-size: 0.9rem; color: #64748b;"><?= htmlspecialchars(substr($row['content'], 0, 100)) . '...' ?></p>
                    </td>
                    <td>
                        <a href="?del=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Delete this post?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</div>

<?php renderAdminFooter(); ?>
