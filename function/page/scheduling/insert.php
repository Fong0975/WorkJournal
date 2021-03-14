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

echo "$schedulingDate/$schedulingHoliday/$schedulingStart/$schedulingEnd/$schedulingStation<br>";

$isRightFormat_date = checkFormat_Date($schedulingDate);
$isRightFormat_stratTime = checkFormat_Time($schedulingStart);
$isRightFormat_endTime = checkFormat_Time($schedulingEnd);
echo "$isRightFormat_date/$isRightFormat_stratTime/$isRightFormat_endTime";

if($isRightFormat_date and $isRightFormat_stratTime and $isRightFormat_endTime){
	setScheduling($schedulingDate,$schedulingStart,$schedulingEnd,$schedulingStation, $schedulingFile);
}else{
// 	echo "-".$schedulingStart;
	header('Location: ../../../scheduling_insert.php?err=date_or_time_not_formated');
	exit;
}


function setScheduling($DATE, $START, $END, $STATION, $FILE){
	if (isset($FILE["size"])) {
		if($FILE["size"] > 0){
			$msg_Upload = uploadImage($DATE,$FILE);
			if(strlen($msg_Upload) > 0 ) {
				echo $msg_Upload;
				header('Location: ../../../scheduling_insert.php?err=wrong_file_format_'.$msg_Upload);
				exit;
			}	
		}
	}
	
	
	if(insertScheduling($DATE,$START, $END,$STATION)){
		header("Location: ../../../scheduling_insert.php?err=can_not_insert_data_to_SQL" );
		exit;
	}else{
		$y = intval(substr($DATE,0,4));
		$m = intval(substr($DATE,5,2));
		$d = intval(substr($DATE,8,2));
		

		$strap = mktime(0,0,0,$m,$d,$y);
		if($number_wk=date("w",$strap) != 0){ //禮拜天為0

			$d +=1;
			if($d >= 32 and ($m == 1 or $m == 3 or $m == 5 or $m == 7 or $m == 8 or $m == 10 or $m == 12 )){
				$d = 1;
				$m ++;
			}elseif($d >= 31 and ($m == 4 or $m == 6 or $m == 9 or $m == 11)){
				$d = 1;
				$m ++;
			}elseif($d >= 30 and $m == 2 and ($y % 4 == 0 )){
				$d = 1;
				$m ++;
			}elseif($d >= 29 and $m == 2 and ($y % 4 != 0 )){
				$d = 1;
				$m ++;
			}
			
			if($m == 13){
				$m = 1;
				$y += 1;
			}
			
			if($m < 10){
				$formatedM = "0".$m;
			}else{
				$formatedM = $m;
			}
			
			if($d < 10){
				$formatedD = "0".$d;
			}else{
				$formatedD = $d;
			}

			header("Location: ../../../scheduling_insert.php?date=$y-$formatedM-$formatedD" );
			exit;

		}

		
		
		header("Location: ../../../index_showDetail.php?y=$y&m=$m&d=$d" );
		exit;
	}
	
	
}

function insertScheduling($DATE,$START, $END,$STATION){
	require "../../link_database_info.php";

	$sql_command = "INSERT INTO schedulingrecord (sr_Date, sr_StartTime, sr_EndTime, sr_Station) VALUES ('$DATE','$START','$END', '$STATION')";
	

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
		if (move_uploaded_file($FILE["tmp_name"], $target_file)) {
			return "";
		} else {
			return "Sorry, there was an error uploading your file.";
		}
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