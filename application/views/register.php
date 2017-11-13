<!DOCTYPE html>
<html lang="en">
	
	<!-- HEAD -->
	<?php echo $head; ?>
	<!-- HEAD -->
	
    <body>
        
		<!-- HEADER -->
		<?php echo $header;?>
		<!-- HEADER -->
        
		<section class="login">
			<div class="container">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-5 col-sm-6 text-center">
						<form class="login_form" id="login_form">
							<h3>Sign Up</h3>
							<div class="form-group">
								<label>Email</label>
								<input type="text" id="email" class="form-control" placeholder="Enter email...">
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" id="password" class="form-control" placeholder="Enter password...">
							</div>
							<div class="form-group">
								<label>Confirm Password</label>
								<input type="password" id="cpassword" class="form-control" placeholder="Enter password...">
							</div>
							<div class="form-group">
								<button type="button" id="register_btn">Sign Up</button>
							</div>
						</form>
					</div>
					<div class="col-md-5 col-sm-6 text-center divider">
						<button class="fb"><i class="fa fa-facebook"></i> Sign In with Facebook</button><br>
						<p class="login_link">Already have an account? <a href="<?php echo base_url('home/signin'); ?>">Sign In</a></p>
					</div>
				</div>
			</div>                        
		</section>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		<script>
			$("#register_btn").on("click",function(){
				var error=0;$(".login_form .text-danger").remove();
				if($("#name").val() == ''){
					error++;
					$("#name").parent().append('<div class="text-danger">This field is required</div>');
				}
				if($("#email").val() == ''){
					error++;
					$("#email").parent().append('<div class="text-danger">This field is required</div>');
				}
				var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if(!email_regex.test($("#email").val()) && $("#email").val() != ''){
					error++;
					$("#email").parent().append('<div class="text-danger">Invalid email</div>');
				}
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
					$("#register_btn").attr("disabled",true);
					$("#register_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
					$.ajax({
						url:'<?php echo base_url('home/register');?>',
						type:'POST',
						data:{'name':$("#name").val(),'email':$("#email").val(),'password':$("#password").val()},
						dataType:'JSON'
					}).success(function(data){						
						if(data.status == 1)
							window.location.reload();
						else{
							$('<div class="text-danger">'+data.message+'</div>').insertAfter( "#login_form h3" );
							$("#register_btn").removeAttr("disabled");
							$("#register_btn").html("Sign Up");
						}
					});
				}
			});
		</script>
		
    </body>

</html>