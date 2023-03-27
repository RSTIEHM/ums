<?php 

require_once 'config.php';

class Auth extends Database {

  // REGISTER NEW USER 
  public function register($name, $email, $password) {
    // $name = "Jason";
    // $email = "voorhees@email.com";
    // $password = "1234567";
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
}


?>