<?php

/*
 * Author: Marijn Martens
 * Created on: 29/12/2013
 * Edit: 09/01/2014 : display timestamp, topicTitle, username/guestid, insert reply
 * Edit: 10/01/2014: update reply with check
 * Edit: 14/01/2014: counters, cleaning code
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
        $this->load->model('login_model');
        $this->load->library('MyAccess');
    }

    //Main Forum - Lists different sections: Guests (i.e. FAQ, Guestbook) / Users / Hexioners / Admins
    public function index() {
        //Get all sections from database where level is equal or higher
        //Only forums are shown when userlevel >= forumlevel
        $level = $this->session->userdata('level');
        $result = $this->forum_model->getForums($level);
        //Check if all data is available otherwise display unknown
        foreach ($result as $row) {
            $forum_id = $row->id;
            //Get data regarding last submitted reply somewhere in a topic in the forum
            $lastReply_result = $this->lastReplyForum($forum_id);
            //if no topics in forum
            if (!$lastReply_result) {
                //display unknown = 'Onbekend'
                $topicTitle = $replyUsername = $lastReplyDate = 'Onbekend';
            } else { //there are topics in forum, display data
                //print title topic where last reply of entire forum is found
                $topicTitle = $this->topic_model->getData($lastReply_result->topic_id)->title;
                //a reply could be submitted by either a registered user or a guest, verify which of the 2
                if ($lastReply_result->user_id != 0) {
                    ;
                    $replyUsername = $this->login_model->getUserdata($lastReply_result->user_id)->username;
                } else {
                    $replyUsername = 'Gast' . $lastReply_result->guest_id;
                }
                //format timestamp date from database to PHP timestamp, then convert to desired format '00/00/0000 00:00'
                $lastReplyDate = date('d/m/Y H:i', strtotime($lastReply_result->date));
            }
            //rows to userscreen
            $result = (
                    '<tr>' .
                    '<td><a href="' . base_url() . 'forum/topics/' . $forum_id . '">' . $row->title . '</a><br/>' .
                    $row->description . '</td>' .
                    '<td><b>' . $this->countTopics($forum_id) . '</b> topics<br/><b>' .
                    $this->countRepliesForum($forum_id) . '</b> antwoorden</td>' .
                    '<td>' . $topicTitle . '<br/>' .
                    'Door: <b>' . $replyUsername . '</b><br/>' .
                    $lastReplyDate . '</td>' .
                    '</tr>'
                    );
            //Put each row in array
            $data[] = $result;
        }
        //Prepare title for webpage
        $headerData = ['title' => 'Forum'];
        //Send array to view
        $bodyData['forums'] = $data;
        $this->load->view('template/tmpHeader_view', $headerData);
        $this->load->view('template/tmpPage_view');
        $this->load->view('forum/forum_view', $bodyData);
        $this->load->view('template/tmpFooter_view');
    }

    //Display list of topics
    public function topics($forum_id = NULL) {
        //security measure to find url tampering when no argument is entered
        $libraryData = array('argument' => $forum_id);
        $this->myaccess->missingArguments($libraryData);
        //security measure to disable modifying URL
        $this->checkLevel($forum_id);
        //Get list of topics in given forum
        $result = $this->topic_model->getTopics($forum_id);
        //If there are topics in forum
        if ($result != NULL) {
            //Display data for each topic
            foreach ($result as $row) {
                $topic_id = $row->id;
                //Get data of lastreply in this topic
                $lastReply_result = $this->reply_model->getLast($topic_id);
                //if no replies in topic set text lastreply
                if (!$lastReply_result) {
                    $replyUsername = $lastReplyDate = 'Onbekend';
                } else {
                    if ($lastReply_result->user_id != 0) {
                        //get username
                        $this->load->model('login_model');
                        $replyUsername = $this->login_model->getUserdata($lastReply_result->user_id)->username;
                    } else {
                        //get guest_id
                        $replyUsername = 'Gast' . $lastReply_result->guest_id;
                    }
                    //format date
                    $lastReplyDate = date('d/m/Y H:i', strtotime($lastReply_result->date));
                }
                $startTopicDate = date('d/m/Y H:i', strtotime($row->date));
                $result[0] = (
                        '<tr>' .
                        '<td><a href="' . base_url() . 'forum/replies/' . $topic_id . '">' . $row->title . '</a><br/>' .
                        'Aangemaakt: <b>' . $row->username . '</b><br/>' .
                        $startTopicDate . '</td>' .
                        '<td><b>' . '#<b/> bezocht<br/>' .
                        '<b>' . $this->countReplies($topic_id) . '<b/> antwoorden</td>' .
                        '<td>Door: <b>' . $replyUsername . '</b><br/>' .
                        $lastReplyDate . '</td>'
                        );
                //check if user is able to delete topic
                $libraryData = array('forum_id' => $forum_id);
                if ($this->myaccess->deleteTopic($libraryData)) {
                    $result[1] = '<td><a href="' . base_url() . 'forum/deleteTopic/' . $topic_id . '">Verwijder</a></td>';
                } else {
                    $result[1] = '';
                }
                $result[2] = (
                        '</tr>'
                        );
                //combine 3 results
                $data[] = implode('', $result);
            }
        } else { //there are no topics in the forum
            $data[] = null;
        }
        //count # topics
        $count = $this->countTopics($forum_id);
        //display page
        $headerData = ['title' => 'Topics'];
        $bodyData['topics'] = $data;
        $bodyData['count'] = $count;
        //keep forum_id for insert new topic
        $this->session->set_flashdata('forum_id', $forum_id);
        //$this->load->view('template/tmpHeader_view', $headerData);
        $pageData = ['aside_visible' => 'false'];
        $this->load->view('template/tmpPage_view', $pageData);
        $this->load->view('forum/topic_view', $bodyData);
        $this->load->view('template/tmpFooter_view');
    }

    //insert new topic
    public function insertTopic($error = NULL) {
        //get forum_id from method topics
        $forum_id = $this->session->flashdata('forum_id');
        echo $forum_id;
        //check if user can create a topic
        $this->myaccess->insertTopic();
        //security measure to find url tampering when no argument is entered
        $libraryData = array('argument' => $forum_id, 'flash' => $forum_id);
        $this->myaccess->missingArguments($libraryData);
        //get user_id
        $user_id = $this->session->userdata('user_id');
        //set form validation
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        //Valide fields
        $this->form_validation->set_rules(
                'title', 'Title', 'required|'
                . 'min_length[5]|'
                . 'max_length[100]|'
        );
        $this->form_validation->set_rules(
                'reply', 'OP', 'required|'
                . 'min_length[2]|'
                . 'max_length[2000]|'
        );
        //Validation form, empty or not correct
        if ($this->form_validation->run() == FALSE) {
            $headerData = ['title' => 'Nieuw Topic'];
            $bodyData['error'] = $error;
            $this->load->view('template/tmpHeader_view', $headerData);
            $pageData = ['aside_visible' => 'false'];
            $this->load->view('template/tmpPage_view', $pageData);
            $this->load->view('forum/insertTopic_view', $bodyData);
            $this->load->view('template/tmpFooter_view');
            //keep flashdata for another run
            $this->session->keep_flashdata('forum_id');
        } else { //Validation is OK, open model to insert new topic
            $result_topic = $this->topic_model->insert(
                    $forum_id, $user_id, ucfirst($this->input->post('title'))
            );
            if (!$result_topic) { //Model did not insert data in database
                $bodyData = ['error' => 'Topic aanmaken is mislukt, probeer nogmaals'];
                $this->insertTopic($error);
            } else {
                //insert first post in newly created topic
                $result_reply = $this->reply_model->insert(
                        $result_topic, $this->input->post('reply'), $user_id
                );
                if (!$result_reply) { //Model did not insert data in database
                    $bodyData = ['error' => 'Openingspost aanmaken is mislukt, probeer topic te openen en een nieuwe reply aan te maken'];
                    $this->insertReply($error);
                } else {
                    $this->replies($result_topic);
                }
            }
        }
    }

    //display list of replies in one topic
    public function replies($topic_id = NULL) {
        //security measure to find url tampering when no argument is entered
        $libraryData = array('argument' => $topic_id);
        $this->myaccess->missingArguments($libraryData);
        //set title
        //get counters
        $result = $this->reply_model->getReplies($topic_id);
        $count = $this->reply_model->getCount($topic_id) - 1;
        //set bodyData
        $bodyData['replies'] = $result;
        $bodyData['count'] = $count;
        //display page
        //set topic_id so we can throw it to insertReply
        $this->session->set_flashdata('topic_id', $topic_id);
        $headerData = ['title' => 'Replies'];
        //$this->load->view('template/tmpHeader_view', $headerData);
        $pageData = ['aside_visible' => 'false'];
        $this->load->view('template/tmpPage_view', $pageData);
        $this->load->view('forum/reply_view', $bodyData);
        $this->load->view('template/tmpFooter_view');
    }

    //insert new reply
    public function insertReply($error = NULL) {
        //call captcha-library
        $this->load->library('MyCaptcha');
        //Call form validation-library
        $topic_id = $this->session->flashdata('topic_id');
        echo $topic_id;
        //security measure to find url tampering when no argument is entered
        $libraryData = array('argument' => $topic_id);
        $this->myaccess->missingArguments($libraryData);
        //get user_id if available, else get or create guest_id
        $user_id = $this->session->userdata('user_id');
        $guest_id = NULL;
        if ($user_id == NULL) {
            if ($this->input->cookie('guest_id')) {
                $guest_id = $this->input->cookie('guest_id');
            } else {
                $guest_id = $this->reply_model->anonymous();
            }
        }
        //Validate form
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        //Validate fields
        $this->form_validation->set_rules(
                'reply', 'Post', 'required|'
                . 'min_length[2]|'
                . 'max_length[2000]|'
        );
        //Validation form
        if ($this->form_validation->run() == FALSE) {
            //First load or form is bad
            $captcha = $this->mycaptcha->showCaptcha();
            $headerData = ['title' => 'Nieuw Reply'];
            $bodyData['error'] = $error;
            $bodyData['captcha'] = $captcha;
            // $this->load->view('template/tmpHeader_view', $headerData);
            $pageData = ['aside_visible' => 'false'];
            $this->load->view('template/tmpPage_view', $pageData);
            $this->load->view('forum/insertReply_view', $bodyData);
            $this->load->view('template/tmpFooter_view');
            //Keep topic_id for another run
            $topic_id = $this->session->keep_flashdata('topic_id');
        } else { //Validation is OK, check if captcha is needed
            $captcha = $this->mycaptcha->validateCaptcha();
            if (!$captcha) {
                /*$error = 'We konden niet vaststellen dat je een mens bent, probeer nogmaals';
                $this->insertReply($error);*/
                echo 'DIT WERKT NOG NIET, splits methode op in insertReplyProcess';
            } else {
                //open model to insert new topi
                $this->load->model('reply_model');
                $result = $this->reply_model->insert(
                        $topic_id, ucfirst($this->input->post('reply')), $user_id, $guest_id
                );
                if (!$result) { //Model did not insert data in database
                    $bodyData = ['error' => 'Antwoord aanmaken is mislukt, probeer nogmaals'];
                    $this->insertReply($error);
                } else {
                    $this->replies($topic_id);
                }
            }
        }
    }

    //edit existing reply
    public function editReply($reply_id = NULL, $error = NULL) {
        //security measure to find url tampering when no argument is entered
        $libraryData = array('argument' => $reply_id);
        $this->myaccess->missingArguments($libraryData);
        //get original data
        $result = $this->reply_model->get($reply_id);
        //if reply closed by admin, stop further processing
        if ($result->mod_break == TRUE) {
            $this->session->set_flashdata('message', 'Geen toegang tot aanpassen reply');
            redirect('welcome/message');
        } else { //check for URL modification
            //to edit a reply the user_id has to match the original if present
            if ($result->user_id != $this->session->userdata('user_id')) {
                //If not, to edit a reply the user_level has to be at least 3
                if ($this->session->userdata('level') < 3) {
                    //If not, to edit a reply the guest_id has to match the original
                    if ($result->guest_id != $this->input->cookie('guest_id')) {
                        //If not one condition is true, get out of here
                        $this->session->set_flashdata('message', 'Geen toegang tot aanpassen reply');
                        redirect('welcome/message');
                    }
                }
            }
        }
        //subtract the modified message ('edited on + data + username') from text before showing
        $reply_message = $result->message;
        //remove string at pos to end if found
        $message_newPosChange = strpos($reply_message, '<h6>Aangepast door: ');
        if ($message_newPosChange > 0) {
            $reply_message = substr_replace($reply_message, '', $message_newPosChange);
        }
        //display form
        $headerData = ['title' => 'Edit Reply'];
        $bodyData['error'] = $error;
        $bodyData['msg'] = $reply_message;
        $this->session->set_flashdata('reply_id', $reply_id);
        $this->session->set_flashdata('message_old', $reply_message);
        // $this->load->view('template/tmpHeader_view', $headerData);
        $pageData = ['aside_visible' => 'false'];
        $this->load->view('template/tmpPage_view', $pageData);
        $this->load->view('forum/editReply_view', $bodyData);
        $this->load->view('template/tmpFooter_view');
    }

    //push edited reply to database
    public function editReplyProcess() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        //Fields we validate
        $this->form_validation->set_rules(
                'reply', 'Post', 'required|'
                . 'min_length[1]|'
                . 'max_length[2100]|'
        );
        //Validation form
        //Initial page, validation failed
        if ($this->form_validation->run() == FALSE) {
            $this->session->keep_flashdata('reply_id');
            $this->session->keep_flashdata('message_old');
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
            $reply_message = $this->input->post('reply');
            $message = $reply_message . '<h6>Aangepast door: ' . $username . ', op: ' . $date = date('d/m/Y H:i:s', time()) . '</h6>';
            $result = $this->reply_model->edit(
                    $reply_id, ucfirst($message), $mod_break, $this->session->flashdata('message_old')
            );
            if (!$result) { //Model did not insert data in database
                $error = 'Antwoord wijzigen is mislukt, probeer nogmaals';
                $this->editReply($reply_id, $error);
            } else {
                $topic_id = $this->reply_model->get($reply_id)->topic_id;
                $this->replies($topic_id);
            }
        }
    }

    //Send confirmation to delete topic
    public function deleteTopic($topic_id) {
        $headerData = ['title' => 'Delete topic'];
        $bodyData['topic_title'] = $this->topic_model->getData($topic_id)->title;
        $this->session->set_flashdata('topic_id', $topic_id);
        //$this->load->view('template/tmpHeader_view', $headerData);
        $pageData = ['aside_visible' => 'false'];
        $this->load->view('template/tmpPage_view', $pageData);
        $this->load->view('forum/deleteTopic_view', $bodyData);
        $this->load->view('template/tmpFooter_view');
    }

    //Process deletion of topic
    public function deleteTopicProcess() {
        $topic_id = $this->session->flashdata('topic_id');
        $result = $this->topic_model->delete($topic_id);
        if (!$result) {
            $this->session->set_flashdata('message', 'Deleten topic was momenteel niet mogelijk');
            redirect('welcome/message');
        } else {
            $this->index();
        }
    }

    public function closeTopic($topic_id) {
        $result = $this->topic_model->close($topic_id);
        if (!$result) {
            $this->session->set_flashdata('message', 'Topic sluiten mislukt');
            redirect('welcome/message');
        } else {
            $this->index();
        }
    }

    //get last reply in forum
    private function lastReplyForum($forum_id) {
        //get all topic_id's as an array
        $result = $this->topic_model->getAll($forum_id);
        if ($result) { //there are topics
            //variable to hold latest date
            $dateMax = '';
            //transverse topics
            foreach ($result as $row) {
                //get latest reply data for each topic
                $reply = $this->reply_model->getLast($row->id);
                //Check if last-reply in last-topic is newer than earlier topics
                if ($reply->date > $dateMax) {
                    //reset dateMax to current date
                    $dateMax = $reply->date;
                    //fill return array with data current reply
                    $data = $reply;
                }
            }
            return $data;
        } else {
            return FALSE;
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
            $this->session->set_flashdata('message', 'Je moet een hoger toegangsrecht hebben om in dit forum te mogen.');
            redirect('welcome/message');
        }
    }

}
