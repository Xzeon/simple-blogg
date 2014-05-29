<?php 

Class SetupController {
	private $dbGateway;
	private $inputHandler;
	private $inputValidation;
	private $view;

	public function __construct($dbGateway, $view, $inputHandler, $inputValidation){
		$this->dbGateway = $dbGateway;
		$this->view = $view;
		$this->inputHandler = $inputHandler;
		$this->inputValidation = $inputValidation;
	}

	/**
	 * Starts the controller for handling the database configuration.
	 *
	 * If a connection to a database has been made with the provided information  
	 * the page will refresh and the FrontController takes over to handle where 
	 * to redirect the user from there.
	 */
	public function start(){
		if ($this->inputHandler->submittedFormCheck()){
			
			$values = $this->inputHandler->getSetup();
			$this->dbGateway->configure($values['dbname'], $values['dbuser'], $values['dbpass']);

			if ($this->dbGateway->isConnected()){
				header('Location:' . $_SERVER['REQUEST_URI']);
			}else{
				$this->view->render('SetupView', 'Uppkopplingen till databasen misslyckades! <br> Har ni skrivit in rätt uppgifter?');
			}
			
		}else{
			$this->view->render('SetupView');	
		}
	}
}