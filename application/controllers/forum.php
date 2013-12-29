<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum extends CI_Controller {
    public function index(){
        $headerData = ['title' => 'Forum'];
        
        $this->load->model('forum_model');
        $result = $this->forum_model->getFora();
               
        $bodyData['fora'] = $result;
        
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('forum_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }
    
    public function topics($forum_id){
        $headerData = ['title' => 'Topics'];
        
        $this->load->model('topic_model');
        $result = $this->topic_model->getTopics($forum_id);
        
        $bodyData['topics'] = $result;
        
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('topic_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }
}