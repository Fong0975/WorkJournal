<?php

function checkFormat_Date($str_date){

	if(date('Y-m-d', strtotime($str_date)) == $str_date){
		return true;
	}else{
		return false;
	}
}

function checkFormat_Time($str_time){

	if(date('H:i', strtotime($str_time)) == $str_time){
		return true;
	}else{
		return false;
	}
}

?>