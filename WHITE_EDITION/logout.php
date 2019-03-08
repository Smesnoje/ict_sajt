<?php session_start(); 
require_once "connection.php";
if (isset($_SESSION['admin'])==false){
  header("Location:index.php");
}else{
  var_dump($_SESSION);
  session_unset();
  session_destroy();
  header("Location: index.php");

}
?>
