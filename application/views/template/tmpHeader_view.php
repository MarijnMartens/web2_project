<?php

/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Last modified on: 04/01/2014
 * Edit: 04/01/2014: Session implementation; hide/show user controls
 * References: none
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 ?>

<!DOCTYPE html>
<html lang="nl"> <!-- Important for the Twitter Timeline -->
    <head>
        <meta charset="UTF-8">
        <title><?PHP echo $title; ?></title>
        <?PHP echo link_tag('assets/images/logo.ico', 'shortcut icon', 'image/ico'); ?>
        <?PHP echo link_tag("assets/css/layout.css"); ?>
        <!-- Download jquery if not on computer -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <a href="<?php echo base_url('welcome/index'); ?>"><img src="../assets/images/logo.png" alt="logo" height="100"/><a/>
                <ul id="login_menu" <?php if ($this->session->userdata('validated') == TRUE) echo 'style="visibility: hidden;"'; ?>>
                    <li><a href="<?php echo base_url('login/index'); ?>">Login</a></li>
                    <li><a href="<?php echo base_url('login/register'); ?>">Registreer</a></li>
                </ul>
                
                <ul id="user_menu" <?php if ($this->session->userdata('validated') == TRUE) echo 'style="visibility: visible;"'; ?>>
                    <li><a href="<?php echo base_url('profile/index'); ?>">Profiel</a></li>
                    <li>messenger</li>
                    <li><a href="<?php echo base_url('profile/all'); ?>">Ledenlijst</a></li>
                    <li>notifications</li>
                    <li><a href="<?php echo base_url('login/logout'); ?>">Logout</a></li>
                </ul>

                <ul id="menu">
                    <li><a href="<?php echo base_url('welcome/index'); ?>">Startpagina</a></li>
                    <li><a href="<?php echo base_url('forum/index'); ?>">Forum</a></li>
                    <li><a href="<?php echo base_url('event/index'); ?>">Evenementen</a></li>
                    <li><a href="<?php echo base_url('welcome/info'); ?>">Info</a></li>
                    <li><a href="<?php echo base_url('welcome/contact'); ?>">Contact</a></li>
                </ul>
        </header>