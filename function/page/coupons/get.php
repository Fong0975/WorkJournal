<?php

function getAll(){
	require_once("function/getData.php");

	$strData = getData_String("*", "qrcode", "1", "ORDER BY qr_used,qr_date");
	$arrDataRow=explode('@br@',$strData);
	for($i = 0; $i<count($arrDataRow);$i++){
		$arrDataRow[$i] = explode('/', $arrDataRow[$i]);
	}
		
	$str = "";

	for($i = 0; $i < count($arrDataRow); $i++){

    $disableStatus = getDisableStatus($arrDataRow[$i][4], $arrDataRow[$i][3]);

		$str .= "<div class='session couponGroup'>
      <table style='border: none; border-collapse:collapse;'>
        <tr class='ticket_HF".(( $disableStatus == 0) ? "":"_disable")."'>
          <td class='ticket_mainColumn topTitle'>摩斯漢堡優惠券 MOS Burger Coupon</td>
          <td class='ticket_subColumn'><button type='button' style='margin: 0px; padding:0px; background-color: transparent; width:100%; text-align: right; padding-right:15px;' onclick=\"deleteCoupon('".$arrDataRow[$i][2]."')\">刪除</button></td>
        </tr>
        <tr class='ticket_content'>
          <td class='ticket_mainColumn'>
            <div class='title'>".$arrDataRow[$i][1]."</div>
            <div id='serial_$i' class='serial'>".$arrDataRow[$i][2]."</div>
            <div class='timeline'>使用期限：".$arrDataRow[$i][3]."</div>
          </td>
          <td class='ticket_subColumn'>
            <div>使用狀態：</div>
            <div style='width: 100%; text-align: center; vertical-align:middle; margin-top: 20px; '>
            	<div id='qr_$i' data_serial='".$arrDataRow[$i][2]."' style='width:100px height:100px;".(($disableStatus == 0) ? "":"display: none;")."'></div>
            	<img id='used_$i' src='images/assets/".(($disableStatus == 2)? "icon_timeout":"icon_used").".png' width='90%' style=' margin: auto; ".(($disableStatus == 0) ? "display : none":"")."'>
            </div>
            <div style='width: 100%; text-align: center;'>
              <button type='button' style='background-color: #c73030; margin-top:20px;' onclick=\"location.href='function/page/coupons/set_used.php?serial=".$arrDataRow[$i][2]."'\">".(( $arrDataRow[$i][4] == 0) ? "已":"未")."使用</button>
            </div>
          </td>
        </tr>
        <tr class='ticket_HF".(( $disableStatus == 0) ? "":"_disable")."'>
          <td class='ticket_mainColumn'></td>
          <td class='ticket_subColumn'>
            
          </td>
        </tr>
      </table>
    </div>";

			
	}

	

	echo $str; 
}

function getQR_Array(){
	require_once("function/getData.php");
	$qr_data = explode("@br@",getData_String("qr_code", "qrcode", "1", "ORDER BY qr_date"));
	
	
	return $qr_data;
}

function getDisableStatus($usedMark, $timeline){
  if(isDatePassed($timeline) == true){
    return 2;
  }elseif(isUsed($usedMark) == true){
    return 1;
  }else{
    return 0;
  }
}

function isUsed($used){
  if($used == 0){
    return false;
  }

  return true; 
}

function isDatePassed($thdDate){
  $date = new DateTime($thdDate);
  $now = new DateTime();

  if($date < $now) {
      return true;
  }

  return false;
}


?>