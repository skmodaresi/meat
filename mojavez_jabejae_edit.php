<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="mojavez_jabejae_edit.php";
$TableName="mojavez_jabejae";
$logtime=date('H:i:s');
$TableName="mojavez_jabejae";
$title='ویرایش مجوز جابه جایی';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){		
        $("#datepicker6").datepicker({
            showOn: "button",
            buttonImage: "styles/images/calendar5.png",
            buttonImageOnly: true,
	    	showButtonPanel: true
        });
		<!--تغییر براساس نوع مجوز-->
        $("[name=noe_mojavez_edit]").bind("change", function (){
		if($(this).val() == 0)
		{
			$("#loading").fadeIn("fast");
			$(".panel").fadeOut("slow",function(){
			$(".notaion").fadeIn("fast");
			$("#loading").fadeOut("fast");
			});	
		}
		if($(this).val() == 1)<!--نوع مجوز فی مابین مناطق --> 
	    {
	        $("#loading").fadeIn("fast");
			$(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");
		    $(".fimabeyn").show();
	        $(".amany").hide();
	        $("#loading").fadeOut("fast");
			});
        }
		if(($(this).val() == 2)||($(this).val() == 4))<!--نوع مجوز کالای امانی یا جایگزینی با بخش خصوصی --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");	
			$(".fimabeyn").hide();
	        $(".amany").show();
	        $("#loading").fadeOut("fast");
            });			
        }
      });		
}); 
</script>
<script type="text/javascript">
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
   window.event.keyCode = 9;
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
 function getDetailKala(code_kala)<!--اطلاعات کالا-->
 { 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKALA : code_kala},function(data){			 
			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#sharh_bastebandy").val(splKala[2]);
			  $("#rahnama").html(splKala[3]);
		 });
    $("#loading").fadeOut("fast");
 }
