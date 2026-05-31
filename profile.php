<?php require_once 'header.php'; ?>
<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=login_required");
    exit;
}
require_once '../backend/db.php';
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<div class="py-5" style="margin-top: 80px; background-color: var(--bg-color); min-height: 60vh;">
    <div class="container">
        <h1 style="color: var(--primary-blue); margin-bottom: 2rem;"><i class="fas fa-user-circle"></i> My Profile</h1>
        
        <div class="grid-2">
            <div class="card" style="margin-bottom: 20px; border-top: 4px solid var(--primary-blue);">
                <h3 style="color: var(--primary-gold); margin-bottom: 20px;"><i class="fas fa-id-card"></i> Account Details</h3>
                <p style="margin-bottom: 15px; font-size: 1.1rem;"><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
                <p style="margin-bottom: 15px; font-size: 1.1rem;"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p style="margin-bottom: 15px; font-size: 1.1rem;"><strong>Role:</strong> <?= ucfirst(htmlspecialchars($user['role'])) ?></p>
                <p style="font-size: 1.1rem;"><strong>Member Since:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
            </div>
            
            <div class="card" style="border-top: 4px solid var(--primary-gold);">
                <h3 style="color: var(--primary-blue); margin-bottom: 15px;"><i class="fas fa-ticket-alt"></i> My Event Registrations</h3>
                <?php
                $stmt = $pdo->prepare("SELECT e.title, e.date FROM registrations r JOIN events e ON r.event_id = e.id WHERE r.user_id = ? ORDER BY e.date ASC");
                $stmt->execute([$user_id]);
                if ($stmt->rowCount() > 0):
                ?>
                    <ul style="list-style-type: none; padding: 0;">
                    <?php while ($reg = $stmt->fetch()): ?>
                        <li style="padding: 15px 0; border-bottom: 1px solid var(--border-color);">
                            <strong style="font-size: 1.1rem; color: var(--text-color);"><?= htmlspecialchars($reg['title']) ?></strong><br>
                            <small style="color: var(--primary-gold); font-weight: bold;"><i class="fas fa-calendar"></i> <?= date('F j, Y - g:i A', strtotime($reg['date'])) ?></small>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p style="color: #64748b; margin-bottom: 20px;">You haven't registered for any upcoming events yet.</p>
                    <a href="events.php" class="btn btn-secondary text-center" style="display: block; width: 100%;">Browse Events to Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
