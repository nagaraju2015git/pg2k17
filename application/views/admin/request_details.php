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
                <div class="panel-heading">Request Details</div>
                <div class="rd">
					<div class="row">
						<div class="col-md-3">
							User Name : <b><?php echo $request->first_name.' '.$request->last_name; ?></b>
						</div>
						<div class="col-md-3">
							Shopper Name : <b><?php echo $request->shopperName; ?></b>
							<a href="#" data-toggle="modal" data-target="#myModal">Assign</a>
						</div>
						<div class="col-md-3">
							Status : 
							<?php if($request->status == 'Ongoing'){ ?>
							<b class="label label-warning"><?php echo $request->status; ?></b> 
							<div class="dropdown" style="display:inline-block;"><a href="#" dropdown-toggle" type="button" data-toggle="dropdown">Change</a><span class="caret"></span></a>
							  <ul class="dropdown-menu">
								<li><a href="#" id="completed" data-id="<?php echo $request->id; ?>">Completed</a></li>
							  </ul>
							</div>
							<?php }else if($request->status == 'Completed'){  ?>
							<b class="label label-success"><?php echo $request->status; ?></b>
							<?php } ?>
						</div>
						<div class="col-md-3">
							Date : <b><?php echo date('d M Y h:i A',strtotime($request->created_date)); ?></b>
						</div>
					</div>
				</div>
				<div class="tab-container">
                  <ul class="nav nav-tabs">
					<li class="active"><a href="#suggested_tab" data-toggle="tab" aria-expanded="true">Suggested Products</a></li>
                    <li class=""><a href="#accepted_tab" data-toggle="tab" aria-expanded="false">Accepted Products</a></li>
                    <li class=""><a href="#rejected_tab" data-toggle="tab" aria-expanded="false">Rejected Products</a></li>
                    <li class=""><a href="#chat_tab" data-toggle="tab" aria-expanded="false">Chat</a></li>
                  </ul>
                  <div class="tab-content">
					<div id="suggested_tab" class="tab-pane cont active">
                      <table class="table table-striped table-bordered table-hover table-fw-widget tp">
							<thead>
								<tr>
									<th>Product Name</th>
									<th style="width:100px;">Price</th>
									<th style="width:100px;">Category</th>
									<th style="width:100px;">Status</th>
								</tr>
							</thead>
							<tbody>
							  <?php foreach($products as $p){ if($p->status == 'Suggested'){ ?>
							  <tr>
								<td><a href="<?php echo $p->product_link; ?>" target="_blank"><img src="<?php echo $p->image; ?>"><div class="name"><?php echo $p->name; ?></div></a></td>
								<td><?php echo $this->config->item('currency').' '.$p->price; ?></td>
								<td><?php echo $p->categoryName; ?></td>
								<td><span class="label label-warning"><?php echo $p->status; ?></span></td>
								</tr>
							  <?php } } ?>
							</tbody>
						</table>
                    </div>
                    <div id="accepted_tab" class="tab-pane">
                      <table class="table table-striped table-bordered table-hover table-fw-widget tp">
							<thead>
								<tr>
									<th>Product Name</th>
									<th style="width:100px;">Price</th>
									<th style="width:100px;">Category</th>
									<th style="width:100px;">Status</th>
								</tr>
							</thead>
							<tbody>
							  <?php foreach($products as $p){ if($p->status == 'Accepted'){ ?>
							  <tr>
								<td><a href="<?php echo $p->product_link; ?>" target="_blank"><img src="<?php echo $p->image; ?>"><div class="name"><?php echo $p->name; ?></div></a></td>
								<td><?php echo $this->config->item('currency').' '.$p->price; ?></td>
								<td><?php echo $p->categoryName; ?></td>
								<td><span class="label label-success"><?php echo $p->status; ?></span></td>
								
							  </tr>
							  <?php } } ?>
							</tbody>
						</table>
                    </div>
					<div id="rejected_tab" class="tab-pane">
                      <table class="table table-striped table-bordered table-hover table-fw-widget tp">
							<thead>
								<tr>
									<th>Product Name</th>
									<th style="width:100px;">Price</th>
									<th style="width:100px;">Category</th>
									<th style="width:100px;">Status</th>
								</tr>
							</thead>
							<tbody>
							  <?php foreach($products as $p){ if($p->status == 'Rejected'){ ?>
							  <tr>
								<td><a href="<?php echo $p->product_link; ?>" target="_blank"><img src="<?php echo $p->image; ?>"><div class="name"><?php echo $p->name; ?></div></a></td>
								<td><?php echo $this->config->item('currency').' '.$p->price; ?></td>
								<td><?php echo $p->categoryName; ?></td>
								<td><span class="label label-danger"><?php echo $p->status; ?></span></td>
							</tr>
							  <?php } } ?>
							</tbody>
						</table>
                    </div>
					<div id="chat_tab" class="tab-pane">
                      <div class="chat_window" id="chat_window">
						<div class="top_menu">
							<img class="pic" src="<?php echo base_url($this->config->item('default_image_user')); ?>">
							<div class="ub">
								<div class="name"><?php echo $request->first_name.' '.$request->last_name; ?></div> 
								<div class="chat" id="online_status">Offline</div>
							</div>
						</div>
						<ul class="messages" id="messages"></ul>
						<div class="bottom_wrapper clearfix">
							<div class="message_input_wrapper">
								<input class="message_input" placeholder="Type your message here..." id="message_input"/>
							</div>
							<button class="send_message" id="send">Send</button>
						</div>
					</div>
                    </div>
                  </div>
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
		 </div>
			  <div class="modal-body">
				<div class="text-center">
				  <div class="text-success"><span class="modal-main-icon mdi mdi-check-circle"></span></div>
				  <h3>Confirm!</h3>
				  <p>Are you sure want to accept this request?>
				  <div class="xs-mt-50">
					<button type="button" data-dismiss="modal" class="btn btn-space btn-default">Cancel</button>
					<button type="button" class="btn btn-space btn-success" id="confirm_btn">Proceed</button>
				  </div>
				</div>
			  </div>
		  <div class="modal-footer"></div>
		</div>
	  </div>
	</div>
	<div id="modal-questions" tabindex="-1" role="dialog" class="modal fade saq" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-body"></div>
          <div class="text-center">
            <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Close</button>
		  </div>
		  <br>
        </div>
      </div>
    </div>
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Shoppers</h4>
		  </div>
		  <div class="modal-body">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Shopper</th>
						<th>Email</th>
						<th>Assign</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($shoppers as $s){ if($s->id != $request->shopper_id){ ?>
					<tr>
						<td><?php echo $s->first_name.' '.$s->last_name; ?></td>
						<td><?php echo $s->email; ?></td>
						<td><button class="btn btn-sm btn-primary assign" data-id="<?php echo $s->id; ?>">Assign</button></td>
					</tr>
				<?php } } ?>
				</tbody>
			</table>
		 
			<div class="text-center">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		   </div>
		</div>

	  </div>
	</div>
	<?php echo $footer; ?>
   
    <?php echo $chat; ?>
	
	<script type="text/javascript">
      $(document).ready(function(){
		App.init();
      	App.dataTables();
      });
	  $(".accept").on("click",function(){
		  var id = $(this).data("id");
		  $("#confirm_btn").data("id",id);
		  $("#modal-confirm").modal("show");
	  });
	  $(".view").on("click",function(){
		var userID = $(this).data("userid");
		$.ajax({
			url:'<?php echo base_url('shopper/get_user_requests');?>',
			type:'POST',
			data:{'userID':userID,'type':'ANSWERS'},
			dataType:'JSON'
		}).success(function(data){
			var html = '';
			for(var i=0;i<data.length;i++){
			html+='<br><div class="sa mt-10">'+
					'<div class="qt">'+(i+1)+'. '+data[i]['question']+'</div>'+
					'<textarea readonly class="form-control">'+data[i]['answer']+'</textarea>'+
				'</div>';
			}
			$("#modal-questions .modal-body").html(html);
			$("#modal-questions").modal("show");			
		});
	  })
	  $(".deny").on("click",function(){
		var id = $(this).data("id");

		$("#delete_btn").data("id",id);
		$("#modal-remove").modal("show");
	  });
	
	  
	 $(".suggest").on("click",function(){
		var obj = $(this);
		var id = obj.data("id");
		obj.attr('disabled',true);
		obj.html('<i class="mdi mdi-spinner"></i>');
		$.ajax({
			url:'<?php echo base_url('shopper/ins_upd_user_requests');?>',
			type:'POST',
			data:{'id':<?php echo $request->id ?>,'productID':id,'type':'SUGGEST','shopperID':<?php echo $this->session->userdata('userID'); ?>},
			dataType:'JSON'
		}).success(function(data){
			if(data.status){
				$.notify({ message: data.message },{type: 'success'});
				setTimeout(function(){window.location.reload()},2000);
			}else{
				$.notify({ message: data.message },{type: 'danger'});
			}
		});
	  });
	  $("#completed").on("click",function(){
		var obj = $(this);
		obj.attr('disabled',true);
		obj.html('<i class="mdi mdi-spinner"></i>');
		$.ajax({
			url:'<?php echo base_url('shopper/ins_upd_user_requests');?>',
			type:'POST',
			data:{'id':<?php echo $request->id ?>,'type':'COMPLETED'},
			dataType:'JSON'
		}).success(function(data){
			if(data.status){
				$.notify({ message: data.message },{type: 'success'});
				setTimeout(function(){window.location.reload()},2000);
			}else{
				$.notify({ message: data.message },{type: 'danger'});
			}
		});
	  });
	  $(".assign").on("click",function(){
		var obj = $(this);
		var userID = $(this).data("id");
		obj.attr('disabled',true);
		obj.html('<i class="mdi mdi-spinner"></i>');
		$.ajax({
			url:'<?php echo base_url('shopper/ins_upd_user_requests');?>',
			type:'POST',
			data:{'id':<?php echo $request->id ?>,'type':'ASSIGN','shopperID':userID},
			dataType:'JSON'
		}).success(function(data){
			$("#myModal").modal("hide");
			if(data.status){
				$.notify({ message: data.message },{type: 'success'});
				setTimeout(function(){window.location.reload()},2000);
			}else{
				$.notify({ message: data.message },{type: 'danger'});
			}
			
		});
	  });
    </script>
  </body>

</html>