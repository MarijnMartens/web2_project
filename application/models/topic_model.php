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
        $this->db->select('topic.*, user.username');
        $this->db->from('topic');
        $this->db->join('user', 'topic.user_id = user.id');
        $this->db->where('topic.forum_id', $forum_id);
        $this->db->where('topic.status', 1);
        $this->db->order_by('topic.date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getCount($forum_id) {
        $this->db->select('count(*) as count');
        $this->db->from('topic');
        $this->db->where('forum_id', $forum_id);
        $query = $this->db->get();
        return $query->row()->count;
    }

    public function getId($forum_id) {
        $this->db->select('id');
        $this->db->from('topic');
        $this->db->where('forum_id', $forum_id);
        $query = $this->db->get();
        return $query->result();
    }

}
