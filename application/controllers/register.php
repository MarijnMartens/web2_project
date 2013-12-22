<?php

class Register extends CI_Controller {

	public function index()
	{
            //Methodes oproepen
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
             
                //Fields die gecontroleerd gaan worden
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[20]|callback_username_check|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[3]|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
                
                //Aangepaste melding
                $this->form_validation->set_message('is_unique', '%s is already used');
                $this->form_validation->set_message('matches', 'Passwords do not match');

                //View tonen
		if ($this->form_validation->run() == FALSE)
		{
                    $headerData = ['title' => 'Register'];
                    $this->load->view('tmpHeader_view', $headerData);
			$this->load->view('register_view');
                        $this->load->view('tmpFooter_view');
		}
		else
		{
                    $encryptedPassword = crypt($this->input->post('password'));
                    $this->load->model('Register_model');
                   $aantal = $this->Register_model->setUsers($this->input->post('username'), $this->input->post('password'), $this->input->post('email'));
                    if ($aantal)
                    {
                        $bodyData = ['gelukt' => 'Insert in database succesful'];
                    } else{
                        $bodyData = ['gelukt' => 'Insert in database failed'];
                    }
			$this->load->view('register_success_view', $bodyData);//moet in de view nog gebruikt worden
		}
	}

        //Admin niet toelaten als username
	public function username_check($str)
	{
		if (!strcasecmp($str, 'admin')) //strcasecmp is case insensitive
		{
			$this->form_validation->set_message('username_check', '%s may not be \'' . $str . '\''); //%s is human name field form
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

}
?>