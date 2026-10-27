<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_tajamoe_gharardad.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش تجمعی قراردادها';
/****************هدر******************/
$columns='
	   <tr class="print_table-title2">
	    <td width=5%>ردیف</td>
	    <td width=10%>استان</td>
	    <td width=10%>تعداد قرارداد</td>
	    <td width="10%">محموع مقادیر قرارداد</td>
	    <td width="10%">تحویلی از قرارداد</td>
	    <td width="10%">مانده از قرارداد</td>
	   </tr>';
Function print_header()
{global $titr,$columns,$name_ostan_mabda,$group_name,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'
   <br/>
   <table width="98%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2">'.$titr.'</td></tr>
	<tr>
     <td class="print_title_2"> از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
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
<title>'.$titr.'</title>
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
	    changeYear: true}
	  );
});
function enterField(shomare_eblagh)
{
  $("#loading").fadeIn("fast");
  $.post("ajax.php",{shomare_Error:shomare_eblagh},function(data){$("#Fill").html(data);});
  $("#loading").fadeOut("fast");				
}
</script> 
</head>';
/****************فیلترها روی گزارش******************/
/******************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $ostan_val) 
      {
       $Condition_ostan_temp.=" T.code_ostan='$ostan_val' OR";
      }
      if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{$Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines) $MaxLines=20;
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
if(!$ok)
{
 echo'
 <table width="90%" height="100%" align="center" cellpadding="0" cellspacing="0">
  <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
   <td height="100%">
    <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
    <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
     <tr class="tr1">	
      <td align="left"> از تاریخ قرارداد :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ قرارداد :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	 </tr>
	 <tr class="tr1">
	  <td align="left" width="150px"><span class="star">*</span> شماره ابلاغ :&nbsp; </td>
	  <td align="right" colspan="3">
	  <input type="hidden" name="id_eblagh" value="'.$id_eblagh.'"/>
	  <input type="hidden" name="name_kala" value="'.$name_kala.'"/>
	  <input type="hidden" name="meghdar_kharid_keshvar" value="'.$meghdar_kharid_keshvar.'"/>
	  <input type="hidden" name="gheymat_kharid" value="'.$gheymat_kharid.'"/>
	  <input type="text" class="textboxme2" name="shomare_eblagh" value="'.$shomare_eblagh.'" onblur="enterField(this.value)"/>';
       include('img_eblagh.php');
	     echo'
	   &nbsp;<span style="color:red" id="Fill">&nbsp;</span></td>
	   </td>
	  </tr>
	  <tr class="tr1" style="line-height:50px;">
       <td align="left" > تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>	
      </tr>';
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" size="6" style="width:180px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>
	   <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و استانهای موردنظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	   &nbsp;
	  </td>
	 </tr>';
	}
	echo'
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
     <tr class="footer"><td colspan="4">&nbsp;</td></tr>
    </table>
    </div>
   </td>
  </tr>
 </table>';
}
else
{
    if(!$shomare_eblagh){echo"<script>alert('لطفاً شماره ابلاغ را وارد نمایید !')</script>";
                   echo"<script>window.location='$FileName';</script>";}
	$Condition="";
    /****************فیلترها روی گزارش*******************/		
	if($date1) $Condition.=" and T.tarikh_gharardad>='$date1'";
    if($date2) $Condition.=" and T.tarikh_gharardad<='$date2'";

