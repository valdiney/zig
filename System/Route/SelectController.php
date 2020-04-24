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
	private $fullRoute;
	private $controller;
	private $method;
	private $getRoute;

	private $objectController;
    
    /**
    * The construc method receive the getRoute instance.
    * @param getRoute Object
    */
	public function __construct(GetRoute $getRoute)
	{
		$this->getRoute = $getRoute;
		$this->controller = $getRoute->getControllerName();
		$this->method = $getRoute->getMethodName();
		$this->fullRoute = "{$this->controller}/{$this->method}";
	}
    
    /**
    * The method is used to invoke the controller method that will be passed like argument
    * and is compared with the method name on  url.
    * @param controller Object
    * @param method String the method name
    * @param variablesName Array the variables name
    * @return Void
    */
	public function route($controller, String $method, $rules = false)
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

		# Verifying if the method of url is the same of the past like parameter.
		if ($this->method === $method) {
            try {
            	$getRouteControllerName = $this->getRoute->getControllerName();
            	$getRouteMethodName = $this->getRoute->getMethodName();
                
                # Veryfing if the Object and Methoad is the same of from the url
            	if ($getRouteControllerName == $controllerName && $getRouteMethodName  == $method) {
                    
                    # Validate the Rules
					if ($rules) {
						$rules->validate();
					}
                    
                    # Instanciate the Controller
            		$controller = new $controller;

                    # Call the Controller Method
            		return $controller->{$method}();

            	    # Cleaning the object from memory
            	    unset($controller);
            	}
            	
            } catch(\Exception $e) { 
            	var_dump($e->getMessage());
    	    }
		}
	} 
	
	/**
	* This method is used to show the first controller of the application
	* @param controller Object
	* @param method String the method name
	* @return Object controller
	*/
	public function index($controller, String $method)
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

		if ( ! $this->getRoute->existControllerOnRoute) {

			$controller = new $controller;
		    $controller->{$method}();

			$firstNameOfTheController = explode('Controller', $controllerName)[0];

			$route = $this->getRoute->getBaseUrl()."/{$firstNameOfTheController}/{$method}";
			return $this->route($controllerName, $controllerName, $method);
			header("Location:{$route}");
		} 
        
		return $this->route($controllerName, $method, false);
	}
}