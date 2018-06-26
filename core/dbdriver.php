<?php

namespace Core;

use PDO;
use Model\DB;

class DBdriver implements iDBdriver
{
	use \Core\Traits\Singleton;
	private $pdo;
	
	private function __construct () {
		$this->pdo = DB::get();
	}
	
	public function query($sql, $params=[]) {
		$query = $this->pdo->prepare($sql);
		$query->execute($params);
		$this->checkDB_error($query);
		
		return $query->fetchAll();
	}
	
	public function insert ($table, array $obj) {
		$cel = [];
		$mask = [];
		foreach ($obj as $k=>$v) {
			$cel []= $k;
			$mask []= ":$k";
		}
		if ($v === null) {
			$obj[$k] = 'NULL';
		}
		$cel = implode (", ", $cel);
		$mask = implode (", ", $mask);
		$insert = $this->pdo->prepare("INSERT INTO {$table} ({$cel}) VALUES ({$mask})");
		$insert->execute($obj);
		$this->checkDB_error($insert);
		
		return $this->pdo->lastInsertId();
	}
	
	public function inserts ($table, array $obj) {
		$cels = [];
		$value = [];
		$i = 0;
		foreach ($obj as $mass) {	
			$val = [];
			foreach ($mass as $k=>$v) {
				if ($i < 1) $cels[] = $k;
				
				$val[] = $v ? addslashes($v) : 'NULL';
			}
			$value[$i] = implode ('\', \'', $val);
			$value[$i] = '(\''.$value[$i].'\')';
			$i++;
		}
		$cels = implode (", ", $cels);
		$value = implode (', ', $value);
		$insert = $this->pdo->prepare("INSERT INTO {$table} ({$cels}) VALUES {$value}");
		$insert->execute();		
		$this->checkDB_error($insert);
		
		return $this->pdo->lastInsertId();
	}
	
	public function update ($table, array $obj, $where) {
		$mask = [];
		foreach($obj as $k=>$v) {
			$mask[] = "$k=:$k";
			if ($v === null) {
				$obj[$k]='NULL';
			}
		}
		$mask = implode(", ", $mask);
		$update = $this->pdo->prepare("UPDATE {$table} SET $mask WHERE $where");
		$update->execute ($obj);
		$this->checkDB_error($update);
		
		return $update->rowCount();
	}
	
	public function delete ($table, array $where) {
		$cel = [];
		$mask = [];
		foreach ($where as $k=>$v) {
			if (!in_array ($k, $cel)) {
				$cel[] = $k;
				$mask[] = ':'.$k;
			}
			if (count($cel)>1) {
				echo 'I do not realise this method yet! I can not delete many colomns with many keys';
				exit;
			}
			$mask = "$cel[0]=$mask[0]";
		}
		
		$delete = $this->pdo->prepare("DELETE FROM {$table} WHERE {$mask}");
		$delete->execute($where);
		$this->checkDB_error($delete);
		
		return $delete->rowCount();
	}
	
	private function checkDB_error ($query) {
		$err = $query->errorInfo();
		if ($err[0] != PDO::ERR_NONE) {
			exit($err[2]);
		}
	}
}