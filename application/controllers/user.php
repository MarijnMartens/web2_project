<?php

/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Last modified on: 04/01/2014
 * Edit: 04/01/2014: Moving session control to baseController
 * References: Session control: http://www.sparklepod.com/myblog/codeigniter-session-and-login-tutorial/
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once 'basecontroller.php';

class User extends BaseController {

    public function index() {
        // If the user is validated, then this function will run
        $headerData = ['title' => 'Ingelogd',
            'info' => $this->session->all_userdata()
        ];
        $bodyData = ['username' => $this->session->userdata['username']];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('home_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }
    
}

?>
