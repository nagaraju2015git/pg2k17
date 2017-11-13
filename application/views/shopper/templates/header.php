<?php $pageTitle = isset($pageTitle)?$pageTitle:''; ?>
<?php $page = isset($page)?$page:''; ?>

<nav class="navbar navbar-default navbar-fixed-top be-top-header">
	<div class="container-fluid">
	  <div class="navbar-header"><a href="<?php echo base_url('shopper'); ?>" class="navbar-brand"></a></div>
	  <div class="be-right-navbar">
		
		<ul class="nav navbar-nav navbar-right be-icons-nav">
		 <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="icon mdi mdi-notifications"></span><span class="indicator"></span></a>
			<ul class="dropdown-menu be-notifications">
			  <li>
				<div class="list">
				  <div class="be-scroller">
					<div class="content">
					  <ul>
						<?php if(count($data['notifications']) > 0){ ?>
						<?php foreach($data['notifications'] as $n){ ?>
						<li class="notification">
							<a href="#">
								<div class="image"><img src="<?php if(file_exists($n->image))echo base_url($n->image);else echo base_url($this->config->item('default_image_user')); ?>" alt="Avatar"></div>
								<div class="notification-info">
								  <div class="text">
									<?php echo $n->subject; ?>
								  </div>
								  <span class="date"><?php echo date('d M,y h:i A', strtotime($n->created_date)); ?></span>
								</div>
							</a>
						</li>
						<?php } } ?>
					  </ul>
					</div>
				  </div>
				</div>
			  </li>
			</ul>
		  </li>
		  <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><img class="avatar" src="<?php echo base_url(); ?>/assets/admin/img/avatar.png" alt="Avatar"></a>
			<ul class="dropdown-menu be-connections">
			  <li><div class="user-name"><?php echo $this->session->userdata("user_name"); ?></div></li>
			  <li><a href="<?php echo base_url('home/logout'); ?>"><span class="icon mdi mdi-power"></span> Logout</a></li>
			</ul>
		  </li>
		</ul>
	  </div>
	</div>
  </nav>
  <div class="be-left-sidebar">
	<div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Options</a>
	  <div class="left-sidebar-spacer">
		<div class="left-sidebar-scroll">
		  <div class="left-sidebar-content">
			<ul class="sidebar-elements">
			  <li <?php if($page == 'DASHBOARD')echo 'class="active"';?>><a href="<?php echo base_url('shopper'); ?>"><i class="icon mdi mdi-home"></i><span>Dashboard</span></a>
			  </li>
			  <li <?php if($page == 'NEW')echo 'class="active"';?>><a href="<?php echo base_url('shopper/requests'); ?>"><i class="icon mdi mdi-home"></i><span>New Requests</span> <span class="label"><?php echo $data['reports']['new']; ?></span></a>
			  </li>
			  <li <?php if($page == 'ONGOING')echo 'class="active"';?>><a href="<?php echo base_url('shopper/ongoing'); ?>"><i class="icon mdi mdi-home"></i><span>Ongoing Requests</span> <span class="label"><?php echo $data['reports']['ongoing']; ?></span></a>
			  </li>
			  <li <?php if($page == 'COMPLETED')echo 'class="active"';?>><a href="<?php echo base_url('shopper/completed'); ?>"><i class="icon mdi mdi-home"></i><span>Completed Requests</span> <span class="label"><?php echo $data['reports']['completed']; ?></span></a>
			  </li>                
			</ul>
		  </div>
		</div>
	  </div>
   </div>
  </div>
      
