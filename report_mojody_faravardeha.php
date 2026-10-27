<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_mojody_faravardeha.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
/****************فیلترها روی گزارش******************/
//if($code_kala) $Condition.=" and code_kala='$code_kala'";
//کد های کالا
if(is_array($kalachoice))
{
//{while (list ($key, $val) = each ($kalachoice)) {
foreach($kalachoice as $key => $val ) {
  //echo "$key <br>";echo "$val <br>";
  $Condition_kala.=" code_kala='$val' OR";
 }
  if($val==-1)$Condition.="";
  else $Condition.=" and $Condition_kala";
 $lastSpacePosition = strrpos($Condition," ");
 //$textWithoutLastWord =substr($Condition,0,$lastSpacePosition);
 $Condition =substr($Condition,0,$lastSpacePosition);
}
/****************هدر******************/
Function print_header()
{global $mt_gl_owner,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$kalaName,$code_kala,$Condition;
 echo'
   <br/>   
   <table width="98%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
   	<tr><td class="print_title_2">گزارش وضعیت فرآورده ها به تفکیک محل نگهداری</td></tr>
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
   </table>
   <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">      
	<tr class="print_table-title2">
	 <td width="5%">ردیف</td>
	 <td width="10%">استان</td>
	 <td width="15%">انبار</td>
	 <td width="5%">نوع مالکیت</td>';
     $q_column="SELECT name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
	 $res_column=$db->query($q_column);
	 while($column=$db->fetch_assoc($res_column))
	 {echo'<td >'.$column['name_kala'].'</td>';}
	 echo'
	 <td width="15%">جمع</td>
	</tr>';
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>گزارش وضعیت فرآورده ها به تفکیک محل نگهداری</title>
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
	    showOn: "off",
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
	    changeYear: true
		}
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
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date2.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=4;
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)
{
  $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
} 
if(!$ok)
{
echo'
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">گزارش وضعیت فرآورده ها به تفکیک محل نگهداری</td>	 
    </tr>';
	echo'
    <tr class="tr1">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">
     <td align="left"> نام کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="kalachoice[]" size="6" style="width:300px;" multiple>';
	  $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']."</option>";
	  echo $kala_options;
	  echo'
	  </select>
	  <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  <!--<input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;-->
	  ';
      //include ("img_helpkala.php");
	  echo'
	  <!--<a class="tooltips" href="#"><img class="help" border="0" src="images/button-round-question-icon.png" style="cursor:pointer" onmouseOver="this.src=\'images/button-round-dark-question-icon.png\'" onmouseOut="this.src=\'images/button-round-question-icon.png\'"/>
	   <span style="width:380px">دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید</span>
	  </a>-->
	 </td>
	</tr>
	<!--<tr class="tr1">
     <td align="left"> زیرانبار : </td>
	 <td align="right">&nbsp;'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY code_ziranbar,name_ziranbar ASC","class='text4'","").'&nbsp;&nbsp;	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
    </tr>-->
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    
   </table>
   </div>
  </td>
 </tr>
</table> ';
}
else
{
    //اگر کاربر تاریخ دوم را وارد نکرده بود
    if(!$date2)
    {
     $today=AsLDate($yymmdd); 
      $end_date_session=$db->get_from_where("end_to","mt_docs","year='$mtActiveYear'");
     if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
    } 
	$dateCond="";
    $radif=1;
	/****************فیلترها روی گزارش******************/	
	//if($code_ziranbar) {$Condition.=" and code_ziranbar='$code_ziranbar'";}//زیرانبار 
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $ostan_condition='';
	else $ostan_condition=' AND code_ostan='.$_SESSION['mt_code_ostan'].'';
	$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane) $ostan_condition AND code_ostan!=90 ORDER BY name_ostan";
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
	 echo'
     <br/>
     <table width="98%" border="1" align="center">
      <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
      <tr><td class="print_title_2">گزارش وضعیت فرآورده ها به تفکیک محل نگهداری</td></tr>
	  <tr>
       <td class="print_title_2">
	    از تاریخ : '.$date1.' تا تاریخ : '.$date2.'
   	   </td>
   	  </tr>
	  <tr>
	   <td class="print_title_2">
	   	<span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
	     &nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	   </td>
	  </tr>
     </table>';
	 /*سطر نمایش فیلترها*/ 
	 if(($kalachoice)or($noe_namayesh))
	 {
	  if($val==-1)$filter_string.='همه کالاها';
	  else $filter_string.=' کالا : ';
	  foreach($kalachoice as $key => $val) {
	   $nameKala=$db->get_from_where("name_kala","kala","code_kala='$val'");
	   $filter_string.=''.$nameKala.'&nbsp;';
	  }
	  if($noe_namayesh) {$filter_string.=' نوع نمایش براساس : '.$namayeshArr[$noe_namayesh].'&nbsp;';}     
	  echo'<table class="filter_text" width="98%" border="0" align="center"><tr><td>فیلتر شده براساس : '.$filter_string.'</td></tr></table>';
	  }
	 echo'
     <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	  <tr class="print_table-title2" >
	   <!--<td height=300px style={vertical-align: bottom;}><div class="verticaltext"> ردیف</div></td>-->
	   <td  width="5%">ردیف</td>
	   <td  width="10%">استان</td>
	   <td  width="15%">انبار</td>
	   <td  width="5%">نوع مالکیت</td>';
       $q_column="SELECT name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
       $res_column=$db->query($q_column);
	   while($column=$db->fetch_assoc($res_column))
	   {echo'<td>'.$column['name_kala'].'</td>';}
	   echo'
	   <td  width="15%">جمع</td>
	  </tr>';
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  //تعداد انبار هر استان
	  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","code_ostan=".$row['code_ostan']."");//تعداد انبارهای هر استان 
	  else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای هر استان     
	  $rowanbar=$tedadanbar;
	  $t=$rowanbar;
	  //if($tedadanbar==0){$rowanbar=1;$t=1;}
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		 <td rowspan="'.$rowanbar.'">'.$radif++.'</td>
	     <td rowspan="'.$rowanbar.'">'.$row['name_ostan'].'</td>';
		   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM list_sardkhane WHERE code_ostan=".$row['code_ostan']."";
		   else $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."";
		   $res2=$db->query($q2);
		   while($row2=$db->fetch_assoc($res2))
		   {	   
			$j=$i+1;
			echo'
		     <td>'.$row2['code_anbar'].'-'.$row2['name_anbar'].'</td>
			 <td>'.$noe_malekiyatArr[$row2['noe_malekiyat']].'</td>';
			  $jame_mojody_anbar=0;//جمع موجودی کل کالاها در هر انبار
			  $s1=0;
			  $q3="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
              $res3=$db->query($q3);
	          while($row3=$db->fetch_assoc($res3))
	          {
			   //موجودی هر کالا در هر انبار
			   if($noe_namayesh==1)//درحالت خالص
	           {
			     $mojodyKhalesAval=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
			     $jameKhalesVarede_bef=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_anbar=".$row2['code_anbar']." AND r_k_d.code_kala=".$row3['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");
			     $jameKhalesSadere_bef=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_anbar=".$row2['code_anbar']." AND h_d.code_kala=".$row3['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
			     $KhalesTadil_Ezafe_bef=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $KhalesTadil_Kasry_bef=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $mojodyKhalesAval_bef=$mojodyKhalesAval+$jameKhalesVarede_bef-$jameKhalesSadere_bef+$KhalesTadil_Ezafe_bef-$KhalesTadil_Kasry_bef;
			     /**/			   
			     $jameKhalesVarede=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_anbar=".$row2['code_anbar']." AND r_k_d.code_kala=".$row3['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
			     $jameKhalesSadere=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_anbar=".$row2['code_anbar']." AND h_d.code_kala=".$row3['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
			     $KhalesTadil_Ezafe=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
			     $KhalesTadil_Kasry=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
                 $mojodyKala=$mojodyKhalesAval_bef+$jameKhalesVarede-$jameKhalesSadere+$KhalesTadil_Ezafe-$KhalesTadil_Kasry;			   
			     //mojody as field//$mojodyKala=$db->get_from_where("SUM(mojody)","mojody_kala","code_kala=".$row3['code_kala']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND deleted=0 GROUP BY code_kala");     
			   }
	           if($noe_namayesh==2)//درحالت ناخالص
	           {
			     $mojodyNaKhalesAval=$db->get_from_where("SUM(mojody_nakhales_aval)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
			     $jameNakhalesVarede_bef=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_anbar=".$row2['code_anbar']." AND r_k_d.code_kala=".$row3['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");
			     $jameNakhalesSadere_bef=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_anbar=".$row2['code_anbar']." AND h_d.code_kala=".$row3['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
			     $NakhalesTadil_Ezafe_bef=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $NakhalesTadil_Kasry_bef=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $mojodyNakhalesAval_bef=$mojodyNaKhalesAval+$jameNakhalesVarede_bef-$jameNakhalesSadere_bef+$NakhalesTadil_Ezafe_bef-$NakhalesTadil_Kasry_bef;
			     /**/			   
			     $jameNakhalesVarede=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_anbar=".$row2['code_anbar']." AND r_k_d.code_kala=".$row3['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
			     $jameNakhalesSadere=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_anbar=".$row2['code_anbar']." AND h_d.code_kala=".$row3['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
			     $NakhalesTadil_Ezafe=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
			     $NakhalesTadil_Kasry=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
                 $mojodyKala=$mojodyNakhalesAval_bef+$jameNakhalesVarede-$jameNakhalesSadere+$NakhalesTadil_Ezafe-$NakhalesTadil_Kasry;			   
			     //mojody as field//$mojodyKala=$db->get_from_where("SUM(mojody)","mojody_kala","code_kala=".$row3['code_kala']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND deleted=0 GROUP BY code_kala");     
			   }
			   if($noe_namayesh==3)//درحالت تعداد کارتن
	           {
			     $tedadKartonAval=$db->get_from_where("SUM(tedad_karton_aval)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
			     $jameKartonVarede_bef=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_anbar=".$row2['code_anbar']." AND r_k_d.code_kala=".$row3['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");
			     $jameKartonSadere_bef=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_anbar=".$row2['code_anbar']." AND h_d.code_kala=".$row3['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
			     $kartonTadil_Ezafe_bef=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $kartonTadil_Kasry_bef=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $tedadKartonAval_bef=$tedadKartonAval+$jameKartonVarede_bef-$jameKartonSadere_bef+$kartonTadil_Ezafe_bef-$kartonTadil_Kasry_bef;
			     /**/			   
			     $jameKartonVarede=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_anbar=".$row2['code_anbar']." AND r_k_d.code_kala=".$row3['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
			     $jameKartonSadere=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_anbar=".$row2['code_anbar']." AND h_d.code_kala=".$row3['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
			     $kartonTadil_Ezafe=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
			     $kartonTadil_Kasry=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
                 $mojodyKala=$tedadKartonAval_bef+$jameKartonVarede-$jameKartonSadere+$kartonTadil_Ezafe-$kartonTadil_Kasry;			   
			     //mojody as field//$mojodyKala=$db->get_from_where("SUM(mojody)","mojody_kala","code_kala=".$row3['code_kala']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND deleted=0 GROUP BY code_kala");     
			   }
			   echo '<td>'.round($mojodyKala,3).'</td>';
			   $jame_mojody_anbar+=$mojodyKala;//جمع موجودی کل کالاها در هر انبار  
			  }//END kala while
			  echo '<td>'.round($jame_mojody_anbar,3).'</td>';
			  $t--;
			  if($t==0) echo'';
			  else 
			  {
			   echo'</tr>';
			   if($j++%2)echo'<tr class="print_table-odd">';
               else echo'<tr class="print_table-even">';
			  }
		   }//END anbar while
		   /*****سطر جمع کل استان*****/
		   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
		   {
		   echo'
		   <tr class="print_table-even sum-row" style="background-color:#FFF;">
		    <td colspan="4">جمع کل استان</td>';
			$jame_mojody_ostan=0;//جمع موجودی کل کالاها در هر استان
			$q4="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
            $res4=$db->query($q4);
	        while($row4=$db->fetch_assoc($res4))
	        {
			   //مجموع موجودی هر کالا در هر استان
			   if($noe_namayesh==1)//درحالت خالص
	           {
			     $mojodyKhalesAval2=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
			     $jameKhalesVarede_bef2=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");
			     $jameKhalesSadere_bef2=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
			     $KhalesTadil_Ezafe_bef2=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $KhalesTadil_Kasry_bef2=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $mojodyKhalesAval_bef2=$mojodyKhalesAval2+$jameKhalesVarede_bef2-$jameKhalesSadere_bef2+$KhalesTadil_Ezafe_bef2-$KhalesTadil_Kasry_bef2;
			     /**/			   
			     $jameKhalesVarede2=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
			     $jameKhalesSadere2=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
			     $KhalesTadil_Ezafe2=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
			     $KhalesTadil_Kasry2=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
                 $mojodyKalaOstan=$mojodyKhalesAval_bef2+$jameKhalesVarede2-$jameKhalesSadere2+$KhalesTadil_Ezafe2-$KhalesTadil_Kasry2;			   
			   }
			   if($noe_namayesh==2)//درحالت ناخالص
	           {
			     $mojodyNaKhalesAval2=$db->get_from_where("SUM(mojody_nakhales_aval)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
			     $jameNakhalesVarede_bef2=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");
			     $jameNakhalesSadere_bef2=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
			     $NakhalesTadil_Ezafe_bef2=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $NakhalesTadil_Kasry_bef2=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $mojodyNakhalesAval_bef2=$mojodyNaKhalesAval2+$jameNakhalesVarede_bef2-$jameNakhalesSadere_bef2+$NakhalesTadil_Ezafe_bef2-$NakhalesTadil_Kasry_bef2;
			     /**/			   
			     $jameNakhalesVarede2=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
			     $jameNakhalesSadere2=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
			     $NakhalesTadil_Ezafe2=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
			     $NakhalesTadil_Kasry2=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
                 $mojodyKalaOstan=$mojodyNakhalesAval_bef2+$jameNakhalesVarede2-$jameNakhalesSadere2+$NakhalesTadil_Ezafe2-$NakhalesTadil_Kasry2;			   
			   }
			   if($noe_namayesh==3)//درحالت تعداد کارتن
	           {
			     $tedadKartonAval2=$db->get_from_where("SUM(tedad_karton_aval)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
			     $jameKartonVarede_bef2=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");
			     $jameKartonSadere_bef2=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
			     $KartonTadil_Ezafe_bef2=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $KartonTadil_Kasry_bef2=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
			     $tedadKartonAval_bef2=$tedadKartonAval2+$jameKartonVarede_bef2-$jameKartonSadere_bef2+$KartonTadil_Ezafe_bef2-$KartonTadil_Kasry_bef2;
			     /**/			   
			     $jameKartonVarede2=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
			     $jameKartonSadere2=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
			     $KartonTadil_Ezafe2=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
			     $KartonTadil_Kasry2=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
                 $mojodyKalaOstan=$tedadKartonAval_bef2+$jameKartonVarede2-$jameKartonSadere2+$KartonTadil_Ezafe2-$KartonTadil_Kasry2;			   
			   } 			   
			   echo '<td>'.round($mojodyKalaOstan,3).'</td>';
			   $jame_mojody_ostan+=$mojodyKalaOstan;//جمع موجودی کل کالاها در هر استان
			}//END kala while
			echo '<td>'.round($jame_mojody_ostan,3).'</td>';
		   echo'	
		   </tr>';
		   }
		   //اگر دسترسی به تمام استان ها ندارد
		   else
		   {
		   echo'
		   <tr class="print_table-even sum-row" style="background-color:#FFF;">
		    <td colspan="4">جمع کل</td>';
			$jame_mojody_ostan=0;//جمع موجودی کل کالاها در هر استان
			$q4="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
            $res4=$db->query($q4);
	        while($row4=$db->fetch_assoc($res4))
	        {			   			   
			   //مجموع موجودی هر کالا در هر استان
			   if($noe_namayesh==1)//درحالت خالص
	           {
				 $mojodyKhalesAval2=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=mojody_kala.code_ostan AND user_ostan_anbar.code_anbar=mojody_kala.code_anbar","user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND user_id=".$_SESSION['mt_user_id']."");        	
			     $jameKhalesVarede_bef2=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=r.code_ostan AND user_ostan_anbar.code_anbar=r.code_anbar","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $jameKhalesSadere_bef2=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=h.code_ostan AND user_ostan_anbar.code_anbar=h.code_anbar","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $KhalesTadil_Ezafe_bef2=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=1 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $KhalesTadil_Kasry_bef2=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=2 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $mojodyKhalesAval_bef2=$mojodyKhalesAval2+$jameKhalesVarede_bef2-$jameKhalesSadere_bef2+$KhalesTadil_Ezafe_bef2-$KhalesTadil_Kasry_bef2;
			     /**/			   
			     $jameKhalesVarede2=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=r.code_ostan AND user_ostan_anbar.code_anbar=r.code_anbar","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
			     $jameKhalesSadere2=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=h.code_ostan AND user_ostan_anbar.code_anbar=h.code_anbar","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
			     $KhalesTadil_Ezafe2=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=1 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
			     $KhalesTadil_Kasry2=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=2 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
                 $mojodyKalaOstan=$mojodyKhalesAval_bef2+$jameKhalesVarede2-$jameKhalesSadere2+$KhalesTadil_Ezafe2-$KhalesTadil_Kasry2;			   
			   }
			   if($noe_namayesh==2)//درحالت ناخالص
	           {
			     $mojodyNaKhalesAval2=$db->get_from_where("SUM(mojody_nakhales_aval)","mojody_kala INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=mojody_kala.code_ostan AND user_ostan_anbar.code_anbar=mojody_kala.code_anbar","user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND user_id=".$_SESSION['mt_user_id']."");        	
			     $jameNakhalesVarede_bef2=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=r.code_ostan AND user_ostan_anbar.code_anbar=r.code_anbar","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $jameNakhalesSadere_bef2=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=h.code_ostan AND user_ostan_anbar.code_anbar=h.code_anbar","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $NakhalesTadil_Ezafe_bef2=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=1 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $NakhalesTadil_Kasry_bef2=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=2 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $mojodyNakhalesAval_bef2=$mojodyNaKhalesAval2+$jameNakhalesVarede_bef2-$jameNakhalesSadere_bef2+$NakhalesTadil_Ezafe_bef2-$NakhalesTadil_Kasry_bef2;
			     /**/			   
			     $jameNakhalesVarede2=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=r.code_ostan AND user_ostan_anbar.code_anbar=r.code_anbar","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
			     $jameNakhalesSadere2=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=h.code_ostan AND user_ostan_anbar.code_anbar=h.code_anbar","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
			     $NakhalesTadil_Ezafe2=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=1 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
			     $NakhalesTadil_Kasry2=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=2 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
                 $mojodyKalaOstan=$mojodyNakhalesAval_bef2+$jameNakhalesVarede2-$jameNakhalesSadere2+$NakhalesTadil_Ezafe2-$NakhalesTadil_Kasry2;			   
			   }
			   if($noe_namayesh==3)//درحالت تعداد کارتن
	           {
			     $tedadKartonAval2=$db->get_from_where("SUM(tedad_karton_aval)","mojody_kala INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=mojody_kala.code_ostan AND user_ostan_anbar.code_anbar=mojody_kala.code_anbar","user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND user_id=".$_SESSION['mt_user_id']."");        	
			     $jameKartonVarede_bef2=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=r.code_ostan AND user_ostan_anbar.code_anbar=r.code_anbar","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $jameKartonSadere_bef2=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=h.code_ostan AND user_ostan_anbar.code_anbar=h.code_anbar","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $KartonTadil_Ezafe_bef2=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=1 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $KartonTadil_Kasry_bef2=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=2 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND user_id=".$_SESSION['mt_user_id']."");
			     $tedadKartonAval_bef2=$tedadKartonAval2+$jameKartonVarede_bef2-$jameKartonSadere_bef2+$KartonTadil_Ezafe_bef2-$KartonTadil_Kasry_bef2;
			     /**/			   
			     $jameKartonVarede2=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=r.code_ostan AND user_ostan_anbar.code_anbar=r.code_anbar","r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.code_kala=".$row4['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
			     $jameKartonSadere2=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=h.code_ostan AND user_ostan_anbar.code_anbar=h.code_anbar","h_d.code_ostan=".$row['code_ostan']." AND h_d.code_kala=".$row4['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
			     $KartonTadil_Ezafe2=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=1 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
			     $KartonTadil_Kasry2=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=tadil_mojody.code_ostan AND user_ostan_anbar.code_anbar=tadil_mojody.code_anbar","noe_tadil=2 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row4['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND user_id=".$_SESSION['mt_user_id']."");
                 $mojodyKalaOstan=$tedadKartonAval_bef2+$jameKartonVarede2-$jameKartonSadere2+$KartonTadil_Ezafe2-$KartonTadil_Kasry2;			   
			   } 			   
			   echo '<td>'.round($mojodyKalaOstan,3).'</td>';
			   $jame_mojody_ostan+=$mojodyKalaOstan;//جمع موجودی کل کالاها در هر استان
			}//END kala while
			echo '<td>'.round($jame_mojody_ostan,3).'</td>';
		   echo'	
		   </tr>';
		   }
		 echo'
	  </tr>';
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
	 }//END FIRST while,ostan while
	/*****سطر جمع موجودی انبارهای ملکی استان ها*****/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	echo'
	 <tr class="print_table-even sum-row" >
	  <td colspan="4">جمع موجودی انبارهای ملکی استان ها</td>';
	   $jame_mojody_melky=0;//جمع موجودی کل کالاها درهمه انبارهای ملکی
	   $q6="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
       $res6=$db->query($q6);
	   while($row6=$db->fetch_assoc($res6))
	   {
		 //مجموع موجودی هر کالادر تمام استان ها ی ملکی
		 if($noe_namayesh==1)//درحالت خالص
	     {
		   $mojodyKhalesAval4=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=mojody_kala.code_anbar AND list_sardkhane.code_ostan=mojody_kala.code_ostan","noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND mojody_kala.code_ostan!=90");        	
		   $jameKhalesVarede_bef4=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=1 AND r_k_d.code_kala=".$row6['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1' AND r_k_d.code_ostan!=90");
	       $jameKhalesSadere_bef4=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=1 AND h_d.code_kala=".$row6['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1' AND h_d.code_ostan!=90");
	       $KhalesTadil_Ezafe_bef4=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1  AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND tadil_mojody.code_ostan!=90");
	       $KhalesTadil_Kasry_bef4=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND tadil_mojody.code_ostan!=90");
	       $mojodyKhalesAval_bef4=$mojodyKhalesAval4+$jameKhalesVarede_bef4-$jameKhalesSadere_bef4+$KhalesTadil_Ezafe_bef4-$KhalesTadil_Kasry_bef4;
	       /**/			   
	       $jameKhalesVarede4=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=1 AND r_k_d.code_kala=".$row6['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND r_k_d.code_ostan!=90");
	       $jameKhalesSadere4=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=1 AND h_d.code_kala=".$row6['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND h_d.code_ostan!=90");
	       $KhalesTadil_Ezafe4=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1 AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND tadil_mojody.code_ostan!=90");
	       $KhalesTadil_Kasry4=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND tadil_mojody.code_ostan!=90");
		   $mojodyKalaMelky=$mojodyKhalesAval_bef4+$jameKhalesVarede4-$jameKhalesSadere4+$KhalesTadil_Ezafe4-$KhalesTadil_Kasry4;
	     }
		 if($noe_namayesh==2)//درحالت ناخالص
	     {
		   $mojodyNaKhalesAval4=$db->get_from_where("SUM(mojody_nakhales_aval)","mojody_kala INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=mojody_kala.code_anbar AND list_sardkhane.code_ostan=mojody_kala.code_ostan","noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND mojody_kala.code_ostan!=90");        	
		   $jameNakhalesVarede_bef4=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=1 AND r_k_d.code_kala=".$row6['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1' AND r_k_d.code_ostan!=90");
	       $jameNakhalesSadere_bef4=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=1 AND h_d.code_kala=".$row6['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1' AND h_d.code_ostan!=90");
	       $NakhalesTadil_Ezafe_bef4=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1  AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND tadil_mojody.code_ostan!=90");
	       $NakhalesTadil_Kasry_bef4=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND tadil_mojody.code_ostan!=90");
	       $mojodyNakhalesAval_bef4=$mojodyNaKhalesAval4+$jameNakhalesVarede_bef4-$jameNakhalesSadere_bef4+$NakhalesTadil_Ezafe_bef4-$NakhalesTadil_Kasry_bef4;
	       /**/			   
	       $jameNakhalesVarede4=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=1 AND r_k_d.code_kala=".$row6['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND r_k_d.code_ostan!=90");
	       $jameNakhalesSadere4=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=1 AND h_d.code_kala=".$row6['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND h_d.code_ostan!=90");
	       $NakhalesTadil_Ezafe4=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1 AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND tadil_mojody.code_ostan!=90");
	       $NakhalesTadil_Kasry4=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND tadil_mojody.code_ostan!=90");
		   $mojodyKalaMelky=$mojodyNakhalesAval_bef4+$jameNakhalesVarede4-$jameNakhalesSadere4+$NakhalesTadil_Ezafe4-$NakhalesTadil_Kasry4;
	     }
		 if($noe_namayesh==3)//درحالت تعداد کارتن
	     {
		   $tedadKartonAval4=$db->get_from_where("SUM(tedad_karton_aval)","mojody_kala INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=mojody_kala.code_anbar AND list_sardkhane.code_ostan=mojody_kala.code_ostan","noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND mojody_kala.code_ostan!=90");        	
		   $jameKartonVarede_bef4=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=1 AND r_k_d.code_kala=".$row6['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1' AND r_k_d.code_ostan!=90");
	       $jameKartonSadere_bef4=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=1 AND h_d.code_kala=".$row6['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1' AND h_d.code_ostan!=90");
	       $KartonTadil_Ezafe_bef4=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1  AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND tadil_mojody.code_ostan!=90");
	       $KartonTadil_Kasry_bef4=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' AND tadil_mojody.code_ostan!=90");
	       $tedadKartonAval_bef4=$tedadKartonAval4+$jameKartonVarede_bef4-$jameKartonSadere_bef4+$KartonTadil_Ezafe_bef4-$KartonTadil_Kasry_bef4;
	       /**/			   
	       $jameKartonVarede4=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=1 AND r_k_d.code_kala=".$row6['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND r_k_d.code_ostan!=90");
	       $jameKartonSadere4=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=1 AND h_d.code_kala=".$row6['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND h_d.code_ostan!=90");
	       $KartonTadil_Ezafe4=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1 AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND tadil_mojody.code_ostan!=90");
	       $KartonTadil_Kasry4=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=1 AND code_kala=".$row6['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND tadil_mojody.code_ostan!=90");
		   $mojodyKalaMelky=$tedadKartonAval_bef4+$jameKartonVarede4-$jameKartonSadere4+$KartonTadil_Ezafe4-$KartonTadil_Kasry4;
	     }
		 echo '<td>'.round($mojodyKalaMelky,3).'</td>';
		 $jame_mojody_melky+=$mojodyKalaMelky;//جمع موجودی کل کالاها درهمه انبارهای ملکی
	   }//END kala while
	   echo '<td>'.round($jame_mojody_melky,3).'</td>';
	 echo'
	 </tr>';
	/*****سطر جمع موجودی انبارهای استیجاری استان ها*****/
    echo'
	 <tr class="print_table-even sum-row" >
	  <td colspan="4">جمع موجودی انبارهای استیجاری استان ها</td>';
	   $jame_mojody_estijary=0;//جمع موجودی کل کالاها درهمه انبارهای استیجاری
	   $q7="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
       $res7=$db->query($q7);
	   while($row7=$db->fetch_assoc($res7))
	   {
		 //مجموع موجودی هر کالادر تمام استان ها ی استیجاری
	     if($noe_namayesh==1)//درحالت خالص
	     {
		   $mojodyKhalesAval5=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=mojody_kala.code_anbar AND list_sardkhane.code_ostan=mojody_kala.code_ostan","noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
		   $jameKhalesVarede_bef5=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=2 AND r_k_d.code_kala=".$row7['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");
	       $jameKhalesSadere_bef5=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=2 AND h_d.code_kala=".$row7['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
	       $KhalesTadil_Ezafe_bef5=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1  AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
	       $KhalesTadil_Kasry_bef5=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
	       $mojodyKhalesAval_bef5=$mojodyKhalesAval5+$jameKhalesVarede_bef5-$jameKhalesSadere_bef5+$KhalesTadil_Ezafe_bef5-$KhalesTadil_Kasry_bef5;
	       /**/			   
	       $jameKhalesVarede5=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=2 AND r_k_d.code_kala=".$row7['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
	       $jameKhalesSadere5=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=2 AND h_d.code_kala=".$row7['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
	       $KhalesTadil_Ezafe5=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1 AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	       $KhalesTadil_Kasry5=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
		   $mojodyKalaEstijary=$mojodyKhalesAval_bef5+$jameKhalesVarede5-$jameKhalesSadere5+$KhalesTadil_Ezafe5-$KhalesTadil_Kasry5;
	     }
		 if($noe_namayesh==2)//درحالت ناخالص
	     {
		   $mojodyNaKhalesAval5=$db->get_from_where("SUM(mojody_nakhales_aval)","mojody_kala INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=mojody_kala.code_anbar AND list_sardkhane.code_ostan=mojody_kala.code_ostan","noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
		   $jameNakhalesVarede_bef5=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=2 AND r_k_d.code_kala=".$row7['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");
	       $jameNakhalesSadere_bef5=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=2 AND h_d.code_kala=".$row7['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
	       $NakhalesTadil_Ezafe_bef5=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1  AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
	       $NakhalesTadil_Kasry_bef5=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
	       $mojodyNakhalesAval_bef5=$mojodyNaKhalesAval5+$jameNakhalesVarede_bef5-$jameNakhalesSadere_bef5+$NakhalesTadil_Ezafe_bef5-$NakhalesTadil_Kasry_bef5;
	       /**/			   
	       $jameNakhalesVarede5=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=2 AND r_k_d.code_kala=".$row7['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
	       $jameNakhalesSadere5=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=2 AND h_d.code_kala=".$row7['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
	       $NakhalesTadil_Ezafe5=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1 AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	       $NakhalesTadil_Kasry5=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
		   $mojodyKalaEstijary=$mojodyNakhalesAval_bef5+$jameNakhalesVarede5-$jameNakhalesSadere5+$NakhalesTadil_Ezafe5-$NakhalesTadil_Kasry5;
	     }
		 if($noe_namayesh==3)//درحالت تعداد کارتن
	     {
		   $tedadKartonAval5=$db->get_from_where("SUM(tedad_karton_aval)","mojody_kala INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=mojody_kala.code_anbar AND list_sardkhane.code_ostan=mojody_kala.code_ostan","noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
		   $jameKartonVarede_bef5=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=2 AND r_k_d.code_kala=".$row7['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");
	       $jameKartonSadere_bef5=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=2 AND h_d.code_kala=".$row7['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
	       $KartonTadil_Ezafe_bef5=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1  AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
	       $KartonTadil_Kasry_bef5=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1'");
	       $tedadKartonAval_bef5=$tedadKartonAval5+$jameKartonVarede_bef5-$jameKartonSadere_bef5+$KartonTadil_Ezafe_bef5-$KartonTadil_Kasry_bef5;
	       /**/			   
	       $jameKartonVarede5=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan","noe_malekiyat=2 AND r_k_d.code_kala=".$row7['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
	       $jameKartonSadere5=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan","noe_malekiyat=2 AND h_d.code_kala=".$row7['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
	       $KartonTadil_Ezafe5=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=1 AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	       $KartonTadil_Kasry5=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=tadil_mojody.code_anbar AND list_sardkhane.code_ostan=tadil_mojody.code_ostan","noe_tadil=2 AND noe_malekiyat=2 AND code_kala=".$row7['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
		   $mojodyKalaEstijary=$tedadKartonAval_bef5+$jameKartonVarede5-$jameKartonSadere5+$KartonTadil_Ezafe5-$KartonTadil_Kasry5;
	     }
	     echo '<td>'.round($mojodyKalaEstijary,3).'</td>';
		 $jame_mojody_estijary+=$mojodyKalaEstijary;//جمع موجودی کل کالاها درهمه انبارهای استیجاری
	   }//END kala while
	   echo '<td>'.round($jame_mojody_estijary,3).'</td>';
	 echo'
	 </tr>';
	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" >
	  <td colspan="4">جمع کل استان ها</td>';
	   $jame_mojody_ostanha=0;//جمع موجودی کل کالاها درهمه استانها
	   $q5="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
       $res5=$db->query($q5);
	   while($row5=$db->fetch_assoc($res5))
	   {
	     //مجموع موجودی هر کالادر تمام استان ها
	     if($noe_namayesh==1)//درحالت خالص
	     {	 
		   $mojodyKhalesAval6=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala","code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND code_ostan!=90");        	
		   $jameKhalesVarede_bef6=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_kala=".$row5['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1' AND r_k_d.code_ostan!=90");
	       $jameKhalesSadere_bef6=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_kala=".$row5['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1' AND h_d.code_ostan!=90");
	       $KhalesTadil_Ezafe_bef6=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<'$date1' AND code_ostan!=90");
	       $KhalesTadil_Kasry_bef6=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<'$date1' AND code_ostan!=90");
	       $mojodyKhalesAval_bef6=$mojodyKhalesAval6+$jameKhalesVarede_bef6-$jameKhalesSadere_bef6+$KhalesTadil_Ezafe_bef6-$KhalesTadil_Kasry_bef6;
	       /**/			   
	       $jameKhalesVarede6=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_kala=".$row5['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND r_k_d.code_ostan!=90");
	       $jameKhalesSadere6=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_kala=".$row5['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND h_d.code_ostan!=90");
	       $KhalesTadil_Ezafe6=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND code_ostan!=90");
	       $KhalesTadil_Kasry6=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND code_ostan!=90");
		   $mojodyKalaOstanha=$mojodyKhalesAval_bef6+$jameKhalesVarede6-$jameKhalesSadere6+$KhalesTadil_Ezafe6-$KhalesTadil_Kasry6;
		   //mojody as field//$mojodyKalaOstanha=$db->get_from_where("SUM(mojody)","mojody_kala","code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 GROUP BY code_kala");     
	     }
		 if($noe_namayesh==2)//درحالت ناخالص
	     {	 
		   $mojodyNaKhalesAval6=$db->get_from_where("SUM(mojody_nakhales_aval)","mojody_kala","code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND code_ostan!=90");        	
		   $jameNakhalesVarede_bef6=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_kala=".$row5['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1' AND r_k_d.code_ostan!=90");
	       $jameNakhalesSadere_bef6=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_kala=".$row5['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1' AND h_d.code_ostan!=90");
	       $NakhalesTadil_Ezafe_bef6=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=1 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<'$date1' AND code_ostan!=90");
	       $KhalesTadil_Kasry_bef6=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=2 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<'$date1' AND code_ostan!=90");
	       $mojodyNakhalesAval_bef6=$mojodyNaKhalesAval6+$jameNakhalesVarede_bef6-$jameNakhalesSadere_bef6+$NakhalesTadil_Ezafe_bef6-$NakhalesTadil_Kasry_bef6;
	       /**/			   
	       $jameNakhalesVarede6=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_kala=".$row5['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND r_k_d.code_ostan!=90");
	       $jameNakhalesSadere6=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_kala=".$row5['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND h_d.code_ostan!=90");
	       $NakhalesTadil_Ezafe6=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=1 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND code_ostan!=90");
	       $NakhalesTadil_Kasry6=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=2 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND code_ostan!=90");
		   $mojodyKalaOstanha=$mojodyNakhalesAval_bef6+$jameNakhalesVarede6-$jameNakhalesSadere6+$NakhalesTadil_Ezafe6-$NakhalesTadil_Kasry6;
	     }
		 if($noe_namayesh==3)//درحالت تعداد کارتن
	     {	 
		   $tedadKartonAval6=$db->get_from_where("SUM(tedad_karton_aval)","mojody_kala","code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND code_ostan!=90");        	
		   $jameKartonVarede_bef6=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_kala=".$row5['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1' AND r_k_d.code_ostan!=90");
	       $jameKartonSadere_bef6=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_kala=".$row5['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1' AND h_d.code_ostan!=90");
	       $KartonTadil_Ezafe_bef6=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<'$date1' AND code_ostan!=90");
	       $KartonTadil_Kasry_bef6=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<'$date1' AND code_ostan!=90");
	       $tedadKartonAval_bef6=$tedadKartonAval6+$jameKartonVarede_bef6-$jameKartonSadere_bef6+$KartonTadil_Ezafe_bef6-$KartonTadil_Kasry_bef6;
	       /**/			   
	       $jameKartonVarede6=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r_k_d.code_kala=".$row5['code_kala']." AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND r_k_d.code_ostan!=90");
	       $jameKartonSadere6=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail h_d INNER JOIN havale h ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year","h_d.code_kala=".$row5['code_kala']." AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND h_d.code_ostan!=90");
	       $KartonTadil_Ezafe6=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND code_ostan!=90");
	       $KartonTadil_Kasry6=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND code_ostan!=90");
		   $mojodyKalaOstanha=$tedadKartonAval_bef6+$jameKartonVarede6-$jameKartonSadere6+$KartonTadil_Ezafe6-$KartonTadil_Kasry6;
	     }
		 echo '<td>'.round($mojodyKalaOstanha,3).'</td>';
		 $jame_mojody_ostanha+=$mojodyKalaOstanha;//جمع موجودی کل کالاها درهمه استانها
	   }//END kala while
	   echo '<td>'.round($jame_mojody_ostanha,3).'</td>';
	 echo'
	 </tr>';
	 }
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
  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'	
</form>
</body>
</html>';	
?>