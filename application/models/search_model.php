<?php

/*
 * Author: Marijn Martens
 * Created on: 18/01/2014
 * References: none
 */

class Search_model extends CI_Model {

    //function to get LIMITED userdata
    //to use when other members request info about other user
    public function getUsernames() {
        $this->db->select('id, username');
        $this->db->order_by('username', 'asc');
        $query = $this->db->get('user');
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    //return public userdata
    public function getUserdata($user_id) {
        $this->db->select('id, username, level, fName, lName, gender, dateOfBirth, city, avatar');
        $this->db->where('id', $user_id);
        $query = $this->db->get('user');
        // Let's check if there are any results
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

}
