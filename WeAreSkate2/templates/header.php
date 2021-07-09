<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WeAreSkate - <?php echo $page_title; ?></title>
  <link rel="stylesheet" href="<?php echo glob_site_url; ?>/css/style.css">
  <link href="https://fonts.googleapis.com/
  css2?family=Poppins:wght@300;400;500;600;700&display=swap"
  rel="stylesheet">
  <link rel="stylesheet" href="<?php echo glob_site_url; ?>/css/font-awesome.min">
  <link rel="stylesheet" href="<?php echo glob_site_url; ?>/css/main.css">
  
</head>
<body>

<div class="header2">
  <div class="container">
    <div class="navbar">
      <div class="logo">
        <img src="<?php echo glob_site_url; ?>/images/WAS2.png" width="125px">
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
                <li><a href="<?php echo glob_site_url; ?>/sign_up.php?reff=<?php echo $_SERVER['REQUEST_URI']; ?>">Sign Up</a></li>
             <?php } ?>
            
            <li><a href="<?php echo glob_site_url; ?>/cart.php"><i class="fa fa-shopping-bag" ></i><span id="carts"><?php echo (@count($_SESSION['carts']) != 0)? @count($_SESSION['carts']) : ''; ?></span></a></li>
          </ul>
      </nav>
      <img src="<?php echo glob_site_url; ?>/images/menu.png" class="menu-icon" onclick="menutoggle()">
    </div> 
  </div>
</div>
