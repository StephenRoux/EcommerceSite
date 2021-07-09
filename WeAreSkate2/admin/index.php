<?php
session_start();

require_once('../connect/config.php');


if(!isset($_SESSION['admina'])) die(header('Location: ./login.php?reff='.$_SERVER['REQUEST_URI']));



$page_title =  'Users Order'; 

require("./templates/header.php");

?>  



<link rel="stylesheet" type="text/css" href="datatable/css/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="datatable/css/editor.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="datatable/css/buttons.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="datatable/css/dataTables.fontAwesome.css" />

<style>
.my_table td{border:1px solid #999; font-size:14px;}

.my_table td a{ color:#0C0; font-weight:bold; cursor:pointer}

.my_table td img{ max-height:50px;}

#myTable th input{ max-width:70px; height:30px;}

#myTable2{ min-width:100%}

#cur_order{color:#0FC;}


</style>


<div class="small-container" style="min-height:70vh">
          <h2 style="color:#555; text-align:center; margin:20px 0px;">Customers Orders</h2>
  
  
  <div class="table-responsive" style="overflow-x: auto">        
   <table id="myTable" class="my_table">
        <thead>
             <tr>
            	<th id="quick_add_th"><span class="my_col_vis">Select</span></th>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Order Status</th>
                <th>Order Date</th>
                <th>Cust. Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                
             </tr>
             
             <tr>
            	<th></th>
                <th class="sch"></th>
                <th></th>
                <th class=""></th>
                <th class=""></th>
                <th></th>
                <th class="sch"></th>
                <th class="sch"></th>
                <th class="sch"></th>
                <th></th>
                
             </tr>
            
	     </thead>
       </table>
    </div>
     
     
     
<div id="item_wrapper" style="position:fixed; left:0; right:0px; top:0px; height:100vh; background-color:rgba(2,2,2,0.7); z-index:4; padding-top:15vh; padding-left: 10%; padding-right: 10%; display:none; width:100%; overflow:auto">     
     
  <div class="table-responsive" style="overflow-x: auto; background-color:#FFF; padding:20px;">        
   	<h3 style="text-align:center; color:#555; margin:15px">Order Item(s) for;  <span id="cur_order"></span> <button class="btn" style="background-color:#FCFCFC; color:#333; border-radius:2px; float:right; margin:0px; margin-bottom:20px; cursor:pointer " onclick="item_wrapper_display(0)"> Close</button></h3>
    	<table id="myTable2" class="my_table">
        <thead>
             <tr>
            	<th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
             </tr>
            
	     </thead>
         <tfoot>
         	<tr>
            	<th colspan="3">Total: </th>
                <th></th>
            </tr>
         </tfoot>
       </table>
    </div>
</div>  
  
    
  
</div>



<!------ footer ------->


<?php require("./templates/footer.php");  ?>



<script src="datatable/js/jquery.dataTables.min.js?version=<?php echo glob_site_version; ?>"></script>    
<script src="datatable/js/papaparse.min.js?version=<?php echo glob_site_version; ?>"></script>    
<script src="datatable/js/datatables.min.js?version=<?php echo glob_site_version; ?>"></script>
<script src="datatable/js/dataTables.buttons.min.js?version=<?php echo glob_site_version; ?>"></script>
<script src="datatable/js/buttons.html5.min.js?version=<?php echo glob_site_version; ?>"></script>
<script src="datatable/js/buttons.print.min.js?version=<?php echo glob_site_version; ?>"></script>
<script src="datatable/js/buttons.colVis.min.js?version=<?php echo glob_site_version; ?>"></script>
<script src="datatable/js/dataTables.select.min.js?version=<?php echo glob_site_version; ?>"></script>
<script src="datatable/js/dataTables.editor.min.js?version=<?php echo glob_site_version; ?>"></script>

<script src="datatable/js/customer_orders.js?version=<?php echo glob_site_version; ?>"></script>



    
</body>
</html>

