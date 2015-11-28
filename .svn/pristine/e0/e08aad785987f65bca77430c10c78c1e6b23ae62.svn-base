<?php
require_once(LIB_PATH.DS."config.php");
class MySQLDatabase {
	private $connection;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	public $last_querry;
	
	function __construct() {
		 $this->open_connection();
		 $this->magic_quotes_active=get_magic_quotes_gpc();
		 $this->real_escape_string_exists=function_exists("mysql_real_escape_string");
	}
	
	public function open_connection() {
		$this->connection=mysql_connect(DB_SERVER,DB_USER,DB_PASS);
		if (!$this->connection) {
			die("Eroare conectare la baza de date: ".mysql_error());
		}
		else {
			$db_select=mysql_select_db(DB_NAME, $this->connection);
			if (!$db_select) {
				die("Eroare selectare baza de date: ".mysql_error());
			}
		}
	}
	
	public function close_connection() {
		if (isset($this->connection)) {
			mysql_close($this->connection);
			unset($this->connection);
		}
	}
	
	public function query($sql) {
		$this->last_query=$sql;
		$result=mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		return $result;
	}
	
	public function fetch_array($result) {
		return mysql_fetch_array($result);
	}
	
	private function confirm_query($result) {
		if (!$result) {
			$output="Eroare in executia comenzii: ".mysql_error();
			$output.=" Ultima comanda executata: ".$this->last_query;
			die($output);
		}
	}
	
	public function num_rows($result_set) {
		return mysql_num_rows($result_set);
	}
	
	public function insert_id() {
		return mysql_insert_id($this->connection);
	}
	
	public function affected_rows() {
		return mysql_affected_rows($this->connection);
	}
	
	public function escape_value($value) {
		
		if ($this->real_escape_string_exists) {
			if ($this->magic_quotes_active) {
				$value=stripslashes($value);
				$value=mysql_real_escape_string($value);
			}
		}
		else {
			if (!$this->magic_quotes_active) {
				$value= addslashes($value);
			}
		}
		return $value;
	}
}
$database = new MySQLDatabase();
?>