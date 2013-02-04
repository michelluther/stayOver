var selectedDates = new Array();
var addDateForm;
var popupDiv;
var popupTitle;
var popupContent;
var preloaderLarge;
var preloaderSmall;
var activePreloader;

$(document).ready(function() {
	$.datepicker.setDefaults($.datepicker.regional['de']);
	$(".selectableTr").on('click', function(event) {
		toggleSelection($(event.target).closest('.selectableTr'));
	});
	popupDiv = $('#dynamicPopup');
	popupTitle = $('#popupTitle');
	popupContent = $('#dynamicPopupContent');
	popupDiv.detach();
	addDateForm = $('#addKidDateForm');
	addDateForm.detach();
	preloaderSmall = $('#preloaderSmall');
	preloaderSmall.detach();
	preloaderLarge = $('#preloaderLarge');
	preloaderLarge.detach();
});

function setTimePicker() {
	$('.timepicker-default').timepicker({
		showMeridian : false,
		showInputs : false,
		disableFocus : true
	});
}

function setDatePicker() {
	$('.datePicker').datepicker();
}

// Feedback
function giveFeedback(data) {
	var text = data.msgText;
	var type = data.msgClass;
	var html = '<div class="alert alert-'
			+ type
			+ ' fade in out"><button class="close" data-dismiss="alert" type="button">&times;</button>'
			+ text + '</div>';
	$('#feedbackArea').html(html);
}

function giveFeedbackInPopup(data) {
	var text = data.msgText;
	var type = data.msgClass;
	var html = '<div class="alert alert-'
			+ type
			+ ' fade in out"><button class="close" data-dismiss="alert" type="button">&times;</button>'
			+ text + '</div>';
	$('#dynamicPopupContent').before(html);
}

// Preloader
function insertLargePreloader(container) {
	container.html(preloaderLarge);
}

function appendSmallPreloader(container) {
	container.append(preloaderSmall);
	activePreloader = preloaderSmall;
	preloaderSmall.show();
}

function putSmallPreloader(container) {
	container.html(preloaderSmall);
}

function removeActivePreloader() {
	activePreloader.detach();
}

// Table & selection management
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

function refreshSelectedDates() {
	selectedDates = new Array();
}

function refreshHelperDates() {
	var getTarget = base_url + 'index.php/stayOver/getNextHelperDates';
	$.get(getTarget, null, function(html) {
		$('#nextHelperDatesDiv').html(html);
	});
	getTarget = base_url + 'index.php/stayOver/getOpenHelperDates';
	$.get(getTarget, null, function(html) {
		$('#openHelperDatesDiv').html(html);
	});
}
// Popup management
function openPopup(title, content) {
	if (content != null) {
		popupContent.html(content);
	} else {
		popupContent.html(preloaderLarge);
		preloaderLarge.show();
	}
	$.blockUI({
		message : popupDiv
	});
	popupTitle.text(title);
}

function openAddDate() {
	openPopup('Einen neuen Termin anlegen', null);
	var getTarget = base_url + 'index.php/manageKidDates/getAddDate';
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
		$(".datepicker").datepicker();
		setTimePicker();
		setDatePicker();
	});
}

function openViewDate(dateID) {
	openPopup("Termindetails");
	var getTarget = base_url + 'index.php/stayOver/viewDate/' + dateID;
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
	});
}

function openChangeDate(selectedID) {
	openPopup("Termindaten ändern");
	var postTarget = base_url + 'index.php/manageKidDates/getChangeDateForm/'
			+ selectedID;
	$.post(postTarget, null, function(data) {
		setPopupContent($(data));
		$(".datepicker").datepicker();
	});
}

function openDeleteDate(dateID) {
	var getTarget = base_url
			+ 'index.php/manageKidDates/getDeleteDatesConfirm/' + dateID;
	openPopup("Termine l&ouml;schen");
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
	});
}

function openAssignDate(dateID) {
	var getTarget = base_url + 'index.php/manageKidDates/getAssignDateForm/'
			+ dateID;
	openPopup("Termin zuweisen");
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
	});
}

function openAssignDateToSelf(dateID) {
	var getTarget = base_url
			+ 'index.php/manageKidDates/getAssignDateToSelfForm/' + dateID;
	openPopup("Termine &uuml;bernehmen");
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
	});
}

function openUnassignDate(dateID) {
	var getTarget = base_url + 'index.php/manageKidDates/getUnassignDatesForm/'
			+ dateID;
	openPopup("Termin freigeben");
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
	});
}

function deleteDate(dateID) {
	var getTarget = base_url + 'index.php/manageKidDates/removeDate/' + dateID;
	$.get(getTarget, function(data) {
		$.unblockUI();
		jsonObject = JSON.parse(data);
		giveFeedback(jsonObject[0]);
		refreshParentDates();
	});
}

function unassignDate(dateID) {
	var getTarget = base_url + 'index.php/manageKidDates/unassignDate/'
			+ dateID;
	$.get(getTarget, function(data) {
		$.unblockUI();
		jsonObject = JSON.parse(data);
		giveFeedback(jsonObject[0]);
		refreshHelperDates();
	});
}

function assignDate(dateID) {
	var helperID = $('#helperIDSelect :selected').val();
	var getTarget = base_url + 'index.php/manageKidDates/assignDate/' + dateID
			+ '/' + helperID;
	$.get(getTarget, function(data) {
		$.unblockUI();
		jsonObject = JSON.parse(data);
		giveFeedback(jsonObject[0]);
		refreshHelperDates();
	});
}

function assignDateToSelf(dateID) {
	var getTarget = base_url + 'index.php/manageKidDates/assignDate/' + dateID;
	$.get(getTarget, function(data) {
		$.unblockUI();
		jsonObject = JSON.parse(data);
		giveFeedback(jsonObject[0]);
		refreshHelperDates();
	});
}

function setPopupContent(content) {
	popupContent.empty();
	popupContent.hide();
	popupContent.html(content);
	popupContent.show();
}

function submitFormAndRefresh(form, target) {
	submitForm(form, target, function() {
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

function openCalendarEntry(dateID) {
	var getTarget = base_url + 'index.php/stayOver/icalEntryPopup/' + dateID;
	openPopup('Kalendereintrag zusenden oder downloaden', null);
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
	});
}

function sendCalendarEntry(dateID) {
	var getTarget = base_url + 'index.php/stayOver/sendIcalEntryToUser/'
			+ dateID;
	$.get(getTarget, function(data) {
		jsonObject = JSON.parse(data);
		giveFeedbackInPopup(jsonObject[0]);
	});
}

function openEmailToParents(dateID) {
	var getTarget = base_url + 'index.php/stayOver/openEmailToParents/'
			+ dateID;
	openPopup('E-Mail an die Eltern verfassen', null);
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
	});
}

function sendMail(dateID) {
	var postTarget = base_url + 'index.php/stayOver/sendMailToParents/'
			+ dateID;
	submitForm('mailToParents', postTarget);
}

function writeDebugData(text) {
	console.log(text);
}