<!DOCTYPE html>
<html lang="en">
  
<?php echo $head; ?>
  
  <body>
    <div class="be-wrapper be-fixed-sidebar">
	
      <?php echo $header; ?>
	  
	  <div class="be-content">
        <div class="main-content container-fluid">
			<form class="form-horizontal" id="api_form">
			<div class="row">
            <div class="col-md-6">
              <div class="panel panel-default panel-border-color panel-border-color-primary" id="fetch_form">
                <div class="panel-heading panel-heading-divider">API Configuration - Fetch</span></div>
                <div class="panel-body">
				
					<div class="form-group">
                      <label class="col-sm-3">Test URL <span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" id="testUrl" name="testURL" value="<?php if(isset($api->testUrl))echo $api->testUrl; ?>">
                      </div>
					</div>
					
					<div class="form-group">
                      <label class="col-sm-3">JSON Root Path <span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" id="rootPath" name="rootPath" value="<?php if(isset($api->rootPath))echo $api->rootPath; ?>">
                      </div>
					</div>
					
					<div class="form-group">
                      <label class="col-sm-3">ID<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product ID depth" id="id_depth" name="id_depth" value="<?php if(isset($api->id_depth))echo $api->id_depth; ?>">
                      </div>
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Name<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product Name Depth" name="name_depth" id="name_depth" value="<?php if(isset($api->name_depth))echo $api->name_depth; ?>">
                      </div>					  
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Image<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product Image Depth" name="image_depth" id="image_depth" value="<?php if(isset($api->image_depth))echo $api->image_depth; ?>">
                      </div>
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Product URL<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product URL Depth" name="url_depth" id="url_depth" value="<?php if(isset($api->url_depth))echo $api->url_depth; ?>">
                      </div>
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Price<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product Price Depth" name="price_depth" id="price_depth" value="<?php if(isset($api->price_depth))echo $api->price_depth; ?>">
                      </div>
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Offer Price<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product Offer Price Depth" name="offer_price_depth" id="offer_price_depth" value="<?php if(isset($api->offer_price_depth))echo $api->offer_price_depth; ?>">
                      </div>
					</div>
					<div class="col-md-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="validate_fetch_btn">Validate</button>
                    </div>
                </div>
              </div>
            </div>
			<div class="col-md-6">
              <div class="panel panel-default panel-border-color panel-border-color-primary" id="update_form">
                <div class="panel-heading panel-heading-divider">API Configuration - Update</span></div>
                <div class="panel-body">
					<pre class="api_response hide" id="api_response"></pre>
					
					<div class="form-group">
                      <label class="col-sm-3">Test URL <span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" id="updateTestUrl" name="updateTestUrl" value="<?php if(isset($api->updateTestUrl))echo $api->updateTestUrl; ?>">
                      </div>
					</div>
					
					<div class="form-group">
                      <label class="col-sm-3">JSON Root Path <span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" id="updateRootPath" name="updateRootPath" value="<?php if(isset($api->updateRootPath))echo $api->updateRootPath; ?>">
                      </div>
					</div>
					
					<div class="form-group">
                      <label class="col-sm-3">ID<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product ID depth" id="update_id_depth" name="update_id_depth" value="<?php if(isset($api->update_id_depth))echo $api->update_id_depth; ?>">
                      </div>
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Name<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product Name Depth" name="update_name_depth" id="update_name_depth" value="<?php if(isset($api->update_name_depth))echo $api->update_name_depth; ?>">
                      </div>					  
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Image<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product Image Depth" name="update_image_depth" id="update_image_depth" value="<?php if(isset($api->update_image_depth))echo $api->update_image_depth; ?>">
                      </div>
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Product URL<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product URL Depth" name="update_url_depth" id="update_url_depth" value="<?php if(isset($api->update_url_depth))echo $api->update_url_depth; ?>">
                      </div>
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Price<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product Price Depth" name="update_price_depth" id="update_price_depth" value="<?php if(isset($api->update_price_depth))echo $api->update_price_depth; ?>">
                      </div>
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Offer Price<span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" placeholder="JSON Product Offer Price Depth" name="update_offer_price_depth" id="update_offer_price_depth" value="<?php if(isset($api->update_offer_price_depth))echo $api->update_offer_price_depth; ?>">
                      </div>
					</div>
					<div class="col-md-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="validate_update_btn">Validate</button>
                    </div>
                </div>
              </div>
            </div>
          </div>
		  
		  <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">API Configuration</span></div>
                <div class="panel-body">
				
					<div class="form-group">
                      <label class="col-sm-2">Name <span>*</span></label>
                      <div class="col-sm-10">
                        <input req="true" type="text" class="form-control" name="name" value="<?php if(isset($api->name))echo $api->name; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2">Key <span>*</span></label>
                      <div class="col-sm-10">
                        <input req="true" type="text" class="form-control" name="key" value="<?php if(isset($api->apiKey))echo $api->apiKey; ?>">
                      </div>
                    </div>
					
					<div class="url_div" id="url_div">
						<?php $i=0;foreach($api_url as $u){ ?>
							<div class="box url" id="urlbox_<?php echo $i; ?>">
								<div class="form-group">
								  <label class="col-md-2">Name <span>*</span></label>
								  <div class="col-md-10">
									<input req="true" type="text" class="form-control" name="name_<?php echo $i; ?>" value="<?php echo $u->name; ?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-md-2">Url <span>*</span></label>
								  <div class="col-md-10">
									<input req="true" type="text" class="form-control" name="url_<?php echo $i; ?>" value="<?php echo $u->apiUrl; ?>">
								  </div>
								</div>
								<div class="remove" data-count="<?php echo $i; ?>"><i class="mdi mdi-delete"></i> Remove</div>
							</div>
						<?php $i++; } ?>
                    </div>
					<div class="form-group">
                      <div class="col-md-3">&nbsp;</div>
                      <div class="col-md-6">
                       <button class="btn btn-primary btn-sm" type="button" id="add_url"><i class="mdi mdi-plus"></i> Add URL</button>
                      </div>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-3">Update URL <span>*</span></label>
                      <div class="col-sm-9">
                        <input req="true" type="text" class="form-control" id="updateUrl" name="updateUrl" value="<?php if(isset($api->updateUrl))echo $api->updateUrl; ?>">
                      </div>
					</div>
					
					<div class="form-group">
                      <label class="col-sm-3">Is Amazon API </label>
                      <label class="col-sm-7 text-left">
                        <input type="checkbox" name="aws" value="1" <?php if(isset($api->aws))if($api->aws == 1)echo 'checked'; ?>>
                      </label>
                    </div>
					
					<div class="form-group">
                      <label class="col-sm-2">Secret Key</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="secret_key" value="<?php if(isset($api->secret_key))echo $api->secret_key; ?>">
                      </div>
                    </div>
					
					<div class="col-md-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                        <a href="<?php echo base_url('admin/api'); ?>" class="btn btn-default btn-lg">Cancel</a>
                    </div>
					
				</div>
			  </div>
			</div>
		  </div>
		  
		  </form>
		</div>
      </div>
      
	  
    </div>
	<?php echo $footer; ?>
   
    <script type="text/javascript">
      $(document).ready(function(){
		App.init();
      	App.dataTables();
      });
	  $("#testUrl").on("blur",function(){
		$("#api_response").html("");
		$("#api_response").addClass("loading");
		$.ajax({
			url:'<?php echo base_url('admin/get_api_response');?>',
			type:'POST',
			data:{'testURL':$("#testUrl").val()},
			dataType:'JSON'
		}).success(function(data){
			try {
				var data = JSON.stringify(JSON.parse(data),null,2);  
			} catch (e) {
				var data = JSON.stringify(data,null,2);  
			}
			
			$("#api_response").html(data);
			$("#api_response").removeClass("loading");
		});
	  });
	  
	  function validate_fetch(submit){
		var error=0;$(".text-danger").remove();
		$("#fetch_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		
		var testURL = $("#testUrl").val();
		var rootPath = $("#rootPath").val();
		var id_depth = $("#id_depth").val();
		var name_depth = $("#name_depth").val();
		var image_depth = $("#image_depth").val();
		var url_depth = $("#url_depth").val();
		var price_depth = $("#price_depth").val();
		var offer_price_depth = $("#offer_price_depth").val();
		
		if(error == 0){
			$("#validate_fetch_btn").attr("disabled",true);
			$("#validate_fetch_btn").html("Please wait...");
			
			$.ajax({
				url:'<?php echo base_url('admin/validate_url');?>',
				type:'POST',
				data:{'testURL':testURL,'rootPath':rootPath,'id_depth':id_depth,'name_depth':name_depth,'image_depth':image_depth,'url_depth':url_depth,'price_depth':price_depth,'offer_price_depth':offer_price_depth},
				dataType:'JSON'
			}).success(function(data){
				
				if(data.status == 1){
					$.notify({ message: 'Fetch API validated successfully' },{type: 'success'});
					if(submit == 1){
						validate_update(1)
					}
				}
				else
					$.notify({ message: "Fetch API - "+ data.message },{type: 'danger'});
				
				$("input").removeClass("has-error");
				$("input").removeClass("has-success");					
				
				if(data.product.id == true){
					$("#id_depth").addClass("has-success");
				}else{
					$("#id_depth").addClass("has-error");
					error++;
					$("#id_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.name == true){					
					$("#name_depth").addClass("has-success");
				}else{
					$("#name_depth").addClass("has-error");
					error++;
					$("#name_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.image == true){					
					$("#image_depth").addClass("has-success");
				}else{
					$("#image_depth").addClass("has-error");
					error++;
					$("#image_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.url == true){					
					$("#url_depth").addClass("has-success");
				}else{
					$("#url_depth").addClass("has-error");
					error++;
					$("#url_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.price == true){					
					$("#price_depth").addClass("has-success");
				}else{
					$("#price_depth").addClass("has-error");
					error++;
					$("#price_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.offer_price == true){					
					$("#offer_price_depth").addClass("has-success");
				}else{
					$("#offer_price_depth").addClass("has-error");
					error++;
					$("#offer_price_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				$("#validate_fetch_btn").removeAttr("disabled");
				$("#validate_fetch_btn").html("Validate");
			});
		  }
	  }
	  
	  function validate_update(submit){
		var error=0;$(".text-danger").remove();
		$("#update_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		
		var testURL = $("#updateTestUrl").val();
		var rootPath = $("#updateRootPath").val();
		var id_depth = $("#update_id_depth").val();
		var name_depth = $("#update_name_depth").val();
		var image_depth = $("#update_image_depth").val();
		var url_depth = $("#update_url_depth").val();
		var price_depth = $("#update_price_depth").val();
		var offer_price_depth = $("#update_offer_price_depth").val();
		
		if(error == 0){
			$("#validate_update_btn").attr("disabled",true);
			$("#validate_update_btn").html("Please wait...");
			
			$.ajax({
				url:'<?php echo base_url('admin/validate_url');?>',
				type:'POST',
				data:{'testURL':testURL,'rootPath':rootPath,'id_depth':id_depth,'name_depth':name_depth,'image_depth':image_depth,'url_depth':url_depth,'price_depth':price_depth,'offer_price_depth':offer_price_depth},
				dataType:'JSON'
			}).success(function(data){
				
				if(data.status == 1){
					$.notify({ message: 'Update API validated successfully' },{type: 'success'});
					if(submit == 1){
						submit_api();
					}
				}
				else{
					$.notify({ message: "Update API - "+ data.message },{type: 'danger'});
				}
				
				$("input").removeClass("has-error");
				$("input").removeClass("has-success");					
				
				if(data.product.id == true){
					$("#update_id_depth").addClass("has-success");
				}else{
					$("#update_id_depth").addClass("has-error");
					error++;
					$("#update_id_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.name == true){					
					$("#update_name_depth").addClass("has-success");
				}else{
					$("#update_name_depth").addClass("has-error");
					error++;
					$("#update_name_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.image == true){					
					$("#update_image_depth").addClass("has-success");
				}else{
					$("#update_image_depth").addClass("has-error");
					error++;
					$("#update_image_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.url == true){					
					$("#update_url_depth").addClass("has-success");
				}else{
					$("#update_url_depth").addClass("has-error");
					error++;
					$("#update_url_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.price == true){					
					$("#update_price_depth").addClass("has-success");
				}else{
					$("#update_price_depth").addClass("has-error");
					error++;
					$("#update_price_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				if(data.product.offer_price == true){					
					$("#update_offer_price_depth").addClass("has-success");
				}else{
					$("#update_offer_price_depth").addClass("has-error");
					error++;
					$("#update_offer_price_depth").parent().append('<div class="text-danger">Invalid</div>');
				}
				
				$("#validate_update_btn").removeAttr("disabled");
				$("#validate_update_btn").html("Validate");
				
			});
		}
	  }
	  
	  function submit_api(){
		var error=0;$(".text-danger").remove();
		$("#api_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		
		if(error == 0){
			$("#submit_btn").attr("disabled",true);
			$("#submit_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
			
			var formData = new FormData($("#api_form")[0]);
			<?php if(isset($api->id)){ ?>
			formData.append('type','UPDATE');
			formData.append('id','<?php echo $api->id;?>');
			<?php }else{ ?>
			formData.append('type','INSERT');
			<?php } ?>
			formData.append('count',$("#url_div .url").length);
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_api');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location = '<?php echo base_url(); ?>admin/api';},2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  }
	  
	  
	  $("#validate_fetch_btn").on("click",function(){
		  validate_fetch(0);
	  });
	  $("#validate_update_btn").on("click",function(){
		  validate_update(0);
	  });
	  $("#submit_btn").on("click",function(){
		  validate_fetch(1);
	  });
	  
	  $("#add_url").on("click",function(){
		  var count = $("#url_div .url").length;
		  
		  var html = '<div class="box url" id="urlbox_'+count+'">'+
						'<div class="form-group">'+
						  '<label class="col-md-2">Name <span>*</span></label>'+
						  '<div class="col-md-10">'+
							'<input req="true" type="text" class="form-control" name="name_'+count+'">'+
						  '</div>'+
						'</div>'+
						'<div class="form-group">'+
						  '<label class="col-md-2">Url <span>*</span></label>'+
						  '<div class="col-md-10">'+
							'<input req="true" type="text" class="form-control" name="url_'+count+'">'+
						  '</div>'+
						'</div>'+
						'<div class="remove" data-count="'+count+'"><i class="mdi mdi-delete"></i> Remove</div>'+
					'</div>';
		$("#url_div").append(html);
		
	  });
	  $(document).on("click",".remove",function(){
		  var count = $(this).data("count");
		  $("#urlbox_"+count).remove();
	  });
	 
	  
    </script>
	
  </body>

</html>