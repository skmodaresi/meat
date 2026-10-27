<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_amalkard_faravardeha.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
/****************هدر******************/
Function print_header()
{global $count,$mt_gl_owner,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$kalaName,$code_kala,$Condition;
 echo'
   <br/>   
   <table width="98%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
   	<tr><td class="print_title_2">گزارش اطلاعات عملکرد فرآورده ها</td></tr>
	<tr>
     <td class="print_title_2">
	   از تاریخ : '.$date1.' تا تاریخ : '.$date2.'
	 </td>
	</tr>
	<tr>
	 <td class="print_title_2"> &nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	 </td>
    </tr>
   <tr><td class="print_title" style="font-size:12px;">
   خرید قطعی شامل :تخلیه در سردخانه،تحویل روباری و حمل با راه آهن  <br/>
   تحویل قطعی شامل : بارگیری از سردخانه، تحویل روباری و حمل باراه آهن <br/>
   دریافتی از بنادر شامل : اسکه بندر امام خمینی و اسکله شهید رجایی
   </td>
   </tr>
   </table>
   <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="print_table-title2">
	 <td width="2%" rowspan="2">ردیف</td>
	 <td width="6%" rowspan="2">کالا</td>
	 <td width="10%" colspan="2">مانده موجودی از قبل</td>
	 <td width="10%" colspan="2">خرید قطعی</td>
	 <td width="6%" colspan="2">دریافتی از سایر استان ها</td>
	 <td width="6%" colspan="2">دریافتی از بنادر</td>
	 <td width="10%" colspan="2">تحویل قطعی</td>
	 <td width="6%" colspan="2">ارسالی به سایر استان ها</td>
	 <td width="6%" colspan="2">تعدیل (اضافه)</td>
	 <td width="6%" colspan="2">تعدیل (کسری)</td>
	 <td width="10%" colspan="2">مانده موجودی</td>
	 <td width="10%" colspan="2">حواله فروش</td>
	 <td width="6%" colspan="2">ابطالی حواله فروش</td>
	 <td width="6%" colspan="2">مانده حواله فروش</td>
	</tr>
	<tr class="print_table-title2">';
	 for($count=1;$count<=12;$count++)
	 {echo'<td >داخلی</td>
    	 <td >وارداتی</td>';
		 }
     echo'
	 </tr>'; 
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>گزارش اطلاعات عملکرد فرآورده ها</title>
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
</script> 
</head>';
/****************فیلترها روی گزارش******************/
/*******استان ها*******/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
 if(is_array($ostanchoice))//کد های استان
 {
   foreach($ostanchoice as $key => $val ) 
   {
     $Condition_ostan_temp.=" code_ostan='$val' OR";
	 $Condition_ostan_resid_temp.=" r_k_d.code_ostan='$val' OR";
     $Condition_ostan_havale_temp.=" h_d.code_ostan='$val' OR";
     $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='$val'");//تبدیل کد به آی دی
     $Condition_ostan_temp_sell.=" dm_havale.h_id_province='$sell_id_ostan' OR";
	 $Condition_ostan_ebtal_temp_sell.=" dm_his_havale.his_id_province='$sell_id_ostan' OR";
   }
   if($val==-1){$Condition_ostan.="1=1 OR";$Condition_ostan_resid.="1=1 OR";$Condition_ostan_havale.="1=1 OR";$Condition_ostan_sell.="1=1 OR";$Condition_ostan_ebtal_sell.="1=1 OR";}
   else {$Condition_ostan.=" $Condition_ostan_temp";$Condition_ostan_resid.=" $Condition_ostan_resid_temp";$Condition_ostan_havale.=" $Condition_ostan_havale_temp";$Condition_ostan_sell.=" $Condition_ostan_temp_sell";$Condition_ostan_ebtal_sell.=" $Condition_ostan_ebtal_temp_sell";}
     $lastSpacePosition = strrpos($Condition_ostan," ");
     $lastSpacePosition_resid = strrpos($Condition_ostan_resid," ");
     $lastSpacePosition_havale = strrpos($Condition_ostan_havale," ");
     $lastSpacePosition_sell = strrpos($Condition_ostan_sell," ");
     $lastSpacePosition_ebtal_sell = strrpos($Condition_ostan_ebtal_sell," ");
     $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     $Condition_ostan_resid =substr($Condition_ostan_resid,0,$lastSpacePosition_resid);
     $Condition_ostan_havale =substr($Condition_ostan_havale,0,$lastSpacePosition_havale);
     $Condition_ostan_sell =substr($Condition_ostan_sell,0,$lastSpacePosition_sell);
     $Condition_ostan_ebtal_sell =substr($Condition_ostan_ebtal_sell,0,$lastSpacePosition_ebtal_sell);    
 }
}
else 
{
	  $Condition_ostan=' code_ostan='.$_SESSION['mt_code_ostan'].'';
	  $Condition_ostan_resid=' r_k_d.code_ostan='.$_SESSION['mt_code_ostan'].'';
	  $Condition_ostan_havale=' h_d.code_ostan='.$_SESSION['mt_code_ostan'].'';	  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='".$_SESSION['mt_code_ostan']."'");//تبدیل کد به آی دی
	  $Condition_ostan_sell=' dm_havale.h_id_province='.$sell_id_ostan.'';
	  $Condition_ostan_ebtal_sell=' dm_his_havale.his_id_province='.$sell_id_ostan.'';
}
/******انبارها******/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_resid='1=1';$Condition_anbar_havale='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" code_anbar=".$row_user['code_anbar']." OR";
   $Condition_anbar_resid_temp.=" r_k_d.code_anbar=".$row_user['code_anbar']." OR";
   $Condition_anbar_havale_temp.=" h_d.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_resid.="  $Condition_anbar_resid_temp";
	 $Condition_anbar_havale.="  $Condition_anbar_havale_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
	 $Condition_anbar_ebtal_sell.="  $Condition_anbar_ebtal_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_resid = strrpos($Condition_anbar_resid," ");
     $lastSpacePosition_havale = strrpos($Condition_anbar_havale," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $lastSpacePosition_ebtal_sell = strrpos($Condition_anbar_ebtal_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
	 $Condition_anbar_resid =substr($Condition_anbar_resid,0,$lastSpacePosition_resid);
     $Condition_anbar_havale =substr($Condition_anbar_havale,0,$lastSpacePosition_havale);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
     $Condition_anbar_ebtal_sell =substr($Condition_anbar_ebtal_sell,0,$lastSpacePosition_ebtal_sell);
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=15;
 //اگر کاربر تاریخ اول را وارد نکرده بود
 if(!$date1)$date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
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
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">گزارش اطلاعات عملکرد فرآورده ها</td>	 
    </tr>
    <tr class="tr1">
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>	
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" size="6" style="width:200px;" multiple>';
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
    
   </table>
   </div>
  </td>
 </tr>
</table> ';
}
else
{
 //تبدیل تاریخ شمسی به میلادی
 $sql_tarikh1=$date1;//تاریخ اول
       $d1=substr($sql_tarikh1,8,2);
       $m1=substr($sql_tarikh1,5,2);
       $y1=substr($sql_tarikh1,0,4);
       $milady1=jalali_to_gregorian($y1,$m1,$d1);
       $sal1=$milady1[0];
       $mah1=$milady1[1];
       $rouz1=$milady1[2];
       $date1_milady=$sal1.'-'.$mah1.'-'.$rouz1;
 $sql_tarikh2=$date2;//تاریخ دوم
       $d2=substr($sql_tarikh2,8,2);  
       $m2=substr($sql_tarikh2,5,2);
       $y2=substr($sql_tarikh2,0,4);
       $milady2=jalali_to_gregorian($y2,$m2,$d2);
       $sal2=$milady2[0];
       $mah2=$milady2[1];
       $rouz2=$milady2[2];
       $date2_milady=$sal2.'-'.$mah2.'-'.$rouz2;	  
/****************شروع نمایش گزارش*******************/	
 $radif=1;
 $page=1;
 $line=0;
 $i=0;
 $cntr=0;
 echo'
 <br/>
 <table width="98%" border="1" align="center">
  <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
  <tr><td class="print_title_2">گزارش اطلاعات عملکرد فرآورده ها</td></tr>
  <tr><td class="print_title_2">از تاریخ : '.$date1.' تا تاریخ : '.$date2.'</td> </tr>
   <tr>
	<td class="print_title_2">
	   	<span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
	     &nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	</td>
   </tr>
   <tr><td class="print_title" style="font-size:12px;">
   خرید قطعی شامل :تخلیه در سردخانه،تحویل روباری و حمل با راه آهن <br/>
   تحویل قطعی شامل : بارگیری از سردخانه، تحویل روباری و حمل باراه آهن <br/>
   دریافتی از بنادر شامل : اسکه بندر امام خمینی و اسکله شهید رجایی
   </td></tr>
  </table>';
  	  //56:اسکله شهید رجایی
	  //57:اسکله بندر امام خمینی
/*سطر نمایش فیلترها*/
  if(($ostanchoice))
  {
	 if($val==-1)$filter_string='همه استانها';
	 else $filter_string=' استان : ';
	 foreach($ostanchoice as $key => $val) {
	  $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$val'");
	  $filter_string.=''.$nameOstan.'&nbsp;';
     }
  }
  if($noe_namayesh==1) $filter_string.="نمایش اطلاعات : خالص";
  if($noe_namayesh==2) $filter_string.="نمایش اطلاعات : ناخالص";
  if($noe_namayesh==3) $filter_string.="نمایش اطلاعات : تعداد";
  echo'<table class="filter_text" width="98%" border="0" align="center"><tr><td>فیلتر شده براساس : '.$filter_string.'</td></tr></table>';
  echo'
  <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
   <tr class="print_table-title2">
    <td width="2%" rowspan="2">ردیف</td>
    <td width="6%" rowspan="2">کالا</td>
    <td width="10%" colspan="2">مانده موجودی از قبل</td>
    <td width="10%" colspan="2">خرید قطعی</td>
    <td width="6%" colspan="2">دریافتی از سایر استان ها</td>
    <td width="6%" colspan="2">دریافتی از بنادر</td>
    <td width="10%" colspan="2">تحویل قطعی</td>
    <td width="6%" colspan="2">ارسالی به سایر استان ها</td>
    <td width="6%" colspan="2">تعدیل (اضافه)</td>
    <td width="6%" colspan="2">تعدیل (کسری)</td>
    <td width="10%" colspan="2">مانده موجودی</td>
    <td width="10%" colspan="2">حواله فروش</td>
    <td width="6%" colspan="2">ابطالی حواله فروش</td>
    <td width="6%" colspan="2">مانده حواله فروش</td>
   </tr>
   <tr class="print_table-title2">';
	for($count=1;$count<=12;$count++)
	{echo'<td >داخلی</td>
    	     <td>وارداتی</td>';}
   echo'
   </tr>';
   $kalagroupArray = array("1"=>"گوشت گاو","2"=>"گوشت گوسفند","3"=>"گوشت مرغ","4"=>"کنسرو مرغ","5"=>"تخم مرغ خوراکی");
   foreach($kalagroupArray as $x => $x_value)
   { 
	$line++;
	if($i++%2)echo'<tr class="print_table-odd">';
    else echo'<tr class="print_table-even">';
    echo'   
	<td>'.$radif++.'</td>
	<td>'.$x_value.'</td>';
	if($x_value=="گوشت گاو")
	{
	  //dakheli:81,82,83,84,85,86
	  $kalaCondition_dakheli=" AND (code_kala=81 OR code_kala=82 OR code_kala=83 OR code_kala=84 OR code_kala=85 OR code_kala=86)";
	  $kalaCondition_resid_dakheli=" AND (r_k_d.code_kala=81 OR r_k_d.code_kala=82 OR r_k_d.code_kala=83 OR r_k_d.code_kala=84 OR r_k_d.code_kala=85 OR r_k_d.code_kala=86)";
	  $kalaCondition_havale_dakheli=" AND (h_d.code_kala=81 OR h_d.code_kala=82 OR h_d.code_kala=83 OR h_d.code_kala=84 OR h_d.code_kala=85 OR h_d.code_kala=86)";
	  $kalaCondition_dakheli_sell=" AND (h_p_code=81 OR h_p_code=82 OR h_p_code=83 OR h_p_code=84 OR h_p_code=85 OR h_p_code=86)";
	  //varedati:75,76,78,92
	  $kalaCondition_varedati=" AND (code_kala=75 OR code_kala=76 OR code_kala=78 OR code_kala=92)";
	  $kalaCondition_resid_varedati=" AND (r_k_d.code_kala=75 OR r_k_d.code_kala=76 OR r_k_d.code_kala=78 OR r_k_d.code_kala=92)";
	  $kalaCondition_havale_varedati=" AND (h_d.code_kala=75 OR h_d.code_kala=76 OR h_d.code_kala=78 OR h_d.code_kala=92)";
	  $kalaCondition_varedati_sell=" AND (h_p_code=75 OR h_p_code=76 OR h_p_code=78 OR h_p_code=92)";
	}
	if($x_value=="گوشت گوسفند")
	{
	  //dakheli:144,148,149,150,151
	  $kalaCondition_dakheli=" AND (code_kala=144 OR code_kala=148 OR code_kala=149 OR code_kala=150 OR code_kala=151)";
	  $kalaCondition_resid_dakheli=" AND (r_k_d.code_kala=144 OR r_k_d.code_kala=148 OR r_k_d.code_kala=149 OR r_k_d.code_kala=150 OR r_k_d.code_kala=151)";
	  $kalaCondition_havale_dakheli=" AND (h_d.code_kala=144 OR h_d.code_kala=148 OR h_d.code_kala=149 OR h_d.code_kala=150 OR h_d.code_kala=151)";
	  $kalaCondition_dakheli_sell=" AND (h_p_code=144 OR h_p_code=148 OR h_p_code=149 OR h_p_code=150 OR h_p_code=151)";
	  //varedati:dont exist
	  $kalaCondition_varedati=" AND 1!=1";
	  $kalaCondition_resid_varedati=" AND 1!=1";
	  $kalaCondition_havale_varedati=" AND 1!=1";
	  $kalaCondition_varedati_sell=" AND 1!=1";	 
    }
	if($x_value=="گوشت مرغ")
	{
	  //dakheli:38,401,402,403,404,410,411,412,197,198,405
	  $kalaCondition_dakheli=" AND (code_kala=38 OR code_kala=401 OR code_kala=402 OR code_kala=403 OR code_kala=404 OR code_kala=410 OR code_kala=411 OR code_kala=412 OR code_kala=197 OR code_kala=198 OR code_kala=405)";
	  $kalaCondition_resid_dakheli=" AND (r_k_d.code_kala=38 OR r_k_d.code_kala=401 OR r_k_d.code_kala=402 OR r_k_d.code_kala=403 OR r_k_d.code_kala=404 OR r_k_d.code_kala=410 OR r_k_d.code_kala=411 OR r_k_d.code_kala=412 OR r_k_d.code_kala=197 OR r_k_d.code_kala=198 OR r_k_d.code_kala=405)";
	  $kalaCondition_havale_dakheli=" AND (h_d.code_kala=38 OR h_d.code_kala=401 OR h_d.code_kala=402 OR h_d.code_kala=403 OR h_d.code_kala=404 OR h_d.code_kala=410 OR h_d.code_kala=411 OR h_d.code_kala=412 OR h_d.code_kala=197 OR h_d.code_kala=198 OR h_d.code_kala=405)";
	  $kalaCondition_dakheli_sell=" AND (h_p_code=38 OR h_p_code=401 OR h_p_code=402 OR h_p_code=403 OR h_p_code=404 OR h_p_code=410 OR h_p_code=411 OR h_p_code=412 OR h_p_code=197 OR h_p_code=198 OR h_p_code=405)";
	  //varedati:154
	  $kalaCondition_varedati=" AND code_kala=154";
	  $kalaCondition_resid_varedati=" AND r_k_d.code_kala=154";
	  $kalaCondition_havale_varedati=" AND h_d.code_kala=154";
	  $kalaCondition_varedati_sell=" AND h_p_code=154";
	}
    if($x_value=="کنسرو مرغ")  
	{
	  //dakheli:406,407
	  $kalaCondition_dakheli=" AND (code_kala=406 OR code_kala=407)";
	  $kalaCondition_resid_dakheli=" AND (r_k_d.code_kala=406 OR r_k_d.code_kala=407)";
	  $kalaCondition_havale_dakheli=" AND (h_d.code_kala=406 OR h_d.code_kala=407)";
	  $kalaCondition_dakheli_sell=" AND (h_p_code=406 OR h_p_code=407)";
	  //varedati:dont exist
	  $kalaCondition_varedati=" AND 1!=1";
	  $kalaCondition_resid_varedati=" AND 1!=1";
	  $kalaCondition_havale_varedati=" AND 1!=1";
	  $kalaCondition_varedati_sell=" AND 1!=1";
	}
	if($x_value=="تخم مرغ خوراکی")
    {
 	  //dakheli:50
	  $kalaCondition_dakheli=" AND code_kala=50";
	  $kalaCondition_resid_dakheli=" AND r_k_d.code_kala=50";
	  $kalaCondition_havale_dakheli=" AND h_d.code_kala=50";
	  $kalaCondition_dakheli_sell=" AND h_p_code=50";
	  //varedati:dont exist
	  $kalaCondition_varedati=" AND 1!=1";
	  $kalaCondition_resid_varedati=" AND 1!=1";
	  $kalaCondition_havale_varedati=" AND 1!=1";
	  $kalaCondition_varedati_sell=" AND 1!=1";
	}
	// if($x_value=="مرغ مادر")
    // {
 	  // //dakheli:405
	  // $kalaCondition_dakheli=" AND code_kala=405";
	  // $kalaCondition_resid_dakheli=" AND r_k_d.code_kala=405";
	  // $kalaCondition_havale_dakheli=" AND h_d.code_kala=405";
	  // $kalaCondition_dakheli_sell=" AND h_p_code=405";
	  // //varedati:dont exist
	  // $kalaCondition_varedati=" AND 1!=1";
	  // $kalaCondition_resid_varedati=" AND 1!=1";
	  // $kalaCondition_havale_varedati=" AND 1!=1";
	  // $kalaCondition_varedati_sell=" AND 1!=1";
	// }
	
	/**************************نوع نمایش خالص**********************************/
	if($noe_namayesh==1)
	{
	 /****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
     //فیلد اول-حالت داخلی
	  $mande_befor_dakheli=0;
	  $avaliye_dakheli=$db->get_from_where("SUM(mojody_khales_aval)","meat.mojody_kala","year='$mtActiveYear' AND deleted=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     	  
	  $jameVarede_befor_dakheli=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_befor_dakheli=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");	
	  $meghdarTadil_Ezafe_befor_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	  $meghdarTadil_Kasry_befor_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	  $mande_befor_dakheli=$avaliye_dakheli+$jameVarede_befor_dakheli-$jameSadere_befor_dakheli+$meghdarTadil_Ezafe_befor_dakheli-$meghdarTadil_Kasry_befor_dakheli;	      
	 //فیلد دوم -حالت وارداتی
	  $mande_befor_varedati=0;
	  $avaliye_varedati=$db->get_from_where("SUM(mojody_khales_aval)","meat.mojody_kala","year='$mtActiveYear' AND deleted=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $jameVarede_befor_varedati=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_befor_varedati=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");	
	  $meghdarTadil_Ezafe_befor_varedati=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $meghdarTadil_Kasry_befor_varedati=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");              
	  $mande_befor_varedati=$avaliye_varedati+$jameVarede_befor_varedati-$jameSadere_befor_varedati+$meghdarTadil_Ezafe_befor_varedati-$meghdarTadil_Kasry_befor_varedati;	      
     //فیلد سوم
	  $kharidghatee_dakheli=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $kharidghatee_varedati=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_jabejae_dakheli=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","(r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_jabejae_varedati=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","(r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  //56:اسکله شهید رجایی
	  //57:اسکله بندر امام خمینی
	  $daryafti_banader_dakheli=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND (r.code_mabda=56 OR r.code_mabda=57) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_banader_varedati=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND (r.code_mabda=56 OR r.code_mabda=57) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $tahvilghatee_dakheli=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $tahvilghatee_varedati=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $ersali_jabejae_dakheli=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $ersali_jabejae_varedati=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $tadil_ezafe_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","noe_tadil=1 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
	  $tadil_ezafe_varedati=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","noe_tadil=1 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
	  $tadil_kasry_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","noe_tadil=2 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
	  $tadil_kasry_varedati=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","noe_tadil=2 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
	  //فیلد هفدهم -حالت داخلی
	  $mande_nahayi_dakheli=0;
	  $jameVarede_dakheli=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_dakheli=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
      $meghdarTadil_Ezafe_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
      $meghdarTadil_Kasry_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
      $mande_nahayi_dakheli=$mande_befor_dakheli+$jameVarede_dakheli-$jameSadere_dakheli+$meghdarTadil_Ezafe_dakheli-$meghdarTadil_Kasry_dakheli;	      
     //فیلد هجدهم - حالت وارداتی
	  $mande_nahayi_varedati=0;
	  $jameVarede_varedati=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_varedati=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $meghdarTadil_Ezafe_varedati=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $meghdarTadil_Kasry_varedati=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $mande_nahayi_varedati=$mande_befor_varedati+$jameVarede_varedati-$jameSadere_varedati+$meghdarTadil_Ezafe_varedati-$meghdarTadil_Kasry_varedati;	      
	  if($x_value=="کنسرو مرغ")
	  {$havale_forush_between_dakheli=0;$havale_forush_between_varedati=0;$meghdar_ebtali_between_dakheli=0;$meghdar_ebtali_between_varedati=0;$mande_forush_between_dakheli=0;$mande_forush_between_varedati=0;}
	  //به غیر از کنسرو
	  else
	  {
		  //مانده از حواله فروش قبل از تاریخ
          //پیدا کردن آی دی سال مربوط به سیستم فروش
          $sellYearCode=substr($mtActiveYear,2);
          $sellYearId=$db->get_from_where("year_id","sell.dm_year","year_code='$sellYearCode'");
		  /******حالت داخلی******/		 
		  $havale_forush_befor_dakheli=0;
          $havale_forush_bef_dakheli=0;
		  $q_forush_befor_dakheli=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND  h_reg_date<'$date1_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $res_forush_befor_dakheli=$db->query($q_forush_befor_dakheli);
		  while($row_forush_befor_dakheli=$db->fetch_array($res_forush_befor_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  {
		   //پیدا کردن کد استان از روی آی دی
            $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_befor_dakheli['h_id_province']."");
           //پیدا کردن کد انباراز روی آی دی
            $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor_dakheli['h_id_province']." AND l_id=".$row_forush_befor_dakheli['h_l_code']."");  
			/**///محاسبه کل تحویلی برای این حواله
            $meghdar_tahvily_per1=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","h_code=".$row_forush_befor_dakheli['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	        /**///محاسبه کل باطله برای این حواله
            $db->selectDb('sell');
			$meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code=".$row_forush_befor_dakheli['h_code']." AND his_id_province=".$row_forush_befor_dakheli['h_id_province']." AND his_l_code=".$row_forush_befor_dakheli['h_l_code']." AND his_id_year='$sellYearId'");
	        $havale_forush_bef_dakheli=$row_forush_befor_dakheli['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
			 /**///محاسبه مقدار مانده از حواله فروش
 	        //مقدار کل ابطالی ها قبل از تاریخ
	        $q_ebtal_befor_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                WHERE his_p_code=".$row_forush_befor_dakheli['h_p_code']." AND his_h_code=".$row_forush_befor_dakheli['h_code']." AND his_id_province=".$row_forush_befor_dakheli['h_id_province']." AND his_l_code=".$row_forush_befor_dakheli['h_l_code']." AND his_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	        $res_ebtal_befor_dakheli=$db->query($q_ebtal_befor_dakheli);
	        $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_dakheli);	        
	        //حواله جنسی قبل از تاریخ
			$db->selectDb($mydatabase);
	        $sadere_befor=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail as h_d INNER JOIN meat.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.h_code=".$row_forush_befor_dakheli['h_code']." AND h_d.code_ostan='$code_ostan_forhavale' AND h_d.code_anbar='$code_anbar_forhavale' AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
	        //محاسبه مقدار حواله فروش قبل از تاریخ
		    $havale_forush_befor_per_dakheli=$havale_forush_bef_dakheli-$sadere_befor-$meghdar_ebtali_befor[0];
			$havale_forush_befor_dakheli+=$havale_forush_befor_per_dakheli;
		  }
		  /******حالت وارداتی******/		 	  
		  $havale_forush_befor_varedati=0;
          $havale_forush_bef_varedati=0;
		  $q_forush_befor_varedati=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND  h_reg_date<'$date1_milady' $kalaCondition_varedati_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $res_forush_befor_varedati=$db->query($q_forush_befor_varedati);
		  while($row_forush_befor_varedati=$db->fetch_array($res_forush_befor_varedati))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  {
		   //پیدا کردن کد استان از روی آی دی
            $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_befor_varedati['h_id_province']."");
           //پیدا کردن کد انباراز روی آی دی
            $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor_varedati['h_id_province']." AND l_id=".$row_forush_befor_varedati['h_l_code']."");  
		   /**///محاسبه کل تحویلی برای این حواله
            $meghdar_tahvily_per1=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","h_code=".$row_forush_befor_varedati['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	       /**///محاسبه کل باطله برای این حواله
            $db->selectDb('sell');
			$meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code=".$row_forush_befor_varedati['h_code']." AND his_id_province=".$row_forush_befor_varedati['h_id_province']." AND his_l_code=".$row_forush_befor_varedati['h_l_code']." AND his_id_year='$sellYearId'");
	        $havale_forush_bef_varedati=$row_forush_befor_varedati['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
			 /**///محاسبه مقدار مانده از حواله فروش
			//مقدار کل ابطالی هل قبل از تاریخ
	        $q_ebtal_befor_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                WHERE his_p_code=".$row_forush_befor_varedati['h_p_code']." AND his_h_code=".$row_forush_befor_varedati['h_code']." AND his_id_province=".$row_forush_befor_varedati['h_id_province']." AND his_l_code=".$row_forush_befor_varedati['h_l_code']." AND his_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	        $res_ebtal_befor_varedati=$db->query($q_ebtal_befor_varedati);
	        $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_varedati); 
			//حواله جنسی قبل از تاریخ
	        $db->selectDb($mydatabase);
	        $sadere_befor=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail as h_d INNER JOIN meat.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.h_code=".$row_forush_befor_varedati['h_code']." AND h_d.code_ostan='$code_ostan_forhavale' AND h_d.code_anbar='$code_anbar_forhavale' AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
	        //محاسبه مقدار حواله فروش قبل از تاریخ
		    $havale_forush_befor_per_varedati=$havale_forush_bef_varedati-$sadere_befor-$meghdar_ebtali_befor[0];
			$havale_forush_befor_varedati+=$havale_forush_befor_per_varedati;
		  }
		 //مقدار کل حواله فروش ها مابین تاریخ
		 /******حالت داخلی******/		 	  
		  $havale_forush_bet_per1=0;
          $havale_forush_between_dakheli=0;
		  $q_forush_dakheli=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $res_forush_dakheli=$db->query($q_forush_dakheli);
		  while($row_forush_dakheli=$db->fetch_array($res_forush_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  {
		   //پیدا کردن کد استان از روی آی دی
            $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_dakheli['h_id_province']."");
           //پیدا کردن کد انباراز روی آی دی
            $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_dakheli['h_id_province']." AND l_id=".$row_forush_dakheli['h_l_code']."");  
		   /**///محاسبه کل تحویلی برای این حواله
		   	$db->selectDb($mydatabase);
            $meghdar_tahvily_per2=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","h_code=".$row_forush_dakheli['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	        /**///محاسبه کل باطله برای این حواله
            $db->selectDb('sell');
			$meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code=".$row_forush_dakheli['h_code']." AND his_id_province=".$row_forush_dakheli['h_id_province']." AND his_l_code=".$row_forush_dakheli['h_l_code']." AND his_id_year='$sellYearId'");
	        $havale_forush_bet_per1=$row_forush_dakheli['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
			$havale_forush_between_dakheli+=$havale_forush_bet_per1;
		  }
		  /******حالت وارداتی******/		 	  
		  $havale_forush_bet_per2=0;
          $havale_forush_between_varedati=0;
		  $q_forush_varedati=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_varedati_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $res_forush_varedati=$db->query($q_forush_varedati);
		  while($row_forush_varedati=$db->fetch_array($res_forush_varedati))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  {
		   //پیدا کردن کد استان از روی آی دی
            $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_varedati['h_id_province']."");
           //پیدا کردن کد انباراز روی آی دی
            $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_varedati['h_id_province']." AND l_id=".$row_forush_varedati['h_l_code']."");  
		   /**///محاسبه کل تحویلی برای این حواله
		   	$db->selectDb($mydatabase);
			$meghdar_tahvily_per2=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","h_code=".$row_forush_varedati['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	       /**///محاسبه کل باطله برای این حواله
            $db->selectDb('sell');
			$meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code=".$row_forush_varedati['h_code']." AND his_id_province=".$row_forush_varedati['h_id_province']." AND his_l_code=".$row_forush_varedati['h_l_code']." AND his_id_year='$sellYearId'");
	        $havale_forush_bet_per2=$row_forush_varedati['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
			$havale_forush_between_varedati+=$havale_forush_bet_per2;
		  }
		  //مقدار کل ابطالی ها مابین تاریخ
	       /******حالت داخلی******/		 	  
		   $q_ebtal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON sell.dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON sell.dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            WHERE dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND his_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_dakheli_sell AND($Condition_ostan_ebtal_sell) AND($Condition_anbar_ebtal_sell)";
		   $res_ebtal_dakheli=$db->query($q_ebtal_dakheli);
	       $meghdar_ebtali_dakheli=$db->fetch_array($res_ebtal_dakheli);	
		   $meghdar_ebtali_between_dakheli=$meghdar_ebtali_dakheli[0];
		   /******حالت وارداتی******/		 	  
		   $q_ebtal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON sell.dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON sell.dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            WHERE dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND his_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_varedati_sell AND($Condition_ostan_ebtal_sell) AND($Condition_anbar_ebtal_sell)";
		   $res_ebtal_varedati=$db->query($q_ebtal_varedati);
	       $meghdar_ebtali_varedati=$db->fetch_array($res_ebtal_varedati);	
		   $meghdar_ebtali_between_varedati=$meghdar_ebtali_varedati[0];
	      //مانده حواله فروش
           $mande_forush_between_dakheli=$havale_forush_befor_dakheli+$havale_forush_between_dakheli-$meghdar_ebtali_between_dakheli-$tahvilghatee_dakheli;		 
           $mande_forush_between_varedati=$havale_forush_befor_varedati+$havale_forush_between_varedati-$meghdar_ebtali_between_varedati-$tahvilghatee_varedati;		 
		 }//END else gheyr az konserv
    }//END noe_namayesh khales
	/**************************نوع نمایش ناخالص**********************************/
	if($noe_namayesh==2)
	{
	 /****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
     //فیلد اول-حالت داخلی
	  $mande_befor_dakheli=0;
	  $avaliye_dakheli=$db->get_from_where("SUM(mojody_nakhales_aval)","meat.mojody_kala","year='$mtActiveYear' AND deleted=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	  $jameVarede_befor_dakheli=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_befor_dakheli=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");	
	  $meghdarTadil_Ezafe_befor_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	  $meghdarTadil_Kasry_befor_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	  $mande_befor_dakheli=$avaliye_dakheli+$jameVarede_befor_dakheli-$jameSadere_befor_dakheli+$meghdarTadil_Ezafe_befor_dakheli-$meghdarTadil_Kasry_befor_dakheli;	      
	 //فیلد دوم -حالت وارداتی
	  $mande_befor_varedati=0;
	  $avaliye_varedati=$db->get_from_where("SUM(mojody_nakhales_aval)","meat.mojody_kala","year='$mtActiveYear' AND deleted=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $jameVarede_befor_varedati=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_befor_varedati=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");	
	  $meghdarTadil_Ezafe_befor_varedati=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $meghdarTadil_Kasry_befor_varedati=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");              
	  $mande_befor_varedati=$avaliye_varedati+$jameVarede_befor_varedati-$jameSadere_befor_varedati+$meghdarTadil_Ezafe_befor_varedati-$meghdarTadil_Kasry_befor_varedati;	      
     //فیلد سوم
	  $kharidghatee_dakheli=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $kharidghatee_varedati=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_jabejae_dakheli=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","(r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_jabejae_varedati=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","(r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_banader_dakheli=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND (r.code_mabda=56 OR r.code_mabda=57) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_banader_varedati=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND (r.code_mabda=56 OR r.code_mabda=57) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $tahvilghatee_dakheli=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $tahvilghatee_varedati=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $ersali_jabejae_dakheli=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $ersali_jabejae_varedati=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $tadil_ezafe_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","noe_tadil=1 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
	  $tadil_ezafe_varedati=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","noe_tadil=1 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
	  $tadil_kasry_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","noe_tadil=2 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
	  $tadil_kasry_varedati=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","noe_tadil=2 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
	 //فیلد هفدهم -حالت داخلی
	  $mande_nahayi_dakheli=0;
	  $jameVarede_dakheli=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_dakheli=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
      $meghdarTadil_Ezafe_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
      $meghdarTadil_Kasry_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
      $mande_nahayi_dakheli=$mande_befor_dakheli+$jameVarede_dakheli-$jameSadere_dakheli+$meghdarTadil_Ezafe_dakheli-$meghdarTadil_Kasry_dakheli;	      
     //فیلد هجدهم - حالت وارداتی
	  $mande_nahayi_varedati=0;
	  $jameVarede_varedati=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_varedati=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $meghdarTadil_Ezafe_varedati=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $meghdarTadil_Kasry_varedati=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $mande_nahayi_varedati=$mande_befor_varedati+$jameVarede_varedati-$jameSadere_varedati+$meghdarTadil_Ezafe_varedati-$meghdarTadil_Kasry_varedati;	      
	  //فیلد های حواله فروش همه صفر 
	  $havale_forush_between_dakheli=0;$havale_forush_between_varedati=0;$meghdar_ebtali_between_dakheli=0;$meghdar_ebtali_between_varedati=0;$mande_forush_between_dakheli=0;$mande_forush_between_varedati=0;
    }//END noe_namayesh nakhales
    /**************************نوع نمایش تعداد**********************************/
	if($noe_namayesh==3)
	{
	 /****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
     //فیلد اول-حالت داخلی
	  $mande_befor_dakheli=0;
	  $avaliye_dakheli=$db->get_from_where("SUM(tedad_karton_aval)","meat.mojody_kala","year='$mtActiveYear' AND deleted=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	  $jameVarede_befor_dakheli=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_befor_dakheli=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");	
	  $meghdarTadil_Ezafe_befor_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	  $meghdarTadil_Kasry_befor_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	  $mande_befor_dakheli=$avaliye_dakheli+$jameVarede_befor_dakheli-$jameSadere_befor_dakheli+$meghdarTadil_Ezafe_befor_dakheli-$meghdarTadil_Kasry_befor_dakheli;	      
	 //فیلد دوم -حالت وارداتی
	  $mande_befor_varedati=0;
	  $avaliye_varedati=$db->get_from_where("SUM(tedad_karton_aval)","meat.mojody_kala","year='$mtActiveYear' AND deleted=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $jameVarede_befor_varedati=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_befor_varedati=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");	
	  $meghdarTadil_Ezafe_befor_varedati=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $meghdarTadil_Kasry_befor_varedati=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");              
	  $mande_befor_varedati=$avaliye_varedati+$jameVarede_befor_varedati-$jameSadere_befor_varedati+$meghdarTadil_Ezafe_befor_varedati-$meghdarTadil_Kasry_befor_varedati;	      
     //فیلد سوم
	  $kharidghatee_dakheli=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $kharidghatee_varedati=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_jabejae_dakheli=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","(r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_jabejae_varedati=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","(r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_banader_dakheli=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND (r.code_mabda=56 OR r.code_mabda=57) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
	  $daryafti_banader_varedati=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND (r.code_mabda=56 OR r.code_mabda=57) AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");	  
	  $tahvilghatee_dakheli=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $tahvilghatee_varedati=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $ersali_jabejae_dakheli=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $ersali_jabejae_varedati=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","(h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $tadil_ezafe_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","noe_tadil=1 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
	  $tadil_ezafe_varedati=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","noe_tadil=1 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
	  $tadil_kasry_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","noe_tadil=2 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
	  $tadil_kasry_varedati=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","noe_tadil=2 AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
	  //فیلد هفدهم -حالت داخلی
	  $mande_nahayi_dakheli=0;
	  $jameVarede_dakheli=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_dakheli AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_dakheli=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_dakheli AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
      $meghdarTadil_Ezafe_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
      $meghdarTadil_Kasry_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
      $mande_nahayi_dakheli=$mande_befor_dakheli+$jameVarede_dakheli-$jameSadere_dakheli+$meghdarTadil_Ezafe_dakheli-$meghdarTadil_Kasry_dakheli;	      
     //فیلد هجدهم - حالت وارداتی
	  $mande_nahayi_varedati=0;
	  $jameVarede_varedati=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_resid_varedati AND($Condition_ostan_resid) AND($Condition_anbar_resid)");
      $jameSadere_varedati=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_havale_varedati AND($Condition_ostan_havale) AND($Condition_anbar_havale)");
	  $meghdarTadil_Ezafe_varedati=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $meghdarTadil_Kasry_varedati=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	  $mande_nahayi_varedati=$mande_befor_varedati+$jameVarede_varedati-$jameSadere_varedati+$meghdarTadil_Ezafe_varedati-$meghdarTadil_Kasry_varedati;	      
	  if($x_value!="کنسرو مرغ")
	  {$havale_forush_between_dakheli=0;$havale_forush_between_varedati=0;$meghdar_ebtali_between_dakheli=0;$meghdar_ebtali_between_varedati=0;$mande_forush_between_dakheli=0;$mande_forush_between_varedati=0;}
	  //اگر کنسرو باشد
	  else
	  {
		  //مانده از حواله فروش قبل از تاریخ
          //پیدا کردن آی دی سال مربوط به سیستم فروش
          $sellYearCode=substr($mtActiveYear,2);
          $sellYearId=$db->get_from_where("year_id","sell.dm_year","year_code='$sellYearCode'");
		  /******حالت داخلی******/		 
		  $havale_forush_befor_dakheli=0;
          $havale_forush_bef_dakheli=0;
		  $q_forush_befor_dakheli=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND  h_reg_date<'$date1_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $res_forush_befor_dakheli=$db->query($q_forush_befor_dakheli);
		  while($row_forush_befor_dakheli=$db->fetch_array($res_forush_befor_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  {
		   //پیدا کردن کد استان از روی آی دی
            $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_befor_dakheli['h_id_province']."");
           //پیدا کردن کد انباراز روی آی دی
            $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor_dakheli['h_id_province']." AND l_id=".$row_forush_befor_dakheli['h_l_code']."");  
			/**///محاسبه کل تحویلی برای این حواله
            $meghdar_tahvily_per1=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","h_code=".$row_forush_befor_dakheli['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	        /**///محاسبه کل باطله برای این حواله
            $db->selectDb('sell');
			$meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code=".$row_forush_befor_dakheli['h_code']." AND his_id_province=".$row_forush_befor_dakheli['h_id_province']." AND his_l_code=".$row_forush_befor_dakheli['h_l_code']." AND his_id_year='$sellYearId'");
	        $havale_forush_bef_dakheli=$row_forush_befor_dakheli['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
			 /**///محاسبه مقدار مانده از حواله فروش
 	        //مقدار کل ابطالی ها قبل از تاریخ
	        $q_ebtal_befor_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                WHERE his_p_code=".$row_forush_befor_dakheli['h_p_code']." AND his_h_code=".$row_forush_befor_dakheli['h_code']." AND his_id_province=".$row_forush_befor_dakheli['h_id_province']." AND his_l_code=".$row_forush_befor_dakheli['h_l_code']." AND his_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	        $res_ebtal_befor_dakheli=$db->query($q_ebtal_befor_dakheli);
	        $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_dakheli);	        
	        //حواله جنسی قبل از تاریخ
			$db->selectDb($mydatabase);
	        $sadere_befor=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail as h_d INNER JOIN meat.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.h_code=".$row_forush_befor_dakheli['h_code']." AND h_d.code_ostan='$code_ostan_forhavale' AND h_d.code_anbar='$code_anbar_forhavale' AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
	        //محاسبه مقدار حواله فروش قبل از تاریخ
		    $havale_forush_befor_per_dakheli=$havale_forush_bef_dakheli-$sadere_befor-$meghdar_ebtali_befor[0];
			$havale_forush_befor_dakheli+=$havale_forush_befor_per_dakheli;
		  }
		  /******حالت وارداتی******/		 	  
		  $havale_forush_befor_varedati=0;
          $havale_forush_bef_varedati=0;
		  $q_forush_befor_varedati=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND  h_reg_date<'$date1_milady' $kalaCondition_varedati_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $res_forush_befor_varedati=$db->query($q_forush_befor_varedati);
		  while($row_forush_befor_varedati=$db->fetch_array($res_forush_befor_varedati))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  {
		   //پیدا کردن کد استان از روی آی دی
            $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_befor_varedati['h_id_province']."");
           //پیدا کردن کد انباراز روی آی دی
            $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor_varedati['h_id_province']." AND l_id=".$row_forush_befor_varedati['h_l_code']."");  
		   /**///محاسبه کل تحویلی برای این حواله
            $meghdar_tahvily_per1=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","h_code=".$row_forush_befor_varedati['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	       /**///محاسبه کل باطله برای این حواله
            $db->selectDb('sell');
			$meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code=".$row_forush_befor_varedati['h_code']." AND his_id_province=".$row_forush_befor_varedati['h_id_province']." AND his_l_code=".$row_forush_befor_varedati['h_l_code']." AND his_id_year='$sellYearId'");
	        $havale_forush_bef_varedati=$row_forush_befor_varedati['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
			 /**///محاسبه مقدار مانده از حواله فروش
			//مقدار کل ابطالی هل قبل از تاریخ
	        $q_ebtal_befor_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                WHERE his_p_code=".$row_forush_befor_varedati['h_p_code']." AND his_h_code=".$row_forush_befor_varedati['h_code']." AND his_id_province=".$row_forush_befor_varedati['h_id_province']." AND his_l_code=".$row_forush_befor_varedati['h_l_code']." AND his_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	        $res_ebtal_befor_varedati=$db->query($q_ebtal_befor_varedati);
	        $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_varedati); 
			//حواله جنسی قبل از تاریخ
	        $db->selectDb($mydatabase);
	        $sadere_befor=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail as h_d INNER JOIN meat.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.h_code=".$row_forush_befor_varedati['h_code']." AND h_d.code_ostan='$code_ostan_forhavale' AND h_d.code_anbar='$code_anbar_forhavale' AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
	        //محاسبه مقدار حواله فروش قبل از تاریخ
		    $havale_forush_befor_per_varedati=$havale_forush_bef_varedati-$sadere_befor-$meghdar_ebtali_befor[0];
			$havale_forush_befor_varedati+=$havale_forush_befor_per_varedati;
		  }
		 //مقدار کل حواله فروش ها مابین تاریخ
		 /******حالت داخلی******/		 	  
		  $havale_forush_bet_per1=0;
          $havale_forush_between_dakheli=0;
		  $q_forush_dakheli=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $res_forush_dakheli=$db->query($q_forush_dakheli);
		  while($row_forush_dakheli=$db->fetch_array($res_forush_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  {
		   //پیدا کردن کد استان از روی آی دی
            $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_dakheli['h_id_province']."");
           //پیدا کردن کد انباراز روی آی دی
            $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_dakheli['h_id_province']." AND l_id=".$row_forush_dakheli['h_l_code']."");  
		   /**///محاسبه کل تحویلی برای این حواله
		   	$db->selectDb($mydatabase);
            $meghdar_tahvily_per2=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","h_code=".$row_forush_dakheli['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	        /**///محاسبه کل باطله برای این حواله
            $db->selectDb('sell');
			$meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code=".$row_forush_dakheli['h_code']." AND his_id_province=".$row_forush_dakheli['h_id_province']." AND his_l_code=".$row_forush_dakheli['h_l_code']." AND his_id_year='$sellYearId'");
	        $havale_forush_bet_per1=$row_forush_dakheli['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
			$havale_forush_between_dakheli+=$havale_forush_bet_per1;
		  }
		  /******حالت وارداتی******/		 	  
		  $havale_forush_bet_per2=0;
          $havale_forush_between_varedati=0;
		  $q_forush_varedati=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_varedati_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $res_forush_varedati=$db->query($q_forush_varedati);
		  while($row_forush_varedati=$db->fetch_array($res_forush_varedati))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  {
		   //پیدا کردن کد استان از روی آی دی
            $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_varedati['h_id_province']."");
           //پیدا کردن کد انباراز روی آی دی
            $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_varedati['h_id_province']." AND l_id=".$row_forush_varedati['h_l_code']."");  
		   /**///محاسبه کل تحویلی برای این حواله
		   	$db->selectDb($mydatabase);
			$meghdar_tahvily_per2=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","h_code=".$row_forush_varedati['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	       /**///محاسبه کل باطله برای این حواله
            $db->selectDb('sell');
			$meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code=".$row_forush_varedati['h_code']." AND his_id_province=".$row_forush_varedati['h_id_province']." AND his_l_code=".$row_forush_varedati['h_l_code']." AND his_id_year='$sellYearId'");
	        $havale_forush_bet_per2=$row_forush_varedati['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
			$havale_forush_between_varedati+=$havale_forush_bet_per2;
		  }
		  //مقدار کل ابطالی ها مابین تاریخ
	       /******حالت داخلی******/		 	  
		   $q_ebtal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON sell.dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON sell.dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            WHERE dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND his_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_dakheli_sell AND($Condition_ostan_ebtal_sell) AND($Condition_anbar_ebtal_sell)";
		   $res_ebtal_dakheli=$db->query($q_ebtal_dakheli);
	       $meghdar_ebtali_dakheli=$db->fetch_array($res_ebtal_dakheli);	
		   $meghdar_ebtali_between_dakheli=$meghdar_ebtali_dakheli[0];
		   /******حالت وارداتی******/		 	  
		   $q_ebtal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON sell.dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON sell.dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            WHERE dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND his_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_varedati_sell AND($Condition_ostan_ebtal_sell) AND($Condition_anbar_ebtal_sell)";
		   $res_ebtal_varedati=$db->query($q_ebtal_varedati);
	       $meghdar_ebtali_varedati=$db->fetch_array($res_ebtal_varedati);	
		   $meghdar_ebtali_between_varedati=$meghdar_ebtali_varedati[0];
	      //مانده حواله فروش
           $mande_forush_between_dakheli=$havale_forush_befor_dakheli+$havale_forush_between_dakheli-$meghdar_ebtali_between_dakheli-$tahvilghatee_dakheli;		 
           $mande_forush_between_varedati=$havale_forush_befor_varedati+$havale_forush_between_varedati-$meghdar_ebtali_between_varedati-$tahvilghatee_varedati;		 
		 }//END else konserv
    }//END noe_namayesh tedad
    //نمایش اطلاعات
	echo'
		  <td>'.round($mande_befor_dakheli,3).'</td>
		  <td>'.round($mande_befor_varedati,3).'</td>
		  <td>'.round($kharidghatee_dakheli,3).'</td>
		  <td>'.round($kharidghatee_varedati,3).'</td>
		  <td>'.round($daryafti_jabejae_dakheli,3).'</td>
		  <td>'.round($daryafti_jabejae_varedati,3).'</td>
		  <td>'.round($daryafti_banader_dakheli,3).'</td>
		  <td>'.round($daryafti_banader_varedati,3).'</td>
		  <td>'.round($tahvilghatee_dakheli,3).'</td>
		  <td>'.round($tahvilghatee_varedati,3).'</td>
		  <td>'.round($ersali_jabejae_dakheli,3).'</td>
		  <td>'.round($ersali_jabejae_varedati,3).'</td>
		  <td>'.round($tadil_ezafe_dakheli,3).'</td>
		  <td>'.round($tadil_ezafe_varedati,3).'</td>
		  <td>'.round($tadil_kasry_dakheli,3).'</td>
		  <td>'.round($tadil_kasry_varedati,3).'</td>
		  <td>'.round($mande_nahayi_dakheli,3).'</td>
		  <td>'.round($mande_nahayi_varedati,3).'</td>
		  <td>'.round($havale_forush_between_dakheli,3).'</td>
		  <td>'.round($havale_forush_between_varedati,3).'</td>
		  <td>'.round($meghdar_ebtali_between_dakheli,3).'</td>
		  <td>'.round($meghdar_ebtali_between_varedati,3).'</td>
		  <td>'.round($mande_forush_between_dakheli,3).'</td>
		  <td>'.round($mande_forush_between_varedati,3).'</td>
	  </tr>';
	  $jame_mande_befor_dakheli+=$mande_befor_dakheli;
	  $jame_mande_befor_varedati+=$mande_befor_varedati;
	  $jame_kharidghatee_dakheli+=$kharidghatee_dakheli;
	  $jame_kharidghatee_varedati+=$kharidghatee_varedati;
	  $jame_daryafti_jabejae_dakheli+=$daryafti_jabejae_dakheli;
	  $jame_daryafti_jabejae_varedati+=$daryafti_jabejae_varedati;
	  $jame_daryafti_banader_dakheli+=$daryafti_banader_dakheli;
	  $jame_daryafti_banader_varedati+=$daryafti_banader_varedati;
	  $jame_tahvilghatee_dakheli+=$tahvilghatee_dakheli;
	  $jame_tahvilghatee_varedati+=$tahvilghatee_varedati;
	  $jame_ersali_jabejae_dakheli+=$ersali_jabejae_dakheli;
	  $jame_ersali_jabejae_varedati+=$ersali_jabejae_varedati;
	  $jame_tadil_ezafe_dakheli+=$tadil_ezafe_dakheli;
	  $jame_tadil_ezafe_varedati+=$tadil_ezafe_varedati;
	  $jame_tadil_kasry_dakheli+=$tadil_kasry_dakheli;
	  $jame_tadil_kasry_varedati+=$tadil_kasry_varedati;
	  $jame_mande_nahayi_dakheli+=$mande_nahayi_dakheli;
	  $jame_mande_nahayi_varedati+=$mande_nahayi_varedati;
	  $jame_havale_forush_between_dakheli+=$havale_forush_between_dakheli;
	  $jame_havale_forush_between_varedati+=$havale_forush_between_varedati;
	  $jame_meghdar_ebtali_between_dakheli+=$meghdar_ebtali_between_dakheli;
	  $jame_meghdar_ebtali_between_varedati+=$meghdar_ebtali_between_varedati;
	  $jame_mande_forush_between_dakheli+=$mande_forush_between_dakheli;
	  $jame_mande_forush_between_varedati+=$mande_forush_between_varedati;
	  /*****تکرار سرصفحه و ستون ها*****/
	   if($line>=$MaxLines && $i <$cntr) 
	   {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
	   }
	 }//END foreach
	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="2">جمع کل</td>';
	   echo '<td>'.round($jame_mande_befor_dakheli,3).'</td>';
	   echo '<td>'.round($jame_mande_befor_varedati,3).'</td>';
	   echo '<td>'.round($jame_kharidghatee_dakheli,3).'</td>';
	   echo '<td>'.round($jame_kharidghatee_varedati,3).'</td>';
	   echo '<td>'.round($jame_daryafti_jabejae_dakheli,3).'</td>';
	   echo '<td>'.round($jame_daryafti_jabejae_varedati,3).'</td>';
	   echo '<td>'.round($jame_daryafti_banader_dakheli,3).'</td>';
	   echo '<td>'.round($jame_daryafti_banader_varedati,3).'</td>';
	   echo '<td>'.round($jame_tahvilghatee_dakheli,3).'</td>';
	   echo '<td>'.round($jame_tahvilghatee_varedati,3).'</td>';
	   echo '<td>'.round($jame_ersali_jabejae_dakheli,3).'</td>';
	   echo '<td>'.round($jame_ersali_jabejae_varedati,3).'</td>';
	   echo '<td>'.round($jame_tadil_ezafe_dakheli,3).'</td>';
	   echo '<td>'.round($jame_tadil_ezafe_varedati,3).'</td>';
	   echo '<td>'.round($jame_tadil_kasry_dakheli,3).'</td>';
	   echo '<td>'.round($jame_tadil_kasry_varedati,3).'</td>';
	   echo '<td>'.round($jame_mande_nahayi_dakheli,3).'</td>';
	   echo '<td>'.round($jame_mande_nahayi_varedati,3).'</td>';
	   echo '<td>'.round($jame_havale_forush_between_dakheli,3).'</td>';
	   echo '<td>'.round($jame_havale_forush_between_varedati,3).'</td>';
	   echo '<td>'.round($jame_meghdar_ebtali_between_dakheli,3).'</td>';
	   echo '<td>'.round($jame_meghdar_ebtali_between_varedati,3).'</td>';
	   echo '<td>'.round($jame_mande_forush_between_dakheli,3).'</td>';
	   echo '<td>'.round($jame_mande_forush_between_varedati,3).'</td>';
	 echo'
	 </tr>';
	 //END//
	 echo'
  </table>
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
  <table width="98%" border="1" align="center">
   <tr class="print_footer">
    <td colspan="9">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
}
echo'	
</form>
</body>
</html>';	
?>