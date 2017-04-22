var isSubmited = false;

$(document).ready(function() {
	var table = $('#services').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": $('#MSE-002').val(),
		"serverMethod": "GET",
		"searching": false,
		"order": [[ 2, "asc" ]],
		"columns": [
		            { "data": "stt", "targets"  : 'no-sort', "orderable": false},
		            { "data": "name", render: $.fn.dataTable.render.text() },
		            { "data": "providerName", render: $.fn.dataTable.render.text() },
		            { "data": "typeName", render: $.fn.dataTable.render.text() },
		            { "data": getItem, "targets"  : 'no-sort', "orderable": false,
		               render: function (data) {
		            	var icon = '';
		            	//Edit Icon
		            	icon += '<a href="' + $('#MSE-003').val() + '/' + data.id + '">';
		            	icon += '	<i class="fa fa-pencil" aria-hidden="true" title="Edit"></i>';
		            	icon += '</a>';
		            	icon += '&nbsp;&nbsp;';
		            	
		            	//Remove Icon
		            	icon += '<a style="cursor:pointer" onclick="remove(' + data.id + ', this)">';
		            	icon += '	<i class="fa fa-trash" aria-hidden="true" title="Remove"></i>';
		            	icon += '</a>';
		            	icon += '&nbsp;&nbsp;';
		            	
		            	//Lock Icon
		            	icon += '<a style="cursor:pointer" onclick="lock(' + data.id + ', this)">';
		            	if(data.locked == 0) {
			            	icon += '<i class="fa fa-unlock" aria-hidden="true" title="Unlocked"></i>';
		            	} else {
			            	icon += '<i class="fa fa-lock" aria-hidden="true" title="Locked"></i>';
		            	}
		            	icon += '</a>';
		            	icon += '&nbsp;&nbsp;';
		            	return icon;
		               }
		            },
		        ]
	});
});

function getItem(data) {
	return data;
}

function lock(id, button) {
	if(isSubmited){
		return;
	}
	
	var accepted = confirm("Bạn có chắc không ?");
	if(!accepted) {
		return;
	}
	
	var formData = new FormData();
	formData.append('_token', $('#csrf-token').val());
	formData.append('id', id);
	
	isSubmited = true;
	
	$.ajax({
		url: $('#MSE-005').val(),
		type: 'POST',
		contentType: false,
		cache: false,
		data: formData,
		processData: false,
		success: function(data) {
			if(data.success) {
				icon = button.childNodes[0]
				if(data.locked) {
					icon.setAttribute('class', 'fa fa-lock');
					icon.setAttribute('title', 'Locked');
				} else {
					icon.setAttribute('class', 'fa fa-unlock');
					icon.setAttribute('title', 'Unlocked');
				}
			}
		},
		error: function(data) {
			alert(data.statusText);
		},
		complete: function( data ) {
			isSubmited = false;
		}
	});
}

function remove(id, button) {
	if(isSubmited){
		return;
	}
	
	var accepted = confirm("Bạn có chắc muốn xóa không ?");
	debugger;
	if(!accepted) {
		return;
	}
	
	var formData = new FormData();
	formData.append('_token', $('#csrf-token').val());
	formData.append('id', id);
	
	isSubmited = true;
	
	$.ajax({
		url: $('#MSE-004').val(),
		type: 'POST',
		contentType: false,
		cache: false,
		data: formData,
		processData: false,
		success: function(data) {
			if(data.success) {
				//Lay dòng data hiện hành
				var currentRow = button.parentNode.parentNode;
				//Xóa dòng data hiện hành
				currentRow.parentNode.removeChild(currentRow);
			}
		},
		error: function(data) {
			alert(data.statusText);
		},
		complete: function( data ) {
			isSubmited = false;
		}
	});
}