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
					<div class="desc">Users</div>
					<div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="<?php echo $reports->users_count; ?>" class="number">0</span>
					</div>
				  </div>
				</div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
				<div class="widget widget-tile">
				  <div id="spark2" class="chart sparkline"></div>
				  <div class="data-info">
					<div class="desc">Products</div>
					<div class="value"><span class="indicator indicator-positive mdi mdi-chevron-up"></span><span data-toggle="counter" data-end="<?php echo $reports->products_count; ?>" class="number">0</span>
					</div>
				  </div>
				</div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
				<div class="widget widget-tile">
				  <div id="spark3" class="chart sparkline"></div>
				  <div class="data-info">
					<div class="desc">API</div>
					<div class="value"><span class="indicator indicator-positive mdi mdi-chevron-up"></span><span data-toggle="counter" data-end="<?php echo $reports->api_count; ?>" class="number">0</span>
					</div>
				  </div>
				</div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
				<div class="widget widget-tile">
				  <div id="spark4" class="chart sparkline"></div>
				  <div class="data-info">
					<div class="desc">Product Views</div>
					<div class="value"><span class="indicator indicator-negative mdi mdi-chevron-down"></span><span data-toggle="counter" data-end="<?php echo $reports->views_count; ?>" class="number">0</span>
					</div>
				  </div>
				</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="widget widget-fullwidth be-loading">
                <div class="widget-head">
                  <div class="tools">
                    <div class="dropdown"><span data-toggle="dropdown" class="icon mdi mdi-more-vert visible-xs-inline-block dropdown-toggle"></span>
                      <ul role="menu" class="dropdown-menu">
                        <li><a href="#" class="chart_type" data-value="TODAY">Today</a></li>
                        <li><a href="#" class="chart_type" data-value="WEEK">Week</a></li>
                        <li><a href="#" class="chart_type" data-value="MONTH">Month</a></li>
                        <li><a href="#" class="chart_type" data-value="YEAR">Year</a></li>
                      </ul>
                    </div>
				  </div>
                  <div class="button-toolbar hidden-xs">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default chart_type active" data-value="TODAY">Today</button>
                      <button type="button" class="btn btn-default chart_type" data-value="WEEK">Week</button>
                      <button type="button" class="btn btn-default chart_type" data-value="MONTH">Month</button>
                      <button type="button" class="btn btn-default chart_type" data-value="YEAR">Year</button>
                    </div>
                  </div>
				  <span class="title">Recent Movement</span>
                </div>
                <div class="widget-chart-container">
                  <div class="widget-chart-info">
                    <ul class="chart-legend-horizontal">
                      <li><span data-color="main-chart-color1"></span> Customers</li>
                      <li><span data-color="main-chart-color2"></span> Products</li>
                      <li><span data-color="main-chart-color3"></span> Product Views</li>
                    </ul>
                  </div>
                  <div class="widget-counter-group widget-counter-group-right">
                    <div class="counter counter-big">
                      <div class="value" id="customers_count"><?php echo $chart->users_count; ?></div>
                      <div class="desc">Customers</div>
                    </div>
                    <div class="counter counter-big">
                      <div class="value" id="products_count"><?php echo $chart->products_count; ?></div>
                      <div class="desc">Products</div>
                    </div>
                    <div class="counter counter-big">
                      <div class="value" id="views_count"><?php echo $chart->views_count; ?></div>
                      <div class="desc">Product Views</div>
                    </div>
                  </div>
                  <div id="placeholder" style="height: 260px;"></div>
                </div>
                <div class="be-spinner">
                  <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                    <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="panel panel-default panel-table">
                <div class="panel-heading"> 
                  <div class="title">Recent Customers</div>
                </div>
                <div class="panel-body table-responsive">
                  <table class="table table-striped table-borderless">
                    <thead>
                      <tr>
                        <th style="width:30%;">Name</th>
                        <th style="width:40%;">Email</th>
                        <th style="width:30%;">Date</th>
                      </tr>
                    </thead>
                    <tbody class="no-border-x">
                      <?php foreach($users as $u){ ?>
					  <tr>
                        <td><?php echo $u->first_name.' '.$u->last_name; ?></td>
                        <td><?php echo $u->email; ?></td>
						<td><?php echo date('M d, Y',strtotime($u->created_date)); ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">
                   <div class="title">Recent Products</div>
                </div>
                <div class="panel-body table-responsive">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th style="width:40%;">Name</th>
                        <th style="number">Price</th>
                        <th>Source</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      
						<tr>
							<td class="user-avatar"> <img src="assets/img/avatar6.png" alt="Avatar">iPhone 5S</td>
							<td>$23</td>
							<td>Best Buy</td>
							<td>Aug 16, 2016</td>
						</tr>
                     
                    </tbody>
                  </table>
                </div>
              </div>
			  
			  </div>
          </div>
        </div>
      </div>
      
	  
	  
    </div>
	<?php echo $footer; ?>
	
	<script type="text/javascript">
		
	</script>
	
    <script type="text/javascript">
      $(document).ready(function(){
      	//initialize the javascript
      	App.init();
      	//App.dashboard();
		
		$('[data-toggle="counter"]').each(function(a,b){var c=$(this),d="",e="",f=0,g=0,h=0,i=2.5;c.data("prefix")&&(d=c.data("prefix")),c.data("suffix")&&(e=c.data("suffix")),c.data("start")&&(f=c.data("start")),c.data("end")&&(g=c.data("end")),c.data("decimals")&&(h=c.data("decimals")),c.data("duration")&&(i=c.data("duration"));var j=new CountUp(c.get(0),f,g,h,i,{suffix:e,prefix:d});j.start()})
		
		var a=App.color.primary,b=App.color.warning,c=App.color.success,d=App.color.danger;
		$("#spark1").sparkline([0,5,3,7,5,10,3,6,5,10],{width:"85",height:"35",lineColor:a,highlightSpotColor:a,highlightLineColor:a,fillColor:!1,spotColor:!1,minSpotColor:!1,maxSpotColor:!1,lineWidth:1.15}),$("#spark2").sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8],{type:"bar",width:"85",height:"35",barWidth:3,barSpacing:3,chartRangeMin:0,barColor:b}),$("#spark3").sparkline([2,3,4,5,4,3,2,3,4,5,6,5,4,3,4,5,6,5,4,4,5],{type:"discrete",width:"85",height:"35",lineHeight:20,lineColor:c,xwidth:18}),$("#spark4").sparkline([2,5,3,7,5,10,3,6,5,7],{width:"85",height:"35",lineColor:d,highlightSpotColor:d,highlightLineColor:d,fillColor:!1,spotColor:!1,minSpotColor:!1,maxSpotColor:!1,lineWidth:1.15})
		
		
		
      });
    </script>
	
	<script type="text/javascript">
	
			
	$(".chart_type").on('click',function(){
		var value = $(this).data('value');
		
		$(".chart_type").removeClass("active");
		$(this).addClass("active");
		
		var a=App.color.danger,b=tinycolor(App.color.primary).lighten(10).toString(),c=tinycolor(App.color.warning).lighten(10).toString();
		var options = {
			lines: {
				show: true
			},
			points: {
				show: true
			},
			xaxis: {
				tickDecimals: 0,
				tickSize: 1
			},
			colors:[a,b,c]
		};
		
		$.ajax({
			url:'<?php echo base_url('admin/get_report');?>',
			type:'POST',
			data:{'type':value},
			dataType:'JSON'
		}).success(function(data){
			
			$("#customers_count").html(data['users_count']);
			$("#products_count").html(data['products_count']);
			$("#views_count").html(data['views_count']);
			
			var d=[[1,0],[2,data['users_count']],[3,0]];
			var e=[[1,0],[2,data['products_count']],[3,0]];
			var f=[[1,0],[2,data['views_count']],[3,0]];
			
			var data = [{data:d},{data:e},{data:f}];
			$.plot("#placeholder", data, options);
			
			$('[data-color="main-chart-color1"]').css({"background-color":a}),$('[data-color="main-chart-color2"]').css({"background-color":b}),$('[data-color="main-chart-color3"]').css({"background-color":c});
		});
	});
	</script>
	
	
  </body>

</html>