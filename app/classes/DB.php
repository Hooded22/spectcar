<?php
include("Filter.php");
class Db {
    private $mysqli; //Database variable
    private $select_result; //result
	private $filter;
    public function __construct($serwer, $user, $pass, $baza) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
        if ($this->mysqli->connect_errno) {
            printf("Connection to server failed: %s \n", $this->mysqli->connect_error);
            exit();
        }
        if ($this->mysqli->set_charset("utf8")) { 
            //charset changed 
        }
    }
    function __destruct() {
        $this->mysqli->close();
    }
    public function select($sql) {
        $results=array();
        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_object()) {
                $results[]=$row;
                }
                $result->close();
            }
            $this->select_result=$results;
        return $results;
    }	
}
?>
