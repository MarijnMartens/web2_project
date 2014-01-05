<?php

/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Last modified on: 04/01/2014
 * Edit: 04/01/2014: User-level restriction
 * References: none
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum_model extends CI_Model {

    public function getForums($level = 0) {
        $this->db->select('*');
        $this->db->from('forum');
        $this->db->where('level <=', $level);
        $this->db->order_by('id');
        $query = $this->db->get();
        return $query->result();
    }

}
