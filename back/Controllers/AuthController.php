<?php

namespace back\Controllers;

use back\Models\User;
use back\Auth;

class AuthController extends Controller{
	
	public function getLogin(){
		if(Auth::check())
			$this->redirect('/');
		
		$this->responseHtml('auth');
	}
	
	public function postLogin($request){
		$this->validate([
			'name'=>'requried',
			'email'=>'requried|email',
		], $request->all());

		$user = User::where('name', '=', $request->get('name'))->where('email', '=', $request->get('email'))->first();
		if($user){
			Auth::login($user->id);
			$this->responseJson(['result'=>'success']);
		}else{
			$this->responseJson(['result'=>'error', 'errors'=>['Не верный логин/пароль']], 422);
		}

	}
	
	public function getRegister(){
		if(Auth::check())
			$this->redirect('/');
		
		$this->responseHtml('register');
	}
	
	public function postRegister($request){
		$this->validate([
			'name'=>'requried',
			'email'=>'requried|email',
			'date'=>'requried|date|age:18',
			'phone'=>'requried|phone'
		], $request->all());
		
		$request->cleanSpacing('phone');
		User::create($request->all() + ['status'=>rand(0,1)]);
		$this->responseJson(['result'=>'success']);
	}
	
	public function postLogout(){
		Auth::logout();
		$this->redirect('/auth/login');
	}
}
