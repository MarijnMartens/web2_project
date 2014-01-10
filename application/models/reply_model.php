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

    //get username corresponing to user_id from replies
    public function getUsername($user_id) {
        $this->db->select('username');
        $this->db->from('user');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        return $query->row()->username;
    }

    //get last reply per topic
    public function getLast($topic_id) {
        $this->db->where('topic_id', $topic_id);
        $this->db->where("date = (select max(date) FROM reply WHERE topic_id = $topic_id)");
        $query = $this->db->get('reply');
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    //count replies per topic
    public function getCount($topic_id) {
        $this->db->select('count(*) as count');
        $this->db->from('reply');
        $this->db->where('topic_id', $topic_id);
        $query = $this->db->get();
        return $query->row()->count;
    }

    public function anonymous() {
        $guest_id = time() - strtotime('5 January 2014') . microtime() * 1000000;
        $this->input->set_cookie('guest_id', $guest_id, 60*60*24*365);
        return $guest_id;
    }

    public function insert($topic_id, $msg, $user_id = 0, $guest_id = 0) {
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
    //get data from one reply
    public function get($reply_id) {
        $this->db->where('id', $reply_id);
        $query = $this->db->get('reply');
        return $query->row();
    }
    //update data from one reply
    public function edit($reply_id, $msg, $mod_break) {
        $data = array(
            'message' => $msg,
            'mod_break' => $mod_break
        );
        $this->db->where('id', $reply_id);
        $this->db->update('reply', $data);
        $query = $this->db->affected_rows();
        if ($query == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
