<form action='<?php echo base_url(); ?>login/login_process' method='post' name='process'>
    <h2>User Login</h2>
    <?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>
    <table>
        <tr>
            <td><label for='username'>Gebruikersnaam</label></td>
            <td><input type='text' name='username' id='username' size='20' /></td>
        </tr>
        <tr>
            <td><label for='password'>Paswoord</label></td>
            <td><input type='password' name='password' id='password' size='20' /></td>
        </tr>
        <tr>
            <td colspan="2"><input type='submit' value='Log mij nu in!' /></td>
        </tr>
    </table>
</form>
<a href="<?php echo base_url(); ?>login/password_forgot">Paswoord vergeten?</a>