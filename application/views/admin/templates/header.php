<?php $pageTitle = isset($pageTitle)?$pageTitle:''; ?>
<?php $page = isset($page)?$page:''; ?>
<nav class="navbar navbar-default navbar-fixed-top be-top-header">
	<div class="container-fluid">
	  <div class="navbar-header"><a href="<?php echo base_url('admin'); ?>" class="navbar-brand"></a>
	  </div>
	  <div class="be-right-navbar">
		<ul class="nav navbar-nav navbar-right be-user-nav">
		  <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><img src="<?php echo base_url(); ?>/assets/admin/img/avatar.png" alt="Avatar"><span class="user-name">Admin</span></a>
			<ul role="menu" class="dropdown-menu">
			  <li>
				<div class="user-info">
				  <div class="user-name">Admin</div>
				</div>
			  </li>
			  <li><a href="<?php echo base_url('home/logout'); ?>"><span class="icon mdi mdi-power"></span> Logout</a></li>
			</ul>
		  </li>
		</ul>
		<div class="page-title hide"><span><?php echo $pageTitle; ?></span></div>
	  
	  </div>
	</div>
</nav>
<div class="be-left-sidebar">
	<div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Dashboard</a>
	  <div class="left-sidebar-spacer">
		<div class="left-sidebar-scroll">
		  <div class="left-sidebar-content">
			<ul class="sidebar-elements">
			  <li <?php if($page == 'DASHBOARD')echo 'class="active"';?>><a href="<?php echo base_url('admin'); ?>"><i class="icon mdi mdi-home"></i><span>Dashboard</span></a>
			  </li>
			  <li class="parent <?php if($page == 'CATALOG')echo ' active';?>"><a href="#"><i class="icon mdi mdi-view-list-alt"></i><span>Catalog</span></a>
				<ul class="sub-menu">
				  <li><a href="<?php echo base_url('admin/categories'); ?>">Categories</a></li>
				  <li><a href="<?php echo base_url('admin/products'); ?>">Products</a></li>
				  <li><a href="<?php echo base_url('admin/user_products'); ?>">User Products</a></li>
				</ul>
			  </li>
			  <li <?php if($page == 'API')echo 'class="active"';?>><a href="<?php echo base_url('admin/api'); ?>"><i class="icon mdi mdi-globe"></i><span>API</span></a>
			  </li>
			  <li <?php if($page == 'FILTER')echo 'class="active"';?>><a href="<?php echo base_url('admin/filters'); ?>"><i class="icon mdi mdi-filter-list"></i><span>Filters</span></a>
			  </li>
			  <li <?php if($page == 'SLIDE')echo 'class="active"';?>><a href="<?php echo base_url('admin/slides'); ?>"><i class="icon mdi mdi-slideshare"></i><span>Slides</span></a>
			  </li>
			  <li <?php if($page == 'NAVIGATION')echo 'class="active"';?>><a href="<?php echo base_url('admin/navigations'); ?>"><i class="icon mdi mdi-8tracks"></i><span>Navigation</span></a>
			  </li>
			  <li <?php if($page == 'USER')echo 'class="active"';?>><a href="<?php echo base_url('admin/users'); ?>"><i class="icon mdi mdi-accounts-alt"></i><span>Users</span></a>
			  </li>
			  <li <?php if($page == 'CMS')echo 'class="active"';?>><a href="<?php echo base_url('admin/pages'); ?>"><i class="icon mdi mdi-window-restore"></i><span>CMS</span></a>
			  </li>
			  <li <?php if($page == 'HOME')echo 'class="active"';?>><a href="<?php echo base_url('admin/sections'); ?>"><i class="icon mdi mdi-window-restore"></i><span>Home Page Sections</span></a>
			  </li>
			  <li <?php if($page == 'POST')echo 'class="active"';?>><a href="<?php echo base_url('admin/posts'); ?>"><i class="icon mdi mdi-window-restore"></i><span>Recent Posts</span></a>
			  </li>
			  <li <?php if($page == 'REVIEW')echo 'class="active"';?>><a href="<?php echo base_url('admin/reviews'); ?>"><i class="icon mdi mdi-window-restore"></i><span>Reviews</span></a>
			  </li>
			  <li <?php if($page == 'QUESTIONS')echo 'class="active"';?>><a href="<?php echo base_url('admin/questionaire'); ?>"><i class="icon mdi mdi-window-restore"></i><span>Questionaire</span></a>
			  <li <?php if($page == 'SHOPPER_REQUESTS')echo 'class="active"';?>><a href="<?php echo base_url('admin/shopper_requests'); ?>"><i class="icon mdi mdi-window-restore"></i><span>Shopper Requests</span></a>
			  </li>
			  <li <?php if($page == 'USER_REQUESTS')echo 'class="active"';?>><a href="<?php echo base_url('admin/user_requests'); ?>"><i class="icon mdi mdi-window-restore"></i><span>User Requests</span></a>
			  </li>
			  <li <?php if($page == 'SA')echo 'class="active"';?>><a href="<?php echo base_url('admin/shopping_assistant_page'); ?>"><i class="icon mdi mdi-window-restore"></i><span>Shopping Assistant Page</span></a>
			  </li>
			  <li <?php if($page == 'SP')echo 'class="active"';?>><a href="<?php echo base_url('admin/shopper_page'); ?>"><i class="icon mdi mdi-window-restore"></i><span>Shopper Page</span></a>
			  </li>
			</ul>
		  </div>
		</div>
	  </div>
	</div>
</div>
