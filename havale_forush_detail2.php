<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="havale_forush_detail.php";
$logtime=date('H:i:s');
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جزئیات حواله فروش</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>

</head>';
if(!(isset($Mode))) $Mode='';   
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.h_reg_date.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="98%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">حواله فروش شماره '.$h_code_.'</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>';

//اطلاعات در حالت سیستم فروش
	$q1="SELECT dm_anbar_det.*,dm_pish_havale_det.phd_ph_code,h_id,h_code,h_reg_date,h_pre_amount,mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton,bastebandy.sharh_bastebandy
          FROM sell.dm_havale
		  INNER JOIN sell.dm_pish_havale_det ON h_phd_id=phd_id
		  INNER JOIN sell.dm_anbar_det ON dad_phd_id=phd_id
		  INNER JOIN meat.mojody_kala ON mojody_kala.id=dm_anbar_det.dad_anbar_id
		  INNER JOIN meat.kala ON mojody_kala.code_kala=kala.code_kala
          INNER JOIN meat.keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
          LEFT JOIN  meat.karton ON mojody_kala.code_karton=karton.code_karton 
          INNER JOIN meat.tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN meat.list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar  	  
	      INNER JOIN meat.bastebandy ON bastebandy.code_bastebandy=mojody_kala.code_bastebandy
		  WHERE h_code=$h_code_ AND h_id_province=$sell_id_ostan AND h_l_code=$sell_id_anbar AND h_id_year=$sellYearId ORDER BY dad_id";
		$res1=mysql_query($q1);				 
	  
			 
	//echo $q1;
	//$res1=mysql_query($q1);
	$radif=1;
	$sum_dad=0;$sum_tahvily_dad_id=0;$sum_ebtal_detail=0;$sum_mande_forush_detail=0;
	while($row1=mysql_fetch_assoc($res1))
	{
	  //تبدیل تاریخ میلادی به شمسی
      $sql_tarikh=$row1['h_reg_date'];
      $d=substr($sql_tarikh,8,2);
      $m=substr($sql_tarikh,5,2);
      $y=substr($sql_tarikh,0,4);
      $shamsi=gregorian_to_jalali($y,$m,$d);
      $sal=$shamsi[0];
      $mah=$shamsi[1];
      $rouz=$shamsi[2];
      $tarikh_forush=$sal.'/'.$mah.'/'.$rouz;	
      //با استفاده از تابع
	   $tedad_karton=mojodyKarton($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton']);
	   $mojody_nakhales=mojodyNakhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton']);
	   $mojody_khales=mojodyKhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton']);
       //مقدار کل فروخته شده از این کالا
	   IF($row1['code_bastebandy']==2)$sold_this_id_without_ebtal=$db->get_from_where("SUM(dad_tedad_khanbar)","sell.dm_anbar_det","dad_anbar_id=".$row1['dad_anbar_id']."");   
	   ELSE $sold_this_id_without_ebtal=$db->get_from_where("SUM(dad_vazn_khanbar)","sell.dm_anbar_det","dad_anbar_id=".$row1['dad_anbar_id']."");
	   
	   //مقدار کل ابطال شده از این کالا
	   $ebtal_this_id=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=".$row1['dad_anbar_id']."");
	   $sold_this_id=$sold_this_id_without_ebtal-$ebtal_this_id;
	   //مقدار تحویلی این کالا در کل
	   IF($row1['code_bastebandy']==2) $tahvily_detail=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","id_mojody=".$row1['id']." AND status=0 AND dad_id!=''");
	   ELSE $tahvily_detail=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","id_mojody=".$row1['id']." AND status=0 AND dad_id!=''");
	   $mande_az_detail_forush=$sold_this_id-$tahvily_detail;
	   IF($row1['code_bastebandy']==2) {$meghdar_mojaz=$tedad_karton-$mande_az_detail_forush;}
	   ELSE {$meghdar_mojaz=$mojody_khales-$mande_az_detail_forush;}
	   
	   //مقدار تحویلی این حواله فروش
	   IF($row1['code_bastebandy']==2)$tahvily_dad_id=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","dad_id=".$row1['dad_id']." AND status=0");
	   ELSE $tahvily_dad_id=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","dad_id=".$row1['dad_id']." AND status=0");
       //مقدار ابطال شده از این حواله فروش
	   $ebtal_detail=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=".$row1['dad_anbar_id']." AND deh_phd_id=".$row1['dad_phd_id']."");

	   //مقدار مانده از این حواله فروش
	   IF($row1['code_bastebandy']==2)$mande_forush_detail=$row1['dad_tedad_khanbar']-$tahvily_dad_id-$ebtal_detail;
	   ELSE $mande_forush_detail=$row1['dad_vazn_khanbar']-$tahvily_dad_id-$ebtal_detail;
	  echo'
      <tr class="tr1 boldtext" >
	      <td align="center">ردیف : '.$radif.'</td>
		  <td align="center">شناسه حواله فروش : '.$row1['h_id'].'</td>
		  <td align="center">شماره حواله فروش : '.$row1['h_code'].'</td>
		  <td align="center">شناسه جزئیات پیش حواله : '.$row1['dad_phd_id'].'</td>
		  <td align="center">شماره پیش حواله : '.$row1['phd_ph_code'].'</td>
	  </tr>
	  <tr class="tr1" >
	   <td colspan="5">
	    <fieldset>
         <table width="100%" height="100px" border="0">
          <tr class="boldtext">		 
		   <td align="right" colspan="2">شناسه جزئیات انبار : '.$row1['dad_id'].'</td>
		   <td align="right" colspan="2">شناسه موجودی کالا : '.$row1['dad_anbar_id'].'</td>
		   <td align="right" colspan="2">مقدار کلی حواله فروش : '.round($row1['h_pre_amount'],3).'</td>
		  </tr>
          <tr>		  
		   <td align="right">کالا : '.$row1['code_kala'].' - '.$row1['name_kala'].'</td>
		   <td align="right">بسته بندی : '.$row1['sharh_bastebandy'].'</td>
		   <td align="right">نام زیرانبار : '.$row1['name_ziranbar'].'</td>
	       <td align="right">کشور : '.$row1['code_keshvar'].' - '.$row1['name_keshvar'].'</td>
		  </tr>
		  <tr>
		   <td align="right">تولیدکننده : '.$row1['code_tolidkonande'].' - '.$row1['name_tolidkonande'].'</td>
		   <td align="right">سال تولید : '.$row1['sal_tolid_shamsi'].'</td>
		   <td align="right">ماه تولید : '.$mahshamsiArr[$row1['mah_tolid_shamsi']].'</td>
		   <td align="right">روز تولید : '.$row1['rouz_tolid_shamsi'].'</td>';
		   if($row1['code_bastebandy']==2)
	       {
	        echo'<td align="right">کد و وزن قوطی : '.$row1['code_karton'].' - '.$row1['vazn_karton_this'].'</td>';
	       }
	       else
	       {
	        echo'<td align="right">کد و وزن کارتن : '.$row1['code_karton'].' - '.$row1['vazn_karton_this'].'</td>';
	       }
	       echo'
		   </tr>
	       <tr>
	  	     <td align="right">تعداد فعلی : '.$tedad_karton.'</td>
	  	     <td align="right">موجودی ناخالص فعلی : '.round($mojody_nakhales,3).'</td>
	  	     <td align="right">موجودی خالص فعلی : '.round($mojody_khales,3).'</td>
	       </tr>
	       <tr>
		   	 <td align="right">مقدار کل فروخته شده (بدون ابطال) : '.round($sold_this_id_without_ebtal,3).'</td>
		   	 <td align="right">مقدار کل ابطالی : '.round($ebtal_this_id,3).'</td>
		   	 <td align="right">مقدار کل فروخته شده : '.round($sold_this_id,3).' '; if(SuperUser()) echo '('.$row1['khales_sold'].')'; echo'</td>
			 <td align="right">مقدار کل تحویلی : '.round($tahvily_detail,3).'</td>
			 <td align="right">مقدار مانده از جزئیات فروش : '.round($mande_az_detail_forush,3).'</td>
	  	     <td align="right">مقدار موجودی مجاز : '.round($meghdar_mojaz,3).'</td><td>&nbsp;</td>
		   </tr>
		   <tr>
	  	     <td align="right">مقدار جزئیات فروش : '; IF($row1['code_bastebandy']==2) echo' '.($row1['dad_tedad_khanbar']).''; ELSE echo' '.round($row1['dad_vazn_khanbar'],3).''; echo'</td>';
	  	     echo'
			 <td align="right">مقدار تحویلی جزئیات فروش : '.round($tahvily_dad_id,3).'</td>
	  	     <td align="right">مقدار ابطالی جزئیات فروش : '.round($ebtal_detail,3).'</td>
	  	     <td align="right">مقدار مانده جزئیات فروش : '.round($mande_forush_detail,3).'</td><td>&nbsp;</td>
	       </tr>';		   
		   echo'
	      </tr>
		 </table>
		</fieldset>
	   </td>
	  </tr>';
    $radif++;
	IF($row1['code_bastebandy']==2)$sum_dad+=$row1['dad_tedad_khanbar'];
	ELSE $sum_dad+=$row1['dad_vazn_khanbar'];
	$sum_tahvily_dad_id+=$tahvily_dad_id;
	$sum_ebtal_detail+=$ebtal_detail;
	$sum_mande_forush_detail+=$mande_forush_detail;
   }	
   echo'
    <tr class="tr1">
	 <td align="right">جمع جزئیات حواله فروش : '.round($sum_dad,3).'</td>
	 <td align="right">جمع مقدار تحویلی : '.round($sum_tahvily_dad_id,3).'</td>
     <td align="right">جمع ابطالی : '.round($sum_ebtal_detail,3).'</td>
     <td align="right">جمع مانده : '.round($sum_mande_forush_detail,3).'</td>
	 <td>&nbsp;</td>
	</tr>
   </table>
   </div>
  </td>
 </tr>
</table>
</div> 
 <!--پايان مرکز صفحه -->
 <table style="position:fixed;bottom:-2px;left:0.5%" width="99%"> 
  <tr class="footer">
 <!-- فوتر-->
 <td align="center" ><div onClick="window.location=\'havale_forush.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back"  title="بازگشت"  ><a href="#"></a></div></td> </tr>
</table>
 <!-- پايان فوتر-->';
echo'	

</form>
</body>
</html>';
?>