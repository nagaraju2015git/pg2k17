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
				<h2 class="page-tittle"><?php if(isset($navigation->name))echo $navigation->name;else echo 'Products'; ?> 
				<button class="pull-right visible-xs" id="m-filter">Filters <i class="fa fa-angle-down"></i></button>
				</h2>
				<div class="row">
					<div class="col-md-2 col-sm-3">
						<div class="search-box" id="search-box">
							<?php if(count($navigationSub) > 0){ ?>
							<div class="title"><?php if(isset($navigation->name))echo $navigation->name; ?> </div>
							<ul>
								<?php foreach($navigationSub as $n){ ?>
								<li><a href="<?php echo base_url();?>home/products/<?php echo $n->slug;?>"><?php echo $n->name; ?></a></li>
								<?php } ?>
							</ul>
							<?php } ?>
							<div class="title">Categories</div>
							<ul>
								<?php foreach($categories as $c){ ?>
								<?php 
									$url = base_url('home/products/'.$navigationSlug);
									$data = array(
										'key' => $key,
										'category' => $c->id,
										'age' => $age,
										'price' => $price
									);
									$url.='?'.http_build_query($data). "\n";
									$url = str_replace('%2C', ',', $url);
								?>
								
								<li><a <?php if($c->id == $category)echo 'class="active"';?> href="<?php echo $url; ?>"><?php echo $c->name; ?></a></li>
								<?php } ?>
							</ul>
							<?php foreach($filterKey as $k){ ?>
							<div class="title"><?php echo $k->filterKey; ?></div>
							<ul>
								<?php foreach($filters as $f){ if($k->filterKey == $f->filterKey){ ?>
								
								<?php 
									$url = base_url('home/products/'.$navigationSlug);
									
									if($k->filterKey == 'age'){
										$data = array(
											'key' => $key,
											'category' => $category,
											'age' => $f->id,
											'price' => $price
										);
									}
									
									if($k->filterKey == 'price'){
										$data = array(
											'key' => $key,
											'category' => $category,
											'age' => $age,
											'price' => $f->id
										);
									}
									
									$url.='?'.http_build_query($data). "\n";
									$url = str_replace('%2C', ',', $url);
								?>
								
								<li><a <?php if($f->id == $price || $f->id == $age)echo 'class="active"';  ?> href="<?php echo $url; ?>"><?php echo $f->name; ?></a></li>
								<?php } } ?>
							</ul>
							<?php } ?>
						</div>
					</div>
					<div class="col-md-10 col-sm-9">
						<div class="search-labels">
							
							<?php if($key != NULL){ ?>
								<?php 
									$url = base_url('home/products/'.$navigationSlug);
									$data = array(
										'category' => $category,
										'age' => $age,
										'price' => $price
									);
									$url.='?'.http_build_query($data). "\n";
									$url = str_replace('%2C', ',', $url);
								?>
								<a href="<?php echo $url; ?>">Search key(<?php echo $key; ?>) <i class="fa fa-times"></i></a>
							<?php } ?>
							<?php foreach($categories as $c){ if($c->id == $category){ ?> 
								<?php 
									$url = base_url('home/products/'.$navigationSlug);
									$data = array(
										'age' => $age,
										'price' => $price,
										'key' => $key
									);
									$url.='?'.http_build_query($data). "\n";
									$url = str_replace('%2C', ',', $url);
								?>
								<a href="<?php echo $url; ?>"><?php echo $c->name; ?> <i class="fa fa-times"></i></a>
							<?php } } ?>
							<?php foreach($filters as $f){ if($f->id == $age || $f->id == $price){ ?>
								
								<?php 
									$url = base_url('home/products/'.$navigationSlug);
									
									if($f->filterKey == 'age'){
										$data = array(
											'key' => $key,
											'category' => $category,
											'price' => $price
										);
									}
									
									if($f->filterKey == 'price'){
										$data = array(
											'key' => $key,
											'category' => $category,
											'age' => $age
										);
									}
									
									$url.='?'.http_build_query($data). "\n";
									$url = str_replace('%2C', ',', $url);
								?>
								
								<a href="<?php echo $url; ?>"><?php echo $f->filterKey.'('.$f->name.')'; ?> <i class="fa fa-times"></i></a>
							<?php } } ?>
						</div>
						<?php if(count($products) > 0){ ?>
						<div class="row plist">
							<?php foreach($products as $p){ ?>
							<div class="col-md-3 col-sm-4 col-xs-6">
								<div class="product">
									<button class="like" data-id="<?php echo $p->id; ?>"><?php if($p->liked > 0){?><i class="fa fa-heart"></i><?php }else{ ?><i class="fa fa-heart-o"></i><?php } ?></button>
									<button class="gift" data-id="<?php echo $p->id; ?>"><i class="fa fa-gift"></i></button>
									<a href="<?php echo $p->product_link; ?>" target="_blank" class="plink" data-id="<?php echo $p->id; ?>">
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
						  
						   <?php 
							if($page > 1){ 
							$url = base_url('home/products/'.$navigationSlug);
							$data = array(
								'category' => $category,
								'age' => $age,
								'price' => $price,
								'key' => $key
							);
							$url.='?'.http_build_query($data). "\n";
							$url = str_replace('%2C', ',', $url);
						  
						  ?>
						  <li><a href="<?php echo $url; ?>"><i class="fa fa-angle-left"></i> First</a></li>
						  <?php } ?>
						  <?php for($i=1;$i<=$pages;$i++){ 
							if($i > ($page-6) && $i < ($page+6)){
							$url = base_url('home/products/'.$navigationSlug);
							$data = array(
								'category' => $category,
								'age' => $age,
								'price' => $price,
								'key' => $key,
								'page' => $i
							);
							$url.='?'.http_build_query($data). "\n";
							$url = str_replace('%2C', ',', $url);
						  
						  ?>
						  <li <?php if($i == $page)echo ' class="disabled"'; ?>><a href="<?php echo $url;?>"><?php echo $i; ?></a></li>
						<?php } } ?>
						  					  
						  <?php 
							if($page < $pages){ 
							$url = base_url('home/products/'.$navigationSlug);
							$data = array(
								'category' => $category,
								'age' => $age,
								'price' => $price,
								'key' => $key,
								'page' => (int)($pages)
							);
							$url.='?'.http_build_query($data). "\n";
							$url = str_replace('%2C', ',', $url);
						  
						  ?>						  
						  <li><a href="<?php echo $url; ?>">Last <i class="fa fa-angle-right"></i></a></li>
						<?php } ?>
						</ul>
						<?php } ?>
						<?php }else{ ?>
						<h4>No products found</h4>
						<?php } 
						//var_dump($page,$pages,$count);
						?>
					</div>
				</div>
			</div>			
		</section>
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
		
		
    </body>

</html>