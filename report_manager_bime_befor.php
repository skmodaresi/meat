<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_bime.php";
$today_mah=substr($today,5,2);
$titr='گزارش فرآورده ها جهت ارسال به شرکت بیمه طرف قرارداد';
$date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
IF($mah==1)      $date2='1396/01/31';
ELSE IF($mah==2) $date2='1396/02/31';
ELSE IF($mah==3) $date2='1396/03/31';
ELSE IF($mah==4) $date2='1396/04/31';
ELSE IF($mah==5) $date2='1396/05/31';
ELSE IF($mah==6) $date2='1396/06/31';
ELSE IF($mah==7) $date2='1396/07/30';
ELSE IF($mah==8) $date2='1396/08/30';
ELSE IF($mah==9) $date2='1396/09/30';
ELSE IF($mah==10)$date2='1396/10/30';
ELSE IF($mah==11)$date2='1396/11/30';
ELSE IF($mah==12)$date2='1396/12/30';
//ELSE IF($mah==12)$date2="$mtActiveYear/12/30";
/****************هدر******************/
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
	  //خروجی اکسل
      $("#exportExcel").click(function(){
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "report_manager_bime",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
	  });	  
});
</script> 
</head>';
Function print_header()
{global $mahshamsiArr,$mah,$titr,$mt_gl_owner,$date1,$date2,$FileName,$page,$db,$Condition;
  echo'   
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
	   <tr class="noExl">
	   	<td class="print_title_2">';
	   	 IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo ''.$titr.' ماه '.$mahshamsiArr[$mah].' &nbsp&nbsp(صفحه : '.$page.')
         <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
	   </tr>
      </table>
     </td>
    </tr>
	<tr class="print_table-title2">
	 <td  width="5%">ردیف</td>
	 <td  width="10%">استان</td>
	 <td  width="10%">نام سردخانه</td>
	 <td  width="5%">وضعیت</td>
	 <td  width="5%">نوع مالکیت</td>';
     $q_column="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition";
     $res_column=$db->query($q_column);
	 while($column=$db->fetch_assoc($res_column))
	 {
	  IF($column['code_group_kala_top']==6) $vahed='(عدد)';
	  ELSE  $vahed='(کیلوگرم)';
	  echo'<td >موجودی '.$column['name_group_kala_top'].' '.$vahed.'</td>
	       <td>مانده حواله '.$column['name_group_kala_top'].' '.$vahed.'</td>
	       <td>مانده موجودی پس از کسر حواله '.$column['name_group_kala_top'].' '.$vahed.'</td>';
	 }
	 echo'
	 <td width="15%">جمع موجودی فرآورده های دامی پس از کسر حواله (به جز کنسرو)</td>
	</tr>';
}
/****************فیلترها روی گزارش******************/
/******************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $ostan_val) 
      {
       $Condition_ostan_temp.=" code_ostan='$ostan_val' OR";
      }
      if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{$Condition_ostan=' code_ostan='.$_SESSION['mt_code_ostan'].'';}
///////////////////////////////////////////////////////////////
//گروه کالا
if(is_array($grkalachoice))
{
 foreach($grkalachoice as $grkala_key => $grkala_val) {
  $Condition_kala.=" code_group_kala_top='$grkala_val' OR";
 }
  if($grkala_val==-1)$Condition.="";
  else $Condition.=" AND $Condition_kala";
 $lastSpacePosition = strrpos($Condition," ");
 $Condition =substr($Condition,0,$lastSpacePosition);
}
/******************نمایش یا عدم نمایش انبارهای موقت******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date2.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=3; 
IF((!$ok)OR($mah==0))
{
echo'
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>	
	<tr class="tr1" style="height:45px">	
     <!--<td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>-->
	 <td align="left"><span class="star">*</span> ماه : </td><td align="right" colspan="3">&nbsp;'.static_listbox("mah",$mah,"mahshamsiArr","1","class='text4'").'</td>
	</tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت</td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
    <tr  class="tr1"> 
	 <td align="left"> تعداد استان در صفحه : </td><td align="right" colspan="3">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1" style="height:45px">
     <td align="left">گروه کالا : </td>
     <td align="right">
	  &nbsp;<select name="grkalachoice[]" class="easyui-combobox" size="6" style="width:100px;" multiple>';
	  $result_grkala = $db->query("SELECT * FROM bzacc.group_kala_top WHERE group_type_top=2");
      $grkala_options = "<option value='-1' selected>همه</option>";
      while($row_grkala=$db->fetch_assoc($result_grkala)) $grkala_options .= "<option value=".$row_grkala['code_group_kala_top'].">".$row_grkala['name_group_kala_top']."</option>";
	  echo $grkala_options;
	  echo'
	  </select>
	 </td>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" size="6" style="width:150px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>      
	  </td>';
	}
	else echo'<td colspan="2"></td>';
	echo'
	</tr>
	<tr class="footer">	
	 <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
   </div>
  </td>
 </tr>
</table> ';
}
ELSE{
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
    $radif=1;
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan ) AND($Condition_ostan) ORDER BY name_ostan";
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
    echo'   
     <br>
     <div class="table2excel">
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
		   echo ''.$titr.' ماه '.$mahshamsiArr[$mah].' &nbsp&nbsp(صفحه : '.$page.')
           <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	      </td>
	     </tr>
        </table>
       </td>
      </tr>';
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
	 if(is_array($grkalachoice))
	 {
	  if($grkala_val==-1)$filter_string.=' همه کالاها';
	  else $filter_string.=' گروه کالا : ';
	  foreach($grkalachoice as $grkala_key => $grkala_val) {
	  $nameGrKala=$db->get_from_where("name_group_kala_top","bzacc.group_kala_top","code_group_kala_top='$grkala_val'");
	  $filter_string.=''.$nameGrKala.'&nbsp;';
      }
	 }
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت -';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت -';
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال ';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیر فعال';
	 echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo'
	  <tr class="print_table-title2">
	   <td width="5%">ردیف</td>
	   <td width="10%">استان</td>
	   <td width="10%">نام سردخانه</td>
	   <td width="5%">وضعیت</td>
	   <td width="5%">نوع مالکیت</td>';
       $q_column="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition";
       $res_column=$db->query($q_column);
	   while($column=$db->fetch_assoc($res_column))
	   {
	    IF($column['code_group_kala_top']==6) $vahed='(عدد)';
	    ELSE  $vahed='(کیلوگرم)';
	    echo'<td >موجودی '.$column['name_group_kala_top'].' '.$vahed.'</td>
	         <td>مانده حواله '.$column['name_group_kala_top'].' '.$vahed.'</td>
	         <td>مانده موجودی پس از کسر حواله '.$column['name_group_kala_top'].' '.$vahed.'</td>';
	   }
	   echo'
	   <td width="15%">جمع موجودی فرآورده های دامی پس از کسر حواله (به جز کنسرو)</td>
	  </tr>';
	 while($row=$db->fetch_assoc($res))//ostan while
	 {
	  $mojodyKalaOstan_morgh=0;$mande_havale_forushOstan_morgh=0;$mande_pasazkasrOstan_morgh=0;
	  $mojodyKalaOstan_ghusht=0;$mande_havale_forushOstan_ghusht=0;$mande_pasazkasrOstan_ghusht=0;
	  $mojodyKalaOstan_konserv=0;$mande_havale_forushOstan_konserv=0;$mande_pasazkasrOstan_konserv=0;
	  $mojodyKalaOstan_tokhm=0;$mande_havale_forushOstan_tokhm=0;$mande_pasazkasrOstan_tokhm=0;
	  $mojodyKalaOstan_sosis=0;$mande_havale_forushOstan_sosis=0;$mande_pasazkasrOstan_sosis=0;
	  $mojodyKalaOstan_soya_d=0;$mande_havale_forushOstan_soya_d=0;$mande_pasazkasrOstan_soya_d=0;
	  $mojodyKalaOstan_soya_v=0;$mande_havale_forushOstan_soya_v=0;$mande_pasazkasrOstan_soya_v=0;
	  $jame_mande_pasazkasr_Ostan=0;
	  $line++;
	  //تعداد انبار ها
	  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","$mydatabase.list_sardkhane","$Condition_movaghat $Condition_anbar_activate code_ostan=".$row['code_ostan']."");//تعداد انبارهای هر استان 
	  else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","$mydatabase.user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_movaghat $Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای هر استان     
	  $rowanbar=$tedadanbar;
	  $t=$rowanbar;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		 <td rowspan="'.$rowanbar.'">'.$radif++.'</td>
	     <td rowspan="'.$rowanbar.'" style="font-weight:bold">'.$row['name_ostan'].'</td>';
		   /**///حلقه روی انبار ها
		   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM $mydatabase.list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate code_ostan=".$row['code_ostan']."";
		   else $q2="SELECT * FROM $mydatabase.user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."";
		   $res2=$db->query($q2);
		   while($row2=$db->fetch_assoc($res2))//anbar while
		   {	   
			$jame_mande_pasazkasr_anbar=0;//جمع موجودی کل کالاها در هر انبار
			$j=$i+1;
			echo'
		     <td>'.$row2['name_anbar'].'</td>
		     <td>'.$activateArr[$row2['activate']].'</td>
			 <td>'.$noe_malekiyatArr[$row2['noe_malekiyat']].'</td>';
			  $s1=0;
              $q3="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition";
			  $res3=$db->query($q3);
			  while($row3=$db->fetch_assoc($res3))//groupkala while
	          {
			   //موجودی هر گروه کالا در هر سردخانه
			   IF($row3['code_group_kala_top']==6)//کنسرو مرغ
			   {
				$mojodyAval=$db->get_from_where("SUM(tedad_karton_aval)","$mydatabase.mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND year='$mtActiveYear' AND deleted=0");        	
			   	$jameVarede_bef=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<='$date2'");
                $jameSadere_bef=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2'");
			   	$meghdarTadil_Ezafe_bef=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
			   	$meghdarTadil_Kasry_bef=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
			    $mojodyKala=$mojodyAval+$jameVarede_bef-$jameSadere_bef+$meghdarTadil_Ezafe_bef-$meghdarTadil_Kasry_bef;			   
			   }
			   ELSE
			   {
				$mojodyAval=$db->get_from_where("SUM(mojody_khales_aval)","$mydatabase.mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND year='$mtActiveYear' AND deleted=0");        	
			   	$jameVarede_bef=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<='$date2'");
                $jameSadere_bef=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2'");
			   	$meghdarTadil_Ezafe_bef=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
			   	$meghdarTadil_Kasry_bef=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
			    $mojodyKala=$mojodyAval+$jameVarede_bef-$jameSadere_bef+$meghdarTadil_Ezafe_bef-$meghdarTadil_Kasry_bef;			   
			   }
			   //مانده حواله فروش
			   //تبدیل کداستان به آی دی برای کوئری های فروش
	           $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$row['code_ostan']."");  
               //تبدیل کدانبار به آی دی برای کوئری های فروش
	           $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=".$sell_id_ostan." AND l_code=".$row2['code_anbar']."");
	 	       //مقدار کل حواله فروش ها مابین تاریخ
	           $havale_forush_bet_per1=0;
               $havale_forush=0;
               $mande_havale_forush=0;
	           $q_forush=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code WHERE h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND code_group_kala_top=".$row3['code_group_kala_top']." AND h_reg_date>='$mtStartDateMi' AND h_reg_date<='$date2_milady'");	           
			   $res_forush=mysql_query($q_forush);
	           while($row_forush=mysql_fetch_array($res_forush))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	           {
	            /**///محاسبه کل تحویلی برای این حواله
                IF($row3['code_group_kala_top']==6)//کنسرو مرغ
				{$meghdar_tahvily_per2=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail","h_code=".$row_forush['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year=$mtActiveYear AND havale_deleted=0 AND status=0");}
				ELSE
				{$meghdar_tahvily_per2=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail","h_code=".$row_forush['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year=$mtActiveYear AND havale_deleted=0 AND status=0");}
				
				/**///محاسبه کل باطله برای این حواله
	  	        $meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush['h_id']." ");
	            $havale_forush_bet_per1=$row_forush['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
	  	        $havale_forush+=$havale_forush_bet_per1;
	           }
			   //مقدار کل ابطالی ها مابین تاریخ
	           $q_ebtal="SELECT SUM(his_eb_amount) AS ebtali FROM sell.dm_his_havale 
	                    INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                    INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                    INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code
						WHERE h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND code_group_kala_top=".$row3['code_group_kala_top']." AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date<='$date2_milady'";
			   //echo $q_ebtal;
			   $res_ebtal=mysql_query($q_ebtal);
			   $meghdar_ebtali=mysql_result($res_ebtal, 0, 'ebtali');
			   
			   //echo $meghdar_ebtali.'<br>';
			   IF($row3['code_group_kala_top']==6)//کنسرو مرغ 
			   {$tahvilghatee=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<='".$date2."'");}	
			   ELSE 
			   {$tahvilghatee=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<='".$date2."'");}	

			   $mande_havale_forush=round(($havale_forush-$meghdar_ebtali-$tahvilghatee),3);
			   //مانده موجودی پس از کسر حواله فروش
               $mande_pasazkasr=$mojodyKala-$mande_havale_forush;
			   echo '<td>'.round($mojodyKala,3).'</td>';
			   echo '<td>'.round($mande_havale_forush,3).'</td>';
			   echo '<td>'.round($mande_pasazkasr,3).'</td>';
			   IF($row3['code_group_kala_top']!=6)$jame_mande_pasazkasr_anbar+=$mande_pasazkasr;//جمع موجودی کل کالاها در هر انبار  
			   //محاسبه جمع کل استان 	
			   IF($row3['code_group_kala_top']==4)  {$mojodyKalaOstan_morgh_temp=$mojodyKala;$mande_havale_forush_morgh_temp=$mande_havale_forush;$mande_pasazkasr_morgh_temp=$mande_pasazkasr;}
               IF($row3['code_group_kala_top']==5) {$mojodyKalaOstan_ghusht_temp=$mojodyKala;$mande_havale_forush_ghusht_temp=$mande_havale_forush;$mande_pasazkasr_ghusht_temp=$mande_pasazkasr;}
               IF($row3['code_group_kala_top']==6) {$mojodyKalaOstan_konserv_temp=$mojodyKala;$mande_havale_forush_konserv_temp=$mande_havale_forush;$mande_pasazkasr_konserv_temp=$mande_pasazkasr;}
               IF($row3['code_group_kala_top']==7) {$mojodyKalaOstan_tokhm_temp=$mojodyKala;$mande_havale_forush_tokhm_temp=$mande_havale_forush;$mande_pasazkasr_tokhm_temp=$mande_pasazkasr;}
               IF($row3['code_group_kala_top']==8)  {$mojodyKalaOstan_sosis_temp=$mojodyKala;$mande_havale_forush_sosis_temp=$mande_havale_forush;$mande_pasazkasr_sosis_temp=$mande_pasazkasr;}
			  }//END kala while
			  echo '<td>'.round($jame_mande_pasazkasr_anbar,3).'</td>';
			  //مرغ
			  $mojodyKalaOstan_morgh+=$mojodyKalaOstan_morgh_temp;
			  $mande_havale_forushOstan_morgh+=$mande_havale_forush_morgh_temp;
			  $mande_pasazkasrOstan_morgh+=$mande_pasazkasr_morgh_temp;
			  //گوشت
			  $mojodyKalaOstan_ghusht+=$mojodyKalaOstan_ghusht_temp;
			  $mande_havale_forushOstan_ghusht+=$mande_havale_forush_ghusht_temp;
			  $mande_pasazkasrOstan_ghusht+=$mande_pasazkasr_ghusht_temp;
			  //کنسرو
			  $mojodyKalaOstan_konserv+=$mojodyKalaOstan_konserv_temp;
			  $mande_havale_forushOstan_konserv+=$mande_havale_forush_konserv_temp;
			  $mande_pasazkasrOstan_konserv+=$mande_pasazkasr_konserv_temp;
			  //تخم مرغ
			  $mojodyKalaOstan_tokhm+=$mojodyKalaOstan_tokhm_temp;
			  $mande_havale_forushOstan_tokhm+=$mande_havale_forush_tokhm_temp;
			  $mande_pasazkasrOstan_tokhm+=$mande_pasazkasr_tokhm_temp;
			  //سوسیس
			  $mojodyKalaOstan_sosis+=$mojodyKalaOstan_sosis_temp;
			  $mande_havale_forushOstan_sosis+=$mande_havale_forush_sosis_temp;
			  $mande_pasazkasrOstan_sosis+=$mande_pasazkasr_sosis_temp;
			  $jame_mande_pasazkasr_Ostan=$mande_pasazkasrOstan_morgh+$mande_pasazkasrOstan_ghusht+$mande_pasazkasrOstan_tokhm+$mande_pasazkasrOstan_sosis;
			  $t--;
			  if($t==0) echo'';
			  else 
			  {
			   echo'</tr>';
			   if($j++%2)echo'<tr class="print_table-odd">';
               else echo'<tr class="print_table-even">';
			  }
			  $majmo=$r;
		   }//END anbar while
		   /*****سطر جمع کل استان*****/
		   //if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))//کل استانها
		   //{
		   echo'
		   <tr class="print_table-even sum-row" style="background-color:#FFF;">
		    <td colspan="5">جمع کل استان</td>';
			$jame_mojody_ostan=0;//جمع موجودی کل کالاها در هر استان
            $q4="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition";
			$res4=$db->query($q4);
	        while($row4=$db->fetch_assoc($res4))
	        { 
			   IF($row4['code_group_kala_top']==4)  echo '<td>'.round($mojodyKalaOstan_morgh,3).'</td><td>'.round($mande_havale_forushOstan_morgh,3).'</td><td>'.round($mande_pasazkasrOstan_morgh,3).'</td>';
               IF($row4['code_group_kala_top']==5) echo '<td>'.round($mojodyKalaOstan_ghusht,3).'</td><td>'.round($mande_havale_forushOstan_ghusht,3).'</td><td>'.round($mande_pasazkasrOstan_ghusht,3).'</td>';
			   IF($row4['code_group_kala_top']==6) echo '<td>'.round($mojodyKalaOstan_konserv,3).'</td><td>'.round($mande_havale_forushOstan_konserv,3).'</td><td>'.round($mande_pasazkasrOstan_konserv,3).'</td>';
			   IF($row4['code_group_kala_top']==7) echo '<td>'.round($mojodyKalaOstan_tokhm,3).'</td><td>'.round($mande_havale_forushOstan_tokhm,3).'</td><td>'.round($mande_pasazkasrOstan_tokhm,3).'</td>';
			   IF($row4['code_group_kala_top']==8)  echo '<td>'.round($mojodyKalaOstan_sosis,3).'</td><td>'.round($mande_havale_forushOstan_sosis,3).'</td><td>'.round($mande_pasazkasrOstan_sosis,3).'</td>';
			}//END kala while
		   echo'
		    <td>'.round($jame_mande_pasazkasr_Ostan,3).'</td>		   
		   </tr>';
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
	 	 //جمع کل
	 //مرغ
	 $mojodyKalaKol_morgh+=$mojodyKalaOstan_morgh;
	 $mande_havale_forushKol_morgh+=$mande_havale_forushOstan_morgh;
	 $mande_pasazkasrKol_morgh+=$mande_pasazkasrOstan_morgh;
	 //گوشت
	 $mojodyKalaKol_ghusht+=$mojodyKalaOstan_ghusht;
	 $mande_havale_forushKol_ghusht+=$mande_havale_forushOstan_ghusht;
	 $mande_pasazkasrKol_ghusht+=$mande_pasazkasrOstan_ghusht;
	 //کنسرو
	 $mojodyKalaKol_konserv+=$mojodyKalaOstan_konserv;
	 $mande_havale_forushKol_konserv+=$mande_havale_forushOstan_konserv;
	 $mande_pasazkasrKol_konserv+=$mande_pasazkasrOstan_konserv;
	 //تخم مرغ
	 $mojodyKalaKol_tokhm+=$mojodyKalaOstan_tokhm;
	 $mande_havale_forushKol_tokhm+=$mande_havale_forushOstan_tokhm;
	 $mande_pasazkasrKol_tokhm+=$mande_pasazkasrOstan_tokhm;
	 //سوسیس
	 $mojodyKalaKol_sosis+=$mojodyKalaOstan_sosis;
	 $mande_havale_forushKol_sosis+=$mande_havale_forushOstan_sosis;
	 $mande_pasazkasrKol_sosis+=$mande_pasazkasrOstan_sosis;
	 $jame_mande_pasazkasr_Kol=$mande_pasazkasrKol_morgh+$mande_pasazkasrKol_ghusht+$mande_pasazkasrKol_tokhm+$mande_pasazkasrKol_sosis;
	}//END FIRST while,ostan while
    if((($_SESSION['mt_all_ostan']==1)or(SuperUser()))and($ostan_val==-1))
	{

	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" >
	  <td colspan="5">جمع کل استان ها</td>';
	   $q5="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition";
       $res5=$db->query($q5);
	   while($row5=$db->fetch_assoc($res5))
	   {
		 //مجموع موجودی هر کالادر تمام استان ها
		IF($row5['code_group_kala_top']==4) echo '<td>'.round($mojodyKalaKol_morgh,3).'</td><td>'.round($mande_havale_forushKol_morgh,3).'</td><td>'.round($mande_pasazkasrKol_morgh,3).'</td>';
        IF($row5['code_group_kala_top']==5) echo '<td>'.round($mojodyKalaKol_ghusht,3).'</td><td>'.round($mande_havale_forushKol_ghusht,3).'</td><td>'.round($mande_pasazkasrKol_ghusht,3).'</td>';
	    IF($row5['code_group_kala_top']==6) echo '<td>'.round($mojodyKalaKol_konserv,3).'</td><td>'.round($mande_havale_forushKol_konserv,3).'</td><td>'.round($mande_pasazkasrKol_konserv,3).'</td>';
		IF($row5['code_group_kala_top']==7) echo '<td>'.round($mojodyKalaKol_tokhm,3).'</td><td>'.round($mande_havale_forushKol_tokhm,3).'</td><td>'.round($mande_pasazkasrKol_tokhm,3).'</td>';
		IF($row5['code_group_kala_top']==8) echo '<td>'.round($mojodyKalaKol_sosis,3).'</td><td>'.round($mande_havale_forushKol_sosis,3).'</td><td>'.round($mande_pasazkasrKol_sosis,3).'</td>';
	   }//END kala while
	 echo'
	  <td>'.round($jame_mande_pasazkasr_Kol,3).'</td>
	 </tr>';
	}
	//END//
  echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
    <tr class="print_footer noExl">
     <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
    </tr>
 </table>';
 }
  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'
</div>	
</form>
</body>
</html>';	
?>