<?php

function isLogged(){
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
		return true;
	else
		return false;
}

function isAdmin(){
	if(isset($_ENV['USER_TYPE']) && $_ENV['USER_TYPE'] == '1'){
		return true;
	}
	return false;
}

function idExists($conn, $username){
	$sql = "SELECT * FROM users WHERE userID = ?;";
	$stmt = mysqli_stmt_init($conn);

	//	Check if statement fails
	if(!mysqli_stmt_prepare($stmt, $sql)){
		// header("Location: login?error=2");
		// exit();
		return false;
	}
	
	mysqli_stmt_bind_param($stmt, "s", $username);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	if($row = mysqli_fetch_assoc($result)){
		return $row;
	}
	else{
		return false;
	}

	mysqli_stmt_close($stmt);
}