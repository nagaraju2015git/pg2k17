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
							<?php if($this->session->userdata('logged_in')){ ?>
							<a class="btn btn-lg" href="#" data-toggle="modal" data-target="#modal-questions">
								<i class="fa fa-arrow-right"></i> <span><?php if(isset($page->btext))echo $page->btext; ?></span>
							</a>
							<?php }else{ ?>
							<a class="btn btn-lg" href="<?php echo base_url('home/signin');?>">
								<i class="fa fa-sign-in"></i> <span><?php if(isset($page->btext))echo $page->btext; ?></span></span>
							</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>                        
		</section>
		
		<section class="padding-30">
			<div class="container hiw">
				<h2 class="title"><?php if(isset($page->pheading))echo $page->pheading; ?></span></h2>
				<div class="row">
					
					<div class="col-md-4">
						<div class="bx">
							<div class="step">01</div>
							<p><?php if(isset($page->step1))echo $page->step1; ?></span></p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="bx">
							<div class="step">02</div>
							<!--div class="head">Fill out a style People</div-->
							<p><?php if(isset($page->step2))echo $page->step2; ?></span></p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="bx">
							<div class="step">03</div>
							<!--div class="head">Fill out a style People</div-->
							<p><?php if(isset($page->step3))echo $page->step3; ?></span></p>
						</div>
					</div>
					
				</div>
			</div>
		</section>
		
		
		<div id="modal-questions" tabindex="-1" role="dialog" class="modal fade saq" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div id="questions">
			  <div class="modal-header">
				<div class="hc">Welcome to the World of Painless gifting. To make the shopping experience seemless, please answer a few questions.</div>            
			  </div>
			  <div class="modal-body">
				<?php $i=1; ?>
				<div class="sa">
					<div class="qt"><?php echo $i++.'. Request title'; ?>? <span class="text-danger">*</span></div>
					<input type="text" req="true" name="title" id="rtitle" class="form-control" placeholder="Write here...">
				</div>
				<?php foreach($data['questions'] as $q){ ?>
					<div class="sa">
						<div class="qt"><?php echo $i.'. '.$q->question; ?>? <?php if($q->mandatory == 1)echo '<span class="text-danger">*</span>'; ?></div>
						
						<?php if($q->qtype == 'Multiple Choice'){ ?>
							<select <?php if($q->mandatory == 1)echo 'req="true"'; ?> class="form-control select2 answers" name="answers" data-qid="<?php echo $q->id; ?>" data-placeholder="Select Options" style="width:100%;" multiple>
								<option value=""></option>
								<?php foreach($data['options'] as $o){ if($o->qid == $q->id){ ?>
									<option value="<?php echo $o->id; ?>"><?php echo $o->name; ?></option>
								<?php } } ?>
							</select>
						<?php }else if($q->qtype == 'Single Choice'){ ?>
							<select <?php if($q->mandatory == 1)echo 'req="true"'; ?> class="form-control select2 answers" name="answers" data-qid="<?php echo $q->id; ?>" data-placeholder="Select Options" style="width:100%;">
								<option value=""></option>
								<?php foreach($data['options'] as $o){ if($o->qid == $q->id){ ?>
									<option value="<?php echo $o->id; ?>"><?php echo $o->name; ?></option>
								<?php } } ?>
							</select>
						<?php }else if($q->qtype == 'Date'){ ?>
							<input type="date" class="form-control answers" <?php if($q->mandatory == 1)echo 'req="true"'; ?> name="answers" data-qid="<?php echo $q->id; ?>">
						<?php }else if($q->qtype == 'Text'){ ?>
							<input type="text" class="form-control answers" <?php if($q->mandatory == 1)echo 'req="true"'; ?> name="answers" data-qid="<?php echo $q->id; ?>" placeholder="Write here...">
						<?php } ?>
						
					</div>
				<?php $i++; } ?>
			  </div>
		  
			  <div class="mt-10 text-center">
				<hr>
				<button type="button" class="btn btn-space btn-primary" id="next_btn"><i class="fa fa-arrow-right"></i> Next</button>
				<button type="button" data-dismiss="modal" class="btn btn-space btn-default"><i class="fa fa-ban"></i> Cancel</button>
			  </div>
		  </div>
		  <div id="payment" class="hide">
			  <div class="modal-header">
				<div class="hc">Payment</div>            
			  </div>
			  <div class="modal-body">
				<!-- CREDIT CARD FORM STARTS HERE -->
				<div class="panel panel-default credit-card-box">
					<div class="panel-heading display-table" >
					<div class="row display-tr" >
					<h3 class="panel-title display-td" >Payment Details</h3>
					<div class="display-td" >                            
					<img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
					</div>
					</div>                    
					</div>
					<div class="panel-body">
					<form role="form" id="payment-form">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="cardNumber">CARD NUMBER</label>
								<div class="input-group">
									<input type="tel" class="form-control" name="cardNumber" placeholder="Valid Card Number" autocomplete="cc-number" required autofocus />
									<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
								</div>
							</div>                            
						</div>
					</div>
					<div class="row">
						<div class="col-xs-7 col-md-7">
						<div class="form-group">
						<label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
						<input 
						type="tel" 
						class="form-control" 
						name="cardExpiry"
						placeholder="MM / YY"
						autocomplete="cc-exp"
						required 
						/>
						</div>
						</div>
						<div class="col-xs-5 col-md-5 pull-right">
							<div class="form-group">
								<label for="cardCVC">CV CODE</label>
								<input type="tel" class="form-control" name="cardCVC" placeholder="CVC" autocomplete="cc-csc"
								required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="couponCode">COUPON CODE</label>
								<input type="text" class="form-control" name="couponCode" />
							</div>
						</div>                        
					</div>
					<div class="row">
						<div class="col-xs-12">
							<button class="btn btn-success btn-lg btn-block" type="button" id="proceed_btn"><i class="fa fa-arrow-right"></i> Proceed Free</button>			
						</div>
					</div>
					<div class="row" style="display:none;">
						<div class="col-xs-12">
							<p class="payment-errors"></p>
						</div>
					</div>
					</form>
					</div>
				</div>            
				<!-- CREDIT CARD FORM ENDS HERE -->
				<div class="text-center"><button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button></div>
			  </div>
		  
		</div>
		  <br>
        </div>
      </div>
    </div>

		
		
		<!-- FOOTER -->
		<?php echo $footer; ?>
		<!-- FOOTER -->
	<script>
		$("#next_btn").on("click",function(){
		var error = 0;var answers = [];
		$(".text-danger").remove();
		$("#modal-questions textarea,#modal-questions select").each(function(){
			var obj = $(this);
			if(obj.val() == "" && obj.attr('req') == "true"){
				error++;
				obj.parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		if($("#rtitle").val().trim() == ""){
			error++;
			$("#rtitle").parent().append('<div class="text-danger">This field is required</div>');
		}
		if(error == 0){
			$("#questions").addClass("hide");
			$("#payment").removeClass("hide");
		}
	});
	$("#proceed_btn").on("click",function(){
		var error = 0;var answers = [];
		$(".text-danger").remove();
		$("#modal-questions .answers").each(function(){
			var obj = $(this);
			if(obj.val() == "" || obj.val() == null){
				error++;
				obj.parent().append('<div class="text-danger">This field is required</div>');
			}else{
				var answer = [];
				answer[0] = obj.data('qid');
				answer[1] = obj.val();
				answers.push(answer);
			}
		});
		if(error == 0){
			$("#proceed_btn").attr('disabled',true);
			$("#proceed_btn").html('<i class="fa fa-spinner fa-spin"></i>');
			$.ajax({
				url:'<?php echo base_url('home/ins_upd_user_answers');?>',
				type:'POST',
				data:{'answers':answers,'title':$("#rtitle").val()},
				dataType:'JSON'
			}).done(function(data){
				if(data.status == 1){
					$("#modal-questions .modal-content").html('<div class="text-center" style="padding:20px;"><p class="text-success">Your request has been submitted successsfully. Our shopping assistent will contact you soon. </p> <button class="btn" type="button" data-dismiss="modal" >Close</button></div>');
					
					//Sending notification
					socket.emit('server_new_request', { image:data.image, message:data.message});
				}else{
					$("#modal-questions .modal-content").html('<div class="text-center" style="padding:20px;"><p class="text-danger">There were some error while submitting your request. Please try again later or contact admin </p> <button class="btn" type="button" data-dismiss="modal" >Close</button></div>');
				}
				
			});
		}
	});
	
	</script>
    </body>

</html>