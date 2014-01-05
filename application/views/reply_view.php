<h1>Replies</h1>
<p><a href="<?php echo base_url('forum/insertReply'); ?>">Insert new reply</a></p>
<table border='1'>
    <?php echo "$count Replies"; ?>
    <?php foreach ($replies as $reply) { ?>
        <tr>
            <td><?php echo $reply->date; ?></td>
            <td><?php if ($reply->username != NULL){
                echo $reply->username;
            } else {
                echo 'Gast' . $reply->guest_id; 
            }?></td>
            <td><?php echo $reply->message; ?></td>
        </tr>
    <?php } ?>
</table>
<p><a href="<?php echo base_url('forum/insertReply'); ?>">Insert new reply</a></p>