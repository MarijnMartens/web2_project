<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//include the facebook.php from libraries directory
require_once APPPATH . 'libraries/facebook/facebook.php';

class Fb extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->config->load('facebook');
    }

    public function index() {
        $this->load->view('tmpHeader_view');
        $this->load->view('facebookLogin_view');
        $this->load->view('tmpFooter_view');
    }

    public function logout() {
        $signed_request_cookie = 'fbsr_' . $this->config->item('appID');
        setcookie($signed_request_cookie, '', time() - 3600, "/");
        $this->session->sess_destroy();  //session destroy
        redirect('/fb/index', 'refresh');  //redirect to the home page
    }

    public function fblogin() {

        $facebook = new Facebook(array(
            'appId' => $this->config->item('appID'),
            'secret' => $this->config->item('appSecret'),
        ));
// We may or may not have this data based on whether the user is logged in.
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.
        $user = $facebook->getUser(); // Get the facebook user id
        $profile = NULL;
        $logout = NULL;

        if ($user) {
            try {
                $profile = $facebook->api('/me');  //Get the facebook user profile data
                $access_token = $facebook->getAccessToken();
                $params = array('next' => base_url('fb/logout/'), 'access_token' => $access_token);
                $logout = $facebook->getLogoutUrl($params);
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = NULL;
            }

            $data['user_id'] = $user;
            $data['name'] = $profile['name'];
            $data['logout'] = $logout;
            $this->session->set_userdata($data);
           // redirect('/fb/test');
        }
    }

   /* public function test() {
        $this->load->view('test');
    } */

}

/* End of file fb.php */
/* Location: ./application/controllers/fb.php */
