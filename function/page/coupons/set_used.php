<?php
	$serial = $_GET['serial'];
	setUsed($serial);
	header('Location: ../../../coupons.php');
	exit;

	function setUsed($serial){
		require "../../link_database_info.php";

		$newStatus = (isUsed($serial) == 0)? "1":"0";
		$sql_command = "UPDATE qrcode SET qr_used = '$newStatus' WHERE qr_code = '$serial'";
		echo $sql_command;

		$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
		$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
		mysqli_set_charset($sql_connect, "utf8");
		$query = mysqli_query($sql_connect,$sql_command );
		
		return !$query;
	}

	function isUsed($serial){
		require_once("../../getData.php");

		$strData = getData_String("qr_used", "qrcode", "qr_code = '$serial'", "");
		$arrDataRow=explode('@br@',$strData);

		return $arrDataRow[0];
	}

?>