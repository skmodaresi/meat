<?php
require_once __DIR__ . '/mysql_compat.php';
ini_set('max_execution_time',300);
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="resid_new.php";
$TableName="resid";
$logtime=date('H:i:s');
$titr='ایجاد رسید جدید';
// ایجاد شماره رسید - با توجه به استان و انبار و سال 
$q2="SELECT shomare_resid FROM $TableName WHERE code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'
     order by shomare_resid DESC LIMIT 0,1";
$res2=$db->query($q2);
$row2=$db->fetch_assoc($res2);
$w=$row2['shomare_resid'];
if($w) {$shomare_resid=$w; $shomare_resid++;}
else $shomare_resid=1;
$shomare_resid=make_pattern($shomare_resid,5);
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $(".datepicker6").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true
    });
 });
function changeFocus(elmnt)
{
  var next;
  if (elmnt.value.length==elmnt.maxLength)
 {
  next=elmnt.tabIndex + 1;
  //look for the fields with the next tabIndex
  var f = elmnt.form;
  for (var i = 0; i < f.elements.length; i++)
  {
   if (next<=f.elements[i].tabIndex)
    {
     f.elements[i].focus();
     break;
    }
  }
 }
}
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width="+w+", height="+h+", top="+top+", left="+left);
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
<!-- پیمانکار حمل-->
function getNamePeymankar(code_peyman)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_resid.php",{codePEYMAN:code_peyman},function(data)
  {
   $("[name=name_peymankar_haml]").val(data);
  });
  $("#loading").fadeOut("fast");		
}
<!-- مبادی ورودی-->
function getNameBargiry(code_mabda_vorudy)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_resid.php",{codeMABDA_V:code_mabda_vorudy},function(data)
  {
   $("[name=name_mabda]").val(data);
  });
  $("#loading").fadeOut("fast");		
}
<!-- نرخ باسکول با انتخاب نوع خودرو-->
function getNerkhBaskul(noe_khodro)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{noeKHODRO:noe_khodro},function(data){
   $("#mablagh_baskul").val(data);
  });
  $("#loading").fadeOut("fast");		
}
function getDetailKeshvar(code_keshvar)<!--اطلاعات کشور--><!--DONT USE***   -->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKESHVAR : code_keshvar},function(data){$("#name_keshvar").val(data);});
    $("#loading").fadeOut("fast");
}
function getVaznKarton(c_karton)<!-- اطلاعات کارتن--><!--DONT USE***   -->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeKARTON: c_karton},function(data){
		   var splKarton = data.split("^");
		   $("#vazn_karton_this").val(splKarton[1]);
		 });
   $("#loading").fadeOut("fast");	
}
function sumkarton()
{
 var sum_k;
 sum_k=Number(document.myform.vazn_karton_this.value)*Number(document.myform.tedad_karton_r_d.value);
 document.myform.sum_karton_r_d_this.value=sum_k;
}
function vazn_khales_resid()
{
 var natije_vazn;
 natije_vazn=Number(document.myform.vazn_nakhales_r_d.value)-Number(document.myform.sum_karton_r_d_this.value);                                      
 document.myform.vazn_khales_r_d.value=natije_vazn;
} 
<!-- نوع پرداخت-->
 $( document ).ready(function() {
 $("[name=noe_pardakht]").bind("change", function () {
    if($(this).val() == 2) {
       $("#paskeraye").slideDown("slow");
    } else {
       $("#paskeraye").slideUp("slow");
    }
 });
  $("#show_detail").bind("click", function () {
       $("#detail").slideDown("slow");});
 }); 

        function showlistkala()
        {
            screenWidth = screen.availWidth;          
            elementRight = (screenWidth - 800) /2;          
            $("#uploadForm").css("right", elementRight + "px");
            $("#lightBox").fadeTo("slow", 0.7,function(){
            $("#uploadForm").slideDown("slow");
            });            
        }
		function closelistkala()
        {
            $("#uploadForm").slideUp("slow", function(){
            $("#lightBox").fadeOut("slow");
            });
            
        } 
