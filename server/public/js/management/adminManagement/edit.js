var isSubmited = false;

function submitForm() {
	if(isSubmited) {
		return;
	}
	var validates = document.getElementsByName('validate');
	validates.forEach(function(label){
		label.innerHTML = '';
	});
	isSubmited = true;
	
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
				window.location=$("#current_route").val();
			}
		},
		error: function(data){
			alert(data.statusText);
		},
		complete: function(data) {
			isSubmited = false;
		}
	});
}