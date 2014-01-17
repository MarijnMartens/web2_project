<?php
/*
 * Author: Marijn
 * Created on: 16/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php 
if(!(isset($aside_visible))){
    $aside_display = '';
} else {
    $aside_display = 'style="display: none;"';
}
?>
<!-- Hide / Show section -->
<script>
    $(document).ready(function()
    {
        var toggle = true;
        var txt = '';
        $("article id='toggle'").click(function()
        {
            txt = $(this).text();
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

<?php 
//Load custom view, done this way to display a view within this template view
//This way I can create multiple 'island', need for ie the homepage
$this->load->view($view);
?>

<aside <?php echo $aside_display; ?>>
    <div id="twitter"><!-- Start Twitter timeline -->
        <div id="twitter-timeline"
             <a class="twitter-timeline"  
           width="200"
           height="500"
           data-link-color="#1c8017"
           data-chrome="nofooter noscrollbar"
           href="https://twitter.com/Marijn_Martens"  
           data-widget-id="416921452827275264">Tweets by @Marijn_Martens</a>
        </div>
        <script>!function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + "://platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, "script", "twitter-wjs");</script>
    </div><!-- End Twitter timeline -->
</aside>