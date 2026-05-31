<?php require_once 'header.php'; ?>
<?php require_once '../backend/db.php'; ?>

<div class="py-5" style="margin-top: 80px; background-color: var(--bg-color);">
    <div class="container">
        <div class="text-center" style="margin-bottom: 3rem;">
            <h1 style="color: var(--primary-blue);">Upcoming Events</h1>
            <p style="color: var(--text-color); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Don't miss our weekend programs and special events. Register below to secure your spot.</p>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Successfully registered for the event!</div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">You are already registered for this event.</div>
        <?php endif; ?>

        <div class="grid-2">
            <!-- Events List -->
            <div>
                <?php
                $stmt = $pdo->query("SELECT * FROM events ORDER BY date ASC LIMIT 10");
                while ($event = $stmt->fetch()):
                    $formattedDate = date('F j, Y, g:i a', strtotime($event['date']));
                ?>
                <div class="card" style="margin-bottom: 20px; border-left: 5px solid var(--primary-blue);">
                    <h3 style="color: var(--primary-gold); margin-bottom: 5px;"><?= htmlspecialchars($event['title']) ?></h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 10px;"><i class="fas fa-clock"></i> <?= htmlspecialchars($formattedDate) ?></p>
                    <p style="margin-bottom: 0;"><?= htmlspecialchars($event['description']) ?></p>
                </div>
                <?php endwhile; ?>
            </div>

            <!-- Registration Form -->
            <div class="card" style="box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;"><i class="fas fa-ticket-alt"></i> Register for an Event</h3>
                <form action="../backend/actions.php" method="POST">
                    <div class="form-group">
                        <label for="event_id">Select Event</label>
                        <select name="event_id" id="event_id" class="form-control" required style="width: 100%;">
                            <option value="">-- Choose Event --</option>
                            <?php
                            $stmt = $pdo->query("SELECT id, title, date FROM events ORDER BY date ASC");
                            while ($event = $stmt->fetch()) {
                                $d = date('M j', strtotime($event['date']));
                                echo "<option value='{$event['id']}'>{$event['title']} ({$d})</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="<?= htmlspecialchars($_SESSION['user_name']) ?>" class="form-control" disabled>
                        </div>
                        <button type="submit" name="register_event" class="btn btn-primary" style="width: 100%;">Confirm Registration</button>
                    <?php else: ?>
                        <div class="alert alert-error">You must be logged in to register for events.</div>
                        <a href="login.php" class="btn btn-secondary" style="width: 100%; display: block;">Log In to Register</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
