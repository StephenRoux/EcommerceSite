<?php 
namespace Listener;

ini_set("log_errors", 1);
ini_set("error_log", ".ipnphp-error.log");

file_put_contents('meeee.txt', 'accc');


require "config.php";



// Set this to true to use the sandbox endpoint during testing:
$enable_sandbox = glob_enable_sandbox;

// Use this to specify all of the email addresses that you have attached to paypal:
$my_email_addresses = array(glob_business_email);


// Set this to true to send a confirmation email:
$send_confirmation_email = false;
$confirmation_email_address = "My Name <my_email_address@gmail.com>";
$from_email_address = "My Name <my_email_address@gmail.com>";


// Set this to true to save a log file:
$save_log_file = true;
$log_file_dir = __DIR__ . "/logs";

// Here is some information on how to configure sendmail:
// http://php.net/manual/en/function.mail.php#118210



require('PaypalIPN.php');
use PaypalIPN;
$ipn = new PaypalIPN();
if ($enable_sandbox) {
    $ipn->useSandbox();
}
$verified = $ipn->verifyIPN();

$data_text = "";
foreach ($_POST as $key => $value) {
    $data_text .= $key . " = " . $value . "\r\n";
}

$test_text = "";
if ($_POST["test_ipn"] == 1) {
    $test_text = "Test ";
}

// Check the receiver email to see if it matches your list of paypal email addresses
$receiver_email_found = false;
foreach ($my_email_addresses as $a) {
    if (strtolower($_POST["receiver_email"]) == strtolower($a)) {
        $receiver_email_found = true;
        break;
    }
}


list($year, $month, $day, $hour, $minute, $second, $timezone) = explode(":", date("Y:m:d:H:i:s:T"));
$date = $year . "-" . $month . "-" . $day;
$timestamp = $date . " " . $hour . ":" . $minute . ":" . $second . " " . $timezone;
$dated_log_file_dir = $log_file_dir . "/" . $year . "/" . $month;

$paypal_ipn_status = "VERIFICATION FAILED";
if ($verified) {
    $paypal_ipn_status = "RECEIVER EMAIL MISMATCH";
    if ($receiver_email_found) {
        $paypal_ipn_status = "Completed Successfully";


        // Process IPN
        // A list of variables are available here:
        // https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/

        // This is an example for sending an automated email to the customer when they purchases an item for a specific amount:
        
		
		$tran_id = $_POST["txn_id"];
		
		$order_id = $_POST['custom'];
		
		
		$mc_gross = $_POST["mc_gross"];
		
		
		$pdo = new mypdo();
		
		$supposed_fee  = number_format((float)($pdo->get_supposed_fee($order_id) * glob_zarusd_rate), 2, '.', '');
		
		$diff_p  =  (float)$mc_gross - $supposed_fee;
		
		if((abs($diff_p) < 0.01) && $_POST["mc_currency"] == "USD" && $_POST["payment_status"] == "Completed"){  //Save amount to conside
			
			$valid =  1;
			
			$pdate = date("Y-m-d H:i", time());
			
			$pdo->update_transaction($order_id, $tran_id); 
		
		//TODO
		// Send email to customer
		
		
		}
		
		
		

    }
} elseif ($enable_sandbox) {
    if ($_POST["test_ipn"] != 1) {
        $paypal_ipn_status = "RECEIVED FROM LIVE WHILE SANDBOXED";
    }
} elseif ($_POST["test_ipn"] == 1) {
    $paypal_ipn_status = "RECEIVED FROM SANDBOX WHILE LIVE";
}

if ($save_log_file) {
    // Create log file directory
    if (!is_dir($dated_log_file_dir)) {
        if (!file_exists($dated_log_file_dir)) {
            mkdir($dated_log_file_dir, 0777, true);
            if (!is_dir($dated_log_file_dir)) {
                $save_log_file = false;
            }
        } else {
            $save_log_file = false;
        }
    }
    // Restrict web access to files in the log file directory
    $htaccess_body = "RewriteEngine On" . "\r\n" . "RewriteRule .* - [L,R=404]";
    if ($save_log_file && (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body)) {
        if (!is_dir($log_file_dir . "/.htaccess")) {
            file_put_contents($log_file_dir . "/.htaccess", $htaccess_body);
            if (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body) {
                $save_log_file = false;
            }
        } else {
            $save_log_file = false;
        }
    }
    if ($save_log_file) {
        // Save data to text file
        file_put_contents($dated_log_file_dir . "/" . $test_text . "paypal_ipn_" . $date . ".txt", "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text . "\r\n", FILE_APPEND);
    }
}

if ($send_confirmation_email) {
    // Send confirmation email
    mail($confirmation_email_address, $test_text . "PayPal IPN : " . $paypal_ipn_status, "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text, "From: " . $from_email_address);
}

// Reply with an empty 200 response to indicate to paypal the IPN was received correctly
header("HTTP/1.1 200 OK");






use PDO;

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
	 
	 	
	 
	 
	public function update_transaction($order_id, $tran_id){
		$qry = "UPDATE  orders  SET payment_status = 1, tran_id = ? WHERE order_id = ?"; 
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $tran_id, PDO::PARAM_STR);
		 $stmt->bindParam(2, $order_id, PDO::PARAM_STR);
		 $stmt->execute();
		  return 'PASS';
	} 
	
	public function get_supposed_fee($order_id){
		
		$qry = "SELECT total_amount FROM orders WHERE order_id = ?"; 
		 $stmt = $this->pdc->prepare($qry);
		 $stmt->bindParam(1, $order_id, PDO::PARAM_STR);
		 $stmt->execute();
		 return $stmt->fetchColumn();
		
		
	} 
	  
}


