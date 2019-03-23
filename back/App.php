<?php

namespace back;

class App{
	
	private $target;
	private $method;
	private $request;
	
	function __construct(Request $request){
		$this->request = $request;
		if($request->getRoute()){
			$route = explode('/', $request->getRoute());
			$this->target = $route[0];
			$this->method = $route[1] ?? 'index';
		}else{
			$this->target = 'index';
			$this->method = 'index';
		}
	}
	
	public function start(){
		try{
			$controller = $this->getContollerName();
			if(!class_exists($controller))
				throw new \Exception('Контроллер: '.$nameContoller . ' не найден');
			
			
			$controller = new $controller();
			
			$method = $this->getMethodName();
			if(!method_exists($controller, $method))
				throw new \Exception('Метод: '.$method . ' не найден');
			
			$this->request->clean();
			$controller->{$method}($this->request);
		}catch(\Exception $ex){
			http_response_code(500);
			echo $ex->getMessage();
			echo $ex->getTraceAsString();
			die();
		}
	}
	
	
	private function getMethodName()
    {
		return strtolower($this->request->getMethod()) . ucfirst($this->method);
	}
	
	private function getContollerName(){
		$nameContoller = mb_convert_case($this->target, MB_CASE_TITLE, "UTF-8");
		return __NAMESPACE__ . '\Controllers\\'.$nameContoller.'Controller';
	}
}
