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
				<h2 class="page-tittle"><?php if(isset($section->name))echo $section->name;else echo 'Products'; ?> </h2>
			<?php if(count($products) > 0){ ?>
				<div class="row plist">
					<?php foreach($products as $p){ ?>
					<div class="col-md-3 col-sm-4 col-xs-6">
						<div class="product">
							<button class="like" data-id="<?php echo $p->id; ?>"><?php if($p->liked > 0){?><i class="fa fa-heart"></i><?php }else{ ?><i class="fa fa-heart-o"></i><?php } ?></button>
							<button class="gift" data-id="<?php echo $p->id; ?>"><i class="fa fa-gift"></i></button>
							<a href="<?php echo $p->product_link; ?>" target="_blank">
								<div class="img">
									<?php if(@file_get_contents($p->image)){ ?>
									<img src="<?php echo $p->image; ?>">
									<?php } ?>
								</div>
								<div class="content">
									<div class="title"><?php echo $p->name; ?></div>
									<div class="price"><?php if($p->price == 0)echo "N/A"; else echo $this->config->item('currency')." ".$p->price; ?></div>
								</div>
							</a>
						</div>
					</div>
					<?php } ?>
				</div>
				
				<?php 
				if($count > $this->config->item("default_items")){
				$pages = ($count/$this->config->item("default_items"));
				if($pages > (int)$pages)
					$pages = (int)((int)$pages + 1);
				?>
				
				<ul class="pagination">
				  
				  <?php if($page > 1){	 ?>
				  <li><a href="<?php echo base_url('home/products_home/'.$section->id); ?>"><i class="fa fa-angle-left"></i> First</a></li>
				  <?php } ?>
				  
				  <?php for($i=1;$i<=$pages;$i++){ 
					if($i > ($page-6) && $i < ($page+6)){
				  ?>
				  <li <?php if($i == $page)echo ' class="disabled"'; ?>><a href="<?php echo base_url('home/products_home/'.$section->id.'/'.$i);?>"><?php echo $i; ?></a></li>
				 <?php } } ?>
									  
				 <?php if($page < $pages){ ?>						  
				  <li><a href="<?php echo base_url('home/products_home/'.$section->id.'/'.$pages); ?>">Last <i class="fa fa-angle-right"></i></a></li>
				 <?php } ?>
				 
				</ul>
				<?php } ?>
				<?php }else{ ?>
				<h4>No products found</h4>
				<?php } ?>
			</div>			
		</section>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		
    </body>

</html>