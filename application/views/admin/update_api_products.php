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
                <div class="panel-heading panel-heading-divider">Updating API Products</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="product_form">
                    
					<div class="form-group">
                      <label class="col-md-1" style="padding-right:0px;">Select API <span>*</span></label>
                      <div class="col-md-3">
                       <select class="select2" data-placeholder="Select" id="api">
							<option></option>
							<?php foreach($api as $a){ ?>
							<option value="<?php echo $a->id; ?>"><?php echo $a->name; ?></option>
							<?php } ?>
					   </select>
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-primary btn-lg" type="button" id="update_btn">Update</button>
                      </div>
					</div>	
					
					</form>
                </div>
              </div>
            </div>
          </div>
			<div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Status</span></div>
                <div class="panel-body">
					<pre class="api_response" id="response">
						
					</pre>
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
		//App.dataTables();
		$(".select2").select2();
		
	  });
	 $("#update_btn").on("click",function(){
		 
		  $(".text-danger").remove();
		  var apiID = $("#api").val();
		  var error = 0;
		  if(apiID == ''){
			error++;
			$("#api").parent().append('<div class="text-danger">This field is required</div>');
		  }
		  if(error == 0){
			$("#update_btn").attr("disbaled",true);
			$("#update_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
			
			//$('#response').load("<?php echo base_url('assets/log/product_update_'.date('Ymd').'.txt'); ?>");
			$('#response').html("Please wait....");
			var interval = setInterval(function(){
				$('#response').load("<?php echo base_url('assets/log/product_update_'.date('Ymd').'.txt'); ?>");
				$("#response").animate({ scrollTop: $(document).height()*30 }, "slow");
				$("#container").scrollTop($("#response").height());
			},1000);
			
			$.ajax({
				url:'<?php echo base_url('admin/updating_api_products');?>',
				type:'POST',
				data:{'apiID':apiID},
				dataType:'JSON'
			}).success(function(data){
				$("#update_btn").removeAttr("disbaled");
				$("#update_btn").html("Update");
				clearInterval(interval);
				$('#response').load("<?php echo base_url('assets/log/product_update_'.date('Ymd').'.txt'); ?>");
				$("#response").animate({ scrollTop: $(document).height()*30 }, "slow");
				$("#container").scrollTop($("#response").height());
			});
		  }
	  });
	 
    </script>
	
  </body>

</html>