<?php

/*
 * Author: Marijn Martens
 * Created on: 29/12/2013
 * Edit: 09/01/2013 : display timestamp, topicTitle, username/guestid, insert reply
 * Edit: 10/01/2013: update reply with check
 * References: All by my pure awesomeness
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum extends CI_Controller {

    //Constructor to load models, this way you do not have to do it for each function
    public function __construct() {
        parent::__construct();
        $this->load->model('forum_model');
        $this->load->model('topic_model');
        $this->load->model('reply_model');
    }

    //Main Forum - Lists different sections: Guests (i.e. FAQ, Guestbook) / Users / Hexioners / Admins
    public function index() {
        $headerData = ['title' => 'Forum'];
        //Get all sections from database where level is equal or higher
        $level = $this->session->userdata('level');
        $result = $this->forum_model->getForums($level);

        //Print each section, done this way for counters; #topics, #replies (in all underlying topics combined)
        foreach ($result as $row) {
            $forum_id = $row->id;
            $lastReply_result = $this->lastReply($forum_id);
            //if no topics in forum
            if (!$lastReply_result) {
                $topicTitle = $replyUsername = $lastReplyDate = 'onbekend';
            } else {
                //print title topic where last reply of entire forum is found
                $topicTitle = $this->topic_model->getTitle($lastReply_result['topic_id']);
                if ($lastReply_result['user_id'] != 0) {
                    $replyUsername = $this->reply_model->getUsername($lastReply_result['user_id']);
                } else {
                    $replyUsername = 'Gast' . $lastReply_result['guest_id'];
                }
                $lastReplyDate = $lastReply_result['date'];
            }
            //Rows to print to userscreen
            $result = (
                    '<tr>' .
                    '<td><a href="' . base_url() . 'forum/topics/' . $forum_id . '">' . $row->title . '</a></td>' .
                    '<td>' . $row->description . '</td>' .
                    '<td>' . $this->countTopics($forum_id) . ' Topics</td>' .
                    '<td>' . $this->countRepliesForum($forum_id) . ' Replies</td>' .
                    '<td> Laatste reactie in Topic: ' . $topicTitle . '</td>' .
                    '<td> Laatste reactie door Gebruiker: ' . $replyUsername . '</td>' .
                    '<td> Om Tijd: ' . $lastReplyDate . '</td>' .
                    '</tr>'
                    );
            // }
            //Put each row in array
            $data[] = $result;
        }
        //Send array to view
        $bodyData['forums'] = $data;
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('forum/forum_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    //get last reply in forum
    private function lastReply($forum_id) {
        $dateMax = '';
        $data = array();
        $result = $this->topic_model->getAll($forum_id);
        if ($result) {
            foreach ($result as $row) {
                $reply_result = $this->reply_model->getLast($row->id);
                foreach ($reply_result as $reply) {
                    if ($reply->date > $dateMax) {
                        $dateMax = $reply->date;
                        $data = array('topic_id' => $reply->topic_id,
                            'user_id' => $reply->user_id,
                            'guest_id' => $reply->guest_id,
                            'date' => $reply->date
                        );
                    }
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    //count all replies in one topic
    private function countReplies($topic_id) {
        $result = $this->reply_model->getCount($topic_id) - 1;
        return $result;
    }

    //Function for index to count all replies from all sub-topics
    private function countRepliesForum($forum_id) {
        $result = $this->topic_model->getAll($forum_id);
        $count = 0;
        if (!$result) {
            return $count;
        }
        foreach ($result as $row) {
            $count += $this->reply_model->getCount($row->id) - 1;
        }
        return $count;
    }

    //count all topics
    private function countTopics($forum_id) {
        $count = $this->topic_model->getCount($forum_id);
        return $count;
    }

    //security measure to disable modifying URL
    private function checkLevel($forum_id) {
        $user_level = $this->session->userdata('level');
        $forum_level = $this->forum_model->getLevel($forum_id);
        if ($user_level < $forum_level) {
            $this->session->set_flashdata('message', 'Gasten mogen niet in dit forum!');
            redirect('welcome/message');
        }
    }

    //display list of topics, more or less like function 'index'
    public function topics($forum_id) {
        //Set flashdata to remember forum_id when creating a new topic
        $this->session->set_flashdata('forum_id', $forum_id);
        $headerData = ['title' => 'Topics'];
        //make list of topics
        $result = $this->topic_model->getTopics($forum_id);
        $data[] = NULL;
        //print each topic
        if ($result != NULL) {
            foreach ($result as $row) {
                $topic_id = $row->id;
                $result = (
                        '<tr>' .
                        '<td><a href="' . base_url() . 'forum/replies/' . $topic_id . '">' . $row->title . '</a></td>' .
                        '<td>' . $row->date . '</td>' .
                        '<td>' . $row->username . '</td>' .
                        '<td>' . $this->countReplies($topic_id) . ' Antwoorden</td>' .
                        '</tr>'
                        );
                $data[] = $result;
            }
        }

        //count # topics
        $count = $this->countTopics($forum_id);
        //security measure to disable modifying URL
        $this->checkLevel($forum_id);
        //display page
        $bodyData['topics'] = $data;
        $bodyData['count'] = $count;
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('forum/topic_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    //insert new topic
    public function insertTopic($error = NULL) {
        $forum_id = $this->session->flashdata('forum_id');
        $user_id = $this->session->userdata('user_id');

        //guests are not allowed to insert a topic
        if ($this->session->userdata('level') < 1) {
            $this->session->set_flashdata('message', 'Je moet eerst inloggen vooraleer je een topic mag aanmaken');
            redirect('welcome/message');
        } else {

            //Modifying URL should not let you reach insertTopic but just to be safe
            $this->checkLevel($forum_id);

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
            //Valide field Title
            $this->form_validation->set_rules(
                    'title', 'Title', 'required|'
                    . 'min_length[5]|'
                    . 'max_length[100]|'
            );
            $this->form_validation->set_rules(
                    'reply', 'OP', 'required|'
                    . 'min_length[2]|'
                    . 'max_length[1000]|'
            );

            //Validation form
            if ($this->form_validation->run() == FALSE) {
                $headerData = ['title' => 'Nieuw Topic'];
                $bodyData['error'] = $error;
                $this->load->view('tmpHeader_view', $headerData);
                $this->load->view('forum/insertTopic_view', $bodyData);
                $this->load->view('tmpFooter_view');
                $forum_id = $this->session->keep_flashdata('forum_id');
            } else { //Validation is OK, open model to insert new topic
                $result_topic = $this->topic_model->insert(
                        $forum_id, $user_id, $this->input->post('title')
                );
                if (!$result_topic) { //Model did not insert data in database
                    $bodyData = ['error' => 'Insert in topic-table failed,'
                        . ' sure database is up and running?'];
                    $this->insertTopic($error);
                } else {
                    $this->load->model('reply_model');
                    $result_reply = $this->reply_model->insert(
                            $result_topic, $this->input->post('reply'), $user_id
                    );
                    if (!$result_reply) { //Model did not insert data in database
                        $bodyData = ['error' => 'Insert in database failed,'
                            . ' sure database is up and running?'];
                        $this->insertReply($error);
                    } else {
                        $this->replies($result_topic);
                    }
                }
            }
        }
    }

    //display list of replies in one topic
    public function replies($topic_id) {
        $this->session->set_flashdata('topic_id', $topic_id);
        $headerData = ['title' => 'Replies'];
        $result = $this->reply_model->getReplies($topic_id);
        $count = $this->reply_model->getCount($topic_id) - 1;

        $bodyData['replies'] = $result;
        $bodyData['count'] = $count;

        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('forum/reply_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    public function insertReply($error = NULL) {
        $topic_id = $this->session->flashdata('topic_id');
        $user_id = $this->session->userdata('user_id');
        $guest_id = NULL;
        if ($user_id == NULL) {
            if (!($this->input->cookie('guest_id'))) {
                $guest_id = $this->reply_model->anonymous();
            } else
                $guest_id = $this->input->cookie('guest_id');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        //Fields die gecontroleerd gaan worden
        $this->form_validation->set_rules(
                'reply', 'Post', 'required|'
                . 'min_length[2]|'
                . 'max_length[1000]|'
        );

        //Validation form
        if ($this->form_validation->run() == FALSE) {
            $headerData = ['title' => 'Nieuw Reply'];
            $bodyData['error'] = $error;
            $this->load->view('tmpHeader_view', $headerData);
            $this->load->view('forum/insertReply_view', $bodyData);
            $this->load->view('tmpFooter_view');
            $topic_id = $this->session->keep_flashdata('topic_id');
        } else { //Validation is OK, open model to insert new topic
            $this->load->model('reply_model');
            $result = $this->reply_model->insert(
                    $topic_id, $this->input->post('reply'), $user_id, $guest_id
            );
            if (!$result) { //Model did not insert data in database
                $bodyData = ['error' => 'Insert in database failed,'
                    . ' sure database is up and running?'];
                $this->insertReply($error);
            } else {
                $this->replies($topic_id);
            }
        }
    }

    public function editReply($reply_id, $error = NULL) {
        $headerData = ['title' => 'Edit Reply'];
        $bodyData['error'] = $error;
        $result = $this->reply_model->get($reply_id);
        //closed by admin, stop further processing
        if ($result->mod_break == TRUE) {
            $this->session->set_flashdata('message', 'Geen toegang tot aanpassen reply');
            redirect('welcome/message');
        } else { //check for URL modification
            if ($result->user_id != $this->session->userdata('user_id')) {
                if ($this->session->userdata('level') < 3) {
                    if ($result->guest_id != $this->input->cookie('guest_id')) {
                        $this->session->set_flashdata('message', 'Geen toegang tot aanpassen reply');
                        redirect('welcome/message');
                    }
                }
            }
        }
        $reply_message = $result->message;
        $bodyData['msg'] = $reply_message;
        $this->session->set_flashdata('reply_id', $reply_id);
        $this->load->view('tmpHeader_view', $headerData);
        $this->load->view('forum/editReply_view', $bodyData);
        $this->load->view('tmpFooter_view');
    }

    public function editReplyProcess() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        //Fields we validate
        $this->form_validation->set_rules(
                'reply', 'Post', 'required|'
                . 'min_length[1]|'
                . 'max_length[1000]|'
        );
        //Validation form
        //Initial page, validation failed
        if ($this->form_validation->run() == FALSE) {
            $this->session->keep_flashdata('reply_id');
            $this->editReply();
        } else { //Validation is OK, open model to insert new topic
            $mod_break = FALSE;
            $reply_id = $this->session->flashdata('reply_id');
            if ($this->session->userdata('user_id')) {
                $username = $this->session->userdata('username');
                if ($this->session->userdata('user_id') != $this->reply_model->get($reply_id)->user_id) {
                    $mod_break = TRUE;
                }
            } else {
                $username = 'Gast' . $this->input->cookie('guest_id');
            }
            $message = '<p>' . $this->input->post('reply') . '</p><h6>Aangepast door: ' . $username . ', op: ' . $date = date('d/m/Y H:i:s', time()) . '</h6>';
            $result = $this->reply_model->edit(
                    $reply_id, $message, $mod_break
            );
            if (!$result) { //Model did not insert data in database
                $error = 'Insert in database failed,'
                        . ' sure database is up and running?';
                $this->editReply($reply_id, $error);
            } else {
                $topic_id = $this->reply_model->get($reply_id)->topic_id;
                $this->replies($topic_id);
            }
        }
    }

}
