<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseModel extends CI_Model {

	private $db;
	public function __construct()
	{
		$this->db = $this->load->database('default', true);

	}
	
    public function showDb()
    {
        return $this->db;
    }

}
