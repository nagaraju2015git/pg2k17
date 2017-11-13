<!DOCTYPE html>
<html lang="en">
	
	<!-- HEAD -->
	<?php echo $head; ?>
	<!-- HEAD -->
	
    <body>
        
		<!-- HEADER -->
		<?php echo $header;?>
		<!-- HEADER -->
        
		<section>
			<div class="container">
				<h2 class="page-tittle">Users</h2>
				<div class="search-labels">
					<?php if($key != NULL){ ?>
						<a href="<?php echo base_url('home/users'); ?>">Search key(<?php echo $key; ?>) <i class="fa fa-times"></i></a>
					<?php } ?>
				</div>
				<?php if(count($users) > 0){ ?>
				<?php foreach($users as $u){ ?>
				<a class="puser_link" href="<?php echo base_url('home/user_profile/'.$u->id); ?>" target="_blank"  style="background-image:url('<?php echo $u->image; ?>')">
					<div class="puser">
						<?php echo $u->name; ?>
					</div>
				</a>
				<?php } ?>
				<?php }else{ ?>
				<h4>No users found</h4>
				<?php } ?>
					
			</div>			
		</section>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		
    </body>

</html>