<?php

$date = $_GET['date'];
deleteSchedulinngImage($date);
header('Location: ../../../scheduling_edit.php?date='.$date);
exit;

function deleteSchedulinngImage($DATE){
	$target_dir = "../../../images/scheduling/";
	$target_file_withoutType = $target_dir . $DATE . ".";
	
	if(file_exists($target_file_withoutType."jpg")){
		unlink($target_file_withoutType."jpg");
	}elseif(file_exists($target_file_withoutType."jpeg")){
		unlink($target_file_withoutType."jpeg");
	}elseif(file_exists($target_file_withoutType."png")){
		unlink($target_file_withoutType."png");
	}elseif(file_exists($target_file_withoutType."gif")){
		unlink($target_file_withoutType."gif");
	}elseif (file_exists($target_file)) {
		unlink($target_file);
	}
}

?>