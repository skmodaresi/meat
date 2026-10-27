<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="mojavez_jabejae_new.php";
$TableName="mojavez_jabejae";
$logtime=date('H:i:s');
$titr='ایجاد مجوز جابه جایی جدید';
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
        $("[name=noe_mojavez]").bind("change", function (){
		if($(this).val() == 0)
		{
			$("#loading").fadeIn("fast");
			$(".panel").fadeOut("slow",function(){
			$(".notaion").fadeIn("fast");
			$("#loading").fadeOut("fast");
			});	
		}
		if(($(this).val() == 1)||($(this).val() == 5))<!--نوع مجوز فی مابین مناطق یا تحت کلید گمرک--> 
		
	    {
	        $("#loading").fadeIn("fast");
			$(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");
		    $(".fimabeyn").show();
	        $(".amany").hide();
	        $(".marjoee").hide();
			$("#loading").fadeOut("fast");
			//$("[name=code_ostan]").bind("change", function getAnbareOstan(){})
			});
        }
		if(($(this).val() == 2)||($(this).val() == 4))<!--نوع مجوز کالای امانی یا جایگزینی با بخش خصوصی --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");	
			$(".fimabeyn").hide();
			$(".marjoee").hide();
	        $(".amany").show();
	        $("#loading").fadeOut("fast");
            });			
        }
		if($(this).val() == 3)<!--نوع مجوز مرجوعی --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");	
			$(".fimabeyn").hide();
	        $(".amany").hide();
			$(".marjoee").show();
	        $("#loading").fadeOut("fast");
            });			
        }
      });		
});
</script>
<script type="text/javascript">
 function enterIE()
 {
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
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
			  //$("#rahnama").val(splKala[3]);
			  $("#rahnama").html(splKala[3]);
		 });
    $("#loading").fadeOut("fast");
 }
 <!-- تعویض انبار با انتخاب استان-->
 function getAnbareOstan(code_ostan,noe_mojavez)
 {
   $("#loading").fadeIn("fast");  
   $.post("ajax_mojavez_jabejae.php",{codeOSTAN1:code_ostan,noeMojavez:noe_mojavez},function(data){$("#anbar_maghsad").html(data);});
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
function mandeAzJabejae()
{
 var natije;
 natije=parseFloat(document.myform.meghdar_jabejae.value).toFixed(3); 
 document.myform.mande_az_jabejae.value=natije;
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_jabejae.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>
    <tr class="tr1">
	 <td width="50%">
      <table width="100%" border="0">
	   <tr><td align="left" width="210px"><span class="star">*</span> شماره مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" name="shomare_jabejae" value="'.$shomare_jabejae.'"/></td></tr>
	  </table>
	 </td>
	 <td width="50%">
      <table width="100%" border="0">
	   <tr> 	  
		<td align="left" width="210px"><span class="star">*</span> تاريخ مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" id="datepicker6" maxlength="10" name="tarikh_jabejae" value="'.$tarikh_jabejae.'"/></td>	 
	    <td align="left" width="30px" style="color:red">توجه</td><td align="left"  width="30px"><img border="0" src="images/Info1.png" title="لطفاً در ثبت مقادیر دقت نمایید ، بعد از کلیک روی گزینه ثبت امکان ویرایش مقادیر وجود ندارد" style="cursor:pointer" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'"/></span></td>
	   </tr>
	  </table>
	 </td>
	</tr>
	<tr class="tr1">
	 <td width="50%">
      <table width="100%" border="0">
	   <tr>';
	    //اگر اولین بار است که وارد صفحه می شویم
		if(!isset($noe_mojavez))
		{
		 if($_SESSION['mt_situation_type']==1) echo'<td align="left" width="210px"><span class="star">*</span> نوع مجوز : </td><td align="right" colspan="3">'.static_listbox("noe_mojavez",$noe_mojavez,"mojavezjabejaeArr",1,"class='text4'").'</td>';
		 else  echo'<td align="left" width="210px"><span class="star">*</span> نوع مجوز : </td><td align="right" colspan="3">'.static_listbox("noe_mojavez",$noe_mojavez,"mojavezjabejaeArrMovaghat",1,"class='text4'").'</td>';
		}
	    //اگر ارروری ظاهر شده و به صفحه برگشته ایم
		else
		{
		 if($_SESSION['mt_situation_type']==1)echo'<td align="left" width="210px"><span class="star">*</span> نوع مجوز  : </td><td align="right">'.static_listbox("noe_mojavez",$noe_mojavez,"mojavezjabejaeArr",1,"class='text4' onchange=myform.submit()").'</td>';
		 else echo'<td align="left" width="210px"><span class="star">*</span> نوع مجوز  : </td><td align="right">'.static_listbox("noe_mojavez",$noe_mojavez,"mojavezjabejaeArrMovaghat",1,"class='text4' onchange=myform.submit()").'</td>';
		}		 
		echo'
	   </tr>
	  </table>
	 </td>
	 <td width="50%"></td>
	</tr>';
	 //اگر اولین بار است وارد صفحه شده ایم
     if(!$noe_mojavez){echo'<tr class=" tr1 notaion"><td>برای مشاهده سایر اطلاعات نوع مجوز جابه جایی را انتخاب نمایید</td>	 <td width="50%"></td></tr><tr class="tr1 panel" style="display:none;">';}
     //اگر ارروری ظاهر شده و به صفحه برگشته ایم
	 else{echo'<tr class="tr1 panel">';}
	 echo'
	 <td valign="top" width="50%">
	  <fieldset>
	   <legend>اطلاعات استان مبدأ</legend>
	   <table border="0" width="100%" height="100px">
	    <tr><td align="left" width="200px"> نام استان مبدأ : </td><td align="right"><input type="text" class="textboxme" readonly  value="'.$mt_gl_name_ostan.'"/></td></tr>
		<tr><td align="left">نام انبار مبدأ : </td><td align="right"><input type="text" class="textboxme" readonly  value="'.$mt_gl_name_anbar.'"/></td></tr>
	   </table>
      </fieldset>
	 </td>
	 <td valign="top" width="50%">
	  <fieldset>';
	  if(($noe_mojavez==2)or($noe_mojavez==4))
	  {
	   echo'
	   	<legend class="amany">اطلاعات مشتری</legend>
	     <table class="amany" width="100%" height="100px" border="0">
	      <tr><td align="left" width="200px"><span class="star">*</span> کد مشتری : </td><td align="right"><input type="text" class="textboxme" name="code_customer" value="'.$code_customer.'" onfocus="getDetailMoshtary(this.value)" onchange="getDetailMoshtary(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;';
		   include ("img_searchmoshtary.php");
           echo'
		   </td></tr>
		  <tr><td align="left" >نام مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="name_customer" name="name_customer" value="'.$name_customer.'"/></td></tr>
	      <!--<tr><td align="left" >استان مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="code_ostan" name="code_ostan" value="'.$code_ostan.'"/></td></tr>-->
	      <tr><td align="left" >آدرس مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="customer_address_office" name="customer_address_office" value="'.$customer_address_office.'"/></td></tr>
	     </table>';
	  }
	  else if($noe_mojavez==3)
	  {
	   echo'
	   	<legend class="amany">اطلاعات کشتی/ فروشنده</legend>
	     <table class="amany" width="100%" height="100px" border="0">
	      <tr><td align="left" width="200px"><span class="star">*</span> کد کشتی / فروشنده : </td><td align="right"><input type="text" class="textboxme" name="code_skk" value="'.$code_skk.'" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;';
		   include ("img_helpskk.php");
           echo'
		   </td></tr>
		  <tr><td align="left" >نام کشتی / فروشنده :</td><td align="right"><input type="text" class="textboxme" readonly id="name_skk" name="name_skk" value="'.$name_skk.'"/></td></tr>
	      <tr>';
		  if($code_skk)//اگر شماره سفر قبلا انتخاب و اجازه ثبت داده نشده
	      {			
	         echo'<td align="left"><span class="star">*</span> شماره سفر / مجوز :</td>
			      <td align="right">'.listbox("id_safar",$id_safar,"id_safar","shomare_safar","shomare_safar","1=1 AND code_skk='$code_skk' AND etmam_safar=0","class='text4'").'';
		  }
	      else
	      {echo'<td align="left"><span class="star">*</span> شماره سفر / مجوز :</td><td align="right"><select name="id_safar" class="text4"><option value="0">انتخاب کنيد</option></select></td>';}		        
		  
		  echo'
		  </tr>
		 </table>';
	  }
	  // else if($noe_mojavez==5)
	  // {
		// echo'
	    // <legend class="fimabeyn">اطلاعات استان مقصد</legend>
	     // <table class="fimabeyn" width="100%" height="100px" border="0">
		  // <tr>
		   // <td align="left" width="200px"><span class="star">*</span> نام استان مقصد : </td>
		   // <td align="right">
		    // <input type="hidden" class="textboxme2" name="code_ostan_maghsad_j" readonly value="'.$mt_gl_code_ostan.'">
		    // <input type="text" class="textboxme2" name="mt_gl_name_ostan" readonly value="'.$mt_gl_name_ostan.'">
		   // </td>
		  // </tr>
          // <tr>		  
		   // <td align="left" width="200px"><span class="star">*</span> نام سردخانه مقصد : </td>
		   // <td align="right">
		    // <input type="hidden" class="textboxme2" name="code_anbar_maghsad_j" readonly value="'.$mt_gl_code_anbar.'">
		    // <input type="text" class="textboxme2" name="mt_gl_name_anbar" readonly value="'.$mt_gl_name_anbar.'">
		   // </td>
		  // </tr>
		 // </table>'; 
	  // }	  
	  else//اولین بار بدون رفرش صفحه
	  {                                                                                                                                                                                                                            
	   echo'
	    <legend class="fimabeyn">اطلاعات استان مقصد</legend>
	     <table class="fimabeyn" width="100%" height="100px" border="0">
		  <tr><td align="left" width="200px"><span class="star">*</span> نام استان مقصد : </td><td align="right">';
		  //سردخانه حقیقی تمام استانها را میتواند انتخاب کند
		  if($_SESSION['mt_situation_type']==1)
		  {
			  //if($noe_mojavez==1)//
			   echo''.listbox("code_ostan_maghsad_j",$code_ostan_maghsad_j,"code_ostan","name_ostan","ostan","1=1 ORDER BY name_ostan ASC","onchange=getAnbareOstan(this.value,document.myform.noe_mojavez.value) class='text4'","").'';
			 // else if($noe_mojavez==5) 
			  // echo''.listbox("code_ostan_maghsad_j",$code_ostan_maghsad_j,"code_ostan","name_ostan","ostan","1=1 ORDER BY name_ostan ASC","onchange=getAnbareOstanGomrok(this.value) class='text4'","").'';
		  }
		  //سردخانه مجازی فقط استان خودش
		  else echo''.listbox("code_ostan_maghsad_j",$code_ostan_maghsad_j,"code_ostan","name_ostan","ostan","code_ostan=$mt_gl_code_ostan ORDER BY name_ostan ASC","onchange=getAnbareOstan(this.value) class='text4'","").'';
		  echo'</td></tr>';
		 if($code_ostan_maghsad_j)//اگر نام انبار قبلا انتخاب و اجازه ثبت داده نشده
		 {
		    echo'<tr><td align="left" width="150px"><span class="star">*</span> نام انبار مقصد :</td><td align="right">';
				if(($code_ostan_maghsad_j==$mt_gl_code_ostan)AND($noe_mojavezojavez==1)) echo''.listbox("code_anbar_maghsad_j",$code_anbar_maghsad_j,"code_anbar","name_anbar","list_sardkhane","1=1 AND code_ostan='$code_ostan_maghsad_j' AND code_anbar!='$mt_gl_code_anbar' ORDER BY name_anbar","class='text4'").'';
				else echo''.listbox("code_anbar_maghsad_j",$code_anbar_maghsad_j,"code_anbar","name_anbar","list_sardkhane","1=1 AND code_ostan='$code_ostan_maghsad_j' ORDER BY name_anbar","class='text4'").'';
			    
			echo'		 
					 </td>
				 </tr>';
		 }
		 else
		 {echo'<tr><td align="left" width="200px"><span class="star">*</span> نام انبار مقصد :</td><td align="right"><select name="code_anbar_maghsad_j" id="anbar_maghsad" class="text4"><option value="0">انتخاب کنيد</option></select></td></tr>';}
         echo'
	    </table>';
	    echo'
	   	<legend class="amany" style="display:none;">اطلاعات مشتری</legend>
	     <table class="amany" style="display:none;" width="100%" height="100px" border="0">
		  <tr><td align="left" width="200px"><span class="star">*</span> کد مشتری : </td><td align="right"><input type="text" class="textboxme" name="code_customer" value="'.$code_customer.'" onfocus="getDetailMoshtary(this.value)" onchange="getDetailMoshtary(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;';
		   include ("img_searchmoshtary.php");
		   echo'
		   </td></tr>
		  <tr><td align="left" >نام مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="name_customer" name="name_customer" value="'.$name_customer.'"/></td></tr>
	      <!--<tr><td align="left" >استان مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="code_ostan" name="code_ostan" value="'.$code_ostan.'"/></td></tr>-->
	      <tr><td align="left" >آدرس مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="customer_address_office" name="customer_address_office" value="'.$customer_address_office.'"/></td></tr>
	     </table>';
		echo'
	   	<legend class="marjoee" style="display:none;">اطلاعات کشتی/ فروشنده</legend>
	     <table class="marjoee" style="display:none;" width="100%" height="100px" border="0">
		  <tr><td align="left" width="200px"><span class="star">*</span> کد کشتی / فروشنده : </td><td align="right"><input type="text" class="textboxme" name="code_skk" value="'.$code_skk.'" id="'.$code_skk.'" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;';
		   include ("img_helpskk.php");
		   echo'
		   </td>
		  </tr>
		  <tr><td align="left" width="150px"> نام کشتی / فروشنده : </td><td align="right"><input type="text" class="textboxme" readonly id="name_skk" name="name_skk" value="'.$name_skk.'"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> شماره سفر / مجوز :</td><td align="right"><select name="id_safar" class="text4"><option value="0">انتخاب کنيد</option></select></td></tr>
		 </table>';
		// echo'
	    // <legend class="tahtekelid">اطلاعات استان مقصد</legend>
	     // <table class="tahtekelid" width="100%" height="100px" border="0">
		  // <tr>
		   // <td align="left" width="200px"><span class="star">*</span> نام استان مقصد : </td>
		   // <td align="right">
		    // <input type="hidden" class="textboxme2" name="code_ostan_maghsad_j" readonly value="'.$mt_gl_code_ostan.'">
		    // <input type="text" class="textboxme2" name="mt_gl_name_ostan" readonly value="'.$mt_gl_name_ostan.'">
		   // </td>
		  // </tr>
          // <tr>		  
		   // <td align="left" width="200px"><span class="star">*</span> نام سردخانه مقصد : </td>
		   // <td align="right">
		    // <input type="hidden" class="textboxme2" name="code_anbar_maghsad_j" readonly value="'.$mt_gl_code_anbar.'">
		    // <input type="text" class="textboxme2" name="mt_gl_name_anbar" readonly value="'.$mt_gl_name_anbar.'">
		   // </td>
		  // </tr>
		 // </table>'; 
		 
		 
	  }
	 echo'
	  </fieldset>
     </td>
	</tr>';
    //اگر اولین بار است وارد صفحه شده ایم
    if(!$noe_mojavez){echo'<tr class="tr1 panel" style="display:none;">';}
    //اگر ارروری ظاهر شده و به صفحه برگشته ایم
	else{echo'<tr class="tr1 panel">';}
	echo'
	 <td valign="top">
	  <fieldset>
	   <legend>کالا</legend>
	   <table width="100%" height="100px">
	    <tr><td align="left" width="150px"><span class="star">*</span> کد کالا :</td><td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onfocus="getDetailKala(this.value)" onchange="getDetailKala(this.value)" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>&nbsp;';
		include ("img_helpkala.php");
		echo'
		  </td>
		</tr>
		<tr><td align="left" width="200px">نام کالا : </td><td align="right"><input type="text" class="textboxme" readonly id="name_kala" name="name_kala" value="'.$name_kala.'"/></td></tr>
        <tr><td align="left">نوع بسته بندی : </td><td align="right"><input type="text" class="textboxme" readonly id="sharh_bastebandy" name="sharh_bastebandy" value="'.$sharh_bastebandy.'"/></td></tr>
	   	<tr><td>&nbsp</td></tr>
	   </table>
	  </fieldset>
	 </td>
	 <td colspan="" valign="top">
	  <fieldset>
	   <legend>مقادیر</legend>
	   <table width="100%" height="100px" border="0">
		 <tr><td align="left" width="200px"><span class="star">*</span> مقدار مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" name="meghdar_jabejae" value="'.$meghdar_jabejae.'" onblur="return mandeAzJabejae();" onKeydown="return PressfloatOnly(event,this)"/><span name="rahnama" id="rahnama" class="rahnama"></span></td></tr>
	     <tr><td align="left">مقدار تحویلی  : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_tahvily_j" value="0"/></td></tr>
		 <tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_batele_j" value="0"/></td></tr>
	     <tr><td align="left"><span class="star">*</span> مقدار مانده از مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2"  name="mande_az_jabejae" readonly value="'.$mande_az_jabejae.'" onblur="return mandeAzJabejae();" /></td></tr>
	   </table>
	  </fieldset>
     </td>
	</tr>';
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
<!-- فوتر-->

 <tr class="footer">
  <td align="center">
   <input type="submit" class="buttonme" name="Insert_x" id="sabt" value="ثبت اطلاعات">
   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'mojavez_jabejae.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
  </td>
 </tr>
 </table>
</div>
<!-- پايان فوتر-->';
/************اجازه براي ذخيره اطلاعات************/ 
function isPermitSave($sh_j,$date_j,$noe_m,$code_c,$code_skk,$safar,$c_o_m_j,$c_a_m_j,$code_k,$meghdar_j,$gl_c_o,$gl_c_a,$gl_year,$mydatabase)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if((!($sh_j and $date_j and $noe_m and $code_k and $meghdar_j)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((($noe_m==1)or($noe_m==5))and(!($c_o_m_j and $c_a_m_j)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((($noe_m==2)or($noe_m==4))and(!($code_c)))//پر بودن فيلدها
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
 if(($sh_j!=NULL)and((!validMojavez($sh_j))))
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
 if(!empty($sh_j))//تکراری نبودن شماره مجوز
 { 
    //$q7="SELECT shomare_jabejae FROM mojavez_jabejae WHERE shomare_jabejae='$sh_j' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a' AND year='$gl_year'";
    $q7="SELECT shomare_jabejae FROM mojavez_jabejae WHERE shomare_jabejae='$sh_j' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a'";
    $res7=mysql_query($q7);
    if(mysql_num_rows($res7)>0){
    echo"<script>alert('اين شماره مجوز قبلاً ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
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
 if(($noe_m==5)and($gl_c_o!=$c_o_m_j)and($c_a_m_j!=$gl_c_a))
 {
    echo"<script>alert('مجاز به انتخاب سردخانه انتخابی نیستید.فقط مجاز به انتخاب استان و سردخانه خود هستید ')</script>";
    $flag=false;
    return $flag;
 }
 else $flag=true;
 if(!empty($code_c))//وجود داشتن کد مشتری در جدول مشتریان
 {
   if($_SESSION['mt_systemforush']==0)//سردخانه 
   {
    $q8="SELECT COUNT(code_customer) FROM moshtary WHERE code_customer='$code_c'";
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
   if($_SESSION['mt_systemforush']==1)//فروش
   {
    mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
	$q8="SELECT COUNT(code_customer) FROM dm_customer_asli WHERE code_customer='$code_c'";
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
   mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());	
 }
 else $flag=true; 
return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 if(isPermitSave($shomare_jabejae,$tarikh_jabejae,$noe_mojavez,$code_customer,$code_skk,$id_safar,$code_ostan_maghsad_j,$code_anbar_maghsad_j,$code_kala,$meghdar_jabejae,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$mydatabase))
 {
  $insert_q=("INSERT INTO $TableName(code_ostan,code_anbar,year,shomare_jabejae,tarikh_jabejae,noe_mojavez,code_customer,code_skk,id_safar,code_ostan_maghsad_j,code_anbar_maghsad_j,code_kala,meghdar_jabejae,mande_az_jabejae,deleted)
              VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$mtActiveYear','$shomare_jabejae','$tarikh_jabejae','$noe_mojavez','$code_customer','$code_skk','$id_safar','$code_ostan_maghsad_j','$code_anbar_maghsad_j','$code_kala','$meghdar_jabejae','$mande_az_jabejae',0)");         
  $insert_res=mysql_query($insert_q);
  if($insert_res)
  {
	$max_id=$db->get_from_where("MAX(id)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/
    echo "<script>alert(' مجوز جابه جایی با شماره مجوز".$shomare_jabejae." به ثبت رسید  ')</script>"; 
    echo "<script>window.location='mojavez_jabejae.php?PageNo=1&RowPerPage=".$RowPerPage."';</script>";  
  }
  else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت مجوز به وجود آمده است ! *</span>';   
 }
} 	
///////////////////////////////////////////////////////////////////
echo'	
'.$message.'
</form>
</body>
</html>';
?>