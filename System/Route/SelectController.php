<?php 
namespace System\Route;

/*
|--------------------------------------------------------------------------
| SelectController 
|--------------------------------------------------------------------------
| This class is used to call the controller and method according 
| the route passed on browser.
|
*/

use System\Request\Request;

class SelectController 
{
	private $controller;
	private $method;
	private $getRoute;
	private $allRouters = [];
	private $routerAliases;

	private $atual;

    /**
    * The construc method receive the getRoute instance.
    * @param getRoute Object
    */
	public function __construct(GetRoute $getRoute)
	{
		$this->getRoute = $getRoute;
		$this->controller = $getRoute->getControllerName();
		$this->method = $getRoute->getMethodName();
		$this->routerAliases = $this->getRoute->getControllerNameAliases().'/'.$this->getRoute->getMethodNameAliases(); 
	}

	public function create(string $aliases, string $controllerAndMethod)
	{
		$arrayExplode = explode('@', $controllerAndMethod);

		$this->allRouters[$aliases] = [
			'controller' => $arrayExplode[0],
			'method' => $arrayExplode[1]
		];
	}
    
    /**
    * The method is used to instantiate the controller
    * @param controller 
    * @param method String the method name
    * @return method
    */
	public function instantiateController(string $controller, string $method)
	{
		# Verifying if exist the character \\ in Controller name
		if (strstr($controller,'\\')) {
			$stringToArray = explode('\\', $controller);
			$controllerName = end($stringToArray);
			$controllerNameWithfullNamespace = implode("\\", array_values($stringToArray));
			$controller = "App\Controllers\\".$controllerNameWithfullNamespace;
			
		} else {
			$controllerName = $controller;
			$controller = "App\Controllers\\".$controller;
		}

		# Instanciate the Controller
        $controller = new $controller;

        # Call the Controller Method
        return $controller->{$method}();
	} 

	public function run()
	{
        if (array_key_exists("{$this->routerAliases}", $this->allRouters)) {
    		$this->instantiateController(
    			$this->allRouters["{$this->routerAliases}"]['controller'],
    			$this->allRouters["{$this->routerAliases}"]['method']
    		);
        } else {
        	require_once('App/Views/Layouts/404.php');
        }
	}
}