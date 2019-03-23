<?php

namespace back;

use back\Models\User;

class Auth{
	
	private static $user;
	
	public static function login($id){
		$_SESSION['user'] = $id;
	}
	
	public static function check(){
		return isset($_SESSION['user']) ? true : false;
	}
	
	public static function user(){
		if(!isset(self::$user)){
			if(!isset($_SESSION['user'])){
				return null;
			}
			
			self::$user = User::where('id', '=', $_SESSION['user'])->first();
			return self::$user;
		}
		
		return self::$user;
	}
	
	public static function logout(){
		if(Auth::check()){
			unset($_SESSION['user']);
		}
	}
}
