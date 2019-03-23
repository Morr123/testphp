<?php

namespace back\Models\DB\Providers;

class MySqlConnector implements ConnectorInterface{
	
	public $connect;
	
	function __construct($dbhost, $dbuser, $dbpass, $db){
		$this->connect = new \mysqli($dbhost, $dbuser, $dbpass, $db) or $this->error();
	}
	
	public function execute($sql, $binding = []){
	
		if(count($binding) > 0){
		
			if(!$smtp = $this->connect->prepare($sql)){
				$this->viewError();
			}
			
			$bindType = '';
			foreach($binding as $val){
				switch(gettype($val)){
					case 'integer': $bindType .= 'i'; break;
					case 'double': $bindType .= 'd'; break;
					case 'string': $bindType .= 's'; break;
					default:
						$bindType .= 's';
				}
			}
			
			array_unshift($binding, $bindType);

			if(!$smtp->bind_param(...$binding)){
				throw new \Exception('Error binding');
			}
			if(!$smtp->execute()){
				$this->error();
			}
			$result = $smtp->get_result();

			if(is_bool($result)){
				return $result;
			}else{
				//var_dump($result->fetch_array(MYSQLI_ASSOC));
				return $result->fetch_array(MYSQLI_ASSOC);
			}
		
		}else{
			if(!$this->connect->query($sql))
				$this->error();
		}
	}
	
	private function error(){
		throw new \Exception('Sql error:' . mysqli_error($this->connect));
	}
}
