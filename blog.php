<?php require_once 'header.php'; ?>
<?php require_once '../backend/db.php'; ?>

<div class="py-5" style="margin-top: 80px; background-color: var(--card-bg);">
    <div class="container">
        <div class="text-center" style="margin-bottom: 3rem;">
            <h1 style="color: var(--primary-blue);">Preaching & Blog</h1>
            <p>Pastor messages, devotions, and updates.</p>
        </div>

        <div style="max-width: 800px; margin: 0 auto;">
            <?php
            $stmt = $pdo->query("SELECT * FROM posts ORDER BY date DESC");
            $hasPosts = false;
            while ($post = $stmt->fetch()):
                $hasPosts = true;
            ?>
            <div class="card" style="margin-bottom: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <h2 style="color: var(--primary-gold); margin-bottom: 5px; font-size: 2rem;"><?= htmlspecialchars($post['title']) ?></h2>
                <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;"><i class="fas fa-calendar"></i> <?= htmlspecialchars($post['date']) ?></p>
                <div style="line-height: 1.8; color: var(--text-color);">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if (!$hasPosts): ?>
                <div class="alert alert-success text-center">
                    <i class="fas fa-book-open fa-2x"></i>
                    <p>No posts are available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
