<?php

require_once("../../check_dateFormat.php");

$schedulingDate = $_POST['schedulingDate'];
$schedulingHoliday = ($_POST['schedulingHoliday'] == "")? "false":"true";
$schedulingStart = $_POST['schedulingTime_start'];
$schedulingEnd = $_POST['schedulingTime_end'];
$schedulingStation = getStrStation($_POST["schedulingStation"]);
$schedulingFile = $_FILES["schedulingFile"];

if($schedulingHoliday == "true"){
	$schedulingStart = "00:00";
	$schedulingEnd = "00:00";
	$schedulingStation = "";
}

echo "$schedulingDate/".$_POST['schedulingHoliday']."|$schedulingHoliday/$schedulingStart/$schedulingEnd/$schedulingStation<br>";

$isRightFormat_date = checkFormat_Date($schedulingDate);
$isRightFormat_stratTime = checkFormat_Time($schedulingStart);
$isRightFormat_endTime = checkFormat_Time($schedulingEnd);
echo "$isRightFormat_date/$isRightFormat_stratTime/$isRightFormat_endTime";


if(checkFormat_Date($schedulingDate) and checkFormat_Time($schedulingStart) and checkFormat_Time($schedulingEnd)){
	setScheduling($schedulingDate,$schedulingStart,$schedulingEnd,$schedulingStation, $schedulingFile);
}else{
	header('Location: ../../../index.php?err=date_or_time_not_formated');
	exit;
}

function setScheduling($DATE,$START, $END, $STATION, $FILE){
	if (isset($FILE["size"])) {
		if($FILE["size"] > 0){
			$msg_Upload = uploadImage($DATE,$FILE);
			if(strlen($msg_Upload) > 0 ) {
				echo $msg_Upload;
				header('Location: ../../../index.php?err=update_image_failed');
				exit;
			}	
		}
	}
	
	
	if(updateScheduling($DATE,$START, $END, $STATION)){
		header("Location: ../../../index.php?err=update_sql_failed" );
		exit;
	}else{
		$y = substr($DATE,0,4);
		$m = substr($DATE,5,2);
		$d = substr($DATE,8,2);
		header("Location: ../../../index_showDetail.php?y=$y&m=$m&d=$d" );
		exit;
	}
	
	
}

function updateScheduling($DATE,$START, $END,$STATION){
	require "../../link_database_info.php";

	$sql_command = "UPDATE schedulingrecord SET sr_StartTime ='$START', sr_EndTime='$END', sr_Station='$STATION' WHERE sr_Date = '$DATE'";
	// echo $sql_command;

	$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
	$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
	mysqli_set_charset($sql_connect, "utf8");
	$query = mysqli_query($sql_connect,$sql_command );
	
	return !$query;
}

function uploadImage($DATE,$FILE){
	$target_dir = "../../../images/scheduling/";
	$temp_name = iconv("UTF-8", "big5", $FILE["name"]);
	$imageFileType = strtolower(pathinfo($temp_name,PATHINFO_EXTENSION));
	
	$target_file_withoutType = $target_dir . $DATE . ".";
	$target_file = $target_dir . $DATE . ".". $imageFileType;
	$uploadOk = "";
	
	
	
	//============================= [檢查文件] =============================
		
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$uploadOk = "Sorry, the file is $imageFileType, but only JPG, JPEG, PNG & GIF files are allowed.";
	}
	
	deleteImage($DATE);
	
	//============================= [檢查文件] =============================
	
	
	if (strlen($uploadOk) != 0) {
		return $uploadOk;
//		header('Location: ../Scheduling.php#err');
//		exit;
	} else {
		if (move_uploaded_file($FILE["tmp_name"], $target_file)) {
			return "";
		} else {
			return "Sorry, there was an error uploading your file.";
		}
	}
}

function deleteImage($DATE){
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


function getStrStation($oriStr){
	$doneStr = "";

	try {
	    foreach ($oriStr as $value) {
		    if($doneStr != ""){
		    	$doneStr .= ",".$value;
		    }else{
		    	$doneStr = $value;
		    }
		}

	} catch (Exception $e) {
	    
	}

	return $doneStr;
}


?>