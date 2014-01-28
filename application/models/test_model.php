<?php

/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test_model extends CI_Model{
    
    public function getUserMetaData(){
        $query = $this->db->get('user');
        return $query;
    
    
    }
}
