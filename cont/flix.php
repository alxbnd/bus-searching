<?php

namespace Cont;

use Core\Request;
use Model\Flix as Model;
use Core\DBdriver;
use Core\Parse;
use Core\Validator;

class Flix extends Base
{
	public function __construct (Request $request) {
		parent::__construct($request);
		$this->model = new Model (DBdriver::instance());
	}
	
	public function action_index() {
		$this->action_search ();	
	}
	
	public function action_search () {
		if ($this->request->is_post()) {
			$data = $this->request->get_post();	
			$val = $this->model->check_data (new Validator($this->model->get_rules()), $data);
			if ($val) {
				$this->title = 'Start searching tickets';
				$this->content = $this->render('search_form.html.php', ['error'=>$val, 'data'=>$data, 'cities'=>$this->model->get_cities()]);
			} else {
				$data = $this->model->get_data();
				$result = $this->model->start_search ($this->request, $data, new Parse ($this->request));		
				$this->title = 'Result of searching';
				$this->content = $this->render('result.html.php', ['result'=>$result]);
			}
		} else {
			$this->title = 'Start searching tickets';
			$this->content = $this->render('search_form.html.php', ['cities'=>$this->model->get_cities()]);
		}
	}
}
