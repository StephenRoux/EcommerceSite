///My main functions

$(document).ready(function(){
   
});


//Function for user to add items to their cart

function add_to_cart(pid){
	
	var quant = $("#quant").val().trim();
	if(quant == "" || quant < 1) return;
	
	if($("#pr_type").length){
		var type = $("#pr_type").val();
		if(type == ""){ 
			myalert('please select size');
			return;
		}
	}
	else{
		var type = "";
		}
	
	var fdata = {ch: 'add_cart', product_id: pid, quant: quant, type: type};
			
	var sbutton = $("#sbutton").html(); //grab the initial content
	
	$("#sbutton").html('<span class="fa fa-spin fa-spinner fa-2x"></span>');
	 
	$("input").prop("disabled", true); 
	
	   $.ajax({
		 type: "POST",
		 url:   glob_site_url + "/connect/main.php",
		 data: fdata,
		 success: function(data){ console.log(data);
				 
				 if(data === 'PASS'){
					$("#sbutton").html(quant + ' item(s) added to cart <a href="../cart.php" style="color:#ff8000; font-weight:bold"> Checkout</a> or Continue shopping');
					
					var qunt = $("#carts").html();
					if(isNaN(qunt)) qunt = 0;
					qunt = parseInt(qunt);
					$("#carts").html(qunt + 1);
				 }
				  else{
					$("input").prop("disabled", false);
					$("#sbutton").html(sbutton);
					//myalert('<div class="text-danger" style="padding:15px; background-color:#FFF; font-size:12px; border: 1px solid #F00; width:93%; margin: 3%; border-radius:4px;">' +data + '</div>');
					myalert(data);
					
				  }
				},
			  });
	
}






//Notification function

function myalert(msg){
	
	alert(msg);
	$("#modal_alert .modal-body").html(msg)
				 $("#modal_alert").modal('show');
	
	
	}


$(document).ready(function(){
	
  if($(".cart_zone").length){
	  recalculate_base();
	  $(".cart_zone tbody tr td input").on('keyup change', function(){
		  
		  var parent = $(this).closest('tr');
		  var pid = parent.data('id');
		  var quant = $(this).val();
		  if(quant == "" || quant < 1) return;
		  var price = parent.data('price');
		  var type = parent.data('type');
		  var  subtotal = "R" + (parseFloat(price) * parseInt(quant)).toFixed(2); 
		  parent.find('.subtotal').html(subtotal);
		  recalculate_base();
		  
		  var fdata = {ch: 'add_cart', product_id: pid, quant: quant, type: type};
		  
		  $.ajax({
			 type: "POST",
			 url:   glob_site_url + "/connect/main.php",
			 data: fdata,
			 success: function(data){ console.log(data);
					 if(data !== 'PASS'){
						//myalert('<div class="text-danger" style="padding:15px; background-color:#FFF; font-size:12px; border: 1px solid #F00; width:93%; margin: 3%; border-radius:4px;">' +data + '</div>');
						myalert(data);
						
					  }
					},
				 });
		  
		  
		  });
		  
		  
		  $(".cart_zone tbody tr td button.fa-times").on('click', function(){
		  
		  var parent = $(this).closest('tr');
		  var pid = parent.data('id');
		  $(this).parent().html('<span class="fa fa-spin fa-spinner fa-2x"></span>');
		  parent.remove();
		  recalculate_base();
		  var fdata = {ch: 'remove_cart', product_id: pid};
		  $.ajax({
			 type: "POST",
			 url:   glob_site_url + "/connect/main.php",
			 data: fdata,
			 success: function(data){ 
					 if(data == "PASS"){
						var qunt = $("#carts").html();
						if(isNaN(qunt)) qunt = 0;
						qunt = parseInt(qunt);
						if(qunt == 1)
							$("#carts").html('');
						else
							$("#carts").html((qunt -1));
					 }
					 else{
						//myalert('<div class="text-danger" style="padding:15px; background-color:#FFF; font-size:12px; border: 1px solid #F00; width:93%; margin: 3%; border-radius:4px;">' +data + '</div>');
						myalert(data);
						
					  }
					},
				 });
		  
		  
		  });
	}	
	
});


//Cart calculation function

function recalculate_base(){
	
	    var subtotal = 0.00;
		$(".cart_zone tbody tr").each(function(){
		  
		  var parent = $(this);
		  var quant = $(this).find("td input").val();
		  var price = parent.data('price');
		  //console.log(quant);
		  subtotal +=  (parseFloat(price) * parseInt(quant)); 
		});	
		
		$("#total_p").html("R" + subtotal.toFixed(2));
	
	
}


//User signup function

