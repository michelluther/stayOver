var selectedDates = new Array();
var addDateForm;
var popupDiv;
var popupTitle;
var popupContent;
var preloaderLarge;
var preloaderSmall;
var activePreloader;
var popupOpen;
var resetTest;

$(document).ready(function() {
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
	$('#loginSubmit').click(function() {
		submitLogin();
	});
	setSubmitOnEnter();
	resetTest = true;
});

function openHelp(){
	window.open('http://www.michelsplayground.com', 'stayOver Hilfe');
}

function toggleHelpContentDisplay(event){
	var target = event.target;
	$(target).children().show();
}

function setSubmitOnEnter() {
	$(".submitOnEnter").keypress(function(e) {
		//submitLogin();
	});
}

function setTimePicker() {
	$('.timepicker-default').timepicker({
		showMeridian : false,
		showInputs : false,
		disableFocus : true,
	});
}

function setDatePicker() {
	$('.datepicker').datepicker();
}

function returnHome() {
	window.location = base_url + 'index.php/stayOver/home';
}

// Feedback
function giveFeedback(data) {
	if (popupOpen == true && data.msgClass == 'error') {
		giveFeedbackInPopup(data);
	} else {
		var text = data.msgText;
		var type = data.msgClass;
		var html = '<div class="alert alert-'
				+ type
				+ ' fade in out"><button class="close" data-dismiss="alert" type="button">&times;</button>'
				+ text + '</div>';
		$('#feedbackArea').html(html);
	}
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

function refreshDates() {
	refreshSelectedDates();
	refreshHelperDates();
	refreshParentDates();
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

function refreshParentDates() {
	var getTarget = base_url + 'index.php/stayOver/getParentDates';
	$.get(getTarget, null, function(html) {
		$('#nextParentDatesDiv').html(html);
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
		message : popupDiv,
		onBlock : function(){ setPopupOpen(true); },
		onUnblock : function(){setPopupOpen(false); }
	});
	popupTitle.text(title);
	popupOpen = true;
}

function closePopup() {
	setPopupOpen(false);
	$.unblockUI();
}

function setPopupOpen(isOpen){
	popupOpen = isOpen;
}

function openAddDate() {
	openPopup('Einen neuen Termin anlegen', null);
	var getTarget = base_url + 'index.php/manageKidDates/getAddDate';
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
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
	openPopup("Termindaten &Auml;ndern");
	var postTarget = base_url + 'index.php/manageKidDates/getChangeDateForm/'
			+ selectedID;
	$.post(postTarget, null, function(data) {
		setPopupContent($(data));
		setTimePicker();
		setDatePicker();
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
		closePopup();
		jsonObject = JSON.parse(data);
		giveFeedback(jsonObject[0]);
		refreshDates();
	});
}

function unassignDate(dateID) {
	var getTarget = base_url + 'index.php/manageKidDates/unassignDate/'
			+ dateID;
	$.get(getTarget, function(data) {
		closePopup();
		jsonObject = JSON.parse(data);
		giveFeedback(jsonObject[0]);
		refreshDates();
	});
}

function assignDate(dateID) {
	var helperID = $('#helperIDSelect :selected').val();
	var getTarget = base_url + 'index.php/manageKidDates/assignDate/' + dateID
			+ '/' + helperID;
	$.get(getTarget, function(data) {
		closePopup();
		jsonObject = JSON.parse(data);
		giveFeedback(jsonObject[0]);
		refreshDates();
	});
}

function assignDateToSelf(dateID) {
	var getTarget = base_url + 'index.php/manageKidDates/assignDate/' + dateID;
	$.get(getTarget, function(data) {
		closePopup();
		jsonObject = JSON.parse(data);
		giveFeedback(jsonObject[0]);
		refreshDates();
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
		var jsonObject = JSON.parse(data);
		var feedback = jsonObject[0];
		if (feedback.msgClass == 'success') {
			closePopup();
		}
		giveFeedback(feedback);
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
		closePopup();
		giveFeedback(jsonObject[0]);
		refreshDates();
	});
}

function submitLogin() {
	var postTarget = base_url + 'index.php/stayOver/submit_login';
	var loginData = form2js('loginForm', '.');
	$.post(postTarget, loginData, function(data) {
		var jsonObject = JSON.parse(data);
		var feedback = jsonObject[0]; // if successful, redirect, otherwise
		// give feedback
		var type = feedback.msgClass;
		if (type == 'success') {
			var redirectTarget = base_url + 'index.php/' + feedback.redirectTarget ;
			window.location.replace(redirectTarget);
		} else {
			giveFeedback(feedback);
		}
	});
}

function submitRegistrationKey(){
	var postTarget = base_url + 'index.php/registration/submitRegistrationKey';
	var loginData = form2js('registrationForm', '.');
	$.post(postTarget, loginData, function(data) {
		var jsonObject = JSON.parse(data);
		var feedback = jsonObject[0]; // if successful, redirect, otherwise
		// give feedback
		var type = feedback.msgClass;
		if (type == 'success') {
			var redirectTarget = base_url + 'index.php/registration/userSetupForm';
			window.location.replace(redirectTarget);
		} else {
			giveFeedback(feedback);
		}
	});
}

function submitUserRegistration(){
	var postTarget = base_url + 'index.php/registration/submitUserRegistration';
	var loginData = form2js('createUserForm', '.');
	$.post(postTarget, loginData, function(data) {
		var jsonObject = JSON.parse(data);
		var feedback = jsonObject[0]; // if successful, redirect, otherwise
		// give feedback
		var type = feedback.msgClass;
		if (type == 'success') {
			var redirectTarget = base_url + 'index.php/stayOver/home';
			window.location.replace(redirectTarget);
		} else {
			giveFeedback(feedback);
		}
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