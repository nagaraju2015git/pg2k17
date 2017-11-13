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
                <div class="panel-heading panel-heading-divider">Product Configuration</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="product_form">
                    
					<div class="form-group">
                      <label class="col-sm-3">Name <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="name" value="<?php if(isset($product->name))echo $product->name; ?>">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-3">Category <span>*</span></label>
                      <div class="col-sm-6">
                        <select class="select2" name="category" data-placeholder="Select">
							<option></option>
							<?php foreach($categories as $c){ ?>
							<option value="<?php echo $c->id; ?>" <?php if(isset($product->category))if($product->category == $c->id) echo 'selected'; ?>><?php echo $c->name; ?></option>
							<?php } ?>
						</select>
					  </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3">Navigations <span>*</span></label>
                      <div class="col-sm-6">
                        <select class="select2" name="navigation[]" multiple data-placeholder="Select">
							<option></option>
							<?php foreach($navigation as $n){ ?>
							<option class="bold" value="<?php echo $n->id; ?>" <?php if(in_array($n->id,$selectedNavigation))echo 'selected'; ?>><?php if($n->parent_id != 0)echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; echo $n->name; ?></option>
							<?php } ?>
						</select>
					  </div>
                    </div>
                    
					<div class="form-group">
                      <label class="col-sm-3">Description <span>*</span></label>
                      <div class="col-sm-6">
                       <div id="editor1"><?php if(isset($product->description))echo $product->description; ?></div>
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Slug <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="slug" value="<?php if(isset($product->slug))echo $product->slug; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Image <span>*</span></label>
                      <div class="col-sm-6">
						<input type="file" name="image" id="image" onchange="return Upload('image',200,200)">
						<input type="hidden" name="uploaded_img" id="uploaded_img" value="<?php if(isset($product->image))echo $product->image;?>">
						<?php if(isset($product->image)){if(getimagesize($product->image) !== false){ ?>
						<img class="preview" src="<?php echo $product->image; ?>">
						<?php } } ?>
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Price <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="price" value="<?php if(isset($product->price))echo $product->price; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Link <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="product_link" value="<?php if(isset($product->product_link))echo $product->product_link; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Min Age <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="min_age" value="<?php if(isset($product->min_age))echo $product->min_age; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Max Age <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="max_age" value="<?php if(isset($product->max_age))echo $product->max_age; ?>">
                      </div>
                    </div>
					
					<div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                        <a href="<?php echo base_url('admin/products'); ?>" class="btn btn-default btn-lg">Cancel</a>
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
		$("#product_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		if(error == 0){
			$("#submit_btn").attr("disabled",true);
			
			var formData = new FormData($("#product_form")[0]);
			formData.append('description',$("#editor1").summernote('code'));
			<?php if(isset($product->id)){ ?>
			formData.append('type','UPDATE');
			formData.append('id','<?php echo $product->id;?>');
			<?php }else{ ?>
			formData.append('type','INSERT');
			<?php } ?>
			
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_product');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location = '<?php echo base_url(); ?>admin/products';},2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  });
	  
    </script>
	
  </body>

</html>