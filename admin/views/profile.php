<h1 class="page-header">Profile</h1>

<!-- edit form for username / this form uses HTML5 attributes, like "required" and type="email" -->
<form method="post" action="/admin/profile" name="user_edit_form_name" class="form-profile" role="form">
	<label for="user_name" class="sr-only">New Username</label>
    <input id="user_name" type="text" name="user_name" pattern="[a-zA-Z0-9]{2,64}" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" required /> 
    <input type="submit" name="user_edit_submit_name" value="<?php echo WORDING_CHANGE_USERNAME; ?>" class="btn btn-lg btn-primary btn-block" />
</form>
<hr/>

<!-- edit form for user email / this form uses HTML5 attributes, like "required" and type="email" -->
<form method="post" action="/admin/profile" name="user_edit_form_email" class="form-profile" role="form">
	<label for="user_name" class="sr-only">New Email</label>
    <input id="user_email" type="email" name="user_email" class="form-control" value="<?php echo $_SESSION['user_email']; ?>" required /> 
    <input type="submit" name="user_edit_submit_email" value="<?php echo WORDING_CHANGE_EMAIL; ?>" class="btn btn-lg btn-primary btn-block" />
</form><hr/>

<!-- edit form for user's password / this form uses the HTML5 attribute "required" -->
<form method="post" action="/admin/profile" name="user_edit_form_password" class="form-profile" role="form">
	<label for="user_password_old" class="sr-only">Old Password</label>
    <input id="user_password_old" type="password" name="user_password_old" autocomplete="off" class="form-control" placeholder="Old Password" />
	<label for="user_password_new" class="sr-only">New Password</label>
    <input id="user_password_new" type="password" name="user_password_new" autocomplete="off" class="form-control" placeholder="New Password" />
	<label for="user_password_repeat" class="sr-only">Repeat New Password</label>
    <input id="user_password_repeat" type="password" name="user_password_repeat" autocomplete="off" class="form-control" placeholder="Repeat New Password" />
    <input type="submit" name="user_edit_submit_password" value="<?php echo WORDING_CHANGE_PASSWORD; ?>" class="btn btn-lg btn-primary btn-block"  />
</form><hr/>
