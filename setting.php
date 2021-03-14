<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>設定 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/setting.css">

    <style type="text/css">
      html{
        background-color: #101010;
      }

      .headerBack{
        position: absolute;
        top: 0px;
        left: 0px;
        right: 0px;
        z-index: -1;
        min-height: 550px;
        
        background-color: #000;
      }
    </style>
  </head>

 <body>
  <div class="headerBack"> </div>

  <div class="mainContent" style="padding-bottom: 170px;">
    <div class="pageHeader">
      <table style="margin-bottom: 20px;">
        <tr>
          <td style="width: 100px;"><img src="images/assets/logo(white).png" style="width: 100px;"></td>
          <td style="text-align: left; padding-left: 20px;"><div class="title">MOS Journal</div></td>
        </tr>
      </table>
      
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">設定 Setting</div>
    </div>
    

    <div class="session header" style="text-align: center;">
      <img class="profile" src="images/assets/profile.jpg">
      <div class="title">服務員</div>
      <div class="subTitle">2018/03/20 ~ <?php $today = date("Y/m/d").""; echo $today; ?></div>
      <div class="text">
        (<?php $datetime1 = date_create('2018/03/20'); $datetime2 = date_create($today); $interval = date_diff($datetime1, $datetime2); echo $interval->format('%a'); ?> 天)</div>
    </div>

  <?php
    require_once("function/page/setting/get.php");
    getSettingItem();
  ?>

  <span style="color: #9c9c9c; font-size: 16pt; padding-left: 30px;">Copyright© SWind. All Rights Reserved.</span>
   
   <div class="tabBar">
      <?php echo printTabbar($TABITEM_SETTING); ?>
   </div>


   <script type="text/javascript">
    function addRowHandlers() {
      for(i=1; i<9; i++){
        var table = document.getElementById("setting_"+i);
        var rows = table.getElementsByTagName("tr");

        for (j = 0; j < rows.length; j++) {
          var currentRow = table.rows[j];
          var createClickHandler = 
              function(row) {
                  return function() { 
                    var str_title = row.getElementsByTagName("td")[0].innerHTML;
                    var str_content = row.getElementsByTagName("td")[1].innerHTML;
                    var title = str_title.substring(str_title.indexOf('i>')+2);
                    var content = str_content.substring(0,str_content.indexOf('<i'));
                    showInputDialog(title,content);
                  };
              };

          currentRow.onclick = createClickHandler(currentRow);
        }
      }
    }
    window.onload = addRowHandlers();
   </script>
   <script type="text/javascript">
    function showInputDialog(strTitle, strDefault){
      var newValue = prompt("請輸入欲變更「"+strTitle+"」的值",strDefault)
      if (newValue != null && newValue != ""){
        window.location.href = "function/page/setting/set.php?title="+strTitle+"&value="+newValue;
        // alert("變更" + strTitle + "為「"+newValue+"」")
      }
    }
   </script>
 </body>

</html>