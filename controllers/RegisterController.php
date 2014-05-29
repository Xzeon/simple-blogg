<?php

Class RegisterController {
	private $dbGateway;
	private $view;
	private $inputHandler;
	private $inputValidation;
	private $auth;

	public function __construct($dbGateway, $view, $inputHandler, $inputValidation, $authentication){
		$this->view = $view;
		$this->dbGateway = $dbGateway;
		$this->inputHandler = $inputHandler;
		$this->inputValidation = $inputValidation;
		$this->auth = $authentication;
	}


	/**
	 * Starts the controller for handling the registration of
	 * an admin account. If registration is sucessfull the user 
	 * is redirected to login page.
	 */
	public function start(){
		if ($this->inputHandler->submittedFormCheck()){

			$this->setReqFields();
			
			if ($this->isValid()) {
				$input = $this->inputHandler->getRegistration();
				$hashValues = $this->auth->createHash($input['password']);

				$bindings = $this->merge($input, $hashValues);
				
				if ($this->dbGateway->insert('users', $bindings)){
					$this->setBloggName();
					header("Location:" . $_SERVER['REQUEST_URI']);
				}

			} else {
				$error = $this->inputValidation->getErrors();
			} 
		}
		$this->view->render("RegisterView", isset($error) ? $error : null);
	}

	/**
	 * Merges regular input with hashed password and salt.
	 * @param  array  $input      Input from registration form
	 * @param  array  $hashValues Hashed password and salt
	 * @return array      
	 */
	private function merge($input, $hashValues){
		$input['password'] = $hashValues['password']; 
		$input['salt'] = $hashValues['salt']; 
		return $input;
	}

	/**
	 * Simple holder for a class->method call:
	 * inputValidation->setRequiredFields. Increases readablity in the calling method.
	 */
	private function setReqFields(){
		$this->inputValidation->setRequiredFields(
			array('username', 'firstname', 'lastname', 'email', 'email_repeat', 'password', 'password_repeat'));
	}

	private function setBloggName(){
		if(!$this->dbGateway->get('bloggconfig')){
			$this->dbGateway->insert('bloggconfig', array('title' => 'Min blogg'));
		}
	}

	/**
	 * Acts as a simple holder for validation checks.
	 * If all validation checks are passed, method returns true, else false. 
	 * @return boolean
	 */
	private function isValid(){

		if (!$this->inputValidation->validateRequiredFields('Du behöver fylla i alla nedanstående fält.')){ return false; }	
		if (!$this->inputValidation->regexValidation('/^[A-Za-z][A-Za-z0-9_]{3,30}$/', 'username', 'Användarnamnet är ogiltigt! (a-z, A-Z, 0-9, minst 4-30 tecken)')){ return false; }
		if (!$this->inputValidation->regexValidation('/^[A-Za-zåäöÅÄÖ]{1,30}$/', 'firstname', 'Förnamn är ogiltigt! (a-ö, A-Ö, minst 2 tecken)')){ return false; }
		if (!$this->inputValidation->regexValidation('/^[A-Za-zåäöÅÄÖ]{1,30}$/', 'lastname', 'Efternamn är ogiltigt! (a-ö, A-Ö, 2-30 tecken)')){ return false; }
		if (!$this->inputValidation->validateEmail('Inskriven e-post är ogiltig.')){ return false; }
		if (!$this->inputValidation->validateRepeat('email', 'email_repeat', 'E-post matchar inte.')){ return false; }
		if (!$this->inputValidation->validateLength('password', 4, 'Lösenord måste vara minst 4 tecken långt.')){ return false; }
		if (!$this->inputValidation->validateRepeat('password', 'password_repeat', 'Lösenord matchar inte.')){ return false; }

		return true;		
	}
}