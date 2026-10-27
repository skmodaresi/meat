<?php
//date change 1395/08/15
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_amalkard_nahadeha.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش اطلاعات عملکرد نهاده ها';
require_once('head.html');
/****************هدر******************/
$columns='
    <tr class="print_table-title2">
     <td width="%" rowspan="2">ردیف</td>
     <td width="%" rowspan="2">کالا</td>
     <td width="%" class="mande_beforPr" colspan="3">مانده موجودی از قبل</td>
     <td width="%" class="tadil_ezafePr" colspan="2">تعدیل (اضافه)</td>
     <td width="%" class="tadil_kasryPr" colspan="2">تعدیل (کسری)</td>
     <td width="%" class="kharidPr" colspan="2">خرید قطعی</td>
     <td width="%" class="daryafti_Pr" colspan="2">دریافتی از سایر استانها</td>
      <!--<td width="%" class="daryafti_movaghatPr" colspan="2">دریافتی از سردخانه موقت</td>-->
     <td width="%" class="daryafti_bandarPr" colspan="2">دریافتی از بنادر</td>
     <td width="%" class="bargashtPr" colspan="2">برگشت از فروش</td>
     <td width="%" class="tahvilPr" colspan="2">تحویل قطعی</td>
	 <td width="%" class="tahvilrobariPr" colspan="2">تحویل قطعی روباری</td>
	 <td width="%" class="kalaye_darrah_sayerPr" colspan="2">کالای در راه به سایر انبارها</td>
	 <td width="%" class="kalaye_darrah_movaghatPr" colspan="2">کالای در راه به موقت</td>
     <td width="%" class="ersaly_sayerPr" colspan="2">ارسالی به سایر انبارها</td>
     <td width="%" class="ersaly_movaghatPr" colspan="2">ارسالی به موقت</td>
     <!--<td width="%" class="kasry_kolPr" colspan="2">کل کسری</td>
         <td width="%" class="kasry_gheyrPr" colspan="2">کسری غیرمجاز</td>-->
     <td width="%" class="forushPr" colspan="2">حواله فروش</td>
     <td width="%" class="forushrobariPr" colspan="2">حواله فروش روباری</td>
     <td width="%" class="ebtalyPr" colspan="2">ابطالی حواله فروش</td>
	 <td width="%" class="ebtalyrobariPr" colspan="2">ابطالی حواله فروش روباری</td>
     <td width="%" class="mande_forushPr" colspan="3">مانده حواله فروش</td>
     <td width="%" class="mande_forushrobariPr" colspan="3">مانده حواله فروش روباری</td>
	 <td width="%" class="mande_anbargardaniPr" colspan="3">مانده موجودی درفرم انبارگردانی</td>
     <td width="%" class="anbargardani_ezafePr" colspan="2">انبارگردانی(اضافه)</td>
     <td width="%" class="anbargardani_kasryPr" colspan="2">انبارگردانی(کسری)</td>
     <td width="%" class="mandePr" colspan="3">مانده موجودی</td>
     <td width="%" class="mande_pasaz_kasrPr" colspan="3">مانده موجودی پس از کسر حواله فروش</td>
	</tr>
    <tr class="print_table-title2 print_table-title_small">
	  <td class="mande_beforPr">داخلی</td><td class="mande_beforPr">وارداتی</td><td class="mande_beforPr">جمع</td>
	  <td class="tadil_ezafePr">داخلی</td><td class="tadil_ezafePr">وارداتی</td>
	  <td class="tadil_kasryPr">داخلی</td><td class="tadil_kasryPr">وارداتی</td>
	  <td class="kharidPr">داخلی</td><td class="kharidPr">وارداتی</td>
	  <td class="daryafti_Pr">داخلی</td><td class="daryafti_Pr">وارداتی</td>
	  <!--<td class="daryafti_movaghatPr">داخلی</td><td class="daryafti_movaghatPr">وارداتی</td>-->
	  <td class="daryafti_bandarPr">داخلی</td><td class="daryafti_bandarPr">وارداتی</td>
	  <td class="bargashtPr">داخلی</td><td class="bargashtPr">وارداتی</td>
	  <td class="tahvilPr">داخلی</td><td class="tahvilPr">وارداتی</td>
	  <td class="tahvilrobariPr">داخلی</td><td class="tahvilrobariPr">وارداتی</td>
	  <td class="kalaye_darrah_sayerPr">داخلی</td><td class="kalaye_darrah_sayerPr">وارداتی</td>
	  <td class="kalaye_darrah_movaghatPr">داخلی</td><td class="kalaye_darrah_movaghatPr">وارداتی</td>
	  <td class="ersaly_sayerPr">داخلی</td><td class="ersaly_sayerPr">وارداتی</td>
	  <td class="ersaly_movaghatPr">داخلی</td><td class="ersaly_movaghatPr">وارداتی</td>
	  <!--<td class="kasry_kolPr">داخلی</td><td class="kasry_kolPr">وارداتی</td>
	      <td class="kasry_gheyrPr">داخلی</td><td class="kasry_gheyrPr">وارداتی</td>-->
	  <td class="forushPr">داخلی</td><td class="forushPr">وارداتی</td>
	  <td class="forushrobariPr">داخلی</td><td class="forushrobariPr">وارداتی</td>
	  <td class="ebtalyPr">داخلی</td><td class="ebtalyPr">وارداتی</td>
	  <td class="ebtalyrobariPr">داخلی</td><td class="ebtalyrobariPr">وارداتی</td>
	  <td class="mande_forushPr">داخلی</td><td class="mande_forushPr">وارداتی</td><td class="mande_forushPr">جمع</td>
	  <td class="mande_forushrobariPr">داخلی</td><td class="mande_forushrobariPr">وارداتی</td><td class="mande_forushrobariPr">جمع</td>
	  <td class="mande_anbargardaniPr">داخلی</td><td class="mande_anbargardaniPr">وارداتی</td><td class="mande_anbargardaniPr">جمع</td>
	  <td class="anbargardani_ezafePr">داخلی</td><td class="anbargardani_ezafePr">وارداتی</td>
	  <td class="anbargardani_kasryPr">داخلی</td><td class="anbargardani_kasryPr">وارداتی</td>
	  <td class="mandePr">داخلی</td><td class="mandePr">وارداتی</td><td class="mandePr">جمع</td>
	  <td class="mande_pasaz_kasrPr">داخلی</td><td class="mande_pasaz_kasrPr">وارداتی</td><td class="mande_pasaz_kasrPr">جمع</td>
	 </tr>';
