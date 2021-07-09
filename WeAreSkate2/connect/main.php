<?php
session_start(); 


require '../connect/config.php';	





///##################################################
/////      ADD CART
///####################################################

if(isset($_POST['ch']) && $_POST['ch'] == 'add_cart') {
    
	$pid = (int)$_POST['product_id'];
	
	$_SESSION['carts'][$pid] = array($_POST['quant'], $_POST['type']);
	
	die('PASS');

}


///##################################################
/////      REMOVE CART
///####################################################

elseif(isset($_POST['ch']) && $_POST['ch'] == 'remove_cart') {
    
	unset($_SESSION['carts'][$_POST['product_id']]);
	
	die('PASS');

}




///##################################################
/////      CONTACT US
///####################################################

elseif(isset($_POST['ch']) && $_POST['ch'] == 'contact_us') {
		$errMsg = '';

		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$fname = $_POST['fname'];
		$message = $_POST['message'];
		$gender = $_POST['gender'];
		
		if(strlen($email) < 6)
			$errMsg = 'Enter Email<br>';
	    if(strlen($message) < 4)
			$errMsg = 'Enter password<br>';
		if(strlen($fname) < 3)
			$errMsg = 'Enter Full Name<br>';

		if($errMsg != ''){
			die($errMsg);
		}
		
		$pdo = new mypdo();
		
		$profn = $pdo->new_contact_message($email, $fname, $phone, $message, $gender);
	    
		die($profn);
	
	  
	   
	  
		 
}





class mypdo{
	 public $pdc = null;
	 public function __construct(){
		 $host = dbhost;
		 $db   =  dbname;
		 $user  =  dbuser;
		 $pass  =   dbpass;
		 $charset = 'utf8';
		 $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		 $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false,];
		 $this->pdc = new PDO($dsn, $user, $pass, $opt);
		 }
	 
	 	
		
	 
  public function new_contact_message($email, $fname, $phone, $message, $gender){
		  $qry = "INSERT INTO contact_me(email, fname, phone, message,  gender)VALUES(?, ?, ?, ?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $email, PDO::PARAM_STR);
		 $stmt->bindParam(2, $fname, PDO::PARAM_STR);
		 $stmt->bindParam(3, $phone, PDO::PARAM_STR);
		 $stmt->bindParam(4, $message, PDO::PARAM_STR);
		 $stmt->bindParam(5, $gender, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else return 'An error occured while creating account';
		  
	 
	 }
	 
		 
	 
}

