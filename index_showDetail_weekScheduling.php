<?php
  require_once('function/frame/showFrame.php');
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
    $prev_date_y = date('Y', strtotime($date .' -7 day'));
    $prev_date_m = date('m', strtotime($date .' -7 day'));
    $prev_date_d = date('d', strtotime($date .' -7 day'));
    $next_date_y = date('Y', strtotime($date .' +7 day'));
    $next_date_m = date('m', strtotime($date .' +7 day'));
    $next_date_d = date('d', strtotime($date .' +7 day'));
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
             <td class="header_title"><?php echo "$YEAR-$MONTH-$DAY ($WEEKDAY)"; ?></td>
             <td class="header_edit"><a href="#" onclick="closeInformationBox();">x 關閉</a></td>
           </tr>
         </table>
     </div>

     <!-- 當週排班 -->
     <div class="informationBox_session">
       <div>
         <table>
           <tr>
             <td class="header_title">當週排班</td>
             <td class="header_edit"></td>
           </tr>
         </table>
         <table style="margin-top: 20px;">
           <tr>
             <td style="text-align: left;"><a href="index_showDetail_weekScheduling.php<?php echo "?y=$prev_date_y&m=$prev_date_m&d=$prev_date_d"; ?>">< 前一週 Previous</a></td>
             <td style="text-align: right;"><a href="index_showDetail_weekScheduling.php<?php echo "?y=$next_date_y&m=$next_date_m&d=$next_date_d"; ?>">下一週 Next ></a></td>
           </tr>
         </table>
       </div>

       <?php require_once('function/page/scheduling/get.php'); ?>
       <div class="content" style="padding-left: 50px;">
         <?php echo getWeekScheduling_show("function/page/index/",$YEAR,$MONTH,$DAY); ?>
       </div>
       <textarea cols="50" rows="5" id="weekScheduling" style="display: none;"><?php
            $text =  str_replace("<br>","", getWeekScheduling_copy("function/page/index/",$YEAR,$MONTH,$DAY));
            echo substr($text, 0, strlen($text)-1) ;
          ?></textarea>

       <div style="margin-top: 30px; text-align: center;">
        <!-- <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent transparent back_white" type="button" onclick="location.href = '<?php //echo 'download_csv.php?y='.$YEAR.'&m='.$MONTH.'&d='.$DAY;?>';">下載CSV檔</button> -->
        <!-- <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent transparent back_white" type="button" onclick="window.open('https://calendar.google.com/calendar/u/0/r/settings/export','_blank');">Google日曆</button> -->
        <a href="<?php echo 'download_csv.php?y='.$YEAR.'&m='.$MONTH.'&d='.$DAY;?>" style="margin-left:15px; color: #4c4c4c;">下載CSV檔</a>
        <a href="https://calendar.google.com/calendar/u/0/r/settings/export" style="margin-left:15px; color: #4c4c4c;">Google日曆</a>
       </div>
       
       <div style="margin-top: 30px; text-align: center;"><button class="btn mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent transparent back_white" type="button">複製到剪貼簿</button></div>
     </div>

     

     <div style="margin-top: 30px;"><button class="large transparent back_white" type="button" onclick="goback_detail();">返回</button></div>
     <div style="height: 200px;"></div>

   </div>


  
   <script src="script/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script src="script/clipboard.min.js"></script>
  <script>
      var clipboard = new ClipboardJS('.btn', {
          text: function() {
            var e=document.getElementById('weekScheduling')
            alert('複製成功 success!')
              return e.value;
          }
      });

      clipboard.on('success', function(e) {
          console.log(e);
      });

      clipboard.on('error', function(e) {
          console.log(e);
      });
    </script>
   <script type="text/javascript">
    function closeInformationBox(){
      let urlParams = new URLSearchParams(window.location.search);
      var queryString = urlParams.toString();
      window.location.href="index.php?"+ queryString;
    }

    function goback_detail(){
      let urlParams = new URLSearchParams(window.location.search);
      var queryString = urlParams.toString();
      window.location.href="index_showDetail.php?"+ queryString;
    }
  </script>
 </body>

</html>