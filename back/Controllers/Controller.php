<?php

namespace back\Controllers;

use back\Validators\Validator;

abstract class Controller{
	
	protected function getPathToView(){
		return $_SERVER['DOCUMENT_ROOT'] . '/../front/';
	}
	
	
	public function responseHtml(string $filename){
		readfile($this->getPathToView().$filename.'.html');
		die();
	}
	
	public function responseJson(array $json, $status = 200){
		$json = json_encode($json);
		http_response_code($status);
		header('Content-Type: application/json');
		echo $json;
		die();
	}
	
	public function validate($rules, $data){
		$validate = Validator::init($rules, $data);
		if(!$validate->check()){
			$this->responseJson(['result'=>'error', 'errors'=>$validate->getError()], 422);
		}
	}
	
	public function redirect($url){
		header('Location: '.$url);
		die();
	}
}
