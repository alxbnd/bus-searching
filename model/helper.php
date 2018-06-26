<?php

namespace Model;

use Core\Validator;

class Helper extends Base
{
	public function __construct ($db) {
		parent::__construct($db);
		$this->table = 'city';
	}
	
	public function add_city ($post) {
		$this->new_insert($post);
	}
	
	public function get_rules ($type) {
		switch ($type) {
			case "add_city": 
				return ['fields'=>['city', 'num_flix'], 'required' =>['city', 'num_flix'], 'string'=>['city'], 'int'=>['num_city']];
		}
	}
}