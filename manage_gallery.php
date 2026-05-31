<?php 
require_once 'layout.php'; 

$error = '';
$success = '';

$dbDir = '../assets/uploads/gallery/';
$uploadDir = __DIR__ . '/../assets/uploads/gallery/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Check if PHP discarded the POST payload because it exceeded post_max_size
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0) {
    $error = "The uploaded file is too large for your server to process. Please increase post_max_size and upload_max_filesize in your php.ini file.";
}

// Upload Photo
if (isset($_POST['upload_photo'])) {
    $category = trim($_POST['category']);
    if (empty($category)) {
        $category = 'General';
    }
    
    // Check if file was uploaded successfully
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if ($fileSize > 100 * 1024 * 1024) {
            $error = "Upload failed. The photo exceeds the 100MB size limit.";
        } elseif (in_array($fileExt, $allowedExts)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExt;
            $dbPath = '../assets/uploads/gallery/' . $newFileName;
            $fsPath = __DIR__ . '/../assets/uploads/gallery/' . $newFileName;
            
            if (move_uploaded_file($fileTmpPath, $fsPath)) {
                $stmt = $pdo->prepare('INSERT INTO gallery (image_path, category) VALUES (?, ?)');
                if ($stmt->execute([$dbPath, $category])) {
                    $success = "Photo successfully added to the gallery.";
                } else {
                    $error = "Database error. Failed to save the record.";
                }
            } else {
                $error = "Could not save the uploaded file. Check folder permissions.";
            }
        } else {
            $error = "Invalid file type. Only JPG, PNG, GIF, and WEBP files are permitted.";
        }
    } else {
        // Provide specific error info if it fails (often due to php.ini limits)
        $phpFileUploadErrors = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );
        $errCode = $_FILES['photo']['error'];
        $error = "File upload failed: " . ($phpFileUploadErrors[$errCode] ?? 'Unknown Error') . ". If uploading a huge file, check your server's max upload settings.";
    }
}

// Delete Photo
if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    $stmt = $pdo->prepare('SELECT image_path FROM gallery WHERE id = ?');
    $stmt->execute([$id]);
    $img = $stmt->fetch();
    
    if ($img) {
        $deletePath = __DIR__ . '/' . $img['image_path'];
        if (file_exists($deletePath)) {
            unlink($deletePath); // Permanently delete the file from the server
        }
        $pdo->query("DELETE FROM gallery WHERE id = $id");
        $success = "Photo deleted successfully.";
    }
}

renderAdminHeader('Manage Photo Gallery'); 
?>

<div class="admin-header">
    <h1 style="color: var(--primary-blue);">Manage Photo Gallery</h1>
</div>

<?php if($error): ?>
    <div class="alert alert-error" style="margin-bottom: 20px; color: #ef4444; background: #fee2e2; border: 1px solid #fecaca; padding: 10px; border-radius: 6px; font-weight: 500;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if($success): ?>
    <div class="alert alert-success" style="margin-bottom: 20px; color: #166534; background: #dcfce7; border: 1px solid #bbf7d0; padding: 10px; border-radius: 6px; font-weight: 500;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="card" style="margin-bottom: 40px; border-top: 4px solid var(--primary-gold);">
    <h2 style="font-size: 1.4rem; margin-bottom: 20px; color: var(--primary-blue);"><i class="fas fa-upload"></i> Upload New Photo</h2>
    <form action="manage_gallery.php" method="POST" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Select Photo</label>
                <!-- Allowed large files assuming server has been configured to accept them -->
                <input type="file" name="photo" class="form-control" accept="image/*" required style="padding-bottom: 35px;">
                <small style="color: #64748b; margin-top: 5px; display: block;">Supports high resolution JPG, PNG, GIF, and WEBP files. Ensure your server permits up to your desired max limit in php.ini.</small>
            </div>
            
            <div class="form-group">
                <label>Category Tag</label>
                <!-- Users can select from pre-defined combos via datalist or type anything -->
                <input type="text" name="category" list="categories" class="form-control" placeholder="E.g. Sunday Worship" required>
                <datalist id="categories">
                    <option value="Sunday Worship">
                    <option value="Community Events">
                    <option value="Youth Ministry">
                    <option value="Bible Study">
                    <option value="Special Services">
                </datalist>
            </div>
        </div>
        <div style="margin-top: 15px;">
            <button type="submit" name="upload_photo" class="btn btn-primary"><i class="fas fa-cloud-upload-alt"></i> Upload to Gallery</button>
        </div>
    </form>
</div>

<div class="card">
    <h2 style="font-size: 1.4rem; margin-bottom: 20px; color: var(--primary-blue);"><i class="fas fa-images"></i> Uploaded Photos</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
        <?php
        $stmt = $pdo->query("SELECT * FROM gallery ORDER BY id DESC");
        $hasPhotos = false;
        while ($img = $stmt->fetch()):
            $hasPhotos = true;
        ?>
        <div style="border: 1px solid var(--border-color); border-radius: var(--border-radius); overflow: hidden; position: relative;">
            <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="<?= htmlspecialchars($img['category']) ?>" style="width: 100%; height: 150px; object-fit: cover; display: block;">
            <div style="padding: 10px; text-align: center; background: rgba(0,0,0,0.03);">
                <span style="font-weight: bold; color: var(--primary-blue); display: block; margin-bottom: 10px; font-size: 0.9rem;"><?= htmlspecialchars($img['category']) ?></span>
                <a href="?del_id=<?= $img['id'] ?>" class="btn" style="background: #fee2e2; color: #991b1b; padding: 5px 10px; font-size: 0.85rem;" onclick="return confirm('Permanently delete this photo from the server?');">
                    <i class="fas fa-trash"></i> Delete
                </a>
            </div>
        </div>
        <?php endwhile; ?>
        
        <?php if (!$hasPhotos): ?>
            <div style="grid-column: 1 / -1; padding: 40px; text-align: center; color: #64748b; font-style: italic;">
                The gallery is currently empty. Upload photos using the form above.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php renderAdminFooter(); ?>
