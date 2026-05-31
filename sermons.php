<?php require_once 'header.php'; ?>
<?php require_once '../backend/db.php'; ?>

<div class="py-5" style="margin-top: 80px; background-color: var(--card-bg);">
    <div class="container">
        <div class="text-center" style="margin-bottom: 3rem;">
            <h1 style="color: var(--primary-blue);">Video Sermons</h1>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Watch our recent messages and let the Word transform your life.</p>
        </div>

        <form method="GET" style="margin-bottom: 2rem; display: flex; gap: 10px; justify-content: center;">
            <input type="text" name="search" placeholder="Search by Speaker or Title..." class="form-control" style="max-width: 300px; display: inline-block;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
        </form>

        <div class="grid-2">
            <?php
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
            $query = "SELECT * FROM sermons";
            if ($search) {
                $query .= " WHERE title LIKE :search OR speaker LIKE :search";
            }
            $query .= " ORDER BY date DESC";
            
            $stmt = $pdo->prepare($query);
            if ($search) {
                $stmt->execute(['search' => "%$search%"]);
            } else {
                $stmt->execute();
            }

            while ($sermon = $stmt->fetch()):
                $embedUrl = str_replace("watch?v=", "embed/", $sermon['video_url']);
            ?>
            <div class="card" style="padding: 0; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: var(--border-radius) var(--border-radius) 0 0;">
                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="<?= htmlspecialchars($embedUrl) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div style="padding: 20px;">
                    <h3 style="color: var(--primary-blue); font-size: 1.3rem; margin-bottom: 10px;"><?= htmlspecialchars($sermon['title']) ?></h3>
                    <div style="display: flex; justify-content: space-between; align-items: center; color: #64748b; font-size: 0.9rem;">
                        <span><i class="fas fa-user"></i> <?= htmlspecialchars($sermon['speaker']) ?></span>
                        <span><i class="fas fa-calendar"></i> <?= htmlspecialchars($sermon['date']) ?></span>
                    </div>
                    <?php if (!empty($sermon['description'])): ?>
                        <p style="margin-top: 15px; font-size: 0.95rem;"><?= htmlspecialchars($sermon['description']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
