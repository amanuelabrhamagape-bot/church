<?php require_once 'header.php'; ?>

<div class="py-5" style="margin-top: 80px; background-color: var(--card-bg);">
    <div class="container">
        <div class="text-center" style="margin-bottom: 3rem;">
            <h1 style="color: var(--primary-blue);">Submit a Prayer Request</h1>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">"For where two or three are gathered together in my name, there am I in the midst of them." - Matthew 18:20</p>
        </div>

        <div style="max-width: 600px; margin: 0 auto;">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success text-center">Your prayer request has been submitted successfully. Our team will be praying for you!</div>
            <?php endif; ?>

            <div class="card" style="box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <form action="../backend/actions.php" method="POST">
                    <div class="form-group">
                        <label for="name">Your Name (Optional)</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Leave blank to remain anonymous">
                    </div>
                    <div class="form-group">
                        <label for="message">Prayer Request <span style="color:red">*</span></label>
                        <textarea name="message" id="message" rows="5" class="form-control" required placeholder="How can we pray for you today?"></textarea>
                    </div>
                    <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="is_public" id="is_public" style="width: 20px; height: 20px; accent-color: var(--primary-gold);">
                        <label for="is_public" style="margin: 0; font-weight: normal;">Allow this request to be shared publicly with the congregation</label>
                    </div>
                    <button type="submit" name="submit_prayer" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">Submit Prayer Request</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
