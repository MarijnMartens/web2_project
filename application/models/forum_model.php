<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getFora() {
        $this->db->select('*');
        $this->db->from('forum');
        $this->db->order_by('id');
        $query = $this->db->get();
        return $query->result();
    }

}
