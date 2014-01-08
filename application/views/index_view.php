<!-- 
Author: Marijn
Created on: 20/12/2013
Last modified on: 26/12/2013
Edit: 04/01/2014: Twitter Timeline implentation
References: Official Twitter developer manual
-->

    <h1>Demonstratie inklappen eiland <span style="font-size: 0.5em;">▲</span></h1> <!-- bij klikken valt style weg -->
    <table>
        <tr>
            <td>row 1 col 1</td>
            <td>row 1 col 2</td>
        </tr>
        <tr>
            <td>row 2 col 1</td>
            <td>row 2 col 2</td>
        </tr>
        <tr>
            <td>row 3 col 1</td>
            <td>row 3 col 2 with extra long text</td>
        </tr>
    </table>

<script>
            $(document).ready(function()
            {
                $("h2").click(function()
                {
                    $(this).hide();
                    $(this).next().hide();
                });
            });
        </script>

<h1>Twitter</h1>
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
