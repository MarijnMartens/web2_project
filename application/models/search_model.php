<?php

/*
 * Author: Marijn Martens
 * Created on: 18/01/2014
 * References: none
 */

class Search_model extends CI_Model {

    //Search in all tables (user, topic, reply, (media eventually)
    public function getUsernames() {
        $this->db->select('username');
        $this->db->order_by('username', 'asc');
        $query = $this->db->get('user');
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

}
