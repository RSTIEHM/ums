<?php 
session_start();
require_once "auth.php";
$user = new Auth();


// HANDLE AJAX REGISTER ========================================  
if(isset($_POST["action"]) && $_POST["action"] == "register") {

  // =====================================================
  $name = $user->test_input($_POST['name']);
  $email = $user->test_input($_POST['email']);
  $password = $user->test_input($_POST['password']);
  $hpass = password_hash($password, PASSWORD_DEFAULT);


  if($user->user_exists($email)) {
    echo $user->showMessage("warning",'This email is already registered');
  } else {
    if($user->register($name, $email, $hpass)) {
      echo 'register';
      $_SESSION["user"] = $email;
    } else {
      echo $user->showMessage("danger", "Something Went Wrong! Try again in a bit");
    }
  }


}

// HANDLE AJAX Login ========================================  
if (isset($_POST["action"]) && $_POST["action"] == "login") {
  $email = $user->test_input($_POST["email"]);
  $password = $user->test_input($_POST["password"]);

  $loggedInUser = $user->login($email);
  if($loggedInUser != null) {
    // USER FOUND ==================
    if(password_verify($password, $loggedInUser["password"])) {
      // USER WITH PASSWORD VERIFIED =============
      if(!empty($_POST["rem"])) {
        setcookie("email", $email, time() + (30*24*60*60), "/");
        setcookie("password", $password, time() + (30 * 24 * 60 * 60), "/");
      } else {
        setcookie("email", "", 1, "/");
        setcookie("password", "", 1, "/");   
      }
      echo "login";
      $_SESSION["user"] = $email;
    }
    else {
      // WRONG PASSWORD ===================================
      echo $user->showMessage("danger", "Password is wrong");
    } 
  } 
  else {
    // NO USER ===================================
    echo $user->showMessage("danger", "No User Found");
  }

}


?>