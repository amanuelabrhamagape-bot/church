<?php
// backend/actions.php
session_start();
require_once 'db.php';

// Handle Prayer Request
if (isset($_POST['submit_prayer'])) {
    $name = !empty($_POST['name']) ? trim($_POST['name']) : 'Anonymous';
    $message = trim($_POST['message']);
    $is_public = isset($_POST['is_public']) ? 1 : 0;

    $stmt = $pdo->prepare('INSERT INTO prayer_requests (name, message, is_public) VALUES (?, ?, ?)');
    if ($stmt->execute([$name, $message, $is_public])) {
        header("Location: ../frontend/prayer.php?success=1");
        exit;
    }
}

// Handle Contact Form
if (isset($_POST['submit_contact'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    $stmt = $pdo->prepare('INSERT INTO messages (name, email, message) VALUES (?, ?, ?)');
    if ($stmt->execute([$name, $email, $message])) {
        header("Location: ../frontend/contact.php?success=1");
        exit;
    }
}

// Handle Event Registration
if (isset($_POST['register_event'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../frontend/login.php?msg=login_required");
        exit;
    }
    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];

    $stmt = $pdo->prepare('SELECT id FROM registrations WHERE user_id = ? AND event_id = ?');
    $stmt->execute([$user_id, $event_id]);
    if ($stmt->rowCount() > 0) {
        header("Location: ../frontend/events.php?error=already_registered");
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO registrations (user_id, event_id) VALUES (?, ?)');
    if ($stmt->execute([$user_id, $event_id])) {
        header("Location: ../frontend/events.php?success=1");
        exit;
    }
}
?>
