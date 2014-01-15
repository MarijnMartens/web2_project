<?php

/*
 * Author: Marijn
 * Created on: 14/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MyAccess {
    //check if there are missing arguments
    public function missingArguments($data){
        //keep flash
        /*if(isset($data['flash'])){
        $CI =& get_instance();
        $CI->session->keep_flashdata($data['flash']);
        }*/
        if ($data['argument'] == null){
            //instantiate
        $CI =& get_instance();
        $CI->session->set_flashdata('message', 'Er is iets misgelopen, contacteer de Admin,  indien je niet zelf probeerde via een zelfgeschreven URL naar deze pagina te gaan');
            redirect('welcome/message');
        } 
         
    }
    //check if user can delete topic
    public function deleteTopic($data) {
        //instantiate
        $CI = & get_instance();
        //get userlevel
        $userLevel = $CI->session->userdata('level');
        //get forumlevel
        $CI->load->model('forum_model');
        $forumLevel = $CI->forum_model->getLevel($data['forum_id']);
        //compare levels
        if ($userLevel >= 3 && $forumLevel < $userLevel) {
            return true;
        } else {
            return false;
        }
    }
    //check if user can create topic
    public function insertTopic() {
        //instantiate
        $CI = & get_instance();
        //get userlevel
        $userLevel = $CI->session->userdata('level');
        if ($userLevel < 1) {
            $CI->session->set_flashdata('message', 'Je moet eerst inloggen vooraleer je een topic mag aanmaken');
            redirect('welcome/message');
        }
    }

}
