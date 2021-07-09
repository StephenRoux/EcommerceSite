<?php
session_start();

require_once('../connect/config.php');

if(!isset($_SESSION['admina'])) die(header('Location: ./login.php?reff='.$_SERVER['REQUEST_URI']));






$page_title =  'Change Password'; 

require("./templates/header.php");

?>  



<div class="small-container">
    
    
  <div class="small-container">
        <h2 style="margin:40px 20px;">Change Password</h2>
 		<form action="#" method="post" onSubmit="change_password(event, 'admin')"  style="max-width:400px;">
                    
                    <div class="form_gr">
                      <label for="m_password">Former Password</label>
                      <input type="password" required class="form-control" id="password" minlength="6">
                      
                    </div>
                    <div class="form_gr">
                      <label for="m_password">New Password</label>
                      <input type="password" required class="form-control" id="password1" minlength="6">
                      
                    </div>
                    <div class="form_gr">
                      <label for="m_password">Retype New Password</label>
                      <input type="password" required class="form-control" id="password2" minlength="6">
                      
                    </div>
                    <div><div id="error_msg" style=" margin: 20px;"></div>
</div>
                    <div class="form_gr" id="sbutton" style="text-align: center">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Change Password">
                    </div>
			
           </form>
  
  
  </div>
    
  
</div>



<!------ footer ------->
<script>
<?php if(isset($_GET['reff'])) echo 'var glob_reff = "'.$_GET['reff'].'"'; else  echo 'var glob_reff = "'.glob_site_url.'"'; ?>

</script>

<?php require("./templates/footer.php");  ?>

    
</body>
</html>

