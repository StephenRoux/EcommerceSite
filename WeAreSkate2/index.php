<?php
session_start();
require_once('./connect/config.php');
$pdo = new mypdo();
?>  

<!------ HTML------>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WeAreSkate</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/
  css2?family=Poppins:wght@300;400;500;600;700&display=swap"
  rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>

 <div class="header">
  <div class="container">
    <div class="navbar">
      <div class="logo">
        <img src="images/WAS2.png" width="125px">
      </div>
      <nav>
          <ul id="MenuItems">
            <li><a href="<?php echo glob_site_url; ?>">Home</a></li>
            <li><a href="<?php echo glob_site_url; ?>/products.php">Products</a></li>
            <li><a href="<?php echo glob_site_url; ?>/about.php">About</a></li>
            <li><a href="<?php echo glob_site_url; ?>/contact.php">Contact</a></li>
            <?php if(isset($_SESSION['uid'])){ ?>
            	<li><a href="<?php echo glob_site_url; ?>/account">Account</a></li>
            <?php }else{ ?>
            	<li><a href="<?php echo glob_site_url; ?>/login.php?reff=<?php echo $_SERVER['REQUEST_URI']; ?>">Login</a></li>
             <?php } ?>
            
            <li><a href="<?php echo glob_site_url; ?>/cart.php"><i class="fa fa-shopping-bag" ></i><span id="carts"><?php echo (@count($_SESSION['carts']) != 0)? @count($_SESSION['carts']) : ''; ?></span></a></li>
            
          </ul>
      </nav>
      <!--<img src="images/cart.png" width="30px" height="30px">--->
      <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
    </div>
    <div class="row">
      <div class="col-2">
        <h1>Skate for fun. <br>Not for fame.</h1>
        <p>The beauty of skating is that everybody has a unique set of variables that they can put in place and express their individual identity in the form of - call it - greatness.<br> - Rodney Mullen </p>
           <!--<a href="" class="btn">Explore Now &#8594;</a>-->
      </div>

      <div class="col-2">
        <img src="images/background4.png">
      </div>
    </div>
  </div>
</div>

<!------ Featured Categories ------->
<div class="categories">
  <div class="small-container">
    <div class="row">
      <div class="col-3">
          <img src="images/skate6.jpg">
      </div>
      <div class="col-3">
          <img src="images/skate7.jpg">
      </div>
      <div class="col-3">
          <img src="images/skate5.jpg">
      </div>
    </div>
  </div>

</div>

<!------ Featured Products ------->
<div class="small-container">
  <h2 class="title">Featured Products</h2>
  <div class="row">
  
  <?php 
  	$featured =  $pdo->get_f_products(); 
	foreach($featured as $prd){ ?>
    <div class="col-4">
       <a href="product/<?php echo $prd['product_id']; ?>_<?php echo urlencode(remove_slash($prd['product_name'])); ?>"><img src="images/<?php echo $prd['image_path']; ?>"></a>
        <h4><?php echo $prd['product_name']; ?></h4>
        <div class="rating">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star-o"></i>
        </div>
        <p>R<?php echo $prd['unit_price']; ?></p>
    </div>
    <?php }?>
    
  </div>

  <!------ Latest Products ------->
  <h2 class="title"> Latest Products </h2>
  <div class="row">
    <?php 
    $featured =  $pdo->get_l_products(); 
	foreach($featured as $prd){ ?>
    <div class="col-4">
       <a href="product/<?php echo $prd['product_id']; ?>_<?php echo urlencode(remove_slash($prd['product_name'])); ?>"><img src="images/<?php echo $prd['image_path']; ?>"></a>
        <h4><?php echo $prd['product_name']; ?></h4>
        <div class="rating">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star-o"></i>
        </div>
        <p>R1800.00</p>  ----->  <p><?php echo $prd['unit_price']; ?></p>
        
    </div>
    <?php } ?>
    
  </div>
</div>
  <!------ Offer Section ------->
  <div class="offer">
    <div class="small-container">
      <div class="row">
        <div class="col-2">
          <img src="images/simpsonsbag2.png" class="offer-img">
        </div>
        <div class="col-2">
          <p>Exclusively Available on WeAreSkate</p>
          <h1>Vans X The Simpsons Backpack</h1>
          <small>Vans and The Simpsons collab backpack, featuring a checkered pattern.</small>
          <a href="productBag.php" class="btn">Buy Now &#8594;</a>
        </div>
      </div>
    </div>
  </div>

<!------ Customer Testimoies ------->
<div class="testimonial">
  <div class="small-container">
    <div class="row">
      <div class="col-3">
        <i class="fa fa-quote-left"></i>
          <p>Very pleased with prices, quality & quick shipping.
Trustworthy and will continue to use your services for all my skating needs.</p>
          <div class="rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>
          <img src="images/user-1.png" >
          <h3>Sean Parker</h3>
      </div>
      <div class="col-3">
        <i class="fa fa-quote-left"></i>
          <p>Great prices, quick and easy shopping, and arrives in a fair amount of time. I use this site for cheaper skate gear and I will continue to be a customer at WeAreSkate</p>
          <div class="rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>
          <img src="images/user-2.png" >
          <h3>Mike Smith</h3>
      </div>
      <div class="col-3">
        <i class="fa fa-quote-left"></i>
          <p>All the best brands at the absolute best prices. WeAreSkate is my #1 pitstop for all skate related purchases</p>
          <div class="rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
          </div>
          <img src="images/user-3.png" >
          <h3>
Evalina Pullano</h3>
      </div>
    </div>
  </div>
</div>

<!------ Brands ------->
<div class="brands">
  <div class="small-container">
    <div class="row">
      <div class="col-5">
        <img src="images/vans2.png" >
      </div>
      <div class="col-5">
        <img src="images/element2.png" >
      </div>
      <div class="col-5">
        <img src="images/palace3.png" >
      </div>
      <div class="col-5">
        <img src="images/logo-paypal.png" >
      </div>
      <div class="col-5">
        <img src="images/flip.png" >
      </div>
    </div>
  </div>
</div>

<!------ footer ------->
<?php require("./templates/footer.php");  ?>

    
</body>
</html>




<?php

class mypdo{
	 public $pdc = null;
	 public function __construct(){
		 $host = dbhost;
		 $db   =  dbname;
		 $user  =  dbuser;
		 $pass  =   dbpass;
		 $charset = 'utf8mb4';
		 $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		 $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false,];
		 $this->pdc = new PDO($dsn, $user, $pass, $opt);
		 }
	 
	 	
	 
  public function get_f_products(){
	     
		 $qry = "SELECT a.product_id, a.product_name, a.unit_price, b.image_path  FROM products a JOIN images b ON a.product_id = b.product_id  WHERE a.featured = 1 AND b.is_main = 1 ORDER BY a.product_id";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetchAll();
	 
	 }
	 
	public function get_l_products(){
	     
		 $qry = "SELECT a.product_id, a.product_name, a.unit_price, b.image_path  FROM products a JOIN images b ON a.product_id = b.product_id  WHERE a.featured != 1 AND b.is_main = 1 ORDER BY a.product_id";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetchAll();
	 
	 }
	 
	 
}


