<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reply_model extends CI_Model {

    public function getReplies($topic_id) {
        $this->db->select('reply.*, user.username');
        $this->db->from('reply');
        $this->db->join('user', 'reply.user_id = user.id');
        $this->db->where('reply.topic_id', $topic_id);
        $this->db->order_by('reply.date');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getCount($topic_id){
        $this->db->select('count(*) as count');
        $this->db->from('reply');
        $this->db->where('topic_id', $topic_id);
        $query = $this->db->get();
        return $query->row()->count;
    }

}
