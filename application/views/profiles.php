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
				<h2 class="page-tittle">Profiles <button class="pull-right" id="create_btn"><i class="fa fa-plus"></i> Create Profile</button></h2>
				
				<?php foreach($profiles as $pr){ ?>
				<div class="profile-info">
					<div class="row">
						<div class="col-md-8">
							<b>Gifts for <?php echo $pr->name; ?></b>
							<span>Reason for Gift: <?php echo $pr->reason; ?></span>
							<span class="space">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
							<span>Date for Gift: <?php echo date('M,d Y',strtotime($pr->date_for_gift)); ?></span>
							<span class="space">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
							<span>Relation To You: <?php echo $pr->relation; ?></span>
						</div>
						<div class="col-md-4">
							<div class="actions">
								<button type="button" data-id="<?php echo $pr->id; ?>" class="pedit"><i class="fa fa-pencil"></i></button>
								<button type="button" class="btn-danger pdelete" data-id="<?php echo $pr->id; ?>"><i class="fa fa-trash"></i></button>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row plist">
						
					<?php $i=0;foreach($products as $p){ if($p->profile_id == $pr->id){ ?>
					<div class="col-md-3 col-sm-4 col-xs-6">
						<div class="product">
							<?php if($p->source != 'User'){ ?>
							<button class="like" data-id="<?php echo $p->id; ?>"><?php if($p->liked > 0){?><i class="fa fa-heart"></i><?php }else{ ?><i class="fa fa-heart-o"></i><?php } ?></button>
							<?php } ?>
							<button class="gift" data-id="<?php echo $p->id; ?>"><i class="fa fa-gift"></i></button>
							<a href="<?php echo $p->product_link; ?>" target="_blank">
								<div class="img">
									<img src="<?php echo $p->image; ?>">
								</div>
								<div class="content">
									<div class="title"><?php echo $p->name; ?></div>
									<div class="price"><?php echo $this->config->item('currency'); ?><?php echo $p->price; ?></div>
								</div>
							</a>
						</div>
					</div>
					<?php $i++;} } ?>
					
				</div>
				
				<?php if($i==0)echo '<p>No products</p>'; ?>
				
				<?php } ?>
			</div>			
		</section>
		
			<!-- Profile Modal -->
			<div class="modal fade" id="profile_modal" role="dialog">
				<div class="modal-dialog">
				
				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-body">
					<div class="row">
					  <div class="col-sm-12">
						<form id="profile_form">
							<input type="hidden" name="id" id="pid" value="0">
							<input type="hidden" name="type" id="ptype" value="INSERT">
						  <div class="form-group">
							<label>Profile Name:</label>
							<input class="form-control" placeholder="Profile Name" type="text" name="name" id="pname">
						  </div>
						  
						  <div class="form-group">
							<label>Reason for Gift:</label>
							<input class="form-control" placeholder="Reason" type="text" name="reason" list="preason">
							<datalist id="preason">
								<option value="Birthday">Birthday</option>
								<option value="Anniversary">Anniversary</option>
								<option value="Valentines Day">Valentines Day</option>
							</datalist>
						  </div>
						  <div class="form-group">
							<label>Date For Gift:</label>
							<input class="form-control" type="date"  name="date" id="pdate">
						  </div>
						  <div class="form-group">
							<label>Relation To You:</label>
							<input class="form-control" placeholder="Relation To You"  type="text" name="relation" list="prelation">
							<datalist id="prelation">
								<option value="Friend">Friend</option>
								<option value="Significant Other">Significant Other</option>
								<option value="Mom">Mom</option>
								<option value="Dad">Dad</option>
								<option value="Brother">Brother</option>
								<option value="Sister">Sister</option>
								<option value="Daughter/Niece">Daughter/Niece</option>
								<option value="Son/Nephew">Son/Nephew</option>
								<option value="Other">Other</option>
							</datalist>
						  </div>
						  <button type="button" id="submit_btn"><i class="fa fa-floppy-o"></i> Submit</button>
						  <button type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
						  </form>
						</div>
					</div>
					</div>
				</div>
				  
				</div>
			  </div>
			<!--profile Modal -->
			<div id="modal_remove" tabindex="-1" role="dialog" class="modal fade">
			  <div class="modal-dialog confirm">
				<div class="modal-content">
				 <div class="modal-body">
					<div class="text-center">
					  <div class="text-danger"><span class="fa fa-times"></span></div>
					  <h3>Delete!</h3>
					  <p>Are you sure want to delete profile?</p>
					</div>
				  </div>
				  <div class="modal-footer">
					 <div class="text-center">
						<button type="button" class="btn btn-space btn-danger" id="delete_btn">Delete</button>
						<button type="button" data-dismiss="modal" class="btn btn-space btn-default">Cancel</button>
					  </div>
				  </div>
				</div>
			  </div>
			</div>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		<script>
			$("#create_btn").on("click",function(){
				$("#profile_form")[0].reset();
				$("#ptype").val('INSERT');
				$("#profile_modal").modal("show");
			});
			$(document).on("click",".pedit",function(){
				var id = $(this).data("id");
				$.ajax({
					url:'<?php echo base_url('home/get_profile');?>',
					type:'POST',
					data:{'id':id,'type':'S'},
					dataType:'JSON'
				}).done(function(data){	
					$("#ptype").val('UPDATE');
					$("#pid").val(data.id);
					$("#pname").val(data.name);
					$("#preason").val(data.reason);
					$("#prelation").val(data.relation);
					$("#pdate").val(data.date_for_gift);
					$("#profile_modal").modal("show");
				});
				
			});
			$(".pdelete").on("click",function(){
				var id = $(this).data("id");
				$("#delete_btn").data("id",id);
				$("#modal_remove").modal("show");
			  });
			$("#delete_btn").click(function() {
				var id = $(this).data("id");
				$("#delete_btn").attr("disabled",true);
				$("#delete_btn").html("Please Wait...");
				var id = $(this).data("id");
				$.ajax({
					url:'<?php echo base_url('home/ins_upd_profile');?>',
					type:'POST',
					data:{'id':id,'type':'DELETE'},
					dataType:'JSON'
				}).done(function(data){	
					window.location.reload();
				});
			});
			$("#submit_btn").on("click",function(){
				var error=0;$("#profile_form .text-danger,#profile_form .text-success").remove();
				
				$("#profile_form input").each(function(){
					if($(this).val().trim() == ''){
						error++;
						$(this).parent().append('<div class="text-danger">This field is required</div>');
					}
				});
				
				
				if(error == 0){
					$("#submit_btn").attr("disabled",true);
					$("#submit_btn").html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
					var formData = new FormData($("#profile_form")[0]);
					$.ajax({
						url:'<?php echo base_url('home/ins_upd_profile');?>',
						type:'POST',
						data:formData,
						dataType:'JSON',
						cache : false,
						contentType : false,
						processData : false
					}).done(function(data){					
						if(data.status == 1){
							$("#profile_form").prepend('<div class="text-success text-center">'+data.message+'</div>');
							window.location.reload();
						}else{
							$("#profile_form").prepend('<div class="text-danger text-center">'+data.message+'</div>');
							$("#submit_btn").removeAttr("disabled");
							$("#submit_btn").html("Save");
						}
						
					});
				}
			});
		</script>
		
			
    </body>

</html>