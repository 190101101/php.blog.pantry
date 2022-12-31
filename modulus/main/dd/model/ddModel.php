<?php 

namespace modulus\main\dd\model;
use core\model;

class ddModel extends model
{
	public function dd()
	{
		$this->db->create('code', $_POST);
		$this->return->referer();
	}	
}
