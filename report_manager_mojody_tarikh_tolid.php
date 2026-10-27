<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_tarikh_tolid.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش موجودی استان ها به تفکیک تاریخ تولید';
//پیدا کردن آی دی سال مربوط به سیستم فروش
//$sellYearCode=substr($mtActiveYear,2);
//$sellYearId=$db->get_from_where("year_id","sell.dm_year","year_code='$sellYearCode'");
/****************هدر******************/
Function print_header()
{global $count,$titr,$mahshamsiArr,$mt_gl_owner,$code_kala,$sal_tolid_shamsi_1,$sal_tolid_shamsi_2,$mah_tolid_shamsi_1,$mah_tolid_shamsi_2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$Condition;
 echo'
   <br/>   
   <table width="98%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
   	<tr><td class="print_title_2">'.$titr.'</td></tr>
	<tr>
     <td class="print_title_2">
	   از تاریخ : '.$sal_tolid_shamsi_1.$mah_tolid_shamsi_1.' تا تاریخ : '.$sal_tolid_shamsi_2.$mah_tolid_shamsi_2.'
	 </td>
	</tr>
	<tr>
	 <td class="print_title_2"> &nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	 </td>
    </tr>
   </table>
   <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="print_table-title2">
	 <td width="5%">ردیف</td>
	 <td width="10%">استان</td>'; 
	 $sal=$sal_tolid_shamsi_1;
	 $mah=$mah_tolid_shamsi_1;
	 $counter=0;
	 $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	 if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	 else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 // if($sal_tolid_shamsi_1==$sal_tolid_shamsi_2)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	 // else $mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	 {	  	   	  
	   echo'<td>'.$mahshamsiArr[$mah].$sal.'</td>';
	   if($mah==12)
	   {$mah=1;$sal++;}
	  else $mah++;
	  $counter++;
	 }
	 echo'
	 <td width="15%">جمع</td>
	</tr>';
	
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
function enterCodeKala(code_kala)
{
  $("#loading").fadeIn("fast");
  $.post("ajax_error.php",{codeKALA_Error:code_kala},function(data){$("#codeK_Error").html(data);});
  $("#loading").fadeOut("fast");				
}
</script> 
</head>';
/****************فیلترها روی گزارش******************/
/************************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $val ) 
      {
       $Condition_ostan_temp.=" code_ostan='$val' OR";
      }
      if($val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{$Condition_ostan=' code_ostan='.$_SESSION['mt_code_ostan'].'';}
/*****************************انبارها****************************/
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
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.sal_tolid_shamsi_1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=10;
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
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <!--<tr class="tr1">
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td>	
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
	</tr>-->
    <tr class="tr1">	   
     <td align="left"> از تاریخ : </td>
	 <td align="right">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_1" value="'.$sal_tolid_shamsi_1.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_1",$mah_tolid_shamsi_1,"mahshamsiArr",1,"class='text4'").'
	</tr>
    <tr class="tr1">	   
     <td align="left"> تا تاریخ : </td>
	 <td align="right">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_2" value="'.$sal_tolid_shamsi_2.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_2",$mah_tolid_shamsi_2,"mahshamsiArr",1,"class='text4'").'
	</tr>
    <tr class="tr1">
	 <td align="left"><span class="star">*</span> کد کالا : </td>
     <td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	  include ("img_helpkala.php");
 	  echo'&nbsp;<span style="color:red" id="codeK_Error">&nbsp;</span></td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>	
    </tr>
    <tr class="tr1">	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left"> نام استان : </td>
      <td align="right">
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
 //اگر کاربر تاریخ اول را وارد نکرده بود
 if(!$sal_tolid_shamsi_1)$sal_tolid_shamsi_1='1393';  
 //اگر کاربر تاریخ دوم را وارد نکرده بود
 if(!$sal_tolid_shamsi_2)$sal_tolid_shamsi_2=$yy; 	  
/****************شروع نمایش گزارش*******************/	
$radif=1;
$page=1;
$line=0;
$i=0;
$cntr=0;
$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane) AND($Condition_ostan) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
 <br/>
 <table width="98%" border="1" align="center">
  <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
  <tr><td class="print_title_2">'.$titr.'</td></tr>
  <tr><td class="print_title_2">از تاریخ : '.$date1.' تا تاریخ : '.$date2.'</td> </tr>
   <tr>
	<td class="print_title_2">
	   	<span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
	     &nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	</td>
   </tr>
  </table>';
