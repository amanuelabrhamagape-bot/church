<?php require_once 'header.php'; ?>
<?php require_once '../backend/db.php'; ?>

<div class="py-5" style="margin-top: 80px; background-color: var(--bg-color);">
    <div class="container">
        <div class="text-center" style="margin-bottom: 3rem;">
            <h1 style="color: var(--primary-blue);">Photo Gallery</h1>
            <p>Glimpses of worship, events, and community life.</p>
        </div>

        <div class="grid-3">
            <?php
            $stmt = $pdo->query("SELECT * FROM gallery ORDER BY id DESC");
            $hasImages = false;
            while ($img = $stmt->fetch()):
                $hasImages = true;
            ?>
            <div class="card" style="padding: 0; position: relative; cursor: pointer;">
                <img src="<?= htmlspecialchars($img['image_path']) ?>" style="width: 100%; height: 250px; object-fit: cover; border-radius: var(--border-radius); display: block;" alt="Gallery Image">
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); color: white; padding: 10px; text-align: center; border-radius: 0 0 var(--border-radius) var(--border-radius);">
                    <?= htmlspecialchars($img['category']) ?>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if (!$hasImages): ?>
                <div class="alert alert-success" style="grid-column: 1 / -1; text-align: center;">
                    <i class="fas fa-camera fa-2x"></i>
                    <p>No photos have been uploaded to the gallery yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
