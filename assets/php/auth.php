<?php 

require_once 'config.php';

class Auth extends Database {

  // REGISTER NEW USER 
  public function register($name, $email, $password) {
    $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt =  $this->conn->prepare($sql);
    $stmt->bindParam("name", $name);
    $stmt->bindParam("email", $email);
    $stmt->bindParam("password", $password);
    $stmt->execute();
    return true;
  }

  public function user_exists($email) {
    $sql = "SELECT email FROM users WHERE email = :email";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public function login($email) {
    $sql = "SELECT email, password FROM users WHERE email = :email AND deleted != 0";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam("email", $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  // CURRENT USER SESSION
  public function currentUser($email) {
    $sql = "SELECT * FROM users WHERE email = :email AND deleted != 0";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam("email", $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }
  
}


?>