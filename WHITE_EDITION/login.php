<?php 
session_start(); 
require_once "connection.php";
if (isset($_SESSION['admin'])!=false){
  header("Location:index.php");
}
$select_menu ="SELECT * FROM menu";
$list_menu = $konekcija->prepare($select_menu);
$list_menu->execute();
$menus = $list_menu->fetchAll();
?>
<!DOCTYPE HTML>
<html>
<head>
<title>White Edition</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<header>
  <nav class="main-nav">
    <ul>
      <li>
        <ul>
          <?php foreach($menus as $menu):?>
          <li><a href="<?php echo($menu->menu_link)?>"><?php echo($menu->menu_text)?></a></li>
          <?php endforeach;?>
        </ul>
      </li>
    </ul>
  </nav>
</header>
<section id="video" class="home">
  <h1>WHITE EDITION</h1>
  <h2>E.S.T 2013</h2>
</section>
<div class="login-form">
    <form action="" id="login-form" method="post">
      <input type="text" name="username" placeholder="username" id="login-username">
      <input type="password" name="password" id="login-password">
      <input type="submit" name="submit" value="Log in" >
    </form>
    <?php if(isset($_POST['submit'])):?>
        <?php
          $query ="SELECT * FROM users WHERE username=:username AND password=:password";
          $username = $_POST['username'];
          $password = $_POST['password'];
          $password = md5($password);
          $stmt = $konekcija->prepare($query);
			    $stmt->bindParam(":username", $username);
			    $stmt->bindParam(":password", $password);
			    $stmt->execute();
          $user = $stmt->fetch();
          if($user!= false){
            $_SESSION['user_logged']=true;
            $_SESSION['username']= $user->username;
            $_SESSION['admin']= $user->admin;
            
          }
          if($_SESSION['admin']== 1){
            header('location:admin.php');
          }
          if($_SESSION['admin']== 0){
            header('location:user.php');
          }
          
          
        ?>
      <?php endif;?>
  </div>
<footer>
  <div class="copyright"><small>Copyright. All Rights Reserved | by <a target="_blank" rel="nofollow" href="http://www.iamsupview.be">Supview</a>.</small></div>
</footer>
</body>
</html>