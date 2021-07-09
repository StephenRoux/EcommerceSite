<?php

session_start();
require_once('../connect/config.php');

if(!isset($_SESSION['uid'])) die(header('Location: '. glob_site_url.'/login.php?reff='.$_SERVER['REQUEST_URI']));

$uid = $_SESSION['uid'];

$pdo = new mypdo();


$page_title =  'Account'; 

require("../templates/header.php");


$orders = $pdo->get_orders($uid);

$prof = $pdo->get_prof($uid);

?>  

<!------ cart items details ------->
    <div class="small-container cart-page" style="min-height:40vh; margin-top:10px;">
    <a style="color:#06C; font-weight:bold; float:right" href="<?php echo glob_site_url.'/login.php?logout='.time(); ?>">Logout</a>
     <a style="color:#06C; font-weight:bold;" href="<?php echo glob_site_url;?>/account/change_password.php">Change Password</a>
        <table class="prof_table"">
        	<tr>
                <th></th>
                <td></td>
            </tr>
        	<tr>
                <th>Name</th>
                <td><?php echo $prof['fname']; ?></td>
            </tr>
            <tr>
                <th>Email address</th>
                <td><?php echo $prof['email']; ?></td>
            </tr>
        </table>
        
        
        
        <h2 style="margin-bottom:20px; text-align:center">Recent Order by you </h2>
        
		<?php if(count($orders) == 0){  ?>
             
        	<p> You currently have no order</p>
        
        <?php } else{ ?> 
        <table class="cart_table" style="font-size:14px;">
        	<thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Satus</th>
                    <th>Order date</th>
                </tr>
             </thead>
             <tbody>
            <?php foreach($orders as $order) { ?>
			<tr>
                <td style="padding:10px;"><a style="color:#093; font-size:18px;" href="order_items/<?php echo $order['order_id']; ?>"><?php echo $order['order_id']; ?></a></td>
                <td><?php echo $order['total_amount']; ?></td>
                <td><?php echo ($order['payment_status'] == 1)? '<span class="fa fa-check" style="color:green"></span>': '<span class="fa fa-times" style="color:red"> not completed</span>'; ?></td>
                <td><?php echo date("Y m d", strtotime($order['date'])); ?></td>
                
           </tr>
           <?php } ?>
           </tbody>
        	
        </table> 
        
      <?php } ?> 
        
        
        
        
    </div>
    

<!------ footer ------->
<?php require("../templates/footer.php");  ?>

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
	 
	 	
	 
  public function get_orders($uid){
	     
		 $qry = "SELECT * FROM orders WHERE uid = ? ORDER BY date DESC";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
		 $stmt->execute();
		 return  $stmt->fetchAll();
	 
	}
	 
	   public function get_prof($uid){
	     
		 $qry = "SELECT * FROM users WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetch();
	 
	 }
	 
	
	 
}
