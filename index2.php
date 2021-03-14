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

    if( $MONTH < 10 ){ $MONTH = "0".intval($MONTH); }
    if( $DAY < 10 ){ $DAY = "0".intval($DAY); }

    require_once("function/page/index/showCalendar_list.php");
    $weekNumber_this = getWeekNumber("$YEAR-$MONTH-$DAY");
    $titleDateRange_this = getWeekNumberRange($weekNumber_this, $YEAR);

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
      <table style="">
        <tr>
          <td style="padding: 0px;">
            <table class="tableTitle-backgroundColor">
              <tr>
                <td>
                  <a href="<?php echo getWeekNumberFirstDay($weekNumber_this-2, $YEAR); ?>">
                    <span class="statisticsTitle_middle"><?php echo $weekNumber_this-2; ?><span style="font-size: 30%;"> 周</span></span>
                    <br>
                    <span class="statisticsContent_mini"><?php echo getWeekNumberRange($weekNumber_this-2, $YEAR); ?></span>
                  </a>
                </td>

                <td>
                  <a href="<?php echo getWeekNumberFirstDay($weekNumber_this-1, $YEAR); ?>">
                    <span class="statisticsTitle_middle"><?php echo $weekNumber_this-1; ?><span style="font-size: 30%;"> 周</span></span>
                    <br>
                    <span class="statisticsContent_mini"><?php echo getWeekNumberRange($weekNumber_this-1, $YEAR); ?></span>
                  </a>
                </td>

                <td class="tableTitle-backgroundColor_selected">
                  <span class="statisticsTitle_middle"><?php echo $weekNumber_this; ?><span style="font-size: 30%;"> 周</span></span>
                  <br>
                  <span class="statisticsContent_mini"><?php echo getWeekNumberRange($weekNumber_this, $YEAR); ?></span>
                </td>

                <td>
                  <a href="<?php echo getWeekNumberFirstDay($weekNumber_this+1, $YEAR); ?>">
                    <span class="statisticsTitle_middle"><?php echo $weekNumber_this+1; ?><span style="font-size: 30%;"> 周</span></span>
                    <br>
                    <span class="statisticsContent_mini"><?php echo getWeekNumberRange($weekNumber_this+1, $YEAR); ?></span>
                  </a>
                </td>

                <td>
                  <a href="<?php echo getWeekNumberFirstDay($weekNumber_this+2, $YEAR); ?>">
                    <span class="statisticsTitle_middle"><?php echo $weekNumber_this+2; ?><span style="font-size: 30%;"> 周</span></span>
                    <br>
                    <span class="statisticsContent_mini"><?php echo getWeekNumberRange($weekNumber_this+2, $YEAR); ?></span>
                  </a>
                </td>
              </tr>
            </table>
          </td>
          
          <td id="datepickerDIV" class="tableTitle-backgroundColor" style="border-left: 1.5px solid #FFF; padding: 0px; margin: 0px; text-align: center;"><i class="fas fa-calendar-alt"></i><input class="tableTitleButton-input" type="text" id="datepicker" readonly="true"></td>
        </tr>
      </table>
      

      <?php 
        require_once("function/getSalary.php");
        require_once("function/page/index/showCalendar_list.php");
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
  <script>
     $(function () {
        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "mm/dd",
            onSelect: function(dateText) { 
                var date = $(this).datepicker('getDate'),
                    day  = date.getDate(),  
                    month = date.getMonth() + 1,              
                    year =  date.getFullYear();
                window.location.href = "?y="+year+"&m="+month+"&d="+day;
            }
        }).datepicker("setDate", new Date("<?php echo "$YEAR-$MONTH-$DAY";?>"));

        $('#datepickerDIV').click(function () {
            //alert('clicked');
            $('#datepicker').datepicker('show');
        });

    });


    $(document).ready(function(){
      var element = $("#<?php echo "$YEAR-$MONTH-$DAY";?>");
      element.css('outline', 'none !important')
       .attr("tabindex", -1)
       .focus();
    })
    
  </script>
  <script type="text/javascript">

    function showInformationBox(redY, redM, redD){
      window.location.href="index_showDetail.php?y="+ redY + "&m=" + redM + "&d=" + redD;
    }

  </script>
  <script type="text/javascript">
    // document.getElementsByTagName('td').innerHTML
    var monthStatistics_salary = parseFloat(<?php echo getStatistics_salary($YEAR,$MONTH);?>);

    var monthStatistics_salary_withScheduling = sumFutureWorkTime() + parseFloat(monthStatistics_salary);
    monthStatistics_salary_withScheduling = Math.round(monthStatistics_salary_withScheduling * 100) / 100;

    

    document.getElementById("monthStatistics_salary").innerHTML = toCurrency(monthStatistics_salary) + " / " + toCurrency(monthStatistics_salary_withScheduling);
    document.getElementById("monthStatistics_workTime").innerHTML = toCurrency(getTotalWorkTime_month())+" 小時";
    document.getElementById("monthStatistics_workDay").innerHTML = <?php echo getStatistics_dayNumber_realWork($YEAR,$MONTH);?> +" / "+ <?php echo getStatistics_dayNumber_schedulingWork($YEAR,$MONTH);?> +" 天";
    document.getElementById("monthStatistics_breakDay").innerHTML = (getMonthLastDay()  - <?php echo getStatistics_dayNumber_schedulingWork($YEAR,$MONTH);?>) +" 天";

    formatFutureWorkTime();


    function sumFutureWorkTime(){
      var basicSalary = parseFloat(document.getElementById("userDefault_basicSalary").innerHTML);

      var totalTime = <?php echo getStatistics_schedulingWorkTimeMinute($YEAR,$MONTH);?>;

      return Math.round((totalTime * basicSalary / 60) * 100) / 100;

      
    }

    function getTotalWorkTime_month(){
      totalTime = <?php echo getStatistics_workTimeMinute($YEAR,$MONTH);?>;
      totalTime = totalTime / 60;

      return Math.round(totalTime * 100) / 100;
    }

    function getMonthLastDay(){
      //var date = new Date();
      var y = <?php echo $YEAR; ?>;//date.getFullYear();
      var m = <?php echo intval($MONTH)-1; ?>;//date.getMonth();
      var lastDay = new Date(y, m + 1, 0).getDate();

      return lastDay;
    }

    function toCurrency(num){
      var parts = num.toString().split('.');
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      return parts.join('.');
    }

    function formatFutureWorkTime(){
      var elems = document.getElementsByClassName("workTime");

      var totalTime = 0;
      for (i = 0; i < elems.length; i++) { 
        if(elems[i].textContent == "" || elems[i].textContent == " "){
          continue;
        }

        var one = parseInt(elems[i].textContent);
        var hr = Math.floor(one / 60);
        var min = Math.floor(one % 60);

        var str = min + " 分鐘";
        if(hr > 0){
          str = "" + hr + " 小時" + str;
        }else{
          str = "" + str;
        }

        elems[i].innerHTML = str;
      }
    }
  
  </script>
 </body>

</html>