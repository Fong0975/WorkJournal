<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>[編輯]打卡記錄 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/clock_records_edit.css">
  </head>


 <body onload="doOnLoad()">
  <?php
    require_once( "function/page/clock_records_edit/get.php" );

    if ( !isset( $_GET[ 'id' ] )) {
      header( 'Location: clock_records.php' );
      exit;
    }

    $clockID = $_GET[ 'id' ];
    $arr_data = explode("/", getRecord($clockID));


    if ( intval($arr_data[0]) == intval($_GET[ 'id' ]) ) {
      

      if ( !isset( $arr_data[ 1 ] ) or!isset( $arr_data[ 2 ] ) or!isset( $arr_data[ 3 ] ) ) {
        header( 'Location: clock_records.php?err=required_field_is_empty' );
        exit;
      }
        
      $clockDate = $arr_data[ 1 ];
      $clockTime = explode( ":", $arr_data[ 2]  );
      $clockType = mb_convert_encoding( $arr_data[ 3 ], "UTF-8" );

      $date_14ago = $date_lastMonth= date("Y-m-d", strtotime("-14 day"));

      $OVER_14_DAYS = false;
      if(strtotime($clockDate) < strtotime($date_14ago)){
        $OVER_14_DAYS = true;
      }

    } else {
      header( 'Location: clock_records.php?err=id_not_equal' );
      exit;
    }


  ?>


   <div class="mainContent">
    <div class="pageHeader">
      <table style="margin-bottom: 20px;">
        <tr>
          <td style="width: 100px;"><img src="images/assets/logo(white).png" style="width: 100px;"></td>
          <td style="text-align: left;  padding-left: 20px;"><div class="title">MOS Journal</div></td>
        </tr>
      </table>
      
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">編輯打卡記錄 Modify Records</div>
    </div>

    <div class="session card" style="margin-top: 300px;">
      <form id='form1' name="form1" action="function/page/clock_records_edit/edit.php" method="post">
        <input name="clockID" value="<?php echo $_GET['id'];?>" maxlength="10" readonly style="text-align: center; border: none; display: none;">
        <table>
          <tr>
            <td class="addCoupon_Title">日期 Date</td>
            <td style="padding-right: 50px;">
              <input class="input_underline" id="inputClock_Date" name="clockDate" type="date"  placeholder="2018-07-22" maxlength="10" style="width: 100% !important;" required>
            </td>
          </tr>
          <tr>
            <td class="addCoupon_Title">時間 Time</td>
            <td style="padding-right: 50px;">
              <table style="width: 100%; border: none;">
                <tr>
                  <td><select id="timeH" onchange="selectToInput();"></select></td>
                  <td style="width: 15px;"></td>
                  <td><select id="timeM" onchange="selectToInput();"></select></td>
                </tr>
              </table>
              <input id="inputClock_time" name="clockTime" style="display: none;">
            </td>
          </tr>
          <tr>
            <td class="addCoupon_Title">類型 Type</td>
            <td style="padding-right: 50px;"ß>
              <select id="clock_type"  name="clockType">
                <option value="上班">上班</option>
                <option value="休息開始">休息</option>
                <option value="休息結束">返回</option>
                <option value="下班">下班</option>
              </select>
            </td>
          </tr>
        </table>
        
        <div style="width: 100%; margin-top: 100px; text-align: center;<?php if($OVER_14_DAYS){echo " display: none;";}?>">
          <input type="checkbox" id="checkDelete" name="cc" onclick ="deleteCheck();" />
          <label for="checkDelete"><span></span>我確定要將這筆紀錄刪除</label><br>
          <button class="delete" id="bt_delete" type="button" disabled="true" onclick="javascript:location.href='function/page/clock_records_edit/delete.php?id=<?php echo $clockID;?>'">刪除紀錄</button>
        </div>

        <div style="width: 100%; margin-top: 20px;">
          <button class="large" type="submit">修改</button>
        </div>
      </form>
    </div>

   
   <div class="tabBar">
      <?php echo printTabbar(""); ?>
   </div>

   <script type="text/javascript">
     function deleteCheck(){
      document.getElementById('bt_delete').disabled = !document.getElementById("checkDelete").checked;
     }
   </script>

   <script type="text/javascript">
      function doOnLoad(){
        //document.getElementById("inputClock_Date").value = new Date().toISOString().substr(0, 10);
        init_Timer()

        loadData();
        selectToInput();
      }

      function init_Timer(){
        var i;
            
        for (i = 0; i < 24; i++) { 
          var x = document.getElementById("timeH");
          var option = document.createElement("option");
          var t = i;
          if(t < 10){ t = "0"+t;}

          option.text = t;
          option.value = t;
          x.add(option);
        }

        for (i = 0; i < 60; i++) { 
          var x = document.getElementById("timeM");
          var option = document.createElement("option");
          var t = i;
        
          if(t < 10){ t = "0"+t;}

          option.text = t;
          option.value = t;
          x.add(option);
        }
      }

      function loadData(){
        document.getElementById("inputClock_Date").value = '<?php echo $clockDate; ?>';

        document.getElementById("timeH").selectedIndex = <?php echo $clockTime[0]; ?>;
        document.getElementById("timeM").selectedIndex = <?php echo $clockTime[1]; ?>;

        document.getElementById("clock_type").selectedIndex = <?php 
          switch ($clockType) {
          case "上班":
              echo "0";
              break;
          case "休息開始":
              echo "1";
              break;
          case "休息結束":
              echo "2";
              break;
          case "下班":
              echo "3";
              break;
          }
        ?>;

      }

      function selectToInput(){
         //inputClock_time
        document.getElementById("inputClock_time").value = document.getElementById("timeH").value + ":" + document.getElementById("timeM").value;
      }
    </script>

 </body>
</html>