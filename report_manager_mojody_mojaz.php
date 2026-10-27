<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_mojaz.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش موجودی مجاز سردخانه ها با جزئیات';
require_once('head.html');
$columns='	  
    <tr class="print_table-title2" style="height:70px;">
	   <td rowspan="2" width=2%>ردیف</td>
	   <td rowspan="2" width=5% class="ostanPr">استان</td>
	   <td rowspan="2" width=5% class="anbarPr">سردخانه</td>
	   <td rowspan="2" width=2% class="codeKalaPr">کد کالا</td>
	   <td rowspan="2" width=8% class="nameKalaPr">نام کالا</td>
	   <td rowspan="2" width=4% class="zirAnbarPr">زیرانبار</td>
	   <td rowspan="2" width=3% class="keshvarPr">کشور</td>
	   <td rowspan="2" width=5% class="tolidkonandePr">تولیدکننده</td>
	   <td colspan="3" width=8% class="toliddatePr">تاریخ تولید</td>
	   <td rowspan="2" width=5% class="kartonPr">وزن کارتن/قوطی</td>
	   <td rowspan="2" width=5% class="mandegariPr">تاریخ ماندگاری</td>
	   <td rowspan="2" width=5% class="avalPr">موجودی اول دوره </td>
	   <td rowspan="2" width=7% class="mandePr">مانده موجودی </td>
	   <td rowspan="2" width=7% class="mandeMojazPr">مانده موجودی مجاز</td>
	   <td rowspan="2" width=8% class="soldPr">مقدار فروخته شده</td>
	   <td rowspan="2" width=4% class="ebtalPr">مقدار ابطال شده</td>
	   <td rowspan="2" width=5% class="tahvilyPr">مقدار تحویلی</td>
	   <td rowspan="2" width=7% class="mandeDetailPr">مقدار مانده از جزئیات فروش</td>
	   <td rowspan="2" width=5% class="darrahPr">کالای در راه</td>
	</tr>
	<tr class="print_table-title2">
	 <td class="toliddatePr">سال</td>
	 <td class="toliddatePr">ماه</td>
	 <td class="toliddatePr">روز</td>
	</tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$code_kala,$code_kala2,$FileName,$page;
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
	      از کد کالای : '.$code_kala.' تا کد کالای : '.$code_kala2.'&nbsp&nbsp(صفحه : '.$page.')
	     <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
	   </tr>';
	   	IF($page==1){echo'
		<tr class="noExl"><td class="print_title" style="font-size:12px;">دقت کنید : در صورتیکه بسته بندی کالا از نوع کارتنی یا لاشه است مقادیر نشان دهنده وزن خالص است و درصورتیکه بسته بندی از نوع قوطی است مقادیر نشان دهنده تعداد کالا است</td></tr>
		<tr class="noExl"><td class="print_title" style="font-size:12px;">همچنین کالای تخم مرغ و جوجه با جزئیات فروخته نمی شود بنابراین در این گزارش نمایش داده نمی شود</td></tr>';
		}
	   echo'
      </table>
     </td>
    </tr>';
}
/****************فیلترها روی گزارش******************/
/************************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $ostan_val ) 
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
/*****************************انبارها****************************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
	 $Condition_anbar_ebtal_sell.="  $Condition_anbar_ebtal_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $lastSpacePosition_ebtal_sell = strrpos($Condition_anbar_ebtal_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
     $Condition_anbar_ebtal_sell =substr($Condition_anbar_ebtal_sell,0,$lastSpacePosition_ebtal_sell);
}
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition.=""; }
else {$Condition.=" AND list_sardkhane.activate=1";}
/****************سایر فیلترها******************/	
if($code_kala)  $Condition.=" and T.code_kala>='$code_kala'";//از کد کالا
if($code_kala2) $Condition.=" and T.code_kala<='$code_kala2'";//تا کد کالا
if($code_keshvar) $Condition.=" AND T.code_keshvar='$code_keshvar'";//کد کشور 
if($code_tolidkonande)$Condition.=" AND T.code_tolidkonande='$code_tolidkonande'";//کد تولیدکننده  
if($code_karton) $Condition.=" AND T.code_karton='$code_karton'";//کد کارتن 
if($sal_tolid_shamsi) $Condition.=" AND T.sal_tolid_shamsi>='$sal_tolid_shamsi'";//سال  
if($mah_tolid_shamsi) $Condition.=" AND T.mah_tolid_shamsi>='$mah_tolid_shamsi'";//ماه 
if($rouz_tolid_shamsi) $Condition.=" AND T.rouz_tolid_shamsi>='$rouz_tolid_shamsi'";//روز
if($sal_tolid_shamsi2) $Condition.=" AND T.sal_tolid_shamsi<='$sal_tolid_shamsi2'";//سال  
if($mah_tolid_shamsi2) $Condition.=" AND T.mah_tolid_shamsi<='$mah_tolid_shamsi2'";//ماه 
if($rouz_tolid_shamsi2) $Condition.=" AND T.rouz_tolid_shamsi<='$rouz_tolid_shamsi2'";//روز
if($code_ziranbar) $Condition.=" and T.code_ziranbar='$code_ziranbar'";//زیرانبار
if($code_mandegari) $Condition.=" and T.code_mandegari='$code_mandegari'";//تاریخ ماندگاری
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=15;
if(!$ok)
{
echo'
<table width="95%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1">
     <td align="left" height="40px">از کد کالا :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
     include ("img_helpkala.php");
	 echo'
	 </td>
	 <td align="left">تا کد کالا :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" name="code_kala2" value="'.$code_kala2.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>
	 	   	   <img border="0" src="images/help.png" onClick="window.open(\'help_kala.php?inputName=code_kala2\',\'_blank\',\'width=400px,left=500px,top=100px,scrollbars=yes\')" title="جدول کد کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left" > کد کشور :&nbsp;</td>
	 <td align="right"><input class="textboxme2" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);" style="width:50px"/>&nbsp;';
     include ("img_helpkeshvar.php");
	 echo'
	 </td>
	 <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>';
     include('img_helptolid.php');
     echo'
     </td>
	</tr>
    <tr class="tr1">
	 <td align="left" height="40px"> کد کارتن / قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>&nbsp;';
	  include('img_helpkartonghooti.php');
	  echo'
	 </td>
	 <td align="left"> زیرانبار :&nbsp;</td>
	 <td align="right">'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY code_ziranbar,name_ziranbar ASC","class='easyui-combobox text4'","").'&nbsp;
    </tr>
    <tr class="tr1">	   
     <td align="left" height="40px"> از سال تولید :&nbsp;</td>
	 <td align="right" colspan="3">
	  <input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  از ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	  از روز تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/>
	 </td>	
    </tr>
	<tr class="tr1">	   
     <td align="left" height="40px">تا سال تولید :&nbsp;</td>
	 <td align="right" colspan="3">
	  <input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi2" value="'.$sal_tolid_shamsi2.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  تا ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi2",$mah_tolid_shamsi2,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	  تا روز تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi2" value="'.$rouz_tolid_shamsi2.'" maxlength="2" onkeypress="return isNumber(event)"/>
	 </td>	
    </tr>
    <tr class="tr1">	   
	  <td align="left">تاریخ ماندگاری :&nbsp;</td><td align="right" colspan="3">'.listbox("code_mandegari",$code_mandegari,"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='easyui-combobox text4' style=width:100px","").'</td>
    </tr>
    <tr class="tr1">	
     <td align="left" height="40px"><input type="checkbox" name="chkactivate"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	 <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right" ><input type="number" class="textboxme2 textbox50" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left" height="40px"> نام استان : </td>
      <td align="right"  colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" style="width:300px;" multiple>';
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
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>      
   </table>
  </td>
 </tr>
