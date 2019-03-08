<?php session_start();?>
<?php require_once('connection.php');?>
<?php if(($_SESSION['admin']== 1)):?>
<?php 
  if(!isset($_GET['id'])){
      header("location: index.php");
  }
  else{
    $query ="DELETE FROM articles WHERE article_id=:article_id";
    $article_id = $_GET['id'];
    $stmt = $konekcija->prepare($query);
    $stmt->bindParam(":article_id", $article_id);
    $stmt->execute();
    header("location: admin.php");
  }
  
  
  echo $_GET['id'];?>
<?php else: ?>
<?php header("location: index.php?msg=Niste admin");?>
<?php endif; ?>