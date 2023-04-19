<?php if (isset($_GET["error"]) && $_GET["error"] == "form_incomplete") {?>
    <div class="message_box error">
        <h2>Error: Form Incomplete</h2>
        <p>Please fill in all fields on the form to sign up.</p>
    </div>
<?php } ?>

<div id="signup_benefits">
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

    echo form_open(site_url('/account/create/request'), ['id' => "signup_form", 'class' => "flex_container"]); // Open a POST form that redirects to /login/request for processing
    // First name:
    echo form_label('First name:', 'fname', ['class' => 'required']);
    echo form_input('fname', '', ['required'=>'']);
    // Last name:
    echo form_label('Last name:', 'lname', ['class' => 'required']);
    echo form_input('lname', '', ['required'=>'']);
    // Date of birth:
    echo form_label("Date of birth:", 'dob', ['class' => 'required']);
    echo form_input('dob', '', ['required'=>''], 'date');
    // Address line 1:
    echo form_label('Address line 1:', 'ad1', ['class' => 'required']);
    echo form_input('ad1', '', ['required'=>'']);
    // Address line 2:
    echo form_label('Address line 2:', 'ad2');
    echo form_input('ad2');
    // Town:
    echo form_label('Town:', 'town', ['class' => 'required']);
    echo form_input('town', '', ['required'=>'']);
    // County:
    echo form_label('County:', 'county', ['class' => 'required']);
    echo form_input('county', '', ['required'=>'']);
    // Postcode:
    echo form_label('Postcode:', 'pcode', ['class' => 'required']);
    echo form_input('pcode', '', ['required'=>'']);
    // Email:
    echo form_label('Email:', 'email', ['class' => 'required']);
    echo form_input('email', '', ['onkeyup' => "onEmailKeyUp()", 'required'=>''], 'email');
    // Password:
    echo form_label('Password:', 'password', ['class'=>'required']);
    echo form_password('password', '', ['id' => "signUpPassword", 'onkeyup' => "onPasswordKeyUp()", 'required'=>'']);
    // Submit: as the form is a POST requesting form, the route will need to be a POST route, not a GET route.
    ?><br><?php
    echo form_submit('submit', 'Sign up');
    echo form_close();
?>
<script>
    // Set the validity for passwords
    const passwordBox = document.getElementById(`signUpPassword`);
    function onPasswordKeyUp()
    {
        if (passwordBox.value.length < 8)
        {
            return passwordBox.setCustomValidity("Passwords must contain at least 8 characters!");
        }
        return passwordBox.setCustomValidity();
    };
    onPasswordKeyUp();
</script>
<br>
<div id="log_in_container" class="flex_container">
    <p>Already have an account?</p>
    <br>
    <a id="login_button" href="<?php echo site_url('/account/login')?>">Log in</a>
</div>