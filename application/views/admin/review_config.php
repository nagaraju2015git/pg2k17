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
                <div class="panel-heading panel-heading-divider">Review Configuration</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="review_form">
                    
					<div class="form-group">
                      <label class="col-sm-3">Name <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="name" value="<?php if(isset($review->name))echo $review->name; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Review <span>*</span></label>
                      <div class="col-sm-6">
                       <textarea name="review" class="form-control" rows="5"><?php if(isset($review->review))echo $review->review; ?></textarea>
                      </div>
                    </div>
					
					
					<div class="form-group">
                      <label class="col-sm-3">Image <span>*</span></label>
                      <div class="col-sm-6">
						<input type="file" name="image" id="image" onchange="return Upload('image',200,200)">
						<input type="hidden" name="uploaded_img" id="uploaded_img" value="<?php if(isset($review->image))echo $review->image;?>">
						<?php if(isset($review->image)){ if(getimagesize($review->image) !== false){ ?>
						<img class="preview" src="<?php echo $review->image;?>">
						<?php } } ?>
                      </div>
                    </div>
										
					<div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                        <a href="<?php echo base_url('admin/reviews'); ?>" class="btn btn-default btn-lg">Cancel</a>
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
		$("#review_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		if(error == 0){
			//$("#submit_btn").attr("disabled",true);
			
			var formData = new FormData($("#review_form")[0]);
			//formData.append('description',$("#editor1").summernote('code'));
			<?php if(isset($review->id)){ ?>
			formData.append('type','UPDATE');
			formData.append('id','<?php echo $review->id;?>');
			<?php }else{ ?>
			formData.append('type','INSERT');
			<?php } ?>
			
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_review');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location = '<?php echo base_url(); ?>admin/reviews';},2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  });
	  
    </script>
	
  </body>

</html>