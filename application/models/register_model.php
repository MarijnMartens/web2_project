<?php

/*
 * Author: Marijn Martens
 * Created on: 29/12/2013
 * References: none
 */

class Register_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function setUsers($username, $password, $email) {
        //encrypting crypt, auto salt met cost
        $option = ['cost' => 12];
        $password = password_hash($password, PASSWORD_DEFAULT, $option);

        $data = array(
            'username' => $username,
            'password' => $password,
            'email' => $email
        );

        //insert user
        $this->db->insert('user', $data);
        $query = $this->db->affected_rows();

        if ($query == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function editProfile($user_id, $fName = null, $lName = null, $dateOfBirth = null, $gender = null, $city = null) {
        $data = array(
            'fName' => $fName,
            'lName' => $lName,
            'dateOfBirth' => $dateOfBirth,
            'gender' => $gender,
            'city' => $city
        );
        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        $query = $this->db->affected_rows();

        if ($query == 1) {
            $data = array(
                'fName' => $fName,
                'lName' => $lName,
                'dateOfBirth' => $dateOfBirth,
                'gender' => $gender,
                'city' => $city
            );
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
