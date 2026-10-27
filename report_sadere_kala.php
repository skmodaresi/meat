<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_sadere_kala.php";
//if($code_kala) $code_kala=make_pattern($code_kala,3);
Function print_header()
{global $code_kala,$code_anbar,$date1,$date2,$FileName,$nameKala;
 echo'
   	<tr>
     <td class=title colspan=6>گزارش مقادیر صادره  '.$nameKala.' از تاریخ : '.$date1.' تا تاریخ : '.$date2.'
      <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	 </td>
	</tr>
	<tr class=table-title>
	 <td width=20%>نام انبار</td>
	 <td width=20%>نام مشتری</td>
	 <td width=20%>شماره حواله فروش</td>
	 <td width=20%>وزن تحویلی</td>
	 <td width=20%>تعداد حواله انبار</td>
	</tr>';
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>گزارش مقادیر صادره از هر کالا</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   $("input").not( $(":button") ).keypress(function (evt){
    if (evt.keyCode == 13) {
    iname = $(this).val();
     if (iname !== "Submit"){
     var fields = $(this).parents("form:eq(0),body").find("button, input, textarea, select");
     <!--var fields = $("input:text,input:checkbox,select,textarea");-->
	 var index = fields.index( this );
     if ( index > -1 && ( index + 1 ) < fields.length ) {
      fields.eq( index + 1 ).focus();}
     return false;
     }
    }
   });
});
$(function(){	    
    $("#datepickerfrom").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true}
	  );
});
function enterCodeKala(code_kala)
{
  $("#loading").fadeIn("fast");
  $.post("ajax.php",{codeKALA_Error:code_kala},function(data){$("#codeK_Error").html(data);});
  $("#loading").fadeOut("fast");				
}
</script> 
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform">
<div align="center">
<table width="90%" height="100%" align="center" cellpadding="0" cellspacing="0">
<img src="images/loading.gif" id="loading" class="loading_img"/>';
if(!$ok)
{
 echo'
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">گزارش مقادیر صادره از هر کالا</td>	 
    </tr>
    <tr class="tr1">
     <td align="left" width="10%"><span class="star">*</span> کد کالا : </td>
     <td align="right" width="40%">&nbsp;<input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>
	 	   	   <img border="0" src="images/help.png" onClick="window.open(\'help_kala.php\',\'_blank\',\'width=400px,left=20px,scrollbars=yes\')" title="جدول کد کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
			   <span style="color:red" id="codeK_Error">&nbsp;</span></td>
	<td width="10%">&nbsp;</td><td width="40%">&nbsp;</td>
	</tr>
    <tr class="tr1">	
	 <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" name="date1" id="datepickerfrom" value="'.$date1.'" maxlength="10"/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" name="date2" id="datepickerto" value="'.$date2.'" maxlength="10"/></td>
	</tr>
    <tr class="tr1">	
	 <td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>
	</tr> 
    
   </table>
   </div>
  </td>
 </tr>';
}
else
{
 echo'
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
   if(!$code_kala){echo"<script>alert('لطفاً کد کالا را وارد کنید !')</script>";
                   echo"<script>window.location='$FileName';</script>";}
   $nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'");
   $Page=0;
   $Line=100;
   $Cntr=0;
   $RowPerPage=20;
   $dateCond="";
   if (!$date1) $date1=$db->get_from_where("min(h_reg_date)","havale_forush","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0"); //اگر کاربر تاریخ اول را وارد نکرده بود
   if (!$date2) $date2=$db->get_from_where("max(h_reg_date)","havale_forush","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0"); //اگر کاربر تاریخ دوم را وارد نکرده بود
   /****************فیلترها روی  گزارش*******************/	
   if ($date1) $dateCond.=" and h_reg_date>='$date1'";
   if ($date2) $dateCond.=" and h_reg_date<='$date2'";   
   /****************شروع نمایش گزارش*******************/	
   // $q2="SELECT *,
        // (SELECT name_anbar FROM list_sardkhane WHERE list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan='$mt_gl_code_ostan')nameAnbar,
        // (SELECT name_customer FROM moshtary WHERE moshtary.code_customer=h.code_customer)nameMoshtary
        // FROM havale AS h WHERE code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0 AND status=0";   
   //$code_kala=make_pattern($code_kala,3);
   $q="SELECT *,
        (SELECT name_anbar FROM list_sardkhane WHERE list_sardkhane.code_anbar=h_f.code_anbar AND list_sardkhane.code_ostan='$mt_gl_code_ostan')nameAnbar,
        (SELECT name_customer FROM moshtary WHERE moshtary.code_customer=h_f.code_customer)nameMoshtary
        FROM havale_forush AS h_f WHERE code_kala='$code_kala' $dateCond AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0";
   //$nameMoshtary=$db->get_from_where("name_customer","moshtary","code_customer='$row['code_customer']'");	 	   
   $res=$db->query($q);
    while($row=$db->fetch_assoc($res))
	{if ($Line>=$RowPerPage)
	 {           
	  print_header();
	  $Line=0; 
     }
	 $Line++;
	 //محاسبه مقدار تحویلی
     $meghdar_tahvily=$db->get_from_where("SUM(vazn_khales_h)","havale","h_code='".$row['h_code']."' AND deleted=0 AND status=0");
     $tedad_havale=$db->get_from_where("count(*)","havale","h_code='".$row['h_code']."' AND deleted=0 AND status=0");
     if($Cntr++%2)echo'<tr class="print_table-odd">';
     else echo'<tr class="print_table-even">';      
	 echo'
	    <td>'.$row['nameAnbar'].'</td>
	    <td>'.$row['nameMoshtary'].'</td>
	    <td>'.$row['h_code'].'</td>
	    <td>'.virgul($meghdar_tahvily).'</td>
	    <td>'.$tedad_havale.'</td>';
		// }
	}
	echo'
	 </tr>
    </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
}
echo'	
</table>
</div>
</form>
</body>
</html>';	
?>