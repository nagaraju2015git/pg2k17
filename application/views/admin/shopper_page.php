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
                <div class="panel-heading panel-heading-divider">Shopper Page Configuration</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="page_form">
                    
					<div class="form-group">
                      <label class="col-sm-3">Heading <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="heading" value="<?php if(isset($page->heading))echo $page->heading; ?>">
                      </div>
                    </div>
					
                    <div class="form-group">
                      <label class="col-sm-3">Content <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="content" value="<?php if(isset($page->content))echo $page->content; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Button Text <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="btext" value="<?php if(isset($page->btext))echo $page->btext; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Page Heading <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="pheading" value="<?php if(isset($page->pheading))echo $page->pheading; ?>">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Page Content <span>*</span></label>
                      <div class="col-sm-9">
                        <div id="editor1"><?php if(isset($page->pcontent))echo $page->pcontent; ?></div>
                      </div>
                    </div>
					
					<div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="update_btn">Update</button>
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
	  $("#update_btn").on("click",function(){
		var error=0;$(".text-danger").remove();
		$("#page_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		if(error == 0){
			$("#update_btn").attr("disabled",true);
			
			var formData = new FormData($("#page_form")[0]);
			formData.append('page','SP');
			formData.append('pcontent',$("#editor1").summernote('code'));
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_shopping_page');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location.reload(); },2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  });
	  
    </script>
	
  </body>

</html>