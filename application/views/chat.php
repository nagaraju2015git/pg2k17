<script type="text/javascript">
		  
	var sendToUserID = '<?php echo $sendToUserID; ?>',sendToImage = '<?php echo $sendToImage; ?>',sendToName = '<?php echo $sendToName; ?>';
	
	$(document).ready(function(){		
		
		socket.on('connected', function (data) {				
			//Online Status
			if(data.indexOf(sendToUserID) != -1){
				$('#online_status').addClass('online');
				$('#online_status').html('Online');
			}
			else{
				$('#online_status').removeClass('online');
				$('#online_status').html('Offline');
			}			
		});
		socket.on('read_message', function (data) {
			if(data.sendTo == myUserID && data.userID == sendToUserID){
				$(".message span.read_status").html('<i class="fa fa-check green"></i><i class="fa fa-check green" style="margin-left:-13px;"></i>');
			}
		});
		socket.on('new_message', function (data) {
			if(data.userID == sendToUserID){
				var html = message_template(data.userID,data.message,currentTime(),0);
				$("#messages").append(html);
				$("#messages").animate({ scrollTop: $(document).height()*30 }, "slow");
				read_message(myUserID,sendToUserID);
			}
		});
		//Refreshing Chat
		refresh();	
	});

	$('#message_input').keypress(function (e) {
	  if (e.which == 13) {
		$("#send").trigger('click');
		return false; 
	  }
	});

	$("#send").on("click",function(){
		$("#send").attr('disabled',true);
		var val = $("#message_input").val();
		if(val != '' && val != ' '){
			$.ajax({
				url:'<?php echo base_url('home/ins_upd_chat');?>',
				type:'POST',
				data:{'userID':myUserID,'sendTo':sendToUserID,'message':val,'type':'INSERT'},
				dataType:'JSON'
			}).success(function(data){
				if(data.status){
					socket.emit('new_message', {message:val,sendTo:sendToUserID,userID:myUserID,sendToName:sendToName});
					$("#messages").append(message_template(myUserID,val,currentTime(),0));
					$("#messages").animate({ scrollTop: $(document).height()*30 }, "slow");
					$("#message_input").val('');
					$("#send").removeAttr('disabled');
					if(!$('#online_status').hasClass('online')){
						$.ajax({
							url:'<?php echo base_url('home/send_chat_push');?>',
							type:'POST',
							data:{'userID':myUserID,'sendTo':sendToUserID,'message':val,'type':'INSERT'}
						})
					}
					
				}
			});			
			
		}else{
			$("#message_input").val('');
		}
	});

	function message_template(user_id,message,time,read){
		var left_right = 'left',image=sendToImage;
		if(user_id == myUserID){
			left_right = 'right';
			image = myImage;
		}
		var html = '<li class="message '+left_right+' appeared">'+
					'<div class="avatar"><img src="'+image+'"></div>'+
					'<div class="text_wrapper">'+
						'<div class="text">'+message+'</div>'+
					'</div>';
				
					html+='<div class="stats">'+time+' ';
				if(user_id == myUserID){
					html+='<span class="read_status">';
					if(read == 1){
						html+='<i class="fa fa-check green"></i><i class="fa fa-check green" style="margin-left:-13px;"></i>';
					}else{
						html+='<i class="fa fa-check"></i>';
					}
					html+='</span>';
				}
				html+='</div>'+
				'</li>';
		return html;
	}

	function currentTime() {
		var date = new Date();
		var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
		var am_pm = date.getHours() >= 12 ? "PM" : "AM";
		hours = hours < 10 ? "0" + hours : hours;
		var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
		var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
		//time = hours + ":" + minutes + ":" + seconds + " " + am_pm;
		time = hours + ":" + minutes + " " + am_pm;
		return time;
	};

	/* Read Message Start*/
	function read_message(myUserID,sendToUserID){
		$.ajax({
			url:'<?php echo base_url('home/ins_upd_chat');?>',
			type:'POST',
			data:{'userID':myUserID,'sendTo':sendToUserID,'type':'UPDATE_READ'},
			dataType:'JSON'
		}).success(function(data){
			$("#user_list a[data-id="+sendToUserID+"] span.count").remove();
			socket.emit('read_message', {sendTo:sendToUserID,userID:myUserID});
		});
	}
	
	//Refreshing chat
	function refresh(){
		
		$("#messages").html('');
		$("#chat_window").append('<div class="loading_chat"><i class="fa fa-spinner fa-spin fa-pulse fa-3x fa-fw"></i></div>');
		$.ajax({
			url:'<?php echo base_url('home/get_chat');?>',
			type:'POST',
			data:{'userID':myUserID,'sendTo':sendToUserID,'type':'USER_CHAT'},
			dataType:'JSON'
		}).success(function(data){
			$("body .loading_chat").remove();
			if(data){
				$("#chat_window div.name").html(data.user.name);
				$("#chat_window img.pic").attr('src',data.user.image);
				sendToUserID = data.user.userID;
				sendToImage = data.user.image;
				
				for(var i=0;i<data.chat.length;i++){
					$("#messages").append(message_template(data.chat[i]['userID'],data.chat[i]['message'],data.chat[i]['dateTime'],data.chat[i]['readMsg']));
				}
				$("#messages").animate({ scrollTop: $(document).height()*30 }, "slow");
				read_message(myUserID,sendToUserID);
			}
		});
	}
	
</script>