<?php
session_start();
    require_once('./connect/config.php');
$pdo = new mypdo();
    $page_title =  'All Products'; 
require("./templates/header.php");
?>  


<!------Products on Sale------->
<div class="small-container">
    
    <div class="row row-2">
        <h2>All Products</h2>
        <select>
            <option>Default Sorting </option>
            <option>Sort by price </option>
            <option>Sort by popularity </option>
            <option>Sort by rating</option>
            <option>Sort by sale</option>
        </select>
    </div>
    
    
  <div class="small-container">
  <div class="row">
    <?php 
  	$featured =  $pdo->get_all_products(); 
	foreach($featured as $prd){ ?>
    <div class="col-4">
       <a href="product/<?php echo $prd['product_id']; ?>_<?php echo urlencode(remove_slash($prd['product_name'])); ?>"><img src="images/<?php echo $prd['image_path']; ?>"></a>
        <h4><?php echo $prd['product_name']; ?></h4>
        <div class="rating">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star-o"></i>
        </div>
        <p>R<?php echo $prd['unit_price']; ?></p>
    </div>
    <?php }?>

  </div>
</div>
    
    <div class="page-btn">
        <span>1</span>
        <span>2</span>
        <span>3</span>
        <span>4</span>
        <span>&#8594;</span>
    
    </div>
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
	 
	 	
	 
  public function get_all_products(){
	     
		 $qry = "SELECT a.product_id, a.product_name, a.unit_price, b.image_path  FROM products a JOIN images b ON a.product_id = b.product_id  WHERE b.is_main = 1 ORDER BY a.product_id";
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $uid, PDO::PARAM_INT);
	     $stmt->execute();
		 return $stmt->fetchAll();
	 
	 }
	 
}


