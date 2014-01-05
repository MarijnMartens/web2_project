<?php
//edit23
/*
 * Author: Marijn
 * Created on: 20/12/2013
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index() {
        $headerData = ['title' => 'Index'];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('index_view');
        $this->load->view('tmpFooter_view');
    }

    public function info() {
        $headerData = ['title' => 'Info'];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('info_view');
        $this->load->view('tmpFooter_view');
    }

    public function forum() {
        $headerData = ['title' => 'Forum'];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('forum_view');
        $this->load->view('tmpFooter_view');
    }

    public function event() {
        $headerData = ['title' => 'Events'];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('event_view');
        $this->load->view('tmpFooter_view');
    }

    public function login() {
        redirect(login);
    }

}
