<!DOCTYPE html>
<html lang="en">
  
<?php echo $head; ?>
  
  <body>
    <div class="be-wrapper be-fixed-sidebar">
	
      <?php echo $header; ?>
	  
	  <div class="be-content">
        <div class="main-content container-fluid">
			
			<div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">User Configuration</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="user_form">
                    
					<div class="form-group">
                      <label class="col-sm-3">First Name <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="first_name" value="<?php if(isset($user->first_name))echo $user->first_name; ?>">
                      </div>
                    </div>
					
                    <div class="form-group">
                      <label class="col-sm-3">Last Name <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="last_name" value="<?php if(isset($user->last_name))echo $user->last_name; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Email <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="email" id="email" value="<?php if(isset($user->email))echo $user->email; ?>">
                      </div>
                    </div>
					<?php if(!isset($user->id)){ ?>
					<div class="form-group">
                      <label class="col-sm-3">Password <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="password" class="form-control" name="password" value="<?php if(isset($user->password))echo $user->password; ?>">
                      </div>
                    </div>
					<?php } ?>
					<div class="form-group">
                      <label class="col-sm-3">Role <span>*</span></label>
                      <div class="col-sm-6">
                       <select req="true" class="select2" name="role" id="role" data-placeholder="Select role">
						<option></option>
						<option value="USER">User</option>
						<option value="ADMIN">Admin</option>
						<option value="SHOPPER">Shopper</option>
					   </select>
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-3">Phone</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="phone" value="<?php if(isset($user->phone))echo $user->phone; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Address</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" value="<?php if(isset($user->address))echo $user->address; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">City</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="city" value="<?php if(isset($user->city))echo $user->city; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Country</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="country" value="<?php if(isset($user->country))echo $user->country; ?>">
                      </div>
                    </div>
					
                    		
					<div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                        <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-default btn-lg">Cancel</a>
                    </div>
				  </form>
                </div>
              </div>
            </div>
          </div>
			
		</div>
      </div>
      
	  
    </div>
	<?php echo $footer; ?>
   
    <script type="text/javascript">
      $(document).ready(function(){
		App.init();
		App.formElements();
		App.textEditors();
      });
	  $("#submit_btn").on("click",function(){
		var error=0;$(".text-danger").remove();
		$("#user_form input,#user_form select").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
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
			$("#submit_btn").attr("disabled",true);
			
			var formData = new FormData($("#user_form")[0]);
			<?php if(isset($user->id)){ ?>
			formData.append('type','UPDATE');
			formData.append('id','<?php echo $user->id;?>');
			<?php }else{ ?>
			formData.append('type','INSERT');
			<?php } ?>
			
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_user');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location = '<?php echo base_url(); ?>admin/users';},2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  });
	  
    </script>
	
  </body>

</html>