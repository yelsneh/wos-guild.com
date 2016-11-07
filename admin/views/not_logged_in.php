<?php include('_header.php'); ?>

<div class="container">

<form method="post" action="index.php" name="loginform" class="form-signin" role="form">
    
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
    <input id="user_name" type="text" name="user_name" class="form-control" placeholder="Username" required autofocus />
	<label for="user_password" class="sr-only">Password</label>
    <input id="user_password" type="password" name="user_password" autocomplete="off" class="form-control" placeholder="Password" required />
    <div class="checkbox">
    	<label>
        	<input type="checkbox" id="user_rememberme" name="user_rememberme" value="1" /> <?php echo WORDING_REMEMBER_ME; ?>
        </label>
    </div>

        	<input type="submit" name="login" value="Log in" class="btn btn-lg btn-primary btn-block" />
<a href="password_reset.php"><?php echo WORDING_FORGOT_MY_PASSWORD; ?></a>
</form>

    </div> <!-- /container -->
<?php include('_footer.php'); ?>