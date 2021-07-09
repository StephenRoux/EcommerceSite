<?php
session_start(); 

require '../connect/config.php';	





///##################################################
/////      SIGN IN FOR USER AND ADMIN
///####################################################

if(isset($_POST['ch']) && $_POST['ch'] == 'sign_in') {
		$errMsg = '';

		$email = $_POST['email'];
		$password = $_POST['password'];
		$utype = $_POST['utype'];
		
		if(strlen($email) < 3)
			$errMsg = 'Enter username<br>';
	    if(strlen($password) < 3)
			$errMsg = 'Enter password<br>';

		if($errMsg != ''){
			$die($errMsg);
		}
		
		$pdo = new mypdo();
		if($utype == 'user')
			$profn = $pdo->get_user($email, 'users');
	  	else
			$profn = $pdo->get_user($email, 'admins');
	  if($profn == null){
		$msg = 'Email password not match';
		die($msg);  
	 }
		
	  
 	$verify = password_verify($password, $profn['password']);
	  if($verify){
		  
		@session_start();
		$_SESSION['email'] = $profn['email'];
		if($utype == 'user')
			$_SESSION['uid'] = $profn['id'];
		else
			$_SESSION['admina'] = $profn['id'];
			
		die('PASS');		 
}
else{
	    $msg = 'Email password not match';
		die($msg); 
	
	}

}




///##################################################
/////      SIGN UP
///####################################################

if(isset($_POST['ch']) && $_POST['ch'] == 'pay_proceed') {
		$errMsg = '';

		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$fname = $_POST['fname'];
		$address = $_POST['address'];
		$password = $_POST['password'];
		$trigger = $_POST['trigger'];
		
		if(strlen($email) < 6)
			$errMsg = 'Enter Email<br>';
	    if(strlen($password) < 6)
			$errMsg = 'Enter password<br>';
		if(strlen($fname) < 3)
			$errMsg = 'Enter Full Name<br>';

		if($errMsg != ''){
			die($errMsg);
		}
		
		$pdo = new mypdo();
		
		/*   check if Email already exist*/
	   if($pdo->check_user($email, 'email') && !isset($_SESSION['uid']))
		   die('Error! Email address already exist. Please login to continue');
		   
		
		$pwd = password_hash($password, PASSWORD_DEFAULT);
	    
	   if(isset($_SESSION['uid']))
	    	$profn = $pdo->update_user($_SESSION['uid'], $email, $fname, $phone, $address);
		else
			$profn = $pdo->insert_user($email, $fname, $phone, $address, $pwd);
	    
		if(substr($profn, 0, 4) == "PASS"){
			
			$uid =  substr($profn, 4);
			
			$_SESSION['uid'] = $uid;
			$_SESSION['email'] = $email;
			
			if($trigger == "checkout")
				create_order($pdo, $uid);
		
		}
		die($profn);
	
	  
	   
	  
		 
}



function  create_order($pdo, $uid){
	
	
	//Process order	
			
	   $letter = array( 1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E',6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z');
		
		$order_id = "WAS";
		
		$order_id .= mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).time();
	
	
	
	$carts = $_SESSION['carts'];
	
	$prd_ids = array();
	
	foreach($carts as $key => $vals)
		$prd_ids[] = $key;
		
	if(count($prd_ids) != 0) 
		$product = $pdo->get_all_products(implode(", ", $prd_ids));
	
	$total = 0.00;
	foreach($carts as $key => $cart){
		
		$sub_total = $cart[0] * $product[$key]['unit_price'];
		$total += $sub_total;
		$pdo->add_item($order_id, $key, $cart[0], $product[$key]['unit_price'], $cart[1]);	
		
	}
	
	$pdo->new_order($uid, $order_id, $total);
	
	unset($_SESSION['carts']);
	
	die('PASS'.$order_id);
	
}


///##################################################
/////     Change Password
///####################################################

