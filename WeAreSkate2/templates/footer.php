<!------ footer ------->
<div class="footer">
  <div class="container">
    <div class="row">
      <div class="footer-col-1">
        <h3>Download Our App</h3>
        <p>Download App for Android and ios mobile phone.</p>
        <div class="app-logo">
            <img src="<?php echo glob_site_url; ?>/images/play-store.png" >
            <img src="<?php echo glob_site_url; ?>/images/app-store.png" >
        </div>
      </div>
      <div class="footer-col-2">
        <img src="<?php echo glob_site_url; ?>/images/WAS2.png" >
        <p>Our purpose is to sustainably make the pleasure and benefits of skateboarding accessible to the many</p>
      </div>
      <div class="footer-col-3">
        <h3>Useful Links</h3>
        <ul>
          <li>Coupons</li>
          <li>Blog Post</li>
          <li>Return Policy</li>
          <li>Join Affiliate</li>
        </ul>
      </div>
      <div class="footer-col-4">
        <h3>Follow us</h3>
        <ul>
          <li>Facebook</li>
          <li>Twitter</li>
          <li>Instagram</li>
          <li>YouTube</li>
        </ul>
      </div>
    </div>
    <hr>
    <p class="copyright">Copyright &copy; 2020 WeAreSkate.</p>
  </div>
</div>




    <!--  Modal  ALert
<div class="modal" id="modal_alert">
  <div class="modal-dialog">
    <div class="modal-content">
    <div style="text-align:right"> <button type="button" class="close" data-dismiss="modal">&times;</button></div>
 <!-- Modal body --
      <div class="modal-body" style="font-size:14px;">
        Modal body..
      </div>
 <!-- Modal footer --
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
 -->
 
<!--------------js for toggle menu----------->
    
 <script>
     var MenuItems = document.getElementById("MenuItems");
     
     MenuItems.style.maxHeight = "0px";
     
     function menutoggle(){
        if(MenuItems.style.maxHeight == "0px")
            {
                MenuItems.style.maxHeight = "200px";
            }
        else
            {
                MenuItems.style.maxHeight = "0px";
            }
	 }
</script>   
  
    
 <!--------------js for product gallery-----------> 
    
 <script>
   try{
   var ProductImg = document.getElementById("ProductImg");
   var SmallImg = document.getElementsByClassName("small-img");
     
     SmallImg[0].onclick = function()
     {
         ProductImg.src = SmallImg[0].src;
     }
     
     SmallImg[1].onclick = function()
     {
         ProductImg.src = SmallImg[1].src;
     }
      SmallImg[2].onclick = function()
     {
         ProductImg.src = SmallImg[2].src;
     }
     SmallImg[3].onclick = function()
     {
         ProductImg.src = SmallImg[3].src;
     }
   
   }catch(exce){}
   
    
	var glob_site_url = '<?php echo glob_site_url; ?>';
	
    </script> 
    
    <script src="<?php echo glob_site_url; ?>/js/jquery.min.js"></script>
    <script src="<?php echo glob_site_url; ?>/js/popper.min.js"></script>
    <script src="<?php echo glob_site_url; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo glob_site_url; ?>/js/main.js"></script>
    