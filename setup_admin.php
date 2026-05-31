<?php
// Temporary script to reset or create an admin account for Agape Church
require_once '../backend/db.php';

$defaultEmail = 'admin@agapechurch.com';
$defaultPassword = 'admin123';
$hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

echo "<h1>Admin Account Setup</h1>";

try {
    // Check if an admin already exists
    $stmt = $pdo->query("SELECT * FROM users WHERE role = 'admin' LIMIT 1");
    $admin = $stmt->fetch();

    if ($admin) {
        $emailToUpdate = $admin['email'];
        // Update the existing admin's password
        $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $updateStmt->execute([$hashedPassword, $admin['id']]);
        
        echo "<p>Found existing admin account.</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($emailToUpdate) . "</p>";
        echo "<p><strong>Password:</strong> $defaultPassword </p>";
        echo "<p style='color:green;'>Password has been successfully reset!</p>";
        
    } else {
        // Create a new admin account
        $insertStmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES ('Administrator', ?, ?, 'admin')");
        $insertStmt->execute([$defaultEmail, $hashedPassword]);
        
        echo "<p>No admin account found. Created a new one.</p>";
        echo "<p><strong>Email:</strong> $defaultEmail </p>";
        echo "<p><strong>Password:</strong> $defaultPassword </p>";
        echo "<p style='color:green;'>Admin account successfully created!</p>";
    }
    
    echo "<br><br><a href='login.php'>Go to Login Page</a>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>Error updating database: " . $e->getMessage() . "</p>";
}
?>
