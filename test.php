<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo $tijd = (time() - strtotime('5 January 2014') . (microtime() * 1000000));
        echo '<br/>';
        echo time();
        echo '<br/>';
        echo microtime()* 1000000;
        echo '<br/>';
        echo time() - strtotime('5 January 2014');
        ?>
    </body>
</html>
