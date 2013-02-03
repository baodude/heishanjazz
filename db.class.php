<?php
class MYSQL {
	public $charset = '';
	protected $link, $query_id, $result;
	private $server, $username, $password, $db;

	public function __construct($server, $username, $password, $db, $charset = 'utf8') {
		$this->server = $server;
		$this->username = $username;
		$this->password = $password;
		$this->charset = $charset;
		$this->db = $db;
		$this->connect();
	}

	private function connect() {
		$this->link_ID = @mysql_connect($this->server, $this->username, $this->password);
		$this->query("SET NAMES " . $this->charset);
		if (!$this->link_ID) {
			$this->Error_("Could not connect to server:<b>$this->server</b><br />");
		}
		if (!@mysql_select_db($this->db, $this->link_ID)) {
			$this->Error_("Could not open database:<b>$this->db</b> <br />");
		}
	}

	public function __destruct() {
		if (!($this ->link_ID)){
            mysql_close();
		}
	}
	private function escape($string) {
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return mysql_real_escape_string($string);
	}

	private function query($sql) {
		return $this->query_id = @mysql_query($sql, $this->link_ID);
	}

	public function Execute($sql,$action='') {
		if(empty($action)){
		return $this->query($sql);
		}
		else{
			switch($action){
					case "rows":
					return $this->DataRows($this->query($sql));
					break;
					case "nums":
					return $this->Rows_Nums($this->query($sql));
					break;
					case "field":
					return $this->Rows_Field($this->query($sql));
					break;
					default:
					return $this->query($sql);
					break;


			}
		}
	}

	public function Fetch($query_id) {
		return $this->result = @mysql_fetch_array($this->query_id = $query_id, MYSQL_ASSOC);
	}

	public function Rows_Nums($query_id) {
		return $this->result = @mysql_num_rows($this->query_id = $query_id);
	}


	public function REPLACE($table, $data) {
		$sql = "REPLACE INTO `" .$table . "` ";
		$n = '';
		$v = '';
		foreach($data as $key => $value) {
			$n .= "`$key`, ";
			$v .= "'" . $this->escape($value) . "', ";
		}
		$sql .= "(" . rtrim($n, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";
		if ($this->query($sql)) {
			return mysql_insert_id();
		} else {
			$this->Error_(mysql_error());
		}
	}

	public function DataRows($result){
		$rows = array();
		$i = 0;
		while ( $row = $this->Fetch($result) ){
			$rows[$i++] = $row;
		}
		return $rows;
	}

	private function Error_($Messges) {
		echo $Messges;
		exit;
	}
}


if(!$db) $db = new MYSQL($setting['db_host'],$setting['db_user'], $setting['db_pass'], $setting['db_base']);
?>