/*سطر نمایش فیلترها*/
if(($ostanchoice))
{
	 if($val==-1)$filter_string1='همه استانها';
	 else $filter_string1=' استان : ';
	 foreach($ostanchoice as $key => $val) {
	  $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$val'");
	  $filter_string1.=''.$nameOstan.'&nbsp;';
     }
}
if($noe_namayesh==1) $filter_string2.="نمایش اطلاعات : خالص";
if($noe_namayesh==2) $filter_string2.="نمایش اطلاعات : ناخالص";
if($noe_namayesh==3) $filter_string2.="نمایش اطلاعات : تعداد";
if($ostanchoice)
 {echo'<table class="filter_text" width="98%" border="0" align="center"><tr><td>فیلتر شده براساس : '.$filter_string1. $filter_string2.'</td></tr></table>';}
  echo'
  <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
   <tr class="print_table-title2">
	 <td width="5%">ردیف</td>
	 <td width="10%">استان</td>';
     // for($sal=$sal_tolid_shamsi_1; $sal<=$sal_tolid_shamsi_2; $sal++)
	 // {  
	    // if($sal==$sal_tolid_shamsi_1) 
		 // {
		  // for($mah=$mah_tolid_shamsi_1; $mah<=12; $mah++)
	      // echo'<td>'.$mahshamsiArr[$mah].$sal.'</td>';
		 // }
		 // else if($sal==$sal_tolid_shamsi_2)
		 // {
		  // for($mah=1; $mah<=$mah_tolid_shamsi_2; $mah++)
	      // echo'<td>'.$mahshamsiArr[$mah].$sal.'</td>';
		 // }
		 // else		  
		 // {for($mah=1; $mah<=12; $mah++)
	       // echo'<td>'.$mahshamsiArr[$mah].$sal.'</td>';
		 // }
	 // }
	 $sal=$sal_tolid_shamsi_1;
	 $mah=$mah_tolid_shamsi_1;
	 $counter=0;
	 $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	 if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	 else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 // if($sal_tolid_shamsi_1==$sal_tolid_shamsi_2)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	 // else $mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	 {	  	   	  
	   echo'<td>'.$mahshamsiArr[$mah].$sal.'</td>';
	   if($mah==12)
	   {$mah=1;$sal++;}
	  else $mah++;
	  $counter++;
	 }
	 
	 echo'
	 <td width="15%">جمع</td>'; 
   while($row=$db->fetch_array($res))//ostan while
   {	
    $line++;
	if($i++%2)echo'<tr class="print_table-odd">';
    else echo'<tr class="print_table-even">';
    echo'   
    <td>'.$radif++.'</td>
    <td>'.$row['name_ostan'].'</td>';

	 /**************************نوع نمایش خالص**********************************/
	 // if($noe_namayesh==1)
	 // {
	 // /****************محاسبه مانده موجودی*******************/		  
     // //فیلد اول-حالت داخلی
	  // $mande_befor_dakheli=0;
	  // $avaliye_dakheli=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala","year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND code_kala=$code_kala AND deleted=0 and($Condition_anbar)");     	  
	  // $jameVarede_befor_dakheli=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_resid_dakheli AND($Condition_anbar_resid)");
      // $jameSadere_befor_dakheli=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.code_ostan=".$row['code_ostan']." AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_havale_dakheli  AND($Condition_anbar_havale)");	
	  // $meghdarTadil_Ezafe_befor_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_anbar)");     
	  // $meghdarTadil_Kasry_befor_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_anbar)");     
	  // $mande_befor_dakheli=$avaliye_dakheli+$jameVarede_befor_dakheli-$jameSadere_befor_dakheli+$meghdarTadil_Ezafe_befor_dakheli-$meghdarTadil_Kasry_befor_dakheli;	      
    // }//END noe_namayesh khales
	/**************************نوع نمایش ناخالص**********************************/
	if($noe_namayesh==2)
	{
	 /****************محاسبه مانده موجودی *******************/		  
     //فیلد اول-حالت داخلی
	  $mande_befor_dakheli=0;
	  $avaliye_dakheli=$db->get_from_where("SUM(mojody_nakhales_aval)","meat.mojody_kala","year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND deleted=0 $kalaCondition_dakheli and($Condition_anbar)");     
	  $jameVarede_befor_dakheli=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_resid_dakheli  AND($Condition_anbar_resid)");
      $jameSadere_befor_dakheli=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.code_ostan=".$row['code_ostan']." AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_havale_dakheli  AND($Condition_anbar_havale)");	
	  $meghdarTadil_Ezafe_befor_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_anbar)");     
	  $meghdarTadil_Kasry_befor_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_anbar)");     
	  $mande_befor_dakheli=$avaliye_dakheli+$jameVarede_befor_dakheli-$jameSadere_befor_dakheli+$meghdarTadil_Ezafe_befor_dakheli-$meghdarTadil_Kasry_befor_dakheli;	      
	 }//END noe_namayesh nakhales
    /**************************نوع نمایش تعداد**********************************/
	if($noe_namayesh==3)
	{
	 /****************محاسبه مانده موجودی*******************/		  
     //فیلد اول-حالت داخلی
	  $mande_befor_dakheli=0;
	  $avaliye_dakheli=$db->get_from_where("SUM(tedad_karton_aval)","meat.mojody_kala","year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND deleted=0 $kalaCondition_dakheli and($Condition_anbar)");     
	  $jameVarede_befor_dakheli=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_resid_dakheli  AND($Condition_anbar_resid)");
      $jameSadere_befor_dakheli=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail h_d INNER JOIN meat.havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.year='$mtActiveYear' AND h_d.code_ostan=".$row['code_ostan']." AND h_d.havale_deleted=0 AND h_d.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_havale_dakheli  AND($Condition_anbar_havale)");	
	  $meghdarTadil_Ezafe_befor_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_anbar)");     
	  $meghdarTadil_Kasry_befor_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody","year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_anbar)");     
	  $mande_befor_dakheli=$avaliye_dakheli+$jameVarede_befor_dakheli-$jameSadere_befor_dakheli+$meghdarTadil_Ezafe_befor_dakheli-$meghdarTadil_Kasry_befor_dakheli;	      
	}//END noe_namayesh tedad
    //نمایش اطلاعات
	// echo'
		  // <td>'.round($mande_befor_dakheli,3).'</td>';
	    // $jame_mande_befor_dakheli+=$mande_befor_dakheli;	  
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
   }//END ostan while
   /*****سطر جمع کل استان ها*****/
   echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="2">جمع کل</td>';
	   echo '<td>'.round($jame_mande_befor_dakheli,3).'</td>';
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
 }//END IF//وجود اطلاعات
  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'	
</form>
</body>
</html>';	
?>