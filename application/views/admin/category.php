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
                <div class="panel-heading panel-heading-divider">Category Configuration</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="category_form">
                    <div class="form-group">
                      <label class="col-sm-3">Name <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="name" value="<?php if(isset($category->name))echo $category->name; ?>">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-3">Description <span>*</span></label>
                      <div class="col-sm-6">
                        <textarea req="true" class="form-control" name="desc"><?php if(isset($category->desc))echo $category->desc; ?></textarea>
                      </div>
                    </div>
                    
					<?php $i=0; /*foreach($api_categories as $api){ ?>
					<input type="hidden" name="api_<?php echo $i; ?>" value="<?php echo $api['api_id']; ?>">
					<div class="form-group">
                      <label class="col-sm-3"><?php echo $api['api']; ?> Categories <span>*</span></label>
                      <div class="col-sm-6">
						<select class="select2" data-placeholder="Select" name="category_<?php echo $i; ?>[]" multiple>
							<?php foreach($api['categories']['api_categoryies'] as $c){ ?>
							<option value="<?php echo $c->id; ?>" <?php if(in_array($c->id,$api['categories']['selected_categories']))echo 'selected'; ?>><?php echo $c->name; ?></option>
							<?php } ?>
						</select>
                      </div>
                    </div>
					<?php $i++; }*/ ?>
					<!--input type="hidden" name="count" value="<?php echo count($api_categories); ?>"-->
					<div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                        <a href="<?php echo base_url('admin/category'); ?>" class="btn btn-default btn-lg">Cancel</a>
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
		
      });
	  $("#submit_btn").on("click",function(){
		var error=0;$(".text-danger").remove();
		$("#category_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		if(error == 0){
			$("#submit_btn").attr("disabled",true);
			var formData = new FormData($("#category_form")[0]);
			<?php if(isset($category->id)){ ?>
			formData.append('type','UPDATE');
			formData.append('id','<?php echo $category->id;?>');
			<?php }else{ ?>
			formData.append('type','INSERT');
			<?php } ?>
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_category');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location = '<?php echo base_url(); ?>admin/categories';},2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  });
	  
    </script>
	
  </body>

</html>