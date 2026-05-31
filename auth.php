<?php
// backend/auth.php
session_start();
require_once 'db.php';

$error = '';
$success = '';

// Registration
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        header("Location: ../frontend/register.php?error=" . urlencode("Email already exists."));
        exit;
    } else {
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        if ($stmt->execute([$name, $email, $password])) {
            header("Location: ../frontend/login.php?success=" . urlencode("Registration successful! You can now log in."));
            exit;
        } else {
            header("Location: ../frontend/register.php?error=" . urlencode("Registration failed. Try again."));
            exit;
        }
    }
}

// Login
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        if ($user['role'] === 'admin') {
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../frontend/index.php");
        }
        exit;
    } else {
        header("Location: ../frontend/login.php?error=" . urlencode("Invalid email or password."));
        exit;
    }
}

// Logout handling (if hitting this file directly)
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../frontend/login.php");
    exit;
}
?>
