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
                      <label class="col-md-1" style="padding-right:0px;">Select API <span>*</span></label>
                      <div class="col-md-3">
                       <select class="select2" data-placeholder="Select" id="api">
							<option></option>
							<?php foreach($api as $a){ ?>
							<option value="<?php echo $a->id; ?>"><?php echo $a->name; ?></option>
							<?php } ?>
					   </select>
                      </div>
                      <label class="col-md-1" style="padding-right:0px;">Select URL <span>*</span></label>
                      <div class="col-md-3">
                       <select class="select2" data-placeholder="Select" id="url">
							<option></option>
					   </select>
                      </div>
					  <div class="col-md-2">
                        <button class="btn btn-primary btn-lg" type="button" id="fetch_btn">Fetch</button>
                      </div>
					</div>	
					
					</form>
                </div>
              </div>
            </div>
          </div>
		  
		  <div class="row hide" id="products_list">
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
	  $("#api").on("change",function(){
		var apiID = $("#api").val();
		var html = '<option></option>';
		$("#url").html(html);
		$.ajax({
			url:'<?php echo base_url('admin/get_api');?>',
			type:'POST',
			data:{'id':apiID,'type':'URL_S'},
			dataType:'JSON'
		}).success(function(data){
			for(var i=0;i<data.length;i++){
				html+='<option value="'+data[i]['apiUrl']+'">'+data[i]['name']+'</option>';
			}
			$("#url").html(html);
			$("#url").select2({width:'100%'});
		});
	  });
	  $("#fetch_btn").on("click",function(){
		  $("#products_div").addClass("hide");
		  $(".text-danger").remove();
		  var apiID = $("#api").val();
		  var url = $("#url").val();
		  var error = 0;
		  if(apiID == ''){
			error++;
			$("#api").parent().append('<div class="text-danger">This field is required</div>');
		  }
		  if(url == ''){
			error++;
			$("#url").parent().append('<div class="text-danger">This field is required</div>');
		  }
		  if(error == 0){
			$("#fetch_btn").attr("disbaled",true);
			$("#fetch_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
			$.ajax({
				url:'<?php echo base_url('admin/get_product_from_api');?>',
				type:'POST',
				data:{'apiID':apiID,'url':url},
				dataType:'HTML'
			}).success(function(data){
				$("#fetch_btn").removeAttr("disbaled");
				$("#fetch_btn").html("Fetch");
				$("#products_list").html(data);
				$("#products_list").removeClass("hide");
				$(".select2").select2();
			});
		  }
	  });
	  $(document).on("click",".select_product",function(){
		  var id = $(this).data("id");
		  if($(this).is(":checked")){
			  $("#category_"+id).removeAttr("disabled");
			  $("#navigation_"+id).removeAttr("disabled");
			  $("#min_age_"+id).removeAttr("disabled");
			  $("#max_age_"+id).removeAttr("disabled");
		  }else{
			  $("#category_"+id).attr("disabled",true);
			  $("#navigation_"+id).attr("disabled",true);
			  $("#min_age_"+id).attr("disabled",true);
			  $("#max_age_"+id).attr("disabled",true);
		  }
	  });
	  $(document).on("click","#submit_btn",function(){
		var error=0;$(".text-danger").remove();
		//alert("ok");
		$(".select_product").each(function(){
			var obj = $(this);
			if(obj.is(":checked")){
				var id = obj.data("id");
				if($("#category_"+id).val() == '' || $("#category_"+id).val() == null){
					error++;
					$("#category_"+id).parent().append('<div class="text-danger">This field is required</div>');
				}
				if($("#navigation_"+id).val() == '' || $("#navigation_"+id).val() == null){
					error++;
					$("#navigation_"+id).parent().append('<div class="text-danger">This field is required</div>');
				}
				if($("#min_age_"+id).val() == ''){
					error++;
					$("#min_age_"+id).parent().append('<div class="text-danger">This field is required</div>');
				}
				if($("#max_age_"+id).val() == ''){
					error++;
					$("#max_age_"+id).parent().append('<div class="text-danger">This field is required</div>');
				}
			}
		});
		var products = [];var ic = 0;
		$(".select_product").each(function(){
		  if($(this).is(":checked")){
			var id = $(this).data("id");
			var product = [];
			product[0] = $("#category_"+id).val();
			product[1] = $("#navigation_"+id).val();
			product[2] = $("#min_age_"+id).val();
			product[3] = $("#max_age_"+id).val();
			product[4] = $(this).val();
			products[ic] = product;
			ic++;
		  }
		});
		if(products.length == 0){
			error++;
			$.notify({ message: 'Please select atleast one product.' },{type: 'danger'}); 
		}
		//alert(error);
		if(error == 0){
			$("#submit_btn").attr("disabled",true);
			$("#submit_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
			var formData = new FormData($("#product_form")[0]);
			formData.append('type','INSERT_API_PRODUCTS');
			formData.append('products',JSON.stringify(products));
			formData.append('apiID',$("#api").val());
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
	  });
    </script>
	
  </body>

</html>