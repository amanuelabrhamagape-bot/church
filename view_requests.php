<?php 
require_once 'layout.php'; 
renderAdminHeader('View Requests'); 

// Mark Prayer action
if (isset($_GET['pray_status']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['pray_status'] == 'prayed' ? 'prayed' : 'answered';
    $stmt = $pdo->prepare("UPDATE prayer_requests SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    echo '<div class="alert alert-success" style="margin-bottom: 20px;">Request status updated.</div>';
}

// Delete Message action
if (isset($_GET['del_msg'])) {
    $id = (int)$_GET['del_msg'];
    $pdo->query("DELETE FROM messages WHERE id = $id");
    echo '<div class="alert alert-success" style="margin-bottom: 20px;">Message deleted.</div>';
}
?>

<div class="admin-header">
    <h1 style="color: var(--primary-blue);">Requests & Messages</h1>
</div>

<div class="card" style="margin-bottom: 40px;">
    <h2 style="font-size: 1.4rem; margin-bottom: 20px; color: var(--primary-gold);"><i class="fas fa-praying-hands"></i> Prayer Requests</h2>
    <div class="table-responsive">
        <table>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Message</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            $stmt = $pdo->query("SELECT * FROM prayer_requests ORDER BY created_at DESC");
            while ($row = $stmt->fetch()):
                $badgeCol = $row['status'] == 'pending' ? 'var(--primary-gold)' : ($row['status'] == 'prayed' ? '#3b82f6' : '#10b981');
            ?>
            <tr>
                <td style="white-space: nowrap;"><?= date('M j, Y', strtotime($row['created_at'])) ?></td>
                <td><strong><?= htmlspecialchars($row['name']) ?></strong><br><small><?= $row['is_public'] ? '<span style="color:#10b981;">Public</span>' : 'Private' ?></small></td>
                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                <td><span style="background: <?= $badgeCol ?>; color: white; padding: 4px 10px; border-radius: 12px; font-size: 0.85rem; font-weight: bold;"><?= ucfirst($row['status']) ?></span></td>
                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                        <a href="?pray_status=prayed&id=<?= $row['id'] ?>" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.8rem; margin-bottom: 5px;"><i class="fas fa-check"></i> Mark Prayed</a>
                    <?php endif; ?>
                    <?php if ($row['status'] != 'answered'): ?>
                        <a href="?pray_status=answered&id=<?= $row['id'] ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem;"><i class="fas fa-star"></i> Answered</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<div class="card">
    <h2 style="font-size: 1.4rem; margin-bottom: 20px; color: var(--primary-blue);"><i class="fas fa-envelope"></i> Contact Messages</h2>
    <div class="table-responsive">
        <table>
            <tr>
                <th>Date</th>
                <th>Sender Info</th>
                <th>Message Details</th>
                <th>Action</th>
            </tr>
            <?php
            $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
            while ($row = $stmt->fetch()):
            ?>
            <tr>
                <td style="white-space: nowrap;"><?= date('M j, Y', strtotime($row['created_at'])) ?></td>
                <td><strong><?= htmlspecialchars($row['name']) ?></strong><br><a href="mailto:<?= htmlspecialchars($row['email']) ?>" style="color: var(--primary-blue);"><?= htmlspecialchars($row['email']) ?></a></td>
                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                <td>
                    <a href="?del_msg=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Delete message?');"><i class="fas fa-trash"></i> Delete</a>
                    <a href="mailto:<?= htmlspecialchars($row['email']) ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem;"><i class="fas fa-reply"></i> Reply</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php renderAdminFooter(); ?>
