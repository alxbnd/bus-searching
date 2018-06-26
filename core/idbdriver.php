<?php

namespace Core;

interface iDBdriver
{
	/*
	* @param string $sql
	*
	*@return array|integer
	*/
	public function query($sql);
	
	/*
	* @param string $table table for insert
	* @param array $obj massive for insert to the base
	*
	* @return integer last inserted id
	*/
	public function insert ($table, array $obj);
	
	/*
	* @param string $table table
	* @param array $obj massive for inserts to the base
	*
	* @return integer last inserted id
	*/
	public function inserts ($table, array $obj);
	
	/*
	* @param string $table
	* @param array $obj
	* @param string $where
	*
	* @return integer updated rows count
	*/
	public function update ($table, array $obj, $where);
	
	/*
	* @param string $table
	* @param string $where
	*
	* @return integer deleted rows count
	*/
	public function delete ($table, array $where);
}