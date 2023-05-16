<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理表</title>
</head>
<script src="kinmu.js"></script>
<link rel="stylesheet" href="kinmu.css">
<body onload="onLoad();">
<form name="kinmu" action="kinmu.php" method="POST">
<?php
// 表示する曜日の作成
function dispYoubi(String $strNum) : string  {
    $intNum = (int)$strNum;
    switch ($intNum) {
      case 0 : 
        return '日';
        break;
      case 1 : 
        return '月';
        break;
      case 2 : 
        return '火';
        break;  
      case 3 : 
        return '水';
        break;  
      case 4 : 
        return '木';
        break;  
      case 5 : 
        return '金';
         break;  
      case 6 : 
        return '土';
        break;  
    }
}

// 表示する勤務表の作成
function makeKinmuhyoHtml(array $list) : void  {
    $startFlg = $list["startFlg"];
    $endFlg = $list["endFlg"];
    $now = new DateTime();
    $strNowYmd = $now->format('Ymd');
    $strYear = $list["strYear"];
    $strMonth = $list["strMonth"];
    $strYM = $strYear.$strMonth;
    $maxDay = date('t',strtotime($strYM));  // 1か月の日数
    $intYear  = (int)$strYear;
    $intMonth = (int)$strMonth;
    // カレンダー日付の作成
    for ($intDay=1; $intDay<=$maxDay; $intDay++) {
        if (checkDate($intMonth, $intDay, $intYear)) {
            $strDay = (String)$intDay;  // int型からstring型に変換
            $strYMD = $strYM.$strDay;
            $numYoubi = date('w',strtotime($strYMD));
            $strDay = str_pad($strDay, 2, "0", STR_PAD_LEFT);  // 1桁の場合、前0詰めの2桁表示
            echo '<tr>';
            echo '<td class="dispDay">';
            echo $strMonth.'月'.$strDay.'日 ('.dispYoubi($numYoubi).')';
            echo '</td>';
            echo '<td>';
            echo '<span id="'.$strMonth.$strDay.'start">';
            // 業務開始（本日付）
            if ($numYoubi == 0 || $numYoubi == 6) {
              echo $now->format('―');
            } else if ($strNowYmd == $strYM.(String)$intDay && $startFlg == '1') {
                echo $now->format('H時i分s秒');
            }
            echo '</span>';
            echo '</td>';
            echo '<td>';
            echo '<span id="'.$strMonth.$strDay.'end">';
            // 業務終了（本日付）
            if ($numYoubi == 0 || $numYoubi == 6) {
              echo $now->format('―');
            } else if ($strNowYmd == $strYM.(String)$intDay && $endFlg == '1') {
                echo $now->format('H時i分s秒');
            }
            echo '</td>';
            echo '</tr>';
        }
    }
}

// 配列作成
$list;

// POSTパラメータ取得
$startFlg = filter_input(INPUT_POST, 'startFlg');
$endFlg = filter_input(INPUT_POST, 'endFlg');
$dispYM = filter_input(INPUT_POST, 'dispYM');
$nowYM = filter_input(INPUT_POST, 'nowYM');
$list["startFlg"] = $startFlg;
$list["endFlg"] = $endFlg;

// 日付の取得
if ($dispYM == null || $dispYM == "") {
  $now = new DateTime();
  $strNowYear  = $now->format('Y');
  $strNowMonth = $now->format('m');
  $dispYM = $strNowYear.$strNowMonth;
  $nowYM = $dispYM;
} else {
  $strNowYear  = mb_substr($dispYM, 0, 4);
  $strNowMonth = mb_substr($dispYM, 4);
}
$list["strYear"] = $strNowYear;
$list["strMonth"] = $strNowMonth;
?>

<div style="text-align:center;">
    <h2>勤怠管理表</h2>
    <div style="text-align:center;">
      <button type="button" style="margin-right:20px;" onClick="monthChange(true);">＜前月</button>
        <span>
  <?php
          echo $strNowYear.'年'.$strNowMonth.'月';
  ?>
        </span>
      <button type="button" style="margin-left:20px;" onClick="monthChange(false);">翌月＞</button>
    </div>
    <div style="margin-top:20px;">
      <button type="button" name="btnStart" style="margin-right:20px;" onClick="frmSubmit(true);">業務開始</button>
      <button type="button" name="btnEnd" onClick="frmSubmit(false);">業務終了</button>
    </div>
    <!-- 勤務表作成開始 -->
    <table border="1" class="border" style="margin:auto; margin-top:20px;">
      <tr>
        <td width="200px" class="dispDay">日付</td>
        <td width="200px" class="dispDay">始業時間</td>
        <td width="200px" class="dispDay">終業時間</td>
      </tr>
<?php
      // 勤務表を表示
      makeKinmuhyoHtml($list);
?>
    </table>
    <!-- 勤務表作成終了 -->
  </div>
  <!-- 隠し項目（パラメータ）-->
  <input type="hidden" name="startFlg" value="">
  <input type="hidden" name="startSumiFlg" value="">
  <input type="hidden" name="endFlg" value="">
  <input type="hidden" name="endSumiFlg" value="">
  <input type="hidden" name="strYear" value="">
  <input type="hidden" name="strMonth" value="">
  <input type="hidden" name="dispYM" value="<?php echo $dispYM;?>">
  <input type="hidden" name="nowYM" value="<?php echo $nowYM;?>">
</form>
</body>
</html>