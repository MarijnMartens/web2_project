<?php echo form_open('forum/insertReply'); ?>
<?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>
<table>
    <tr>
        <td><label for="reply">Reply</label></td>
        <td><textarea name="reply" value="<?php echo set_value('reply'); ?>" rows="4" cols="50"></textarea></td>
    </tr>
    <tr>
        <td colspan="3"><input type="submit" value="Maak reply aan" /></td>
    </tr>
</table>
<?php echo form_close(); ?>