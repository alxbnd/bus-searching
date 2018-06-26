<?php

namespace Core;

use Libraries\Snoopy;

class Parse
{
	private $snoopy;
	private $data;
	private $result;
	private $url;
	
	public function __construct (Request $request) {
		$this->snoopy = new Snoopy();
		$this->snoopy->agent = $request->get_agent();
		
	}
	
	public function run ($data) {
		$this->data = $data;
		$find = $this->get_data();
		$price = $this->get_date_quantity($find, 'price');
		$this->prepare_result($price, $find);
	}
	
	public function get_result () {
		return $this->result;
	}
	
	private function get_data () {
		$compl = [];
		for ($i=$this->data['datestart']; $i <= $this->data['dateend']; $i+=86400) {
			$url = $this->get_url($i);
			$this->snoopy->fetch($url);
			$res = $this->snoopy->results;	
			preg_match_all(PREG_TICKET_NUM, $res, $price);
			preg_match_all(PREG_TICKET_DEPARTURE, $res, $dep);
			preg_match_all(PREG_TICKET_ARRIVAL, $res, $arr);
			$price = str_ireplace('zł', '', $price[1]);
			$compl[$i]['price'] = $this->array_sort($price);
			$compl[$i]['dep'] = $dep[1];
			$compl[$i]['arr'] = $arr[1];
			$compl[$i]['url'] = $url;
		}
		return $compl;
	}
	
	private function array_sort ($data) {
		$price = [];
		foreach ($data as $k=>$v) {
			if (gettype($key = $k/2) === 'integer') {
				$price[] = (float)$v;
				if ($v == 0) {
					unset ($price[$key]);
				}
			}
		}
		return $price;
	}
	
	private function prepare_result ($price, $find) {
		$value = min($price['min']);
		$date = array_keys($price['min'], $value);
		$this->result['min'] = [
				'min'=> $value, 
				'date'=> $date, 
				'details' => $this->get_details($value, $date, $find)
			];
		$value = max($price['max']);
		$date = array_keys($price['max'], $value);
		$this->result['max'] = [
				'max'=>$value,
				'date'=>$date,
				'details' => $this->get_details($value, $date, $find)
			];
		$this->result['price'] = $price;
		$this->result['route'] = ['depart'=>$this->data['cityDepart'], 'arrive'=>$this->data['cityArrive']];
		$this->result['period'] = ['start'=>$this->data['start'], 'end'=>$this->data['end']];
	}
	
	private function get_url($date) {
		if (!$this->url) {
			$this->url = 'https://shop.flixbus.pl/search?departureCity='.$this->data['dep'].
						'&arrivalCity='.$this->data['arr'].'&rideDate=';
		}
		return $this->url.date('d.m.Y', $date).'&adult=1&currency=PLN';
	}
	
	private function get_date_quantity ($obj, $flag) {
		$price = [];
		foreach ($obj as $k=>$mass) {
			$date = date('d.m.Y', $k);
			$price['min'][$date] = min($mass[$flag]);
			$price['max'][$date] = max($mass[$flag]);
		}
		return $price;
	}
	
	private function get_details ($price, $date, $find) {
		$result = [];
		foreach ($date as $k=>$v) {
			$day = $find[strtotime($v)];
			$keys = array_keys($day['price'], $price);
			foreach ($keys as $key=>$val) {
				$result[$v]['departure'][]= $day['dep'][$val];
				$result[$v]['arrive'][]= $day['arr'][$val];
			}
			$result[$v]['url'] = $day['url'];
		}
		return $result;
	}	
}
