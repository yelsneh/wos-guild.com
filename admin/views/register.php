<?php include('_header.php'); ?>
<div class="container">

<!-- show registration form, but only if we didn't submit already -->
<?php if (!$registration->registration_successful && !$registration->verification_successful) { ?>
<form method="post" action="register.php" name="registerform" class="form-register" role="form">
<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$error.'</div>';;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$message.'</div>';
        }
    }
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$error.'</div>';;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$message.'</div>';
        }
    }
}
?>

	<label for="user_name" class="sr-only">Username</label>
    <input id="user_name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" class="form-control" placeholder="Username" required autofocus />

	<label for="user_email" class="sr-only">Email</label>
    <input id="user_email" type="email" name="user_email" class="form-control" placeholder="Email" required />

	<label for="user_password_new" class="sr-only">Password</label>
    <input id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" class="form-control" placeholder="Password" required autocomplete="off" />

	<label for="user_password_repeat" class="sr-only">Repeat Password</label>
    <input id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}" class="form-control" placeholder="Repeat Password" required autocomplete="off" />

    <img src="tools/showCaptcha.php" alt="captcha" />

	<label for="captcha" class="sr-only">Enter Captcha Characters</label>
    <input type="text" name="captcha" required class="form-control" placeholder="Enter Characters" />

    <input type="submit" name="register" value="<?php echo WORDING_REGISTER; ?>" class="btn btn-lg btn-primary btn-block"/>
</form>
<?php } ?>
</div>
<?php include('_footer.php'); ?>