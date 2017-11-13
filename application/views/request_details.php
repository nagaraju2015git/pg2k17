<!DOCTYPE html>
<html lang="en">
	
	<!-- HEAD -->
	<?php echo $head; ?>
	<!-- HEAD -->
	
    <body>
        
		<!-- HEADER -->
		<?php echo $header;?>
		<!-- HEADER -->
        
		<section class="profile mbh">
			<div class="container">
				<h2 class="page-tittle">Request Details</h2>
				<div class="rd">
					<div class="row">
						<div class="col-md-7">
							Shopper Name : <b><?php echo $request->shopperName; ?></b>
						</div>
						<div class="col-md-2">
							Status : 
							<?php if($request->status == 'Ongoing'){  ?>
							<b class="label label-warning"><?php echo $request->status; ?></b> 
							<?php }else if($request->status == 'Completed'){  ?>
							<b class="label label-success"><?php echo $request->status; ?></b>
							<?php } ?>						
						</div>
						<div class="col-md-3">
							Date : <b><?php echo date('d M Y h:i A',strtotime($request->created_date)); ?></b>
						</div>
					</div>
				</div>
				<div class="box">
				<ul class="nav nav-tabs responsive-tabs">
				  <li class="active"><a data-toggle="tab" href="#suggested_tab">Suggested</a></li>
				  <li><a data-toggle="tab" href="#accepted_tab">Accepted</a></li>
				  <li><a data-toggle="tab" href="#rejected_tab">Rejected</a></li>
				  <li><a data-toggle="tab" href="#chat_tab">Chat</a></li>
				</ul>

				<div class="tab-content">
				  <div id="suggested_tab" class="tab-pane fade in active">
					<div class="row plist mt-10">						
					<?php foreach($products as $p){ if($p->status == 'Suggested'){ ?>
					<div class="col-md-3 col-sm-4 col-xs-6">
						<div class="product">
							<button class="like" data-id="<?php echo $p->id; ?>"><i class="fa fa-heart"></i></button>
							<button class="gift" data-id="<?php echo $p->id; ?>"><i class="fa fa-gift"></i></button>
							<a href="<?php echo $p->product_link; ?>" target="_blank">
								<div class="img">
									<img src="<?php echo $p->image; ?>">
								</div>
								<div class="content">
									<div class="title"><?php echo $p->name; ?></div>
									<div class="price bb"><?php echo $this->config->item('currency'); ?><?php echo $p->price; ?></div>
									<button class="btn btn-sm btn-success accept" data-id="<?php echo $p->urpID; ?>" data-type="Accept"><i class="fa fa-check"></i> <span class="hidden-xs">Accept</span></button>
									<button class="btn btn-sm btn-danger reject" data-id="<?php echo $p->urpID; ?>"  data-type="Reject"><i class="fa fa-times"></i> <span class="hidden-xs">Reject</span></button>
								</div>
							</a>							
						</div>
					</div>
					<?php } } ?>				
					</div>
				  </div>
				  <div id="accepted_tab" class="tab-pane fade in">
					<div class="row plist mt-10">						
					<?php foreach($products as $p){ if($p->status == 'Accepted'){ ?>
					<div class="col-md-3 col-sm-4 col-xs-6">
						<div class="product">
							<button class="like" data-id="<?php echo $p->id; ?>"><i class="fa fa-heart"></i></button>
							<button class="gift" data-id="<?php echo $p->id; ?>"><i class="fa fa-gift"></i></button>
							<a href="<?php echo $p->product_link; ?>" target="_blank">
								<div class="img">
									<img src="<?php echo $p->image; ?>">
								</div>
								<div class="content">
									<div class="title"><?php echo $p->name; ?></div>
									<div class="price bb"><?php echo $this->config->item('currency'); ?><?php echo $p->price; ?></div>
									<button class="btn btn-sm btn-danger reject" data-id="<?php echo $p->urpID; ?>"  data-type="Reject">Reject</button>
								</div>
							</a>							
						</div>
					</div>
					<?php } } ?>				
					</div>
				  </div>
				  <div id="rejected_tab" class="tab-pane fade in">
					<div class="row plist mt-10">						
					<?php foreach($products as $p){ if($p->status == 'Rejected'){ ?>
					<div class="col-md-3 col-sm-4 col-xs-6">
						<div class="product">
							<button class="like" data-id="<?php echo $p->id; ?>"><i class="fa fa-heart"></i></button>
							<button class="gift" data-id="<?php echo $p->id; ?>"><i class="fa fa-gift"></i></button>
							<a href="<?php echo $p->product_link; ?>" target="_blank">
								<div class="img">
									<img src="<?php echo $p->image; ?>">
								</div>
								<div class="content">
									<div class="title"><?php echo $p->name; ?></div>
									<div class="price bb"><?php echo $this->config->item('currency'); ?><?php echo $p->price; ?></div>
									<button class="btn btn-sm btn-success accept" data-id="<?php echo $p->urpID; ?>" data-type="Accept">Accept</button>
								</div>
							</a>							
						</div>
					</div>
					<?php } } ?>				
					</div>
				  </div>
				  <div id="chat_tab" class="tab-pane fade in">
					<div class="chat_window" id="chat_window">
						<div class="top_menu">
							<img class="pic" src="<?php echo base_url($this->config->item('default_image_user')); ?>">
							<div class="ub">
								<div class="name"><?php echo $request->shopperName; ?></div> 
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
		</section>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		<?php echo $chat; ?>		
		
		<script>
			$(".accept,.reject").on("click",function(e){
				e.preventDefault();
				var obj = $(this);
				var urpID = obj.data("id");
				var status = obj.data("type");
				obj.attr('disabled',true);
				obj.html('<i class="fa fa-refresh fa-spin"></i>');
				$.ajax({
					url:'<?php echo base_url('shopper/ins_upd_user_requests');?>',
					type:'POST',
					data:{'id':<?php echo $request->id; ?>,'urpID':urpID,'type':'ACCEPT_REJECT','status':status},
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
			
		</script>
		
			
    </body>

</html>