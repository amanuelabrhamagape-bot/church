<?php require_once 'header.php'; ?>
<?php require_once '../backend/db.php'; ?>

<div class="py-5" style="margin-top: 80px;">
    <div class="container">
        <div class="text-center" style="margin-bottom: 3rem;">
            <h1 style="color: var(--primary-blue);">Our Weekly Programs</h1>
            <p style="color: var(--text-color); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Join us throughout the week as we grow together in faith, fellowship, and the Word of God.</p>
        </div>

        <div class="grid-2">
            <?php
            $stmt = $pdo->query("SELECT * FROM programs ORDER BY id ASC");
            while ($row = $stmt->fetch()):
            ?>
            <div class="card" style="border-left: 5px solid var(--primary-gold); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h3 style="color: var(--primary-blue); font-size: 1.5rem; margin-bottom: 5px;"><?= htmlspecialchars($row['title']) ?></h3>
                    <p style="color: var(--primary-gold); font-weight: 600; margin-bottom: 15px;">
                        <i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($row['day']) ?> &nbsp;|&nbsp;
                        <i class="fas fa-clock"></i> <?= htmlspecialchars($row['time']) ?>
                    </p>
                    <p style="font-size: 1.05rem; margin-bottom: 15px; color: var(--text-color);">
                        <?= htmlspecialchars($row['description']) ?>
                    </p>
                </div>
                <?php if (!empty($row['speaker'])): ?>
                    <div style="background: rgba(0,0,0,0.03); padding: 10px; border-radius: var(--border-radius); font-size: 0.9rem; margin-top: auto;">
                        <i class="fas fa-user-tie" style="color: var(--primary-blue);"></i> <strong>Speaker:</strong> <?= htmlspecialchars($row['speaker']) ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
