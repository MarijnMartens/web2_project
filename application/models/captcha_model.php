<?php

/*
 * Author: Marijn
 * Created on: 15/01/2014
 * References: none
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum_model extends CI_Model {

    public function insert($data) {
        $this->db->select('*');
        $this->db->from('forum');
        $this->db->where('level <=', $level);
        $this->db->order_by('id');
        $query = $this->db->get();
        return $query->result();
    }
    
}