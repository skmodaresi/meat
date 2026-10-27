<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>window.location='mainpage.php';</script>";
$FileName="report_cardex_mojody.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
Function print_header()
{global $mt_gl_owner,$gl_name_sardkhane,$mt_gl_name_ostan,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName;
 echo'
    <tr>
     <td colspan="9">
      <table width="100%" border="1" align="center">
       <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr><td class="print_title_2"> انبار : '.$gl_name_sardkhane.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
      </table>
     </td>
    </tr> 
   	<tr>
     <td class=title colspan=9>وضعیت کاردکس موجودی انبار از تاریخ : '.$date1.' تا تاریخ : '.$date2.'
      <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	 </td>
	</tr>
   	<tr>
     <td class=title colspan=9> از کد کالای : '.$code_kala.' تا کد کالای : '.$code_kala2.'
	 </td>
	</tr>
	<tr class=table-title>
	 <td rowspan="2" width=7%>ردیف</td>
	 <td rowspan="2" width=8%>کد کالا</td>
	 <td rowspan="2" width=10%>نام کالا</td>
	 <td rowspan="2" width=15%>موجودی اول دوره</td>
	 <td rowspan="2" width=15%>وارده طی دوره</td>
	 <td rowspan="2" width=15%>صادره طی دوره</td>
	 <td colspan="2" width=15%>تعدیل</td>
	 <td rowspan="2" width=15%>مانده در پایان دوره</td>
	</tr>
    <tr class=table-title>
	 <td>اضافه</td>
	 <td>کسری</td>
	</tr>';
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>وضعیت کاردکس موجودی انبار</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
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
 function enterIE()
 {
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
 }
</script> 
</head>';
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">';
if(!$ok)
{
 echo'
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">وضعیت کاردکس موجودی انبار</td>	 
    </tr>';
    //if($mt_gl_code_ostan==-1)
    // if($_SESSION['role']==1)
	// { 
	 // echo'<tr class="tr1">
		   // <td align="left" > استان : </td><td align="right" >&nbsp;
		          // <!--<select name="global_code_ostan" class="text4" onChange="myform.submit();getAnbareOstan(this.value);">-->
		   // <select name="global_code_ostan" class="text4" onChange="myform.submit();">
		    // <option value=0>همه استانها</option>';
		    // $result_ostan = $db->query("SELECT * FROM ostan");
            // while($row_ostan=$db->fetch_assoc($result_ostan)) 
			// echo'<option value='.$row_ostan['code_ostan'].'>'.$row_ostan['name_ostan'].'</option>';
		    // echo'
		   // </select>';	   
		   // //&nbsp;'.listbox("global_code_ostan","$mt_gl_code_ostan","code_ostan","name_ostan","ostan","1=1","onChange='IndexForm.submit()' class='text4'").'&nbsp;&nbsp;</td>';	  	  	    
		   // if($global_code_ostan) echo'<td align="left" > انبار : </td><td align="right" width="30%"> &nbsp;'.listbox("global_code_anbar",$gl_code_sardkhane,"code_anbar","name_anbar","list_sardkhane","1=1 and code_ostan=$global_code_ostan","onChange='myform.submit()' class='text4'").'</td>';
	       // else echo'<td align="left" > انبار : </td><td align="right" > &nbsp; <select name="global_code_anbar" id="code_anbar" class="text4" ><option value="0">انتخاب کنيد</option></select></td>';	  	    
	  // echo'</tr>';
	  		           // //$result_anbar = $db->query("SELECT * FROM list_sardkhane WHERE code_ostan='$global_code_ostan'");
		           // // echo '<td align="left" width="20%"> انبار : </td>
		           // // <td align="right" width="30%"> &nbsp;<select name="global_code_anbar">';
		           // // $result_anbar = $db->query("SELECT * FROM list_sardkhane");
                   // // while($row_anbar=$db->fetch_assoc($result_anbar)){
                   // // echo'<option value='.$row_anbar['code_anbar'].'>'.$row_anbar['name_anbar'].'</option>';}
                   // // echo '</select></td>';
      // //echo'<td align="left" width="20%"> انبار : <td align="right" width="30%"><input type="text" class="textboxme2" maxlength="10" name="global_code_anbar" value="'.$global_code_anbar.'" onChange="myform.submit();"/></td></td>';	  	    
	  // // echo "<script>alert(".$mt_gl_code_ostan.");</script>";
	  // // echo "<script>alert(".$gl_code_sardkhane.");</script>";
    // }
	echo'
    <tr class="tr1">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
     <td align="left" width="10%">از کد کالا : </td>
     <td align="right" width="40%">&nbsp;<input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
     include ("img_helpkala.php");
	 echo'
	 </td>
	 <td align="left" width="10%">تا کد کالا : </td>
     <td align="right" width="40%">&nbsp;<input type="text" class="textboxme2" name="code_kala2" value="'.$code_kala2.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>
	 	   	   <img border="0" src="images/help.png" onClick="window.open(\'help_kala.php?inputName=code_kala2\',\'_blank\',\'width=400px,left=500px,top=100px,scrollbars=yes\')" title="جدول کد کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td>
	</tr>
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>  
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
    $Page=0;
    $Line=100;
    $Cntr=0;
    $RowPerPage=20;
    $dateCond="";
    $dateCond2="";
    $dateCond3="";
    $radif=1;
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
	if(!$code_kala)  $code_kala=$db->get_from_where("min(code_kala)","mojody_kala","code_ostan='$mt_gl_code_ostan' AND code_anbar='$gl_code_sardkhane' AND year='$mtActiveYear' AND deleted=0");//اگر کاربر از کد کالا را انتخاب نکرده بود
    if(!$code_kala2) $code_kala2=$db->get_from_where("max(code_kala)","mojody_kala","code_ostan='$mt_gl_code_ostan' AND code_anbar='$gl_code_sardkhane' AND year='$mtActiveYear' AND deleted=0");//اگر کاربر تا کد کالا را انتخاب نکرده بود
	/****************فیلترها روی گزارش******************/	
    if($code_kala) {$Condition.=" and code_kala>='$code_kala'";}//از کد کالا
    if($code_kala2){$Condition.=" and code_kala<='$code_kala2'";}//تا کد کالا
	/****************شروع نمایش گزارش*******************/	
	$q="SELECT *,
	   (SELECT name_kala FROM kala WHERE kala.code_kala=m.code_kala)nameKala,
	   (SELECT SUM(vazn_khales) FROM resid WHERE resid.code_kala=m.code_kala AND resid.code_ostan=m.code_ostan AND resid.code_anbar=m.code_anbar AND resid.year=m.year AND resid.deleted=0 AND resid.status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2')jameVarede,
	   (SELECT SUM(vazn_khales_h) FROM havale WHERE havale.code_kala=m.code_kala AND havale.code_ostan=m.code_ostan  AND havale.code_anbar=m.code_anbar AND havale.year=m.year AND havale.deleted=0 AND havale.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2')jameSadere,
	   (SELECT SUM(meghdar_tadil) FROM tadil_mojody WHERE tadil_mojody.code_kala=m.code_kala AND tadil_mojody.noe_tadil=1 AND tadil_mojody.code_ostan=m.code_ostan AND tadil_mojody.code_anbar=m.code_anbar AND tadil_mojody.year=m.year AND tadil_mojody.deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2')meghdarTadil_Ezafe,	 
	   (SELECT SUM(meghdar_tadil) FROM tadil_mojody WHERE tadil_mojody.code_kala=m.code_kala AND tadil_mojody.noe_tadil=2 AND tadil_mojody.code_ostan=m.code_ostan AND tadil_mojody.code_anbar=m.code_anbar AND tadil_mojody.year=m.year  AND tadil_mojody.deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2')meghdarTadil_Kasry
	   FROM mojody_kala m WHERE 1=1 $Condition AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$gl_code_sardkhane' AND year='$mtActiveYear' AND deleted=0";	 
	$res=$db->query($q);
	if(mysql_num_rows($res)>0)
    {
	 while($row=$db->fetch_assoc($res))
	 {if($Line>=$RowPerPage)
	  {	    
	   print_header();
	   $Line=0; 
      }
	  $Line++;
	  $mande_payane_dore=$row['mojody_aval']+$row['jameVarede']-$row['jameSadere']+$row['meghdarTadil_Ezafe']-$row['meghdarTadil_Kasry'];//مانده طی دوره انتخاب شده
      if($Cntr++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  echo'
	     <td>'.$radif++.'</td>
	     <td>'.$row['code_kala'].'</td>
	     <td>'.$row['nameKala'].'</td>
	     <td>'.virgul($row['mojody_aval']).'</td>
	     <td>'.virgul($row['jameVarede']).'</td>
	     <td>'.virgul($row['jameSadere']).'</td>
	     <td>'.virgul($row['meghdarTadil_Ezafe']).'</td>
	     <td>'.virgul($row['meghdarTadil_Kasry']).'</td>
	     <td>'.virgul($mande_payane_dore).'</td>';
	 }
	 echo'<!-- چاپ زیرنویس-->
      <tr class="print_footer">
       <td colspan="9">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$userNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
      </tr>';
	}
	 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
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