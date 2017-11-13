<!DOCTYPE html>
<html lang="en">
  
<?php echo $head; ?>
  
  <body>
    <div class="be-wrapper be-fixed-sidebar">
	
      <?php echo $header; ?>
	  
	  <div class="be-content">
        <div class="main-content container-fluid">
			<div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Status</span></div>
                <div class="panel-body">
					<pre class="api_response" id="response"></pre>
                </div>
            </div>
		</div>
      </div>
      
	  
    </div>
	<?php echo $footer; ?>
   
    <script type="text/javascript">
      $(document).ready(function(){
		App.init();
		
		var interval = setInterval(function(){
			$('#response').load("<?php echo base_url('assets/log/profile_remainder_'.date('Ymd').'.txt'); ?>");
			$("#response").animate({ scrollTop: $(document).height()*30 }, "slow");
		},1000);
		
		$.ajax({
			url:'<?php echo base_url('admin/remainder');?>',
			dataType:'JSON'
		}).success(function(data){
			clearInterval(interval);
			$('#response').load(data);
			$("#response").animate({ scrollTop: $(document).height()*30 }, "slow");
		});
		
	  });
    </script>
	
  </body>

</html>