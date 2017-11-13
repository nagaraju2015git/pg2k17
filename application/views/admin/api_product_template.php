 <?php if(isset($products['products'])){ ?>
 <div class="col-sm-12">
  <div class="panel panel-default panel-table">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">Products List</div>
		</div>
	</div>
	<div class="panel-body">
	  <table id="table1" class="table table-striped table-hover table-fw-widget api_products">
		<thead>
		  <tr>
			<th width="70px" class="text-center">Select</th>
			<th>Name</th>
			<th width="70px">Price</th>
			<th width="170px">Category</th>
			<th>Navigation</th>
			<th>Min Age</th>
			<th>Max Age</th>
		  </tr>
		</thead>
		<tbody>
			
			<?php foreach($products['products'] as $p){ ?>
			<tr>
				<td class="text-center"><input type="checkbox" class="select_product" data-id="<?php echo $p->id; ?>" value='<?php echo json_encode($p); ?>'></td>
				<td><img src="<?php echo $p->image; ?>"><div class="name"><?php echo $p->name; ?></div></td>
				<td><?php echo $p->price; ?></td>
				<td>
					<select id="category_<?php echo $p->id; ?>" class="select2 sm" disabled>
						<option value="">Select Category</option>
						<?php foreach($categories as $c){ ?>
						<option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
						<?php } ?>
					</select>
				</td>
				<td>
					<select id="navigation_<?php echo $p->id; ?>" data-placeholder="Select Navigation" class="select2 sm" multiple disabled style="width:160px;height: 30px;" >
						<?php foreach($navigations as $n){ if($n->parent_id == 0){ ?>
						<optgroup label="<?php echo $n->name; ?>">
							<?php foreach($navigations as $sn){ if($n->id == $sn->parent_id){ ?>
							<option value="<?php echo $sn->id; ?>"><?php echo $sn->name; ?></option>
							<?php } } ?>
						</optgroup>
						<?php } } ?>
					</select>
				</td>
				<td><input type="number" placeholder="Min Age" value="5" id="min_age_<?php echo $p->id; ?>" disabled></td>
				<td><input type="number" placeholder="Max Age" value="60" id="max_age_<?php echo $p->id; ?>" disabled></td>
			</tr>	
			<?php } ?>
			
		</tbody>
	  </table>
	  <br>
	   <div class="col-sm-12 text-center">
			<button class="btn btn-primary btn-lg" type="button" id="submit_btn">Add to database</button>
			<br><br>
	   </div>
	</div>
  </div>
</div>
<?php }else{
echo $products['message'];
} ?>
			