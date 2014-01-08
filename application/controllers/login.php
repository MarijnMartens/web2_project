<?php

/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Last modified on: 04/01/2014
 * Edit: 26/12/2013: Email password reset
 * Edit: 04/01/2014: Logout function
 * Edit: 08/01/2014: Translated errors, reducing code
 * References: 
 * - Basic login control: http://www.jotorres.com/2012/03/create-user-login-with-codeigniter/
 * - Session control: http://www.sparklepod.com/myblog/codeigniter-session-and-login-tutorial/
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    //inloggen
    public function index($error = NULL) {
        $headerData = ['title' => 'Login'];
        $bodyData['error'] = $error;
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('login_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    public function login_process() {
        // grab user input
        // security handled in config.php
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        // Load the model
        $this->load->model('login_model');
        // Validate the user can login
        $result = $this->login_model->validate($username, $password);
        // Now we verify the result
        if (!$result) {
            // If user did not validate, then show them login page again
            $error = 'Gebruikersnaam en/of paswoord incorrect';
            $this->index($error);
        } else {
            // If user did validate, 
            // Send them to members area
            redirect('user');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        $this->index('Tot ziens!');
    }

    //register
    public function register($error = NULL) {
        //Call for methods
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        //Input field validation
        $this->form_validation->set_rules(
                'username', 'Gebruikersnaam', 'required|'
                . 'min_length[3]|'
                . 'max_length[20]|'
                . 'callback_register_username_check|'
                . 'is_unique[user.username]'
        );
        $this->form_validation->set_rules(
                'password', 'Paswoord', 'required|'
                . 'min_length[3]|'
                . 'matches[passconf]'
        );
        $this->form_validation->set_rules(
                'passconf', 'Herhaling paswoord', 'required|'
        );
        $this->form_validation->set_rules(
                'email', 'Email adres', 'required|'
                . 'valid_email|'
                . 'is_unique[user.email]'
        );

        //Validation form
        if ($this->form_validation->run() == FALSE) {
            $headerData = ['title' => 'Register'];
            $bodyData['error'] = $error;
            $this->load->view('tmpHeader_view', $headerData);
            $this->load->view('register_view', $bodyData);
            $this->load->view('tmpFooter_view');
        } else { //Validation is OK, open model to insert new user
            $this->load->model('register_model');
            $result = $this->register_model->setUsers(
                    $this->input->post('username'), $this->input->post('password'), $this->input->post('email')
            );
            if (!$result) { //Model did not insert data in database
                $bodyData = ['error' => 'Invoer in database is mislukt'];
                $this->register($error);
            } else {
                $this->login_process();
            }
        }
    }

    //'Admin' is not allowed as username to not confuse other users
    public function register_username_check($str) {
        if (!strcasecmp($str, 'admin')) { //strcasecmp is case insensitive
            $this->form_validation->set_message('username_check', '%s is niet toegelaten als gebruikersnaam');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //Forgot password
    public function password_reset($error = NULL) {
        //Call for methods
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        //Input field validation
        $this->form_validation->set_rules(
                'username', 'Gebruikersnaam', 'min_length[3]|'
                . 'max_length[20]'
        );
        $this->form_validation->set_rules(
                'email', 'Email adres', 'valid_email'
        );

        $username = $this->input->post('username');
        $email = $this->input->post('email');

        //Validation form
        if ($this->form_validation->run() == FALSE) {
            $headerData = ['title' => 'Vraag nieuw paswoord aan'];
            $bodyData['error'] = $error;
            $this->load->view('tmpHeader_view', $headerData);
            $this->load->view('passwordReset_view', $bodyData);
            $this->load->view('tmpFooter_view');
        } else { //First validation is ok
            //Check at least one field is filled
            if ($username == '' && $email == '') {
                $headerData = ['title' => 'Vraag nieuw paswoord aan'];
                $bodyData['error'] = 'Vul op zijn minst 1 van de velden in';
                $this->load->view('tmpHeader_view', $headerData);
                $this->load->view('passwordReset_view', $bodyData);
                $this->load->view('tmpFooter_view');
            } else {
                //Validations both OK, go on with transaction
                $this->load->model('password_model');
                $result = $this->password_model->reset($username, $email);
                if (!$result) { //Model did not insert data in database
                    $bodyData = ['error' => 'Gebruikersnaam of email adres is fout'];
                    $this->password_reset($error);
                } else {
                    if ($username == '') {
                        //$username = $this->session->flashdata('username');
                        $username = $result['username'];
                    }
                    if ($email == '') {
                        //$email = $this->session->flashdata('email');
                        $email = $result['email'];
                    }
                    // Send them email
                    $this->load->model('email_model');
                    $result = $this->email_model->mail('do-not-reply@hexioners.be', 'VOS@10eten', 'do-not-reply@hexioners.be', $email, 'Reset paswoord Hexioners.be', 'Hallo ' . $username . ', <br/> je nieuwe wachtwoord is <b>' . $result['password'] . '</b>.'
                    );
                    if (!$result) {
                        $error = 'De mailserver is even ziek, probeer later opnieuw';
                        $this->password_reset($error);
                    } else {
                        $this->index($error = '<span style="color:blue;">Een email werd naar ' . $email . ' verzonden.</span>');
                    }
                }
            }
        }
    }

}
