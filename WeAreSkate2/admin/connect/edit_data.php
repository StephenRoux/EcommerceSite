<?php
session_start(); 

session_write_close(); //prevent session locking

$dataz = json_decode(file_get_contents('php://input'), true);

require '../../connect/config.php';

if(isset($_SESSION['admina'])){
	$idc = 	$_SESSION['admina'];
 }
else{
	
	die(die(json_encode(array("error" => 'auttentication error. Please refresh browser and login'))));
	
	}



if(isset($_POST['action']) && $_POST['action'] == 'remove'){
	$pdo = new mypdo();
    foreach($_POST['data'] as $index => $val){
		
		//Delete related order Items
		$pdo->delete_order_item($index);
			
	}
	
}

include( "./lib/DataTables.php" );
 
use 
	DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\Mjoin,
    DataTables\Editor\Options,
    DataTables\Editor\Upload,
    DataTables\Editor\Validate;



if(isset($_REQUEST['table']) &&  $_REQUEST['table'] = 'contact_me'){
	
	$editor = Editor::inst( $db, 'contact_me', 'id' )
		->fields(
			Field::inst( 'id', 0 )
		)
		->process( $_POST )
		->json();
}
else{
	
	$editor = Editor::inst( $db, 'orders', 'order_id' )
		->fields(
			Field::inst( 'payment_status', 3 ),
			Field::inst( 'order_status', 4 )
			
		)
		->process( $_POST )
		->json();
	
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
	 
	
	public function delete_order_item($index){ 
		 
		$qry = "DELETE FROM order_items  WHERE order_id =  ?";
		$stmt = $this->pdc->prepare($qry);
		$stmt->bindParam(1, $index, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	

}
	