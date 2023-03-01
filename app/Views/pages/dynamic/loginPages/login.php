<?php
    helper('form'); // This helper will allow CodeIgniter to help with the form-building process

    echo form_open(site_url('/login/request'), ['id' => "login_form", 'class' => "flex_container"]); // Open a POST form that redirects to /login/request for processing
    // Email:
    echo form_label('Email:', 'email');
    echo form_input('email', '', '', 'email');
    // Password:
    echo form_label('Password:', 'password');
    echo form_password('password');
    // Submit: as the form is a POST requesting form, the route will need to be a POST route, not a GET route.
    ?><br><?php
    echo form_submit('submit', 'Log in');
    echo form_close();
?>
<br>
<div id="sign_up_container" class="flex_container">
    <p>Don't have an account?</p>
    <a id="sign_up_button" href="<?php echo site_url('/signup')?>">Sign Up</a>
</div>