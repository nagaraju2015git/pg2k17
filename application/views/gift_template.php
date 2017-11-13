<div class="modal-dialog gift_modal">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-body">
			
			<?php if($product){ ?>
			<div class="row">
			   <div class="col-sm-6">
					<div class="product" style="width:100%;">
						<a href="<?php echo $product->product_link; ?>" target="_blank">
							<div class="img">
								<img src="<?php echo $product->image; ?>">
							</div>
							<div class="content">
								<div class="title"><?php echo $product->name; ?></div>
								<div class="price"><?php echo $this->config->item('currency'); ?><?php echo $product->price; ?></div>
							</div>
						</a>
					</div>
			   </div>
			   <div class="col-sm-6">
				
				<h3 class="title">Pick a Profile <button class="pclose pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button></h3>
				<ul class="cp">
					<?php foreach($profiles as $p){ ?>
					<li <?php if($p->selected > 0)echo 'class="active"'; ?> data-id="<?php echo $p->id; ?>" data-pid="<?php echo $product->id; ?>"> <?php echo $p->name; ?> <i class="fa fa-times"></i></li>
					<?php } ?>
				</ul>
			   </div>
			</div>
			<?php }else{ ?>
				<h4>Invalid product configuration.</h4>
			<?php } ?>
			
		</div>
	</div>
</div>