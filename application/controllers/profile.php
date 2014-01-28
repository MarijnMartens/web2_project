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
    public function index($user_id = null) {
        if ($user_id == null) {
            //current user, get ALL userdata
            $this->load->model('login_model');
            $bodyData['userdata'] = $this->login_model->getUserdata($this->session->userdata('user_id'));
        } else {
            //page directed from other url than menu, check if user == profile request user
            if ($user_id == $this->session->userdata('user_id')) {
                $this->load->model('login_model');
                $bodyData['userdata'] = $this->login_model->getUserdata($this->session->userdata('user_id'));
            } else {
                //other user, get LIMITED userdata
                $this->load->model('search_model');
                $bodyData['userdata'] = $this->search_model->getUserdata($user_id);
            }
        }

        //getUserData failed
        if (!$bodyData['userdata']) {
            $this->session->set_flashdata('message', 'Userdata kon niet opgehaald worden');
            redirect('welcome/message');
        }
        //insert all userdata in flash
        $this->session->set_flashdata('userdata', $bodyData['userdata']);
        //Display profilepage
        $bodyData['title'] = 'Profieldetails';
        $bodyData['view'] = 'profile/profile_view';
        $this->load->view('template/tmpPage_view', $bodyData);
    }

    //edit user information
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
        $avatar = array(
            'name' => 'userfile',
            'id' => 'userfile'
        );
        $email = array(
            'name' => 'email',
            'id' => 'email',
            'value' => $userdata->email
        );
        $emailConf = array(
            'name' => 'emailConf',
            'id' => 'emailConf',
        );
        $password = array(
            'name' => 'password',
            'id' => 'password',
        );
        $passwordConf = array(
            'name' => 'passwordConf',
            'id' => 'passwordConf'
        );
        $passwordOld = array(
            'name' => 'passwordOld',
            'id' => 'passwordOld'
        );

        $bodyData['title'] = 'Edit profile';
        $bodyData['error'] = $error;
        $bodyData['userdata'] = array(
            'fName' => $fName,
            'lName' => $lName,
            'dateOfBirth' => $dateOfBirth,
            'genderM' => $genderM,
            'genderF' => $genderF,
            'city' => $city,
            'avatar' => $avatar,
            'email' => $email,
            'emailConf' => $emailConf,
            'password' => $password,
            'passwordConf' => $passwordConf,
            'passwordOld' => $passwordOld
        );
        $bodyData['view'] = 'profile/edit_view';
        $this->load->view('template/tmpPage_view', $bodyData);
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
        $this->form_validation->set_rules(
                'email', 'Email adres', 'required|'
                . 'valid_email|'
                . 'is_unique[user.email]'
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
            $email = $this->input->post('email');
            $dateOfBirth = array($year, $month, $day);
            $dateOfBirth = implode('-', $dateOfBirth);
            //upload avatar
            $config['upload_path'] = './assets/images/avatars/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '1024';
            $config['max_width'] = '2000';
            $config['max_height'] = '1300';

            $this->load->library('upload', $config);
            //check if a new avatar is provided
            if (!empty($_FILES['userfile']['name'])) {
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    // print_r($error);
                    //input forms in flashdata zetten
                    $userdata = array(
                        'fName' => $fName,
                        'lName' => $lName,
                        'gender' => $gender,
                        'city' => $city,
                        'dateOfBirth' => $dateOfBirth,
                        'email' => $email
                    );
                    $this->session->set_flashdata('userdata', $userdata);

                    $this->edit($error);
                } else {
                    $upload_data = $this->upload->data();
                    $file_name = $upload_data['file_name'];
                    //print_r($data);
                }
                //no new avatar selected
            } else {
                $file_name = null;
            }

            //process changes
            $this->load->model('register_model');
            $result = $this->register_model->editProfile(
                    $this->session->userdata('user_id'), $fName, $lName, $dateOfBirth, $gender, $city, $file_name, $email
            );

            //check update database
            if (!$result) { //Model did not insert data in database
                $error = 'Invoer in database is mislukt';
                //$this->edit($error);
                $this->session->set_flashdata('message', $error);
                redirect('welcome/message');
            } else {
                //display profile after edit
                redirect('profile');
            }
        }
    }

    //save non-critical user information
    public function saveSecure() {
        //get all fields, xss filter
        $this->input->post(NULL, TRUE);
        //format errors
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        //Input field validation
        $this->form_validation->set_rules(
                'password', 'Paswoord', 'min_length[3]|' . 'matches[passConf]'
        );
        $this->form_validation->set_rules(
                'passConf', 'Herhaling paswoord'
        );
        $this->form_validation->set_rules(
                'email', 'Email adres', 'valid_email|'
                . 'matches[emailConf]'
        );
        $this->form_validation->set_rules(
                'emailConf', 'Email adres'
        );
        $this->form_validation->set_rules(
                'passwordOld', 'Huidig paswoord', 'required'
        );

        //Validation form
        if ($this->form_validation->run() == FALSE) {
            $this->edit();
        } else {
            $email = $this->input->post('email');
            $emailConf = $this->input->post('emailConf');
            $password = $this->input->post('password');
            $passwordConf = $this->input->post('passwordConf');
            $passwordOld = $this->input->post('passwordOld');
            //load model
            $this->load->model('register_model');
            //Check if email has changed
            if ($email != $this->session->userdata('email')) {
                //Check if both email fields are filled
                if ($email == $emailConf) {
                    $result = $this->register_model->editProfileSecure(
                            $this->session->userdata('user_id'), $passwordOld, $email);
                    //check update database
                    if (!$result) { //Model did not insert data in database
                        $error = 'Invoer in database is mislukt';
                        //$this->edit($error);
                        $this->session->set_flashdata('message', $error);
                        redirect('welcome/message');
                    }
                }
            }
        }
    }

    public function all() {
        $this->load->model('search_model');
        $result = $this->search_model->getUsernames();
        //array alphabet
        $alphabet_keys = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ', 1);
        //set values as keys with array as value
        $alphabet = array();
        foreach ($alphabet_keys as $letter) {
            $alphabet[$letter] = array();
        }
        //get usernames, place in array corresponding begin letter
        foreach ($result as $row) {
            $username = $row->username;
            //Iterate from A to Z
            for ($i = 'A'; $i != 'AA'; $i++) {
                if (substr($username, 0, 1) == $i) {
                    array_push($alphabet[$i], $row/* array($row->id, $username) */);
                }
            }
        }
        $bodyData['title'] = 'Ledenlijst';
        $bodyData['alphabet'] = $alphabet;
        $bodyData['view'] = 'users_view';
        $this->load->view('template/tmpPage_view', $bodyData);
    }
}
