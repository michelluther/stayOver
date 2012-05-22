$(document).ready(function(){
	$( ".datepicker" ).datepicker();
});


function giveFeedback(text){
	$('#msg_area').html(text);
}

function submitForm(form, target, callback){
	var jsonForm = form2js(form, '.', true);
	writeDebugData('sending data to ' + target + ': ' + JSON.stringify(jsonForm, null, '\t'));
	writeDebugData('callback will be: ' + callback);
	$.post(target, jsonForm, function(data){
		writeDebugData(data);
	}, function(data){alert(data);});
}

function formSubmitted(data){
	writeDebugData('data returned');
}

function writeDebugData(text){
	$('#debugArea').append(text);
	$('#debugArea').append('<br />');
}