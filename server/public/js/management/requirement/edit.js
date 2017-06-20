var isSubmited = false;

$(document).ready(function() {
    $('#created_at').datetimepicker({
        format: 'Y-m-d',
        timepicker: false
    });

    $("#type").select2( { placeholder: "Chọn loại" } );
    $("#tag").select2( { placeholder: "Chọn tag" } );
    $("#is_repeat_problem").select2( { placeholder: "Sự cố lặp lại" } );
});

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