<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_anbargardani2.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش انبارگردانی';
$columns='
	<tr class="print_table-title2 print_table-title_small">
     <td width="3%" rowspan="2">ردیف</td>
     <td width="8%" rowspan="2">استان</td>
     <td width="15%" rowspan="2">سردخانه</td>
     <td width="5%" rowspan="2">گروه کالا</td>
     <td width="22%" colspan="3">موجودی سیستم</td>
     <td width="22%" colspan="3">مقدار انبارگردانی</td>
	 <td width="10%" colspan="3">اول دوره سال بعد</td>
     <td width="13%" colspan="3">کسری</td>
     <td width="12%" colspan="3">اضافه</td>
	</tr>
	<tr class="print_table-title2 print_table-title_small">
	 <td>داخلی</td><td>وارداتی</td><td>جمع</td>
	 <td>داخلی</td><td>وارداتی</td><td>جمع</td>
	 <td>داخلی</td><td>وارداتی</td><td>جمع</td>
	 <td>داخلی</td><td>وارداتی</td><td>جمع</td>
	 <td>داخلی</td><td>وارداتی</td><td>جمع</td>
	</tr>';
/****************هدر******************/
Function print_header()
{global $titr,$columns,$mtActiveYear,$count,$mt_gl_owner,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$kalaName,$code_kala,$Condition;
 echo'
   <br/>   
   <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr>
     <td colspan="50">
      <table width="100%"  align="center">
	   <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
   	   <tr><td class="print_title_2">'.$titr.'
	     سال : '.$mtActiveYear.'&nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
       </tr>
	  </table>
	 </td>
	</tr> 	  
    '.$columns.'';
}
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
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
/****************فیلترها روی گزارش******************/
/************************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $val ) 
      {
       $Condition_ostan_temp.=" T.code_ostan='$val' OR";
      }
      if($val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{$Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';}
/*****************************انبارها****************************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_resid_d='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
   $Condition_anbar_resid_d_temp.=" r_d.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_resid_d.="  $Condition_anbar_resid_d_temp";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_resid_d = strrpos($Condition_anbar_resid_d," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
	 $Condition_anbar_resid_d =substr($Condition_anbar_resid_d,0,$lastSpacePosition_resid_d);
}
/**************انتخاب گروه کالا****************/
if(is_array($groupkalachoice))
{
 $grpkalaArrChoice=array();//کالاهای انتخاب شده داخل این آرایه قرار میگیرد
 foreach($groupkalachoice as $grp_val) 
 {
  if($grp_val=='همه'){$grpkalaArrChoice=array();$grpkalaArrChoice=$kalagroupArr;break;}
  else array_push($grpkalaArrChoice,$grp_val);
  //print_r($grpkalaArrChoice);
 }
}
/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
if($show_movaghat==1){$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_s.situation_type=1 AND ";}
else if($show_movaghat==2){$Condition_movaghat="";$Condition_movaghat_mj="";}
else if($show_movaghat==3){$Condition_movaghat="list_sardkhane.situation_type=2 AND ";$Condition_movaghat_mj="";}//خودش موقت ولی مقصد هر انباری
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=3;
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
    <tr class="tr1">
     <td align="left"> سال : </td><td align="right" colspan="3">&nbsp;<input type="text" readonly class="textboxme2" maxlength="4" name="year" value="'.$mtActiveYear.'" /></td>	
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>	
	 <td align="left"> تعداد استان در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> وضعیت نمایش سردخانه های موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='text4'").'</td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
    <tr class="tr1">
     <td align="left">گروه کالا : </td>
     <td align="right">
	  &nbsp;<select name="groupkalachoice[]" size="6" style="width:130px;" multiple>
	  <option value="همه" selected>همه کالاها</option>';
	  foreach($kalagroupArr as $grp_key=>$grp_val)
	  {echo '<option value="'.$grp_val.'" >'.$grp_val.'</option>';}
	  echo'
	  <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  &nbsp;
	 </td>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
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
	  </td>';
	}
    else echo '<td colspan="2">&nbsp;</td>';	
	echo'
	</tr>
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
//شرط برای اینکه فقط آنهایی که حداقل یه  کالا دارند را بیاورد
foreach($groupkalachoice as $x => $x_value) 
{
	   $kalaCondition='';
	   if($x_value=="گوشت گاو")$kalaCondition=" AND (m.code_kala=81 OR m.code_kala=82 OR m.code_kala=83 OR m.code_kala=84 OR m.code_kala=85 OR m.code_kala=86 OR m.code_kala=75 OR m.code_kala=76 OR m.code_kala=78 OR m.code_kala=92)";
	   else if($x_value=="گوشت گوسفند")$kalaCondition=" AND (m.code_kala=144 OR m.code_kala=148 OR m.code_kala=149 OR m.code_kala=150 OR m.code_kala=151)";
	   else if($x_value=="گوشت مرغ")$kalaCondition=" AND (m.code_kala=38 OR m.code_kala=401 OR m.code_kala=402 OR m.code_kala=403 OR m.code_kala=404 OR m.code_kala=410 OR m.code_kala=411 OR m.code_kala=412 OR m.code_kala=197 OR m.code_kala=198 OR m.code_kala=405 OR m.code_kala=413 OR m.code_kala=414 OR m.code_kala=415 OR m.code_kala=154)";
       else if($x_value=="کنسرو مرغ") $kalaCondition=" AND (m.code_kala=406 OR m.code_kala=407)";
       else if($x_value=="تخم مرغ خوراکی") $kalaCondition=" AND (m.code_kala=50)";
	   //else if($x_value=="همه")  {$kalaCondition="AND (m.code_kala=1 OR m.code_kala=21 OR m.code_kala=17 OR m.code_kala=11 OR m.code_kala=20 OR m.code_kala=2) AND mojody>0";}
}
//استانها
$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane) AND($Condition_ostan) ORDER BY name_ostan";
//$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT list_sardkhane.code_ostan FROM list_sardkhane INNER JOIN mt_anbargardani_detail m ON m.code_ostan=list_sardkhane.code_ostan AND m.code_anbar=list_sardkhane.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate_ostan AND m.year=$mtActiveYear $kalaCondition) AND($Condition_ostan) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
 <br/>
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
  <tr>
   <td colspan="50">
    <table width="100%" align="center">
     <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
     <tr><td class="print_title_2">'.$titr.'
      <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
	  سال : '.$mtActiveYear.'&nbsp&nbsp(صفحه : '.$page.')
      <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	 </td>
    </tr>
   </table>
  </td>
 </tr> ';
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
if(is_array($groupkalachoice))
{
	$filter_string.=' گروه کالا : ';
	foreach($groupkalachoice as $grp_val) 
	{
	  if($grp_val=="همه"){$filter_string.=' همه کالاها ';break;}
	  else $filter_string.=''.$grp_val.'&nbsp;';
   }
}
if($show_movaghat==1) $filter_string.=' بدون اطلاعات سردخانه موقت-';
else if($show_movaghat==2) $filter_string.=' با اطلاعات سردخانه موقت-';
else if($show_movaghat==3) $filter_string.=' فقط اطلاعات سردخانه موقت-';

