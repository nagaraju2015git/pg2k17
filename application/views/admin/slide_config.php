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
                <div class="panel-heading panel-heading-divider">Slide Configuration</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="slide_form">
                    
					<div class="form-group">
                      <label class="col-sm-3">Title <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="title" value="<?php if(isset($slide->title))echo $slide->title; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Type <span>*</span></label>
                      <div class="col-sm-6">
                        <select req="true" class="select2" name="slideType">
							<option></option>
							<option value="slide" <?php if(isset($slide->slideType))if($slide->slideType == 'slide')echo 'selected';?>>Slide</option>
							<option value="banner" <?php if(isset($slide->slideType))if($slide->slideType == 'banner')echo 'selected';?>>Banner</option>
						</select>
                      </div>
                    </div>
                    
					<div class="form-group">
                      <label class="col-sm-3">URL </label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="slideUrl" value="<?php if(isset($slide->slideUrl))echo $slide->slideUrl; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Description </label>
                      <div class="col-sm-6">
                       <div id="editor1"><?php if(isset($slide->description))echo $slide->description; ?></div>
                      </div>
                    </div>
					
					
					<div class="form-group">
                      <label class="col-sm-3">Image <span>*</span></label>
                      <div class="col-sm-6">
						<input req="true" type="file" name="image" id="image" onchange="return Upload('image',400,250)">
						<input type="hidden" name="uploaded_img" id="uploaded_img" value="<?php if(isset($slide->image))echo $slide->image;?>">
						<?php if(isset($slide->image)){if(getimagesize($slide->image) !== false){?>
						<img class="preview" src="<?php echo $slide->image;?>">
						<?php } } ?>
                      </div>
                    </div>
										
					<div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                        <a href="<?php echo base_url('admin/slides'); ?>" class="btn btn-default btn-lg">Cancel</a>
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
		$("#slide_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		if(error == 0){
			//$("#submit_btn").attr("disabled",true);
			
			var formData = new FormData($("#slide_form")[0]);
			formData.append('description',$("#editor1").summernote('code'));
			<?php if(isset($slide->id)){ ?>
			formData.append('type','UPDATE');
			formData.append('id','<?php echo $slide->id;?>');
			<?php }else{ ?>
			formData.append('type','INSERT');
			<?php } ?>
			
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_slide');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location = '<?php echo base_url(); ?>admin/slides';},2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  });
	  
    </script>
	
  </body>

</html>