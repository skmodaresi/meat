
<?php
$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
$j_days_name = array("", "يکم", "دوم", "سوم", "چهارم", "پنجم", "ششم", "هفتم", "هشتم", "نهم", "دهم",
    "يازدهم", "دوازدهم", "سيزدهم", "چهاردهم", "پانزدهم", "شانزدهم", "هفدهم", "هجدهم", "نوزدهم", "بيستم",
    "بيست ويکم", "بيست و دوم", "بيست و سوم", "بيست و چهارم", "بيست و پنجم", "بيست و ششم", "بيست و هفتم", "بيست و هشتم", "بيست و نهم", "سي ام", "سي و يکم");

$j_month_name = array("", "فروردين", "ارديبهشت", "خرداد", "تير",
    "مرداد", "شهريور", "مهر", "آبان", "آذر",
    "دي", "بهمن", "اسفند");
$g_month_name = array("", "January", "February", "March", "April",
    "May", "June", "July", "August", "September",
    "October", "November", "December");
function div($a, $b){
    return (int)($a / $b);
}
function gregorian_to_jalali($g_y, $g_m, $g_d){
    global $g_days_in_month;
    global $j_days_in_month;

    $gy = $g_y - 1600;
    $gm = $g_m - 1;
    $gd = $g_d - 1;

    $g_day_no = 365 * $gy + div($gy + 3, 4) - div($gy + 99, 100) + div($gy + 399, 400);

    for ($i = 0; $i < $gm; ++$i)
        $g_day_no += $g_days_in_month[$i];
    if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0)))
        /* leap and after Feb */
        ++$g_day_no;
    $g_day_no += $gd;

    $j_day_no = $g_day_no - 79;

    $j_np = div($j_day_no, 12053);
    $j_day_no %= 12053;

    $jy = 979 + 33 * $j_np + 4 * div($j_day_no, 1461);

    $j_day_no %= 1461;

    if ($j_day_no >= 366) {
        $jy += div($j_day_no - 1, 365);
        $j_day_no = ($j_day_no - 1) % 365;
    }

    for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) {
        $j_day_no -= $j_days_in_month[$i];
    }
    $jm = $i + 1;
    $jd = $j_day_no + 1;

    if (strlen($jm) == 1)
        $jm = '0' . $jm;
    if (strlen($jd) == 1)
        $jd = '0' . $jd;
	
    return array($jy, $jm, $jd);
}

function AsLDate($d1){
    if (!$d1) $d = $d1;
    else {
        $d = substr($d1, 0, 4) . "/" . substr($d1, 4, 2) . "/" . substr($d1, 6, 2);
        return $d;
    }
}
?>