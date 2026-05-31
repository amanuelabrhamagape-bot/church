<?php 
require_once 'layout.php'; 

$error = '';
$success = '';

// Add User
if (isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if email exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $error = "Email already exists.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
        if ($stmt->execute([$name, $email, $hashed_password, $role])) {
            $success = "User account created successfully.";
        } else {
            $error = "Failed to create user.";
        }
    }
}

// Edit User
if (isset($_POST['edit_user'])) {
    $id = (int)$_POST['user_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password']; // optional

    // Check if email belongs to another user
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
    $stmt->execute([$email, $id]);
    if ($stmt->rowCount() > 0) {
        $error = "Email belongs to another user.";
    } else {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, role = ?, password = ? WHERE id = ?');
            $exec = $stmt->execute([$name, $email, $role, $hashed_password, $id]);
        } else {
            $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?');
            $exec = $stmt->execute([$name, $email, $role, $id]);
        }
        
        if ($exec) {
            $success = "User updated successfully.";
        } else {
            $error = "Failed to update user.";
        }
    }
}

// Delete User
if (isset($_GET['del_user'])) {
    $id = (int)$_GET['del_user'];
    
    // Prevent deleting oneself
    if ($id === $_SESSION['user_id']) {
        $error = "You cannot delete your own account.";
    } else {
        $pdo->query("DELETE FROM users WHERE id = $id");
        $success = "User deleted successfully.";
    }
}

$editUser = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_GET['edit_id']]);
    $editUser = $stmt->fetch();
}

renderAdminHeader('Manage Accounts'); 
?>

<div class="admin-header">
    <h1 style="color: var(--primary-blue);">Manage Accounts</h1>
</div>

<?php if($error): ?>
    <div class="alert alert-error" style="margin-bottom: 20px; color: #ef4444; background: #fee2e2; border: 1px solid #fecaca; padding: 10px; border-radius: 6px; font-weight: 500;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if($success): ?>
    <div class="alert alert-success" style="margin-bottom: 20px; color: #166534; background: #dcfce7; border: 1px solid #bbf7d0; padding: 10px; border-radius: 6px; font-weight: 500;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="card" style="margin-bottom: 40px; border-top: 4px solid var(--primary-gold);">
    <h2 style="font-size: 1.4rem; margin-bottom: 20px; color: var(--primary-blue);">
        <i class="fas <?= $editUser ? 'fa-user-edit' : 'fa-user-plus' ?>"></i> 
        <?= $editUser ? 'Edit User Account' : 'Create New Account' ?>
    </h2>
    
    <form action="manage_accounts.php" method="POST">
        <?php if($editUser): ?>
            <input type="hidden" name="user_id" value="<?= $editUser['id'] ?>">
        <?php endif; ?>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="<?= $editUser ? htmlspecialchars($editUser['name']) : '' ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= $editUser ? htmlspecialchars($editUser['email']) : '' ?>" required>
            </div>
            
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="member" <?= ($editUser && $editUser['role'] === 'member') ? 'selected' : '' ?>>Member</option>
                    <option value="admin" <?= ($editUser && $editUser['role'] === 'admin') ? 'selected' : '' ?>>Administrator</option>
                </select>
            </div>

            <div class="form-group">
                <label>Password <?= $editUser ? '(Leave blank to keep current)' : '' ?></label>
                <input type="password" name="password" class="form-control" <?= $editUser ? '' : 'required' ?>>
            </div>
        </div>
        
        <div style="margin-top: 15px;">
            <button type="submit" name="<?= $editUser ? 'edit_user' : 'add_user' ?>" class="btn btn-primary">
                <?= $editUser ? 'Save Changes' : 'Create Account' ?>
            </button>
            <?php if($editUser): ?>
                <a href="manage_accounts.php" class="btn btn-secondary" style="margin-left: 10px;">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card" style="margin-bottom: 40px;">
    <h2 style="font-size: 1.4rem; margin-bottom: 20px; color: var(--primary-gold);"><i class="fas fa-users"></i> Account Directory</h2>
    <div class="table-responsive">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th>Action</th>
            </tr>
            <?php
            $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
            while ($row = $stmt->fetch()):
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                <td><a href="mailto:<?= htmlspecialchars($row['email']) ?>" style="color: var(--primary-blue);"><?= htmlspecialchars($row['email']) ?></a></td>
                <td>
                    <?php if ($row['role'] == 'admin'): ?>
                        <span style="background: var(--primary-gold); color: white; padding: 3px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: bold;"><i class="fas fa-shield-alt"></i> Admin</span>
                    <?php else: ?>
                        <span style="background: #10b981; color: white; padding: 3px 8px; border-radius: 12px; font-size: 0.8rem;">Member</span>
                    <?php endif; ?>
                </td>
                <td><?= date('M j, Y', strtotime($row['created_at'])) ?></td>
                <td>
                    <a href="manage_accounts.php?edit_id=<?= $row['id'] ?>" class="action-btn edit"><i class="fas fa-edit"></i> Edit</a>
                    
                    <?php if ($row['id'] !== $_SESSION['user_id']): ?>
                        <a href="?del_user=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Remove this member? This will also delete their event registrations.');"><i class="fas fa-trash"></i> Delete</a>
                    <?php else: ?>
                        <span style="color: #64748b; font-size: 0.9rem; padding: 5px 10px; display: inline-block;">Current</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<div class="card">
    <h2 style="font-size: 1.4rem; margin-bottom: 20px; color: var(--primary-blue);"><i class="fas fa-ticket-alt"></i> Event Registrations</h2>
    <div class="table-responsive">
        <table>
            <tr>
                <th>Member Info</th>
                <th>Event Info</th>
                <th>Registration Date</th>
            </tr>
            <?php
            // Join query to get user and event details
            $q = "SELECT r.created_at as reg_date, u.name as user_name, u.email as user_email, e.title as event_title, e.date as event_date 
                  FROM registrations r 
                  JOIN users u ON r.user_id = u.id 
                  JOIN events e ON r.event_id = e.id 
                  ORDER BY r.created_at DESC";
            $stmt = $pdo->query($q);
            while ($row = $stmt->fetch()):
            ?>
            <tr>
                <td>
                    <strong><?= htmlspecialchars($row['user_name']) ?></strong><br>
                    <small style="color: #64748b;"><?= htmlspecialchars($row['user_email']) ?></small>
                </td>
                <td>
                    <strong style="color: var(--primary-blue);"><?= htmlspecialchars($row['event_title']) ?></strong><br>
                    <small>Event Date: <?= date('M j, Y g:i A', strtotime($row['event_date'])) ?></small>
                </td>
                <td><?= date('M j, Y g:i A', strtotime($row['reg_date'])) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php renderAdminFooter(); ?>
