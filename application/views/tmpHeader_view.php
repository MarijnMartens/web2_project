<!DOCTYPE html>
<html lang="nl"> <!-- Important for the Twitter Timeline -->
    <head>
        <meta charset="UTF-8">
        <title><?PHP echo $title; ?></title>
        <link rel="icon" href="../../assets/images/logo.ico" type="image/x-icon">
        <?PHP echo link_tag('../assets/css/layout.css'); ?>
    </head>
    <body>
        <header>
            <img src="../../assets/images/logo.png" alt="logo" height="100"/>
            <ul id="login_menu">
                <li><a href="<?php echo base_url('login/index'); ?>">Login</a></li>
                <li><a href="<?php echo base_url('login/register'); ?>">Register</a></li>
            </ul>

            <ul id="user_menu">
                <li>settings</li>
                <li>messenger</li>
                <li>member list</li>
                <li>notifications</li>
                <li>logout</li>
            </ul>

            <ul id="menu">
                <li><a href="<?php echo base_url('welcome/index'); ?>">Home</a></li>
                <li><a href="<?php echo base_url('forum/index'); ?>">Forum</a></li>
                <li>Events</li>
                <li><a href="<?php echo base_url('welcome/info'); ?>">Info</a></li>
                <li>Contact</li>
            </ul>
        </header>