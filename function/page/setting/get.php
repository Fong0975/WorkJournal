<?php
	function getSettingItem(){
		require_once("function/getData.php");

		$strData = getData_String("*", "userdefault", "1", "ORDER BY ud_group, ud_id");
		$arrDataRow=explode('@br@',$strData);
		for($i = 0; $i<count($arrDataRow);$i++){
			$arrDataRow[$i] = explode('/', $arrDataRow[$i]);
		}
		$str = "";

		for($i = 0; $i < count($arrDataRow); $i++){
			mb_internal_encoding("UTF-8");

			if($i == 0){
				$str .= "
	<div class='session settingGroup' style='text-align: center;'>
      <div class='title'>".mb_substr($arrDataRow[$i][1], strpos($arrDataRow[$i][1],".")+1)."</div>
";
			}elseif($arrDataRow[$i][1] != $arrDataRow[$i-1][1]){
				$str .= "
	<div class='session settingGroup' style='text-align: center;'>
      <div class='title'>".mb_substr($arrDataRow[$i][1], strpos($arrDataRow[$i][1],".")+1)."</div>
";
			}


			$str .="
      <div class='item'>
        <table";

        	if($arrDataRow[$i][6] == 0){
        		$str .= " id='setting_".($i+1)."'";
        	}


        	$str .= ">
          <tr>
            <td class='title'><i class='".$arrDataRow[$i][5]."'></i>".$arrDataRow[$i][2]."</td>
            <td class='content'>".$arrDataRow[$i][4];

        	if($arrDataRow[$i][6] == 0){
        		$str .= "<i class='fas fa-caret-right'></i>";
        	}


        	$str .= "</td>
          </tr>
        </table>
      </div>
";

			if($i == count($arrDataRow)-1){
				$str .="
    </div>
		";
			}elseif($arrDataRow[$i][1] != $arrDataRow[$i+1][1]){
				$str .="
    </div>
		";
			}

			
		}

		

		

		echo $str; 
	}

	function getSetting_BasicSalary(){
		require_once("../../getData.php");

		$strData = getData_String("ud_value", "userdefault", "ud_title = '基本薪資'", "");
		$arrDataRow=explode('@br@',$strData);

		return floatval ($arrDataRow[0]);
	}

?>