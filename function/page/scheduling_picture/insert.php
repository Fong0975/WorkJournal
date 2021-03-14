<?php

$fileName = $_POST["weekScheduling_date"];
$filesArray = $_FILES["schedulingFile"];
uploadImage($fileName, $filesArray["name"], $filesArray["tmp_name"]);

$nextDate_y = date('Y', strtotime($fileName . ' +1 day'));
$nextDate_m = date('m', strtotime($fileName . ' +1 day'));
$nextDate_d = date('d', strtotime($fileName . ' +1 day'));

header("Location: ../../../scheduling_insertPicture_week.php?y=".$nextDate_y."&m=".$nextDate_m."&d=".$nextDate_d );
exit;

function uploadImage($DATE,$FILE_NAME, $FILE_TMP_NAME){
	$target_dir = "../../../images/scheduling/";
	$temp_name = iconv("UTF-8", "big5", $FILE_NAME);
	$imageFileType = strtolower(pathinfo($temp_name,PATHINFO_EXTENSION));
	
	$target_file = $target_dir . $DATE . ".". $imageFileType;
	$uploadOk = "";
	
	
	
	//============================= [檢查文件] =============================
		
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$uploadOk = "Sorry, the file is $imageFileType, but only JPG, JPEG, PNG & GIF files are allowed.";
	}
	
	if (file_exists($target_file)) {
		if(file_exists($target_file)) unlink($target_file);
	}
	
	//============================= [檢查文件] =============================
	
	
	if (strlen($uploadOk) != 0) {
		return $uploadOk;
//		header('Location: ../Scheduling.php#err');
//		exit;
	} else {
		if (move_uploaded_file($FILE_TMP_NAME, $target_file)) {
			return "";
		} else {
			return "Sorry, there was an error uploading your file.";
		}
	}
}

?>