<?php
//edit23
/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Last modified on: 08/01/2014
 * Edit: 08/01/2014: message page for all sorts of errors / restrictions / success messages
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    public function message(){
        $headerData = ['title' => 'Boodschap van algemeen nut'];
        //If we forget to set up a flash_session
        try {
            $msg = $this->session->flashdata('message');
        } catch (Exception $ex) {
            $msg = 'Intern iets misgelopen';
        }
        $bodyData = ['message' => $msg];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('message_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

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
