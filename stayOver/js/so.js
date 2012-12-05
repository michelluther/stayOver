var selectedDates = new Array();
var addDateForm;

$(document).ready(function() {
	$.datepicker.setDefaults($.datepicker.regional['de']);
	$(".datepicker").datepicker();
	$(".selectableTr").on('click', function(event) {
		toggleSelection($(event.target).closest('.selectableTr'));
	});
	addDateForm = $('#addKidDateForm');
	addDateForm.detach();
});

// Feedback Data
function giveFeedback(data) {
	var text = data.msgText;
	var type = data.msgClass;
	var html = '<div class="alert alert-'
			+ type
			+ ' fade in out"><button class="close" data-dismiss="alert" type="button">&times;</button>'
			+ text + '</div>';
	$('#content').before(html);
}

// Table Management
function toggleSelection(target) {
	var selectedID = target.attr('so_data.id');
	if (target.hasClass('highlight') == true) {
		selectedDates = $.grep(selectedDates, function(value) {
			return value != selectedID;
		});
		target.removeClass('highlight');
	} else {
		selectedDates.push(selectedID);
		target.addClass('highlight');
	}
}

function refreshSelectedDates(){
	selectedDates = new Array();
}

function refreshDates() {
	refreshSelectedDates();
	var postTarget = base_url + 'index.php/manageKidDates/getDates';
	$.post(postTarget, null, function(html) {
		$('#kidDatesTable').html(html);
		$.unblockUI();
		$(".selectableTr").on('click', function(event) {
			toggleSelection($(event.target).closest('.selectableTr'));
		});
	});
}
// Popup Management
function openAddDate() {
	$.blockUI({
		message : $('#dynamicPopup')
	});
	setPopupContent(addDateForm);
}

function openChangeDate() {
	if (selectedDates.length == 1) {
		$.blockUI({
			message : $('#dynamicPopup')
		});
		clearPopupContent();
		var selectedID = selectedDates[0];
		var postTarget = base_url
				+ 'index.php/manageKidDates/getChangeDateForm/' + selectedID;
		$.post(postTarget, null, function(data) {
			setPopupContent($(data));
			$(".datepicker").datepicker();
		});
	} else {
		var feedBackData = new Object();
		feedBackData.sgText = 'Bitte nur einen Eintrag selektieren';
		feedBackData.msgClass = 'error';
		giveFeedback(feedBackData);
	}
}

function openDeleteDate() {
	var postTarget = base_url
			+ 'index.php/manageKidDates/getDeleteDatesConfirm';
	$.blockUI({
		message : $('#dynamicPopup')
	});
	$.post(postTarget, {
		dates : selectedDates
	}, function(data) {
		setPopupContent($(data));
	});
}

function openAssignDate() {
	var postTarget = base_url + 'index.php/manageKidDates/getAssignDatesForm';
	$.blockUI({
		message : $('#dynamicPopup')
	});
	$.post(postTarget, {
		dates : selectedDates
	}, function(data) {
		setPopupContent($(data));
	});
}

function openUnassignDate(){
	var postTarget = base_url + 'index.php/manageKidDates/getUnassignDatesForm';
	$.blockUI({
		message : $('#dynamicPopup')
	});
	$.post(postTarget, {
		dates : selectedDates
	}, function(data) {
		setPopupContent($(data));
	});
}

function setPopupContent(content) {
	clearPopupContent();
	$('#dynamicPopupContent').html(content);
	$('#dynamicPopupContent').show();
}

function clearPopupContent() {
	$('#dynamicPopupContent').empty();
	$('#dynamicPopupContent').hide();
}

function submitFormAndRefresh(form, target){
	submitForm(form, target, function(){
		refreshDates();
	});
}

function submitForm(form, target, callback) {
	var jsonForm = form2js(form, '.', false);
	$.post(target, {
		'form' : jsonForm,
		'dates' : selectedDates
	}, function(data) {
		jsonObject = JSON.parse(data);
		$.unblockUI();
		giveFeedback(jsonObject[0]);
		if (callback != undefined && typeof callback == 'function') {
			callback();
		}
	});
}

function submitDeletion() {
	var postTarget = base_url + 'index.php/manageKidDates/removeDates';
	$.post(postTarget, {
		dates : selectedDates
	}, function(data) {
		jsonObject = JSON.parse(data);
		$.unblockUI();
		giveFeedback(jsonObject[0]);
		refreshDates();
	});
}

function writeDebugData(text) {
	console.log(text);
}