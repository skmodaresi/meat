<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="cardex_forush.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ کاردکس حواله فروش</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
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
<script type="text/javascript" src="functions.js"></script>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<br/>
<!--هدر-->
<table width="99%" height="100%" align="center" cellpadding="0" border="1" cellspacing="0">
 <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
 <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
 <tr><td class="print_title_2"> کنترل کاردکس  حواله فروش شماره '.$h_code_.'&nbsp&nbsp(صفحه : 1)
	   <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText--hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
	  </td>
 </tr>
</table>
<!--پايان هدر-->';
/**نمایش اطلاعات در حالت سیستم انبار**/	
if($_SESSION['mt_systemforush']==0)
{
	   $q1="SELECT *,
	       (SELECT name_kala FROM kala WHERE code_kala=h_f.code_kala)nameKala, 
	       (SELECT name_customer FROM moshtary WHERE code_customer=h_f.code_customer AND code_ostan='$mt_gl_code_ostan')nameMoshtary, 
	       (SELECT name_ostan FROM ostan WHERE code_ostan=h_f.code_ostan)nameOstan, 
	       (SELECT name_anbar FROM list_sardkhane WHERE code_anbar=h_f.code_anbar AND code_ostan='$mt_gl_code_ostan')nameMahalTahvil,
           (SELECT SUM(vazn_khales_h_d) FROM havale_detail WHERE h_code=h_f.h_code AND code_ostan=h_f.code_ostan AND code_anbar=h_f.code_anbar AND year=h_f.year AND havale_deleted=0 AND status=0)meghdar_tahvily,
           (SELECT SUM(meghdar_batele) FROM ebtal WHERE h_code=h_f.h_code AND code_ostan=h_f.code_ostan AND code_anbar=h_f.code_anbar AND year=h_f.year AND deleted=0)meghdar_batele 
	       FROM havale_forush as h_f WHERE h_code='$h_code_' AND h_f.h_reg_date>='$mtStartDateSh' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";	
	   $res1 = $db->query($q1);
	   $row1=$db->fetch_assoc($res1);
	   /**///محاسبه مقدار باطله
       //$meghdar_batele=$db->get_from_where("SUM(meghdar_batele)","ebtal","h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
       /**///محاسبه مقدار مانده از حواله فروش
	   //$mande_az_forush=$row1['meghdar_havale_forush']-$meghdar_tahvily-$meghdar_batele;
   echo'
   <!-- مرکز صفحه-->
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr class="tr1">
     <td align="right"> شماره حواله فروش : '.$h_code_.'&nbsp;</td>
	 <td align="right"> کد مشتری : '.$row1['code_customer'].'</td>
     <td align="right" colspan="3"> نام مشتری : '.$row1['nameMoshtary'].'</td>';
    echo'
	</tr>
	<tr class="tr1">
     <td align="right"> کد استان : '.$row1['code_ostan'].'</td>
     <td align="right"> نام استان : '.$row1['nameOstan'].'</td>
     <td align="right"> کد کالا : '.$row1['code_kala'].'</td>
	 <td align="right" colspan="2"> نام کالا : '.$row1['nameKala'].'</td>
	</tr>
    <tr class="tr1">
     <td align="right" colspan=""> سردخانه محل تحویل کالا : '.$row1['nameMahalTahvil'].'</td>
     <td align="right">مقدار حواله فروش  : '.($row1['meghdar_havale_forush']).'</td>
	 <td align="right">مقدار تحویلی از حواله : '.($row1['meghdar_tahvily']).'</td>
	 <td align="right">مقدار باطله : '.($row1['meghdar_batele']).'</td>
	 <td align="right">مقدار مانده از حواله فروش : '.($row1['mande_az_forush']).'</td>
	</tr>
   </table>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	<tr class="print_table-title">
	   <td width="5%">ردیف</td>
	   <td width="20%">تاریخ حواله سردخانه</td>
	   <td width="20%">شماره حواله سردخانه</td>
	   <td width="20%">مقدار ابطالی حواله سردخانه</td>
	   <td width="20%">مقدار تحویلی</td>
	   <td width="15%">مانده</td>
	</tr>';
	$page=1;
    $line=0;
    $i=0;$cntr=0;
    $MaxLines=15;
	$radif=1;	
	  $q2="SELECT * FROM havale WHERE h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by tarikh_havale_anbar";
	  $res2=$db->query($q2);
	  $cntr =mysql_num_rows($res2);
	  //$mande=$row1['meghdar_havale_forush'];
	  //$mande-=$row1['meghdar_batele'];//مقدار باطله را نیز همینجا از حواله فروش کم می کنم       
	  $mande=$row1['meghdar_tahvily']+$row1['mande_az_forush'];
	  while($row2=$db->fetch_assoc($res2))
	  {
	   $line++;
       if($i++%2)echo'<tr class="print_table-odd"/>';
       else echo'<tr class="print_table-even"/>';
	   //اضافه کردن صفر پشت کد استان
	    if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
        else $code_a=$row2['code_ostan'];	
	   echo'
	   	<td>'.$radif++.'</td>
	    <td>'.$row2['tarikh_havale_anbar'].'</td>
	    <td>'.$code_a.$row2['code_anbar'].$row2['shomare_havale_anbar'].'</td>';
		if($row2['status']==0)//حواله جاری است
		{
		 //وزن خالص حواله با استفاده از تابع
	      // $detail_havale=havale_detail($row2['shomare_havale_anbar'],$row2['code_ostan'],$row2['code_anbar'],$row2['year']);
	      // $detail_row=mysql_fetch_assoc($detail_havale);
		 // echo '<td>-</td>
		       // <td>'.virgul($detail_row['sum_khales_h']).'</td>';
			   // $mande-=$detail_row['sum_khales_h'];
	     echo '<td>-</td>
		       <td>'.($row2['vazn_khales_h']).'</td>';
			   $mande-=$row2['vazn_khales_h'];		   
	     echo '<td>'.($mande).'</td>';
		}
		else//حواله ابطالی است
		{
		 //وزن خالص حواله با استفاده از تابع
	      // $detail_havale=havale_detail($row2['shomare_havale_anbar'],$row2['code_ostan'],$row2['code_anbar'],$row2['year']);
	      // $detail_row=mysql_fetch_assoc($detail_havale);
		 // echo'<td>'.virgul($detail_row['sum_khales_h']).'</td>
             // <td>-</td>';
		 echo'<td>'.($row2['vazn_khales_h']).'</td>
             <td>-</td>';
		 echo'<td>'.($mande).'</td>';
	    }
	  echo '
	  </tr>';
	  if($line>=$MaxLines && $i <$cntr) 
	  {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">
           <table width="99%" border="1" align="center">
            <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
            <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
            <tr><td class="print_title_2"> کنترل کاردکس  حواله فروش شماره '.$h_code_.'&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	        <tr class="print_table-title">
	         <td width="5%">ردیف</td>
	         <td width="15%">تاریخ حواله سردخانه</td>
	         <td width="15%">شماره حواله سردخانه</td>
	         <td width="10%">وضعیت</td>
	         <td width="20%">مقدار ابطالی حواله سردخانه</td>
	         <td width="20%">مقدار تحویلی</td>
	         <td width="15%">مانده</td>
	        </tr>';
	   }	
	  }//END while
	echo'
	</table>
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
 
	 $h_daterange=$db->get_from_where("h_reg_date","dm_havale","h_code='$h_code_' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'");
	 //اگر تاریخ این شماره حواله فروش بعد از تاریخ شروع سال بود
	 if($h_daterange>=$mtStartDateMi)
	 {
	  $q1="SELECT dm_havale.*,dm_customer_asli.name_customer,dm_province.province_code,dm_location_goods.l_code,kala.name_kala,kala.code_bastebandy 
		  FROM sell.dm_havale
	      INNER JOIN meat.kala ON kala.code_kala=dm_havale.h_p_code		  
	   	  LEFT OUTER JOIN sell.dm_customer_asli ON dm_havale.h_customer_code=dm_customer_asli.code_customer
	   	  LEFT OUTER JOIN sell.dm_province ON dm_havale.h_id_province=dm_province.province_id
	   	  LEFT OUTER JOIN sell.dm_location_goods ON dm_havale.h_l_code=dm_location_goods.l_id
	   	  WHERE dm_havale.h_code='$h_code_' AND dm_havale.h_reg_date>='$mtzStartDateMi' AND dm_havale.h_id_province='$sell_id_ostan' AND dm_havale.h_l_code='$sell_id_anbar' AND dm_havale.h_id_year='$sellYearId'";
	  $res1 = $db->query($q1);
	  $row1=$db->fetch_assoc($res1);
	  //مجموع مقدار ابطالی های این حواله فروش در سیستم فروش
	 $q_ebtalha="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id  WHERE his_h_code=".$row1['h_code']." AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' And h_id_year='$sellYearId'";	   
	 //$q_ebtalha="SELECT SUM(his_eb_amount) FROM dm_his_havale WHERE his_h_code=".$row1['h_code']." AND his_id_province='$sell_id_ostan' AND his_l_code='$sell_id_anbar' And his_id_year='$sellYearId'";	   
	 $res_ebtalha=mysql_query($q_ebtalha);
	 $row_ebtalha=mysql_fetch_array($res_ebtalha);
	 $batele_forush=$row_ebtalha[0];
	/*اطلاعات لازم از سیستم انبار*/ 
      mysql_select_db("$mydatabase") or die('no Select Db BECAUSE: ' . mysql_error()); 
     //نام کالا از سیستم انبار
       $res_kala=mysql_query("SELECT name_kala FROM kala WHERE code_kala=".$row1['h_p_code']."");
       $row_kala=mysql_fetch_assoc($res_kala);
	   $nameKALA=$row_kala['name_kala'];
     //نام استان از سیستم انبار     
	   $res_ostan=mysql_query("SELECT name_ostan FROM ostan WHERE code_ostan=".$row1['province_code']."");
       $row_ostan=mysql_fetch_assoc($res_ostan);
	   $nameOSTAN=$row_ostan['name_ostan'];
	 //نام انبار از سیستم انبار 
       $res_anbar=mysql_query("SELECT name_anbar FROM list_sardkhane WHERE code_anbar=".$row1['l_code']." AND code_ostan=".$row1['province_code']."");
       $row_anbar=mysql_fetch_assoc($res_anbar);
	   $nameANBAR=$row_anbar['name_anbar'];
	 //محاسبه مقدار تحویلی
	   $meghdar_tahvily=tahvily_az_forush($h_code_,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$row1['code_bastebandy']);
       //$meghdar_tahvily=$db->get_from_where("SUM(vazn_khales_h)","havale","h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
     /**///محاسبه مقدار مانده از فروش
     //$mande_az_forush=$row1['h_pre_amount']-$meghdar_tahvily-$batele_forush;//محاسبه مقدار مانده از حواله فروش
	}
	echo'
    <!-- مرکز صفحه-->
    <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0">
     <tr class="tr1">
      <td align="right"> شماره حواله فروش : '.$h_code_.'</td>
	  <td align="right"> کد مشتری : '.$row1['h_customer_code'].'</td>
      <td align="right" colspan="3"> نام مشتری : '.$row1['name_customer'].'</td>
     </tr>
	 <tr class="tr1">
      <td align="right"> کد استان : '.$row1['province_code'].'</td>
      <td align="right"> نام استان : '.$nameOSTAN.'</td>
      <td align="right"> کد کالا : '.$row1['h_p_code'].'</td>
	  <td align="right" colspan="2"> نام کالا : '.$nameKALA.'</td>
	 </tr>
     <tr class="tr1">
      <td align="right"> سردخانه محل تحویل کالا : '.$nameANBAR.'</td>
      <td align="right">مقدار حواله فروش  : '.($row1['h_pre_amount']).'</td>
	  <td align="right">مقدار تحویلی از حواله : '.($meghdar_tahvily).'</td>
	  <td align="right">مقدار باطله : '.($batele_forush).'</td>
	  <td align="right">مقدار مانده از حواله فروش : '.($row1['h_mande_havale']).'</td>
	 </tr>
    </table>
    <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	 <tr class="print_table-title">
	  <td width="5%">ردیف</td>
	  <td width="15%">تاریخ حواله سردخانه</td>
	  <td width="15%">شماره حواله سردخانه</td>
	  <td width="10%">وضعیت</td>
	  <td width="20%">مقدار ابطالی حواله سردخانه</td>
	  <td width="20%">مقدار تحویلی</td>
	  <td width="15%">مانده</td>
	 </tr>';
	mysql_select_db("sell") or die('no Select Db BECAUSE: ' . mysql_error()); 
	$h_daterange=$db->get_from_where("h_reg_date","dm_havale","h_code='$h_code_' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'");
	if($h_daterange>=$mtStartDateMi)	
	{
      mysql_select_db("$mydatabase") or die('no Select Db BECAUSE: ' . mysql_error()); 	  
	  $page=1;
      $line=0;
      $i=0;$cntr=0;
      $MaxLines=15;
	  $radif=1; 
	  $q2="SELECT * FROM havale WHERE h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by tarikh_havale_anbar";
	  $res2=$db->query($q2);
	  $cntr =mysql_num_rows($res2);
	  //$mande=$row1['h_pre_amount'];
      //$mande-=$batele_forush;
      $mande=$meghdar_tahvily+$row1['h_mande_havale'];	  	  
      while($row2=$db->fetch_assoc($res2))
	  {
       $line++;
	   if($row2['status']==0) $vaziyat='جاری';
	   if($row2['status']==1) $vaziyat='ابطالی';
	   if($i++%2)echo'<tr class="print_table-odd"/>';
       else echo'<tr class="print_table-even"/>';
	   //اضافه کردن صفر پشت کد استان
	   	if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
        else $code_a=$row2['code_ostan'];
	   echo'
	   	<td>'.$radif++.'</td>
	    <td>'.$row2['tarikh_havale_anbar'].'</td>
	    <td>'.$code_a.$row2['code_anbar'].$row2['shomare_havale_anbar'].'</td>
		<td>'.$vaziyat.'</td>';
	  	if(($row1['code_bastebandy']==1)OR($row1['code_bastebandy']==3))
		 {
		   if($row2['status']==0)//اگر حواله جاری است
		   {
		     //وزن خالص حواله با استفاده از تابع
	         // $detail_havale=havale_detail($row2['shomare_havale_anbar'],$row2['code_ostan'],$row2['code_anbar'],$row2['year']);
	         // $detail_row=mysql_fetch_assoc($detail_havale);
	  	     // echo '<td>-</td>
	  	        // <td>'.virgul($detail_row['sum_khales_h']).'</td>';
	  	  	  // $mande-=$detail_row['sum_khales_h'];
	         // echo '<td>'.virgul($mande).'</td>';
	  	     echo '<td>-</td>
	  	        <td>'.round($row2['vazn_khales_h'],3).'</td>';
	  	  	  $mande-=$row2['vazn_khales_h'];
	         echo '<td>'.round($mande,3).'</td>';
	  	   }
	  	   else//اگر حواله ابطالی است
		   {
	  	     //وزن خالص حواله با استفاده از تابع
	         // $detail_havale=havale_detail($row2['shomare_havale_anbar'],$row2['code_ostan'],$row2['code_anbar'],$row2['year']);
	         // $detail_row=mysql_fetch_assoc($detail_havale);
		     // echo'<td>'.virgul($detail_row['sum_khales_h']).'</td>
                  // <td>-</td>';
	  	     // echo'<td>'.virgul($mande).'</td>';
		     echo'<td>'.round($row2['vazn_khales_h'],3).'</td>
                 <td>-</td>';
	  	     echo'<td>'.round($mande,3).'</td>';
	       }
		 }
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
		 
		 // if($row2['status']==0)//اگر حواله جاری است
		 // {
		   // // //وزن خالص حواله با استفاده از تابع
	       // // $detail_havale=havale_detail($row2['shomare_havale_anbar'],$row2['code_ostan'],$row2['code_anbar'],$row2['year']);
	       // // $detail_row=mysql_fetch_assoc($detail_havale);
	  	   // // echo '<td>-</td>
	  	      // // <td>'.virgul($detail_row['sum_khales_h']).'</td>';
	  		  // // $mande-=$detail_row['sum_khales_h'];
		  // echo '<td>-</td>
	  	        // <td>'.($row2['vazn_khales_h']).'</td>';
	  		  // $mande-=$row2['vazn_khales_h'];
	       // echo '<td>'.($mande).'</td>';
	  	 // }
	  	 // else//اگر حواله ابطالی است
		 // {
	  	   // //وزن خالص حواله با استفاده از تابع
	       // // $detail_havale=havale_detail($row2['shomare_havale_anbar'],$row2['code_ostan'],$row2['code_anbar'],$row2['year']);
	       // // $detail_row=mysql_fetch_assoc($detail_havale);
		   // // echo'<td>'.virgul($detail_row['sum_khales_h']).'</td>
                // // <td>-</td>';
		   // echo'<td>'.($row2['vazn_khales_h']).'</td>
                // <td>-</td>';
	  	   // echo'<td>'.($mande).'</td>';
	     // }
	  echo '
	  </tr>';
	  if($line>=$MaxLines && $i <$cntr) 
	  {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">
           <table width="99%" border="1" align="center">
            <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
            <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
            <tr><td class="print_title_2"> کنترل کاردکس  حواله فروش شماره '.$h_code_.'&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	        <tr class="print_table-title">
	         <td width="5%">ردیف</td>
	         <td width="15%">تاریخ حواله سردخانه</td>
	         <td width="15%">شماره حواله سردخانه</td>
	         <td width="10%">وضعیت</td>
	         <td width="20%">مقدار ابطالی حواله سردخانه</td>
	         <td width="20%">مقدار تحویلی</td>
	         <td width="15%">مانده</td>
	        </tr>';
	   }
	  }//END while
	echo'
	</table>';
	}
	echo'
 <!--پايان مرکز صفحه -->';  
}	
 echo'
 <!-- چاپ زیرنویس-->
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
  <tr class="print_footer">
   <td colspan="3">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
  </tr>	
 </table>
</body>
</html>';		
?>