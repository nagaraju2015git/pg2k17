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
			<div class="shopper-slide">
				<div class="layer">
					<div class="container">
						<div class="caption">
							<h2><?php if(isset($page->heading))echo $page->heading; ?></h2>
							<p><?php if(isset($page->content))echo $page->content; ?></p>
							<a class="btn btn-lg" href="<?php echo base_url('home/shopper_signup');?>">
								<i class="fa fa-envelope"></i> <span><?php if(isset($page->btext))echo $page->btext; ?></span>
							</a>
						</div>
					</div>
				</div>
			</div>                        
		</section>
		
		<section class="padding-30">
			<div class="container hiw">
				<h2 class="title"><?php if(isset($page->pheading))echo $page->pheading; ?></h2>
				<div class="bx2">
					<?php if(isset($page->pcontent))echo $page->pcontent; ?>
				</div>
			</div>
		</section>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->

    </body>

</html>