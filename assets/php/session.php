<?php 
session_start();
require_once 'auth.php';
$curr_user = new Auth();

if(!isset($_SESSION["user"])) {
  header("location: index.php");
  die;
}

// $curr_email = $_SESSION["user"];
// $data = "WE ARE HERE";
// $data = $curr_user->currentUser($curr_email);
?>