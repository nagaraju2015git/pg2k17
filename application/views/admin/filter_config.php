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
                <div class="panel-heading panel-heading-divider">Filter Configuration</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="filter_form">
                    
					<div class="form-group">
                      <label class="col-sm-3">Name <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="name" value="<?php if(isset($filter->name))echo $filter->name; ?>">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-3">Min Value <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="min_value" value="<?php if(isset($filter->min_value))echo $filter->min_value; ?>">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-3">Max Value <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="max_value" value="<?php if(isset($filter->max_value))echo $filter->max_value; ?>">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-3">Key <span>*</span></label>
                      <div class="col-sm-6">
                        <select req="true" class="select2" data-placeholder="Select key" name="key">
							<option></option>
							<option value="age"  <?php if(isset($filter->filterKey))if($filter->filterKey == 'age')echo 'selected';?>>Age</option>
							<option value="price" <?php if(isset($filter->filterKey))if($filter->filterKey == 'price')echo 'selected';?>>Price</option>
						</select>
                      </div>
                    </div>
					<!--div class="filter_div" id="filter_div">
						<?php $i=0;foreach($filter_keys as $f){ ?>
							<input type="hidden" name="key_id_<?php echo $i; ?>" value="<?php echo $f->id; ?>">
							<div class="box filter" id="filterbox_<?php echo $i; ?>">
								<div class="form-group">
								  <label class="col-sm-3">Filter Key <?php echo (int)($i+1); ?><span>*</span></label>
								  <div class="col-sm-6">
									<input req="true" type="text" class="form-control" name="name_<?php echo $i; ?>" value="<?php echo $f->name; ?>">
								  </div>
								</div>
								<div class="remove" data-count="<?php echo $i; ?>"><i class="mdi mdi-delete"></i> Remove</div>
							</div>
						<?php $i++; } ?>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">&nbsp;</label>
                      <div class="col-sm-6">
                       <button class="btn btn-primary btn-sm" type="button" id="add_filter"><i class="mdi mdi-plus"></i> Add Filter Key</button>
                      </div>
                    </div--!>
                    		
					<div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                        <a href="<?php echo base_url('admin/filters'); ?>" class="btn btn-default btn-lg">Cancel</a>
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
	   $("#add_filter").on("click",function(){
		  var count = $("#filter_div .filter").length + 1;
		  
		  var html = '<div class="box filter" id="filterbox_'+count+'">'+
						'<div class="form-group">'+
						  '<label class="col-sm-3">Filter Key '+count+' <span>*</span></label>'+
						  '<div class="col-sm-6">'+
							'<input req="true" type="text" class="form-control" name="name_'+count+'">'+
						  '</div>'+
						'</div>'+
						
						'<div class="remove" data-count="'+count+'"><i class="mdi mdi-delete"></i> Remove</div>'+
					'</div>';
		$("#filter_div").append(html);
		
	  });
	  $(document).on("click",".remove",function(){
		  var count = $(this).data("count");
		  $("#filterbox_"+count).remove();
	  });
	  $("#submit_btn").on("click",function(){
		var error=0;$(".text-danger").remove();
		$("#filter_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		if(error == 0){
			$("#submit_btn").attr("disabled",true);
			
			var formData = new FormData($("#filter_form")[0]);
			<?php if(isset($filter->id)){ ?>
			formData.append('type','UPDATE');
			formData.append('id','<?php echo $filter->id;?>');
			<?php }else{ ?>
			formData.append('type','INSERT');
			<?php } ?>
			formData.append("count",parseInt($("#filter_div .filter").length));
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_filter');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location = '<?php echo base_url(); ?>admin/filters';},2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  });
	  
    </script>
	
  </body>

</html>