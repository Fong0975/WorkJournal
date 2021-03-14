 <?php
  require_once('function/frame/showFrame.php');
  require_once('function/page/scheduling/get.php');
  require_once "function/page/scheduling_week/get.php";
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新增週排班 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/scheduling.css">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <style type="text/css">
      td{
        padding: 5px 10px;
        text-align: center;
      }

      input{
        text-align: center;
      }

      .weekScheduling_time{
        display: inline-block;
        /*width: auto;*/
      }

      .weekScheduling_station_button{
        cursor: pointer;

      }

    </style>
  </head>

 <body onload="document.getElementById('weekScheduling_time_start_1').focus();">
  <?php
    

    date_default_timezone_set('Asia/Taipei');
    $todayDate = date("Y-m-d");
    $emptyMonday = "";

    //get Monday
    $i = 0;
    do{

      $index = $i * 7;
      $testingDate = date('Y-m-d', strtotime($todayDate . ' +'.$index.' day'));
      $Monday = date('Y-m-d', strtotime('last Monday', strtotime($testingDate)));

      if(isExistScheduling_byDate("function/", $Monday) == 0){
        $emptyMonday = $Monday;
        break;
      }else{
        $i++;
      }

    } while ( 1 );
    

    $Tuesday = date('Y-m-d', strtotime($Monday . ' +1 day'));
    $Wednesday = date('Y-m-d', strtotime($Monday . ' +2 day'));
    $Thursday = date('Y-m-d', strtotime($Monday . ' +3 day'));
    $Friday = date('Y-m-d', strtotime($Monday . ' +4 day'));
    $Saturday = date('Y-m-d', strtotime($Monday . ' +5 day'));
    $Sunday = date('Y-m-d', strtotime($Monday . ' +6 day'));
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
      <div class="subTitle">新增排班 Add Scheduling</div>
    </div>
    
    <div class="session transparent" style="margin-top: 100px; ">
      <form id='form1' name="form1" action="function/page/scheduling_week/insert.php" method="post" enctype="multipart/form-data">
        <table>
          <tr>
            <td><input class="dark" type="date" name="weekScheduling_date[]" value="<?php echo $Monday; ?>"  readonly="readonly" unselectable="on" οnfοcus="this.blur()"></td>
            <td style="white-space: nowrap;">星期一</td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_start_1" name="weekScheduling_time_start[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_end_1" name="weekScheduling_time_end[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
          </tr>
        </table>
        <div style="padding: 10px 50px; margin: 0px 0px 20px 0px;">
          <?php showStation(0);?>
        </div>
        

        <table>
          <tr>
            <td><input class="dark" type="date" name="weekScheduling_date[]" value="<?php echo $Tuesday; ?>"  readonly="readonly" unselectable="on" οnfοcus="this.blur()"></td>
            <td style="white-space: nowrap;">星期二</td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_start_2" name="weekScheduling_time_start[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_end_2" name="weekScheduling_time_end[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
          </tr>
        </table>
        <div style="padding: 10px 50px; margin: 0px 0px 20px 0px;">
          <?php showStation(1);?>
        </div>

        <table>
          <tr>
            <td><input class="dark" type="date" name="weekScheduling_date[]" value="<?php echo $Wednesday; ?>"  readonly="readonly" unselectable="on" οnfοcus="this.blur()"></td>
            <td style="white-space: nowrap;">星期三</td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_start_3" name="weekScheduling_time_start[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_end_3" name="weekScheduling_time_end[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
          </tr>
        </table>
        <div style="padding: 10px 50px; margin: 0px 0px 20px 0px;">
          <?php showStation(2);?>
        </div>

        <table>
          <tr>
            <td><input class="dark" type="date" name="weekScheduling_date[]" value="<?php echo $Thursday; ?>"  readonly="readonly" unselectable="on" οnfοcus="this.blur()"></td>
            <td style="white-space: nowrap;">星期四</td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_start_4" name="weekScheduling_time_start[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_end_4" name="weekScheduling_time_end[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
          </tr>
        </table>
        <div style="padding: 10px 50px; margin: 0px 0px 20px 0px;">
          <?php showStation(3);?>
        </div>

        <table>
          <tr>
            <td><input class="dark" type="date" name="weekScheduling_date[]" value="<?php echo $Friday; ?>"  readonly="readonly" unselectable="on" οnfοcus="this.blur()"></td>
            <td style="white-space: nowrap;">星期五</td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_start_5" name="weekScheduling_time_start[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_end_5" name="weekScheduling_time_end[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
          </tr>
        </table>
        <div style="padding: 10px 50px; margin: 0px 0px 20px 0px;">
          <?php showStation(4);?>
        </div>

        <table>
          <tr>
            <td><input class="dark" type="date" name="weekScheduling_date[]" value="<?php echo $Saturday; ?>"  readonly="readonly" unselectable="on" οnfοcus="this.blur()"></td>
            <td style="white-space: nowrap;">星期六</td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_start_6" name="weekScheduling_time_start[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_end_6" name="weekScheduling_time_end[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
          </tr>
        </table>
        <div style="padding: 10px 50px; margin: 0px 0px 20px 0px;">
          <?php showStation(5);?>
        </div>

        <table>
          <tr>
            <td><input class="dark" type="date" name="weekScheduling_date[]" value="<?php echo $Sunday; ?>"  readonly="readonly" unselectable="on" οnfοcus="this.blur()"></td>
            <td style="white-space: nowrap;">星期日</td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_start_7" name="weekScheduling_time_start[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
            <td><input class="dark weekScheduling_time" type="number" id="weekScheduling_time_end_7" name="weekScheduling_time_end[]" value="0000" onfocus="this.select();" onkeypress="return inputKeyPress(event, this.id);"></td>
          </tr>
        </table>
        <div style="padding: 10px 50px; margin: 0px 0px 20px 0px;">
          <?php showStation(6);?>
        </div>

        <!-- <div style="width: 100%; margin-top: 20px;">
          <input class="col_upload" name="schedulingFile[]" type="file" accept="image/*" style="border-bottom: none;" onkeypress="nextIndex(event);" multiple>
        </div> -->

        
        <div style="width: 100%; margin-top: 100px;">
          <button class="large fontColor_white" type="submit" tabindex="14">新增</button>
        </div>
        <div style="width: 100%; margin-top: 20px;">
          <button class="large cancel fontColor_white" type="button" onclick="javascript:location.href='index.php'">返回</button>
        </div>
      </form>
    </div>
    

   
   <div class="tabBar">
      <?php echo printTabbar(""); ?>
   </div>


   
   <script type="text/javascript">
     function switchHoliday(){
      var isHoliday = document.getElementById("schedulingHoliday").checked;
      if(isHoliday){
        document.getElementById("row_startWork").style.display = "none";
        document.getElementById("row_endWork").style.display = "none";
        document.getElementById("row_station").style.display = "none";
      }else{
        document.getElementById("row_startWork").style.display = "";
        document.getElementById("row_endWork").style.display = "";
        document.getElementById("row_station").style.display = "";
      }
     }
   </script>

  <script type="text/javascript">
     function inputKeyPress(event, id){
      var id_elements = id.split("_");
      //alert(id_elements[2]);
      var keyCode_ascii = event.which || event.keyCode;
      //alert(id_elements[2] + "\n" + id_elements[3] + "\n" + keyCode_ascii);

      var newType = "start";
      var newNum = parseInt(id_elements[3]);
      if(id_elements[2] == "start"){
        newType = "end";
      }else{
        newNum += 1;
      }
      

      if(keyCode_ascii == 13){
        //alert("click enter");
        document.getElementById("weekScheduling_time_" + newType + "_" + newNum).focus();
        return false;
      }else if(keyCode_ascii == 9){
        alert("click tab");
        return false;
      }else{
        var strInput = document.getElementById("weekScheduling_time_" + id_elements[2] + "_" + id_elements[3]).value;
        if(strInput.length == 3){
          strInput += String.fromCharCode(keyCode_ascii);
          var strHours = parseInt(strInput.substring(0,2));
          var strMin = parseInt(strInput.substring(2,4));
          
          if(strHours >= 0 && strHours <= 23 && strMin >= 0 && strMin <= 59){
            document.getElementById("weekScheduling_time_" + id_elements[2] + "_" + id_elements[3]).value =strInput;
            try {
              document.getElementById("weekScheduling_time_" + newType + "_" + newNum).focus(); 
            }
            catch (e) {
            }
            return false;
          }else{
            document.getElementById("weekScheduling_time_" + id_elements[2] + "_" + id_elements[3]).value ="";
            document.getElementById("weekScheduling_time_" + id_elements[2] + "_" + id_elements[3]).focus();
            return false;
          }
          
        }
      }
            
     }
  </script>

  <script>
    $(".weekScheduling_station_button").click(function (event) {
      var index = event.target.id.split("_")[3];
      // alert(index);

      if ( $( "#weekScheduling_station_area_" + index ).first().is( ":hidden" ) ) {
        $('#' + event.target.id).text("▲隱藏預排崗位");
        $( "#weekScheduling_station_area_" + index ).slideDown( "slow" );
      } else {
        $('#' + event.target.id).text("▼顯示預排崗位");
        $( "#weekScheduling_station_area_" + index ).hide();
      }
    });
  </script>

  </body>
</html>