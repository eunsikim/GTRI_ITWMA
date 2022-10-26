<?php
function emptyInput($firstName, $lastName, $email, $password){
	if(empty($firstName) || empty($lastName) || empty($email) || empty($password)){
		return true;
	}
	return false;
}
