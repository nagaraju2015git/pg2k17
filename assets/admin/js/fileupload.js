 function Upload(id,w,h) {
	//Get reference of FileUpload.
	var fileUpload = $("#"+id)[0];
	
	$("#"+id).parent().find(".preview").remove();
	$("#"+id).parent().find(".progress").remove();
	$("#"+id).parent().find(".text-danger").remove();
	
	//Check whether the file is valid Image.
	var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
	if (regex.test(fileUpload.value.toLowerCase())) {
		//Check whether HTML5 is supported.
		if (typeof (fileUpload.files) != "undefined") {
			//Initiate the FileReader object.
			var reader = new FileReader();
			//Read the contents of Image File.
			reader.readAsDataURL(fileUpload.files[0]);
			reader.onload = function (e) {
				//Initiate the JavaScript Image object.
				var image = new Image();
				//Set the Base64 string return from FileReader as source.
				image.src = e.target.result;
				image.onload = function () {
					//Determine the Height and Width.
					var height = this.height;
					var width = this.width;
					if (height < h || width < w) {
						$("#"+id).val('');
						$("#"+id).parent().append('<span class="text-danger">Image width and height should be greater than '+w+'X'+h+'</span>');
						return false;
					}
					/* var html ='<div class="progress">'+
									'<div class="bar"></div >'+
									'<div class="percent">0%</div >'+
								'</div>';
					$("#"+id).parent().append(html);
					var ui = 0;
					var uic = setInterval(function(){
						$("#"+id).parent().find('.bar').css('width',ui+'%');
						$("#"+id).parent().find('.percent').html(ui+'%');
						ui++;
						if(ui == 101)clearInterval(uic)
					},10); */
					$("#"+id).parent().append('<img class="preview" src='+this.src+'>');
					return true;
				};
			}
		} else {
			$("#"+id).val('');
			$("#"+id).parent().append('<span class="text-danger">This browser does not support HTML5.</span>');
			return false;
		}
	} else {
		$("#"+id).val('');
		$("#"+id).parent().append('<span class="text-danger">Please select a valid Image file.</span>');
		return false;
	}
}