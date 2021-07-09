<?php
session_start();

require_once('./connect/config.php');






if(isset($_REQUEST['logout'])){   ///Logout  area
    @session_start();	   
	session_unset();
	session_destroy();
	die(header('Location: ./'));
	
}

else {




$pdo = new mypdo();


$page_title =  'Login'; 

require("./templates/header.php");

?>  



<div class="small-container">
    
    
  <div class="small-container">
        <h2 style="margin:40px 20px;">Login</h2>
 		<form action="#" method="post" onSubmit="sign_in(event, 'user')"  style="max-width:400px;">
                    
                    <div class="form_gr">
                      <label for="m_email">Email Addess</label>
                      <input  reqiured  class="form-control" id="email" type="email">
                    </div>
                    <div class="form_gr">
                      <label for="m_password">Password</label>
                      <input type="password" required class="form-control" id="password" name="password">
                      
                    </div>
                    <div><div id="error_msg" style=" margin: 20px;"></div>
</div>
                    <div class="form_gr" id="sbutton" style="text-align: center">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Log in">
                    </div>
			
           </form>
  
  
  </div>
    
  
</div>



<!------ footer ------->
<script>
<?php if(isset($_GET['reff'])) echo 'var glob_reff = "'.$_GET['reff'].'"'; else  echo 'var glob_reff = "'.glob_site_url.'"'; ?>

</script>

<?php require("./templates/footer.php");  ?>

    
</body>
</html>

<?php
}

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
	 
	 	
	 
  public function get_all_products(){
	     
		 $qry = "SELECT a.product_id, a.product_name, a.unit_price, b.image_path  FROM products a JOIN images b ON a.product_id = b.product_id  WHERE b.is_main = 1 ORDER BY a.product_id";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetchAll();
	 
	 }
	 
}


