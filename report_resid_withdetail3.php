<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_resid_withdetail.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$columns='	
      <tr class="print_table-title2">
	   <td width="2%" rowspan="2">ردیف</td>
	   <td width="5%" rowspan="2">شماره رسید</td>
	   <td width="5%" rowspan="2">تاریخ رسید</td>
	   <td width="5%" rowspan="2">نوع تحویل بار</td>
	   <td width="5%" rowspan="2">کشتی/شرکت</td>
	   <td width="5%" rowspan="2">استان مبدأ</td>
	   <td width="5%" rowspan="2">سردخانه مبدأ/مبدأ بارگیری</td>
	   <td width="2%" rowspan="2">نوع تخلیه</td>
	   <td width="5%" rowspan="2">شرکت حمل کننده</td>
	   <td width="3%" rowspan="2">شماره بارنامه</td>
	   <td width="3%" rowspan="2">تاریخ بارنامه</td>
	   <td width="3%" rowspan="2">شماره کامیون</td>
	   <td width="4%" rowspan="2">پلاک خودرو</td>
	   <td width="4%" rowspan="2">شماره باسکول</td> 
	   <td width="3%" rowspan="2">وضعیت</td>
	   <td width="5%" rowspan="2">کالا</td>
	   <td width="5%" rowspan="2">تاریخ تولید</td>
	   <td width="5%" rowspan="2">وزن کارتن</td>
	   <td width="5%" rowspan="2">وزن مبدأ</td>
	   <td width="5%" rowspan="2">وزن نا</td>
	   <td width="10%" colspan="3">وزن مقصد</td>
	   <td width="5%" rowspan="2">کل کسری</td>
	   <td width="4%" rowspan="2">کسری غیرمجاز</td>
	   <td width="5%" rowspan="2">وزن اضافه</td>
	    <!--<td width="5%" rowspan="2">مبلغ کرایه مبدأ</td>
	    <td width="4%" rowspan="2">مبلغ جریمه</td>
	    <td width="5%" rowspan="2">مبلغ پرداختی</td>-->
	  </tr>
	  <tr class="print_table-title2">
	   <td>تعداد</td>
	   <td>وزن ناخالص</td>
	   <td>وزن خالص</td>
	  </tr>';
Function print_header()
{global $columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'
   <br/>   
   <table width="98%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
   	<tr>
     <td class="print_title_2">
	  گزارش براساس رسید سردخانه با جزئیات از تاریخ  : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
      <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	 </td>
	</tr>
   </table>
   <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">  
   '.$columns.'';
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>گزارش براساس رسید سردخانه با جزئیات</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
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
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepickerfrom").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true,
		});		
	    $("#barname_tarikh").datepicker({
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
		});
});
function enterIE()
{
  if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
  window.event.keyCode = 9;
}
<!-- نوع تحویل بار-->
 $( document ).ready(function() {
 $("[name=noe_tahvil_bar]").bind("change", function () {
    if(($(this).val() == 4)||($(this).val() == 5)) $("#ostananbar").slideDown("fast");
	else {$("#ostananbar").slideUp("fast");}
  });
 }); 
<!-- تعویض انبار با انتخاب استان-->
function getAnbareOstan(code_ostan)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_re_resid.php",{codeOSTAN1:code_ostan},function(data){$("#anbar_mabda").html(data);});
  $("#loading").fadeOut("fast");		
}
<!-- تعویض اطلاعات شماره سفر با انتخاب کشتی-->
function getShomareSafar(code_skk)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_re_resid.php",{codeKESHTY:code_skk},function(data){$("[name=id_safar]").html(data);});
  $("#loading").fadeOut("fast");		
}
</script> 
</head>';
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
    <img src="images/loading.gif" id="loading" class="loading_img"/>';
