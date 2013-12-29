<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topic_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getTopics($forum_id) {
        $this->db->select('topic.*, users.username');
        $this->db->from('topic');
        $this->db->join('users', 'topic.user_id = users.id');
        $this->db->where('topic.forum_id', $forum_id);
        $this->db->where('topic.status', 1);
        $this->db->order_by('topic.datum', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

}
