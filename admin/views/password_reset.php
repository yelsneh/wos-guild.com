<?php include('_header.php'); ?>


<div class="container">

<?php if ($login->passwordResetLinkIsValid() == true) { ?>
<form method="post" action="password_reset.php" name="new_password_form" class="form-password" role="form">
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

    <input type='hidden' name='user_name' value='<?php echo $_GET['user_name']; ?>' />
    <input type='hidden' name='user_password_reset_hash' value='<?php echo $_GET['verification_code']; ?>' />

    <input id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" class="form-control" placeholder="New Password" required autocomplete="off" />

    <input id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}" class="form-control" placeholder="Repeat New Password"  required autocomplete="off" />
    <input type="submit" name="submit_new_password" value="<?php echo WORDING_SUBMIT_NEW_PASSWORD; ?>" class="btn btn-lg btn-primary btn-block" />
<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>
</form>
<!-- no data from a password-reset-mail has been provided, so we simply show the request-a-password-reset form -->
<?php } else { ?>
<form method="post" action="password_reset.php" name="password_reset_form" class="form-password" role="form">
<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo '<div class="alert alert-warning" role="alert">'.$message.'</div>';
        }
    }
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo '<div class="alert alert-warning" role="alert">'.$message.'</div>';
        }
    }
}
?>
    <input id="user_name" type="text" name="user_name" class="form-control" placeholder="Username" required autofocus />
    <input type="submit" name="request_password_reset" value="<?php echo WORDING_RESET_PASSWORD; ?>" class="btn btn-lg btn-primary btn-block" />
<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>
</form>
<?php } ?>

</div>

<?php include('_footer.php'); ?>