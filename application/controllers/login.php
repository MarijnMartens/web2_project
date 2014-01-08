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
        $this->load->helper(array('form', 'url'));
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
    public function password_forgot($error = NULL) {
        $headerData = ['title' => 'Vraag nieuw paswoord aan'];
        $bodyData['error'] = $error;
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('passwordReset_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    public function password_reset() {
        // grab user input
        $username = $this->input->post('username');
        $email = $this->input->post('email');        
        // Load the model
        $this->load->model('password_model');
        // Validate the user has correct username and email
        $result = $this->password_model->reset($username, $email);
        // Now we verify the result
        if (!$result) {
            // If user did not validate, then show them login page again
            $error = 'Gebruikersnaam of email adres is fout';
            $this->password_forgot($error);
        } else {
            // If user did validate, 
            // Send them email
            $this->load->library('email');
            $this->email->from('do-not-reply@hexioners.be', 'Hexioners.be');
            $this->email->to($email);
            $this->email->subject('Reset paswoord Hexioners.be');
            $this->email->message('Hallo ' . $username . ', <br/> je nieuwe wachtwoord is <b>' . $result . '</b>.');
            $this->email->send();
            $this->index($error = '<span style="color:blue;">Een email werd naar ' . $email . ' verzonden.</span>');
        }
    }

}
