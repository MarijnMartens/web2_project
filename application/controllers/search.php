<?php

/*
 * Author: Marijn
 * Created on: 18/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    public function index() {
        $this->load->model('search_model');
        $keyword = trim($this->input->post('search'));
        $result = $this->search_model->getAll($keyword);
        if ($result) {
            //iterate each database table in getAll
            foreach ($result as $table) {
                //check database table has result
                if ($table) {
                    //iterate rows in table
                    foreach ($table as $row) {
                        //iterate columns in table
                        echo '<table border="1" width="200">';
                        foreach ($row as $column) {
                            echo "<tr><td>$column</td></tr>";
                        }
                        echo '</table></br>';
                    }
                }
            }
        }
    }

}
