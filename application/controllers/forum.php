<?php

/*
 * Author: Marijn Martens
 * Created on: 29/12/2013
 * Last modified on: 
 * 
 * References: none
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum extends CI_Controller {

    //Constructor to load models, this way you do not have to do it for each function
    function __construct() {
        parent::__construct();
        $this->load->model('forum_model');
        $this->load->model('topic_model');
        $this->load->model('reply_model');
    }

    //Main Forum - Lists different sections: Guests (i.e. FAQ, Guestbook) / Users / Hexioners / Admins
    public function index() {
        $headerData = ['title' => 'Forum'];
        //Get all sections from database
        $result = $this->forum_model->getForums();

        //Print each section, done this way for counters; #topics, #replies (in all underlying topics combined)
        foreach ($result as $row) {
            $forum_id = $row->id;
            //Rows to print to userscreen
            $result = (
                    '<tr>' .
                    '<td><a href="' . base_url() . 'forum/topics/' . $forum_id . '">' . $row->title . '</a></td>' .
                    '<td>' . $row->description . '</td>' .
                    '<td>' . $this->countTopics($forum_id) . ' Topics</td>' .
                    '<td>' . $this->countRepliesForum($forum_id) . ' Replies</td>' .
                    '</tr>'
                    );
            $data[] = $result;
        }
        $bodyData['forums'] = $data;
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('forum_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    public function countTopics($forum_id) {
        $count = $this->topic_model->getCount($forum_id);
        return $count;
    }

    public function countRepliesForum($forum_id) {
        $result = $this->topic_model->getId($forum_id);

        $count = 0;
        foreach ($result as $row) {
            $count += $this->reply_model->getCount($row->id);
        }
        return $count;
    }

    public function countReplies($topic_id) {
        $result = $this->reply_model->getCount($topic_id);
        return $result;
    }

    public function topics($forum_id) {
        $headerData = ['title' => 'Topics'];
        $result = $this->topic_model->getTopics($forum_id);

        foreach ($result as $row) {
            $topic_id = $row->id;
            $result = (
                    '<tr>' .
                    '<td><a href="' . base_url() . 'forum/replies/' . $topic_id . '">' . $row->title . '</a></td>' .
                    '<td>' . $row->date . '</td>' .
                    '<td>' . $row->username . '</td>' .
                    '<td>' . $this->countReplies($topic_id) . ' Replies</td>' .
                    '</tr>'
                    );
            $data[] = $result;
        }
        $count = $this->countTopics($forum_id);

        $bodyData['topics'] = $data;
        $bodyData['count'] = $count;
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('topic_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    public function replies($topic_id) {
        $headerData = ['title' => 'Replies'];
        $result = $this->reply_model->getReplies($topic_id);
        $count = $this->reply_model->getCount($topic_id);

        $bodyData['replies'] = $result;
        $bodyData['count'] = $count;

        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('reply_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

}
