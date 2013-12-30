<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Basis login gebaseerd op:
 * http://www.jotorres.com/2012/03/create-user-login-with-codeigniter/
 */

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
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        // Load the model
        $this->load->model('login_model');
        // Validate the user can login
        $result = $this->login_model->validate($username, $password);
        // Now we verify the result
        if (!$result) {
            // If user did not validate, then show them login page again
            $error = 'Invalid username and/or password.';
            $this->index($error);
        } else {
            // If user did validate, 
            // Send them to members area
            redirect('user');
        }
    }

    //registereren
    public function register($error = NULL) {
        //Methodes oproepen
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        //Fields die gecontroleerd gaan worden
        $this->form_validation->set_rules(
                'username', 'Username', 'required|'
                . 'min_length[3]|'
                . 'max_length[20]|'
                . 'callback_register_username_check|'
                . 'is_unique[user.username]'
        );
        $this->form_validation->set_rules(
                'password', 'Password', 'required|'
                . 'min_length[3]|'
                . 'matches[passconf]'
        );
        $this->form_validation->set_rules(
                'passconf', 'Password Confirmation', 'required|'
        );
        $this->form_validation->set_rules(
                'email', 'Email', 'required|'
                . 'valid_email|'
                . 'is_unique[user.email]'
        );

        //Aangepaste melding
        $this->form_validation->set_message('is_unique', '%s is already used');
        $this->form_validation->set_message('matches', 'Passwords do not match');

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
                $bodyData = ['error' => 'Insert in database failed,'
                    . ' sure database is up and running?'];
                $this->register($error);
            } else {
                $this->login_process();
            }
        }
    }

    //Admin niet toelaten als username
    public function register_username_check($str) {
        if (!strcasecmp($str, 'admin')) { //strcasecmp is case insensitive
            $this->form_validation->set_message('username_check', '%s may not be \'' . $str . '\''); //%s is human name field form
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //wachtwoord vergeten
    public function password_forgot($error = NULL){
        $headerData = ['title' => 'Request new password'];
        $bodyData['error'] = $error;
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('passwordReset_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }
    
    public function password_reset(){
        // grab user input
        $username = $this->security->xss_clean($this->input->post('username'));
        $email = $this->security->xss_clean($this->input->post('email'));
        // Load the model
        $this->load->model('password_model');
        // Validate the user has correct username and email
        $result = $this->password_model->reset($username, $email);
        // Now we verify the result
        if (!$result) {
            // If user did not validate, then show them login page again
            $error = 'Invalid username and/or email.';
            $this->password_forgot($error);
        } else {
            // If user did validate, 
            // Send them email
            $this->load->library('email');
            $this->email->from('do-not-reply@marijnmartens.be', 'Hexion.be');
            $this->email->to($email);
            $this->email->subject('Hexion Forgot Password');
            $this->email->message('Hello ' . $username . ', <br/> Your new password is <b>' . $result . '</b>.');
            $this->email->send();
            echo $result;
            $this->index($error = '<span style="color:blue;">Een E-mail werd naar ' . $email . ' verzonden.</span>');
        }
    }
}