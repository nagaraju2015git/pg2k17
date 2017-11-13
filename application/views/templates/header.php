<div id="preloader"><div class="img"></div></div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-100563500-1', 'auto');
  ga('send', 'pageview');
</script>

<input type="hidden" id="path" value="<?php echo base_url(); ?>">
<header>
	<div class="header">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-4">
					<div class="logo">
						<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Logo" /></a>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 m-search text-center">
					<form id="search_form">
						<div class="search">
							<?php 
								$search_type_value = 'product';
								$placeholder = 'Search Gifts, Ideas, Users & More…. '; 
								if(isset($search_type)){
									if($search_type == 'user'){
										$placeholder = 'Search User...'; 
										$search_type_value = 'user';
									}
								}
							?>
							<div class="dropdown search_type">
								<i class="fa fa-search"></i>
								<input type="hidden" value="<?php echo $search_type_value; ?>" id="search_type">
								<ul class="dropdown-menu">
								  <li <?php if($search_type_value == 'product') echo 'class="active"'; ?>><a href="#" data-value="product">Products</a></li>
								  <li <?php if($search_type_value == 'user') echo 'class="active"'; ?>><a href="#" data-value="user">Users</a></li>
								</ul>
							</div>
							<select class="hide">
								<option value="product" <?php if(isset($search_type))if($search_type == 'product')echo 'selected';?>>Products</option>
								<option value="user" <?php if(isset($search_type))if($search_type == 'user')echo 'selected';?>>Users</option>
							</select>
							<input class="search-input" type="text" name="key" id="key" placeholder="<?php echo $placeholder;  ?>" value="<?php if(isset($search_key)){if($search_key != NULL)echo $search_key;} ?>">
							<button type="button" id="search">Search</button>
						</div>
					</form>
				</div>
				<div class="col-md-3 col-sm-3 text-center">
					<?php if($this->session->userdata('logged_in') == true){ ?>
						
						<ul class="user-info hidden-xs">
							<li>
								<a href="#" data-toggle="dropdown">
								<i class="fa fa-bell"></i>
								<div>Notifications</div>
								</a>
								<ul class="dropdown-menu nt">
						
									<?php foreach($data['notifications'] as $n){ ?>
									<li>
										<img src="<?php if(file_exists($n->image))echo base_url($n->image);else echo base_url($this->config->item('default_image_user')); ?>">
										<div class="content">
											<div><?php echo $n->subject; ?></div>
											<div class="time"><i class="fa fa-clock-o"></i> <?php echo date('d M,y h:i A', strtotime($n->created_date)); ?></div>
										</div>
									</li>
									<?php } ?>
									<?php if(count($data['notifications']) == 0){ ?>
									<li>No messages</li>
									<?php } ?>
								</ul>
							</li>
							<li>
								<a href="#" data-toggle="dropdown">
								<img src="<?php if(file_exists($this->session->userdata('image')))echo $this->session->userdata('image');else echo base_url($this->config->item('default_image_user'));  ?>">
								<div>Profile</div>
								</a>
								<ul class="dropdown-menu ud">
									<li><div class="name"><?php echo $this->session->userdata('name'); ?></div></li>
									<li><a href="<?php echo base_url();?>home/profiles"><i class="fa fa-gift"></i> Created Profiles </a></li>
									<li><a href="<?php echo base_url();?>home/likes"><i class="fa fa-thumbs-o-up"></i> Gifts for Me</a></li>
									<li><a href="<?php echo base_url();?>home/requests"><i class="fa fa-cubes"></i> Personal Gift Shopping</a></li>
									<li><a href="<?php echo base_url();?>home/reset_password"><i class="fa fa-unlock-alt"></i> Reset Pasword</a></li>
									<li><a href="<?php echo base_url();?>home/profile"><i class="fa fa-cogs"></i> Settings</a></li>
									<li><a href="<?php echo base_url();?>home/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
								</ul>
							</li>
						</ul>
					
					<?php }else{ ?>
					<div class="login-section hidden-xs">
						<a href="<?php echo base_url('home/signin'); ?>">
						<img src="<?php echo base_url($this->config->item("default_image_user")); ?>">	
						Sign in
						</a>
					</div>
					<?php } ?>
					<button class="navigation visible-xs" id="mh-view"><i class="fa fa-bars"></i></button>
					<button class="navigation visible-xs" id="ms-view"><i class="fa fa-search"></i></button>
				</div>
			</div>
		</div>
		<div class="container sub-header hidden-xs">
			<ul>
				<?php foreach($data['navigations'] as $m){ if($m->parent_id == 0){ ?>
				<li class="dropdown">
					
					<?php if($m->navigation_type == 'page'){ ?>
					<a href="<?php echo base_url('home/page/'.$m->page_id);?>"><?php echo $m->name; ?> </a>
					<?php }else if($m->navigation_type == 'custom'){ ?>
					<a href="<?php echo $m->navigation_link; ?>"><?php echo $m->name; ?> </a>
					<?php }else if($m->navigation_type == 'product'){ ?>
					<a href="<?php echo base_url();?>home/products/<?php echo $m->slug;?>"><?php echo $m->name; ?> 
					<?php if($m->childs > 0){ ?>
					<i class="fa fa-angle-down"></i>
					<?php } ?>
					</a>
					<?php if($m->childs > 0){ ?>
					<ul class="dropdown-list">
						<?php foreach($data['navigations'] as $cm) { if($cm->parent_id == $m->id){ ?>
						<li><a href="<?php echo base_url();?>home/products/<?php echo $cm->slug;?>"><?php echo $cm->name;?> </a></li>
						<?php } } ?>
					</ul>
					<?php } ?>
					<?php } ?>
				</li>
				<?php } } ?>
			</ul>
		</div>
				
	</div>
	
