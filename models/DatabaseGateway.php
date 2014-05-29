<?php

class DatabaseGateway{
	private $db;

	public function __construct(Database $db){
		$this->db = $db;
	}

	/**
	 * Creates an .ini file with database configuration.
	 *
	 * IMPORTANT! Lock down the access to the file within .htaccess.
	 * 
	 * @param  string $dbName     Name of database to be connected.
	 * @param  string $dbUser     Database username.
	 * @param  string $dbPassword Database password.
	 * @return void
	 */
	public function configure($dbName, $dbUser, $dbPassword){

		file_put_contents(
				'config/database.ini', 
				"[database_configuration]\n\n" . 
				"database = $dbName\n" . 
				"username = $dbUser\n" .
				"password = $dbPassword");
	}

	/**
	 * Check if a database connection can be established.
	 * @return boolean
	 */
	public function isConnected(){
		$this->db->getConfig();
		return $this->db->connect();
	}

	/**
	 * Query a table for all columns, with an optional WHERE clause.
	 * @param  string $table      	Name of the table to fetch information from.
	 * @param  string $columnName 	Columnname to be compared.  
	 * @param  mixed  $id         	The value to compare against.  
	 * @return mixed              	Returns database rows, if rows empty: false, if error occured: false. 
	 */
	public function get($table, $columnName = null, $id = null){

		$query = "SELECT * FROM $table";

		if ($id != null && $columnName != null) {
			$query = $query . " WHERE $columnName = \"$id\"" ;
		}

		$query .= " ORDER BY id DESC";


		return $this->db->get($query);
	}

	/**
	 * Insert values into database tables with prepared statements.
	 * @param  string $table    The tablename, key for getting the right query.
	 * @param  array  $bindings The values to bind to prepared statements.
	 * @return boolean           Sucessfull SQL INSERT or not.
	 */
	public function insert($table, Array $bindings){
		
		$query = array(
			"posts" 		=> 	"INSERT INTO $table (header, body, uri, author) 
								VALUES (:header, :body, :uri, :author)", 
			"users" 		=> 	"INSERT INTO $table (username, email, firstname, lastname, password, salt) 
								VALUES (:username, :email, :firstname, :lastname, :password, :salt)", 
			"comments" 		=> 	"INSERT INTO $table (author, body, belongs_to) 
								VALUES (:author, :body, :belongs_to)",
			"bloggconfig"	=>	"INSERT INTO $table (title) 
								VALUES (:title)"
			);

		return $this->db->set($query[$table], $bindings) ? true : false;
	}

	/**
	 * Update values in database tables with prepared statements.
	 * @param  string $table      The tablename, key for getting the right query.
	 * @param  array  $bindings   The values to bind to prepared statements.
	 * @param  string $columnName Columnname to be compared. 
	 * @param  string $id         The value to compare against.
	 * @return boolean            Sucessfull SQL UPDATE or not.
	 */
	public function update($table, Array $bindings, $columnName, $id){
		$query = array(
			'posts' => "UPDATE $table SET header = :header, body = :body, author = :author, uri = :uri WHERE $columnName = $id",
			'bloggconfig' => "UPDATE $table SET title = :title WHERE $columnName = $id");

		return $this->db->set($query[$table], $bindings) ? true : false;
	}

	/**
	 * Removes an entry from database table using prepared statement.
	 * @param  string $table     The table to remove from.
	 * @param  array  $bindings  The values to bind to prepared statements (the id to be removed).
	 * @return boolean           Sucessfull SQL DELETE or not.
	 */
	public function remove($table, Array $bindings){

		$query = "DELETE FROM $table WHERE id = :id";

		return $this->db->set($query, $bindings) ? true : false;
	}

	public function getDatabaseErrors(){
		$errors = $this->db->getErrors();

		switch ($errors['code']) {
			case 23000:
				$errors['message'] = 'Ett blogginlägg med samma namn existerar redan!';
				break;
			
			default:
				$error['message'] = 'Det har uppstått ett fel i databasen. Felkod: ' . $errors['code'];
				break;
		}

		return $errors['message'];
	}

}