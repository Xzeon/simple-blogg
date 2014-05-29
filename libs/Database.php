<?php

class Database{
		
		private $conn;
		private $errors;
		private $config;

		public function __construct(){
			$this->getConfig();
			if ($this->connect()){
				$this->createTable('users');
				$this->createTable('posts');
				$this->createTable('comments');	
				$this->createTable('bloggconfig');	
			}
		}
		/**
		 * Connects to a Database with PDO.
		 * @return bolean Connected or not.
		 */
		public function connect(){
			try {
				$this->conn = new PDO("mysql:host=localhost;dbname=" . 
					$this->config['database'],
					$this->config['username'],
					$this->config['password']);

				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				// Throw exception if database name is empty
				if ($this->config['database'] == ''){
					throw new Exception(" You need to provide name for the database", 1);
				}

				return true;
			} catch(Exception $e) {
				$this->errors['code'] = $e->getCode();
				$this->errors['message'] = $e->getMessage();
				// echo $e->getMessage();
				return false;
			}
		}

		/**
		 * Get the Database credentials from .ini file and store it in class attribute $config.
		 *
		 * IMPORTANT! Lock down the access to the file within .htaccess.
		 * 
		 * @return void.
		 */
		public function getConfig(){
			$this->config = parse_ini_file('config/database.ini');
		}

		/**
		 * Creates tables in the Database by referencing predefined SQL queries.
		 * Provide table names to match an array of different queries.
		 * @param  String $tablename Table to be created.
		 * @return bolean            Successfull creation or not.
		 */
		private function createTable($tablename){
			
			$query = array(

					"users" 		=> "CREATE TABLE IF NOT EXISTS users (
										id int(11) unsigned NOT NULL AUTO_INCREMENT,
										username varchar(64) DEFAULT NULL UNIQUE,
										email varchar(128) DEFAULT NULL UNIQUE,
										firstname varchar(128) DEFAULT NULL,
										lastname varchar(128) DEFAULT NULL,
										password varchar(255) DEFAULT NULL,
										salt varchar(32) DEFAULT NULL,
										PRIMARY KEY (id)) 
										ENGINE=InnoDB DEFAULT CHARSET=utf8;",

					"posts" 		=>	"CREATE TABLE IF NOT EXISTS posts (
	  									id int(11) unsigned NOT NULL AUTO_INCREMENT,
										header varchar(255) DEFAULT NULL UNIQUE,
										body text DEFAULT NULL,
										uri varchar(255) DEFAULT NULL,
										author int(11) unsigned NOT NULL,
										post_timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
										PRIMARY KEY (id),
										CONSTRAINT post_author FOREIGN KEY (author) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE)
										ENGINE=InnoDB DEFAULT CHARSET=utf8;",

					"comments"		=>	"CREATE TABLE IF NOT EXISTS comments (
										id int(11) unsigned NOT NULL AUTO_INCREMENT,
										author varchar(128) DEFAULT  NULL,
										body text DEFAULT NULL,
										belongs_to int(11) unsigned NOT NULL,
										comment_timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
										PRIMARY KEY (id),
										CONSTRAINT belongs_to_post FOREIGN KEY (belongs_to) REFERENCES posts (id) ON DELETE CASCADE ON UPDATE CASCADE) 
										ENGINE=InnoDB DEFAULT CHARSET=utf8;",

					"bloggconfig"	=>	"CREATE TABLE IF NOT EXISTS bloggconfig (
										id int(11) unsigned NOT NULL AUTO_INCREMENT,
										title varchar(128) DEFAULT  'Min Blogg',
										PRIMARY KEY (id))
										ENGINE=InnoDB DEFAULT CHARSET=utf8;"
					);
			
			try {
				$stmt = $this->conn->query($query[$tablename]);
				return true;
			} catch(Exception $e) {
				$this->errors['code'] = $e->getCode();
				$this->errors['message'] = $e->getMessage();
				// echo $e->getMessage();
				return false;
			}
		}

		/**
		 * Fetch data from Database with a provided query.
		 * @param  String $query The query to be executed.
		 * @return mixed        Returns database rows, if rows empty: false, if error occured: false. 
		 */
		public function get($query){
			try {
				$stmt = $this->conn->query($query);
				return ( $stmt->rowCount() > 0 )
						? $stmt->fetchAll(PDO::FETCH_ASSOC)
						: false;
			} catch(Exception $e) {
				$this->errors['code'] = $e->getCode();
				$this->errors['message'] = $e->getMessage();
				// echo $e->getMessage();
				return false;
			}
		}
		/**
		 * Insert, Update or Delete from Database with a query using prepared statements.
		 * @param String $query    	A SQL query with preperaded statements.
		 * @param Array  $bindings 	Bindings for the prepered statements.
		 */
		public function set($query, $bindings){
			try {
				$stmt = $this->conn->prepare($query);
				return $stmt->execute($bindings);	
			} catch (Exception $e) {
				$this->errors['code'] = $e->getCode();
				$this->errors['message'] = $e->getMessage();
				// echo $e->getMessage();
				return false;
			}
		}

		/**
		 * Get database errors for connecting, getting or setting.
		 * @return array
		 */
		public function getErrors(){
			return $this->errors;
		}
	}