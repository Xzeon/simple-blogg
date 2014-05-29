<?php

Class PostController {
	private $dbGateway;
	private $view;
	private $outputFiltering;

	public function __construct($dbGateway, $view, $outputFiltering){
		$this->dbGateway = $dbGateway;
		$this->view = $view;
		$this->outputFiltering = $outputFiltering;	
	}

	/**
	 * Starts the controller for handling bloggposts, requires 
	 * the admin-user to be logged in.
	 * 
	 * Handles the flow by calling different classmethods for
	 * getting, setting, validating and manipulating data. When 
	 * the data is ready it is sent to the view for rendering.
	 * 
	 * @return void
	 */
	public function start(){

		$data['bloggconfig'] = $this->dbGateway->get('bloggconfig');

		if($data['posts'] = $this->dbGateway->get('posts')){
			$data['posts'] = $this->outputFiltering->dateFormat('Y-m-d', $data['posts'], 'post_timestamp');
			$data['posts'] = $this->outputFiltering->nl2p($data['posts'], 'body');
			$data['posts'] = $this->outputFiltering->excerpt(1000, $data['posts'], 'body');	
		}
		
		if($this->removeCheck()){
			$controller = IoC::resolve('DeleteController');
			$controller->removePost();
		}

		$this->view->render('PostView', $data);
	}

	/**
	 * Check form input for bloggpost removal.
	 * @return boolean
	 */
	private function removeCheck(){
		if(isset($_POST['remove_post'], $_SESSION['username'])){
			return true; 
		}
		return false;
	}

}