function enterIE()
{
  if(window.event.keyCode == 13 && window.event.srcElement.id != \'Insert_x\')
  window.event.keyCode = 9;
}

<!--با انتخاب نوع تحویل اطلاعات عوض شود--><!-- dont use-->
function getInfo(noe_tahvil)
{
  $("#loading").fadeIn("fast",function(){$("#infobefor").fadeOut("fast");});
  $.post("ajax_resid.php",{noeTAHVIL:noe_tahvil},function(data){$("#info").html(data);});
  $("#loading").fadeOut("fast");		
}
<!--با انتخاب نوع خرید اطلاعات عوض شود-->
function kharidInfo(noe_kharid)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{noeKHARID:noe_kharid},function(data){$("#info").html(data);});
  $("#loading").fadeOut("fast");		
}
function changeInfo(noe_kharid)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{noeKHARID:noe_kharid},function(data){$("#info").html(data);});
  $("#loading").fadeOut("fast");		
}
<!-- تعویض انبار با انتخاب استان-->
function getAnbareOstan(code_ostan)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{codeOSTAN1:code_ostan},function(data){$("[name=code_anbar_mabda]").html(data);});
  $("#loading").fadeOut("fast");		
}
<!--محاسبه کسری مجاز--><!--DONT USE***   -->
function mojaz()
{
 var natije_mojaz;
 natije_mojaz=parseFloat((document.myform.vazn_mabda_r.value)*((document.myform.zarib_this.value)/1000)).toFixed(2);                                       
 document.myform.kasry_mojaz_r.value=natije_mojaz;
 return natije_mojaz;
}
function vazn()<!--وزن خالص و مبلغ تخلیه-->
{
 var natije_vazn,natije_mablaghT;
 document.myform.vazn_khales_r.value=Number(document.myform.vazn_kamiyon_bar.value)-Number(document.myform.vazn_kamiyon.value);                                       
 natije_vazn=document.myform.vazn_khales_r.value;
 document.myform.mablagh_takhlie.value=(natije_vazn)*(Number(document.myform.nerkh_takhlie_this.value));                                       
 natije_mablaghT=document.myform.mablagh_takhlie.value;
 return natije_vazn,natije_mablaghT;
}
function baskul(vazn_khales_r)<!--نرخ باسکول--><!--dont use-->
{
	$("#loading").fadeIn("fast");
    $.post("ajax.php",{vaznKHALES:vazn_khales_r},function(data){$("#nerkh_baskul_this").val(data);});
    $("#loading").fadeOut("fast");
}
function mablaghbaskul()<!--محاسبه مبلغ باسکول--><!--dont use-->
{
 var natije_vazn,natije_mablaghB;
 document.myform.vazn_khales_r.value=Number(document.myform.vazn_kamiyon_bar.value)-Number(document.myform.vazn_kamiyon.value);                                        
 natije_vazn=document.myform.vazn_khales_r.value;
 document.myform.mablagh_baskul.value=(natije_vazn)*Number(document.myform.nerkh_baskul_this.value);                                       
 natije_mablaghB=document.myform.mablagh_baskul.value;
 return natije_mablaghB;
}
function maghadir()
{
 var natije_kasry_kol,natije_vazn_ezafe,natije_kasry_gheyrmojaz,natije_jarime,natije_mablagh_ezafe;
 document.myform.kasry_kol.value=Number(document.myform.vazn_mabda_r.value)-Number(document.myform.vazn_khales_r.value);                                      							
 if(document.myform.kasry_kol.value<0){document.myform.kasry_kol.value=0;}
 document.myform.vazn_ezafe.value=Number(document.myform.vazn_khales_r.value)-Number(document.myform.vazn_mabda_r.value);                                      							
 if(document.myform.vazn_ezafe.value<0){document.myform.vazn_ezafe.value=0;}
 document.myform.kasry_gheyremojaz.value=Number(document.myform.kasry_kol.value)-Number(document.myform.kasry_mojaz_r.value);                                      							
 if(document.myform.kasry_gheyremojaz.value<0){document.myform.kasry_gheyremojaz.value=0;}
 document.myform.mablagh_jarimekasry.value=Number(document.myform.kasry_gheyremojaz.value)*Number(document.myform.fee_this.value);                                      							
    <!--document.myform.mablagh_ezafebar.value=Number(document.myform.vazn_ezafe.value)*Number(document.myform.fee_this.value);-->                                      							
 natije_kasry_kol=document.myform.kasry_kol.value;
 natije_vazn_ezafe=document.myform.vazn_ezafe.value;
 natije_kasry_gheyrmojaz=document.myform.kasry_gheyremojaz.value;
 natije_jarime=document.myform.kasry_gheyremojaz.value;
   <!--natije_mablagh_ezafe=document.myform.mablagh_ezafebar.value;-->
 return natije_kasry_kol,natije_vazn_ezafe,natije_kasry_gheyrmojaz,natije_jarime,natije_mablagh_ezafe;
}
function pardakhty()<!--محسابه مقدار پرداختی--><!--change-->
{
 var natije_mablagh;
 natije_mablagh=Number(document.myform.mablagh_kerayemabda.value)+Number(document.myform.mablagh_haghetavaghof.value);
 if(natije_mablagh<0) natije_mablagh=0;
 document.myform.mablagh_pardakhty.value=natije_mablagh;
}
function getBaskul(sh_baskul,n_tahvil)<!-- اطلاعات باسکول از سیستم توزین-->
{
   $.post("ajax_tozin.php",{shomareBaskul: sh_baskul,noeTahvilBar: n_tahvil},function(data){
		   var splBaskul = data.split("^");
		   $("[name=bsk_id]").val(splBaskul[0]);
		   $("[name=bsk_no]").val(splBaskul[1]);
		   $("[name=plak1]").val(splBaskul[2]);
		   $("[name=plak2]").val(splBaskul[3]);
		   $("[name=plak3]").val(splBaskul[4]);
		   $("[name=plak4]").val(splBaskul[5]);
		   $("[name=ranande_name]").val(splBaskul[6]);
		   $("[name=ranande_melicode]").val(splBaskul[7]);
		   $("[name=shomare_hesab_ranande]").val(splBaskul[8]);   
		   $("[name=bank_ranande]").val(splBaskul[9]);   
		   $("[name=ranande_tel]").val(splBaskul[11]);
		   $("[name=code_takhlie]").val(splBaskul[12]);   
		   $("[name=vazn_kamiyon_bar]").val(splBaskul[13]);
		   $("[name=vazn_kamiyon]").val(splBaskul[14]);
		   
		   if((n_tahvil!=4)&(n_tahvil!=5)&(n_tahvil!=7))
		   {
			$("[name=barname_id]").val(splBaskul[15]);
			$("[name=barname_no]").val(splBaskul[16]);
			$("[name=barname_sn]").val(splBaskul[17]);
		    $("[name=barname_tarikh]").val(splBaskul[18]);
		    $("[name=noe_khodro]").val(splBaskul[19]);   
		   }

		   
		 });
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
$load="document.myform.noe_ziranbar.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">ايجاد رسيد جديد</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>
	<tr class="tr1">
	 <td align="right" style="color:red">
	  لطفاً قبل از تکمیل فرم به علایم 	<img border="0" src="images/Info1.png" "onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;"/> توجه نمایید
	 </td>
	 <td align="left" colspan="2" style="color:red">توجه<img border="0" src="images/Info1.png" title="لطفاً در ثبت مقادیر دقت نمایید ، بعد از کلیک روی گزینه ثبت امکان ویرایش مقادیر وجود ندارد" style="cursor:pointer" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'"/></span></td>
	</tr>
	<tr class="tr1">
	 <td colspan="3">
      <table width="100%" border="0">
	   <tr>
        <td align="left" width="150px"> شماره رسيد : </td>
		<td align="right" width="150px">
		 <input type="text" tabindex="-1" class="textboxme" readonly value="'.$shomare_resid.'" name="shomare_resid" style="width:50px;"/>&nbsp;/&nbsp;';
		 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
		 else $code_a=$mt_gl_code_ostan;
		 echo'<input  tabindex="-1" type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>';
		 if($_SESSION["mtActiveYear"]==$yy)echo'<td align="left" width="140px"> تاريخ رسيد : </td><td align="right" ><input  tabindex="-1" type="text" readonly value="'.AsLDate($yymmdd).'" class="textboxme2" name="tarikh_resid"/></td>';	 
		 else echo'<td align="left" width="140px"> تاريخ رسيد : </td><td align="right" ><input tabindex="-1" type="text" readonly value="'.$mtEndDateSh.'" class="textboxme2" name="tarikh_resid" maxlength="10"/></td>';	
	   echo'
	   </tr>
	  </table>
	 </td>
	</tr>
    <tr class="tr1">
     <td colspan="3">
	  <fieldset>
	   <legend>اطلاعات</legend>
	   <table width="100%" border="0">
	    <tr>
		 <td>
		  <table>
		   <tr>
		   	  <td align="left"><span class="star">*</span> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","1=1 ORDER BY sharh_bastebandy ASC","class='text4'  tabindex='-1' onchange=myform.submit()","").'</td>';
	          //if($_SESSION['mt_situation_type']==1)echo'<td align="left" width="140px"><span class="star">*</span> نوع تحویل بار : </td><td align="right">'.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr",1,"class='text4' tabindex='-1' onchange=myform.submit()").'</td>';
	          if($_SESSION['mt_situation_type']==1)echo'<td align="left" width="140px"><span class="star">*</span> نوع تحویل بار : </td><td align="right">'.listbox("noe_tahvil_bar",$noe_tahvil_bar,"noe_tahvil_bar","sharh_tahvil_bar","tahvilbar_resid","noe_tahvil_bar!=6 AND noe_tahvil_bar!=10","class='text4' onchange=myform.submit() tabindex='-6'").'</td>';
			  else echo'<td align="left" width="140px"><span class="star">*</span> نوع تحویل بار : </td><td align="right"><td align="right">'.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArrMovaghat",1,"class='text4' tabindex='-1' onchange=myform.submit()").'</td></td>';
		   echo'
		   </tr>
		  </table>
         </td> 
		</tr>';
	   if(($noe_tahvil_bar)and($code_bastebandy))//اگر موردی را انتخاب کرد
	   {	
		echo'
		<tr>
		 <td>
		  <table width="100%" >';
	       if(($noe_tahvil_bar==4)or($noe_tahvil_bar==5))//اگر نوع تحویل  بار جابجایی باشد
	       {
	        echo'
			<tr>
			 <td colspan="2"><span class="star">*</span>لیست حواله های مرتبط با این رسید </span><img border="0" src="images/image(7).gif" onClick="popupwindow(\'help_havale_jabejae.php?parent_page='.$FileName.'&code_bastebandy='.$code_bastebandy.'\',500,900)" title="لیست حواله" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/></td>
			 <td align="left"><span class="star">*</span> نام زیرانبار : </span><td align="right">'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar","class='text4'","").'</td>
	        </tr>
			<tr id="infobefor">
             <td align="left"><span class="star">*</span> نام استان مبدأ : </td>
			 <td align="right">
			  <input type="hidden" name="code_ostan_mabda" value="'.$code_ostan_mabda.'"/>
			  <input type="text" class="textboxme2" name="name_ostan_mabda" value="'.$name_ostan_mabda.'" readonly/>
			 </td>
		     <td align="left"><span class="star">*</span> نام انبار مبدأ  :</td>
			 <td align="right">
			  <input type="hidden" name="code_anbar_mabda" value="'.$code_anbar_mabda.'"/>
			  <input type="text" class="textboxme2" name="name_anbar_mabda" value="'.$name_anbar_mabda.'" readonly/>
			 </td>
			 <td align="left"><span class="star">*</span> شماره حواله انبار  :</td>
			 <td align="right">
			  <input type="hidden" class="textboxme2" name="id_havale" value="'.$id_havale.'" >
			  <input type="hidden" class="textboxme2" name="havale_year" value="'.$havale_year.'" >
			  <input type="text" class="textboxme2" name="shomare_havale_anbar" readonly value="'.$shomare_havale_anbar.' "style="width:50px;"/>&nbsp;/&nbsp;<input readonly type="text" class="textboxme" name="ostan_anbar_mabda" value="'.$ostan_anbar_mabda.'" style="width:50px;"/>
			 </td>
			 <td align="left"><span class="star">*</span> شماره مجوز جابه جایی  :</td>
			 <td align="right">
			  <input type="text" class="textboxme2" name="shomare_jabejae" readonly value="'.$shomare_jabejae.'" />
			 </td> 			 
			</tr>';
	       }
	       else//در سایر موارد
	       {
	         echo'
	    	  <tr id="infobefor">
	    		<td align="left" width="150px"><span class="star">*</span> کدفروشنده/ کشتی : </td>
	    		<td align="right">
	    		 <input  tabindex="-1" type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)" onkeypress="return isNumber(event)"  style="width:50px;"/>';
				 echo'
				 <img border="0" src="images/help.png" onClick="popupwindow(\'help_skk_coding_mali.php?parent_page=resid&noe_tahvil_bar='.$noe_tahvil_bar.'\',600,600)" title="جدول کد کشتی / فروشنده" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
	    		</td>
	    		<td align="left" width="150px"> نام فروشنده/ کشتی : </td>
	    		<td align="right"><input tabindex="-1" type="text" class="textboxme2" name="name_skk" id="name_skk" readonly value="'.$name_skk.'"/></td>';
	    	    IF(($noe_tahvil_bar!=6)AND($noe_tahvil_bar!=7)AND($noe_tahvil_bar!=9))//برگشت از فروش یا تخلیه در سردخانه کالای امانی یا تحت کلید نباشد
				{
			     IF($code_skk)//اگر شماره سفر قبلا انتخاب و اجازه ثبت داده نشده
	    	     {			
	              echo'<td align="left"><span class="star">*</span> شماره قرارداد/ سفر :</td>
					   <td align="right">'.listbox("id_safar",$id_safar,"id_safar","shomare_safar","shomare_safar","1=1 AND code_skk='$code_skk' AND etmam_safar=0","class='text4'  tabindex='-1'").'';
				 }
	    	     ELSE{echo'<td align="left"><span class="star">*</span> شماره قرارداد/ سفر :</td><td align="right"><select name="id_safar" class="text4"  tabindex="-1"><option value="0">انتخاب کنيد</option></select></td>';}		   
				}
			   echo'
	    	   <td align="left"><span class="star">*</span> مبدأ بارگيری : </td>
		       <td align="right">
	            <input type="hidden" class="textboxme2" name="code_mabda" value="'.$code_mabda.'" style="width:50px;"/>
	            <input type="text" class="textboxme2" name="name_mabda" id="name_mabda" readonly value="'.$name_mabda.'" onfocus="getNameBargiry(document.myform.code_mabda.value)" onchange="getNameBargiry(document.myform.code_mabda.value)""/>';
	            include('img_mabady_vorudy.php');
		        echo'
	           </td>
			  </tr>';
	       }		
		   if($noe_tahvil_bar==3)//اگر نوع تحویل بار حمل با راه آهن بود
		   {
		   	echo'
			<tr>';
			  if($_SESSION['mt_systemtozin']==1)//اتصال به سیستم باسکول
              {
			    echo'<td align="left" width="100px"> شماره باسکول : </td><td  align="right"><input type="hidden" name="bsk_id" value="'.$bsk_id.'" /><input type="text" class="textboxme2" name="bsk_no" value="'.$bsk_no.'"  onfocus="getBaskul(this.value,document.myform.noe_tahvil_bar.value)"  onblur="getBaskul(this.value,document.myform.noe_tahvil_bar.value)"  tabindex="-13"/>'; 
			    echo'&nbsp;<img border="0" src="images/help.png" onClick="popupwindow(\'help_baskul.php?parent_page='.$FileName.'&noe_tahvil_bar_='.$noe_tahvil_bar.'&pl1_=\'+document.myform.plak1.value+\'&pl2_=\'+document.myform.plak2.value+\'&pl3_=\'+document.myform.plak3.value+\'&pl4_=\'+document.myform.plak4.value+\'\',\'\',800,600)" title="اطلاعات باسکول" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>';

				//include ("img_helpbaskul.php");
			  }
			 echo'
			 <td align="left" width="100px"> شماره بارنامه : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" name="barname_no" value="'.$barname_no.'"/></td>
			 <td align="left" > تاريخ بارنامه : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2 datepicker6"  name="barname_tarikh" maxlength="10" value="'.$barname_tarikh.'"/></td>
			 <td align="left"> پلاک خودرو : </td><td align="right">
			   <sup>ایران</sup>
		       <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" tabindex="1" onkeyup="changeFocus(this)" style="width:20px;"/> |
			   <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" tabindex="2" onkeyup="changeFocus(this)" style="width:30px;"/>
			   <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" tabindex="3" onkeyup="changeFocus(this)" style="width:20px;"/>
			   <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" tabindex="4" onkeyup="changeFocus(this)" style="width:20px;"/>
			  </td>
			</tr>';
           }
		   else
		   {
	       	echo'<tr>';
		    if(($noe_tahvil_bar!=2)and($noe_tahvil_bar!=5))//اگر نوع تحویل بار روباری یا جابه جایی روباری نباشد    	    
	        {
			  if($_SESSION['mt_systemtozin']==1)//اتصال به سیستم باسکول
              {
			    echo'<td class="robaryhide" align="left" width="100px">';if(($code_bastebandy!=2)and($mt_gl_code_anbar!=301))echo'<span class="star">*</span>'; echo' شماره باسکول : </td><td class="robaryhide" align="right"><input type="hidden" name="bsk_id" value="'.$bsk_id.'" /><input type="text" class="textboxme2 inputreadonly" name="bsk_no" value="'.$bsk_no.'" readonly  onfocus="getBaskul(this.value,document.myform.noe_tahvil_bar.value)"  onblur="getBaskul(this.value,document.myform.noe_tahvil_bar.value)"  tabindex="-13"/>'; 
			    echo'&nbsp;<img border="0" src="images/help.png" onClick="popupwindow(\'help_baskul.php?parent_page='.$FileName.'&noe_tahvil_bar_='.$noe_tahvil_bar.'&pl1_=\'+document.myform.plak1.value+\'&pl2_=\'+document.myform.plak2.value+\'&pl3_=\'+document.myform.plak3.value+\'&pl4_=\'+document.myform.plak4.value+\'\',\'\',800,600)" title="اطلاعات باسکول" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>';

				//include ("img_helpbaskul.php");
			  }
              else			  
			  {echo'<td class="robaryhide" align="left" width="100px">';if(($code_bastebandy!=2)and($mt_gl_code_anbar!=301))echo'<span class="star">*</span>';echo' شماره باسکول : </td><td class="robaryhide" align="right"><input tabindex="-1" type="text" class="textboxme2" name="bsk_no" value="'.$bsk_no.'" onkeypress="return isNumber(event)" /> <img border="0" src="images/Info1.png" title="برای توزین دستی بدون استفاده از شماره باسکول عدد صفر را وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>';}
			}
            if($_SESSION['mt_systemmabadi']==0)
	    	  echo'<td align="left" width="100px"> شماره بارنامه : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" name="barname_no" value="'.$barname_no.'"/></td>';
			echo'
	    	  <td align="left" > تاريخ بارنامه : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2 datepicker6" name="barname_tarikh" maxlength="10" value="'.$barname_tarikh.'"/></td>
	          <td align="left" >';
			  IF(($code_bastebandy!=2)AND($noe_tahvil_bar!=4)AND($noe_tahvil_bar!=5)AND($noe_tahvil_bar!=9))echo'<span class="star">*</span>';
			  
			  echo' پلاک خودرو : </td>
			  <td align="right">
			   <sup>ایران</sup>
		       <input ';if((($_SESSION['mt_systemtozin']==1)AND($noe_tahvil_bar!=2))OR($noe_tahvil_bar==4)OR($noe_tahvil_bar==5)) echo 'readonly class="textboxme2 inputreadonly" ';else echo' class="textboxme2" '; echo' type="text" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" tabindex="1" onkeyup="changeFocus(this)" style="width:20px;"/> |
			   <input ';if((($_SESSION['mt_systemtozin']==1)AND($noe_tahvil_bar!=2))OR($noe_tahvil_bar==4)OR($noe_tahvil_bar==5)) echo 'readonly class="textboxme2 inputreadonly" ';else echo' class="textboxme2" '; echo' type="text" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" tabindex="2" onkeyup="changeFocus(this)" style="width:30px;"/>
			   <input ';if((($_SESSION['mt_systemtozin']==1)AND($noe_tahvil_bar!=2))OR($noe_tahvil_bar==4)OR($noe_tahvil_bar==5)) echo 'readonly class="textboxme2 inputreadonly" ';else echo' class="textboxme2" '; echo' type="text" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" tabindex="3" onkeyup="changeFocus(this)" style="width:20px;"/>
			   <input ';if((($_SESSION['mt_systemtozin']==1)AND($noe_tahvil_bar!=2))OR($noe_tahvil_bar==4)OR($noe_tahvil_bar==5)) echo 'readonly class="textboxme2 inputreadonly" ';else echo' class="textboxme2" '; echo' type="text" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" tabindex="4" onkeyup="changeFocus(this)" style="width:20px;"/>
			  </td>
			</tr>
	    	<tr>
	    	 <td align="left">';IF(($code_bastebandy!=2)AND($noe_tahvil_bar!=4)AND($noe_tahvil_bar!=5)AND($noe_tahvil_bar!=9))echo'<span class="star">*</span>';echo' نام راننده : </td><td align="right"><input ';if(($_SESSION['mt_systemtozin']==1)AND($noe_tahvil_bar!=2)) echo 'readonly class="textboxme2 inputreadonly"'; else echo' class="textboxme2" '; echo' type="text" name="ranande_name" value="'.$ranande_name.'" onkeyup="changeFocus(this)" tabindex="5"/></td>
	    	 <td align="left">';IF(($code_bastebandy!=2)AND($noe_tahvil_bar!=4)AND($noe_tahvil_bar!=5)AND($noe_tahvil_bar!=9))echo'<span class="star">*</span>';echo' کد ملی راننده : </td><td align="right"><input ';if(($_SESSION['mt_systemtozin']==1)AND($noe_tahvil_bar!=2)) echo 'readonly class="textboxme2 inputreadonly"'; else echo' class="textboxme2" '; echo' type="text"  name="ranande_melicode" maxlength="10" value="'.$ranande_melicode.'" onkeypress="return isNumber(event);"/>
	    	  <img border="0" src="images/Info1.png" title="کد ملی را در 10 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	    	 </td>
	    	 <td align="left">شماره حساب راننده : </td><td align="right"><input type="text" class="textboxme2" name="shomare_hesab_ranande" value="'.$shomare_hesab_ranande.'" onkeypress="return isNumber(event);"/></</td>
	    	 <!--<td align="left">بانک راننده : </td><td align="right"><input type="text" class="textboxme2" name="bank_ranande" value="'.$bank_ranande.'"/></</td>-->
	    	 <td align="left">بانک راننده : </td><td align="right">'.listbox("bank_ranande",$bank_ranande,"id","nb_noe_bank","payroll.pay_c_noe_bank","nb_del=0 ORDER BY nb_noe_bank ASC","class='text4'","").'</td>
			</tr>';
			}
			echo'
	    	<tr>';
			 if($noe_tahvil_bar!=3)//اگر نوع تحویل بار حمل با راه آهن نبود
			  echo'<td align="left">تلفن همراه راننده : </td><td align="right"><input type="text" class="textboxme2" name="ranande_mobile" value="'.$ranande_mobile.'" onkeypress="return isNumber(event);"/></</td>';
	 	     echo' 		
			  <td align="left" width="120px">';if(($mt_gl_code_anbar!=301))echo'<span class="star">*</span>';
			  echo'شرکت حمل کننده : </td>
	    	  <td align="right">
	    	   <input type="hidden" class="textboxme2" name="code_peymankar_haml" value="'.$code_peymankar_haml.'"  onkeypress="return isNumber(event)" style="width:50px;"/>
	    	   <input type="text" class="textboxme2" name="name_peymankar_haml" id="name_peymankar_haml" readonly value="'.$name_peymankar_haml.'" onfocus="getNamePeymankar(document.myform.code_peymankar_haml.value)" onchange="getNamePeymankar(document.myform.code_peymankar_haml.value)""/>';
	    	   include('img_peymankar_haml.php');
			   echo'
	    	  </td>';
	        if(($noe_tahvil_bar==2)or($noe_tahvil_bar==5))//اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
	        {echo'';}
	    	else //در سایر موارد	    
	    	{echo'<td class="robaryhide" align="left">';if(($mt_gl_code_anbar!=301))echo'<span class="star">*</span>';echo' نوع تخليه : </td><td class="robaryhide" align="right">'.listbox("code_takhlie",$code_takhlie,"code_takhlie","sharh_takhlie","takhlie","","class='text4'","").'</td>';}
	    	IF($noe_tahvil_bar==9)echo'<td align="left"><span class="star">*</span> شماره کوتاژ : </td><td align="right"><input type="text" class="textboxme2" name="shomare_kotazh" value="'.$shomare_kotazh.'"/></td>';
		    ELSE                  echo'<td align="left"> شماره کانتینر : </td><td align="right"><input type="text" class="textboxme2" name="shomare_container" value="'.$shomare_container.'"/></td>';
	    	echo'
			</tr>
			<tr>';
			IF($noe_tahvil_bar==9)
			{
			 echo'
			 <td align="left"><span class="star">*</span>شماره ثبت سفارش : </td><td align="right"><input type="text" class="textboxme2" name="shomare_sabt_sefaresh" value="'.$shomare_sabt_sefaresh.'"/></td>
		     <td align="left">تاريخ ورود به کشور : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2 datepicker6"  name="tarikh_vorud" maxlength="10" value="'.$tarikh_vorud.'"/></td>
			 <td align="left">توضیحات علت عدم ترخیص :</td><td align="right"><input type="text" class="textboxme" name="tozihat" value="'.$tozihat.'"/></td>';
		    }
			ELSE
			{	
			 echo'
		     <td align="left"> شماره پلمپ : </td><td align="right"><input type="text" class="textboxme2" name="shomare_polomp" value="'.$shomare_polomp.'"/></td>
	         <td align="left"> وضعیت پلمپ : </td><td align="right">'.static_listbox("vaziyat_polomp",$vaziyat_polomp,"polompArr",1,"class='text4'").'</td>
		     <td align="left">شماره گواهی بهداشتی :</td><td align="right"><input type="text" class="textboxme2" name="shomare_govahi_behdashti" value="'.$shomare_govahi_behdashti.'"/></td>
		     <td align="left">توضیحات :</td><td align="right"><input type="text" class="textboxme" name="tozihat" value="'.$tozihat.'"/></td>';
			}
			echo'
			</tr>
	      </table>
	     </td>
	    </tr> 
	   </table>
	  </fieldset>
     </td>
	</tr>';
	if($noe_tahvil_bar!=3)//اگرنوع تحویل حمل با راه آهن نباشد
	{
    echo'
    <tr class="tr1">';
	  if(($noe_tahvil_bar==2)or($noe_tahvil_bar==5))//اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
  	   echo'<td>&nbsp;</td>
	     <input readonly type="hidden" name="noe_khodro" value="'.$noe_khodro.'"/>
		 <input readonly type="hidden" name="khodro" value="'.$khodro.'"/>';
        //if(($noe_tahvil_bar==1)or($noe_tahvil_bar==4))//اگر نوع تحویل بار تخلیه و یا جابهجایی تخلیه باشد
	  else
	  {
	   echo'
	   <td valign="top">
	   <fieldset>
	    <legend>وزن کامیون</legend>
	     <table width="100%" height="80px">
	      <tr><td align="left">';if($code_bastebandy!=2)echo'<span class="star">*</span>';echo' وزن کاميون با بار : </td><td align="right"><input '; if($_SESSION['mt_systemtozin']==1) echo'readonly class="textboxme2 inputreadonly"'; else echo' class="textboxme2" '; echo' type="text"  name="vazn_kamiyon_bar" value="'.($vazn_kamiyon_bar).'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
	      <tr><td align="left">';if($code_bastebandy!=2)echo'<span class="star">*</span>';echo' وزن کاميون : </td><td align="right"><input '; if($_SESSION['mt_systemtozin']==1) echo'readonly class="textboxme2 inputreadonly"'; else echo' class="textboxme2" '; echo' type="text" name="vazn_kamiyon" value="'.($vazn_kamiyon).'" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left">';if($code_bastebandy!=2)echo'<span class="star">*</span>';echo' نوع خودرو : </td><td align="right">';
		   if($noe_tahvil_bar==4)echo'<input type="hidden" class="textboxme2" name="noe_khodro" value="'.$noe_khodro.'"/><input type="text" class="textboxme2" readonly name="khodro" value="'.$khodro.'"/>';
           else echo''.static_listbox("noe_khodro",$noe_khodro,"khodroArr",1,"class='text4' onchange=getNerkhBaskul(this.value) ").'';
		   echo'
		   </td>
		  </tr>
		 </table>
	    </fieldset>
	   </td>';
	  }
	  //if(($noe_tahvi_bar==1)or($noe_tahvil_bar==4)) echo'<td valign="top">';
	  //else echo'<td valign="top" colspan="2">';
	  echo'
	  <td valign="top">
	  <fieldset>
	   <legend>مبالغ</legend>
	   <table width="100%" border="0" height="80px">';
	   //اگر اولین بار است که وارد صفحه می شویم
	   // if(!isset($noe_pardakht))
	    // {echo'
		 // <tr><td align="left"><span class="star">*</span> نوع پرداخت پسکرایه : </td><td align="right">'.static_listbox("noe_pardakht",$noe_pardakht,"pardakhtArr",1,"class='text4' onchange=myform.submit()").'</td></tr>
		 // <tr>
		 // <td colspan="2">
 		  // <span id="paskeraye" style="display:none;">
		   // <table width="100%" border="0">
		    // <tr><td align="left"><span class="star">*</span> مبلغ کرايه مبدأ : </td><td align="right"><input type="text" class="textboxme2" name="mablagh_kerayemabda" value="'.$mablagh_kerayemabda.'" onblur="return pardakhty()" onkeypress="return isNumber(event)"/></td></tr>
	        // <tr><td align="left">مبلغ حق توقف : </td><td align="right"><input type="text" class="textboxme2" name="mablagh_haghetavaghof" value="'.$mablagh_haghetavaghof.'" onblur="return pardakhty()" onkeypress="return isNumber(event)"/></td></tr>';	
	   	    // //اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
			// if(($noe_tahvil_bar==2)or($noe_tahvil_bar==5)) echo 'one';
            // else echo'<tr><td align="left">مبلغ باسکول one : </td><td align="right"><input type="text" readonly class="textboxme2" id="mablagh_baskul" name="mablagh_baskul" value="'.$mablagh_baskul.'" onblur="return pardakhty()" onkeypress="return isNumber(event)"/> <img border="0" src="images/Info1.png" title="مبلغ باسکول از مبلغ پرداختی کسر نمی شود" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td></tr>';
			// echo'
			// <tr><td colspan="2"><hr/><td></tr>
			// <tr><td align="left"> مبلغ پرداختی : </td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_pardakhty" value="'.$mablagh_pardakhty.'" onfocus="return pardakhty();"/></td></tr>';
		    // $amel_default=$db->get_from_where("amel_p_accnting_code","amel_pardakht","status_amel_p=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
		    // echo'
			// <tr><td align="left"><span class="star">*</span> عامل پرداخت پسکرایه : </td><td align="right">'.listboxMe("amel_p_accnting_code",$amel_default,"amel_p_accnting_code","concat(amel_p_name,'&nbsp',amel_p_lastname)","amel_pardakht","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' order by amel_p_name,amel_p_lastname ASC","class='text4'","").'</td></tr>
		  // </table>
		  // </span>
		 // </td>
		// </tr>';
		// }
	   //اگر ارروری ظاهر شده و به صفحه برگشته ایم
	   //else 
	   echo'<tr><td align="left"><span class="star">*</span> نوع پرداخت پسکرایه : </td><td align="right">
	   '.static_listbox("noe_pardakht",$noe_pardakht,"pardakhtArr",1,"class='text4' onchange=myform.submit()").'</td></tr>';
	   //اگر نوع پرداخت کرایه پس از رسید بود
	   if($noe_pardakht==1) echo'';
	   //اگر نوع پرداخت کرایه در مقصد بود
	   if($noe_pardakht==2)
	   {
	   echo'
		<tr>
		 <td colspan="2" >
 		  <span id="paskeraye">
		   <table width="100%" border="0">
		    <tr><td align="left"><span class="star">*</span> مبلغ کرايه مبدأ : </td><td align="right"><input type="text" class="textboxme2" name="mablagh_kerayemabda" value="'.$mablagh_kerayemabda.'" onblur="return pardakhty()" onkeypress="return isNumber(event)"/></td></tr>
	        <tr><td align="left">مبلغ حق توقف : </td><td align="right"><input type="text" class="textboxme2" name="mablagh_haghetavaghof" value="'.$mablagh_haghetavaghof.'" onblur="return pardakhty()" onkeypress="return isNumber(event)"/></td></tr>';	
	   	    //اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
			if(($noe_tahvil_bar==2)or($noe_tahvil_bar==5)) echo '';
            else{echo'<tr><td align="left">مبلغ باسکول : </td><td align="right"><input type="text" readonly class="textboxme2" id="mablagh_baskul" name="mablagh_baskul" value="'.$mablagh_baskul.'" onblur="return pardakhty()" onkeypress="return isNumber(event)"/> <img border="0" src="images/Info1.png" title="مبلغ باسکول از مبلغ پرداختی کسر نمی شود" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td></tr>';}
			echo'
			<tr><td colspan="2"><hr/><td></tr>
			<tr><td align="left"> مبلغ پرداختی : </td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_pardakhty" value="'.$mablagh_pardakhty.'" onfocus="return pardakhty();"/></td></tr>';
		    $amel_default=$db->get_from_where("amel_p_accnting_code","amel_pardakht","status_amel_p=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
			echo'
		    <tr><td align="left"><span class="star">*</span> عامل پرداخت پسکرایه : </td><td align="right">'.listboxMe("amel_p_accnting_code",$amel_default,"amel_p_accnting_code","concat(amel_p_name,'&nbsp',amel_p_lastname)","amel_pardakht","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' order by amel_p_name,amel_p_lastname ASC","class='text4'","").'</td></tr>
		  </table>
		  </span>
		 </td>
		</tr>';
		}
	    echo'	
       </table>
      </fieldset>
	 </td>	  
	</tr>';
	 }
	}//END if select tahvilbar
   //اگر نوع تحویل را هنوز انتخاب نکرده
	else echo'<tr><td>برای مشاهده سایر اطلاعات نوع تحویل بار و نوع بسته بندی را انتخاب نمایید</td></tr>';
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
</table>
</div>';
 echo'
<!-- فوتر-->
<table style="position:fixed;bottom:-2px;left:0.5%" width="99%"> 
  <tr class="footer">  	
   <td align="center">
	<input type="submit" class="buttonme" name="Insert_x" id="sabt" value="ثبت اطلاعات">
   	<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'resid.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
   </td>
	 <!--<td width="70px"><div onClick="window.location=\'resid.php?PageNo='.$PageNo.'\'" id="btn-sabt"  title="ثبت اطلاعات"><a href="#"></a></div></td>-->
	 <!--<td width="70px"><div onClick="window.location=\'resid.php?PageNo='.$PageNo.'\'" id="btn-enseraf"  title="انصراف"><a href="#"></a></div></td>-->
	 <!--<td width="70px"><div onClick="window.location=\'resid.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت"><a href="#"></a></div></td>-->       
  </tr>
</table>
<!-- پايان فوتر-->';
/************اجازه براي ذخيره اطلاعات************/ 
function isPermitSave($date_resid,$code_baste,$n_tahvil,$c_keshty,$safar,$c_mabda,$c_o_mabda,$c_a_mabda,$sh_baskul,$sh_barname,$date_barname,$pl1,$pl2,$pl3,$pl4,$n_ranande,$c_meli,$c_takhlie,$c_peyman_h,$v_k_b,$v_k,$n_pardakht,$m_keraye,$a_p_acc_code,$khodro,$gl_c_o,$gl_c_s,$gl_year,$sh_havale,$code_zir_a,$sh_container,$sh_sabt_sefaresh,$sho_kotazh,$tarikh_vorud,$db)  
{
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if((!$code_baste) or (!$n_tahvil) or(($gl_c_s!=301)and(!$c_peyman_h)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //بسته بندی کارتن و نوع تحویل به غیراز حمل با راه آهن
 if(($code_baste!=2) and ($n_tahvil!=3) and($n_tahvil!=4) and ($n_tahvil!=5) and ($n_tahvil!=9) and((!$pl1) or (!$pl2) or (!$pl3) or (!$pl4) or (!$n_ranande) or (!$c_meli)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //حمل بار راه آهن نباشد
 if(($n_tahvil!=3) and(!$n_pardakht))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($n_tahvil!=3)and($n_pardakht==2)and(!($m_keraye and $a_p_acc_code)))//اگر پرداخت از نوع کرایه در مقصد ، پر بودن مبلغ کرایه مبدأ وعامل پرداخت
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 }
 else $flag=true;
 //نوع تحویل جا به جایی نباشد
 if(($n_tahvil!=4)and($n_tahvil!=5)and(!($c_keshty and $c_mabda)))//پر بودن فروشنده یا کشتی و مبدا بارگیری
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //نوع تحویل تخلیه در سردخانه تحویل روباری حمل باراه آهن
 if((($n_tahvil==1)or($n_tahvil==2)or($n_tahvil==3)or($n_tahvil==8))and(!($safar)))//پر بودن شماره قرارداد یا سفر
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 
 //نوع تحویل جا به جایی باشد
 if((($n_tahvil==4)or($n_tahvil==5))and(!($c_o_mabda and $c_a_mabda and $sh_havale and $code_zir_a)))//پر بودن استان و انبار مبدأ
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //نوع تحویل روباری یا جابه جایی روباری نباشد
 if(($n_tahvil!=2)and($n_tahvil!=5)and(!($c_takhlie))and($gl_c_s!=301))//نوع تخلیه 
 {
	$flag=false;
	echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
    return $flag;
 } 
 else $flag=true;
 //نوع تحویل روباری یا جابه جایی روباری یا حمل باراه آهن نباشد و بسته بندی کارتنی
 if(($code_baste!=2)and($n_tahvil!=2)and($n_tahvil!=3)and($n_tahvil!=5)and($n_tahvil!=9)and(!($v_k_b and $v_k and $khodro)))//نوع تخلیه و وزن کامیون بار ووزن کامیون و خودرو
 {
	$flag=false;
	echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
    return $flag;
 } 
 else $flag=true;
 if($sh_baskul!='0')
 { 
  if(($code_baste!=2)and($n_tahvil!=2)and($n_tahvil!=3)and($n_tahvil!=5)and($gl_c_s!=301)and(!($sh_baskul)))//شماره باسکول
  {
	$flag=false;
	echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
    return $flag;
  } 
  else $flag=true;
 }
 else $falg=true;
 //نوع تحویل تحت کلید گمرک
 if(($n_tahvil==9)and(!($sh_sabt_sefaresh and $sho_kotazh)))
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(checkdatejalali($date_resid)==false)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(($date_barname)and((checkdatejalali($date_barname)==false) or ($date_barname>$date_resid)))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ بارنامه را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(($code_baste!=2)and($sh_baskul!='0')and($n_tahvil!=2)and($n_tahvil!=3)and($n_tahvil!=5))//تکراری نبودن شماره باسکول هم در رسید و هم در حواله به ازای هر انبار و هر سال 
 { 
   $q_baskul_r="SELECT bsk_no FROM resid WHERE bsk_no='$sh_baskul' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year' AND deleted=0 AND status=0";
   $q_baskul_h="SELECT bsk_no FROM havale WHERE bsk_no='$sh_baskul' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year' AND deleted=0 AND status=0";
   $res_baskul_r=mysql_query($q_baskul_r);
   $res_baskul_h=mysql_query($q_baskul_h);
   if((mysql_num_rows($res_baskul_r)>0)or(mysql_num_rows($res_baskul_h)>0)){
   echo"<script>alert('اين شماره باسکول قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 //پلاک خودرو
 if((($pl1!=NULL)and(($pl2==NULL)or($pl3==NULL)or($pl4==NULL)))or(($pl2!=NULL)and(($pl1==NULL)or($pl3==NULL)or($pl4==NULL)))or(($pl3!=NULL)and(($pl1==NULL)or($pl2==NULL)or($pl4==NULL)))or(($pl4!=NULL)and(($pl1==NULL)or($pl2==NULL)or($pl3==NULL))))
 {
   $flag=false;
   echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true; 
 // if(($pl1!=NULL)and($pl2!=NULL)and($pl4!=NULL)and((((!justNumber($pl1))or(strlen($pl1)>2)or(strlen($pl1)<2)))or((((!justNumber($pl2)) or (strlen($pl2)>3) or (strlen($pl2)<3))))or((((!justNumber($pl4))or(strlen($pl4)>2)or(strlen($pl4)<2))))))
 // {
   // $flag=false;
   // echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   // return $flag;
 // }
 // else $flag=true;
 // if(($pl3!=NULL)and((!validFarsi($pl3))))
 // {
   // $flag=false;
   // echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   // return $flag;
 // }
 // else $flag=true;
 //نوع تحویل حمل با راه آهن نباشد
 if(($code_baste!=2)and ($n_tahvil!=3) and($n_tahvil!=4) and ($n_tahvil!=5) and ($n_tahvil!=9) and((!justNumber($c_meli)) or (strlen($c_meli)>10) or (strlen($c_meli)<10)))//بررسی کد ملی
 {
   //echo "<script>alert('haha')</script>";
   $flag=false;
   echo"<script>alert('فیلد کد ملی نادرست است!')</script>";
   return $flag;
 }
 else $flag=true;
 if(($n_tahvil==1)or($n_tahvil==2)or($n_tahvil==3)or($n_tahvil==8))//خرید
 {
	//*az gharardad kharid*//
	$q1_1="SELECT gharardad_kharid.*,eblagh_kharid.code_group_kala_top,eblagh_kharid.mahmule_type FROM gharardad_kharid INNER JOIN dastorolamal_kharid d_kh ON gharardad_kharid.id_dastorolamal=d_kh.id_dastorolamal
	       INNER JOIN eblagh_kharid ON eblagh_kharid.id_eblagh=d_kh.id_eblagh
           WHERE gharardad_kharid.shomare_gharardad=(SELECT shomare_safar FROM shomare_safar WHERE id_safar=".$safar.") AND gharardad_kharid.deleted=0";
	

	$res1_1=mysql_query($q1_1);
    //disabled in 1395/11/24
	if(mysql_num_rows($res1_1)>0)// اگر قرارداد وجود دارد
    {
      $row1_1=mysql_fetch_assoc($res1_1);
	  //if(($row1_1['code_group_kala_top']==7)and(!($sh_container)))
	  if((($row1_1['mahmule_type']==2)OR($row1_1['mahmule_type']==3))and(!($sh_container)))//وارداتی
	  {
		echo"<script>alert('شماره کانتینر را وارد کنید!')</script>";
        $flag=false;
        return $flag;  
	  }
	  else $flag=true;
	  if(($row1_1['mahmule_type']==1)OR($row1_1['mahmule_type']==4))//داخلی
	  {
		//چک کردن تاریخ اتمام قرارداد
	    $exist_elhaghie_date=$db->get_from_where("COUNT(*)","meat.elhaghie_kharid","id_gharardad='".$row1_1['id_gharardad']."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ");
        if($exist_elhaghie_date>0)//اگر الحاقیه دارد
        {
          $tarikh_etmam_elhaghie=$db->get_from_where("tarikh_etmam_elhaghie","meat.elhaghie_kharid","id_gharardad='".$row1_1['id_gharardad']."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ORDER BY id_elhaghie DESC"); 
          $tarikh_etmam=$tarikh_etmam_elhaghie;
        }
        else//اگر الحاقیه ندارد
        {
         $tarikh_etmam=$db->get_from_where("tarikh_etmam","gharardad_kharid","id_gharardad='".$row1_1['id_gharardad']."' AND deleted=0");
        }
		if($tarikh_etmam<$date_resid)//تاریخ قرارداد به اتمام رسیده
	    {
		 echo"<script>alert('تاریخ قرارداد خرید به اتمام رسیده است اجازه ثبت رسید وجود ندارد!')</script>";
         $flag=false;
         return $flag;
        }
        else $flag=true;  
	  }
    }
    //comment in 1400/04/19
    // if(mysql_num_rows($res1_1)==0)// اگر قرارداد وجود ندارد
	// {
      // echo"<script>alert('اطلاعات قرارداد برای  استان تعیین نشده است!')</script>";
      // $flag=false;
      // return $flag;
    // }
 }
 if(($n_tahvil!=3)and($n_pardakht==2)and($a_p_acc_code))
 {
  $q10="SELECT status_amel_p FROM amel_pardakht WHERE amel_p_accnting_code='$a_p_acc_code' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s'";
  $res10=mysql_query($q10);
  $row10=mysql_fetch_array($res10);
  if($row10['status_amel_p']==2)//اگر عامل پرداخت غیرجاری است
  { echo"<script>alert('وضعیت عامل پرداخت پسکرایه انتخاب شده غیرجاری است !')</script>";
    $flag=false;
    return $flag;	
  }
  else $flag=true;
 }
 else $flag=true;
  //نوع تحویل جا به جایی باشد
  if(($n_tahvil==4)or($n_tahvil==5))//شماره و تاریخ بارنامه
 {
   $q11="SELECT shomare_barname_h,tarikh_barname_h FROM havale WHERE shomare_havale_anbar='$sh_havale' AND code_ostan='$c_o_mabda' AND code_anbar='$c_a_mabda' AND year='$gl_year'";
   $res11=mysql_query($q11);
   $row11=mysql_fetch_assoc($res11);
   if(($row11['shomare_barname_h']!='')and($sh_barname!=$row11['shomare_barname_h']))
   {
    echo"<script>window.alert('شماره بارنامه با حواله متناظر مغایرت دارد!');</script>";
    $flag=false;
    return $flag;
    } 
    else $flag=true;
	if(($row11['tarikh_barname_h']!='')and($date_barname!=$row11['tarikh_barname_h']))
   {
    echo"<script>window.alert('تاریخ بارنامه با حواله متناظر مغایرت دارد!');</script>";
    $flag=false;
    return $flag;
    } 
    else $flag=true;
  }
 else $flag=true;
 //نوع تحویل جا به جایی نباشد
 if(($n_tahvil!=4)and($n_tahvil!=5)and($c_keshty))//وجود کدمالی کشتی
 {
   $flag=false;
   $q_coding="SELECT code_skk FROM coding_mali_keshty WHERE code_skk='$c_keshty'";
   $res_coding=mysql_query($q_coding);
   if(mysql_num_rows($res_coding)==0){
    echo"<script>window.alert('برای این کشتی/فروشنده کد مالی تعریف نشده است!');</script>";
    $flag=false;
    return $flag;
   }
   else $flag=true;
 } 
 else $flag=true;
return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 $plak1 = intval($plak1);//صفر اولش نباشد
 $plak2 = intval($plak2);
 $plak4 = intval($plak4);
 $IssuedTime = date('H:i');
 if(isPermitSave($tarikh_resid,$code_bastebandy,$noe_tahvil_bar,$code_skk,$id_safar,$code_mabda,$code_ostan_mabda,$code_anbar_mabda,$bsk_no,$barname_no,$barname_tarikh,$plak1,$plak2,$plak3,$plak4,$ranande_name,
                $ranande_melicode,$code_takhlie,$code_peymankar_haml,$vazn_kamiyon_bar,$vazn_kamiyon,$noe_pardakht,$mablagh_kerayemabda,$amel_p_accnting_code,$noe_khodro,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$shomare_havale_anbar,
				$code_ziranbar,$shomare_container,$shomare_sabt_sefaresh,$shomare_kotazh,$tarikh_vorud,$db))				  
 {
   echo'
      <script type="text/javascript">
       document.getElementById("sabt").disabled = "true";
       document.getElementById("sabt").value = "در حال انتظار ...";
       document.getElementById("sabt").style.opacity="0.5";
       document.getElementById("sabt").style.cursor="progress";
      </script>';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION'); 
   $insert_res=true;$log_i=true;$insert_detail_res=true;$insert_kala_res=true;$update_kala_res=true; $update_mojody_res=true;$res_update_resid=true;$insert_mojody_res=true; 

  $ranande_name=str_replace("ي","ی",$ranande_name);
  $ranande_name=str_replace("ك","ک",$ranande_name);
  $vazn_kamiyon_bar=round($vazn_kamiyon_bar,3);
  //if($shomare_polomp==NULL) $vaziyat_polomp='-1';//اگر شماره پلمپ را نزد وضعیت پلمپ هم خالی باشد
  //if($noe_pardakht==2)$mablagh_pardakhty=$mablagh_kerayemabda+$mablagh_haghetavaghof;
  if(($noe_tahvil_bar==4)or($noe_tahvil_bar==5))$taeed_nazer=1;
  $signiture ="select sign_id from mt_typesign where activate=1 and type_id=1 and code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' and ((expire_date='')or(expire_date is NULL)or(expire_date!='' and expire_date>='$tarikh_resid')) ORDER BY turn";
  $allsigniture  = $db->query($signiture);
  $separatesigniture='';
  while($row_id=$db->fetch_assoc($allsigniture)) $separatesigniture = $separatesigniture . $row_id['sign_id'].';' ;
  $separatesigniture=rtrim($separatesigniture, ";");
  $insert_q=("INSERT INTO $TableName
            (code_ostan,code_anbar,shomare_resid,year,tarikh_resid,IssuedTime,code_bastebandy,noe_tahvil_bar,code_skk,
			 id_safar,code_mabda,code_ostan_mabda,code_anbar_mabda,id_havale,shomare_havale_anbar,shomare_jabejae,bsk_id,bsk_no,barname_no,
             barname_tarikh,plak1,plak2,plak3,plak4,ranande_name,ranande_melicode,shomare_hesab_ranande,bank_ranande,ranande_mobile,code_takhlie,shomare_container,code_peymankar_haml,vazn_kamiyon_bar,vazn_kamiyon,
			 shomare_polomp,vaziyat_polomp,noe_khodro,noe_pardakht,mablagh_kerayemabda,mablagh_haghetavaghof,mablagh_baskul,amel_p_accnting_code,shomare_govahi_behdashti,shomare_sabt_sefaresh,shomare_kotazh,tarikh_vorud,tozihat,deleted,status,taeed_nazer,signiture_resid)
             VALUES
			('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_resid','$mtActiveYear','$tarikh_resid','$IssuedTime','$code_bastebandy','$noe_tahvil_bar','$code_skk',
			 '$id_safar','$code_mabda','$code_ostan_mabda','$code_anbar_mabda','$id_havale','$shomare_havale_anbar','$shomare_jabejae','$bsk_id','$bsk_no','$barname_no',
			 '$barname_tarikh','$plak1','$plak2','$plak3','$plak4','$ranande_name','$ranande_melicode','$shomare_hesab_ranande','$bank_ranande','$ranande_mobile','$code_takhlie','$shomare_container','$code_peymankar_haml','$vazn_kamiyon_bar','$vazn_kamiyon',
			 '$shomare_polomp','$vaziyat_polomp','$noe_khodro','$noe_pardakht','$mablagh_kerayemabda','$mablagh_haghetavaghof','$mablagh_baskul','$amel_p_accnting_code','$shomare_govahi_behdashti','$shomare_sabt_sefaresh','$shomare_kotazh','$tarikh_vorud','$tozihat',0,0,'$taeed_nazer','$separatesigniture')");
  $insert_res=mysql_query($insert_q);
  if($insert_res)
  {
    if(($noe_tahvil_bar==4)or($noe_tahvil_bar==5))//جابه جایی
	{
	  $q_h1="SELECT *,SUM(tedad_karton_h_d) tedadKarton,SUM(vazn_nakhales_h_d) NaKhales,SUM(vazn_khales_h_d) Khales From havale_detail WHERE shomare_havale_anbar='$shomare_havale_anbar' AND code_ostan=$code_ostan_mabda AND code_anbar=$code_anbar_mabda AND year=$havale_year AND havale_deleted=0 AND status=0 GROUP BY code_kala,code_keshvar,code_tolidkonande";	
	  $res_h1=$db->query($q_h1);
	  $todaydate=$yy.'/'.$mm.'/'.$dd; 	  
	  while($row_h1=$db->fetch_assoc($res_h1))
	  {
	    $exist_gheymat=$db->get_from_where("count(*)","gheymat","deleted=0");
        if($exist_gheymat>0)
        {
         $res_gheymat=$db->query("SELECT id_gheymat FROM gheymat WHERE tarikh_etebar>='".$todaydate."' AND deleted=0 order by id_gheymat DESC LIMIT 0,1");//شماره آخرین جدول قیمت
         if(mysql_num_rows($res_gheymat)>0)
         {
          $row_gheymat=$db->fetch_assoc($res_gheymat);
          $res_gheymat_d=$db->query("SELECT * FROM gheymat_detail WHERE id_gheymat=".$row_gheymat['id_gheymat']." AND code_kala=".$row_h1['code_kala']." AND deleted=0 ");//بدست آوردن فی و ضریب کد کالا
          $row_gheymat_d=$db->fetch_assoc($res_gheymat_d);
         }
        }
	    if(($noe_tahvil_bar==4)OR($noe_tahvil_bar==5))//جابه جایی تخلیه
		{
		 if($code_bastebandy==1)//کارتن
		 { 
		  $vazn_mabda_r_d=$row_h1['NaKhales'];
	     }
		 else if($code_bastebandy==5)//دست
		 {
		  $vazn_mabda_r_d=$row_h1['tedadKarton'];
		 }
		 else 
		 {
		  $vazn_mabda_r_d=$row_h1['Khales'];
		 }
		 $kasry_mojaz_r_d=round(floatval(($vazn_mabda_r_d)*($row_gheymat_d['zarib']/1000)),2);
		}
		else {$vazn_mabda_r_d=0;$kasry_mojaz_r_d=0;}
	    $insert_detail_res=$db->query("INSERT INTO resid_detail(code_ostan,code_anbar,shomare_resid,year,code_kala,code_keshvar,code_tolidkonande,id_gheymat_this,fee_this,zarib_this,nerkh_takhlie_this,vazn_mabda_r_d,kasry_mojaz_r_d,vazn_khales_r_d,Re_GheymatDetailID,resid_deleted,status)VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_resid','$mtActiveYear',".$row_h1['code_kala'].",".$row_h1['code_keshvar'].",".$row_h1['code_tolidkonande'].",".$row_gheymat['id_gheymat'].",".$row_gheymat_d['fee'].",".$row_gheymat_d['zarib'].",'$nerkh_takhlie_this',".$vazn_mabda_r_d.",".$kasry_mojaz_r_d.",".$row_h1['Khales'].",'$GheymatDetailID',0,0)");   
	  }//END havale for resid_detail
	  $q_h2="SELECT * FROM havale_detail WHERE shomare_havale_anbar='$shomare_havale_anbar' AND code_ostan='$code_ostan_mabda' AND code_anbar='$code_anbar_mabda' AND year='$havale_year' AND havale_deleted=0 AND status=0";	
	  $res_h2=$db->query($q_h2);
      while($row_h2=$db->fetch_assoc($res_h2))
	  {
	    $tedad_karton_r+=$row_h2['tedad_karton_h_d'];
	    $vazn_nakhales_r+=$row_h2['vazn_nakhales_h_d'];
	    $vazn_khales_r+=$row_h2['vazn_khales_h_d'];
	    $exist_kala_detail=$db->get_from_where("count(*)","resid_kala_detail","code_ziranbar='$code_ziranbar' AND code_kala=".$row_h2['code_kala']." AND code_keshvar=".$row_h2['code_keshvar']." AND code_tolidkonande=".$row_h2['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h2['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h2['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h2['rouz_tolid_shamsi']." AND code_karton=".$row_h2['code_karton']." AND code_mandegari='".$row_h2['code_mandegari']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_resid='$shomare_resid'");	
		if($exist_kala_detail>0)//اگر در جزئیات کالا وجود دارد
		{
	     $tedad_karton_r_d_sub=$db->get_from_where("tedad_karton_r_d_sub","resid_kala_detail","code_ziranbar='$code_ziranbar' AND code_kala=".$row_h2['code_kala']." AND code_keshvar=".$row_h2['code_keshvar']." AND code_tolidkonande=".$row_h2['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h2['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h2['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h2['rouz_tolid_shamsi']." AND code_karton=".$row_h2['code_karton']." AND code_mandegari='".$row_h2['code_mandegari']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_resid='$shomare_resid'");	
	     $sum_karton_r_d_sub=$db->get_from_where("sum_karton_r_d_sub","resid_kala_detail","code_ziranbar='$code_ziranbar' AND code_kala=".$row_h2['code_kala']." AND code_keshvar=".$row_h2['code_keshvar']." AND code_tolidkonande=".$row_h2['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h2['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h2['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h2['rouz_tolid_shamsi']." AND code_karton=".$row_h2['code_karton']." AND code_mandegari='".$row_h2['code_mandegari']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_resid='$shomare_resid'");	
	     $vazn_nakhales_r_d_sub=$db->get_from_where("vazn_nakhales_r_d_sub","resid_kala_detail","code_ziranbar='$code_ziranbar' AND code_kala=".$row_h2['code_kala']." AND code_keshvar=".$row_h2['code_keshvar']." AND code_tolidkonande=".$row_h2['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h2['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h2['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h2['rouz_tolid_shamsi']." AND code_karton=".$row_h2['code_karton']." AND code_mandegari='".$row_h2['code_mandegari']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_resid='$shomare_resid'");	
	     $vazn_khales_r_d_sub=$db->get_from_where("vazn_khales_r_d_sub","resid_kala_detail","code_ziranbar='$code_ziranbar' AND code_kala=".$row_h2['code_kala']." AND code_keshvar=".$row_h2['code_keshvar']." AND code_tolidkonande=".$row_h2['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h2['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h2['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h2['rouz_tolid_shamsi']." AND code_karton=".$row_h2['code_karton']." AND code_mandegari='".$row_h2['code_mandegari']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_resid='$shomare_resid'");	
		 $tedad_shane_r_d_sub=$db->get_from_where("tedad_shane_r_d_sub","resid_kala_detail","code_ziranbar='$code_ziranbar' AND code_kala=".$row_h2['code_kala']." AND code_keshvar=".$row_h2['code_keshvar']." AND code_tolidkonande=".$row_h2['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h2['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h2['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h2['rouz_tolid_shamsi']." AND code_karton=".$row_h2['code_karton']." AND code_mandegari='".$row_h2['code_mandegari']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_resid='$shomare_resid'");	
		 $update_tedad=$tedad_karton_r_d_sub+$row_h2['tedad_karton_h_d'];
		 $update_sum=$sum_karton_r_d_sub+$row_h2['sum_karton_h_d'];
		 $update_nakhales=$vazn_nakhales_r_d_sub+$row_h2['vazn_nakhales_h_d'];
		 $update_khales=$vazn_khales_r_d_sub+$row_h2['vazn_khales_h_d'];
		 $update_shane=$tedad_shane_r_d_sub+$row_h2['tedad_shane_h_d'];
		 $update_kala_res=$db->query("UPDATE resid_kala_detail SET tedad_karton_r_d_sub='$update_tedad',sum_karton_r_d_sub='$update_sum',vazn_nakhales_r_d_sub='$update_nakhales',vazn_khales_r_d_sub='$update_khales',tedad_shane_r_d_sub='$update_shane' WHERE code_ziranbar='$code_ziranbar' AND code_kala=".$row_h2['code_kala']." AND code_keshvar=".$row_h2['code_keshvar']." AND code_tolidkonande=".$row_h2['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h2['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h2['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h2['rouz_tolid_shamsi']." AND code_karton=".$row_h2['code_karton']." AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_resid='$shomare_resid'");  	
		}
		else $insert_kala_res=$db->query("INSERT INTO resid_kala_detail(code_ostan,code_anbar,shomare_resid,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_karton,vazn_karton_this,code_mandegari,sum_karton_r_d_sub,tedad_karton_r_d_sub,vazn_nakhales_r_d_sub,vazn_khales_r_d_sub,tedad_shane_r_d_sub,status) VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_resid','$mtActiveYear','$code_ziranbar',".$row_h2['code_kala'].",".$row_h2['code_keshvar'].",".$row_h2['code_tolidkonande'].",".$row_h2['sal_tolid_shamsi'].",".$row_h2['mah_tolid_shamsi'].",".$row_h2['rouz_tolid_shamsi'].",".$row_h2['sal_tolid_milady'].",".$row_h2['mah_tolid_milady'].",".$row_h2['rouz_tolid_milady'].",".$row_h2['code_karton'].",".$row_h2['vazn_karton_this'].",'".$row_h2['code_mandegari']."',".$row_h2['sum_karton_h_d'].",".$row_h2['tedad_karton_h_d'].",".$row_h2['vazn_nakhales_h_d'].",".$row_h2['vazn_khales_h_d'].",'".$row_h2['tedad_shane_h_d']."',0)");  
	    
		/*آپدیت موجودی*/  
	    $exist_mojody=$db->get_from_where("count(*)","mojody_kala","code_ziranbar='$code_ziranbar' AND code_kala=".$row_h2['code_kala']." AND code_keshvar=".$row_h2['code_keshvar']." AND code_tolidkonande=".$row_h2['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h2['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h2['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h2['rouz_tolid_shamsi']." AND code_karton=".$row_h2['code_karton']." AND code_mandegari='".$row_h2['code_mandegari']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");	
		if($exist_mojody>0)//اگر در جدول موجودی کالا وجود دارد
        {   
		   //آپدیت موجودی کالا
	       $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$row_h2['code_kala'],$row_h2['code_keshvar'],$row_h2['code_tolidkonande'],$row_h2['sal_tolid_shamsi'],$row_h2['mah_tolid_shamsi'],$row_h2['rouz_tolid_shamsi'],$row_h2['code_karton'],$row_h2['code_mandegari']);
	       $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$row_h2['code_kala'],$row_h2['code_keshvar'],$row_h2['code_tolidkonande'],$row_h2['sal_tolid_shamsi'],$row_h2['mah_tolid_shamsi'],$row_h2['rouz_tolid_shamsi'],$row_h2['code_karton'],$row_h2['code_mandegari']);
	       $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$row_h2['code_kala'],$row_h2['code_keshvar'],$row_h2['code_tolidkonande'],$row_h2['sal_tolid_shamsi'],$row_h2['mah_tolid_shamsi'],$row_h2['rouz_tolid_shamsi'],$row_h2['code_karton'],$row_h2['code_mandegari']);
           IF($row_h2['code_kala']==50)$update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane"];
           ELSE IF($row_h2['code_kala']==54)$update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane_dakheli"];
		   ELSE $update_tedad_shane=0; 
		   $update_mojody_res=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton',tedad_shane='$update_tedad_shane' WHERE code_ziranbar='$code_ziranbar' AND code_kala=".$row_h2['code_kala']." AND code_keshvar=".$row_h2['code_keshvar']." AND code_tolidkonande=".$row_h2['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h2['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h2['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h2['rouz_tolid_shamsi']." AND code_karton=".$row_h2['code_karton']." AND code_mandegari='".$row_h2['code_mandegari']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");  
        }
        else //اگر وجود ندارد
        {
		  $insert_mojody_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,code_mandegari,sum_karton_this,tedad_karton_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_shane_aval,tedad_karton,mojody_nakhales,mojody_khales,tedad_shane,deleted)
                             VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$mtActiveYear','$code_ziranbar',".$row_h2['code_kala'].",".$row_h2['code_keshvar'].",".$row_h2['code_tolidkonande'].",".$row_h2['sal_tolid_shamsi'].",".$row_h2['mah_tolid_shamsi'].",".$row_h2['rouz_tolid_shamsi'].",".$row_h2['sal_tolid_milady'].",".$row_h2['mah_tolid_milady'].",".$row_h2['rouz_tolid_milady'].",'$code_bastebandy',".$row_h2['code_karton'].",".$row_h2['vazn_karton_this'].",'".$row_h2['code_mandegari']."',0,0,0,0,0,".$row_h2['tedad_karton_h_d'].",".$row_h2['vazn_nakhales_h_d'].",".$row_h2['vazn_khales_h_d'].",'".$row_h2['tedad_shane_h_d']."','0')");
		  $insert_mojody_res=$db->query($insert_mojody_q);
	    }
	  }//END havale for resid_kala_detail
	  $res_update_resid=$db->query("UPDATE resid SET tedad_karton_r='$tedad_karton_r',vazn_nakhales_r='$vazn_nakhales_r',vazn_khales_r='$vazn_khales_r' WHERE shomare_resid='$shomare_resid' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");       
      //update barname in havale
	  $q11="SELECT shomare_barname_h,tarikh_barname_h FROM havale WHERE shomare_havale_anbar='$shomare_havale_anbar' AND code_ostan='$code_ostan_mabda' AND code_anbar='$code_anbar_mabda' AND year='$mtActiveYear'";
      $res11=mysql_query($q11);
      $row11=mysql_fetch_assoc($res11);
	  if(($row11['shomare_barname_h']=='')or($row11['tarikh_barname_h']==''))//اگر درحواله خالی بود
	   $update_havale=$db->query("UPDATE havale SET shomare_barname_h='$barname_no',tarikh_barname_h='$barname_tarikh',barname_from_resid=1 WHERE code_ostan='$code_ostan_mabda' AND code_anbar='$code_anbar_mabda' AND year='$mtActiveYear' AND shomare_havale_anbar='$shomare_havale_anbar'");

	}//END jabejae
	$max_id=$db->get_from_where("MAX(id)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/ 

  }
  //IF(($insert_res AND $log_i)OR($insert_res AND $log_i AND $insert_detail_res AND $insert_kala_res AND $update_mojody_res AND $res_update_resid)OR($insert_res AND $log_i AND $insert_detail_res AND $insert_kala_res AND $insert_mojody_res AND $res_update_resid)) 
  IF($insert_res AND $log_i AND $insert_detail_res AND $insert_kala_res AND $update_kala_res AND $update_mojody_res AND $res_update_resid AND $insert_mojody_res)
  {
	   mysql_query("COMMIT");
	   IF(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); ELSE $code_a=$mt_gl_code_ostan;
	   echo "<script>alert('رسید شما به شماره".$code_a.$mt_gl_code_anbar.$shomare_resid." به ثبت رسید  . برای تکمیل رسید بخش جزئیات رسید را تکمیل نمایید')</script>"; 
       echo "<script>window.location='resid.php?PageNo=1&RowPerPage=".$RowPerPage."&order=".$order."';</script>";
   }
   ELSE  
   {
       mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
       echo "<script>alert('مشکلی در ثبت رسید به وجود آمده است')</script>";
       echo "<script>window.location='resid.php?PageNo=1&RowPerPage=".$RowPerPage."&order=".$order."';</script>";	   
   }
   mysql_query('SET AUTOCOMMIT=1'); 
 }
}
/***********************END*****************************/
echo'	
'.$message.'
		  <!--نمایش کالاهای اضافه شده به رسید-->
		  <!--  <div id="lightBox" style="display: none; width: 100%; height: 1000px; background: black; position: fixed; top:0px; right:0px; z-index: 1000"></div>    
		   <div id="uploadForm">
            <span onclick="closelistkala()" id="closeBtn"><img src="images/readonly.png" title="خروج"/></span>';
			include('resid_detail_bef.php');
            echo'
           </div> -->
<br/>
<br/>		 
</form>
</body>
</html>';
?>