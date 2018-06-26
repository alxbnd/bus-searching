<?php

namespace Cont;

use Core\Request;
use Model\Helper as Model;
use Core\DBdriver;
use Core\Validator;

class Helper extends Base
{
	public function __construct (Request $request) {
		parent::__construct($request);
		$this->model = new Model (DBdriver::instance());
	}
	
	public function action_index () {
		echo 'index_method';
		exit;
	}
	
	public function action_add () {
		if ($this->request->is_post()) {
			$data = $this->request->get_post();
			$val = new Validator ($this->model->get_rules('add_city'));
			$err = $val->run($data);
			if (!$err) {
				$this->model->add_city($val->get_clean ());
				exit;
			} else {
				print_r($err);
			}
			$this->model->add_city($data);
			print_r($data);
			exit;
		}
		$this->title = 'Add new city';
		$this->content = $this->render('add_city.html.php');
	}
}