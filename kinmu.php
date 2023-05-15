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
// 定数
const MAX_DAYS = 31; // １か月に存在する最大の日数
  
// 表示する勤務表の作成
function makeKinmuhyoHtml(array $list) : void  {
    $startFlg = $list["startFlg"];
    $endFlg = $list["endFlg"];
    if ($startFlg == "1" || $endFlg == "1") {
        $now = new DateTime();
        $strNowYmd = $now->format('Ymd');
    }
    $strYear = $list["strYear"];
    $strMonth = $list["strMonth"];
    $strYM = $strYear.$strMonth;
    $intYear  = (int)$strYear;
    $intMonth = (int)$strMonth;
    // カレンダー日付の作成
    for ($intDay=1; $intDay<=MAX_DAYS; $intDay++) {
        if (checkDate($intMonth, $intDay, $intYear)) {
            $strDay = (String)$intDay;  // int型からstring型に変換
            $strDay = str_pad($strDay, 2, "0", STR_PAD_LEFT);  // 1桁の場合、前0詰めの2桁表示
            echo '<tr>';
            echo '<td class="dispDay">';
            echo $strMonth.'月'.$strDay.'日';
            echo '</td>';
            echo '<td>';
            echo '<span id="'.$strMonth.$strDay.'start">';
            // 業務開始（本日付）
            if ($strNowYmd == $strYM.(String)$intDay && $startFlg == '1') {
                echo $now->format('H時i分s秒');
            }
            echo '</span>';
            echo '</td>';
            echo '<td>';
            echo '<span id="'.$strMonth.$strDay.'end">';
            // 業務終了（本日付）
            if ($strNowYmd == $strYM.(String)$intDay && $endFlg == '1') {
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
$list["startFlg"] = $startFlg;
$list["endFlg"] = $endFlg;

// 日付の取得
$now = new DateTime();
$strNowYear  = $now->format('Y');
$strNowMonth = $now->format('m');
$list["strYear"] = $strNowYear;
$list["strMonth"] = $strNowMonth;

echo '<div style="text-align:center;">';
echo '<h2>'.'勤怠管理表'.'</h2>';
echo '<div style="text-align:center;">';
echo '<button type="button" style="margin-right:20px;">＜前月</button>';
echo '<span>'.$strNowYear.'年'.$strNowMonth.'月'.'</span>';
echo '<button type="button" style="margin-left:20px;">翌月＞</button>';
echo '</div>';
echo '<div style="margin-top:20px;">';
echo '<button type="button" style="margin-right:20px;" onClick="workStart();">業務開始</button>';
echo '<button type="button" onClick="workEnd();">業務終了</button>';
echo '</div>';
// 勤務表作成
echo '<table border="1" class="border" style="margin:auto; margin-top:20px;">';
echo '<tr>';
echo '<td width="150px" class="dispDay">'.'日付'.'</td>';
echo '<td width="200px" class="dispDay">'.'始業時間'.'</td>';
echo '<td width="200px" class="dispDay">'.'終業時間'.'</td>';
makeKinmuhyoHtml($list); // 勤務表を表示
echo '</tr>';
echo '</td>';
echo '</table>';
echo '</div>';
?>
<!-- 隠し項目（パラメータ）-->
<input type="hidden" name="startFlg" value="">
<input type="hidden" name="startSumiFlg" value="">
<input type="hidden" name="endFlg" value="">
<input type="hidden" name="endSumiFlg" value="">
<input type="hidden" name="strYear" value="">
<input type="hidden" name="strMonth" value="">
</form>
</body>
</html>