<?php require_once 'header.php'; ?>

<div class="py-5" style="margin-top: 80px;">
    <div class="container">
        <div class="text-center" style="margin-bottom: 3rem;">
            <h1 style="color: var(--primary-blue);">Contact Us</h1>
            <p>We would love to hear from you. Reach out to us with any questions or inquiries.</p>
        </div>

        <div class="grid-2">
            <!-- Contact Info & Map -->
            <div>
                <div class="card" style="margin-bottom: 20px;">
                    <h3><i class="fas fa-map-marker-alt" style="color: var(--primary-gold);"></i> Address</h3>
                    <p>123 Faith Avenue, Grace City, GC 10001</p>
                    <br>
                    <h3><i class="fas fa-phone-alt" style="color: var(--primary-gold);"></i> Phone</h3>
                    <p>+1 (555) 123-4567</p>
                    <br>
                    <h3><i class="fas fa-envelope" style="color: var(--primary-gold);"></i> Email</h3>
                    <p>info@agapechurch.com</p>
                </div>
                <div class="card" style="padding: 0; overflow: hidden;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d-74.11976397304603!3d40.69766374874431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1684347783965!5m2!1sen!2s" width="100%" height="250" style="border:0; display: block;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="card" style="box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;"><i class="fas fa-envelope-open-text"></i> Send us a Message</h3>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Your message has been sent successfully. We will get back to you soon.</div>
                <?php endif; ?>

                <form action="../backend/actions.php" method="POST">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required placeholder="john@example.com">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="5" class="form-control" required placeholder="Your message here..."></textarea>
                    </div>
                    <button type="submit" name="submit_contact" class="btn btn-primary" style="width: 100%;">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
