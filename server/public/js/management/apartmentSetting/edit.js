var isSubmited = false;

$(document).ready(function() {
    $("#province").select2( { placeholder: "Chọn Tỉnh / Thành phố" } );
    $("#district").select2( { placeholder: "Chọn Quận / Huyện" } );
    $("#ward").select2( { placeholder: "Chọn Phường / Xã" } );
});

/**
 * Load thông tin Quận / Huyện combobox với Thành phố / Tỉnh tương ứng
 */
function loadDistrictCombobox() {
    $.ajax({
        url: $("#MAS-003").val() + "?province_id=" + $('#province').val(),
        type: 'GET',
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function(data){
            list = data;
            
            //Remove tất cả các option nếu có
            $('#district').find('option').remove();
            $('#district').val('-1').change();
            $('#district').val('');

            //Add lai các option nhận từ server
            $('#district').append($('<option>'));
            $.each(list, function (i, item){
                $('#district').append($('<option>', {
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
 * Load thông tin Phường / Xã combobox với Quận / Huyện tương ứng
 */
function loadWardCombobox() {
    $.ajax({
        url: $("#MAS-004").val() + "?district_id=" + $('#district').val(),
        type: 'GET',
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function(data){
            list = data;
            
            //Remove tất cả các option nếu có
            $('#ward').find('option').remove();
            $('#ward').val('-1').change();
            $('#ward').val('');

            //Add lai các option nhận từ server
            $('#ward').append($('<option>'));
            $.each(list, function (i, item){
                $('#ward').append($('<option>', {
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
                window.location = $("#current_route").val();
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