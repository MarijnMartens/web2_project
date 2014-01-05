<?php

/*
 * Author: Marijn
 * Created on: 20/12/2013
 * Last modified on: 04/01/2014
 * Edit: 04/01/2014: Insert new topic
 * References: none
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topic_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //return list of topics
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

    //return count of topics
    public function getCount($forum_id) {
        $this->db->select('count(*) as count');
        $this->db->from('topic');
        $this->db->where('forum_id', $forum_id);
        $query = $this->db->get();
        return $query->row()->count;
    }

    //return list of topic id's from on forum, 
    //used for reply counter in forum
    public function getAll($forum_id) {
        $this->db->select('*');
        $this->db->from('topic');
        $this->db->where('forum_id', $forum_id);
        $query = $this->db->get();
        return $query->result();
    }

    //insert new topic
    public function insert($forum_id, $user_id, $title) {
            $data = array(
                'forum_id' => $forum_id,
                'user_id' => $user_id,
                'title' => $title
            );
            $this->db->insert('topic', $data);
            $query = $this->db->affected_rows();
            if ($query == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
    } 

}
