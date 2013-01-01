var addChildForm;

$(document).ready(function() {
	addChildForm = $('#addKidDateForm');
	addChildForm.detach();
});

function saveUserData(){
	submitForm('UserDataForm', base_url + 'index.php/settings/saveUserData/');
}

function removeHelper(kidID, helperID) {
	var getTarget = base_url + 'index.php/settings/removeHelper/' + kidID + '/' + helperID;
	$.blockUI();
	$.get(getTarget, function(data) {
		jsonObject = JSON.parse(data);
		$.unblockUI();
		giveFeedback(jsonObject[0]);
	});
}

function openAddChildPopup() {
	$.blockUI({
		message : $('#dynamicPopup')
	});
	setPopupContent(addChildForm);
}

function deleteChild() {
	
}