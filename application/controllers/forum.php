<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $headerData = ['title' => 'Forum'];

        $this->load->model('forum_model');
        $result = $this->forum_model->getFora();

        foreach ($result as $row) {
            $forum_id = $row->id;
            $instantie = (
                    '<tr>' .
                    '<td><a href="' . base_url() . 'forum/topics/' . $forum_id . '">' . $row->naam . '</a></td>' .
                    '<td>' . $row->omschrijving . '</td>' .
                    '<td>Aantal topics:  ' . $this->aantalTopics($forum_id) . '</td>' .
                    '<td>Aantal posts: ' . $this->aantalPostsPerForum($forum_id) . '</td>' .
                    '</tr>'
                    );
            $data[] = $instantie;
        }
        $bodyData['fora'] = $data;
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('forum_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    public function aantalTopics($forum_id) {
        $this->load->model('topic_model');
        $aantal = $this->topic_model->getAantal($forum_id);
        return $aantal;
    }
    public function aantalPostsPerForum($forum_id) {
        $this->load->model('topic_model');
        $this->load->model('post_model');
        $result = $this->topic_model->getId($forum_id);
        
        $aantal = 0;
        foreach($result as $row)
        {
            $aantal += $this->post_model->getAantal($row->id);
        }
        return $aantal;
    }
    public function aantalPosts($topic_id)
    {
        $this->load->model('post_model');
        $result = $this->post_model->getAantal($topic_id);
        return $result;
    }

    public function topics($forum_id) {
        $headerData = ['title' => 'Topics'];

        $this->load->model('topic_model');
        $result = $this->topic_model->getTopics($forum_id);
        
        foreach($result as $row)
        {
            $topic_id = $row->id;
            $instantie = (
                    '<tr>' .
                    '<td><a href="' . base_url() . 'forum/posts/' . $topic_id . '">' . $row->naam . '</a></td>' .
                    '<td>' . $row->datum . '</td>' .
                    '<td>' . $row->username . '</td>' .
                    '<td>Aantal posts: ' . $this->aantalPosts($topic_id) . '</td>' .
                    '</tr>'
                    );
            $data[] = $instantie;
        }
        $aantal = $this->aantalTopics($forum_id);

        $bodyData['topics'] = $data;
        $bodyData['aantal'] = $aantal;

        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('topic_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    public function posts($topic_id) {
        $headerData = ['title' => 'Posts'];

        $this->load->model('post_model');
        $result = $this->post_model->getPosts($topic_id);
        $aantal = $this->post_model->getAantal($topic_id);

        $bodyData['posts'] = $result;
        $bodyData['aantal'] = $aantal;

        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('post_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

}
