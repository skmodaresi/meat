<?php
require_once __DIR__ . '/mysql_compat.php';
//برای حالت اتصال به سیستم فروش تهیه شد اتصال به سردخانه را ننوشتم
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_bime.php";
$ExcelFileName=str_replace('.php','',$FileName);
$today_mah=substr($today,5,2);
$titr='گزارش فرآورده ها جهت ارسال به شرکت بیمه طرف قرارداد';
require_once('head.html');
$date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
IF($mtActiveYear==1396)
{
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
}
IF($mtActiveYear==1397)
{
 IF($mah==1)      $date2='1397/01/31';
 ELSE IF($mah==2) $date2='1397/02/31';
 ELSE IF($mah==3) $date2='1397/03/31';
 ELSE IF($mah==4) $date2='1397/04/31';
 ELSE IF($mah==5) $date2='1397/05/31';
 ELSE IF($mah==6) $date2='1397/06/31';
 ELSE IF($mah==7) $date2='1397/07/30';
 ELSE IF($mah==8) $date2='1397/08/30';
 ELSE IF($mah==9) $date2='1397/09/30';
 ELSE IF($mah==10)$date2='1397/10/30';
 ELSE IF($mah==11)$date2='1397/11/30';
 ELSE IF($mah==12)$date2='1397/12/30';	
}
IF($mtActiveYear==1398)
{
 IF($mah==1)      $date2='1398/01/31';
 ELSE IF($mah==2) $date2='1398/02/31';
 ELSE IF($mah==3) $date2='1398/03/31';
 ELSE IF($mah==4) $date2='1398/04/31';
 ELSE IF($mah==5) $date2='1398/05/31';
 ELSE IF($mah==6) $date2='1398/06/31';
 ELSE IF($mah==7) $date2='1398/07/30';
 ELSE IF($mah==8) $date2='1398/08/30';
 ELSE IF($mah==9) $date2='1398/09/30';
 ELSE IF($mah==10)$date2='1398/10/30';
 ELSE IF($mah==11)$date2='1398/11/30';
 ELSE IF($mah==12)$date2='1398/12/30';	
}
IF($mtActiveYear==1399)
{
 IF($mah==1)      $date2='1399/01/31';
 ELSE IF($mah==2) $date2='1399/02/31';
 ELSE IF($mah==3) $date2='1399/03/31';
 ELSE IF($mah==4) $date2='1399/04/31';
 ELSE IF($mah==5) $date2='1399/05/31';
 ELSE IF($mah==6) $date2='1399/06/31';
 ELSE IF($mah==7) $date2='1399/07/30';
 ELSE IF($mah==8) $date2='1399/08/30';
 ELSE IF($mah==9) $date2='1399/09/30';
 ELSE IF($mah==10)$date2='1399/10/30';
 ELSE IF($mah==11)$date2='1399/11/30';
 ELSE IF($mah==12)$date2='1399/12/30';	
}
IF($mtActiveYear==1400)
{
 IF($mah==1)      $date2='1400/01/31';
 ELSE IF($mah==2) $date2='1400/02/31';
 ELSE IF($mah==3) $date2='1400/03/31';
 ELSE IF($mah==4) $date2='1400/04/31';
 ELSE IF($mah==5) $date2='1400/05/31';
 ELSE IF($mah==6) $date2='1400/06/31';
 ELSE IF($mah==7) $date2='1400/07/30';
 ELSE IF($mah==8) $date2='1400/08/30';
 ELSE IF($mah==9) $date2='1400/09/30';
 ELSE IF($mah==10)$date2='1400/10/30';
 ELSE IF($mah==11)$date2='1400/11/30';
 ELSE IF($mah==12)$date2='1400/12/30';	
}
IF($mtActiveYear==1401)
{
 IF($mah==1)      $date2='1401/01/31';
 ELSE IF($mah==2) $date2='1401/02/31';
 ELSE IF($mah==3) $date2='1401/03/31';
 ELSE IF($mah==4) $date2='1401/04/31';
 ELSE IF($mah==5) $date2='1401/05/31';
 ELSE IF($mah==6) $date2='1401/06/31';
 ELSE IF($mah==7) $date2='1401/07/30';
 ELSE IF($mah==8) $date2='1401/08/30';
 ELSE IF($mah==9) $date2='1401/09/30';
 ELSE IF($mah==10)$date2='1401/10/30';
 ELSE IF($mah==11)$date2='1401/11/30';
 ELSE IF($mah==12)$date2='1401/12/30';	
}
//ELSE IF($mah==12)$date2="$mtActiveYear/12/30";
/****************هدر******************/
Function print_header()
{global $mahshamsiArr,$mah,$titr,$mt_gl_owner,$date1,$date2,$FileName,$page,$db,$Condition;
  echo'   
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="60">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
	   <tr class="noExl">
	   	<td class="print_title_2">';
	   	 IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo ''.$titr.' ماه '.$mahshamsiArr[$mah].' &nbsp&nbsp(صفحه : '.$page.')
         <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
	   </tr>
      </table>
     </td>
    </tr>
	<tr class="print_table-title2">
	 <td rowspan="3" width="5%">ردیف</td>
	 <td rowspan="3" width="10%">استان</td>
	 <td rowspan="3" width="10%">نام سردخانه</td>
	 <td rowspan="3" width="5%">وضعیت</td>
	 <td rowspan="3" width="5%">نوع مالکیت</td>';
     $q_column="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition ORDER BY code_group_kala_top";
     $res_column=$db->query($q_column);
	 while($column=$db->fetch_assoc($res_column))
	 {
	  IF($column['code_group_kala_top']==6) $vahed='(عدد)';
	  ELSE IF($column['code_group_kala_top']==7) $vahed='(شانه)';
	  ELSE  $vahed='(کیلوگرم)';
	  echo'<td colspan="7">'.$column['name_group_kala_top'].' '.$vahed.'</td>';
	 }
	 echo'
	 <td rowspan="3" width="15%">جمع موجودی فرآورده های دامی پس از کسر حواله (به جز کنسرو و تخم مرغ خوراکی و جوجه)</td>
	</tr>
	<tr class="print_table-title2">';
	 $res_column=$db->query($q_column);
     while($column=$db->fetch_assoc($res_column))
	 {
	  echo'
	   <td colspan="3">داخلی</td>
	   <td colspan="3">وارداتی</td>
	   <td rowspan="2">جمع موجودی پس از کسر حواله</td>';
	 }
     echo'
	 </tr>
	 <tr class="print_table-title2">';
	 $res_column=$db->query($q_column);
	 while($column=$db->fetch_assoc($res_column))
	 {
	  echo'
	  <td>موجودی</td>
	  <td>مانده حواله</td>
	  <td>مانده موجودی پس از کسر حواله</td>
	  <td>موجودی</td>
	  <td>مانده حواله</td>
	  <td>مانده موجودی پس از کسر حواله</td>';
	 }
	 echo'</tr>';
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
/******************مالکیت سردخانه ها******************/  
if(is_array($malekiyatchoice))
{
    foreach($malekiyatchoice as $key => $mal_val) 
    {
       $Condition_malekiyat_temp.=" noe_malekiyat='$mal_val' OR";
    }
    if($mal_val==-1){$Condition_malekiyat.="1=1 OR";}
    else {$Condition_malekiyat.=" $Condition_malekiyat_temp";}
    $lastSpacePosition = strrpos($Condition_malekiyat," ");
    $Condition_malekiyat =substr($Condition_malekiyat,0,$lastSpacePosition);
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
   <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>	
	<tr class="tr1" style="height:45px">	
     <!--<td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>-->
	 <td align="left"><span class="star">*</span> ماه : </td><td align="right" colspan="3">&nbsp;'.static_listbox("mah",$mah,"mahshamsiArr","1","class='easyui-combobox text4' style=width:130px").'</td>
	</tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت</td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
    <tr  class="tr1">
	 <td align="left" style="height:45px">نوع مالکیت : </td>
	 <td align="right">
	 &nbsp;<select name="malekiyatchoice[]" class="easyui-combobox" size="6" style="width:130px;" data-options=panelHeight:155 multiple>';
	 $malekiyat_options = "<option value='-1' selected>همه</option>";
	 foreach($noe_malekiyatArr AS $key=>$val)
	 {
	  IF($key==0)continue;
	  $malekiyat_options .= "<option value=".$key.">".$val."</option>";
	 }
	 echo $malekiyat_options;
	 echo'
	   </select>      
	 </td>	
	 <td align="left"> تعداد استان در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1" style="height:45px">
     <td align="left">گروه کالا : </td>
     <td align="right">
	  &nbsp;<select name="grkalachoice[]" class="easyui-combobox" size="7" style="width:130px;" data-options=panelHeight:220 multiple>';
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
    <tr class="tr1">
	    <td align="left" height="40px"> نمایش :</td><td align="right" colspan="3">&nbsp;
		'.static_listbox("namayesh_info",$namayesh_info,"namayesh_infoArr",1,"class='easyui-combobox text4' style=width:130px data-options=panelHeight:110 ").'
		</td>	
    </tr> 
	<tr class="footer">	
	 <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
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
	IF($namayesh_info==2){$table_mojody='mojody_kala_gomrok'; $Condition_info=" AND noe_tahvil_bar=9";}
    ELSE {$table_mojody='mojody_kala'; $Condition_info=" AND noe_tahvil_bar!=9";}
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan AND($Condition_malekiyat)) AND($Condition_ostan) ORDER BY name_ostan";
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
    echo'   
     <br>
     <div class="table2excel">
	 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
      <tr class="noExl">
	   <td colspan="60">
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
           <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
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
	 if(is_array($malekiyatchoice))
     {
  	   $filter_string.=' - نوع مالکیت  : ';
       if($mal_val==-1)$filter_string.=' همه ';
  	   else{
  	 	 foreach($malekiyatchoice as $mal_key => $mal_val) {
  	       $nameMalekiyat=$noe_malekiyatArr[$mal_val];
  	       $filter_string.=''.$nameMalekiyat.'&nbsp;';
            }	 
       } 
     }
	 echo'<tr class="noExl"><td class="filter_text" colspan="60">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo'
	  <tr class="print_table-title2">
	 <td rowspan="3" width="5%">ردیف</td>
	 <td rowspan="3" width="10%">استان</td>
	 <td rowspan="3" width="10%">نام سردخانه</td>
	 <td rowspan="3" width="5%">وضعیت</td>
	 <td rowspan="3" width="5%">نوع مالکیت</td>';
     $q_column="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition ORDER BY code_group_kala_top";
     $res_column=$db->query($q_column);
	 while($column=$db->fetch_assoc($res_column))
	 {
	  IF(($column['code_group_kala_top']==6)OR($column['code_group_kala_top']==10)) $vahed='(عدد)';
	  ELSE IF($column['code_group_kala_top']==7) $vahed='(شانه)';
	  ELSE  $vahed='(کیلوگرم)';
	  echo'<td colspan="7">'.$column['name_group_kala_top'].' '.$vahed.'</td>';
	 }
	 echo'
	 <td rowspan="3" width="15%">جمع موجودی فرآورده های دامی پس از کسر حواله (به جز کنسروو تخم مرغ خوراکی و جوجه )</td>
	</tr>
	<tr class="print_table-title2">';
	 $res_column=$db->query($q_column);
     while($column=$db->fetch_assoc($res_column))
	 {
	  echo'
	   <td colspan="3">داخلی</td>
	   <td colspan="3">وارداتی</td>
	   <td rowspan="2">جمع موجودی پس از کسر حواله</td>';
	 }
     echo'
	 </tr>
	 <tr class="print_table-title2">';
	 $res_column=$db->query($q_column);
	 while($column=$db->fetch_assoc($res_column))
	 {
	  echo'
	  <td>موجودی</td>
	  <td>مانده حواله</td>
	  <td>مانده موجودی پس از کسر حواله</td>
	  <td>موجودی</td>
	  <td>مانده حواله</td>
	  <td>مانده موجودی پس از کسر حواله</td>';
	 }
	 echo'</tr>';
	 while($row=$db->fetch_assoc($res))//ostan while
	 {
	  $mojodyKalaOstan_morgh_dakheli=0;$mande_havale_forushOstan_morgh_dakheli=0;$mande_pasazkasrOstan_morgh_dakheli=0;
	  $mojodyKalaOstan_morgh_varedati=0;$mande_havale_forushOstan_morgh_varedati=0;$mande_pasazkasrOstan_morgh_varedati=0;
	  $mojodyKalaOstan_melki_morgh_dakheli=0;$mande_havale_forushOstan_melki_morgh_dakheli=0;$mande_pasazkasrOstan_melki_morgh_dakheli=0;
	  $mojodyKalaOstan_melki_morgh_varedati=0;$mande_havale_forushOstan_melki_morgh_varedati=0;$mande_pasazkasrOstan_melki_morgh_varedati=0;
	  $mojodyKalaOstan_estijari_morgh_dakheli=0;$mande_havale_forushOstan_estijari_morgh_dakheli=0;$mande_pasazkasrOstan_estijari_morgh_dakheli=0;
	  $mojodyKalaOstan_estijari_morgh_varedati=0;$mande_havale_forushOstan_estijari_morgh_varedati=0;$mande_pasazkasrOstan_estijari_morgh_varedati=0;
	  $mande_pasazkasrOstan_morgh=0;
	  $mojodyKalaOstan_ghusht_dakheli=0;$mande_havale_forushOstan_ghusht_dakheli=0;$mande_pasazkasrOstan_ghusht_dakheli=0;
	  $mojodyKalaOstan_ghusht_varedati=0;$mande_havale_forushOstan_ghusht_varedati=0;$mande_pasazkasrOstan_ghusht_varedati=0;
	  $mojodyKalaOstan_melki_ghusht_dakheli=0;$mande_havale_forushOstan_melki_ghusht_dakheli=0;$mande_pasazkasrOstan_melki_ghusht_dakheli=0;
	  $mojodyKalaOstan_melki_ghusht_varedati=0;$mande_havale_forushOstan_melki_ghusht_varedati=0;$mande_pasazkasrOstan_melki_ghusht_varedati=0;
	  $mojodyKalaOstan_estijari_ghusht_dakheli=0;$mande_havale_forushOstan_estijari_ghusht_dakheli=0;$mande_pasazkasrOstan_estijari_ghusht_dakheli=0;
	  $mojodyKalaOstan_estijari_ghusht_varedati=0;$mande_havale_forushOstan_estijari_ghusht_varedati=0;$mande_pasazkasrOstan_estijari_ghusht_varedati=0;
	  $mande_pasazkasrOstan_ghusht=0;
	  $mojodyKalaOstan_konserv_dakheli=0;$mande_havale_forushOstan_konserv_dakheli=0;$mande_pasazkasrOstan_konserv_dakheli=0;
	  $mojodyKalaOstan_konserv_varedati=0;$mande_havale_forushOstan_konserv_varedati=0;$mande_pasazkasrOstan_konserv_varedati=0;
	  $mojodyKalaOstan_melki_konserv_dakheli=0;$mande_havale_forushOstan_melki_konserv_dakheli=0;$mande_pasazkasrOstan_melki_konserv_dakheli=0;
	  $mojodyKalaOstan_melki_konserv_varedati=0;$mande_havale_forushOstan_melki_konserv_varedati=0;$mande_pasazkasrOstan_melki_konserv_varedati=0;
	  $mojodyKalaOstan_estijari_konserv_dakheli=0;$mande_havale_forushOstan_estijari_konserv_dakheli=0;$mande_pasazkasrOstan_estijari_konserv_dakheli=0;
	  $mojodyKalaOstan_estijari_konserv_varedati=0;$mande_havale_forushOstan_estijari_konserv_varedati=0;$mande_pasazkasrOstan_estijari_konserv_varedati=0;
	  $mande_pasazkasrOstan_konserv=0;
	  $mojodyKalaOstan_tokhm_dakheli=0;$mande_havale_forushOstan_tokhm_dakheli=0;$mande_pasazkasrOstan_tokhm_dakheli=0;
	  $mojodyKalaOstan_tokhm_varedati=0;$mande_havale_forushOstan_melki_tokhm_varedati=0;$mande_pasazkasrOstan_melki_tokhm_varedati=0;
	  $mojodyKalaOstan_melki_tokhm_dakheli=0;$mande_havale_forushOstan_melki_tokhm_dakheli=0;$mande_pasazkasrOstan_melki_tokhm_dakheli=0;
	  $mojodyKalaOstan_melki_tokhm_varedati=0;$mande_havale_forushOstan_tokhm_varedati=0;$mande_pasazkasrOstan_tokhm_varedati=0;
	  $mojodyKalaOstan_estijari_tokhm_dakheli=0;$mande_havale_forushOstan_estijari_tokhm_dakheli=0;$mande_pasazkasrOstan_estijari_tokhm_dakheli=0;
	  $mojodyKalaOstan_estijari_tokhm_varedati=0;$mande_havale_forushOstan_estijari_tokhm_varedati=0;$mande_pasazkasrOstan_estijari_tokhm_varedati=0;
	  $mande_pasazkasrOstan_tokhm=0;
	  $mojodyKalaOstan_tokhm_s_dakheli=0;$mande_havale_forushOstan_tokhm_s_dakheli=0;$mande_pasazkasrOstan_tokhm_s_dakheli=0;
	  $mojodyKalaOstan_tokhm_s_varedati=0;$mande_havale_forushOstan_melki_tokhm_s_varedati=0;$mande_pasazkasrOstan_melki_tokhm_s_varedati=0;
	  $mojodyKalaOstan_melki_tokhm_s_dakheli=0;$mande_havale_forushOstan_melki_tokhm_s_dakheli=0;$mande_pasazkasrOstan_melki_tokhm_s_dakheli=0;
	  $mojodyKalaOstan_melki_tokhm_s_varedati=0;$mande_havale_forushOstan_tokhm_s_varedati=0;$mande_pasazkasrOstan_tokhm_s_varedati=0;
	  $mojodyKalaOstan_estijari_tokhm_s_dakheli=0;$mande_havale_forushOstan_estijari_tokhm_s_dakheli=0;$mande_pasazkasrOstan_estijari_tokhm_s_dakheli=0;
	  $mojodyKalaOstan_estijari_tokhm_s_varedati=0;$mande_havale_forushOstan_estijari_tokhm_s_varedati=0;$mande_pasazkasrOstan_estijari_tokhm_s_varedati=0;
	  $mande_pasazkasrOstan_tokhm_s=0;
	  $mojodyKalaOstan_sosis_dakheli=0;$mande_havale_forushOstan_sosis_dakheli=0;$mande_pasazkasrOstan_sosis_dakheli=0;
	  $mojodyKalaOstan_sosis_varedati=0;$mande_havale_forushOstan_sosis_varedati=0;$mande_pasazkasrOstan_sosis_varedati=0;
	  $mojodyKalaOstan_melki_sosis_dakheli=0;$mande_havale_forushOstan_melki_sosis_dakheli=0;$mande_pasazkasrOstan_melki_sosis_dakheli=0;
	  $mojodyKalaOstan_melki_sosis_varedati=0;$mande_havale_forushOstan_melki_sosis_varedati=0;$mande_pasazkasrOstan_melki_sosis_varedati=0;
	  $mojodyKalaOstan_estijari_sosis_dakheli=0;$mande_havale_forushOstan_estijari_sosis_dakheli=0;$mande_pasazkasrOstan_estijari_sosis_dakheli=0;
	  $mojodyKalaOstan_estijari_sosis_varedati=0;$mande_havale_forushOstan_estijari_sosis_varedati=0;$mande_pasazkasrOstan_estijari_sosis_varedati=0;
	  $mande_pasazkasrOstan_sosis=0;
	  $mojodyKalaOstan_joje_dakheli=0;$mande_havale_forushOstan_joje_dakheli=0;$mande_pasazkasrOstan_joje_dakheli=0;
	  $mojodyKalaOstan_joje_varedati=0;$mande_havale_forushOstan_joje_varedati=0;$mande_pasazkasrOstan_joje_varedati=0;
	  $mojodyKalaOstan_melki_joje_dakheli=0;$mande_havale_forushOstan_melki_joje_dakheli=0;$mande_pasazkasrOstan_melki_joje_dakheli=0;
	  $mojodyKalaOstan_melki_joje_varedati=0;$mande_havale_forushOstan_melki_joje_varedati=0;$mande_pasazkasrOstan_melki_joje_varedati=0;
	  $mojodyKalaOstan_estijari_joje_dakheli=0;$mande_havale_forushOstan_estijari_joje_dakheli=0;$mande_pasazkasrOstan_estijari_joje_dakheli=0;
	  $mojodyKalaOstan_estijari_joje_varedati=0;$mande_havale_forushOstan_estijari_joje_varedati=0;$mande_pasazkasrOstan_estijari_joje_varedati=0;
	  $mande_pasazkasrOstan_joje=0;
	  $jame_mande_pasazkasr_Ostan=0;
	  $line++;
	  //تعداد انبار ها
	  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","$mydatabase.list_sardkhane","$Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND code_ostan=".$row['code_ostan']."");//تعداد انبارهای هر استان 
	  else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","$mydatabase.user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای هر استان     
	  $rowanbar=$tedadanbar;
	  $t=$rowanbar;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		 <td rowspan="'.$rowanbar.'">'.$radif++.'</td>
	     <td rowspan="'.$rowanbar.'" style="font-weight:bold">'.$row['name_ostan'].'</td>';
		   /**///حلقه روی انبار ها
		   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM $mydatabase.list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND code_ostan=".$row['code_ostan']."";
		   else $q2="SELECT * FROM $mydatabase.user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."";
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
              $q3="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition ORDER BY code_group_kala_top";
			  $res3=$db->query($q3);
			  while($row3=$db->fetch_assoc($res3))//groupkala while
	          {
			   IF($row3['code_group_kala_top']==6)//کنسرو مرغ
			   {$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
			   ELSE IF($row3['code_group_kala_top']==7)//تخم مرغ
			   {$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
               ELSE
			   {$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
				
			   //موجودی هر گروه کالا در هر سردخانه
				//داخلی 
				$mojodyAval_dakheli=$db->get_from_where("SUM($avalField)","$mydatabase.$table_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=1 AND year='$mtActiveYear' AND deleted=0");        	
			   	$jameVarede_bef_dakheli=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=1 AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0  AND r.tarikh_resid<='$date2' $Condition_info");
                $jameSadere_bef_dakheli=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=1 AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2' $Condition_info");
			   	$meghdarTadil_Ezafe_bef_dakheli=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=1 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' $Condition_info");
			   	$meghdarTadil_Kasry_bef_dakheli=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=1 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' $Condition_info");
			    $mojodyKala_dakheli=$mojodyAval_dakheli+$jameVarede_bef_dakheli-$jameSadere_bef_dakheli+$meghdarTadil_Ezafe_bef_dakheli-$meghdarTadil_Kasry_bef_dakheli;			   
                // IF(SuperUser())echo $mojodyAval_dakheli.'<br>';  
				// IF(SuperUser())echo $jameVarede_bef_dakheli.'<br>';  
                // IF(SuperUser())echo $jameSadere_bef_dakheli.'<br>';  
                // IF(SuperUser())echo "select SUM($havaleField)from havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala where T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=1 AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2'";

				//وارداتی
				$mojodyAval_varedati=$db->get_from_where("SUM($avalField)","$mydatabase.$table_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=2 AND year='$mtActiveYear' AND deleted=0");        	
			   	$jameVarede_bef_varedati=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=2 AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0  AND r.tarikh_resid<='$date2' $Condition_info");
                $jameSadere_bef_varedati=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=2 AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0  AND h.tarikh_havale_anbar<='$date2' $Condition_info");
			   	$meghdarTadil_Ezafe_bef_varedati=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=2 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' $Condition_info");
			   	$meghdarTadil_Kasry_bef_varedati=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=2 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' $Condition_info");
			    $mojodyKala_varedati=$mojodyAval_varedati+$jameVarede_bef_varedati-$jameSadere_bef_varedati+$meghdarTadil_Ezafe_bef_varedati-$meghdarTadil_Kasry_bef_varedati;			   
               //برای حالت اتصال به سیستم فروش
			   //تبدیل کداستان به آی دی برای کوئری های فروش
	           $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$row['code_ostan']."");  
               //تبدیل کدانبار به آی دی برای کوئری های فروش
	           $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=".$sell_id_ostan." AND l_code=".$row2['code_anbar']."");
	 	       
			  IF($namayesh_info==1)
			  {
			   /*******مانده حواله فروش داخلی******/
			   //مقدار کل حواله فروش ها مابین تاریخ
	           //داخلی
			   $havale_forush_bet_per1_dakheli=0;
               $havale_forush_dakheli=0;
               $mande_havale_forush_dakheli=0;
			   $q_forush_dakheli=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code WHERE h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=1 AND h_reg_date>='$mtStartDateMi' AND h_reg_date<='$date2_milady'");	           
			   $res_forush_dakheli=mysql_query($q_forush_dakheli);
	           while($row_forush_dakheli=mysql_fetch_array($res_forush_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	           {
	            /**///محاسبه کل تحویلی برای این حواله
				$meghdar_tahvily_per2_dakheli=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","h_code=".$row_forush_dakheli['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year=$mtActiveYear AND havale_deleted=0 AND status=0");
				/**///محاسبه کل باطله برای این حواله
	  	        $meghdar_batele_per2_dakheli=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_dakheli['h_id']." ");
	            $havale_forush_bet_per1_dakheli=$row_forush_dakheli['h_mande_havale']+$meghdar_tahvily_per2_dakheli+$meghdar_batele_per2_dakheli;//مقدار اولیه هر حواله فروش
	  	        $havale_forush_dakheli+=$havale_forush_bet_per1_dakheli;
	           }
			   //مقدار کل ابطالی ها مابین تاریخ
	           $q_ebtal_dakheli="SELECT SUM(his_eb_amount) AS ebtali FROM sell.dm_his_havale 
	                    INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                    INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                    INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code
						WHERE h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=1 AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date<='$date2_milady'";
			   $res_ebtal_dakheli=mysql_query($q_ebtal_dakheli);
			   $meghdar_ebtali_dakheli=mysql_result($res_ebtal_dakheli, 0, 'ebtali');
			   
			   $tahvilghatee_dakheli=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=1 AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<='".$date2."' $Condition_info");
			   $mande_havale_forush_dakheli=round(($havale_forush_dakheli-$meghdar_ebtali_dakheli-$tahvilghatee_dakheli),3);
			   /*******مانده حواله فروش وارداتی******/
	 	       //مقدار کل حواله فروش ها مابین تاریخ
			   $havale_forush_bet_per1_varedati=0;
               $havale_forush_varedati=0;
               $mande_havale_forush_varedati=0;
	           $q_forush_varedati=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code WHERE h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=2 AND h_reg_date>='$mtStartDateMi' AND h_reg_date<='$date2_milady'");	           
			   $res_forush_varedati=mysql_query($q_forush_varedati);
	           while($row_forush_varedati=mysql_fetch_array($res_forush_varedati))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	           {
	            /**///محاسبه کل تحویلی برای این حواله
				$meghdar_tahvily_per2_varedati=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","h_code=".$row_forush_varedati['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year=$mtActiveYear AND havale_deleted=0 AND status=0");
				
				/**///محاسبه کل باطله برای این حواله
	  	        $meghdar_batele_per2_varedati=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_varedati['h_id']." ");
	            $havale_forush_bet_per1_varedati=$row_forush_varedati['h_mande_havale']+$meghdar_tahvily_per2_varedati+$meghdar_batele_per2_varedati;//مقدار اولیه هر حواله فروش
				$havale_forush_varedati+=$havale_forush_bet_per1_varedati;
	           }
			   //مقدار کل ابطالی ها مابین تاریخ
	           $q_ebtal_varedati="SELECT SUM(his_eb_amount) AS ebtali FROM sell.dm_his_havale 
	                    INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                    INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                    INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code
						WHERE h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=2 AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date<='$date2_milady'";
			   $res_ebtal_varedati=mysql_query($q_ebtal_varedati);
			   $meghdar_ebtali_varedati=mysql_result($res_ebtal_varedati, 0, 'ebtali');
			   
			   $tahvilghatee_varedati=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala","(h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top=".$row3['code_group_kala_top']." AND mahmule_type=2 AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<='".$date2."' $Condition_info");
			   $mande_havale_forush_varedati=round(($havale_forush_varedati-$meghdar_ebtali_varedati-$tahvilghatee_varedati),3);
			  } 
			   //مانده موجودی پس از کسر حواله فروش
               $mande_pasazkasr_dakheli=$mojodyKala_dakheli-$mande_havale_forush_dakheli;
               $mande_pasazkasr_varedati=$mojodyKala_varedati-$mande_havale_forush_varedati;
			   
			   echo '<td>'.round($mojodyKala_dakheli,3).'</td>';
			   echo '<td>'.round($mande_havale_forush_dakheli,3).'</td>';
			   echo '<td>'.round($mande_pasazkasr_dakheli,3).'</td>';
			   echo '<td>'.round($mojodyKala_varedati,3).'</td>';
			   echo '<td>'.round($mande_havale_forush_varedati,3).'</td>';
			   echo '<td>'.round($mande_pasazkasr_varedati,3).'</td>';
               $jame_mande_pasazkasr=$mande_pasazkasr_dakheli+$mande_pasazkasr_varedati;
			   echo '<td>'.round($jame_mande_pasazkasr,3).'</td>';
			   //جمع موجودی کل کالاها در هر انبار   
			   IF(($row3['code_group_kala_top']!=6)AND($row3['code_group_kala_top']!=7)){$jame_mande_pasazkasr_anbar+=$jame_mande_pasazkasr;} 
			   //محاسبه جمع کل استان 	
			   IF($row3['code_group_kala_top']==4) {$mojodyKalaOstan_morgh_dakheli_temp=$mojodyKala_dakheli; $mande_havale_forush_morgh_dakheli_temp=$mande_havale_forush_dakheli; $mande_pasazkasr_morgh_dakheli_temp=$mande_pasazkasr_dakheli;  $mojodyKalaOstan_morgh_varedati_temp=$mojodyKala_varedati; $mande_havale_forush_morgh_varedati_temp=$mande_havale_forush_varedati; $mande_pasazkasr_morgh_varedati_temp=$mande_pasazkasr_varedati;}
               IF($row3['code_group_kala_top']==5) {$mojodyKalaOstan_ghusht_dakheli_temp=$mojodyKala_dakheli; $mande_havale_forush_ghusht_dakheli_temp=$mande_havale_forush_dakheli; $mande_pasazkasr_ghusht_dakheli_temp=$mande_pasazkasr_dakheli;  $mojodyKalaOstan_ghusht_varedati_temp=$mojodyKala_varedati; $mande_havale_forush_ghusht_varedati_temp=$mande_havale_forush_varedati; $mande_pasazkasr_ghusht_varedati_temp=$mande_pasazkasr_varedati;}
               IF($row3['code_group_kala_top']==6) {$mojodyKalaOstan_konserv_dakheli_temp=$mojodyKala_dakheli; $mande_havale_forush_konserv_dakheli_temp=$mande_havale_forush_dakheli; $mande_pasazkasr_konserv_dakheli_temp=$mande_pasazkasr_dakheli;  $mojodyKalaOstan_konserv_varedati_temp=$mojodyKala_varedati; $mande_havale_forush_konserv_varedati_temp=$mande_havale_forush_varedati; $mande_pasazkasr_konserv_varedati_temp=$mande_pasazkasr_varedati;}
               IF($row3['code_group_kala_top']==7) {$mojodyKalaOstan_tokhm_dakheli_temp=$mojodyKala_dakheli; $mande_havale_forush_tokhm_dakheli_temp=$mande_havale_forush_dakheli; $mande_pasazkasr_tokhm_dakheli_temp=$mande_pasazkasr_dakheli;  $mojodyKalaOstan_tokhm_varedati_temp=$mojodyKala_varedati; $mande_havale_forush_tokhm_varedati_temp=$mande_havale_forush_varedati; $mande_pasazkasr_tokhm_varedati_temp=$mande_pasazkasr_varedati;}
               IF($row3['code_group_kala_top']==8) {$mojodyKalaOstan_tokhm_s_dakheli_temp=$mojodyKala_dakheli; $mande_havale_forush_tokhm_s_dakheli_temp=$mande_havale_forush_dakheli; $mande_pasazkasr_tokhm_s_dakheli_temp=$mande_pasazkasr_dakheli;  $mojodyKalaOstan_tokhm_s_varedati_temp=$mojodyKala_varedati; $mande_havale_forush_tokhm_s_varedati_temp=$mande_havale_forush_varedati; $mande_pasazkasr_tokhm_s_varedati_temp=$mande_pasazkasr_varedati;}
               IF($row3['code_group_kala_top']==9) {$mojodyKalaOstan_sosis_dakheli_temp=$mojodyKala_dakheli; $mande_havale_forush_sosis_dakheli_temp=$mande_havale_forush_dakheli; $mande_pasazkasr_sosis_dakheli_temp=$mande_pasazkasr_dakheli;  $mojodyKalaOstan_sosis_varedati_temp=$mojodyKala_varedati; $mande_havale_forush_sosis_varedati_temp=$mande_havale_forush_varedati; $mande_pasazkasr_sosis_varedati_temp=$mande_pasazkasr_varedati;}
               IF($row3['code_group_kala_top']==10){$mojodyKalaOstan_joje_dakheli_temp=$mojodyKala_dakheli; $mande_havale_forush_joje_dakheli_temp=$mande_havale_forush_dakheli; $mande_pasazkasr_joje_dakheli_temp=$mande_pasazkasr_dakheli;  $mojodyKalaOstan_joje_varedati_temp=$mojodyKala_varedati; $mande_havale_forush_joje_varedati_temp=$mande_havale_forush_varedati; $mande_pasazkasr_joje_varedati_temp=$mande_pasazkasr_varedati;}
			  }//END groupkala while
			  echo '<td>'.round($jame_mande_pasazkasr_anbar,3).'</td>';
			  //مرغ
			   //داخلی
			   $mojodyKalaOstan_morgh_dakheli+=$mojodyKalaOstan_morgh_dakheli_temp;
			   $mande_havale_forushOstan_morgh_dakheli+=$mande_havale_forush_morgh_dakheli_temp;
			   $mande_pasazkasrOstan_morgh_dakheli+=$mande_pasazkasr_morgh_dakheli_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			    $mojodyKalaOstan_melki_morgh_dakheli+=$mojodyKalaOstan_morgh_dakheli_temp;
			    $mande_havale_forushOstan_melki_morgh_dakheli+=$mande_havale_forush_morgh_dakheli_temp;
			    $mande_pasazkasrOstan_melki_morgh_dakheli+=$mande_pasazkasr_morgh_dakheli_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			    $mojodyKalaOstan_estijari_morgh_dakheli+=$mojodyKalaOstan_morgh_dakheli_temp;
			    $mande_havale_forushOstan_estijari_morgh_dakheli+=$mande_havale_forush_morgh_dakheli_temp;
			    $mande_pasazkasrOstan_estijari_morgh_dakheli+=$mande_pasazkasr_morgh_dakheli_temp;
			   }
			   //وارداتی
			   $mojodyKalaOstan_morgh_varedati+=$mojodyKalaOstan_morgh_varedati_temp;
			   $mande_havale_forushOstan_morgh_varedati+=$mande_havale_forush_morgh_varedati_temp;
			   $mande_pasazkasrOstan_morgh_varedati+=$mande_pasazkasr_morgh_varedati_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			    $mojodyKalaOstan_melki_morgh_varedati+=$mojodyKalaOstan_morgh_varedati_temp;
			    $mande_havale_forushOstan_melki_morgh_varedati+=$mande_havale_forush_morgh_varedati_temp;
			    $mande_pasazkasrOstan_melki_morgh_varedati+=$mande_pasazkasr_morgh_varedati_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			    $mojodyKalaOstan_estijari_morgh_varedati+=$mojodyKalaOstan_morgh_varedati_temp;
			    $mande_havale_forushOstan_estijari_morgh_varedati+=$mande_havale_forush_morgh_varedati_temp;
			    $mande_pasazkasrOstan_estijari_morgh_varedati+=$mande_pasazkasr_morgh_varedati_temp;
			   }
			   $mande_pasazkasrOstan_morgh=$mande_pasazkasrOstan_morgh_dakheli+$mande_pasazkasrOstan_morgh_varedati;
			   $mande_pasazkasrOstan_melki_morgh=$mande_pasazkasrOstan_melki_morgh_dakheli+$mande_pasazkasrOstan_melki_morgh_varedati;
			   $mande_pasazkasrOstan_estijari_morgh=$mande_pasazkasrOstan_estijari_morgh_dakheli+$mande_pasazkasrOstan_estijari_morgh_varedati;
			  //گوشت
			   //داخلی
			   $mojodyKalaOstan_ghusht_dakheli+=$mojodyKalaOstan_ghusht_dakheli_temp;
			   $mande_havale_forushOstan_ghusht_dakheli+=$mande_havale_forush_ghusht_dakheli_temp;
			   $mande_pasazkasrOstan_ghusht_dakheli+=$mande_pasazkasr_ghusht_dakheli_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			    $mojodyKalaOstan_melki_ghusht_dakheli+=$mojodyKalaOstan_ghusht_dakheli_temp;
			    $mande_havale_forushOstan_melki_ghusht_dakheli+=$mande_havale_forush_ghusht_dakheli_temp;
			    $mande_pasazkasrOstan_melki_ghusht_dakheli+=$mande_pasazkasr_ghusht_dakheli_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			    $mojodyKalaOstan_estijari_ghusht_dakheli+=$mojodyKalaOstan_ghusht_dakheli_temp;
			    $mande_havale_forushOstan_estijari_ghusht_dakheli+=$mande_havale_forush_ghusht_dakheli_temp;
			    $mande_pasazkasrOstan_estijari_ghusht_dakheli+=$mande_pasazkasr_ghusht_dakheli_temp;
			   }
			   //وارداتی
			   $mojodyKalaOstan_ghusht_varedati+=$mojodyKalaOstan_ghusht_varedati_temp;
			   $mande_havale_forushOstan_ghusht_varedati+=$mande_havale_forush_ghusht_varedati_temp;
			   $mande_pasazkasrOstan_ghusht_varedati+=$mande_pasazkasr_ghusht_varedati_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_ghusht_varedati+=$mojodyKalaOstan_ghusht_varedati_temp;
			    $mande_havale_forushOstan_melki_ghusht_varedati+=$mande_havale_forush_ghusht_varedati_temp;
			    $mande_pasazkasrOstan_melki_ghusht_varedati+=$mande_pasazkasr_ghusht_varedati_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_ghusht_varedati+=$mojodyKalaOstan_ghusht_varedati_temp;
			    $mande_havale_forushOstan_estijari_ghusht_varedati+=$mande_havale_forush_ghusht_varedati_temp;
			    $mande_pasazkasrOstan_estijari_ghusht_varedati+=$mande_pasazkasr_ghusht_varedati_temp;
			   }
			   $mande_pasazkasrOstan_ghusht=$mande_pasazkasrOstan_ghusht_dakheli+$mande_pasazkasrOstan_ghusht_varedati;
			   $mande_pasazkasrOstan_melki_ghusht=$mande_pasazkasrOstan_melki_ghusht_dakheli+$mande_pasazkasrOstan_melki_ghusht_varedati;
			   $mande_pasazkasrOstan_estijari_ghusht=$mande_pasazkasrOstan_estijari_ghusht_dakheli+$mande_pasazkasrOstan_estijari_ghusht_varedati;
			  
			  //کنسرو
			   //داخلی
			   $mojodyKalaOstan_konserv_dakheli+=$mojodyKalaOstan_konserv_dakheli_temp;
			   $mande_havale_forushOstan_konserv_dakheli+=$mande_havale_forush_konserv_dakheli_temp;
			   $mande_pasazkasrOstan_konserv_dakheli+=$mande_pasazkasr_konserv_dakheli_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_konserv_dakheli+=$mojodyKalaOstan_konserv_dakheli_temp;
			    $mande_havale_forushOstan_melki_konserv_dakheli+=$mande_havale_forush_konserv_dakheli_temp;
			    $mande_pasazkasrOstan_melki_konserv_dakheli+=$mande_pasazkasr_konserv_dakheli_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_konserv_dakheli+=$mojodyKalaOstan_konserv_dakheli_temp;
			    $mande_havale_forushOstan_estijari_konserv_dakheli+=$mande_havale_forush_konserv_dakheli_temp;
			    $mande_pasazkasrOstan_estijari_konserv_dakheli+=$mande_pasazkasr_konserv_dakheli_temp;
			   }
			   //وارداتی
			   $mojodyKalaOstan_konserv_varedati+=$mojodyKalaOstan_konserv_varedati_temp;
			   $mande_havale_forushOstan_konserv_varedati+=$mande_havale_forush_konserv_varedati_temp;
			   $mande_pasazkasrOstan_konserv_varedati+=$mande_pasazkasr_konserv_varedati_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			    $mojodyKalaOstan_melki_konserv_varedati+=$mojodyKalaOstan_konserv_varedati_temp;
			    $mande_havale_forushOstan_melki_konserv_varedati+=$mande_havale_forush_konserv_varedati_temp;
			    $mande_pasazkasrOstan_melki_konserv_varedati+=$mande_pasazkasr_konserv_varedati_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_konserv_varedati+=$mojodyKalaOstan_konserv_varedati_temp;
			    $mande_havale_forushOstan_estijari_konserv_varedati+=$mande_havale_forush_konserv_varedati_temp;
			    $mande_pasazkasrOstan_estijari_konserv_varedati+=$mande_pasazkasr_konserv_varedati_temp;
			   }
			   $mande_pasazkasrOstan_konserv=$mande_pasazkasrOstan_konserv_dakheli+$mande_pasazkasrOstan_konserv_varedati;
			   $mande_pasazkasrOstan_melki_konserv=$mande_pasazkasrOstan_melki_konserv_dakheli+$mande_pasazkasrOstan_melki_konserv_varedati;
			   $mande_pasazkasrOstan_estijari_konserv=$mande_pasazkasrOstan_estijari_konserv_dakheli+$mande_pasazkasrOstan_estijari_konserv_varedati;
			  //تخم مرغ خوراکی
			   //داخلی
			   $mojodyKalaOstan_tokhm_dakheli+=$mojodyKalaOstan_tokhm_dakheli_temp;
			   $mande_havale_forushOstan_tokhm_dakheli+=$mande_havale_forush_tokhm_dakheli_temp;
			   $mande_pasazkasrOstan_tokhm_dakheli+=$mande_pasazkasr_tokhm_dakheli_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_tokhm_dakheli+=$mojodyKalaOstan_tokhm_dakheli_temp;
			    $mande_havale_forushOstan_melki_tokhm_dakheli+=$mande_havale_forush_tokhm_dakheli_temp;
			    $mande_pasazkasrOstan_melki_tokhm_dakheli+=$mande_pasazkasr_tokhm_dakheli_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_tokhm_dakheli+=$mojodyKalaOstan_tokhm_dakheli_temp;
			    $mande_havale_forushOstan_estijari_tokhm_dakheli+=$mande_havale_forush_tokhm_dakheli_temp;
			    $mande_pasazkasrOstan_estijari_tokhm_dakheli+=$mande_pasazkasr_tokhm_dakheli_temp;
			   }
			   //وارداتی
			   $mojodyKalaOstan_tokhm_varedati+=$mojodyKalaOstan_tokhm_varedati_temp;
			   $mande_havale_forushOstan_tokhm_varedati+=$mande_havale_forush_tokhm_varedati_temp;
			   $mande_pasazkasrOstan_tokhm_varedati+=$mande_pasazkasr_tokhm_varedati_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_tokhm_varedati+=$mojodyKalaOstan_tokhm_varedati_temp;
			    $mande_havale_forushOstan_melki_tokhm_varedati+=$mande_havale_forush_tokhm_varedati_temp;
			    $mande_pasazkasrOstan_melki_tokhm_varedati+=$mande_pasazkasr_tokhm_varedati_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_tokhm_varedati+=$mojodyKalaOstan_tokhm_varedati_temp;
			    $mande_havale_forushOstan_estijari_tokhm_varedati+=$mande_havale_forush_tokhm_varedati_temp;
			    $mande_pasazkasrOstan_estijari_tokhm_varedati+=$mande_pasazkasr_tokhm_varedati_temp;
			   }
			   $mande_pasazkasrOstan_tokhm=$mande_pasazkasrOstan_tokhm_dakheli+$mande_pasazkasrOstan_tokhm_varedati;
			   $mande_pasazkasrOstan_melki_tokhm=$mande_pasazkasrOstan_melki_tokhm_dakheli+$mande_pasazkasrOstan_melki_tokhm_varedati;
			   $mande_pasazkasrOstan_estijari_tokhm=$mande_pasazkasrOstan_estijari_tokhm_dakheli+$mande_pasazkasrOstan_estijari_tokhm_varedati;
			  //تخم مرغ صنعتی
			   //داخلی
			   $mojodyKalaOstan_tokhm_s_dakheli+=$mojodyKalaOstan_tokhm_s_dakheli_temp;
			   $mande_havale_forushOstan_tokhm_s_dakheli+=$mande_havale_forush_tokhm_s_dakheli_temp;
			   $mande_pasazkasrOstan_tokhm_s_dakheli+=$mande_pasazkasr_tokhm_s_dakheli_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_tokhm_s_dakheli+=$mojodyKalaOstan_tokhm_s_dakheli_temp;
			    $mande_havale_forushOstan_melki_tokhm_s_dakheli+=$mande_havale_forush_tokhm_s_dakheli_temp;
			    $mande_pasazkasrOstan_melki_tokhm_s_dakheli+=$mande_pasazkasr_tokhm_s_dakheli_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_tokhm_s_dakheli+=$mojodyKalaOstan_tokhm_s_dakheli_temp;
			    $mande_havale_forushOstan_estijari_tokhm_s_dakheli+=$mande_havale_forush_tokhm_s_dakheli_temp;
			    $mande_pasazkasrOstan_estijari_tokhm_s_dakheli+=$mande_pasazkasr_tokhm_s_dakheli_temp;
			   }
			   //وارداتی
			   $mojodyKalaOstan_tokhm_s_varedati+=$mojodyKalaOstan_tokhm_s_varedati_temp;
			   $mande_havale_forushOstan_tokhm_s_varedati+=$mande_havale_forush_tokhm_s_varedati_temp;
			   $mande_pasazkasrOstan_tokhm_s_varedati+=$mande_pasazkasr_tokhm_s_varedati_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_tokhm_s_varedati+=$mojodyKalaOstan_tokhm_s_varedati_temp;
			    $mande_havale_forushOstan_melki_tokhm_s_varedati+=$mande_havale_forush_tokhm_s_varedati_temp;
			    $mande_pasazkasrOstan_melki_tokhm_s_varedati+=$mande_pasazkasr_tokhm_s_varedati_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_tokhm_s_varedati+=$mojodyKalaOstan_tokhm_s_varedati_temp;
			    $mande_havale_forushOstan_estijari_tokhm_s_varedati+=$mande_havale_forush_tokhm_s_varedati_temp;
			    $mande_pasazkasrOstan_estijari_tokhm_s_varedati+=$mande_pasazkasr_tokhm_s_varedati_temp;
			   }
			   $mande_pasazkasrOstan_tokhm_s=$mande_pasazkasrOstan_tokhm_s_dakheli+$mande_pasazkasrOstan_tokhm_s_varedati;
			   $mande_pasazkasrOstan_melki_tokhm_s=$mande_pasazkasrOstan_melki_tokhm_s_dakheli+$mande_pasazkasrOstan_melki_tokhm_s_varedati;
			   $mande_pasazkasrOstan_estijari_tokhm_s=$mande_pasazkasrOstan_estijari_tokhm_s_dakheli+$mande_pasazkasrOstan_estijari_tokhm_s_varedati;
			  //سوسیس
			   //داخلی
			   $mojodyKalaOstan_sosis_dakheli+=$mojodyKalaOstan_sosis_dakheli_temp;
			   $mande_havale_forushOstan_sosis_dakheli+=$mande_havale_forush_sosis_dakheli_temp;
			   $mande_pasazkasrOstan_sosis_dakheli+=$mande_pasazkasr_sosis_dakheli_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_sosis_dakheli+=$mojodyKalaOstan_sosis_dakheli_temp;
			    $mande_havale_forushOstan_melki_sosis_dakheli+=$mande_havale_forush_sosis_dakheli_temp;
			    $mande_pasazkasrOstan_melki_sosis_dakheli+=$mande_pasazkasr_sosis_dakheli_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_sosis_dakheli+=$mojodyKalaOstan_sosis_dakheli_temp;
			    $mande_havale_forushOstan_estijari_sosis_dakheli+=$mande_havale_forush_sosis_dakheli_temp;
			    $mande_pasazkasrOstan_estijari_sosis_dakheli+=$mande_pasazkasr_sosis_dakheli_temp;
			   }
			   //وارداتی
			   $mojodyKalaOstan_sosis_varedati+=$mojodyKalaOstan_sosis_varedati_temp;
			   $mande_havale_forushOstan_sosis_varedati+=$mande_havale_forush_sosis_varedati_temp;
			   $mande_pasazkasrOstan_sosis_varedati+=$mande_pasazkasr_sosis_varedati_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_sosis_varedati+=$mojodyKalaOstan_sosis_varedati_temp;
			    $mande_havale_forushOstan_melki_sosis_varedati+=$mande_havale_forush_sosis_varedati_temp;
			    $mande_pasazkasrOstan_melki_sosis_varedati+=$mande_pasazkasr_sosis_varedati_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_sosis_varedati+=$mojodyKalaOstan_sosis_varedati_temp;
			    $mande_havale_forushOstan_estijari_sosis_varedati+=$mande_havale_forush_sosis_varedati_temp;
			    $mande_pasazkasrOstan_estijari_sosis_varedati+=$mande_pasazkasr_sosis_varedati_temp;
			   }
			   $mande_pasazkasrOstan_sosis=$mande_pasazkasrOstan_sosis_dakheli+$mande_pasazkasrOstan_sosis_varedati;
			   $mande_pasazkasrOstan_melki_sosis=$mande_pasazkasrOstan_melki_sosis_dakheli+$mande_pasazkasrOstan_melki_sosis_varedati;
			   $mande_pasazkasrOstan_estijari_sosis=$mande_pasazkasrOstan_estijari_sosis_dakheli+$mande_pasazkasrOstan_estijari_sosis_varedati;
			  
			  //جوجه یهک روزه
			   //داخلی
			   $mojodyKalaOstan_joje_dakheli+=$mojodyKalaOstan_joje_dakheli_temp;
			   $mande_havale_forushOstan_joje_dakheli+=$mande_havale_forush_joje_dakheli_temp;
			   $mande_pasazkasrOstan_joje_dakheli+=$mande_pasazkasr_joje_dakheli_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_joje_dakheli+=$mojodyKalaOstan_joje_dakheli_temp;
			    $mande_havale_forushOstan_melki_joje_dakheli+=$mande_havale_forush_joje_dakheli_temp;
			    $mande_pasazkasrOstan_melki_joje_dakheli+=$mande_pasazkasr_joje_dakheli_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_joje_dakheli+=$mojodyKalaOstan_joje_dakheli_temp;
			    $mande_havale_forushOstan_estijari_joje_dakheli+=$mande_havale_forush_joje_dakheli_temp;
			    $mande_pasazkasrOstan_estijari_joje_dakheli+=$mande_pasazkasr_joje_dakheli_temp;
			   }
			   //وارداتی
			   $mojodyKalaOstan_joje_varedati+=$mojodyKalaOstan_joje_varedati_temp;
			   $mande_havale_forushOstan_joje_varedati+=$mande_havale_forush_joje_varedati_temp;
			   $mande_pasazkasrOstan_joje_varedati+=$mande_pasazkasr_joje_varedati_temp;
			   //ملکی
			   IF($row2['noe_malekiyat']==1){
			   	$mojodyKalaOstan_melki_joje_varedati+=$mojodyKalaOstan_joje_varedati_temp;
			    $mande_havale_forushOstan_melki_joje_varedati+=$mande_havale_forush_joje_varedati_temp;
			    $mande_pasazkasrOstan_melki_joje_varedati+=$mande_pasazkasr_joje_varedati_temp;
			   }
			   //استیجاری
			   IF($row2['noe_malekiyat']==2){
			   	$mojodyKalaOstan_estijari_joje_varedati+=$mojodyKalaOstan_joje_varedati_temp;
			    $mande_havale_forushOstan_estijari_joje_varedati+=$mande_havale_forush_joje_varedati_temp;
			    $mande_pasazkasrOstan_estijari_joje_varedati+=$mande_pasazkasr_joje_varedati_temp;
			   }
			   $mande_pasazkasrOstan_joje=$mande_pasazkasrOstan_joje_dakheli+$mande_pasazkasrOstan_joje_varedati;
			   $mande_pasazkasrOstan_melki_joje=$mande_pasazkasrOstan_melki_joje_dakheli+$mande_pasazkasrOstan_melki_joje_varedati;
			   $mande_pasazkasrOstan_estijari_joje=$mande_pasazkasrOstan_estijari_joje_dakheli+$mande_pasazkasrOstan_estijari_joje_varedati;
			  
			  
			  //مجموع کیلوگرم ها (به جز تخم مرغ خوراکی و کنسروو جوجه یک روزه)
			  $jame_mande_pasazkasr_Ostan=$mande_pasazkasrOstan_morgh+$mande_pasazkasrOstan_ghusht+$mande_pasazkasrOstan_tokhm_s+$mande_pasazkasrOstan_sosis;
			  $jame_mande_pasazkasr_Ostan_melki=$mande_pasazkasrOstan_melki_morgh+$mande_pasazkasrOstan_melki_ghusht+$mande_pasazkasrOstan_melki_tokhm_s+$mande_pasazkasrOstan_melki_sosis;
			  $jame_mande_pasazkasr_Ostan_estijari=$mande_pasazkasrOstan_estijari_morgh+$mande_pasazkasrOstan_estijari_ghusht+$mande_pasazkasrOstan_estijari_tokhm_s+$mande_pasazkasrOstan_estijari_sosis;
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
		   /*****سطر جمع کل استان - انبارهای ملکی*****/
		   if(( in_array(1,$malekiyatchoice ) )OR($mal_val==-1))//اگر ملکی در شروط باشد یا فقط همه انتخاب شده باشد
		   {
		    echo'
		    <tr class="print_table-even sum-row" style="background-color:#FFF;">
		     <td colspan="5">جمع کل سردخانه های ملکی استان '.$row['name_ostan'].'</td>';
			 $jame_mojody_ostan=0;//جمع موجودی کل کالاها در هر استان
             $q4="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition ORDER BY code_group_kala_top";
			 $res4=$db->query($q4);
	         while($row4=$db->fetch_assoc($res4))
	         { 
			   IF($row4['code_group_kala_top']==4)  echo '<td>'.round($mojodyKalaOstan_melki_morgh_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_melki_morgh_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_melki_morgh_dakheli,3).'</td><td>'.round($mojodyKalaOstan_melki_morgh_varedati,3).'</td><td>'.round($mande_havale_forushOstan_melki_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_morgh,3).'</td>';
               IF($row4['code_group_kala_top']==5)  echo '<td>'.round($mojodyKalaOstan_melki_ghusht_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_melki_ghusht_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_melki_ghusht_dakheli,3).'</td><td>'.round($mojodyKalaOstan_melki_ghusht_varedati,3).'</td><td>'.round($mande_havale_forushOstan_melki_ghusht_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_ghusht_varedati,3).'<td>'.round($mande_pasazkasrOstan_melki_ghusht,3).'</td></td>';
			   IF($row4['code_group_kala_top']==6)  echo '<td>'.round($mojodyKalaOstan_melki_konserv_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_melki_konserv_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_melki_konserv_dakheli,3).'</td><td>'.round($mojodyKalaOstan_melki_konserv_varedati,3).'</td><td>'.round($mande_havale_forushOstan_melki_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_konserv,3).'</td>';
			   IF($row4['code_group_kala_top']==7)  echo '<td>'.round($mojodyKalaOstan_melki_tokhm_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_melki_tokhm_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_melki_tokhm_dakheli,3).'</td><td>'.round($mojodyKalaOstan_melki_tokhm_varedati,3).'</td><td>'.round($mande_havale_forushOstan_melki_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_tokhm,3).'</td>';
			   IF($row4['code_group_kala_top']==8)  echo '<td>'.round($mojodyKalaOstan_melki_tokhm_s_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_melki_tokhm_s_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_melki_tokhm_s_dakheli,3).'</td><td>'.round($mojodyKalaOstan_melki_tokhm_s_varedati,3).'</td><td>'.round($mande_havale_forushOstan_melki_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_tokhm_s,3).'</td>';
			   IF($row4['code_group_kala_top']==9)  echo '<td>'.round($mojodyKalaOstan_melki_sosis_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_melki_sosis_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_melki_sosis_dakheli,3).'</td> <td>'.round($mojodyKalaOstan_melki_sosis_varedati,3).'</td><td>'.round($mande_havale_forushOstan_melki_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_sosis,3).'</td>';
			   IF($row4['code_group_kala_top']==10) echo '<td>'.round($mojodyKalaOstan_melki_joje_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_melki_joje_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_melki_joje_dakheli,3).'</td> <td>'.round($mojodyKalaOstan_melki_joje_varedati,3).'</td><td>'.round($mande_havale_forushOstan_melki_joje_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_joje_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_melki_joje,3).'</td>';
			 }//END kala while
		    echo'
		     <td>'.round($jame_mande_pasazkasr_Ostan_melki,3).'</td>		   
		    </tr>';   
		   }
		   /*****سطر جمع کل استان - انبارهای استیجاری*****/
		   if(( in_array(2,$malekiyatchoice ) )OR($mal_val==-1))//اگر استیجاری در شروط باشد یا فقط همه انتخاب شده باشد
		   {
			echo'
		    <tr class="print_table-even sum-row" style="background-color:#FFF;">
		     <td colspan="5">جمع کل سردخانه های استیجاری استان '.$row['name_ostan'].'</td>';
			 $jame_mojody_ostan=0;//جمع موجودی کل کالاها در هر استان
             $q4="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition ORDER BY code_group_kala_top";
			 $res4=$db->query($q4);
	         while($row4=$db->fetch_assoc($res4))
	         { 
			   IF($row4['code_group_kala_top']==4)  echo '<td>'.round($mojodyKalaOstan_estijari_morgh_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_estijari_morgh_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_morgh_dakheli,3).'</td><td>'.round($mojodyKalaOstan_estijari_morgh_varedati,3).'</td><td>'.round($mande_havale_forushOstan_estijari_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_morgh,3).'</td>';
               IF($row4['code_group_kala_top']==5)  echo '<td>'.round($mojodyKalaOstan_estijari_ghusht_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_estijari_ghusht_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_ghusht_dakheli,3).'</td><td>'.round($mojodyKalaOstan_estijari_ghusht_varedati,3).'</td><td>'.round($mande_havale_forushOstan_estijari_ghusht_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_ghusht_varedati,3).'<td>'.round($mande_pasazkasrOstan_estijari_ghusht,3).'</td></td>';
			   IF($row4['code_group_kala_top']==6)  echo '<td>'.round($mojodyKalaOstan_estijari_konserv_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_estijari_konserv_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_konserv_dakheli,3).'</td><td>'.round($mojodyKalaOstan_estijari_konserv_varedati,3).'</td><td>'.round($mande_havale_forushOstan_estijari_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_konserv,3).'</td>';
			   IF($row4['code_group_kala_top']==7)  echo '<td>'.round($mojodyKalaOstan_estijari_tokhm_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_estijari_tokhm_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_tokhm_dakheli,3).'</td><td>'.round($mojodyKalaOstan_estijari_tokhm_varedati,3).'</td><td>'.round($mande_havale_forushOstan_estijari_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_tokhm,3).'</td>';
			   IF($row4['code_group_kala_top']==8)  echo '<td>'.round($mojodyKalaOstan_estijari_tokhm_s_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_estijari_tokhm_s_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_tokhm_s_dakheli,3).'</td><td>'.round($mojodyKalaOstan_estijari_tokhm_s_varedati,3).'</td><td>'.round($mande_havale_forushOstan_estijari_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_tokhm_s,3).'</td>';
			   IF($row4['code_group_kala_top']==9)  echo '<td>'.round($mojodyKalaOstan_estijari_sosis_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_estijari_sosis_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_sosis_dakheli,3).'</td> <td>'.round($mojodyKalaOstan_estijari_sosis_varedati,3).'</td><td>'.round($mande_havale_forushOstan_estijari_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_sosis,3).'</td>';
			   IF($row4['code_group_kala_top']==10) echo '<td>'.round($mojodyKalaOstan_estijari_joje_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_estijari_joje_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_joje_dakheli,3).'</td> <td>'.round($mojodyKalaOstan_estijari_joje_varedati,3).'</td><td>'.round($mande_havale_forushOstan_estijari_joje_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_joje_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_estijari_joje,3).'</td>';
			 }//END kala while
		    echo'
		     <td>'.round($jame_mande_pasazkasr_Ostan_estijari,3).'</td>		   
		    </tr>';   
		   }
		   /*****سطر جمع کل استان*****/
		   echo'
		   <tr class="print_table-even sum-row" style="background-color:#FFF;">
		    <td colspan="5">جمع کل استان '.$row['name_ostan'].'</td>';
			$jame_mojody_ostan=0;//جمع موجودی کل کالاها در هر استان
            $q4="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition ORDER BY code_group_kala_top";
			$res4=$db->query($q4);
	        while($row4=$db->fetch_assoc($res4))
	        { 
			  IF($row4['code_group_kala_top']==4)  echo '<td>'.round($mojodyKalaOstan_morgh_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_morgh_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_morgh_dakheli,3).'</td><td>'.round($mojodyKalaOstan_morgh_varedati,3).'</td><td>'.round($mande_havale_forushOstan_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_morgh,3).'</td>';
              IF($row4['code_group_kala_top']==5)  echo '<td>'.round($mojodyKalaOstan_ghusht_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_ghusht_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_ghusht_dakheli,3).'</td><td>'.round($mojodyKalaOstan_ghusht_varedati,3).'</td><td>'.round($mande_havale_forushOstan_ghusht_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_ghusht_varedati,3).'<td>'.round($mande_pasazkasrOstan_ghusht,3).'</td></td>';
			  IF($row4['code_group_kala_top']==6)  echo '<td>'.round($mojodyKalaOstan_konserv_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_konserv_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_konserv_dakheli,3).'</td><td>'.round($mojodyKalaOstan_konserv_varedati,3).'</td><td>'.round($mande_havale_forushOstan_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_konserv,3).'</td>';
			  IF($row4['code_group_kala_top']==7)  echo '<td>'.round($mojodyKalaOstan_tokhm_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_tokhm_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_tokhm_dakheli,3).'</td><td>'.round($mojodyKalaOstan_tokhm_varedati,3).'</td><td>'.round($mande_havale_forushOstan_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_tokhm,3).'</td>';
			  IF($row4['code_group_kala_top']==8)  echo '<td>'.round($mojodyKalaOstan_tokhm_s_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_tokhm_s_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_tokhm_s_dakheli,3).'</td><td>'.round($mojodyKalaOstan_tokhm_s_varedati,3).'</td><td>'.round($mande_havale_forushOstan_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_tokhm_s,3).'</td>';
			  IF($row4['code_group_kala_top']==9)  echo '<td>'.round($mojodyKalaOstan_sosis_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_sosis_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_sosis_dakheli,3).'</td> <td>'.round($mojodyKalaOstan_sosis_varedati,3).'</td><td>'.round($mande_havale_forushOstan_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_sosis,3).'</td>';
			  IF($row4['code_group_kala_top']==10) echo '<td>'.round($mojodyKalaOstan_joje_dakheli,3).'</td><td>'.round($mande_havale_forushOstan_joje_dakheli,3).'</td><td>'.round($mande_pasazkasrOstan_joje_dakheli,3).'</td> <td>'.round($mojodyKalaOstan_joje_varedati,3).'</td><td>'.round($mande_havale_forushOstan_joje_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_joje_varedati,3).'</td><td>'.round($mande_pasazkasrOstan_joje,3).'</td>';
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
	  //داخلی
	  $mojodyKalaKol_morgh_dakheli+=$mojodyKalaOstan_morgh_dakheli;
	  $mande_havale_forushKol_morgh_dakheli+=$mande_havale_forushOstan_morgh_dakheli;
	  $mande_pasazkasrKol_morgh_dakheli+=$mande_pasazkasrOstan_morgh_dakheli;
	  //ملکی
	  $mojodyKalaKol_melki_morgh_dakheli+=$mojodyKalaOstan_melki_morgh_dakheli;
	  $mande_havale_forushKol_melki_morgh_dakheli+=$mande_havale_forushOstan_melki_morgh_dakheli;
	  $mande_pasazkasrKol_melki_morgh_dakheli+=$mande_pasazkasrOstan_melki_morgh_dakheli;
	  //استیجاری
	  $mojodyKalaKol_estijari_morgh_dakheli+=$mojodyKalaOstan_estijari_morgh_dakheli;
	  $mande_havale_forushKol_estijari_morgh_dakheli+=$mande_havale_forushOstan_estijari_morgh_dakheli;
	  $mande_pasazkasrKol_estijari_morgh_dakheli+=$mande_pasazkasrOstan_estijari_morgh_dakheli;
	  //وارداتی
	  $mojodyKalaKol_morgh_varedati+=$mojodyKalaOstan_morgh_varedati;
	  $mande_havale_forushKol_morgh_varedati+=$mande_havale_forushOstan_morgh_varedati;
	  $mande_pasazkasrKol_morgh_varedati+=$mande_pasazkasrOstan_morgh_varedati;
	  //ملکی
	  $mojodyKalaKol_melki_morgh_varedati+=$mojodyKalaOstan_melki_morgh_varedati;
	  $mande_havale_forushKol_melki_morgh_varedati+=$mande_havale_forushOstan_melki_morgh_varedati;
	  $mande_pasazkasrKol_melki_morgh_varedati+=$mande_pasazkasrOstan_melki_morgh_varedati;
	  //استیجاری
	  $mojodyKalaKol_estijari_morgh_varedati+=$mojodyKalaOstan_estijari_morgh_varedati;
	  $mande_havale_forushKol_estijari_morgh_varedati+=$mande_havale_forushOstan_estijari_morgh_varedati;
	  $mande_pasazkasrKol_estijari_morgh_varedati+=$mande_pasazkasrOstan_estijari_morgh_varedati;
	  
	  $mande_pasazkasrKol_morgh=$mande_pasazkasrKol_morgh_dakheli+$mande_pasazkasrKol_morgh_varedati;
	  $mande_pasazkasrKol_melki_morgh=$mande_pasazkasrKol_melki_morgh_dakheli+$mande_pasazkasrKol_melki_morgh_varedati;
	  $mande_pasazkasrKol_estijari_morgh=$mande_pasazkasrKol_estijari_morgh_dakheli+$mande_pasazkasrKol_estijari_morgh_varedati;
	 //گوشت
	  //داخلی
	  $mojodyKalaKol_ghusht_dakheli+=$mojodyKalaOstan_ghusht_dakheli;
	  $mande_havale_forushKol_ghusht_dakheli+=$mande_havale_forushOstan_ghusht_dakheli;
	  $mande_pasazkasrKol_ghusht_dakheli+=$mande_pasazkasrOstan_ghusht_dakheli;
	  //ملکی
	  $mojodyKalaKol_melki_ghusht_dakheli+=$mojodyKalaOstan_melki_ghusht_dakheli;
	  $mande_havale_forushKol_melki_ghusht_dakheli+=$mande_havale_forushOstan_melki_ghusht_dakheli;
	  $mande_pasazkasrKol_melki_ghusht_dakheli+=$mande_pasazkasrOstan_melki_ghusht_dakheli;
	  //استیجاری
	  $mojodyKalaKol_estijari_ghusht_dakheli+=$mojodyKalaOstan_estijari_ghusht_dakheli;
	  $mande_havale_forushKol_estijari_ghusht_dakheli+=$mande_havale_forushOstan_estijari_ghusht_dakheli;
	  $mande_pasazkasrKol_estijari_ghusht_dakheli+=$mande_pasazkasrOstan_estijari_ghusht_dakheli;
	  //وارداتی	  
	  $mojodyKalaKol_ghusht_varedati+=$mojodyKalaOstan_ghusht_varedati;
	  $mande_havale_forushKol_ghusht_varedati+=$mande_havale_forushOstan_ghusht_varedati;
	  $mande_pasazkasrKol_ghusht_varedati+=$mande_pasazkasrOstan_ghusht_varedati;
	  //ملکی
	  $mojodyKalaKol_melki_ghusht_varedati+=$mojodyKalaOstan_melki_ghusht_varedati;
	  $mande_havale_forushKol_melki_ghusht_varedati+=$mande_havale_forushOstan_melki_ghusht_varedati;
	  $mande_pasazkasrKol_melki_ghusht_varedati+=$mande_pasazkasrOstan_melki_ghusht_varedati;
	  //استیجاری
	  $mojodyKalaKol_estijari_ghusht_varedati+=$mojodyKalaOstan_estijari_ghusht_varedati;
	  $mande_havale_forushKol_estijari_ghusht_varedati+=$mande_havale_forushOstan_estijari_ghusht_varedati;
	  $mande_pasazkasrKol_estijari_ghusht_varedati+=$mande_pasazkasrOstan_estijari_ghusht_varedati;
	  
	  $mande_pasazkasrKol_ghusht=$mande_pasazkasrKol_ghusht_dakheli+$mande_pasazkasrKol_ghusht_varedati;
	  $mande_pasazkasrKol_melki_ghusht=$mande_pasazkasrKol_melki_ghusht_dakheli+$mande_pasazkasrKol_melki_ghusht_varedati;
	  $mande_pasazkasrKol_estijari_ghusht=$mande_pasazkasrKol_estijari_ghusht_dakheli+$mande_pasazkasrKol_estijari_ghusht_varedati;
	 //کنسرو
	  //داخلی
	  $mojodyKalaKol_konserv_dakheli+=$mojodyKalaOstan_konserv_dakheli;
	  $mande_havale_forushKol_konserv_dakheli+=$mande_havale_forushOstan_konserv_dakheli;
	  $mande_pasazkasrKol_konserv_dakheli+=$mande_pasazkasrOstan_konserv_dakheli;
	  //ملکی
	  $mojodyKalaKol_melki_konserv_dakheli+=$mojodyKalaOstan_melki_konserv_dakheli;
	  $mande_havale_forushKol_melki_konserv_dakheli+=$mande_havale_forushOstan_melki_konserv_dakheli;
	  $mande_pasazkasrKol_melki_konserv_dakheli+=$mande_pasazkasrOstan_melki_konserv_dakheli;
	  //استیجاری
	  $mojodyKalaKol_estijari_konserv_dakheli+=$mojodyKalaOstan_estijari_konserv_dakheli;
	  $mande_havale_forushKol_estijari_konserv_dakheli+=$mande_havale_forushOstan_estijari_konserv_dakheli;
	  $mande_pasazkasrKol_estijari_konserv_dakheli+=$mande_pasazkasrOstan_estijari_konserv_dakheli;
	  //وارداتی
	  $mojodyKalaKol_konserv_varedati+=$mojodyKalaOstan_konserv_varedati;
	  $mande_havale_forushKol_konserv_varedati+=$mande_havale_forushOstan_konserv_varedati;
	  $mande_pasazkasrKol_konserv_varedati+=$mande_pasazkasrOstan_konserv_varedati;
	  //ملکی
	  $mojodyKalaKol_melki_konserv_varedati+=$mojodyKalaOstan_melki_konserv_varedati;
	  $mande_havale_forushKol_melki_konserv_varedati+=$mande_havale_forushOstan_melki_konserv_varedati;
	  $mande_pasazkasrKol_melki_konserv_varedati+=$mande_pasazkasrOstan_melki_konserv_varedati;
	  //استیجاری
	  $mojodyKalaKol_estijari_konserv_varedati+=$mojodyKalaOstan_estijari_konserv_varedati;
	  $mande_havale_forushKol_estijari_konserv_varedati+=$mande_havale_forushOstan_estijari_konserv_varedati;
	  $mande_pasazkasrKol_estijari_konserv_varedati+=$mande_pasazkasrOstan_estijari_konserv_varedati;
	  
	  $mande_pasazkasrKol_konserv=$mande_pasazkasrKol_konserv_dakheli+$mande_pasazkasrKol_konserv_varedati;
	  $mande_pasazkasrKol_melki_konserv=$mande_pasazkasrKol_melki_konserv_dakheli+$mande_pasazkasrKol_melki_konserv_varedati;
	  $mande_pasazkasrKol_estijari_konserv=$mande_pasazkasrKol_estijari_konserv_dakheli+$mande_pasazkasrKol_estijari_konserv_varedati;
	 //تخم مرغ خوراکی
	  //داخلی
	  $mojodyKalaKol_tokhm_dakheli+=$mojodyKalaOstan_tokhm_dakheli;
	  $mande_havale_forushKol_tokhm_dakheli+=$mande_havale_forushOstan_tokhm_dakheli;
	  $mande_pasazkasrKol_tokhm_dakheli+=$mande_pasazkasrOstan_tokhm_dakheli;
      //ملکی
	  $mojodyKalaKol_melki_tokhm_dakheli+=$mojodyKalaOstan_melki_tokhm_dakheli;
	  $mande_havale_forushKol_melki_tokhm_dakheli+=$mande_havale_forushOstan_melki_tokhm_dakheli;
	  $mande_pasazkasrKol_melki_tokhm_dakheli+=$mande_pasazkasrOstan_melki_tokhm_dakheli;
	  //استیجاری
	  $mojodyKalaKol_estijari_tokhm_dakheli+=$mojodyKalaOstan_estijari_tokhm_dakheli;
	  $mande_havale_forushKol_estijari_tokhm_dakheli+=$mande_havale_forushOstan_estijari_tokhm_dakheli;
	  $mande_pasazkasrKol_estijari_tokhm_dakheli+=$mande_pasazkasrOstan_estijari_tokhm_dakheli;
	  //وارداتی
	  $mojodyKalaKol_tokhm_varedati+=$mojodyKalaOstan_tokhm_varedati;
	  $mande_havale_forushKol_tokhm_varedati+=$mande_havale_forushOstan_tokhm_varedati;
	  $mande_pasazkasrKol_tokhm_varedati+=$mande_pasazkasrOstan_tokhm_varedati;
	  //ملکی
	  $mojodyKalaKol_melki_tokhm_varedati+=$mojodyKalaOstan_melki_tokhm_varedati;
	  $mande_havale_forushKol_melki_tokhm_varedati+=$mande_havale_forushOstan_melki_tokhm_varedati;
	  $mande_pasazkasrKol_melki_tokhm_varedati+=$mande_pasazkasrOstan_melki_tokhm_varedati;
	  //استیجاری
	  $mojodyKalaKol_estijari_tokhm_varedati+=$mojodyKalaOstan_estijari_tokhm_varedati;
	  $mande_havale_forushKol_estijari_tokhm_varedati+=$mande_havale_forushOstan_estijari_tokhm_varedati;
	  $mande_pasazkasrKol_estijari_tokhm_varedati+=$mande_pasazkasrOstan_estijari_tokhm_varedati;
	  
	  $mande_pasazkasrKol_tokhm=$mande_pasazkasrKol_tokhm_dakheli+$mande_pasazkasrKol_tokhm_varedati;
	  $mande_pasazkasrKol_melki_tokhm=$mande_pasazkasrKol_melki_tokhm_dakheli+$mande_pasazkasrKol_tokhm_melki_varedati;
	  $mande_pasazkasrKol_estijari_tokhm=$mande_pasazkasrKol_estijari_tokhm_dakheli+$mande_pasazkasrKol_estijari_tokhm_varedati;
	 //تخم مرغ صنعتی
	  //داخلی
	  $mojodyKalaKol_tokhm_s_dakheli+=$mojodyKalaOstan_tokhm_s_dakheli;
	  $mande_havale_forushKol_tokhm_s_dakheli+=$mande_havale_forushOstan_tokhm_s_dakheli;
	  $mande_pasazkasrKol_tokhm_s_dakheli+=$mande_pasazkasrOstan_tokhm_s_dakheli;
      //ملکی
	  $mojodyKalaKol_melki_tokhm_s_dakheli+=$mojodyKalaOstan_melki_tokhm_s_dakheli;
	  $mande_havale_forushKol_melki_tokhm_s_dakheli+=$mande_havale_forushOstan_melki_tokhm_s_dakheli;
	  $mande_pasazkasrKol_melki_tokhm_s_dakheli+=$mande_pasazkasrOstan_melki_tokhm_s_dakheli;
	  //استیجاری
	  $mojodyKalaKol_estijari_tokhm_s_dakheli+=$mojodyKalaOstan_estijari_tokhm_s_dakheli;
	  $mande_havale_forushKol_estijari_tokhm_s_dakheli+=$mande_havale_forushOstan_estijari_tokhm_s_dakheli;
	  $mande_pasazkasrKol_estijari_tokhm_s_dakheli+=$mande_pasazkasrOstan_estijari_tokhm_s_dakheli;
	  //وارداتی
	  $mojodyKalaKol_tokhm_s_varedati+=$mojodyKalaOstan_tokhm_s_varedati;
	  $mande_havale_forushKol_tokhm_s_varedati+=$mande_havale_forushOstan_tokhm_s_varedati;
	  $mande_pasazkasrKol_tokhm_s_varedati+=$mande_pasazkasrOstan_tokhm_s_varedati;
	  //ملکی
	  $mojodyKalaKol_melki_tokhm_s_varedati+=$mojodyKalaOstan_melki_tokhm_s_varedati;
	  $mande_havale_forushKol_melki_tokhm_s_varedati+=$mande_havale_forushOstan_melki_tokhm_s_varedati;
	  $mande_pasazkasrKol_melki_tokhm_s_varedati+=$mande_pasazkasrOstan_melki_tokhm_s_varedati;
	  //استیجاری
	  $mojodyKalaKol_estijari_tokhm_s_varedati+=$mojodyKalaOstan_estijari_tokhm_s_varedati;
	  $mande_havale_forushKol_estijari_tokhm_s_varedati+=$mande_havale_forushOstan_estijari_tokhm_s_varedati;
	  $mande_pasazkasrKol_estijari_tokhm_s_varedati+=$mande_pasazkasrOstan_estijari_tokhm_s_varedati;
	  
	  $mande_pasazkasrKol_tokhm_s=$mande_pasazkasrKol_tokhm_s_dakheli+$mande_pasazkasrKol_tokhm_s_varedati;
	  $mande_pasazkasrKol_melki_tokhm_s=$mande_pasazkasrKol_melki_tokhm_s_dakheli+$mande_pasazkasrKol_tokhm_s_melki_varedati;
	  $mande_pasazkasrKol_estijari_tokhm_s=$mande_pasazkasrKol_estijari_tokhm_s_dakheli+$mande_pasazkasrKol_estijari_tokhm_s_varedati;
	 
	 //سوسیس
	  //داخلی
	  $mojodyKalaKol_sosis_dakheli+=$mojodyKalaOstan_sosis_dakheli;
	  $mande_havale_forushKol_sosis_dakheli+=$mande_havale_forushOstan_sosis_dakheli;
	  $mande_pasazkasrKol_sosis_dakheli+=$mande_pasazkasrOstan_sosis_dakheli;
      //ملکی
	  $mojodyKalaKol_melki_sosis_dakheli+=$mojodyKalaOstan_melki_sosis_dakheli;
	  $mande_havale_forushKol_melki_sosis_dakheli+=$mande_havale_forushOstan_melki_sosis_dakheli;
	  $mande_pasazkasrKol_melki_sosis_dakheli+=$mande_pasazkasrOstan_melki_sosis_dakheli;
	  //استیجاری
	  $mojodyKalaKol_estijari_sosis_dakheli+=$mojodyKalaOstan_estijari_sosis_dakheli;
	  $mande_havale_forushKol_estijari_sosis_dakheli+=$mande_havale_forushOstan_estijari_sosis_dakheli;
	  $mande_pasazkasrKol_estijari_sosis_dakheli+=$mande_pasazkasrOstan_estijari_sosis_dakheli;
	  //وارداتی
	  $mojodyKalaKol_sosis_varedati+=$mojodyKalaOstan_sosis_varedati;
	  $mande_havale_forushKol_sosis_varedati+=$mande_havale_forushOstan_sosis_varedati;
	  $mande_pasazkasrKol_sosis_varedati+=$mande_pasazkasrOstan_sosis_varedati;
	  //ملکی
	  $mojodyKalaKol_melki_sosis_varedati+=$mojodyKalaOstan_melki_sosis_varedati;
	  $mande_havale_forushKol_melki_sosis_varedati+=$mande_havale_forushOstan_melki_sosis_varedati;
	  $mande_pasazkasrKol_melki_sosis_varedati+=$mande_pasazkasrOstan_melki_sosis_varedati;
	  //استیجاری
	  $mojodyKalaKol_estijari_sosis_varedati+=$mojodyKalaOstan_estijari_sosis_varedati;
	  $mande_havale_forushKol_estijari_sosis_varedati+=$mande_havale_forushOstan_estijari_sosis_varedati;
	  $mande_pasazkasrKol_estijari_sosis_varedati+=$mande_pasazkasrOstan_estijari_sosis_varedati;
	  
	  $mande_pasazkasrKol_sosis=$mande_pasazkasrKol_sosis_dakheli+$mande_pasazkasrKol_sosis_varedati;
	  $mande_pasazkasrKol_melki_sosis=$mande_pasazkasrKol_melki_sosis_dakheli+$mande_pasazkasrKol_melki_sosis_varedati;
	  $mande_pasazkasrKol_estijari_sosis=$mande_pasazkasrKol_estijari_sosis_dakheli+$mande_pasazkasrKol_estijari_sosis_varedati;
	 
	 //جوجه یک روزه
	  //داخلی
	  $mojodyKalaKol_joje_dakheli+=$mojodyKalaOstan_joje_dakheli;
	  $mande_havale_forushKol_joje_dakheli+=$mande_havale_forushOstan_joje_dakheli;
	  $mande_pasazkasrKol_joje_dakheli+=$mande_pasazkasrOstan_joje_dakheli;
      //ملکی
	  $mojodyKalaKol_melki_joje_dakheli+=$mojodyKalaOstan_melki_joje_dakheli;
	  $mande_havale_forushKol_melki_joje_dakheli+=$mande_havale_forushOstan_melki_joje_dakheli;
	  $mande_pasazkasrKol_melki_joje_dakheli+=$mande_pasazkasrOstan_melki_joje_dakheli;
	  //استیجاری
	  $mojodyKalaKol_estijari_joje_dakheli+=$mojodyKalaOstan_estijari_joje_dakheli;
	  $mande_havale_forushKol_estijari_joje_dakheli+=$mande_havale_forushOstan_estijari_joje_dakheli;
	  $mande_pasazkasrKol_estijari_joje_dakheli+=$mande_pasazkasrOstan_estijari_joje_dakheli;
	  //وارداتی
	  $mojodyKalaKol_joje_varedati+=$mojodyKalaOstan_joje_varedati;
	  $mande_havale_forushKol_joje_varedati+=$mande_havale_forushOstan_joje_varedati;
	  $mande_pasazkasrKol_joje_varedati+=$mande_pasazkasrOstan_joje_varedati;
	  //ملکی
	  $mojodyKalaKol_melki_joje_varedati+=$mojodyKalaOstan_melki_joje_varedati;
	  $mande_havale_forushKol_melki_joje_varedati+=$mande_havale_forushOstan_melki_joje_varedati;
	  $mande_pasazkasrKol_melki_joje_varedati+=$mande_pasazkasrOstan_melki_joje_varedati;
	  //استیجاری
	  $mojodyKalaKol_estijari_joje_varedati+=$mojodyKalaOstan_estijari_joje_varedati;
	  $mande_havale_forushKol_estijari_joje_varedati+=$mande_havale_forushOstan_estijari_joje_varedati;
	  $mande_pasazkasrKol_estijari_joje_varedati+=$mande_pasazkasrOstan_estijari_joje_varedati;
	  
	  $mande_pasazkasrKol_joje=$mande_pasazkasrKol_joje_dakheli+$mande_pasazkasrKol_joje_varedati;
	  $mande_pasazkasrKol_melki_joje=$mande_pasazkasrKol_melki_joje_dakheli+$mande_pasazkasrKol_melki_joje_varedati;
	  $mande_pasazkasrKol_estijari_joje=$mande_pasazkasrKol_estijari_joje_dakheli+$mande_pasazkasrKol_estijari_joje_varedati;
	  	 
	 $jame_mande_pasazkasr_Kol=$mande_pasazkasrKol_morgh+$mande_pasazkasrKol_ghusht+$mande_pasazkasrKol_tokhm+$mande_pasazkasrKol_sosis;
	 $jame_mande_pasazkasr_Kol_melki=$mande_pasazkasrKol_melki_morgh+$mande_pasazkasrKol_melki_ghusht+$mande_pasazkasrKol_melki_tokhm+$mande_pasazkasrKol_melki_sosis;
	 $jame_mande_pasazkasr_Kol_estijari=$mande_pasazkasrKol_estijari_morgh+$mande_pasazkasrKol_estijari_ghusht+$mande_pasazkasrKol_estijari_tokhm+$mande_pasazkasrKol_estijari_sosis;
	}//END FIRST while,ostan while
    if((($_SESSION['mt_all_ostan']==1)or(SuperUser()))and($ostan_val==-1))
	{
     /*****سطر جمع موجودی انبارهای ملکی استان ها*****/
	 if(( in_array(1,$malekiyatchoice ) )OR($mal_val==-1))//اگر ملکی در شروط باشد یا فقط همه انتخاب شده باشد
	 {
	  echo'
	  <tr class="print_table-even sum-row" >
	   <td colspan="5">جمع کل سردخانه های ملکی استان ها</td>';
	    $q5="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition ORDER BY code_group_kala_top";
        $res5=$db->query($q5);
	    while($row5=$db->fetch_assoc($res5))
	    {
	  	 //مجموع موجودی هر کالادر تمام استان ها
	  	 IF($row5['code_group_kala_top']==4)  echo '<td>'.round($mojodyKalaKol_melki_morgh_dakheli,3).'</td><td>'.round($mande_havale_forushKol_melki_morgh_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_melki_morgh_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_melki_morgh_varedati,3).'</td><td>'.round($mande_havale_forushKol_melki_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_morgh,3).'</td>';
         IF($row5['code_group_kala_top']==5)  echo '<td>'.round($mojodyKalaKol_melki_ghusht_dakheli,3).'</td><td>'.round($mande_havale_forushKol_melki_ghusht_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_melki_ghusht_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_melki_ghusht_varedati,3).'</td><td>'.round($mande_havale_forushKol_melki_ghusht_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_ghusht_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_ghusht,3).'</td>';
	     IF($row5['code_group_kala_top']==6)  echo '<td>'.round($mojodyKalaKol_melki_konserv_dakheli,3).'</td><td>'.round($mande_havale_forushKol_melki_konserv_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_melki_konserv_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_melki_konserv_varedati,3).'</td><td>'.round($mande_havale_forushKol_melki_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_konserv,3).'</td>';
	  	 IF($row5['code_group_kala_top']==7)  echo '<td>'.round($mojodyKalaKol_melki_tokhm_dakheli,3).'</td><td>'.round($mande_havale_forushKol_melki_tokhm_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_melki_tokhm_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_melki_tokhm_varedati,3).'</td><td>'.round($mande_havale_forushKol_melki_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_tokhm,3).'</td>';
	  	 IF($row5['code_group_kala_top']==8)  echo '<td>'.round($mojodyKalaKol_melki_tokhm_s_dakheli,3).'</td><td>'.round($mande_havale_forushKol_melki_tokhm_s_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_melki_tokhm_s_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_melki_tokhm_s_varedati,3).'</td><td>'.round($mande_havale_forushKol_melki_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_tokhm_s,3).'</td>';
	  	 IF($row5['code_group_kala_top']==9)  echo '<td>'.round($mojodyKalaKol_melki_sosis_dakheli,3).'</td><td>'.round($mande_havale_forushKol_melki_sosis_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_melki_sosis_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_melki_sosis_varedati,3).'</td><td>'.round($mande_havale_forushKol_melki_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_sosis,3).'</td>';
	  	 IF($row5['code_group_kala_top']==10) echo '<td>'.round($mojodyKalaKol_melki_joje_dakheli,3).'</td><td>'.round($mande_havale_forushKol_melki_joje_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_melki_joje_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_melki_joje_varedati,3).'</td><td>'.round($mande_havale_forushKol_melki_joje_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_joje_varedati,3).'</td><td>'.round($mande_pasazkasrKol_melki_joje,3).'</td>';
	    }//END kala while
	   echo'
	   <td>'.round($jame_mande_pasazkasr_Kol_melki,3).'</td>
	  </tr>';		
	 }
	 /*****سطر جمع موجودی انبارهای استیجاری استان ها*****/
     if(( in_array(2,$malekiyatchoice ) )OR($mal_val==-1))//اگر استیجاری در شروط باشد یا فقط همه انتخاب شده باشد 
	 {
	  echo'
	  <tr class="print_table-even sum-row" >
	   <td colspan="5">جمع کل سردخانه های استیجاری استان ها</td>';
	    $q5="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition ORDER BY code_group_kala_top";
        $res5=$db->query($q5);
	    while($row5=$db->fetch_assoc($res5))
	    {
	  	 //مجموع موجودی هر کالادر تمام استان ها
	  	 IF($row5['code_group_kala_top']==4)  echo '<td>'.round($mojodyKalaKol_estijari_morgh_dakheli,3).'</td><td>'.round($mande_havale_forushKol_estijari_morgh_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_estijari_morgh_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_estijari_morgh_varedati,3).'</td><td>'.round($mande_havale_forushKol_estijari_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_morgh,3).'</td>';
         IF($row5['code_group_kala_top']==5)  echo '<td>'.round($mojodyKalaKol_estijari_ghusht_dakheli,3).'</td><td>'.round($mande_havale_forushKol_estijari_ghusht_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_estijari_ghusht_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_estijari_ghusht_varedati,3).'</td><td>'.round($mande_havale_forushKol_estijari_ghusht_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_ghusht_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_ghusht,3).'</td>';
	     IF($row5['code_group_kala_top']==6)  echo '<td>'.round($mojodyKalaKol_estijari_konserv_dakheli,3).'</td><td>'.round($mande_havale_forushKol_estijari_konserv_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_estijari_konserv_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_estijari_konserv_varedati,3).'</td><td>'.round($mande_havale_forushKol_estijari_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_konserv,3).'</td>';
	  	 IF($row5['code_group_kala_top']==7)  echo '<td>'.round($mojodyKalaKol_estijari_tokhm_dakheli,3).'</td><td>'.round($mande_havale_forushKol_estijari_tokhm_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_estijari_tokhm_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_estijari_tokhm_varedati,3).'</td><td>'.round($mande_havale_forushKol_estijari_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_tokhm,3).'</td>';
	  	 IF($row5['code_group_kala_top']==8)  echo '<td>'.round($mojodyKalaKol_estijari_tokhm_s_dakheli,3).'</td><td>'.round($mande_havale_forushKol_estijari_tokhm_s_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_estijari_tokhm_s_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_estijari_tokhm_s_varedati,3).'</td><td>'.round($mande_havale_forushKol_estijari_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_tokhm_s,3).'</td>';
	  	 IF($row5['code_group_kala_top']==9)  echo '<td>'.round($mojodyKalaKol_estijari_sosis_dakheli,3).'</td><td>'.round($mande_havale_forushKol_estijari_sosis_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_estijari_sosis_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_estijari_sosis_varedati,3).'</td><td>'.round($mande_havale_forushKol_estijari_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_sosis,3).'</td>';
	  	 IF($row5['code_group_kala_top']==10) echo '<td>'.round($mojodyKalaKol_estijari_joje_dakheli,3).'</td><td>'.round($mande_havale_forushKol_estijari_joje_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_estijari_joje_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_estijari_joje_varedati,3).'</td><td>'.round($mande_havale_forushKol_estijari_joje_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_joje_varedati,3).'</td><td>'.round($mande_pasazkasrKol_estijari_joje,3).'</td>';
	    }//END kala while
	  echo'
	   <td>'.round($jame_mande_pasazkasr_Kol_estijari,3).'</td>
	  </tr>';	
	 } 
	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" >
	  <td colspan="5">جمع کل استان ها</td>';
	   $q5="SELECT code_group_kala_top,name_group_kala_top FROM bzacc.group_kala_top WHERE group_type_top=2 $Condition ORDER BY code_group_kala_top";
       $res5=$db->query($q5);
	   while($row5=$db->fetch_assoc($res5))
	   {
		 //مجموع موجودی هر کالادر تمام استان ها
		IF($row5['code_group_kala_top']==4)  echo '<td>'.round($mojodyKalaKol_morgh_dakheli,3).'</td><td>'.round($mande_havale_forushKol_morgh_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_morgh_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_morgh_varedati,3).'</td><td>'.round($mande_havale_forushKol_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrKol_morgh_varedati,3).'</td><td>'.round($mande_pasazkasrKol_morgh,3).'</td>';
        IF($row5['code_group_kala_top']==5)  echo '<td>'.round($mojodyKalaKol_ghusht_dakheli,3).'</td><td>'.round($mande_havale_forushKol_ghusht_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_ghusht_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_ghusht_varedati,3).'</td><td>'.round($mande_havale_forushKol_ghusht_varedati,3).'</td><td>'.round($mande_pasazkasrKol_ghusht_varedati,3).'</td><td>'.round($mande_pasazkasrKol_ghusht,3).'</td>';
	    IF($row5['code_group_kala_top']==6)  echo '<td>'.round($mojodyKalaKol_konserv_dakheli,3).'</td><td>'.round($mande_havale_forushKol_konserv_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_konserv_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_konserv_varedati,3).'</td><td>'.round($mande_havale_forushKol_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrKol_konserv_varedati,3).'</td><td>'.round($mande_pasazkasrKol_konserv,3).'</td>';
		IF($row5['code_group_kala_top']==7)  echo '<td>'.round($mojodyKalaKol_tokhm_dakheli,3).'</td><td>'.round($mande_havale_forushKol_tokhm_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_tokhm_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_tokhm_varedati,3).'</td><td>'.round($mande_havale_forushKol_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrKol_tokhm_varedati,3).'</td><td>'.round($mande_pasazkasrKol_tokhm,3).'</td>';
		IF($row5['code_group_kala_top']==8)  echo '<td>'.round($mojodyKalaKol_tokhm_s_dakheli,3).'</td><td>'.round($mande_havale_forushKol_tokhm_s_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_tokhm_s_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_tokhm_s_varedati,3).'</td><td>'.round($mande_havale_forushKol_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrKol_tokhm_s_varedati,3).'</td><td>'.round($mande_pasazkasrKol_tokhm_s,3).'</td>';
		IF($row5['code_group_kala_top']==9)  echo '<td>'.round($mojodyKalaKol_sosis_dakheli,3).'</td><td>'.round($mande_havale_forushKol_sosis_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_sosis_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_sosis_varedati,3).'</td><td>'.round($mande_havale_forushKol_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrKol_sosis_varedati,3).'</td><td>'.round($mande_pasazkasrKol_sosis,3).'</td>';
		IF($row5['code_group_kala_top']==10) echo '<td>'.round($mojodyKalaKol_joje_dakheli,3).'</td><td>'.round($mande_havale_forushKol_joje_dakheli,3).'</td><td>'.round($mande_pasazkasrKol_joje_dakheli,3).'</td>  <td>'.round($mojodyKalaKol_joje_varedati,3).'</td><td>'.round($mande_havale_forushKol_joje_varedati,3).'</td><td>'.round($mande_pasazkasrKol_joje_varedati,3).'</td><td>'.round($mande_pasazkasrKol_joje,3).'</td>';
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
     <td colspan="60">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
    </tr>
 </table>';
 }
  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'
</div>	
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>