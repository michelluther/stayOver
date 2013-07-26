function addUser(){
	submitForm('addUserForm', base_url + 'index.php/admin/addUser/');
}

function unlockUser(){
	submitForm('unlockUserForm', base_url + 'index.php/admin/unlockUser/');
}

function resetUserPW(){
	submitForm('resetPasswordForm', base_url + 'index.php/admin/resetPWAdmin/');
}