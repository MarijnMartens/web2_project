<?php

/*
 * Author: Laurens
 * Created on: 29/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event extends CI_Controller {
    public function index() {
        $bodyData['title'] = 'Evenementen';
        $bodyData['view'] = 'event_view';
        $this->load->view('template/tmpPage_view', $bodyData);
    }
    
    public function edit() {
        
    }
    
    public function insert() {
        
    }
}

