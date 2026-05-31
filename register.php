<?php require_once 'header.php'; ?>

<div class="py-5" style="margin-top: 80px; background-color: var(--bg-color); min-height: calc(100vh - 80px - 200px); display: flex; align-items: center;">
    <div class="container" style="width: 100%;">
        <div style="max-width: 450px; margin: 0 auto;">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error text-center" style="color: #ef4444; background: #fee2e2; border: 1px solid #fecaca; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>
            <div class="card" style="box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 4px solid var(--primary-gold);">
                <h2 class="text-center" style="color: var(--primary-blue); font-size: 2rem;"><i class="fas fa-user-plus"></i> Create Account</h2>
                <p class="text-center" style="margin-bottom: 2rem; color: #64748b;">Join our family today.</p>
                
                <form action="../backend/auth.php" method="POST">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 1.1rem;">Create Account</button>
                    <p class="text-center" style="margin-top: 20px;">Already a member? <a href="login.php" style="color: var(--primary-blue-light); font-weight: bold; text-decoration: underline;">Log in here</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
