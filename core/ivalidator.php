<?php

namespace Core;

interface iValidator
{
	/**
	* @param array $rules
	*
	* set rules
	*/
	public function __construct (array $rules);
	
	/*
	* @array $fields
	*
	* @return array errors if crashed or boolean false if succeed
	*/
	public function run (array $fields);
	
	/*
	* @return array with validated data 
	*/
	public function get_clean ();
}
