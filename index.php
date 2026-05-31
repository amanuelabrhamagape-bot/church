<?php require_once 'header.php'; ?>

<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(rgba(10, 61, 98, 0.8), rgba(10, 61, 98, 0.9)), url('https://images.unsplash.com/photo-1438032005730-c779502df39b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover; background-attachment: fixed;">
    <div class="container">
        <h1>Welcome to Agape Church</h1>
        <p>A place of faith, hope, and love. Join our community and experience the transformative power of the Word of God together.</p>
        <div class="hero-btns">
            <a href="live.php" class="btn btn-primary" style="margin-right: 15px;">Watch Live</a>
            <a href="programs.php" class="btn btn-secondary" style="margin-right: 15px;">Weekly Programs</a>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="../admin/index.php" class="btn btn-primary" style="background-color: var(--primary-gold); color: #1a202c; border-color: var(--primary-gold);">Admin Panel</a>
            <?php else: ?>
                <a href="../admin/index.php" class="btn btn-secondary" style="border-color: rgba(255,255,255,0.3); color: rgba(255,255,255,0.7);">Admin Login</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Weekly Programs Highlight -->
<section class="py-5" style="background-color: var(--card-bg);">
    <div class="container">
        <h2 class="text-center">Upcoming Programs</h2>
        <div class="grid-3 my-4">
            <?php
            require_once '../backend/db.php';
            $stmt = $pdo->query("SELECT * FROM programs ORDER BY id ASC LIMIT 3");
            while ($row = $stmt->fetch()):
            ?>
                <div class="card" style="border-top: 4px solid var(--primary-gold);">
                    <h3 style="color: var(--primary-blue); margin-bottom: 10px;"><?= htmlspecialchars($row['title']) ?></h3>
                    <p><strong><i class="fas fa-calendar-day" style="color: var(--primary-gold);"></i> <?= htmlspecialchars($row['day']) ?></strong></p>
                    <p><i class="fas fa-clock" style="color: var(--primary-gold);"></i> <?= htmlspecialchars($row['time']) ?></p>
                    <p style="margin-top: 15px; font-size: 0.95rem;"><?= htmlspecialchars($row['description']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center">
            <a href="programs.php" class="btn btn-blue">View All Programs</a>
        </div>
    </div>
</section>

<!-- Latest Sermon -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center">Latest Sermon</h2>
        <div class="my-4" style="text-align: center;">
            <?php
            $stmt = $pdo->query("SELECT * FROM sermons ORDER BY date DESC LIMIT 1");
            $sermon = $stmt->fetch();
            if ($sermon):
                $embedUrl = str_replace("watch?v=", "embed/", $sermon['video_url']);
            ?>
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 900px; margin: 0 auto; border-radius: var(--border-radius); box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="<?= htmlspecialchars($embedUrl) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <h3 style="margin-top: 20px; font-size: 1.8rem;"><?= htmlspecialchars($sermon['title']) ?></h3>
                <p style="color: #64748b;">By <?= htmlspecialchars($sermon['speaker']) ?> | <?= htmlspecialchars($sermon['date']) ?></p>
            <?php else: ?>
                <div class="card text-center" style="max-width: 600px; margin: 0 auto;">
                    <i class="fas fa-video-slash fa-3x" style="color: #ccc; margin-bottom: 15px;"></i>
                    <h3>No recent sermons</h3>
                    <p>Check back later for recent sermon videos.</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center">
            <a href="sermons.php" class="btn btn-primary">Watch More Sermons</a>
        </div>
    </div>
</section>

<!-- Quick Links -->
<section class="py-5" style="background-color: var(--primary-blue); color: white;">
    <div class="container text-center">
        <h2 style="color: white; margin-bottom: 3rem;">Get Involved</h2>
        <div class="grid-3">
            <div class="card" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(5px);">
                <i class="fas fa-calendar-alt fa-3x" style="color: var(--primary-gold); margin-bottom: 15px;"></i>
                <h3 style="color: white; margin-bottom: 10px;">Events</h3>
                <p style="color: #cbd5e1; font-size: 0.95rem; margin-bottom: 20px;">Register for our upcoming weekend programs and special services.</p>
                <a href="events.php" class="btn btn-primary" style="width: 100%;">Register Now</a>
            </div>
            <div class="card" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(5px);">
                <i class="fas fa-praying-hands fa-3x" style="color: var(--primary-gold); margin-bottom: 15px;"></i>
                <h3 style="color: white; margin-bottom: 10px;">Prayer</h3>
                <p style="color: #cbd5e1; font-size: 0.95rem; margin-bottom: 20px;">Need prayer? Submit a request and our intercessory team will pray for you.</p>
                <a href="prayer.php" class="btn btn-primary" style="width: 100%;">Submit Request</a>
            </div>
            <div class="card" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(5px);">
                <i class="fas fa-video fa-3x" style="color: var(--primary-gold); margin-bottom: 15px;"></i>
                <h3 style="color: white; margin-bottom: 10px;">Live Stream</h3>
                <p style="color: #cbd5e1; font-size: 0.95rem; margin-bottom: 20px;">Can't make it in person? Join our live worship experience online.</p>
                <a href="live.php" class="btn btn-primary" style="width: 100%;">Watch Live</a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'footer.php'; ?>
