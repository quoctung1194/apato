function addRow() {
	var table = document.getElementById('option');
	
	var tr = document.createElement("tr");
	var td = document.createElement("td");
	var optionContent = document.getElementById('optionContent');
	
	td.setAttribute("style", "padding-bottom: 5px");
		var button = document.createElement("button");
		button.setAttribute('type', 'button');
		button.setAttribute('onClick', 'deleteRow(this)');
		button.innerHTML = '<i class="fa fa-times" aria-hidden="true"></i>';
	td.appendChild(button);
	tr.appendChild(td);
	
	var td = document.createElement("td");
	td.innerHTML = '<label class="control-label">'+optionContent.value+'</label>';
	tr.appendChild(td);
	
	table.appendChild(tr);
	optionContent.value = '';
}

function deleteRow(obj) {
	var row = obj.parentNode.parentNode;
	var table = document.getElementById('option');
	
	if(obj.getAttribute('key') == 'other') {
		document.getElementById('otherContainer').innerHTML = '<button type="button" class="btn btn-link">Ý Kiến Khác</button>';
	}
	
	table.removeChild(row);
}

function addOther() {
	var table = document.getElementById('option');
	var tr = document.createElement("tr");
	var td = document.createElement("td");
	var otherContainer = document.getElementById('otherContainer');
	
	td.setAttribute("style", "padding-bottom: 5px");
		var button = document.createElement("button");
		button.setAttribute('type', 'button');
		button.setAttribute("key", "other");
		button.setAttribute('onClick', 'deleteRow(this)');
		button.innerHTML = '<i class="fa fa-times" aria-hidden="true"></i>';
	td.appendChild(button);
	tr.appendChild(td);
	
	var td = document.createElement("td");
	td.innerHTML = '<label class="control-label">Ý Kiến Khác</label>';
	tr.appendChild(td);
	
	table.appendChild(tr);
	otherContainer.innerHTML = '';
}

function convertToJson() {
	var input = document.getElementById('options');
	var table = document.getElementById('option');
	var options = [];
	
	for(var i = 0; i < table.childNodes.length; i++) {
		var node = table.childNodes[i];
		
		if(node.nodeName == 'TR') {
			var option = {};
			option.content = node.childNodes[1].childNodes[0].innerHTML;
			
			var key = node.childNodes[0].childNodes[0].getAttribute('key');
			if(key != undefined) {
				option.isOther = true;
			} else {
				option.isOther = false;
			}
			
			options.push(option);
		}
	}
	
	input.value = JSON.stringify(options);
}

function submitForm() {
	var form = document.getElementById('Optionsform');

	if($('input[name="id"]').val() == "") {
		convertToJson();
	}

	let container = $('#userTags');
	// convert to hidden field
	let userListHidden = $('#privateUserList');
	let values = [];

	// find tag element in container
    container.find('.tag').each(function() {
        values.push($(this).attr('user-id')); 
    });

    userListHidden.attr('value', values.join(","));
	
	form.submit();
}