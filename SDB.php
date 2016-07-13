<?php

class SDB {
	var $link;
	var $sql;
	var $row;
	var $database;

    function __construct(){
        $db = array(
            //"server"=>"10.129.64.241:3306",
	    "server"=>"localhost",
            "username"=>"userdb",
            "password"=>"43CeHR3cg9Gn",
            "database"=>"api_log"
        );
        $this->connect($db);
        $this->setcharset("utf-8");
        $this->cmd("SET NAMES 'UTF8'");
    }

	function connect($db) {
		$this->link = mysql_connect($db["server"], $db["username"], $db["password"]) or die(mysql_error());
		$this->database = mysql_select_db($db["database"]) or die(mysql_error());
		return $this->link;
	}
	
	function setcharset($type) {
		return mysql_set_charset($type, $this->link);
	}
	
	function cmd($sql) {
			return mysql_query($sql, $this->link);
	}
	
	function error_sql($code, $msg, $mail="0") {
		echo $code."".$msg;
	}
	
	
	function num_rows($sql) {
		$is_connect = $this->check_connect() ? $this->check_connect() : die("Can't connect to MySQL Server.");
		if($is_connect) {
			return mysql_num_rows($sql);
		}
	}
	
	function fetch_array($sql) {
		
		$is_connect = $this->check_connect() ? $this->check_connect() : die("Can't connect to MySQL Server.");
		if($is_connect) {
			return mysql_fetch_array($sql);
		}
	}
	
	function fetch_assoc($sql) {
	
		$is_connect = $this->check_connect() ? $this->check_connect() : die("Can't connect to MySQL Server.");
		if($is_connect) {
			return mysql_fetch_assoc($sql);
		}
	}
	
	function check_connect() {
		return mysql_ping($this->link) or die(mysql_error($this->link));
	}
}
