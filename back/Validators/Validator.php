<?php

namespace back\Validators;

class Validator{
	
	use Rules;
	
	public static $messages = [
		'requried' => 'Поле обязательно для заполнения',
		'email' => 'Введите корректный email',
		'phone' => 'Не верный формат номера телефона',
		'date'	=> 'Не корректный формат даты',
		'age'	=> 'Не верный возраст',
	];
	
	public static function init(array $rules, $array){
		return new Validator($rules, $array);
	}
	
	
	private $rules;
	private $data;
	private $error = [];
	
	function __construct(array $rules, $array){
		$this->rules = $rules;
		$this->data = $array;
	}
	
	public function check(){
		$error = [];
		foreach($this->rules as $key => $value){
			$rules = explode('|', $value);
			foreach($rules as $rule){
				if(strpos($rule, ':') !== false){
					list($rLeft, $rRight) = explode(':', $rule);
					$method = $rLeft;
					$args = explode(',', $rRight);
					array_unshift($args, $this->data[$key]);
					$result = $this->{$method}(...$args);
				}else{
					$method = $rule;
					$result = $this->{$rule}($this->data[$key]);
				}
				
				if(!$result){
					$error[$key] ? array_push($error[$key], self::$messages[$method]) : $error[$key] = [self::$messages[$method]];
				}
			}
		}
		

		if(count($error) > 0){
			$this->error = $error;
			return false;
		}else{
			return true;
		}
	}
	
	public function getError(){
		return $this->error;
	}
	
}
