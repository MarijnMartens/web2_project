<?php
//edit23
/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Last modified on: 08/01/2014
 * Edit: 08/01/2014: message page for all sorts of errors / restrictions / success messages
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    public function message(){
        $headerData = ['title' => 'Boodschap van algemeen nut'];
        //If we forget to set up a flash_session
        try {
            $msg = $this->session->flashdata('message');
        } catch (Exception $ex) {
            $msg = 'Intern iets misgelopen';
        }
        $bodyData = ['message' => $msg];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('message_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    public function index() {
        $headerData = ['title' => 'Index'];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('index_view');
        $this->load->view('tmpFooter_view');
    }

    public function info() {
        $headerData = ['title' => 'Info'];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('info_view');
        $this->load->view('tmpFooter_view');
    }

    public function forum() {
        $headerData = ['title' => 'Forum'];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('forum_view');
        $this->load->view('tmpFooter_view');
    }

    public function event() {
        $headerData = ['title' => 'Events'];
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('event_view');
        $this->load->view('tmpFooter_view');
    }
    //decrapicated i believe
    public function login() {
        redirect(login);
    }
    
    public function contact($error = NULL){
        //Call for methods
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        //Input field validation
        $this->form_validation->set_rules(
                'name', 'Naam', 'required|'
                . 'min_length[3]|'
                . 'max_length[30]'
        );
        $this->form_validation->set_rules(
                'email', 'Email adres', 'required|'
                . 'valid_email'
        );
        $this->form_validation->set_rules(
                'subject', 'Onderwerp', 'required|'
                . 'min_length[3]|'
                . 'max_length[100]'
        );
        $this->form_validation->set_rules(
                'message', 'Bericht', 'required|'
                . 'min_length[3]|'
                . 'max_length[2000]'
        );

        //Validation form
        if ($this->form_validation->run() == FALSE) {
            $headerData = ['title' => 'Contact'];
            $bodyData['error'] = $error;
            $this->load->view('tmpHeader_view', $headerData);
            $this->load->view('contact_view', $bodyData);
            $this->load->view('tmpFooter_view');
        } else { //Validation is OK, open model to insert new user
            $this->load->model('email_model');
            $result = $this->email_model->mail(
                    'contact@hexioners.be', 'VOS@50eten', 'contact@hexioners.be', 
                    'contact@hexioners.be', 'Contact Hexioners.be ' . $this->input->post('subject'),
                    'Geschreven door: ' . ucfirst($this->input->post('name')) . '</br>'
                    . 'Email: ' . $this->input->post('email') . '<br/>'
                    . $this->input->post('message')
                            );
            if (!$result) { //Model did not insert data in database
                $error = 'Bericht kon niet verzonden worden, probeer het zodadelijk nogmaals';
                $this->contact($error);
            } else {
                //Mocht deze email mislukken is dat niet erg, is maar een bevestinging dat er een mail verzonden was
                /*$result = $this->email_model->mail(
                    'do-not-reply@hexioners.be', 'VOS@50eten', 'do-not-reply@hexioners.be', $this->input->post('email'), 
                    'Je contact: ' . $this->input->post('subject') . ' ',
                    'Hallo ' . ucfirst($this->input->post('name')) . ',</br>' . 'Hieronderzie je nog eens je bericht die je verzonden hebt, tot binnenkort!</br>' . $this->input->post('message')
                            );*/
                $this->session->set_flashdata('message', 'Bericht verzonden, je krijgt ASAP een antwoord');
                redirect('welcome/message');
            }
        }
    }

}
