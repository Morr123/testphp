<?php

namespace back\Validators;

trait Rules{
	
	private function requried($field){
		return ($field || $field !== '') ?? false;
	}
	
	private function email($field){
		return filter_var($field, FILTER_VALIDATE_EMAIL);
	}
	
	private function regex($field, $regex){
		return preg_match($regex, $field);
	}
	
	private function phone($field){
		return $this->regex($field, '/8 [0-9]{3} [0-9]{3} [0-9]{4}/');
	}
	
	private function date($field){
		$date = \DateTime::createFromFormat('Y-m-d', $field);
		return $date ? true : false;
	}
	
	private function age($field, $max){
		$date1 = \DateTime::createFromFormat('Y-m-d', $field);
		if($date1){
			$date2 = new \DateTime(date('Y-m-d'));
			$interval = $date1->diff($date2);
			return $interval->y >= $max ? true : false;
		}
		return false;
	}
}
