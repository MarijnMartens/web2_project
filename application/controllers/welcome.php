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

    public function message() {
        $bodyData['title'] = 'Boodschap van algemeen nut';
        //If we forget to set up a flash_session
        try {
            $msg = $this->session->flashdata('message');
        } catch (Exception $ex) {
            $msg = 'Intern iets misgelopen';
        }
        $bodyData['message'] = $msg;
        $bodyData['view'] = 'message_view';
        $this->load->view('template/tmpPage_view', $bodyData);
    }

    public function index() {
        $this->load->model('homepage_model');
        $result = $this->homepage_model->getAll();
        $bodyData['title'] = 'Index';
        $bodyData['result'] = $result;
        $bodyData['view'] = 'index_view';
        $this->load->view('template/tmpPage_view', $bodyData);
    }

    public function info() {
        $bodyData['title'] = 'Info';
        $bodyData['view'] = 'info_view';
        $this->load->view('template/tmpPage_view', $bodyData);
    }

    public function event() {
        $bodyData['title'] = 'Events';
        $bodyData['view'] = 'event_view';
        $this->load->view('template/tmpPage_view', $bodyData);
    }

    //Load contact form or redisplay when false input / captcha failed
    public function contact($error = NULL) {
        //call captcha-library
        $this->load->library('MyCaptcha');
        //Call form validation-library
        $this->load->library('form_validation');
        //Display page
        $bodyData['title'] = 'Contact';
        $captcha = $this->mycaptcha->showCaptcha();
        $bodyData['error'] = $error;
        $bodyData['captcha'] = $captcha;
        $bodyData['view'] = 'contact_view';
        $this->load->view('template/tmpPage_view', $bodyData);
    }

    //process contact
    public function contactProcess() {
        //call captcha-library
        $this->load->library('MyCaptcha');
        //Call form validation-library
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
            $this->contact();
        } else { //Validation is OK, check captcha
            $captcha = $this->mycaptcha->validateCaptcha();
            if (!$captcha) {
                $error = 'We konden niet vaststellen dat je een mens bent, probeer nogmaals';
                $this->contact($error);
            } else { //captcha is ok, send mail
                $this->load->model('email_model');
                $result = $this->email_model->mail(
                        'contact@hexioners.be', 'VOS@50eten', 'Contact Hexioners.be ' . $this->input->post('subject'), 'Geschreven door: ' . ucfirst($this->input->post('name')) . '</br>'
                        . 'Email: <a href="mailto:' . $this->input->post('email') . '">Send back</a><br/>'
                        . nl2br($this->input->post('message'))
                );
                if (!$result) { //Model did not insert data in database
                    $error = 'Bericht kon niet verzonden worden, probeer het zodadelijk nogmaals';
                    $this->contact($error);
                } else {
                    $this->session->set_flashdata('message', 'Bericht verzonden, je krijgt ASAP een antwoord');
                    redirect('welcome/message');
                }
            }
        }
    }

}
