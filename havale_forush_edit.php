<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="havale_forush_edit.php";
$TableName="havale_forush";
$logtime=date('H:i:s');
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
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ویرایش حواله فروش</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepicker6").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true
    });
 });
</script>
<script type="text/javascript">
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
   window.event.keyCode = 9;
}
function getDetailKala(code_kala)<!--اطلاعات کالا-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKALA : code_kala},function(data){			 
			 <!--$("[name=name_kala]").val(data[0]);-->			 
			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#sharh_vahedkala").val(splKala[1]);
		 });
    $("#loading").fadeOut("fast");
}
function getDetailMoshtary(code_customer)<!--اطلاعات مشتری-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeMOSHTARY: code_customer},function(data){
              var splMoshtary = data.split("^");
			  $("#name_customer").val(splMoshtary[0]);
              $("#code_ostan").val(splMoshtary[1]);
              $("#customer_address_office").val(splMoshtary[3]);
		 });
   $("#loading").fadeOut("fast");	
}
function mandeAzForush()
{
 var natije;
 document.myform.mande_az_forush.value=Number(document.myform.meghdar_havale_forush.value)-Number(document.myform.meghdar_tahvily.value)-Number(document.myform.meghdar_batele.value); 
 natije=document.myform.mande_az_forush.value;
 return natije;
}
function mandeAzForushSell()
{
 var natije;
 document.myform.h_mande_havale.value=Number(document.myform.meghdar_havale_forush.value)-Number(document.myform.meghdar_tahvily.value)-Number(document.myform.meghdar_batele.value); 
 natije=document.myform.h_mande_havale.value;
 return natije;
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';

/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.h_reg_date.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">حواله فروش شماره '.$h_code_.'</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>';
    //اطلاعات در حالت سیستم انبار  
   if($_SESSION['mt_systemforush']==0)
   {
	$q1="select $TableName.*,kala.name_kala,vahed_kala.sharh_vahedkala,kala.code_bastebandy,moshtary.name_customer,moshtary.customer_address_office,ostan.name_ostan,list_sardkhane.name_anbar,list_sardkhane.address_anbar
     FROM $TableName 
     LEFT OUTER JOIN kala ON $TableName.code_kala=kala.code_kala 
     LEFT OUTER JOIN vahed_kala ON vahed_kala.code_vahedkala=kala.code_vahedkala
	 LEFT OUTER JOIN moshtary ON $TableName.code_customer=moshtary.code_customer   
	 LEFT OUTER JOIN ostan ON moshtary.code_ostan=ostan.code_ostan
     LEFT OUTER JOIN list_sardkhane ON $TableName.code_anbar=list_sardkhane.code_anbar AND $TableName.code_ostan=list_sardkhane.code_ostan 
	 WHERE $TableName.id='$id_'";	 
    $res1=$db->query($q1);
    $row1=$db->fetch_assoc($res1);
    // $q20="SELECT SUM(vazn_khales_h) FROM havale WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0";//محاسبه مقدار تحویلی
    // $res20=$db->query($q20);
    // $meghdar_tahvily=$db->fetch_array($res20);
	
    $meghdar_tahvily=tahvily_az_forush($row1['h_code'],$row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_bastebandy'],$row1['code_kala']);
	
    $q21="select SUM(meghdar_batele) FROM ebtal WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";//محاسبه مقدار باطله
    $res21=$db->query($q21);
    $meghdar_batele=$db->fetch_array($res21);
    /**///$mande_az_forush=$row1['meghdar_havale_forush']-$meghdar_tahvily[0]-$meghdar_batele[0];//محاسبه مقدار مانده از حواله فروش
    $mande_az_forush=$row1['mande_az_forush'];
   
     echo'
     <tr class="tr1">
	   <td colspan="2">
       <table width="100%">
	     <tr>
          <td align="left"  width="200px">';
		  if(SuperUser())echo 'id: '.$row1['id'].'&nbsp;&nbsp;';
		  echo'<span class="star">*</span> شماره حواله فروش : </td><td  align="right"><input type="text" class="textboxme2" name="h_code" readonly value="'.$row1['h_code'].'"/></td>
	      <td align="left" width="150px"><span class="star">*</span> تاريخ حواله فروش : </td><td align="right"><input type="text" class="textboxme2" id="datepicker6" maxlength="10" name="h_reg_date" value="'.$row1['h_reg_date'].'"/></td>	 
	     </tr>
	     <tr>
	      <td align="left" width="150px"><span class="star">*</span> نوع حواله فروش : </td><td align="right">'.static_listbox("noe_havale_forush",$row1['noe_havale_forush'],"noe_havale_forushArr",1,"class='text4'").'</td>
		  <!--<td align="left" width="200px"><span class="star">*</span> کد نرخ فروش : </td><td align="right"><input type="text" class="textboxme2" name="h_price_code" value="'.$row1['h_price_code'].'" onkeypress="return isNumber(event)"/></td>-->
		  <td align="left" width="200px"><span class="star">*</span> تحویل گیرنده : </td><td align="right"><input type="text" class="textboxme2" name="h_deli_name" value="'.$row1['h_deli_name'].'" "/></td>
	     </tr>
	    </table>
	   </td>
	  </tr>
	  <tr class="tr1">
	   <td valign="top">
	    <fieldset>
	     <legend>کالا</legend>
	     <table width="100%">
	      <tr><td align="left" width="150px"><span class="star">*</span> کد کالا : </td><td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$row1['code_kala'].'" onfocus="getDetailKala(this.value)" onchange="getDetailKala(this.value)" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>&nbsp;';
	  	  include ("img_helpkala.php");
	  	 echo'
	  	   </td>
		  </tr>
		  <tr><td align="left" >نام کالا : </td><td align="right"><input type="text" class="textboxme" readonly id="name_kala" name="name_kala" value="'.$row1['name_kala'].'" /></td></tr>
          <tr><td align="left" >واحد کالا : </td><td align="right"><input type="text" class="textboxme" readonly id="sharh_vahedkala" value="'.$row1['sharh_vahedkala'].'"/></td></tr>
		 </table>
	    </fieldset>
	   </td>
       <td>
	    <fieldset>
	     <legend>مشتری</legend>
	     <table width="100%">
	      <tr><td align="left" width="150px"><span class="star">*</span> کد مشتری : </td><td align="right"><input type="text" class="textboxme2" name="code_customer" value="'.$row1['code_customer'].'" onfocus="getDetailMoshtary(this.value)" onchange="getDetailMoshtary(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;
	        <img border="0" src="images/help.png" onClick="window.showModalDialog(\'help_moshtary.php\',\'_blank\',\'dialogwidth=500px,left=20px,scrollbars=yes\')" title="جدول کد مشتری" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td></tr>
	  	  <tr><td align="left" >نام مشتری : </td><td align="right"><input type="text" class="textboxme" readonly id="name_customer" value="'.$row1['name_customer'].'"/></td></tr>
	      <!--<tr><td align="left" >استان مشتری : </td><td align="right"><input type="text" class="textboxme" readonly id="code_ostan" value="'.$row1['name_ostan'].'"/></td></tr>-->
	      <tr><td align="left" >آدرس مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="customer_address_office" value="'.$row1['customer_address_office'].'"/></td></tr>
	     </table>
	    </fieldset>
      </td>
	  </tr>
     <tr class="tr1">
      <td colspan="" valign="top">
	    <fieldset>
	    <legend>آدرس</legend>
	     <table border="0" width="100%">
	      <tr><td align="left" width="150px"><span class="star">*</span> کد محل تحویل : </td><td align="right"><input type="text" readonly class="textboxme2" name="code_anbar" value="'.$row1['code_anbar'].'" style="width:50px;"/></tr>
	  	  <tr><td align="left">نام سردخانه : </td><td align="right"><input type="text" class="textboxme" readonly id="name_anbar" name="name_anbar" value="'.$row1['name_anbar'].'"/></td></tr>
	      <tr><td align="left">آدرس سردخانه : </td><td align="right"><input type="text" class="textboxme" readonly id="address_anbar" name="address_anbar" value="'.$row1['address_anbar'].'"/></td></tr>
	      <tr><td>&nbsp;</td></tr>
		 </table>
       </fieldset>
	   </td>
	   <td colspan="" valign="top">
	    <fieldset>
	     <legend>مقادیر</legend>
	     <table width="100%">
	      <tr><td align="left"  width="200px"><span class="star">*</span> مقدار حواله فروش: </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_havale_forush" value="'.$row1['meghdar_havale_forush'].'" onblur="return mandeAzForush()" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
	      <tr><td align="left">مقدار تحویلی از حواله : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_tahvily" value="'.round($meghdar_tahvily,3).'" onblur="return mandeAzForush()"/></td></tr>
	      <tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" readonly class="textboxme2" readonly name="meghdar_batele" value="'.round($meghdar_batele[0],3).'" onblur="return mandeAzForush()"/></td></tr>
	      <tr><td align="left">مقدار مانده از حواله فروش : </td><td align="right"><input type="text" class="textboxme2" readonly name="mande_az_forush" value="'.round($mande_az_forush,3).'" onfocus="return mandeAzForush();" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
	     </table>
	    </fieldset>
      </td>
	  </tr>';
   }
/////////////////////////////////////////////////////////////////////////////////////   
	//اطلاعات در حالت سیستم فروش
   if($_SESSION['mt_systemforush']==1)
   {
    //$q2="select * FROM $TableName WHERE  $TableName.h_id='$id_'";	 
    $q1="SELECT $TableName.h_id,$TableName.h_code,$TableName.h_reg_date,$TableName.h_price_code,$TableName.h_p_code,$TableName.h_customer_code,
                         $TableName.h_mande_havale,dm_customer_asli.code_customer,dm_customer_asli.name_customer,dm_customer_asli.customer_address_office,
                         dm_province.province_name,dm_location_goods.l_code,$TableName.h_pre_amount 
                         FROM $TableName         
						 LEFT OUTER JOIN dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer
						 LEFT OUTER JOIN dm_province ON dm_customer_asli.customer_province_id=dm_province.province_id
						 LEFT OUTER JOIN dm_location_goods ON dm_location_goods.l_id=dm_havale.h_l_code
						 WHERE $TableName.h_id='$id_' AND $TableName.h_id_province='$sell_id_ostan' AND $TableName.h_l_code='$sell_id_anbar' AND $TableName.h_id_year='$sellYearId'";
    //echo $q1;
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
	 $q_ebtalha="SELECT SUM(his_eb_amount) FROM dm_his_havale WHERE his_h_id=".$row1['h_id']."";	   
	 $res_ebtalha=mysql_query($q_ebtalha);
	 $row_ebtalha=mysql_fetch_array($res_ebtalha);
	 $batele_forush=$row_ebtalha[0];
	 //اطلاعات لازم از سیستم انبار
	  mysql_select_db("$mydatabase") or die('no Select Db BECAUSE: ' . mysql_error());
     //نام کالا و واحد کالا از سیستم انبار
	  $res_kala=mysql_query("SELECT kala.name_kala,vahed_kala.sharh_vahedkala,kala.code_bastebandy FROM kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala WHERE kala.code_kala=".$row1['h_p_code']."");
      $row_kala=mysql_fetch_assoc($res_kala);
	  $nameKALA=$row_kala['name_kala'];
	  $vahedKALA=$row_kala['sharh_vahedkala'];
	  $bastebandyKALA=$row_kala['code_bastebandy'];
	 //نام انبار و آدرس انبار از سیستم انبار
	  $res_anbar=mysql_query("SELECT name_anbar,address_anbar FROM list_sardkhane WHERE code_anbar='$mt_gl_code_anbar' AND code_ostan='$mt_gl_code_ostan'");
      $row_anbar=mysql_fetch_assoc($res_anbar);
      $nameANBAR=$row_anbar['name_anbar']; 	
      $addressANBAR=$row_anbar['address_anbar'];
     //محاسبه مقدار تحویلی در هر دو سیستم یکسان است    
      // $q20=("SELECT SUM(vazn_khales_h) FROM havale WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
	  // $res20=mysql_query($q20);
      // $meghdar_tahvil=mysql_fetch_array($res20);
      // $meghdar_tahvily=$meghdar_tahvil[0];
	  $meghdar_tahvily=tahvily_az_forush($row1['h_code'],$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$bastebandyKALA,$row1['h_p_code']); 
	 //پایان محاسبه مقدار تحویلی
      /**///$mande_az_forush=$row1['h_pre_amount']-$meghdar_tahvily-$batele_forush;
	 echo'
      <tr class="tr1">
	   <td colspan="2">
        <table width="100%">
	     <tr>
		  <td align="left"  width="200px">';
		  if(SuperUser())echo 'h_id: '.$row1['h_id'].'&nbsp;&nbsp;';
		  echo'<span class="star">*</span> شماره حواله فروش : </td><td  align="right"><input type="text" class="textboxme2" name="h_code" readonly value="'.$row1['h_code'].'"/></td>
	      <td align="left" width="150px"><span class="star">*</span> تاريخ حواله فروش : </td><td align="right"><input type="text" readonly class="textboxme2" id="datepicker6" maxlength="10" name="h_reg_date" value="'.$tarikh_forush.'"/></td>	 
	     </tr>
	     <tr>
		  <td align="left" width="150px"><span class="star">*</span> نوع حواله فروش : </td><td align="right">حواله فروش</td>
	      <td align="left" width="200px"><span class="star">*</span> کد نرخ فروش : </td><td align="right"><input type="text" readonly class="textboxme2" name="h_price_code" value="'.$row1['h_price_code'].'" onkeypress="return isNumber(event)"/></td>
	     </tr>
	    </table>
	   </td>
	  </tr>
	  <tr class="tr1">
	   <td valign="top">
	    <fieldset>
	     <legend>کالا</legend>
	     <table width="100%">
	  	  <tr><td align="left" width="150px"><span class="star">*</span> کد کالا : </td><td align="right"><input type="text" class="textboxme2" readonly name="code_kala" value="'.$row1['h_p_code'].'" onfocus="getDetailKala(this.value)" onchange="getDetailKala(this.value)" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>&nbsp;</td></tr>
	  	  <tr><td align="left" >نام کالا : </td><td align="right"><input type="text" class="textboxme" readonly id="name_kala" name="name_kala" value="'.$nameKALA.'" /></td></tr>
          <tr><td align="left" >واحد کالا : </td><td align="right"><input type="text" class="textboxme" readonly id="sharh_vahedkala" value="'.$vahedKALA.'"/></td></tr>
		 </table>
	    </fieldset>
	   </td>
       <td>
	    <fieldset>
	     <legend>مشتری</legend>
	     <table width="100%">
	      <tr><td align="left" width="150px"><span class="star">*</span> کد مشتری : </td><td align="right"><input type="text" class="textboxme2" readonly name="h_customer_code" value="'.$row1['h_customer_code'].'" onfocus="getDetailMoshtary(this.value)" onchange="getDetailMoshtary(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;
	       <!-- <img border="0" src="images/help.png" onClick="window.showModalDialog(\'help_moshtary.php\',\'_blank\',\'dialogwidth=500px,left=20px,scrollbars=yes\')" title="جدول کد مشتری" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>-->
		   </td>
		  </tr> 
	  	  <tr><td align="left" width=""> نام مشتری : </td><td align="right"><input type="text" class="textboxme" readonly id="name_customer" value="'.$row1['name_customer'].'"/></td></tr>
		  <!--<tr><td align="left" width=""> استان مشتری : </td><td align="right"><input type="text" class="textboxme" readonly id="code_ostan" value="'.$row1['province_name'].'"/></td></tr>-->
	      <tr><td align="left" width=""> آدرس مشتری : </td><td align="right"><input type="text" class="textboxme" readonly id="customer_address_office" value="'.$row1['customer_address_office'].'" /></td></tr>
		 </table>
	    </fieldset>
       </td>
	  </tr>
      <tr class="tr1">
       <td colspan="" valign="top">
	    <fieldset>
	    <legend>آدرس</legend>
	     <table border="0" width="100%">
	      <tr><td align="left" width="150px"><span class="star">*</span> کد محل تحویل : </td><td align="right"><input type="text" readonly class="textboxme2" name="code_anbar" value="'.$row1['l_code'].'" style="width:50px;"/></tr>
	  	  <tr><td align="left">نام انبار : </td><td align="right"><input type="text" class="textboxme" readonly id="name_anbar" name="name_anbar" value="'.$nameANBAR.'"/></td></tr>
	      <tr><td align="left">آدرس انبار : </td><td align="right"><input type="text" class="textboxme" readonly id="address_anbar" name="address_anbar" value="'.$addressANBAR.'"/></td></tr>
	      <tr><td>&nbsp;</td></tr>
		 </table>
        </fieldset>
	   </td>
	   <td colspan="" valign="top">
	    <fieldset>
	     <legend>مقادیر</legend>
	     <table width="100%">
	      <tr><td align="left"  width="200px"><span class="star">*</span> مقدار حواله فروش: </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_havale_forush" value="'.$row1['h_pre_amount'].'" onblur="return mandeAzForushSell()" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
	      <tr><td align="left">مقدار تحویلی از حواله : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_tahvily" value="'.round($meghdar_tahvily,3).'" onblur="return mandeAzForushSell()"/></td></tr>
	      <tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" readonly class="textboxme2" readonly name="meghdar_batele" value="'.round($batele_forush,3).'" onblur="return mandeAzForushSell()"/></td></tr>
	      <tr><td align="left">مقدار مانده از حواله فروش : </td><td align="right"><input type="text" class="textboxme2" name="h_mande_havale" value="'.($row1['h_mande_havale']).'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
	     </table>
	    </fieldset>
       </td>
	  </tr>';
   }	
   echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 echo'
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table  width="100%"  border="0" cellspacing="0" cellpadding="0" height="100%"  style="margin-bottom:20px;">
    <tr>';
	  if(($_SESSION['mtStatusYear']==0)or(SuperUser()))//اگر سال فعال بود یا سوپریوزر بود
	  {
	  echo'
	   <td align="center">
	    <input type="submit" class="buttonme" name="Edit_x" id="sabt" value="ثبت تغييرات">
   	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'havale_forush.php?PageNo='.$PageNo.'\'" >
	   </td>';
      }
	  else echo'<td width="45%">&nbsp;</td><td width="70px"><div onClick="window.location=\'havale_forush.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back" title="بازگشت"><a href="#"></a></div></td> ';
     echo'	  
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
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($h_c,$h_date,$n_h_f,$code_k,$code_c,$m_h_f,$h_deli,$gl_c_o,$gl_c_s,$gl_year,$this_id)
{
  $flag=false;
  if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
  {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
  }
  else $flag=true; 
  if(!($h_c and $h_date and $n_h_f and $code_k and $code_c and $m_h_f and $h_deli))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if(!empty($code_k))//وجود داشتن کد کالا در جدول کالا
  {
   $q8="SELECT COUNT(code_kala) FROM kala WHERE code_kala='$code_k'";
   $res8=mysql_query($q8);
   $row8=mysql_fetch_array($res8);   
   if($row8[0]==0)
   {
     echo"<script>alert('کالایی با این کد کالا در جدول کالا وجود ندارد')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true; 
  }
  else $flag=true; 
  if(!empty($code_c))//وجود داشتن کد مشتری در جدول مشتریان
  {
   $q9="SELECT COUNT(code_customer) FROM moshtary WHERE code_customer='$code_c' AND code_ostan='$gl_c_o'";
   $res9=mysql_query($q9);
   $row9=mysql_fetch_array($res9);   
   if($row9[0]==0)
   {
     echo"<script>alert(مشتری با این کد مشتری در جدول مشتریان وجود ندارد !)</script>";
     $flag=false;
     return $flag;
   }
  else $flag=true; 
  }
  else $flag=true; 
 return $flag;
}
   

/************EDIT BUTTON********/// اصلاح اطلاعات	
if (isset($Edit_x))
{
  /**اگر به فروش متصل هستیم**/
  if($_SESSION['mt_systemforush']==1)
  {  //آپدیت مانده مقدار حواله فروش در جدول حواله فروش سیستم فروش
	    mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
	     //$update_mande=$mande_az_forush-$vazn_khales_h; 
         $res_update_mande=$db->query("UPDATE dm_havale SET h_mande_havale='$h_mande_havale' WHERE h_id='$id_'");    
	   	mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());
  }
  /**اگر به فروش متصل نیستیم**/
  if($_SESSION['mt_systemforush']==0)
  {
	//if(isPermitEdit($h_code,$h_reg_date,$noe_havale_forush,$code_kala,$code_customer,$meghdar_havale_forush,$h_deli_name,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$id_))
    //{ 
	  $edit_q=("UPDATE $TableName SET h_reg_date='$h_reg_date',noe_havale_forush='$noe_havale_forush',code_kala='$code_kala',code_customer='$code_customer',h_deli_name='$h_deli_name' WHERE id='$id_';");		  
      //echo ("UPDATE $TableName SET h_reg_date='$h_reg_date',noe_havale_forush='$noe_havale_forush',code_kala='$code_kala',code_customer='$code_customer',h_deli_name='$h_deli_name' WHERE id='$id_';");		  
      $edit_res=$db->query($edit_q,'مشکلی در ویرایش مشخصات به وجود آمده است');
      if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/  
    //}
  }
  echo "<script>window.location='havale_forush.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
}	
?>