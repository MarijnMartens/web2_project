<?php

/*
 * Author: Marijn
 * Created on: 04/01/2014
 * References: Inspired by: http://www.sparklepod.com/myblog/codeigniter-session-and-login-tutorial/
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseController extends CI_Controller {

    function BaseController() {
        parent::__construct();
        if (!$this->session->userdata('validated')) {
            redirect('login');
        }
    }

}
