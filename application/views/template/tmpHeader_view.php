<?php
/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Last modified on: 16/01/2014
 * Edit: 04/01/2014: Session implementation; hide/show user controls
 * Edit: 16/01/2014: divided code over tmpHeader_view and tmpPage_view
 * References: none
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="nl"> <!-- Important for the Twitter Timeline -->
    <head>
        <meta charset="UTF-8">
        <!-- Get page-title -->
        <title><?PHP echo $title; ?></title>
        <!-- Get icon -->
        <?PHP echo link_tag('assets/images/logo.ico', 'shortcut icon', 'image/ico'); ?>
        <!-- Get css -->
        <?PHP echo link_tag("assets/css/layout.css"); ?>
        <!-- Download jquery if not on computer -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <!-- Get logo -->
            <a href="<?php echo base_url('welcome'); ?>"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" height="100"/><a/>
            <div id='login_menu'>
                <ul id="login_menu" <?php if ($this->session->userdata('validated') == TRUE) echo 'style="visibility: hidden;"'; ?>>
                    <li><a href="<?php echo base_url('login'); ?>">Login</a></li>
                    <li><a href="<?php echo base_url('login/register'); ?>">Registreer</a></li>
                </ul>
            </div><!-- End login-menu -->
            <div id ='user_menu'><!-- Start user-menu -->
                <ul id="user_menu" <?php if ($this->session->userdata('validated') == TRUE) echo 'style="visibility: visible;"'; ?>>
                    <li><a href="<?php echo base_url('profile'); ?>">Profiel</a></li>
                    <li>messenger</li>
                    <li><a href="<?php echo base_url('profile/all'); ?>">Ledenlijst</a></li>
                    <li>notifications</li>
                    <li><a href="<?php echo base_url('login/logout'); ?>">Logout</a></li>
                </ul>
            </div><!-- End user-menu -->
            <div id='menu'><!-- Start menu --> 
                <ul id="menu">
                    <li><a href="<?php echo base_url('welcome'); ?>">Startpagina</a></li>
                    <li><a href="<?php echo base_url('forum'); ?>">Forum</a></li>
                    <li><a href="<?php echo base_url('event'); ?>">Evenementen</a></li>
                    <li><a href="<?php echo base_url('welcome/info'); ?>">Info</a></li>
                    <li><a href="<?php echo base_url('welcome/contact'); ?>">Contact</a></li>
                    <li><a href="<?php echo base_url('welcome/multimedia'); ?>">Multimedia</a></li>                    
                </ul>
                <!-- Search form -->
                <form action="<?php echo base_url('search'); ?>" method="post">
                    <input type="text" name="search" placeholder="Zoeken" size="25"/>
                    <input type="submit" name="submit" value="Zoeken"/>
                </form>
            </div><!-- End meu -->
        </header>