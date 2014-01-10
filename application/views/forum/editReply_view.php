<?php 
$this->load->helper('form');
echo form_open('forum/editReplyProcess'); ?>
<?php if (!is_null($error)){ echo "<span class='error'>$error</span><br/>"; }?>
<table>
    <tr>
        <td><label for="reply">Reply</label></td>
        <td><textarea name="reply" rows="4" cols="50"><?php echo $msg; ?><?php echo set_value('reply'); ?></textarea></td>
    </tr>
    <tr>
        <td colspan="3"><input type="submit" value="Wijzig reply" /></td>
    </tr>
</table>
<?php echo form_close();