if(!$MaxLines)$MaxLines=10;
if(!$ok)
{
echo'
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td colspan="4" class="title">گزارش براساس رسید سردخانه با جزئیات</td>	 
    </tr>
	<tr class="tr1">	
     <td align="left" width="20%"> از تاریخ :&nbsp;</td><td align="right" width="30%"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td>
     <td align="left" width="20%"> تا تاریخ :&nbsp;</td><td align="right" width="30%"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">';
	 //اضافه کردن صفر پشت کد استان		
	 if(strlen($mt_gl_code_ostan)==1) {$code_a=make_pattern($mt_gl_code_ostan,2);}
     else{$code_a=$mt_gl_code_ostan;}	
    echo'
	 <td align="left"> از شماره رسید :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shomare1" value="'.$shomare1.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
     <td align="left"> تا شماره رسید :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shomare2" value="'.$shomare2.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
	</tr>
	<tr class="tr1">
     <td align="left"> کد کالا :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	 include ("img_helpkala.php");
	 echo'</td>
	 <td align="left" > کد کشور :&nbsp;</td>
	 <td align="right"><input class="textboxme2" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);" style="width:50px"/>&nbsp;';
     include ("img_helpkeshvar.php");
	 echo'
	 </td>
	</tr>
    <tr class="tr1">	
	 <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>&nbsp;';
     include('img_helptolid.php');
     echo'
     </td>
	 <td align="left"> کد کارتن / قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>&nbsp;';
	  include('img_helpkartonghooti.php');
	 echo'
	 </td>
	</tr>
	<tr class="tr1">	   
     <td align="left"> سال تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	 <td align="left"> ماه تولید :&nbsp;</td><td align="right">'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='text4'").'
	</tr>
	<tr class="tr1">
	 <td align="left"> روز تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
     <td align="left"> نام زیرانبار :&nbsp;</td><td align="right">'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar ORDER BY name_ziranbar","class='text4'","").'</td>
	</tr>
	<tr class="tr1">	
	 <td align="left"> کد کشتی / شرکت :&nbsp;</td>
	 <td align="right"><input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onkeypress="return isNumber(event)" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)" style="width:50px;"/>
	 <input type="hidden" name="name_skk" value="name_skk"/>&nbsp;';
	 include("img_helpskk.php");
	 echo'
	 <td align="left"> شماره سفر :&nbsp;</td><td align="right"><select name="id_safar" class="text4"><option value="0">انتخاب کنيد</option></select></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","","class='text4'").'</td>
     <td align="left"> نوع تخلیه :&nbsp;</td><td align="right">'.listbox("code_takhlie",$code_takhlie,"code_takhlie","sharh_takhlie","takhlie","","class='text4'","").'</td>
	</tr>		   
	<tr class="tr1">	
     <td align="left"> شرکت حمل کننده :&nbsp;</td><td align="right">'.listbox("code_peymankar_haml",$code_peymankar_haml,"code_peymankar_haml","name_peymankar_haml","peymankar_haml","","class='text4'","").'</td>
     <td align="left"> وضعیت رسید :&nbsp;</td>
	 <td align="right">'.static_listbox("status","-1","statusFormArr",1,"class='text4' ").'</td>						 
    </tr>
	<tr class="tr1">	
	 <td align="left"> مبدأ بارگيری :&nbsp;</td><td align="right" >'.listbox("code_mabda",$code_mabda,"code_mabda","name_mabda","mabady_vorudy","1=1 ORDER BY name_mabda ASC","class='text4'","").'</td>
	 <td align="left"> نوع تحویل بار :&nbsp;</td><td align="right" >'.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr",1,"class='text4'").'</td>
    </tr>
    <tr class="tr1">	
     <td align="left"> شماره بارنامه :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="barname_no" value="'.$barname_no.'"/></td>
     <td align="left"> تاریخ بارنامه :&nbsp;</td><td align="right"><input type="text" class="textboxme2" id="barname_tarikh" name="barname_tarikh" value="'.$barname_tarikh.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> شماره کاميون :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="kamion_no" value="'.$kamion_no.'"/></td>
	 <td align="left"> پلاک خودرو : </td>
	 <td align="right">&nbsp;
	 		   <sup>ایران</sup>
			   <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/> |
			   <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" style="width:30px;"/>
			   <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" style="width:20px;"/>
			   <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/>
	 </td>
	</tr>
	<tr class="tr1">
     <td align="left"> شماره باسکول :&nbsp;</td><td align="right"><input type="text" class="textboxme2"  name="shomare_baskul" value="'.$shomare_baskul.'"/></td>
     <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1" id="ostananbar" style="display:none;">
      <td align="left"> نام استان مبدأ :&nbsp;</td><td align="right">'.listbox("code_ostan_mabda",$code_ostan_mabda,"code_ostan","name_ostan","ostan","1=1 ORDER BY name_ostan ASC","onchange=getAnbareOstan(this.value) class='text4'","").'</td>
      <td align="left"> نام سردخانه مبدأ :&nbsp;</td><td align="right"><select name="code_anbar_mabda" id="anbar_mabda" class="text4"><option value="0">انتخاب کنيد</option></select></td>
    </tr>	
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    
   </table>
  </td>
 </tr>
