<?php
session_start();

require_once('../connect/config.php');

if(!isset($_SESSION['uid'])) die(header('Location: '. glob_site_url.'/login.php?reff='.$_SERVER['REQUEST_URI']));


$pdo = new mypdo();


$page_title =  'Payment'; 

$order_id = trim($_GET['idx']);



$uid = $_SESSION['uid'];

$odetails =  $pdo->get_order($order_id, $uid);


if($odetails['order_id'] == "") die(header('Location: '. glob_site_url));



require("../templates/header.php");

?>  



<div class="small-container">
    
    
  <div class="small-container">
  	<h1 style="text-align:center; margin:40px; color:#444"> Complete Payment </h1>
        <table class="payment_table">
        	<tr>
            	<th>Order ID</th>
                <td><?php echo $odetails['order_id']; ?> </td>
            </tr>
            <tr>
            	<th>Total Amount</th>
                <td>R<?php echo $odetails['total_amount']; ?></td>
            </tr>
            <tr>
            	<th>Payment method</th>
                <td>Paypal</td>
            </tr>
            
            <tr>
             <?php if($odetails['payment_status'] == 0){?>
                <td colspan="2">
                <form method="post" action="<?php echo glob_paypal_url; ?>">
                
                <input type='hidden' name='business' value='<?php echo glob_business_email; ?>'> 
                
                <input type='hidden' name='item_name' id="item_name" value="<?php echo $odetails['order_id']; ?>"> 
                <input type="hidden" id="custom_inpt" name="custom" value="<?php echo $odetails['order_id']; ?>">
                
                <input type='hidden' name='amount'  value="<?php echo number_format((float)($odetails['total_amount'] * glob_zarusd_rate), 2, '.', ''); ?>">
                <input type='hidden' name='no_shipping' value='1'> 
                <input type='hidden' name='currency_code' value='USD'>
                <input type='hidden' name='notify_url'  value='<?php echo $glob_paypal_notify_url; ?>'>
                 <input type='hidden' name='cancel_return' value='<?php echo $glob_paypal_cancel_url; ?>'>
                <input type='hidden' name='return'  value='<?php echo $glob_paypal_return_url; ?>'>
                <input type="hidden" name="cmd" value="_xclick">
                
                <input type="submit" name="pay_now" value="Pay Now" class="btn" style="margin-bottom:100px; cursor:pointer" />
                
                </form>
                </td>
                <?php } elseif($odetails['payment_status'] == 1){?>
                     <td colspan="2" style="color:#090; font-weight:bold; font-size:24px;">
                        Payment Completed
                          
                     </td>
                
                <?php } ?>
            </tr>
        
        
        </table>
        
  
  
  </div>
    
  
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
	 
	 	
	 
  public function get_order($order_id, $uid){
	     
		 $qry = "SELECT * FROM orders WHERE order_id = ? AND uid = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $order_id, PDO::PARAM_STR);
		 $stmt->bindParam(2, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetch();
	 
	 }
	 
}


