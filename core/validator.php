<?php

namespace Core;

class Validator implements iValidator
{
	private $rules;
	private $errors = [];
	private $ready = [];
	
	public function __construct (array $rules) {
		$this->rules = $rules;
	}
	
	public function run (array $fields) {
		foreach ($this->rules['fields'] as $k=>$v) {
			if (!array_key_exists($v, $fields)) $this->errors[$v] = 'empty';
		}
		foreach ($fields as $k=>$v) {
			$value = in_array($k, $this->rules['fields']) ? trim(strip_tags($v)) : false; 
			if (in_array($k, $this->rules['required']) && $value == '') $this->errors[$k] = 'empty';
			if (isset($this->rules['string']) && !is_string($value) && in_array($k, $this->rules['string'])) $this->errors[$k] = 'not_string';
			
			if (!$this->errors) $this->ready[$k] = $value;
		}
		
		return $this->errors ? $this->errors : false;
	}
	
	public function get_clean () {
		return $this->ready;
	}

}
