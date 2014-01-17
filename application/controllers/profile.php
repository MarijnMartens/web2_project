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
    public function index() {
        $this->load->model('login_model');
        $bodyData['userdata'] = $this->login_model->getUserdata($this->session->userdata('user_id'));
        //getUserData failed
        if (!$bodyData['userdata']) {
            $this->session->set_flashdata('message', 'Userdata kon niet opgehaald worden');
            redirect('welcome/message');
        }
        //insert all userdata in flash
        $this->session->set_flashdata('userdata', $bodyData['userdata']);
        //Display profilepage
        $headerData['title'] = 'Profile';
        $bodyData['view'] = 'profile/profile_view';
        $this->load->view('template/tmpHeader_view', $headerData);
        $this->load->view('template/tmpPage_view', $bodyData);
        $this->load->view('template/tmpFooter_view');
    }

    //edit non-critical user information
    public function edit($error = NULL) {
        //get all data from index 
        $userdata = $this->session->flashdata('userdata');
        //prepare form fields, fill value where provided
        $fName = array(
            'name' => 'fName',
            'id' => 'fName',
            'value' => $userdata->fName
        );
        $lName = array(
            'name' => 'lName',
            'id' => 'lName',
            'value' => $userdata->lName
        );
        $dateOfBirth = $userdata->dateOfBirth;
        //Fill radiogroup gender
        if ($userdata->gender == 'm') {
            $sexM = true;
            $sexF = false;
        } else if ($userdata->gender == 'f') {
            $sexM = false;
            $sexF = true;
        } else {
            $sexM = false;
            $sexF = false;
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
            'value' => $userdata->city
        );

        $headerData['title'] = 'Edit profile';
        $bodyData['userdata'] = array(
            'fName' => $fName,
            'lName' => $lName,
            'dateOfBirth' => $dateOfBirth,
            'genderM' => $genderM,
            'genderF' => $genderF,
            'city' => $city
        );
        $bodyData['view'] = 'profile/edit_view';
        $this->load->view('template/tmpHeader_view', $headerData);
        $this->load->view('template/tmpPage_view', $bodyData);
        $this->load->view('template/tmpFooter_view');
    }

    //save non-critical user information
    public function save() {
        //get all fields, xss filter
        $this->input->post(NULL, TRUE);
        //format errors
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        //Input field validation
        $this->form_validation->set_rules(
                'fName', 'Voornaam', 'min_length[2]|'
                . 'max_length[20]|'
        );
        $this->form_validation->set_rules(
                'lName', 'Achternaam', 'min_length[2]|'
                . 'max_length[20]|'
        );
        $this->form_validation->set_rules(
                'fName', 'Voornaam', 'min_length[2]|'
                . 'max_length[20]|'
        );

        //Validation form
        if ($this->form_validation->run() == FALSE) {
            $this->edit();
        } else {
            $fName = $this->input->post('fName');
            $lName = $this->input->post('lName');
            $day = $this->input->post('day');
            $month = $this->input->post('month');
            $year = $this->input->post('year');
            $gender = $this->input->post('gender');
            $city = $this->input->post('city');
            $dateOfBirth = array($year, $month, $day);
            $dateOfBirth = implode('-', $dateOfBirth);
            //process changes
            $this->load->model('register_model');
            $result = $this->register_model->editProfile(
                    $this->session->userdata('user_id'), $fName, $lName, $dateOfBirth, $gender, $city
            );
            if (!$result) { //Model did not insert data in database
                $error = 'Invoer in database is mislukt';
                $this->edit($error);
            } else {
                $this->index();
            }
        }
    }

}
