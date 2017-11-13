<footer class="hide">
	<div class="container">
	   <div class="copyright">Copyright 2017 Painlessgift | All Rights Reserved </div>
	</div>
</footer>
<?php if(isset($data['shopper_page']->stickytext)){ ?>
<div class="sticky-sidebar">
	<a href="<?php echo base_url('home/shopping_assistant'); ?>"> <?php echo $data['shopper_page']->stickytext; ?></a>
</div>
<?php } ?>
<!-- Profile Modal -->
<div class="modal fade" id="gift_modal" role="dialog">
		
</div>
<!--profile Modal -->

<!-- JS Global -->
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/admin/js/bootstrap-notify.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/fileupload.js"></script>
<script src="<?php echo base_url();?>assets/admin/lib/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/lib/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/lib/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.bootstrap-responsive-tabs.min.js"></script>
<script src="<?php echo $this->config->item('node_server_url').'/socket.io/socket.io.js'; ?>"></script>
<!-- JS Page Level -->
<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>

<script>
	var myUserID = '<?php echo $this->session->userdata('userID'); ?>';
	var myImage = '<?php echo $this->session->userdata('image'); ?>';
	var myName = '<?php echo $this->session->userdata('name'); ?>';
	
	$(document).ready(function(){
		$('.responsive-tabs').responsiveTabs({
		  accordionOn: ['xs', 'sm'] // xs, sm, md, lg 
		});
	});
	
	var socket = io.connect('<?php echo $this->config->item('node_server_url'); ?>');
	$(document).ready(function(){
		socket.emit('join', { name:myName, userID:myUserID});		
		
		socket.on('new_message', function (data) {
			if(!$("#chat_tab").hasClass("active")){
				$.notify({ message: data.sendToName+':'+data.message },{type: 'success'});
			}		
		});
	});
</script>

<script>
	$(document).ready(function(){
		//$("#modal-questions").modal("show");
		$(".datatable").dataTable();
		$(".select2").select2();
	});
	$("#search_form").on("submit",function(e){
		e.preventDefault();
		$("#search").trigger("click");
	});
	$("#search").on("click",function(){
		var key = $("#key").val();
		var search_type = $("#search_type").val();
		var url = '<?php echo base_url('home'); ?>';
		if(search_type == 'product')
			url+='/products?key='+key;
		else if(search_type == 'user')
			url+='/users?key='+key;
		window.location = url;
	});
</script>
<script>
	$(".like").on("click",function(e){
		e.preventDefault();
		var obj = $(this);
		var id = obj.data("id");
		<?php if($this->session->userdata('logged_in') == true){ ?>
		$.ajax({
			url:'<?php echo base_url('home/ins_upd_like');?>',
			type:'POST',
			data:{'id':id},
			dataType:'JSON'
		}).done(function(data){	
			if(data)
				obj.html('<i class="fa fa-heart"></i>');
			else
				obj.html('<i class="fa fa-heart-o"></i>');
			window.location.reload();
		});
		<?php }else{ ?>
		window.location = '<?php echo base_url('home/signin'); ?>';
		<?php } ?>
	});
	$(".gift").on("click",function(e){
		e.preventDefault();
		var obj = $(this);
		var id = obj.data("id");
		<?php if($this->session->userdata('logged_in') == true){ ?>
		$.ajax({
			url:'<?php echo base_url('home/get_gift_modal');?>',
			type:'POST',
			data:{'id':id,'type':'GIFT'},
			dataType:'HTML'
		}).done(function(data){	
			$("#gift_modal").html(data);
			$("#gift_modal").modal("show");
		});
		<?php }else{ ?>
		window.location = '<?php echo base_url('home/signin'); ?>';
		<?php } ?>
	});
	$(".plink").on("click",function(e){
		//e.preventDefault();
		var obj = $(this);
		var id = obj.data("id");
		var url = obj.attr("href");
		var target = obj.attr("target");
		if(obj.attr("disabled") != true){
			obj.attr("disabled",true);
			$.ajax({
				url:'<?php echo base_url('home/ins_upd_product_views');?>',
				type:'POST',
				data:{'id':id}
			})
		}
	});
	$(document).on("click",".cp li",function(){
		var obj = $(this);
		var id = obj.data("id");
		var productID = obj.data("pid");
		$.ajax({
			url:'<?php echo base_url('home/ins_upd_gift');?>',
			type:'POST',
			data:{'id':id,'productID':productID},
			dataType:'JSON'
		}).success(function(data){
			if(data){
				obj.addClass('active');
			}else{
				window.location.reload();
				obj.removeClass('active');
			}
		});
	});
</script>
		