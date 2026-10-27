<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_resid_mt.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
Function print_header()
{global $mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$noe_namayesh;
 echo'
    <tr>
     <td colspan="18">
      <table width="100%" border="1" align="center">
       <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr><td class="print_title_2"> انبار : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
      </table>
     </td>
    </tr> 
   	<tr>
     <td class=title colspan="18">
	  <span style="float:right"><a href="javascript:window.print();"><img src="images/printer.png" onmouseOver="this.src=\'images/Printer_hover.png\'" onmouseOut="this.src=\'images/printer.png\'" title="چاپ"  id="IMG1" class="hideatprint"/></a></span>
	  گزارش براساس رسید انبار از تاریخ  : '.$date1.' تا تاریخ : '.$date2.'
      <div onClick="window.location=\''.$FileName.'\'" id="btn-back" style="float:left;" title="بازگشت"><a href="#"></a></div>
	 </td>
	</tr>
	<tr class="print_table-title2" style="height:60px;">
	 <td>شماره رسید</td>
	 <td>تاریخ رسید</td>
	 <td>نام کالا</td>
	 <td>نام کشور</td>
	 <td >نوع تحویل بار</td>
	 <td>نام کشتی</td>
	 <td >نام استان مبدأ</td>
	 <td >نام انبار مبدأ</td>
	 <td>نوع تخلیه</td>
	 <td>نوع بسته بندی</td>
	 <td>شرکت حمل کننده</td>
	 <td>شماره بارنامه</td>
	 <td>شماره کامیون</td>
	 <td >شماره باسکول</td> 
	 <td>وضعیت</td>
	 <td>وزن مبدأ</td>';
	 if($noe_namayesh==1) echo '<td>وزن خالص</td>';
	 if($noe_namayesh==2) echo '<td>وزن ناخالص</td>';
	 if($noe_namayesh==3) echo '<td>تعداد کارتن</td>';
	 echo'
	   <!--<td>وزن مقصد</td>-->
	   <!--<td width=10%>مانده موجودی</td>-->
	 <td>مبلغ پرداختی</td>
	</tr>';
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>گزارش براساس رسید انبار</title>
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
function getAnbareOstan(code_ostan)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{codeOSTAN1:code_ostan},function(data){$("#code_anbar").html(data);});
  $("#loading").fadeOut("fast");		
}
</script> 
</head>';
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" border="0" cellspacing="0">';
if(!$ok)
{
 echo'
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td colspan="4" class="title">گزارش براساس رسید انبار</td>	 
    </tr>';
	echo'
	<tr class="tr1">	
     <td align="left" width="20%"> از تاریخ : </td><td align="right" width="30%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td>
     <td align="left" width="20%"> تا تاریخ : </td><td align="right" width="30%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">';
	 //اضافه کردن صفر پشت کد استان		
	 if(strlen($mt_gl_code_ostan)==1) {$code_a=make_pattern($mt_gl_code_ostan,2);}
     else{$code_a=$mt_gl_code_ostan;}	
    echo'
	 <td align="left"> از شماره رسید : </td><td align="right">&nbsp;<input type="text" class="textboxme2" name="shomare1" value="'.$shomare1.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
     <td align="left"> تا شماره رسید : </td><td align="right">&nbsp;<input type="text" class="textboxme2" name="shomare2" value="'.$shomare2.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
	</tr>
	<tr class="tr1">
     <td align="left"> کد کالا : </td>
     <td align="right">&nbsp;<input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	  include ("img_helpkala.php");
     echo
	 '</td>
	 <!--<td align="left"> نام کشتی : </td><td align="right">&nbsp;'.listbox("code_skk",$row['code_skk'],"code_skk","name_skk","keshty","","class='text4'").'</td>-->
	 <td align="left"> کد کشتی : </td>
	 <td align="right">&nbsp;<input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;
	   ';
	 include ("img_helpkeshty.php");
	echo'
	</tr>
	<tr class="tr1">	
     <td align="left"> نوع تحویل بار : </td>
	 <td align="right">&nbsp;<select name="noe_tahvil_bar" class="text4">
					          <option value="0">انتخاب کنید</option>
					          <option value="1">تخلیه در انبار</option>
					          <option value="2">تحویل روباری</option>
					          <option value="3">حمل با راه آهن</option>
					          <option value="4">جابه جایی</option>
					         </select>
     <td align="left"> نوع بسته بندی : </td><td align="right">&nbsp;'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","","class='text4'").'</td>
	</tr>
	<tr class="tr1">	
     <td align="left"> شرکت حمل کننده : </td><td align="right">&nbsp;'.listbox("code_peymankar_haml",$code_peymankar_haml,"code_peymankar_haml","name_peymankar_haml","peymankar_haml","","class='text4'","").'</td>
     <td align="left"> وضعیت رسید : </td>
	 <td align="right">&nbsp;<select name="status" class="text4">
					          <option value="2">انتخاب کنید</option>
					          <option value="0">جاری</option>
					          <option value="1">ابطالی</option>
					         </select>
    </tr>
    <tr class="tr1">	
     <td align="left"> شماره بارنامه : </td><td align="right">&nbsp;<input type="text" class="textboxme2" name="barname_no" value="'.$barname_no.'"/></td>
 	 <td align="left"> شماره کاميون : </td><td align="right">&nbsp;<input type="text" class="textboxme2" name="kamion_no" value="'.$kamion_no.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> شماره باسکول : </td><td align="right">&nbsp;<input type="text" class="textboxme2"  name="shomare_baskul" value="'.$shomare_baskul.'"/></td>
	 <td align="left"> نوع تخلیه : </td><td align="right">&nbsp;'.listbox("code_takhlie",$code_takhlie,"code_takhlie","sharh_takhlie","takhlie","","class='text4'","").'</td>
	</tr>
	<tr class="tr1">
	 <td align="left"><span class="star">*</span>  نمایش اطلاعات : </td>
	 <td align="right">&nbsp; '.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>
	 <td colspan="2">&nbsp</td>
	</tr>
    <tr class="tr1">	
	 <td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" id="sabt" value="شروع گزارش"></td>
	</tr> 
    <tr class="footer"><td  colspan="4">&nbsp;</td></tr>
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
    $Condition="";
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
    if ($date1) {$Condition.=" and tarikh_resid>='$date1'";//از تاریخ
	            }
    if ($date2) {$Condition.=" and tarikh_resid<='$date2'";//تا تاریخ 
                }				 
    if ($shomare1)//از شماره رسید
    { 
     $sh_part1_1=substr($shomare1,0,2);
     $sh_part1_2=substr($shomare1,2,3);
     $sh_part1_3=substr($shomare1,5,5);
     $Condition.=" and shomare_resid>='$shomare1'";      
    }
    if ($shomare2)//تا شماره رسید
    {
     $sh_part2_1=substr($shomare2,0,2);
     $sh_part2_2=substr($shomare2,2,3);
     $sh_part2_3=substr($shomare2,5,5);
	 $Condition.=" and shomare_resid<='$shomare2'";
    }    
     //if ($code_kala) $Condition.=" and resid.code_kala='$code_kala'";//کد کالا 
     
	 if ($code_skk) $Condition.=" and resid.code_skk='$code_skk'";//کد کشتی 
     if ($noe_tahvil_bar) $Condition.=" and noe_tahvil_bar='$noe_tahvil_bar'";//نوع تحویل بار
     if ($code_bastebandy) $Condition.=" and bastebandy.code_bastebandy='$code_bastebandy'";//نوع بسته بندی
	 if ($code_peymankar_haml) $Condition.=" and resid.code_peymankar_haml='$code_peymankar_haml'";//کد پیمانکار 
     if (isset($status)and($status=='0')) $Condition.=" and status=0";//وضعیت رسید 	 
     if (isset($status)and($status=='1')) $Condition.=" and status=1";//وضعیت رسید 	 
     if (isset($status) and ($status=='2')) $Condition.="";//وضعیت رسید
	 if ($barname_no) $Condition.=" and resid.barname_no='$barname_no'";//شماره بارنامه
     if ($kamion_no) $Condition.=" and resid.kamion_no='$kamion_no'";//شماره کامیون 
	 if ($shomare_baskul) $Condition.=" and shomare_baskul='$shomare_baskul'";//شماره باسکول 
	 if ($code_takhlie) $Condition.=" and resid.code_takhlie='$code_takhlie'";//نوع تخلیه
	
	/****************شروع نمایش گزارش*******************/				
	// $q="SELECT resid.*,r_d.code_kala,kala.name_kala,kala.code_bastebandy,bastebandy.sharh_bastebandy,keshty.name_skk,takhlie.sharh_takhlie,peymankar_haml.name_peymankar_haml,ostan.name_ostan,list_sardkhane.name_anbar
	    // FROM resid
        // INNER JOIN resid_detail r_d ON r_d.shomare_resid=resid.shomare_resid AND r_d.code_ostan=resid.code_ostan AND r_d.code_anbar=resid.code_anbar AND r_d.year=resid.year 		
        // LEFT JOIN kala ON r_d.code_kala=kala.code_kala    
        // LEFT JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy    
        // LEFT JOIN keshty ON keshty.code_skk=resid.code_skk    
        // LEFT JOIN takhlie ON takhlie.code_takhlie=resid.code_takhlie    
        // LEFT JOIN peymankar_haml ON peymankar_haml.code_peymankar_haml=resid.code_peymankar_haml    
        // LEFT JOIN ostan ON ostan.code_ostan=resid.code_ostan_mabda    
        // LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=resid.code_anbar_mabda AND list_sardkhane.code_ostan=resid.code_ostan_mabda
		// WHERE 1=1 $Condition AND resid.code_ostan='$mt_gl_code_ostan' AND resid.code_anbar='$mt_gl_code_anbar' AND resid.year='$mtActiveYear' AND resid.deleted=0 ORDER BY tarikh_resid";			
	
	$q="SELECT resid.*,r_d.code_kala,r_d.code_keshvar,kala.name_kala,kala.code_bastebandy,keshvar.name_keshvar,bastebandy.sharh_bastebandy,keshty.name_skk,takhlie.sharh_takhlie,peymankar_haml.name_peymankar_haml,ostan.name_ostan,list_sardkhane.name_anbar
	    FROM resid
        INNER JOIN resid_detail r_d ON r_d.shomare_resid=resid.shomare_resid AND r_d.code_ostan=resid.code_ostan AND r_d.code_anbar=resid.code_anbar AND r_d.year=resid.year 		
        INNER JOIN kala ON r_d.code_kala=kala.code_kala    
        INNER JOIN keshvar ON r_d.code_keshvar=keshvar.code_keshvar    
        INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy    
        LEFT JOIN keshty ON keshty.code_skk=resid.code_skk    
        LEFT JOIN takhlie ON takhlie.code_takhlie=resid.code_takhlie    
        LEFT JOIN peymankar_haml ON peymankar_haml.code_peymankar_haml=resid.code_peymankar_haml    
        LEFT JOIN ostan ON ostan.code_ostan=resid.code_ostan_mabda    
        LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=resid.code_anbar_mabda AND list_sardkhane.code_ostan=resid.code_ostan_mabda
		WHERE 1=1 $Condition AND resid.code_ostan='$mt_gl_code_ostan' AND resid.code_anbar='$mt_gl_code_anbar' AND resid.year='$mtActiveYear' AND resid.deleted=0 ORDER BY tarikh_resid";			
		
	$res=$db->query($q);
	//اگر رسیدی پیدا شد
	if(mysql_num_rows($res)>0)
	{
     $myAnbarName=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");//نام انبار خودمان	
	 while($row=$db->fetch_assoc($res))
	 {if ($Line>=$RowPerPage)
	  {	    
	   print_header();
	   $Line=0; 
      }
	  $Line++;
	  if($Cntr++%2)echo'<tr class="print_table-odd_small">';
      else echo'<tr class="print_table-even_small">';
	  //اضافه کردن صفر پشت کد استان
	    if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
        else $code_a=$row['code_ostan'];
       echo'
	    <td>'.$code_a.$row['code_anbar'].$row['shomare_resid'].'</td>
	    <td>'.$row['tarikh_resid'].'</td>
	    <td>'.$row['name_kala'].'</td>
	    <td>'.$row['name_keshvar'].'</td>
	    <td>'.$tahvilbarArr[$row['noe_tahvil_bar']].'</td>
	    <td>'.$row['name_skk'].'</td>
	    <td>'.$row['name_ostan'].'</td>
	    <td>'.$row['name_anbar'].'</td>
	    <td>'.$row['sharh_takhlie'].'</td>
	    <td>'.$row['sharh_bastebandy'].'</td>
	    <td>'.$row['name_peymankar_haml'].'</td>
	    <td>'.$row['barname_no'].'</td>
	    <td>'.$row['kamion_no'].'</td>
	    <td>'.$row['shomare_baskul'].'</td>
	    <td>';if($row['status']==0) echo 'جاری';else echo 'ابطالی </td>';
	    $vazn_mabda_r=$db->get_from_where("SUM(vazn_mabda_r_d)","resid_detail r_d","shomare_resid='".$row['shomare_resid']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0 AND status=0");
	    $mablagh_pardakhty=paskeraye($row['shomare_resid'],$row['code_ostan'],$row['code_anbar'],$row['year']);
		echo'
	    <td>'.($vazn_mabda_r).'</td>';
		//درحالت خالص
		 if($noe_namayesh==1) echo'<td>'.($row['vazn_khales_r']).'</td>';
		//در حالت ناخالص
		if($noe_namayesh==2) 
		{
		  $vazn_nakhales_r=nakhales_resid($row['shomare_resid'],$row['code_ostan'],$row['code_anbar'],$row['year']);
		  echo'<td>'.($vazn_nakhales_r).'</td>';
		} 
		//تعداد کارتن
		if($noe_namayesh==3)
		{
		 $tedad_karton_r=karton_resid($row['shomare_resid'],$row['code_ostan'],$row['code_anbar'],$row['year']);
		 echo'<td>'.virgul($tedad_karton_r).'</td>';
		}
		echo'<td>'.virgul($mablagh_pardakhty).'</td>';   	
	    //echo'<td>'.virgul(($row['mablagh_pardakhty']),0,',').'</td>';   	
	  echo'
	  </tr>';
	 }
	 echo'<tr><td colspan="18">&nbsp;</td></tr> ';
      echo'
      <table width="600px" height="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">  
	   <tr class="title"><td>موجودی کالا</td></tr>
        <tr>
         <td height="100%">
          <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
           <table width="600px" border="1" align="center" cellpadding="0" cellspacing="0">';
	       if($code_kala)//فقط موجودی کالای انتخاب شده
	       {
	        //اگر برای کالای انتخاب شده هیچ رسیدی نبودموجودی را نمایش ندهد
	        $tedadkala=$db->get_from_where("count(code_kala)","resid","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
	        if($tedadkala!=0)
	        {
			 $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$code_kala."");//نام کالای مورد نظر
			 $mojodyKala=$db->get_from_where("mojody","mojody_kala","code_kala=".$code_kala."");//موجودی پایانی کالا   
	         echo'
              <tr class="print_table-title2">		 
		       <td>کد کالا</td>
		       <td>نام کالا</td>
		       <td>موجودی فعلی کالا</td>
		      </tr>';
	          $j=0;
	          if($j++%2)
              echo'<tr class="print_table-odd_small"/>';
              else echo '<tr class="print_table-even_small"/>';
              echo '<td>'.$code_kala.'</td>
	          <td>'.$nameKala.'</td>
		      <td>'.virgul($mojodyKala).'</td>';	 
	        }
	       }
	       else
	       {
	        //موجودی کالاهایی که رسید دارند نمایش داده شودودر بالا نمایش داده شده
	        $q4="SELECT mojody,code_kala FROM mojody_kala WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND 
	             (code_kala IN (SELECT resid.code_kala 
	              FROM resid 
                  LEFT JOIN kala ON resid.code_kala=kala.code_kala    
                  LEFT JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy    
                  LEFT JOIN keshty ON keshty.code_skk=resid.code_skk    
                  LEFT JOIN takhlie ON takhlie.code_takhlie=resid.code_takhlie    
                  LEFT JOIN peymankar_haml ON peymankar_haml.code_peymankar_haml=resid.code_peymankar_haml    
                  WHERE 1=1 $Condition AND resid.code_ostan='$mt_gl_code_ostan' AND resid.code_anbar='$mt_gl_code_anbar' AND resid.year='$mtActiveYear' AND resid.deleted=0 ORDER BY tarikh_resid))";	
			//$q4="SELECT mojody,code_kala FROM mojody_kala WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND 
	            // (code_kala IN (SELECT code_kala FROM resid WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0))";
	        $res4=$db->query($q4);
	        echo'
               <tr class="print_table-title2"">		 
	        	  <td>کد کالا</td>
	        	  <td>نام کالا</td>
	        	  <td>موجودی فعلی کالا</td>
	        	 </tr>';
	        while($row4=$db->fetch_assoc($res4))
	        {
	         $j=0;
	         if($j++%2)
             echo'<tr class="print_table-odd_small"/>';
             else echo '<tr class="print_table-even_small"/>';
	         $nameKala2=$db->get_from_where("name_kala","kala","code_kala=".$row4['code_kala']."");//نام کالای مورد نظر
	         echo'<td>'.$row4['code_kala'].'</td>
	              <td>'.$nameKala2.'</td>
	              <td>'.virgul($row4['mojody']).'</td>';
	        }
            echo'
	        </tr>';
	       }
	       echo'
	       </table>
	      </div>
         </td>
        </tr>
       </table>';
      echo'
    </table>
   </div>
  </td>
 </tr>
 <!--پايان مرکز صفحه -->';
  echo'
  <table width="100%" border="1">
  <!-- چاپ زیرنویس-->
    <tr class="print_footer">
     <td colspan="3">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
    </tr>
 </table>';	 	 
}	
	 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
  echo'
 </table>
</div>';
}
echo'
</form>
</body>
</html>';	
?>