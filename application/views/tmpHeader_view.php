<!-- 
Author: Marijn
Created on: 20/12/2013
Last modified on: 04/01/2014
Edit: 04/01/2014: Session implementation; hide/show user controls
References: none
-->

<!DOCTYPE html>
<html lang="nl"> <!-- Important for the Twitter Timeline -->
    <head>
        <meta charset="UTF-8">
        <title><?PHP echo $title; ?></title>
        <link rel="icon" href="../../assets/images/logo.ico" type="image/x-icon">
        <?PHP echo link_tag('../assets/css/layout.css'); ?>
        <!-- Download jquery if not on computer -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
        </script>
        <!-- collapse item -->
        <script>
            $(document).ready(function()
            {
                var toggle = true;
                var txt = '';
                $("h1").click(function()
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
        <script>
            $(document).ready(function()
            {
                $("h3").click(function()
                {
                    $(this).next().slideToggle("slow");
                });
            });
        </script>

    </head>
    <body>
        <header>
            <a href="<?php echo base_url('welcome/index'); ?>"><img src="../../assets/images/logo.png" alt="logo" height="100"/><a/>
                <ul id="login_menu" <?php if ($this->session->userdata('validated') == TRUE) echo 'style="visibility: hidden;"'; ?>>
                    <li><a href="<?php echo base_url('login/index'); ?>">Login</a></li>
                    <li><a href="<?php echo base_url('login/register'); ?>">Registreer</a></li>
                </ul>

                <ul id="user_menu" <?php if ($this->session->userdata('validated') == TRUE) echo 'style="visibility: visible;"'; ?>>
                    <li><a href="<?php echo base_url('profile/view'); ?>">Settings</a></li>
                    <li>messenger</li>
                    <li><a href="<?php echo base_url('profile/all'); ?>">Ledenlijst</a></li>
                    <li>notifications</li>
                    <li><a href="<?php echo base_url('login/logout'); ?>">Logout</a></li>
                </ul>

                <ul id="menu">
                    <li><a href="<?php echo base_url('welcome/index'); ?>">Startpagina</a></li>
                    <li><a href="<?php echo base_url('forum/index'); ?>">Forum</a></li>
                    <li><a href="<?php echo base_url('event/view'); ?>">Evenementen</a></li>
                    <li><a href="<?php echo base_url('welcome/info'); ?>">Info</a></li>
                    <li><a href="<?php echo base_url('welcome/contact'); ?>">Contact</a></li>
                </ul>
        </header>