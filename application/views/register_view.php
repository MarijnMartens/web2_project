<?php echo form_open('login/register'); ?>
<?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>
<table>
    <tr>
        <td><label for="username">Gebruikersnaam</label></td>
        <td><input type="text" name="username" placeholder="Gebruikersnaam" value="<?php echo set_value('username'); ?>" size="20" /></td>
        <td><?php echo form_error('username'); ?></td>
    </tr>
    <tr>
        <td><label for="password">Paswoord</label></td>
        <td><input type="password" name="password" placeholder="Paswoord" value="<?php echo set_value('password'); ?>" size="20" /></td>
        <td><?php echo form_error('password'); ?></td>
    </tr>
    <tr>
        <td><label for="passconf">Herhaal Paswoord</label></td>
        <td><input type="password" name="passconf" placeholder="Paswoord" value="<?php echo set_value('passconf'); ?>" size="20" /></td>
        <td><?php echo form_error('passconf'); ?></td>
    </tr>
    <tr>
        <td><label for="email">Email Adres</label></td>
        <td><input type="text" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>" size="20" /></td>
        <td><?php echo form_error('email'); ?></td>
    </tr>
    <tr>
        <td colspan="3"><input type="submit" value="Registreer nu!" /></td>
    </tr>
</table>
<?php echo form_close(); ?>