<!DOCTYPE html>
<html lang="en">
	
	<!-- HEAD -->
	<?php echo $head; ?>
	<!-- HEAD -->
	
    <body>
        
		<!-- HEADER -->
		<?php echo $header;?>
		<!-- HEADER -->
        
		<section class="profile">
			<div class="container">
				<?php if($user){ ?>
				<h2 class="page-tittle">Reset Password</h2>
				<div class="box">
					<form id="user_form">
					<div class="row mb-10">
						<label class="col-md-3 col-sm-3">New Password <span>*</span></label>
						<div class="col-md-6 col-sm-6">	
							<input type="password" class="form-control" name="password" id="password" placeholder="Enter password...">
						</div>
					</div>
					<div class="row mb-10">
						<label class="col-md-3 col-sm-3">Confirm Password <span>*</span></label>
						<div class="col-md-6 col-sm-6">	
							<input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Enter confirm password...">
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-8 col-sm-9 text-center">	
							<button type="button" id="save_btn">Change Password</button>
						</div>
					</div>
					</form>
				</div>
				<?php }else{ ?>
				<h2 class="text-danger text-center">Reset password link expaired.</h2>
				<?php } ?>
			</div>			
		</section>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		<script>
			$("#save_btn").on("click",function(){
				var error=0;$("#user_form .text-danger,#user_form .text-success").remove();
				if($("#password").val() == ''){
					error++;
					$("#password").parent().append('<div class="text-danger">This field is required</div>');
				}
				if($("#password").val().length < 5 && $("#password").val().trim() != ''){
					error++;
					$("#password").parent().append('<div class="text-danger">Password should be atleast 6 characters</div>');
				}
				if($("#cpassword").val() == ''){
					error++;
					$("#cpassword").parent().append('<div class="text-danger">This field is required</div>');
				}
				if($("#cpassword").val() != $("#password").val() && $("#password").val() != '' && $("#cpassword").val() != ''){
					error++;
					$("#cpassword").parent().append('<div class="text-danger">Password not matched</div>');
				}
				
				if(error == 0){
					$("#save_btn").attr("disabled",true);
					$("#save_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
					$.ajax({
						url:'<?php echo base_url('home/password_change');?>',
						type:'POST',
						data:{'auth_id':'<?php echo $auth_id; ?>','password':$("#cpassword").val()},
						dataType:'JSON'
					}).success(function(data){						
						$("#user_form")[0].reset();
						if(data.status == 1){
							$("#user_form").prepend('<div class="text-success text-center">'+data.message+'</div>');
							setTimeout(function(){window.location='<?php echo base_url(); ?>';},2000);
						}
						else{
							$("#user_form").prepend('<div class="text-danger text-center">'+data.message+'</div>');
							$("#save_btn").removeAttr("disabled");
							$("#save_btn").html("Change Password");
						}
					});
				}
			});
		</script>
		
			
    </body>

</html>