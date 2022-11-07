<?php
function emptyInput($form){
	foreach($form as $input){
		if(empty($input)){
			return true;
		}
	}
	return false;
}
