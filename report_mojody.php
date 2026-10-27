<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_mojody.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='وضعیت موجودی سردخانه';
require_once('head.html');
IF($noe_namayesh==1)$str='(خالص)';
ELSE IF($noe_namayesh==2)$str='(ناخالص)';
ELSE IF($noe_namayesh==3)$str='(تعداد)';
ELSE IF($noe_namayesh==4)$str='(شانه)';
$columns='
	<tr class="print_table-title2" style="height:70px;">
	   <td rowspan="2" width=4%>ردیف</td>
	   <td rowspan="2" width=5%>کد کالا</td>
	   <td rowspan="2" width=10%>نام کالا</td>
	   <td rowspan="2" width=5%>زیرانبار</td>
	   <td rowspan="2" width=5%>کشور</td>
	   <td rowspan="2" width=5%>تولیدکننده</td>
	   <td colspan="3" width=9%>تاریخ تولید</td>
	   <td rowspan="2" width=6%>تاریخ ماندگاری</td>
	   <td rowspan="2" width=5%>وزن کارتن/قوطی</td>
	   <td rowspan="2" width=10%>موجودی اول دوره '.$str.'</td>
	   <td rowspan="2" width=9%>وارده طی دوره '.$str.'</td>
	   <td rowspan="2" width=9%>صادره طی دوره '.$str.'</td>
	   <td colspan="2" width=9%>تعدیل '.$str.'</td>
	   <td rowspan="2" width=9%>مانده در پایان دوره '.$str.'</td>
	</tr>
	<tr class="print_table-title2">
	 <td>سال</td>
	 <td>ماه</td>
	 <td>روز</td>
	 <td>اضافه</td>
	 <td>کسری</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$noe_namayesh;
 echo'
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
   	   <tr class="noExl"><td class="print_title_2">'.$titr.' از تاریخ : '.$date1.' تا تاریخ : '.$date2.'</td></tr>
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
	   </tr>
      </table>
	 </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=15;
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
{
	  $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
} 
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
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1">	
     <td align="left" height="40px"> از تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
     <td align="left"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
     <td align="left">از کد کالا :&nbsp;</td>
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
	 <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>&nbsp;';
     include('img_helptolid.php');
     echo'
     </td>
	</tr>
    <tr class="tr1">
	 <td align="left"> کد کارتن / قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>&nbsp;';
	  include('img_helpkartonghooti.php');
	  echo'
	 </td>
	 <td align="left"> زیرانبار :&nbsp;</td>
	 <td align="right">'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY code_ziranbar,name_ziranbar ASC","class='easyui-combobox text4' style=width:100px","").'</td>
    </tr>
    <tr class="tr1">	   
     <td align="left"> سال تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
 	 <td align="left"> ماه تولید :&nbsp;</td><td align="right">'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'</td>	
	</tr>	
	<tr class="tr1">
	 <td align="left"> روز تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
	 <td align="left"> نمایش اطلاعات :&nbsp;</td><td align="right">'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>
    </tr>
	<tr class="tr1">
	 <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme2 textbox50" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
    </tr>
    <tr class="tr1">
	    <td align="left" height="40px"> نمایش :</td><td align="right" colspan="3">&nbsp;
		'.static_listbox("namayesh_info",$namayesh_info,"namayesh_infoArr",1,"class='easyui-combobox text4' style=width:100px").'
		</td>	
    </tr> 
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
   </table>
  </td>
 </tr>