if(isset($_POST['ch']) && $_POST['ch'] == 'change_password') {
        
		// If not login as either admin or user
		if(!isset($_SESSION['uid']) && !isset($_SESSION['uid'])) die('not allowed'); 
		
		$password =  $_POST['password'];
		$password_1 =  $_POST['password1'];
		$password_2 =  $_POST['password2'];
		
		$utype = $_POST['utype'];
		
		if(($password_1 != $password_2)  || (strlen($password_1) < 6))
			die('Please retype password. New password not match');
		
		$pdo = new mypdo();    //Instantiate new PDO class
		
		if($utype == 'user')
			$profn = $pdo->get_user_2($_SESSION['uid'], 'users');
		else
			$profn = $pdo->get_user_2($_SESSION['admina'], 'admins');
			
		
		$verify = password_verify($password, $profn['password']);
	  	if(!$verify)
			die('Old password is incorrect');
	   
	   $password =  password_hash($password_1, PASSWORD_DEFAULT);
	 	
		if($utype == 'user')
			die($pdo->update_password($_SESSION['uid'], $password, 'users'));
		else
			die($pdo->update_password($_SESSION['admina'], $password, 'admins'));
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
	 
	 	
		
	public function get_user($email, $table){
		
		 $qry = "SELECT id, password,  email FROM $table WHERE email = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $email, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return $stmt->fetch(); else return null;
		  
	 
	 }
	 
	 public function get_user_2($id, $table){
		
		 $qry = "SELECT id, password,  email FROM $table WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $id, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return $stmt->fetch(); else return null;
		  
	 
	 }
	 
	
	public function check_user($val, $ch){
		
		$qry = "SELECT id  FROM users WHERE $ch = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $val, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return true; else return false;
		 }
	 
	 
  public function insert_user($email, $fname, $phone, $address, $pwd){
		  $qry = "INSERT INTO users(email, fname, phone, address,  password)VALUES(?, ?, ?, ?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $email, PDO::PARAM_STR);
		 $stmt->bindParam(2, $fname, PDO::PARAM_STR);
		 $stmt->bindParam(3, $phone, PDO::PARAM_STR);
		 $stmt->bindParam(4, $address, PDO::PARAM_STR);
		 $stmt->bindParam(5, $pwd, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'.$this->pdc->lastInsertId(); else return 'An error occured while creating account';
		  
	 
	 }
	 
	
	 public function update_user($uid, $email, $fname, $phone, $address){
		  $qry = "UPDATE users SET fname = ?, phone = ?, address = ? WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $fname, PDO::PARAM_STR);
		 $stmt->bindParam(2, $phone, PDO::PARAM_STR);
		 $stmt->bindParam(3, $address, PDO::PARAM_STR);
		 $stmt->bindParam(4, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 return 'PASS'.$uid;
		  
	 
	 }
	 
	 
	 public function get_profile($email){
		$qry = "SELECT email, fname FROM users WHERE email = ?"; 
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $email, PDO::PARAM_STR);
		 $stmt->execute();
		 if($stmt->rowCount() < 1)
		 die('No record for this Email address');
		 else{
		  $row = $stmt->fetch();
		  return $row;
		    }
		 }
	   
	  
	  public function add_item($order_id, $product_id, $quant, $price,$extra){
		 $qry = "INSERT INTO order_items (order_id, product_id, quant, unit_price, extra) VALUES(?, ?, ?, ?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $order_id, PDO::PARAM_STR);
		 $stmt->bindParam(2, $product_id, PDO::PARAM_INT);
		 $stmt->bindParam(3, $quant, PDO::PARAM_STR);
		 $stmt->bindParam(4, $price, PDO::PARAM_STR);
		 $stmt->bindParam(5, $extra, PDO::PARAM_STR);
		 $stmt->execute();		 
	} 
	
	 public function new_order($uid, $order_id, $total){
		 $qry = "INSERT INTO orders (uid, order_id, total_amount) VALUES(?, ?, ?)";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
		 $stmt->bindParam(2, $order_id, PDO::PARAM_INT);
		 $stmt->bindParam(3, $total, PDO::PARAM_STR);
		 $stmt->execute();		 
	} 
	   
	  
	  public function get_all_products($ids){
	     
		 $qry = "SELECT a.product_id, a.product_name, a.unit_price, b.image_path  FROM products a JOIN images b ON a.product_id = b.product_id  WHERE a.product_id IN($ids) AND b.is_main = 1 ORDER BY a.product_id";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->execute();
		 $all_pr = array();
		 while($row = $stmt->fetch())
		 	$all_pr[$row['product_id']] = $row;
		 return $all_pr;
	 
	 }
	 
	 
	  public function update_password($id, $password, $table){
		// try{
		  $qry = "UPDATE $table SET password = ? WHERE  id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $password, PDO::PARAM_STR);
		 $stmt->bindParam(2, $id, PDO::PARAM_INT);
		 $stmt->execute();
		 if($stmt->rowCount() > 0) return 'PASS'; else die('No update was made');
		  
	 
	 }

	   
	   
	   
	 
}




function validate($field, $limit, $value, $extra = ''){
	
	  if(strlen($value) < $limit) $GLOBALS['global_report'] .=  'Not a valid data entry provided for '.$field.'<br><br>';
	  
	if($extra != '') // This must be a password field
	if($value  != $extra) $GLOBALS['global_report'] .=  'Password not match<br><br>';
	  
    if($extra != '') // This must be a password field; return a hash password
		return password_hash($value, PASSWORD_DEFAULT);
	else  /// Purify the string from html 
        return htmlspecialchars($value,  ENT_COMPAT);
	
	
	
}




