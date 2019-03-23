<?php

namespace back\Models\DB;

use back\Models\DB\Providers\MySqlConnector;
use back\Config;

class DB{
	
	private static $defaultConnect = 'mysql';
	
	private static $connects = [];
	
	private static function connect($connector){
		$configBd = Config::get()['db']['connections'][$connector];
		if(!isset(self::$connects[$connector])){
			switch($configBd['provider']){
				case 'mysql':
					self::$connects[$connector] = new MySqlConnector($configBd['host'], 
																	 $configBd['username'], 
																	 $configBd['password'], 
																	 $configBd['db']);
					break;
				default:
					throw new \Exception('Not found connect');
			}
		}
	}
	
	public static function execute($sql, $binding = [], $connector = false){
		$connector = $connector ? $connector : self::$defaultConnect;
		self::connect($connector);
		return self::$connects[$connector]->execute($sql, $binding);
	}
}
