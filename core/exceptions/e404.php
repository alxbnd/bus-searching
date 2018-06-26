<?php

namespace Core\Exceptions;

class E404 extends Base 
{
	public function __construct ($message = null, $code = 0, Exception $previous = null) {
		$this->err = '404';			
		parent::__construct ($message, $code, $previous);	
	}
	
	public function index () {
		$this->title = 'Error_404';
		$this->content = $this->render('error.html.php', ['message'=>$this->msg]);
		header("HTTP/1.1 404 Not Found"); 
	}
}