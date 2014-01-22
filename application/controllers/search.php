<?php

/*
 * Author: Marijn
 * Created on: 18/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {
    public function index(){
        echo $this->input->post('search');
    }
}