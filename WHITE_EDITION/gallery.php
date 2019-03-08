  <?php 
session_start(); 
require_once "connection.php";
// gallery
$select_gallery ="SELECT * FROM gallery";
$list_photos = $konekcija->prepare($select_gallery);
$list_photos->execute();
$photos = $list_photos->fetchAll();
// menu
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
  <h1>Gallery</h1>
</section>
<section id="gallery">

  <?php foreach($photos as $photo):?>
      <div class="one-third gallery_photo" style="background-image:url('<?php echo $photo->image_path;?>')">
      <h2 class="image_naslov"><?php echo $photo->image_naslov;?></h2>
      </div>
  <?php endforeach;?>
</section>
<footer>
  <div class="copyright"><small>Copyright. All Rights Reserved | by <a target="_blank" rel="nofollow" href="http://www.iamsupview.be">Supview</a>.</small></div>
</footer>
</body>
</html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/main.js"></script>