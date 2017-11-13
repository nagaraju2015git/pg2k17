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
				<h2 class="page-tittle">Personal Shopper Assistant Requests</h2>
				<div class="box">
				<table class="table table-bordered table-striped datatable">
				<thead>
					<tr>
						<th class="visible-xs">Details</th>
						<th class="hidden-xs">Request ID</th>
						<th class="hidden-xs">Title</th>
						<th class="hidden-xs">Shopper</th>
						<th class="hidden-xs">Date</th>
						<th class="hidden-xs">Status</th>
						<th class="hidden-xs">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; foreach($requests as $r){ ?>
					<tr>
						<td class="visible-xs">
							<div><b>Request ID:</b> <?php echo $r->id; ?></div>
							<div><b>Title :</b> <?php echo $r->title; ?></div>
							<div><b>Shopper :</b> <?php if($r->shopperName)echo $r->shopperName;else echo 'No Shopper Assigned'; ?></div>
							<div><b>Status :</b> <?php echo $r->status; ?></div>
							<a href="<?php echo base_url('home/request_details/'.$r->id); ?>" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View</a> 
						</td>
						<td class="hidden-xs"><?php echo $r->id; ?></td>
						<td class="hidden-xs"><?php echo $r->title; ?></td>
						<td class="hidden-xs"><?php if($r->shopperName)echo $r->shopperName;else echo 'No Shopper Assigned'; ?></td>
						<td class="hidden-xs"><?php echo date('d M,y h:i A',strtotime($r->created_date)); ?></td>
						<td class="hidden-xs"><?php echo $r->status; ?> </td>
						<td class="hidden-xs">
							<a href="<?php echo base_url('home/request_details/'.$r->id); ?>" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View</a> 
						</td>
					</tr>
					<?php $i++; } ?>
				</tbody>
				</table>
				</div>
			</div>			
		</section>
		
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		<script>
			
		</script>
		
			
    </body>

</html>