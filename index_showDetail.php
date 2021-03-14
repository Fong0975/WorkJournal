<?php
  require_once('function/frame/showFrame.php');
  require_once('function/page/index/get_journal.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>摩斯漢堡工作紀錄 MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <style type="text/css">
      .note{
        font-size: 12pt;

        margin-top: 20px;
        padding-left: 20px;
      }
    </style>
  </head>

 <body>
  <?php
    if(!isset($_GET['y']) or !isset($_GET['m']) or !isset($_GET['d']) ){
      $YEAR = date("Y");
      $MONTH = date("m");
      $DAY = date("d");
    }else{
      $YEAR = intval($_GET['y']);
      $MONTH = intval($_GET['m']);
      $DAY = intval($_GET['d']);
    }

    if( $MONTH < 10 ){ $MONTH = "0".$MONTH; }
    if( $DAY < 10 ){ $DAY = "0".$DAY; }

    $WEEKDAY = ['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime("$YEAR-$MONTH-$DAY"))];


    $date = "$YEAR-$MONTH-$DAY";
    $prev_date_y = date('Y', strtotime($date .' -1 day'));
    $prev_date_m = date('m', strtotime($date .' -1 day'));
    $prev_date_d = date('d', strtotime($date .' -1 day'));
    $next_date_y = date('Y', strtotime($date .' +1 day'));
    $next_date_m = date('m', strtotime($date .' +1 day'));
    $next_date_d = date('d', strtotime($date .' +1 day'));
  ?>

  <div class="mainContent">
    <div class="pageHeader" style="text-align: center;">
      <img src="images/assets/logo_with_title.png" style="height: 200px;">
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">工作紀錄 Work Journal</div>
    </div>
    
    

   <div id="informationBox" class="informationBox">
     <div class="informationBox_header">
        <table>
           <tr>
             <td id="timer_date" class="header_title" colspan="2"><?php echo "$YEAR-$MONTH-$DAY ($WEEKDAY)"; ?></td>
             <td class="header_edit"><a href="#" onclick="closeInformationBox();">x 關閉</a></td>
           </tr>
           <tr>
             <td style="text-align: left;padding-top: 20px; width: 33%"><a href="index_showDetail.php<?php echo "?y=$prev_date_y&m=$prev_date_m&d=$prev_date_d"; ?>">< 前一日 Previous</a></td>
             <td style="text-align: center;padding-top: 20px;"><a href="#" onclick="goToDate();">指定日期</a></td>
             <td style="text-align: right;padding-top: 20px; width: 33%"><a href="index_showDetail.php<?php echo "?y=$next_date_y&m=$next_date_m&d=$next_date_d"; ?>">下一日 Next ></a></td>
           </tr>
         </table>
     </div>

     <?php require_once("function/page/index/informationBox.php"); ?>

     <!-- 預定排班 -->
     <div class="informationBox_session">
       <div>
         <table>
           <tr>
             <td class="header_title">預定排班</td>
             <td class="header_edit">
              <?php
                if(isScheduled("function/page/index/", "$YEAR-$MONTH-$DAY")){
                  echo "<a href=\"scheduling_edit.php?date=$YEAR-$MONTH-$DAY\">[ 編輯 ]</a>";
                }else{
                  echo "<a href=\"scheduling_insert.php?date=$YEAR-$MONTH-$DAY\">[ 新增 ]</a>";
                }
              ?>
             </td>
           </tr>
         </table>
       </div>

       <div class="content">
         <?php echo getInformationContent_scheduling("function/page/index/", "$YEAR-$MONTH-$DAY"); ?>
       </div>
     </div>

     <!-- 工作總覽 -->
     <div class="informationBox_session">
       <div>
         <table>
           <tr>
             <td class="header_title">工作總覽</td>
             <td class="header_edit"><a href="<?php echo "clock_records.php?y=$YEAR&m=$MONTH&d=$DAY"?>">[ 打卡紀錄 ]</a></td>
           </tr>
         </table>
       </div>

       <div class="content">
         <?php echo getInformationContent_clock("function/page/index/", "$YEAR-$MONTH-$DAY"); ?>
       </div>
     </div>

     <!-- 工作日誌 -->
     <div class="informationBox_session">
       <div>
         <table>
           <tr>
             <td class="header_title">工作日誌</td>
             <td class="header_edit"><a href="index_showDetail_editJournal.php?date=<?php echo "$YEAR-$MONTH-$DAY"; ?>"<?php if(isExistJournal("$YEAR-$MONTH-$DAY") == "false"){ echo "style=\"display: none;\""; } ?>>[ 編輯 ]</a></td>
           </tr>
         </table>
       </div>

       <div class="content">
         <?php echo getInformationContent_journal("function/page/index/", "$YEAR-$MONTH-$DAY"); ?>
         <div class="note">
          <i class="fas fa-exclamation"></i>需已經紀錄了當天的上班卡，方可編輯當天的工作日誌項目。
          <!-- <br><i class="fas fa-exclamation"></i>僅完成單一比率的休假日津貼計算。 -->
        </div>
       </div>
     </div>

     <!-- 工作工具 -->
     <div class="informationBox_session">
       <div>
         <table>
           <tr>
             <td class="header_title">工作工具</td>
             <td class="header_edit"></td>
           </tr>
         </table>
       </div>

       <div class="content">
         <table>
           <tr>
             <td class="content_title"><i class="fas fa-hourglass-half"></i>下班倒數</td>
             <td id="demo" class="content_value"></td>
           </tr>
         </table>
       </div>
     </div>

     <div style="margin-top: 30px;">
      <button class="large transparent back_white" type="button" onclick="location.href='<?php echo "clock_records.php?y=$YEAR&m=$MONTH&d=$DAY"?>';">打卡紀錄</button>
      <button class="large transparent back_white" type="button" onclick="go_weekScheduling();">週排班表</button
     </div>

     <div style="height: 200px;"></div>

   </div>


  
   <script src="script/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script type="text/javascript">
    function closeInformationBox(){
      let urlParams = new URLSearchParams(window.location.search);
      var queryString = urlParams.toString();
      window.location.href="index.php?"+ queryString;
    }

    function go_weekScheduling(){
      let urlParams = new URLSearchParams(window.location.search);
      var queryString = urlParams.toString();
      window.location.href="index_showDetail_weekScheduling.php?"+ queryString;
    }
  </script>
  <script type="text/javascript">
    var dateline_date = document.getElementById("timer_date").innerHTML.split(" ")[0].replace("-", "/");
    dateline_date = dateline_date.replace("-", "/");
    var dateline_time = document.getElementById("timer_time").innerHTML.split("～")[1].substring(0, 5);
    var countDownDate = new Date(dateline_date + " " + dateline_time).getTime();
    // alert(dateline_date + " " + dateline_time);

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      if(distance > 86400000){
        clearInterval(x);
        // document.getElementById("demo").innerHTML = days + " 天 " + hours + " 時 "
      + minutes + " 分 " + seconds + " 秒";
        document.getElementById("demo").innerHTML = document.getElementById("timer_schedulingTime").innerHTML;
      }else{
        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML = hours + " 時 "
      + minutes + " 分 " + seconds + " 秒";

        // If the count down is finished, write some text
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("demo").innerHTML = "00 時 00 分 00 秒";
        }
      }

      
    }, 1000);
  </script>
  <script type="text/javascript">
    function goToDate(){
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = today.getFullYear();

      var result = prompt("請選擇欲轉跳的日期", yyyy+"/"+mm+"/"+dd);

      var dateArray = result.split('/');
      window.location.href = 'index_showDetail.php?y='+ dateArray[0] + '&m='+ dateArray[1] + '&d='+ dateArray[2];

    }
  </script>
 </body>

</html>