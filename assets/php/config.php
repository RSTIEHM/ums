<?php 

 class Database {
  private $dbh = "mysql:host=localhost;dbname=db_ums";
  private $dbuser = "root";
  private $dbpass = "";

  public $conn;

  public function __construct() 
  { 
    try {
      $this->conn = new PDO($this->dbh, $this->dbuser, $this->dbpass);
    } catch(PDOException $e) {
      die("Error: " . $e->getMessage());
    }
    return $this->conn;
  }
 }





?>