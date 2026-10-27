<?php
require_once __DIR__ . '/mysql_compat.php';
ini_set('max_execution_time',300);
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="havale_new2.php";
$TableName="havale";
$titr='ایجاد حواله جدید';
// ایجاد شماره حواله - با توجه به استان و انبار وسال 
$q2="SELECT shomare_havale_anbar FROM $mydatabase.$TableName WHERE code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar'  
     AND year='$mtActiveYear' order by shomare_havale_anbar DESC LIMIT 0,1";
$res2=$db->query($q2);
$row2=$db->fetch_assoc($res2);
$w=$row2['shomare_havale_anbar'];
if($w){$shomare_havale_anbar=$w; $shomare_havale_anbar++;}
else $shomare_havale_anbar=1;
$shomare_havale_anbar=make_pattern($shomare_havale_anbar,5);
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
function OpenWindowDialog(url, w, h)
{
	 var features = "resizable:no;status:yes;dialogwidth:" + w + "px;dialogheight:" + h + "px;help:no";
     features = features + ";dialogtop:" + (window.screen.availHeight - w) /2;
	 features = features + ";dialogleft:" + (window.screen.availWidth - h) /2;	 
	 window.showModalDialog(url, this, features);	 
}
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width="+w+", height="+h+", top="+top+", left="+left);
}
function enterIE()
{
  if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
  window.event.keyCode = 9;
}
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
function getZiranbar(noe_zir_anbar)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{noeZIRANBAR:noe_zir_anbar},function(data){$("[name=code_ziranbar]").html(data);});
  $("#loading").fadeOut("fast");		
}
<!--چک کردن نام کاربری در صفحه کاربران در حالت کاربر جدید-->
function kamiyon_set(baskul_val)
{   
  $("#loading").fadeIn("fast"); 
       $.ajax({
        url: "ajax.php",
        type: "post",
        data:{baskulVAL:baskul_val},
        success: function(data){$(".baskul_set").show();}
    });
  $("#loading").fadeOut("fast");				
}
$(document).ready(function(){		
	    $("#tarikh_barname_h,#tarikh_govahi_behdashti").datepicker({
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
		});
		<!--تغییر براساس نوع تحویل بار-->
        $("[name=noe_tahvil_bar]").bind("change", function (){
        //alert($(this).val());
		if($(this).val() == 0)
		{
			$("#loading").fadeIn("fast");
			$(".panel").fadeOut("fast",function(){
			$(".notaion").fadeIn("slow");
			$("#loading").fadeOut("fast");
			});	
		}
		if($(this).val() == 2)<!--نوع تحویل بار روباری --> 
	    {
	        $("#loading").fadeIn("fast");
			$(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");
			$("[name=nerkh_bargiry_this]").prop("disabled", true);
            $("[name=vazn_khales_h]").prop("readonly", false);
	        $(".robaryhide").hide();
		    $(".j_hide_amani").show();
		    $(".j_show_manategh").hide();
		    $(".j_show_marjoee").hide();
		    $(".jabejaemanategh_hide").show();
		    $(".jabejae_hide").show();
	        $(".jabejaemanategh_show").hide();
	        $(".jabejae_show").hide();
		    //$(".jabejaeamani_hide").show();
	        //$(".jabejaeamani_show").hide();
	        $(".plakstar").hide();
	        $("#loading").fadeOut("fast");
			});
        }
		if(($(this).val() == 5)||($(this).val() == 7))<!--نوع تحویل بار جابه جایی کالای امانی --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");
			$(".j_hide_amani").show();
		    $(".j_show_manategh").hide();
		    $(".j_show_marjoee").hide();
			$(".jabejaemanategh_hide").hide();
			$(".jabejae_hide").hide();
			$(".jabejaemanategh_show").hide();			
			$(".jabejae_show").show();			
			//$(".jabejaeamani_hide").hide();
	        //$(".jabejaeamani_show").show();
			$(".robaryhide").show();
		    $(".plakstar").show();
	        $("#loading").fadeOut("fast");
            });			
        }
		if($(this).val() == 4)<!--نوع تحویل بار جابه جایی بین مناطق --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");	
			$(".jabejaemanategh_hide").hide();
			$(".jabejae_hide").hide();
			$(".j_hide_amani").hide();
			$(".j_show_marjoee").hide();
		    $(".j_show_manategh").show();
	        $(".jabejaemanategh_show").show();
	        $(".jabejae_show").show();
			//$(".jabejaeamani_hide").show();
	        //$(".jabejaeamani_show").hide();
			$(".robaryhide").show();
		    $(".plakstar").show();
	        $("#loading").fadeOut("fast");
            });			
		}
	    if($(this).val() == 6)<!--نوع تحویل بار جابه جایی مرجوعی --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");
			$(".j_hide_amani").hide();
		    $(".j_show_manategh").hide();
		    $(".j_show_marjoee").show();
			$(".jabejaemanategh_hide").hide();
			$(".jabejae_hide").hide();
			$(".jabejaemanategh_show").hide();			
			$(".jabejae_show").show();			
			//$(".jabejaeamani_hide").show();
	        //$(".jabejaeamani_show").hide();
			$(".robaryhide").show();
		    $(".plakstar").show();
	        $("#loading").fadeOut("fast");
            });			
        }
        if(($(this).val() == 1)||($(this).val() == 3))
	    {
	        $("#loading").fadeIn("fast");
	        $(".notaion").fadeOut("fast",function(){
			$(".panel").fadeIn("slow");
			$("[name=nerkh_bargiry_this]").prop("disabled", false);
	        $(".robaryhide").show();
			$(".j_hide_amani").show();
		    $(".j_show_manategh").hide();
		    $(".j_show_marjoee").hide();
			$(".jabejaemanategh_hide").show();
			$(".jabejae_hide").show();
	        $(".jabejaemanategh_show").hide();
	        $(".jabejae_show").hide();
			$(".jabejaeamani_hide").show();
	        $(".jabejaeamani_show").hide();
		    $(".plakstar").show();
	        $("#loading").fadeOut("fast");
            });			
        }
      });
      $("[name=shomare_baskul_h]").blur(function (){
		  if($(this).val().length > 0) 
		  {
			$(".baskul_set").show();
		  }
		  if($(this).val().length === 0) 
		  {
			$(".baskul_set").hide();
		  }		
      });
	  <!-- نمایش کومبو باکس نوع تحویل بار-->
      $("[name=chk_recieve]").change(function() {
           if (this.checked) {
			 $("#loading").fadeIn("fast");  
       		 $(".tahvilbar_display").show();
			 $("[name=help1]").val("1");
			 $("#loading").fadeOut("fast");
           } 
		   else {
			 $("#loading").fadeIn("fast");
       		 $(".tahvilbar_display").hide();
			 $("[name=help1]").val("0");
			 $("#loading").fadeOut("fast");
           }
       });	  
});
<!-- نرخ باسکول با انتخاب نوع خودرو-->
function getNerkhBaskul(noe_khodro)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{noeKHODRO:noe_khodro},function(data){
   $("#mablagh_baskul").val(data);
  });
  $("#loading").fadeOut("fast");		
}
function getDetailForush(s_h_f)<!-- اطلاعات حواله فروش-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax_detail_forush.php",{shomareHAVALEFORUSH: s_h_f},function(data){
		   var splForush = data.split("^");
		   $("#h_reg_date").val(splForush[0]);
		   $("#code_kala").val(splForush[1]);
		   $("#name_kala").val(splForush[2]);
		   $("#sharh_bastebandy").val(splForush[3]);		   
		   $("#code_customer").val(splForush[4]);
		   $("#name_customer").val(splForush[5]);
		   $("#ostan_moshtary").val(splForush[6]);
		   $("#shahr_moshtary").val(splForush[7]);
		   $("#h_deli_name").val(splForush[8]);
		   $("#meghdar_havale_forush").val(splForush[9]);
		   $("#meghdar_tahvily").val(splForush[10]);
		   $("#meghdar_batele").val(splForush[11]);
		   $("#mande_az_forush").val(splForush[12]);
		   $("#nerkh_bargiry_this").val(splForush[13]);
		   $("#mablagh_bargiry").val(splForush[13]);
		   $("#h_id").val(splForush[14]);
		   $("#rahnama_f").html(splForush[15]);
		   var x1=$("#h_reg_date").val();
		   $("#tarikh_barname_h").datepicker( "option", "minDate",x1 );		   
		   <!--$("#img_mojody").html(splForush[13]);-->
		   $("#loading").fadeOut("fast");	
		 });	
}
function getDetailJabejae(sh_j,noe_tahvil)<!-- اطلاعات مجوز جابه جایی-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax_detail_jabejae.php",{shomareJABEJAE:sh_j,noeTahvilBar:noe_tahvil},function(data){
		   var splJabejae = data.split("^");
		   $("#tarikh_jabejae").val(splJabejae[0]);
		   $("#code_ostan_maghsad_j").val(splJabejae[1]);
		   $("#code_anbar_maghsad_j").val(splJabejae[2]);
		   $("#code_kala").val(splJabejae[3]);
		   $("#name_kala").val(splJabejae[4]);
		   $("#sharh_bastebandy").val(splJabejae[5]);
		   $("#meghdar_jabejae").val(splJabejae[6]);
		   $("#meghdar_tahvily_j").val(splJabejae[7]);
		   $("#meghdar_batele_j").val(splJabejae[8]);
		   $("#mande_az_jabejae").val(splJabejae[9]);
		   $("#nerkh_bargiry_this").val(splJabejae[10]);
		   $("#mablagh_bargiry").val(splJabejae[10]);
		   $("#idJabejae").val(splJabejae[11]);
		   $("#code_customer").val(splJabejae[12]);
		   $("#name_customer").val(splJabejae[13]);
		   $("#rahnama").html(splJabejae[14]);
		   $("#code_skk").val(splJabejae[15]);
		   $("#name_skk").val(splJabejae[16]);
		   var x1=$("#tarikh_jabejae").val();
		   $("#tarikh_barname_h").datepicker( "option", "minDate",x1 );		   
		 });
    $("#loading").fadeOut("fast");
}
function getBaskul(sh_baskul,n_tahvil)<!-- اطلاعات باسکول از سیستم توزین-->
{
   $.post("ajax_havale.php",{shomareBaskul: sh_baskul,noeTahvilBar: n_tahvil},function(data){
		   var splBaskul = data.split("^");
		   $("[name=bsk_id]").val(splBaskul[0]);
		   $("[name=bsk_no]").val(splBaskul[1]);
		   $("[name=plak1]").val(splBaskul[2]);
		   $("[name=plak2]").val(splBaskul[3]);
		   $("[name=plak3]").val(splBaskul[4]);
		   $("[name=plak4]").val(splBaskul[5]);
		   $("[name=ranande_name]").val(splBaskul[6]);
		   $("[name=ranande_melicode]").val(splBaskul[7]);  
		   $("[name=vazn_kamiyon_bar]").val(splBaskul[8]);
		   $("[name=vazn_kamiyon]").val(splBaskul[9]);
		   $("[name=h_code]").val(splBaskul[10]);
		   $("[name=shomare_jabejae]").val(splBaskul[11]);
		   $("[name=noe_khodro]").val(splBaskul[12]);
		   if((n_tahvil==1)||(n_tahvil==2)||(n_tahvil==3))  {$("[name=h_code]").focus();}
		   else $("[name=shomare_jabejae]").focus();
		 });
}
function tahvil_mande()
{
 var natije1,natije2;
 document.myform.meghdar_tahvily.value=Number(document.myform.vazn_kamiyon_bar_h.value)-Number(document.myform.vazn_kamiyon_h.value);                                       
 document.myform.mande_az_forush.value=Number(document.myform.meghdar_havale_forush.value)-Number(document.myform.meghdar_tahvily.value)-Number(document.myform.meghdar_batele.value);
 natije1=document.myform.meghdar_tahvily.value;
 natije2=document.myform.mande_az_forush.value;
 return natije1,natije2;
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" border="0" height="100%" align="center" cellpadding="0" cellspacing="0" >
 <!--هدر-->
 <tr><td class="title" >ايجاد حواله جديد</td></tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div styles="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>';
	IF($mtActiveYear=='1397')
	{
	 echo'
	 <tr class="tr1">
	  <td colspan="3" align="right" style="color:red">
	  کاربر گرامی در صورتیکه حواله هایی مربوط به سال قبل دارید که هنوز ثبت نکرده اید ،
	  ابتدا آنها را ثبت کنید تا در صورت انتقال مجدد موجودی به سال جدید ، مقادیر موجودی سردخانه شما منفی نشود.
	  </td>
	 </tr>';	
	}
    echo'	
	<tr class="tr1">
	 <td colspan="2" align="right" style="color:red">
	  لطفاً قبل از تکمیل فرم به علایم 	<img border="0" src="images/Info1.png" "onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;"/> توجه نمایید
	 </td>
	 <td align="left"  style="color:red">توجه <img border="0" src="images/Info1.png" title="لطفاً در ثبت مقادیر دقت نمایید ، بعد از کلیک روی گزینه ثبت امکان ویرایش مقادیر وجود ندارد" style="cursor:pointer" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'"/></span>
	 </td>
	</tr>
	<tr class="tr1">
     <td colspan="4" align="right" style="color:red">توجه :
	  دقت کنید ابتدا نوع تحویل بار را انتخاب نمایید سپس شماره حواله فروش یا شماره مجوز جابه جایی را پر کنید ! 
	 </td>
	</tr> 
	<tr class="tr1">
	 <td valign="top" width="30%">
	  <fieldset>
	   <legend> حواله سردخانه</legend>
       <table width=100% border="0" height="85px">
	    <tr><td align="left" width="155px"><span class="star">*</span> شماره حواله سردخانه : </td>
	        <td align="right" width="160px">
	 	     <input tabindex="-1" type="text" class="textboxme" readonly value="'.$shomare_havale_anbar.'" name="shomare_havale_anbar" style="width:50px;"/>&nbsp;/&nbsp;';
	 	     if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
	 	     else $code_a=$mt_gl_code_ostan;		
	 	     echo'<input tabindex="-1" type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
	    </tr>
        <tr>';
	    if($_SESSION["mtActiveYear"]==$yy)echo'<td align="left" width="155px"><span class="star">*</span> تاريخ حواله سردخانه : </td><td align="right" width="160px"><input type="text" tabindex="-1" readonly value="'.AsLDate($yymmdd).'" class="textboxme2" name="tarikh_havale_anbar" id="tarikh_havale_anbar"/></td>';
	 	else echo'<td align="left" width="155px"><span class="star">*</span> تاريخ حواله سردخانه : </td><td align="right" width="160px"><input tabindex="-1" type="text" readonly value="'.$mtEndDateSh.'" class="textboxme2" name="tarikh_havale_anbar" id="tarikh_havale_anbar" maxlenght="10"/></td>';
	    echo'
		</tr>
	   </table>
	  </fieldset>
	 </td> 
	 <td valign="top" width="35%">
	  <fieldset>
	  <legend>تحویل بار</legend>
       <table width=100% border="0" height="85px">
	    <tr>
		 <td align="center" colspan="2"><input type="checkbox" name="chk_recieve" '; if($help1==1) echo 'checked';  echo' />
		 اصل حواله فروش/ مجوز جابه جایی دریافت شد</td>
		 <input type="hidden" name="help1" value='.$help1.'><!--برای درست ظاهر شدن تیک و کمبوباکس تحویل بار-->
		</tr>
		<tr class="tahvilbar_display" '; if($help1==0) echo' style="display:none;"'; echo'>';
	     //اگر اولین بار است که وارد صفحه می شویم
		 if(!isset($noe_tahvil_bar))
		 {
		  echo'<td align="left" width="130px"><span class="star">*</span> نوع تحویل بار : </td><td align="right">';
		  //سردخانه حقیقی
		  //if($_SESSION['mt_situation_type']==1)echo''.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr_h",1,"class='text4'").'</td>';
		  if($_SESSION['mt_situation_type']==1)echo''.listbox("noe_tahvil_bar",$noe_tahvil_bar,"noe_tahvil_bar","sharh_tahvil_bar","tahvilbar_havale","noe_tahvil_bar!=10","class='text4' onchange=myform.submit() tabindex='-6'").'</td>';
		  else echo''.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr_h_Movaghat",1,"class='text4'").'</td>';
		 }
	     //اگر ارروری ظاهر شده و به صفحه برگشته ایم
		 else 
		 {
		  echo'<td align="left" width="130px"><span class="star">*</span> نوع تحویل بار : </td><td align="right">';
		  //سردخانه حقیقی
		  if($_SESSION['mt_situation_type']==1)echo''.listbox("noe_tahvil_bar",$noe_tahvil_bar,"noe_tahvil_bar","sharh_tahvil_bar","tahvilbar_havale","noe_tahvil_bar!=10","class='text4' onchange=myform.submit() tabindex='-6'").'</td>';
		  
		  else echo''.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr_h_Movaghat",1,"class='text4' onchange=myform.submit()").'</td>';
		 }		 
		 echo'
		</tr> 
	   </table>
	  </fieldset>
     </td>
	 <td valign="top" width="35%">
	  <fieldset>
	   <legend>اطلاعات تکمیلی</legend>
 	    <table width=100% border="0" height="85px">
	     <tr><td align="left">نوع بارگیری : </td><td align="right">'.listbox("code_bargiry",$code_bargiry,"code_takhlie","sharh_takhlie","takhlie","","class='text4'","").'</td>
		 <!--<tr><td align="left" width="90px">تاریخ گواهی بهداشتی :</td><td align="right" width="160px"><input type="text" class="textboxme2" maxlength="10" id="tarikh_govahi_behdashti" name="tarikh_govahi_behdashti" value="'.$tarikh_govahi_behdashti.'"/></td></tr>-->
	     <tr><td align="left" width="90px">شماره گواهی بهداشتی :</td><td align="right" width="160px"><input type="text" class="textboxme2" name="shomare_govahi_behdashti" value="'.$shomare_govahi_behdashti.'"/></td></tr>
		 <tr><td align="left">توضیحات :</td><td align="right"><input type="text" class="textboxme" name="tozihat" value="'.$tozihat.'"/></td></tr>
		</table> 
	  </fieldset>
	 </td>
	</tr>';
	//اگر اولین بار است وارد صفحه شده ایم
    if(!$noe_tahvil_bar){echo'<tr class="tr1 notaion"><td colspan="3">برای مشاهده سایر اطلاعات نوع تحویل بار را انتخاب نمایید</td></tr><tr class="tr1 panel" style="display:none;">';}
    //اگر ارروری ظاهر شده و به صفحه برگشته ایم
	else{echo'<tr class="tr1 panel">';}
	echo'
   	<td valign="top" width="30%">';
   	if(($noe_tahvil_bar==4)or($noe_tahvil_bar==5)or($noe_tahvil_bar==6)or($noe_tahvil_bar==7)or($noe_tahvil_bar==9))//جابه جایی 
	{echo'
	  <fieldset class="jabejae_show">
	   <legend>مجوز جابه جایی</legend>
	   <table width=100% border="0" height="240px">	   
        <tr>
		 <input type="hidden" name="idJabejae" id="idJabejae" value="'.$idJabejae.'"/>
		 <td align="left"><span class="star">*</span> شماره مجوز جابه جایی : </td>
		 <td align="right"><input type="text" class="textboxme2" readonly name="shomare_jabejae" value="'.$shomare_jabejae.'" onfocus="getDetailJabejae(this.value,document.myform.noe_tahvil_bar.value)" onchange="getDetailJabejae(this.value,document.myform.noe_tahvil_bar.value)"/>&nbsp;';
	     include ("img_helpjabejae.php");
		 echo'
		 </td>
		</tr>
        <tr><td align="left" width="160px">تاريخ مجوز جابه جایی : </td><td align="right" width="160px"><input tabindex="-1" type="text" class="textboxme2" readonly id="tarikh_jabejae" name="tarikh_jabejae" value="'.$tarikh_jabejae.'"/></td></tr>
	   </table>
	  </fieldset>';
	 }
	 else
	 {echo'
	   <fieldset class="jabejae_hide">
	    <legend >حواله فروش</legend>
	    <table  width=100% border="0" height="240px">
	     <tr>
          <input tabindex="-1" type="hidden" name="h_id" id="h_id" value="'.$h_id.'"/>	   
          <td align="left" ><span class="star">*</span> شماره حواله فروش : </td>
		  <td align="right"><input type="text" class="textboxme2" readonly name="h_code" value="'.$h_code.'" onfocus="getDetailForush(this.value)" onchange="getDetailForush(this.value)" onkeypress="return isNumber(event)"/>&nbsp;';
	       include ("img_helphavaleforush.php");echo'
		  </td>
		 </tr>
         <tr >		
		  <td align="left">تاريخ حواله فروش : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" readonly id="h_reg_date" name="h_reg_date" value="'.$h_reg_date.'"/></td>
		 </tr>
		 <tr >		
		  <td align="left">شماره درخواست : </td><td align="right"><input type="text" class="textboxme2" name="shomare_darkhast" value="'.$shomare_darkhast.'"/></td>
		 </tr>
	    </table>
	   </fieldset>
	   <fieldset class="jabejae_show" style="display:none;">
	    <legend>مجوز جابه جایی</legend>
	    <table width=100% border="0" height="240px" >
		 <tr>
		  <input tabindex="-1" type="hidden" name="idJabejae" id="idJabejae" value="'.$idJabejae.'"/>
		  <td align="left"><span class="star">*</span> شماره مجوز جابه جایی : </td>
		  <td align="right"><input type="text" class="textboxme2" readonly name="shomare_jabejae" value="'.$shomare_jabejae.'" onfocus="getDetailJabejae(this.value,document.myform.noe_tahvil_bar.value)" onchange="getDetailJabejae(this.value,document.myform.noe_tahvil_bar.value)"/>&nbsp;';
	       //include ("img_helpjabejae.php");
		   echo'<img border="0" src="images/help.png" onClick="popupwindow(\'help_jabejae.php?noe_tahvil_bar_=\'+document.myform.noe_tahvil_bar.value+\'\',\'\',700,650)" title="جدول مجوز جابه جایی" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>';
		   echo'
		  </td>
		 </tr>
         <tr>   		
		  <td align="left" >تاريخ مجوز جابه جایی : </td><td align="right" width="160px"><input tabindex="-1" type="text" class="textboxme2" readonly id="tarikh_jabejae" name="tarikh_jabejae" value="'.$tarikh_jabejae.'"/></td>
		 </tr>
		</table>
	   </fieldset>';
	   }
	 echo'
	</td>
    <td width="35%" valign="top">
	  <fieldset>
	   <legend>اطلاعات</legend>
	   <table width=100% border="0" height="240px">';
		//اگر نوع تحویل  بار تحویل روباری باشد
	    if($noe_tahvil_bar==2) echo'';
	    else
		{
		  IF($_SESSION['mt_systemtozin']==1)//اتصال به سیستم باسکول
		  {
		   echo'<tr><td align="left" class="robaryhide"><span class="star" style="color:red">*</span> شماره باسکول : </td><td align="right" class="robaryhide"><input type="hidden" name="bsk_id" value="'.$bsk_id.'" /><input  tabindex="-1" type="text" class="textboxme2" id="bsk_no" name="bsk_no" value="'.$bsk_no.'" onfocus="getBaskul(this.value,document.myform.noe_tahvil_bar.value)" onblur="getBaskul(this.value,document.myform.noe_tahvil_bar.value)" />';
		   IF(($noe_tahvil_bar==1)OR($noe_tahvil_bar==2)OR($noe_tahvil_bar==3))echo'&nbsp;<img border="0" src="images/help.png" onClick="popupwindow(\'help_baskul.php?parent_page='.$FileName.'&noe_tahvil_bar_='.$noe_tahvil_bar.'&h_id_=\'+document.myform.h_id.value+\'\',\'\',900,500)" title="اطلاعات باسکول" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td></tr>';
		   ELSE echo'&nbsp;<img border="0" src="images/help.png" onClick="popupwindow(\'help_baskul.php?parent_page='.$FileName.'&noe_tahvil_bar_='.$noe_tahvil_bar.'&idJabejae_=\'+document.myform.id_jabejae.value+\'\',\'\',900,500)" title="اطلاعات باسکول" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td></tr>';
		  }
		  ELSE //عدم اتصال به سیستم باسکول
		  {
		   echo'
		   <tr>
			<td align="left" class="robaryhide"><span class="star" style="color:red">*</span> شماره باسکول : </td>
			<td align="right" class="robaryhide"><input type="text" class="textboxme2" id="shomare_baskul_h" name="shomare_baskul_h" value="'.$shomare_baskul_h.'" onkeypress="return isNumber(event)"/> <img border="0" src="images/Info1.png" title="برای توزین دستی بدون استفاده از شماره باسکول عدد صفر را وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>
		   </tr>';
		  }
	    }		
		 //if($_SESSION['mt_systemmabadi']==0)
		  echo'<tr><td align="left"><span class="star">*</span> شماره بارنامه : </td><td align="right"><input type="text" class="textboxme2" name="shomare_barname_h" value="'.$shomare_barname_h.'"/></td></tr>';
		 //if($_SESSION['mt_systemmabadi']==1)
		  //echo'<tr><td align="left"> شماره بارنامه : </td><td align="right"><input type="text" class="textboxme2" name="shomare_barname_h" value="'.$shomare_barname_h.'"/>';
		  //include ("img_helpbarname.php");echo'</td></tr>
	     echo'
		 <tr><td align="left"><span class="star">*</span> تاريخ بارنامه : </td><td align="right"><input type="text" class="textboxme2" maxlength="10" id="tarikh_barname_h" name="tarikh_barname_h" value="'.$tarikh_barname_h.'"/></td></tr>';
	     echo'
		 <tr class="baskul_set">
		  <td align="left">';
		   if($noe_tahvil_bar==2) echo'';
		   else echo'<span class="star plakstar" style="color:red">*</span>';
		   echo'
		   پلاک خودرو : </td>
		  <td align="right">
		   <!--<input type="text" class="textboxme2" name="shomare_kamiyon_h" value="'.$shomare_kamiyon_h.'"/>-->
		    <sup>ایران</sup>
		    <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" tabindex="1" onkeyup="changeFocus(this)" style="width:20px;"/> |
		    <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" tabindex="2" onkeyup="changeFocus(this)" style="width:30px;"/>
	        <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" tabindex="3" onkeyup="changeFocus(this)" style="width:20px;"/>
		    <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" tabindex="4" onkeyup="changeFocus(this)" style="width:20px;"/>
		  </td>
		 </tr>
		 <tr><td align="left"> نام راننده : </td><td align="right"><input type="text" class="textboxme2" name="ranande_name" value="'.$ranande_name.'" /></td></tr>
		 <tr><td align="left"> کد ملی راننده : </td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="ranande_melicode" value="'.$ranande_melicode.'" onkeypress="return isNumber(event);" /></td></tr>';
	     echo'<tr><td align="left"> شماره پلمپ : </td><td align="right"><input type="text" class="textboxme2" name="shomare_polomp_h" value="'.$shomare_polomp_h.'"/></td></tr>
	     <tr><td align="left"> وضعیت پلمپ : </td><td align="right">'.static_listbox("vaziyat_polomp_h",$vaziyat_polomp_h,"polompArr",1,"class='text4'").'</td></tr>
	   </table>
	  </fieldset>
     </td>
	 <td width="35%" valign="top">';
	 if(($noe_tahvil_bar==4)OR($noe_tahvil_bar==9))//جابه جایی بین مناطق یا تحت کلید
	 {
	  echo'
	  <fieldset class="j_show_manategh">
	   <legend>اطلاعات استان مقصد</legend>
	   <table width=100% border="0" height="240px">
		<tr><td align="left">نام استان مقصد : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="code_ostan_maghsad_j" id="code_ostan_maghsad_j" value="'.$code_ostan_maghsad_j.'"/></td></tr>
		<tr><td align="left">نام سردخانه مقصد : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="code_anbar_maghsad_j" id="code_anbar_maghsad_j" value="'.$code_anbar_maghsad_j.'"/></td></tr>
	   </table>
	  </fieldset>';
	 }
	 else if($noe_tahvil_bar==6)//جابه جایی مرجوعی
	 {
	  echo'
	  <fieldset class="j_show_marjoee">
	   <legend>اطلاعات کشتی / فروشنده</legend>
	   <table width=100% border="0" height="240px">
		<tr><td align="left">کد کشتی / فروشنده : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="code_skk" id="code_skk" value="'.$code_skk.'"/></td></tr>
		<tr><td align="left">نام کشتی / فروشنده : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="name_skk" id="name_skk" value="'.$name_skk.'"/></td></tr>
	   </table>
	  </fieldset>';
	 }
	 else
	 {
	 echo'
	  <fieldset class="j_hide_amani">
	   <legend>مشتری</legend>
	   <table width=100% border="0" height="240px">
	    <tr><td align="left" width="90px"> کد مشتری : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2 textbox50" readonly name="code_customer" id="code_customer" value="'.$code_customer.'"/></td></tr>
		<tr><td align="left">نام مشتری : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="name_customer" id="name_customer" value="'.$name_customer.'"/></td></tr>
	   	<tr><td align="left">نام تحویل گیرنده : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="h_deli_name" id="h_deli_name" value="'.$h_deli_name.'"/></td></tr>
	   </table>
	  </fieldset>
	  <fieldset class="j_show_manategh" style="display:none;">
	   <legend>اطلاعات استان مقصد</legend>
	   <table width=100% border="0" height="240px">
		<tr><td align="left" width="90px">نام استان مقصد : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="code_ostan_maghsad_j" id="code_ostan_maghsad_j" value="'.$code_ostan_maghsad_j.'"/></td></tr>
		<tr><td align="left">نام انبار مقصد : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="code_anbar_maghsad_j" id="code_anbar_maghsad_j" value="'.$code_anbar_maghsad_j.'"/></td></tr>
	   </table>
	  </fieldset>
	  <fieldset class="j_show_marjoee" style="display:none;">
	   <legend>اطلاعات کشتی / فروشنده</legend>
	   <table width=100% border="0" height="240px">
		<tr><td align="left">کد کشتی / فروشنده : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="code_skk" id="code_skk" value="'.$code_skk.'"/></td></tr>
		<tr><td align="left">نام کشتی / فروشنده : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="name_skk" id="name_skk" value="'.$name_skk.'"/></td></tr> 
	   </table>
	  </fieldset>
	       <!--<fieldset class="jabejaemanategh_hide">
	        <legend>اطلاعات مشتری</legend>
	        <table width=100% border="0" height="155px">
	         <tr><td align="left"> کد مشتری : </td><td align="right"><input type="text" class="textboxme2 textbox50" readonly name="code_customer" id="code_customer" value="'.$code_customer.'"/></td></tr>
	  	   <tr><td align="left">نام مشتری : </td><td align="right"><input type="text" class="textboxme" readonly name="name_customer" id="name_customer" value="'.$name_customer.'"/></td></tr>
	        	<tr><td align="left">نام تحویل گیرنده : </td><td align="right"><input type="text" class="textboxme" readonly name="h_deli_name" id="h_deli_name" value="'.$h_deli_name.'"/></td></tr>
	        </table>
	       </fieldset>
	       <fieldset class="jabejaemanategh_show" style="display:none;">
	        <legend>اطلاعات استان مقصد</legend>
	        <table width=100% border="0" height="155px">
	  	   <tr><td align="left" width="90px">نام استان مقصد : </td><td align="right"><input type="text" class="textboxme" readonly name="code_ostan_maghsad_j" id="code_ostan_maghsad_j" value="'.$code_ostan_maghsad_j.'"/></td></tr>
	  	   <tr><td align="left">نام انبار مقصد : </td><td align="right"><input type="text" class="textboxme" readonly name="code_anbar_maghsad_j" id="code_anbar_maghsad_j" value="'.$code_anbar_maghsad_j.'"/></td></tr>
	         <tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
	        </table>
	       </fieldset>
	       <fieldset class="jabejaeamani_show" style="display:none;">
	        <legend>اطلاعات مشتریofkgokdo</legend>
	        <table width=100% border="0" height="155px">
	         <tr><td align="left"> کد مشتری : </td><td align="right"><input type="text" class="textboxme2 textbox50" readonly name="code_customer" id="code_customer_amani" value="'.$code_customer.'"/></td></tr>
	  	   <tr><td align="left">نام مشتری : </td><td align="right"><input type="text" class="textboxme" readonly name="name_customer" id="name_customer_amani" value="'.$name_customer.'"/></td></tr>
	        </table>
	       </fieldset>-->';
	  }
	  echo'
     </td>
	</tr>';
	//اگر اولین بار است وارد صفحه شده ایم
    if(!$noe_tahvil_bar){echo'<tr class="tr1 panel" style="display:none;">';}
    //اگر ارروری ظاهر شده و به صفحه برگشته ایم
	else{echo'<tr class="tr1 panel">';}
	echo'
	 <td width="30%" valign="top">
	  <fieldset>
	   <legend>کالا</legend>
	   <table width=100% border="0" height="190px">
	    <tr><td align="left" width="90px"> کد کالا : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2 textbox50" readonly name="code_kala" id="code_kala" value="'.$code_kala.'"/></td></tr>
		<tr><td align="left">نام کالا : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="name_kala" id="name_kala" value="'.$name_kala.'"/></td></tr>
		<tr><td align="left">نوع بسته بندی : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly name="sharh_bastebandy" id="sharh_bastebandy" value="'.$sharh_bastebandy.'"/></td></tr>';
		//اگر نوع تحویل  بار تحویل روباری باشد
		if($noe_tahvil_bar==2) echo'';
	    else echo'<tr class="robaryhide"><td align="left">نرخ بارگیری : </td><td align="right"><input tabindex="-1" type="text" class="textboxme" readonly id="nerkh_bargiry_this" name="nerkh_bargiry_this" value="'.$nerkh_bargiry_this.'"/></td></tr>';
        echo'
	   </table>
	  </fieldset>
	 </td>
	 <td width="35%" valign="top" >';
	 if($noe_tahvil_bar!=2)//اگر نوع تحویل  بار تحویل روباری نباشد
	 {echo'	  
	  <fieldset class="robaryhide baskul_set">
	   <legend>وزن</legend>
	   <table width=100% border="0" height="60px">
	    <tr><td align="left"><span class="star" style="color:red">*</span> وزن کاميون با بار : </td><td align="right"><input type="text" class="textboxme2" name="vazn_kamiyon_bar_h" value="'.$vazn_kamiyon_bar_h.'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
	    <tr><td align="left"><span class="star" style="color:red">*</span> وزن کاميون : </td><td align="right"><input type="text" class="textboxme2" name="vazn_kamiyon_h" value="'.$vazn_kamiyon_h.'" onkeypress="return isNumber(event)"/></td></tr>
	   </table>
	  </fieldset>';
	 }
	  echo'
	  <fieldset>
	   <legend>هزینه ها</legend>
	   <table width="100%" height="70px">
	    <tr><td align="left"><span class="star">*</span> نوع خودرو : </td><td align="right">'.static_listbox("noe_khodro",$noe_khodro,"khodroArr",1,"class='text4' onchange=getNerkhBaskul(this.value) ").'</td></tr>
	    <tr><td align="left">مبلغ باسکول : </td><td align="right"><input tabindex="-1" type="text" readonly class="textboxme2" id="mablagh_baskul" name="mablagh_baskul" value="'.$mablagh_baskul.'"/></td></tr>';
	    //اگر نوع تحویل  بار تحویل روباری باشد
	    if($noe_tahvil_bar==2) echo'';	  
	    else echo'<tr class="robaryhide"><td align="left">هزینه بارگیری :</td><td align="right"><input tabindex="-1" type="text" readonly class="textboxme2" name="mablagh_bargiry" id="mablagh_bargiry" value="'.$mablagh_bargiry.'"/></td></tr>';
	    echo'
	   </table>
	  </fieldset>
     </td>
	 <td width="35%" valign="top">
	  <fieldset>
	   <legend>مقادیر</legend>';
	   if(($noe_tahvil_bar==4)or($noe_tahvil_bar==5)or($noe_tahvil_bar==6)or($noe_tahvil_bar==7)or($noe_tahvil_bar==9))
	   {
	    echo'
	    <table width="100%" border="0" height="190px" class="jabejae_show">
	  	 <tr><td align="left" width="200px"> مقدار مجوز جابه جایی : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" id="meghdar_jabejae" name="meghdar_jabejae" value="'.$meghdar_jabejae.'" readonly/>
		     <span  name="rahnama" id="rahnama" class="rahnama"></span>
			 </td>
		 </tr>
	     <tr><td align="left">مقدار تحویلی  : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" readonly id="meghdar_tahvily_j" name="meghdar_tahvily_j" value="'.$meghdar_tahvily_j.'"/></td></tr>
	  	 <tr><td align="left">مقدار باطله : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" readonly id="meghdar_batele_j" name="meghdar_batele_j" value="'.$meghdar_batele_j.'"/></td></tr>
	     <tr><td align="left"> مقدار مانده از مجوز جابه جایی : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" id="mande_az_jabejae" name="mande_az_jabejae" value="'.$mande_az_jabejae.'" readonly/></td></tr>
		</table>';
	   }
	   else
	   {
	   echo'
	   <table width=100% border="0" height="190px" class="jabejae_hide">
	    <tr><td align="left">مقدار حواله فروش : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" readonly name="meghdar_havale_forush" id="meghdar_havale_forush" value="'.$meghdar_havale_forush.'"/><span  name="rahnama_f" id="rahnama_f" class="rahnama"></span></td></tr>
	    <tr><td align="left">مقدار تحویلی از حواله فروش : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" readonly name="meghdar_tahvily" id="meghdar_tahvily" value="'.$meghdar_tahvily.'" /></td></tr>
	    <tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" tabindex="-1" class="textboxme2" readonly name="meghdar_batele" id="meghdar_batele" value="'.$meghdar_batele.'"/></td></tr>
	    <tr><td align="left">مقدار مانده از حواله فروش : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" readonly name="mande_az_forush" id="mande_az_forush" value="'.$mande_az_forush.'"/></td></tr>
	   </table>
	   <table width="100%" border="0" height="190px" class="jabejae_show" style="display:none;">
	  	 <tr><td align="left" width="200px"><span class="star">*</span> مقدار مجوز جابه جایی : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" id="meghdar_jabejae" name="meghdar_jabejae" value="'.$meghdar_jabejae.'" readonly/>
		      <span  name="rahnama" id="rahnama" class="rahnama"></span>
			 </td>
		 </tr>
	     <tr><td align="left">مقدار تحویلی  : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" readonly id="meghdar_tahvily_j" name="meghdar_tahvily_j" value="'.$meghdar_tahvily_j.'"/></td></tr>
	  	 <tr><td align="left">مقدار باطله : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" readonly id="meghdar_batele_j" name="meghdar_batele_j" value="'.$meghdar_batele_j.'"/></td></tr>
	     <tr><td align="left"><span class="star">*</span> مقدار مانده از مجوز جابه جایی : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2" id="mande_az_jabejae" name="mande_az_jabejae" value="'.$mande_az_jabejae.'" readonly/></td></tr>
		</table>';
	   }
	   echo'
      </fieldset>
	 </td>
	</tr>';
   echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
</table>
</div>
<!-- فوتر-->
<table style="position:fixed;bottom:-2px;left:0.5%" width="99%"> 
 <tr class="footer">
  <td align="center">
   <input type="submit" class="buttonme" name="Insert_x" id="sabt" value="ثبت اطلاعات">
   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'havale.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
  </td>
 </tr>
</table> 
<!-- پايان فوتر-->';
/************اجازه براي ذخيره اطلاعات************/ 
function isPermitSave($sh_h,$ta_h,$h_code,$sh_j,$chk_r,$n_tahvil,$bsk_id,$bsk_no,$sh_baskul,$shomare_barname_h,$date_barname,$pl1,$pl2,$pl3,$pl4,$co_kala,$co_customer,$v_k_b,$v_k,$khodro,$ta_forush,$m_forush,$m_jabejae,$gl_c_o,$gl_c_s,$gl_year) 
{
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($sh_h and $ta_h and $n_tahvil and $co_kala and $khodro and $chk_r and $shomare_barname_h and $date_barname))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((($n_tahvil==1)or($n_tahvil==2)or($n_tahvil==3))and(!($h_code and $ta_forush and $co_customer)))//پر بودن شماره حواله فروش در صورتیکه نوع تحویل جابهجایی نباشد
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((($n_tahvil==4)or($n_tahvil==5)or($n_tahvil==6)or($n_tahvil==7)or($n_tahvil==9))and(!($sh_j)))//پر بودن شماره جابه جایی در حالت جابه جایی
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //if(($n_tahvil!=2) and ($sh_baskul!='') and (!($sh_kamiyon and $v_k_b and $v_k)))//پر بودن وزن کامیون با بار و وزن کامیون در صورتیکه نوع تحویل بار روباری نباشد
 if(($n_tahvil!=2) and ($sh_baskul!='') and (!($pl1 and $pl2 and $pl3 and $pl4 and $v_k_b and $v_k)))//پر بودن وزن کامیون با بار و وزن کامیون در صورتیکه نوع تحویل بار روباری نباشد
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(checkdatejalali($ta_h)==false)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(($date_barname)and((checkdatejalali($date_barname)==false) or ($date_barname>$ta_h)))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ بارنامه را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 // if($sh_baskul!='0') 
 // {
  // if(($n_tahvil!=2) and (!($sh_baskul)))//پر بودن شماره باسکول در صورتیکه نوع تحویل بار روباری نباشد
  // {
   // $flag=false;
   // echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   // return $flag;
  // } 
  // else $flag=true;
 // }
 // else $falg=true;
 //if(($sh_baskul!='0')and ($n_tahvil!=2))//تکراری نبودن شماره باسکول هم در رسید و هم در حواله به ازای هر انبار و هر سال 
 if(($sh_baskul)and ($n_tahvil!=2))//تکراری نبودن شماره باسکول هم در رسید و هم در حواله به ازای هر انبار و هر سال 
 { 
   $q_baskul_r="SELECT shomare_baskul FROM meat.resid WHERE shomare_baskul='".$sh_baskul."' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year' AND deleted=0 AND status=0";
   $q_baskul_h="SELECT shomare_baskul_h FROM meat.havale WHERE shomare_baskul_h='".$sh_baskul."' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year' AND deleted=0 AND status=0";
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
 //if((($sh_kamiyon)or($v_k_b)or($v_k)) and($n_tahvil!=2) and ($sh_baskul==''))//اگر شماره کامیون و یا وزن کامیون ها را زد 
 if((($pl1)or($pl2)or($pl3)or($pl4)or($v_k_b)or($v_k)) and($n_tahvil!=2) and ($sh_baskul==''))//اگر شماره کامیون و یا وزن کامیون ها را زد 
 {
   $flag=false;
   echo"<script>window.alert('شماره باسکول را وارد نمایید!');</script>";
   //echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((!empty($date_barname))and($date_barname<$ta_forush)) //تاریخ بارنامه
 {
   $flag=false;
   echo"<script>window.alert('تاریخ بارنامه نباید زودتر از تاریخ حواله فروش باشد !')</script>";
   return $flag;
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
 if(($pl1!=NULL)and($pl2!=NULL)and($pl4!=NULL)and((((!justNumber($pl1))or(strlen($pl1)>2)or(strlen($pl1)<2)))or((((!justNumber($pl2)) or (strlen($pl2)>3) or (strlen($pl2)<3))))or((((!justNumber($pl4))or(strlen($pl4)>2)or(strlen($pl4)<2))))))
 {
   $flag=false;
   echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;
 if(($pl3!=NULL)and((!validFarsi($pl3))))
 {
   $flag=false;
   echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;
 if((($n_tahvil==1)or($n_tahvil==2)or($n_tahvil==3))and($m_forush<=0))//بررسی مانده از فروش
 {$flag=false;
  echo"<script>window.alert('مقدار مانده از حواله فروش صفر است !امکان ثبت حواله جدید وجود ندارد')</script>";
  return $flag;
 }
 else $flag=true;
 if((($n_tahvil==4)or($n_tahvil==5)or($n_tahvil==6)or($n_tahvil==7)or($n_tahvil==9))and($m_jabejae<=0))//بررسی مانده از جابه جایی
 {$flag=false;
  echo"<script>window.alert('مقدار مانده از مجوز جابه جایی صفر است ! امکان ثبت حواله جدید وجود ندارد')</script>";
  return $flag;
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
   if(($noe_tahvil_bar==4)or($noe_tahvil_bar==5)or($noe_tahvil_bar==6)or($noe_tahvil_bar==7)or($noe_tahvil_bar==9))//جابه جایی
   {
    $h_code='';
	$mande_az_jabejae_again=$db->get_from_where("mande_az_jabejae","$mydatabase.mojavez_jabejae","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND shomare_jabejae='$shomare_jabejae'");   
    $meghdar_batele_j_again=batele_jabejae($shomare_jabejae,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear);
   }
   else//اگر نوع تحویل جابه جایی نباشد
   {
	    $shomare_jabejae='';
		/**اگر به فروش متصل نیستیم**/
	    if($_SESSION['mt_systemforush']==0)
	    {  
          $mande_az_forush_again=$db->get_from_where("mande_az_forush","$mydatabase.havale_forush","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND h_code='$h_code'");   
          $meghdar_batele_again=$db->get_from_where("SUM(meghdar_batele)","$mydatabase.ebtal","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND h_code='$h_code' AND deleted=0");   
		}
	    /**اگر به فروش متصل هستیم**/
	    if($_SESSION['mt_systemforush']==1)
	    {  
		   $mande_az_forush_again=$db->get_from_where("h_mande_havale","sell.dm_havale","h_id='$h_id'");   
           $meghdar_batele_again=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code='$h_code' AND his_id_province='$sell_id_ostan' AND his_l_code='$sell_id_anbar' And his_id_year='$sellYearId'");  
		   mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());
	    }
   }
   if(isPermitSave($shomare_havale_anbar,$tarikh_havale_anbar,$h_code,$shomare_jabejae,$chk_recieve,$noe_tahvil_bar,$bsk_id,$bsk_no,$shomare_baskul_h,$shomare_barname_h,$tarikh_barname_h,
                   $plak1,$plak2,$plak3,$plak4,$code_kala,$code_customer,$vazn_kamiyon_bar_h,$vazn_kamiyon_h,$noe_khodro,$h_reg_date,$mande_az_forush_again,$mande_az_jabejae_again,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear)) 
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
	 $insert_res=true;$log_i=true;
	 if ($chk_recieve=='on') $chk_recieve=1; else $chk_recieve=0;
	 if($shomare_polomp_h==NULL) $vaziyat_polomp_h='-1';//اگر شماره پلمپ را نزد وضعیت پلمپ هم خالی باشد
     $signiture_havale ="select sign_id from $mydatabase.mt_typesign where activate=1 and type_id=2 and code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' and ((expire_date='')or(expire_date is NULL)or(expire_date!='' and expire_date>='$tarikh_havale_anbar')) ORDER BY turn";
     $allsigniture_havale = $db->query($signiture_havale);
     $separatesigniture_havale='';
     while($row_sign1=$db->fetch_assoc($allsigniture_havale)) $separatesigniture_havale = $separatesigniture_havale . $row_sign1['sign_id'].';' ;
     $separatesigniture_havale=rtrim($separatesigniture_havale, ";");
     $signiture_khorooj ="select sign_id from $mydatabase.mt_typesign where activate=1 and type_id=4 and code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' and ((expire_date='')or(expire_date is NULL)or(expire_date!='' and expire_date>='$tarikh_havale_anbar')) ORDER BY turn";
     $allsigniture_khorooj = $db->query($signiture_khorooj);
     $separatesigniture_khorooj='';
     while($row_sign2=$db->fetch_assoc($allsigniture_khorooj)) $separatesigniture_khorooj = $separatesigniture_khorooj . $row_sign2['sign_id'].';' ;
     $separatesigniture_khorooj=rtrim($separatesigniture_khorooj, ";");
	 $insert_q=("INSERT INTO $mydatabase.$TableName
            (code_ostan,code_anbar,shomare_havale_anbar,year,tarikh_havale_anbar,IssuedTime,
			 h_code,h_id,shomare_jabejae,chk_recieve,noe_tahvil_bar,bsk_id,bsk_no,shomare_baskul_h,shomare_barname_h,tarikh_barname_h,
			 plak1,plak2,plak3,plak4,ranande_name,ranande_melicode,shomare_polomp_h,vaziyat_polomp_h,code_kala,code_customer,
			 vazn_kamiyon_bar_h,vazn_kamiyon_h,noe_khodro,mablagh_baskul,nerkh_bargiry_this,mablagh_bargiry,shomare_govahi_behdashti,tarikh_govahi_behdashti,code_bargiry,tozihat,deleted,status,signiture_havale,signiture_khorooj,shomare_darkhast)
             VALUES
			('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_havale_anbar','$mtActiveYear','$tarikh_havale_anbar','$IssuedTime',
			 '$h_code','$h_id','$shomare_jabejae','$chk_recieve','$noe_tahvil_bar','$bsk_id','$bsk_no','$shomare_baskul_h','$shomare_barname_h','$tarikh_barname_h',
			 '$plak1','$plak2','$plak3','$plak4','$ranande_name','$ranande_melicode','$shomare_polomp_h','$vaziyat_polomp_h','$code_kala','$code_customer',
			 '$vazn_kamiyon_bar_h','$vazn_kamiyon_h','$noe_khodro','$mablagh_baskul','$nerkh_bargiry_this','$mablagh_bargiry','$shomare_govahi_behdashti','$tarikh_govahi_behdashti','$code_bargiry','$tozihat',0,0,'$separatesigniture_havale','$separatesigniture_khorooj','$shomare_darkhast')");
	 $insert_res=mysql_query($insert_q);
     /*لاگ ها*/	  
	 $max_id=$db->get_from_where("MAX(id)","$mydatabase.$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
     $log_i=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
	 
    IF($insert_res AND $log_i)
    {
	   mysql_query("COMMIT");
	   IF(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); ELSE $code_a=$mt_gl_code_ostan;
       echo "<script>alert(' حواله شما به شماره".$code_a.$mt_gl_code_anbar.$shomare_havale_anbar." به ثبت رسید  . برای تکمیل حواله بخش جزئیات کالا را تکمیل نمایید' )</script>"; 
       echo "<script>window.location='havale.php?PageNo=1&RowPerPage=".$RowPerPage."&order=".$order."';</script>"; 
    }
    ELSE  
    {
       mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
       echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";
       echo "<script>window.location='havale.php?PageNo=1&RowPerPage=".$RowPerPage."&order=".$order."';</script>";	   
    }
    mysql_query('SET AUTOCOMMIT=1'); 
  }
}	
/*****************************************************************************/	
echo'	
'.$message.'
<br/>
<br/>
</form>
</body>
</html>';
?>