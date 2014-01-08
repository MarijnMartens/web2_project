<?php echo form_open('forum/insertTopic'); ?>
<?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>
<table>
    <tr>
        <td><label for="title">Topic-naam</label></td>
        <td><input type="text" name="title" placeholder="Topic-naam" value="<?php echo set_value('title'); ?>" size="70" /></td>
        <td><?php echo form_error('title'); ?></td>
    </tr>
    <tr>
        <td><label for="reply">Open post</label></td>
        <td><textarea name="reply" value="<?php echo set_value('reply'); ?>" rows="4" cols="50"></textarea></td>
        <td><?php echo form_error('reply'); ?></td>
    </tr>
    <tr>
        <td colspan="3"><input type="submit" value="Maak topic aan" /></td>
    </tr>
</table>
<?php echo form_close(); ?>