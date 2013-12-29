<p>FORUM</p>
<table border='1'>
    <?php echo "Aantal posts $aantal"; ?>
    <?php foreach ($posts as $post) { ?>
        <tr>
            <td><?php echo $post->date; ?></td>
            <td><?php echo $post->username; ?></td>
            <td><?php echo $post->message; ?></td>
        </tr>
    <?php } ?>
</table>