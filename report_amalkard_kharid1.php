<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_amalkard_kharid.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش عملکرد خرید';
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
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 	
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script src="scripts/jquery.table2excel.js"></script>
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
<script type="text/javascript">
$(function(){	    
	  //خروجی اکسل
      $("#exportExcel").click(function(){
		  		$(".table2excel").table2excel({
		  			exclude: ".noExl",
		  			name: "Excel Document Name",
		  			filename: "report_gharardad",
		  			fileext: ".xls",
		  			exclude_img: true,
		  			exclude_links: true,
		  			exclude_inputs: true
		  		});
	    });	
});

</script> 
</head>';
/****************هدر******************/
$columns='
	   <tr class="print_table-title2" style="line-height:25px;">
	    <td rowspan="2" width=3%>ردیف</td>
	    <td rowspan="2" width=5% class="shEblaghPr">شماره ابلاغ</td>
	    <td rowspan="2" width=5% class="dateEblaghPr">تاریخ ابلاغ</td>
		<td rowspan="2" width="5%" class="shDastPr">شماره دستورالعمل</td>
		<td rowspan="2" width="5%" class="dateDastPr">تاریخ دستورالعمل</td>
		<td rowspan="2" width=10% class="skkPr">نام فروشنده</td>
	    <td rowspan="2" width=7% class="shghPr">شماره قرارداد</td>
	    <td rowspan="2" width=5% class="dateghPr">تاریخ قرارداد</td>
	    <td rowspan="2" width="5%" class="meghdaravalPr">مقدار اولیه قرارداد</td>
		<td rowspan="2" width="4%" class="mazadPr">مقادیر الحاقیه</td>
	    <td rowspan="2" width="5%" class="meghdarPr">مجموع قرارداد و الحاقیه</td>
	    <!--<td rowspan="2" width="5%" class="gheymatPr">قیمت موضوع قرارداد</td>-->
	    <td rowspan="2" width="5%" class="shResidPr">شماره رسید</td>
	    <td rowspan="2" width="5%" class="dateResidPr">تاریخ رسید</td>
		<td rowspan="2" width=5% class="ostanPr">استان</td>
		<td rowspan="2" width=5% class="sardkhanePr">سردخانه</td>
		<td rowspan="2" width=5% class="containerPr">شماره کانتینر</td>
		<td rowspan="2" width=5% class="tahvilbarPr">نوع تحویل بار</td>
		<td rowspan="2" width=4% class="statusPr">وضعیت</td>
	    <td rowspan="2" width=10% class="namekalaPr">نام کالا</td>
	    <td rowspan="2" width=10% class="tolidkonandePr">تولیدکننده</td>
	    <td rowspan="2" width=10% class="kartonPr">وزن کارتن</td>
	    <td colspan="3" width=10% class="tarikhTolidPr">تاریخ تولید</td>
	    <td rowspan="2" width=10% class="mandegariPr">مدت زمان ماندگاری</td>
	    <td rowspan="2" width=10% class="tedadPr">تعداد</td>
	    <td rowspan="2" width=10% class="nakhalesPr">وزن ناخالص</td>
	    <td rowspan="2" width=10% class="khalesPr">وزن خالص</td>
	   </tr>
	   <tr class="print_table-title2">
	    <td class="tarikhTolidPr">سال</td>
	    <td class="tarikhTolidPr">ماه</td>
	    <td class="tarikhTolidPr">روز</td>
	   </tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
   	   <tr class="noExl"><td class="print_title_2">'.$titr.'</td></tr>
       <tr class="noExl">
	    <td class="print_title_2">';
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo'
	    از تاریخ رسید : '.$date1.' تا تاریخ رسید : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>  
	   </tr>
      </table>
	 </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines) $MaxLines=15;
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
	 <tr class="tr1" >	
      <td align="left" height="40px"> از تاریخ (رسید) :&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerfrom" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ (رسید) :&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerto" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	 </tr>
	 <tr class="tr1" >	
      <td align="left" height="40px"> از تاریخ (قرارداد) :&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerfrom" maxlength="10" name="tarikh_gharardad1"  /></td>
      <td align="left"> تا تاریخ (قرارداد):&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerto" maxlength="10" name="tarikh_gharardad2"  /></td>
 	 </tr>
	 <tr class="tr1" >	
      <td align="left" height="40px"> از تاریخ (ابلاغ) :&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerfrom" maxlength="10" name="date_eblagh1" /></td>
      <td align="left"> تا تاریخ (ابلاغ):&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerto" maxlength="10" name="date_eblagh2"  /></td>
 	 </tr>
	 <tr class="tr1" >
	  <td align="left" width="150px" height="40px"> شماره ابلاغ :&nbsp; </td>
	  <td align="right" >
	  <input type="hidden" name="id_eblagh" value="'.$id_eblagh.'"/>
	  <input type="hidden" name="meghdar_kharid_keshvar" value="'.$meghdar_kharid_keshvar.'"/>
	  <input type="text" class="textboxme2" name="shomare_eblagh" value="'.$shomare_eblagh.'" onblur="enterField(this.value)"/>';
       include('img_eblagh.php');
	   echo'
	   </td>
	   <td align="left"> شماره قرارداد :&nbsp; </td>
	   <td align="right">
	    <input type="text" class="textboxme2" name="shomare_gharardad" value="'.$shomare_gharardad.'" />';
         //include('img_eblagh.php');
	     echo'
	   </td>
	  </tr>
	  <tr class="tr1">
	   <td align="left" height="40px"> طرف قرارداد (فروشنده) :&nbsp;</td>
	   <td align="right"><input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onkeypress="return isNumber(event)" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)"/>
	    <input type="hidden" name="name_skk" value="name_skk"/>';
	    include("img_helpcoding_mali.php");
	    echo'
	   <td align="left"> شماره دستورالعمل :&nbsp; </td>
	   <td align="right"><input type="text" class="textboxme2" name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'" /></td>	 
	  </tr>
	  <tr class="tr1">
	   <td align="left"  height="40px"> تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	  </tr>
	  <tr class="tr1">';
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left" height="40px">نام استان :&nbsp;</td>
      <td align="right" colspan="3">
	   <select name="ostanchoice[]"  class="easyui-combobox text4" style=width:200px  multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>
	  </td>';
	}
	echo'
	 </tr>
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    </table>
    </div>
   </td>
  </tr>
 </table>';
}
else
{
	$Condition_date="";
    /****************فیلترها روی گزارش*******************/		
    /******************استان ها******************/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
    {  
         if(is_array($ostanchoice))//کد های استان
         {
           foreach($ostanchoice as $key => $ostan_val) 
          {
           $Condition_ostan_temp.=" r.code_ostan='$ostan_val' OR";
          }
          if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
          else {$Condition_ostan.=" $Condition_ostan_temp";}
           $lastSpacePosition = strrpos($Condition_ostan," ");
           $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
         }
    }
    else 
    {$Condition_ostan=' r.code_ostan='.$_SESSION['mt_code_ostan'].'';}
    if($shomare_eblagh) $Condition.=" AND shomare_eblagh LIKE '%$shomare_eblagh%'";
    if($shomare_gharardad) $Condition.=" AND gh_kh.shomare_gharardad LIKE '%$shomare_gharardad%'";
	if($shomare_dastorolamal) $Condition.=" AND d_kh.shomare_dastorolamal LIKE '%$shomare_dastorolamal%'";
	if($code_skk) $Condition.=" AND r.code_skk='$code_skk'";//کد فروشنده /کشتی
	if($date1) $Condition_date.=" AND r.tarikh_resid>='$date1'";
    if($date2) $Condition_date.=" AND r.tarikh_resid<='$date2'";
	if($tarikh_gharardad1) $Condition_date.=" AND gh_kh.tarikh_gharardad>='$tarikh_gharardad1'";
    if($tarikh_gharardad2) $Condition_date.=" AND gh_kh.tarikh_gharardad<='$tarikh_gharardad2'";
	if($date_eblagh1) $Condition_date.=" AND eblagh_kharid.tarikh_eblagh>='$date_eblagh1'";
    if($date_eblagh2) $Condition_date.=" AND eblagh_kharid.tarikh_eblagh<='$date_eblagh2'";
/****************شروع نمایش گزارش*******************/	
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
    $radif=1;
	$sum=0;//مجموع 
	$sum_tedad=0;//مجموع 
    $q="SELECT r.*,gh_kh.*,r_k_d.*,shomare_eblagh,tarikh_eblagh,gh_kh.shomare_gharardad,kala.name_kala,kala.code_bastebandy,d_kh.shomare_dastorolamal,tarikh_dastorolamal,mt_skk.name_skk,ostan.name_ostan,name_anbar,name_group_kala_top,
	           sharh_tahvil_bar,name_tolidkonande,vazn_karton
		From $mydatabase.resid r
		LEFT OUTER JOIN resid_detail AS r_d ON r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year
        LEFT OUTER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande 
		LEFT JOIN tolidkonande ON tolidkonande.code_tolidkonande=r_k_d.code_tolidkonande    
		INNER JOIN $mydatabase.shomare_safar sh_s ON sh_s.id_safar=r.id_safar 
		INNER JOIN $mydatabase.gharardad_kharid gh_kh ON gh_kh.shomare_gharardad=sh_s.shomare_safar  
		INNER JOIN $mydatabase.sahmiebandy_kharid s_kh ON gh_kh.id_sahmiebandy=s_kh.id_sahmiebandy
		INNER JOIN $mydatabase.eblagh_kharid ON s_kh.id_eblagh=eblagh_kharid.id_eblagh
		INNER JOIN $mydatabase.dastorolamal_kharid d_kh ON d_kh.id_dastorolamal=gh_kh.id_dastorolamal
		INNER JOIN $mydatabase.mt_skk ON mt_skk.code_skk=gh_kh.code_skk
		INNER JOIN $mydatabase.ostan ON ostan.code_ostan=s_kh.code_ostan
		INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_ostan=r.code_ostan AND list_sardkhane.code_anbar=r.code_anbar 
		INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=eblagh_kharid.code_group_kala_top
		INNER JOIN $mydatabase.tahvilbar_resid ON tahvilbar_resid.noe_tahvil_bar=r.noe_tahvil_bar
		INNER JOIN $mydatabase.kala ON kala.code_kala=r_k_d.code_kala
		INNER JOIN $mydatabase.karton ON karton.code_karton=r_k_d.code_karton
		WHERE r.deleted=0 AND r.status=0 AND($Condition_ostan) $Condition $Condition_date ORDER By tarikh_resid,name_ostan";

	//echo $q;
	$res=$db->query($q);
    $cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)//وجود داشتن
	{
	 echo'
	   <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title2 "><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
		<tr class="print_table-title2 select_all">
		 <td width="4%">شماره ابلاغ</td>
		 <td width="4%">تاریخ ابلاغ</td>
		 <td width="4%">شماره دستورالعمل</td>
         <td width="4%">تاریخ دستورالعمل</td>
		 <td width=4%>نام فروشنده</td>
	     <td width=4%>شماره قرارداد</td>
	     <td width=4%>تاریخ قرارداد</td>
	     <td width="4%">مقدار اولیه قرارداد</td>
		 <td width="4%">مقادیر الحاقیه</td>
	     <td width="4%">مجموع قرارداد و الحاقیه</td>
	     <!--<td width="4%">قیمت موضوع قرارداد</td>-->
	     <td width="4%">شماره رسید</td>
	     <td width="4%">تاریخ رسید</td>
		 <td width=4%>استان</td>
		 <td width=4%>سردخانه</td>
		 <td width=4%>شماره کانتینر</td>
		 <td width=4%>نوع تحویل بار</td>
		 <td width=4%>وضعیت</td>
	     <td width=4%>نام کالا</td>
	     <td width=4%>تولیدکننده</td>
	     <td width=4%>کارتن</td>
	     <td width=4%>تعداد</td>
	     <td width=4%>مدت زمان ماندگاری</td>
	     <td width=4%>وزن ناخالص</td>
	     <td width=4%>وزن خالص</td>
	    </tr>   	
		<tr class="print_table-title2">
	     <td><input name="shEblaghPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="dateEblaghPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="shDastPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="dateDastPr" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="skkPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="shghPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="dateghPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="meghdaravalPr" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="mazadPr" class="count_sum" type="checkbox" checked></td>
		 <td><input name="meghdarPr" class="count_sum" type="checkbox" checked ></td>
		 <!--<td><input name="gheymatPr" class="count_sum" type="checkbox" checked></td>-->
		 <td><input name="shResidPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="dateResidPr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="ostanPr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="sardkhanePr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="containerPr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="tahvilbarPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="statusPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="namekalaPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="tolidkonandePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="kartonPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="mandegariPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="tedadPr"  type="checkbox" checked ></td>
	     <td><input name="nakhalesPr"  type="checkbox" checked ></td>
	     <td><input name="khalesPr"   type="checkbox" checked ></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if(is_array($ostanchoice))
     {
	  if($ostan_val==-1)$filter_string='همه استانها';
	  else $filter_string=' استان : ';
	  foreach($ostanchoice as $key => $ostan_val) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
     }
     if($date_eblagh1) $filter_string.=' از تاریخ ابلاغ : '.$date_eblagh1.'&nbsp;';
	 if($date_eblagh2) $filter_string.=' تا تاریخ ابلاغ : '.$date_eblagh2.'&nbsp;';
     if($tarikh_gharardad1) $filter_string.=' از تاریخ قرارداد : '.$tarikh_gharardad1.'&nbsp;';
	 if($tarikh_gharardad2) $filter_string.=' تا تاریخ قرارداد : '.$tarikh_gharardad2.'&nbsp;';	 
	 if($shomare_eblagh) $filter_string.=' شماره ابلاغ : '.$shomare_eblagh.'&nbsp;';
	 if($shomare_gharardad) $filter_string.=' شماره قرارداد : '.$shomare_gharardad.'&nbsp;';
	 if($shomare_dastorolamal) $filter_string.=' شماره دستورالعمل : '.$shomare_dastorolamal.'&nbsp;';
	 if($code_skk) $filter_string.=' کد مشتری : '.$code_skk.'&nbsp;';
	 if($noe_khat)   $filter_string.=' نوع خط : '.$noeKhatArr[$noe_khat].'&nbsp;';
	 {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
     {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
      //اضافه کردن صفر پشت کد استان
	  if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
      else $code_a=$row['code_ostan'];
	  //محاسبه مانده انقضا (اختلاف تاریخ رسید با تاریخ انقضا)
		 $milady=jalali_to_gregorian($row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi']);
         $sal1=$milady[0];$mah1=$milady[1];$rouz1=$milady[2];
         $tolid_milady=$sal1.'-'.$mah1.'-'.$rouz1;
	    //تاریخ انقضا یک سال بعد از تاریخ تولید 
         $tarikh_engheza_m = strtotime ( '+1 year' , strtotime ( $tolid_milady ) ) ;//1 year later
         $tarikh_engheza_m = date ( 'Y-m-j' , $tarikh_engheza_m );
         $d2=substr($tarikh_engheza_m,8,2);$m2=substr($tarikh_engheza_m,5,2);$y2=substr($tarikh_engheza_m,0,4);
         $DateF2=gregorian_to_jalali($y2,$m2,$d2);
         $yy2=$DateF2[0];
         $mm2=$DateF2[1];
         $dd2=$DateF2[2];
         $tarikh_engheza=$yy2.'/'.$mm2.'/'.$dd2;
	  $tarikh_resid=$row['tarikh_resid'];
	  if($tarikh_resid<$tarikh_engheza)$mande_ta_engheza=calculate_date_diff($tarikh_resid,$tarikh_engheza);
	  else $mande_ta_engheza=calculate_date_diff($tarikh_engheza,$tarikh_resid).'از تاریخ گذشته';
	     
	  echo'  
	    <td>'.$radif++.'</td>
		<td class="shEblaghPr">'.$row['shomare_eblagh'].'</td>
		<td class="dateEblaghPr">'.$row['tarikh_eblagh'].'</td>
		<td class="shDastPr">'.$row['shomare_dastorolamal'].'</td>
		<td class="dateDastPr">'.$row['tarikh_dastorolamal'].'</td>
		<td class="skkPr">'.$row['name_skk'].'</td>
	    <td class="shghPr">'.$row['shomare_gharardad'].'</td>
	    <td class="dateghPr">'.$row['tarikh_gharardad'].'</td>
	    <td class="meghdaravalPr">'.round($row['meghdar_gharardad_avaliye'],3).'</td>
	    <td class="mazadPr">'.round($row['mazad_gharardad'],3).'</td>
		<td class="meghdarPr">'.round($row['meghdar_gharardad_avaliye']+$row['mazad_gharardad'],3).'</td>
		<!--<td class="gheymatPr"></td>-->
		<td class="shResidPr">'.$code_a.$row['code_anbar'].$row['shomare_resid'].'</td>
		<td class="dateResidPr">'.$row['tarikh_resid'].'</td>
		<td class="ostanPr">'.$row['name_ostan'].'</td>
		<td class="sardkhanePr">'.$row['name_anbar'].'</td>
		<td class="containerPr">'.$row['shomare_container'].'</td>
		<td class="tahvilbarPr">'.$row['sharh_tahvil_bar'].'</td>
		<td class="statusPr">'.$typeGrArr[$row['termination']].'</td>
	    <td class="namekalaPr">'.$row['name_kala'].'</td>
	    <td class="tolidkonandePr">'.$row['name_tolidkonande'].'</td>
	    <td class="kartonPr">'.$row['vazn_karton'].'</td>
	    <td class="tarikhTolidPr">'.$row['sal_tolid_shamsi'].'</td>
	    <td class="tarikhTolidPr">'.$row['mah_tolid_shamsi'].'</td>
	    <td class="tarikhTolidPr">'.$row['rouz_tolid_shamsi'].'</td>
	    <td class="mandegariPr">'.$mande_ta_engheza.'</td>
	    <td class="tedadPr">'.virgul($row['tedad_karton_r_d_sub']).'</td>
		<td class="nakhalesPr">'.round($row['vazn_nakhales_r_d_sub'],3).'</td>
		<td class="khalesPr">'.round($row['vazn_khales_r_d_sub'],3).'</td>
	   </tr>';
		if($line>=$MaxLines && $i<$cntr)//تکرار هدر در صفحات بعد
	    {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
			echo $columns;
	    }	
	 /****************محاسبه مجموع مقادیر در سطر آخر*******************/
	  $jame_meghdaraval_gharardad+=$row['meghdar_gharardad_avaliye'];
	  $jame_mazad_gharardad+=$row['mazad_gharardad'];
	  $jame_meghdar_gharardad+=($row['meghdar_gharardad_avaliye']+$row['mazad_gharardad']);
	  $jame_tedad+=$row['tedad_karton_r_d_sub'];
	  $jame_vazn_nakhales+=$row['vazn_nakhales_r_d_sub'];
	  $jame_vazn_khales+=$row['vazn_khales_r_d_sub'];
	  //if($row['code_bastebandy']==2) $vahed='(تعداد)';
	  //else $vahed='(کیلوگرم)';
     }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td class="sum_row" colspan="25">جمع مقادیر '.$vahed.'</td>
	   <td class="tedadPr">'.round($jame_tedad,3).'</td>
	   <td class="nakhalesPr">'.round($jame_vazn_nakhales,3).'</td>
	   <td class="khalesPr">'.round($jame_vazn_khales,3).'</td>
	  </tr>
	 <!--پايان مرکز صفحه -->
     <!-- چاپ زیرنوس-->';
     require_once('prt-footer.php');
     echo' 
     </table>';
	}//END IF //وجود داشتن
	 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'
</div>	
</form>
</body>
</html>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {

//نمایش ستونها
	    $("input:checkbox:not(:checked)").each(function() {
         var column = "table ." + $(this).attr("name");
         $(column).hide();
        });
        $("input:checkbox").click(function(){
         var column = "table ." + $(this).attr("name");
         $(column).toggle();
         var count_sum=25;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var count_sum=count_sum-numberNotChecked;
		 $(".sum_row").attr("colspan",count_sum);
        });
//انتخاب تاریخ		
    $(".datepickerfrom").datepicker({
	    defaultDate:"<?php $today ?>",
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $(".datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $(".datepickerto").datepicker(
	  { 
	    defaultDate:"<?php $today ?>",
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
		}
	  );		
});
</script> 