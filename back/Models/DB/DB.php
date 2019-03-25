<?php

namespace back\Models\DB;

use back\Models\DB\Providers\MySqlConnector;
use back\Config;

class DB{
	
	private static $defaultConnect = 'mysql';
	
	private static $connects = [];
	
	private static function connect($connector){
		if(!isset(self::$connects[$connector])){
			$configBd = Config::get()['db']['connections'][$connector];
			switch($configBd['provider']){
				case 'mysql':
					self::$connects[$connector] = new MySqlConnector($configBd['host'], 
																	 $configBd['username'], 
																	 $configBd['password'], 
																	 $configBd['db']);
					return self::$connects[$connector];
				default:
					throw new \Exception('Not found connect');
			}
		}
		
		return self::$connects[$connector];
	}
	
	public static function execute($sql, $binding = [], $connector = false){
		return self::connect($connector ? $connector : self::$defaultConnect)->execute($sql, $binding);
	}
}
