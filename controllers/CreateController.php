<?php 

Class CreateController{
	private $dbGateway;
	private $view;
	private $inputValidation;
	private $inputFiltering;
	private $inputHandler;

	public function __construct($dbGateway, $view, $inputHandler, $inputValidation, $inputFiltering){
		$this->dbGateway = $dbGateway;
		$this->view = $view;
		$this->inputHandler = $inputHandler;
		$this->inputValidation = $inputValidation;
		$this->inputFiltering = $inputFiltering;
	}

	/**
	 * Starts the controller for handling the creation of new 
	 * bloggposts, requires the admin-user to be logged in.
	 * 
	 * Handles the flow by calling different classmethods for
	 * getting, setting, validating and manipulating data. When 
	 * the data is ready it is sent to the view for rendering.
	 * 
	 * @return void
	 */
	public function start(){
		if(isset($_SESSION['username'])){

			// bloggconfig
			$data['bloggconfig'] = $this->dbGateway->get('bloggconfig');


			if($this->inputHandler->submittedFormCheck()){

				$this->inputValidation->setRequiredFields(array('header', 'body'));

				if($this->isValid()){
					$input = $this->filter($this->inputHandler->getPost());
					
					if($this->dbGateway->insert('posts', $input)){
						header('Location:' . '/' );
					}else{
						$data['error'] = $this->dbGateway->getDatabaseErrors();
					}
					
				}else{
					$data['error'] = $this->inputValidation->getErrors();
				}
			}

			$this->view->render('CreateView', $data);
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

		if (!$this->inputValidation->validateRequiredFields('Du behöver fylla i alla nedanstående fält.')){ return false; }	
		if (!$this->inputValidation->regexValidation('/^[A-Za-zåäöÅÄÖ0-9\s]{2,255}$/', 'header', 'Rubriken innehåller otillåtna tecken.')){ return false; }

		return true;		
	}

	/**
	 * Acts as a simple holder for filters.
	 * All filters are applied then the result is returned.
	 * @return array
	 */
	private function filter($input){
		$input['uri'] = $this->inputFiltering->stringToUri($input['header']);
		$input['body'] = $this->inputFiltering->stripTags($input['body'], '<h3><h4><h5><p><em><strong><q><quote><img>');

		return $input;
	}
}

