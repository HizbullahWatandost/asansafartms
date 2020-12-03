<?php
// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Admin {
	protected static $table_name="admin";
	protected static $db_fields =
		array('adminFullName',
		'adminEmail',
		'adminMobile',
		'adminPassword');


	public $adminFullName;
	public $adminEmail;
	public $adminMobile;
	public $adminPassword;

	/* =================================================================
	 * This function will check the adminname and password from the admin table
	 * according to the admin's input. */
	public static function authenticate($adminEmail="", $adminPassword="") {
		global $database;
		$adminEmail = $database->escape_value($adminEmail);
		$adminPassword = $database->escape_value($adminPassword);
		$adminPassword = md5($adminPassword);

		$sql = "SELECT * FROM admin ";
		$sql .= "WHERE adminEmail  = '{$adminEmail}' ";
		$sql .= "AND adminPassword = '{$adminPassword}' ";
		$sql .= "LIMIT 1";

		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	/* ===================================================================
	 * This function will count all the records of admins in the admins table
	 * and return the total number. */
	public static function count_all() {
		global $database;
		$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}

	/* =====================================================================
	 * This function will return an array of attributes keys and their values
	 * */
	protected function attributes() {
		// return an array of attributes keys and their values
		$attributes = array();
		foreach(self::$db_fields as $field) {
			if(property_exists($this, $field)) {
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}

	/* ================================================================
	 * This function is for security.
	 * It will sanitize the values before submitting them
	 * It will not affect the actual value of each attribute. */
	protected function sanitized_attributes() {
		global $database;
		$clean_attributes = array();
		// sanitize the values before submitting
		// Note: does not alter the actual value of each attribute
		foreach($this->attributes() as $key => $value) {
			$clean_attributes[$key] = $database->escape_value($value);
		}
		return $clean_attributes;
	}

	/* ================================================================
	 * This function is responsible to save the record to the database
	 * which is taking help from 2 other function update() and create().
	 * */

	/* ================================================================
	 * This function will insert the record to the admins table
	 * */
	public function createAdmin($fullName, $email, $mobile, $password) {
		global $database;
    $query = "INSERT INTO admin(
        adminFullName,
        adminEmail,
        adminMobile,
        adminPassword)
        VALUES(
          '{$fullName}',
          '{$email}',
          '{$mobile}',
          '{$password}'
        )";
		if($database->query($query)) {
			return true;
		} else {
      echo mysqli_error;
			return false;
		}
	}

	public function createOperator($fullName, $email, $mobile, $password) {
		global $database;
		$query = "INSERT INTO admin(
				adminFullName,
				adminEmail,
				adminMobile,
				adminPassword,role)
				VALUES(
					'{$fullName}',
					'{$email}',
					'{$mobile}',
					'{$password}',
					'operator'
				)";
		if($database->query($query)) {
			return true;
		} else {
			echo mysqli_error;
			return false;
		}
	}

	/* ==============================================================
	 * This function will update the record in admins table according
	 * to the input submited. */
	public function update() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE adminId=" . $database->escape_value($this->adminId);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

	/* ================================================================
	 * This table will delete record from the admins table according
	 * to the admin's selection. */
	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
		$sql = "DELETE FROM ".self::$table_name." ";
		$sql .= "WHERE adminId=" . $database->escape_value($this->adminId);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

	// Common Database Methods
	/* === This function will retrieve all the records in admins table ===== */
	public static function find_all() {
		return static::find_by_sql("SELECT * FROM ".self::$table_name);
	}

	/* ======= This function will find a admin by its unique id ========== */
	public static function find_by_id($id=0){
		global $database;
		$result_array = static::find_by_sql("SELECT * FROM ". static::$table_name ." WHERE adminId={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	/* ====== This function can handle a sql query and return the result ======= */
	public static function find_by_sql($sql="") {
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while($row = $database->fetch_array($result_set)) {
			$object_array[] = static::instantiate($row);
		}
		return $object_array;
	}

	/* ===== This function will check weather the record exists in the submitted values ===== */
	private static function instantiate($record) {
		// Could check that $record exists and is an array
		// Simple, long-form approach:
		$class_name = get_called_class();
		$object = new $class_name;

		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value) {
			if($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}

		return $object;
	}

	/* ==== This function will check weather attributes has value if yes it will return them === */
	private function has_attribute($attribute) {
		// get_object_vars returns an associative array with all attributes
		// (incl. private ones!) as the keys and their current values as the value
		$object_vars = $this->attributes();
		// We don't care about the value, we just want to know if the key exists
		// Will return true or false
		return array_key_exists($attribute, $object_vars);
	}
}

$admin = new Admin();
?>
