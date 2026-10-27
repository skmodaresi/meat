<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_havale_forush_one.php";
if($_SESSION['mt_systemforush']==0){$TableName="havale_forush";}//اطلاعات حواله فروش از سیستم انبار
if($_SESSION['mt_systemforush']==1)//اطلاعات حواله فروش از سیستم فروش
{
 mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
 $TableName="dm_havale";
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
}
$today=AsLDate($yymmdd);
$logtime=date('H:i');
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ حواله فروش</title>
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
<form method="post" name="myform">
<div align="center">
<br/>
<table width="85%" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td>
   <table width="100%" border="0" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> نسخه ی  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">حواله فروش
		    <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText--hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
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
//نمایش اطلاعات در حالت سیستم انبار	
   if($_SESSION['mt_systemforush']==0)
   {
     $q1="select $TableName.*,kala.name_kala,vahed_kala.sharh_vahedkala,moshtary.name_customer,moshtary.customer_address_office,ostan.name_ostan,list_sardkhane.name_anbar,list_sardkhane.address_anbar
     FROM $TableName 
     LEFT OUTER JOIN kala ON $TableName.code_kala=kala.code_kala 
     LEFT OUTER JOIN vahed_kala ON vahed_kala.code_vahedkala=kala.code_vahedkala
	 LEFT OUTER JOIN moshtary ON $TableName.code_customer=moshtary.code_customer AND $TableName.code_ostan=moshtary.code_ostan   
	 LEFT OUTER JOIN ostan ON moshtary.code_ostan=ostan.code_ostan
     LEFT OUTER JOIN list_sardkhane ON $TableName.code_anbar=list_sardkhane.code_anbar AND $TableName.code_ostan=list_sardkhane.code_ostan 
	 WHERE $TableName.id='$id_'";
     $res1=mysql_query($q1);
     $row1=mysql_fetch_assoc($res1);
     $tarikh_forush=$row1['h_reg_date'];
     //محاسبه مقدار تحویلی
     $q20="SELECT SUM(vazn_khales_h) FROM havale WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0";
     $res20=mysql_query($q20);
     $meghdar_tahvily=mysql_fetch_array($res20);
	     if($meghdar_tahvily[0]==NULL) $meghdar_tahvily[0]=0;//به جای خالی بودن صفر نمایش بدهیم
     //محاسبه مقدار باطله
     $batele_anbar=$db->get_from_where("SUM(meghdar_batele)","ebtal","h_code=".$row1['h_code']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");  
         if($batele_anbar==NULL) $batele_anbar=0; //به جای خالی بودن صفر نمایش بدهیم   
	/**///محاسبه مقدار مانده از حواله فروش
     //$mande_az_forush=$row1['meghdar_havale_forush']-$meghdar_tahvily[0]-$batele_anbar;//محاسبه مقدار مانده از حواله فروش   
    echo'
	<tr class="print_tr1">
	 <td colspan="2">
      <table border=0  width=100%>
	   <tr>
        <td align="right"> شماره حواله فروش : '.$row1['h_code'].' </td>
	    <td align="right" > تاريخ حواله فروش : '.$tarikh_forush.' </td>
	   </tr>
	   <tr><td>&nbsp;</td></tr>
       <tr>	   
		<td align="right" > نوع حواله فروش : '.$noe_havale_forushArr[$row1['noe_havale_forush']].'</td>
        <td align="right"> کد نرخ فروش : '.$row1['h_price_code'].'</td>
	   </tr>
	  </table>
	 </td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr class="print_tr1">
	 <td valign="top">
	  <fieldset class="print-fieldset">
	   <legend>کالا</legend>
	   <table border=0  width=100%>
	    <tr><td align="right"> کد کالا : '.$row1['code_kala'].'<td></td></tr> 
		<tr><td align="right">نام کالا : '.$row1['name_kala'].'</td></tr>
        <tr><td align="right">واحد کالا : '.$row1['sharh_vahedkala'].'</td></tr>
	   </table>
	  </fieldset>
	 </td>
     <td valign="top">
	  <fieldset class="print-fieldset">
	   <legend>مشتری</legend>
	   <table border=0 width=100%>
	    <tr><td align="right"> کد مشتری : '.$row1['code_customer'].'</td></tr>
		<tr><td align="right">نام مشتری : '.$row1['name_customer'].'</td></tr>
	    <!--<tr><td align="right">استان مشتری : '.$row1['name_ostan'].'</td></tr>-->
		<tr><td align="right">آدرس مشتری :'.$row1['customer_address_office'].'</td></tr>
	   </table>
	  </fieldset>
     </td>
	</tr>
    <tr class="print_tr1">
     <td colspan="" valign="top" width=50%>
	  <fieldset class="print-fieldset">
	   <legend>آدرس</legend>
	   <table border="0" width=100%>
		<tr><td align="right"> کد محل تحویل : '.$row1['code_anbar'].'</td></tr>
	    <tr><td align="right">نام سردخانه : '.$row1['name_anbar'].'</td></tr>
		<tr><td align="right">آدرس سردخانه : '.$row1['address_anbar'].'</td></tr>
	    <tr><td>&nbsp;</td></tr>
	   </table>
      </fieldset>
	 </td>
	 <td colspan="" valign="top">
	  <fieldset class="print-fieldset">
	   <legend>مقادیر</legend>
	   <table border="0" width=100%>
	    <tr><td align="right"> مقدار اولیه حواله فروش : '.($row1['meghdar_havale_forush']).'</td></tr>
	    <tr><td align="right">مقدار تحویلی از حواله : '.($meghdar_tahvily[0]).'</td></tr>
	    <tr><td align="right">مقادیر باطله : '.($batele_anbar).'</td></tr>
	    <tr><td align="right">مقدار مانده از حواله فروش : '.($row1['mande_az_forush']).'</td></tr>';
   }
///////////////////////////////////////////////////////////////////////////////////////////   
//نمایش اطلاعات در حالت سیستم فروش	
   if($_SESSION['mt_systemforush']==1)
   {
    //$q2="select * FROM $TableName WHERE  $TableName.h_id='$id_'";	 
    $q1="SELECT $TableName.h_code,$TableName.h_reg_date,$TableName.h_p_code,$TableName.h_customer_code,
                         dm_customer_asli.code_customer,dm_customer_asli.name_customer,dm_customer_asli.customer_address_office,
                         dm_province.province_name,dm_location_goods.l_code,$TableName.h_pre_amount 
                         FROM $TableName         
						 LEFT OUTER JOIN dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer AND customer_code_org='$mt_gl_code_ostan'
						 LEFT OUTER JOIN dm_province ON dm_customer_asli.customer_province_id=dm_province.province_id
						 LEFT OUTER JOIN dm_location_goods ON dm_location_goods.l_id=dm_havale.h_l_code
						 WHERE $TableName.h_id='$id_' AND $TableName.h_id_province='$sell_id_ostan' AND $TableName.h_l_code='$sell_id_anbar' AND $TableName.h_id_year='$sellYearId'";
    $res1=mysql_query($q1);
    $row1=mysql_fetch_assoc($res1);
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
    //مجموع مقدار ابطالی های این حواله فروش در سیستم فروش
	 $q_ebtalha="SELECT SUM(his_eb_amount) FROM dm_his_havale WHERE his_h_code=".$row1['h_code']." AND his_id_province='$sell_id_ostan' AND his_l_code='$sell_id_anbar' And his_id_year='$sellYearId'";	   
	 $res_ebtalha=mysql_query($q_ebtalha);
	 $row_ebtalha=mysql_fetch_array($res_ebtalha);
	 $batele_forush=$row_ebtalha[0];
	 //اطلاعات لازم از سیستم انبار
	  mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());
     //نام کالا و واحد کالا از سیستم انبار
	  $res_kala=mysql_query("SELECT kala.name_kala,vahed_kala.sharh_vahedkala FROM kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala WHERE kala.code_kala=".$row1['h_p_code']."");
      $row_kala=mysql_fetch_assoc($res_kala);
	  $nameKALA=$row_kala['name_kala'];
	  $vahedKALA=$row_kala['sharh_vahedkala'];
	 //نام انبار و آدرس انبار از سیستم انبار
	  $res_anbar=mysql_query("SELECT name_anbar,address_anbar FROM list_sardkhane WHERE code_anbar=".$row1['l_code']."");
      $row_anbar=mysql_fetch_assoc($res_anbar);
      $nameANBAR=$row_anbar['name_anbar']; 	
      $addressANBAR=$row_anbar['address_anbar'];
     //محاسبه مقدار تحویلی در هر دو سیستم یکسان است    
      $q20=("SELECT SUM(vazn_khales_h) FROM havale WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
	  $res20=mysql_query($q20);
      $meghdar_tahvil=mysql_fetch_array($res20);
      $meghdar_tahvily=$meghdar_tahvil[0];
	  //پایان محاسبه مقدار تحویلی
      //مانده به صورت محاسباتی
	  //$mande_az_forush=$row1['h_pre_amount']-$meghdar_tahvily-$batele_forush;	
	echo'
	<tr class="print_tr1">
	 <td colspan="2">
      <table border=0  width=100%>
	   <tr>
        <td align="right"> شماره حواله فروش : '.$row1['h_code'].' </td>
	    <td align="rigth"> تاريخ حواله فروش : '.$tarikh_forush.' </td>
 	   </tr>
	   <tr><td>&nbsp;</td></tr>
       <tr>	   
		<td align="right"> نوع حواله فروش : حواله فروش</td>
        <td align="right"> کد نرخ فروش : '.$row1['h_price_code'].'</td>
	   </tr>
	  </table>
	 </td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr class="print_tr1">
	 <td valign="top">
	  <fieldset class="print-fieldset">
	   <legend>کالا</legend>
	   <table border=0  width=100%>
	    <tr><td align="right"> کد کالا : '.$row1['h_p_code'].'<td></td></tr> 
		<tr><td align="right">نام کالا : '.$nameKALA.'</td></tr>
        <tr><td align="right">واحد کالا : '.$vahedKALA.'</td></tr>
	   </table>
	  </fieldset>
	 </td>
     <td valign="top">
	  <fieldset class="print-fieldset">
	   <legend>مشتری</legend>
	   <table border=0 width=100%>
	    <tr><td align="right"> کد مشتری : '.$row1['h_customer_code'].'</td></tr>
		<tr><td align="right">نام مشتری : '.$row1['name_customer'].'</td></tr>
	    <!--<tr><td align="right">استان مشتری : '.$row1['province_name'].'</td></tr>-->
		<tr><td align="right">>آدرس مشتری : '.$row1['customer_address_office'].'</td></tr>
	   </table>
	  </fieldset>
     </td>
	</tr>
    <tr class="print_tr1">
     <td colspan="" valign="top" width=60%>
	  <fieldset class="print-fieldset">
	   <legend>آدرس</legend>
	   <table border="0" width=100%>
		<tr><td align="right"> کد محل تحویل : '.$row1['l_code'].'</td></tr>
	    <tr><td align="right">نام انبار : '.$nameANBAR.'</td></tr>
		<tr><td align="right">آدرس انبار : '.$addressANBAR.'</td></tr>
		<tr><td>&nbsp;</td></tr>
	   </table>
      </fieldset>
	 </td>
	 <td colspan="" valign="top">
	  <fieldset class="print-fieldset">
	   <legend>مقادیر</legend>
	   <table border="0" width=100%>
	    <tr><td align="right"> مقدار اولیه حواله فروش : '.($row1['h_pre_amount']).'</td></tr>
	    <tr><td align="right">مقدار تحویلی از حواله : '.($meghdar_tahvily).'</td></tr>
	    <tr><td align="right">مقادیر باطله : '.($batele_forush).'</td></tr>
	    <tr><td align="right">مقدار مانده از حواله فروش : '.($row1['h_mande_havale']).'</td></tr>
	     <!--<tr><td align="right">مقدار مانده از حواله فروش : '.($mande_az_forush).'</td></tr>-->
		';
		}
		echo'
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
 </tr>';
 //تعداد توضیحات	
 $tozihCount=$db->get_from_where("count(*)","mt_typetozih","type_id='3' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");     
 if($tozihCount>0)
 {
	   echo'
	   <tr class="print_footer">';
	   $tozihat_q=$db->query("SELECT form_tozihat FROM mt_typetozih WHERE type_id='3' AND code_ostan='".$_SESSION['mt_code_ostan']."' and code_anbar='".$_SESSION['mt_code_anbar']."'");	
       while ($tozih=$db->fetch_array($tozihat_q)) echo '<td>'.$tozih[0].'</td>';
       echo'</tr>';
 }
 echo'
</table>	
</form>
</body>
</html>';		
?>