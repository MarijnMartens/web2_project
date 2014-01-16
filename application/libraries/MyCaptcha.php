<?php

/*
 * Author: Marijn
 * Created on: 16/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MyCaptcha {

    public function __construct() {
        // Instantiate the AYAH object. You need to instantiate the AYAH object
        // on each page that is using PlayThru.
        require_once("application/third_party/ayah/ayah.php");
    }

    //
    public function showCaptcha() {
        $ayah = new AYAH();
        //instantiate
        $CI = & get_instance();
        if (!$CI->session->userdata('validated')) {
            return '<tr>' .
                    '<td>Voer de captcha uit</td>' .
                    '<td>' . $ayah->getPublisherHTML() . '</td>' .
                    '</tr>';
        } else {
            return '';
        }
    }

    public function validateCaptcha() {
        $ayah = new AYAH();
        $score = $ayah->scoreResult();
        //instantiate
        $CI = & get_instance();
        if ($CI->session->userdata('validated')) {
            return true;
        } else {
            if ($score) {
                return true;
            } else {
                return false;
            }
        }
    }

}

?>
