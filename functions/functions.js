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