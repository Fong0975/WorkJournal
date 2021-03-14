<?php

function isExistJournal($date){
	$journalID = intval(getJournalID($date));
	// echo "ID=".$journalID.(($journalID > 0)? "T":"F")."<br>";

	if($journalID > 0){
		return "true";
	}else{
		return "false";
	}
}

function getJournalID($date){
	require_once("function/getData.php");
	// echo getData_String("cr_ID", "clockrecord", "(cr_Date = '$date' AND cr_Type = '上班')", "")."<BR>";

	$journalID_string = explode("@br@",getData_String("cr_ID", "clockrecord", "(cr_Date = '$date' AND cr_Type = '上班')", ""))[0];
	$journalID = intval($journalID_string);

	return $journalID;
}

function getJournal($date){
	require_once("function/getData.php");

	$journal_string = explode("@br@",getData_String("cr_ID, cr_Date, cr_baseSalary, cr_isPay_off, cr_isPay_holiday", "clockrecord", "(cr_Date = '$date' AND cr_Type = '上班')", ""))[0];
	$journal_array = explode("/", $journal_string);

	return $journal_array;
}

?>