<?php

namespace back;


class Request{
	
	private $method;
	private $data;
	private $route;
	
	public static function initFromGlobal(){
		return new Request(
			$_GET['route'],
			$_SERVER['REQUEST_METHOD'],
			$_POST
		);
	}
	
	function __construct($route, $method, $data){
		$this->route = $route;
		$this->method = $method;
		$this->data = $data;
	}
	
	public function getRoute(){
		return $this->route;
	}
	
	public function getMethod(){
		return $this->method;
	}
	
	public function all(){
		return $this->data;
	}
	
	public function clean(){
		foreach($this->data as &$val){
			$value = trim($val);
			$value = stripslashes($val);
			$value = strip_tags($val);
			$value = htmlspecialchars($val);
		}
		return $this;
	}
	
	public function cleanSpacing($field){
		$this->data[$field] = str_replace(' ', '', $this->data[$field]);
		return $this;
	}
	
	public function get($field){
		return $this->data[$field];
	}
	
}
