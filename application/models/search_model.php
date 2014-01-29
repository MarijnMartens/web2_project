<?php

/*
 * Author: Marijn Martens
 * Created on: 18/01/2014
 * References: none
 */

class Search_model extends CI_Model {

    //function to get LIMITED userdata
    //to use when other members request info about other user
    public function getUsernames() {
        $this->db->select('id, username');
        $this->db->order_by('username', 'asc');
        $query = $this->db->get('user');
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    //return public userdata
    public function getUserdata($user_id) {
        $this->db->select('id, username, level, fName, lName, gender, dateOfBirth, city, avatar');
        $this->db->where('id', $user_id);
        $query = $this->db->get('user');
        // Let's check if there are any results
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    //search whatever you want
    public function getAll($keyword) {
        //search in tables
        $result[0] = $this->searchUser($keyword);
        //$result[1] = $this->searchForum($keyword);
        $result[1] = $this->searchTopic($keyword);
        $result[2] = $this->searchReply($keyword);

        return $result;
    }

    //search in table USER
    private function searchUser($keyword) {
        $this->db->select('id as user_id, username, avatar');
        $array = array(
            'username' => $keyword,
            'fName' => $keyword,
            'lName' => $keyword,
            'dateOfBirth' => $keyword,
            'city' => $keyword
        );
        $this->db->or_like($array);
        $query = $this->db->get('user');
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query; //->result();
        } else {
            return false;
        }
    }

    //search in table FORUM
    private function searchForum($keyword) {
        $this->db->select('id as forum_id, title as forum_title, description, level');
        $array = array(
            'title' => $keyword,
            'description' => $keyword
        );
        $this->db->or_like($array);
        $query = $this->db->get('forum');
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query; //->result();
        } else {
            return false;
        }
    }

    //search in table TOPIC
    private function searchTopic($keyword) {
        $this->db->select('id as topic_id, forum_id, user_id, title as topic_title, date');
        $array = array(
            'title' => $keyword,
            'date' => $keyword
        );
        $this->db->or_like($array);
        $query = $this->db->get('topic');
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query; //->result();
        } else {
            return false;
        }
    }

    //search in table REPLY
    private function searchReply($keyword) {
        $this->db->select('reply.id as reply_id, reply.date, reply.topic_id, topic.title as topic_title, reply.user_id, reply.guest_id, user.username, reply.message');
        $array = array(
            'reply.date' => $keyword,
            'guest_id' => 'Gast' . $keyword,
            'message' => $keyword
        );
        $this->db->from('reply');
        $this->db->join('user', 'reply.user_id = user.id', 'left');
        $this->db->join('topic', 'reply.topic_id = topic.id');
        $this->db->or_like($array);
        $query = $this->db->get();
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query; //->result();
        } else {
            return false;
        }
    }

}
