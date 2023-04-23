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
        <a>Configure</a>
    </div>
    <div id="block">
        <h2>Golf Management</h2>
        <p>As a staff member, you can edit the golf times available on specific date ranges.</p>
        <p>You are also able to manage individual bookings on the <a id="no_btn" href="<?php echo site_url("/golf"); ?>">time sheet</a></p>
        <a>Configure</a>
    </div>
    <?php if (session()->has('privilegeLevel') && session()->get('privilegeLevel') == 6) { ?>
        <div id="block">
            <h2>Bar Management</h2>
            <p>As a level 6 user, you are able to create, change, and remove products from the bar.</p>
            <a>Configure</a>
        </div>
    <?php } ?>
</div>