<?php 

 class Database {
  private $dbh = "mysql:host=localhost;dbname=ums";
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

  public function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  public function showMessage($type, $message) {
    return '
      <div class="alert alert-'.$type.' alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong class="text=-center">'.$message.'</strong>
      </div>
    ';
  }

 }





?>