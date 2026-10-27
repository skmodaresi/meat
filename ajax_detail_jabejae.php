<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
if((isset($_POST['shomareJABEJAE']))and(isset($_POST['noeTahvilBar'])))//آمدن اطلاعات مجوز جابه جایی در حواله انبار
{ 
   if(($noeTahvilBar==4)OR($noeTahvilBar==9))
   {
    $result =mysql_query("SELECT mojavez_jabejae.*,kala.code_kala,kala.name_kala,kala.code_bastebandy,bastebandy.sharh_bastebandy,ostan.name_ostan,list_sardkhane.name_anbar											     
	 					  FROM mojavez_jabejae
                          INNER JOIN kala ON mojavez_jabejae.code_kala=kala.code_kala              
                          INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy              
                          INNER JOIN ostan ON ostan.code_ostan=mojavez_jabejae.code_ostan_maghsad_j           
                          INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=mojavez_jabejae.code_anbar_maghsad_j AND list_sardkhane.code_ostan=mojavez_jabejae.code_ostan_maghsad_j           
                          WHERE shomare_jabejae='$shomareJABEJAE' AND mojavez_jabejae.code_ostan='".$_SESSION['mt_code_ostan']."' AND mojavez_jabejae.code_anbar='".$_SESSION['mt_code_anbar']."' AND mojavez_jabejae.year=".$_SESSION["mtActiveYear"]." AND mojavez_jabejae.deleted=0");
   
      $row=mysql_fetch_assoc($result);
   }
   if(($noeTahvilBar==5)OR($noeTahvilBar==7))
   {
    $result =mysql_query("SELECT mojavez_jabejae.*,kala.code_kala,kala.name_kala,kala.code_bastebandy,bastebandy.sharh_bastebandy											     
	 					  FROM mojavez_jabejae
                          INNER JOIN kala ON mojavez_jabejae.code_kala=kala.code_kala              
                          INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy              
                          WHERE shomare_jabejae='$shomareJABEJAE' AND mojavez_jabejae.code_ostan='".$_SESSION['mt_code_ostan']."' AND mojavez_jabejae.code_anbar='".$_SESSION['mt_code_anbar']."' AND mojavez_jabejae.year=".$_SESSION["mtActiveYear"]." AND mojavez_jabejae.deleted=0");
    $row=mysql_fetch_assoc($result);
	if($_SESSION['mt_systemforush']==0) $nameCustomer=$db->get_from_where("name_customer","moshtary","code_customer='".$row['code_customer']."'");
  	if($_SESSION['mt_systemforush']==1) 
    {
		 $db->selectDb('sell');
		 $nameCustomer=$db->get_from_where("name_customer","sell.dm_customer_asli","code_customer='".$row['code_customer']."'");
		
    }  
   }
   if($noeTahvilBar==6)
   {
    $result =mysql_query("SELECT mojavez_jabejae.*,kala.code_kala,kala.name_kala,kala.code_bastebandy,bastebandy.sharh_bastebandy,mt_skk.name_skk											     
	 					  FROM mojavez_jabejae
                          INNER JOIN kala ON mojavez_jabejae.code_kala=kala.code_kala              
                          INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy              
                          INNER JOIN mt_skk ON mt_skk.code_skk=mojavez_jabejae.code_skk       
                          WHERE shomare_jabejae='$shomareJABEJAE' AND mojavez_jabejae.code_ostan='".$_SESSION['mt_code_ostan']."' AND mojavez_jabejae.code_anbar='".$_SESSION['mt_code_anbar']."' AND mojavez_jabejae.year=".$_SESSION["mtActiveYear"]." AND mojavez_jabejae.deleted=0");
   
      $row=mysql_fetch_assoc($result);
   }
   //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	$meghdar_tahvily_j=tahvily_az_jabejae($row['shomare_jabejae'],$row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_bastebandy']);
   //محاسبه مقادیر باطله مجوز جابه جایی با استفاده از تابع
	$maghadir_batele_j=batele_jabejae($row['shomare_jabejae'],$row['code_ostan'],$row['code_anbar'],$row['year']);
   //بدست آوردن نرخ بارگیری کالا اگر انبار پیمانکار دارد   
   if($_SESSION['mt_status_peymankar']==1)
   {
	 $res_sh_bargiry=$db->query("SELECT sh_jadval_bargiry FROM $mydatabase.hazine_bargiry WHERE code_ostan='$mt_gl_code_ostan' AND deleted=0 order by sh_jadval_bargiry DESC LIMIT 0,1");//شماره آخرین جدول هزینه بارگیری
     $row_sh=$db->fetch_assoc($res_sh_bargiry);
	 if(mysql_num_rows($res_sh_bargiry)>0)
	 {
	   $nerkhBargiry=$db->get_from_where("nerkh_bargiry","$mydatabase.hazine_bargiry_detail","sh_jadval_bargiry=".$row_sh['sh_jadval_bargiry']." AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_kala='".$row['code_kala']."'"); 
	 }
   }
   if($row['code_bastebandy']==2)$vahed_andazegiry=' (تعداد قوطی)';
   else if($row['code_bastebandy']==5)$vahed_andazegiry=' (تعداد دست)';
   else if($row['code_bastebandy']==6)$vahed_andazegiry=' (تعداد)';
   else if($row['code_kala']==50)$vahed_andazegiry=' (تعداد شانه)';
   else $vahed_andazegiry=' (کیلوگرم)'; 
   if(($row['code_ostan']==$_SESSION['mt_code_ostan'])and($row['code_anbar']==$_SESSION['mt_code_anbar'])and($row['year']==$_SESSION['mtActiveYear'])) 
   {echo $row['tarikh_jabejae'].'^'.$row['name_ostan'].'^'.$row['name_anbar'].'^'.$row['code_kala'].'^'.$row['name_kala'].'^'.$row['sharh_bastebandy'].'^'.$row['meghdar_jabejae'].'^'.$meghdar_tahvily_j.'^'.$maghadir_batele_j.'^'.$row['mande_az_jabejae'].'^'.$nerkhBargiry.'^'.$row['id'].'^'.$row['code_customer'].'^'.$nameCustomer.'^'.$vahed_andazegiry.'^'.$row['code_skk'].'^'.$row['name_skk'];}
   else
    echo '';
} 
?>