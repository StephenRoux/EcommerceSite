<?php
session_start();

require_once('../connect/config.php');


if(!isset($_SESSION['admina'])) die(header('Location: ./login.php?reff='.$_SERVER['REQUEST_URI']));



$page_title =  'Contact Me - Customer messages'; 

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
          <h2 style="color:#555; text-align:center; margin:20px 0px;">Customer Messages</h2>
  
  
  <div class="table-responsive" style="overflow-x: auto">        
   <table id="myTable" class="my_table">
        <thead>
             <tr>
            	<th id="quick_add_th"><span class="my_col_vis">Select</span></th>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Gender</th>
                <th>Message</th>
                
             </tr>
             
             <tr>
            	<th></th>
                <th class="sch"></th>
                <th class="sch"></th>
                <th class="sch"></th>
                <th class="sch"></th>
                <th></th>
                
             </tr>
            
	     </thead>
       </table>
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

<script src="datatable/js/customer_messages.js?version=<?php echo glob_site_version; ?>"></script>



    
</body>
</html>

