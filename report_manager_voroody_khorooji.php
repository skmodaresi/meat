<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_voroody_khorooji.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش ورودی و خروجی سردخانه ها';
/****************هدر******************/
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
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
	  //خروجی اکسل
      $("#exportExcel").click(function(){
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "report_manager_voroody_khorooji",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
	  });
	  //نمایش ستونها
	  $("input:checkbox:not(:checked)").each(function() {
       var column = "table ." + $(this).attr("name");
       $(column).hide();
      });
      $("input:checkbox").click(function(){
       var column = "table ." + $(this).attr("name");
       $(column).toggle();
      });  
});
</script> 
</head>';
$columns='
    <tr class="print_table-title2">
     <td width="4%" >ردیف</td>
     <td width="4%" >کد استان</td>
     <td width="9%" >استان</td>
	 <td width="4%" >کد سردخانه</td>
	 <td width="10%" >سردخانه</td>
     <td width="4%" >کد کالا</td>
     <td width="5%" >کالا</td>
     <td width="10%" class="mande_beforPr" >مانده موجودی از قبل</td>
     <td width="10%" class="varedePr" >وارده به سردخانه</td>
     <td width="10%" class="saderePr" >صادره از سردخانه</td>
	 <td width="10%" class="tadil_ezafePr" >تعدیل (اضافه)</td>
     <td width="10%" class="tadil_kasryPr" >تعدیل (کسری)</td>
	 <td width="10%" class="mandePr" >مانده موجودی</td>
	</tr>';
