<!DOCTYPE html>
<html lang="en">
	
	<!-- HEAD -->
	<?php echo $head; ?>
	<!-- HEAD -->
	
    <body style="background-color:#fff;">
        
		<!-- HEADER -->
		<?php echo $header;?>
		<!-- HEADER -->
        
		<section>
			<div class="home-slide owl-carousel">
				<?php foreach($slides as $s) { ?>
				<div class="item slide" style="background-image:url('<?php echo $s->image; ?>');">
					<div class="container">
						<div class="caption">
							<h2>LOOKING FOR GREAT GIFT IDEAS?</h2>
							<?php if($this->session->userdata('logged_in') != true){ ?>
							<a class="signup-email" href="<?php echo base_url('home/signup');?>">
								<i class="fa fa-envelope"></i> <span>Sign Up with Email</span>
							</a>
							<a class="signin-facebook" href="<?php echo $fb_login_url; ?>">
								<i class="fa fa-facebook"></i> <span>Sign In with Facebook</span>
							</a>
							<?php } ?>
							<h2>LET US HELP!</h2>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>                        
		</section>
		
		<section class="home-banners">
			<div class="container">
				<div class="row">
					
					<?php foreach($banners as $b){ ?>
					<div class="col-md-6 col-xs-6">
						<div class="thumbnail thumbnail-banner size-1x3">
							<div class="media">
								<a class="media-link" href="<?php echo base_url('home/products/'.$b->slideUrl); ?>">
									<div class="img-bg" style="background-image: url('<?php echo $b->image; ?>')"></div>
									<div class="caption">
										<div class="caption-wrapper div-table">
											<div class="caption-inner">
												<h2 class="caption-title"><span><?php echo $b->title; ?></span></h2>
												<span class="btn btn-theme btn-theme-sm">Shop Now</span>
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
					<?php } ?>
					
				</div>
			</div>
		</section>
		
		<?php $i=1;foreach($sections as $s){ ?>
		<?php if(count($s['products']) > 0){ ?>
		<section class="padding-50 <?php if($i%2 == 0)echo ' bgg';?>">
			<div class="container">
				<h2 class="title"><?php echo $s['name']; ?> </h2>
				<div class="home_sections hlist">
					<?php foreach($s['products'] as $p){ ?>
					<div class="item">
						<div class="product">
							<button class="like" data-id="<?php echo $p->id; ?>"><?php if($p->liked > 0){?><i class="fa fa-heart"></i><?php }else{ ?><i class="fa fa-heart-o"></i><?php } ?></button>
							<button class="gift" data-id="<?php echo $p->id; ?>"><i class="fa fa-gift"></i></button>
							<a href="<?php echo $p->product_link; ?>" class="plink" data-id="<?php echo $p->id; ?>">
								<div class="img">
									<img src="<?php echo $p->image; ?>">
								</div>
								<div class="content">
									<div class="title"><?php echo $p->name; ?></div>
									<div class="price"><?php echo $this->config->item('currency'); ?><?php echo $p->price; ?></div>
								</div>
							</a>
						</div>
					</div>
					<?php } ?>
				</div>
				<div class="text-center"><a href="<?php echo base_url('home/products_home/'.$s['id']); ?>" class="view-more"> View More <i class="fa fa-caret-right"></i></a></div>
			</div>
		</section>
		<?php } ?>
		<?php $i++;} ?>
		<?php if(count($reviews) > 0){ ?>
		<section class="padding-50 <?php if($i%2 == 1)echo ' bgg';?>">
			<div class="container">
				<h2 class="title">Reviews</h2>
				<div class="reviews">
					<?php foreach($reviews as $r){ ?>
					<div class="item">
						<div class="media">
							<img class="media-object" src="<?php echo $r->image; ?>">
							<div class="media-body">
								<h4 class="media-heading"><?php echo $r->name; ?></h4>
								<q><?php echo substr($r->review, 0, 200); ?></q>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</section>
		<?php } ?>
		<?php if(count($posts) > 0){ ?>
		<section class="padding-50 <?php if($i%2 == 0)echo ' bgg';?>">
			<div class="container">
				<h2 class="title">Our Recent Posts</h2>
				<div class="row">
					
					<?php foreach($posts as $p){ ?>
					<div class="col-md-6">
						<div class="recent-post">
							<div class="media">
								<a class="pull-left media-link" href="<?php echo $p->url; ?>" target="_blank">
									<img class="media-object" src="<?php echo $p->image; ?>" alt="">
								</a>
								<div class="media-body">
									<h4 class="media-heading"><a href="<?php echo $p->url; ?>" target="_blank"><?php echo substr($p->title, 0, 40); ?></a></h4>
									<p><?php echo substr($p->description, 0, 150); ?></p>
									<div class="media-meta">
										<?php echo date('d M, Y',strtotime($p->created_date)); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
					
				</div>
			</div>
		</section>
		<?php } ?>
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->

    </body>

</html>