Function print_header()
{global $titr,$columns,$count,$bz_gl_owner,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$kalaName,$code_kala,$Condition;
 echo'
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" >
    <tr class="noExl"><td class="print_title_2" colspan="56">'.$bz_gl_owner.'</td></tr>
	<tr class="noExl"><td class="print_title_2" colspan="56">'.$titr.'
	  <span style="float:left;"><button  class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></span>
	 </td>
	</tr>
	<tr '; IF($page!=1) echo 'class="noExl"'; echo'>
	 <td class="print_title_2" colspan="56">';
	   IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
	   }
	   echo'
	    <span >از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')</span>
	  </td>
	 </tr>';
	 IF($page==1){
	  echo'<tr class="noExl">
		    <td class="print_title" colspan="56">
            خرید قطعی شامل : تخلیه در انبار ، تحویل روباری و حمل با راه آهن<br/>
            تحویل قطعی شامل : بارگیری از انبار و تحویل روباری<br/>
            دریافتی از بنادر شامل : بندر امام خمینی ، بندر انزلی  ، بندر نوشهر و بندر عباس وبندر امیرآباد و بندر چابهار
            </td>
          </tr>';
	 }
}	
/****************فیلترها روی گزارش******************/
/*******استان ها*******/
if(($_SESSION['bz_all_ostan']==1)or(SuperUser()))
{  
 if(is_array($ostanchoice))//کد های استان
 {
   foreach($ostanchoice as $ostan_key => $ostan_val ) 
   {
     $Condition_ostan_temp.=" T.code_ostan='$ostan_val' OR";
     $Condition_ostan_ebtal_temp.=" ebtal.code_ostan='$ostan_val' OR";
     $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='$ostan_val'");//تبدیل کد به آی دی
     $Condition_ostan_temp_sell.=" dm_havale.h_id_province='$sell_id_ostan' OR";
	 $Condition_ostan_ebtal_temp_sell.=" dm_his_havale.his_id_province='$sell_id_ostan' OR";
   }
   if($ostan_val==-1){$Condition_ostan.="1=1 OR";$Condition_ostan_ebtal.="1=1 OR";$Condition_ostan_sell.="1=1 OR";}
   else {$Condition_ostan.=" $Condition_ostan_temp";$Condition_ostan_ebtal.=" $Condition_ostan_ebtal_temp";$Condition_ostan_sell.=" $Condition_ostan_temp_sell";}
     $lastSpacePosition = strrpos($Condition_ostan," ");
     $lastSpacePosition_ebtal = strrpos($Condition_ostan_ebtal," ");
     $lastSpacePosition_sell = strrpos($Condition_ostan_sell," ");
     $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     $Condition_ostan_ebtal =substr($Condition_ostan_ebtal,0,$lastSpacePosition_ebtal);
     $Condition_ostan_sell =substr($Condition_ostan_sell,0,$lastSpacePosition_sell);
      
 }
}
else 
{
	  $Condition_ostan=' T.code_ostan='.$_SESSION['bz_code_ostan'].'';
	  $Condition_ostan_ebtal=' ebtal.code_ostan='.$_SESSION['bz_code_ostan'].'';
	  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='".$_SESSION['bz_code_ostan']."'");//تبدیل کد به آی دی
	  $Condition_ostan_sell=' dm_havale.h_id_province='.$sell_id_ostan.'';
}
/******انبارها******/
if(($_SESSION['bz_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_ebtal='1=1';$Condition_anbar_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_anbar ON list_anbar.code_ostan=user_ostan_anbar.code_ostan AND list_anbar.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat list_anbar.code_ostan=".$_SESSION["bz_code_ostan"]." AND user_id=".$_SESSION['bz_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
   $Condition_anbar_ebtal_temp.=" ebtal.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["bz_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_ebtal.="  $Condition_anbar_ebtal_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_ebtal = strrpos($Condition_anbar_ebtal," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     $Condition_anbar_ebtal =substr($Condition_anbar_ebtal,0,$lastSpacePosition_ebtal);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
}
/**************انتخاب گروه کالا****************/
if(is_array($groupkalachoice))
{
 $grpkalaArrChoice=array();//کالاهای انتخاب شده داخل این آرایه قرار میگیرد
 foreach($groupkalachoice as $grp_val) 
 {
  if($grp_val=='همه'){$grpkalaArrChoice=array();$grpkalaArrChoice=$kalagroupArr;break;}
  else array_push($grpkalaArrChoice,$grp_val);
 }
}
/******************نمایش یا عدم نمایش انبارهای موقت******************/
// if($chkmovaghat=='on') {$Condition_movaghat="";$Condition_movaghat_mj="";}
// else {$Condition_movaghat="list_anbar.situation_type=1 AND "; $Condition_movaghat_mj="l_a.situation_type=1 AND";}
/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
if($show_movaghat==1){$Condition_movaghat="list_anbar.situation_type=1 AND "; $Condition_movaghat_mj="l_a.situation_type=1 AND";}
else if($show_movaghat==2){$Condition_movaghat="";$Condition_movaghat_mj="";}
else if($show_movaghat==3){$Condition_movaghat="list_anbar.situation_type=2 AND ";$Condition_movaghat_mj="";}//خودش موقت ولی مقصد هر انباری
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_mj="";}
else {$Condition_anbar_activate="list_anbar.activate=1 AND"; $Condition_anbar_activate_mj="l_a.activate=1 AND"; }
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=15; 
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)$date1=$db->get_from_where("start_from","bzacc.bz_docs","year='$bzActiveYear'");  
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
    $ExcelFileName=str_replace('.php','',$FileName); 
    $end_date_session=$db->get_from_where("end_to","bzacc.bz_docs","year='$bzActiveYear'");
    if($today<$end_date_session) $date2=$today;
    else  $date2=$end_date_session;	 
}
if(!$ok)
{
echo'
<table width="95%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="750px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px">
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>	
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
	 <!--<td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; همراه با اطلاعات انبار موقت </td>-->
     <td align="left"> وضعیت نمایش انبارهای موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='text4'").'</td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات انبارهای غیرفعال</td>
	</tr>
	<tr class="tr1"> 
	 <td align="left" height="40px"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>';
	 if(($_SESSION['bz_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox text4" style="width:200px;" multiple>';
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
	 <td align="left">گروه کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="groupkalachoice[]" size="4" style="font-family:bYekan;width:130px;" multiple>
	  <option value="همه" selected>همه کالاها</option>';
	  foreach($kalagroupArr as $grp_key=>$grp_val)
	  {echo '<option value="'.$grp_val.'" >'.$grp_val.'</option>';}
	  //echo $kala_options;
	  echo'
	  </select>
	  <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  &nbsp;
	 </td>
	</tr>
	<tr class="footer">	
	 <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
  </td>
 </tr>
</table> ';
}
else
{	   
	/****************شروع نمایش گزارش*******************/	
	 $radif=1;
	 $page=1;
     $line=0;
     $i=0;
     $cntr=0;
	 echo'
     <br/>
	 <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	    <tr class="print_table-title2"><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
		<tr class="print_table-title2"> 
	     <td width="5%">مانده موجودی از قبل</td>
	     <td width="4%" >تعدیل (اضافه)</td>
	     <td width="4%" >تعدیل (کسری)</td>
	     <td width="4%" >خرید قطعی</td>
	     <td width="5%" >دریافتی از سایر استان ها</td>
	     <td width="4%" >دریافتی از بنادر</td>
	     <td width="4%" >برگشت از فروش</td>
	     <td width="4%" >تحویل قطعی</td>
	     <td width="4%" >تحویل قطعی روباری</td>
	     <td width="4%" >کالای در راه به سایر انبارها</td>
	     <td width="5%" >کالای در راه به موقت</td>
		 <td width="5%" >ارسالی به سایر انبارها</td>
		 <td width="4%" >ارسالی به موقت</td>
		 <!--<td width="4%" >کل کسری</td>
		     <td width="4%" >کسری غیر مجاز</td>-->
		 <td width="4%" >حواله فروش</td>
		 <td width="4%" >حواله فروش روباری</td>
	     <td width="4%" >ابطالی حواله فروش</td>
	     <td width="4%" >ابطالی حواله فروش روباری</td>
	     <td width="4%" >مانده حواله فروش</td>
	     <td width="4%" >مانده حواله فروش روباری</td>
	     <td width="7%" >مانده موجودی در فرم انبارگردانی</td>
	     <td width="5%" >انبارگردانی(اضافه)</td>
	     <td width="5%" >انبارگردانی(کسری)</td>
		 <td width="4%" >مانده موجودی</td>
	     <td width="7%" >مانده موجودی پس از کسر حواله فروش</td>
	    </tr>   	
		<tr class="print_table-title2 print_table-title_small">
	     <td><input name="mande_beforPr" type="checkbox" checked ></td>
	     <td><input name="tadil_ezafePr" type="checkbox" ></td>
	     <td><input name="tadil_kasryPr" type="checkbox" ></td>
	     <td><input name="kharidPr" type="checkbox" checked ></td>
	     <td><input name="daryafti_Pr" type="checkbox" checked ></td>
	     <td><input name="daryafti_bandarPr" type="checkbox"  ></td>
	     <td><input name="bargashtPr" type="checkbox"  ></td>
	     <td><input name="tahvilPr" type="checkbox" checked ></td>
	     <td><input name="tahvilrobariPr" type="checkbox" checked ></td>
	     <td><input name="kalaye_darrah_sayerPr" type="checkbox" checked ></td>
	     <td><input name="kalaye_darrah_movaghatPr" type="checkbox" ></td>
	     <td><input name="ersaly_sayerPr" type="checkbox" checked ></td>
	     <td><input name="ersaly_movaghatPr" type="checkbox" checked></td>
	     <!--<td><input name="kasry_kolPr" type="checkbox"  ></td>
	         <td><input name="kasry_gheyrPr" type="checkbox"  ></td>-->
	     <td><input name="forushPr" type="checkbox" checked ></td>
	     <td><input name="forushrobariPr" type="checkbox" checked ></td>
	     <td><input name="ebtalyPr" type="checkbox" checked ></td>
	     <td><input name="ebtalyrobariPr" type="checkbox" checked ></td>
	     <td><input name="mande_forushPr" type="checkbox" checked ></td>
	     <td><input name="mande_forushrobariPr" type="checkbox" checked ></td>
	     <td><input name="mande_anbargardaniPr" type="checkbox" ';IF($bzActiveYear!=$yy) echo' checked'; echo' ></td>
	     <td><input name="anbargardani_ezafePr" type="checkbox" ></td>
	     <td><input name="anbargardani_kasryPr" type="checkbox" ></td>
		 <td><input name="mandePr" type="checkbox" checked ></td>
	     <td><input name="mande_pasaz_kasrPr" type="checkbox" checked ></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if(($ostanchoice))
	 {
	      if($ostan_val==-1)$filter_string='همه استانها';
	      else $filter_string=' استان : ';
	      foreach($ostanchoice as $ostan_key => $ostan_val) {
	       $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	       $filter_string.=''.$nameOstan.'&nbsp;';
          }
	 }
	 if($show_movaghat==1) $filter_string.=' بدون اطلاعات انبار موقت -';
     else if($show_movaghat==2) $filter_string.=' با اطلاعات انبار موقت -';
     else if($show_movaghat==3) $filter_string.=' فقط اطلاعات انبار موقت -';
     if($chkactivate==TRUE) $filter_string.=' با اطلاعات انبار غیرفعال ';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات انبار غیرفعال';   
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 $kalagroupArray = array("1"=>"ذرت","2"=>"جو","3"=>"سویا");
     //foreach($kalagroupArray as $x => $x_value)
     foreach($grpkalaArrChoice as $x => $x_value ) 
	 { 
	   $sty_dakheli='';
	   $sty_varedati='';
	   $sty_jam='';
	   $line++;
       if($i++%2)echo'<tr class="print_table-odd_small">';
       else echo'<tr class="print_table-even_small">';
	   echo'   
		 <td>'.$radif++.'</td>
	     <td>'.$x_value.'</td>';
		 if($x_value=="ذرت"){$kalaCondition_dakheli=" AND T.code_kala=21";$kalaCondition_varedati=" AND T.code_kala=1";$kalaCondition_dakheli_sell=" AND h_p_code=21";$kalaCondition_varedati_sell=" AND h_p_code=1";}
		 if($x_value=="جو"){$kalaCondition_dakheli=" AND T.code_kala=17";$kalaCondition_varedati=" AND T.code_kala=11";$kalaCondition_dakheli_sell=" AND h_p_code=17";$kalaCondition_varedati_sell=" AND h_p_code=11";}
		 if($x_value=="سویا"){$kalaCondition_dakheli=" AND T.code_kala=20";$kalaCondition_varedati=" AND T.code_kala=2";$kalaCondition_dakheli_sell=" AND h_p_code=20";$kalaCondition_varedati_sell=" AND h_p_code=2";}
		 /****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
         //فیلد اول-حالت داخلی
		  $mande_befor_dakheli=0;
		  $avaliye_dakheli=$db->get_from_where("SUM(mojody_aval)","bzacc.mojody_kala T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND deleted=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	      $jameVarede_befor_dakheli=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND tarikh_resid<'".$date1."' AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
         //تحویل قطعی
	      //$jameSadere_befor_dakheli_ghatee=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<'".$date1."' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
	     //جابهجایی
	      //$darrah_sayer_befor_dakheli=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_movaghat_mj $Condition_anbar_activate $Condition_anbar_activate_mj (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar<'".$date1."' $kalaCondition_dakheli AND($Condition_ostan) AND($Condition_anbar) AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM bzacc.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=$bzActiveYear AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND year=T.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5))) ");
		  $jameSadere_befor_dakheli=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND tarikh_havale_anbar<'".$date1."' AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	      $meghdarTadil_Ezafe_befor_dakheli=$db->get_from_where("SUM(meghdar_tadil)","bzacc.tadil_mojody T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	      $meghdarTadil_Kasry_befor_dakheli=$db->get_from_where("SUM(meghdar_tadil)","bzacc.tadil_mojody T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");     
	      $mande_befor_dakheli=$avaliye_dakheli+$jameVarede_befor_dakheli-$jameSadere_befor_dakheli+$meghdarTadil_Ezafe_befor_dakheli-$meghdarTadil_Kasry_befor_dakheli;	     
          echo'<td class="mande_beforPr">'.virgul($mande_befor_dakheli).'</td>';
		 //فیلد دوم -حالت وارداتی
		  $mande_befor_varedati=0;
		  $avaliye_varedati=$db->get_from_where("SUM(mojody_aval)","bzacc.mojody_kala T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND deleted=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	      $jameVarede_befor_varedati=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND tarikh_resid<'".$date1."' AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
         //تحویل قطعی
	      //$jameSadere_befor_varedati_ghatee=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<'".$date1."' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
	     //جابهجایی
	      //$darrah_sayer_befor_varedati=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_movaghat_mj $Condition_anbar_activate $Condition_anbar_activate_mj (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar<'".$date1."' $kalaCondition_varedati AND($Condition_ostan) AND($Condition_anbar) AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM bzacc.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=$bzActiveYear AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND year=T.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5))) ");		  
		  $jameSadere_befor_varedati=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND tarikh_havale_anbar<'".$date1."' AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	      $meghdarTadil_Ezafe_befor_varedati=$db->get_from_where("SUM(meghdar_tadil)","bzacc.tadil_mojody T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	      $meghdarTadil_Kasry_befor_varedati=$db->get_from_where("SUM(meghdar_tadil)","bzacc.tadil_mojody T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate year='$bzActiveYear' AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");     
	      $mande_befor_varedati=$avaliye_varedati+$jameVarede_befor_varedati-$jameSadere_befor_varedati+$meghdarTadil_Ezafe_befor_varedati-$meghdarTadil_Kasry_befor_varedati;	      
          echo'<td class="mande_beforPr">'.virgul($mande_befor_varedati).'</td>';
		  //فیلد سوم
          $jame_mande_befor_kala=0;
	      $jame_mande_befor_kala=$mande_befor_dakheli+$mande_befor_varedati;
		  echo'<td class="mande_beforPr">'.virgul($jame_mande_befor_kala).'</td>';
		  //فیلد چهارم تا هفتم 
		  $tadil_ezafe_dakheli=$db->get_from_where("SUM(meghdar_tadil)","bzacc.tadil_mojody T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=1 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="tadil_ezafePr">'.virgul($tadil_ezafe_dakheli).'</td>';
		  $tadil_ezafe_varedati=$db->get_from_where("SUM(meghdar_tadil)","bzacc.tadil_mojody T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=1 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="tadil_ezafePr">'.virgul($tadil_ezafe_varedati).'</td>';
		  $tadil_kasry_dakheli=$db->get_from_where("SUM(meghdar_tadil)","bzacc.tadil_mojody T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=2 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="tadil_kasryPr">'.virgul($tadil_kasry_dakheli).'</td>';
		  $tadil_kasry_varedati=$db->get_from_where("SUM(meghdar_tadil)","bzacc.tadil_mojody T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=2 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="tadil_kasryPr">'.virgul($tadil_kasry_varedati).'</td>';
		  //خرید قطعی
		  $kharidghatee_dakheli=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3 OR noe_tahvil_bar=6 OR noe_tahvil_bar=7 OR noe_tahvil_bar=9) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="kharidPr">'.virgul($kharidghatee_dakheli).'</td>';
		  $kharidghatee_varedati=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3 OR noe_tahvil_bar=6 OR noe_tahvil_bar=7 OR noe_tahvil_bar=9) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="kharidPr">'.virgul($kharidghatee_varedati).'</td>';
		  //دریافتی از استانها
		  $daryafti_jabejae_dakheli=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=4 OR noe_tahvil_bar=5) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="daryafti_Pr">'.virgul($daryafti_jabejae_dakheli).'</td>';
		  $daryafti_jabejae_varedati=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=4 OR noe_tahvil_bar=5) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="daryafti_Pr">'.virgul($daryafti_jabejae_varedati).'</td>';
          //دریافتی از بنادر
		  //بندر امام خمینی/بندرانزلی/بندرنوشهر/بندر عباس و بندر امیرآبادوبندر چابهار
		  $daryafti_banader_dakheli=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3 OR noe_tahvil_bar=6 OR noe_tahvil_bar=7) AND (code_mabda=295 OR code_mabda=296 OR code_mabda=297 OR code_mabda=42 OR code_mabda=43 OR code_mabda=294) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="daryafti_bandarPr">'.virgul($daryafti_banader_dakheli).'</td>';
		  $daryafti_banader_varedati=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3 OR noe_tahvil_bar=6 OR noe_tahvil_bar=7) AND (code_mabda=295 OR code_mabda=296 OR code_mabda=297 OR code_mabda=42 OR code_mabda=43 OR code_mabda=294) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="daryafti_bandarPr">'.virgul($daryafti_banader_varedati).'</td>';
		  //برگشت از فروش
	      $bargasht_dakheli=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tahvil_bar=8 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  echo'<td class="bargashtPr">'.virgul($bargasht_dakheli).'</td>';
		  $bargasht_varedati=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tahvil_bar=8 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");		 		  
	      echo'<td class="bargashtPr">'.virgul($bargasht_varedati).'</td>';
		  //تحویل قطعی
		  $tahvilghatee_dakheli=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  $tahvilghatee_dakheli_robari=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN sell.dm_havale ON dm_havale.h_id=T.h_id INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  $tahvilghatee_dakheli_withoutrobari=$tahvilghatee_dakheli-$tahvilghatee_dakheli_robari;
		  
		  $tahvilghatee_varedati=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");		 
		  $tahvilghatee_varedati_robari=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN sell.dm_havale ON dm_havale.h_id=T.h_id INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");		 
		  $tahvilghatee_varedati_withoutrobari=$tahvilghatee_varedati-$tahvilghatee_varedati_robari;
		  echo'<td class="tahvilPr">'.virgul($tahvilghatee_dakheli_withoutrobari).'</td>';
		  echo'<td class="tahvilPr">'.virgul($tahvilghatee_varedati_withoutrobari).'</td>';
		  echo'<td class="tahvilrobariPr">'.virgul($tahvilghatee_dakheli_robari).'</td>';
		  echo'<td class="tahvilrobariPr">'.virgul($tahvilghatee_varedati_robari).'</td>';
		  //کالای در راه ارسالی به سایر انبارها
	      $darrah_sayer_dakheli=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate $Condition_anbar_activate_mj l_a.situation_type=1 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_dakheli  AND($Condition_ostan) AND($Condition_anbar) AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM bzacc.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=$bzActiveYear AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND year=T.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	      echo'<td class="kalaye_darrah_sayerPr">'.virgul($darrah_sayer_dakheli).'</td>';
		  $darrah_sayer_varedati=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate $Condition_anbar_activate_mj l_a.situation_type=1 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_varedati  AND($Condition_ostan) AND($Condition_anbar) AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM bzacc.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=$bzActiveYear AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND year=T.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	      echo'<td class="kalaye_darrah_sayerPr">'.virgul($darrah_sayer_varedati).'</td>';
		  //change
		  //کالای در راه ارسالی به انبارهای موقت
	      $darrah_movaghat_dakheli=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate $Condition_anbar_activate_mj l_a.situation_type=2 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_dakheli  AND($Condition_ostan) AND($Condition_anbar) AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM bzacc.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=$bzActiveYear AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND year=T.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	      echo'<td class="kalaye_darrah_movaghatPr">'.virgul($darrah_movaghat_dakheli).'</td>';
		  $darrah_movaghat_varedati=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate $Condition_anbar_activate_mj l_a.situation_type=2 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_varedati  AND($Condition_ostan) AND($Condition_anbar) AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM bzacc.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=$bzActiveYear AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND year=T.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	      echo'<td class="kalaye_darrah_movaghatPr">'.virgul($darrah_movaghat_varedati).'</td>';
		  //ارسالی به سایر انبارها به غیر از موقتها
	      $ersali_sayer_jabejae_dakheli=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate $Condition_anbar_activate_mj l_a.situation_type=1 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_dakheli AND($Condition_ostan) AND($Condition_anbar)");
	      echo'<td class="ersaly_sayerPr">'.virgul($ersali_sayer_jabejae_dakheli).'</td>';
		  $ersali_sayer_jabejae_varedati=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate $Condition_anbar_activate_mj l_a.situation_type=1 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_varedati AND($Condition_ostan) AND($Condition_anbar)");
	      echo'<td class="ersaly_sayerPr">'.virgul($ersali_sayer_jabejae_varedati).'</td>';
		  //change 
		  //ارسالی به انبارهای موقت
	      $ersali_movaghat_jabejae_dakheli=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate $Condition_anbar_activate_mj l_a.situation_type=2 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_dakheli AND($Condition_ostan) AND($Condition_anbar)");
	      echo'<td class="ersaly_movaghatPr">'.virgul($ersali_movaghat_jabejae_dakheli).'</td>';
		  $ersali_movaghat_jabejae_varedati=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan INNER JOIN bzacc.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN bzacc.list_anbar l_a ON l_a.code_anbar=m_j.code_anbar_maghsad_j AND l_a.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate $Condition_anbar_activate_mj l_a.situation_type=2 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND T.year='$bzActiveYear' AND T.deleted=0 AND T.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_varedati AND($Condition_ostan) AND($Condition_anbar)");
	      echo'<td class="ersaly_movaghatPr">'.virgul($ersali_movaghat_jabejae_varedati).'</td>';
		  //موجودی در فرم انبارگردانی
	      //حالت داخلی
	      $mande_anbargardani_dakheli=$db->get_from_where("SUM(meghdar_anbargardani)","bzacc.bz_anbargardani_detail T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat year='$bzActiveYear' $kalaCondition_dakheli AND($Condition_ostan) AND($Condition_anbar)");
		  //حالت وارداتی
	      $mande_anbargardani_varedati=$db->get_from_where("SUM(meghdar_anbargardani)","bzacc.bz_anbargardani_detail T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat year='$bzActiveYear' $kalaCondition_varedati AND($Condition_ostan) AND($Condition_anbar)");
		  //جمع مانده انبارگردانی
	      $jame_mande_nahayi_kala_anbargardani=0;
	      $jame_mande_nahayi_kala_anbargardani=$mande_anbargardani_dakheli+$mande_anbargardani_varedati;
	      //رسید های انبارگردانی
	      $anbargardani_ezafe_dakheli=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tahvil_bar=10 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
	      $anbargardani_ezafe_varedati=$db->get_from_where("SUM(vazn_khales)","bzacc.resid T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tahvil_bar=10 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
	      //حواله های انبارگردانی
	   	  $anbargardani_kasry_dakheli=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tahvil_bar=10 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
	   	  $anbargardani_kasry_varedati=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tahvil_bar=10 AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");  
		  //مانده موجودی- حالت داخلی
	      $mande_nahayi_dakheli=0;
	      $mande_nahayi_dakheli=$mande_befor_dakheli+$tadil_ezafe_dakheli-$tadil_kasry_dakheli+$kharidghatee_dakheli+$daryafti_jabejae_dakheli+$bargasht_dakheli-$tahvilghatee_dakheli-$ersali_sayer_jabejae_dakheli-$ersali_movaghat_jabejae_dakheli+$anbargardani_ezafe_dakheli-$anbargardani_kasry_dakheli;	  
	      //مانده موجودی- حالت وارداتی
	      $mande_nahayi_varedati=0;
	      $mande_nahayi_varedati=$mande_befor_varedati+$tadil_ezafe_varedati-$tadil_kasry_varedati+$kharidghatee_varedati+$daryafti_jabejae_varedati+$bargasht_varedati-$tahvilghatee_varedati-$ersali_sayer_jabejae_varedati-$ersali_movaghat_jabejae_varedati+$anbargardani_ezafe_varedati-$anbargardani_kasry_varedati;
	      //جمع مانده
	      $jame_mande_nahayi_kala=0;
	      $jame_mande_nahayi_kala=$mande_nahayi_dakheli+$mande_nahayi_varedati;
	      IF(($mande_anbargardani_dakheli!=$mande_nahayi_dakheli)AND($bzActiveYear!=$yy)) $sty_dakheli='style="color:#8C001A;"'; 
	      IF(($mande_anbargardani_varedati!=$mande_nahayi_varedati)AND($bzActiveYear!=$yy)) $sty_varedati='style="color:#FF0080;"'; 
	      IF(($jame_mande_nahayi_kala_anbargardani!=$jame_mande_nahayi_kala)AND($bzActiveYear!=$yy)) $sty_jam='style="color:#FF0000;"';  
		IF($show_movaghat!=3)//موقت ها حواله فروش ندارند
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
		 //مانده از حواله فروش قبل از تاریخ
		 //پیدا کردن آی دی سال مربوط به سیستم فروش
          $sellYearCode=substr($bzActiveYear,2);
          $sellYearId=$db->get_from_where("year_id","sell.dm_year","year_code='$sellYearCode'");
		 /******حالت داخلی******/		 
		  $havale_forush_bef_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province","$Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND h_reg_date<'$date1_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $q_ebtal_bef_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            INNER JOIN sell.dm_location_goods ON h_l_code=l_id
                INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province				
				WHERE $Condition_anbar_activate dm_ebtal_h.ebh_reg_date>='$bzStartDateMi' AND dm_havale.h_reg_date>='$bzStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date<'$date1_milady' $kalaCondition_dakheli_sell AND($Condition_ostan_sell) AND($Condition_anbar_sell)";
		  $res_ebtal_bef_dakheli=$db->query($q_ebtal_bef_dakheli);
	      $meghdar_ebtali_bef_dakheli=$db->fetch_array($res_ebtal_bef_dakheli);	
		  $meghdar_ebtali_befor_dakheli=$meghdar_ebtali_bef_dakheli[0];
		  //روباری
		  $havale_forush_bef_dakheli_robari=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=dm_havale.h_id_province","$Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND h_reg_date<'$date1_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $q_ebtal_bef_dakheli_robari="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            INNER JOIN sell.dm_location_goods ON h_l_code=l_id
			    INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=dm_havale.h_id_province
				WHERE $Condition_anbar_activate dm_ebtal_h.ebh_reg_date>='$bzStartDateMi' AND dm_havale.h_reg_date>='$bzStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date<'$date1_milady' $kalaCondition_dakheli_sell AND($Condition_ostan_sell) AND($Condition_anbar_sell)";
		  $res_ebtal_bef_dakheli_robari=$db->query($q_ebtal_bef_dakheli_robari);
	      $meghdar_ebtali_bef_dakheli_robari=$db->fetch_array($res_ebtal_bef_dakheli_robari);	
		  $meghdar_ebtali_befor_dakheli_robari=$meghdar_ebtali_bef_dakheli_robari[0];
		  
		  $tahvilghatee_befor_dakheli=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<'$date1' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  $tahvilghatee_befor_dakheli_robari=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN sell.dm_havale ON dm_havale.h_id=T.h_id INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<'$date1' $kalaCondition_dakheli and($Condition_ostan) and($Condition_anbar)");
		  $tahvilghatee_befor_dakheli_withoutrobari=$tahvilghatee_befor_dakheli-$tahvilghatee_befor_dakheli_robari;
		  
		  $havale_forush_befor_dakheli=$havale_forush_bef_dakheli-$meghdar_ebtali_befor_dakheli-$tahvilghatee_befor_dakheli_withoutrobari;
		  $havale_forush_befor_dakheli_robari=$havale_forush_bef_dakheli_robari-$meghdar_ebtali_befor_dakheli_robari-$tahvilghatee_befor_dakheli_robari;
		  
		  // $havale_forush_befor_dakheli=0;
		  // $havale_forush_bef_dakheli=0;  
		  // $q_forush_befor_dakheli=("SELECT h_id,h_code,h_pre_amount,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province WHERE $Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND  h_reg_date<'$date1_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  // $res_forush_befor_dakheli=$db->query($q_forush_befor_dakheli);
		  // while($row_forush_befor_dakheli=$db->fetch_array($res_forush_befor_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  // {
		   // //پیدا کردن کد استان از روی آی دی
            // $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_befor_dakheli['h_id_province']."");
           // //پیدا کردن کد انباراز روی آی دی
            // $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor_dakheli['h_id_province']." AND l_id=".$row_forush_befor_dakheli['h_l_code']."");  
			// /**///محاسبه کل تحویلی برای این حواله
            // //$meghdar_tahvily_per1=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale","h_code=".$row_forush_befor_dakheli['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year=$bzActiveYear AND deleted=0 AND status=0");
	        // /**///محاسبه کل باطله برای این حواله
			// //$meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_befor_dakheli['h_id']."");
	        // //$havale_forush_bef_dakheli=$row_forush_befor_dakheli['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
			// $havale_forush_bef_dakheli=$row_forush_befor_dakheli['h_pre_amount'];//از فیلد فروش استفاده شده
			// /**///محاسبه مقدار مانده از حواله فروش
 	        // //مقدار کل ابطالی ها قبل از تاریخ
	        // $q_ebtal_befor_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                // INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                // INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                // INNER JOIN sell.dm_location_goods ON h_l_code=l_id
					// INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province
					// WHERE $Condition_anbar_activate his_p_code=".$row_forush_befor_dakheli['h_p_code']." AND his_h_code=".$row_forush_befor_dakheli['h_code']." AND h_id_province=".$row_forush_befor_dakheli['h_id_province']." AND h_l_code=".$row_forush_befor_dakheli['h_l_code']." AND h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	        // $res_ebtal_befor_dakheli=$db->query($q_ebtal_befor_dakheli);
	        // $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_dakheli);	        
	        // //حواله جنسی قبل از تاریخ
	        // $sadere_befor=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale","h_code=".$row_forush_befor_dakheli['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<'$date1'");
	        // //محاسبه مقدار حواله فروش قبل از تاریخ
		    // $havale_forush_befor_per_dakheli=$havale_forush_bef_dakheli-$sadere_befor-$meghdar_ebtali_befor[0];
			// $havale_forush_befor_dakheli+=$havale_forush_befor_per_dakheli;
		  // }
		  /******حالت وارداتی******/		 	  
		  $havale_forush_bef_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province","$Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND h_reg_date<'$date1_milady' $kalaCondition_varedati_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  
		  $q_ebtal_bef_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            INNER JOIN sell.dm_location_goods ON h_l_code=l_id 
				INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province
				WHERE $Condition_anbar_activate dm_ebtal_h.ebh_reg_date>='$bzStartDateMi' AND dm_havale.h_reg_date>='$bzStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date<'$date1_milady' $kalaCondition_varedati_sell AND($Condition_ostan_sell) AND($Condition_anbar_sell)";
		  $res_ebtal_bef_varedati=$db->query($q_ebtal_bef_varedati);
	      $meghdar_ebtali_bef_varedati=$db->fetch_array($res_ebtal_bef_varedati);	
		  $meghdar_ebtali_befor_varedati=$meghdar_ebtali_bef_varedati[0];
		  //روباری
		  $havale_forush_bef_varedati_robari=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=dm_havale.h_id_province","$Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND h_reg_date<'$date1_milady' $kalaCondition_varedati_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $q_ebtal_bef_varedati_robari="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            INNER JOIN sell.dm_location_goods ON h_l_code=l_id 
			    INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=dm_havale.h_id_province
				WHERE $Condition_anbar_activate dm_ebtal_h.ebh_reg_date>='$bzStartDateMi' AND dm_havale.h_reg_date>='$bzStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date<'$date1_milady' $kalaCondition_varedati_sell AND($Condition_ostan_sell) AND($Condition_anbar_sell)";
		  $res_ebtal_bef_varedati_robari=$db->query($q_ebtal_bef_varedati_robari);
	      $meghdar_ebtali_bef_varedati_robari=$db->fetch_array($res_ebtal_bef_varedati_robari);	
		  $meghdar_ebtali_befor_varedati_robari=$meghdar_ebtali_bef_varedati_robari[0];
		  
		  $tahvilghatee_befor_varedati=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=T.code_anbar AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<'$date1' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
		  $tahvilghatee_befor_varedati_robari=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale T INNER JOIN sell.dm_havale ON dm_havale.h_id=T.h_id INNER JOIN bzacc.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate (noe_tahvil_bar=1 OR noe_tahvil_bar=2) AND year='$bzActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<'$date1' $kalaCondition_varedati and($Condition_ostan) and($Condition_anbar)");
		  $tahvilghatee_befor_varedati_withoutrobari=$tahvilghatee_befor_varedati-$tahvilghatee_befor_varedati_robari;
		  $havale_forush_befor_varedati=$havale_forush_bef_varedati-$meghdar_ebtali_befor_varedati-$tahvilghatee_befor_varedati_withoutrobari;
		  $havale_forush_befor_varedati_robari=$havale_forush_bef_varedati_robari-$meghdar_ebtali_befor_varedati_robari-$tahvilghatee_befor_varedati_robari;
		  

		 //مقدار کل حواله فروش ها مابین تاریخ
		 /******حالت داخلی******/		 	  
		  $havale_forush_between_dakheli1=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province","$Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $havale_forush_between_dakheli_robari=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=dm_havale.h_id_province","$Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $havale_forush_between_dakheli=$havale_forush_between_dakheli1+$havale_forush_between_dakheli_robari;
		  
		  // $havale_forush_bet_per1=0;
          // $havale_forush_between_dakheli=0;
		  // $q_forush_dakheli=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province WHERE $Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_dakheli_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  // $res_forush_dakheli=$db->query($q_forush_dakheli);
		  // while($row_forush_dakheli=$db->fetch_array($res_forush_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  // {
		   // //پیدا کردن کد استان از روی آی دی
            // $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_dakheli['h_id_province']."");
           // //پیدا کردن کد انباراز روی آی دی
            // $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_dakheli['h_id_province']." AND l_id=".$row_forush_dakheli['h_l_code']."");  
		   // /**///محاسبه کل تحویلی برای این حواله
            // $meghdar_tahvily_per2=$db->get_from_where("SUM(vazn_khales_h)","bzacc.havale","h_code=".$row_forush_dakheli['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year=$bzActiveYear AND deleted=0 AND status=0");
	        // /**///محاسبه کل باطله برای این حواله
			// $meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_dakheli['h_id']."");
	        // $havale_forush_bet_per1=$row_forush_dakheli['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
			// $havale_forush_between_dakheli+=$havale_forush_bet_per1;
		  // }
		  /******حالت وارداتی******/		 	  
		  $havale_forush_between_varedati1=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province","$Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_varedati_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
		  $havale_forush_between_varedati_robari=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=dm_havale.h_id_province","$Condition_anbar_activate h_id_year='$sellYearId' AND h_reg_date>='$bzStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_varedati_sell and($Condition_ostan_sell) and($Condition_anbar_sell)");
          $havale_forush_between_varedati=$havale_forush_between_varedati1+$havale_forush_between_varedati_robari;
		  //مقدار کل ابطالی ها مابین تاریخ
	       /******حالت داخلی******/		 	  
		   $q_ebtal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            INNER JOIN sell.dm_location_goods ON h_l_code=l_id 
				INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province
				WHERE $Condition_anbar_activate dm_ebtal_h.ebh_reg_date>='$bzStartDateMi' AND dm_havale.h_reg_date>='$bzStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_dakheli_sell AND($Condition_ostan_sell) AND($Condition_anbar_sell)";
		   $res_ebtal_dakheli=$db->query($q_ebtal_dakheli);
	       $meghdar_ebtali_dakheli=$db->fetch_array($res_ebtal_dakheli);
		   $meghdar_ebtali_between_dakheli=$meghdar_ebtali_dakheli[0];
		   //روباری
		   $q_ebtal_dakheli_robari="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            INNER JOIN sell.dm_location_goods ON h_l_code=l_id 
			    INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=dm_havale.h_id_province 
				WHERE $Condition_anbar_activate dm_ebtal_h.ebh_reg_date>='$bzStartDateMi' AND dm_havale.h_reg_date>='$bzStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_dakheli_sell AND($Condition_ostan_sell) AND($Condition_anbar_sell)";
		   $res_ebtal_dakheli_robari=$db->query($q_ebtal_dakheli_robari);
	       $meghdar_ebtali_dakheli_robari=$db->fetch_array($res_ebtal_dakheli_robari);		   
		   $meghdar_ebtali_between_dakheli_robari=$meghdar_ebtali_dakheli_robari[0];
		   /******حالت وارداتی******/		 	  
		   $q_ebtal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
				INNER JOIN sell.dm_location_goods ON h_l_code=l_id
				INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_location_goods.l_code AND list_anbar.code_ostan=dm_location_goods.l_id_province
				WHERE $Condition_anbar_activate dm_ebtal_h.ebh_reg_date>='$bzStartDateMi' AND dm_havale.h_reg_date>='$bzStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_varedati_sell AND($Condition_ostan_sell) AND($Condition_anbar_sell)";
		   $res_ebtal_varedati=$db->query($q_ebtal_varedati);
	       $meghdar_ebtali_varedati=$db->fetch_array($res_ebtal_varedati);	
		   $meghdar_ebtali_between_varedati=$meghdar_ebtali_varedati[0];
		   //روباری
		   $q_ebtal_varedati_robari="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
				INNER JOIN sell.dm_location_goods ON h_l_code=l_id
			    INNER JOIN $mydatabase.list_anbar ON list_anbar.code_anbar=dm_havale.h_robari_code AND list_anbar.code_ostan=dm_havale.h_id_province 
				WHERE $Condition_anbar_activate dm_ebtal_h.ebh_reg_date>='$bzStartDateMi' AND dm_havale.h_reg_date>='$bzStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_varedati_sell AND($Condition_ostan_sell) AND($Condition_anbar_sell)";
		   $res_ebtal_varedati_robari=$db->query($q_ebtal_varedati_robari);
	       $meghdar_ebtali_varedati_robari=$db->fetch_array($res_ebtal_varedati_robari);
		   $meghdar_ebtali_between_varedati_robari=$meghdar_ebtali_varedati_robari[0];
	      //مانده حواله فروش
           $mande_forush_dakheli=$havale_forush_befor_dakheli+$havale_forush_between_dakheli1-$meghdar_ebtali_between_dakheli-$tahvilghatee_dakheli_withoutrobari;		 
           $mande_forush_varedati=$havale_forush_befor_varedati+$havale_forush_between_varedati1-$meghdar_ebtali_between_varedati-$tahvilghatee_varedati_withoutrobari;		 
           
	       //مانده حواله فروش روباری
	       $mande_forush_dakheli_robari=$havale_forush_befor_dakheli_robari+$havale_forush_between_dakheli_robari-$meghdar_ebtali_between_dakheli_robari-$tahvilghatee_dakheli_robari;		 
           $mande_forush_varedati_robari=$havale_forush_befor_varedati_robari+$havale_forush_between_varedati_robari-$meghdar_ebtali_between_varedati_robari-$tahvilghatee_varedati_robari;		 
	   
          //جمع مانده حواله فروش
	       $jame_mande_forush=0;
	       $jame_mande_forush=$mande_forush_dakheli+$mande_forush_varedati;
		   $jame_mande_forush_robari=0;
	       $jame_mande_forush_robari=$mande_forush_dakheli_robari+$mande_forush_varedati_robari;
	   
		} 
		//مانده موجودی پس از کسر حواله فروش
           $mande_pasazkasr_dakheli=$mande_nahayi_dakheli-$mande_forush_dakheli; 	   
           $mande_pasazkasr_varedati=$mande_nahayi_varedati-$mande_forush_varedati; 	   
           $mande_pasazkasr=$mande_pasazkasr_dakheli+$mande_pasazkasr_varedati; 

		 //نمایش اطلاعات
		 echo' 
		  <!--<td class="kasry_kolPr">'.virgul($kasry_kol_dakheli).'</td>
		      <td class="kasry_kolPr">'.virgul($kasry_kol_varedati).'</td>
		      <td class="kasry_gheyrPr">'.virgul($kasry_gheyremojaz_dakheli).'</td>
		      <td class="kasry_gheyrPr">'.virgul($kasry_gheyremojaz_varedati).'</td>-->
		  <td class="forushPr">'.virgul($havale_forush_between_dakheli1).'</td>
		  <td class="forushPr">'.virgul($havale_forush_between_varedati1).'</td>
		  <td class="forushrobariPr">'.virgul($havale_forush_between_dakheli_robari).'</td>
		  <td class="forushrobariPr">'.virgul($havale_forush_between_varedati_robari).'</td>
		  <td class="ebtalyPr">'.virgul($meghdar_ebtali_between_dakheli).'</td>
		  <td class="ebtalyPr">'.virgul($meghdar_ebtali_between_varedati).'</td>
		  <td class="ebtalyrobariPr">'.virgul($meghdar_ebtali_between_dakheli_robari).'</td>
		  <td class="ebtalyrobariPr">'.virgul($meghdar_ebtali_between_varedati_robari).'</td>
		  <td class="mande_forushPr">'.virgul($mande_forush_dakheli).'</td>
		  <td class="mande_forushPr">'.virgul($mande_forush_varedati).'</td>
		  <td class="mande_forushPr">'.virgul($jame_mande_forush).'</td>
		  <td class="mande_forushrobariPr">'.virgul($mande_forush_dakheli_robari).'</td>
		  <td class="mande_forushrobariPr">'.virgul($mande_forush_varedati_robari).'</td>
		  <td class="mande_forushrobariPr">'.virgul($jame_mande_forush_robari).'</td>
		  <td '.$sty_dakheli.' class="mande_anbargardaniPr">'.virgul($mande_anbargardani_dakheli).'</td>
		  <td '.$sty_varedati.' class="mande_anbargardaniPr">'.virgul($mande_anbargardani_varedati).'</td>
		  <td '.$sty_jam.' class="mande_anbargardaniPr">'.virgul($jame_mande_nahayi_kala_anbargardani).'</td>
		  <td class="anbargardani_ezafePr">'.virgul($anbargardani_ezafe_dakheli).'</td>
		  <td class="anbargardani_ezafePr">'.virgul($anbargardani_ezafe_varedati).'</td>
		  <td class="anbargardani_kasryPr">'.virgul($anbargardani_kasry_dakheli).'</td>
		  <td class="anbargardani_kasryPr">'.virgul($anbargardani_kasry_varedati).'</td>
		  <td '.$sty_dakheli.' class="mandePr">'.virgul($mande_nahayi_dakheli).'</td>
		  <td '.$sty_varedati.' class="mandePr">'.virgul($mande_nahayi_varedati).'</td>
		  <td '.$sty_jam.' class="mandePr">'.virgul($jame_mande_nahayi_kala).'</td>
		  <td class="mande_pasaz_kasrPr">'.virgul($mande_pasazkasr_dakheli).'</td>
		  <td class="mande_pasaz_kasrPr">'.virgul($mande_pasazkasr_varedati).'</td>
		  <td class="mande_pasaz_kasrPr">'.virgul($mande_pasazkasr).'</td>
	    </tr>';
	    $jame_mande_befor_dakheli+=$mande_befor_dakheli;
	    $jame_mande_befor_varedati+=$mande_befor_varedati;
	    $jame_mande_befor+=$jame_mande_befor_kala;
		$jame_kharidghatee_dakheli+=$kharidghatee_dakheli;
	    $jame_tadil_ezafe_dakheli+=$tadil_ezafe_dakheli;
	    $jame_tadil_ezafe_varedati+=$tadil_ezafe_varedati;
	    $jame_tadil_kasry_dakheli+=$tadil_kasry_dakheli;
	    $jame_tadil_kasry_varedati+=$tadil_kasry_varedati;
		$jame_kharidghatee_varedati+=$kharidghatee_varedati;
	    $jame_daryafti_jabejae_dakheli+=$daryafti_jabejae_dakheli;
	    $jame_daryafti_jabejae_varedati+=$daryafti_jabejae_varedati;
	    $jame_daryafti_banader_dakheli+=$daryafti_banader_dakheli;
	    $jame_daryafti_banader_varedati+=$daryafti_banader_varedati;
	    $jame_bargasht_dakheli+=$bargasht_dakheli;
	    $jame_bargasht_varedati+=$bargasht_varedati;
		$jame_tahvilghatee_dakheli_withoutrobari+=$tahvilghatee_dakheli_withoutrobari;
	    $jame_tahvilghatee_varedati_withoutrobari+=$tahvilghatee_varedati_withoutrobari;
	    $jame_tahvilghatee_dakheli_robari+=$tahvilghatee_dakheli_robari;
	    $jame_tahvilghatee_varedati_robari+=$tahvilghatee_varedati_robari;
	    $jame_darrah_sayer_dakheli+=$darrah_sayer_dakheli;
	    $jame_darrah_sayer_varedati+=$darrah_sayer_varedati;
	    $jame_darrah_movaghat_dakheli+=$darrah_movaghat_dakheli;
	    $jame_darrah_movaghat_varedati+=$darrah_movaghat_varedati;
		$jame_ersali_sayer_jabejae_dakheli+=$ersali_sayer_jabejae_dakheli;
	    $jame_ersali_sayer_jabejae_varedati+=$ersali_sayer_jabejae_varedati;
	    $jame_ersali_movaghat_jabejae_dakheli+=$ersali_movaghat_jabejae_dakheli;
	    $jame_ersali_movaghat_jabejae_varedati+=$ersali_movaghat_jabejae_varedati;
		$jame_kasry_kol_dakheli+=$kasry_kol_dakheli;
	    $jame_kasry_kol_varedati+=$kasry_kol_varedati;
	    $jame_kasry_gheyremojaz_dakheli+=$kasry_gheyremojaz_dakheli;
	    $jame_kasry_gheyremojaz_varedati+=$kasry_gheyremojaz_varedati;
	    $jame_havale_forush_between_dakheli1+=$havale_forush_between_dakheli1;
	    $jame_havale_forush_between_varedati1+=$havale_forush_between_varedati1;
	    $jame_havale_forush_between_dakheli_robari+=$havale_forush_between_dakheli_robari;
	    $jame_havale_forush_between_varedati_robari+=$havale_forush_between_varedati_robari;
	    $jame_meghdar_ebtali_between_dakheli+=$meghdar_ebtali_between_dakheli;
	    $jame_meghdar_ebtali_between_varedati+=$meghdar_ebtali_between_varedati;
		$jame_meghdar_ebtali_between_dakheli_robari+=$meghdar_ebtali_between_dakheli_robari;
	    $jame_meghdar_ebtali_between_varedati_robari+=$meghdar_ebtali_between_varedati_robari;
	    $jame_mande_forush_dakheli+=$mande_forush_dakheli;
	    $jame_mande_forush_varedati+=$mande_forush_varedati;
	    $jame_mande_forush_kol+=$jame_mande_forush;
	    $jame_mande_forush_dakheli_robari+=$mande_forush_dakheli_robari;
	    $jame_mande_forush_varedati_robari+=$mande_forush_varedati_robari;
	    $jame_mande_forush_kol_robari+=$jame_mande_forush_robari;
		$jame_mande_anbargardani_dakheli+=$mande_anbargardani_dakheli;
		$jame_mande_anbargardani_varedati+=$mande_anbargardani_varedati;
		$jame_mande_nahayi_anbargardani+=$jame_mande_nahayi_kala_anbargardani;
	    $jame_anbargardani_ezafe_dakheli+=$anbargardani_ezafe_dakheli;
		$jame_anbargardani_ezafe_varedati+=$anbargardani_ezafe_varedati;
		$jame_anbargardani_kasry_dakheli+=$anbargardani_kasry_dakheli;
		$jame_anbargardani_kasry_varedati+=$anbargardani_kasry_varedati;
		$jame_mande_nahayi_dakheli+=$mande_nahayi_dakheli;
	    $jame_mande_nahayi_varedati+=$mande_nahayi_varedati;
		$jame_mande_nahayi+=$jame_mande_nahayi_kala;
	    $jame_mande_pasazkasr_dakheli+=$mande_pasazkasr_dakheli;
	    $jame_mande_pasazkasr_varedati+=$mande_pasazkasr_varedati;
	    $jame_mande_pasazkasr+=$mande_pasazkasr;
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
	 }//END foreach
	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="2">جمع کل (کیلوگرم)</td>
	    <td class="mande_beforPr">'.virgul($jame_mande_befor_dakheli).'</td>
	    <td class="mande_beforPr">'.virgul($jame_mande_befor_varedati).'</td>
	    <td class="mande_beforPr">'.virgul($jame_mande_befor).'</td>
	    <td class="tadil_ezafePr">'.virgul($jame_tadil_ezafe_dakheli).'</td>
	    <td class="tadil_ezafePr">'.virgul($jame_tadil_ezafe_varedati).'</td>
	    <td class="tadil_kasryPr">'.virgul($jame_tadil_kasry_dakheli).'</td>
	    <td class="tadil_kasryPr">'.virgul($jame_tadil_kasry_varedati).'</td>
	    <td class="kharidPr">'.virgul($jame_kharidghatee_dakheli).'</td>
	    <td class="kharidPr">'.virgul($jame_kharidghatee_varedati).'</td>
	    <td class="daryafti_Pr">'.virgul($jame_daryafti_jabejae_dakheli).'</td>
	    <td class="daryafti_Pr">'.virgul($jame_daryafti_jabejae_varedati).'</td>
	    <td class="daryafti_bandarPr">'.virgul($jame_daryafti_banader_dakheli).'</td>
	    <td class="daryafti_bandarPr">'.virgul($jame_daryafti_banader_varedati).'</td>
	    <td class="bargashtPr">'.virgul($jame_bargasht_dakheli).'</td>
	    <td class="bargashtPr">'.virgul($jame_bargasht_varedati).'</td>
	    <td class="tahvilPr">'.virgul($jame_tahvilghatee_dakheli_withoutrobari).'</td>
	    <td class="tahvilPr">'.virgul($jame_tahvilghatee_varedati_withoutrobari).'</td>
	    <td class="tahvilrobariPr">'.virgul($jame_tahvilghatee_dakheli_robari).'</td>
	    <td class="tahvilrobariPr">'.virgul($jame_tahvilghatee_varedati_robari).'</td>
	    <td class="kalaye_darrah_sayerPr">'.virgul($jame_darrah_sayer_dakheli).'</td>
	    <td class="kalaye_darrah_sayerPr">'.virgul($jame_darrah_sayer_varedati).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.virgul($jame_darrah_movaghat_dakheli).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.virgul($jame_darrah_movaghat_varedati).'</td>
		<td class="ersaly_sayerPr">'.virgul($jame_ersali_sayer_jabejae_dakheli).'</td>
	    <td class="ersaly_sayerPr">'.virgul($jame_ersali_sayer_jabejae_varedati).'</td>
	    <td class="ersaly_movaghatPr">'.virgul($jame_ersali_movaghat_jabejae_dakheli).'</td>
	    <td class="ersaly_movaghatPr">'.virgul($jame_ersali_movaghat_jabejae_varedati).'</td>
	    <!--<td class="kasry_kolPr">'.virgul($jame_kasry_kol_dakheli).'</td>
	        <td class="kasry_kolPr">'.virgul($jame_kasry_kol_varedati).'</td>
            <td class="kasry_gheyrPr">'.virgul($jame_kasry_gheyremojaz_dakheli).'</td>
	        <td class="kasry_gheyrPr">'.virgul($jame_kasry_gheyremojaz_varedati).'</td>-->
	    <td class="forushPr">'.virgul($jame_havale_forush_between_dakheli1).'</td>
	    <td class="forushPr">'.virgul($jame_havale_forush_between_varedati1).'</td>
		<td class="forushrobariPr">'.virgul($jame_havale_forush_between_dakheli_robari).'</td>
	    <td class="forushrobariPr">'.virgul($jame_havale_forush_between_varedati_robari).'</td>
	    <td class="ebtalyPr">'.virgul($jame_meghdar_ebtali_between_dakheli).'</td>
	    <td class="ebtalyPr">'.virgul($jame_meghdar_ebtali_between_varedati).'</td>
	    <td class="ebtalyrobariPr">'.virgul($jame_meghdar_ebtali_between_dakheli_robari).'</td>
	    <td class="ebtalyrobariPr">'.virgul($jame_meghdar_ebtali_between_varedati_robari).'</td>
		<td class="mande_forushPr">'.virgul($jame_mande_forush_dakheli).'</td>
	    <td class="mande_forushPr">'.virgul($jame_mande_forush_varedati).'</td>
	    <td class="mande_forushPr">'.virgul($jame_mande_forush_kol).'</td>
		<td class="mande_forushrobariPr">'.virgul($jame_mande_forush_dakheli_robari).'</td>
	    <td class="mande_forushrobariPr">'.virgul($jame_mande_forush_varedati_robari).'</td>
	    <td class="mande_forushrobariPr">'.virgul($jame_mande_forush_kol_robari).'</td>
		<td class="mande_anbargardaniPr">'.virgul($jame_mande_anbargardani_dakheli).'</td>
		<td class="mande_anbargardaniPr">'.virgul($jame_mande_anbargardani_varedati).'</td>
		<td class="mande_anbargardaniPr">'.virgul($jame_mande_nahayi_anbargardani).'</td>	
	    <td class="anbargardani_ezafePr">'.virgul($jame_anbargardani_ezafe_dakheli).'</td>
	    <td class="anbargardani_ezafePr">'.virgul($jame_anbargardani_ezafe_varedati).'</td>
	    <td class="anbargardani_kasryPr">'.virgul($jame_anbargardani_kasry_dakheli).'</td>
	    <td class="anbargardani_kasryPr">'.virgul($jame_anbargardani_kasry_varedati).'</td>
	    <td class="mandePr">'.virgul($jame_mande_nahayi_dakheli).'</td>
	    <td class="mandePr">'.virgul($jame_mande_nahayi_varedati).'</td>
	    <td class="mandePr">'.virgul($jame_mande_nahayi).'</td>
	    <td class="mande_pasaz_kasrPr">'.virgul($jame_mande_pasazkasr_dakheli).'</td>
	    <td class="mande_pasaz_kasrPr">'.virgul($jame_mande_pasazkasr_varedati).'</td>
	    <td class="mande_pasaz_kasrPr">'.virgul($jame_mande_pasazkasr).'</td>
	 </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
   <tr class="print_footer noExl">
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$bzuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
}
echo'
</div>	
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript">
   function doNow(ch)
   { if(ch=="on") ck=1; else ck=0;
   void(d=document);
   void(el=d.getElementsByTagName("INPUT"));
   for(i=0;i<el.length;i++)
   void(el[i].checked=ck)
   if(ch=="on") ch="off"; else if(ch=="off")ch="on";
   return ch;
   }
$(function(){	    
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