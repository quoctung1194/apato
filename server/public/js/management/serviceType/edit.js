var isSubmited = false;

$(document).ready(function() {
	var img = $('#fileInput').change(function(event) {
		if (event.target.files[0] === undefined) {
			$("img").fadeIn("fast").attr('src', '');
		} else {
			var tmpPath = URL.createObjectURL(event.target.files[0]);
			$("img").fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
			$("img").attr('style', 'object-fit: contain;');
		}
	});
});

function submitForm() {
	//Kiểm tra có đang chờ server phản hồi hay không
	if(isSubmited) {
		return;
	}
	
	//Trim tất cả các input là text
	var allInputs = $(":input"); 
	allInputs.each(function() {
		if($(this).attr('type') != 'file') {
			$(this).val($.trim($(this).val()));
		}
	});
	
	//Reset nội dung các label hiện lỗi
	var validates = document.getElementsByName('validate');
	validates.forEach(function(label){
		label.innerHTML = '';
	});
	isSubmited = true;
	
	//Submit lên server
	var formData = new FormData($("#editForm")[0]);
	$.ajax({
		url: $("#editForm").attr('action'),
		type: 'POST',
		contentType: false,
		cache: false,
		data: formData,
		processData: false,
		dataType: "json",
		success: function(data){
			
			if (data.success == false) {
				for (error in data.message) {
					for (var i = 0; i < validates.length; i++) {
						var labelValue = validates[i].getAttribute('value');
						if (labelValue == error + '_error') {
							validates[i].innerHTML = data.message[error][0];
							break;
						}
					}
				}
			} else {
				window.location=$("#current_route").val() + "/" + data.id ;
			}
		},
		error: function(data){
			alert(data.statusText);
			console.log(data);
		},
		complete: function(data) {
			isSubmited = false;
		}
	});
}
