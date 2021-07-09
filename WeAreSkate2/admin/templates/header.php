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

<div class="header2" >
  <div class="container" style="background-color:#036">
    <div class="navbar">
      <div class="logo">
        <img src="<?php echo glob_site_url; ?>/images/WAS2.png" width="125px">
      </div>
      <nav>
          <ul id="MenuItems">
            <li><a href="<?php echo glob_site_url; ?>">Home</a></li>
            <li><a href="<?php echo glob_site_url; ?>/admin">Customers Order</a></li>
            <li><a href="<?php echo glob_site_url; ?>/admin/contact.php">Contacts</a></li>
            <li><a href="<?php echo glob_site_url; ?>/admin/change_password.php"><small style="color:#FFF">change password</small></a></li>
            <li><a> | </a></li>
            <li><a href="<?php echo glob_site_url; ?>/admin/login.php?logout=true"><small style="color:#FFF"> Logout</small></a></li>
          </ul>
      </nav>
      <img src="<?php echo glob_site_url; ?>/images/menu.png" class="menu-icon" onclick="menutoggle()">
    </div> 
  </div>
</div>
