<form action='<?php echo base_url();?>login/password_reset' method='post' name='password_reset'>
<h2>Reset Password</h2>
<?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>

<label for='username'>Username</label>
<input type='text' name='username' id='username' size='25' /><br />

<label for='email'>Email</label>
<input type='text' name='email' id='email' size='25' /><br />                            

<input type='submit' value='Send new password' />
</form>