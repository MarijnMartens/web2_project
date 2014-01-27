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
    //get all replies from one topic
    public function getReplies($topic_id) {
        $this->db->select('reply.*, user.id as user_id, user.username, user.avatar');
        $this->db->from('reply');
        $this->db->join('user', 'reply.user_id = user.id', 'left');
        $this->db->where('reply.topic_id', $topic_id);
        $this->db->order_by('reply.date');
        $query = $this->db->get();
        return $query->result();
    }
    //get last reply per topic
    public function getLast($topic_id) {
        $this->db->where('topic_id', $topic_id);
        $this->db->where("date = (select max(date) FROM reply WHERE topic_id = $topic_id)");
        $query = $this->db->get('reply');
        if ($query->num_rows() == 1) {
            return $query->row();
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
    //reply anonymously, create ID
    public function anonymous() {
        $guest_id = time() - strtotime('5 January 2014') . microtime() * 1000000;
        $this->input->set_cookie('guest_id', $guest_id, 60*60*24*365);
        return $guest_id;
    }
    //insert reply
    public function insert($topic_id, $msg, $user_id = 0, $guest_id = 0) {
        //check not both user_id and guest_id are empty
        if($user_id == 0 && $guest_id == 0){
            //make a guest_id
            $this->anonymous();
        }
        //prepare data
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
    public function edit($reply_id, $msg, $mod_break, $msg_old) {
        $data = array(
            'message' => $msg,
            'mod_break' => $mod_break,
            'message_old' => $msg_old
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
