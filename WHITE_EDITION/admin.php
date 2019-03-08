<?php 
session_start();
require_once "connection.php";
// users
$select_users ="SELECT * FROM users";
$list_users = $konekcija->prepare($select_users);
$list_users->execute();
$users = $list_users->fetchAll();
// articles
$select_articles ="SELECT * FROM articles";
$list_articles = $konekcija->prepare($select_articles);
$list_articles->execute();
$articles = $list_articles->fetchAll();
// menu
$select_menu ="SELECT * FROM menu";
$list_menu = $konekcija->prepare($select_menu);
$list_menu->execute();
$menus = $list_menu->fetchAll();
// gallery
$select_gallery ="SELECT * FROM gallery";
$list_photos = $konekcija->prepare($select_gallery);
$list_photos->execute();
$photos = $list_photos->fetchAll();

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
          <li><a href="<?php echo($menu->menu_link)?>" ><?php echo($menu->menu_text)?></a></li>
          <?php endforeach;?>
          <?php if(isset($_SESSION['admin'])):?>
            <a href="logout.php">Log out</a>
          <?php else:?>
            <a href="login.php">Log in</a>
          <?php endif; ?>
        </ul>
      </li>
    </ul>
  </nav>
</header>

<section id="video" class="home">

  <h1>WHITE EDITION</h1>
  <h2>E.S.T 2013</h2>
</section>
<?php if (isset($_SESSION['admin'])==false):?>
  <?php $_SESSION['admin']=null ?>
