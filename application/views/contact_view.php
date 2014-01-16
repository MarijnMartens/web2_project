<?php
/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php
// Instantiate the AYAH object. You need to instantiate the AYAH object
// on each page that is using PlayThru.
require_once("application/third_party/ayah/ayah.php");
$ayah = new AYAH();
?>
<?php echo form_open('welcome/contact'); ?>
<?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>
<table>
    <tr>
        <td><label for="name">Naam</label></td>
        <td><input type="text" name="name" placeholder="Naam" value="<?php echo set_value('name'); ?>" size="20" /></td>
        <td><?php echo form_error('name'); ?></td>
    </tr>
    <tr>
        <td><label for="email">Email Adres</label></td>
        <td><input type="text" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>" size="20" /></td>
        <td><?php echo form_error('email'); ?></td>
    </tr>
    <tr>
        <td><label for="subject">Onderwerp</label></td>
        <td><input type="text" name="subject" placeholder="Onderwerp" value="<?php echo set_value('subject'); ?>" size="70" /></td>
        <td><?php echo form_error('subject'); ?></td>
    </tr>
    <tr>
        <td><label for="message">Bericht Inhoud</label></td>
        <td><textarea name="message" rows="10" cols="80" wrap="soft" placeholder="Bericht"><?php echo set_value('message'); ?></textarea></td>
        <td><?php echo form_error('message'); ?></td>
    </tr>
    <tr>
        <td>Voer de captcha uit</td>
        <td><?php echo $ayah->getPublisherHTML(); ?></td>
    </tr>
    <tr>
        <td colspan="3"><input type="submit" value="Stuur bericht naar Admin" /></td>
    </tr>
</table>
<?php echo form_close(); ?>