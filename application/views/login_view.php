<form action='<?php echo base_url();?>login/login_process' method='post' name='process'>
<?php //echo form_open('login/login_process'); WERKT NEIT ?>
<h2>User Login</h2>
<?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>

<label for='username'>Username</label>
<input type='text' name='username' id='username' size='25' /><br />

<label for='password'>Password</label>
<input type='password' name='password' id='password' size='25' /><br />                            

<input type='submit' value='Login' />            
<?php //echo form_close(); WERKT NIET ?>
</form>