<?php
session_start(); 

session_write_close(); //prevent session locking

require '../../connect/config.php';

if(isset($_SESSION['admina'])){
	$idc = 	$_SESSION['admina'];
 }
else{
	
	die(die(json_encode(array("error" => 'auttentication error. Please refresh browser and login'))));
	}



/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
//$table = 'trade_lines';

if($_GET['table'] == 'orders'){

	$table = "(SELECT a.order_id, a.total_amount, a.payment_status, a.order_status, a.date, b.fname, b.email, b.phone, b.address FROM orders a LEFT JOIN users b ON a.uid = b.id) temp";
	
	// Table's primary key
	$primaryKey = 'order_id';
				 
	$columns = array(
		array( 'db' => 'order_id', 'dt' => 1 ),
		array( 'db' => 'total_amount',  'dt' => 2 ),
		array( 'db' => 'payment_status',   'dt' => 3 ),
		array( 'db' => 'order_status',     'dt' => 4 ),
		array( 'db' => 'date',     'dt' => 5 ),
		array( 'db' => 'fname',     'dt' => 6 ),
		array( 'db' => 'email',     'dt' => 7 ),
		array( 'db' => 'phone',     'dt' => 8 ),
		array( 'db' => 'address',     'dt' => 9 ),
		
	);

}

elseif($_GET['table'] == 'order_items'){
	$order_id = $_REQUEST['order_id'];

	$table = "(SELECT a.*, (a.unit_price * a.quant) as subtotal, b.product_name, c.image_path  FROM order_items a JOIN products b ON a.product_id = b.product_id JOIN images c ON a.product_id = c.product_id  WHERE a.order_id = '$order_id' AND c.is_main = 1) temp";
	
	// Table's primary key
	$primaryKey = 'order_id';
				 
	$columns = array(
		array( 'db' => 'product_name', 'dt' => 1 ),
		array( 'db' => 'image_path',  'dt' => 2 ),
		array( 'db' => 'quant',   'dt' => 3 ),
		array( 'db' => 'unit_price',     'dt' => 4 ),
		array( 'db' => 'extra',     'dt' => 5 ),
		array( 'db' => 'subtotal',     'dt' => 6 ),		
	);

}


elseif($_GET['table'] == 'contact_me'){
	
	$table = "contact_me";
	
	// Table's primary key
	$primaryKey = 'id';
				 
	$columns = array(
		array( 'db' => 'id', 'dt' => 0 ),
		array( 'db' => 'fname', 'dt' => 1 ),
		array( 'db' => 'email',  'dt' => 2 ),
		array( 'db' => 'phone',   'dt' => 3 ),
		array( 'db' => 'gender',     'dt' => 4 ),
		array( 'db' => 'message',     'dt' => 5 )
	);

}




 
// SQL server connection information
$sql_details = array(
    'user' => dbuser,
    'pass' => dbpass,
    'db'   => dbname,
    'host' => dbhost
);
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp_class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
);