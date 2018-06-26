<?php

namespace Model;

use Core\iDBdriver;

abstract class Base 
{
	protected $db;
	protected $table;
	
	public function __construct(iDBdriver $db) {
			$this->db = $db;
	}
	
	public function get_everything () {
		return $this->db->query("SELECT * FROM {$this->table}");		
	}
	
	public function get_one (array $key) {
		$str = false;
		foreach ($key as $k=>$v) {			
			$str = $this->db->query("SELECT * FROM {$this->table} WHERE $k=:$k", ["$k"=>$v]);
		}
		return $str ? $str[0] : false ;
	}
	
	public function get_fields (String $cell, String $par, array $obj) {
		$str = '\'';
		$str .= implode('\', \'', $obj).'\'';
		return $this->db->query("SELECT $cell, $par FROM {$this->table} WHERE $par IN ($str)");
	}
	
	public function get_all ($par) {
		return $this->db->query ("SELECT $par FROM {$this->table}");
	}
	
	public function get_all_sort ($par, $sort) {		
		return $this->db->query("SELECT $sort $par FROM {$this->table}");
	}
	
	public function new_insert (array $fields) {
		return $this->db->insert ($this->table, $fields);
	}
	
	public function del_line ($obj) {
		return $this->db->delete($this->table, $obj);
	}
	
	public function edit_line ($obj) {
		return $this->db->update ($this->table, $obj);
	}
}
