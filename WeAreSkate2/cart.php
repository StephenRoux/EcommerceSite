<?php

session_start();
require_once('./connect/config.php');



$pdo = new mypdo();


$page_title =  'carts'; 

if(isset($_SESSION['carts']))
	$carts = $_SESSION['carts'];
else
	$carts = array();
$prd_ids = array();

foreach($carts as $key => $vals)
	$prd_ids[] = $key;
	
if(count($prd_ids) != 0) 
	$product = $pdo->get_all_products(implode(", ", $prd_ids));

require("./templates/header.php");

?>  

<!------ Cart Items Details ------->

    <div class="small-container cart-page" style="min-height:40vh; margin-top:2px;">
        <h2 style="margin-bottom:20px; text-align:center">Cart</h2>
        <?php if(count($prd_ids) == 0){  ?>
        
        	<p> You currently have no Item in cart. keeo shopping</p>
        
        <?php } else{ ?> 
        <table class="cart_table cart_zone">
        	<thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th></th> 
                </tr>
             </thead>
             <tbody>
            <?php foreach($carts as $key => $cart) { ?>
				 
            <tr id="row_<?php echo $key; ?>" data-id="<?php echo $key; ?>" data-price="<?php echo $product[$key]['unit_price']; ?>"  data-type="<?php echo $cart[1]; ?>">
                <td><img style="max-height:100px;" src="images/<?php echo $product[$key]['image_path']; ?>"><br><?php echo $product[$key]['product_name']; ?><br><small><?php echo $cart[1]; ?></small></td>
                <td>R<?php echo $product[$key]['unit_price']; ?></small></td>
                <td><input type="number" value="<?php echo $cart[0]; ?>" min="1"></td>
                <td class="subtotal">R<?php echo ($cart[0] * $product[$key]['unit_price']); ?></td>
                <td><button class="fa fa-times"></button></td>
           </tr>
           <?php } ?>
           </tbody>
           <tfoot>
           		<tr><td colspan="3" style="text-align:left;" >Total</td><td style="text-align:left; padding-top:20px; font-weight:bolder" id="total_p"></td><td></td></tr>
                <tr><td colspan="5" style="text-align:center;" ><a href="checkout.php" class="btn"> Checkout</a></td></tr>
           </tfoot>
			
        </table> 
        
        <?php } ?>
    </div>
    

<!------ Footer ------->
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
	 
	 	
<!---------Cart/Products-------->
    
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
	 
}
