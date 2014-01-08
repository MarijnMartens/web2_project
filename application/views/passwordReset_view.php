<!-- 
Author: Marijn
Created on: 20/12/2013
References: none
-->

<form action='<?php echo base_url(); ?>login/password_reset' method='post' name='password_reset'>
    <h2>Vul gebruikersnaam en/of email adres in</h2>
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
        <tr>
            <td colspan="2"><input type='submit' value='Stuur een nieuw paswoord!' /></td>
        </tr>
    </table>
</form>