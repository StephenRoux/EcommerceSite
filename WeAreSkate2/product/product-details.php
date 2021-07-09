<?php
session_start();

require_once('../connect/config.php');



$pdo = new mypdo();
$pid = $_GET['idn'];

$prd = $pdo->get_product($pid);

$pr_size = $pdo->get_product_size($pid);

$pr_img =  $pdo->get_product_images($pid);



$page_title =  $prd['product_name']; 

require("../templates/header.php");

?>  




<!------ single product details ------->

    <div class="small-container single-product">
        <div class="row">
            <div class="col-2">
                <img src="../images/<?php echo $prd['image_path']; ?>" width="100%" id="ProductImg">
                <div class="small-img-row">
                <?php
				$iflag = 0;
				while($iflag < 4){
                foreach($pr_img as $img){
                      $iflag++;
					  if($iflag > 4)continue;  	  
                    ?>
                    <div class="small-img-col">
                        <img src="../images/<?php echo $img; ?>" width="100%" class="small-img">
                    </div>
                 <?php }} ?>
                      
                </div>    
            </div>
            <div class="col-2">
                <p>Home / <?php echo $prd['category_name']; ?></p>
                <h1><?php echo $prd['product_name']; ?></h1>
                <h4>R<?php echo $prd['unit_price']; ?></h4>
                <?php 
				  if(count($pr_size) > 0){
						  
				?>
                	<select id="pr_type">
                        <option value="">Select Size</option>
					<?php 
                      foreach($pr_size as $size){
                        	  
                    ?>
                        <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                       <?php } ?>
                    </select>
                  <?php } 
				  
				  if(isset($_SESSION['carts'][$prd["product_id"]])){
					 
				  ?>
                  <span><?php echo $_SESSION['carts'][$prd["product_id"]][0]; ?> item(s)  added to cart <a href="../cart.php" class="btn"> Checkout</a></span>
                  <?php }else{ ?>
                <input type="number" value="1" id="quant">
                <span id="sbutton"><a style="cursor:pointer" onClick="add_to_cart(<?php echo $prd["product_id"]; ?>)" class="btn"> Add to Cart</a></span>
				<?php } ?>
                <h3>Delivery Details<i class="fa fa-indent"></i></h3>
                <br>
                <p>Orders placed & paid on work days before 20:00h are shipped the same day.</p>
            </div>
        </div>  
    </div>
    
<!------title -------> 
    <div class="small-container">
        <div class="row row-2">
            <h2>Related Products</h2>   
            <p>View More</p>
        </div>
    
    </div>
 

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
	 
	 	
	 
  public function get_product($pid){
	     
		 $qry = "SELECT a.product_id, a.product_name, a.unit_price, b.image_path, c.category_name  FROM products a JOIN images b ON a.product_id = b.product_id  JOIN category c ON a.category_id = c.category_id WHERE a.product_id = ? AND b.is_main = 1";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $pid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetch();
	 
	 }
	 
	  public function get_product_size($pid){
	     
		 $qry = "SELECT size   FROM sizes  WHERE product_id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $pid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetchAll(PDO::FETCH_COLUMN);
	 
	 }
	 public function get_product_images($pid){
	     
		 $qry = "SELECT image_path   FROM images  WHERE product_id = ?";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $pid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetchAll(PDO::FETCH_COLUMN);
	 
	 }
	 
	 
	 
}



