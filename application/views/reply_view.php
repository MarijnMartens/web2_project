<h1>Replies</h1>
<table border='1'>
    <?php echo "$count Replies"; ?>
    <?php foreach ($replies as $reply) { ?>
        <tr>
            <td><?php echo $reply->date; ?></td>
            <td><?php echo $reply->username; ?></td>
            <td><?php echo $reply->message; ?></td>
        </tr>
    <?php } ?>
</table>