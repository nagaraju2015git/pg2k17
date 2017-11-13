<!DOCTYPE html>
<html lang="en">
	
	<!-- HEAD -->
	<?php echo $head; ?>
	<!-- HEAD -->
	
    <body>
        
		<!-- HEADER -->
		<?php echo $header;?>
		<!-- HEADER -->
        
		<section class="profile mbh">
			<div class="container">
				<h2 class="page-tittle">Profile</h2>
				<div class="row">
				<div class="col-md-6">
				<div class="box">
					<form id="user_form">
					
					<div class="row mb-10 mt-10">
						<label class="col-md-3">First Name <span>*</span></label>
						<div class="col-md-8">	
							<input type="text" req="true" class="form-control" name="first_name" id="first_name" placeholder="Enter first name..." value="<?php echo $user->first_name; ?>">
						</div>
					</div>
					<div class="row mb-10">
						<label class="col-md-3">Last Name <span>*</span></label>
						<div class="col-md-8">	
							<input type="text" req="true" class="form-control" name="last_name" id="last_name" placeholder="Enter last name..." value="<?php echo $user->last_name; ?>">
						</div>
					</div>
					<div class="row mb-10">
						<label class="col-md-3">Email <span>*</span></label>
						<div class="col-md-8">	
							<input type="text" req="true" class="form-control" name="email" id="email" placeholder="Enter email..." value="<?php echo $user->email; ?>">
						</div>
					</div>
					<div class="row mb-20">
						<label class="col-md-3">Phone <span>*</span></label>
						<div class="col-md-8">	
							<input type="text" req="true" class="form-control" name="phone" id="phone" placeholder="Enter phone..." value="<?php echo $user->phone; ?>">
						</div>
					</div>
					<div class="row mb-20">
						<label class="col-md-3">Private </label>
						<div class="col-md-8">	
							<input type="checkbox" name="private" id="private" value="1" style="margin-top: 8px;" <?php if($user->private)echo 'checked'; ?> >
						</div>
					</div>
					<div class="row mb-20">
						<label class="col-md-3">Push Notifications </label>
						<div class="col-md-8">	
							<input type="checkbox" name="push_enabled" id="push_enabled" value="1" style="margin-top: 8px;" <?php if($user->push_enabled)echo 'checked'; ?> >
						</div>
					</div>
					<div class="row mb-10">
						<label class="col-md-3">Profile Pic </label>
						<div class="col-md-8">	
							<input type="file" name="image" id="image" onchange="return Upload('image',400,400)">
							<input type="hidden" name="uploaded_img" name="image" value="<?php echo $user->image; ?>">
							<?php if(@file_get_contents($user->image) !== false){ ?>
							<img class="preview" src="<?php echo $user->image; ?>">
							<?php } ?>
						</div>
					</div>
					<hr>
					<div class="row mb-10">
						<div class="col-md-12 text-center">	
							<button type="button" class="btn-lg" id="save_btn"><i class="fa fa-floppy-o"></i> Save</button>
						</div>
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
		
		<script>
			$("#save_btn").on("click",function(){
				var error=0;$("#user_form .text-danger,#user_form .text-success").remove();
				
				$("#user_form input").each(function(){
					if($(this).val().trim() == '' && $(this).attr("req") == "true"){
						error++;
						$(this).parent().append('<div class="text-danger">This field is required</div>');
					}
				});
				var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if(!email_regex.test($("#email").val()) && $("#email").val() != ''){
					error++;
					$("#email").parent().append('<div class="text-danger">Invalid email</div>');
				}
				if(error == 0){
					$("#save_btn").attr("disabled",true);
					$("#save_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
					var formData = new FormData($("#user_form")[0]);
					$.ajax({
						url:'<?php echo base_url('home/update_user');?>',
						type:'POST',
						data:formData,
						dataType:'JSON',
						cache: false,
						contentType: false,
						processData: false
					}).success(function(data){						
						if(data.status == 1){
							$("#user_form").prepend('<div class="text-success text-center">'+data.message+'</div>');
							window.location.reload();
						}
						else{
							$("#user_form").prepend('<div class="text-danger text-center">'+data.message+'</div>');
						}
						$("#save_btn").removeAttr("disabled");
						$("#save_btn").html("Save");
					});
				}
			});
		</script>
		
			
    </body>

</html>
