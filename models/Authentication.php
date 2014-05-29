<?php

Class Authentication{

	/**
	 * Hashing passwords.
	 * @param  string $password The password to be hashed.
	 * @return array 			Hashed password and salt string.           
	 */
	public function createHash($password){

		// create random salt of 22 chararacters
		$salt = substr(sha1(mt_rand()),0,22); 

		//create hash of password, $2y sets the hashing to blowfish, $10$ is the time cost in base 2. 
		//if we use 10 it's equal to 2^10 or 1024 iterations.
		$hashedPassword = crypt($password, '$2y$10$' . $salt);

		//place hashed password in array with the generated salt
		$hashedValues = array(
			'salt' 			=> $salt,
			'password' 		=> $hashedPassword
			); 

		return $hashedValues;
	}

	/**
	 * Authenticate user by comparing the stored password hash with entered password hash.
	 * @param  string $inputPass  The user provided password.
	 * @param  string $dbHash     The hashed database password.
	 * @param  string $dbSalt     The salted string used in the creation of the hashed password.
	 * @return boolean            Matching password, true or false.
	 */
	public function authenticate($inputPass, $dbHash, $dbSalt){

		$inputHash = crypt($inputPass, '$2y$10$' . $dbSalt);

		return $inputHash == $dbHash ? true : false;
	}
}