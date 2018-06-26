<?php

namespace Core;

class Log
{
	
	private $message;
	private $path;
	
	public function __construct ($type, $err) {
		$this->path = LOG_DIR.$type.'/'.date('Y-m-d');
		$this->message = $err;
		$this->prep_dir(LOG_DIR.$type);
	}
	
	public function write_log() {
		$msg = date("H:m:s") . ':____'. $this->message. '
		IP = '. $_SERVER['REMOTE_ADDR'] .'
		
';		
		file_put_contents($this->path, $msg, FILE_APPEND);
	}
	
	private function prep_dir($dir) {
		if (!file_exists($this->path)) {
			mail('webmaster@xlk.pl', 'error_logs', 'new logfile created '.$this->path);
		}
	}
}
