<?php

class FrontController {
	private $dbGateway;
	private $view;
	private $route;

	public function __construct($dbGateway, $view, $route){
		$this->dbGateway = $dbGateway;
		$this->view = $view;
		$this->route = $route;
	}
	
	/**
	 * Every request goes through this controller, loads other 
	 * controllers depending on conditions.
	 *
	 * If there is NO connection to a database then load the 
	 * SetupController to configure a new database connection.
	 * 
	 * If no admin account has been created, load the 
	 * RegisterController to create an admin account.
	 *
	 * If uri is not set, user is on root adress, then load
	 * PostController, else load controller that is registered on
	 * the current adress, if it fails render 404 view.
	 * 
	 * @return void
	 */
	public function start(){
	
		if (!$this->dbGateway->isConnected()){
			$controller = IoC::resolve('SetupController');
			$controller->start();
			return;
		}

		if (!$this->adminExist()){
			$controller = IoC::resolve('RegisterController');
			$controller->start();
			return;
		}

		if(!isset($_GET['uri'])){
			$controller = IoC::resolve('PostController');
			$controller->start();
		}else{	
			try {
				$controller = IoC::resolve($this->route->getController());
				$controller->start();	
			} catch (Exception $e) {
				$this->view->render('404View');
			}
		}
	}

	/**
	 * Check if there is any information in the user table.
	 * @return mixed 
	 */
	private function adminExist(){
		return $this->dbGateway->get('users');
	}
}