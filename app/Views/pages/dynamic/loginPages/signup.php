<?php
    if (isset($_GET["error"]) && $_GET["error"] == "form_incomplete") {
        ?>
        <div class="message_box error">
            <h2>Error: Form Incomplete</h2>
            <p>Please fill in all fields on the form to sign up.</p>
        </div>
        <?php
    }
?>

<div id="signup_benefits">
    <h2>Log in to Furness Golf Club portal</h2>
    <p>Logging in has an array of benefits, including:</p>
    <ul>
        <li>Book a tee time for golf.</li>
        <li>See who else is booked on today.</li>
        <li>Order drinks from the bar remotely.</li>
    </ul>
    <br>
    <p>Log in <a href="<?php echo site_url('/account/login'); ?>">here</a> if you already have an account.</p>
</div>
<br>

<?php
    helper('form'); // This helper will allow CodeIgniter to help with the form-building process

    echo form_open(site_url('/account/create/request'), ['id' => "signup_form", 'class' => "flex_container"]) // Open a POST form that redirects to /login/request for processing
    . csrf_field()
    // First name:
    . form_label('First name:', 'fname', ['class' => 'required'])
    . form_input('fname', '', ['required'=>''])
    // Last name:
    . form_label('Last name:', 'lname', ['class' => 'required'])
    . form_input('lname', '', ['required'=>''])
    // Date of birth:
    . form_label("Date of birth:", 'dob', ['class' => 'required'])
    . form_input('dob', '', ['required'=>''], 'date')
    // Address line 1:
    . form_label('Address line 1:', 'ad1', ['class' => 'required'])
    . form_input('ad1', '', ['required'=>''])
    // Address line 2:
    . form_label('Address line 2:', 'ad2')
    . form_input('ad2')
    // Town:
    . form_label('Town:', 'town', ['class' => 'required'])
    . form_input('town', '', ['required'=>''])
    // County:
    . form_label('County:', 'county', ['class' => 'required'])
    . form_input('county', '', ['required'=>''])
    // Postcode:
    . form_label('Postcode:', 'pcode', ['class' => 'required'])
    . form_input('pcode', '', ['required'=>''])
    // Email:
    . form_label('Email:', 'email', ['class' => 'required'])
    . form_input('email', '', ['onkeyup' => "onEmailKeyUp()", 'required'=>''], 'email')
    // Password:
    . form_label('Password:', 'password', ['class'=>'required'])
    . form_password('password', '', ['id' => "signUpPassword", 'onkeyup' => "onPasswordKeyUp()", 'required'=>'']);
    // Submit: as the form is a POST requesting form, the route will need to be a POST route, not a GET route.
    ?><br><?php
    echo form_submit('submit', 'Sign up')
    . form_close();
?>
<script>
    // Set the validity for passwords
    const passwordBox = document.getElementById('signUpPassword');
    function onPasswordKeyUp() {
        if (passwordBox.value.length < 8) {
            passwordBox.setCustomValidity('Passwords must contain at least 8 characters!');
        } else {
            passwordBox.setCustomValidity('');
        }
    }
    onPasswordKeyUp();
</script>
<br>
<div id="log_in_container" class="flex_container">
    <p>Already have an account?</p>
    <br>
    <a id="login_button" href="<?php echo site_url('/account/login')?>">Log in</a>
</div>