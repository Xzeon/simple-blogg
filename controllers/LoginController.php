<?php 

Class LoginController {
	private $dbGateway;
	private $view;
	private $inputHandler;
	private $inputValidation;
	private $auth;

	public function __construct($dbGateway, $view, $inputHandler, $inputValidation, $authentication){
		$this->dbGateway = $dbGateway;
	 	$this->view = $view;
		$this->inputHandler = $inputHandler;
		$this->inputValidation = $inputValidation;
		$this->auth = $authentication;
	}
	
	/**
	 * Starts the controller for handling login/logout process.
	 *
	 * If logout form button has been pressed the session is destroyed
	 * and user is redirected to root ('/').
	 *
	 * Checks login credentials against database if theres match the user
	 * is redirect to bloggpost creation page. Else the is presented with
	 * an error message;
	 * 
	 * @return void
	 */
	public function start(){
		
		$this->logoutCheck();

		$data['bloggconfig'] = $this->dbGateway->get('bloggconfig');
		if (!$this->authenticate()){
			$data['error'] = "Fel användarnamn eller lösenord";
	 		$this->view->render('LoginView', $data);
	 	}else{
	 		header('Location:' . '/admin/create');
	 	}
	}

	/**
	 * Authenticate provided login credentials.
	 * @return boolean
	 */
	private function authenticate(){
		$input = $this->inputHandler->getLogin();
		$admin = $this->dbGateway->get('users', 'username', $input['login_username']);

		if($this->auth->authenticate($input['login_password'], $admin[0]['password'], $admin[0]['salt'])){
	 		session_regenerate_id();
	 		$this->setSessionVariables($admin);
	 		return true;
		}
		return false;
	}

	/**
	 * Saves all admin-user values to $_SESSION;
	 * @param  array $admin The admin-user values from the database.
	 * @return void
	 * 
	 */
	private function setSessionVariables($admin){
		foreach ($admin[0] as $key => $value) {
			$_SESSION[$key] = $value;
		}
	}

	/**
	 * Check if admin-user is logging out, if so logout.
	 * @return void
	 */
	private function logoutCheck(){

		if(isset($_POST['logout'])){
			$_SESSION = array();
			session_destroy();
			header('Location:' . '/');
		}
	}
}