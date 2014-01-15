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
    //get all forums user has access to
    public function getForums($level = 0) {
        $this->db->where('level <=', $level);
        $this->db->order_by('id');
        $query = $this->db->get('forum');
        return $query->result();
    }
    //Restrict access
    public function getLevel($forum_id){
        $this->db->select('level');
        $this->db->from('forum');
        $this->db->where('id', $forum_id);
        $query = $this->db->get();
        return $query->row()->level;
    }

}
