<h1>User Management</h1>
<br>
<div class="introduction">
    <p>This facility will allow you to edit the details of or delete user accounts.</p>
    <?php if (session()->has('privilegeLevel') && session()->get('privilegeLevel') == 6) { ?>
        <p>As a level 6 user, you are allowed to promote other users to staff-level accounts.</p>
    <?php } elseif (session()->has('privilegeLevel') && session()->get('privilegeLevel') == 5) { ?>
        <p>As you are a level 5 user, you can not make other accounts staff accounts.</p>
    <?php } ?>
</div>
<br>
<div class="initial_interaction">
    <?php
        helper('form'); // Load the form helper
        echo form_open()
           . form_label('Name:', 'name')
           . form_input('name')
           . form_close();
    ?>
</div>
