<?php require_once 'header.php'; ?>

<div class="py-5" style="margin-top: 80px; background-color: var(--bg-color);">
    <div class="container">
        <div class="text-center" style="margin-bottom: 2rem;">
            <h1 style="color: var(--primary-blue);">Live Stream</h1>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto; color: var(--text-color);">Join our service live online. Worship, pray, and grow with us from anywhere in the world.</p>
        </div>

        <div style="max-width: 900px; margin: 0 auto; background: var(--card-bg); padding: 20px; border-radius: var(--border-radius); box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px;">
                <!-- Placeholder for dynamic live stream link -->
                <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="https://www.youtube.com/embed/live_stream?channel=UCYOURCHANNELID" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div style="margin-top: 20px; text-align: center;">
                <h3 style="color: red; font-weight: bold;"><i class="fas fa-circle" style="font-size: 0.8em; vertical-align: middle;"></i> LIVE NOW</h3>
                <p style="color: var(--text-color); margin-top: 10px;">Our Sunday service streams live every week at 09:00 AM.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
