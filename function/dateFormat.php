<?php

function isRightDate($testY, $testM, $testD){
	
	$y = intval($testY);
	$m = intval($testM);
	$d = intval($testD);

	//testing Year
	if($y < 1911 || $y > 2100){
		return false;
	}

	//testing Month
	if($m < 1 || $m > 12){
		return false;
	}
	
	//testing Day
	if($m == 2){
		if($y % 4 == 0){
			if($d < 1 || $d > 29){
				return false;
			}
		}else{
			if($d < 1 || $d > 28){
				return false;
			}
		}
	}elseif($m == 4 || $m == 6 || $m == 9 || $m == 11){
		if($d < 1 || $d > 30){
			return false;
		}
	}else{
		if($d < 1 || $d > 31){
			return false;
		}
	}

	return true;
}

function getFormatedDate($y, $m, $d){

	if(!isRightDate($y, $m, $d)){
		return "";
	}
	
	$formatedY = intval($y);
	$formatedM = intval($m);
	$formatedD = intval($d);

	if($formatedM < 10){
		$formatedM = "0".$formatedM;
	}

	if($formatedD < 10){
		$formatedD = "0".$formatedD;
	}


	return "$formatedY-$formatedM-$formatedD";
}

?>