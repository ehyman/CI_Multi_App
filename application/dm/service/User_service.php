<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* user service
*/
class User_service extends MY_Service
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('BaseModel');
    }

    public function showDb()
    {
        return $this->BaseModel->showDb();
    }
}