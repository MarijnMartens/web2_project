<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        for($i = date('Y')-16; $i >= date('Y')-70; $i--)
        {
            echo "'$i', ";
        }
        ?>
    </body>
</html>
