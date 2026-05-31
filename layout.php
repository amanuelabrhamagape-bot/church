<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../frontend/login.php?msg=admin_only");
    exit;
}
require_once '../backend/db.php';

function renderAdminHeader($title) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.' - Admin Panel</title>
        <link rel="stylesheet" href="../assets/css/index.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            .admin-wrapper { display: flex; min-height: 100vh; }
            .sidebar { width: 250px; background: var(--nav-bg); padding: 20px; border-right: 1px solid var(--border-color); display: flex; flex-direction: column; flex-shrink: 0; }
            .sidebar a { display: block; padding: 12px 15px; margin-bottom: 8px; border-radius: 8px; color: var(--text-color); font-weight: 600; font-size: 1.05rem; transition: var(--transition); }
            .sidebar a i { margin-right: 8px; width: 20px; text-align: center; }
            .sidebar a:hover, .sidebar a.active { background: var(--primary-gold); color: #1a202c; transform: translateX(5px); }
            .admin-content { flex: 1; padding: 40px; background: var(--bg-color); overflow-y: auto;}
            .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;}
            .table-responsive { width: 100%; overflow-x: auto; background: var(--card-bg); border-radius: var(--border-radius); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
            table { width: 100%; border-collapse: collapse; }
            th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border-color); }
            th { background-color: rgba(0,0,0,0.03); color: var(--primary-blue); font-weight: 700; }
            .dark th { background-color: rgba(255,255,255,0.05); color: var(--primary-gold); }
            .action-btn { padding: 5px 10px; border-radius: 5px; font-size: 0.9rem; margin-right: 5px; display: inline-block; cursor: pointer; border: none; }
            .action-btn.edit { background: var(--primary-blue); color: white; }
            .action-btn.delete { background: #fee2e2; color: #991b1b; }
            .dark .action-btn.delete { background: #7f1d1d; color: #fee2e2; }
            @media (max-width: 1024px) {
                .admin-wrapper { flex-direction: column; }
                .sidebar { width: 100%; border-right: none; border-bottom: 1px solid var(--border-color); }
                .admin-content { padding: 15px; }
            }
        </style>
    </head>
    <body class="'.(isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'dark' : '').'">
        <div class="admin-wrapper">
            <nav class="sidebar">
                <div style="text-align: center; margin-bottom: 30px;">
                    <i class="fas fa-church fa-3x" style="color: var(--primary-gold); margin-bottom: 10px;"></i>
                    <h2 style="color: var(--primary-blue); font-size: 1.5rem;">Admin Panel</h2>
                </div>
                
                <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="manage_programs.php"><i class="fas fa-calendar-alt"></i> Programs</a>
                <a href="manage_sermons.php"><i class="fas fa-video"></i> Sermons</a>
                <a href="manage_events.php"><i class="fas fa-ticket-alt"></i> Events</a>
                <a href="manage_gallery.php"><i class="fas fa-images"></i> Photo Gallery</a>
                <a href="manage_posts.php"><i class="fas fa-pen"></i> Blog Posts</a>
                <a href="view_requests.php"><i class="fas fa-praying-hands"></i> Requests</a>
                <a href="manage_accounts.php"><i class="fas fa-users-cog"></i> Accounts</a>
                
                <div style="margin-top: auto;">
                    <hr style="margin: 20px 0; border: 0; border-top: 1px solid var(--border-color);">
                    <a href="../frontend/index.php"><i class="fas fa-home"></i> View Site</a>
                    <a href="../backend/auth.php?logout=1" style="color: #ef4444;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </nav>
            <div class="admin-content">';
}

function renderAdminFooter() {
    echo '</div>
        </div>
    </body>
    </html>';
}
?>
