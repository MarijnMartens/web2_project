<?php

/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Last modified on: 04/01/2014
 * Edit: 04/01/2014: Insert new post
 * References: none
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reply_model extends CI_Model {

    public function getReplies($topic_id) {
        $this->db->select('reply.*, user.username');
        $this->db->from('reply');
        $this->db->join('user', 'reply.user_id = user.id', 'left');
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
    
    public function anonymous(){
            $guest_id = time() - strtotime('5 January 2014') . microtime() * 1000000;
            $this->session->set_userdata('guest_id', $guest_id);
            return $guest_id;
    }
    
    public function insert($topic_id, $msg, $user_id = NULL, $guest_id = NULL)
    {
         $data = array(
                'topic_id' => $topic_id,
                'user_id' => $user_id,
                'message' => $msg,
                'guest_id' => $guest_id
            );
            $this->db->insert('reply', $data);
            $query = $this->db->affected_rows();
            if ($query == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
    }

}
