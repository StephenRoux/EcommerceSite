<?php

session_start();
require_once('./connect/config.php');



$pdo = new mypdo();


$page_title =  'Checkout'; 

require("./templates/header.php");

$carts = $_SESSION['carts'];

$prd_ids = array();

foreach($carts as $key => $vals)
	$prd_ids[] = $key;
	
if(count($prd_ids) != 0) 
	$product = $pdo->get_all_products(implode(", ", $prd_ids));


?>  

<!------ Cart Items Details ------->

    <div class="small-container cart-page" style="min-height:40vh">
        <h2 style="margin-bottom:20px; text-align:center">Checkout </h2>
        <?php if(count($prd_ids) == 0){  ?>
             
        	<p> You currently have no Item in cart. Keep Shopping</p>
        
        <?php } else{ ?> 
        <table class="cart_table cart_zone" style="font-size:14px;">
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
                <td><?php echo $product[$key]['product_name']; ?><br><small><?php echo $cart[1]; ?></small></td>
                <td>R<?php echo $product[$key]['unit_price']; ?></small></td>
                <td><?php echo $cart[0]; ?><input type="hidden" value="<?php echo $cart[0]; ?>" min="1"></td>
                <td class="subtotal">R<?php echo ($cart[0] * $product[$key]['unit_price']); ?></td>
           </tr>
           <?php } ?>
           </tbody>
           <tfoot>
           		<tr><td colspan="3" style="text-align:left; font-weight:bold" >Total</td><td style="text-align:left; padding-top:20px; font-weight:bolder" id="total_p"></td><td></td></tr>
           </tfoot>
			
        </table> 
        <?php if(isset($_SESSION['uid'])){
			
			$prof =  $pdo->get_prof($_SESSION['uid']);
			
			?>
        
         <div style="max-width:490px;">
         <p class="billing_p">Billing Details</p>
           <form onsubmit="signup_proceed_to_payment(event, 'checkout')">
               <div class="form_gr">
                <label>FullName *</label>
                <input id="fname" value="<?php echo $prof['fname']; ?>" required minlength="4" />
               </div>
               <div class="form_gr">
                <label>Email Address *</label>
                <input style="background-color:#FCFCFC" id="email" value="<?php echo $prof['email']; ?>" readonly="readonly" required  type="email"/>
               </div>
               <div class="form_gr">
                <label>Phone Number</label>
                <input id="phone" type="tel" value="<?php echo $prof['phone']; ?>" />
                <input id="password" type="hidden" value="xxxxxxxxx" />
               </div>
               <div class="form_gr">
                <label>Delivery Address *</label>
                <textarea id="address" required minlength="8" rows="2" ><?php echo $prof['address']; ?></textarea>
               </div>
               <div id="error_msg"></div>
               
               <div id="sbutton">
                <button class="btn">Proceed to Payment </button>
               </div>
             </form>
        </div> 
        
        
        
        
        <?php } else{ ?>
        
         <p class="billing_p">Billing Details  ( signup before? <a href="login.php?reff=<?php echo $_SERVER['REQUEST_URI']; ?>">Login</a> to continue )</p>
         <div style="max-width:490px;">
           <form onsubmit="signup_proceed_to_payment(event, 'checkout')">
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
                <label>Delivery Address *</label>
                <textarea id="address" required minlength="8" rows="2"></textarea>
               </div>
               <div class="form_gr">
                <label>Password<br /><small>Please provide a secure password to login</small></label>
                <input id="password" required minlength="6" type="password" />
               </div>
               
               <div id="error_msg"></div>
               
               <div id="sbutton">
                <button class="btn">Proceed to Payment </button>
               </div>
             </form>
        </div> 
       
       <?php } ?>   
       <?php } ?>
    </div>
    

<!------ footer ------->
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
	 
	 	
<!-------Get products details------> 
  public function get_all_products($ids){
	     
		 $qry = "SELECT a.product_id, a.product_name, a.unit_price, b.image_path  FROM products a JOIN images b ON a.product_id = b.product_id  WHERE a.product_id IN($ids) AND b.is_main = 1 ORDER BY a.product_id";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->execute();
		 $all_pr = array();
		 while($row = $stmt->fetch())
		 	$all_pr[$row['product_id']] = $row;
		 return $all_pr;
	 
	 }
	 
    
    <!------Get users details------>
        
	   public function get_prof($uid){
	     
		 $qry = "SELECT * FROM users WHERE id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetch();
	 
	 }
	 
	
	 
}
