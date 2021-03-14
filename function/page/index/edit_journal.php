<?php
	$journalID = $_POST['journalID'];
	$journalDate = explode("-", $_POST['journalDate']);
	$journalBasicSalary = number_format(floatval($_POST['journalBasicSalary']),2);
	$journalIsOffDay = ($_POST['journalOffDay'] == "")? "0":"1";
	$journalIsHoliday = ($_POST['journalHoliday'] == "")? "0":"1";
	// echo "$journalID/$journalBasicSalary/$journalIsOffDay/$journalIsHoliday";

	updateScheduling($journalID, $journalBasicSalary, $journalIsOffDay, $journalIsHoliday);
	header('Location: ../../../index_showDetail.php?y='.$journalDate[0].'&m='.$journalDate[1].'&d='.$journalDate[2].'');
	exit;

function updateScheduling($ID, $salary, $isOff, $isHoliday){
	require "../../link_database_info.php";

	$sql_command = "UPDATE clockrecord SET cr_baseSalary= $salary, cr_isPay_off= $isOff, cr_isPay_holiday= $isHoliday WHERE cr_ID = $ID";
	// echo $sql_command;

	$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
	$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
	mysqli_set_charset($sql_connect, "utf8");
	$query = mysqli_query($sql_connect,$sql_command );
	
	return !$query;
}
?>