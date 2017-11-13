<!DOCTYPE html>
<html lang="en">
	
	<!-- HEAD -->
	<?php echo $head; ?>
	<!-- HEAD -->
	
    <body>
        
		<!-- HEADER -->
		<?php echo $header;?>
		<!-- HEADER -->
        
		<section class="mbh">
			<div class="container">
				<div class="login">
					<div class="head">
						Welcome to Painless Gift
						<p>The new way to find your next gift</p>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-4 col-sm-6 text-center">
							<form action="#" class="login_form" id="login_form">
								<h3>Login</h3>
								<div class="form-group">
									<label>Email</label>
									<input type="text" id="email" class="form-control" placeholder="Enter email...">
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" id="password" class="form-control" placeholder="Enter password...">
								</div>
								<div class="form-group">
									<button type="button" id="login_btn"><i class="fa fa-sign-in"></i> Login</button>
									<p class="forgot_link" id="forgot_link">Forgot Password ?</p>
									<div id="forgot_div" class="hide">
										<input type="text" id="femail" class="form-control mb-5" placeholder="Enter email...">
										<button type="submit" id="submit_btn">Submit</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-3 col-sm-6 text-center divider">
							<a href="<?php echo $fb_login_url; ?>" class="fb"><i class="fa fa-facebook"></i> Sign In with Facebook</a><br>
							<a class="gmail" href="<?php echo base_url('home/signup'); ?>"><i class="fa fa-envelope"></i> Sign Up with Email</a><br><br>
						</div>
						<div class="col-md-3 col-sm-6 text-center divider">
							<p><?php if(isset($page->content))echo $page->content; ?></p><br>
							<a class="gmail" href="<?php echo base_url('home/shopper'); ?>"><i class="fa fa-user-o"></i> Sign Up as a Shopper</a><br>
						</div>
					</div>
				</div>                        
			</div>                        
		</section>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		<script>
			$("#login_form").on("submit",function(e){
				e.preventDefault();
				$("#login_btn").trigger("click");
			});
			$("#forgot_link").on("click",function(){
				$("#forgot_div").removeClass("hide");
			});
			$("#submit_btn").on("click",function(){
				var email = $("#femail").val();
				var error=0;$(".text-danger").remove();
				if(email.trim() == ''){
					error++;
					$('<div class="text-danger">This field is required</div>').insertAfter("#femail");
				}
				if(error == 0){
					$("#submit_btn").attr("disabled",true);
					$("#submit_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
					$.ajax({
						url:'<?php echo base_url('home/forgot_password');?>',
						type:'POST',
						data:{'email':$("#femail").val(),'password':$("#password").val()},
						dataType:'JSON'
					}).success(function(data){						
						if(data.status == 1){
							$("#forgot_div").html('<div class="text-success">'+data.message+'</div>');
						}else{
							$('<div class="text-danger">'+data.message+'</div>').insertAfter("#femail");
							$("#submit_btn").removeAttr("disabled");
							$("#submit_btn").html("Submit");
						}
					});
				}
			});
			$("#login_btn").on("click",function(){
				var error=0;$(".login_form .text-danger").remove();
				if($("#email").val() == ''){
					error++;
					$("#email").parent().append('<div class="text-danger">This field is required</div>');
				}
				if($("#password").val() == ''){
					error++;
					$("#password").parent().append('<div class="text-danger">This field is required</div>');
				}
				if(error == 0){
					$("#login_btn").attr("disabled",true);
					$("#login_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
					$.ajax({
						url:'<?php echo base_url('home/login');?>',
						type:'POST',
						data:{'email':$("#email").val(),'password':$("#password").val()},
						dataType:'JSON'
					}).success(function(data){						
						if(data.status == 1)
							window.location = data.url;
						else{
							$('<div class="text-danger">'+data.message+'</div>').insertAfter( "#login_form h3" );
							$("#login_btn").removeAttr("disabled");
							$("#login_btn").html("Login");
						}
					});
				}
			});
		</script>
		
    </body>

</html>