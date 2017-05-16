$( document ).ready(function() {
	$('#remindCalender').datetimepicker();
	description_editor = CKEDITOR.replace('content');
});

function turnOnCalender() {
	if(document.getElementById('remind').checked) {
		document.getElementById('remindCalender').disabled = false;
	} else {
		document.getElementById('remindCalender').disabled = true;
		document.getElementById('remindCalender').value="";
	}
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