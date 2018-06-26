<?php

namespace Core\Exceptions;
use Exception;
use Core\Log;

abstract class Base extends Exception
{
	public $title;
	public $content;
	public $err = 'error';
	public $msg;
	protected $log;
	
	public function __construct($message = null, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);	
		$this->msg = $this->get_message().$message;
		$this->log = new Log ($this->err, $this->msg);
		$this->log->write_log();
	}
	
	public function response () {
		echo $this->render ('base.html.php', 
						[
							'title'=>$this->title, 'content'=>$this->content
						]);
	}
	
	protected function render ($tmp, array $vars = []) {
		ob_start();
		extract($vars);

		include_once __DIR__.'/../../view/' . $tmp;

		return ob_get_clean();
	}
	
	protected function get_message () {
		return 'trace_stek:
'.$this->getTraceAsString().'__'; 
	}
}