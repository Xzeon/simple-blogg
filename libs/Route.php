<?php

class Route{	
	private $routes;
	private $uri;
	private $controller;
	private $dbGateway;

	public function __construct($dbGateway){
		$this->dbGateway = $dbGateway;

		$this->addRoute('/', 'FrontController');
		$this->addRoute('/login', 'LoginController');
		$this->addRoute('/admin/create', 'CreateController');
		$this->addRoute('/admin/edit', 'EditController');
		$this->addRoute('/admin/config', 'ConfigController');

		if($this->dbGateway->isConnected()){
			$this->addSQLRoutes();
		}
		
		$this->setControllers();
	}

	/**
	 * Gets the URI for each post and assigns a controller for 
	 * handling request for that URI.
	 * @return void.
	 */
	public function addSQLRoutes(){
		$posts = $this->dbGateway->get('posts');
		
		if($posts){
			foreach ($posts as $post) {
				$this->addRoute('/' . $post['uri'], 'SinglePostController');
			}	
		}
		
	}

	/**
	 * Maps URI to Controller.
	 * @param String $uri 			URI (web address).
	 * @param String $controller 	Controller to handle the URI.
	 * @return Array 				Array of URI => Controller.				
	 */
	public function addRoute($uri, $controller){
		$ref = array();
		$ref[$uri] = $controller;
		$ref[$uri . '/'] = $controller;

		return $this->routes[] = $ref;

	}

	/**
	 * Loops through array of URI => Controller to find as match 
	 * for the current URI.
	 * @return String 	The Controller for the current URI. 
	 */
	public function setControllers(){
		$this->uri = isset($_GET["uri"]) ? "/" . $_GET["uri"] : "/";	
		
		foreach ($this->routes as $route) {

			if (array_key_exists($this->uri, $route)){
				return $this->controller = current($route);
			}	
		}	
	}
	
	/**
	 * Fetches the Controller matching the current URI.
	 * @return String 	The name of the controler
	 */
	public function getController(){
		return $this->controller;
	}
}