<?php

/*
 * Author: Marijn
 * Created on: 18/01/2014
 */

/* if (!defined('BASEPATH'))
  exit('No direct script access allowed'); */

class Search extends CI_Controller {

    public function index() {
        $this->load->model('search_model');
        $keyword = trim($this->input->post('search'));
        $result = $this->search_model->getAll($keyword);
        //Empty arrays count as null
        if (!(array_filter($result) == null)) {
            $bodyData['result'] = $result;
            $bodyData['title'] = 'Zoekresultaten';
            $bodyData['view'] = 'search_view';
            $this->load->view('template/tmpPage_view', $bodyData);
        } else { //No results
            $this->session->set_flashdata('message', 'Geen zoekresultaten');
            redirect('welcome/message');
        }
    }

}
