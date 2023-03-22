<div id="signup_benefits">
    <h2>Log in to Furness Golf Club portal</h2>
    <p>Logging in has an array of benefits, including:</p>
    <ul>
        <li>Book a tee time for golf.</li>
        <li>See who else is booked on today.</li>
        <li>Order drinks from the bar remotely.</li>
    </ul>
    <br>
    <p><a href="<?php echo site_url('/signup'); ?>">Sign up</a> to get all the benefits of a visitor or member.</p>
</div>
<br>

<?php
    helper('form'); // This helper will allow CodeIgniter to help with the form-building process

    echo form_open(site_url('/signup/request'), ['id' => "signup_form", 'class' => "flex_container"]); // Open a POST form that redirects to /login/request for processing
    // First name:
    echo form_label('First name:', 'fname');
    echo form_input('fname');
    // Last name:
    echo form_label('Last name:', 'lname');
    echo form_input('lname');
    // Date of birth:
    echo form_label("Date of birth:", 'dob');
    echo form_input('dob', '', '', 'date');
    // Address line 1:
    echo form_label('Address line 1:', 'ad1');
    echo form_input('ad1');
    // Address line 2:
    echo form_label('Address line 2:', 'ad2');
    echo form_input('ad2');
    // Town:
    echo form_label('Town:', 'town');
    echo form_input('town');
    // County:
    echo form_label('County:', 'county');
    echo form_input('county');
    // Postcode:
    echo form_label('Postcode:', 'pcode');
    echo form_input('pcode');
    // Email:
    echo form_label('Email:', 'email');
    echo form_input('email', '', '', 'email');
    // Password:
    echo form_label('Password:', 'password');
    echo form_password('password');
    // Submit: as the form is a POST requesting form, the route will need to be a POST route, not a GET route.
    ?><br><?php
    echo form_submit('submit', 'Sign up');
    echo form_close();
?>
<br>
<div id="log_in_container" class="flex_container">
    <p>Already have an account?</p>
    <a id="login_button" href="<?php echo site_url('/login')?>">Log in</a>
</div>