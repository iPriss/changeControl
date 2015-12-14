function getParamsForm(form, classInput){
	if(!classInput){ classInput = '.formData'; }
	params = {};
    form.find(classInput).each(function(){
    	if($(this).val() != '' && $(this).val() != 'undefined'){
    		params[$(this).attr('name')] = $(this).val();
    	}
    });
    return params
}

function truncateText(text, maxLength, returnAs) {
	if(!maxLength){ maxLength = 18; }

	if(text.length > maxLength){
		if(!returnAs){
			return text.substr(0, maxLength);
		}else if(returnAs == 'aWithTitle'){
			return '<a title="'+text+'" default-content="'+text+'">'+text.substr(0, maxLength)+'</a>';
		}
	}else{
		return text;
	}
}

function loadChangeRequest(dom){
	alert($(dom).parents('tr').find('td:eq(0)').text());
}

/* Edit layout */
function updateChangeRequestStats(data) {
	var pending = $('.pending-to-approvals');
	var approved = $('.approved');
	var inProgress = $('change-in-progress');
	var closed = $('.closed-request');

	pending.find('.row-stat-value').text(data['pending']);
	approved.find('.row-stat-value').text(data['approved']);
	inProgress.find('.row-stat-value').text(data['inProgress']);
	closed.find('.row-stat-value').text(data['closed']);
}


/* Connect to data */
function sendEmailToApprovers(data){
	$.ajax({
    	'url': 'init.php',
    	'data': {'service': 'sendEmailToApprovers', 'params': {'changeId': data['change_id']}},
    	'method': 'POST',
    	'dataType': 'json'
    }).done(function(dataReturn){
		if(typeof callback === 'fuctnion'){callback(dataReturn); }
	});
}

function sendEmailToExecutors(data, callback){
	$.ajax({
    	'url': 'init.php',
    	'data': {'service': 'sendEmailToExecutors', 'params': {'changeId': data['change_id']}},
    	'method': 'POST',
    	'dataType': 'json'
    }).done(function(dataReturn){
		if(typeof callback === 'fuctnion'){callback(dataReturn); }
	});
}

function getStats() {
	$.ajax({
    	'url': 'init.php',
    	'data': {'service': 'getStats'},
    	'method': 'POST',
    	'dataType': 'json'
    }).done(function(dataReturn){
		if(dataReturn['status'] == 'ok'){
			updateChangeRequestStats(dataReturn['data']);
		}
	});
}