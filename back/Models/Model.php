<?php

namespace back\Models;

use back\Models\DB\DB;
use back\Models\DB\Builder;

abstract class Model{
	
	protected static $tableName;
	protected static $fillable;
	protected $builder = false;
	
	public static function __callStatic($name, $arguments){
		$instance = new static();
		$instance->builder = new Builder(static::$tableName);
		$instance->builder->{$name}(...$arguments);
		return $instance->builder;
	}
	
	public static function create($arr){
		$arr = array_intersect_key($arr, array_flip(static::$fillable));
		$keys = array_keys($arr);
		$fields = implode(', ', $keys);
		$str = '';
		foreach($keys as $key => $val){
			$str .= "?";
			if(count($keys)-1 !== $key){
				$str .= ', ';
			}		
		}
		
		DB::execute('INSERT INTO ' . static::$tableName . ' ('.$fields.') VALUES ('.$str.')', array_values($arr));
	}
}
