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
                  <table id="table1" class="table table-striped table-hover table-fw-widget">
					<thead>
						<tr>
							<th>Request ID</th>
							<th>Name</th>
							<th class="hidden-xs">Request Title</th>
							<th class="hidden-xs">Answers</th>
							<th class="hidden-xs">Date Time</th>
							<th>Actions</th>
						</tr>
					</thead>
                    <tbody>
                      <?php $i=1;foreach($requests as $r){ ?>
					  <tr>
                        <td><?php echo $r->id; ?></td>
                        <td><?php echo $r->first_name." ".$r->last_name; ?></td>
                        <td  class="hidden-xs"><?php echo $r->title; ?></td>
                        <td class="hidden-xs"><a href="#" class="view" data-id="<?php echo $r->id; ?>"  data-userid="<?php echo $r->userID; ?>">View</a></td>
                        <td class="hidden-xs"><?php echo date('d M,y h:i A',strtotime($r->created_date)); ?></td>
						<td>
							<button class="btn btn-primary accept" title="Accept Request" data-id="<?php echo $r->id; ?>">	<span class="mdi mdi-check"></span><span class="hidden-xs"> Accept</span></button> 
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
	
	<?php echo $footer; ?>
   
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
		var id = $(this).data("id");
		$.ajax({
			url:'<?php echo base_url('shopper/get_user_requests');?>',
			type:'POST',
			data:{'id':id,'userID':userID,'type':'ANSWERS'},
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
	
	  
	 $("#confirm_btn").on("click",function(){
		var obj = $(this);
		var id = obj.data("id");
		obj.attr('disabled',true);
		obj.html('<i class="mdi mdi-spinner"></i>');
		$.ajax({
			url:'<?php echo base_url('shopper/ins_upd_user_requests');?>',
			type:'POST',
			data:{'id':id,'type':'CONFIRM','shopperID':<?php echo $this->session->userdata('userID'); ?>},
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