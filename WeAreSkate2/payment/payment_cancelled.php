<?php
session_start();
require '../connect/config.php';	

$page_title = "Your Payment"; // Title of page
$header_n = 'Your payment';


require_once('../templates/header.php');





?>  
    <div class="container main_container" style="min-height:40vh">
    	   	     
    
    
			<h1 style="text-align:center; margin-top:50px; font-size:40px; color:#900"> <span class="fa fa-times"></span></h1>
            <h1 style="text-align:center; margin-top:20px; color:#900"> Payment was Cancel</h1>
            
            <p style="text-align:center; size:18px">
            </p>


	</div>
  
 
    
    
    <?php require_once('../templates/footer.php');
?>

</body>
</html>

