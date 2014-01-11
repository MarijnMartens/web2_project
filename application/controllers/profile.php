<?php

/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once 'basecontroller.php';

class Profile extends BaseController {

    //view displays all information in a view-only format
    public function view() {
        $this->load->model('login_model');
        $bodyData['userdata'] = $this->login_model->getUserdata($this->session->userdata('user_id'));
        //getUserData failed
        if(!$bodyData['userdata']){
            $this->session->set_flashdata('message', 'Userdata kon niet opgehaald worden');
            redirect('welcome/message');
        }
        
        //insert all userdata in flash
        $this->session->set_flashdata('userdata', $bodyData['userdata']);

        $headerData = ['title' => 'Profile'];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('profile/profile_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    //edit non-critical user information
    public function edit($error = NULL) {
        $userdata = $this->session->flashdata('userdata');
        $fName = array(
            'name' => 'fName',
            'id' => 'fName',
            'value' => $userdata['fName']
        );
        $lName = array(
            'name' => 'lName',
            'id' => 'lName',
            'value' => $userdata['lName']
        );
        $dateOfBirth = array(
            'name' => 'dateOfBirth',
            'id' => 'dateOfBirth',
            'value' => $userdata['dateOfBirth']
        );
        //Check gender
        if ($userdata['gender'] = 'm') {
            $sexM = true;
            $sexF = false;
        } else {
            $sexM = false;
            $sexF = true;
        }
        $genderM = array(
            'name' => 'gender',
            'id' => 'gender',
            'value' => 'm',
            'checked' => $sexM
        );
        $genderF = array(
            'name' => 'gender',
            'id' => 'gender',
            'value' => 'f',
            'checked' => $sexF
        );
        $city = array(
            'name' => 'city',
            'id' => 'city',
            'value' => $userdata['city']
        );

        $headerData = ['title' => 'Edit profile'];
        $bodyData['userdata'] = array(
            'fName' => $fName,
            'lName' => $lName,
            'dateOfBirth' => $dateOfBirth,
           /* 'genderM' => $genderM,
            'genderF' => $genderF,*/
            'city' => $city
        );
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('profile/edit_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }
    
    //save non-critical user information
    public function save(){
        //get all fields, xss filter
        $this->input->post(NULL, TRUE);
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        //Input field validation
        $this->form_validation->set_rules(
                'fName', 'Voornaam',
                'min_length[2]|'
                . 'max_length[20]|'
        );
        $this->form_validation->set_rules(
                'lName', 'Achternaam',
                'min_length[2]|'
                . 'max_length[20]|'
        );
        $this->form_validation->set_rules(
                'fName', 'Voornaam',
                'min_length[2]|'
                . 'max_length[20]|'
        );
        
        //Validation form
        if ($this->form_validation->run() == FALSE) {
            $this->edit();
        } else {
            $this->load->model('register_model');
            $result = $this->register_model->editProfile(
                    $this->session->userdata('user_id'),
                    $this->input->post('fName'),
                    $this->input->post('lName'),
                    $this->input->post('dateOfBirth'),
                   $gender = null,
                    $this->input->post('city'));
            if (!$result) { //Model did not insert data in database
                $error = 'Invoer in database is mislukt';
                $this->edit($error);
            } else {
                $this->view();
            }
            
        }
    }

}
