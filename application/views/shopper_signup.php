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
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<form class="user_form" id="user_form">
							<h3 class="ssh">Sign Up as a shopper</h3>
							<div class="row mt-10">
								<div class="col-md-6">
								  <label class="col-md-4">First Name <span>*</span></label>
								  <div class="col-md-8">
									<input req="true" type="text" class="form-control" name="first_name" value="">
								  </div>
								</div>
								<div class="col-md-6">
								  <label class="col-md-4">Last Name <span>*</span></label>
								  <div class="col-md-8">
									<input req="true" type="text" class="form-control" name="last_name" value="">
								  </div>
								</div>
							</div>
							<div class="row mt-10">
								<div class="col-md-6">
									<label class="col-md-4">Gender <span>*</span></label>
									<div class="col-md-8">
										<select class="form-control"  name="gender" id="gender" >
											<option value="Male" selected>Male</option>
											<option value="Female">Female</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
								  <label class="col-md-4">Email <span>*</span></label>
								  <div class="col-md-8">
									<input req="true" type="text" class="form-control" name="email" id="email" value="">
								  </div>
								</div>
								
							</div>
							<div class="row mt-10">
								<div class="col-md-6">
								  <label class="col-md-4">Phone</label>
								  <div class="col-md-8">
									<input type="text" class="form-control" name="phone" value="">
								  </div>
								</div>
								<div class="col-md-6">
								  <label class="col-md-4">Address</label>
								  <div class="col-md-8">
									<input type="text" class="form-control" name="address" value="">
								  </div>
								</div>
							</div>
							<div class="row mt-10">
								<div class="col-md-6">
								  <label class="col-md-4">City</label>
								  <div class="col-md-8">
									<input type="text" class="form-control" name="city" value="">
								  </div>
								</div>
								<div class="col-md-6">
								  <label class="col-md-4">Country</label>
								  <div class="col-md-8">
									<input type="text" class="form-control" name="country" value="">
								  </div>
								</div>
							</div>
							<div class="row mt-10">
								<div class="col-md-2"></div>
								<div class="col-md-6">
								  <input type="checkbox" id="terms" value="1"> please accept <a href="<?php echo base_url('home/shopper'); ?>" target="_blank">terms and conditions</a>.
								</div>
							</div><br>

							<div class="form-group mt-10 text-center">
								<button type="button" id="submit_btn">Sign Up</button>
							</div>
						</form>
					</div>
				</div>
				</div>
			</div>

		</section>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		<script type="text/javascript">
		  $(document).ready(function(){
			
		  });
		  $("#submit_btn").on("click",function(){
			var error=0;$(".text-danger").remove();
			$("#user_form input").each(function(){
				if($(this).attr("req") == "true" && $(this).val().trim() == ""){
					error++;
					$(this).parent().append('<div class="text-danger">This field is required</div>');
				}
			});
			if(!$("#terms").is(":checked")){
				error++;
				$("#terms").parent().append('<div class="text-danger">Accept terms and conditions</div>');
			}
			var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!email_regex.test($("#email").val()) && $("#email").val() != ''){
				error++;
				$("#email").parent().append('<div class="text-danger">Invalid email</div>');
			}
			if(error == 0){
				$("#submit_btn").attr("disabled",true);
				
				var formData = new FormData($("#user_form")[0]);
				formData.append('type','INSERT');

				$.ajax({
					url:'<?php echo base_url('home/ins_upd_shopper_request');?>',
					type:'POST',
					data:formData,
					dataType:'JSON',
					cache: false,
					contentType: false,
					processData: false
				}).success(function(data){
					
					if(data.status){
						$.notify({ message: data.message },{type: 'success'});
						var html='<div class="text-success text-center">Thank you for registering as a Personal Shopping Assistant, we will get back to you in 24 hrs.</div>';
						$("#user_form").html(html);
					}else{
						$.notify({ message: data.message },{type: 'danger'});
						$("#submit_btn").removeAttr("disabled");
					}
				});
			}
		  });
		  
    </script>
		
    </body>

</html>