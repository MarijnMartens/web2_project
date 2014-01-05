<?php echo form_open('forum/insertTopic'); ?>
<?php if (!is_null($error)) echo "<span class='error'>$error</span><br/>"; ?>
<table>
    <tr>
        <td><label for="title">Title</label></td>
        <td><input type="text" name="title" placeholder="Title" value="<?php echo set_value('title'); ?>" size="75" /></td>
    </tr>
    <tr>
        <td colspan="3"><input type="submit" value="Maak topic aan" /></td>
    </tr>
</table>
<?php echo form_close(); ?>