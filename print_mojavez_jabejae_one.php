<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_mojavez_jabejae_one.php";
$TableName="mojavez_jabejae";
$today=AsLDate($yymmdd);
$logtime=date('H:i:s');
$TableName="mojavez_jabejae";
$titr='چاپ مجوز جابه جایی';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<style>
       @media screen
       {
           .hideatprint
           {
           }
       }
       @media print
       {
           .hideatprint
           {
               display: none;
           }
       }
</style>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body>
<div align="center">
<br/>
<table width="85%" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
  <tr>
  <td>
   <table width="100%" border="0" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> نسخه ی  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">مجوز جابه جایی
	    <a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
	 </td>
	</tr>	
   </table>
  </td>
 </tr> 
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
   $q1="SELECT $TableName.*,kala.name_kala,bastebandy.code_bastebandy,bastebandy.sharh_bastebandy,vahed_kala.sharh_vahedkala,ostan.name_ostan,list_sardkhane.name_anbar,shomare_safar.shomare_safar FROM $TableName 
         INNER JOIN kala ON $TableName.code_kala=kala.code_kala 
         INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy
         INNER JOIN vahed_kala ON vahed_kala.code_vahedkala=kala.code_vahedkala
         LEFT JOIN ostan ON ostan.code_ostan=$TableName.code_ostan_maghsad_j
         LEFT JOIN list_sardkhane ON $TableName.code_anbar_maghsad_j=list_sardkhane.code_anbar AND $TableName.code_ostan_maghsad_j=list_sardkhane.code_ostan 
	     LEFT OUTER JOIN shomare_safar ON $TableName.id_safar=shomare_safar.id_safar
		 WHERE $TableName.id='$id_'"; 
	$res1=$db->query($q1);
    $row1=$db->fetch_assoc($res1);
	$ostanMabda=$db->get_from_where("name_ostan","ostan","code_ostan=".$row1['code_ostan']."");     
	$anbarMabda=$db->get_from_where("name_anbar","list_sardkhane","code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");     
    //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	 $meghdar_tahvily_j=tahvily_az_jabejae($row1['shomare_jabejae'],$row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_bastebandy']);
	//محاسبه مقادیر باطله مجوز جابه جایی با استفاده از تابع
	 $maghadir_batele_j=batele_jabejae($row1['shomare_jabejae'],$row1['code_ostan'],$row1['code_anbar'],$row1['year']);
    if($row1['noe_mojavez']==2)//اگر کالای امانی بود
    {
     //سیستم سردخانه
     if($_SESSION['mt_systemforush']==0)
     { 
      //بدست آوردن نام مشتری
       $q_moshtary="SELECT name_customer,code_ostan,city_code,customer_address_office FROM moshtary WHERE code_customer='".$row1['code_customer']."' AND code_ostan='".$row1['code_ostan']."'";
       $res_moshtary=mysql_query($q_moshtary);
       $row_moshtary=mysql_fetch_array($res_moshtary);
	  //بدست آوردن نام استان مشتری
        $q_ostan_moshtary="SELECT code_ostan,name_ostan FROM ostan WHERE code_ostan='".$row_moshtary['code_ostan']."'";
        $res_ostan_moshtary=mysql_query($q_ostan_moshtary);
        $row_ostan_moshtary=mysql_fetch_array($res_ostan_moshtary);
        $ostan_moshtary=$row_ostan_moshtary['name_ostan'];
     }
     //سیستم فروش
     else
     {  
      $db->selectDb('sell');
     //بدست آوردن نام مشتری
      //$q_moshtary="SELECT customer_province_id,customer_city_id,name_customer,customer_address_office FROM dm_customer_asli WHERE code_customer='".$row1['code_customer']."' AND customer_code_org=".$row1['code_ostan']."";
      $q_moshtary="SELECT customer_province_id,customer_city_id,name_customer,customer_address_office FROM dm_customer_asli WHERE code_customer='".$row1['code_customer']."'";
      $res_moshtary=mysql_query($q_moshtary);
      $row_moshtary=mysql_fetch_array($res_moshtary);
     //بدست آوردن نام استان مشتری
      $q_ostan_moshtary="SELECT * FROM dm_province WHERE province_id='".$row_moshtary['customer_province_id']."'";
      $res_ostan_moshtary=mysql_query($q_ostan_moshtary);
      $row_ostan_moshtary=mysql_fetch_array($res_ostan_moshtary);
   	  $ostan_moshtary=$row_ostan_moshtary['province_name'];
      $db->selectDb($mydatabase);
      //mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());
     }
    }
	echo'
	  <tr class="print_tr1">
	   <td colspan="2">
        <table border=0  width=100%>
	     <tr><td align="right"> شماره مجوز جابه جایی : '.$row1['shomare_jabejae'].'</td>
	         <td align="right"> تاريخ مجوز جابه جایی : '.$row1['tarikh_jabejae'].'</td>	 
		 </tr>
	    </table>
	   </td>
	  </tr>
	  <tr><td>&nbsp;</td></tr>
	  <tr class="print_tr1">
	   <td valign="top" width="50%">
	    <fieldset class="print-fieldset">
	     <legend>اطلاعات استان مبدأ</legend>
	     <table border="0" width="100%" height="80px">
	      <tr><td align="right"> نام استان مبدأ : '.$ostanMabda.'</td></tr>
	  	  <tr><td align="right">نام سردخانه مبدأ : '.$anbarMabda.'</td></tr>
	     </table>
        </fieldset>
	   </td>
       <td valign="top" width="50%">
	    <fieldset class="print-fieldset">';
		 if($row1['noe_mojavez']==1)//فی مابین 
		 {echo'
	      <legend>اطلاعات استان مقصد</legend>
	      <table width="100%" border="0" height="80px">
	  	   <tr><td align="right"> نام استان مقصد : '.$row1['name_ostan'].'</td></tr>
	       <tr><td align="right"> نام سردخانه مقصد : '.$row1['name_anbar'].'</td></tr>
	      </table>';
		 }
		 if($row1['noe_mojavez']==2)//کالای امانی
		 {echo'
	      <legend>اطلاعات مشتری</legend>
	      <table width="100%" border="0" height="80px">
	  	   <tr><td align="right"> کد مشتری : '.$row1['code_customer'].'</td></tr>
	       <tr><td align="right"> نام مشتری : '.$row_moshtary['name_customer'].'</td></tr>
	       <!--<tr><td align="right"> استان مشتری : '.$ostan_moshtary.'</td></tr>-->
	       <tr><td align="right"> آدرس مشتری : '.$row_moshtary['customer_address_office'].'</td></tr>
	      </table>';
		 }
		 if($row1['noe_mojavez']==3)//مرجوعی
		 {
		  $name_skk=$db->get_from_where("name_skk","mt_skk","code_skk=".$row1['code_skk']."");
		  echo'
	      <legend>اطلاعات کشتی/ فروشنده</legend>
	      <table width="100%" border="0" height="80px">
	  	   <tr><td align="right"> کد کشتی / فروشنده : '.$row1['code_skk'].'</td></tr>
	       <tr><td align="right"> نام کشتی / فروشنده : '.$name_skk.'</td></tr>
	       <tr><td align="right"> شماره سفر / مجوز : '.$row1['shomare_safar'].'</td></tr>
		  </table>';
		 }
		 echo'
	    </fieldset>
       </td>
	  </tr>
	  <tr class="print_tr1">
	   <td valign="top">
	    <fieldset class="print-fieldset">
	     <legend>کالا</legend>
	     <table width="100%">
	      <tr><td align="right"> کد کالا : '.$row1['code_kala'].'</td></tr>
	  	  <tr><td align="right"> نام کالا : '.$row1['name_kala'].'</td></tr>
          <tr><td align="right"> نوع بسته بندی: '.$row1['sharh_bastebandy'].'</td></tr>
	      <tr><td>&nbsp</td></tr>
	     </table>
	    </fieldset>
	   </td>
	   <td colspan="" valign="top">
	    <fieldset class="print-fieldset">
	     <legend>مقادیر';		  
		  if($row1['code_bastebandy']==1)echo' (کیلوگرم)';
		  if($row1['code_bastebandy']==2)echo' (تعداد)';echo'</legend>
	     <table width="100%" border="0">
	  	  <tr><td align="right"> مقدار مجوز جابه جایی : '.($row1['meghdar_jabejae']).'
			  </td></tr>
	      <tr><td align="right">مقدار تحویلی  : '.round($meghdar_tahvily_j,3).'</td></tr>
	  	  <tr><td align="right">مقدار باطله : '.round($maghadir_batele_j,3).'</td></tr>
	      <tr><td align="right"> مقدار مانده از مجوز جابه جایی :  '.round($row1['mande_az_jabejae'],3).'</td></tr>
	     </table>
	    </fieldset>
       </td>
	  </tr>
   </table>
   </div>
  </td>
 </tr>
 <tr class="print_footer">
  <td align="left">&nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr> 
 <!--پايان مرکز صفحه -->
</table>
</div>
<!-- چاپ زیرنویس-->
<table width="85%" border="1" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr class="print_footer">
  <td>نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.'</td>';
   $dc=mysql_query("SELECT dpt_id FROM mt_typesign WHERE type_id='3' AND code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' order by turn");	
   while ($dr=mysql_fetch_array($dc))
   {
	$vahed=$db->get_from_where("dpt_name,manager","mt_dpt","dpt_id=".$dr[0]." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
    echo '<td>'.$vahed[0].' :&nbsp;&nbsp;'.$vahed[1].'</td>';
   }
  echo'
  </td>
 </tr>
</table>
</body>
</html>';
?>