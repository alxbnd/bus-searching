<?php

namespace Core;

class Request 
{
	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';
	
	public $get;
	public $post;
	public $files;
	public $server;
	
	public function __construct ($get, $post, $files, $server) {
		$this->get = $get;
		$this->post = $post;
		$this->files = $files;
		$this->server = $server;
	}	
	
	public function is_post () {
		return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
	}
	
	public function get_post () {
		return $this->post;
	}
	
	public function is_get () {
		return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
	}

	public function get_uri() {
		$ret = str_replace(ROOT, '', $this->server['REQUEST_URI']);
		return $this->exp_uri(strtolower($ret));
	}
	
	public function get_elem($i) {
		return $this->get_uri()[$i];
	}
	
	public function get_refer() {
		return isset($this->server["HTTP_REFERER"]) ? $this->server["HTTP_REFERER"] : ROOT;
	}
	
	public function get_data ($scheme) {
		$arr = [];
		foreach ($scheme as $k=>$v) {
			$arr[$k] = isset($this->server[$v]) ? $this->server[$v] : false;
		}
		return $arr;
	}
	
	public function get_agent () {
		return $this->server['HTTP_USER_AGENT'];
	}
	
	private function exp_uri ($ret) {
		$uri = explode('/', $ret);
		$count = count($uri);
		if ($uri[$count - 1] === '') unset($uri[$count - 1]);
		return $uri;
	}
}