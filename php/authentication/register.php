<?php
function emptyInput($form){
	foreach($form as $input){
		if(empty($input)){
			return true;
		}
	}
	return false;
}

function getDefaultRoleID($conn){
	$sql = "SELECT id FROM roles WHERE role_name = 'Default';";
	$res = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($res);

	$id[]=$row;

	return $id;
}