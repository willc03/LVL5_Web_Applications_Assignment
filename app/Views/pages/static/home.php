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
<h2>home page</h2>