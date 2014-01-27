<?php

/*
 * Author: Marijn
 * Created on: 11/01/2014
 * Special thanks to: http://thephpcode.com/blog/codeigniter/how-to-create-custom-404-page-with-codeigniter
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class my404 extends CI_Controller {

    public function index() {
        $this->output->set_status_header('404');
        $bodyData['title'] = 'Page not found';
        $bodyData['view'] = 'my404_view';
        $this->load->view('template/tmpPage_view', $bodyData);
        }

}
