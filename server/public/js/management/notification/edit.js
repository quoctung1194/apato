$( document ).ready(function() {
	$('#remindDate').datetimepicker();
	description_editor = CKEDITOR.replace('content');
	turnOnCalender();
});

function turnOnCalender() {
	if(document.getElementById('remind').checked) {
		document.getElementById('remindDate').disabled = false;
	} else {
		document.getElementById('remindDate').disabled = true;
		document.getElementById('remindDate').value = "";
	}
}

function showUsers()
{
	// show modal
	$('#usersModal').modal();

	//load user list
	$('#usersContainer').load($('#MM-008').val());
}

function submitForm()
{
	let container = $('#userTags');
	// convert to hidden field
	let userListHidden = $('#privateUserList');
	let values = [];

	// find tag element in container
    container.find('.tag').each(function() {
        values.push($(this).attr('user-id')); 
    });

    userListHidden.attr('value', values.join(","));
}

//Config for CKEDITOR
CKEDITOR.config.image_previewText = CKEDITOR.tools.repeat(' ', 100 );
CKEDITOR.on('dialogDefinition', function(ev) {
    var editor = ev.editor;
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    if (dialogName == 'image') {
		var infoTab = dialogDefinition.getContents( 'info' );
		infoTab.remove('txtBorder' );
		infoTab.remove('txtHSpace' );
		infoTab.remove('txtVSpace' );
		infoTab.remove('txtVSpace' );
		infoTab.remove('txtWidth');
		infoTab.remove('txtHeight');
		infoTab.remove('ratioLock');
		infoTab.remove('cmbAlign');
		infoTab.remove('txtAlt');
		infoTab.remove('htmlPreview');
		infoTab.get('htmlPreview');
		//Remove tab Link
		dialogDefinition.removeContents( 'Link' );

		dialogDefinition.onOk = function (e) {
			var imageSrcUrl = e.sender.originalElement.$.src;

			var imgHtml = CKEDITOR.dom.element.createFromHtml('<img src="' + imageSrcUrl + '" style="width: 100%; height: auto" />');
			editor.insertElement(imgHtml);
		};
	}
});