<?php

Class SinglePostController {
	private $dbGateway;
	private $view;
	private $inputHandler;
	private $inputValidation;
	private $inputFiltering;
	private $outputFiltering;

	public function __construct($dbGateway, $view, $inputHandler, $inputValidation, $inputFiltering, $outputFiltering){
		$this->dbGateway = $dbGateway;
		$this->view = $view;
		$this->inputValidation = $inputValidation;
		$this->inputHandler = $inputHandler;
		$this->inputFiltering = $inputFiltering;
		$this->outputFiltering = $outputFiltering;
	}

	/**
	 * Starts the controller for handling single blogg posts.
	 * 
	 * Handles the flow by calling different classmethods for
	 * getting, setting, validating and manipulating data. 
	 * When the data is ready it is sent to the view for rendering.
	 * 
	 * @return void.
	 */
	public function start(){
		
		//bloggconfig
		$data['bloggconfig'] = $this->dbGateway->get('bloggconfig');

		// posts
		if($data['posts'] = $this->dbGateway->get('posts', 'uri', $_GET['uri'])){
			$data['posts'] = $this->outputFiltering->dateFormat('Y-m-d', $data['posts'], 'post_timestamp');
			$data['posts'] = $this->outputFiltering->nl2p($data['posts'], 'body');
		}
		
		//comments
		 if($data['comments'] = $this->dbGateway->get('comments', 'belongs_to', $data['posts'][0]['id'])){
		 	$data['comments'] = $this->outputFiltering->nl2p($data['comments'], 'body');
		 	$data['comments'] = $this->outputFiltering->dateFormat('Y-m-d', $data['comments'], 'comment_timestamp');
		 }

		if($this->removeCheck()){
			$controller = IoC::resolve('DeleteController');
			$controller->removeComment();
		}
			

		if($this->inputHandler->submittedFormCheck()){
			$this->inputValidation->setRequiredFields(array('author', 'body'));

			if($this->isValid()){
				$input = $this->filter($this->inputHandler->getComments());
				$input['belongs_to'] = $data['posts'][0]['id'];

				
				if($this->dbGateway->insert('comments', $input)){
					header('Location:' . $_SERVER['REQUEST_URI']);
				}

			}else{
				$data['error'] = $this->inputValidation->getErrors();
			}
		}

		$this->view->render('SinglePostView', $data);
	}

	/**
	 * Checks if comment is to be removed by listening to form input.
	 * @return boolean.
	 */
	private function removeCheck(){
		if(isset($_POST['remove_comment'], $_SESSION['username'])){
			return true; 
		}
		return false;
	}

	/**
	 * Acts as a simple holder for validation checks.
	 * If all validation checks are passed, method returns true, else false. 
	 * @return boolean.
	 */
	private function isValid(){

		if (!$this->inputValidation->validateRequiredFields('Du måste i fylla både namn och kommentar.')){ return false; }	
		if (!$this->inputValidation->regexValidation('/^[A-Za-zåäöÅÄÖ\s]{2,64}$/', 'author', 'Namnet innehåller otillåtna tecken. (A-Ö, a-ö, 2-64 tecken)')){ return false; }

		return true;		
	}

	/**
	 * Acts as a simple holder for filters.
	 * All filters are applied then the result is returned.
	 * @return array.
	 */
	private function filter($input){
		$input['body'] = $this->inputFiltering->stripTags($input['body'], '<p><em><strong><q><quote>');
		return $input;
	}
}