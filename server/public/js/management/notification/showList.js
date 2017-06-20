function remove(id, button) {  
    var accepted = confirm("Bạn có chắc muốn xóa không ?");
    if(!accepted) {
        return;
    }
    
    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('id', id);
    
    $.ajax({
        url: $('#MM-007').val(),
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
            
        }
    });
}