<style>
    body {
        background-image: url("/assets/golf-bg-1.png");
        background-size: cover;
    }
</style>

<?php
// Section to make error boxes
if (isset($_GET["error"]) && $_GET["error"] == "not_logged_in") {?>
    <div class="message_box error">
        <h2>Error: Members Only Area</h2>
        <p><a href="<?php echo site_url("/account/login"); ?>">Log in</a> as a member to access member-only areas.</p>
    </div>
<?php } elseif ( isset($_GET["error"]) && $_GET["error"] == "access_denied" ) { ?>
    <div class="message_box error">
        <h2>Access denied</h2>
        <p>Your account doesn't have the correct access level for this service.0</p>
    </div>
<?php } ?>
<br>
<h1>Furness Golf Club</h1>
<div>
    <br>
    <h3>Welcome to Furness Golf Club</h3>
    <p>The 3rd oldest links course in England, and the 6th oldest golf course in England.</p>
</div>
<br>
<div>
    <br>
    <h3><a href="<?php echo site_url("/account/login"); ?>">Log in</a> to enjoy the full benefits of our website and course.</h3>
</div>