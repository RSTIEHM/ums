<?php 
require_once "auth.php";
// $user = new Auth();

if(isset($_POST["action"]) && $_POST["action"] == "register") {
  // $name = $user->test_input($_POST['name']);
  // $email = $user->test_input($_POST['email']);
  // $password = $user->test_input($_POST['password']);
  // $hpass = password_hash($password, PASSWORD_DEFAULT);

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hpass = password_hash($password, PASSWORD_DEFAULT);

  define("HOSTNAME", "localhost");
  define("USERNAME", "root");
  define("PASSWORD", "");
  define("DATABASE", "ums");

  $con = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

  if (!$con) {
    die("Connection Failed!!!");
  }

  $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hpass')";

  $result = mysqli_query($con,$sql);

  if (!$result) {
    die("FAILED" . mysqli_error($con));
  } else {
    echo "register";
    // header("location:index.php");
  }

  // if($user->user_exists($email)) {
  //   echo $user->showMessage("warning",'This email is already registered');
  // } else {
  //   if($user->register($name, $email, $hpass)) {
  //     echo 'register';
  //     $_SESSION["user"] = $email;
  //   } else {
  //     echo $user->showMessage("danger", "Something Went Wrong! Try again in a bit");
  //   }
  // }


}


?>