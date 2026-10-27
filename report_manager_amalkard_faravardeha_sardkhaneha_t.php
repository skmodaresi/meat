<?php
require_once __DIR__ . '/mysql_compat.php';
//این گزارش برای سایر کاربران در لوکال به خاطر وجود کوئری های فروش اررور دارد در هاست درست است
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_amalkard_faravardeha_sardkhaneha_t.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش اطلاعات عملکرد فرآورده ها به تفکیک استان و سردخانه';
require_once('head.html');
//پیدا کردن آی دی سال مربوط به سیستم فروش
$sellYearCode=substr($mtActiveYear,2);
$sellYearId=$db->get_from_where("year_id","sell.dm_year","year_code='$sellYearCode'");
$columns='
	<tr class="print_table-title2 print_table-title_small">
     <td width="%" rowspan="2">ردیف</td>
     <td width="%" rowspan="2">استان</td>
     <td width="%" rowspan="2">سردخانه</td>
     <td width="%" rowspan="2">کالا</td>
     <td width="%" class="mande_beforPr" colspan="3">مانده موجودی از قبل</td>
     <td width="%" class="tadil_ezafePr" colspan="2">تعدیل (اضافه)</td>
     <td width="%" class="tadil_kasryPr" colspan="2">تعدیل (کسری)</td>
     <td width="%" class="kharidPr" colspan="2">خرید قطعی</td>
     <td width="%" class="daryafti_Pr" colspan="2">دریافتی از سایر استانها</td>
      <!--<td width="%" class="daryafti_movaghatPr" colspan="2">دریافتی از سردخانه موقت</td>-->
     <td width="%" class="daryafti_bandarPr" colspan="2">دریافتی از بنادر</td>
     <td width="%" class="daryafti_khososiPr" colspan="2">دریافتی از بخش خصوصی</td>
	 <td width="%" class="bargashtPr" colspan="2">برگشت از فروش</td>
     <td width="%" class="tahvilPr" colspan="2">تحویل قطعی</td>
	 <td width="%" class="kalaye_darrah_sayerPr" colspan="2">کالای در راه به سایر سردخانه ها</td>
	 <td width="%" class="kalaye_darrah_movaghatPr" colspan="2">کالای در راه به موقت</td>
     <td width="%" class="ersaly_sayerPr" colspan="2">ارسالی به سایر سردخانه ها</td>
     <td width="%" class="ersaly_movaghatPr" colspan="2">ارسالی به موقت</td>
	 <td width="%" class="ersaly_amaniPr" colspan="2">ارسالی امانی</td>
	 <td width="%" class="ersaly_khososiPr" colspan="2">ارسالی بخش خصوصی</td>
     <td width="%" class="kasry_kolPr" colspan="2">کل کسری</td>
     <td width="%" class="kasry_gheyrPr" colspan="2">کسری غیرمجاز</td>
     <td width="%" class="forushPr" colspan="2">حواله فروش</td>
     <td width="%" class="ebtalyPr" colspan="2">ابطالی حواله فروش</td>
     <td width="%" class="mande_forushPr" colspan="3">مانده حواله فروش</td>
	 <td width="%" class="mande_anbargardaniPr" colspan="3">مانده موجودی درفرم انبارگردانی</td>
     <td width="%" class="mandePr" colspan="3">مانده موجودی</td>
     <td width="%" class="mande_pasaz_kasrPr" colspan="3">مانده موجودی پس از کسر حواله فروش و افت وکسری</td>
	 <td width="%" class="ezafe_oftokasryPr" colspan="2">مطروحه در کمیسیون افت و کسری (اضافه)</td>
     <td width="%" class="kasry_oftokasryPr" colspan="2">مطروحه در کمیسیون افت و کسری (کسری)</td>
	</tr>
    <tr class="print_table-title2 print_table-title_small">
	  <td class="mande_beforPr">داخلی</td><td class="mande_beforPr">وارداتی</td><td class="mande_beforPr">جمع</td>
	  <td class="tadil_ezafePr">داخلی</td><td class="tadil_ezafePr">وارداتی</td>
	  <td class="tadil_kasryPr">داخلی</td><td class="tadil_kasryPr">وارداتی</td>
	  <td class="kharidPr">داخلی</td><td class="kharidPr">وارداتی</td>
	  <td class="daryafti_Pr">داخلی</td><td class="daryafti_Pr">وارداتی</td>
	  <!--<td class="daryafti_movaghatPr">داخلی</td><td class="daryafti_movaghatPr">وارداتی</td>-->
	  <td class="daryafti_bandarPr">داخلی</td><td class="daryafti_bandarPr">وارداتی</td>
	  <td class="daryafti_khososiPr">داخلی</td><td class="daryafti_khososiPr">وارداتی</td>
	  <td class="bargashtPr">داخلی</td><td class="bargashtPr">وارداتی</td>
	  <td class="tahvilPr">داخلی</td><td class="tahvilPr">وارداتی</td>
	  <td class="kalaye_darrah_sayerPr">داخلی</td><td class="kalaye_darrah_sayerPr">وارداتی</td>
	  <td class="kalaye_darrah_movaghatPr">داخلی</td><td class="kalaye_darrah_movaghatPr">وارداتی</td>
	  <td class="ersaly_sayerPr">داخلی</td><td class="ersaly_sayerPr">وارداتی</td>
	  <td class="ersaly_movaghatPr">داخلی</td><td class="ersaly_movaghatPr">وارداتی</td>
	  <td class="ersaly_amaniPr">داخلی</td><td class="ersaly_amaniPr">وارداتی</td>
	  <td class="ersaly_khososiPr">داخلی</td><td class="ersaly_khososiPr">وارداتی</td>
	  <td class="kasry_kolPr">داخلی</td><td class="kasry_kolPr">وارداتی</td>
	  <td class="kasry_gheyrPr">داخلی</td><td class="kasry_gheyrPr">وارداتی</td>
	  <td class="forushPr">داخلی</td><td class="forushPr">وارداتی</td>
	  <td class="ebtalyPr">داخلی</td><td class="ebtalyPr">وارداتی</td>
	  <td class="mande_forushPr">داخلی</td><td class="mande_forushPr">وارداتی</td><td class="mande_forushPr">جمع</td>
	  <td class="mande_anbargardaniPr">داخلی</td><td class="mande_anbargardaniPr">وارداتی</td><td class="mande_anbargardaniPr">جمع</td>
	  <td class="mandePr">داخلی</td><td class="mandePr">وارداتی</td><td class="mandePr">جمع</td>
	  <td class="mande_pasaz_kasrPr">داخلی</td><td class="mande_pasaz_kasrPr">وارداتی</td><td class="mande_pasaz_kasrPr">جمع</td>
	  <td class="ezafe_oftokasryPr">داخلی</td><td class="ezafe_oftokasryPr">وارداتی</td>
	  <td class="kasry_oftokasryPr">داخلی</td><td class="kasry_oftokasryPr">وارداتی</td>
	 </tr>';
