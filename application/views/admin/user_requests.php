<!DOCTYPE html>
<html lang="en">
  
<?php echo $head; ?>
  
  <body>
    <div class="be-wrapper be-fixed-sidebar">
	
      <?php echo $header; ?>
	  
	  <div class="be-content">
        <div class="main-content container-fluid">
			
			<div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">
					<div class="row">
						<div class="col-md-6">User Requests</div>
						<div class="col-md-6 text-right"> 
							
						</div>
					</div>
                </div>
                <div class="panel-body">
                  
				  <div class="col-md-12">
					  <div class="row">
						<div class="col-md-4">
							<input type="text" class="form-control" id="key" placeholder="Search...">
						</div>
						<div class="col-md-4">
							<select class="form-control" id="shopper">
								<option value="">Select Shopper</option>
								<?php foreach($shoppers as $s){ ?>
								<option value="<?php echo $s->id; ?>"><?php echo $s->first_name.' '.$s->last_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-2">
							<select class="form-control" id="status">
								<option value="">Select Status</option>
								<option>New</option>
								<option>Ongoing</option>
								<option>Completed</option>
							</select>
						</div>
						<div class="col-md-2">
							<button class="btn btn-primary btn-lg" id="search_btn">Search</button>
						</div>
					  </div>
				  </div>
				  
				  <table class="table table-striped table-hover table-fw-widget">
					<thead>
						<tr>
							<th>Request ID</th>
							<th>User</th>
							<th>Shopper</th>
							<th>Date Time</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
                    <tbody id="user_requests">
                      <?php $i=1;foreach($requests as $r){ ?>
					  <tr>
                        <td><?php echo $r->id; ?></td>
                        <td><?php echo $r->userName; ?></td>
                        <td><?php if($r->shopperName)echo $r->shopperName;else echo '--'; ?></td>
                        <td><?php echo date('d M,y h:i A',strtotime($r->created_date)); ?></td>
                        <td><?php echo $r->status ?></td>
						<td>
							<a href="<?php echo base_url('admin/request_details/'.$r->id); ?>" class="btn btn-primary"> View</a> 
						</td>
                      </tr>
                      <?php $i++; } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
			
		</div>
      </div>
      
	  
    </div>
	
	<div id="modal-confirm" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
			<h4 class="modal-title">Modal Header</h4>
		  </div>
			  <div class="modal-body">
				<div class="text-center">
				  <div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
				  <h3>Confirm!</h3>
				  <p>Confirm Shopper?>
				  <div class="xs-mt-50">
					<button type="button" data-dismiss="modal" class="btn btn-space btn-default">Cancel</button>
					<button type="button" class="btn btn-space btn-danger" id="confirm_btn">Proceed</button>
				  </div>
				</div>
			  </div>
		  <div class="modal-footer"></div>
		</div>
	  </div>
	</div>
	<div id="modal-remove" tabindex="-1" role="dialog" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
          </div>
          <div class="modal-body">
            <div class="text-center">
              <div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
              <h3>Deny!</h3>
              <p>Deny Shopper?</p>
              <div class="xs-mt-50">
                <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Cancel</button>
                <button type="button" class="btn btn-space btn-danger" id="delete_btn">Proceed</button>
              </div>
            </div>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>
	
	<?php echo $footer; ?>
   
    <script type="text/javascript">
      $(document).ready(function(){
		App.init();
      	App.dataTables();
      });
	  $(".deny").on("click",function(){
		var id = $(this).data("id");

		$("#delete_btn").data("id",id);
		$("#modal-remove").modal("show");
	  });
	  $("#delete_btn").on("click",function(){
		var obj = $(this);
		var id = obj.data("id");
		obj.attr('disabled',true);
		obj.html('<i class="mdi mdi-spinner"></i>');
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_shopper');?>',
			type:'POST',
			data:{'id':id,'type':'DENY'},
			dataType:'JSON'
		}).success(function(data){
			$("#modal-remove").modal("hide");
			if(data.status){
				$.notify({ message: data.message },{type: 'success'});
				setTimeout(function(){window.location.reload()},2000);
			}else{
				$.notify({ message: data.message },{type: 'danger'});
			}
		});
	  });
	  
$(".confirm").on("click",function(){
		var id = $(this).data("id");
		var fname=$(this).data("fname");
		var phone=$(this).data("phone");
		$("#confirm_btn").data("id",id);
		$("#confirm_btn").data("fname",fname);
		$("#confirm_btn").data("phone",phone);
		
		$("#modal-confirm").modal("show");
	  });
	  
	  
	 $("#confirm_btn").on("click",function(){
		var obj = $(this);
		var id = obj.data("id");
		var fname=obj.data("fname");
		var phone=obj.data("phone");
		obj.attr('disabled',true);
		obj.html('<i class="mdi mdi-spinner"></i>');
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_shopper');?>',
			type:'POST',
			data:{'id':id,'type':'CONFIRM','fname':fname,'phone':phone},
			dataType:'JSON'
		}).success(function(data){
			$("#modal-confirm").modal("hide");
			if(data.status){
				$.notify({ message: data.message },{type: 'success'});
				setTimeout(function(){window.location.reload()},2000);
			}else{
				$.notify({ message: data.message },{type: 'danger'});
			}
		});
	  });
	  $("#search_btn").on("click",function(){
		var obj = $(this);
		obj.attr('disabled',true);
		obj.html('<i class="mdi mdi-spinner"></i>');
		$.ajax({
			url:'<?php echo base_url('admin/get_user_requests');?>',
			type:'POST',
			data:{'key':$("#key").val(),'type':'SEARCH','shopper':$("#shopper").val(),'status':$("#status").val()},
			dataType:'JSON'
		}).success(function(data){
			var html = '';
			for(var i=0;i<data.length;i++){
				html+='<tr>'+
					'<td>'+data[i]['user']+'</td>'+
					'<td>'+data[i]['shopper']+'</td>'+
					'<td>'+data[i]['date_time']+'</td>'+
					'<td>'+data[i]['status']+'</td>'+
					'<td>'+
						'<a href="<?php echo base_url('admin/request_details'); ?>/'+data[i]['id']+'" class="btn btn-primary"> View</a> '+
					'</td>'+
				  '</tr>';
			}
			$("#user_requests").html(html);
			obj.removeAttr('disabled');
			obj.html('Search');
		});
	  });
    </script>
  </body>

</html>