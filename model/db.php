<?php

namespace Model;

use PDO;

class DB 
{
	private static $instance;
	
	public static function get () {
		if (self::$instance === null) self::$instance = self::connect();
		
		return self::$instance;
	}
	
	private static function connect () {
		$dsn = DB_DRIVER . ':' . 'host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
		$opt = [ PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC ];
		
		return new PDO($dsn, DB_USER, DB_PASS, $opt);		
	}
}