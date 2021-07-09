<?php

session_start();

require_once('./connect/config.php');

$page_title =  'About us'; 

require("./templates/header.php");

?>  

  <div class="row">
    <div class="col-10">
        <img src="images/finallogoweareskate.png">
        <h4>About Us</h4>
        <br>
        <p>WeAreSkate is your number one stop for all skate-related items, clothing, accessories and gear. Here at WeAreSkate, we strive to provide a great experience to each individual customer, ensuring your experience with us, from browsing products to the purchasing and delievery of said products is a pleasant and hassle free process. </p>
    </div>
  </div>

  
   
  
<!------ footer ------->
<?php require("./templates/footer.php");  ?>


    
</body>
</html>