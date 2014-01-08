<?php

/*
 * Author: Marijn Martens
 * Created on: 29/12/2013
 * Last modified on: 08/01/2014
 * Edit: 08/01/2014: username and email no longer both required
 * References: none
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Password_model extends CI_Model {

    public function reset($username, $email) {
        //username filled, email blank
        if((!($username == '')) && ($email == '')){
            //get mail
            $email = $this->getEmail($username);
            if (!$email){
                return FALSE;
            }
        //username blank, email filled
        } else if((!($email == '')) && ($username == '')){
            //get username
            $username = $this->getUsername($email);
            if (!$username){
                return FALSE;
            }
        }
        //both are already inserted, just get the data
        //find row where is match
        $this->db->where('username', $username);
        //not to long to keep it simple for the user
        $password = random_string('alnum', 10);
        //encrypting crypt, auto salt with cost
        $option = ['cost' => 12];
        $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT, $option);
        $data = array('password' => $passwordEncrypted);
        
        $this->db->update('user', $data);
        // Let's check if there are any results
        if ($this->db->affected_rows() == 1) {
            //send everything back that CAN be missing (not necessarily missing)
            $data = array('password' => $password,
                'username' => $username,
                'email' => $email);
         return $data;
        } else {
            //user not found
            return FALSE;
        }
    }
    
    private function getUsername($email) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $query = $this->db->get();
        // Let's check if there are any results
        if ($query->num_rows() == 1) {
            $result = $query->row()->username;
            return $result;
        } else {
            return FALSE;
        }
    }
    
    private function getEmail($username) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $username);
        $query = $this->db->get();
        // Let's check if there are any results
        if ($query->num_rows() == 1) {
            $result = $query->row()->email;
            return $result;
        } else {
            return FALSE;
        }
    }
    
}

?>