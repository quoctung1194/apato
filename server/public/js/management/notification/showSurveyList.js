var isSubmited = false;

function formatDDMMYYYY(strDate) {
    var date = new Date(strDate);
    var formatDate = (date.getDate() + 1) + "/" + date.getMonth() + "/" + date.getFullYear();
    return formatDate;
}

$(document).ready(function() {
    var table = $('#notificationTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#MM-007').val(),
        "serverMethod": "GET",
        "searching": false,
        "order": [[ 1, "asc" ]],
        "columns": [
                    { "data": "stt", "targets"  : 'no-sort', "orderable": false},
                    { 
                        "data": getItem, 
                        render: function(data) {
                            var title = '';
                            title += '<a href="' + $('#MM-005').val() + '/' + data.id + '">';
                            title +=    data.title;
                            title += '</a>';
                            return title;
                        } 
                    },
                    { 
                        "data": "created_at", 
                        render: function(val) {
                            var created_at = formatDDMMYYYY(val);
                            return created_at;
                        } 
                    },
                    { "data": "adminUsername", render: $.fn.dataTable.render.text() },
                    { 
                        "data": "remindDate",
                        render: function(val) {
                            var remindDate = "";

                            if (!val) {
                                remindDate = "None";
                            } else {
                                remindDate = formatDDMMYYYY(val);
                            }
                            return remindDate;
                        }
                    },
                    { "data": getItem, "targets"  : 'no-sort', "orderable": false,
                       render: function (data) {
                            var icon = '';
                            //Edit Icon
                            icon += '<a href="' + $('#MM-005').val() + '/' + data.id + '">';
                            icon += '   <i class="fa fa-pencil" aria-hidden="true" title="Edit"></i>';
                            icon += '</a>';
                            icon += '&nbsp;&nbsp;';
                            
                            //Remove Icon
                            icon += '<a style="cursor:pointer" onclick="remove(' + data.id + ', this)">';
                            icon += '   <i class="fa fa-trash" aria-hidden="true" title="Remove"></i>';
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
                    }
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
    
    var accepted = confirm("Bạn có chắc muốn khóa không ?");
    if(!accepted) {
        return;
    }
    debugger;
    var formData = new FormData();
    formData.append('_token', $('#csrf-token').val());
    formData.append('id', id);
    
    isSubmited = true;
    
    $.ajax({
        url: $('#MM-009').val(),
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
            alert('Lỗi! Vui lòng thử lại');
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
    
    if(!accepted) {
        return;
    }
    debugger;
    var formData = new FormData();
    formData.append('_token', $('#csrf-token').val());
    formData.append('id', id);
    
    isSubmited = true;
    
    $.ajax({
        url: $('#MM-008').val(),
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
            alert('Lỗi! Vui lòng thử lại');
        },
        complete: function( data ) {
            isSubmited = false;
        }
    });
}