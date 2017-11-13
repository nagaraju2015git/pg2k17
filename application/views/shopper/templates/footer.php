
	  
<script src="<?php echo base_url(); ?>/assets/admin/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/js/bootstrap-notify.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/js/main.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/js/fileupload.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/jquery-flot/jquery.flot.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/jquery-flot/jquery.flot.pie.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/jquery-flot/jquery.flot.resize.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/jquery-flot/plugins/jquery.flot.orderBars.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/jquery-flot/plugins/curvedLines.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/jquery.sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/countup/countUp.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/jqvmap/jquery.vmap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>/assets/admin/lib/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/datatables/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/datatables/plugins/buttons/js/dataTables.buttons.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/datatables/plugins/buttons/js/buttons.html5.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/datatables/plugins/buttons/js/buttons.flash.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/datatables/plugins/buttons/js/buttons.print.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/datatables/plugins/buttons/js/buttons.colVis.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/datatables/plugins/buttons/js/buttons.bootstrap.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>/assets/admin/lib/jquery.nestable/jquery.nestable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/moment.js/min/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/select2/js/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/bootstrap-slider/js/bootstrap-slider.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>/assets/admin/lib/summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/summernote/summernote-ext-beagle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/admin/lib/markdown-js/markdown.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/fileupload.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.bootstrap-responsive-tabs.min.js"></script>
<script src="<?php echo $this->config->item('node_server_url').'/socket.io/socket.io.js'; ?>"></script>

<script>
	var myUserID = '<?php echo $this->session->userdata('userID'); ?>';
	var myImage = '<?php if(file_exists($this->session->userdata('image')))echo base_url($this->session->userdata('image')); else echo base_url($this->config->item('default_image_user')); ?>';
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
