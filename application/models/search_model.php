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
        $result[1] = $this->searchForum($keyword);
        $result[2] = $this->searchTopic($keyword);
        $result[3] = $this->searchReply($keyword);

        return $result;
    }

    //search in table USER
    private function searchUser($keyword) {
        $this->db->select('username, id, level, fName, lName, gender, dateOfBirth, city, avatar');
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
            return $query->result();
        } else {
            return false;
        }
    }

    //search in table FORUM
    private function searchForum($keyword) {
        $this->db->select('title, id, description, level');
        $array = array(
            'title' => $keyword,
            'description' => $keyword
        );
        $this->db->or_like($array);
        $query = $this->db->get('forum');
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    //search in table TOPIC
    private function searchTopic($keyword) {
        $this->db->select('id, forum_id, user_id, title, date');
        $array = array(
            'title' => $keyword,
            'date' => $keyword
        );
        $this->db->or_like($array);
        $query = $this->db->get('topic');
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    //search in table REPLY
    private function searchReply($keyword) {
        $this->db->select('user_id, id, date, topic_id, message', 'guest_id');
        $array = array(
            'date' => $keyword,
            'guest_id' => 'Gast' . $keyword,
            'message' => $keyword
        );
        $this->db->or_like($array);
        $query = $this->db->get('reply');
        // Let's check if there are any results
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

}
