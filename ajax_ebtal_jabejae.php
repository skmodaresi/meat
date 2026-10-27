<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/ 
if(isset($_POST['shomareJABEJAE']))//آمدن اطلاعات مجوز جابه جایی در حواله انبار
{ 
   if($_SESSION['mt_systemforush']==0)//سردخانه
   {	
    $result =mysql_query("SELECT mojavez_jabejae.*,kala.code_kala,kala.name_kala,kala.code_bastebandy,ostan.name_ostan,list_sardkhane.name_anbar,moshtary.name_customer FROM mojavez_jabejae
                          INNER JOIN kala ON mojavez_jabejae.code_kala=kala.code_kala              
						  INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
						  LEFT JOIN moshtary ON mojavez_jabejae.code_customer=moshtary.code_customer
                          LEFT JOIN ostan ON ostan.code_ostan=mojavez_jabejae.code_ostan_maghsad_j           
                          LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=mojavez_jabejae.code_anbar_maghsad_j AND list_sardkhane.code_ostan=mojavez_jabejae.code_ostan_maghsad_j           
                          WHERE shomare_jabejae='$shomareJABEJAE' AND mojavez_jabejae.code_ostan='".$_SESSION['mt_code_ostan']."' AND mojavez_jabejae.code_anbar='".$_SESSION['mt_code_anbar']."' AND mojavez_jabejae.year=".$_SESSION["mtActiveYear"]." AND mojavez_jabejae.deleted=0");
	}
	if($_SESSION['mt_systemforush']==1)//فروش
    {	
	 $result =mysql_query("SELECT mojavez_jabejae.*,kala.code_kala,kala.name_kala,kala.code_bastebandy,ostan.name_ostan,list_sardkhane.name_anbar,dm_customer_asli.name_customer FROM mojavez_jabejae
                           INNER JOIN kala ON mojavez_jabejae.code_kala=kala.code_kala              
                           INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
						   LEFT JOIN sell.dm_customer_asli ON mojavez_jabejae.code_customer=sell.dm_customer_asli.code_customer
                           LEFT JOIN ostan ON ostan.code_ostan=mojavez_jabejae.code_ostan_maghsad_j           
                           LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=mojavez_jabejae.code_anbar_maghsad_j AND list_sardkhane.code_ostan=mojavez_jabejae.code_ostan_maghsad_j           
                           WHERE shomare_jabejae='$shomareJABEJAE' AND mojavez_jabejae.code_ostan='".$_SESSION['mt_code_ostan']."' AND mojavez_jabejae.code_anbar='".$_SESSION['mt_code_anbar']."' AND mojavez_jabejae.year=".$_SESSION["mtActiveYear"]." AND mojavez_jabejae.deleted=0");
    }
    $row=mysql_fetch_assoc($result);
    IF($row['code_bastebandy']==2)$vahed_andazegiry=' (تعداد قوطی)';
    ELSE IF($row['code_kala']==50) $vahed_andazegiry=' (تعداد شانه)';
	ELSE $vahed_andazegiry=' (کیلوگرم)';
   //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	$meghdar_tahvily_j=tahvily_az_jabejae($row['shomare_jabejae'],$row['code_ostan'],$row['code_anbar'],$row['year']);
   //محاسبه مقادیر باطله مجوز جابه جایی با استفاده از تابع
	$maghadir_batele_j=batele_jabejae($row['shomare_jabejae'],$row['code_ostan'],$row['code_anbar'],$row['year']);
   if(($row['code_ostan']==$_SESSION['mt_code_ostan'])and($row['code_anbar']==$_SESSION['mt_code_anbar'])and($row['year']==$_SESSION['mtActiveYear'])) 
   {echo $row['tarikh_jabejae'].'^'.$row['name_ostan'].'^'.$row['name_anbar'].'^'.$row['code_kala'].'^'.$row['name_kala'].'^'.$row['name_customer'].'^'.$row['meghdar_jabejae'].'^'.$meghdar_tahvily_j.'^'.$row['mande_az_jabejae'].'^'.$row['id'].'^'.$vahed_andazegiry;}
   //{echo $row['tarikh_jabejae'].'^'.$row['name_ostan'].'^'.$row['name_anbar'].'^'.$row['code_kala'].'^'.$row['name_kala'].'^'.$row['meghdar_jabejae'].'^'.$meghdar_tahvily_j.'^'.$row['mande_az_jabejae'].'^'.$row['id'];}
   else
    echo '';
}
?>