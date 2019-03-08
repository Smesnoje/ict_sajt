<?php 
session_start(); 
require_once "connection.php";
$select_articles ="SELECT * FROM articles";
$list_articles = $konekcija->prepare($select_articles);
$list_articles->execute();
$articles = $list_articles->fetchAll();
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
  <h1>WHITE EDITION</h1>
  <h2>E.S.T 2013</h2>
</section>
<section id="main-content">
<div class="info">
      <h1>Here you can see stories of other climbers</h1>
  </div>
  <div class="about_front">
 
<div id="poll">
      <h3>Vote for next destination here:</h3>
      <form>
      Mesto1:
      <input type="radio" name="vote" value="0" onclick="getVote(this.value)">
      <br>Mesto2:
      <input type="radio" name="vote" value="1" onclick="getVote(this.value)">
      </form>
    </div>
  </div>

  <div class="columns features">
    <div class="first">
    <?php foreach (array_reverse($articles) as $article): ?>
      <div class="article">
                 <h1 class="article_heading"> <?php echo($article->heading);?></h1>
                  <div class="article-date">  <?php echo(date('j.F Y',$article->date));?></div>
                 <p class="article_content"> <?php echo($article->content);?></p>
      </div>       
    <?php endforeach; ?>
    </div>
    
  </div>
</section>
<footer>
  <div class="copyright"><small>Copyright. All Rights Reserved | by <a target="_blank" rel="nofollow" href="http://www.iamsupview.be">Supview</a>.</small></div>
</footer>
</body>
</html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/main.js"></script>