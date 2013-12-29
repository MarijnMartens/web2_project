<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Post_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getPosts($topic_id) {
        $this->db->select('post.*, users.username');
        $this->db->from('post');
        $this->db->join('users', 'post.user_id = users.id');
        $this->db->where('post.topic_id', $topic_id);
        $this->db->order_by('post.date');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getAantal($topic_id){
        $this->db->select('count(*) as count');
        $this->db->from('post');
        $this->db->where('post.topic_id', $topic_id);
        $query = $this->db->get();
        return $query->row()->count;
    }

}
