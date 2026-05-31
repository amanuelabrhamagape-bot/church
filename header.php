<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agape </title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-church"></i> Agape<span>Church</span>
            </a>
            <div class="menu-toggle" id="menu-toggle">☰</div>
            <ul class="nav-links" id="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="programs.php">Programs</a></li>
                <li><a href="sermons.php">Sermons</a></li>
                <li><a href="live.php">Live Stream</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="prayer.php">Prayer</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <li><a href="../admin/index.php" class="btn btn-secondary" style="padding: 8px 16px; border-width: 1px;">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="../backend/auth.php?logout=1" class="btn btn-primary" style="padding: 8px 16px;">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn btn-primary" style="padding: 8px 16px;">Login</a></li>
                <?php endif; ?>
                <li><button id="theme-toggle" class="theme-toggle">🌙</button></li>
            </ul>
        </div>
    </nav>
