<?php
require_once __DIR__ . '/mysql_compat.php';
require 'db_mysql.php';
include 'functions.php';
header('Content-Type: text/html; charset=UTF-8');
//require 'include/define_config.php';//اگر بخواهیم در فایل دیگر اینها را تعریف کنیم به صورت استاتیک 
//$db = new phpdbform_db(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
$db = new phpdbform_db('localhost','user', 'xlsdj@#@aHdF');
//$db = new phpdbform_db('localhost','root', '');
//اضافه کردن
$db->selectDb('meat');
$mydatabase='meat';
$selldatabase='sell';
$accDB='mali';
date_default_timezone_set('Iran');
ini_set('mbstring.internal_encoding','UTF-8');
ini_set('mbstring.http_input','UTF-8');
ini_set('mbstring.http_output','UTF-8');
mysql_query('SET CHARACTER SET utf8');
$logtime=date('H:i:s');//ساعت فعلی 
$DateE=date("Y.m.d");
$d=substr($DateE,8,2);
$m=substr($DateE,5,2);
$y=substr($DateE,0,4);
$DateF=gregorian_to_jalali($y,$m,$d);
$yy=$DateF[0];
//$yy=substr($yy,2,2);
$mm=$DateF[1];
$dd=$DateF[2];
$yymmdd=$yy.$mm.$dd;
$today=AsLDate($yymmdd);//تاریخ فعلی شمسی
$today_milady=date("Y-m-d");//تاریخ فعلی میلادی
//شرط نمایش حواله و رسیدهای جابه جایی
$Condition_JabejaeDate_m = strtotime ( '-2 month' , strtotime ( $today_milady ) ) ;//2 month ago
$Condition_JabejaeDate_m = date ( 'Y-m-j' , $Condition_JabejaeDate_m );
$d2=substr($Condition_JabejaeDate_m,8,2);$m2=substr($Condition_JabejaeDate_m,5,2);$y2=substr($Condition_JabejaeDate_m,0,4);
$DateF2=gregorian_to_jalali($y2,$m2,$d2);
$yy2=$DateF2[0];
$mm2=$DateF2[1];
$dd2=$DateF2[2];
$Condition_JabejaeDate_sh=$yy2.'/'.$mm2.'/'.$dd2;
//شرط اجازه رسید و حواله زدن  آنهایی که ثبت نهایی نشده
$Condition_SabtNashodeDate_m = strtotime ( '-3 day' , strtotime ( $today_milady ) ) ;//1 week ago
//$Condition_SabtNashodeDate_m = strtotime ( '-1 month' , strtotime ( $today_milady ) ) ;//1 month ago
$Condition_SabtNashodeDate_m = date ( 'Y-m-j' , $Condition_SabtNashodeDate_m );
$d3=substr($Condition_SabtNashodeDate_m,8,2);$m3=substr($Condition_SabtNashodeDate_m,5,2);$y3=substr($Condition_SabtNashodeDate_m,0,4);
$DateF3=gregorian_to_jalali($y3,$m3,$d3);
$yy3=$DateF3[0];
$mm3=$DateF3[1];
$dd3=$DateF3[2];
$Condition_SabtNashodeDate_sh=$yy3.'/'.$mm3.'/'.$dd3;


////////
// $DateE=date("Y.m.d");
// $d=substr($DateE,8,2);
// $m=substr($DateE,5,2);
// $y=substr($DateE,0,4);
// $DateKind=$db->get_from_where("org_calendar","org","org_code='$g_org_id'");
// if ($DateKind==2)
// {$yy=substr($y,2,2);
 // $mm=$m;
 // $dd=$d;
// }
// else
// {$DateF=gregorian_to_jalali($y,$m,$d);
 // $yy=Substr($DateF[0],2,2);
 // $mm=$DateF[1];
 // $dd=$DateF[2];