</table>';
}
else
{
    $Condition_resid="";
	if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
	{
	  $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
	} 
    //اگر کاربر تاریخ دوم را وارد نکرده بود
	if(!$date2)
	{
	 $today=AsLDate($yymmdd); 
 	 $end_date_session=$db->get_from_where("end_to","mt_docs","year='$mtActiveYear'");
	 if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
	} 
    /****************فیلترها روی گزارش******************/
    if ($date1)$Condition_resid.=" and r.tarikh_resid>='$date1'";//از تاریخ	        
    if ($date2)$Condition_resid.=" and r.tarikh_resid<='$date2'";//تا تاریخ                 				 
    if ($shomare1)//از شماره رسید
    {
  	 if(strlen($shomare1)!=5) $shomare1=make_pattern($shomare1,5);
     $Condition_resid.=" and r.shomare_resid>='$shomare1'";      
    }
    if ($shomare2)//تا شماره رسید
    {
     if(strlen($shomare2)!=5) $shomare2=make_pattern($shomare2,5);
	 $Condition_resid.=" and r.shomare_resid<='$shomare2'";
    }
    if ($code_kala)//کد کالا  
	{$Condition_r_k_d.=" and r_k_d.code_kala='$code_kala'";   
     $Condition_r_d.=" and r_d.code_kala='$code_kala'";
    }    
    if ($code_keshvar)	//کد کشور 
	{$Condition_r_k_d.=" and r_k_d.code_keshvar='$code_keshvar'";
	 $Condition_r_d.=" and r_d.code_keshvar='$code_keshvar'";
	}
    if ($code_tolidkonande)//کد تولیدکننده  
	{$Condition_r_k_d.=" and r_k_d.code_tolidkonande='$code_tolidkonande'";    
	 $Condition_r_d.=" and r_d.code_tolidkonande='$code_tolidkonande'";
	} 
    if ($code_karton) $Condition_r_k_d.=" and r_k_d.code_karton='$code_karton'";//کد کارتن     
    if ($sal_tolid_shamsi) $Condition_r_k_d.=" and r_k_d.sal_tolid_shamsi='$sal_tolid_shamsi'";//سال تولید شمسی 
    if ($mah_tolid_shamsi) $Condition_r_k_d.=" and r_k_d.mah_tolid_shamsi='$mah_tolid_shamsi'";//ماه تولید شمسی 
    if ($rouz_tolid_shamsi) $Condition_r_k_d.=" and r_k_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";//روز تولید شمسی 
    if ($code_ziranbar) $Condition_r_k_d.=" and r_k_d.code_ziranbar='$code_ziranbar'";//زیرانبار 
    if ($code_skk) $Condition_resid.=" and r.code_skk='$code_skk'";//کد کشتی 
	if ($id_safar) $Condition_resid.=" and r.id_safar='$id_safar'";//شماره سفر 
	if ($code_bastebandy) $Condition_resid.=" and r.bastebandy.code_bastebandy='$code_bastebandy'";//نوع بسته بندی    
    if ($code_peymankar_haml) $Condition_resid.=" and r.code_peymankar_haml='$code_peymankar_haml'";//کد پیمانکار 
	if (isset($status)and($status=='0')) $Condition_resid.=" and r.status=0";//وضعیت رسید 	 
    if (isset($status)and($status=='1')) $Condition_resid.=" and r.status=1";//وضعیت رسید 	 
    if (isset($status) and ($status=='2')) $Condition_resid.="";//وضعیت رسید
    if ($barname_no) $Condition_resid.=" and r.barname_no='$barname_no'";//شماره بارنامه
	if ($barname_tarikh) $Condition_resid.=" and r.barname_tarikh='$barname_tarikh'";//تاریخ بارنامه
	if ($noe_tahvil_bar) $Condition_resid.=" and r.noe_tahvil_bar='$noe_tahvil_bar'";//نوع تحویل بار
	if ($code_mabda) $Condition_resid.=" and r.code_mabda='$code_mabda'";//مبدأ بارگیری
    if ($code_ostan_mabda) $Condition_resid.=" and r.code_ostan_mabda='$code_ostan_mabda'";//استان مبدأ
    if ($code_anbar_mabda) $Condition_resid.=" and r.code_anbar_mabda='$code_anbar_mabda'";//انبار مبدأ
	if ($code_takhlie) $Condition_resid.=" and r.code_takhlie='$code_takhlie'";//نوع تخلیه
	if ($kamion_no) $Condition_resid.=" and r.kamion_no='$kamion_no'";//شماره کامیون 
	if ($plak1) $Condition_resid.=" and r.plak1='$plak1'";//پلاک خودرو 
    if ($plak2) $Condition_resid.=" and r.plak2='$plak2'";//پلاک خودرو 
    if ($plak3) $Condition_resid.=" and r.plak3='$plak3'";//پلاک خودرو 
    if ($plak4) $Condition_resid.=" and r.plak4='$plak4'";//پلاک خودرو 
	if ($shomare_baskul) $Condition_resid.=" and r.shomare_baskul='$shomare_baskul'";//شماره باسکول 
	/****************شروع نمایش گزارش*******************/				
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	$q="SELECT r.*,kala.name_kala,kala.code_bastebandy,bastebandy.sharh_bastebandy,mt_skk.name_skk,takhlie.sharh_takhlie,mabady_vorudy.name_mabda,peymankar_haml.name_peymankar_haml,ostan.name_ostan,list_sardkhane.name_anbar,list_sardkhane_detail.name_ziranbar,r_d.vazn_mabda_r_d,r_d.kasry_mojaz_r_d,r_d.fee_this,r_d.nerkh_takhlie_this,r_k_d.code_kala,r_k_d.vazn_karton_this,r_k_d.sal_tolid_shamsi,r_k_d.mah_tolid_shamsi,r_k_d.rouz_tolid_shamsi,r_k_d.tedad_karton_r_d_sub,r_k_d.vazn_nakhales_r_d_sub,r_k_d.vazn_khales_r_d_sub,
	   (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year $Condition_r_k_d)tedadKarton,
	   (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year $Condition_r_k_d)vaznNaKhales,
	   (SELECT SUM(vazn_khales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year $Condition_r_k_d)vaznKhales,
	   (SELECT SUM(vazn_mabda_r_d) FROM resid_detail r_d WHERE r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year $Condition_r_d)vaznMabda
		FROM resid AS r 
	    LEFT OUTER JOIN resid_detail AS r_d ON r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year
        LEFT OUTER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande 
		LEFT JOIN kala ON r_d.code_kala=kala.code_kala    
        LEFT JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy    
        LEFT JOIN mt_skk ON mt_skk.code_skk=r.code_skk    
        LEFT JOIN takhlie ON takhlie.code_takhlie=r.code_takhlie    
        LEFT JOIN mabady_vorudy ON mabady_vorudy.code_mabda=r.code_mabda    
        LEFT JOIN peymankar_haml ON peymankar_haml.code_peymankar_haml=r.code_peymankar_haml    
        LEFT JOIN ostan ON ostan.code_ostan=r.code_ostan_mabda    
        LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar_mabda AND list_sardkhane.code_ostan=r.code_ostan_mabda    
        LEFT JOIN list_sardkhane_detail ON list_sardkhane_detail.code_ziranbar=r_k_d.code_ziranbar AND list_sardkhane_detail.code_ostan=r_k_d.code_ostan AND list_sardkhane_detail.code_anbar=r_k_d.code_anbar    
		WHERE 1=1 $Condition_resid $Condition_r_k_d AND r.code_ostan='$mt_gl_code_ostan' AND r.code_anbar='$mt_gl_code_anbar' AND r.year='$mtActiveYear' AND r.deleted=0 ORDER BY r.tarikh_resid,r.shomare_resid";				
	//echo $q;
	$res=$db->query($q);
    $cntr =mysql_num_rows($res);
	$myAnbarName=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");//نام انبار خودمان
	if(mysql_num_rows($res)>0)
	{		
	 echo'
     <br/>
     <table width="98%" border="1" align="center">
      <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
      <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr> 
      <tr>
       <td class="print_title_2">
   	   <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
   	    گزارش براساس رسید سردخانه از تاریخ  : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
        <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
   	   </td>
   	  </tr>
     </table>';
	 /*سطر نمایش فیلترها*/
	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
     else $code_a=$mt_gl_code_ostan;
	 if($shomare1) $filter_string.=' از شماره رسید : '.$code_a.$mt_gl_code_anbar.$shomare1.'&nbsp;';    
	 if($shomare2) $filter_string.=' تا شماره رسید : '.$code_a.$mt_gl_code_anbar.$shomare2.'&nbsp;';    
	 if($code_kala) {$nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
	 if($code_keshvar) {$nameKeshvar=$db->get_from_where("name_keshvar","keshvar","code_keshvar='$code_keshvar'"); $filter_string.=' کشور : '.$nameKeshvar.'&nbsp;';}     
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_karton) $filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';    
	 if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}     
	 if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if($mah_tolid_shamsi) {$filter_string.=' ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
	 if($code_skk) {$nameKeshty=$db->get_from_where("name_skk","mt_skk","code_skk='$code_skk'");$filter_string.=' نام کشتی/شرکت : '.$nameKeshty.'&nbsp;';}     
	 if($id_safar) {$shomareSafar=$db->get_from_where("shomare_safar","shomare_safar","code_skk='$code_skk' AND id_safar='$id_safar'"); $filter_string.=' شماره سفر : '.$shomareSafar.'&nbsp;';}     
	 if($code_bastebandy) {$sharhBastebandy=$db->get_from_where("sharh_bastebandy","bastebandy","code_bastebandy='$code_bastebandy'"); $filter_string.=' بسته بندی : '.$sharhBastebandy.'&nbsp;';}     
	 if($code_peymankar_haml) {$sharhPeymankar=$db->get_from_where("name_peymankar_haml","peymankar_haml","code_peymankar_haml='$code_peymankar_haml'"); $filter_string.=' بسته بندی : '.$sharhPeymankar.'&nbsp;';}     
	 if($status!='-1')
	 { 
	   if($status=='0') $filter_string.=' وضعیت رسید : '.$statusFormArr[$status].'&nbsp;';    
	   if($status=='1') $filter_string.=' وضعیت رسید : '.$statusFormArr[$status].'&nbsp;';    
     }
	 if($barname_no) $filter_string.=' شماره بارنامه : '.$barname_no.'&nbsp;';
	 if($barname_tarikh) $filter_string.=' تاریخ بارنامه : '.$barname_tarikh.'&nbsp;';
	 if($kamion_no) $filter_string.=' شماره کامیون : '.$kamion_no.'&nbsp;';
	 if(($plak1)or($plak2)or($plak3)or($plak4)) 
	 {
	  $filter_string.=' پلاک خودرو :&nbsp;';
	  $filter_string.='  '.$plak1.'&nbsp;';
	  $filter_string.='  '.$plak2.'&nbsp;';
	  $filter_string.='  '.$plak3.'&nbsp;';
	  $filter_string.='  '.$plak4.'&nbsp;';}
	 if($shomare_baskul!='') $filter_string.=' شماره باسکول : '.$shomare_baskul.'&nbsp;';
	 if($code_takhlie) {$sharhTakhlie=$db->get_from_where("sharh_takhlie","takhlie","code_takhlie='$code_takhlie'"); $filter_string.=' نوع تخلیه : '.$sharhTakhlie.'&nbsp;';}     
	 if($noe_tahvil_bar) $filter_string.=' نوع تحویل بار : '.$tahvilbarArr[$noe_tahvil_bar].'&nbsp;';    
	 if($code_mabda) {$nameMabda=$db->get_from_where("name_mabda","mabady_vorudy","code_mabda='$code_mabda'");$filter_string.=' مبدأ بارگیری : '.$nameMabda.'&nbsp;';}     
	 if($code_ostan_mabda) {$nameOstanMabda=$db->get_from_where("name_ostan","ostan","code_ostan='$code_ostan_mabda'"); $filter_string.=' استان مبدأ : '.$nameOstanMabda.'&nbsp;';}     
     if($code_anbar_mabda) {$nameAnbarMabda=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$code_ostan_mabda' AND code_anbar='$code_anbar_mabda'"); $filter_string.=' انبارمبدأ : '.$nameAnbarMabda.'&nbsp;';}     
	 if(($shomare1)or($shomare2)or($code_kala)or($code_keshvar)or($code_tolidkonande)or($code_karton)or($code_ziranbar)or($sal_tolid_shamsi)or($mah_tolid_shamsi)or($rouz_tolid_shamsi)or($code_skk)or($id_safar)or($code_bastebandy)or($code_peymankar_haml)or($status!='-1')or($barname_no)or($barname_tarikh)or($kamion_no)or($plak1)or($plak2)or($plak3)or($plak4)or($shomare_baskul!='')or($code_takhlie)or($noe_tahvil_bar)or($code_mabda)or($code_ostan_mabda)or($code_anbar_mabda))
	 {echo'<table class="filter_text" width="98%" border="0" align="center"><tr><td>فیلتر شده براساس : '.$filter_string.'</td></tr></table>';}
	 
	 echo
	 '<table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	 '.$columns.'';   
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd_small">';
      else echo'<tr class="print_table-even_small">';
	  //اضافه کردن صفر پشت کد استان
	  if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
      else $code_a=$row['code_ostan'];
      echo'
	    <td>'.$radif++.'</td>
	    <td>'.$code_a.$row['code_anbar'].$row['shomare_resid'].'</td>
	    <td>'.$row['tarikh_resid'].'</td>
	    <td>'.$tahvilbarArr[$row['noe_tahvil_bar']].'</td>
        <td>'.$row['name_skk'].'</td>
	    <td>'.$row['name_ostan'].'</td>
	    <td>';if(($row['noe_tahvil_bar']==4)or($row['noe_tahvil_bar']==5)) echo''.$row['name_anbar'].''; else echo''.$row['name_mabda'].'';echo'</td>
	    <td>'.$row['sharh_takhlie'].'</td>
	    <td>'.$row['name_peymankar_haml'].'</td>
	    <td>'.$row['barname_no'].'</td>
	    <td>'.$row['barname_tarikh'].'</td>
	    <td>'.$row['kamion_no'].'</td>
		<td dir="rtl">'.$row['plak2'].'-'.$row['plak1'].''.$row['plak3'].''.$row['plak4'].'</td>
	    <td>'.$row['shomare_baskul'].'</td>
	    <td>'.$statusFormArr[$row['status']].'</td>
		<td>'.$row['name_kala'].'</td>
	    <td>'.$row['rouz_tolid_shamsi'].''.$mahshamsiArr[$row['mah_tolid_shamsi']].''.$row['sal_tolid_shamsi'].'</td>
		<td>'.$row['vazn_karton_this'].'</td>';
		//اگر روباری بود وزن مبدأ همان وزن ناخالص است
		$vaznNaKhales_r_d=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail","shomare_resid='".$row['shomare_resid']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND code_kala='".$row['code_kala']."' AND resid_deleted=0 AND status=0");
		if($row['noe_tahvil_bar']==2)echo'<td>'.round($vaznNaKhales_r_d,3).'</td>';
		else echo'<td>'.($row['vazn_mabda_r_d']).'</td>';
		echo'
		<td>'.round($vaznNaKhales_r_d,3).'</td>
		<td>'.virgul($row['tedad_karton_r_d_sub']).'</td>
		<td>'.round($row['vazn_nakhales_r_d_sub'],3).'</td>
		<td>'.round($row['vazn_khales_r_d_sub'],3).'</td>';

		$kasry_kol_r_d=$row['vazn_mabda_r_d']-$vaznNaKhales_r_d;//کل کسری این کالا
		//$kasry_kol_r_d=$row['vazn_mabda_r_d']-$row['vazn_nakhales_r_d_sub'];//کل کسری این کالا
	    
		if($kasry_kol_r_d<0) $kasry_kol_r_d=0;//اگر جواب منفی شد
	    if($kasry_kol_r_d==$row['vazn_mabda_r_d'])//اگر هنوز وزن ناخالص را ثبت نکرده ایم
	    { 
	    	 $kasry_kol_r_d=0;
	         $kasry_gheyremojaz_r_d=0;
 	    }
	    $kasry_gheyremojaz_r_d=$kasry_kol_r_d-$row['kasry_mojaz_r_d'];//کسری غیرمجاز این کالا
	    if($kasry_gheyremojaz_r_d<0) $kasry_gheyremojaz_r_d=0;//اگر جواب منفی شد
		$vazn_ezafe_r_d=$vaznNaKhales_r_d-$row['vazn_mabda_r_d'];//وزن اضافه
		//$vazn_ezafe_r_d=$row['vazn_nakhales_r_d_sub']-$row['vazn_mabda_r_d'];//وزن اضافه
	    if($vazn_ezafe_r_d<0) $vazn_ezafe_r_d=0;//اگر جواب منفی شد
	    

		echo'
		<td>'.($kasry_kol_r_d).'</td>
		<td>'.($kasry_gheyremojaz_r_d).'</td>
		<td>'.($vazn_ezafe_r_d).'</td>';
		
		//اطلاعات از جزئیات
	    // $q_d="SELECT *,
             // (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_nakhales_r_d,				  
             // (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) tedad_karton_r_d,		
             // (SELECT SUM(sum_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) sum_karton_r_d		
		     // From resid_detail r_d WHERE 1=1 $Condition_r_d AND r_d.shomare_resid='".$row['shomare_resid']."' AND r_d.code_ostan='".$row['code_ostan']."' AND r_d.code_anbar='".$row['code_anbar']."' AND r_d.year='".$row['year']."'";	
		// $res_d =$db->query($q_d);
		// if(mysql_num_rows($res_d)>0)//اگر جزئیات کالا را پر کرده است
	    // {
		 	// $kasry_kol_r=0;
	        // $kasry_mojaz_r=0;
	        // $kasry_gheyremojaz_r=0;
	        // $vazn_ezafe_r=0;
	        // $mablagh_jarimekasry_r=0;
	        // $mablagh_takhlie_r=0;
			// $mablagh_pardakhty=0;
	     // while($row_d=$db->fetch_assoc($res_d))
	     // {
	      // $mablagh_jarimekasry_r_d=$kasry_gheyremojaz_r_d*$row_d['fee_this'];//مبلغ جریمه کسری
	      // $mablagh_takhlie_r_d=$row_d['nerkh_takhlie_this'];//مبلغ تخلیه
		  // //اگر نوع تحویل بار روباری نباشد
		  // if(($row['noe_tahvil_bar']!=2)and($row['noe_tahvil_bar']!=5))
		  // {
	        // $kasry_kol_r+=$kasry_kol_r_d;
	        // $kasry_mojaz_r+=$row_d['kasry_mojaz_r_d'];
	        // $kasry_gheyremojaz_r+=$kasry_gheyremojaz_r_d;
	        // $vazn_ezafe_r+=$vazn_ezafe_r_d;
	        // if($row['noe_pardakht']==2)//اگر نوع پرداخت کرایه در مقصد بود
            // {
			 // $mablagh_jarimekasry_r+=$mablagh_jarimekasry_r_d;
	         // $mablagh_takhlie_r+=$mablagh_takhlie_r_d;
			// }
		  // }
		 // }
		// }
		 // $mablagh_pardakhty=$row['mablagh_kerayemabda']-$mablagh_jarimekasry_r+$row['mablagh_haghetavaghof']-$mablagh_takhlie_r;
	     // if($mablagh_pardakhty<0) $mablagh_pardakhty=0;
		
		// echo'
	    // <td>'.virgul($row['mablagh_kerayemabda']).'</td>
	    // <td>'.virgul($mablagh_jarimekasry_r).'</td>
	    // <td>'.virgul($mablagh_pardakhty).'</td>';   	
	  echo'
	  </tr>';
	  if($line>=$MaxLines && $i <$cntr) 
	  {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
	  }	
	  /****************محاسبه مجموع مقادیر در سطر آخر*******************/ 
	 //اگر روباری بود وزن مبدأ همان وزن ناخالص است
	  // if($row['noe_tahvil_bar']==2) $sum_vazn_mabda+=$row['vaznNaKhales'];
      // else $sum_vazn_mabda+=$row['vaznMabda'];  
	  // $sum_tedad_karton+=$row['tedadKarton'];
	  // $sum_vazn_nakhales+=$row['vaznNaKhales'];
	  // $sum_vazn_khales+=$row['vaznKhales'];
	  // $sum_kasry_kol+=$kasry_kol_r;
	  // $sum_kasry_gheyremojaz+=$kasry_gheyremojaz_r;
	  // $sum_vazn_ezafe+=$vazn_ezafe_r;
	  // $sum_mablagh_kerayemabda+=$row['mablagh_kerayemabda'];
	  // $sum_mablagh_jarimekasry+=$mablagh_jarimekasry_r;
	  // $sum_mablagh_pardakhty+=$mablagh_pardakhty;
	  
	  //اگر روباری بود وزن مبدأ همان وزن ناخالص است
	  if($row['noe_tahvil_bar']==2) $sum_vazn_mabda+=$row['vaznNaKhales'];
      else $sum_vazn_mabda+=$row['vaznMabda'];  
	  if($row['status']==0)
	  {
	   // $sum_tedad_karton+=$row['tedadKarton'];
	   // $sum_vazn_nakhales+=$row['vaznNaKhales'];
	   // $sum_vazn_khales+=$row['vaznKhales'];
	   $sum_tedad_karton+=$row['tedad_karton_r_d_sub'];
	   $sum_vazn_nakhales+=$row['vazn_nakhales_r_d_sub'];
	   $sum_vazn_khales+=$row['vazn_khales_r_d_sub'];
	  }
	  $sum_kasry_kol+=$kasry_kol_r;
	  $sum_kasry_gheyremojaz+=$kasry_gheyremojaz_r;
	  $sum_vazn_ezafe+=$vazn_ezafe_r;

	  
	  
	 }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="19">جمع مقادیر</td>
	   <!--<td>'.($sum_vazn_mabda).'</td>-->
	   <td>'.virgul($sum_tedad_karton).'</td>
	   <td>'.($sum_vazn_nakhales).'</td>
	   <td>'.($sum_vazn_khales).'</td>
	   <td></td>
	   <td></td>
	   <td></td>
	  </tr>
	 </table>';
 echo'
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
 <table width="98%" border="1" align="center">
    <tr class="print_footer">
     <td>&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
    </tr>
 </table>';	 	 
}	
 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}//END else
echo'
</form>
</body>
</html>';	
?>