</table> ';
}
else
{
    $radif=1;
	if(!$code_kala)  $code_kala=$db->get_from_where("min(code_kala)","mojody_kala T","year='$mtActiveYear' AND deleted=0 AND (T.code_kala!=50 AND T.code_kala!=51)  AND($Condition_ostan) AND($Condition_anbar)");//اگر کاربر از کد کالا را انتخاب نکرده بود
    if(!$code_kala2) $code_kala2=$db->get_from_where("max(code_kala)","mojody_kala T","year='$mtActiveYear' AND deleted=0 AND (T.code_kala!=50 AND T.code_kala!=51) AND($Condition_ostan) AND($Condition_anbar)");//اگر کاربر تا کد کالا را انتخاب نکرده بو
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT T.*,
	   (SELECT name_ostan FROM ostan WHERE ostan.code_ostan=T.code_ostan)nameOstan,
	   (SELECT name_anbar FROM list_sardkhane WHERE list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar)nameAnbar,
	   (SELECT name_kala FROM kala WHERE kala.code_kala=T.code_kala)nameKala,
	   (SELECT name_ziranbar FROM list_sardkhane_detail l_a_d WHERE l_a_d.code_ostan=T.code_ostan AND l_a_d.code_anbar=T.code_anbar AND l_a_d.code_ziranbar=T.code_ziranbar)nameZiranbar,
	   (SELECT name_keshvar FROM keshvar WHERE keshvar.code_keshvar=T.code_keshvar)nameKeshvar,
	   (SELECT name_tolidkonande FROM tolidkonande WHERE tolidkonande.code_tolidkonande=T.code_tolidkonande)nameTolidkonande,
	   (SELECT sharh_mandegari FROM tarikh_mandegari WHERE tarikh_mandegari.code_mandegari=T.code_mandegari)sharhMandegari
	   FROM mojody_kala T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan WHERE 1=1 $Condition AND (T.code_kala!=50 AND T.code_kala!=51) AND situation_type=1 AND year='$mtActiveYear' AND deleted=0 AND($Condition_ostan) AND($Condition_anbar) order by nameOstan,nameAnbar,code_kala,code_ziranbar,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton asc";	 
    //echo $q;
	$res=$db->query($q);
	$cntr=mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    { 
	 echo'
	  <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title2"><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
		<tr class="print_table-title2 select_all">
		 <td width="5%" >استان</td>
	     <td width="5%" >سردخانه</td>
	     <td width="5%" >کد کالا</td>
	     <td width="5%" >نام کالا</td>
	     <td width="5%" >زیرانبار</td>
	     <td width="5%" >کشور</td>
	     <td width="5%" >تولیدکننده</td>
	     <td width="5%" >تاریخ تولید</td>
	     <td width="5%" >وزن کارتن/قوطی</td>
	     <td width="5%" >تاریخ ماندگاری</td>
	     <td width="5%" >موجودی اول دوره</td>
	     <td width="5%" >مانده موجودی</td>
	     <td width="7%" >مانده موجودی مجاز</td>
	     <td width="7%" >مقدار فروخته شده</td>
	     <td width="7%" >مقدار ابطال شده</td>
	     <td width="6%" >مقدار تحویلی</td>
	     <td width="8%" >مقدار مانده از جزئیات فروش</td>
	     <td width="5%" >کالای در راه</td>
	    </tr>   	
		<tr class="print_table-title2 print_table-title_small">
	     <td><input name="ostanPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="anbarPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="codeKalaPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="nameKalaPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="zirAnbarPr" class="count_sum" type="checkbox"  checked></td>
		 <td><input name="keshvarPr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="tolidkonandePr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="toliddatePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="kartonPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="mandegariPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="avalPr"  type="checkbox" checked></td>
	     <td><input name="mandePr"  type="checkbox" checked></td>
		 <td><input name="mandeMojazPr"  type="checkbox" checked></td>
		 <td><input name="soldPr" type="checkbox" checked></td>
		 <td><input name="ebtalPr" type="checkbox" checked></td>
	     <td><input name="tahvilyPr" type="checkbox" checked></td>
	     <td><input name="mandeDetailPr" type="checkbox"  checked></td>
	     <td><input name="darrahPr" type="checkbox"  checked></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
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
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if($code_keshvar) {$nameKeshvar=$db->get_from_where("name_keshvar","keshvar","code_keshvar='$code_keshvar'"); $filter_string.=' کشور : '.$nameKeshvar.'&nbsp;';}     
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_karton) {$filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';}     
	 if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}        
	 if($sal_tolid_shamsi) {$filter_string.=' از سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if($mah_tolid_shamsi) {$filter_string.=' از ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 if($rouz_tolid_shamsi) {$filter_string.=' از روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
	 if($sal_tolid_shamsi2) {$filter_string.=' تا سال : '.$sal_tolid_shamsi2.'&nbsp;';}     
	 if($mah_tolid_shamsi2) {$filter_string.=' تا ماه : '.$mahshamsiArr[$mah_tolid_shamsi2].'&nbsp;';}     
	 if($rouz_tolid_shamsi2) {$filter_string.=' تا روز : '.$rouz_tolid_shamsi2.'&nbsp;';}     
	 if($code_mandegari) {$sharhMandegari=$db->get_from_where("sharh_mandegari","tarikh_mandegari","code_mandegari='$code_mandegari'");$filter_string.=' تاریخ ماندگاری : '.$sharhMandegari.'&nbsp;';}        
	 echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  IF($row['code_bastebandy']==2){$avalField='tedad_karton_aval';$selldetail='dad_tedad_khanbar';$havaleField='tedad_karton_h_d';}
	  ELSE {$avalField='mojody_khales_aval';$selldetail='dad_vazn_khanbar';$havaleField='vazn_khales_h_d';}
	  //فیلد اول
	  $mojodyAval=$db->get_from_where("SUM($avalField)","$mydatabase.mojody_kala","code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_ziranbar=".$row['code_ziranbar']." AND code_mandegari='".$row['code_mandegari']."' AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND deleted=0");     
	  $mojodyAval=round($mojodyAval,3);
	  //فیلد دوم
	  IF($row['code_bastebandy']==2) $mojody=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);  
	  ELSE 	                         $mojody=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);  
	  $mojody=round($mojody,3);
	  //فیلد چهارم
	  $sold_this_id_without_ebtal=$db->get_from_where("SUM($selldetail)","sell.dm_anbar_det","dad_anbar_id=".$row['id']."");
	  $sold_this_id_without_ebtal=round($sold_this_id_without_ebtal,3);
	  //فیلد پنجم
	  $ebtal_this_id=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=".$row['id']."");
	  $ebtal_this_id=round($ebtal_this_id,3);
	  $sold_this_id=$sold_this_id_without_ebtal-$ebtal_this_id;
	  //فیلد ششم
	  $tahvily_detail=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","id_mojody=".$row['id']." AND status=0 AND dad_id!=''");
	  $tahvily_detail=round($tahvily_detail,3);
	  //فیلد هفتم
	  $mande_az_detail_forush=$sold_this_id-$tahvily_detail;
	  $mande_az_detail_forush=round($mande_az_detail_forush,3);
	  //فیلد سوم
	  $meghdar_mojaz=$mojody-$mande_az_detail_forush;
	  $meghdar_mojaz=round($meghdar_mojaz,3);
	  //فیلد هشتم
	  $query_find = $db->query("set session group_concat_max_len=250000");
	  $darrah_sayer=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year","h.noe_tahvil_bar=4 AND T.code_kala=".$row['code_kala']." AND T.code_keshvar=".$row['code_keshvar']." AND T.code_tolidkonande=".$row['code_tolidkonande']." AND T.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND T.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND T.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND T.code_karton=".$row['code_karton']." AND T.code_ziranbar=".$row['code_ziranbar']." AND code_mandegari='".$row['code_mandegari']."' AND T.year=".$row['year']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND T.havale_deleted=0 AND T.status=0 AND not find_in_set(h.id,(SELECT group_concat(id_havale SEPARATOR ',') FROM $mydatabase.resid WHERE code_ostan_mabda=".$row['code_ostan']." AND code_anbar_mabda=".$row['code_anbar']." AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");

	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  echo'
	       <td>'.$radif++.'</td>
		   <td class="ostanPr">'.$row['nameOstan'].'</td>
		   <td class="anbarPr">'.$row['nameAnbar'].'</td>
		   <td class="codeKalaPr">'.$row['code_kala'].'</td>
	       <td class="nameKalaPr">'.$row['nameKala'].'</td>
	       <td class="zirAnbarPr">'.$row['nameZiranbar'].'</td>
	       <td class="keshvarPr">'.$row['nameKeshvar'].'</td>
	       <td class="tolidkonandePr">'.$row['nameTolidkonande'].'</td>
	       <td class="toliddatePr">'.$row['sal_tolid_shamsi'].'</td>
	       <td class="toliddatePr">'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
	       <td class="toliddatePr">'.$row['rouz_tolid_shamsi'].'</td>
	       <td class="kartonPr">'.$row['vazn_karton_this'].'</td>
		   <td class="mandegariPr">'.$row['sharhMandegari'].'</td>
	       <td class="avalPr">'.($mojodyAval).'</td>
	       <td class="mandePr">'.($mojody).'</td>
		   <td class="mandeMojazPr">'.($meghdar_mojaz).'</td>
	       <td class="soldPr">'.($sold_this_id_without_ebtal).'</td>
	       <td class="ebtalPr">'.($ebtal_this_id).'</td>
	       <td class="tahvilyPr">'.($tahvily_detail).'</td>
	       <td class="mandeDetailPr">'.($mande_az_detail_forush).'</td>
	       <td class="darrahPr">'.round($darrah_sayer,3).'</td>
	    </tr>';
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
	  /****************محاسبه مجموع مقادیر در سطر آخر*******************/   
	   IF($row['code_bastebandy']==2)//قوطی
       {	
	    $sum_mojodyAval_ghoti+=$mojodyAval;
	    $sum_mojody_ghoti+=$mojody;
	    $sum_meghdar_mojaz_ghoti+=$meghdar_mojaz;
	    $sum_sold_this_id_without_ebtal_ghoti+=$sold_this_id_without_ebtal;
	    $sum_ebtal_this_id_ghoti+=$ebtal_this_id;
	    $sum_tahvily_detail_ghoti+=$tahvily_detail;
	    $sum_mande_az_detail_forush_ghoti+=$mande_az_detail_forush;
	    $sum_darrah_sayer_ghoti+=$darrah_sayer;  
	   }
	   ELSE//کارتن یا لاشه
	   {
		$sum_mojodyAval_kartoni+=$mojodyAval;
	    $sum_mojody_kartoni+=$mojody;
	    $sum_meghdar_mojaz_kartoni+=$meghdar_mojaz;
	    $sum_sold_this_id_without_ebtal_kartoni+=$sold_this_id_without_ebtal;
	    $sum_ebtal_this_id_kartoni+=$ebtal_this_id;
	    $sum_tahvily_detail_kartoni+=$tahvily_detail;
	    $sum_mande_az_detail_forush_kartoni+=$mande_az_detail_forush;  
	    $sum_darrah_sayer_kartoni+=$darrah_sayer;  
	   }   
	  }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td name="sum_row" colspan="13">جمع خالص (کارتنی ها یا لاشه)</td>
	    <td class="avalPr">'.round($sum_mojodyAval_kartoni,3).'</td>
	    <td class="mandePr">'.round($sum_mojody_kartoni,3).'</td>
	    <td class="mandeMojazPr">'.round($sum_meghdar_mojaz_kartoni,3).'</td>
	    <td class="soldPr">'.round($sum_sold_this_id_without_ebtal_kartoni,3).'</td>
	    <td class="ebtalPr">'.round($sum_ebtal_this_id_kartoni,3).'</td>
	    <td class="tahvilyPr">'.round($sum_tahvily_detail_kartoni,3).'</td>
	    <td class="mandeDetailPr">'.round($sum_mande_az_detail_forush_kartoni,3).'</td>
	    <td class="darrahPr">'.round($sum_darrah_sayer_kartoni,3).'</td>
	   </tr>
	   <tr class="print_table-even sum-row-white-b">
	    <td name="sum_row" colspan="13">جمع تعداد (قوطی ها)</td>
	    <td class="avalPr">'.virgul($sum_mojodyAval_ghoti).'</td>
	    <td class="mandePr">'.virgul($sum_mojody_ghoti).'</td>
	    <td class="mandeMojazPr">'.virgul($sum_meghdar_mojaz_ghoti).'</td>
	    <td class="soldPr">'.virgul($sum_sold_this_id_without_ebtal_ghoti).'</td>
	    <td class="ebtalPr">'.virgul($sum_ebtal_this_id_ghoti).'</td>
	    <td class="tahvilyPr">'.virgul($sum_tahvily_detail_ghoti).'</td>
	    <td class="mandeDetailPr">'.virgul($sum_mande_az_detail_forush_ghoti).'</td>
	    <td class="darrahPr">'.virgul($sum_darrah_sayer_ghoti).'</td>
	   </tr>';
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
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {    
		//نمایش ستونها
	    $("input:checkbox:not(:checked)").each(function() {
         var column = "table ." + $(this).attr("name");
         $(column).hide();
        });
        $("input:checkbox").click(function(){
         var column = "table ." + $(this).attr("name");
         $(column).toggle();
         var count_for_sum=13;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var count_for_sum=count_for_sum-numberNotChecked;
		 $("[name=sum_row]").attr("colspan",count_for_sum);
        }); 
}); 
</script>