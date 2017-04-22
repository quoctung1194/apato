var isSubmited = false;
var table = null;

$(document).ready(function() {
	$('#start_at, #end_at').datetimepicker({
		format: 'Y-m-d',
		timepicker: false,
	});
	
	var img = $('#fileInput').change(function(event) {
		if (event.target.files[0] === undefined) {
			$("img").fadeIn("fast").attr('src', '');
		} else {
			var tmpPath = URL.createObjectURL(event.target.files[0]);
			$("img").fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
		}
	});
});

$(document).ready(function() {
	$("#service_type").select2( { placeholder: "Chọn loại dịch vụ" } );
	$("#provider").select2( { placeholder: "Chọn nhà cung cấp" } );
	table = $('#apartments').dataTable();
	
	//Load dữ liệu thể hiện tham số click nếu có
	if($('#id').val() != '') {
		var clickTable = $('#clicks').DataTable({
			"serverSide": true,
			"ajax": $('#MSE-006').val(),
			"serverMethod": "GET",
			"searching": false,
			"order": [[ 7, "desc" ]],
			"columns": [
			            { "data": "stt", "targets"  : 'no-sort', "orderable": false },
			            { "data": "first_name" },
			            { "data": "last_name" },
			            { "data": "apartment_name" },
			            { "data": "block_name" },
			            { "data": "floor_name" },
			            { "data": "room_name" },
			            { "data": "clicks" },
//			            { "data": getClickItem, "targets"  : 'no-sort', "orderable": false,
//			              render: function (data) {
//			            	if(data.note != null) {
//			            		return 'Có';
//			            	} else {
//			            		return '';
//			            	}
//			              }
//			            },
//			            { "data": "note",  "orderable": false},
			        ]
		});
	}
});

/**
 * Quy định data trả về của 1 dòng dữ liệu datatable
 * data : giá trị item của từng dòng
 * @return data
 */
function getClickItem(data) {
	return data;
}

/**
 * Load thông tin những nhà cung lên combobox với dịch vụ tương ứng
 */
function loadProviderCombobox() {
	$.ajax({
		url: $("#MPST-001").val() + "/" + $('#service_type').val(),
		type: 'GET',
		contentType: false,
		cache: false,
		processData: false,
		dataType: "json",
		success: function(data){
			list = data.list;
			
			//Enable combobox probider
			$('#provider').prop( 'disabled', false );
			//Remove tất cả các option nếu có
			$('#provider').find('option').remove();
			$('#provider').val('-1').change();
			$('#provider').val('');
			//Add lai các option nhận từ server
			$('#provider').append($('<option>'));
			$.each(list, function (i, item){
				$('#provider').append($('<option>', {
					value: list[i].id,
					text: list[i].name
				}));
			});
		},
		error: function(data){
			alert(data.statusText);
		},
		complete: function(data) {
			isSubmited = false;
		}
	});
}

/**
 * Lấy tất cả chưng cư được chọn
 */
function getSelectedApartments() {
	//Lấy ra mảng các checkbox được check
	var checkboxs = $(table.fnGetNodes()).find('input:checked');
	
	//Div chứa các tags
	var holder = $('#apartmentTags');
	
	//Xóa tất cả các tags hiện hành
	holder.html('');
	
	for(var i = 0; i < checkboxs.length; i++) {
		//Vẽ tags lên giao diện
		var tag = $('<div class="tag btn">' + checkboxs[i].name + '</div>');
		holder.append(tag);
	}
	
	//Đóng popup
	$('#apartmentModel').modal('hide');
}

/**
 * Convert các checkbox vào hidden field
 */
function convertCheckboxs() {
	//Lấy ra mảng các checkbox được check
	var checkboxs = $(table.fnGetNodes()).find('input:checked');
	//Biến chứa các id của các checkbox được check
	var ids = '';
	
	for(var i = 0; i < checkboxs.length; i++) {
		//Lấy giá trị các id của chung cư
		ids += checkboxs[i].value + ',';
	}
	
	//Gán giá trị vào hidden field và loại bỏ dấu ' tại cuối chuỗi
	if(ids.length > 0) {
		$('#apartmentIds').val(ids.slice(0, -1));
	}
}

/**
 * Submit form dịch vụ
 */
function submitForm() {
	if(isSubmited) {
		return;
	}
	
	//Convert các checkbox của apartment được chọn vào hidden field
	convertCheckboxs();
	
	//Trim tất cả các input là text
	var allInputs = $(":input"); 
	allInputs.each(function() {
		if($(this).attr('type') != 'file') {
			$(this).val($.trim($(this).val()));
		}
	});
	
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
				var messageError = '';
				
				for (error in data.message) {
					for (var i = 0; i < validates.length; i++) {
						var labelValue = validates[i].getAttribute('value');
						if (labelValue == error + '_error') {
							validates[i].innerHTML = data.message[error][0];
							messageError += validates[i].innerHTML + '\n';
							break;
						}
					}
				}
				
				alert(messageError);
			} else {
				window.location = $("#current_route").val() + "/" + data.id ;
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

