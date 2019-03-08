
<?php 
session_start(); 
require_once "connection.php";
if (isset($_SESSION['admin'])==false){
  header("Location:login.php");
  
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
<?php if (isset($_SESSION['admin'])==false):?>
  <?php $_SESSION['admin']=null ?>
<?php endif;?>
<?php if(($_SESSION['admin']== 1)):?>
<?php header('Location: admin.php');?>
<?php else: ?>
<section id="video" class="home">
  <h1>WHITE EDITION</h1>
  <h1>USER</h1>
  <h2>E.S.T 2013</h2>
</section>
<section id="main-content">
  <div class="text-intro">
    <h2>About</h2>
  </div>
  <div class="one-third">
  <div class="columns features">
  <h3>Create an article</h3>
      <p>Create new article here<p>
            <form action="" method="POST"name="article"id="article">
              <input type="text" name="heading" placeholder="Heading">
              <textarea id="content-textarea" placeholder="Content here..." rows="4" cols="30" name="content"form="article"> </textarea>
              <input type="submit" name="article" value="Create article">
            </form>
            <?php if(isset($_POST['article'])):?>
            <?php  
                $query ="INSERT INTO articles (heading, content) values (?,?)";
                $heading = $_POST['heading'];
                $content = $_POST['content'];
                $stmt = $konekcija->prepare($query);
                $stmt->execute([$heading, $content]);
                header("location: user.php");
            ?>
           
            <?php endif;?>
    </div>
    </div>
  
    <div class="one-third">
      <h3>Add a photo to gallery</h3>
      <p> Add a photo to the site gallery</p>
      <div class="add_picture">
          <form action="user.php" method="POST"name="image_add"id="image_add" enctype="multipart/form-data" >
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
            echo 'window.location.href="user.php?msg=Uspesno ste poslali sliku";';
            echo '</script>';
       
           } else{ 
            echo "Sorry, file not uploaded, please try again!"; 
           } 
            ?> 
            
        <?php endif;?>
        <?php if(isset(($_GET['msg']))){ echo($_GET['msg']);} ?>
      </div>
    </div>
  </div>
</section>
<footer>
  <div class="copyright"><small>Copyright. All Rights Reserved | by <a target="_blank" rel="nofollow" href="http://www.iamsupview.be">Supview</a>.</small></div>
</footer>
</body>
</html>
<?php endif;?>