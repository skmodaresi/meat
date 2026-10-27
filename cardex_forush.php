<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="cardex_forush.php";
$titr='کنترل کاردکس حواله فروش';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.h_code.focus();">
<form method="post" name="myform">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">کنترل کاردکس حواله فروش</td>	 
 </tr>
 <!--پايان هدر-->';
/**نمایش اطلاعات در حالت سیستم سردخانه**/	
if($_SESSION['mt_systemforush']==0)
{
echo'
<!-- مرکز صفحه-->
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
	<tr class="tr1">
     <td align="left"> شماره حواله فروش : </td>
     <td align="right" colspan="6">&nbsp;<input type="text" class="textboxme2" name="h_code" value="'.$h_code.'" onkeypress="return isNumber(event)"/>&nbsp;';
       include ("img_helphavaleforush_report.php");
	 echo'&nbsp;<input type="submit" class="buttonme" name="ok" value="گزارش"></td>';
	 if($h_code)echo'<td align="center"><div onClick="window.open(\'print_cardex_forush.php?h_code_='.$h_code.'\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ کاردکس فروش"><a href="#"></a></div></td>';
	 else echo '<td>&nbsp;</td>';
	echo'
	</tr>';
	if($ok)
	{
	 $h_daterange=$db->get_from_where("h_reg_date","havale_forush","h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
	 //اگر تاریخ این شماره حواله فروش بعد از تاریخ شروع سال بود
	 if($h_daterange>=$mtStartDateSh)
	 {$q1="SELECT *,
	       (SELECT name_kala FROM kala WHERE code_kala=h_f.code_kala)nameKala,
	       (SELECT code_bastebandy FROM kala WHERE code_kala=h_f.code_kala)codeBastebandy, 		   
	       (SELECT name_customer FROM moshtary WHERE code_customer=h_f.code_customer)nameMoshtary, 
	       (SELECT name_ostan FROM ostan WHERE code_ostan=h_f.code_ostan)nameOstan, 
	       (SELECT name_anbar FROM list_sardkhane WHERE code_anbar=h_f.code_anbar AND code_ostan='$mt_gl_code_ostan')nameMahalTahvil,
           (SELECT SUM(meghdar_batele) FROM ebtal WHERE h_code=h_f.h_code AND code_ostan=h_f.code_ostan AND code_anbar=h_f.code_anbar AND year=h_f.year AND deleted=0)meghdar_batele 
	       FROM havale_forush as h_f WHERE h_code='$h_code' AND h_f.h_reg_date>='$mtStartDateSh' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";	
	   $res1 = $db->query($q1);
	   $row1=$db->fetch_assoc($res1);
	   //محاسبه مقدار تحویلی
	   $meghdar_tahvily=tahvily_az_forush($row1['h_code'],$row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['codeBastebandy'],$row1['code_kala']);
         /**///محاسبه مقدار مانده از حواله فروش
	     //$mande_az_forush=$row1['meghdar_havale_forush']-$meghdar_tahvily-$meghdar_batele;
	 }
	}
	echo'
	<tr class="tr1">
	 <td align="left"> کد کالا : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="code_kala" value="'.$row1['code_kala'].'"/></td>
	 <td align="left"> نام کالا : </td>
     <td align="right" colspan="3">&nbsp;<input type="text" readonly class="textboxme" name="name_kala" value="'.$row1['nameKala'].'" style="width:95%"/></td>
	 <td colspan="2" align="right">'; 
	 if($row1['codeBastebandy']==1)echo'<input type="text" name="rahnama" id="rahnama" value=" (کیلوگرم)" class="rahnama"/>';
     if($row1['codeBastebandy']==2)echo'<input type="text" name="rahnama" id="rahnama" value=" (تعداد)" class="rahnama"/>';
	 echo'
	 </td>
	</tr>
	<tr class="tr1">
     <td align="left"> کد مشتری : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="code_customer" value="'.$row1['code_customer'].'"/></td>
     <td align="left"> نام مشتری : </td>
     <td align="right" colspan="3">&nbsp;<input type="text" readonly class="textboxme2" name="name_customer" value="'.$row1['nameMoshtary'].'" style="width:95%;"/></td>
     <td colspan="2">&nbsp;</td>
	</tr>
	<tr class="tr1">
     <td align="left"> کد استان : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="code_ostan" value="'.$row1['code_ostan'].'"/></td>
     <td align="left"> نام استان : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="name_ostan" value="'.$row1['nameOstan'].'"/></td>
     <td align="left" colspan="3"> سردخانه محل تحویل کالا : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="name_mahal_tahvil" value="'.$row1['nameMahalTahvil'].'"/></td>
	</tr> 
    <tr class="tr1">
     <td align="left" width="120px">مقدار حواله فروش  : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="meghdar_havale_forush" value="'.($row1['meghdar_havale_forush']).'"/></td>
	 <td align="left" width="130px">مقدار تحویلی از حواله : </td>
	 <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="meghdar_tahvily" value="'.round($meghdar_tahvily,3).'"/></td>
	 <td align="left" width="80px">مقدار باطله : </td>
	 <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="meghdar_batele" value="'.($row1['meghdar_batele']).'"/></td>
	 <td align="left" width="150px">مقدار مانده از حواله فروش : </td>
	 <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="mande_az_forush" value="'.($row1['mande_az_forush']).'"/></td>
	</tr>
   </table>
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	<tr class="table-title">
	 <td width="5%">ردیف</td>
	 <td width="15%">تاریخ حواله سردخانه</td>
	 <td width="15%">شماره حواله سردخانه</td>
	 <td width="10%">وضعیت</td>
	 <td width="20%">مقدار ابطالی حواله سردخانه</td>
	 <td width="20%">مقدار تحویلی</td>
	 <td width="15%">مانده</td>
	</tr>';
	if($ok)
	{ 
	  $radif=1;	
	  $h_daterange=$db->get_from_where("h_reg_date","havale_forush","h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
	  //اگر تاریخ این شماره حواله فروش بعد از تاریخ شروع سال بود
	  if($h_daterange>=$mtStartDateSh)
	  {$i=0;	  
	   $q2="SELECT * FROM havale WHERE h_code='$h_code' AND tarikh_havale_anbar>='$mtStartDateSh' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by tarikh_havale_anbar";
	   $res2=$db->query($q2);
	   //$mande=$row1['meghdar_havale_forush'];
	   //$mande-=$row1['meghdar_batele'];//مقدار باطله را نیز همینجا از حواله فروش کم می کنم       
	   //$mande=$row1['meghdar_tahvily']+$row1['mande_az_forush'];
	   $mande=$meghdar_tahvily+$row1['mande_az_forush'];
	   while($row2=$db->fetch_assoc($res2))
	   {
        if($row2['status']==0) $vaziyat='جاری';
	    if($row2['status']==1) $vaziyat='ابطالی';
		if($i++%2)echo'<tr class="table-odd"/>';
        else echo'<tr class="table-even"/>';
	    //اضافه کردن صفر پشت کد استان
	     if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
         else $code_a=$row2['code_ostan'];	
	    echo'
		 <td>'.$radif++.'</td>
	     <td>'.$row2['tarikh_havale_anbar'].'</td>
	     <td>'.$code_a.$row2['code_anbar'].$row2['shomare_havale_anbar'].'</td>
		 <td>'.$vaziyat.'</td>';
	     if($row1['codeBastebandy']==2)
		 {
		   if($row2['status']==0)//اگر حواله جاری است
		   {
	  	     echo '<td>-</td>
	  	        <td>'.round($row2['tedad_karton_h'],3).'</td>';
	  	  	  $mande-=$row2['tedad_karton_h'];
	         echo '<td>'.round($mande,3).'</td>';
	  	   }
	  	   else//اگر حواله ابطالی است
		   {
		     echo'<td>'.round($row2['tedad_karton_h'],3).'</td>
                 <td>-</td>';
	  	     echo'<td>'.round($mande,3).'</td>';
	       }
		 }
		 else if(($row1['code_kala']==50)or($row1['code_kala']==54))
		 {
		   if($row2['code_kala']==50) $tedad_shane_h=$row2['tedad_karton_h']*$_SESSION["mtShane"];
		   else if($row2['code_kala']==54) $tedad_shane_h=$row2['tedad_karton_h']*$_SESSION["mtShane_dakheli"];
		   if($row2['status']==0)//اگر حواله جاری است
		   {
	  	     echo '<td>-</td>
	  	        <td>'.round($tedad_shane_h,3).'</td>';
	  	  	  $mande-=$tedad_shane_h;
	         echo '<td>'.round($mande,3).'</td>';
	  	   }
	  	   else//اگر حواله ابطالی است
		   {
		     echo'<td>'.round($tedad_shane_h,3).'</td>
                 <td>-</td>';
	  	     echo'<td>'.round($mande,3).'</td>';
	       }
		 }
		 else
         {
		  if($row2['status']==0)//حواله جاری است
		  {
		   //وزن خالص حواله با استفاده از تابع
	        //$detail_havale=havale_detail($row2['shomare_havale_anbar'],$row2['code_ostan'],$row2['code_anbar'],$row2['year']);
	        //$detail_row=mysql_fetch_assoc($detail_havale);
		   // echo '<td>-</td>
		         // <td>'.($detail_row['sum_khales_h']).'</td>';
		  	   // $mande-=$detail_row['sum_khales_h'];
	       // echo '<td>'.($mande).'</td>';
		   echo '<td>-</td>
		         <td>'.round($row2['vazn_khales_h'],3).'</td>';
		  	   $mande-=$row2['vazn_khales_h'];
	       echo '<td>'.round($mande,3).'</td>';
		  }
		  else//حواله ابطالی است
		  {
		   //وزن خالص حواله با استفاده از تابع
	        // $detail_havale=havale_detail($row2['shomare_havale_anbar'],$row2['code_ostan'],$row2['code_anbar'],$row2['year']);
	        // $detail_row=mysql_fetch_assoc($detail_havale);
		   // echo'<td>'.($detail_row['sum_khales_h']).'</td>
               // <td>-</td>';
		   // echo'<td>'.($mande).'</td>';
		   echo'<td>'.round($row2['vazn_khales_h'],3).'</td>
               <td>-</td>';
		   echo'<td>'.round($mande,3).'</td>';
	      }
		 }
	  echo '
	  </tr>';
	   }
	  }
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
}
/**نمایش اطلاعات در حالت سیستم فروش**/	
if($_SESSION['mt_systemforush']==1)
{
  mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
  // //پیدا کردن آی دی کد استان مربوط به سیتم فروش
   // $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
   // $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
  // //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
   // $res_anbar=mysql_query("SELECT l_id FROM dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code='$mt_gl_code_anbar'");
   // $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
  // //پیدا کردن آی دی سال مربوط به سیستم فروش
   // $sellYearCode=substr($mtActiveYear,2);
   // $res_sal=mysql_query("SELECT year_id FROM dm_year WHERE year_code='$sellYearCode'");
   // $sellYearId=mysql_result($res_sal, 0, 'year_id');
 echo'
 <!-- مرکز صفحه-->
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
	<tr class="tr1">
     <td align="left"> شماره حواله فروش : </td>
     <td align="right" colspan="6">&nbsp;<input type="text" class="textboxme2" name="h_code" value="'.$h_code.'" onkeypress="return isNumber(event)"/>';
	 include ("img_helphavaleforush_report.php");
	 echo' <input type="submit" class="buttonme" name="ok" value="گزارش"></td>';
	 if($h_code)echo'<td align="center"><div onClick="window.open(\'print_cardex_forush.php?h_code_='.$h_code.'\',\'\',\'\')" id="printer_T" title="چاپ کاردکس فروش"><a href="#"></a></div></td>';
	 else echo '<td>&nbsp;</td>';
	 echo'
	</tr>';
    if($ok)
	{
	  $h_daterange=$db->get_from_where("h_reg_date","dm_havale","h_code='$h_code' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'");
	  //اگر تاریخ این شماره حواله فروش بعد از تاریخ شروع سال بود
	  if($h_daterange>=$mtzStartDateMi)
      {  // $q1="SELECT dm_havale.*,dm_customer_asli.name_customer,dm_province.province_code,dm_province.province_name,dm_location_goods.l_code, 
                    // dm_location_goods.l_code
	   			 // FROM dm_havale         
	   					 // LEFT OUTER JOIN dm_customer_asli ON dm_havale.h_customer_code=dm_customer_asli.code_customer
	   					 // LEFT OUTER JOIN dm_province ON dm_customer_asli.customer_province_id=dm_province.province_id
	   					 // LEFT OUTER JOIN dm_location_goods ON dm_location_goods.l_id=dm_havale.h_l_code
	   					 // WHERE dm_havale.h_code='$h_code' AND dm_havale.h_id_province='$sell_id_ostan' AND dm_havale.h_l_code='$sell_id_anbar' AND dm_havale.h_id_year='$sellYearId'";	
	    $q1="SELECT dm_havale.*,dm_customer_asli.name_customer,dm_province.province_code,dm_location_goods.l_code,kala.name_kala,kala.code_bastebandy 
		  FROM sell.dm_havale
	      INNER JOIN meat.kala ON kala.code_kala=dm_havale.h_p_code		  
	   	  LEFT OUTER JOIN sell.dm_customer_asli ON dm_havale.h_customer_code=dm_customer_asli.code_customer
	   	  LEFT OUTER JOIN sell.dm_province ON dm_havale.h_id_province=dm_province.province_id
	   	  LEFT OUTER JOIN sell.dm_location_goods ON dm_havale.h_l_code=dm_location_goods.l_id
	   	  WHERE dm_havale.h_code='$h_code' AND dm_havale.h_reg_date>='$mtzStartDateMi' AND dm_havale.h_id_province='$sell_id_ostan' AND dm_havale.h_l_code='$sell_id_anbar' AND dm_havale.h_id_year='$sellYearId'";
	    $res1 = $db->query($q1);
	    $row1=$db->fetch_assoc($res1);
	    //مجموع مقدار ابطالی های این حواله فروش در سیستم فروش
	    $q_ebtalha="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id  WHERE his_h_code=".$row1['h_code']." AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' And h_id_year='$sellYearId'";	   
	    $res_ebtalha=mysql_query($q_ebtalha);
	    $row_ebtalha=mysql_fetch_array($res_ebtalha);
	    $batele_forush=$row_ebtalha[0];
		
	   /*اطلاعات لازم از سیستم انبار*/ 
          mysql_select_db("$mydatabase") or die('no Select Db BECAUSE: ' . mysql_error()); 
		//نام کالا از سیستم انبار
          // $res_kala=mysql_query("SELECT name_kala FROM kala WHERE code_kala=".$row1['h_p_code']."");
          // $row_kala=mysql_fetch_assoc($res_kala);
	      // $nameKALA=$row_kala['name_kala'];
        //نام استان از سیستم انبار     
	      $res_ostan=mysql_query("SELECT name_ostan FROM ostan WHERE code_ostan=".$row1['province_code']."");
          $row_ostan=mysql_fetch_assoc($res_ostan);
	      $nameOSTAN=$row_ostan['name_ostan'];
	    //نام انبار از سیستم انبار 
          $res_anbar=mysql_query("SELECT name_anbar FROM list_sardkhane WHERE code_anbar=".$row1['l_code']." AND code_ostan=".$row1['province_code']."");
          $row_anbar=mysql_fetch_assoc($res_anbar);
	      $nameANBAR=$row_anbar['name_anbar'];
	    //محاسبه مقدار تحویلی
	      $meghdar_tahvily=tahvily_az_forush($h_code,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$row1['code_bastebandy'],$row1['h_p_code']);
		  //$meghdar_tahvily=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail","h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	    /**///محاسبه مقدار مانده از فروش
        //$mande_az_forush=$row1['h_pre_amount']-$meghdar_tahvily-$batele_forush;//محاسبه مقدار مانده از حواله فروش
	  }
	}
	echo'
    <tr class="tr1">
	 <td align="left"> کد کالا : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="code_kala" value="'.$row1['h_p_code'].'"/></td>
	 <td align="left"> نام کالا : </td>
     <td align="right" colspan="3">&nbsp;<input type="text" readonly class="textboxme" name="name_kala" value="'.$row1['name_kala'].'" style="width:95%"/></td>
	 <td colspan="2">&nbsp;</td>
	</tr>
	<tr class="tr1">
	 <td align="left"> کد مشتری : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="code_customer" value="'.$row1['h_customer_code'].'"/></td>
     <td align="left"> نام مشتری : </td>
     <td align="right" colspan="3">&nbsp;<input type="text" readonly class="textboxme2" name="name_customer" value="'.$row1['name_customer'].'" style="width:95%;"/></td>
     <td colspan="2">&nbsp;</td>';
    echo'
	</tr>
	<tr class="tr1">
     <td align="left"> کد استان : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="code_ostan" value="'.$row1['province_code'].'"/></td>
     <td align="left"> نام استان : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="name_ostan" value="'.$nameOSTAN.'"/></td>
     <td align="left" colspan="3"> سردخانه محل تحویل کالا : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="name_mahal_tahvil" value="'.$nameANBAR.'"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left" width="120px">مقدار حواله فروش  : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="meghdar_havale_forush" value="'.($row1['h_pre_amount']).'"/></td>
	 <td align="left" width="130px">مقدار تحویلی از حواله : </td>
	 <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="meghdar_tahvily" value="'.round($meghdar_tahvily,3).'"/></td>
	 <td align="left" width="80px">مقدار باطله : </td>
	 <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="meghdar_batele" value="'.($batele_forush).'"/></td>
	 <td align="left" width="150px">مقدار مانده از حواله فروش : </td>
	 <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="mande_az_forush" value="'.($row1['h_mande_havale']).'"/></td>
	</tr>
   </table>
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	<tr class="table-title">
	 <td width="5%">ردیف</td>
	 <td width="15%">تاریخ حواله سردخانه</td>
	 <td width="15%">شماره حواله سردخانه</td>
	 <td width="10%">وضعیت</td>
	 <td width="20%">مقدار ابطالی حواله سردخانه</td>
	 <td width="20%">مقدار تحویلی</td>
	 <td width="15%">مانده</td>
	</tr>';
	if($ok)
	{
      $radif=1;
	  mysql_select_db("sell") or die('no Select Db BECAUSE: ' . mysql_error()); 
	  $h_daterange=$db->get_from_where("h_reg_date","dm_havale","h_code='$h_code' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'");
	  //اگر تاریخ این شماره حواله فروش بعد از تاریخ شروع سال بود
	  //echo $h_daterange.'<br/>';
	  //echo $mtzStartDateMi;
	  if($h_daterange>=$mtzStartDateMi)	
	  {
       mysql_select_db("$mydatabase") or die('no Select Db BECAUSE: ' . mysql_error()); 	  
	   $i=0;	  
	   $q2="SELECT * FROM havale WHERE h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by tarikh_havale_anbar";
	   $res2=$db->query($q2);
	   //$mande=$row1['h_pre_amount'];
       //$mande-=$batele_forush;
       $mande=$meghdar_tahvily+$row1['h_mande_havale']; 	   	   
       while($row2=$db->fetch_assoc($res2))
	   {
         if($row2['status']==0) $vaziyat='جاری';
	     if($row2['status']==1) $vaziyat='ابطالی';
		 if($i++%2)echo'<tr class="table-odd"/>';
         else echo'<tr class="table-even"/>';
	     //اضافه کردن صفر پشت کد استان
	     	if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
          else $code_a=$row2['code_ostan'];
	     echo'
		  <td>'.$radif++.'</td>
	      <td>'.$row2['tarikh_havale_anbar'].'</td>
	      <td>'.$code_a.$row2['code_anbar'].$row2['shomare_havale_anbar'].'</td>
		  <td>'.$vaziyat.'</td>';
	  	 if($row1['code_bastebandy']==2)
		 {
		   if($row2['status']==0)//اگر حواله جاری است
		   {
	  	     echo '<td>-</td>
	  	        <td>'.round($row2['tedad_karton_h'],3).'</td>';
	  	  	  $mande-=$row2['tedad_karton_h'];
	         echo '<td>'.round($mande,3).'</td>';
	  	   }
	  	   else//اگر حواله ابطالی است
		   {
		     echo'<td>'.round($row2['tedad_karton_h'],3).'</td>
                 <td>-</td>';
	  	     echo'<td>'.round($mande,3).'</td>';
	       }
		 }
		 else if(($row1['h_p_code']==50)or($row1['h_p_code']==54))
		 {
		   if($row2['code_kala']==50) $tedad_shane_h=$row2['tedad_karton_h']*$_SESSION["mtShane"];
		   else if($row2['code_kala']==54) $tedad_shane_h=$row2['tedad_karton_h']*$_SESSION["mtShane_dakheli"];
		   if($row2['status']==0)//اگر حواله جاری است
		   {
	  	     echo '<td>-</td>
	  	        <td>'.round($tedad_shane_h,3).'</td>';
	  	  	  $mande-=$tedad_shane_h;
	         echo '<td>'.round($mande,3).'</td>';
	  	   }
	  	   else//اگر حواله ابطالی است
		   {
		     echo'<td>'.round($tedad_shane_h,3).'</td>
                 <td>-</td>';
	  	     echo'<td>'.round($mande,3).'</td>';
	       }
		 }
		 else
		 {
		   if($row2['status']==0)//اگر حواله جاری است
		   {
	  	     echo '<td>-</td>
	  	        <td>'.round($row2['vazn_khales_h'],3).'</td>';
	  	  	  $mande-=$row2['vazn_khales_h'];
	         echo '<td>'.round($mande,3).'</td>';
	  	   }
	  	   else//اگر حواله ابطالی است
		   {
		     echo'<td>'.round($row2['vazn_khales_h'],3).'</td>
                 <td>-</td>';
	  	     echo'<td>'.round($mande,3).'</td>';
	       }
		 }

	   echo '
	   </tr>';
	   }
	  }
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';	
}	
 echo'
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">    			
	<tr>
	 <td width="10px">&nbsp;</td>
	</tr>
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->';
echo'	
</table>
</div>
</form>
</body>
</html>';	
?>