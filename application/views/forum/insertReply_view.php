<!-- 
Author: Marijn
Created on: 08/01/2014
References: none
-->

<?php echo form_open('forum/insertReply'); ?>
<?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>
<table>
    <tr>
        <td><label for="reply">Reply</label></td>
        <td><textarea name="reply" rows="10" cols="80" wrap="soft" placeholder="Hier je antwoord"><?php echo set_value('reply'); ?></textarea></td>
    </tr>
    <?php echo $captcha; ?>
    <tr>
        <td colspan="3"><input type="submit" value="Maak reply aan" /></td>
    </tr>
</table>
<?php echo form_close(); ?>