<!-- تعویض انبار با انتخاب استان-->
function getAnbareOstan(code_ostan)
{
   $("#loading").fadeIn("fast");  
   $.post("ajax_mojavez_jabejae.php",{codeOSTAN1:code_ostan},function(data){$("[name=code_anbar_maghsad_j]").html(data);});
   $("#loading").fadeOut("fast");		
}
<!-- تعویض اطلاعات شماره سفر با انتخاب کشتی--><!--همراه با نام کشتی-->
function getShomareSafar(code_skk)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{codeKESHTY:code_skk},function(data)
  {
   var spl = data.split("^");
   $("#name_skk").val(spl[0]);
   $("[name=id_safar]").html(spl[1]);
  });
  $("#loading").fadeOut("fast");		
}
function mandeAzJabejaeEdit()
{
 var natije;
 natije=parseFloat((document.myform.meghdar_jabejae.value)-(document.myform.meghdar_tahvily_j.value)-(document.myform.maghadir_batele_j.value)).toFixed(3); 
 if(natije<0) natije=0;
 document.myform.mande_az_jabejae.value=natije;
}
</script>
</head>';
if(!(isset($Mode))) $Mode=''; 
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.tarikh_jabejae.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">مجوز جابه جایی شماره '.$shomare_jabejae_.'</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>';
	$q1="SELECT $TableName.*,kala.name_kala,bastebandy.code_bastebandy,bastebandy.sharh_bastebandy,vahed_kala.sharh_vahedkala,ostan.name_ostan,list_sardkhane.name_anbar FROM $TableName 
         INNER JOIN kala ON $TableName.code_kala=kala.code_kala 
         INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy
         INNER JOIN vahed_kala ON vahed_kala.code_vahedkala=kala.code_vahedkala
         LEFT JOIN ostan ON ostan.code_ostan=$TableName.code_ostan_maghsad_j
         LEFT JOIN list_sardkhane ON $TableName.code_anbar_maghsad_j=list_sardkhane.code_anbar AND $TableName.code_ostan_maghsad_j=list_sardkhane.code_ostan 
	     WHERE $TableName.id='$id_'";	 
	$res1=$db->query($q1);
    $row1=$db->fetch_assoc($res1);
	$ostanMabda=$db->get_from_where("name_ostan","ostan","code_ostan=".$row1['code_ostan']."");     
	$anbarMabda=$db->get_from_where("name_anbar","list_sardkhane","code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");     
    //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	$meghdar_tahvily_j=tahvily_az_jabejae($row1['shomare_jabejae'],$row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_bastebandy'],$row1['code_kala']);
	// $q21="select SUM(meghdar_batele) FROM ebtal WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";//محاسبه مقدار باطله
    // $res21=$db->query($q21);
    // $meghdar_batele=$db->fetch_array($res21);
    // $mande_az_forush=$row1['mande_az_forush'];
    //محاسبه مقادیر باطله مجوز جابه جایی با استفاده از تابع
	$maghadir_batele_j=batele_jabejae($row1['shomare_jabejae'],$row1['code_ostan'],$row1['code_anbar'],$row1['year']);
   if($row1['noe_mojavez']==2)//اگر کالای امانی بود
   {
    //سیستم سردخانه
    if($_SESSION['mt_systemforush']==0)
    { 
      //بدست آوردن نام مشتری
       $q_moshtary="SELECT name_customer,code_ostan,city_code,customer_address_office FROM moshtary WHERE code_customer='".$row1['code_customer']."'";
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
      $q_moshtary="SELECT customer_province_id,customer_city_id,name_customer,customer_address_office FROM dm_customer_asli WHERE code_customer='".$row1['code_customer']."'";
      $res_moshtary=mysql_query($q_moshtary);
      $row_moshtary=mysql_fetch_array($res_moshtary);
     //بدست آوردن نام استان مشتری
      $q_ostan_moshtary="SELECT * FROM dm_province WHERE province_id='".$row_moshtary['customer_province_id']."'";
      $res_ostan_moshtary=mysql_query($q_ostan_moshtary);
      $row_ostan_moshtary=mysql_fetch_array($res_ostan_moshtary);
   	  $ostan_moshtary=$row_ostan_moshtary['province_name'];
      $db->selectDb($mydatabase);
    }
   }
   $exist_havale=$db->get_from_where("count(*)","havale","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND shomare_jabejae='".$row1['shomare_jabejae']."'");     	
   $exist_havale_detail=$db->get_from_where("count(*)","havale_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND havale_deleted=0 AND shomare_jabejae='".$row1['shomare_jabejae']."'");     	
	echo'
	  <tr class="tr1">
	   <td width="50%">
        <table width="100%" border="0">
	     <tr><td align="left" width="210px"> شناسه مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" name="shomare_jabejae" value="'.$row1['id'].'" readonly/></td></tr>
		 <tr><td align="left" width="210px"><span class="star">*</span> شماره مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" name="shomare_jabejae" value="'.$row1['shomare_jabejae'].'" ';IF(($exist_havale)or($exist_havale_detail)) echo' readonly'; echo' /></td></tr>
	    </table>
	   </td>
	   <td width="50%">
        <table width="100%" border="0">
	     <tr><td align="left" width="210px"><span class="star">*</span> تاريخ مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" id="datepicker6" maxlength="10" name="tarikh_jabejae" value="'.$row1['tarikh_jabejae'].'"/></td></tr>	 
	      
	       <!--<tr><td align="left" width="210px"><span class="star">*</span> نوع مجوز  : </td><td align="right">'.static_listbox("noe_mojavez",$row1['noe_mojavez'],"mojavezjabejaeArr",1,"class='text4' onchange=myform.submit()").'</td></tr>-->';
	       //if($exist_havale) echo'<tr><td align="left" width="210px"><span class="star">*</span> نوع مجوز  : </td><td align="right"><input type="hidden" name="noe_mojavez" value="'.$row1['noe_mojavez'].'"/>'.static_listbox("noe_mojavez",$row1['noe_mojavez'],"mojavezjabejaeArr",1,"class='text4' disabled").'</td></tr>';
	       //else {$noe_mojavez_default=$row1['noe_mojavez']; echo'<tr><td align="left" width="210px"><span class="star">*</span> نوع مجوز  : </td><td align="right">'.static_listbox("noe_mojavez",$noe_mojavez_default,"mojavezjabejaeArr",1,"class='text4' disabled").'</td></tr>';}
	       echo'<tr><td align="left" ><span class="star">*</span> نوع مجوز  : </td><td align="right"><input type="hidden" name="noe_mojavez" value="'.$row1['noe_mojavez'].'"/>'.static_listbox("noe_mojavez",$row1['noe_mojavez'],"mojavezjabejaeArr",1,"class='text4' disabled").'</td></tr>';
	       echo'
	    </table>
	   </td>
	  </tr>
	  <tr class="tr1">
	   <td valign="top" width="50%">
	    <fieldset>
	     <legend>اطلاعات استان مبدأ</legend>
	     <table border="0" width="100%" height="100px">
	      <tr><td align="left" width="200px"> نام استان مبدأ : </td><td align="right"><input type="text" class="textboxme" readonly  value="'.$ostanMabda.'"/></td></tr>
	  	  <tr><td align="left">نام انبار مبدأ : </td><td align="right"><input type="text" class="textboxme" readonly  value="'.$anbarMabda.'"/></td></tr>
	     </table>
        </fieldset>
	   </td>
       <td valign="top" width="50%">
	    <fieldset>';
		 IF($row1['noe_mojavez']==1)//فی مابین 
		 {
		  echo'
	      <legend>اطلاعات استان مقصد</legend>
	      <table width="100%" height="100px" border="0">';
          IF(($exist_havale)or($exist_havale_detail))		  
		  {echo'
	  	   <tr><td align="left" width="200px"><span class="star">*</span> نام استان مقصد : </td><td align="right"><input type="hidden" name="code_ostan_maghsad_j" value="'.$row1['code_ostan_maghsad_j'].'"/>'.listbox("code_ostan_maghsad_j",$row1['code_ostan_maghsad_j'],"code_ostan","name_ostan","ostan","1=1 ORDER BY name_ostan ASC","onchange=getAnbareOstan(this.value) class='text4' disabled","").'</td></tr>
	       <tr><td align="left"><span class="star">*</span> نام انبار مقصد : </td><td align="right" colspan="2"><input type="hidden" name="code_anbar_maghsad_j" value="'.$row1['code_anbar_maghsad_j'].'"/>'.listbox("code_anbar_maghsad_j",$row1['code_anbar_maghsad_j'],"code_anbar","name_anbar","list_sardkhane","code_ostan=".$row1['code_ostan_maghsad_j']." ORDER BY name_anbar","class='text4' disabled").'</td></tr>';
	      }
          ELSE		  
		  {echo'
	  	   <tr><td align="left" width="200px"><span class="star">*</span> نام استان مقصد : </td><td align="right">';
		   //سردخانه حقیقی تمام استانها را میتواند انتخاب کند
		   if($_SESSION['mt_situation_type']==1)echo''.listbox("code_ostan_maghsad_j",$row1['code_ostan_maghsad_j'],"code_ostan","name_ostan","ostan","1=1 ORDER BY name_ostan ASC","onchange=getAnbareOstan(this.value) class='text4'","").'';
		   //سردخانه مجازی فقط استان خودش
		   else	echo''.listbox("code_ostan_maghsad_j",$row1['code_ostan_maghsad_j'],"code_ostan","name_ostan","ostan","code_ostan=$mt_gl_code_ostan ORDER BY name_ostan ASC","onchange=getAnbareOstan(this.value) class='text4'","").'';

		   echo'
		   </td></tr>
	       <tr><td align="left"><span class="star">*</span> نام انبار مقصد : </td>
		   <td align="right" colspan="2">';
		   //IF($row1['noe_mojavez']==1) echo' '.listbox("code_anbar_maghsad_j",$row1['code_anbar_maghsad_j'],"code_anbar","name_anbar","list_sardkhane","code_ostan=".$row1['code_ostan_maghsad_j']." AND code_anbar!='$mt_gl_code_anbar'  ORDER BY name_anbar","class='text4'").'</td></tr>';
		    echo' '.listbox("code_anbar_maghsad_j",$row1['code_anbar_maghsad_j'],"code_anbar","name_anbar","list_sardkhane","code_ostan=".$row1['code_ostan_maghsad_j']."  ORDER BY name_anbar","class='text4'").'</td></tr>';
	      }
		  echo'
		  </table>';
		 }
		 
		 IF($row1['noe_mojavez']==5)//تحت کلید
		 {
		  echo'
	      <legend>اطلاعات استان مقصد</legend>
	      <table width="100%" height="100px" border="0">
	  	   <tr><td align="left" width="200px"><span class="star">*</span> نام استان مقصد : </td><td align="right"><input type="hidden" name="code_ostan_maghsad_j" value="'.$row1['code_ostan_maghsad_j'].'"/>'.listbox("code_ostan_maghsad_j",$row1['code_ostan_maghsad_j'],"code_ostan","name_ostan","ostan","1=1 ORDER BY name_ostan ASC","onchange=getAnbareOstan(this.value) class='text4' disabled","").'</td></tr>
	       <tr><td align="left"><span class="star">*</span> نام انبار مقصد : </td><td align="right" colspan="2"><input type="hidden" name="code_anbar_maghsad_j" value="'.$row1['code_anbar_maghsad_j'].'"/>'.listbox("code_anbar_maghsad_j",$row1['code_anbar_maghsad_j'],"code_anbar","name_anbar","list_sardkhane","code_ostan=".$row1['code_ostan_maghsad_j']." ORDER BY name_anbar","class='text4' disabled").'</td></tr>
		  </table>';
			 
		 }
         IF(($row1['noe_mojavez']==2)OR($row1['noe_mojavez']==4))//کالای امانی
		 {
		  echo'
		  <legend class="amany">اطلاعات مشتری</legend>
	      <table class="amany" width="100%" height="100px" border="0">';
		   IF(($exist_havale)or($exist_havale_detail))echo'<tr><td align="left" width="200px"><span class="star">*</span> کد مشتری : </td><td align="right"><input type="text" class="textboxme" name="code_customer" value="'.$row1['code_customer'].'" readonly style="width:50px;"/></td></tr>';
		   ELSE echo'<tr><td align="left" width="200px"><span class="star">*</span> کد مشتری : </td><td align="right"><input type="text" class="textboxme" name="code_customer" value="'.$row1['code_customer'].'" onfocus="getDetailMoshtary(this.value)" onchange="getDetailMoshtary(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;<img border="0" src="images/help.png" onClick="window.showModalDialog(\'help_moshtary.php\',\'_blank\',\'dialogwidth=500px,left=20px,scrollbars=yes\')" title="جدول کد مشتری" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td></tr>';
		   echo'
		   <tr><td align="left" > نام مشتری : </td><td align="right"><input type="text" class="textboxme" readonly id="name_customer" name="name_customer" value="'.$row_moshtary['name_customer'].'"/></td></tr>
	       <tr><td align="left" > آدرس مشتری : </td><td align="right"><input type="text" class="textboxme" readonly id="customer_address_office" name="customer_address_office" value="'.$row_moshtary['customer_address_office'].'"/></td></tr>
	      </table>';
		 }
		 IF($row1['noe_mojavez']==3)//مرجوعی
		 {
		  $name_skk=$db->get_from_where("name_skk","mt_skk","code_skk=".$row1['code_skk']."");
		  $shomare_safar=$db->get_from_where("shomare_safar","shomare_safar","id_safar=".$row1['id_safar']."");
		  echo'
		  <legend class="amany">اطلاعات کشتی/ فروشنده</legend>
	      <table class="amany" width="100%" height="100px" border="0">';
		   IF(($exist_havale)or($exist_havale_detail))echo'<tr><td align="left" width="200px"><span class="star">*</span> کد کشتی / فروشنده : </td><td align="right"><input type="text" class="textboxme" name="code_skk" value="'.$row1['code_skk'].'" readonly style="width:50px;"/></td></tr>';
		   ELSE{echo'<tr><td align="left" width="200px"><span class="star">*</span> کد کشتی / فروشنده : </td><td align="right"><input type="text" class="textboxme" name="code_skk" value="'.$row1['code_skk'].'" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;';include ("img_helpskk.php");echo'</td></tr>';}
		   echo'
		   <tr><td align="left" > نام کشتی / فروشنده : </td><td align="right"><input type="text" class="textboxme" readonly id="name_skk" name="name_skk" value="'.$name_skk.'"/></td></tr>
		   <tr><td align="left"><span class="star">*</span> شماره سفر / مجوز : </td><td align="right">';
	       IF(($exist_havale)or($exist_havale_detail))echo'<input type="text" class="textboxme2" readonly id="id_safar" name="id_safar" value="'.$shomare_safar.'"/>';
	       ELSE echo''.listbox("id_safar",$row1['id_safar'],"id_safar","shomare_safar","shomare_safar","code_skk=".$row1['code_skk']." AND etmam_safar=0","class='text4'").'';
		   echo'
		   </td>
		   </tr>
		  </table>';
		 }
		 echo'
	    </fieldset>
       </td>
	  </tr>
	  <tr class="tr1">
	   <td valign="top">
	    <fieldset>
	     <legend>کالا</legend>
	     <table width="100%">';
		 IF(($exist_havale)or($exist_havale_detail)){echo'<tr><td align="left" width="150px"> کد کالا :</td><td align="right"><input readonly type="text" class="textboxme2" name="code_kala" value="'.$row1['code_kala'].'" onfocus="getDetailKala(this.value)" onchange="getDetailKala(this.value)" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>&nbsp;';}
		 ELSE {echo'<tr><td align="left" width="150px"><span class="star">*</span> کد کالا :</td><td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$row1['code_kala'].'" onfocus="getDetailKala(this.value)" onchange="getDetailKala(this.value)" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>&nbsp;';
	  	      include ("img_helpkala.php");}
	  	echo'
	  	  </td>
	  	</tr>
	  	<tr><td align="left" width="200px">نام کالا : </td><td align="right"><input type="text" class="textboxme" readonly id="name_kala" name="name_kala" value="'.$row1['name_kala'].'"/></td></tr>
          <tr><td align="left">نوع بسته بندی : </td><td align="right"><input type="text" class="textboxme" readonly id="sharh_bastebandy" name="sharh_bastebandy" value="'.$row1['sharh_bastebandy'].'"/></td></tr>
	      <tr><td>&nbsp</td></tr>
	     </table>
	    </fieldset>
	   </td>
	   <td colspan="" valign="top">
	    <fieldset>
	     <legend>مقادیر</legend>
	     <table width="100%" border="0">
		  <tr><td align="left" width="200px"><span class="star">*</span> مقدار مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" name="meghdar_jabejae" value="'.$row1['meghdar_jabejae'].'" onblur="return mandeAzJabejaeEdit();" onKeydown="return PressfloatOnly(event,this)"/>
		  <span name="rahnama" id="rahnama" class="rahnama">';
		  //<tr><td align="left" width="200px"><span class="star">*</span> مقدار مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" name="meghdar_jabejae" value="'.$row1['meghdar_jabejae'].'" onblur="return mandeAzJabejaeEdit();" onKeydown="return PressfloatOnly(event,this)" ';if(!(SuperUser())) echo'readonly'; echo'/>';
		  if($row1['code_bastebandy']==1)
		  {
			if(($row1['code_kala']==50)OR($row1['code_kala']==54)) echo'(تعداد شانه)';
			else echo'(کیلوگرم)';
		  }	  
		  else echo'(تعداد)';
		  echo'
		    </span>
		   </td>
		  </tr>
	      <tr><td align="left">مقدار تحویلی  : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_tahvily_j" value="'.round($meghdar_tahvily_j,3).'"/></td></tr>
	  	  <tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" class="textboxme2" readonly name="maghadir_batele_j" value="'.$maghadir_batele_j.'"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> مقدار مانده از مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2"  name="mande_az_jabejae" value="'.$row1['mande_az_jabejae'].'" onkeypress="return isNumber(event)" readonly/></td></tr>
	     </table>
	    </fieldset>
       </td>
	  </tr>
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table  width="100%"  border="0" cellspacing="0" cellpadding="0" height="100%" >
    <tr>';
	if(($_SESSION['mtStatusYear']==0)or(SuperUser()))//اگر سال فعال بود یا سوپریوزر بود
	{
	 echo'
     <td align="center">
	  <input type="submit" class="buttonme" name="Edit_x" id="sabt" value="ثبت تغييرات">
   	  <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'mojavez_jabejae.php?PageNo='.$PageNo.'\'" >
	 </td>';
    }
    else echo'<td width="45%">&nbsp;</td><td width="70px"><div onClick="window.location=\'mojavez_jabejae.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back" title="بازگشت"><a href="#"></a></div></td> ';
	echo'
	</tr>
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->	
</table>
</div>';
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($sh_j,$date_j,$noe_m,$code_c,$code_skk,$safar,$c_o_m_j,$c_a_m_j,$code_k,$meghdar_j,$tahvily,$batele,$mande_j,$gl_c_o,$gl_c_a,$gl_year)
{
    // echo"<script> alert('$safar')</script>";

  $flag=false;
  if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
  {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
  }
  else $flag=true;   
  if(!($sh_j and $date_j and $code_k and $meghdar_j))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
  } 
  else $flag=true;
  if(($noe_m==1)and(!($c_o_m_j and $c_a_m_j)))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
  } 
  else $flag=true;
  if(($noe_m==2)and(!($code_c)))//پر بودن فيلدها
  {
    $flag=false;
    echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
    return $flag;
  } 
  else $flag=true;
  if(($noe_m==3)and(!($code_skk and $safar)))//پر بودن فيلدها
  {
    $flag=false;
    echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
    return $flag;
  } 
  else $flag=true;
  if(!validMojavez($sh_j))
  {
   $flag=false;
   echo"<script>alert('شماره مجوز با فرمت نادرست وارد شده است!')</script>";
   return $flag;
  }
  else $flag=true;
  if(checkdatejalali($date_j)==false)//صحت فرمت تاریخ
  {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
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
  if(($noe_m==1)and($gl_c_o==$c_o_m_j)and($c_a_m_j==$gl_c_a))
  {
    echo"<script>alert('مجاز به انتخاب سردخانه انتخابی نیستید')</script>";
    $flag=false;
    return $flag;
  }
  else $flag=true;
  if(!empty($code_c))//وجود داشتن کد مشتری در جدول مشتریان
  {
    if($_SESSION['mt_systemforush']==0)//سردخانه
    {$q8="SELECT COUNT(code_customer) FROM meat.moshtary WHERE code_customer='$code_c'";}
    if($_SESSION['mt_systemforush']==1)//فروش 
    {
     //mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
	 //$q8="SELECT count(dm_customer_det.code_customer) FROM sell.dm_customer_asli INNER JOIN sell.dm_customer_det ON dm_customer_asli.code_customer=dm_customer_det.code_customer WHERE dm_customer_det.code_customer='$code_c' AND dm_customer_det.customer_code_org='$gl_c_o'";	
	 $q8="SELECT COUNT(code_customer) FROM sell.dm_customer_asli WHERE code_customer='$code_c'";
	 //$db->selectDb($mydatabase);
	}
	 $res8=mysql_query($q8);
     $row8=mysql_fetch_array($res8);
    if($row8[0]==0)
    {
      echo"<script>alert('مشتری بااین کد مشتری در جدول مشتریان وجود ندارد')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true; 
  }
  else $flag=true; 
  if(!empty($meghdar_j))//کمتر نبودن مقدار مجوز از تحویلی و باطله
  {
   $t1=round(($tahvily+$batele),3);
   if($meghdar_j<$t1)
   {
     echo"<script>alert('مقدار مجوز از مقادیر تحویلی و باطله کمتر است')</script>";
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
  if(isPermitEdit($shomare_jabejae,$tarikh_jabejae,$noe_mojavez,$code_customer,$code_skk,$id_safar,$code_ostan_maghsad_j,$code_anbar_maghsad_j,$code_kala,$meghdar_jabejae,$meghdar_tahvily_j,$maghadir_batele_j,$mande_az_jabejae,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
  { 
    $mande_az_jabejae=round($mande_az_jabejae,3);
	$edit_q=("UPDATE $TableName SET shomare_jabejae='$shomare_jabejae',tarikh_jabejae='$tarikh_jabejae',noe_mojavez='$noe_mojavez',code_customer='$code_customer',code_skk='$code_skk',id_safar='$id_safar',code_ostan_maghsad_j='$code_ostan_maghsad_j',code_anbar_maghsad_j='$code_anbar_maghsad_j',code_kala='$code_kala',meghdar_jabejae='$meghdar_jabejae',mande_az_jabejae='$mande_az_jabejae' WHERE id='$id_';");		  
    $edit_res=mysql_query($edit_q);
    if(($edit_res) and (mysql_affected_rows()!=0))
    { $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/  
      echo "<script>window.location='mojavez_jabejae.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
    }
    else if(mysql_affected_rows()==0) echo "<script>window.location='mojavez_jabejae.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
    else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>'; 	  
  }
}	  
/*************END*****************/
echo'	
'.$message.'
</form>
</body>
</html>';
?>