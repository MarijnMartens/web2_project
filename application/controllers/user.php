<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->check_isvalidated();
    }

    public function index() {
        // If the user is validated, then this function will run
        $headerData = ['title' => 'Ingelogd',
            'info' => $this->session->all_userdata()];
        $bodyData = ['username' => $this->session->userdata['username']];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('home_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    private function check_isvalidated() {
        if (!$this->session->userdata('validated')) {
            redirect('login');
        }
    }

    public function logout() {
        $msg = '<p>Tot ziens ' . $this->session->userdata['username'] . ', tot binnenkort!.</p>';
        $this->session->sess_destroy();
        echo $msg;
    }

}

?>
