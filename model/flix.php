<?php

namespace Model;

use Core\Parse;
use Core\iValidator;

class Flix extends Base
{
	private $validator;
	
	public function __construct ($db) {
		parent::__construct($db);
		$this->table = 'city';
	}
	
	public function get_cities() {
		$cities = $this->get_all('city');
		$ready = [];
		foreach ($cities as $city) {
			foreach ($city as $k=>$v) {
				$ready[] = $v;
			}
		}
		return $ready;
	}
	
	public function check_data (iValidator $val, $data) {
		$this->validator = $val;
		$val = $this->validator->run($data);
		
		return $val ? $val : false;
	}
	
	public function get_data () {
		
		return $this->validator->get_clean();
	}
	
	public function start_search ($request, $data, Parse $core) {
		$data = $this->prep_data($data);
		$core->run($data);
		
		return $core->get_result();
	}
	
	public function get_rules () {
		return [
					'fields'=>['dateStart', 'dateEnd','cityDepart', 'cityArrive'],
					'required' =>['dateEnd', 'cityDepart', 'cityArrive'],
					'string'=>['cityDepart', 'cityArrive']
				];
	}
	
	private function prep_data ($data) {
		$ready = [];
		$cities = $this->get_fields('num_flix', 'city', [$data['cityDepart'], $data['cityArrive']]);
		foreach ($cities as $num) {
				if ($data['cityDepart'] === $num['city']) {
					$ready['dep'] = $num['num_flix'];
					$ready['cityDepart'] = $num['city'];
				}
				if ($data['cityArrive'] === $num['city']) {
					$ready['arr'] = $num['num_flix'];
					$ready['cityArrive'] = $num['city'];
				}
			}
		$ready['datestart'] = strtotime($data['dateStart']);
		$ready['start'] = $data['dateStart'];
		$ready['dateend'] = strtotime($data['dateEnd']);
		$ready['end'] = $data['dateEnd'];
		
		return $ready;
	}
	
}
