<?php

include_once __DIR__ . '/config.php';
use Core\App;

session_start();

function my_class_loader ($classname) {
	$classname = strtolower($classname);
	$classname = str_replace('\\', '/', $classname);
	
	include_once($classname . '.php');
}

spl_autoload_register('my_class_loader');

$app = new App();

$app->run();
