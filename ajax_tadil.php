<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
//error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
if(isset($_POST['codeKALA3']))//اطلاعات کالا و موجودی در فایل تعدیل
{
  $res_kala3 =$db->query("SELECT kala.name_kala FROM kala WHERE code_kala='$codeKALA3'");
  $row_kala3=$db->fetch_assoc($res_kala3);
  if($codeKALA3==null)$mojody_img='';  
  else $mojody_img='<img border="0" src="images/image(7).gif" onClick="window.showModalDialog(\'help_mojodykala.php?code_kala_='.$codeKALA3.'\',\'_blank\',\'dialogwidth=800px,left=300px,top=100px,scrollbars=yes\')" title="جدول موجودی کالا" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/>';
  echo $row_kala3['name_kala'].'^'.$mojody_img;   
}
/*************************************************************/
if((isset($_POST['codeKESHVAR2']))and(isset($_POST['codeKALA2'])))//اطلاعات کشوردر فرم تعدیل موجودی
{
  $res_keshvar2 =$db->query("SELECT name_keshvar FROM keshvar WHERE code_keshvar='$codeKESHVAR2'");
  $row_keshvar2=$db->fetch_assoc($res_keshvar2);  
  //$mojody_img='<img border="0" src="images/image(7).gif" onClick="window.open(\'help_mojodykala.php?code_kala_='.$codeKALA2.'&code_keshvar='.$codeKESHVAR2.'\',\'_blank\',\'width=750px,left=400px,top=100px,scrollbars=yes\')" title="جدول موجودی کالا" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/>';
  $mojody_img="image-mojody";
  echo $row_keshvar2['name_keshvar'].'^'.$mojody_img;     
}
/*************************************************************/
if(isset($_POST['codeMOSHTARY']))//اطلاعات مشتری
{
  $TableName="moshtary";
  $result2=mysql_query("SELECT * FROM $TableName 
                       INNER JOIN ostan ON $TableName.code_ostan=ostan.code_ostan 
					   INNER JOIN shahrestan ON $TableName.city_code=shahrestan.city_code and ostan.code_ostan=shahrestan.code_ostan						  
					   WHERE code_customer='$codeMOSHTARY' AND $TableName.code_ostan='$mt_gl_code_ostan'");
  $row2=mysql_fetch_assoc($result2);
  echo $row2['name_customer'].'^'.$row2['name_ostan'].'^'.$row2['city_name'].'^'.$row2['customer_address_office'];
}
/******************اطلاعات مجوز تعدیل**********************/
//if((isset($_POST['shomareMojavezTadil']))and(isset($_POST['codeZirAnbar'])))
if(isset($_POST['shomareMojavezTadil']))
{
  $result=$db->query("SELECT mojavez_tadil.*,name_kala,kala.code_bastebandy,name_keshvar,name_tolidkonande,name_ziranbar,bastebandy.sharh_bastebandy,sharh_mandegari FROM mojavez_tadil 
                       INNER JOIN kala ON kala.code_kala=mojavez_tadil.code_kala 
                       INNER JOIN keshvar ON keshvar.code_keshvar=mojavez_tadil.code_keshvar
                       INNER JOIN tolidkonande ON tolidkonande.code_tolidkonande=mojavez_tadil.code_tolidkonande
                       INNER JOIN list_sardkhane_detail l_s_d ON mojavez_tadil.code_ziranbar=l_s_d.code_ziranbar AND mojavez_tadil.code_ostan=l_s_d.code_ostan AND mojavez_tadil.code_anbar=l_s_d.code_anbar 
					   INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
					   INNER JOIN tarikh_mandegari ON mojavez_tadil.code_mandegari=tarikh_mandegari.code_mandegari
					   WHERE shomare_mojavez_tadil='$shomareMojavezTadil' AND mojavez_tadil.code_ostan=$mt_gl_code_ostan AND mojavez_tadil.code_anbar=$mt_gl_code_anbar AND mojavez_tadil.year=$mtActiveYear");
  
  $row=$db->fetch_assoc($result);
  //موجودی کالا با  تابع
  $tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
  $mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
  $mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);  
  echo $row['noe_tadil'].'^'.$tadilArr[$row['noe_tadil']].'^'.$row['code_kala'].'^'.$row['name_kala'].'^'.$row['sal_tolid_shamsi'].'^'.$mahshamsiArr[$row['mah_tolid_shamsi']].'^'.$row['mah_tolid_shamsi'].'^'.$row['rouz_tolid_shamsi'].'^'.$row['code_keshvar'].'^'.$row['name_keshvar'].'^'.$row['code_tolidkonande'].'^'.$row['name_tolidkonande'].'^'.$row['code_ziranbar'].'^'.$row['name_ziranbar'].'^'.$row['code_karton'].'^'.$row['vazn_karton_this'].'^'.$row['code_mandegari'].'^'.$row['sharh_mandegari'].'^'.$tedad_karton.'^'.$mojody_nakhales.'^'.$mojody_khales.'^'.$row['tedad_karton_mojavez'].'^'.$row['sum_karton_mojavez'].'^'.$row['meghdar_nakhales_mojavez'].'^'.$row['meghdar_khales_mojavez'].'^'.$row['code_bastebandy'].'^'.$row['id_mojody'].'^'.$row['noe_tadil'].'^'.$row['chkchangeCode'].'^'.$row['change_code_kala'];
// echo "SELECT mojavez_tadil.*,name_kala,bastebandy.sharh_bastebandy FROM mojavez_tadil 
                       // INNER JOIN kala ON kala.code_kala=mojavez_tadil.code_kala 
                       // INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
					   // WHERE shomare_mojavez_tadil='$shomareMojavezTadil'";
  }
?>