$(document).ready(function() {
	$.datepicker.setDefaults($.datepicker.regional['de']);
	$(".datepicker").datepicker();
//	$(".dateNavigation").on('mouseover', function(e) {
//		showSubNavigation(e.target);
//	});
//	$(".dateNavigation").on('mouseout', function(e) {
//		hideSubNavigation(e.target);
//	});
});

function giveFeedback(data) {
	var text = data.msgText;
	var type = data.msgClass;
	var html = '<div class="alert alert-'
			+ type
			+ ' fade in out"><button class="close" data-dismiss="alert" type="button">&times;</button>'
			+ text + '</div>';
	alert($('#content').html());
	$('#content').before(html);
}

function openAddDate() {
	// $('#addDateForm').modal('show');
	$.blockUI({
		message : $('#addDateForm')
	});
}

function submitForm(form, target, callback) {
	var jsonForm = form2js(form, '.', false);
	// $(".loaderText").display();
	$.post(target, jsonForm, function(data) {
		jsonObject = JSON.parse(data);
		$.unblockUI();
		giveFeedback(jsonObject[0]);
		//writeDebugData(data);
		
	});
}

function formSubmitted(data) {
	writeDebugData('data returned');
}

function showSubNavigation(hoverTarget) {
	var navigation = $(hoverTarget);
	while (navigation.hasClass('dateNavigation') != true) {
		navigation = navigation.parent();
		if (navigation.id == 'content') {
			continue;
		}
	}
	if (navigation.hasClass('dateNavigation') == true) {
		navigation.css('color', '#000');
	}
}

function hideSubNavigation(target) {
	if (target.hasClass('dateNavigation') == true) {
		$(target).css('color', '#fff');
	}
}

function writeDebugData(text) {
	console.log(text);
	}

function giveFeedbackTest() {
	var object = new Object();
	object.msgText = 'Haaaaalo';
	giveFeedback(object);
}