Function print_header()
{global $titr,$columns,$count,$mt_gl_owner,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$kalaName,$code_kala,$Condition;
 echo'
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
	      از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
         <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
	   </tr>
      </table>
     </td>
    </tr>';
}	 
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=5;
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
<table width="95%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="750px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
	<!--<tr class="tr1">
	 <td align="left"> سال : </td><td align="right" colspan="3">&nbsp;'.listbox("mtact_yr",$mtActiveYear,"year","year","mt_docs","1=1 ORDER BY year","onChange='myform.submit()' class='text4'","").'</td>
    </tr>-->
	<tr class="tr1" style="height:40px">
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>	
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> وضعیت نمایش سردخانه های موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='text4'").'</td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right" >&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1" style="height:40px">
     <td align="left">نام کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="kalachoice[]" class="easyui-combobox" size="6" style="width:300px;" multiple>';
	  $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']."</option>";
	  echo $kala_options;
	  echo'
	  </select>
	 </td>
	</tr> ';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1" style="height:40px">
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox text4" style="width:300px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>
	  </td>
	 </tr>';
	}
	echo'
	<tr class="footer">	
	 <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
    <!--    <tr class="footer"><td  colspan="4">&nbsp;</td></tr>-->
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
/****************فیلترها روی گزارش******************/
/************************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $ostan_key => $ostan_val ) 
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
/******************کد های کالا**********************/
if(is_array($kalachoice))
{
  foreach($kalachoice as $key_kala => $kala_val ) {
  $Condition_kala_temp.=" T.code_kala='$kala_val' OR";
  }
  if($kala_val==-1)$Condition_kala.="1=1 OR";
  else $Condition_kala.=" $Condition_kala_temp";
  $lastSpacePosition = strrpos($Condition_kala," ");
  $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
}
/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
if($show_movaghat==1){$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_a.situation_type=1 AND";}
else if($show_movaghat==2){$Condition_movaghat="";$Condition_movaghat_mj="";}
else if($show_movaghat==3){$Condition_movaghat="list_sardkhane.situation_type=2 AND ";$Condition_movaghat_mj="";}
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_mj="";  $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND"; $Condition_anbar_activate_mj="l_a.activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
	   
/****************شروع نمایش گزارش*******************/	
$radif=1;
$page=1;
$line=0;
$i=0;
$cntr=0;
$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT list_sardkhane.code_ostan FROM list_sardkhane INNER JOIN mojody_kala T ON T.code_ostan=list_sardkhane.code_ostan AND T.code_anbar=list_sardkhane.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate_ostan AND T.year=$mtActiveYear AND ($Condition_kala)) AND($Condition_ostan) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{
IF($noe_namayesh==1) {$str='خالص';$sum_str='کیلوگرم';}
 IF($noe_namayesh==2) {$str='ناخالص';$sum_str='کیلوگرم';}
 IF($noe_namayesh==3) {$str='تعداد';$sum_str='تعداد';}
 echo'
 <br>
 <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title"><td colspan="6">وضعیت نمایش ستونها در گزارش ('.$str.')</td></tr>
      	<tr class="print_table-title">
		 <td width="5%">مانده موجودی از قبل </td>
	     <td width="4%" >وارده به سردخانه</td>
	     <td width="5%" >صادره از سردخانه</td>
		 <td width="4%" >تعدیل (اضافه)</td>
	     <td width="4%" >تعدیل (کسری)</td>
		 <td width="4%" >مانده موجودی</td>
	    </tr>   	
		<tr class="print_table-title2">
	     <td><input name="mande_beforPr" type="checkbox" checked ></td>
	     <td><input name="varedePr" type="checkbox" checked ></td>
	     <td><input name="saderePr" type="checkbox" checked ></td>
		 <td><input name="tadil_ezafePr" type="checkbox" checked></td>
	     <td><input name="tadil_kasryPr" type="checkbox" checked></td>
		 <td><input name="mandePr" type="checkbox" checked ></td>
	    </tr>	
 </table>
 <div class="table2excel">';
 print_header();
  /*سطر نمایش فیلترها*/
  if(is_array($ostanchoice))
  {
	  if($ostan_val==-1)$filter_string='همه استانها';
	  else $filter_string=' استان : ';
	  foreach($ostanchoice as $ostan_key => $ostan_val) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
  }
  if($show_movaghat==1) $filter_string.=' بدون اطلاعات سردخانه موقت -';
  else if($show_movaghat==2) $filter_string.=' با اطلاعات سردخانه موقت -';
  else if($show_movaghat==3) $filter_string.=' فقط اطلاعات سردخانه موقت -';
  if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
  if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
  if(is_array($kalachoice))
  {
	  if($kala_val==-1)$filter_string.='همه کالاها';
	  else $filter_string.=' کالا : ';
	  foreach($kalachoice as $key_kala => $kala_val) {
	  $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
	  $filter_string.=''.$nameKala.'&nbsp;';
      }
  }
  if($noe_namayesh==1) $filter_string.="نمایش اطلاعات : خالص";
  if($noe_namayesh==2) $filter_string.="نمایش اطلاعات : ناخالص";
  if($noe_namayesh==3) $filter_string.="نمایش اطلاعات : تعداد";
  echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
  echo''.$columns.'';
  while($row=$db->fetch_array($res))//ostan while
 {	  
    $line++;
   	//تعداد انبار ها
	// if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","$Condition_movaghat $Condition_anbar_activate code_ostan=".$row['code_ostan']."");//تعداد انبارهای هر استان 
	// else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_movaghat $Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای هر استان     
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(distinct(name_anbar))","list_sardkhane INNER JOIN mojody_kala T ON T.code_ostan=list_sardkhane.code_ostan AND T.code_anbar=list_sardkhane.code_anbar","$Condition_movaghat $Condition_anbar_activate T.code_ostan=".$row['code_ostan']." AND($Condition_kala)");//تعداد انبارهای هر استان 
	else $tedadanbar=$db->get_from_where("count(distinct(user_ostan_anbar.code_anbar))","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar INNER JOIN mojody_kala T ON T.code_ostan=list_sardkhane.code_ostan AND T.code_anbar=list_sardkhane.code_anbar","$Condition_movaghat $Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." AND($Condition_kala)");//تعداد انبارهای هر استان     
	
	$rowanbar=$tedadanbar;
    //$tedadkala=$db->get_from_where("COUNT(distinct code_kala)","mojody_kala T INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar","$Condition_anbar_activate T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND($Condition_kala)");
    $tedadkala=$db->get_from_where("COUNT(code_kala)","kala T","$Condition_kala");
	$rowkala=$tedadkala;
	
	$row_anbarkala=$rowanbar*$rowkala;
	$t=$rowanbar;
    if($i++%2)echo'<tr class="print_table-odd_small">';
    else echo'<tr class="print_table-even_small">';
    echo'   
    <td rowspan="'.$row_anbarkala.'">'.$radif++.'</td>
    <td rowspan="'.$row_anbarkala.'">'.$row['code_ostan'].'</td>
    <td rowspan="'.$row_anbarkala.'">'.$row['name_ostan'].'</td>';
    /**///حلقه روی انبار ها
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT distinct(T.code_anbar) FROM list_sardkhane INNER JOIN mojody_kala T ON T.code_ostan=list_sardkhane.code_ostan AND T.code_anbar=list_sardkhane.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate T.code_ostan=".$row['code_ostan']." AND($Condition_kala) ORDER BY name_anbar";
	else $q2="SELECT distinct(list_sardkhane.code_anbar) FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar INNER JOIN mojody_kala T ON T.code_ostan=list_sardkhane.code_ostan AND T.code_anbar=list_sardkhane.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." AND($Condition_kala) ORDER BY name_anbar";
	$res2=$db->query($q2);
	while($row2=$db->fetch_assoc($res2))//حلقه انبارها
	{	
     $j=$i+1;
   	 $t2=$rowkala;
	 $name_anbar=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='".$row['code_ostan']."' AND code_anbar='".$row2['code_anbar']."'");
	  if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
      else $code_a=$row['code_ostan'];
	 echo'
	 <td rowspan="'.$rowkala.'">'.$row2['code_anbar'].'</td>';
	 IF(SuperUser())echo'<td rowspan="'.$rowkala.'">'.$code_a.$row2['code_anbar'].'-'.$name_anbar.'</td>';
	 ELSE echo'<td rowspan="'.$rowkala.'">'.$name_anbar.'</td>';
     //$q_kala="SELECT code_kala,(SELECT name_kala FROM kala WHERE code_kala=T.code_kala) name_kala FROM mojody_kala T INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar WHERE $Condition_anbar_activate T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND($Condition_kala) GROUP BY code_kala";
     $q_kala="SELECT code_kala,name_kala FROM kala T WHERE $Condition_kala";
	 //echo $q_kala.'<br>';
	 $res_kala=$db->query($q_kala);
	 while($row_kala=$db->fetch_assoc($res_kala))
	 {
	   $k=$i+1;
	   echo'
	   <td>'.$row_kala['code_kala'].'</td>
	   <td>'.$row_kala['name_kala'].'</td>'; 
       /**************************نوع نمایش خالص**********************************/
	   if($noe_namayesh==1)
	   {
	   	/****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
	    //فیلد اول
	    $mande_befor=0;
		$avaliye=$db->get_from_where("SUM(mojody_khales_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0");     
	    $jameVarede_befor=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (r.noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."'");
	    $jameSadere_befor=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."'");	
		$meghdarTadil_Ezafe_befor=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0");     
	    $meghdarTadil_Kasry_befor=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0");     
	    $mande_befor=$avaliye+$jameVarede_befor-$jameSadere_befor+$meghdarTadil_Ezafe_befor-$meghdarTadil_Kasry_befor;	      
	    //وارده
	    $varede=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
		//صادره
	    $sadere=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2'");	
	    //تعدیل
	    $tadil_ezafe=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	    $tadil_kasry=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	   }
	   /**************************نوع نمایش ناخالص**********************************/
	   if($noe_namayesh==2)
	   {
	   	/****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
	    //فیلد اول
	    $mande_befor=0;
		$avaliye=$db->get_from_where("SUM(mojody_nakhales_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0");     
	    $jameVarede_befor=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (r.noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."'");
	    $jameSadere_befor=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."'");	
		$meghdarTadil_Ezafe_befor=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0");     
	    $meghdarTadil_Kasry_befor=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0");     
	    $mande_befor=$avaliye+$jameVarede_befor-$jameSadere_befor+$meghdarTadil_Ezafe_befor-$meghdarTadil_Kasry_befor;	      
	    //وارده
	    $varede=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
		//صادره
	    $sadere=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2'");	
	    //تعدیل
	    $tadil_ezafe=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	    $tadil_kasry=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	   }
       /**************************نوع نمایش تعداد**********************************/
	   if($noe_namayesh==3)
	   {
	   	/****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
	    //فیلد اول
	    $mande_befor=0;
		$avaliye=$db->get_from_where("SUM(tedad_karton_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0");     
	    $jameVarede_befor=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (r.noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."'");
	    $jameSadere_befor=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."'");	
		$meghdarTadil_Ezafe_befor=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0");     
	    $meghdarTadil_Kasry_befor=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0");     
	    $mande_befor=$avaliye+$jameVarede_befor-$jameSadere_befor+$meghdarTadil_Ezafe_befor-$meghdarTadil_Kasry_befor;	      
	    //وارده
	    $varede=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
		//صادره
	    $sadere=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar!=10) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2'");	
	    //تعدیل
	    $tadil_ezafe=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	    $tadil_kasry=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	   }
	   	//مانده موجودی
	    $mande_nahayi=0;
	    $mande_nahayi=$mande_befor+$varede-$sadere+$tadil_ezafe-$tadil_kasry;
	 //نمایش اطلاعات
	 echo'
		  <td class="mande_beforPr">'.round($mande_befor,3).'</td>
		  <td class="varedePr">'.round($varede,3).'</td>
		  <td class="saderePr">'.round($sadere,3).'</td>
		  <td class="tadil_ezafePr">'.round($tadil_ezafe,3).'</td>
		  <td class="tadil_kasryPr">'.round($tadil_kasry,3).'</td>
		  <td class="mandePr">'.round($mande_nahayi,3).'</td>';
	    $jame_mande_befor+=$mande_befor;
	    $jame_varede+=$varede;
	    $jame_sadere+=$sadere;
	    $jame_tadil_ezafe+=$tadil_ezafe;
	    $jame_tadil_kasry+=$tadil_kasry;
	    $jame_mande_nahayi+=$mande_nahayi;
   		/*****************************************/
		  $t2--;//هر دفعه از تعداد گروه کالا کم می شود
		  if($t2==0) {echo'';}
		  else 
		  {
		   echo'</tr>';
		   if($k++%2)echo'<tr class="print_table-odd_small">';
           else echo'<tr class="print_table-even_small">';
	      } 
	    }//END foreach Groupkala
	   /*****************************************/
		$t--;//هر دفعه از تعداد انبارهای اون استان کم می شود
	    if($t==0) {echo'';}
		else 
		{
		  echo'</tr>';
		  if($j++%2)echo'<tr class="print_table-odd_small">';
          else echo'<tr class="print_table-even_small">';
		}
	  }//END WHILE anbar
     /*****تکرار سرصفحه و ستون ها*****/
     if($line>=$MaxLines && $i <$cntr) 
	 {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
			echo $columns;
     }
   }//END WHILE ostan

 /*****سطر جمع کل استان ها*****/
   echo'
	 <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	    <td colspan="7">جمع کل ('.$sum_str.')</td>
		<td class="mande_beforPr">'.round($jame_mande_befor,3).'</td>
	    <td class="varedePr">'.round($jame_varede,3).'</td>
	    <td class="saderePr">'.round($jame_sadere,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi,3).'</td>
	 </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
   <tr class="print_footer noExl">
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
 }//END IF//وجود اطلاعات
  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'
</div>	
</form>
</body>
</html>';	
?>