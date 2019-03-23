<?php

namespace back\Models\DB;

class Builder{
	
	private $methods = [
		'where' => [],
		'limit' => false
	];
	private $table;
		
	function __construct($table){
		$this->table = $table;
	}
	
	
	public function where($field, $condition, $value){
		array_push($this->methods['where'], [$field, $condition, $value]);
		return $this;
	}
	
	public function limit($limit){
		$this->methods['limit'] = $limit;
		return $this;
	}
	
	public function first(){
		$this->limit(1);
		$sql = 'SELECT * FROM '.$this->table . ' ';
		$binding = [];
		$initWhere = 0;
		foreach($this->methods as $method => $params){
			switch($method){
				case 'where':
					foreach($params as $valParam){
						$sql .= !$initWhere ? ' WHERE ' : ' AND ';
						$sql .= $valParam[0] . ' ' . $valParam[1] . ' ?';
						array_push($binding, $valParam[2]);
						$initWhere = 1;
					}
					break;
				case 'limit':
					$sql .= ' LIMIT ?';
					array_push($binding, $params);
					break;
				default:
					throw new \Exception('Метод не найден');
			}
			
		}
		
		$row = DB::execute($sql, $binding);
		if(count($row) === 0)
			return null;
		else
			return (object) $row;
	}
}
