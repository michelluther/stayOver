var childInChange;

function saveUserData(){
	submitForm('UserDataForm', base_url + 'index.php/settings/saveUserData/');
}

function removeHelperFromChild(kidID, helperID) {
	var getTarget = base_url + 'index.php/settings/removeHelper/' + kidID + '/' + helperID;
	$.get(getTarget, function(data) {
		jsonObject = JSON.parse(data);
		giveFeedbackInPopup(jsonObject[0]);
		reloadAssignedHelpers(kidID);
	});
}

function addHelperToChild(kidID, helperID){
	var getTarget = base_url + 'index.php/settings/assignHelper/' + kidID + '/' + helperID;
	$.get(getTarget, function(data) {
		jsonObject = JSON.parse(data);
		giveFeedbackInPopup(jsonObject[0]);
		reloadAssignedHelpers(kidID);
	});
}

function reloadAssignedHelpers(kidID){
	var getTarget = base_url + 'index.php/settings/getAssignedHelpers/' + kidID;
	$.get(getTarget, function(data) {
		$('#assignedHelpers').html(data);
	});
}

function openAddChildPopup() {
	openPopup("Neues Kind anlegen");
	var getTarget = base_url + 'index.php/settings/addChildPopup/';
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
	});
}

function addChild(){
	var postTarget = base_url + 'index.php/settings/addChild';
	submitForm("addChildForm", postTarget, reloadChildren());
}

function confirmChildDeletion(kidID){
	openPopup("Kind l&ouml;schen", null);
	var getTarget = base_url + 'index.php/settings/getRemoveChildConfirm/' + kidID;
	$.get(getTarget, function(data) {
		setPopupContent($(data));
	});
}

function deleteChild(kidID) {
	var getTarget = base_url + 'index.php/settings/removeChild/' + kidID;
	$.get(getTarget, function(data) {
		jsonObject = JSON.parse(data);
		closePopup();
		giveFeedback(jsonObject[0]);
		reloadChildren();
	});
}

function reloadChildren(){
	var getTarget = base_url + 'index.php/settings/getAssignedChildren';
	$.get(getTarget, function(data) {
		$('#assignedChildren').html(data);
	});
}

function openChangeKidHelpers(kidID){
	var getTarget = base_url + 'index.php/settings/manageHelpersPopup/' + kidID;
	childInChange = kidID;
	openPopup("Helferzuweisungen &auml;ndern", null);
	$.get(getTarget, null, function(data) {
		setPopupContent($(data));
	});
}

function saveChildData(kidID){
	var formID = "kidDataForm_" + kidID;
	var postTarget = base_url + 'index.php/settings/saveChildData/' + kidID;
	submitForm(formID, postTarget, null);
}

function searchHelper(){
	var searchString = $('#helperSearchString').val();
	var getTarget = base_url + 'index.php/settings/searchHelpers/' + searchString;
	appendSmallPreloader($('#searchInput').parent());
	$.getJSON(getTarget, null, function(data){
		removeActivePreloader();
		replaceHelperSearchHits(data);
	});
}

function changePassword(){
	var target = base_url + 'index.php/settings/changePassWord';
	submitForm('ChangePasswordForm', target);
}

function inviteHelper(){
	var target = base_url + 'index.php/settings/inviteHelper/' + childInChange;
	submitForm(inviteHelperForm, target);
}

function replaceHelperSearchHits(hits){
	var additional_dom = "";
	$.each(hits, (function(i, hit){
		var new_row = '<tr><td>' + hit.firstName + '</td><td>' + hit.lastName + 
					  '</td><td width="40px"><a class="btn btn-small" onClick="addHelperToChild(' + 
					  childInChange + ', ' + hit.id + ')"><i class="icon-plus"></i></a>' + '</td></tr>';
		additional_dom = additional_dom + new_row;
	}));
	$('#helperSearchHits').html(additional_dom);
}