<?php if (isset($_GET["error"]) && $_GET["error"] == "unknown_user") {?>
    <div class="message_box error">
        <h2>Error: User does not exist</h2>
        <p>The user with the entered email does not exist. <a href="<?php echo site_url("/account/create"); ?>">Create an account</a></p>
    </div>
<?php } else if (isset($_GET["error"]) && $_GET["error"] == "incorrect_password") {?>
    <div class="message_box error">
        <h2>Error: Incorrect Password</h2>
        <p>Please try again.</p>
    </div>
<?php } ?>

<div id="login_benefits">
    <h2>Log in to Furness Golf Club portal</h2>
    <p>Logging in has an array of benefits, including:</p>
    <ul>
        <li>Book a tee time for golf.</li>
        <li>See who else is booked on today.</li>
        <li>Order drinks from the bar remotely.</li>
    </ul>
    <br>
    <p><a href="<?php echo site_url('/account/create'); ?>">Sign up</a> to get all the benefits of a visitor or member.</p>
</div>
<br>

<?php
    helper('form'); // This helper will allow CodeIgniter to help with the form-building process

    echo form_open(site_url('/account/login/request'), ['id' => "login_form", 'class' => "flex_container"]) // Open a POST form that redirects to /login/request for processing
    . csrf_field()
    // Email:
    . form_label('Email:', 'email', ['class' => 'required'])
    . form_input('email', '', ['required'=>''], 'email')
    // Password:
    . form_label('Password:', 'password', ['class' => 'required'])
    . form_password('password', '', ['required'=>'']);
    // Submit: as the form is a POST requesting form, the route will need to be a POST route, not a GET route.
    ?><br><?php
    echo form_submit('submit', 'Log in')
    . form_close();
?>
<br>
<div id="sign_up_container" class="flex_container">
    <p>Don't have an account?</p>
    <br>
    <a id="sign_up_button" href="<?php echo site_url('/account/create')?>">Sign Up</a>
</div>