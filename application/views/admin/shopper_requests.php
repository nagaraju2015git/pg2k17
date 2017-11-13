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
						<div class="col-md-6">Shopper Approval</div>						
					</div>
                </div>
                <div class="panel-body">
                  <table id="table1" class="table table-striped table-hover table-fw-widget">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Name</th>
							<th>Gender</th>
							<th>Email</th>
							<th>Phone</th>
							<th>City</th>
							<th>Actions</th>
						</tr>
					</thead>
                    <tbody>
                      <?php $i=1;foreach($shoppers as $sa){ ?>
					  <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $sa->first_name." ".$sa->last_name; ?></td>
                        <td><?php echo $sa->gender ?></td>
                        <td><?php echo $sa->email ?></td>
                        <td><?php echo $sa->phone ?></td>
                        <td><?php echo $sa->city ?></td>
						<td>
							<button class="btn btn-success confirm" title="confirm" data-id="<?php echo $sa->id; ?>" data-fname="<?php echo $sa->first_name; ?>" data-phone="<?php echo $sa->phone; ?>" ><i class="mdi mdi-check"  style="font-size:18px"></i></button>
							<button class="btn btn-danger deny" title="Deny" data-id="<?php echo $sa->id; ?>"><i class="mdi mdi-close" style="font-size:18px"></i></button>
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
				  <div class="text-success"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
				  <h3>Confirm!</h3>
				  <p>Confirm Shopper?>
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
    </script>
  </body>

</html>