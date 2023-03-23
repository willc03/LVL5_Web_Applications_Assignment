<?php if (isset($_GET["error"]) && $_GET["error"] == "not_logged_in") {?>
    <div class="message_box error">
        <h2>Error: Members Only Area</h2>
        <p><a href="<?php echo site_url("/account/login"); ?>">Log in</a> as a member to access member-only areas.</p>
    </div>
<?php } ?>
<h2>home page</h2>