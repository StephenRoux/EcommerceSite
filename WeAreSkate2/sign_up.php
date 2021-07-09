<?php

session_start();
require_once('./connect/config.php');


if(isset($_SESSION['uid'])) header("Location: ./");

$pdo = new mypdo();


$page_title =  'Sign Up'; 

require("./templates/header.php");



?>  

<!------ Sign Up Section------->
    <div class="small-container cart-page" style="min-height:40vh; text-align:center">
        <h2 style="margin-bottom:20px;">Sign Up </h2>
        
         <div style="max-width:490px; display:inline-block; text-align:left">
        
         <div style="max-width:490px;">
           <form onsubmit="signup_proceed_to_payment(event, 'sign_up')">
               <div class="form_gr">
                <label>FullName *</label>
                <input id="fname" required minlength="4" />
               </div>
               <div class="form_gr">
                <label>Email Address *</label>
                <input id="email" required  type="email"/>
               </div>
               <div class="form_gr">
                <label>Phone Number</label>
                <input id="phone" type="tel" />
               </div>
               <div class="form_gr">
                <label>Address *</label>
                <textarea id="address" required minlength="8" rows="2"></textarea>
               </div>
               <div class="form_gr">
                <label>Password<br /><small>Please provide a secure password to login</small></label>
                <input id="password" required minlength="6" type="password" />
               </div>
               
               <div id="error_msg"></div>
               
               <div id="sbutton">
                <button class="btn">Sign Up </button>
               </div>
             </form>
       
        </div> 
       
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
	 
	 	
	 
  public function get_all_products($ids){
	     
		 $qry = "SELECT a.product_id, a.product_name, a.unit_price, b.image_path  FROM products a JOIN images b ON a.product_id = b.product_id  WHERE a.product_id IN($ids) AND b.is_main = 1 ORDER BY a.product_id";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->execute();
		 $all_pr = array();
		 while($row = $stmt->fetch())
		 	$all_pr[$row['product_id']] = $row;
		 return $all_pr;
	 
	 }
	 
	   public function get_prof($uid){
	     
		 $qry = "SELECT * FROM users WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetch();
	 
	 }
	 
	
	 
}
