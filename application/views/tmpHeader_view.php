<!DOCTYPE html>
<html lang="nl"> <!-- van belang voor de twitter timeline -->
    <head>
        <meta charset="UTF-8">
        <title><?PHP echo $title; ?></title>
        <?PHP echo link_tag('../assets/css/layout.css'); ?>
        <?PHP //echo $level; ?>
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
                <li><a href="<?php echo base_url('welcome/forum'); ?>">Forum</a></li>
                <li><a href="<?php echo base_url('welcome/events'); ?>">Events</a></li>
                <li><a href="<?php echo base_url('welcome/info'); ?>">Info</a></li>
                <li><a href="<?php echo base_url('welcome/contact'); ?>">Contact</a></li>
            </ul>
        </header>