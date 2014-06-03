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
	$(".datepicker").datepicker();
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
	$.blockUI.defaults = {
		css : {
			textAlign : "left"
		}
	};
});

// Feedback
function giveFeedback(data) {
	var text = data.msgText;
	var type = data.msgClass;
	var html = '<div class="alert alert-'
			+ type
			+ ' fade in out"><button class="close" data-dismiss="alert" type="button">&times;</button>'
			+ text + '</div>';
	$('#content').before(html);
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

function refreshDates() {
	refreshSelectedDates();
	refreshHelperDates();
	refreshParentDates();
}
// Popup management
function openPopup(title, content){
	if(content != null){
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
	openPopup('Neuen Termin anlegen', null);
	setPopupContent(addDateForm);
	$(".datepicker").datepicker();
}

function openChangeDate() {
	if (selectedDates.length == 1) {
		openPopup("Termindaten &auml;ndern");
		var selectedID = selectedDates[0];
		var postTarget = base_url + 'index.php/manageKidDates/getChangeDateForm/' + selectedID;
		$.post(postTarget, null, function(data) {
			setPopupContent($(data));
			$(".datepicker").datepicker();
		});
	} else {
		var feedBackData = new Object();
		feedBackData.msgText = 'Bitte nur einen Eintrag selektieren';
		feedBackData.msgClass = 'error';
		giveFeedback(feedBackData);
	}
}

function openDeleteDate() {
	var postTarget = base_url + 'index.php/manageKidDates/getDeleteDatesConfirm';
	openPopup("Termine l&ouml;schen")
	$.post(postTarget, {
		dates : selectedDates
	}, function(data) {
		setPopupContent($(data));
	});
}

function openAssignDate() {
	var postTarget = base_url + 'index.php/manageKidDates/getAssignDatesForm';
	openPopup("Termine zuweisen");
	$.post(postTarget, {
		dates : selectedDates
	}, function(data) {
		setPopupContent($(data));
	});
}

function openUnassignDate() {
	var postTarget = base_url + 'index.php/manageKidDates/getUnassignDatesForm';
	openPopup("Termine freigeben");
	$.post(postTarget, {
		dates : selectedDates
	}, function(data) {
		setPopupContent($(data));
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

function writeDebugData(text) {
	console.log(text);
}