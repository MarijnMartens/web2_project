<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of allCities
 *
 * @author Marijn
 */
class allCities extends CI_Controller{
    public function index()
    {
    $headerData = ['title' => 'AllCities'];
    $this->load->view('tmpHeader_view', $headerData);
    
    $bodyData = ['heading' => 'Alle gemeneenten'];
    $this->load->model('City_model');
    $bodyData['gemeenten'] = $this->City_model->getCities();
    $this->load->view('cities_view', $bodyData);
    
    $this->load->view('tmpFooter_view');
    }
}
