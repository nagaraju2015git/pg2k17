<!DOCTYPE html>
<html lang="en">
  
<?php echo $head; ?>
  
  <body>
    <div class="be-wrapper be-fixed-sidebar">
	
      <?php echo $header; ?>
	  
	  <div class="be-content">
        <div class="main-content container-fluid">
			
			<div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Questionnaire Configuration</span></div>
                <div class="panel-body">
                  <form class="form-horizontal" id="question_form">
                    
					<div class="form-group">
                      <label class="col-sm-3"><b>Question <span>*</span></b></label>
                      <div class="col-sm-6">
                        <input req="true" type="text" class="form-control" name="question" value="<?php if(isset($question->question))echo $question->question; ?>">
                      </div>
                    </div>
					<div class="form-group">
                      <div class="col-sm-3 text-right">Mandatory</div>
                      <div class="col-sm-6">
                        <input type="checkbox" name="mandatory" value="1" <?php if(isset($question->mandatory))if($question->mandatory == 1)echo 'checked';?>>
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-3">Question Type <span>*</span></label>
                      <div class="col-sm-6">
                        <select req="true" class="form-control select2" name="qtype" id="qtype" data-placeholder="Select type">
							<option></option>
							<option <?php if(isset($question->qtype))if($question->qtype == 'Text')echo 'selected'; ?>>Text</option>
							<option <?php if(isset($question->qtype))if($question->qtype == 'Date')echo 'selected'; ?>>Date</option>
							<option <?php if(isset($question->qtype))if($question->qtype == 'Multiple Choice')echo 'selected'; ?>>Multiple Choice</option>
							<option <?php if(isset($question->qtype))if($question->qtype == 'Single Choice')echo 'selected'; ?>>Single Choice</option>
						</select>
                      </div>
                    </div>
					<div id="options" class="q-options <?php if(count($options) == 0)echo ' hide';?>">
						<?php foreach($options as $k=>$o){ ?>
						<div class="form-group">
						  <label class="col-sm-3">Option <?php echo ++$k; ?> <span>*</span></label>
						  <div class="col-sm-6">
							<input req="true" type="text" class="form-control" name="options" value="<?php echo $o->name; ?>" data-id="<?php echo $o->id; ?>">
						  </div>
						  <div class="col-md-1">
								<button class="btn btn-sm btn-danger btn-remove">X</button>
						  </div>
						</div>
						<?php } ?>
					</div>
					<div class="form-group <?php if(isset($question->mandatory)){if($question->qtype != 'Multiple Choice' && $question->qtype != 'Single Choice')echo ' hide';}else{echo ' hide';} ?>" id="option_div">
						 <div class="col-md-12 text-center">
							<button class="btn btn-sm" type="button" id="add_option">Add option</button>
						</div>
					</div>
					<div class="form-group">
                      <label class="col-sm-3">Display Order <span>*</span></label>
                      <div class="col-sm-6">
                        <input req="true" type="number" class="form-control" name="sorting_order" value="<?php if(isset($question->sorting_order))echo $question->sorting_order; ?>">
                      </div>
                    </div>
					<hr>
					<div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-lg" type="button" id="submit_btn">Submit</button>
                        <a href="<?php echo base_url('admin/questionaire'); ?>" class="btn btn-default btn-lg">Cancel</a>
                    </div>
				  </form>
                </div>
              </div>
            </div>
          </div>
			
		</div>
      </div>
      
	  
    </div>
	<?php echo $footer; ?>
   
    <script type="text/javascript">
      $(document).ready(function(){
		App.init();
		App.formElements();
		App.textEditors();
      });
	  $(document).on("click",".btn-remove",function(){
		  $(this).parents(".form-group").remove();
		  var i=1;
		  $("#options .form-group").each(function(){
			  $(this).find("label").html('Option '+i+' <span>*</span>');i++;
		  });
		  if($("#options .form-group").length == 0)$("#options").addClass('hide');
	  });
	  $("#qtype").on("change",function(){
		  if($("#qtype").val() == 'Multiple Choice' || $("#qtype").val() == 'Single Choice'){
			 $("#option_div").removeClass("hide");
		  }else{
			$("#option_div").addClass("hide");
			$("#options").html('');			
			$("#options").addClass('hide');			
		  }
	  });
	  $("#add_option").on("click",function(){
		  var i = $("#options .form-group").length+1;
		  var html ='<div class="form-group mb-5">'+
				  '<label class="col-sm-3">Option '+i+' <span>*</span></label>'+
				  '<div class="col-sm-6">'+
					'<input req="true" type="text" class="form-control" data-id="0" name="options" placeholder="Enter option">'+
				  '</div>'+
				  '<div class="col-md-1">'+
					'<button class="btn btn-sm btn-danger btn-remove">X</button>'+
				  '</div>'+
				'</div>';
			$("#options").append(html);
			if($("#options .form-group").length != 0)$("#options").removeClass('hide');
	  });
	  $("#submit_btn").on("click",function(){
		var error=0;$(".text-danger").remove();
		$("#question_form input").each(function(){
			if($(this).attr("req") == "true" && $(this).val().trim() == ""){
				error++;
				$(this).parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		var options = [];
		$("input[name=options]").each(function(){
			var option = [];
			option[0] = $(this).data('id');
			option[1] = $(this).val();
			options.push(option);
		});
		
		if(options.length < 2 && ($("#qtype").val() == 'Multiple Choice' || $("#qtype").val() == 'Single Choice')){
			error++;
			$.notify({ message: 'Please add atleast two options to the question' },{type: 'danger'});
		}
		
		if(error == 0){
			$("#submit_btn").attr("disabled",true);
			
			var formData = new FormData($("#question_form")[0]);
			<?php if(isset($question->id)){ ?>
			formData.append('type','UPDATE');
			formData.append('id','<?php echo $question->id;?>');
			<?php }else{ ?>
			formData.append('type','INSERT');
			<?php } ?>
			formData.append('options',JSON.stringify(options));
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_questions');?>',
				type:'POST',
				data:formData,
				dataType:'JSON',
				cache: false,
				contentType: false,
				processData: false
			}).success(function(data){
				
				if(data.status){
					$.notify({ message: data.message },{type: 'success'});
					setTimeout(function(){window.location = '<?php echo base_url(); ?>admin/questionaire';},2000);
				}else{
					$.notify({ message: data.message },{type: 'danger'});
				}
			});
		}
	  });
	  
    </script>
	
  </body>

</html>