function signup_proceed_to_payment(event, trigger){
	
	event.preventDefault();
	
	var fname= $("#fname").val().trim();
	var email= $("#email").val().trim();
	var phone= $("#phone").val().trim();
	var address= $("#address").val().trim();
	var password= $("#password").val().trim();
	
	if(fname == "" || email == "" || address =="") return;
	
	
	var fdata = {ch: 'pay_proceed', fname: fname, email: email, phone: phone, address: address, password: password, trigger: trigger};
			
	var sbutton = $("#sbutton").html(); //grab the initial content
	
	$("#sbutton").html('<span class="fa fa-spin fa-spinner fa-2x"></span>');
	 
	$("#error_msg").html('');
	
	   $.ajax({
		 type: "POST",
		 url:   glob_site_url + "/connect/signing.php",
		 data: fdata,
		 success: function(data){ console.log(data);  
				
				 if(data.substr(0, 4) == 'PASS'){
					if(trigger == 'checkout'){
						window.location.href = 'payment/' + data.substr(4);
					}else{
						window.location.href = glob_reff;
					}
				 
				 }
				  else{
					
					$("#sbutton").html(sbutton);
					$("#error_msg").html('<div class="text-danger" style="padding:15px; background-color:#FFF; font-size:12px; border: 1px solid #F00; width:93%; margin: 3%; border-radius:4px;">' +data + '</div>');
										
				  }
				},
			  });
	
}




//User signin function

function sign_in(event, utype){
	
	event.preventDefault();
	
	var email= $("#email").val().trim();
	var password= $("#password").val().trim();
	
	
	var fdata = {ch: 'sign_in', email: email, password: password, utype: utype};
			
	var sbutton = $("#sbutton").html(); //grab the initial content
	
	$("#sbutton").html('<span class="fa fa-spin fa-spinner fa-2x"></span>');
	 
	$("#error_msg").html('');
	
	   $.ajax({
		 type: "POST",
		 url:   glob_site_url + "/connect/signing.php",
		 data: fdata,
		 success: function(data){ console.log(data);
				 
				 if(data === 'PASS'){
					window.location.href = glob_reff;
				 }
				  else{
					
					$("#sbutton").html(sbutton);
					$("#error_msg").html('<div class="text-danger" style="padding:15px; background-color:#FFF; font-size:12px; border: 1px solid #F00; width:93%; margin: 3%; border-radius:4px;">' +data + '</div>');
										
				  }
				},
			  });
	
}



// User Change Password Function

function change_password(event, utype){
	
	event.preventDefault();
	
	var password = $("#password").val().trim();
	var password1 = $("#password1").val().trim();
	var password2 = $("#password2").val().trim();
	
	if(password1 !== password2) { alert('new password not match'); return;}
	
	var fdata = {ch: 'change_password', password: password, password1: password1, password2: password2, utype: utype};
			
	var sbutton = $("#sbutton").html(); //grab the initial content
	
	$("#sbutton").html('<span class="fa fa-spin fa-spinner fa-2x"></span>');
	 
	$("#error_msg").html('');
	
	   $.ajax({
		 type: "POST",
		 url:   glob_site_url + "/connect/signing.php",
		 data: fdata,
		 success: function(data){ console.log(data);
				 $("#sbutton").html(sbutton);
				 if(data === 'PASS'){
					$("#error_msg").html('<div class="text-success" style="padding:15px; background-color:#FFF; font-size:14px; border: 1px solid #0F0; coloe: #090; width:93%; margin: 3%; border-radius:4px;">Password Changed successfully</div>');
					$("form")[0].reset();
				 }
				  else{
					
					$("#error_msg").html('<div class="text-danger" style="padding:15px; background-color:#FFF; font-size:12px; border: 1px solid #F00; width:93%; margin: 3%; border-radius:4px;">' +data + '</div>');
										
				  }
				},
			  });
	
}




//Function for grabbing users contact details

function contact_us(event){
	
	event.preventDefault();
	
	var fname= $("#fname").val().trim();
	var email= $("#email").val().trim();
	var phone= $("#phone").val().trim();
	var message = $("#message").val().trim();
	var gender = $("#gender").val().trim();
	
	if(fname == "" || email == "" || message =="") return;
	
	
	var fdata = {ch: 'contact_us', fname: fname, email: email, phone: phone, message: message, gender: gender};
			
	var sbutton = $("#sbutton").html(); //grab the initial content
	
	$("#sbutton").html('<span class="fa fa-spin fa-spinner fa-2x"></span>');
	 
	$("#error_msg").html('');
	
	   $.ajax({
		 type: "POST",
		 url:   glob_site_url + "/connect/main.php",
		 data: fdata,
		 success: function(data){ console.log(data);
				 
				 if(data == 'PASS'){
					 
					$("#sbutton").html('<div  style="padding:15px; background-color:#FFF; font-size:18px; font-weight:bold; color:#090"> Submitted successfully. We will get back to you soon. <br><br> Thank You.</div>');
				 
				 }
				  else{
					
					$("#sbutton").html(sbutton);
					$("#error_msg").html('<div style="padding:15px; background-color:#FFF; font-size:12px; color: #C000">' +data + '</div>');
										
				  }
				},
			  });
	
}
