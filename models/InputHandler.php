<?php 

Class InputHandler {

	/**
	 * Get submitted POST input for login information.
	 * Empty values are represented as 'empty', temporary fix for a bug.  
	 * @return array 
	 */
	public function getLogin(){
		$values;
		if(isset($_POST['login_submit']) && $_POST['login_submit']){
			foreach ($_POST as $key => $value) {
				$values[$key] = trim($value); 
			}

			unset($values['login_submit']);
			return $values;
		}
	}
	
	/**
	 * Get submitted POST input for adding a comment.
	 * @return array
	 */
	public function getComments(){
		$values;
		if(isset($_POST['comment_submit']) && $_POST['comment_submit']){
			foreach ($_POST as $key => $value) {
				$values[$key] = $value;
			}

			unset($values['comment_submit']);
			return $values;
		}
	}

	/**
	 * Get submitted POST input for configuration changes.
	 * @return array 
	 */
	public function getConfig(){
		$values;
		if(isset($_POST['config_submit']) && $_POST['config_submit']){
			foreach ($_POST as $key => $value) {
				$values[$key] = $value;
			}

			unset($values['config_submit']);
			return $values;
		}
	}

	/**
	 * Get submitted POST input for bloggpost creation.
	 * @return array
	 */
	public function getPost(){
		$values;
		if(isset($_POST['blogg_post_submit']) && $_POST['blogg_post_submit']){
			foreach ($_POST as $key => $value) {
					$values[$key] = $value;
			}
	
			$values['author'] = $_SESSION['id'];

			unset($values['blogg_post_submit']);
			return $values;
		}
	}

	/**
	 * Get submitted POST input for updating a bloggpost.
	 * @return array
	 */
	public function getUpdate(){
		$values;
		if(isset($_POST['edit_id']) && $_POST['edit_id']){
			foreach ($_POST as $key => $value) {
				$values[$key] = $value;
			}
	
			$values['author'] = $_SESSION['id'];
			return $values;
		}
	}

	/**
	 * Get submitted POST input for setting up a database connection.
	 * Empty values are represented as 'empty', a temporary fix for a bug. 
	 * @return array
	 */
	public function getSetup(){
		$values;
		if(isset($_POST['setup_submit']) && $_POST['setup_submit']){
			foreach ($_POST as $key => $value) {
				$values[$key] = trim($value); 
			}

			unset($values['setup_submit']);
			return $values;
		}
	}

	/**
	 * Get submitted POST input for the registration of an admin account.
	 * @return array
	 */
	public function getRegistration(){
		$values;
		if(isset($_POST['register_submit']) && $_POST['register_submit']){
			foreach ($_POST as $key => $value) {
				$values[$key] = $value;
			}
			
			unset($values['register_submit']);
			unset($values['password_repeat']);
			unset($values['email_repeat']);

			return $values;
		}
	}
	/**
	 * Checks whether or not the request method is POST. 
	 * @return boolean
	 */
	public function submittedFormCheck(){
		return $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;
	}

}