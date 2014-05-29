<?php

Class InputValidation{
	private $requiredFields;
	private $validationErrors;

	/**
	 * Set required fieldnames for POST input.
	 * @param  array $req The fieldnames that are required.
	 * @return void 
	 */
	public function setRequiredFields(Array $req){
		$this->requiredFields = $req;
	}

	/**
	 * Checks whether or not two formfields are equal.
	 * @param  string $field1   First field for comparison.
	 * @param  string $field2   Second field for comparison.
	 * @param  string $message  Error message if not $field1 == $field2.
	 * @return boolean.
	 */
	public function validateRepeat($field1, $field2, $message){
		try {
			if ($_POST[$field1] != $_POST[$field2]){
				throw new Exception($message); 	
			}
		} catch (Exception $e){
			$this->validationErrors = $e->getMessage();
			return false;
		}
		return true;
	}

	/**
	 * Checks wheter or not all the required fields are filled out
	 * @param  string $message Error message if not filled out.
	 * @return boolean.          
	 */
	public function validateRequiredFields($message){
		$check;

		try {
			foreach ($this->requiredFields as $value) {
				// Loopen testar varje obligatiskt fält ($required), att de är satta och ej tomma , resultatet sparas i arrayn $check.
				isset($_POST[$value]) && !empty($_POST[$value]) ? $check[] = true : $check[] = false;	
			} 

			if (in_array(false, $check)) {
				throw new Exception($message); 
			}

		} catch (Exception $e) {
			$this->validationErrors = $e->getMessage();
			return false;
		}
		return true;
	}

	/**
	 * Checks wheter or not provided email is valid.
	 * @param  string  $message Error message if not valid email.
	 * @return boolean
	 */
	public function validateEmail($message){
		try {
			
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				throw new Exception($message); 		
			}	

		} catch (Exception $e) {
			$this->validationErrors = $e->getMessage();
			return false;
		}
		return true;
	}	

	/**
	 * Checks whether or not submitted formfield is above a minimum stringlength.
	 * @param  string $field   Formfield to be checked.
	 * @param  int    $length  Minimum length.
	 * @param  string $message Error message if length is above minimum.
	 * @return boolean.
	 */
	public function validateLength($field, $length, $message){
		try {
			
			if (strlen(trim($_POST[$field])) <  $length) {
				throw new Exception($message);
			}

		} catch (Exception $e) {
			$this->validationErrors = $e->getMessage();
			return false;
		}
		return true;
	}

	// public function validateName($field, $message){
	// 	try {
			
	// 		$regex = array(
	// 			'username' 		=>	'/^[A-Za-z][A-Za-z0-9_]{3,30}$/',
	// 			'firstname' 	=>	'/^[A-Za-zåäöÅÄÖ]{2,30}$/',
	// 			'lastname'		=>	'/^[A-Za-zåäöÅÄÖ]{2,30}$/');

	// 		if (!preg_match($regex[$field], $_POST[$field])){
	// 			throw new Exception($message); 	
	// 		}	
	// 	} catch (Exception $e) {
	// 		$this->validationErrors = $e->getMessage();
	// 		return false;
	// 	}
	// 	return true;
	// }

	/**
	 * Match a formfield against a regular expression.
	 * @param  string $regex   	The regular expression to match against.
	 * @param  string $field   	The field to be checked.
	 * @param  string $message 	Error message if mismatch.
	 * @return boolean
	 */
	public function regexValidation($regex, $field, $message){
		try {
			if (!preg_match($regex, $_POST[$field])){
				throw new Exception($message); 	
			}	
		} catch (Exception $e) {
			$this->validationErrors = $e->getMessage();
			return false;
		}
		return true;
	}

	/**
	 * Get validation error.
	 * @return string
	 */
	public function getErrors(){
		return $this->validationErrors;
	}			
}