/****************هدر******************/
Function print_header()
{global $titr,$mt_gl_owner,$date1,$date2,$FileName,$page;
 echo'
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr class="noExl"><td class="print_title_2" colspan="60">'.$mt_gl_owner.'</td></tr>
    <tr class="noExl"><td class="print_title_2" colspan="60">'.$titr.'
     <span style="float:left;"><button  class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></span>
	 </td>
	</tr>
	<tr '; IF($page!=1) echo 'class="noExl"'; echo'>
	 <td class="print_title_2" colspan="60">';
	    IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
         echo'
	     <span>از تاریخ : '.$date1.' تا تاریخ : '.$date2.' &nbsp&nbsp(صفحه : '.$page.')</span>
	  </td>
     </tr>';
	 IF($page==1){
       echo'
	    <tr class="noExl">
	     <td class="print_title" colspan="60">
          خرید قطعی شامل :تخلیه در سردخانه،تحویل روباری و حمل با راه آهن <br>
          تحویل قطعی شامل : بارگیری از سردخانه، تحویل روباری و حمل باراه آهن <br>
           دریافتی از بنادر شامل : اسکه بندر امام خمینی و اسکله شهید رجایی <br>
		   واحد کالا های گوشت گاو ، گوسفند ، مرغ و تخم مرغ کیلوگرم و کنسرو مرغ عدد است <br>
           دقت کنید در صورتیکه تیک نمایش اطلاعات سردخانه های غیرفعال را بردارید حواله هایی که به مقصد 
		   سردخانه های غیرفعال زده شده باشند در محاسبات گزارش در نظر گرفته نمی شود.
		  </td>
	    </tr>';
	 }
}
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
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_mj="";  $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND"; $Condition_anbar_activate_mj="l_s.activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=1;
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
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>	
	 <td align="left"> تعداد استان در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left" height="40px"> وضعیت نمایش سردخانه های موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='text4'").'</td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
    <tr class="tr1">
     <td align="left" height="160px">گروه کالا : </td>
     <td align="right">
	  &nbsp;<select name="groupkalachoice[]" size="7" style="font-family:bYekan;width:130px;" multiple>
	  <option value="همه" selected>همه کالاها</option>';
	  foreach($kalagroupArr as $grp_key=>$grp_val)
	  {echo '<option value="'.$grp_val.'" >'.$grp_val.'</option>';}
	  echo'
	  </select>
	  <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  &nbsp;
	 </td>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" size="7" style="font-family:bYekan;width:200px;" multiple>';
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
//استانها
$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan) AND($Condition_ostan) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
 <br>
  <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
   <tr class="print_table-title2"><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
   <tr class="print_table-title2">
		 <td width="5%" rowspan="2">مانده موجودی از قبل</td>
	     <td width="5%" colspan="2">تعدیل</td>
	     <td width="5%" rowspan="2">خرید قطعی</td>
	     <td width="5%" colspan="2">دریافتی از</td>
		 <td width="5%" rowspan="2">دریافتی از بخش خصوصی</td>
	     <td width="5%" rowspan="2">برگشت از فروش</td>
	     <td width="5%" rowspan="2">تحویل قطعی</td>
	     <td width="5%" colspan="2">کالای در راه</td>
		 <td width="5%" rowspan="2">ارسالی به سایر سردخانه ها</td>
		 <td width="5%" rowspan="2">ارسالی به موقت</td>
		 <td width="5%" rowspan="2">ارسالی امانی</td>
		 <td width="5%" rowspan="2">ارسالی بخش خصوصی</td>
		 <td width="5%" rowspan="2">کل کسری</td>
		 <td width="5%" rowspan="2">کسری غیر مجاز</td>
		 <td width="5%" rowspan="2">حواله فروش</td>
	     <td width="5%" rowspan="2">ابطالی حواله فروش</td>
	     <td width="5%" rowspan="2">مانده حواله فروش</td>
		 <td width="5%" rowspan="2">مانده موجودی در فرم انبارگردانی</td>
	     <td width="5%" rowspan="2">مانده موجودی</td>
	     <td width="5%" rowspan="2">مانده موجودی پس از کسر حواله فروش و افت وکسری</td>
		 <td width="5%" colspan="2">مطروحه در کمیسیون افت و کسری</td>
   </tr>
   <tr class="print_table-title2">
		 <td>اضافه</td>
		 <td>کسری</td>
		 <td>سایر استانها</td>
	     <td>بنادر</td>
		 <td>به سایر سردخانه ها</td>
	     <td>به موقت</td>
		 <td>اضافه</td>
		 <td>کسری</td>
   </tr>   
   <tr class="print_table-title2">
	     <td><input name="mande_beforPr" type="checkbox" checked ></td>
	     <td><input name="tadil_ezafePr" type="checkbox" checked ></td>
	     <td><input name="tadil_kasryPr" type="checkbox" checked ></td>
	     <td><input name="kharidPr" type="checkbox" checked ></td>
	     <td><input name="daryafti_Pr" type="checkbox" checked ></td>
	     <td><input name="daryafti_bandarPr" type="checkbox" checked ></td>
	     <td><input name="daryafti_khososiPr" type="checkbox" checked ></td>
	     <td><input name="bargashtPr" type="checkbox" checked ></td>
	     <td><input name="tahvilPr" type="checkbox" checked ></td>
	     <td><input name="kalaye_darrah_sayerPr" type="checkbox" checked ></td>
	     <td><input name="kalaye_darrah_movaghatPr" type="checkbox" checked ></td>
	     <td><input name="ersaly_sayerPr" type="checkbox" checked ></td>
	     <td><input name="ersaly_movaghatPr" type="checkbox" checked ></td>
		 <td><input name="ersaly_amaniPr" type="checkbox" checked ></td>
		 <td><input name="ersaly_khososiPr" type="checkbox" checked ></td>
	     <td><input name="kasry_kolPr" type="checkbox"  ></td>
	     <td><input name="kasry_gheyrPr" type="checkbox"  ></td>
	     <td><input name="forushPr" type="checkbox" checked ></td>
	     <td><input name="ebtalyPr" type="checkbox" checked ></td>
	     <td><input name="mande_forushPr" type="checkbox" checked ></td>
		 <td><input name="mande_anbargardaniPr" type="checkbox" ';IF($mtActiveYear!=$yy) echo' checked'; echo' ></td>
	     <td><input name="mandePr" type="checkbox" checked ></td>
	     <td><input name="mande_pasaz_kasrPr" type="checkbox" checked ></td>
		 <td><input name="ezafe_oftokasryPr" type="checkbox"></td>
		 <td><input name="kasry_oftokasryPr" type="checkbox"></td>
   </tr>	
 </table>
 <div class="table2excel">';
 print_header();
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
 if($show_movaghat==1) $filter_string.=' بدون اطلاعات سردخانه موقت';
 else if($show_movaghat==2) $filter_string.=' با اطلاعات سردخانه موقت';
 else if($show_movaghat==3) $filter_string.=' فقط اطلاعات سردخانه موقت';
 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
 if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
 if(is_array($groupkalachoice))
 {
 	$filter_string.=' گروه کالا : ';
 	foreach($groupkalachoice as $grp_val) 
 	{
 	  if($grp_val=="همه"){$filter_string.=' همه کالاها ';break;}
 	  else $filter_string.=''.$grp_val.'&nbsp;';
    }
 }
 if($noe_namayesh==1) $filter_string.="نمایش اطلاعات : خالص";
 if($noe_namayesh==2) $filter_string.="نمایش اطلاعات : ناخالص";
 if($noe_namayesh==3) $filter_string.="نمایش اطلاعات : تعداد";
  echo'<tr class="noExl"><td class="filter_text" colspan="60">فیلتر شده براساس : '.$filter_string.'</td></tr>';
  echo $columns;
  while($row=$db->fetch_array($res))//حلقه استانها
  {	
    $line++;
	//تعداد انبار ها
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","$Condition_anbar_activate $Condition_movaghat code_ostan=".$row['code_ostan']."");//تعداد انبارهای هر استان 
	else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای هر استان     
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
	  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM list_sardkhane WHERE  $Condition_anbar_activate $Condition_movaghat code_ostan=".$row['code_ostan']."";
	  else $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE  $Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."";
	  $res2=$db->query($q2);
	  while($row2=$db->fetch_assoc($res2))//حلقه انبارها
	  {	   
	   $j=$i+1;
	   $t2=$rowgrkala;
	   echo'<td rowspan="'.$rowgrkala.'">'.$row2['name_anbar'].'</td>';
	   //echo'<td >'.$row2['name_anbar'].'</td>';
	    foreach($grpkalaArrChoice as $x => $x_value )//حلقه گروه کالا 
        {
	      $sty_dakheli='';
	      $sty_varedati='';
	      $sty_jam='';
		  $k=$i+1;
		  echo'
	      <td>'.$x_value.'</td>';	  
		  if($x_value=="گوشت گاو")
	      {
	        //dakheli:81,82,83,84,85,86
	        $kalaCondition_dakheli=" AND (T.code_kala=81 OR T.code_kala=82 OR T.code_kala=83 OR T.code_kala=84 OR T.code_kala=85 OR T.code_kala=86)";
	        $kalaCondition_resid_d_dakheli=" AND (r_d.code_kala=81 OR r_d.code_kala=82 OR r_d.code_kala=83 OR r_d.code_kala=84 OR r_d.code_kala=85 OR r_d.code_kala=86)";
	        $kalaCondition_dakheli_sell=" AND (h_p_code=81 OR h_p_code=82 OR h_p_code=83 OR h_p_code=84 OR h_p_code=85 OR h_p_code=86)";
	        //varedati:72,73,74,75,76,78,77,79,92
	        $kalaCondition_varedati=" AND (T.code_kala=72 OR T.code_kala=73 OR T.code_kala=74 OR T.code_kala=75 OR T.code_kala=76 OR T.code_kala=77 OR T.code_kala=78 OR T.code_kala=79 OR T.code_kala=92)";
	        $kalaCondition_resid_d_varedati=" AND (r_d.code_kala=72 OR r_d.code_kala=73 OR r_d.code_kala=74 OR r_d.code_kala=75 OR r_d.code_kala=76 OR r_d.code_kala=77 OR r_d.code_kala=78 OR r_d.code_kala=79 OR r_d.code_kala=92)";
	        $kalaCondition_varedati_sell=" AND (h_p_code=72	OR h_p_code=73 OR h_p_code=74 OR h_p_code=75 OR h_p_code=76 OR h_p_code=77 OR h_p_code=78 OR h_p_code=79 OR h_p_code=92)";
	        $bastebandy=1;
	      }
	      if($x_value=="گوشت گوسفند")
	      {
	        //dakheli:144,148,149,150,151,88
	        $kalaCondition_dakheli=" AND (T.code_kala=144 OR T.code_kala=148 OR T.code_kala=149 OR T.code_kala=150 OR T.code_kala=151 OR T.code_kala=88)";
	        $kalaCondition_resid_d_dakheli=" AND (r_d.code_kala=144 OR r_d.code_kala=148 OR r_d.code_kala=149 OR r_d.code_kala=150 OR r_d.code_kala=151 OR r_d.code_kala=88)";
	        $kalaCondition_dakheli_sell=" AND (h_p_code=144 OR h_p_code=148 OR h_p_code=149 OR h_p_code=150 OR h_p_code=151 OR h_p_code=88)";
	        //varedati:87
	        $kalaCondition_varedati=" AND (T.code_kala=87)";
	        $kalaCondition_resid_d_varedati=" AND (r_d.code_kala=87)";
	        $kalaCondition_varedati_sell=" AND (h_p_code=87)";	 
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
 	        //dakheli:54
	        $kalaCondition_dakheli=" AND T.code_kala=54";
	        $kalaCondition_resid_d_dakheli=" AND r_d.code_kala=54";
	        $kalaCondition_dakheli_sell=" AND h_p_code=54";
		    //varedati:50
	        $kalaCondition_varedati=" AND T.code_kala=50";
	        $kalaCondition_resid_d_varedati=" AND r_d.code_kala=50";
	        $kalaCondition_varedati_sell=" AND h_p_code=50";
	        $bastebandy=1;
	      }
		  if($x_value=="تخم مرغ صنعتی")
          {
 	        //dakheli:dont exist
	        $kalaCondition_dakheli=" AND 1!=1";
	        $kalaCondition_resid_d_dakheli=" AND 1!=1";
	        $kalaCondition_dakheli_sell=" AND 1!=1";
		    //varedati:51
	        $kalaCondition_varedati=" AND T.code_kala=51";
	        $kalaCondition_resid_d_varedati=" AND r_d.code_kala=51";
	        $kalaCondition_varedati_sell=" AND h_p_code=51";
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
	      //تبدیل کداستان به آی دی برای کوئری های فروش
          $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$row['code_ostan']."");	
	      //تبدیل کدانبار به آی دی برای کوئری های فروش
		  $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=".$sell_id_ostan." AND l_code=".$row2['code_anbar']."");	
		  IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';$anbargardaniField='khales_anbargardani';$oftokasryField='meghdar_khales_oftokasry';$vahed='کیلوگرم';}
	      ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';$anbargardaniField='nakhales_anbargardani';$oftokasryField='meghdar_nakhales_oftokasry';$vahed='کیلوگرم';}
	      ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';$anbargardaniField='tedad_anbargardani';$oftokasryField='tedad_oftokasry';$vahed='تعداد';}				 
	      ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';$anbargardaniField='shane_anbargardani';$oftokasryField='tedad_shane_oftokasry';$vahed='شانه';}

	      /****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
          //فیلد اول-حالت داخلی
	       $mande_befor_dakheli=0;
	       $avaliye_dakheli=$db->get_from_where("SUM($avalField)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_dakheli");     	  
		   $jameVarede_befor_dakheli=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_dakheli ");
		   $jameSadere_befor_dakheli=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_dakheli");	
		  //حواله های قطعی
	       //$jameSadere_befor_dakheli_ghatee=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_dakheli");	
		  //جابهجایی بین مناطق
	       //$ersali_jabejae_dakheli_befor=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_movaghat_mj $Condition_anbar_activate_mj (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_dakheli");
		  //حواله های جابه جایی امانی
	       //$jabejae_amani_dakheli_befor=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=5) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_dakheli");	
		   $meghdarTadil_Ezafe_befor_dakheli=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_dakheli");     
	       $meghdarTadil_Kasry_befor_dakheli=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_dakheli");     
		   $mande_befor_dakheli=$avaliye_dakheli+$jameVarede_befor_dakheli-$jameSadere_befor_dakheli+$meghdarTadil_Ezafe_befor_dakheli-$meghdarTadil_Kasry_befor_dakheli;	      
		  //فیلد دوم -حالت وارداتی
	       $mande_befor_varedati=0;
	       $avaliye_varedati=$db->get_from_where("SUM($avalField)","meat.mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 $kalaCondition_varedati and($Condition_anbar)");     
	       $jameVarede_befor_varedati=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' $kalaCondition_varedati ");
           $jameSadere_befor_varedati=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_varedati");	
		  //حواله های قطعی
	       //$jameSadere_befor_varedati_ghatee=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_varedati");	
	      //جابهجایی بین مناطق
	       //$ersali_jabejae_varedati_befor=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_movaghat_mj $Condition_anbar_activate_mj (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_varedati");           
	      //حواله های جابه جایی امانی 
		   //$jabejae_amani_varedati_befor=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=5) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' $kalaCondition_varedati");	
		   $meghdarTadil_Ezafe_befor_varedati=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=1 AND deleted=0 AND status=0 $kalaCondition_varedati ");     
	       $meghdarTadil_Kasry_befor_varedati=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND tarikh_barge_tadil<'".$date1."' AND noe_tadil=2 AND deleted=0 AND status=0 $kalaCondition_varedati ");              
	       $mande_befor_varedati=$avaliye_varedati+$jameVarede_befor_varedati-$jameSadere_befor_varedati+$meghdarTadil_Ezafe_befor_varedati-$meghdarTadil_Kasry_befor_varedati;	      
          //فیلد سوم
	       $jame_mande_befor_kala=0;
	       $jame_mande_befor_kala=$mande_befor_dakheli+$mande_befor_varedati;
	       //فیلد چهارم تا هفتم 
	       $tadil_ezafe_dakheli=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_dakheli ");
	       $tadil_ezafe_varedati=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_varedati ");
	       $tadil_kasry_dakheli=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_dakheli ");
	       $tadil_kasry_varedati=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' $kalaCondition_varedati ");
	       //فیلد هشتم خرید قطعی
	       $kharidghatee_dakheli=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat  (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_dakheli ");
	       $kharidghatee_varedati=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_varedati ");
	       //دریافتی از استانها
	       $daryafti_jabejae_dakheli=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_dakheli ");
	       $daryafti_jabejae_varedati=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_varedati ");
	       //دریافتی از بنادر
	       //56:اسکله شهید رجایی
	       //57:اسکله بندر امام خمینی
	       $daryafti_banader_dakheli=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND (r.code_mabda=56 OR r.code_mabda=57) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_dakheli ");
	       $daryafti_banader_varedati=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND (r.code_mabda=56 OR r.code_mabda=57) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_varedati ");
	       //دریافتی از بخش خصوصی
	       $daryafti_khososi_dakheli=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat r.noe_tahvil_bar=7 AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_dakheli ");
	       $daryafti_khososi_varedati=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat r.noe_tahvil_bar=7 AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_varedati ");
		   //برگشت از فروش
	       $bargasht_dakheli=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat r.noe_tahvil_bar=6 AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_dakheli ");
	       $bargasht_varedati=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat r.noe_tahvil_bar=6 AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' $kalaCondition_varedati ");
	       //تحویل قطعی
	       $tahvilghatee_dakheli=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_dakheli ");
	       $tahvilghatee_varedati=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_varedati ");
	       //کالای در راه ارسالی به سایر سردخانه ها
	       $darrah_sayer_dakheli=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate_mj l_s.situation_type=1 AND (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_dakheli AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM meat.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=T.year AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
		   $darrah_sayer_varedati=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate_mj l_s.situation_type=1 AND (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_varedati AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM meat.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=T.year AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");  
	       //کالای در راه ارسالی به سردخانه های موقت
	       //if($show_movaghat==1){$darrah_movaghat_dakheli=0;$darrah_movaghat_varedati=0;}
	       //else
	       //{
		     $darrah_movaghat_dakheli=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate_mj l_s.situation_type=2 AND (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_dakheli  AND($Condition_anbar) AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM meat.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=T.year AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	         $darrah_movaghat_varedati=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate_mj l_s.situation_type=2 AND (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_varedati  AND($Condition_anbar) AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM meat.resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND year=T.year AND code_ostan=m_j.code_ostan_maghsad_j AND code_anbar=m_j.code_anbar_maghsad_j AND shomare_havale_anbar=T.shomare_havale_anbar AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	       //}	 
		   //ارسالی به سایر سردخانه ها به غیر از موقتها
	       $ersali_sayer_jabejae_dakheli=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate_mj l_s.situation_type=1 AND (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_dakheli ");
	       $ersali_sayer_jabejae_varedati=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate_mj l_s.situation_type=1 AND (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_varedati ");
		   //ارسالی به سردخانه های موقت
	       //if($show_movaghat==1){$ersali_movaghat_jabejae_dakheli=0;$ersali_movaghat_jabejae_varedati=0;}
	       //else
	       //{
	         $ersali_movaghat_jabejae_dakheli=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate_mj l_s.situation_type=2 AND (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_dakheli ");
	         $ersali_movaghat_jabejae_varedati=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_anbar_activate_mj l_s.situation_type=2 AND (h.noe_tahvil_bar=4) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_varedati ");
		   //}
		   //حواله های جابه جایی امانی
	        $jabejae_amani_dakheli=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=5) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_dakheli");
	        $jabejae_amani_varedati=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=5) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_varedati");
           //حواله های جابه جایی بخش خصوصی
	        $jabejae_khososi_dakheli=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=7) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_dakheli");
	        $jabejae_khososi_varedati=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat (h.noe_tahvil_bar=7) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' $kalaCondition_varedati");
           
		   //موجودی در فرم انبارگردانی
	       //مانده موجودی- حالت داخلی
	        $mande_anbargardani_dakheli=$db->get_from_where("SUM($anbargardaniField)","$mydatabase.mt_anbargardani_detail T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." $kalaCondition_dakheli");

		   //مانده موجودی- حالت وارداتی
	        $mande_anbargardani_varedati=$db->get_from_where("SUM($anbargardaniField)","$mydatabase.mt_anbargardani_detail T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." $kalaCondition_varedati");
	       //جمع مانده
	        $jame_mande_nahayi_kala_anbargardani=0;
	        $jame_mande_nahayi_kala_anbargardani=$mande_anbargardani_dakheli+$mande_anbargardani_varedati;
	  	 /**************************نوع نمایش خالص**********************************/
	     if($noe_namayesh==1)
	     {     
	      IF($show_movaghat!=3)//موقت ها حواله فروش ندارند
	      {
		   //اطلاعات حواله فروش
	       if(($x_value=="کنسرو مرغ")OR($x_value=="تخم مرغ خوراکی"))
	       {$havale_forush_between_dakheli=0;$havale_forush_between_varedati=0;$meghdar_ebtali_between_dakheli=0;$meghdar_ebtali_between_varedati=0;$mande_forush_dakheli=0;$mande_forush_varedati=0;$jame_mande_forush=0;}
	       //به غیر از کنسرو و تخم مرغ خوراکی
	       else
	       {
	     	//مانده از حواله فروش قبل از تاریخ
            /******حالت داخلی******/		 
	     	$havale_forush_befor_dakheli=0;
            $havale_forush_bef_dakheli=0;
	     	$q_forush_befor_dakheli=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_reg_date>='$mtStartDateMi' AND  h_reg_date<'$date1_milady' $kalaCondition_dakheli_sell");
	     	$res_forush_befor_dakheli=$db->query($q_forush_befor_dakheli);
	     	while($row_forush_befor_dakheli=$db->fetch_array($res_forush_befor_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	     	{
              //پیدا کردن کد انباراز روی آی دی
               //$code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor_dakheli['h_id_province']." AND l_id=".$row_forush_befor_dakheli['h_l_code']."");  
		   	  /**///محاسبه کل تحویلی برای این حواله
               $meghdar_tahvily_per1=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","h_code=".$row_forush_befor_dakheli['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	           /**///محاسبه کل باطله برای این حواله
		       $meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_befor_dakheli['h_id']." AND his_h_code=".$row_forush_befor_dakheli['h_code']."");
	           $havale_forush_bef_dakheli=$row_forush_befor_dakheli['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
		   	 /**///محاسبه مقدار مانده از حواله فروش
 	           //مقدار کل ابطالی ها قبل از تاریخ
	           $q_ebtal_befor_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                WHERE his_p_code=".$row_forush_befor_dakheli['h_p_code']." AND his_h_code=".$row_forush_befor_dakheli['h_code']." AND h_id_province=".$row_forush_befor_dakheli['h_id_province']." AND h_l_code=".$row_forush_befor_dakheli['h_l_code']." AND h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	           $res_ebtal_befor_dakheli=$db->query($q_ebtal_befor_dakheli);
	           $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_dakheli);	        
	           //حواله جنسی قبل از تاریخ
	           $sadere_befor=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.h_code=".$row_forush_befor_dakheli['h_code']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");
	           //محاسبه مقدار حواله فروش قبل از تاریخ
		       $havale_forush_befor_per_dakheli=$havale_forush_bef_dakheli-$sadere_befor-$meghdar_ebtali_befor[0];
			   $havale_forush_befor_dakheli+=$havale_forush_befor_per_dakheli;
		    }
		    /******حالت وارداتی******/		 	  
		    $havale_forush_befor_varedati=0;
            $havale_forush_bef_varedati=0;
			$q_forush_befor_varedati=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_reg_date>='$mtStartDateMi' AND  h_reg_date<'$date1_milady' $kalaCondition_varedati_sell");
			$res_forush_befor_varedati=$db->query($q_forush_befor_varedati);
		    while($row_forush_befor_varedati=$db->fetch_array($res_forush_befor_varedati))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		    {
              //پیدا کردن کد انباراز روی آی دی
               //$code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor_varedati['h_id_province']." AND l_id=".$row_forush_befor_varedati['h_l_code']."");  
		      /**///محاسبه کل تحویلی برای این حواله
               $meghdar_tahvily_per1=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","h_code=".$row_forush_befor_varedati['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	          /**///محاسبه کل باطله برای این حواله
		   	   //$meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code=".$row_forush_befor_varedati['h_code']." AND his_id_province=".$row_forush_befor_varedati['h_id_province']." AND his_l_code=".$row_forush_befor_varedati['h_l_code']." AND h_id_year='$sellYearId'");
		   	   $meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_befor_varedati['h_id']." AND his_h_code=".$row_forush_befor_varedati['h_code']."");
	           $havale_forush_bef_varedati=$row_forush_befor_varedati['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
		   	 /**///محاسبه مقدار مانده از حواله فروش
		   	//مقدار کل ابطالی هل قبل از تاریخ
	           $q_ebtal_befor_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                   INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                   INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                   WHERE his_p_code=".$row_forush_befor_varedati['h_p_code']." AND his_h_code=".$row_forush_befor_varedati['h_code']." AND h_id_province=".$row_forush_befor_varedati['h_id_province']." AND h_l_code=".$row_forush_befor_varedati['h_l_code']." AND h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	           $res_ebtal_befor_varedati=$db->query($q_ebtal_befor_varedati);
	           $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_varedati); 
		     	//حواله جنسی قبل از تاریخ
	           $sadere_befor=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.h_code=".$row_forush_befor_varedati['h_code']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");
	           //محاسبه مقدار حواله فروش قبل از تاریخ
		       $havale_forush_befor_per_varedati=$havale_forush_bef_varedati-$sadere_befor-$meghdar_ebtali_befor[0];
		   	   $havale_forush_befor_varedati+=$havale_forush_befor_per_varedati;
		    }
		    //مقدار کل حواله فروش ها مابین تاریخ
		    /******حالت داخلی******/		 	  
		     $havale_forush_bet_per1=0;
             $havale_forush_between_dakheli=0;
		     $q_forush_dakheli=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_dakheli_sell");
		     $res_forush_dakheli=$db->query($q_forush_dakheli);
		     while($row_forush_dakheli=$db->fetch_array($res_forush_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		     {
              //پیدا کردن کد انباراز روی آی دی
               //$code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_dakheli['h_id_province']." AND l_id=".$row_forush_dakheli['h_l_code']."");  
		      /**///محاسبه کل تحویلی برای این حواله
               $meghdar_tahvily_per2=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","h_code=".$row_forush_dakheli['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	           /**///محاسبه کل باطله برای این حواله
		   	   $meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_dakheli['h_id']." AND his_h_code=".$row_forush_dakheli['h_code']."");
	           $havale_forush_bet_per1=$row_forush_dakheli['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
		   	   $havale_forush_between_dakheli+=$havale_forush_bet_per1;
		     }
	     	  /******حالت وارداتی******/		 	  
	     	  $havale_forush_bet_per2=0;
              $havale_forush_between_varedati=0;
	     	  $q_forush_varedati=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_varedati_sell");
			  $res_forush_varedati=$db->query($q_forush_varedati);
	     	  while($row_forush_varedati=$db->fetch_array($res_forush_varedati))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	     	  {
                //پیدا کردن کد انباراز روی آی دی
                //$code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_varedati['h_id_province']." AND l_id=".$row_forush_varedati['h_l_code']."");  
	     	   /**///محاسبه کل تحویلی برای این حواله
	     		$meghdar_tahvily_per2=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","h_code=".$row_forush_varedati['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
				/**///محاسبه کل باطله برای این حواله
	     		$meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_varedati['h_id']." AND his_h_code=".$row_forush_varedati['h_code']."");
				$havale_forush_bet_per2=$row_forush_varedati['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
	     		$havale_forush_between_varedati+=$havale_forush_bet_per2;
	     	  }
	     	  //مقدار کل ابطالی ها مابین تاریخ
	            /******حالت داخلی******/		 	  
	     	   $q_ebtal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                 INNER JOIN sell.dm_havale ON sell.dm_his_havale.his_h_id=dm_havale.h_id
	                 INNER JOIN sell.dm_ebtal_h ON sell.dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                 WHERE h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_dakheli_sell";
	     	   $res_ebtal_dakheli=$db->query($q_ebtal_dakheli);
	           $meghdar_ebtali_dakheli=$db->fetch_array($res_ebtal_dakheli);	
	     	   $meghdar_ebtali_between_dakheli=$meghdar_ebtali_dakheli[0];
	     	   /******حالت وارداتی******/		 	  
	     	   $q_ebtal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                 INNER JOIN sell.dm_havale ON sell.dm_his_havale.his_h_id=dm_havale.h_id
	                 INNER JOIN sell.dm_ebtal_h ON sell.dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                 WHERE h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_varedati_sell";
			   $res_ebtal_varedati=$db->query($q_ebtal_varedati);
	           $meghdar_ebtali_varedati=$db->fetch_array($res_ebtal_varedati);	
	     	   $meghdar_ebtali_between_varedati=$meghdar_ebtali_varedati[0];
	           //مانده حواله فروش
               $mande_forush_dakheli=$havale_forush_befor_dakheli+$havale_forush_between_dakheli-$meghdar_ebtali_between_dakheli-$tahvilghatee_dakheli;		 
               $mande_forush_varedati=$havale_forush_befor_varedati+$havale_forush_between_varedati-$meghdar_ebtali_between_varedati-$tahvilghatee_varedati;		 
		   	   //جمع مانده حواله فروش
	           $jame_mande_forush=0;
	           $jame_mande_forush=$mande_forush_dakheli+$mande_forush_varedati;
		   }//END else gheyr az konserv
		  }
         }//END noe_namayesh khales
	      /**************************نوع نمایش ناخالص**********************************/
	      if($noe_namayesh==2)
	      {
	        //فیلد های حواله فروش همه صفر 
	        $havale_forush_between_dakheli=0;$havale_forush_between_varedati=0;$meghdar_ebtali_between_dakheli=0;$meghdar_ebtali_between_varedati=0;$mande_forush_dakheli=0;$mande_forush_varedati=0;$jame_mande_forush=0;
          }//END noe_namayesh nakhales
          /**************************نوع نمایش تعداد**********************************/
	      if($noe_namayesh==3)
	      {
			if($x_value!="کنسرو مرغ")
	        {$havale_forush_between_dakheli=0;$havale_forush_between_varedati=0;$meghdar_ebtali_between_dakheli=0;$meghdar_ebtali_between_varedati=0;$mande_forush_dakheli=0;$mande_forush_varedati=0;$jame_mande_forush=0;}
	         //اگر کنسرو باشد
	        else
	        {
	        	//مانده از حواله فروش قبل از تاریخ
	        	/******حالت داخلی******/		 
	        	$havale_forush_befor_dakheli=0;
                $havale_forush_bef_dakheli=0;
	        	$q_forush_befor_dakheli=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_reg_date>='$mtStartDateMi' AND  h_reg_date<'$date1_milady' $kalaCondition_dakheli_sell");
	        	$res_forush_befor_dakheli=$db->query($q_forush_befor_dakheli);
	        	while($row_forush_befor_dakheli=$db->fetch_array($res_forush_befor_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	        	{
                   //پیدا کردن کد انباراز روی آی دی
                    //$code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor_dakheli['h_id_province']." AND l_id=".$row_forush_befor_dakheli['h_l_code']."");  
		        	/**///محاسبه کل تحویلی برای این حواله
                    $meghdar_tahvily_per1=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","h_code=".$row_forush_befor_dakheli['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	                /**///محاسبه کل باطله برای این حواله
		        	$meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_befor_dakheli['h_id']." AND his_h_code=".$row_forush_befor_dakheli['h_code']."");
	                $havale_forush_bef_dakheli=$row_forush_befor_dakheli['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
		        	 /**///محاسبه مقدار مانده از حواله فروش
 	                //مقدار کل ابطالی ها قبل از تاریخ
	                $q_ebtal_befor_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                        INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                        INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                        WHERE his_p_code=".$row_forush_befor_dakheli['h_p_code']." AND his_h_code=".$row_forush_befor_dakheli['h_code']." AND h_id_province=".$row_forush_befor_dakheli['h_id_province']." AND h_l_code=".$row_forush_befor_dakheli['h_l_code']." AND h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	                $res_ebtal_befor_dakheli=$db->query($q_ebtal_befor_dakheli);
	                $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_dakheli);	        
	                //حواله جنسی قبل از تاریخ
	                $sadere_befor=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.h_code=".$row_forush_befor_dakheli['h_code']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");
	                //محاسبه مقدار حواله فروش قبل از تاریخ
		            $havale_forush_befor_per_dakheli=$havale_forush_bef_dakheli-$sadere_befor-$meghdar_ebtali_befor[0];
			        $havale_forush_befor_dakheli+=$havale_forush_befor_per_dakheli;
		        }
		        /******حالت وارداتی******/		 	  
		         $havale_forush_befor_varedati=0;
                 $havale_forush_bef_varedati=0;
		         $q_forush_befor_varedati=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_reg_date>='$mtStartDateMi' AND  h_reg_date<'$date1_milady' $kalaCondition_varedati_sell");
		         $res_forush_befor_varedati=$db->query($q_forush_befor_varedati);
		         while($row_forush_befor_varedati=$db->fetch_array($res_forush_befor_varedati))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		         {
                  //پیدا کردن کد انباراز روی آی دی
                   //$code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor_varedati['h_id_province']." AND l_id=".$row_forush_befor_varedati['h_l_code']."");  
		          /**///محاسبه کل تحویلی برای این حواله
                   $meghdar_tahvily_per1=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","h_code=".$row_forush_befor_varedati['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	              /**///محاسبه کل باطله برای این حواله
		       	   $meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_befor_varedati['h_id']." AND his_h_code=".$row_forush_befor_varedati['h_code']."");
	               $havale_forush_bef_varedati=$row_forush_befor_varedati['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
		       	 /**///محاسبه مقدار مانده از حواله فروش
		        	//مقدار کل ابطالی هل قبل از تاریخ
	              $q_ebtal_befor_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                      INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                      INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                      WHERE his_p_code=".$row_forush_befor_varedati['h_p_code']." AND his_h_code=".$row_forush_befor_varedati['h_code']." AND h_id_province=".$row_forush_befor_varedati['h_id_province']." AND h_l_code=".$row_forush_befor_varedati['h_l_code']." AND h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	              $res_ebtal_befor_varedati=$db->query($q_ebtal_befor_varedati);
	              $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_varedati); 
		      	 //حواله جنسی قبل از تاریخ
	              $sadere_befor=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.h_code=".$row_forush_befor_varedati['h_code']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");
	              //محاسبه مقدار حواله فروش قبل از تاریخ
		          $havale_forush_befor_per_varedati=$havale_forush_bef_varedati-$sadere_befor-$meghdar_ebtali_befor[0];
		      	  $havale_forush_befor_varedati+=$havale_forush_befor_per_varedati;
		        }
	        	 //مقدار کل حواله فروش ها مابین تاریخ
	        	 /******حالت داخلی******/		 	  
	        	  $havale_forush_bet_per1=0;
                  $havale_forush_between_dakheli=0;
	        	  $q_forush_dakheli=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_dakheli_sell");
	        	  $res_forush_dakheli=$db->query($q_forush_dakheli);
	        	  while($row_forush_dakheli=$db->fetch_array($res_forush_dakheli))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	        	  {
                   //پیدا کردن کد انباراز روی آی دی
                    //$code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_dakheli['h_id_province']." AND l_id=".$row_forush_dakheli['h_l_code']."");  
	        	   /**///محاسبه کل تحویلی برای این حواله
	        	   	$db->selectDb($mydatabase);
                    $meghdar_tahvily_per2=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","h_code=".$row_forush_dakheli['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	                /**///محاسبه کل باطله برای این حواله
	         		$meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_dakheli['h_id']." AND his_h_code=".$row_forush_dakheli['h_code']."");
	                $havale_forush_bet_per1=$row_forush_dakheli['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
	         		$havale_forush_between_dakheli+=$havale_forush_bet_per1;
	         	  }
	         	  /******حالت وارداتی******/		 	  
	         	  $havale_forush_bet_per2=0;
                  $havale_forush_between_varedati=0;
	         	  $q_forush_varedati=("SELECT h_id,h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale WHERE  h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_varedati_sell");
	         	  $res_forush_varedati=$db->query($q_forush_varedati);
	         	  while($row_forush_varedati=$db->fetch_array($res_forush_varedati))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	        	  {
                   //پیدا کردن کد انباراز روی آی دی
                    //$code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_varedati['h_id_province']." AND l_id=".$row_forush_varedati['h_l_code']."");  
	        	   /**///محاسبه کل تحویلی برای این حواله
	        		$meghdar_tahvily_per2=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","h_code=".$row_forush_varedati['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	               /**///محاسبه کل باطله برای این حواله
	        		$meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_id=".$row_forush_varedati['h_id']." AND his_h_code=".$row_forush_varedati['h_code']."");
	                $havale_forush_bet_per2=$row_forush_varedati['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
	        		$havale_forush_between_varedati+=$havale_forush_bet_per2;
	        	  }
	        	  //مقدار کل ابطالی ها مابین تاریخ
	               /******حالت داخلی******/		 	  
	        	   $q_ebtal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                    INNER JOIN sell.dm_havale ON sell.dm_his_havale.his_h_id=dm_havale.h_id
	                    INNER JOIN sell.dm_ebtal_h ON sell.dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                    WHERE  h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_dakheli_sell ";
	        	   $res_ebtal_dakheli=$db->query($q_ebtal_dakheli);
	               $meghdar_ebtali_dakheli=$db->fetch_array($res_ebtal_dakheli);	
		           $meghdar_ebtali_between_dakheli=$meghdar_ebtali_dakheli[0];
		          /******حالت وارداتی******/		 	  
		          $q_ebtal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                   INNER JOIN sell.dm_havale ON sell.dm_his_havale.his_h_id=dm_havale.h_id
	                   INNER JOIN sell.dm_ebtal_h ON sell.dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                   WHERE  h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_varedati_sell ";
		          $res_ebtal_varedati=$db->query($q_ebtal_varedati);
	              $meghdar_ebtali_varedati=$db->fetch_array($res_ebtal_varedati);	
		          $meghdar_ebtali_between_varedati=$meghdar_ebtali_varedati[0];
	             //مانده حواله فروش
                  $mande_forush_dakheli=$havale_forush_befor_dakheli+$havale_forush_between_dakheli-$meghdar_ebtali_between_dakheli-$tahvilghatee_dakheli;		 
                  $mande_forush_varedati=$havale_forush_befor_varedati+$havale_forush_between_varedati-$meghdar_ebtali_between_varedati-$tahvilghatee_varedati;		 
		    	 //جمع مانده حواله فروش
	              $jame_mande_forush=0;
	              $jame_mande_forush=$mande_forush_dakheli+$mande_forush_varedati;
			}//END else konserv
          }//END noe_namayesh tedad
          //مطروحه در کمیسیون افت و کسری (اضافه)
	      //داخلی
	      //$oftokasry_ezafe_dakheli=$db->get_from_where("SUM($oftokasryField)","$mydatabase.mojavez_oftokasry T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_oftokasry=1 AND chktaeed=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 AND status=0 AND tarikh_nameh>='$date1' AND tarikh_nameh<='$date2' $kalaCondition_dakheli ");	 
	      $oftokasry_ezafe_dakheli=$db->get_from_where("SUM($oftokasryField)","$mydatabase.mojavez_oftokasry T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_oftokasry=1 AND chktaeed=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 AND status=0 $kalaCondition_dakheli ");	 
	      //وارداتی
	      $oftokasry_ezafe_varedati=$db->get_from_where("SUM($oftokasryField)","$mydatabase.mojavez_oftokasry T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_oftokasry=1 AND chktaeed=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 AND status=0 $kalaCondition_varedati ");	 
          //مطروحه در کمیسیون افت و کسری (کسری)
	      //داخلی
	      $oftokasry_kasry_dakheli=$db->get_from_where("SUM($oftokasryField)","$mydatabase.mojavez_oftokasry T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_oftokasry=2 AND chktaeed=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 AND status=0 $kalaCondition_dakheli ");	 
	      //وارداتی
	      $oftokasry_kasry_varedati=$db->get_from_where("SUM($oftokasryField)","$mydatabase.mojavez_oftokasry T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat noe_oftokasry=2 AND chktaeed=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND deleted=0 AND status=0 $kalaCondition_varedati ");	 
	
          
		  //محاسبات کل کسری و کسری غیرمجاز
          /******حالت داخلی******/		 	  
           $q_kasry_dakheli="SELECT SUM(vazn_mabda_r_d) as vazn_mabda,SUM(kasry_mojaz_r_d) as kasry_mojaz FROM meat.resid_detail r_d 
	                         INNER JOIN meat.resid r ON r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year 
                             INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=r_d.code_ostan AND list_sardkhane.code_anbar=r_d.code_anbar 
	       		             WHERE $Condition_movaghat r_d.year='$mtActiveYear' AND r_d.code_ostan=".$row['code_ostan']." AND r_d.code_anbar=".$row2['code_anbar']." AND r_d.resid_deleted=0 AND r_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition_resid_d_dakheli  AND($Condition_anbar_resid_d)
                             AND code_kala IN(select code_kala from resid_kala_detail T where T.code_ostan=r_d.code_ostan AND T.code_anbar=r_d.code_anbar AND T.shomare_resid=r_d.shomare_resid AND T.year=r_d.year AND T.resid_deleted=0 AND T.status=0)
                             AND code_tolidkonande IN(select code_tolidkonande from resid_kala_detail T where T.code_ostan=r_d.code_ostan AND T.code_anbar=r_d.code_anbar AND T.shomare_resid=r_d.shomare_resid AND T.year=r_d.year AND T.resid_deleted=0 AND T.status=0)";
	       $result_kasry_dakheli=$db->query($q_kasry_dakheli);
	       $row_kasry_dakheli=$db->fetch_assoc($result_kasry_dakheli);
           //echo $row_kasry_dakheli['vazn_mabda'];
           //echo $row_kasry_dakheli['kasry_mojaz'];
           $q_vazn_dakheli="SELECT SUM(vazn_nakhales_r_d_sub) as vazn_nakhales,SUM(vazn_khales_r_d_sub) as vazn_khales FROM meat.resid_kala_detail T 
	                 INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year 
                     INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
					 WHERE $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition_dakheli AND($Condition_anbar)";
         	$result_vazn_dakheli=$db->query($q_vazn_dakheli);
         	$row_vazn_dakheli=$db->fetch_assoc($result_vazn_dakheli);
             if($bastebandy==2)$kasry_kol_dakheli = $row_kasry_dakheli['vazn_mabda'] - $row_vazn_dakheli['vazn_khales'];//کل کسری این کالا
             else $kasry_kol_dakheli = $row_kasry_dakheli['vazn_mabda'] - $row_vazn_dakheli['vazn_nakhales'];//کل کسری این کالا
         	if($kasry_kol_dakheli<0)$kasry_kol_dakheli=0;
         	//کسری غیرمجاز
         	$kasry_gheyremojaz_dakheli=$kasry_kol_dakheli-$row_kasry_dakheli['kasry_mojaz'];
            if($kasry_gheyremojaz_dakheli<0)$kasry_gheyremojaz_dakheli=0;
            /******حالت وارداتی******/		 	  
        	$vazn_mabda_varedati=$db->get_from_where("SUM(vazn_mabda_r_d)","meat.resid_detail r_d INNER JOIN meat.resid r ON r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year INNER JOIN meat.resid_kala_detail T ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year","r_d.year='$mtActiveYear' AND r_d.code_ostan=".$row['code_ostan']." AND r_d.resid_deleted=0 AND r_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition_dakheli  AND($Condition_anbar)");
            $q_kasry_varedati="SELECT SUM(vazn_mabda_r_d) as vazn_mabda,SUM(kasry_mojaz_r_d) as kasry_mojaz FROM meat.resid_detail r_d 
        	                   INNER JOIN meat.resid r ON r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year 
                               INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=r_d.code_ostan AND list_sardkhane.code_anbar=r_d.code_anbar 
        			           WHERE $Condition_movaghat r_d.year='$mtActiveYear' AND r_d.code_ostan=".$row['code_ostan']." AND r_d.code_anbar=".$row2['code_anbar']." AND r_d.resid_deleted=0 AND r_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition_resid_d_varedati  AND($Condition_anbar_resid_d)
                               AND code_kala IN(select code_kala from resid_kala_detail T where T.code_ostan=r_d.code_ostan AND T.code_anbar=r_d.code_anbar AND T.shomare_resid=r_d.shomare_resid AND T.year=r_d.year AND T.resid_deleted=0 AND T.status=0)
                               AND code_tolidkonande IN(select code_tolidkonande from resid_kala_detail T where T.code_ostan=r_d.code_ostan AND T.code_anbar=r_d.code_anbar AND T.shomare_resid=r_d.shomare_resid AND T.year=r_d.year AND T.resid_deleted=0 AND T.status=0)";
        	$result_kasry_varedati=$db->query($q_kasry_varedati);
        	$row_kasry_varedati=$db->fetch_assoc($result_kasry_varedati);
            $q_vazn_varedati="SELECT SUM(vazn_nakhales_r_d_sub) as vazn_nakhales,SUM(vazn_khales_r_d_sub) as vazn_khales FROM meat.resid_kala_detail T
                         	  INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year 
                              INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
        					  WHERE $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition_varedati  AND($Condition_anbar)";
        	$result_vazn_varedati=$db->query($q_vazn_varedati);
        	$row_vazn_varedati=$db->fetch_assoc($result_vazn_varedati);
            if($bastebandy==2)$kasry_kol_varedati = $row_kasry_varedati['vazn_mabda'] - $row_vazn_varedati['vazn_khales'];//کل کسری این کالا
            else $kasry_kol_varedati = $row_kasry_varedati['vazn_mabda'] - $row_vazn_varedati['vazn_nakhales'];//کل کسری این کالا
        	if($kasry_kol_varedati<0)$kasry_kol_varedati=0;
        	//کسری غیرمجاز
	        $kasry_gheyremojaz_varedati=$kasry_kol_varedati-$row_kasry_varedati['kasry_mojaz'];
            if($kasry_gheyremojaz_varedati<0)$kasry_gheyremojaz_varedati=0;
	        //مانده موجودی- حالت داخلی
	        $mande_nahayi_dakheli=0;
	        $mande_nahayi_dakheli=$mande_befor_dakheli+$tadil_ezafe_dakheli-$tadil_kasry_dakheli+$kharidghatee_dakheli+$daryafti_jabejae_dakheli+$daryafti_khososi_dakheli+$bargasht_dakheli-$tahvilghatee_dakheli-$ersali_sayer_jabejae_dakheli-$ersali_movaghat_jabejae_dakheli-$jabejae_amani_dakheli-$jabejae_khososi_dakheli;	  
	       //مانده موجودی- حالت وارداتی
	        $mande_nahayi_varedati=0;
	        $mande_nahayi_varedati=$mande_befor_varedati+$tadil_ezafe_varedati-$tadil_kasry_varedati+$kharidghatee_varedati+$daryafti_jabejae_varedati+$daryafti_khososi_varedati+$bargasht_varedati-$tahvilghatee_varedati-$ersali_sayer_jabejae_varedati-$ersali_movaghat_jabejae_varedati-$jabejae_amani_varedati-$jabejae_khososi_varedati;
            //جمع مانده
	         $jame_mande_nahayi_kala=0;
	         $jame_mande_nahayi_kala=$mande_nahayi_dakheli+$mande_nahayi_varedati;
            //مانده موجودی پس از کسر حواله فروش
            $mande_pasazkasr_dakheli=$mande_nahayi_dakheli-$mande_forush_dakheli; 	   
            $mande_pasazkasr_varedati=$mande_nahayi_varedati-$mande_forush_varedati; 	   
            $mande_pasazkasr=$mande_pasazkasr_dakheli+$mande_pasazkasr_varedati;
		    //مانده موجودی پس از کسر حواله فروش و تاثیر افت و کسری
            $mande_pasazkasr_dakheli=$mande_pasazkasr_dakheli+$oftokasry_ezafe_dakheli-$oftokasry_kasry_dakheli; 	   
            $mande_pasazkasr_varedati=$mande_pasazkasr_varedati+$oftokasry_ezafe_varedati-$oftokasry_kasry_varedati; 	   
            $mande_pasazkasr=$mande_pasazkasr_dakheli+$mande_pasazkasr_varedati;
		
	   IF(($mande_anbargardani_dakheli!=$mande_nahayi_dakheli)AND($mtActiveYear!=$yy)) $sty_dakheli='style="color:#8C001A;"'; 
	   IF(($mande_anbargardani_varedati!=$mande_nahayi_varedati)AND($mtActiveYear!=$yy)) $sty_varedati='style="color:#FF0080;"'; 
	   IF(($jame_mande_nahayi_kala_anbargardani!=$jame_mande_nahayi_kala)AND($mtActiveYear!=$yy)) $sty_jam='style="color:#FF0000;"';
	 //نمایش اطلاعات
	 echo'
		  <td class="mande_beforPr">'.round($mande_befor_dakheli,3).'</td>
		  <td class="mande_beforPr">'.round($mande_befor_varedati,3).'</td>
		  <td class="mande_beforPr">'.round($jame_mande_befor_kala,3).'</td>
		  <td class="tadil_ezafePr">'.round($tadil_ezafe_dakheli,3).'</td>
		  <td class="tadil_ezafePr">'.round($tadil_ezafe_varedati,3).'</td>
		  <td class="tadil_kasryPr">'.round($tadil_kasry_dakheli,3).'</td>
		  <td class="tadil_kasryPr">'.round($tadil_kasry_varedati,3).'</td>
		  <td class="kharidPr">'.round($kharidghatee_dakheli,3).'</td>
		  <td class="kharidPr">'.round($kharidghatee_varedati,3).'</td>
		  <td class="daryafti_Pr">'.round($daryafti_jabejae_dakheli,3).'</td>
		  <td class="daryafti_Pr">'.round($daryafti_jabejae_varedati,3).'</td>
		  <td class="daryafti_bandarPr">'.round($daryafti_banader_dakheli,3).'</td>
		  <td class="daryafti_bandarPr">'.round($daryafti_banader_varedati,3).'</td>
		  <td class="daryafti_khososiPr">'.round($daryafti_khososi_dakheli,3).'</td>
		  <td class="daryafti_khososiPr">'.round($daryafti_khososi_varedati,3).'</td>
		  <td class="bargashtPr">'.round($bargasht_dakheli,3).'</td>
		  <td class="bargashtPr">'.round($bargasht_varedati,3).'</td>
		  <td class="tahvilPr">'.round($tahvilghatee_dakheli,3).'</td>
		  <td class="tahvilPr">'.round($tahvilghatee_varedati,3).'</td>
		  <td class="kalaye_darrah_sayerPr">'.round($darrah_sayer_dakheli,3).'</td>
		  <td class="kalaye_darrah_sayerPr">'.round($darrah_sayer_varedati,3).'</td>
		  <td class="kalaye_darrah_movaghatPr">'.round($darrah_movaghat_dakheli,3).'</td>
		  <td class="kalaye_darrah_movaghatPr">'.round($darrah_movaghat_varedati,3).'</td>
		  <td class="ersaly_sayerPr">'.round($ersali_sayer_jabejae_dakheli,3).'</td>
		  <td class="ersaly_sayerPr">'.round($ersali_sayer_jabejae_varedati,3).'</td>
		  <td class="ersaly_movaghatPr">'.round($ersali_movaghat_jabejae_dakheli,3).'</td>
		  <td class="ersaly_movaghatPr">'.round($ersali_movaghat_jabejae_varedati,3).'</td>
		  <td class="ersaly_amaniPr">'.round($jabejae_amani_dakheli,3).'</td>
		  <td class="ersaly_amaniPr">'.round($jabejae_amani_varedati,3).'</td>
		  <td class="ersaly_khososiPr">'.round($jabejae_khososi_dakheli,3).'</td>
		  <td class="ersaly_khososiPr">'.round($jabejae_khososi_varedati,3).'</td>
		  <td class="kasry_kolPr">'.round($kasry_kol_dakheli,3).'</td>
		  <td class="kasry_kolPr">'.round($kasry_kol_varedati,3).'</td>
		  <td class="kasry_gheyrPr">'.round($kasry_gheyremojaz_dakheli,3).'</td>
		  <td class="kasry_gheyrPr">'.round($kasry_gheyremojaz_varedati,3).'</td>
		  <td class="forushPr">'.round($havale_forush_befor_dakheli,3).'-'.round($havale_forush_between_dakheli,3).'</td>
		  <td class="forushPr">'.round($havale_forush_befor_varedati,3).'-'.round($havale_forush_between_varedati,3).'</td>
		  <td class="ebtalyPr">'.round($meghdar_ebtali_between_dakheli,3).'</td>
		  <td class="ebtalyPr">'.round($meghdar_ebtali_between_varedati,3).'</td>
		  <td class="mande_forushPr">'.round($mande_forush_dakheli,3).'</td>
		  <td class="mande_forushPr">'.round($mande_forush_varedati,3).'</td>
		  <td class="mande_forushPr">'.round($jame_mande_forush,3).'</td>
		  <td '.$sty_dakheli.' class="mande_anbargardaniPr">'.round($mande_anbargardani_dakheli,3).'</td>
		  <td '.$sty_varedati.' class="mande_anbargardaniPr">'.round($mande_anbargardani_varedati,3).'</td>
		  <td '.$sty_jam.' class="mande_anbargardaniPr">'.round($jame_mande_nahayi_kala_anbargardani,3).'</td>
		  <td class="mandePr">'.round($mande_nahayi_dakheli,3).'</td>
		  <td class="mandePr">'.round($mande_nahayi_varedati,3).'</td>
		  <td class="mandePr">'.round($jame_mande_nahayi_kala,3).'</td>
		  <td class="mande_pasaz_kasrPr">'.round($mande_pasazkasr_dakheli,3).'</td>
		  <td class="mande_pasaz_kasrPr">'.round($mande_pasazkasr_varedati,3).'</td>
		  <td class="mande_pasaz_kasrPr">'.round($mande_pasazkasr,3).'</td>
		  <td class="ezafe_oftokasryPr">'.round($oftokasry_ezafe_dakheli,3).'</td>
		  <td class="ezafe_oftokasryPr">'.round($oftokasry_ezafe_varedati,3).'</td>
		  <td class="kasry_oftokasryPr">'.round($oftokasry_kasry_dakheli,3).'</td>
		  <td class="kasry_oftokasryPr">'.round($oftokasry_kasry_varedati,3).'</td>';

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
	    $jame_daryafti_khososi_dakheli+=$daryafti_khososi_dakheli;
	    $jame_daryafti_khososi_varedati+=$daryafti_khososi_varedati;
	    $jame_bargasht_dakheli+=$bargasht_dakheli;
	    $jame_bargasht_varedati+=$bargasht_varedati; 
		$jame_tahvilghatee_dakheli+=$tahvilghatee_dakheli;
	    $jame_tahvilghatee_varedati+=$tahvilghatee_varedati;
	    $jame_darrah_sayer_dakheli+=$darrah_sayer_dakheli;
	    $jame_darrah_sayer_varedati+=$darrah_sayer_varedati;
	    $jame_darrah_movaghat_dakheli+=$darrah_movaghat_dakheli;
	    $jame_darrah_movaghat_varedati+=$darrah_movaghat_varedati;
		$jame_ersali_sayer_jabejae_dakheli+=$ersali_sayer_jabejae_dakheli;
	    $jame_ersali_sayer_jabejae_varedati+=$ersali_sayer_jabejae_varedati;
	    $jame_ersali_movaghat_jabejae_dakheli+=$ersali_movaghat_jabejae_dakheli;
	    $jame_ersali_movaghat_jabejae_varedati+=$ersali_movaghat_jabejae_varedati;
		$jame_jabejae_amani_dakheli+=$jabejae_amani_dakheli;
	    $jame_jabejae_amani_varedati+=$jabejae_amani_varedati;
		$jame_jabejae_khososi_dakheli+=$jabejae_khososi_dakheli;
	    $jame_jabejae_khososi_varedati+=$jabejae_khososi_varedati;
		$jame_kasry_kol_dakheli+=$kasry_kol_dakheli;
	    $jame_kasry_kol_varedati+=$kasry_kol_varedati;
	    $jame_kasry_gheyremojaz_dakheli+=$kasry_gheyremojaz_dakheli;
	    $jame_kasry_gheyremojaz_varedati+=$kasry_gheyremojaz_varedati;
	    $jame_havale_forush_between_dakheli+=$havale_forush_between_dakheli;
	    $jame_havale_forush_between_varedati+=$havale_forush_between_varedati;
	    $jame_meghdar_ebtali_between_dakheli+=$meghdar_ebtali_between_dakheli;
	    $jame_meghdar_ebtali_between_varedati+=$meghdar_ebtali_between_varedati;
	    $jame_mande_forush_dakheli+=$mande_forush_dakheli;
	    $jame_mande_forush_varedati+=$mande_forush_varedati;
	    $jame_mande_forush_kol+=$jame_mande_forush;
		$jame_mande_anbargardani_dakheli+=$mande_anbargardani_dakheli;
		$jame_mande_anbargardani_varedati+=$mande_anbargardani_varedati;
		$jame_mande_nahayi_anbargardani+=$jame_mande_nahayi_kala_anbargardani;
		$jame_mande_nahayi_dakheli+=$mande_nahayi_dakheli;
	    $jame_mande_nahayi_varedati+=$mande_nahayi_varedati;
		$jame_mande_nahayi+=$jame_mande_nahayi_kala;
	    $jame_mande_pasazkasr_dakheli+=$mande_pasazkasr_dakheli;
	    $jame_mande_pasazkasr_varedati+=$mande_pasazkasr_varedati;
	    $jame_mande_pasazkasr+=$mande_pasazkasr;
		$jame_oftokasry_ezafe_dakheli+=$oftokasry_ezafe_dakheli;
		$jame_oftokasry_ezafe_varedati+=$oftokasry_ezafe_varedati;
		$jame_oftokasry_kasry_dakheli+=$oftokasry_kasry_dakheli;
		$jame_oftokasry_kasry_varedati+=$oftokasry_kasry_varedati;
		IF($x_value=="گوشت گاو")//برای جمع تکی 
		{
		 $show_gav=1;
		 $jame_mande_befor_dakheli_gav+=$mande_befor_dakheli;
	     $jame_mande_befor_varedati_gav+=$mande_befor_varedati;
	     $jame_mande_befor_gav+=$jame_mande_befor_kala;
		 $jame_kharidghatee_dakheli_gav+=$kharidghatee_dakheli;
	     $jame_tadil_ezafe_dakheli_gav+=$tadil_ezafe_dakheli;
	     $jame_tadil_ezafe_varedati_gav+=$tadil_ezafe_varedati;
	     $jame_tadil_kasry_dakheli_gav+=$tadil_kasry_dakheli;
	     $jame_tadil_kasry_varedati_gav+=$tadil_kasry_varedati;
		 $jame_kharidghatee_varedati_gav+=$kharidghatee_varedati;
	     $jame_daryafti_jabejae_dakheli_gav+=$daryafti_jabejae_dakheli;
	     $jame_daryafti_jabejae_varedati_gav+=$daryafti_jabejae_varedati;
	     $jame_daryafti_banader_dakheli_gav+=$daryafti_banader_dakheli;
	     $jame_daryafti_banader_varedati_gav+=$daryafti_banader_varedati;
	     $jame_daryafti_khososi_dakheli_gav+=$daryafti_khososi_dakheli;
	     $jame_daryafti_khososi_varedati_gav+=$daryafti_khososi_varedati;
 	     $jame_bargasht_dakheli_gav+=$bargasht_dakheli;
	     $jame_bargasht_varedati_gav+=$bargasht_varedati; 
		 $jame_tahvilghatee_dakheli_gav+=$tahvilghatee_dakheli;
	     $jame_tahvilghatee_varedati_gav+=$tahvilghatee_varedati;
	     $jame_darrah_sayer_dakheli_gav+=$darrah_sayer_dakheli;
	     $jame_darrah_sayer_varedati_gav+=$darrah_sayer_varedati;
	     $jame_darrah_movaghat_dakheli_gav+=$darrah_movaghat_dakheli;
	     $jame_darrah_movaghat_varedati_gav+=$darrah_movaghat_varedati;
		 $jame_ersali_sayer_jabejae_dakheli_gav+=$ersali_sayer_jabejae_dakheli;
	     $jame_ersali_sayer_jabejae_varedati_gav+=$ersali_sayer_jabejae_varedati;
	     $jame_ersali_movaghat_jabejae_dakheli_gav+=$ersali_movaghat_jabejae_dakheli;
	     $jame_ersali_movaghat_jabejae_varedati_gav+=$ersali_movaghat_jabejae_varedati;
	     $jame_jabejae_amani_dakheli_gav+=$jabejae_amani_dakheli;
	     $jame_jabejae_amani_varedati_gav+=$jabejae_amani_varedati;
	     $jame_jabejae_khososi_dakheli_gav+=$jabejae_khososi_dakheli;
	     $jame_jabejae_khososi_varedati_gav+=$jabejae_khososi_varedati;
		 $jame_kasry_kol_dakheli_gav+=$kasry_kol_dakheli;
	     $jame_kasry_kol_varedati_gav+=$kasry_kol_varedati;
	     $jame_kasry_gheyremojaz_dakheli_gav+=$kasry_gheyremojaz_dakheli;
	     $jame_kasry_gheyremojaz_varedati_gav+=$kasry_gheyremojaz_varedati;
	     $jame_havale_forush_between_dakheli_gav+=$havale_forush_between_dakheli;
	     $jame_havale_forush_between_varedati_gav+=$havale_forush_between_varedati;
	     $jame_meghdar_ebtali_between_dakheli_gav+=$meghdar_ebtali_between_dakheli;
	     $jame_meghdar_ebtali_between_varedati_gav+=$meghdar_ebtali_between_varedati;
	     $jame_mande_forush_dakheli_gav+=$mande_forush_dakheli;
	     $jame_mande_forush_varedati_gav+=$mande_forush_varedati;
	     $jame_mande_forush_kol_gav+=$jame_mande_forush;
		 $jame_mande_anbargardani_dakheli_gav+=$mande_anbargardani_dakheli;
		 $jame_mande_anbargardani_varedati_gav+=$mande_anbargardani_varedati;
		 $jame_mande_nahayi_anbargardani_gav+=$jame_mande_nahayi_kala_anbargardani;
		 $jame_mande_nahayi_dakheli_gav+=$mande_nahayi_dakheli;
	     $jame_mande_nahayi_varedati_gav+=$mande_nahayi_varedati;
		 $jame_mande_nahayi_gav+=$jame_mande_nahayi_kala;
	     $jame_mande_pasazkasr_dakheli_gav+=$mande_pasazkasr_dakheli;
	     $jame_mande_pasazkasr_varedati_gav+=$mande_pasazkasr_varedati;
	     $jame_mande_pasazkasr_gav+=$mande_pasazkasr;
		 $jame_oftokasry_ezafe_dakheli_gav+=$oftokasry_ezafe_dakheli;
		 $jame_oftokasry_ezafe_varedati_gav+=$oftokasry_ezafe_varedati;
		 $jame_oftokasry_kasry_dakheli_gav+=$oftokasry_kasry_dakheli;
		 $jame_oftokasry_kasry_varedati_gav+=$oftokasry_kasry_varedati;
		}
		IF($x_value=="گوشت گوسفند")
		{
		 $show_gosfand=1;
	     $jame_mande_befor_dakheli_gosfand+=$mande_befor_dakheli;
	     $jame_mande_befor_varedati_gosfand+=$mande_befor_varedati;
	     $jame_mande_befor_gosfand+=$jame_mande_befor_kala;
		 $jame_kharidghatee_dakheli_gosfand+=$kharidghatee_dakheli;
	     $jame_tadil_ezafe_dakheli_gosfand+=$tadil_ezafe_dakheli;
	     $jame_tadil_ezafe_varedati_gosfand+=$tadil_ezafe_varedati;
	     $jame_tadil_kasry_dakheli_gosfand+=$tadil_kasry_dakheli;
	     $jame_tadil_kasry_varedati_gosfand+=$tadil_kasry_varedati;
		 $jame_kharidghatee_varedati_gosfand+=$kharidghatee_varedati;
	     $jame_daryafti_jabejae_dakheli_gosfand+=$daryafti_jabejae_dakheli;
	     $jame_daryafti_jabejae_varedati_gosfand+=$daryafti_jabejae_varedati;
	     $jame_daryafti_banader_dakheli_gosfand+=$daryafti_banader_dakheli;
	     $jame_daryafti_banader_varedati_gosfand+=$daryafti_banader_varedati;
	     $jame_daryafti_khososi_dakheli_gosfand+=$daryafti_khososi_dakheli;
	     $jame_daryafti_khososi_varedati_gosfand+=$daryafti_khososi_varedati;
	     $jame_bargasht_dakheli_gosfand+=$bargasht_dakheli;
	     $jame_bargasht_varedati_gosfand+=$bargasht_varedati; 
		 $jame_tahvilghatee_dakheli_gosfand+=$tahvilghatee_dakheli;
	     $jame_tahvilghatee_varedati_gosfand+=$tahvilghatee_varedati;
	     $jame_darrah_sayer_dakheli_gosfand+=$darrah_sayer_dakheli;
	     $jame_darrah_sayer_varedati_gosfand+=$darrah_sayer_varedati;
	     $jame_darrah_movaghat_dakheli_gosfand+=$darrah_movaghat_dakheli;
	     $jame_darrah_movaghat_varedati_gosfand+=$darrah_movaghat_varedati;
		 $jame_ersali_sayer_jabejae_dakheli_gosfand+=$ersali_sayer_jabejae_dakheli;
	     $jame_ersali_sayer_jabejae_varedati_gosfand+=$ersali_sayer_jabejae_varedati;
	     $jame_ersali_movaghat_jabejae_dakheli_gosfand+=$ersali_movaghat_jabejae_dakheli;
	     $jame_ersali_movaghat_jabejae_varedati_gosfand+=$ersali_movaghat_jabejae_varedati;
	     $jame_jabejae_amani_dakheli_gosfand+=$jabejae_amani_dakheli;
	     $jame_jabejae_amani_varedati_gosfand+=$jabejae_amani_varedati;
	     $jame_jabejae_khososi_dakheli_gosfand+=$jabejae_khososi_dakheli;
	     $jame_jabejae_khososi_varedati_gosfand+=$jabejae_khososi_varedati;
		 $jame_kasry_kol_dakheli_gosfand+=$kasry_kol_dakheli;
	     $jame_kasry_kol_varedati_gosfand+=$kasry_kol_varedati;
	     $jame_kasry_gheyremojaz_dakheli_gosfand+=$kasry_gheyremojaz_dakheli;
	     $jame_kasry_gheyremojaz_varedati_gosfand+=$kasry_gheyremojaz_varedati;
	     $jame_havale_forush_between_dakheli_gosfand+=$havale_forush_between_dakheli;
	     $jame_havale_forush_between_varedati_gosfand+=$havale_forush_between_varedati;
	     $jame_meghdar_ebtali_between_dakheli_gosfand+=$meghdar_ebtali_between_dakheli;
	     $jame_meghdar_ebtali_between_varedati_gosfand+=$meghdar_ebtali_between_varedati;
	     $jame_mande_forush_dakheli_gosfand+=$mande_forush_dakheli;
	     $jame_mande_forush_varedati_gosfand+=$mande_forush_varedati;
	     $jame_mande_forush_kol_gosfand+=$jame_mande_forush;
		 $jame_mande_anbargardani_dakheli_gosfand+=$mande_anbargardani_dakheli;
		 $jame_mande_anbargardani_varedati_gosfand+=$mande_anbargardani_varedati;
		 $jame_mande_nahayi_anbargardani_gosfand+=$jame_mande_nahayi_kala_anbargardani;
		 $jame_mande_nahayi_dakheli_gosfand+=$mande_nahayi_dakheli;
	     $jame_mande_nahayi_varedati_gosfand+=$mande_nahayi_varedati;
		 $jame_mande_nahayi_gosfand+=$jame_mande_nahayi_kala;
	     $jame_mande_pasazkasr_dakheli_gosfand+=$mande_pasazkasr_dakheli;
	     $jame_mande_pasazkasr_varedati_gosfand+=$mande_pasazkasr_varedati;
	     $jame_mande_pasazkasr_gosfand+=$mande_pasazkasr;
		 $jame_oftokasry_ezafe_dakheli_gosfand+=$oftokasry_ezafe_dakheli;
		 $jame_oftokasry_ezafe_varedati_gosfand+=$oftokasry_ezafe_varedati;
		 $jame_oftokasry_kasry_dakheli_gosfand+=$oftokasry_kasry_dakheli;
		 $jame_oftokasry_kasry_varedati_gosfand+=$oftokasry_kasry_varedati;		 
		}
		IF($x_value=="گوشت مرغ")
		{
		 $show_morgh=1;
	     $jame_mande_befor_dakheli_morgh+=$mande_befor_dakheli;
	     $jame_mande_befor_varedati_morgh+=$mande_befor_varedati;
	     $jame_mande_befor_morgh+=$jame_mande_befor_kala;
		 $jame_kharidghatee_dakheli_morgh+=$kharidghatee_dakheli;
	     $jame_tadil_ezafe_dakheli_morgh+=$tadil_ezafe_dakheli;
	     $jame_tadil_ezafe_varedati_morgh+=$tadil_ezafe_varedati;
	     $jame_tadil_kasry_dakheli_morgh+=$tadil_kasry_dakheli;
	     $jame_tadil_kasry_varedati_morgh+=$tadil_kasry_varedati;
		 $jame_kharidghatee_varedati_morgh+=$kharidghatee_varedati;
	     $jame_daryafti_jabejae_dakheli_morgh+=$daryafti_jabejae_dakheli;
	     $jame_daryafti_jabejae_varedati_morgh+=$daryafti_jabejae_varedati;
	     $jame_daryafti_banader_dakheli_morgh+=$daryafti_banader_dakheli;
	     $jame_daryafti_banader_varedati_morgh+=$daryafti_banader_varedati;
	     $jame_daryafti_khososi_dakheli_morgh+=$daryafti_khososi_dakheli;
	     $jame_daryafti_khososi_varedati_morgh+=$daryafti_khososi_varedati;
	     $jame_bargasht_dakheli_morgh+=$bargasht_dakheli;
	     $jame_bargasht_varedati_morgh+=$bargasht_varedati; 
		 $jame_tahvilghatee_dakheli_morgh+=$tahvilghatee_dakheli;
	     $jame_tahvilghatee_varedati_morgh+=$tahvilghatee_varedati;
	     $jame_darrah_sayer_dakheli_morgh+=$darrah_sayer_dakheli;
	     $jame_darrah_sayer_varedati_morgh+=$darrah_sayer_varedati;
	     $jame_darrah_movaghat_dakheli_morgh+=$darrah_movaghat_dakheli;
	     $jame_darrah_movaghat_varedati_morgh+=$darrah_movaghat_varedati;
		 $jame_ersali_sayer_jabejae_dakheli_morgh+=$ersali_sayer_jabejae_dakheli;
	     $jame_ersali_sayer_jabejae_varedati_morgh+=$ersali_sayer_jabejae_varedati;
	     $jame_ersali_movaghat_jabejae_dakheli_morgh+=$ersali_movaghat_jabejae_dakheli;
	     $jame_ersali_movaghat_jabejae_varedati_morgh+=$ersali_movaghat_jabejae_varedati;
	     $jame_jabejae_amani_dakheli_morgh+=$jabejae_amani_dakheli;
	     $jame_jabejae_amani_varedati_morgh+=$jabejae_amani_varedati;
	     $jame_jabejae_khososi_dakheli_morgh+=$jabejae_khososi_dakheli;
	     $jame_jabejae_khososi_varedati_morgh+=$jabejae_khososi_varedati;
		 $jame_kasry_kol_dakheli_morgh+=$kasry_kol_dakheli;
	     $jame_kasry_kol_varedati_morgh+=$kasry_kol_varedati;
	     $jame_kasry_gheyremojaz_dakheli_morgh+=$kasry_gheyremojaz_dakheli;
	     $jame_kasry_gheyremojaz_varedati_morgh+=$kasry_gheyremojaz_varedati;
	     $jame_havale_forush_between_dakheli_morgh+=$havale_forush_between_dakheli;
	     $jame_havale_forush_between_varedati_morgh+=$havale_forush_between_varedati;
	     $jame_meghdar_ebtali_between_dakheli_morgh+=$meghdar_ebtali_between_dakheli;
	     $jame_meghdar_ebtali_between_varedati_morgh+=$meghdar_ebtali_between_varedati;
	     $jame_mande_forush_dakheli_morgh+=$mande_forush_dakheli;
	     $jame_mande_forush_varedati_morgh+=$mande_forush_varedati;
	     $jame_mande_forush_kol_morgh+=$jame_mande_forush;
		 $jame_mande_anbargardani_dakheli_morgh+=$mande_anbargardani_dakheli;
		 $jame_mande_anbargardani_varedati_morgh+=$mande_anbargardani_varedati;
		 $jame_mande_nahayi_anbargardani_morgh+=$jame_mande_nahayi_kala_anbargardani;
		 $jame_mande_nahayi_dakheli_morgh+=$mande_nahayi_dakheli;
	     $jame_mande_nahayi_varedati_morgh+=$mande_nahayi_varedati;
		 $jame_mande_nahayi_morgh+=$jame_mande_nahayi_kala;
	     $jame_mande_pasazkasr_dakheli_morgh+=$mande_pasazkasr_dakheli;
	     $jame_mande_pasazkasr_varedati_morgh+=$mande_pasazkasr_varedati;
	     $jame_mande_pasazkasr_morgh+=$mande_pasazkasr;
		 $jame_oftokasry_ezafe_dakheli_morgh+=$oftokasry_ezafe_dakheli;
		 $jame_oftokasry_ezafe_varedati_morgh+=$oftokasry_ezafe_varedati;
		 $jame_oftokasry_kasry_dakheli_morgh+=$oftokasry_kasry_dakheli;
		 $jame_oftokasry_kasry_varedati_morgh+=$oftokasry_kasry_varedati;		 
		}
		IF($x_value=="کنسرو مرغ")
		{
		 $show_konserv=1;
         $jame_mande_befor_dakheli_konserv+=$mande_befor_dakheli;
	     $jame_mande_befor_varedati_konserv+=$mande_befor_varedati;
	     $jame_mande_befor_konserv+=$jame_mande_befor_kala;
		 $jame_kharidghatee_dakheli_konserv+=$kharidghatee_dakheli;
	     $jame_tadil_ezafe_dakheli_konserv+=$tadil_ezafe_dakheli;
	     $jame_tadil_ezafe_varedati_konserv+=$tadil_ezafe_varedati;
	     $jame_tadil_kasry_dakheli_konserv+=$tadil_kasry_dakheli;
	     $jame_tadil_kasry_varedati_konserv+=$tadil_kasry_varedati;
		 $jame_kharidghatee_varedati_konserv+=$kharidghatee_varedati;
	     $jame_daryafti_jabejae_dakheli_konserv+=$daryafti_jabejae_dakheli;
	     $jame_daryafti_jabejae_varedati_konserv+=$daryafti_jabejae_varedati;
	     $jame_daryafti_banader_dakheli_konserv+=$daryafti_banader_dakheli;
	     $jame_daryafti_banader_varedati_konserv+=$daryafti_banader_varedati;
	     $jame_daryafti_khososi_dakheli_konserv+=$daryafti_khososi_dakheli;
	     $jame_daryafti_khososi_varedati_konserv+=$daryafti_khososi_varedati;
 	     $jame_bargasht_dakheli_konserv+=$bargasht_dakheli;
	     $jame_bargasht_varedati_konserv+=$bargasht_varedati; 
		 $jame_tahvilghatee_dakheli_konserv+=$tahvilghatee_dakheli;
	     $jame_tahvilghatee_varedati_konserv+=$tahvilghatee_varedati;
	     $jame_darrah_sayer_dakheli_konserv+=$darrah_sayer_dakheli;
	     $jame_darrah_sayer_varedati_konserv+=$darrah_sayer_varedati;
	     $jame_darrah_movaghat_dakheli_konserv+=$darrah_movaghat_dakheli;
	     $jame_darrah_movaghat_varedati_konserv+=$darrah_movaghat_varedati;
		 $jame_ersali_sayer_jabejae_dakheli_konserv+=$ersali_sayer_jabejae_dakheli;
	     $jame_ersali_sayer_jabejae_varedati_konserv+=$ersali_sayer_jabejae_varedati;
	     $jame_ersali_movaghat_jabejae_dakheli_konserv+=$ersali_movaghat_jabejae_dakheli;
	     $jame_ersali_movaghat_jabejae_varedati_konserv+=$ersali_movaghat_jabejae_varedati;
	     $jame_jabejae_amani_dakheli_konserv+=$jabejae_amani_dakheli;
	     $jame_jabejae_amani_varedati_konserv+=$jabejae_amani_varedati;
	     $jame_jabejae_khososi_dakheli_konserv+=$jabejae_khososi_dakheli;
	     $jame_jabejae_khososi_varedati_konserv+=$jabejae_khososi_varedati;
		 $jame_kasry_kol_dakheli_konserv+=$kasry_kol_dakheli;
	     $jame_kasry_kol_varedati_konserv+=$kasry_kol_varedati;
	     $jame_kasry_gheyremojaz_dakheli_konserv+=$kasry_gheyremojaz_dakheli;
	     $jame_kasry_gheyremojaz_varedati_konserv+=$kasry_gheyremojaz_varedati;
	     $jame_havale_forush_between_dakheli_konserv+=$havale_forush_between_dakheli;
	     $jame_havale_forush_between_varedati_konserv+=$havale_forush_between_varedati;
	     $jame_meghdar_ebtali_between_dakheli_konserv+=$meghdar_ebtali_between_dakheli;
	     $jame_meghdar_ebtali_between_varedati_konserv+=$meghdar_ebtali_between_varedati;
	     $jame_mande_forush_dakheli_konserv+=$mande_forush_dakheli;
	     $jame_mande_forush_varedati_konserv+=$mande_forush_varedati;
	     $jame_mande_forush_kol_konserv+=$jame_mande_forush;
		 $jame_mande_anbargardani_dakheli_konserv+=$mande_anbargardani_dakheli;
		 $jame_mande_anbargardani_varedati_konserv+=$mande_anbargardani_varedati;
		 $jame_mande_nahayi_anbargardani_konserv+=$jame_mande_nahayi_kala_anbargardani;
		 $jame_mande_nahayi_dakheli_konserv+=$mande_nahayi_dakheli;
	     $jame_mande_nahayi_varedati_konserv+=$mande_nahayi_varedati;
		 $jame_mande_nahayi_konserv+=$jame_mande_nahayi_kala;
	     $jame_mande_pasazkasr_dakheli_konserv+=$mande_pasazkasr_dakheli;
	     $jame_mande_pasazkasr_varedati_konserv+=$mande_pasazkasr_varedati;
	     $jame_mande_pasazkasr_konserv+=$mande_pasazkasr;
		 $jame_oftokasry_ezafe_dakheli_konserv+=$oftokasry_ezafe_dakheli;
		 $jame_oftokasry_ezafe_varedati_konserv+=$oftokasry_ezafe_varedati;
		 $jame_oftokasry_kasry_dakheli_konserv+=$oftokasry_kasry_dakheli;
		 $jame_oftokasry_kasry_varedati_konserv+=$oftokasry_kasry_varedati;		 
		}
		IF($x_value=="تخم مرغ خوراکی")
		{
		 $show_tokhme_m=1;
	     $jame_mande_befor_dakheli_tokhme_m+=$mande_befor_dakheli;
	     $jame_mande_befor_varedati_tokhme_m+=$mande_befor_varedati;
	     $jame_mande_befor_tokhme_m+=$jame_mande_befor_kala;
		 $jame_kharidghatee_dakheli_tokhme_m+=$kharidghatee_dakheli;
	     $jame_tadil_ezafe_dakheli_tokhme_m+=$tadil_ezafe_dakheli;
	     $jame_tadil_ezafe_varedati_tokhme_m+=$tadil_ezafe_varedati;
	     $jame_tadil_kasry_dakheli_tokhme_m+=$tadil_kasry_dakheli;
	     $jame_tadil_kasry_varedati_tokhme_m+=$tadil_kasry_varedati;
		 $jame_kharidghatee_varedati_tokhme_m+=$kharidghatee_varedati;
	     $jame_daryafti_jabejae_dakheli_tokhme_m+=$daryafti_jabejae_dakheli;
	     $jame_daryafti_jabejae_varedati_tokhme_m+=$daryafti_jabejae_varedati;
	     $jame_daryafti_banader_dakheli_tokhme_m+=$daryafti_banader_dakheli;
	     $jame_daryafti_banader_varedati_tokhme_m+=$daryafti_banader_varedati;
	     $jame_daryafti_khososi_dakheli_tokhme_m+=$daryafti_khososi_dakheli;
	     $jame_daryafti_khososi_varedati_tokhme_m+=$daryafti_khososi_varedati;
 	     $jame_bargasht_dakheli_tokhme_m+=$bargasht_dakheli;
	     $jame_bargasht_varedati_tokhme_m+=$bargasht_varedati; 
		 $jame_tahvilghatee_dakheli_tokhme_m+=$tahvilghatee_dakheli;
	     $jame_tahvilghatee_varedati_tokhme_m+=$tahvilghatee_varedati;
	     $jame_darrah_sayer_dakheli_tokhme_m+=$darrah_sayer_dakheli;
	     $jame_darrah_sayer_varedati_tokhme_m+=$darrah_sayer_varedati;
	     $jame_darrah_movaghat_dakheli_tokhme_m+=$darrah_movaghat_dakheli;
	     $jame_darrah_movaghat_varedati_tokhme_m+=$darrah_movaghat_varedati;
		 $jame_ersali_sayer_jabejae_dakheli_tokhme_m+=$ersali_sayer_jabejae_dakheli;
	     $jame_ersali_sayer_jabejae_varedati_tokhme_m+=$ersali_sayer_jabejae_varedati;
	     $jame_ersali_movaghat_jabejae_dakheli_tokhme_m+=$ersali_movaghat_jabejae_dakheli;
	     $jame_ersali_movaghat_jabejae_varedati_tokhme_m+=$ersali_movaghat_jabejae_varedati;
	     $jame_jabejae_amani_dakheli_tokhme_m+=$jabejae_amani_dakheli;
	     $jame_jabejae_amani_varedati_tokhme_m+=$jabejae_amani_varedati;
	     $jame_jabejae_khososi_dakheli_tokhme_m+=$jabejae_khososi_dakheli;
	     $jame_jabejae_khososi_varedati_tokhme_m+=$jabejae_khososi_varedati;
		 $jame_kasry_kol_dakheli_tokhme_m+=$kasry_kol_dakheli;
	     $jame_kasry_kol_varedati_tokhme_m+=$kasry_kol_varedati;
	     $jame_kasry_gheyremojaz_dakheli_tokhme_m+=$kasry_gheyremojaz_dakheli;
	     $jame_kasry_gheyremojaz_varedati_tokhme_m+=$kasry_gheyremojaz_varedati;
	     $jame_havale_forush_between_dakheli_tokhme_m+=$havale_forush_between_dakheli;
	     $jame_havale_forush_between_varedati_tokhme_m+=$havale_forush_between_varedati;
	     $jame_meghdar_ebtali_between_dakheli_tokhme_m+=$meghdar_ebtali_between_dakheli;
	     $jame_meghdar_ebtali_between_varedati_tokhme_m+=$meghdar_ebtali_between_varedati;
	     $jame_mande_forush_dakheli_tokhme_m+=$mande_forush_dakheli;
	     $jame_mande_forush_varedati_tokhme_m+=$mande_forush_varedati;
	     $jame_mande_forush_kol_tokhme_m+=$jame_mande_forush;
		 $jame_mande_anbargardani_dakheli_tokhme_m+=$mande_anbargardani_dakheli;
		 $jame_mande_anbargardani_varedati_tokhme_m+=$mande_anbargardani_varedati;
		 $jame_mande_nahayi_anbargardani_tokhme_m+=$jame_mande_nahayi_kala_anbargardani;
		 $jame_mande_nahayi_dakheli_tokhme_m+=$mande_nahayi_dakheli;
	     $jame_mande_nahayi_varedati_tokhme_m+=$mande_nahayi_varedati;
		 $jame_mande_nahayi_tokhme_m+=$jame_mande_nahayi_kala;
	     $jame_mande_pasazkasr_dakheli_tokhme_m+=$mande_pasazkasr_dakheli;
	     $jame_mande_pasazkasr_varedati_tokhme_m+=$mande_pasazkasr_varedati;
	     $jame_mande_pasazkasr_tokhme_m+=$mande_pasazkasr;	
		 $jame_oftokasry_ezafe_dakheli_tokhme_m+=$oftokasry_ezafe_dakheli;
		 $jame_oftokasry_ezafe_varedati_tokhme_m+=$oftokasry_ezafe_varedati;
		 $jame_oftokasry_kasry_dakheli_tokhme_m+=$oftokasry_kasry_dakheli;
		 $jame_oftokasry_kasry_varedati_tokhme_m+=$oftokasry_kasry_varedati;		 
		}
	    IF($x_value=="تخم مرغ صنعتی")
		{
		 $show_tokhme_m_s=1;
	     $jame_mande_befor_dakheli_tokhme_m_s+=$mande_befor_dakheli;
	     $jame_mande_befor_varedati_tokhme_m_s+=$mande_befor_varedati;
	     $jame_mande_befor_tokhme_m_s+=$jame_mande_befor_kala;
		 $jame_kharidghatee_dakheli_tokhme_m_s+=$kharidghatee_dakheli;
	     $jame_tadil_ezafe_dakheli_tokhme_m_s+=$tadil_ezafe_dakheli;
	     $jame_tadil_ezafe_varedati_tokhme_m_s+=$tadil_ezafe_varedati;
	     $jame_tadil_kasry_dakheli_tokhme_m_s+=$tadil_kasry_dakheli;
	     $jame_tadil_kasry_varedati_tokhme_m_s+=$tadil_kasry_varedati;
		 $jame_kharidghatee_varedati_tokhme_m_s+=$kharidghatee_varedati;
	     $jame_daryafti_jabejae_dakheli_tokhme_m_s+=$daryafti_jabejae_dakheli;
	     $jame_daryafti_jabejae_varedati_tokhme_m_s+=$daryafti_jabejae_varedati;
	     $jame_daryafti_banader_dakheli_tokhme_m_s+=$daryafti_banader_dakheli;
	     $jame_daryafti_banader_varedati_tokhme_m_s+=$daryafti_banader_varedati;
	     $jame_daryafti_khososi_dakheli_tokhme_m_s+=$daryafti_khososi_dakheli;
	     $jame_daryafti_khososi_varedati_tokhme_m_s+=$daryafti_khososi_varedati;
 	     $jame_bargasht_dakheli_tokhme_m_s+=$bargasht_dakheli;
	     $jame_bargasht_varedati_tokhme_m_s+=$bargasht_varedati; 
		 $jame_tahvilghatee_dakheli_tokhme_m_s+=$tahvilghatee_dakheli;
	     $jame_tahvilghatee_varedati_tokhme_m_s+=$tahvilghatee_varedati;
	     $jame_darrah_sayer_dakheli_tokhme_m_s+=$darrah_sayer_dakheli;
	     $jame_darrah_sayer_varedati_tokhme_m_s+=$darrah_sayer_varedati;
	     $jame_darrah_movaghat_dakheli_tokhme_m_s+=$darrah_movaghat_dakheli;
	     $jame_darrah_movaghat_varedati_tokhme_m_s+=$darrah_movaghat_varedati;
		 $jame_ersali_sayer_jabejae_dakheli_tokhme_m_s+=$ersali_sayer_jabejae_dakheli;
	     $jame_ersali_sayer_jabejae_varedati_tokhme_m_s+=$ersali_sayer_jabejae_varedati;
	     $jame_ersali_movaghat_jabejae_dakheli_tokhme_m_s+=$ersali_movaghat_jabejae_dakheli;
	     $jame_ersali_movaghat_jabejae_varedati_tokhme_m_s+=$ersali_movaghat_jabejae_varedati;
	     $jame_jabejae_amani_dakheli_tokhme_m_s+=$jabejae_amani_dakheli;
	     $jame_jabejae_amani_varedati_tokhme_m_s+=$jabejae_amani_varedati;
	     $jame_jabejae_khososi_dakheli_tokhme_m_s+=$jabejae_khososi_dakheli;
	     $jame_jabejae_khososi_varedati_tokhme_m_s+=$jabejae_khososi_varedati;
		 $jame_kasry_kol_dakheli_tokhme_m_s+=$kasry_kol_dakheli;
	     $jame_kasry_kol_varedati_tokhme_m_s+=$kasry_kol_varedati;
	     $jame_kasry_gheyremojaz_dakheli_tokhme_m_s+=$kasry_gheyremojaz_dakheli;
	     $jame_kasry_gheyremojaz_varedati_tokhme_m_s+=$kasry_gheyremojaz_varedati;
	     $jame_havale_forush_between_dakheli_tokhme_m_s+=$havale_forush_between_dakheli;
	     $jame_havale_forush_between_varedati_tokhme_m_s+=$havale_forush_between_varedati;
	     $jame_meghdar_ebtali_between_dakheli_tokhme_m_s+=$meghdar_ebtali_between_dakheli;
	     $jame_meghdar_ebtali_between_varedati_tokhme_m_s+=$meghdar_ebtali_between_varedati;
	     $jame_mande_forush_dakheli_tokhme_m_s+=$mande_forush_dakheli;
	     $jame_mande_forush_varedati_tokhme_m_s+=$mande_forush_varedati;
	     $jame_mande_forush_kol_tokhme_m_s+=$jame_mande_forush;
		 $jame_mande_anbargardani_dakheli_tokhme_m_s+=$mande_anbargardani_dakheli;
		 $jame_mande_anbargardani_varedati_tokhme_m_s+=$mande_anbargardani_varedati;
		 $jame_mande_nahayi_anbargardani_tokhme_m_s+=$jame_mande_nahayi_kala_anbargardani;
		 $jame_mande_nahayi_dakheli_tokhme_m_s+=$mande_nahayi_dakheli;
	     $jame_mande_nahayi_varedati_tokhme_m_s+=$mande_nahayi_varedati;
		 $jame_mande_nahayi_tokhme_m_s+=$jame_mande_nahayi_kala;
	     $jame_mande_pasazkasr_dakheli_tokhme_m_s+=$mande_pasazkasr_dakheli;
	     $jame_mande_pasazkasr_varedati_tokhme_m_s+=$mande_pasazkasr_varedati;
	     $jame_mande_pasazkasr_tokhme_m_s+=$mande_pasazkasr;
		 $jame_oftokasry_ezafe_dakheli_tokhme_m_s+=$oftokasry_ezafe_dakheli;
		 $jame_oftokasry_ezafe_varedati_tokhme_m_s+=$oftokasry_ezafe_varedati;
		 $jame_oftokasry_kasry_dakheli_tokhme_m_s+=$oftokasry_kasry_dakheli;
		 $jame_oftokasry_kasry_varedati_tokhme_m_s+=$oftokasry_kasry_varedati;		 
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
            echo $columns;
     }
   }//END WHILE ostan
   /*****سطر جمع تکی گروه کالا*****/
   IF($show_gav==1)
   {
	echo'
	 <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  <td colspan="4">جمع گوشت گاو</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_dakheli_gav,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_varedati_gav,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_gav,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_dakheli_gav,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_varedati_gav,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_dakheli_gav,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_varedati_gav,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_dakheli_gav,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_varedati_gav,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_dakheli_gav,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_varedati_gav,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_dakheli_gav,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_varedati_gav,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_dakheli_gav,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_varedati_gav,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_dakheli_gav,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_varedati_gav,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_gav,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_gav,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_dakheli_gav,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_varedati_gav,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_dakheli_gav,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_varedati_gav,3).'</td>
		<td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_dakheli_gav,3).'</td>
	    <td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_varedati_gav,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_dakheli_gav,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_varedati_gav,3).'</td>
		<td class="ersaly_amaniPr">'.round($jame_jabejae_amani_dakheli_gav,3).'</td>
	    <td class="ersaly_amaniPr">'.round($jame_jabejae_amani_varedati_gav,3).'</td>
		<td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_dakheli_gav,3).'</td>
	    <td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_varedati_gav,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_dakheli_gav,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_varedati_gav,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_dakheli_gav,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_varedati_gav,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_dakheli_gav,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_varedati_gav,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_dakheli_gav,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_varedati_gav,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_dakheli_gav,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_varedati_gav,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_kol_gav,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_dakheli_gav,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_varedati_gav,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_nahayi_anbargardani_gav,3).'</td>
		<td class="mandePr">'.round($jame_mande_nahayi_dakheli_gav,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_varedati_gav,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_gav,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_dakheli_gav,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_varedati_gav,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_gav,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_dakheli_gav,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_varedati_gav,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_dakheli_gav,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_varedati_gav,3).'</td>
	 </tr>'; 
   }
   IF($show_gosfand==1)
   {  
     echo'
	 <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  <td colspan="4">جمع گوشت گوسفند</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_dakheli_gosfand,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_varedati_gosfand,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_gosfand,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_dakheli_gosfand,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_varedati_gosfand,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_dakheli_gosfand,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_varedati_gosfand,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_dakheli_gosfand,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_varedati_gosfand,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_dakheli_gosfand,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_varedati_gosfand,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_dakheli_gosfand,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_varedati_gosfand,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_dakheli_gosfand,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_varedati_gosfand,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_dakheli_gosfand,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_varedati_gosfand,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_gosfand,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_gosfand,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_dakheli_gosfand,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_varedati_gosfand,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_dakheli_gosfand,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_varedati_gosfand,3).'</td>
		<td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_dakheli_gosfand,3).'</td>
	    <td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_varedati_gosfand,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_dakheli_gosfand,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_varedati_gosfand,3).'</td>
		<td class="ersaly_amaniPr">'.round($jame_jabejae_amani_dakheli_gosfand,3).'</td>
	    <td class="ersaly_amaniPr">'.round($jame_jabejae_amani_varedati_gosfand,3).'</td>
		<td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_dakheli_gosfand,3).'</td>
	    <td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_varedati_gosfand,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_dakheli_gosfand,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_varedati_gosfand,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_dakheli_gosfand,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_varedati_gosfand,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_dakheli_gosfand,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_varedati_gosfand,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_dakheli_gosfand,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_varedati_gosfand,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_dakheli_gosfand,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_varedati_gosfand,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_kol_gosfand,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_dakheli_gosfand,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_varedati_gosfand,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_nahayi_anbargardani_gosfand,3).'</td>
		<td class="mandePr">'.round($jame_mande_nahayi_dakheli_gosfand,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_varedati_gosfand,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_gosfand,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_dakheli_gosfand,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_varedati_gosfand,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_gosfand,3).'</td>
		<td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_dakheli_gosfand,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_varedati_gosfand,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_dakheli_gosfand,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_varedati_gosfand,3).'</td>
	 </tr>';   
    }
	IF($show_morgh==1)
    {
	 echo'
	 <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  <td colspan="4">جمع گوشت مرغ</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_dakheli_morgh,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_varedati_morgh,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_morgh,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_dakheli_morgh,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_varedati_morgh,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_dakheli_morgh,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_varedati_morgh,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_dakheli_morgh,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_varedati_morgh,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_dakheli_morgh,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_varedati_morgh,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_dakheli_morgh,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_varedati_morgh,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_dakheli_morgh,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_varedati_morgh,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_dakheli_morgh,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_varedati_morgh,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_morgh,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_morgh,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_dakheli_morgh,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_varedati_morgh,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_dakheli_morgh,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_varedati_morgh,3).'</td>
		<td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_dakheli_morgh,3).'</td>
	    <td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_varedati_morgh,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_dakheli_morgh,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_varedati_morgh,3).'</td>
		<td class="ersaly_amaniPr">'.round($jame_jabejae_amani_dakheli_morgh,3).'</td>
	    <td class="ersaly_amaniPr">'.round($jame_jabejae_amani_varedati_morgh,3).'</td>
		<td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_dakheli_morgh,3).'</td>
	    <td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_varedati_morgh,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_dakheli_morgh,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_varedati_morgh,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_dakheli_morgh,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_varedati_morgh,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_dakheli_morgh,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_varedati_morgh,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_dakheli_morgh,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_varedati_morgh,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_dakheli_morgh,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_varedati_morgh,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_kol_morgh,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_dakheli_morgh,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_varedati_morgh,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_nahayi_anbargardani_morgh,3).'</td>
		<td class="mandePr">'.round($jame_mande_nahayi_dakheli_morgh,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_varedati_morgh,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_morgh,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_dakheli_morgh,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_varedati_morgh,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_morgh,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_dakheli_morgh,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_varedati_morgh,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_dakheli_morgh,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_varedati_morgh,3).'</td>
	 </tr>';	
	}
	IF($show_konserv==1)
    {
	echo'
	 <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  <td colspan="4">جمع کنسرو مرغ</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_dakheli_konserv,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_varedati_konserv,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_konserv,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_dakheli_konserv,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_varedati_konserv,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_dakheli_konserv,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_varedati_konserv,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_dakheli_konserv,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_varedati_konserv,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_dakheli_konserv,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_varedati_konserv,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_dakheli_konserv,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_varedati_konserv,3).'</td>
		<td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_dakheli_konserv,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_varedati_konserv,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_dakheli_konserv,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_varedati_konserv,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_konserv,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_konserv,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_dakheli_konserv,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_varedati_konserv,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_dakheli_konserv,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_varedati_konserv,3).'</td>
		<td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_dakheli_konserv,3).'</td>
	    <td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_varedati_konserv,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_dakheli_konserv,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_varedati_konserv,3).'</td>
		<td class="ersaly_amaniPr">'.round($jame_jabejae_amani_dakheli_konserv,3).'</td>
	    <td class="ersaly_amaniPr">'.round($jame_jabejae_amani_varedati_konserv,3).'</td>
		<td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_dakheli_konserv,3).'</td>
	    <td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_varedati_konserv,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_dakheli_konserv,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_varedati_konserv,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_dakheli_konserv,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_varedati_konserv,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_dakheli_konserv,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_varedati_konserv,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_dakheli_konserv,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_varedati_konserv,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_dakheli_konserv,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_varedati_konserv,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_kol_konserv,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_dakheli_konserv,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_varedati_konserv,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_nahayi_anbargardani_konserv,3).'</td>
		<td class="mandePr">'.round($jame_mande_nahayi_dakheli_konserv,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_varedati_konserv,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_konserv,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_dakheli_konserv,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_varedati_konserv,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_konserv,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_dakheli_konserv,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_varedati_konserv,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_dakheli_konserv,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_varedati_konserv,3).'</td>
	 </tr>';
	}
	IF($show_tokhme_m==1)
    {
	 echo'
	 <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  <td colspan="4">جمع تخم مرغ خوراکی</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_dakheli_tokhme_m,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_varedati_tokhme_m,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_tokhme_m,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_dakheli_tokhme_m,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_varedati_tokhme_m,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_dakheli_tokhme_m,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_varedati_tokhme_m,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_dakheli_tokhme_m,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_varedati_tokhme_m,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_dakheli_tokhme_m,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_varedati_tokhme_m,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_dakheli_tokhme_m,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_varedati_tokhme_m,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_dakheli_tokhme_m,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_varedati_tokhme_m,3).'</td>
		<td class="bargashtPr">'.round($jame_bargasht_dakheli_tokhme_m,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_varedati_tokhme_m,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_tokhme_m,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_tokhme_m,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_dakheli_tokhme_m,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_varedati_tokhme_m,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_dakheli_tokhme_m,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_varedati_tokhme_m,3).'</td>
		<td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_dakheli_tokhme_m,3).'</td>
	    <td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_varedati_tokhme_m,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_dakheli_tokhme_m,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_varedati_tokhme_m,3).'</td>
		<td class="ersaly_amaniPr">'.round($jame_jabejae_amani_dakheli_tokhme_m,3).'</td>
	    <td class="ersaly_amaniPr">'.round($jame_jabejae_amani_varedati_tokhme_m,3).'</td>
		<td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_dakheli_tokhme_m,3).'</td>
	    <td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_varedati_tokhme_m,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_dakheli_tokhme_m,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_varedati_tokhme_m,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_dakheli_tokhme_m,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_varedati_tokhme_m,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_dakheli_tokhme_m,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_varedati_tokhme_m,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_dakheli_tokhme_m,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_varedati_tokhme_m,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_dakheli_tokhme_m,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_varedati_tokhme_m,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_kol_tokhme_m,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_dakheli_tokhme_m,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_varedati_tokhme_m,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_nahayi_anbargardani_tokhme_m,3).'</td>
		<td class="mandePr">'.round($jame_mande_nahayi_dakheli_tokhme_m,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_varedati_tokhme_m,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_tokhme_m,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_dakheli_tokhme_m,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_varedati_tokhme_m,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_tokhme_m,3).'</td>
		<td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_dakheli_tokhme_m,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_varedati_tokhme_m,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_dakheli_tokhme_m,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_varedati_tokhme_m,3).'</td>
	 </tr>';	
	}
	IF($show_tokhme_m_s==1)
    {
	 echo'
	 <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  <td colspan="4">جمع تخم مرغ صنعتی</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_dakheli_tokhme_m_s,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_varedati_tokhme_m_s,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_tokhme_m_s,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_dakheli_tokhme_m_s,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_varedati_tokhme_m_s,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_dakheli_tokhme_m_s,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_varedati_tokhme_m_s,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_dakheli_tokhme_m_s,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_varedati_tokhme_m_s,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_dakheli_tokhme_m_s,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_varedati_tokhme_m_s,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_dakheli_tokhme_m_s,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_varedati_tokhme_m_s,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_dakheli_tokhme_m_s,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_varedati_tokhme_m_s,3).'</td>
		<td class="bargashtPr">'.round($jame_bargasht_dakheli_tokhme_m_s,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_varedati_tokhme_m_s,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_tokhme_m_s,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_tokhme_m_s,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_dakheli_tokhme_m_s,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_varedati_tokhme_m_s,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_dakheli_tokhme_m_s,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_varedati_tokhme_m_s,3).'</td>
		<td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_dakheli_tokhme_m_s,3).'</td>
	    <td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_varedati_tokhme_m_s,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_dakheli_tokhme_m_s,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_varedati_tokhme_m_s,3).'</td>
		<td class="ersaly_amaniPr">'.round($jame_jabejae_amani_dakheli_tokhme_m_s,3).'</td>
	    <td class="ersaly_amaniPr">'.round($jame_jabejae_amani_varedati_tokhme_m_s,3).'</td>
		<td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_dakheli_tokhme_m_s,3).'</td>
	    <td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_varedati_tokhme_m_s,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_dakheli_tokhme_m_s,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_varedati_tokhme_m_s,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_dakheli_tokhme_m_s,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_varedati_tokhme_m_s,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_dakheli_tokhme_m_s,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_varedati_tokhme_m_s,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_dakheli_tokhme_m_s,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_varedati_tokhme_m_s,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_dakheli_tokhme_m_s,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_varedati_tokhme_m_s,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_kol_tokhme_m_s,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_dakheli_tokhme_m_s,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_varedati_tokhme_m_s,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_nahayi_anbargardani_tokhme_m_s,3).'</td>
		<td class="mandePr">'.round($jame_mande_nahayi_dakheli_tokhme_m_s,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_varedati_tokhme_m_s,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_tokhme_m_s,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_dakheli_tokhme_m_s,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_varedati_tokhme_m_s,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_tokhme_m_s,3).'</td>
		<td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_dakheli_tokhme_m_s,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_varedati_tokhme_m_s,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_dakheli_tokhme_m_s,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_varedati_tokhme_m_s,3).'</td>
	 </tr>';
	}	
   /*****سطر جمع کل استان ها*****/
   echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="4">جمع کل</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_dakheli,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor_varedati,3).'</td>
	    <td class="mande_beforPr">'.round($jame_mande_befor,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_dakheli,3).'</td>
	    <td class="tadil_ezafePr">'.round($jame_tadil_ezafe_varedati,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_dakheli,3).'</td>
	    <td class="tadil_kasryPr">'.round($jame_tadil_kasry_varedati,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_dakheli,3).'</td>
	    <td class="kharidPr">'.round($jame_kharidghatee_varedati,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_dakheli,3).'</td>
	    <td class="daryafti_Pr">'.round($jame_daryafti_jabejae_varedati,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_dakheli,3).'</td>
	    <td class="daryafti_bandarPr">'.round($jame_daryafti_banader_varedati,3).'</td>
		<td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_dakheli,3).'</td>
	    <td class="daryafti_khososiPr">'.round($jame_daryafti_khososi_varedati,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_dakheli,3).'</td>
	    <td class="bargashtPr">'.round($jame_bargasht_varedati,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_dakheli,3).'</td>
	    <td class="kalaye_darrah_sayerPr">'.round($jame_darrah_sayer_varedati,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_dakheli,3).'</td>
	    <td class="kalaye_darrah_movaghatPr">'.round($jame_darrah_movaghat_varedati,3).'</td>
		<td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_dakheli,3).'</td>
	    <td class="ersaly_sayerPr">'.round($jame_ersali_sayer_jabejae_varedati,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_dakheli,3).'</td>
	    <td class="ersaly_movaghatPr">'.round($jame_ersali_movaghat_jabejae_varedati,3).'</td>
		<td class="ersaly_amaniPr">'.round($jame_jabejae_amani_dakheli,3).'</td>
	    <td class="ersaly_amaniPr">'.round($jame_jabejae_amani_varedati,3).'</td>
		<td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_dakheli,3).'</td>
	    <td class="ersaly_khososiPr">'.round($jame_jabejae_khososi_varedati,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_dakheli,3).'</td>
	    <td class="kasry_kolPr">'.round($jame_kasry_kol_varedati,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_dakheli,3).'</td>
	    <td class="kasry_gheyrPr">'.round($jame_kasry_gheyremojaz_varedati,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_dakheli,3).'</td>
	    <td class="forushPr">'.round($jame_havale_forush_between_varedati,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_dakheli,3).'</td>
	    <td class="ebtalyPr">'.round($jame_meghdar_ebtali_between_varedati,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_dakheli,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_varedati,3).'</td>
	    <td class="mande_forushPr">'.round($jame_mande_forush_kol,3).'</td>
	    <td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_dakheli,3).'</td>
		<td class="mande_anbargardaniPr">'.round($jame_mande_anbargardani_varedati,3).'</td>
		<td class="mande_anbargardaniPr">'.round($jame_mande_nahayi_anbargardani,3).'</td>
		<td class="mandePr">'.round($jame_mande_nahayi_dakheli,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi_varedati,3).'</td>
	    <td class="mandePr">'.round($jame_mande_nahayi,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_dakheli,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr_varedati,3).'</td>
	    <td class="mande_pasaz_kasrPr">'.round($jame_mande_pasazkasr,3).'</td>
		<td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_dakheli,3).'</td>
	    <td class="ezafe_oftokasryPr">'.round($jame_oftokasry_ezafe_varedati,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_dakheli,3).'</td>
	    <td class="kasry_oftokasryPr">'.round($jame_oftokasry_kasry_varedati,3).'</td>
	 </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
  <tr class="print_footer noExl">
    <td colspan="60">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
  }//END IF//وجود اطلاعات
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
<script type="text/javascript">
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