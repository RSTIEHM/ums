<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

require_once "auth.php";
$user = new Auth();


// HANDLE AJAX REGISTER ========================================  
if(isset($_POST["action"]) && $_POST["action"] == "register") {

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

// HANDLE FORGOT PASSWORD ======================================== 
if (isset($_POST["action"]) && $_POST["action"] == "forgot") {
  $email = $user->test_input($_POST["email"]);
  $user_found = $user->currentUser($email);
  if($user_found != null) {
    $token = uniqid();
    $token = str_shuffle($token);
    $user->forgot_password($token,$email);
    try {
      $mail->isSMTP();
      $mail->Host = "smtp.gmail.com";
      $mail->SMTPAuth = true;
      $mail->Username = "";
      $mail->Password = "";
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->port = 587;
      $mail->setFrom("email@gmail.com", "RJS");
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->subject("RESET");
      $mail->Body("<h3>Hey</h3>");
      $mail->send();
      echo $user->showMessage("success", "Mail Sent");
    } catch() {
      echo $user->showMessage("danger", "Problem");
    }
  }
}

?>