</header>
<div class="m-header hide" id="m-header">
	<div class="m-inner" id="m-inner">
		
		
		<div class="m-user">
			<?php if($this->session->userdata('logged_in') == true){ ?>
				<img src="<?php echo $this->session->userdata('image'); ?>">
				<div class="name"><?php echo $this->session->userdata('name'); ?></div>
				<div class="logout"><a href="<?php echo base_url();?>home/logout">Logout <i class="fa fa-sign-out"></i></a></div>
				<ul>
					<li><a href="<?php echo base_url();?>home/profiles"><i class="fa fa-users"></i> Profiles</a></li>
					<li><a href="<?php echo base_url();?>home/likes">| <i class="fa fa-gift"></i> Likes</a></li>
					<li><a href="<?php echo base_url();?>home/requests">| <i class="fa fa-gift"></i> Requests</a></li>
					<li><a href="<?php echo base_url();?>home/profile">| <i class="fa fa-cog"></i> Settings</a></li>
					<li><a href="<?php echo base_url();?>home/reset_password">| <i class="fa fa-key"></i> Reset</a></li>
				</ul>
			<?php }else{ ?>
				<img src="<?php echo base_url($this->config->item('default_image_user')); ?>">
				<a href="<?php echo base_url('home/signin'); ?>" class="name">Login</a>
			<?php } ?>
		
		</div>
		
		<ul class="m-list">
			<?php foreach($data['navigations'] as $m){ if($m->parent_id == 0){ ?>
			<li class="dropdown">
				
				<?php if($m->navigation_type == 'page'){ ?>
				<a href="<?php echo base_url('home/page/'.$m->page_id);?>"><?php echo $m->name; ?> </a>
				<?php }else if($m->navigation_type == 'custom'){ ?>
				<a href="<?php echo $m->navigation_link; ?>"><?php echo $m->name; ?> </a>
				<?php }else if($m->navigation_type == 'product'){ ?>
				<span class="toggle"><i class="fa fa-angle-down"></i></span>
				<a href="<?php echo base_url();?>home/products/<?php echo $m->slug;?>"><?php echo $m->name; ?> </a>
				<ul class="dropdown-list">
					<?php foreach($data['navigations'] as $cm) { if($cm->parent_id == $m->id){ ?>
					<li><a href="<?php echo base_url();?>home/products/<?php echo $cm->slug;?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $cm->name;?> </a></li>
					<?php } } ?>
				</ul>
				<?php } ?>
			</li>
			<?php } } ?>
		</ul>
		
	</div>
</div>