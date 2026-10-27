<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_havale_one.php";
$TableName="havale";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='چاپ حواله سردخانه';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
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
//برای هر دو سیستم انبار و فروش   
  $q1=("SELECT $TableName.*,kala.code_kala,kala.name_kala,kala.code_bastebandy,bastebandy.code_bastebandy,bastebandy.sharh_bastebandy	 
       FROM $TableName 
       INNER JOIN kala ON $TableName.code_kala=kala.code_kala	 
       INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy 	             
	   WHERE $TableName.id=$id_");	
  $res1=$db->query($q1);
  $row1=$db->fetch_assoc($res1);
  if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)or($row1['noe_tahvil_bar']==6)or($row1['noe_tahvil_bar']==7))//اگر نوع تحویل بار جابه جایی 
  {
     $q_jabejae=("SELECT m_j.*,ostan.name_ostan,list_sardkhane.name_anbar,mt_skk.code_skk,mt_skk.name_skk FROM mojavez_jabejae m_j
                  LEFT JOIN ostan ON ostan.code_ostan=m_j.code_ostan_maghsad_j           
                  LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=m_j.code_anbar_maghsad_j AND list_sardkhane.code_ostan=m_j.code_ostan_maghsad_j 
				  LEFT JOIN mt_skk ON mt_skk.code_skk=m_j.code_skk           
				  WHERE m_j.shomare_jabejae='".$row1['shomare_jabejae']."' AND m_j.code_ostan='".$row1['code_ostan']."' AND m_j.code_anbar='".$row1['code_anbar']."' AND m_j.year='".$row1['year']."' AND m_j.deleted=0");	
	 $res_jabejae=mysql_query($q_jabejae);
     $row_jabejae=mysql_fetch_assoc($res_jabejae);
	 $code_customer=$row_jabejae['code_customer'];
  }
  else
  {
    //اگر سیستم سردخانه
     if($_SESSION['mt_systemforush']==0)
    { 
    //بدست آوردن تاریخ ومقدار حواله فروش و مانده از فروش و کد مشتری
     $q_havale_forush="SELECT h_reg_date,id,mande_az_forush,code_customer,h_deli_name FROM havale_forush WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
     $res_havale_forush=mysql_query($q_havale_forush);
     $row_havale_forush=mysql_fetch_array($res_havale_forush);
     $tarikh_forush=$row_havale_forush['h_reg_date'];
     $mande_az_forush=$row_havale_forush['mande_az_forush'];
     $code_customer=$row_havale_forush['code_customer'];
    }
    //اگر سیستم فروش  
    else
    {  
     mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
     //بدست آوردن تاریخ ومقدار حواله فروش و مانده از فروش وکد مشتری
  	  $q_havale_forush="SELECT h_id,h_reg_date,h_mande_havale,h_customer_code,h_deli_name FROM dm_havale WHERE h_code='".$row1['h_code']."' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";
      $res_havale_forush=mysql_query($q_havale_forush);
      $row_havale_forush=mysql_fetch_array($res_havale_forush);
      $mande_az_forush=$row_havale_forush['h_mande_havale']; 
      $code_customer=$row_havale_forush['h_customer_code']; 
	 //تبدیل تاریخ میلادی به شمسی
  	   $sql_tarikh=$row_havale_forush['h_reg_date'];
         $d=substr($sql_tarikh,8,2);
         $m=substr($sql_tarikh,5,2);
         $y=substr($sql_tarikh,0,4);
         $shamsi=gregorian_to_jalali($y,$m,$d);
         $sal=$shamsi[0];
         $mah=$shamsi[1];
         $rouz=$shamsi[2];
         $tarikh_forush=$sal.'/'.$mah.'/'.$rouz;
    }
  }
  //بدست آوردن نام مشتری
  $name_customer=customer($code_customer);//تابع
  $db->selectDb($mydatabase);
  if($row1['code_bastebandy']==1)$vahed_andazegiry=' (کیلوگرم)';
  if($row1['code_bastebandy']==2)$vahed_andazegiry=' (تعداد)'; 
echo'
<body>
<br>
<table width="99%" border="1" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td>
   <table width="100%" border="0" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> نسخه ی  : '.$mt_gl_name_anbar.' &nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">حواله سردخانه
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
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="print_tr1">
	 <td colspan="3">
      <table border="0" width="100%">
	   <tr>
        <td align="right" class="boldtext"> شماره حواله سردخانه : '.$code_a.$row1['code_anbar'].$row1['shomare_havale_anbar'].'</td>
		<td align="right" class="boldtext"> تاريخ حواله سردخانه : '.$row1['tarikh_havale_anbar'].'</td>	 	   		 
	    <td align="right" class="boldtext"> شناسه یکتا وزارت صمت : '.$row1['wb_id'].'</td>	 
		<td align="right" class="boldtext">وضعیت : ';if($row1['status']==0) echo 'جاری'; else echo 'ابطالی </td>';
	    echo'
	   </tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr>';
	   //اگر نوع تحویل  بار جابه جایی باشد
	   if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)or($row1['noe_tahvil_bar']==6)or($row1['noe_tahvil_bar']==7))
	   { 
	    echo'	   
	    <td align="right" class="boldtext"> شماره مجوز جابه جایی : '.$row1['shomare_jabejae'].'</td>
		<td align="right"> تاريخ مجوز جابه جایی : '.$row_jabejae['tarikh_jabejae'].'</td>
	    <td align="right" class="boldtext"> مقدار مانده از مجوز جابه جایی : '.round($row_jabejae['mande_az_jabejae'],3).' '.$vahed_andazegiry.'</td>';
       } 
	   else
       {echo'	   
	    <td align="right" class="boldtext"> شماره حواله فروش : '.$row1['h_code'].'</td>
		<td align="right"> تاريخ حواله فروش : '.$tarikh_forush.'</td>
		<td align="right"> شماره درخواست : '.$row1['shomare_darkhast'].'</td>
	    <td align="right" class="boldtext">مقدار مانده از حواله فروش : '.round($mande_az_forush,3).'</td>';
       }
	   echo'
	   </tr>
	   <tr><td>&nbsp;</td></tr>
       <tr><td align="right"> نوع تحویل بار : '.$tahvilbarArr_h[$row1['noe_tahvil_bar']].'</td></tr>
	  </table>
	 </td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr class="print_tr1">
	 <td valign="top">
	  <fieldset class="print-fieldset">
	   <legend class="boldtext">اطلاعات</legend>
	   <table width="100%" height="120px">';
		 //اگر نوع تحویل  بار تحویل روباری باشد		
	     if($row1['noe_tahvil_bar']==2)echo'';
	     else echo'<tr><td align="right"> شماره باسکول : '.$row1['bsk_no'].'</td></tr>';
		 echo'
		 <tr><td align="right"> شماره بارنامه : '.$row1['shomare_barname_h'].'</td></tr>
	     <tr><td align="right"> تاريخ بارنامه : '.$row1['tarikh_barname_h'].'</td></tr>
	   	 <tr><td align="right" class="boldtext"> پلاک خودرو : <sup>ایران</sup> '.$row1['plak1'].'-'.$row1['plak2'].''.$row1['plak3'].''.$row1['plak4'].'';if($row1['shomare_kamiyon_h'])   echo' /'.$row1['shomare_kamiyon_h'].'';echo'</td></tr>
		 <tr><td align="right"> شماره پلمپ :  '.$row1['shomare_polomp_h'].'</td></tr>
	     <tr><td align="right"> وضعیت پلمپ : '.$polompArr[$row1['vaziyat_polomp_h']].'</td></tr>
	   </table>
	  </fieldset>
     </td>
	 <td  valign="top">';
	  if($row1['noe_tahvil_bar']==4)
	  {echo'
	   <fieldset class="print-fieldset">
	    <legend class="boldtext">اطلاعات استان مقصد</legend>
	    <table width=100% border="0" height="120px">
		 <tr><td align="right">نام استان مقصد :  '.$row_jabejae['name_ostan'].'</td></tr>
		 <tr><td align="right">نام سردخانه مقصد : '.$row_jabejae['name_anbar'].'</td></tr>
	    </table>
	   </fieldset>';
	   }
	  else if($row1['noe_tahvil_bar']==6)
	  {echo'
	   <fieldset class="print-fieldset">
	   <legend class="boldtext">اطلاعات کشتی / فروشنده</legend>
	   <table width=100% border="0" height="120px">
		<tr><td align="right">کد کشتی / فروشنده : '.$row_jabejae['code_skk'].'</td></tr>
		<tr><td align="right">نام کشتی / فروشنده : '.$row_jabejae['name_skk'].'</td></tr>
	   </table>
	   </fieldset>';
       }
	   else
	   {echo'
	    <fieldset class="print-fieldset">
	     <legend class="boldtext">مشتری</legend>
	     <table width="100%" height="120px">
	      <tr><td align="right"> کد مشتری :  '.$code_customer.'</td></tr>
	      <tr><td align="right" class="boldtext"> نام مشتری :  '.$name_customer.'</td></tr>';
	      if($row1['noe_tahvil_bar']!=5)echo'<tr><td align="right" width="10%">نام تحویل گیرنده :  '.$row_havale_forush['h_deli_name'].'</td></tr>';
	   	  echo'
	     </table>
	    </fieldset>';
	    }
	   echo'
     </td>
	 <td valign="top">
	  <fieldset  class="print-fieldset">
	   <legend>اطلاعات تکمیلی</legend>
 	    <table width=100% height="120px">
	     <tr><td align="right">شماره گواهی بهداشتی : '.$row1['shomare_govahi_behdashti'].'</td></tr>
		 <tr><td align="right">توضیحات :'.$row1['tozihat'].'</td></tr>
		</table> 
	  </fieldset>
	 </td>	
	</tr>
    <tr class="print_tr1">
	 <td colspan="3">
	  <fieldset class="print-fieldset">
	  <legend class="boldtext">اطلاعات کالا</legend>
	  <table width="99%" border="0">
	   <tr>
		<td align="right" class="boldtext"> کد کالا : '.$row1['code_kala'].'</td>
		<td align="right" class="boldtext">نام کالا : '.$row1['name_kala'].'</td>
	    <td align="right">نوع بسته بندی : '.$row1['sharh_bastebandy'].'</td>';
        if($row1['noe_tahvil_bar']==2)echo'';
		else echo'<td align="right">نرخ بارگیری : '.virgul($row1['nerkh_bargiry_this']).'</td>';
	   echo'
	   </tr>
	  </table>
      <table width="100%" style="border:1px solid #000">	  
	    <tr><td colspan="14" class="borderbottom boldtext">جزئیات کالا</td></tr>
		<tr>
	    <td class="borderbottom " width="%" rowspan="2">زیرانبار</td>
	    <td class="borderbottom " width="%" rowspan="2">کشور</td>
	    <td class="borderbottom " width="%" rowspan="2">تولید کننده</td>
	    <td class="borderbottom " colspan="3">تاریخ تولید</td>
		<td class="borderbottom " rowspan="2">تاریخ ماندگاری</td>';
		if($row1['code_bastebandy']==1)//بسته بندی کارتنی
		{echo'
		 <td class="borderbottom " width="%" rowspan="2">کد کارتن</td>
		 <td class="borderbottom " width="%" rowspan="2">وزن کارتن</td>
		 <td class="borderbottom " width="%" rowspan="2">تعداد کارتن</td>
		 <td class="borderbottom " width="%" rowspan="2">مجموع وزن کارتن ها</td>
		 <td class="borderbottom " width="%" rowspan="2">وزن ناخالص</td>';
		}
		if($row1['code_bastebandy']==2)//بسته بندی قوطی
		{echo'
		 <td class="borderbottom " width="%" rowspan="2">کد قوطی</td>
		 <td class="borderbottom " width="%" rowspan="2">وزن قوطی</td>
		 <td class="borderbottom " width="%" rowspan="2">تعداد قوطی</td>';
		}
		if($row1['code_bastebandy']==3)//بسته بندی لاشه
		{echo'
		 <td class="borderbottom " width="%" rowspan="2">تعداد</td>';
		}
		echo'
	    <td class="borderbottom " width="%" rowspan="2">وزن خالص</td>
	    <tr style="border:2px solid #000;">
		 <td class="borderbottom " width="%" >سال</td>
	     <td class="borderbottom " width="%" >ماه</td>
	     <td class="borderbottom " width="%" >روز</td>
		</tr>
	   </tr>';
	   $q_d="SELECT h_d.*,keshvar.code_keshvar,keshvar.name_keshvar,tolidkonande.code_tolidkonande,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.code_karton,karton.vazn_karton,sharh_mandegari
      	     From havale_detail h_d
             INNER JOIN keshvar ON h_d.code_keshvar=keshvar.code_keshvar
             LEFT JOIN karton ON h_d.code_karton=karton.code_karton
             INNER JOIN tolidkonande ON h_d.code_tolidkonande=tolidkonande.code_tolidkonande
             INNER JOIN list_sardkhane_detail l_s_d ON h_d.code_ziranbar=l_s_d.code_ziranbar AND h_d.code_ostan=l_s_d.code_ostan AND h_d.code_anbar=l_s_d.code_anbar  	  
	         INNER JOIN tarikh_mandegari ON h_d.code_mandegari=tarikh_mandegari.code_mandegari    		
		     WHERE h_d.shomare_havale_anbar='".$row1['shomare_havale_anbar']."' AND h_d.code_ostan=$mt_gl_code_ostan AND h_d.code_anbar=$mt_gl_code_anbar AND h_d.year=$mtActiveYear AND havale_deleted=0";	
		$res_d=$db->query($q_d);
        $i=0;
		if(mysql_num_rows($res_d)>0)//اگر جزئیات کالا را پر کرده است
		{
		 while($row_d=$db->fetch_assoc($res_d))
	     {   
	      echo'
		  <tr>
	       <td>'.$row_d['name_ziranbar'].'</td>
	       <td>'.$row_d['name_keshvar'].'</td>
	       <td>'.$row_d['name_tolidkonande'].'</td>
	       <td>'.$row_d['sal_tolid_shamsi'].'</td>
	       <td>'.$mahshamsiArr[$row_d['mah_tolid_shamsi']].'</td>
		   <td>'.$row_d['rouz_tolid_shamsi'].'</td>
		   <td>'.$row_d['sharh_mandegari'].'</td>';
		   if($row1['code_bastebandy']!=3)//غیر از لاشه
		   {echo'
		    <td>'.$row_d['code_karton'].'</td>
		    <td>'.$row_d['vazn_karton_this'].'</td>';
		   }
		   echo'
		   <td>'.$row_d['tedad_karton_h_d'].'</td>';
		   if($row1['code_bastebandy']==1)//بسته بندی کارتنی
		   {
		    echo'
		    <td>'.$row_d['sum_karton_h_d'].'</td>
		    <td>'.$row_d['vazn_nakhales_h_d'].'</td>';
		   }
		   echo'
		   <td>'.$row_d['vazn_khales_h_d'].'</td>
	      </tr>';
		  //محاسبه مجموع در سطر آخرو داخل فیلد ها
		   $tedad_karton_h+=$row_d['tedad_karton_h_d'];
		   //$vazn_karton_h+=$row_d['vazn_karton_this'];
		   $sum_karton_h+=$row_d['sum_karton_h_d'];
		   $vazn_nakhales_h+=$row_d['vazn_nakhales_h_d'];
		   $vazn_khales_h+=$row_d['vazn_khales_h_d'];
	     }
		 echo'
	      <tr>
	       <td class="bordertop boldtext" ';if($row1['code_bastebandy']==3) echo' colspan="7" '; else echo 'colspan="9"'; echo'>مجموع مقادیر</td>
	       <!--<td class="bordertop">'.$vazn_karton_h.'</td>-->
		   <td class="bordertop boldtext">'.$tedad_karton_h.'</td>';
		   if($row1['code_bastebandy']==1)//بسته بندی کارتنی
		   {
		    echo'
	        <td class="bordertop boldtext">'.$sum_karton_h.'</td>
	        <td class="bordertop boldtext">'.$vazn_nakhales_h.'</td>';
		   }
		   echo'
	       <td class="bordertop boldtext">'.$vazn_khales_h.'</td>
	      </tr>';
		}
		else if($row1['status']==1){echo'<tr><td colspan="14" style="color:red">حواله ابطال شد</td></tr>';}
		else {echo'<tr><td colspan="14">جزئیات کالا تکمیل نشده است!</td></tr>';}
	   echo'
	  </table>
	  </fieldset>
	 </td>
	</tr>   
	<tr class="print_tr1">
	 <td colspan="" valign="top">
	  <fieldset class="print-fieldset">
	   <legend class="boldtext">وزن</legend>
	   <table width="100%" height="120px">';
		//اگر نوع تحویل  بار تحویل روباری باشد
	    if($row1['noe_tahvil_bar']==2)
		{
		 if($row1['code_bastebandy']==1)echo'<tr><td align="right" class="boldtext"> وزن ناخالص : '.$vazn_nakhales_h.'</td></tr>';
		 if($row1['code_bastebandy']==1)echo'<tr><td align="right" class="boldtext"> تعداد کارتن :';if($row1['code_bastebandy']==2)echo'<tr><td align="right" class="boldtext"> تعداد قوطی :';echo'  '.$tedad_karton_h.'</td></tr>';
		 if($row1['code_bastebandy']==1)echo'<tr><td align="right"> مجموع وزن کارتن ها : '.$sum_karton_h.'</td></tr>';
	     echo'<tr><td align="right" class="boldtext"> وزن خالص : '.$row1['vazn_khales_h'].'</td></tr> 
		  <!--<tr><td align="right"> وزن خالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_khales_h" value="'.$vazn_khales_h.'"/></td></tr>-->';
	   	}
		else
		{
		 echo'
		 <tr><td align="right"> وزن کاميون با بار : '.$row1['vazn_kamiyon_bar_h'].'</td></tr>
	     <tr><td align="right"> وزن کاميون : '.$row1['vazn_kamiyon_h'].'</td></tr>';
	     if($row1['code_bastebandy']==1)echo'<tr><td align="right" class="boldtext"> وزن ناخالص : '.$vazn_nakhales_h.'</td></tr>';
	     echo'<tr><td align="right" class="boldtext"> تعداد : '.$tedad_karton_h.'</td></tr>';
	     if($row1['code_bastebandy']==1)echo'<tr><td align="right"> مجموع وزن کارتن ها : '.$sum_karton_h.'</td></tr>';
	     echo'<tr><td align="right" class="boldtext"> وزن خالص : '.$row1['vazn_khales_h'].'</td></tr>';  
		}
	    echo'
	   </table>
	  </fieldset>
     </td>
	 <td colspan="" valign="top">
	  <fieldset class="print-fieldset">
	   <legend class="boldtext">هزینه ها</legend>
	   <table width="100%" height="120px">
	    <tr><td align="right"> نوع خودرو : '.$khodroArr[$row1['noe_khodro']].'</td></tr>
	    <tr><td align="right">مبلغ باسکول : '.$row1['mablagh_baskul'].'</tr>';
	    //اگر نوع تحویل  بار تحویل روباری باشد
	    if($row1['noe_tahvil_bar']==2)echo'';
	    else  echo'<tr><td align="right" >هزینه بارگیری : '.virgul($row1['mablagh_bargiry']).'</td></tr>';
	    echo'
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
	   </table>
      </fieldset>
	 </td>
	</tr>
   </table>
   </div>
  </td>
 </tr>
 <!--پايان مرکز صفحه -->
 <tr class="print_footer">
  <td align="left">&nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr>
 <!-- چاپ زیرنویس-->
 <tr>
  <td>
   <table width="100%" border="0" height="100%" align="center" cellpadding="0" cellspacing="0">
    <tr class="print_footer">
     <td>نام کاربر :&nbsp;'.$mtuserNAME.'</td>';
  	 //mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());
	 $db->selectDb($mydatabase);
	 //$dc=$db->query("SELECT dpt_id FROM mt_typesign WHERE type_id='2' AND code_ostan='".$_SESSION['mt_code_ostan']."' and code_anbar='".$_SESSION['mt_code_anbar']."' order by turn");	
     // while ($dr=$db->fetch_array($dc))
     // {
	 // $vahed=$db->get_from_where("dpt_name,manager","mt_dpt","dpt_id=".$dr[0]." AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");
     // echo '<td>'.$vahed[0].' :&nbsp;'.$vahed[1].'</td>';
     // }
	 if($row1['signiture_havale']!='')
	 {
       $signarray =explode(';',$row1['signiture_havale']);
	   foreach($signarray as $signID)
	   {
	    $sql_q ="SELECT mt_typesign.manager,mt_dpt.dpt_name FROM mt_typesign INNER JOIN mt_dpt ON mt_typesign.dpt_id=mt_dpt.dpt_id AND mt_typesign.code_ostan=mt_dpt.code_ostan AND mt_typesign.code_anbar=mt_dpt.code_anbar WHERE sign_id=$signID ORDER BY turn";
	    $sql_res=mysql_query($sql_q);
	    $row_n=mysql_fetch_assoc($sql_res);
	    echo '<td>'.$row_n['dpt_name'].' :&nbsp;&nbsp;'.$row_n['manager'].'</td>';
	   }
	 }
    echo'
    </tr>';
	 //تعداد توضیحات	
     $tozihCount=$db->get_from_where("COUNT(*)","mt_typetozih","type_id='2' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");     
	 if($tozihCount>0)
	 {
	   echo'
	   <tr class="print_footer">';
	   $tozihat_q=$db->query("SELECT form_tozihat FROM mt_typetozih WHERE type_id='2' AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");	
       while ($tozih=$db->fetch_array($tozihat_q)) echo '<td>'.$tozih[0].'</td>';
       echo'</tr>';
	 }  
     IF($row1['h_code']>0){
	  echo'
	  <tr><td>&nbsp;</td></tr>
	  <tr class="print_footer">
	   <td colspan="10">در مورخ '.$row1['tarikh_havale_anbar'].'
	   موضوع حواله به صورت سالم و بهداشتی تحویل اینجانب '.$row_havale_forush['h_deli_name'].' شد.
       محل امضا و اثر انگشت	 
	   </td>
	  </tr>';	
	}
	echo'
   </table>
  </td>
 </tr>
 </table>
</body>
</html>';	
?>