if($noe_namayesh==1) $filter_string.="نمایش اطلاعات : خالص";
if($noe_namayesh==2) $filter_string.="نمایش اطلاعات : ناخالص";
if($noe_namayesh==3) $filter_string.="نمایش اطلاعات : تعداد";
 echo'<tr><td class="filter_text" colspan="50">توجه : دقت کنید در این گزارش سردخانه هایی نمایش داده می شود که فرم انبارگردانی را تکمیل کرده اند</td></tr>';
 echo'<tr><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
 echo'
 '.$columns.'';
   while($row=$db->fetch_array($res))//حلقه استانها
   {	
    $line++;
	//تعداد انبار ها
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","$Condition_movaghat code_ostan=".$row['code_ostan']."");//تعداد انبارهای هر استان 
	else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای هر استان     
    //if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(distinct(name_anbar))","list_sardkhane INNER JOIN mt_anbargardani_detail m ON m.code_ostan=list_sardkhane.code_ostan AND m.code_anbar=list_sardkhane.code_anbar","$Condition_movaghat $Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND m.year=$mtActiveYear $kalaCondition");//تعداد انبارهای هر استان 
	//else $tedadanbar=$db->get_from_where("count(distinct(user_ostan_anbar.code_anbar))","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar INNER JOIN mt_anbargardani_detail m ON m.code_ostan=list_sardkhane.code_ostan AND m.code_anbar=list_sardkhane.code_anbar","$Condition_movaghat $Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." AND m.year=$bzActiveYear $kalaCondition");//تعداد انبارهای هر استان     
		
	$rowanbar=$tedadanbar;
    $rowgrkala=count($grpkalaArrChoice);
	$row_anbarkala=$rowanbar*$rowgrkala;
	$t=$rowanbar;

	if($i++%2)echo'<tr class="print_table-odd_small">';
    else echo'<tr class="print_table-even_small">';
    echo'   
    <td rowspan="'.$row_anbarkala.'">'.$radif++.'</td>
    <td rowspan="'.$row_anbarkala.'">'.$row['name_ostan'].'</td>';
	 /**///حلقه روی انبار ها
	  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM list_sardkhane WHERE $Condition_movaghat code_ostan=".$row['code_ostan']."";
	  else $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."";
	  //if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT distinct(list_sardkhane.code_anbar) FROM list_sardkhane INNER JOIN mt_anbargardani_detail m ON m.code_ostan=list_sardkhane.code_ostan AND m.code_anbar=list_sardkhane.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND m.year=$mtActiveYear $kalaCondition ORDER BY name_anbar";
	  //else $q2="SELECT distinct(list_sardkhane.code_anbar) FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar INNER JOIN mt_anbargardani_detail m ON m.code_ostan=list_sardkhane.code_ostan AND m.code_anbar=list_sardkhane.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." AND m.year=$bzActiveYear $kalaCondition  ORDER BY name_anbar";
      
	  $res2=$db->query($q2);
	  while($row2=$db->fetch_assoc($res2))//حلقه انبارها
	  {	   
	   $j=$i+1;
	   $t2=$rowgrkala;
	   $name_sardkhane=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='".$row['code_ostan']."' AND code_anbar='".$row2['code_anbar']."'");
	   echo'<td rowspan="'.$rowgrkala.'">'.$name_sardkhane.'</td>';
	   //echo'<td >'.$row2['name_anbar'].'</td>';
	    foreach($grpkalaArrChoice as $x => $x_value )//حلقه گروه کالا 
        {
	      $sty_dakheli='';
	      $sty_varedati='';
	      $sty_dakheli2='';
	      $sty_varedati2='';
		  $k=$i+1;
		  echo'
	      <td>'.$x_value.'</td>';	  
		  if($x_value=="گوشت گاو")
	      {
	        //dakheli:81,82,83,84,85,86
	        $kalaCondition_dakheli=" AND (T.code_kala=81 OR T.code_kala=82 OR T.code_kala=83 OR T.code_kala=84 OR T.code_kala=85 OR T.code_kala=86)";
	        $kalaCondition_resid_d_dakheli=" AND (r_d.code_kala=81 OR r_d.code_kala=82 OR r_d.code_kala=83 OR r_d.code_kala=84 OR r_d.code_kala=85 OR r_d.code_kala=86)";
	        $kalaCondition_dakheli_sell=" AND (h_p_code=81 OR h_p_code=82 OR h_p_code=83 OR h_p_code=84 OR h_p_code=85 OR h_p_code=86)";
	        //varedati:75,76,78,92
	        $kalaCondition_varedati=" AND (T.code_kala=75 OR T.code_kala=76 OR T.code_kala=78 OR T.code_kala=92)";
	        $kalaCondition_resid_d_varedati=" AND (r_d.code_kala=75 OR r_d.code_kala=76 OR r_d.code_kala=78 OR r_d.code_kala=92)";
	        $kalaCondition_varedati_sell=" AND (h_p_code=75 OR h_p_code=76 OR h_p_code=78 OR h_p_code=92)";
	        $bastebandy=1;
	      }
	      if($x_value=="گوشت گوسفند")
	      {
	        //dakheli:144,148,149,150,151
	        $kalaCondition_dakheli=" AND (T.code_kala=144 OR T.code_kala=148 OR T.code_kala=149 OR T.code_kala=150 OR T.code_kala=151)";
	        $kalaCondition_resid_d_dakheli=" AND (r_d.code_kala=144 OR r_d.code_kala=148 OR r_d.code_kala=149 OR r_d.code_kala=150 OR r_d.code_kala=151)";
	        $kalaCondition_dakheli_sell=" AND (h_p_code=144 OR h_p_code=148 OR h_p_code=149 OR h_p_code=150 OR h_p_code=151)";
	        //varedati:dont exist
	        $kalaCondition_varedati=" AND 1!=1";
	        $kalaCondition_resid_d_varedati=" AND 1!=1";
	        $kalaCondition_varedati_sell=" AND 1!=1";	 
            $bastebandy=1;
	      }
	      if($x_value=="گوشت مرغ")//به جز جگر مرغ
	      {
	        //dakheli:38,401,402,403,404,410,411,412,197,198,405,413,414,415
	        $kalaCondition_dakheli=" AND (T.code_kala=38 OR T.code_kala=401 OR T.code_kala=402 OR T.code_kala=403 OR T.code_kala=404 OR T.code_kala=410 OR T.code_kala=411 OR T.code_kala=412 OR T.code_kala=197 OR T.code_kala=198 OR T.code_kala=405 OR T.code_kala=413 OR T.code_kala=414 OR T.code_kala=415)";
	        $kalaCondition_resid_d_dakheli=" AND (r_d.code_kala=38 OR r_d.code_kala=401 OR r_d.code_kala=402 OR r_d.code_kala=403 OR r_d.code_kala=404 OR r_d.code_kala=410 OR r_d.code_kala=411 OR r_d.code_kala=412 OR r_d.code_kala=197 OR r_d.code_kala=198 OR r_d.code_kala=405 OR r_d.code_kala=413 OR r_d.code_kala=414 OR r_d.code_kala=415)";
	        $kalaCondition_dakheli_sell=" AND (h_p_code=38 OR h_p_code=401 OR h_p_code=402 OR h_p_code=403 OR h_p_code=404 OR h_p_code=410 OR h_p_code=411 OR h_p_code=412 OR h_p_code=197 OR h_p_code=198 OR h_p_code=405 OR h_p_code=413 OR h_p_code=414 OR h_p_code=415)";
	        //varedati:154
	        $kalaCondition_varedati=" AND T.code_kala=154";
	        $kalaCondition_resid_d_varedati=" AND r_d.code_kala=154";
	        $kalaCondition_varedati_sell=" AND h_p_code=154";
	        $bastebandy=1;
	      }
          if($x_value=="کنسرو مرغ")  
	      {
	        //dakheli:406,407
	        $kalaCondition_dakheli=" AND (T.code_kala=406 OR T.code_kala=407)";
	        $kalaCondition_resid_d_dakheli=" AND (r_d.code_kala=406 OR r_d.code_kala=407)";
	        $kalaCondition_dakheli_sell=" AND (h_p_code=406 OR h_p_code=407)";
	        //varedati:dont exist
	        $kalaCondition_varedati=" AND 1!=1";
	        $kalaCondition_resid_d_varedati=" AND 1!=1";
	        $kalaCondition_varedati_sell=" AND 1!=1";
	        $bastebandy=2;
	      }
	      if($x_value=="تخم مرغ خوراکی")
          {
 	        //dakheli:50
	        $kalaCondition_dakheli=" AND T.code_kala=50";
	        $kalaCondition_resid_d_dakheli=" AND r_d.code_kala=50";
	        $kalaCondition_dakheli_sell=" AND h_p_code=50";
	        //varedati:dont exist
	        $kalaCondition_varedati=" AND 1!=1";
	        $kalaCondition_resid_d_varedati=" AND 1!=1";
	        $kalaCondition_varedati_sell=" AND 1!=1";
	        $bastebandy=1;
	      }
	      // if($x_value=="مرغ مادر")
          // {
 	       // //dakheli:405
	       // $kalaCondition_dakheli=" AND T.code_kala=405";
	       // $kalaCondition_dakheli_sell=" AND h_p_code=405";
	       // //varedati:dont exist
	       // $kalaCondition_varedati=" AND 1!=1";
	       // $kalaCondition_varedati_sell=" AND 1!=1";
	      // }
		 /**************************نوع نمایش خالص**********************************/
	     if($noe_namayesh==1)
	     {
	      /****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
          //فیلد اول-حالت داخلی
	       $mojody_sys_dakheli=0;
		   $avaliye_dakheli=$db->get_from_where("SUM(mojody_khales_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_dakheli");     	  		   
		   $varede_dakheli=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0  $kalaCondition_dakheli");
	       $sadere_dakheli=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 $kalaCondition_dakheli");	
		   $tadil_ezafe_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli");     
	       $tadil_kasry_dakheli=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli");     
	       $mojody_sys_dakheli=$avaliye_dakheli+$varede_dakheli-$sadere_dakheli+$tadil_ezafe_dakheli-$tadil_kasry_dakheli;
		  //فیلد دوم -حالت وارداتی
	       $avaliye_varedati=$db->get_from_where("SUM(mojody_khales_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_varedati");     	  		   
		   $varede_varedati=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0  $kalaCondition_varedati");
	       $sadere_varedati=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 $kalaCondition_varedati");	
		   $tadil_ezafe_varedati=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati");     
	       $tadil_kasry_varedati=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati");     
	       $mojody_sys_varedati=$avaliye_varedati+$varede_varedati-$sadere_varedati+$tadil_ezafe_varedati-$tadil_kasry_varedati;
		  //فیلد سوم
	       $jame_mojody_sys=0;
	       $jame_mojody_sys=$mojody_sys_dakheli+$mojody_sys_varedati;
		  //فیلد چهارم-مقدار انبارگردانی-حالت داخلی
	       $anbargardani_dakheli=$db->get_from_where("SUM(khales_anbargardani)","mt_anbargardani_detail T INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." $kalaCondition_dakheli");     
	      //فیلد پنجم-مقدارانبارگردانی-حالت وارداتی
	       $anbargardani_varedati=$db->get_from_where("SUM(khales_anbargardani)","mt_anbargardani_detail T INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." $kalaCondition_varedati");     
	      //فیلد ششم
	       $jame_anbargardani=0;
	       $jame_anbargardani=$anbargardani_dakheli+$anbargardani_varedati;
	      
		   $sal_bad=$mtActiveYear+1;
	   	   $avaliye_dakheli_salbad=$db->get_from_where("SUM(mojody_khales_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$sal_bad' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_dakheli");     	  		   
	   	   $avaliye_varedati_salbad=$db->get_from_where("SUM(mojody_khales_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$sal_bad' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_varedati");     	  		   
	       $jame_mojody_sys_salbad=0;
	       $jame_mojody_sys_salbad=$avaliye_dakheli_salbad+$avaliye_varedati_salbad;
	   
	       if((round($avaliye_dakheli_salbad,3)!=round($mojody_sys_dakheli,3)))$sty_dakheli='background-color:white;';
	       if((round($avaliye_varedati_salbad,3)!=round($mojody_sys_varedati,3)))$sty_varedati='background-color:white;';
	       if((round($avaliye_dakheli_salbad,3)!=round($anbargardani_dakheli,3)))$sty_dakheli2='color:#8C001A;';
	       if((round($avaliye_varedati_salbad,3)!=round($anbargardani_varedati,3)))$sty_varedati2='color:#FF0080;';
	       
		  
		  //کسری-اضافه داخلی
	       $diffrence_dakheli=0;$diffrence_kasry_dakheli=0;$diffrence_ezafe_dakheli=0;
	       {$diffrence_dakheli=$mojody_sys_dakheli-$anbargardani_dakheli;
	        IF($diffrence_dakheli>0)$diffrence_kasry_dakheli=($diffrence_dakheli);
	        ELSE IF($diffrence_dakheli<0)$diffrence_ezafe_dakheli=abs($diffrence_dakheli);
	       }
		  //کسری-اضافه وارداتی
	       $diffrence_varedati=0;$diffrence_kasry_varedati=0;$diffrence_ezafe_varedati=0;
	       {$diffrence_varedati=$mojody_sys_varedati-$anbargardani_varedati;
	        IF($diffrence_varedati>0)$diffrence_kasry_varedati=($diffrence_varedati);
	        ELSE IF($diffrence_varedati<0)$diffrence_ezafe_varedati=abs($diffrence_varedati);
	       }
	       $jame_diffrence_kasry=$diffrence_kasry_dakheli+$diffrence_kasry_varedati;
	       $jame_diffrence_ezafe=$diffrence_ezafe_dakheli+$diffrence_ezafe_varedati;
         }//END noe_namayesh khales
	      /**************************نوع نمایش ناخالص**********************************/
	      if($noe_namayesh==2)
	      {
	       /****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
           //فیلد اول-حالت داخلی
	       $mojody_sys_dakheli=0;
		   $avaliye_dakheli=$db->get_from_where("SUM(mojody_nakhales_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_dakheli");     	  		   
		   $varede_dakheli=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0  $kalaCondition_dakheli");
	       $sadere_dakheli=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 $kalaCondition_dakheli");	
		   $tadil_ezafe_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli");     
	       $tadil_kasry_dakheli=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli");     
	       $mojody_sys_dakheli=$avaliye_dakheli+$varede_dakheli-$sadere_dakheli+$tadil_ezafe_dakheli-$tadil_kasry_dakheli;

		   //فیلد دوم -حالت وارداتی
	       $avaliye_varedati=$db->get_from_where("SUM(mojody_nakhales_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_varedati");     	  		   
		   $varede_varedati=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0  $kalaCondition_varedati");
	       $sadere_varedati=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 $kalaCondition_varedati");	
		   $tadil_ezafe_varedati=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati");     
	       $tadil_kasry_varedati=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati");     
	       $mojody_sys_varedati=$avaliye_varedati+$varede_varedati-$sadere_varedati+$tadil_ezafe_varedati-$tadil_kasry_varedati;
		  //فیلد سوم
	       $jame_mojody_sys=0;
	       $jame_mojody_sys=$mojody_sys_dakheli+$mojody_sys_varedati;
		  //فیلد چهارم-مقدار انبارگردانی-حالت داخلی
	       $anbargardani_dakheli=$db->get_from_where("SUM(nakhales_anbargardani)","mt_anbargardani_detail T INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." $kalaCondition_dakheli");     
	      //فیلد پنجم-مقدارانبارگردانی-حالت وارداتی
	       $anbargardani_varedati=$db->get_from_where("SUM(nakhales_anbargardani)","mt_anbargardani_detail T INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." $kalaCondition_varedati");     
	      //فیلد ششم
	       $jame_anbargardani=0;
	       $jame_anbargardani=$anbargardani_dakheli+$anbargardani_varedati;
	      //کسری-اضافه داخلی
	       $diffrence_dakheli=0;$diffrence_kasry_dakheli=0;$diffrence_ezafe_dakheli=0;
	       {$diffrence_dakheli=$mojody_sys_dakheli-$anbargardani_dakheli;
	        IF($diffrence_dakheli>0)$diffrence_kasry_dakheli=($diffrence_dakheli);
	        ELSE IF($diffrence_dakheli<0)$diffrence_ezafe_dakheli=abs($diffrence_dakheli);
	       }
		  //کسری-اضافه وارداتی
	       $diffrence_varedati=0;$diffrence_kasry_varedati=0;$diffrence_ezafe_varedati=0;
	       {$diffrence_varedati=$mojody_sys_varedati-$anbargardani_varedati;
	        IF($diffrence_varedati>0)$diffrence_kasry_varedati=($diffrence_varedati);
	        ELSE IF($diffrence_varedati<0)$diffrence_ezafe_varedati=abs($diffrence_varedati);
	       }
	       $jame_diffrence_kasry=$diffrence_kasry_dakheli+$diffrence_kasry_varedati;
	       $jame_diffrence_ezafe=$diffrence_ezafe_dakheli+$diffrence_ezafe_varedati;
		  }//END noe_namayesh nakhales
          /**************************نوع نمایش تعداد**********************************/
	      if($noe_namayesh==3)
	      {
	       /****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
           //فیلد اول-حالت داخلی
	       $mojody_sys_dakheli=0;
		   $avaliye_dakheli=$db->get_from_where("SUM(tedad_karton_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_dakheli");     	  		   
		   $varede_dakheli=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0  $kalaCondition_dakheli");
	       $sadere_dakheli=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 $kalaCondition_dakheli");	
		   $tadil_ezafe_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli");     
	       $tadil_kasry_dakheli=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli");     
	       $mojody_sys_dakheli=$avaliye_dakheli+$varede_dakheli-$sadere_dakheli+$tadil_ezafe_dakheli-$tadil_kasry_dakheli;

		   //فیلد دوم -حالت وارداتی
	       $avaliye_varedati=$db->get_from_where("SUM(tedad_karton_aval)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_varedati");     	  		   
		   $varede_varedati=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0  $kalaCondition_varedati");
	       $sadere_varedati=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 $kalaCondition_varedati");	
		   $tadil_ezafe_varedati=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati");     
	       $tadil_kasry_varedati=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati");     
	       $mojody_sys_varedati=$avaliye_varedati+$varede_varedati-$sadere_varedati+$tadil_ezafe_varedati-$tadil_kasry_varedati;
		   //فیلد سوم
	       $jame_mojody_sys=0;
	       $jame_mojody_sys=$mojody_sys_dakheli+$mojody_sys_varedati;
		   //فیلد چهارم-مقدار انبارگردانی-حالت داخلی
	       $anbargardani_dakheli=$db->get_from_where("SUM(tedad_anbargardani)","mt_anbargardani_detail T INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." $kalaCondition_dakheli");     
	       //فیلد پنجم-مقدارانبارگردانی-حالت وارداتی
	       $anbargardani_varedati=$db->get_from_where("SUM(tedad_anbargardani)","mt_anbargardani_detail T INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." $kalaCondition_varedati");     
	       //فیلد ششم
	       $jame_anbargardani=0;
	       $jame_anbargardani=$anbargardani_dakheli+$anbargardani_varedati;
	       //کسری-اضافه داخلی
	       $diffrence_dakheli=0;$diffrence_kasry_dakheli=0;$diffrence_ezafe_dakheli=0;
	       {$diffrence_dakheli=$mojody_sys_dakheli-$anbargardani_dakheli;
	        IF($diffrence_dakheli>0)$diffrence_kasry_dakheli=($diffrence_dakheli);
	        ELSE IF($diffrence_dakheli<0)$diffrence_ezafe_dakheli=abs($diffrence_dakheli);
	       }
		   //کسری-اضافه وارداتی
	       $diffrence_varedati=0;$diffrence_kasry_varedati=0;$diffrence_ezafe_varedati=0;
	       {$diffrence_varedati=$mojody_sys_varedati-$anbargardani_varedati;
	        IF($diffrence_varedati>0)$diffrence_kasry_varedati=($diffrence_varedati);
	        ELSE IF($diffrence_varedati<0)$diffrence_ezafe_varedati=abs($diffrence_varedati);
	       }
	       $jame_diffrence_kasry=$diffrence_kasry_dakheli+$diffrence_kasry_varedati;
	       $jame_diffrence_ezafe=$diffrence_ezafe_dakheli+$diffrence_ezafe_varedati;
          }//END noe_namayesh tedad

	 //نمایش اطلاعات
	 echo'
		  <td class="">'.round($mojody_sys_dakheli,3).'</td>
		  <td class="">'.round($mojody_sys_varedati,3).'</td>
		  <td class="">'.round($jame_mojody_sys,3).'</td>
		  <td class="">'.round($anbargardani_dakheli,3).'</td>
		  <td class="">'.round($anbargardani_varedati,3).'</td>
		  <td class="">'.round($jame_anbargardani,3).'</td>
		  
		  <td style="'.$sty_dakheli.$sty_dakheli2.'" class="">'.round($avaliye_dakheli_salbad,3).'</td>
		  <td style="'.$sty_varedati.$sty_varedati2.'"  class="">'.round($avaliye_varedati_salbad,3).'</td>
		  <td class="">'.round($jame_mojody_sys_salbad,3).'</td>
		  
		  <td class="">'.round($diffrence_kasry_dakheli,3).'</td>
		  <td class="">'.round($diffrence_kasry_varedati,3).'</td>
		  <td class="">'.round($jame_diffrence_kasry,3).'</td>
		  <td class="">'.round($diffrence_ezafe_dakheli,3).'</td>
		  <td class="">'.round($diffrence_ezafe_varedati,3).'</td>
		  <td class="">'.round($jame_diffrence_ezafe,3).'</td>';
        //محاسبه مجموع
	    $jamekoli_mojody_sys_dakheli+=$mojody_sys_dakheli;
	    $jamekoli_mojody_sys_varedati+=$mojody_sys_varedati;
	    $jamekoli_mojody_sys+=$jame_mojody_sys;
	    $jamekoli_anbargardani_dakheli+=$anbargardani_dakheli;
	    $jamekoli_anbargardani_varedati+=$anbargardani_varedati;
	    $jamekoli_anbargardani+=$jame_anbargardani;
	    $jamekoli_diffrence_kasry_dakheli+=$diffrence_kasry_dakheli;
	    $jamekoli_diffrence_kasry_varedati+=$diffrence_kasry_varedati;
	    $jamekoli_diffrence_kasry+=$jame_diffrence_kasry;
	    $jamekoli_diffrence_ezafe_dakheli+=$diffrence_ezafe_dakheli;
	    $jamekoli_diffrence_ezafe_varedati+=$diffrence_ezafe_varedati;
	    $jamekoli_diffrence_ezafe+=$jame_diffrence_ezafe;
		IF($x_value=="گوشت گاو")//برای جمع تکی 
		{
		 $show_gav=1;
	     $jamekoli_mojody_sys_dakheli_gav+=$mojody_sys_dakheli;
	     $jamekoli_mojody_sys_varedati_gav+=$mojody_sys_varedati;
	     $jamekoli_mojody_sys_gav+=$jame_mojody_sys;
	     $jamekoli_anbargardani_dakheli_gav+=$anbargardani_dakheli;
	     $jamekoli_anbargardani_varedati_gav+=$anbargardani_varedati;
	     $jamekoli_anbargardani_gav+=$jame_anbargardani;
	     $jamekoli_diffrence_kasry_dakheli_gav+=$diffrence_kasry_dakheli;
	     $jamekoli_diffrence_kasry_varedati_gav+=$diffrence_kasry_varedati;
	     $jamekoli_diffrence_kasry_gav+=$jame_diffrence_kasry;
	     $jamekoli_diffrence_ezafe_dakheli_gav+=$diffrence_ezafe_dakheli;
	     $jamekoli_diffrence_ezafe_varedati_gav+=$diffrence_ezafe_varedati;
	     $jamekoli_diffrence_ezafe_gav+=$jame_diffrence_ezafe;
		}
		IF($x_value=="گوشت گوسفند")
		{
		 $show_gosfand=1;
	     $jamekoli_mojody_sys_dakheli_gosfand+=$mojody_sys_dakheli;
	     $jamekoli_mojody_sys_varedati_gosfand+=$mojody_sys_varedati;
	     $jamekoli_mojody_sys_gosfand+=$jame_mojody_sys;
	     $jamekoli_anbargardani_dakheli_gosfand+=$anbargardani_dakheli;
	     $jamekoli_anbargardani_varedati_gosfand+=$anbargardani_varedati;
	     $jamekoli_anbargardani_gosfand+=$jame_anbargardani;
	     $jamekoli_diffrence_kasry_dakheli_gosfand+=$diffrence_kasry_dakheli;
	     $jamekoli_diffrence_kasry_varedati_gosfand+=$diffrence_kasry_varedati;
	     $jamekoli_diffrence_kasry_gosfand+=$jame_diffrence_kasry;
	     $jamekoli_diffrence_ezafe_dakheli_gosfand+=$diffrence_ezafe_dakheli;
	     $jamekoli_diffrence_ezafe_varedati_gosfand+=$diffrence_ezafe_varedati;
	     $jamekoli_diffrence_ezafe_gosfand+=$jame_diffrence_ezafe;		 
		}
		IF($x_value=="گوشت مرغ")
		{
		 $show_morgh=1;
	     $jamekoli_mojody_sys_dakheli_morgh+=$mojody_sys_dakheli;
	     $jamekoli_mojody_sys_varedati_morgh+=$mojody_sys_varedati;
	     $jamekoli_mojody_sys_morgh+=$jame_mojody_sys;
	     $jamekoli_anbargardani_dakheli_morgh+=$anbargardani_dakheli;
	     $jamekoli_anbargardani_varedati_morgh+=$anbargardani_varedati;
	     $jamekoli_anbargardani_morgh+=$jame_anbargardani;
	     $jamekoli_diffrence_kasry_dakheli_morgh+=$diffrence_kasry_dakheli;
	     $jamekoli_diffrence_kasry_varedati_morgh+=$diffrence_kasry_varedati;
	     $jamekoli_diffrence_kasry_morgh+=$jame_diffrence_kasry;
	     $jamekoli_diffrence_ezafe_dakheli_morgh+=$diffrence_ezafe_dakheli;
	     $jamekoli_diffrence_ezafe_varedati_morgh+=$diffrence_ezafe_varedati;
	     $jamekoli_diffrence_ezafe_morgh+=$jame_diffrence_ezafe;		 
		}
		IF($x_value=="کنسرو مرغ")
		{
		 $show_konserv=1;
         $jamekoli_mojody_sys_dakheli_konserv+=$mojody_sys_dakheli;
	     $jamekoli_mojody_sys_varedati_konserv+=$mojody_sys_varedati;
	     $jamekoli_mojody_sys_konserv+=$jame_mojody_sys;
	     $jamekoli_anbargardani_dakheli_konserv+=$anbargardani_dakheli;
	     $jamekoli_anbargardani_varedati_konserv+=$anbargardani_varedati;
	     $jamekoli_anbargardani_konserv+=$jame_anbargardani;
	     $jamekoli_diffrence_kasry_dakheli_konserv+=$diffrence_kasry_dakheli;
	     $jamekoli_diffrence_kasry_varedati_konserv+=$diffrence_kasry_varedati;
	     $jamekoli_diffrence_kasry_konserv+=$jame_diffrence_kasry;
	     $jamekoli_diffrence_ezafe_dakheli_konserv+=$diffrence_ezafe_dakheli;
	     $jamekoli_diffrence_ezafe_varedati_konserv+=$diffrence_ezafe_varedati;
	     $jamekoli_diffrence_ezafe_konserv+=$jame_diffrence_ezafe;
		}
		IF($x_value=="تخم مرغ خوراکی")
		{
		 $show_tokhme_m=1;
	     $jamekoli_mojody_sys_dakheli+=$mojody_sys_dakheli;
	     $jamekoli_mojody_sys_varedati+=$mojody_sys_varedati;
	     $jamekoli_mojody_sys+=$jame_mojody_sys;
	     $jamekoli_anbargardani_dakheli+=$anbargardani_dakheli;
	     $jamekoli_anbargardani_varedati+=$anbargardani_varedati;
	     $jamekoli_anbargardani+=$jame_anbargardani;
	     $jamekoli_diffrence_kasry_dakheli+=$diffrence_kasry_dakheli;
	     $jamekoli_diffrence_kasry_varedati+=$diffrence_kasry_varedati;
	     $jamekoli_diffrence_kasry+=$jame_diffrence_kasry;
	     $jamekoli_diffrence_ezafe_dakheli+=$diffrence_ezafe_dakheli;
	     $jamekoli_diffrence_ezafe_varedati+=$diffrence_ezafe_varedati;
	     $jamekoli_diffrence_ezafe+=$jame_diffrence_ezafe;		 
		}
		
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
     }
   }//END WHILE ostan
   /*****سطر جمع تکی گروه کالا*****/
   // IF($show_gav==1)
   // {
	// echo'
	 // <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  // <td colspan="4">جمع گوشت گاو</td>
	    // <td class="">'.round($jamekoli_mojody_sys_dakheli_gav,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys_varedati_gav,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys_gav,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_dakheli_gav,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_varedati_gav,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_gav,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_dakheli_gav,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_varedati_gav,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_gav,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_dakheli_gav,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_varedati_gav,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_gav,3).'</td>
	 // </tr>'; 
   // }
   // IF($show_gosfand==1)
   // {  
     // echo'
	 // <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  // <td colspan="4">جمع گوشت گوسفند</td>
	    // <td class="">'.round($jamekoli_mojody_sys_dakheli_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys_varedati_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_dakheli_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_varedati_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_dakheli_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_varedati_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_dakheli_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_varedati_gosfand,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_gosfand,3).'</td>
	 // </tr>';   
    // }
	// IF($show_morgh==1)
    // {
	 // echo'
	 // <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  // <td colspan="4">جمع گوشت مرغ</td>
	    // <td class="">'.round($jamekoli_mojody_sys_dakheli_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys_varedati_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_dakheli_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_varedati_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_dakheli_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_varedati_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_dakheli_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_varedati_morgh,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_morgh,3).'</td>
	 // </tr>';	
	// }
	// IF($show_konserv==1)
    // {
	// echo'
	 // <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  // <td colspan="4">جمع کنسرو مرغ</td>
	    // <td class="">'.round($jamekoli_mojody_sys_dakheli_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys_varedati_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_dakheli_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_varedati_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_dakheli_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_varedati_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_dakheli_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_varedati_konserv,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_konserv,3).'</td>
	 // </tr>';
	// }
   // /*****سطر جمع کل استان ها*****/
   // echo'
	 // <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  // <td colspan="4">جمع کل</td>
	    // <td class="">'.round($jamekoli_mojody_sys_dakheli,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys_varedati,3).'</td>
	    // <td class="">'.round($jamekoli_mojody_sys,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_dakheli,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani_varedati,3).'</td>
	    // <td class="">'.round($jamekoli_anbargardani,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_dakheli,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry_varedati,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_kasry,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_dakheli,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe_varedati,3).'</td>
	    // <td class="">'.round($jamekoli_diffrence_ezafe,3).'</td>
	 // </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
  <tr class="print_footer">
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
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