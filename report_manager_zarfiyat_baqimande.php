<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_zarfiyat_baqimande.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش ظرفیت ، درصد بهره برداری و فضای باقیمانده سردخانه های کل کشور';
require_once('head.html');
/****************هدر******************/
$columns='	
	<tr class="print_table-title2">
	 <td width="5%" rowspan="2">ردیف</td>
	 <td width="10%" rowspan="2">استان</td>
	 <td width="25%" colspan="3">ظرفیت سردخانه ها</td>
	 <td width="30%" colspan="3">درصد بهره برداری سردخانه ها</td>
	 <td width="30%" colspan="3">فضای باقیمانده سردخانه ها</td>
	</tr>
	<tr class="print_table-title2">
	 <td width="5%">ظرفیت سردخانه ملکی</td>
	 <td width="5%">ظرفیت سردخانه استیجاری</td>
	 <!--<td width="5%">ظرفیت تحققی سردخانه تحت کلید</td>-->
	 <!--<td width="5%">ظرفیت کل سردخانه ملکی و استیجاری</td>-->
	 <td width="5%">ظرفیت کل</td>
	 <td width="5%">درصد بهره برداری سردخانه ملکی</td>
	 <td width="5%">درصد بهره برداری سردخانه استیجاری</td>
	 <!--<td width="5%">درصد بهره برداری سردخانه تحت کلید</td>-->
	 <!--<td width="5%">درصد بهره برداری سردخانه ملکی و استیجاری</td>-->
	 <td width="5%">درصد بهره برداری کل</td>
	 <td width="5%">فضای باقیمانده سردخانه ملکی</td>
	 <td width="5%">فضای باقیمانده سردخانه استیجاری</td>
	 <!--<td width="5%">فضای باقیمانده سردخانه تحت کلید</td>-->
	 <!--<td width="5%">فضای باقیمانده سردخانه ملکی و استیجاری</td>-->
	 <td width="5%">فضای باقیمانده ظرفیت کل</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$kalaName,$code_kala,$Condition;
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
	      از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
         <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>	    </td>
	   </tr>
      </table>
     </td>
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
/**************انتخاب گروه کالا****************/
if(is_array($grkalachoice))
{
 foreach($grkalachoice as $grkala_key => $grkala_val) {
  $Condition_grkala_temp.=" code_group_kala_top='$grkala_val' OR";
 }
  if($grkala_val==-1)$Condition_grkala.="1=1 OR";
  else $Condition_grkala.=" $Condition_grkala_temp";
 $lastSpacePosition = strrpos($Condition_grkala," ");
 $Condition_grkala =substr($Condition_grkala,0,$lastSpacePosition);
}
/******************مالکیت انبارها******************/  
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
/******************نمایش یا عدم نمایش انبارهای موقت / حقیقی و مجازی******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date2.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=10;
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)
{
  $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
}
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
     $ExcelFileName=str_replace('.php','',$FileName); 
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
   <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت / مجازی</td>
	 <td align="left"><input type="checkbox" name="chkactivate"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
    <tr  class="tr1">
     <td align="left">گروه کالا : </td>
     <td align="right">
	  &nbsp;<select name="grkalachoice[]" class="easyui-combobox" size="6" style="width:100px;" panelHeight="190px" multiple>';
	  $result_grkala = $db->query("SELECT * FROM bzacc.group_kala_top WHERE group_type_top=2");
      $grkala_options = "<option value='-1' selected>همه</option>";
      while($row_grkala=$db->fetch_assoc($result_grkala)) $grkala_options .= "<option value=".$row_grkala['code_group_kala_top'].">".$row_grkala['name_group_kala_top']."</option>";
	  echo $grkala_options;
	  echo'
	  </select>
	 </td>	
	 <td align="left"> تعداد استان در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1" style="height:45px">
	 <!--<td align="left" style="height:45px">نوع مالکیت : </td>
	 <td align="right">
	 &nbsp;<select name="malekiyatchoice[]" class="easyui-combobox" size="6" style="width:100px;" data-options=panelHeight:155 multiple>';
	 $malekiyat_options = "<option value='-1' selected>همه</option>";
	 foreach($noe_malekiyatArr AS $key=>$val)
	 {
	  IF($key==0)continue;
	  $malekiyat_options .= "<option value=".$key.">".$val."</option>";
	 }
	 echo $malekiyat_options;
	 echo'
	   </select>      
	 </td>-->
	 ';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" size="6" style="width:200px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>      
	  </td>';
	}
	else echo'<td colspan="2">&nbsp;</td>';
	echo'
	</tr>
	<tr class="footer"><td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
  </td>
 </tr>
</table> ';
}
else
{
    $malekiyatArr=array();//آرایه جدید برای ایجاد حلقه سطرهای مجموع استان
	IF((count($malekiyatchoice)==1)AND(in_array(-1,$malekiyatchoice)))//اگر فقط همه انتخاب شده باشد
	{
			foreach($noe_malekiyatArr AS $key=>$val)
			{
			 array_push($malekiyatArr,$key);
			}
			//array_shift($malekiyatArr);//عنصر - را از آرایه حذف کردم
			array_unshift($malekiyatArr,'-1');//عنصر (-1) را به اول آرایه اضافه کردم
	}
	ELSE $malekiyatArr=$malekiyatchoice;//در بقیه موارد همان آرایه ایی که از انتخاب کاربر شکل گرفته 
	/****************شروع نمایش گزارش*******************/	
	$radif=1;
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
	        echo'
	         از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
           <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>	       </td>
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
	 // if(is_array($malekiyatchoice))
     // {
  	   // $filter_string.=' - نوع مالکیت  : ';
       // if($mal_val==-1)$filter_string.=' همه ';
  	   // else{
  	 	 // foreach($malekiyatchoice as $mal_key => $mal_val) {
  	       // $nameMalekiyat=$noe_malekiyatArr[$mal_val];
  	       // $filter_string.=''.$nameMalekiyat.'&nbsp;';
            // }	 
       // } 
     // }
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت / مجازی -';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت /  مجازی -';
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال ';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال';
	 echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
     echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {   

	  //ظرفیت ها
	  $zarfiyat_gharardadi_melki=$db->get_from_where("SUM(zarfiyat_gharardadi)","list_sardkhane","$Condition_movaghat $Condition_anbar_activate code_ostan=".$row['code_ostan']." AND noe_malekiyat=1");        	
	  //echo "select SUM(zarfiyat_gharardadi) from list_sardkhane where $Condition_anbar_activate code_ostan=".$row['code_ostan']." AND noe_malekiyat=1";        	
	  $zarfiyat_gharardadi_estijari=$db->get_from_where("SUM(zarfiyat_gharardadi)","list_sardkhane","$Condition_movaghat $Condition_anbar_activate code_ostan=".$row['code_ostan']." AND noe_malekiyat=2");        	
	  $zarfiyat_melki_estijari=$zarfiyat_gharardadi_melki+$zarfiyat_gharardadi_estijari;
	  //موجودی کل کالاها در هر استان -ملکی
	  $mojodyAval_melki=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala INNER JOIN kala ON kala.code_kala=mojody_kala.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=mojody_kala.code_ostan AND l_s.code_anbar=mojody_kala.code_anbar","$Condition_movaghat $Condition_anbar_activate mojody_kala.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 AND noe_malekiyat=1 AND($Condition_grkala)");        	
      $jameVarede_melki=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN kala ON kala.code_kala=T.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=T.code_ostan AND l_s.code_anbar=T.code_anbar","$Condition_movaghat $Condition_anbar_activate T.code_ostan=".$row['code_ostan']."   AND T.year='$mtActiveYear' AND r.deleted=0 AND T.status=0 AND tarikh_resid<='$date2' AND noe_malekiyat=1 AND($Condition_grkala)");
      $jameSadere_melki=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN kala ON kala.code_kala=T.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=T.code_ostan AND l_s.code_anbar=T.code_anbar","$Condition_movaghat $Condition_anbar_activate T.code_ostan=".$row['code_ostan']."  AND T.year='$mtActiveYear' AND h.deleted=0 AND T.status=0 AND tarikh_havale_anbar<='$date2' AND noe_malekiyat=1 AND($Condition_grkala)");
	  $meghdarTadil_Ezafe_melki=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN kala ON kala.code_kala=tadil_mojody.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=tadil_mojody.code_ostan AND l_s.code_anbar=tadil_mojody.code_anbar","$Condition_movaghat $Condition_anbar_activate noe_tadil=1 AND tadil_mojody.code_ostan=".$row['code_ostan']."  AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND noe_malekiyat=1 AND($Condition_grkala)");
      $meghdarTadil_Kasry_melki=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN kala ON kala.code_kala=tadil_mojody.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=tadil_mojody.code_ostan AND l_s.code_anbar=tadil_mojody.code_anbar","$Condition_movaghat $Condition_anbar_activate noe_tadil=2 AND tadil_mojody.code_ostan=".$row['code_ostan']."  AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND noe_malekiyat=1 AND($Condition_grkala)");
      $mojody_melki=$mojodyAval_melki+$jameVarede_melki-$jameSadere_melki+$meghdarTadil_Ezafe_melki-$meghdarTadil_Kasry_melki;	
	  //بهره وری
	  $bahrevary_melki=round((($mojody_melki/$zarfiyat_gharardadi_melki)*100),1);	 
	  //موجودی کل کالاها در هر استان -ملکی
	  $mojodyAval_estijari=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala INNER JOIN kala ON kala.code_kala=mojody_kala.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=mojody_kala.code_ostan AND l_s.code_anbar=mojody_kala.code_anbar","$Condition_movaghat $Condition_anbar_activate mojody_kala.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 AND noe_malekiyat=2 AND($Condition_grkala)");        	
      $jameVarede_estijari=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN kala ON kala.code_kala=T.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=T.code_ostan AND l_s.code_anbar=T.code_anbar","$Condition_movaghat $Condition_anbar_activate T.code_ostan=".$row['code_ostan']."   AND T.year='$mtActiveYear' AND r.deleted=0 AND T.status=0 AND tarikh_resid<='$date2' AND noe_malekiyat=2 AND($Condition_grkala)");
      $jameSadere_estijari=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN kala ON kala.code_kala=T.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=T.code_ostan AND l_s.code_anbar=T.code_anbar","$Condition_movaghat $Condition_anbar_activate T.code_ostan=".$row['code_ostan']."  AND T.year='$mtActiveYear' AND h.deleted=0 AND T.status=0 AND tarikh_havale_anbar<='$date2' AND noe_malekiyat=2 AND($Condition_grkala)");
	  $meghdarTadil_Ezafe_estijari=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN kala ON kala.code_kala=tadil_mojody.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=tadil_mojody.code_ostan AND l_s.code_anbar=tadil_mojody.code_anbar","$Condition_movaghat $Condition_anbar_activate noe_tadil=1 AND tadil_mojody.code_ostan=".$row['code_ostan']."  AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND noe_malekiyat=2 AND($Condition_grkala)");
      $meghdarTadil_Kasry_estijari=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN kala ON kala.code_kala=tadil_mojody.code_kala INNER JOIN list_sardkhane l_s ON l_s.code_ostan=tadil_mojody.code_ostan AND l_s.code_anbar=tadil_mojody.code_anbar","$Condition_movaghat $Condition_anbar_activate noe_tadil=2 AND tadil_mojody.code_ostan=".$row['code_ostan']."  AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND noe_malekiyat=2 AND($Condition_grkala)");
      $mojody_estijari=$mojodyAval_estijari+$jameVarede_estijari-$jameSadere_estijari+$meghdarTadil_Ezafe_estijari-$meghdarTadil_Kasry_estijari;	
	  //بهره وری
	  $bahrevary_estijari=round((($mojody_estijari/$zarfiyat_gharardadi_estijari)*100),1);	 
	  //$bahrevary_melki_estijari=$bahrevary_melki+$bahrevary_estijari;//اشتباه بود
	  $mojody_melki_estijari=$mojody_melki+$mojody_estijari;
	  $bahrevary_melki_estijari=round((($mojody_melki_estijari/$zarfiyat_melki_estijari)*100),1);
	  
	  $baqimande_melki=$zarfiyat_gharardadi_melki-$mojody_melki;
	  $baqimande_estijari=$zarfiyat_gharardadi_estijari-$mojody_estijari;
	  $baqimande_melki_estijari=$baqimande_melki+$baqimande_estijari;
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		<td >'.$radif++.'</td>
	    <td >'.$row['name_ostan'].'</td>
	    <td >'.virgul($zarfiyat_gharardadi_melki).'</td>
	    <td >'.virgul($zarfiyat_gharardadi_estijari).'</td>
	    <td >'.virgul($zarfiyat_melki_estijari).'</td>
		<td>'.$bahrevary_melki.'</td>
		<td>'.$bahrevary_estijari.'</td>
		<td>'.$bahrevary_melki_estijari.'</td>
		<td>'.$baqimande_melki.'</td>
		<td>'.$baqimande_estijari.'</td>
		<td>'.$baqimande_melki_estijari.'</td>
		';
        $jame_zarfiyat_gharardadi_melki+=$zarfiyat_gharardadi_melki;		
        $jame_zarfiyat_gharardadi_estijari+=$zarfiyat_gharardadi_estijari;		
        $jame_zarfiyat_melki_estijari+=$zarfiyat_melki_estijari;		
	    //اشتباه
		// $jame_bahrevary_melki+=$bahrevary_melki;
	    // $jame_bahrevary_estijari+=$bahrevary_estijari;
	    // $jame_bahrevary_melki_estijari+=$bahrevary_melki_estijari;
	    //محاسبه
		$jame_mojody_melki+=$mojody_melki;
		$jame_mojody_estijari+=$mojody_estijari;
		$jame_mojody_melki_estijari=$jame_mojody_melki+$jame_mojody_estijari;
		
		$jame_bahrevary_melki=round((($jame_mojody_melki/$jame_zarfiyat_gharardadi_melki)*100),1);
	    $jame_bahrevary_estijari=round((($jame_mojody_estijari/$jame_zarfiyat_gharardadi_estijari)*100),1);
	    $jame_bahrevary_melki_estijari=round((($jame_mojody_melki_estijari/$jame_zarfiyat_melki_estijari)*100),1);
		
		
		$jame_baqimande_melki+=$baqimande_melki;
	    $jame_baqimande_estijari+=$baqimande_estijari;
	    $jame_baqimande_melki_estijari+=$baqimande_melki_estijari;
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
	 }//END FIRST while,ostan while
	/*****سطر جمع کل استان ها*****/
    IF((($_SESSION['mt_all_ostan']==1)or(SuperUser())))
	{    
	  echo'
		  <tr class="print_table-even sum-row" >
	       <td colspan="2">جمع کل </td>
			  <td>'.virgul($jame_zarfiyat_gharardadi_melki).'</td>
			  <td>'.virgul($jame_zarfiyat_gharardadi_estijari).'</td>	
			  <td>'.virgul($jame_zarfiyat_melki_estijari).'</td>
			  <td>'.$jame_bahrevary_melki.'</td>
			  <td>'.$jame_bahrevary_estijari.'</td>
			  <td>'.$jame_bahrevary_melki_estijari.'</td>
			  <td>'.$jame_baqimande_melki.'</td>
			  <td>'.$jame_baqimande_estijari.'</td>
			  <td>'.$jame_baqimande_melki_estijari.'</td>
		  </tr>	  '; 

	}//END IF
	//END//
 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
    <tr class="print_footer noExl">
     <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
    </tr>
 </table>';
 }
 ELSE{
	 echo'
	 <div class="msg_error">
	  <span >اطلاعاتی یافت نشد</span><br>
	  <button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button>
	 </div>';
 }
}
echo'
</div>	
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>