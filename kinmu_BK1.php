<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理表</title>
</head>
<body>
<?php
const MAX_DAYS = 31;
// 表示するカレンダー日付の作成
function calender(int $year, int $month) {
    $retDays = [];
    // カレンダー日付の作成
    for ($day = 1; $day <= MAX_DAYS; $day++) {
        if (checkDate($month, $day, $year)) {
            $retDays[$day-1] = $day;
        }
    }
    return $retDays;
}

$now = new DateTime();
$nowYear  = (int)$now->format('Y');
$nowMonth = (int)$now->format('m');
$nowDays = calender($nowYear, $nowMonth);
for ($i = 0; $i < count($nowDays); $i++) {
    print $nowDays[$i].'日<br>';
}
?>
</body>
</html>