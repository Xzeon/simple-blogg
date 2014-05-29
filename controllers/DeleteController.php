<?php 

Class DeleteController {

	public function __construct($dbGateway){
		$this->dbGateway = $dbGateway;
	}

	/**
	 * Remove a bloggpost from database.
	 * @return void
	 */
	public function removePost(){
		$bindings = array(
			'id' => $_POST['remove_post']);

		if($this->dbGateway->remove('posts', $bindings)){
			header('Location:' . $_SERVER['REQUEST_URI']);
		}
	}

	/**
	 * Remove a comment from database.
	 * @return void
	 */
	public function removeComment(){
		$bindings = array(
			'id' => $_POST['remove_comment']);

		if($this->dbGateway->remove('comments', $bindings)){
			header('Location:' . $_SERVER['REQUEST_URI']);
		}
	}


}