// }
// $yymmdd=$yy.$mm.$dd;
if($_SESSION["mt_owner"])         $mt_gl_owner=$_SESSION["mt_owner"];
if($_SESSION["mt_code_ostan"])    $mt_gl_code_ostan=$_SESSION["mt_code_ostan"];
if($_SESSION['mt_code_anbar'])    $mt_gl_code_anbar=$_SESSION['mt_code_anbar'];
if($_SESSION["mt_id_anbar"])      $mt_gl_id_anbar=$_SESSION["mt_id_anbar"];
if($_SESSION['mt_name_ostan'])    $mt_gl_name_ostan=$_SESSION['mt_name_ostan'];
if($_SESSION["mt_name_anbar"])    $mt_gl_name_anbar=$_SESSION["mt_name_anbar"];
if($_SESSION['mt_role'])          $role_id=$_SESSION['mt_role'];
if($_SESSION['mt_userName'])      $mtuserNAME=$_SESSION['mt_userName'];
if(SuperUser())                   $mtuserNAME="Administrator";
if($_SESSION["mtActiveYear"])     $mtActiveYear=$_SESSION["mtActiveYear"];
if($_SESSION['mtstart_date_sh'])  $mtStartDateSh=$_SESSION['mtstart_date_sh'];
if($_SESSION['mtstart_date_mi'])  $mtStartDateMi=$_SESSION['mtstart_date_mi'];
if($_SESSION['mtend_date_sh'])    $mtEndDateSh=$_SESSION['mtend_date_sh'];
if($_SESSION['mtend_date_mi'])    $mtEndDateMi=$_SESSION['mtend_date_mi'];
$_SESSION["acc_etesal"]='متصل به مالی';
if($_SESSION['mt_systemforush']==1)
{  
  //پیدا کردن آی دی کد استان مربوط به سیتم فروش
  $res_ostan=mysql_query("SELECT province_id FROM sell.dm_province WHERE province_code=".$_SESSION["mt_code_ostan"]."");
  $_SESSION['sell_id_ostan']=mysql_result($res_ostan, 0, 'province_id');
  $sell_id_ostan=$_SESSION['sell_id_ostan'];
  //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
  $res_anbar=mysql_query("SELECT l_id FROM sell.dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code=".$_SESSION['mt_code_anbar']."");
  $_SESSION['sell_id_anbar']=mysql_result($res_anbar, 0, 'l_id');
  $sell_id_anbar=$_SESSION['sell_id_anbar'];
  //پیدا کردن آی دی سال مربوط به سیستم فروش
  // $sellYearCode=substr($mtActiveYear,2);
  // $res_sal=mysql_query("SELECT year_id FROM sell.dm_year WHERE year_code='$sellYearCode'");
  // $_SESSION['sellYearId']=mysql_result($res_sal, 0, 'year_id');
  // $sellYearId=$_SESSION['sellYearId'];
}
//پیدا کردن آی دی سال مربوط به سیستم فروش
IF($mtActiveYear<1400)$sellYearCode=substr($mtActiveYear,2);
ELSE $sellYearCode=$mtActiveYear;
$_SESSION["sellYearId"]=$db->get_from_where("year_id","sell.dm_year","year_code='$sellYearCode'");
if($_SESSION["sellYearId"]) $sellYearId=$_SESSION["sellYearId"];
//هر کارتن شامل 12 شانه تخم مرغ است
$_SESSION["mtShane"]=12;
//هر کارتن شامل 6 شانه تخم مرغ داخلی است
$_SESSION["mtShane_dakheli"]=6;
$Search_img="<span class=\"fa fa-search \"></span>";
$Save_img="<span class=\"fa fa-save \"></span>";
$Edit_img="<span class=\"fa fa-edit \"></span>";
$Ignore_img="<span class=\"fa fa-minus-circle \"></span>";
$Taeed_img="<span class=\"fa fa-check\"></span>";
$Show_img="<span class=\"fa fa-clipboard\"></span>";
$Confirm_icon="<span class=\"fa fa-check-circle fa-2x\" style=\"color:green\"></span>";
$Confirm_icon_s="<span class=\"fa fa-check-circle\" style=\"color:green\"></span>";
$DontConfirm_icon="<span class=\"fa fa-times-circle fa-2x\" style=\"color:red\"></span>";
$DontConfirm_icon_s="<span class=\"fa fa-times-circle\" style=\"color:red\"></span>";

?>