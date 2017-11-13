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
                <div class="panel-heading panel-heading-divider">Post Configuration</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="post_form">
                    
					<div class="form-group">
                      <label class="col-sm-3">Title <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="title" value="<?php if(isset($post->title))echo $post->title; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">URL </label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="postUrl" value="<?php if(isset($post->url))echo $post->url; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Description <span>*</span></label>
                      <div class="col-sm-6">
                       <textarea name="description" class="form-control" rows="5"><?php if(isset($post->description))echo $post->description; ?></textarea>
                      </div>
                    </div>
					
					
					<div class="form-group">
                      <label class="col-sm-3">Image <span>*</span></label>
                      <div class="col-sm-6">
						<input type="file" name="image" id="image" onchange="return Upload('image',200,200)">
						<input type="hidden" name="uploaded_img" id="uploaded_img" value="<?php if(isset($post->image))echo $post->image;?>">
						<?php if(isset($post->image)){ if(getimagesize($post->image) !== false){ ?>
						<img class="preview" src="<?php echo $post->image;?>">
						<?php } } ?>
                      </div>
                    </div>
										
					<div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                        <a href="<?php echo base_url('admin/posts'); ?>" class="btn btn-default btn-lg">Cancel</a>
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
		$("#post_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		if(error == 0){
			//$("#submit_btn").attr("disabled",true);
			
			var formData = new FormData($("#post_form")[0]);
			//formData.append('description',$("#editor1").summernote('code'));
			<?php if(isset($post->id)){ ?>
			formData.append('type','UPDATE');
			formData.append('id','<?php echo $post->id;?>');
			<?php }else{ ?>
			formData.append('type','INSERT');
			<?php } ?>
			
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_post');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location = '<?php echo base_url(); ?>admin/posts';},2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  });
	  
    </script>
	
  </body>

</html>