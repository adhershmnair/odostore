<?php
class Mysql{
	protected $connection = false;
	protected $sql;
	public function __construct($config = array()){
		$host = isset($config['host'])? $config['host'] : 'localhost';
		$user = isset($config['user'])? $config['user'] : 'root';
		$password = isset($config['password'])? $config['password'] : '';
		$dbname = isset($config['dbname'])? $config['dbname'] : 'odo';
		$port = isset($config['port'])? $config['port'] : '3306';
		$charset = isset($config['charset'])? $config['charset'] : 'utf8';
		$this->connection = mysqli_connect("$host:$port",$user,$password) or die('Database connection error');
		mysqli_select_db($this->connection, $dbname) or die('Database selection error');
		$this->setChar($charset);
	}

	private function setChar($charest){
		$sql = 'set names '.$charest;
		$this->query($sql);
	}

	public function query($sql){        
		$this->sql = $sql;
		$str = $sql . "  [". date("Y-m-d H:i:s") ."]" . PHP_EOL;
		file_put_contents("var/log/mysql.log", $str,FILE_APPEND);
		$result = mysqli_query($this->connection, $this->sql);
		if (! $result) {
			die($this->errno().':'.$this->error().'<br />Error SQL statement is '.$this->sql.'<br />');
		}
		return $result;
	}

	public function getOne($sql){
		$result = $this->query($sql);
		$row = mysqli_fetch_row($result);
		if ($row) {
			return $row[0];
		} else {
			return false;
		}
	}

	public function getRow($sql){
		if ($result = $this->query($sql)) {
			$row = mysqli_fetch_assoc($result);
			return $row;
		} else {
			return false;
		}
	}

	public function getAll($sql){
		$result = $this->query($sql);
		$list = array();
		while ($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}

	public function getColumn($sql){
		$result = $this->query($sql);
		$list = array();
		while ($row = mysqli_fetch_row($result)) {
			$list[] = $row[0];
		}
		return $list;
	}

	public function getInsertId(){
		return mysqli_insert_id($this->connection);
	}

	public function errno(){
		return mysqli_errno($this->connection);
	}

	public function error(){
		return mysqli_error($this->connection);
	}

}