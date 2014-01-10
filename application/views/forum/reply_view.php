<h1>Replies</h1>
<p><a href="<?php echo base_url('forum/insertReply'); ?>">Insert new reply</a></p>
<table border='1'>
    <?php echo "$count Replies"; ?>
    <?php foreach ($replies as $reply) { ?>
        <tr>
            <td><?php echo $reply->date; ?></td>
            <td><?php
                if ($reply->username != NULL) {
                    echo $reply->username;
                    if ($reply->user_id == $this->session->userdata('user_id')) {
                        $delete = true;
                    } else if ($this->session->userdata('level') >= 2) {
                        $delete = true;
                    }
                } else {
                    echo 'Gast' . $reply->guest_id;
                    if ($reply->guest_id == $this->session->userdata('guest_id')) {
                        $delete = true;
                    }
                }
                ?></td>
            <td><?php echo nl2br($reply->message); ?></td>
            <?php if (isset($delete)) { ?>
                <td><a href="<?php echo base_url('forum/deleteReply'); ?>">Delete reply</a></td>
            <?php } ?> 
        </tr>
    <?php } ?>
</table>
<p><a href="<?php echo base_url('forum/insertReply'); ?>">Insert new reply</a></p>