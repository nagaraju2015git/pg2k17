<!DOCTYPE html>
<html lang="en">
  
<?php echo $head; ?>
  
  <body>
    <div class="be-wrapper be-fixed-sidebar">
	
      <?php echo $header; ?>
	  
	  <div class="be-content">
        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
				<div class="widget widget-tile">
				  <div id="spark1" class="chart sparkline"></div>
				  <div class="data-info">
					<div class="desc">New Requests</div>
					<div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="<?php echo $reports['new']; ?>" class="number"><?php echo $reports['new']; ?></span>
					</div>
				  </div>
				</div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
				<div class="widget widget-tile">
				  <div id="spark2" class="chart sparkline"></div>
				  <div class="data-info">
					<div class="desc">Ongoing Requests</div>
					<div class="value"><span class="indicator indicator-positive mdi mdi-chevron-up"></span><span data-toggle="counter" data-end="<?php echo $reports['ongoing']; ?>" class="number"><?php echo $reports['ongoing']; ?></span>
					</div>
				  </div>
				</div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
				<div class="widget widget-tile">
				  <div id="spark3" class="chart sparkline"></div>
				  <div class="data-info">
					<div class="desc">Completed Requests</div>
					<div class="value"><span class="indicator indicator-positive mdi mdi-chevron-up"></span><span data-toggle="counter" data-end="<?php echo $reports['completed']; ?>" class="number"><?php echo $reports['completed']; ?></span>
					</div>
				  </div>
				</div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
				<div class="widget widget-tile">
				  <div id="spark4" class="chart sparkline"></div>
				  <div class="data-info">
					<div class="desc">Users</div>
					<div class="value"><span class="indicator indicator-negative mdi mdi-chevron-down"></span><span data-toggle="counter" data-end="<?php echo $reports['users']; ?>" class="number"><?php echo $reports['users']; ?></span>
					</div>
				  </div>
				</div>
            </div>
          </div>
        </div>
      </div>      
	  
    </div>
	<?php echo $footer; ?>
   
    <script type="text/javascript">
      $(document).ready(function(){
      	//initialize the javascript
      	App.init();
      	App.dashboard();
      });
    </script>
  </body>

</html>