</table> ';
}
else
{
	$Condition="";
    $radif=1; 
	IF($namayesh_info==2){$table_mojody='mojody_kala_gomrok'; $Condition_info=" AND noe_tahvil_bar=9";}
    ELSE {$table_mojody='mojody_kala'; $Condition_info=" AND noe_tahvil_bar!=9";}
	if(!$code_kala)  $code_kala=$db->get_from_where("min(code_kala)","mojody_kala","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");//اگر کاربر از کد کالا را انتخاب نکرده بود
    if(!$code_kala2) $code_kala2=$db->get_from_where("max(code_kala)","mojody_kala","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");//اگر کاربر تا کد کالا را انتخاب نکرده بود
	/****************فیلترها روی گزارش******************/	
    if($code_kala) $Condition.=" and code_kala>='$code_kala'";//از کد کالا
    if($code_kala2) $Condition.=" and code_kala<='$code_kala2'";//تا کد کالا
    if($code_keshvar) $Condition.=" AND code_keshvar='$code_keshvar'";//کد کشور 
	if($code_tolidkonande)$Condition.=" AND code_tolidkonande='$code_tolidkonande'";//کد تولیدکننده  
	if($code_karton) $Condition.=" AND code_karton='$code_karton'";//کد کارتن 
	if($sal_tolid_shamsi) $Condition.=" AND sal_tolid_shamsi='$sal_tolid_shamsi'";//سال  
	if($mah_tolid_shamsi) $Condition.=" AND mah_tolid_shamsi='$mah_tolid_shamsi'";//ماه 
	if($rouz_tolid_shamsi) $Condition.=" AND rouz_tolid_shamsi='$rouz_tolid_shamsi'";
	if($code_ziranbar) {$Condition.=" and code_ziranbar='$code_ziranbar'";}//زیرانبار
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT *,
	   (SELECT name_kala FROM kala WHERE kala.code_kala=m.code_kala)nameKala,
	   (SELECT name_ziranbar FROM list_sardkhane_detail l_a_d WHERE l_a_d.code_ostan=m.code_ostan AND l_a_d.code_anbar=m.code_anbar AND l_a_d.code_ziranbar=m.code_ziranbar)nameZiranbar,
	   (SELECT name_keshvar FROM keshvar WHERE keshvar.code_keshvar=m.code_keshvar)nameKeshvar,
	   (SELECT name_tolidkonande FROM tolidkonande WHERE tolidkonande.code_tolidkonande=m.code_tolidkonande)nameTolidkonande,
	   (SELECT sharh_mandegari FROM tarikh_mandegari WHERE tarikh_mandegari.code_mandegari=m.code_mandegari)sharhMandegari
	   FROM $table_mojody m WHERE 1=1 $Condition AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by code_kala,code_ziranbar,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton asc";	 
		// $q="SELECT *,
	   // (SELECT name_kala FROM kala WHERE kala.code_kala=m.code_kala)nameKala,
	   // (SELECT name_ziranbar FROM list_sardkhane_detail l_a_d WHERE l_a_d.code_ostan=m.code_ostan AND l_a_d.code_anbar=m.code_anbar AND l_a_d.code_ziranbar=m.code_ziranbar)nameZiranbar,
	   // (SELECT SUM(vazn_khales_r) FROM resid WHERE resid.code_kala=m.code_kala AND resid.code_ostan=m.code_ostan AND resid.code_anbar=m.code_anbar AND resid.code_ziranbar=m.code_ziranbar AND resid.year=m.year AND resid.deleted=0 AND resid.status=0 AND tarikh_resid>='$date1' AND tarikh_resid<='$date2')jameVarede,
	   // (SELECT SUM(vazn_khales_h) FROM havale WHERE havale.code_kala=m.code_kala AND havale.code_ostan=m.code_ostan  AND havale.code_anbar=m.code_anbar AND havale.code_ziranbar=m.code_ziranbar AND havale.year=m.year AND havale.deleted=0 AND havale.status=0 AND tarikh_havale_anbar>='$date1' AND tarikh_havale_anbar<='$date2')jameSadere,
	   // (SELECT SUM(meghdar_tadil) FROM tadil_mojody WHERE tadil_mojody.code_kala=m.code_kala AND tadil_mojody.noe_tadil=1 AND tadil_mojody.code_ostan=m.code_ostan AND tadil_mojody.code_anbar=m.code_anbar AND tadil_mojody.code_ziranbar=m.code_ziranbar AND tadil_mojody.year=m.year AND tadil_mojody.deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2')meghdarTadil_Ezafe,	 
	   // (SELECT SUM(meghdar_tadil) FROM tadil_mojody WHERE tadil_mojody.code_kala=m.code_kala AND tadil_mojody.noe_tadil=2 AND tadil_mojody.code_ostan=m.code_ostan AND tadil_mojody.code_anbar=m.code_anbar AND tadil_mojody.code_ziranbar=m.code_ziranbar AND tadil_mojody.year=m.year AND tadil_mojody.deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2')meghdarTadil_Kasry
	   // FROM mojody_kala m WHERE 1=1 $Condition AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";	
	//echo $q;
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if($code_keshvar) {$nameKeshvar=$db->get_from_where("name_keshvar","keshvar","code_keshvar='$code_keshvar'"); $filter_string.=' کشور : '.$nameKeshvar.'&nbsp;';}     
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_karton) {$filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';}     
	 if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}     
	 if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if($mah_tolid_shamsi) {$filter_string.=' ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
     if(($code_keshvar)or($code_tolidkonande)or($code_karton)or($code_ziranbar)or($sal_tolid_shamsi)or($mah_tolid_shamsi)or($rouz_tolid_shamsi))
     {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
	  ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
	  ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
	  ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
	  /****************محاسبه مانده از قبل*******************/		  
       $mojodyAval=$db->get_from_where("SUM($avalField)","$table_mojody","code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");     
       $jameVaderebef=$db->get_from_where("SUM($residField)","resid_kala_detail r_k_d INNER JOIN resid as r ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year","r_k_d.code_kala=".$row['code_kala']." AND r_k_d.code_keshvar=".$row['code_keshvar']." AND r_k_d.code_tolidkonande=".$row['code_tolidkonande']." AND r_k_d.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND r_k_d.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND r_k_d.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND r_k_d.code_karton=".$row['code_karton']." AND r_k_d.code_mandegari='".$row['code_mandegari']."' AND r_k_d.code_ziranbar=".$row['code_ziranbar']." AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition_info AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");     
	   $jameSaderebef=$db->get_from_where("SUM($havaleField)","havale_detail h_d INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_kala=".$row['code_kala']." AND h_d.code_keshvar=".$row['code_keshvar']." AND h_d.code_tolidkonande=".$row['code_tolidkonande']." AND h_d.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND h_d.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND h_d.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND h_d.code_karton=".$row['code_karton']." AND h_d.code_mandegari='".$row['code_mandegari']."' AND h_d.code_ziranbar=".$row['code_ziranbar']." AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition_info AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");     
	   $TadilEzafebef=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=1 AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	   $TadilKasrybef=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=2 AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	   $mande_az_ghabl=$mojodyAval+$jameVaderebef-$jameSaderebef+$TadilEzafebef-$TadilKasrybef;
	  /****************محاسبات بین دوره*******************/		  
	   $jameVadere=$db->get_from_where("SUM($residField)","resid_kala_detail r_k_d INNER JOIN resid as r ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year","r_k_d.code_kala=".$row['code_kala']." AND r_k_d.code_keshvar=".$row['code_keshvar']." AND r_k_d.code_tolidkonande=".$row['code_tolidkonande']." AND r_k_d.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND r_k_d.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND r_k_d.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND r_k_d.code_karton=".$row['code_karton']." AND r_k_d.code_mandegari='".$row['code_mandegari']."' AND r_k_d.code_ziranbar=".$row['code_ziranbar']." AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition_info AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");     
	   $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail h_d INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_kala=".$row['code_kala']." AND h_d.code_keshvar=".$row['code_keshvar']." AND h_d.code_tolidkonande=".$row['code_tolidkonande']." AND h_d.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND h_d.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND h_d.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND h_d.code_karton=".$row['code_karton']." AND h_d.code_mandegari='".$row['code_mandegari']."' AND h_d.code_ziranbar=".$row['code_ziranbar']." AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition_info AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");     
	   $TadilEzafe=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=1 AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition_info AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");     
	   $TadilKasry=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=2 AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition_info AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");     
	   $mande_payane_dore=$mande_az_ghabl+$jameVadere-$jameSadere+$TadilEzafe-$TadilKasry;//مانده طی دوره انتخاب شده
       if($i++%2)echo'<tr class="print_table-odd">';
       else echo'<tr class="print_table-even">'; 
	   echo'
	       <td>'.$radif++.'</td>
	       <td>'.$row['code_kala'].'</td>
	       <td>'.$row['nameKala'].'</td>
	       <td>'.$row['nameZiranbar'].'</td>
	       <td>'.$row['nameKeshvar'].'</td>
	       <td>'.$row['nameTolidkonande'].'</td>
	       <td>'.$row['sal_tolid_shamsi'].'</td>
	       <td>'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
	       <td>'.$row['rouz_tolid_shamsi'].'</td>
	       <td>'.$row['sharhMandegari'].'</td>
	       <td>'.$row['vazn_karton_this'].'</td>';
		   IF(($noe_namayesh==1)OR($noe_namayesh==2))
	       {
	        echo'
			<td>'.round($mande_az_ghabl,3).'</td>
	        <td>'.round($jameVadere,3).'</td>
	        <td>'.round($jameSadere,3).'</td>
	        <td>'.round($TadilEzafe,3).'</td>
	        <td>'.round($TadilKasry,3).'</td>
			<td>'.round($mande_payane_dore,3).'</td>';
		   }
		   ELSE IF(($noe_namayesh==3)OR($noe_namayesh==4))
		   {
			echo'
	        <td>'.virgul($mande_az_ghabl).'</td>
	        <td>'.virgul($jameVadere).'</td>
	        <td>'.virgul($jameSadere).'</td>
	        <td>'.virgul($TadilEzafe).'</td>
	        <td>'.virgul($TadilKasry).'</td>
	        <td>'.virgul($mande_payane_dore).'</td>';			   
		   }   
	   	 echo'
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
	   $sum_mande_az_ghabl+=$mande_az_ghabl;
       $sum_jameVadere+=$jameVadere;
	   $sum_jameSadere+=$jameSadere;
	   $sum_TadilEzafe+=$TadilEzafe;
	   $sum_TadilKasry+=$TadilKasry;
	   $sum_mande_payane_dore+=$mande_payane_dore;
	  }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="11">جمع مقادیر</td>';
		IF(($noe_namayesh==1)OR($noe_namayesh==2))
		{
	     echo'
	     <td>'.round($sum_mande_az_ghabl,3).'</td>
	     <td>'.round($sum_jameVadere,3).'</td>
	     <td>'.round($sum_jameSadere,3).'</td>
	     <td>'.round($sum_TadilEzafe,3).'</td>
	     <td>'.round($sum_TadilKasry,3).'</td>
	     <td>'.round($sum_mande_payane_dore,3).'</td>';
	    }
		ELSE IF(($noe_namayesh==3)OR($noe_namayesh==4))
	    {
	     echo'
	     <td>'.virgul($sum_mande_az_ghabl).'</td>
	     <td>'.virgul($sum_jameVadere).'</td>
	     <td>'.virgul($sum_jameSadere).'</td>
	     <td>'.virgul($sum_TadilEzafe).'</td>
	     <td>'.virgul($sum_TadilKasry).'</td>
	     <td>'.virgul($sum_mande_payane_dore).'</td>';
	    }
	  echo'
	  </tr>
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنوس-->';
     require_once('prt-footer.php');
     echo' 
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