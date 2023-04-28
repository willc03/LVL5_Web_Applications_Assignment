<?php if (isset($_GET["error"]) && $_GET["error"] == "no_access") {?>
    <div class="message_box error">
        <h2>Page Restricted</h2>
        <p>Your account cannot access this section. Try another section.</p>
    </div>
<?php } ?>

<h1>Administration Panel</h1>
<br>
<div id="blocks">
    <div id="block">
        <h2>User Management</h2>
        <?php if (session()->has('privilegeLevel') && session()->get('privilegeLevel') == 6) { ?>
            <p>As a level 6 user, you can edit all accounts including staff accounts.</p>
        <?php } else { ?>
            <p>As a staff member, you can edit all user accounts excluding staff accounts.</p>
        <?php } ?>
        <a href="<?php echo site_url('/admin/users'); ?>">Configure</a>
    </div>
    <div id="block">
        <h2>Golf Management</h2>
        <p>As a staff member, you can edit the golf times available on specific date ranges.</p>
        <p>You are also able to manage individual bookings on the <a id="no_btn" href="<?php echo site_url("/golf"); ?>">time sheet</a></p>
        <a href="<?php echo site_url('/admin/golf'); ?>">Configure</a>
    </div>
</div>