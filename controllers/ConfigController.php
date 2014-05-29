<?php

Class ConfigController {
	private $dbGateway;
	private $view;
	private $inputHandler;
	private $inputValidation;
	private $inputFiltering;

	public function __construct($dbGateway, $view, $inputHandler, $inputValidation, $inputFiltering){
		$this->dbGateway = $dbGateway;
		$this->view = $view;
		$this->inputHandler = $inputHandler; 
		$this->inputValidation = $inputValidation;
		$this->inputFiltering = $inputFiltering;
	}

	/**
	 * Starts the controller for handling bloggconfiguration, 
	 * requires the admin-user to be logged in.
	 * 
	 * Handles the flow by calling different classmethods for
	 * getting, setting, validating and manipulating data. When 
	 * the data is ready it is sent to the view for rendering.
	 * 
	 * @return void
	 */
	public function start(){
		if(isset($_SESSION['username'])){

			$data = $this->dbGateway->get('bloggconfig');

			if($this->inputHandler->submittedFormCheck()){

				$this->inputValidation->setRequiredFields(array('title'));

				if($this->isValid()){
					$input = $this->inputHandler->getConfig();
					
					if($this->dbGateway->update('bloggconfig', $input, 'id', 1)){
						header('Location:' . $_SERVER['REQUEST_URI']);
					}
					
				}else{
					$data[] = $this->inputValidation->getErrors();
				}
			}

			$this->view->render('ConfigView', $data);
		}else{
			header('Location:' . '/');
		}
	}

	/**
	 * Acts as a simple holder for validation checks.
	 * If all validation checks are passed, method returns true, else false. 
	 * @return boolean
	 */
	private function isValid(){

		if (!$this->inputValidation->validateRequiredFields('Du behöver fylla i bloggtitel.')){ return false; }	
		if (!$this->inputValidation->regexValidation('/^[A-Za-zåäöÅÄÖ0-9\s]{2,255}$/', 'title', 'Bloggtitel innehåller otillåtna tecken.')){ return false; }

		return true;		
	}
}