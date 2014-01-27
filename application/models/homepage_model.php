<?php

/*
 * Author: Marijn Martens
 * Created on: 18/01/2014
 * References: none
 */

class Homepage_model extends CI_Model {

    //function to get LIMITED userdata
    //to use when other members request info about other user
    public function getAll() {
        $this->db->select('homepage.*, user.id, user.username');
        $this->db->from('homepage');
        $this->db->join('user', 'homepage.user_id = user.id');
        $this->db->order_by('homepage.date', 'desc');
        $query = $this->db->get();
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

}
