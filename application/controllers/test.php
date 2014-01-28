<?php

class Test extends CI_Controller {
    
    public function metaData(){
        $this->load->model('test_model');
        
        $result = $this->test_model->getUserMetaData();
        
         $bodyData['result'] = $result;
         $bodyData['title'] = 'Zoekresultaten';
         $bodyData['view'] = 'test_view';
         $this->load->view('template/tmpPage_view', $bodyData);
        
    }

	
}
?>