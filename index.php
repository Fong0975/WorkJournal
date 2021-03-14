<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>摩斯漢堡工作紀錄 MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/assets/icon/touch-icon-iphone.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="images/assets/icon/touch-icon-iphone-retina.png" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
  </head>

 <body>
  <?php

    // =============  Get QueryString Date =============
    date_default_timezone_set("Asia/Taipei");
    if(!isset($_GET['y']) or !isset($_GET['m']) or !isset($_GET['d']) ){
      $YEAR = date("Y");
      $MONTH = date("m");
      $DAY = date("d");
    }else{
      $YEAR = intval($_GET['y']);
      $MONTH = intval($_GET['m']);
      $DAY = intval($_GET['d']);
    }

    require_once("function/page/index/getFrame.php");
    $isShowCalendar = intval(getDisplayMode("function/"));

    if($isShowCalendar == 1){
      // =============  Setting Relative Value of Full-Calendar =============
      //previous
      $previousM = $MONTH - 1;
      if($previousM == 0){
        $previousM = 12;
        $previousY = $YEAR-1;
      }else{
        $previousY = $YEAR;
      }

      //next
      $nextM = $MONTH + 1;
      if($nextM == 13){
        $nextM = 1;
        $nextY = $YEAR+1;
      }else{
        $nextY = $YEAR;
      }

      if( $MONTH < 10 ){ $MONTH = "0".intval($MONTH); }
      if( $DAY < 10 ){ $DAY = "0".intval($DAY); }
      if( $previousM < 10 ){ $previousM = "0".intval($previousM); }
      if( $nextM < 10 ){ $nextM = "0".intval($nextM); }
    }else{
      // =============  Setting Relative Value of Simple-Calendar =============
      if( $MONTH < 10 ){ $MONTH = "0".intval($MONTH); }
      if( $DAY < 10 ){ $DAY = "0".intval($DAY); }

      require_once("function/page/index/showCalendar_list.php");
      $weekNumber_this = getWeekNumber("$YEAR-$MONTH-$DAY");
      $titleDateRange_this = getWeekNumberRange($weekNumber_this, $YEAR);
    }
    
    
  ?>

  <div class="mainContent" >
    <div class="pageHeader" style="text-align: center;">
      <img src="images/assets/logo_with_title.png" style="height: 200px;">
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">工作紀錄 Work Journal</div>
    </div>
    
    <div class="session transparent bordered" style="margin: auto 0px;">
      <table class="statistics">
        <tr>
          <td colspan="2" class="statisticsTitle_large"><i class="fas fa-hand-holding-usd"></i>本月薪資</td>
          <td colspan="1" class="statisticsContent_large">新台幣</td>
          <td id="monthStatistics_salary" colspan="2" class="statisticsContent_large" style="text-align: center;">0</td>
          <td colspan="1" class="statisticsContent_large" style="text-align: center;">元</td>
        </tr>
        <tr><td colspan="6"  class="bordered"></td></tr>
        <tr>
          <td class="statisticsTitle_small"><i class="fas fa-clock"></i>工時</td>
          <td id="monthStatistics_workTime" class="statisticsContent_small">0 hr</td>
          <td class="statisticsTitle_small"><i class="fas fa-briefcase"></i>工作</td>
          <td id="monthStatistics_workDay" class="statisticsContent_small">0 天</td>
          <td class="statisticsTitle_small"><i class="fas fa-bed"></i>休息</td>
          <td id="monthStatistics_breakDay" class="statisticsContent_small">0 天</td>
        </tr>
      </table>
    </div>


    <div class="session">
      
      <?php 
        if($isShowCalendar == 1){
          // =============  Show Header of Full-Calendar =============
          require_once("function/page/index/showCalendar.php");
          showFrame_Header($previousY, $previousM, $YEAR, $MONTH, $nextY, $nextM);
        }else{
          // =============  Show Header of Simple-Calendar =============
          require_once("function/page/index/showCalendar_list.php");
          showFrame_Header($weekNumber_this, $YEAR);
        }
        
      ?>


      <?php 
        require_once("function/getSalary.php");
        echo showCanendar($YEAR,$MONTH,$DAY);
        echo "<span id=\"userDefault_basicSalary\" style=\"display:none;\">".getHourBasicSalary("function/")."</span>";
      ?>

      <hr style="width: 100%;">
      <div style="text-align: center; margin: 30px 0px 30px 0px;">
        <a href="clock_records.php" style="color: #db1a34; text-decoration: none; font-size: 25pt; font-weight: bolder;">打卡記錄</a>
      </div>
      <hr>
      <div style="text-align: center; margin: 30px 0px 10px 0px;">
        <a href="shortcut_schedulingPicture.php" style="color: #db1a34; text-decoration: none; font-size: 25pt; font-weight: bolder;">檢視班表</a>
      </div>
    </div>


    <div class="session otherFunction"  style="margin-bottom: 150px; padding: 0px;" >
      <div class="header">
        <dir class="title">週排班表</dir>
        <dir class="subscript">新增、查詢週排班的紀錄</dir>
      </div>
      <div class="button">
        <a href="scheduling_insert_week.php" style="color: #db1a34; text-decoration: none; font-size: 25pt; font-weight: bolder;"><i class="fas fa-pen"></i>新增排班</a>
      </div>
      <hr>
      <div class="button">
        <a href="scheduling_insertPicture_week.php" style="color: #db1a34; text-decoration: none; font-size: 25pt; font-weight: bolder;"><i class="fas fa-cloud-upload-alt"></i>上傳班表</a>
      </div>
      <hr>
      <div class="button">
        <a href="index_showDetail_weekScheduling.php?<?php echo "y=$YEAR&m=$MONTH&d=$DAY"; ?>" style="color: #db1a34; text-decoration: none; font-size: 25pt; font-weight: bolder;"><i class="fas fa-search"></i>檢視排班</a>
      </div>
    </div>

  </div>



   
   <div class="tabBar">
      <?php echo printTabbar($TABITEM_OUTLINE); ?>
   </div>

   

   <div id="dialog" class="clockOptionPanel" title="使用優惠券" style="text-align: center; display: none;">
    <button class="btDarkRed" onclick="javascript:location.href='function/shortcut/clockIn.php?type=上班'">上班</button>
    <button class="btLightRed" onclick="javascript:location.href='function/shortcut/clockIn.php?type=休息開始'">休息</button>
    <button class="btLightRed" onclick="javascript:location.href='function/shortcut/clockIn.php?type=休息結束'">返回</button>
    <button class="btDarkRed" onclick="javascript:location.href='function/shortcut/clockIn.php?type=下班'">下班</button>
    <button id="btCancel" class="btCancel">取消</button>
  </div>

  <a id="newCoupon" href="#" class="float">
    <i class="my-float fas fa-bell"></i>
  </a>

   <script src="script/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script>
    $( "#newCoupon" ).click(function() {
      $( "#dialog" ).dialog({
                title: "上班打卡",
                resizable: true,
                draggable: false,
                width: "650px",
                modal: true
              });
    });

    $( "#btCancel" ).click(function() {
      $( "#dialog" ).dialog( "close" );
    });
  </script>


  <?php
    if($isShowCalendar == 1){
      // =============  Show JS of Full-Calendar =============
      showFrame_JS($YEAR, $MONTH);
    }else{
      // =============  Show JS of Simple-Calendar =============
      showFrame_JS($YEAR, $MONTH, $DAY);
    } 
  ?>
  
 </body>

</html>