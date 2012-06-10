$(document).ready(function(){
	$.datepicker.setDefaults($.datepicker.regional['de']);
	$( ".datepicker" ).datepicker();
});


function giveFeedback(text){
	$('#msg_area').html(text);
}

function openAddDate(){
	$.blockUI( {message: $('#addDateDiv')} );
}

function submitForm(form, target, callback){
	var jsonForm = form2js(form, '.', false);
	writeDebugData('sending data to ' + target + ': ' + JSON.stringify(jsonForm, null, '\t'));
	writeDebugData('callback will be: ' + callback);
	$.blockUI({
				message: $('#preloader')
	});
	$.post(	target, 
			jsonForm, 
			function(data){
				$.unblockUI();
				writeDebugData(data);
			}
	);
}

function formSubmitted(data){
	writeDebugData('data returned');
}

function writeDebugData(text){
	$('#debugArea').append(text);
	$('#debugArea').append('<br />');
}