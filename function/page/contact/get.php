<?php
	function getAll(){
		require_once("function/getData.php");

		$strData = getData_String("*", "contact", "1", "ORDER BY contact_group, contact_number");
		$arrDataRow=explode('@br@',$strData);
		for($i = 0; $i<count($arrDataRow);$i++){
			$arrDataRow[$i] = explode('/', $arrDataRow[$i]);
		}
		$str = "";

		for($i = 0; $i<count($arrDataRow);$i++){
			$str .= "    <div class='session contactGroup";
			if($arrDataRow[$i][6] == 0){
				$str .= " leave";
			}

			$str .= "' style='text-align: center; padding-right: 20px;'>
      <table>
        <tr>
          <td class='picture'><img src='images/assets/contact/".$arrDataRow[$i][5]."'></td>
          <td class='content'>
            <div class='jobTitle'>".mb_substr($arrDataRow[$i][1],3)."</div>
            <div class='name'>".intval($arrDataRow[$i][2])." ".$arrDataRow[$i][3]."</div>
            <div class='phone'>".formatPhone($arrDataRow[$i][4])."</div>
          </td>
          ";
        if($arrDataRow[$i][6] != 0){
          $str .="<td class='qr'><a href='qr_identification.php?num=".intval($arrDataRow[$i][2])."'><i class='fas fa-qrcode'></i></a></td>";
      	}
          $str .="<td class='call'><a href='tel:".$arrDataRow[$i][4]."'><i class='fas fa-phone-alt'></i></a></td>
        </tr>
      </table>
    </div>";
		}

		

		echo $str; 
	}

	function formatPhone($phone){
		mb_internal_encoding("UTF-8");
		return mb_substr($phone, 0,4)."-".mb_substr($phone, 4,3)."-".mb_substr($phone, 7,3);
	}
?>