<?php endif;?>
<?php if(($_SESSION['admin']== 1)):?>
<section id="main-content">
  <div class="text-intro">
    <h2>Admin panel</h2>
  </div>
  <div class="columns features">
    <div class="one-third first">
      <h3>Create an article</h3>
      <p>Create new article here<p>
            <form action="admin.php" method="POST"name="article"id="article">
              <input type="text" name="heading" placeholder="Heading">
              <textarea id="content-textarea" placeholder="Content here..." rows="4" cols="30" name="content"form="article"> </textarea>
              <input type="submit" name="article" value="Create article">
            </form>
            <?php if(isset($_POST['article'])):?>
            <?php  
                $query ="INSERT INTO articles (heading, content, date) values (?,?,?)";
                $heading = $_POST['heading'];
                $content = $_POST['content'];
                $date = mktime();
                

                $stmt = $konekcija->prepare($query);
                $stmt->execute([$heading, $content,$date]);
            header("location: admin.php");
            ?>
           
            <?php endif;?>
    </div>
    <div class="one-third second">
      <h3>Delete an article</h3>
      <p>Delete unwanted articles here.</p>
      
            
      <div class="articles">
        <table>
        <tr class="table-rows">
            <th class="table-heading">Article ID</th>
            <th class="table-heading">Heading</th> 
            <th class="table-heading">Date</th> 
            <th class="table-heading"></th> 
        </tr>
        <?php foreach ($articles as $article): ?>
           <tr>
             <td class="table-data">
                <?php echo($article->article_id);?>
            </td>
            <td class="table-data">
                <?php echo($article->heading);?>
            </td>
            <td class="table-data">
                <?php echo(date('j.F Y',$article->date));?>
            </td>
            <td>
                <a href="delete_article.php?id=<?php echo ($article->article_id);?>">Delete</a>
            </td>
            </tr>
        <?php endforeach; ?>
        
        </table>
      </div>
    </div>
    <div class="one-third">
      <h3>Add user</h3>
      <p>Register a user</p>
      <form action="admin.php" method="POST"name="user_add"id="user_add">
              <input type="text" name="user_add_username" placeholder="Username">
              <input type="password" name="user_add_password" placeholder="Password">
              <br>
              <div class="radio_buttons">
                  <span class="admin"><input type="radio" name="role" value="1"> Admin</span>
                  <span class="user"> <input type="radio" checked="checked" name="role" value="0"> User</span>
              </div>
              <input type="submit" name="user_add" value="Add user">
            </form>
            <?php if(isset($_POST['user_add'])):?>
            <?php  
                $query ="INSERT INTO users (username, password, admin) values (?,?,?)";
                $username = $_POST['user_add_username'];
                $password = $_POST['user_add_password'];
                $admin =$_POST['role'];
                $user_exists=0;
                $username_wrong=0;
                $password_wrong=0;
                if($username=='' || strlen($username)<5){
                  echo("Username too short");
                  $username_wrong=1;
                }
                if($password=='' || strlen($password)<5){
                  echo("Password too short");
                  $password_wrong=1;
                }
                $password =md5($password);
                if(($username_wrong == 1) && ($password_wrong==1)){
                  echo("lose je");
                }
                else{
                  foreach($users as $user){
                    if($username==$user->username){
                        $user_exists=1;
                      break;
                    }
                  }
                  if($user_exists != 1){
                    $stmt = $konekcija->prepare($query);
                    $stmt->execute([$username, $password,$admin]);  
                  }
                    header("location: admin.php");   

                  }
              
               ?>
           
            <?php endif;?>
    </div>
    <div class="one-third">
      <h3>Delete user</h3>
      <p>User causing troubles? Delete him here</p>
     
            
      <div class="articles">
        <table>
        <tr class="table-rows">
            <th class="table-heading">Role</th>
            <th class="table-heading">Username</th> 
        </tr >
        <?php foreach ($users as $user): ?>
       
           <tr>
             <td class="table-data" >
             <?php if (($user->admin)==1):?>
                <?php echo('admin');?>
             <?php else:?>
                <?php echo('user');?>
             <?php endif;?>
            </td >
            <td>
                <?php echo($user->username);?>
            </td>
            <td class="table-data">
                <a href="delete_user.php?id=<?php echo $user->user_id?> "> Delete</a>
            </td>
            </tr>
        <?php endforeach; ?>
        
        </table>
      </div>
    </div>
    <div class="one-third">
      <h3>Add a photo to gallery</h3>
      <p> Add a photo to the site gallery</p>
      <div class="add_picture">
          <form action="admin.php" method="POST"name="image_add"id="image_add" enctype="multipart/form-data" >
                  <input type="file" name="fileToUpload" accept="image/jpg,image/jpeg" /> 
                  <input type="submit" name="image_add">
          </form>
        
        <?php if(isset($_POST['image_add'])):?>
        <?php 
          $target_path = "e:/"; 
          $target_path = $target_path.basename( $_FILES['fileToUpload']['name']); 
          if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], __DIR__.'/gallery/'.$_FILES['fileToUpload']['name'])) { 
            echo "File uploaded successfully!"; 
            $query ="INSERT INTO gallery (image_path) values (?)";
            $image_path ='gallery/'. $_FILES['fileToUpload']['name'];;
            $stmt = $konekcija->prepare($query);
            $stmt->execute([$image_path]);
            echo '<script type="text/javascript">';
            echo 'window.location.href="admin.php";';
            echo '</script>';
       
           } else{ 
            echo "Sorry, file not uploaded, please try again!"; 
           } 
            
            ?> 
     
        <?php endif;?>
      </div>
    </div>
    <div class="one-third">
      <h3>Delete photo</h3>
      <p> Inappropriate photo? Delete it here</p>
     
            
      <div class="photos">
        <table>
        <tr class="table-rows">
            <th class="table-heading">Photo</th>
            <th class="table-heading"></th> 
        </tr >
        <?php foreach ($photos as $photo): ?>
       
           <tr>
             <td class="table-data" >
              <img class ="thumbnail" src="<?php echo $photo->image_path;?>" alt="">
            </td >
            <td class="table-data">
                <a href="delete_user.php?id=<?php echo $user->user_id?> "> Delete</a>
            </td>
            </tr>
        <?php endforeach; ?>
        
        </table>
      </div>
    </div>
  </div>
</section>
<?php else: ?>
<section id="main-content">
  <div class="login-form">
    <form action="admin.php" id="login-form" method="post">
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
            header('location:admin.php');
          }
          if($_SESSION['admin']!= 1){
            header('location:user.php ');
          }
        ?>
      <?php endif;?>
  </div>
</section>
<?php endif;?>
<footer>
  <div class="copyright"><small>Copyrssight. All Rights Reserved | by <a target="_blank" rel="nofollow" href="http://www.iamsupview.be">Supview</a>.</small></div>
</footer>
</body>
</html>