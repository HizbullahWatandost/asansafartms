<?php
	include_once ('dbconfig.php');
	// Database Constants
	defined('DB_SERVER') ? null : define("DB_SERVER", $config["host"]);
	defined('DB_USER') ? null : define("DB_USER", $config["username"]);
	defined('DB_PASS') ? null : define("DB_PASS", $config["password"]);
	defined('DB_NAME') ? null : define("DB_NAME", $config["database"]);

class MySQLDatabase {

	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string;

	function __construct() {
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string = function_exists("mysqli_real_escape_string");
	}

	/* =========================================================================
	 * This function will open a new connection to the database and will return
	 * true if the connection was successful or false if unsuccessful.
	 * */
	public function open_connection() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		if(!$this->connection) {
			$dbConnectiviyFailure='Database connection is not valid please enter the valid database connection';
			header("location: install_step.php?msg=$dbConnectiviyFailure");
	 		exit;
			//die("Database connection failed: " . mysqli_error());
		}
	}

	/* ===========================================================================
	 * This function will close the open connection, which is good for security and
	 * database performance. */
	public function close_connection() {
		if(isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	/* =============================================================================
	 * This function will execute the query which will pass out by the user
	 * and return the result of it. */
	public function query($sql) {
		$this->last_query = $sql;
		$result = mysqli_query($this->connection, $sql);
		$this->confirm_query($result);
		return $result;
	}

	/* ==============================================================================
	 * This function will confirm that the query is executed successfully, if so it will
	 * return true if not it will give a custom message. */
	private function confirm_query($result) {
		if(!$result) {
			$output = "Database query failed: " . mysqli_error() . "<br /><br />";
			$output .= "Last SQL query: " . $this->last_query;
			die($output);
		}
	}

	/* ================================================================================
	 * This function will do the security checking, which is responsible for removing
	 * the slashes and useless characters which may hack the data. */
	public function escape_value($value) {
		if($this->real_escape_string) { // PHP v4.3.0 or higher
		// undo any magic quote effects so mysql_real_escape_string can do the work
		if($this->magic_quotes_active) { $value = stripslashes($value); }
			$value = mysqli_real_escape_string($this->connection, $value);
		} else { // before PHP v4.3.0
		// If magic quotes aren't already on then add slases manually
		if(!$this->magic_quotes_active) { $value = addslashes($value); }
		// if magic quotes are active, then teh slashes already exist
		}
		return $value;
	}

	// "Database-neutral" methods
	/* ===============================================================================
	 * This function will retrive all the data from the database table which is given
	 * to this function. */
	public function fetch_array($result_set) {
		return mysqli_fetch_array($result_set);
	}

	/* ===============================================================================
	 * This function will return the number of rows in a table */
	public function num_rows($result_set) {
		return mysqli_num_rows($result_set);
	}

	/* ================================================================================
	 * This function will get the last id inserted over the current db connection */
	public function insert_id() {
		// get the last id inserted over the current db connection
		return mysqli_insert_id($this->connection);
	}

	/* =================================================================================
	 * This function will check which rows are affected after doing certain activity */
	public function affected_rows() {
		return mysqli_affected_rows($this->connection);
	}

	/* ================================================================================
	/** Get the result of the query as value. The query should return a unique cell.\n
   * Note: no need to add "LIMIT 1" at the end of your query because
   * the method will add that (for optimisation purpose).
   * @param $query The query.
   * @return A value representing a data cell (or NULL if result is empty).
   */
	public function queryUniqueValue($query){
		$query = "$query LIMIT 1";
		$result = $this->query($query);
		$line = mysqli_fetch_row($result);
		return $line[0];
	}
	/** Get the count of rows in a table, with a condition.
		* @param $table The table where to compute the number of rows.
		* @param $where The condition before to compute the number or rows.
		* @return The number of rows (0 or more).
		*/
	public function countOf($table, $where){
		return $this->queryUniqueValue("SELECT COUNT(*) FROM $table WHERE $where");
	}
	/** Get the count of rows in a table.
    * @param $table The table where to compute the number of rows.
    * @return The number of rows (0 or more).
    */
	public function countOfAll($table){
		return $this->queryUniqueValue("SELECT COUNT(*) FROM $table");
	}


}
/* Instantiate a new object from the current class, which will be used in other pages */
$database = new MySQLDatabase();
$db =& $database;
?>
