<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <title>Twitter Widget</title>
    </head>
    <body style="background-color: lime;">
        <?php
        $this->db->where('username', 'maarten');
        $query = $this->db->get('users');
            $row = $query->row();
                    $username = $row->username;
                    $email = $row->email;
                
        echo 'username is ' . $username . '<br/>';
        echo 'email is ' . $email . '<br/>';
        
        ?>
    </body>
</html>
