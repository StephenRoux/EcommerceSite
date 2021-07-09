<!------ footer ------->
<div class="footer">
  <div class="container">
    <div class="row">
      <div><strong>ADMIN AREA</strong></div>
    </div>
    <hr>
    <p class="copyright">Copyright &copy; 2020 WeAreSkate.</p>
  </div>
</div>



 
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
    