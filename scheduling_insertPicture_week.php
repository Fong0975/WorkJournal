 <?php
  require_once('function/frame/showFrame.php');
  require_once('function/page/scheduling/get.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>上傳預排班表 - MOS Journal</title>
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

 <body>
  <?php
    
    date_default_timezone_set("Asia/Taipei");
    if(!isset($_GET['y']) or !isset($_GET['m']) or !isset($_GET['d']) ){
      $YEAR = date("Y");
      $MONTH = date("m");
      $DAY = date("d");
    }else{
      $YEAR = intval($_GET['y']);
      $MONTH = intval($_GET['m']);
      $DAY = intval($_GET['d']);
      if( $MONTH < 10 ){ $MONTH = "0".intval($MONTH); }
      if( $DAY < 10 ){ $DAY = "0".intval($DAY); }
    }

    $today = "$YEAR-$MONTH-$DAY";
    $weeklist = array('日', '一', '二', '三', '四', '五', '六');
    $weekday  = $weeklist[date('w', strtotime($today))];

    $isExistPicture = ture;
    if(strlen(isExistSchedulingImage("images/scheduling/",$today)) == 0){
      $isExistPicture = false;
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
      <div class="subTitle">上傳預排班表 <span style="white-space: pre;">Upload Scheduling</span></div>
    </div>
    
    <div class="session transparent" style="margin-top: 100px; ">
      <form id='form1' name="form1" action="function/page/scheduling_picture/insert.php" method="post" enctype="multipart/form-data">

        <table>
          <tr>
            <td>
              <input class="dark" type="date" name="weekScheduling_date" value="<?php echo $today; ?>"  onchange="changeDate(event);">
            </td>
            <td style="white-space: nowrap;">星期<?php echo $weekday; ?></td>
          </tr>
          <tr>
            <td colspan="2" style="padding: 50px 5px;">
              <input class="col_upload" name="schedulingFile" type="file" accept="image/*" style="border-bottom: none;">
            </td>
          </tr>
        </table>

        
        <div style="width: 100%; margin-top: 100px;">
          <button class="large fontColor_white" type="submit" tabindex="14"<?php if($isExistPicture == ture){echo " disabled";} ?>><?php if($isExistPicture == ture){echo "檔案已存在";}else{echo "新增";} ?></button>
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
     function changeDate(e){
      var dateElements = e.target.value.split("-");
      this.window.location = "scheduling_insertPicture_week.php?y=" + dateElements[0] + "&m=" + dateElements[1] +"&d="+ dateElements[2];
    }
   </script>

  </body>
</html>