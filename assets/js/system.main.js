function login(username, password){
	if(username.val().length <= 0 || password.val().length <= 0){
		swal("Fehler!", "Bitte alle Felder ausfüllen.", "error");
		return;
	}else{
		$.ajax({
			url: "ajax/ajax.login.php",
			type: "POST",
			dataType: "json",
			data: { key: 'login', username: username.val(), password: password.val()},
			success: function(rsp){
				if(rsp.isValid){
					if(rsp.isAuthorized)
					{
						window.location = "index.php";
					}
					else{
						swal(rsp.alert.aHeading, rsp.alert.aMessage, rsp.alert.aType);
					}
				}
				else{
					swal("Error!", "Failed to login.", "error");
				}
			}
		});
	}
}

//cf CheckForm Functions
function cfIsAllInsert(serializedForm){
	var isAllInsert = true;
	serializedForm.each(function(){
		var parentElement = $(this).parent(".input-group");
		if($(this).val().length <= 0 && !$(this).is("button")){
			parentElement.addClass("has-error");
			isAllInsert = false;
		}
	});
	return isAllInsert;
}

function addUser(serializedForm){
	$.ajax({
		url: "ajax/ajax.addUser.php",
		type: "POST",
		dataType: "json",
		data: { persNr: persNr, username: username, firstname: firstname, lastname: lastname},
		success: function(rsp){
			return rsp.isValid;
		}
	});
}

function ajaxAddUser(persNr, username, firstname, lastname){

}
