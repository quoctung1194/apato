var isSubmited = false;

$(document).ready(function() {
    $('#birthday').datetimepicker({
        format: 'Y-m-d',
        timepicker: false,
    });
    $("#gender").select2( { placeholder: "Chọn cách xưng hô" } );
    $("#block").select2( { placeholder: "Chọn block" } );
    $("#floor").select2( { placeholder: "Chọn tầng" } );
    $("#room").select2( { placeholder: "Chọn phòng" } );
});

/**
 * Load thông tin Tầng combobox với Block tương ứng
 */
function loadFloorCombobox() {
    $.ajax({
        url: $("#MAR-007").val() + "?apartmentId=" + $('#apartment_id').val() + "&blockId=" + $('#block').val(),
        type: 'GET',
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function(data){
            list = data;
            
            //Remove tất cả các option nếu có
            $('#floor').find('option').remove();
            $('#floor').val('-1').change();
            $('#floor').val('');

            //Add lai các option nhận từ server
            $('#floor').append($('<option>'));
            $.each(list, function (i, item){
                $('#floor').append($('<option>', {
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
 * Load thông tin Phòng combobox với Tầng tương ứng
 */
function loadRoomCombobox() {
    $.ajax({
        url: $("#MAR-008").val() + "?apartmentId=" + $('#apartment_id').val() + "&blockId=" + $('#block').val() + "&floorId=" + $('#floor').val(),
        type: 'GET',
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function(data){
            list = data;
            
            //Remove tất cả các option nếu có
            $('#room').find('option').remove();
            $('#room').val('-1').change();
            $('#room').val('');

            //Add lai các option nhận từ server
            $('#room').append($('<option>'));
            $.each(list, function (i, item){
                $('#room').append($('<option>', {
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
 * Submit form dịch vụ
 */
function submitForm() {
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