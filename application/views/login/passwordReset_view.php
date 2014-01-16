<?php
/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Edit on: 16/04/2014: Captcha added
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<h2>Vul in wat je nog weet</h2>
<?php echo validation_errors(); ?>
<form action='<?php echo base_url(); ?>login/password_reset' method='post' name='password_reset'>
    <?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>
    <table>
        <tr>
            <td><label for='username'>Gebruikersnaam</label></td>
            <td><input type='text' name='username' id='username' size='25' /></td>
        </tr>
        <tr>
            <td><label for='email'>Email adres</label></td>
            <td><input type='text' name='email' id='email' size='25' /></td>
        </tr>
        <?php echo $captcha; ?>
        <tr>
            <td colspan="2"><input type='submit' value='Stuur een nieuw paswoord!' /></td>
        </tr>
    </table>
</form>