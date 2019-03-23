<?php

namespace back\Controllers;

use back\Auth;

class IndexController extends Controller{
	
	public function getIndex(){
		if(!Auth::check())
			$this->responseHtml('notauth');
			
		if(Auth::user()->status === 1){
			$this->responseHtml('index');
		}else{
			$this->responseHtml('denied');
		}
	}
}