/****************شروع نمایش گزارش*******************/	
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
    $radif=1;
	$sum=0;//مجموع 
	$sum_tedad=0;//مجموع 
    $q="SELECT T.code_ostan,COUNT(*) AS tedad_gharardad,SUM(meghdar_gharardad) AS sum_gharardad_ostan,kala.code_bastebandy,kala.name_kala,ostan.name_ostan
		From gharardad_kharid T 
		INNER JOIN sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
		INNER JOIN eblagh_kharid ON s_kh.id_eblagh=eblagh_kharid.id_eblagh
		INNER JOIN kala ON kala.code_kala=eblagh_kharid.code_kala	
		INNER JOIN ostan ON ostan.code_ostan=s_kh.code_ostan
		WHERE 1=1 $condition AND shomare_eblagh='".$shomare_eblagh."' AND T.year='$mtActiveYear' AND T.deleted=0 AND($Condition_ostan) GROUP BY T.code_ostan ORDER By name_ostan ";

	
	//echo $q;
	$res=$db->query($q);
    $cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)//وجود داشتن
	{
     echo'
     <br/>
     <table width="98%" border="1" align="center">
      <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
      <tr><td class="print_title_2">'.$titr.'</td></tr>
      <tr>
       <td class="print_title_2">
       <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText--hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
        از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
        <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
       </td>
      </tr>
     </table>';
	 /*سطر نمایش فیلترها*/ 
	  // if($code_kala) {$nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
	  // if(($code_kala)or($code_ziranbar)or($ranande_name)or($bank_ranande)or($shomare_resid))
	  // {echo'<table class="filter_text" width="98%" border="0" align="center"><tr><td>فیلتر شده براساس : '.$filter_string.'</td></tr></table>';}
	 
	 echo'
     <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">  
     '.$columns.'';
	 while($row=$db->fetch_assoc($res))
     {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  
	  $q_inside="SELECT shomare_gharardad,code_bastebandy From gharardad_kharid 
	  INNER JOIN sahmiebandy_kharid s_kh ON gharardad_kharid.id_sahmiebandy=s_kh.id_sahmiebandy 
	  INNER JOIN eblagh_kharid ON s_kh.id_eblagh=eblagh_kharid.id_eblagh
	  INNER JOIN kala ON kala.code_kala=eblagh_kharid.code_kala	
	  WHERE eblagh_kharid.id_eblagh='".$id_eblagh."' AND gharardad_kharid.code_ostan=".$row['code_ostan']." AND gharardad_kharid.year='$mtActiveYear' AND gharardad_kharid.deleted=0";
      //echo $q_inside;
	  $res_inside=$db->query($q_inside);
	  while($row_inside=$db->fetch_assoc($res_inside))
	  {
	   //کل تحویلی قرارداد
	   // //قوطی
	   // if($row_inside['code_bastebandy']==2) $sum_tahvily_gharardad1=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row_inside['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$row_inside['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
	   // //کارتن یا لاشه
	   // else 
	   $sum_tahvily_gharardad1=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row_inside['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan='".$row_inside['code_ostan']."' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
	   //echo "select SUM(vazn_khales_r_d_sub) from meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year where r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row_inside['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan='".$row_inside['code_ostan']."' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0";
	  
	  $sum_tahvily_gharardad+=$sum_tahvily_gharardad1;
	  
	  }
	   //مانده قرارداد
	  	   $mande_tahvily_ostan=$row['sum_gharardad_ostan']-$sum_tahvily_gharardad;

	  echo'  
	    <td>'.$radif++.'</td>
	    <td>'.$row['name_ostan'].'</td>
	    <td>'.$row['tedad_gharardad'].'</td>
	    <td>'.virgul($row['sum_gharardad_ostan']).'</td>
	    <td>'.round($sum_tahvily_gharardad,3).'</td>
		<td>'.round($mande_tahvily_ostan,3).'</td>
	   </tr>';
		if($line>=$MaxLines && $i<$cntr)//تکرار هدر در صفحات بعد
	    {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
	    }	
	 /****************محاسبه مجموع مقادیر در سطر آخر*******************/
	  $jame_meghdar_gharardad+=$row['meghdar_gharardad'];
	  $jame_tahvily_gharardad+=$sum_tahvily_gharardad;
	  $jame_mande_gharardad+=$mande_tahvily_gharardad;
	 
	 if($row['code_bastebandy']==2) $vahed='(تعداد)';
	 else $vahed='(کیلوگرم)';

     }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="3">جمع مقادیر '.$vahed.'</td>
	   <td>'.virgul($jame_meghdar_gharardad).'</td>
	   <td>'.round($jame_tahvily_gharardad,3).'</td>
	   <td>'.round($jame_mande_gharardad,3).'</td>
	  </tr>
	 </table>
	 <!--پايان مرکز صفحه -->
	 <!-- چاپ زیرنویس-->
     <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
      <tr class="print_footer">
      <td >&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
      </tr>
	 </table>'; 
	}//END IF //وجود داشتن
	 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'	
</form>
</body>
</html>';	
?>