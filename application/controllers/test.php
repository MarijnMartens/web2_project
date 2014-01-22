<?php

class Test extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$this->load->view('test_view', array('error' => ' ' ));
	}

	function process()
	{
            $fName=$this->input->post('fName');
            $userfile= $this->input->post('userfile');
		$config['upload_path'] = './assets/images/avatars/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '300';
		$config['max_width']  = '2000';
		$config['max_height']  = '1300';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('test_view', $error);
		}
		else
		{
			$data['upload_data'] = $this->upload->data();
                        $data['fName'] = $fName;
                        $data['userfile'] = $userfile;

			$this->load->view('test_process_view', $data);
		}
	}
}
?>