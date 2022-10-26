<?php
require 'vendor/autoload.php';
use Bcrypt\Bcrypt;

function emptyInput($id, $password){
	if(empty($id) || empty($password)){
		return true;
	}
	return false;
}

function loginUser($conn, $id, $password){
	$idExists = idExists($conn, $id);

	//	User does not exist
	if($idExists === false){
		// header("Location: login?error=3");
		// exit();
		return false;
	}

	$passwordHashed = $idExists['password'];

	$bcrypt = new Bcrypt();

	if($bcrypt->verify($password, $passwordHashed)){
		$checkedPassword = true;
	}
	else{
		$checkedPassword = false;
	}

	//	Password does not match
	if($checkedPassword === false){
		// header("Location: login?error=4");
		// exit();
		return false;
	}
	//	SUCCESS
	else if($checkedPassword === true){
		return $idExists;
	}
}