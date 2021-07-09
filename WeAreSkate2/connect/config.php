<?php


//  DATABASE SETTINGS   
define('dbhost', 'localhost');  //usually default
define('dbuser', 'root');
define('dbpass', '');
define('dbname', 'weareskate');
 



//define('glob_site_version', '1.0');   //
define('glob_site_url', 'http://localhost/WeAreSkate2');          // Site url FQD
//define('glob_site_url', 'https://2273bdf2638d.ngrok.io/WeAreSkate2');
 




/*paypa; settings */
define('glob_enable_sandbox', true);  //Live or sandbox
define('glob_business_email', 'sb-v0wlh1920599@business.example.com');  //paypal business email 
define('glob_paypal_url', 'https://sandbox.paypal.com/cgi-bin/webscr'); //sandbox or live

define('glob_zarusd_rate', 0.057); //Curency conversion zar to usd



//Do not edit

$glob_paypal_notify_url =  glob_site_url.'/connect/paypal_ipn.php';
$glob_paypal_cancel_url =  glob_site_url.'/payment/payment_cancelled.php';
$glob_paypal_return_url =  glob_site_url.'/payment/payment_confirmed.php';






function remove_slash($str){
	
	
	return str_replace('/', '-', $str);
	
}