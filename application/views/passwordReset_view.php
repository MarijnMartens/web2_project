<form action='<?php echo base_url(); ?>login/password_reset' method='post' name='password_reset'>
    <h2>Reset Password</h2>
    <?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>
    <table>
        <tr>
            <td><label for='username'>Username</label></td>
            <td><input type='text' name='username' id='username' size='25' /></td>
        </tr>
        <tr>
            <td><label for='email'>Email</label></td>
            <td><input type='text' name='email' id='email' size='25' /></td>
        </tr>
        <tr>
            <td colspan="2"><input type='submit' value='Send new password' /></td>
        </tr>
    </table>
</form>