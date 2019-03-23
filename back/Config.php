<?php

namespace back;


class Config{
	public static function get(){
		return [
			'db'=>[
				'connections'=>[
					'mysql'=>[
						'host'=>'localhost',
						'username'=>'root',
						'password'=>'',
						'db'=>'testphp1',
						'provider'=>'mysql'
					]
				]
			]	
		];
	}
}
