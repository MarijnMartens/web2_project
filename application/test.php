<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <!-- Hide / Show article -->
        <script>
            $(document).ready(function()
            {
                var toggle = true;
                var txt = '';
                $('.toggle').click(function()
                {
                    txt = $(this).text();
                    //Hide / show next element
                    $(this).next().slideToggle("slow");
                    if (toggle == true) {
                        $(this).text(txt.replace('▲', '▼'));
                        toggle = false;
                    } else {
                        $(this).text(txt.replace('▼', '▲'));
                        toggle = true;
                    }
                });
            });
        </script>

        <script>
            
            var i;
            var arrayBoolean = new Array();
            var arrayTitles = new Array();
            arrayTitles = (this).innerText();
        </script>
    </head>
    <body>
        <a class="toggle" onclick="loadBoolean()">Test AJAX</a>
        <?php
        // put your code here
        ?>
    </body>
</html>
