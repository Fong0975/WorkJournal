<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>工作分析 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/setting.css">

    <style type="text/css">
      .session .part{
        min-height: 50px;

        border: 1px solid #3c3c3c;
        border-radius: 10px;

        margin-top: 10px;
        margin-bottom: 10px;

        background-color: #2c2c2c;
      }

      .statisticsItem_title{
        padding: 20px 30px;

        text-align: left;
        font-size: 25pt;
        font-weight: bold;
        color: #9c9c9c;
      }

      .statisticsItem_value{
        padding: 30px;

        font-size: 40pt;
      }

      .statisticsItem_unit{
        padding: 20px 30px;

        text-align: right;
        font-size: 25pt;
        color: #9c9c9c;
      }

      .mainContent .pageHeader .filter .title{
        font-size: 35pt;
        font-weight: bolder;
        text-align: left;
        color: #a0a0a0;

      }

      .filterColumn_input input{
        display:inline-block;
        color: #9c9c9c;
        text-align: center;
        font-size: 25pt;
      }

      .filterColumn_button{
        width: 20%;
      }

      .filterColumn_button button{
        
      }
    </style>
  </head>

 <body>
  <div class="mainContent">
    <div class="pageHeader">
      <table style="margin-bottom: 20px;">
        <tr>
          <td style="width: 100px;"><img src="images/assets/logo(white).png" style="width: 100px;"></td>
          <td style="text-align: left;  padding-left: 20px;"><div class="title">MOS Journal</div></td>
        </tr>
      </table>
      
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">工作分析 Statistics</div>

      <div class="filter">
        <div class="title">篩選條件</div>
        <table>
          <tr>
            <td class="filterColumn_input">+
              <div id="reportrange" style="cursor: pointer; width: 100%; color: #9c9c9c;">
                  <i class="fa fa-calendar"></i>&nbsp;
                  <span></span> <i class="fa fa-caret-down"></i>
              </div>
            </td>
            <td class="filterColumn_button"><button><i class="fas fa-funnel-dollar"></i></button></td>
          </tr>
        </table>
      </div>
      <hr style="border-color: #3c3c3c; border-width: 3px; margin: 0px -20px; box-shadow: 0px 10px 20px 8px #2c2c2c;">
    </div>

    
    <div class="session" style="text-align: center; padding: 0px; margin-top: 60px;">
      <div class="part">
        <table>
          <thead>
            <tr>
              <td class="statisticsItem_title"><i class="fas fa-money-bill-wave"></i>平均薪資</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="statisticsItem_value"><span class="Single">150</span></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td class="statisticsItem_unit">元</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="part">
        
      </div>
    </div>
    
    

   
   <div class="tabBar">
      <?php echo printTabbar($TABITEM_QR_IDENTIFICATION); ?>
   </div>

  <script src="script/jquery-1.12.4.js"></script>
  <script type="text/javascript">
    function toCurrency(num){
      var parts = num.toString().split('.');
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      return parts.join('.');
    }
  </script>
  <script type="text/javascript">
    $({ Counter: 0 }).animate({
      Counter: $('.Single').text()
    }, {
      duration: 1000,
      easing: 'swing',
      step: function() {
        $('.Single').text(Math.ceil(this.Counter));
      }
    });
  </script>


  <!-- date interval picker -->
  <script type="text/javascript" src="script/dateIntervalPicker/moment.min.js"></script>
  <script type="text/javascript" src="script/dateIntervalPicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="script/dateIntervalPicker/daterangepicker.css" />

  <script type="text/javascript">
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Week': [moment().startOf('week').subtract(-1, 'days'), moment().endOf('week').subtract(-1, 'days')],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
    </script>
 </body>
</html>