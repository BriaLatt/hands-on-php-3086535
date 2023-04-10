<?php
class MyConnect {
	private $db_name;
	private $username;
	private $password;
	private $host;

	private static $connection;
	
	private function __construct($name, $username, $password) {
		$this->db_name = $name;
		$this->username = $username;
		$this->password = $password;
		$this->host = 'localhost';	
	}
	
	public static function open_connection($name, $username, $password) {
		if ( !isset(self:$connection) ) {
			self::$connection = new MyConnect($name, $username, $password)
		}
	}
	public function get_info( $query ) {
		//STUB
	}
	
	public function set_info( $query ) {
		//STUB
	}

	public function get_db_name() {
		return $this->db_name;
	}
}

$db = new MyConnect( 'people', 'joe', 'hello_there' );
echo $db->get_db_name();