<?php
session_start();

require_once('../../connect/config.php');

if(!isset($_SESSION['uid'])) die(header('Location: '. glob_site_url.'/login.php?reff='.$_SERVER['REQUEST_URI']));


$pdo = new mypdo();


$order_id = trim($_GET['idx']);

$page_title =  'Order '.$order_id; 


$uid = $_SESSION['uid'];

$odetails =  $pdo->get_order($order_id, $uid);


if($odetails['order_id'] == "") die(header('Location: '. glob_site_url));





$items = $pdo->get_order_items($order_id);

$prd_ids = array();

foreach($items as $item)
	$prd_ids[] = $item['product_id'];
	
if(count($prd_ids) != 0) 
	$product = $pdo->get_all_products(implode(", ", $prd_ids));

require("../../templates/header.php");

?>  

<!------ cart items details ------->
    <div class="small-container cart-page" style="min-height:40vh; margin-top:2px;">
        <h2 style="margin-bottom:20px; text-align:center; margin:30px">Order - <?php echo $odetails['order_id']; ?></h2>
        
        <table class="cart_table">
        	<thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
             </thead>
             <tbody>
            <?php foreach($items as $item) { ?>
				 
            <tr>
                <td><img style="max-height:70px;" src="../../images/<?php echo $product[$item['product_id']]['image_path']; ?>"><br><a style="color:#03C" href="<?php echo glob_site_url.'/product/'.$item['product_id'].'_'.urlencode(remove_slash($product[$item['product_id']]['product_name'])); ?>"><?php echo $product[$item['product_id']]['product_name']; ?></a><br><small><?php echo $item['extra']; ?></small></td>
                <td>R<?php echo $item['unit_price']; ?></small></td>
                <td><?php echo $item['quant']; ?></td>
                <td class="subtotal">R<?php echo ($item['unit_price'] * $item['quant']); ?></td>
           </tr>
           <?php } ?>
           </tbody>
           <tfoot>
           		<tr><td colspan="3" style="text-align:left;" >Total</td><td style="text-align:left; padding-top:20px; font-weight:bolder" id="total_p">R<?php echo $odetails['total_amount']; ?></td><td></td></tr>
           </tfoot>
			
        </table> 
        
        
        
    </div>



<!------ footer ------->
<?php require("../../templates/footer.php");  ?>

    
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
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 $all_pr = array();
		 while($row = $stmt->fetch())
		 	$all_pr[$row['product_id']] = $row;
		 return $all_pr;
	 
	 }	 	
	 
  
  public function get_order($order_id, $uid){
	     
		 $qry = "SELECT * FROM orders WHERE order_id = ? AND uid = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $order_id, PDO::PARAM_STR);
		 $stmt->bindParam(2, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetch();
	 
	 }
	 
	public function get_order_items($order_id){
	     
		 $qry = "SELECT * FROM order_items WHERE order_id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $order_id, PDO::PARAM_STR);
	     $stmt->execute();
		 return $stmt->fetchAll();
	 
	 }
	 
}


