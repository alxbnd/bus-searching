<?php

namespace Core\Exceptions;

class Ebd extends Base
{
	public function __construct($message = 0, $code = 0 , Exception $previous = null) {
		$this->err = 'DB';
		parent::__construct ($message, $code, $previous);
	}
	
	private function index () {
		$this->title = 'Error_BD';
		$this->content = $this->render('error.html.php', ['message'=>$this->msg]);
		header("HTTP/1.1 500 Internal Server Error");
	}
}