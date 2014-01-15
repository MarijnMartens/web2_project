<?php 

/*
 * Author: Marijn
 * Created on: 09/01/2014
 */

$this->load->helper('form');
echo form_open('forum/editReplyProcess'); ?>
<?php if (!is_null($error)){ echo "<span class='error'>$error</span><br/>"; }?>
<table>
    <tr>
        <td><label for="reply">Reply</label></td>
        <td><textarea name="reply" rows="10" cols="80" wrap="soft" placeholder="Hier je antwoord"><?php echo $msg; ?><?php echo set_value('reply'); ?></textarea></td>
    </tr>
    <tr>
        <td colspan="3"><input type="submit" value="Wijzig reply" /></td>
    </tr>
</table>
<?php echo form_close();