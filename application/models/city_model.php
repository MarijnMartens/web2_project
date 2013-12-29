<?php

class City_model extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function getCities()
    {
        $this->db->select('Name');
        $this->db->from('City');
        $this->db->order_by('Name');
        $query = $this->db->get();
        
        if ($query->num_rows() == 0)
        {
            return 0;
        } else {        
        return $query->result();
        }
    }
}