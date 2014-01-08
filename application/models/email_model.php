<?php
/*
 * Author: Marijn Martens
 * Created on: 29/12/2013
 * Last modified on: 08/01/2014
 * Edit: 08/01/2014: username and email no longer both required
 * References: PHPMailer framework for sending mails in azureWeb
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_Model {

    public function mail($username, $password, $from, $to, $subject, $message) {
        require 'third_party/PHPMailer-master/class.phpmailer.php';

                try {
                    $mail = new PHPMailer;

                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.live.com';  // Specify main and backup server
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = $username;                            // SMTP username
                    $mail->Password = $password;                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

                    $mail->From = $from;
                    $mail->addAddress($to);  // Add a recipient
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    if (!$mail->send()) {
                        return FALSE;
                    }
                    return TRUE;
                } catch (Exception $e) {
                    return FALSE;
                    
                }
            }
        }
        ?>
}

}