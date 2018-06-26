<?php

namespace Core\Traits;

trait Singleton
{
	protected static $singleton_instance;
	
	public static function instance () {
		if (static::$singleton_instance === null) {
			static::$singleton_instance = new static ();
		}
		return static::$singleton_instance;
	}
	
	protected function __construct () {}
	protected function __clone () {}
	protected function __sleep () {}
	protected function __wakeup () {}
}