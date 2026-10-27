<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_mojody.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='وضعیت موجودی سردخانه براساس فروشنده';
require_once('head.html');
IF($noe_namayesh==1)$str='(خالص)';
ELSE IF($noe_namayesh==2)$str='(ناخالص)';
ELSE IF($noe_namayesh==3)$str='(تعداد)';
ELSE IF($noe_namayesh==4)$str='(شانه)';
$columns='
	<tr class="print_table-title2" style="height:70px;">
	   <td rowspan="2" width=3%>ردیف</td>
	   <td rowspan="2" width=5% class="code_skkPr">کد فروشنده</td>
	   <td rowspan="2" width=5% class="name_skkPr">نام فروشنده</td>
	   <td rowspan="2" width=5% class="sh_residPr">شماره رسید</td>
	   <td rowspan="2" width=3% class="code_kalaPr">کد کالا</td>
	   <td rowspan="2" width=9% class="name_kalaPr">نام کالا</td>
	   <td rowspan="2" width=5% class="ziranbarPr">زیرانبار</td>
	   <td rowspan="2" width=3% class="keshvarPr">کشور</td>
	   <td rowspan="2" width=5% class="tolidkonandePr">تولیدکننده</td>
	   <td colspan="3" width=10% class="tarikh_tolidPr">تاریخ تولید</td>
	   <td rowspan="2" width=5% class="mandegariPr">تاریخ ماندگاری</td>
	   <td rowspan="2" width=5% class="vazn_k_ghPr">وزن کارتن/قوطی</td>
	   <td rowspan="2" width=5% class="mande_beforPr">موجودی اول دوره '.$str.'</td>
	   <td rowspan="2" width=10% class="varedePr">وارده طی دوره '.$str.'</td>
	   <td rowspan="2" width=10% class="saderePr">صادره طی دوره '.$str.'</td>
	   <td colspan="2" width=7% class="tadilPr">تعدیل '.$str.'</td>
	   <td rowspan="2" width=10% class="mandePr">مانده در پایان دوره '.$str.'</td>
	</tr>
	<tr class="print_table-title2">
	 <td class="tarikh_tolidPr">سال</td>
	 <td class="tarikh_tolidPr">ماه</td>
	 <td class="tarikh_tolidPr">روز</td>
	 <td class="tadilPr">اضافه</td>
	 <td class="tadilPr">کسری</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$noe_namayesh,$namayesh_info;
 IF($namayesh_info==2) $info='نمایش : تحت کلید گمرک';
 ELSE $info='نمایش : سایر';
 echo'
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
	    از کد کالای : '.$code_kala.' تا کد کالای : '.$code_kala2.'&nbsp&nbsp(صفحه : '.$page.') -'.$info.'
	    <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>  
	   </tr>
      </table>
	 </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
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
	 <td align="left"> کد فروشنده / کشتی :&nbsp;</td>
	 <td align="right"><input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onkeypress="return isNumber(event)" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)" style="width:50px;"/>';
	 include("img_helpskk.php");
	echo'
	 <td colspan="2">&nbsp;</td>
	 <!--<td align="left"> شماره سفر :&nbsp;</td><td align="right"><select class="text4" name="id_safar"><option value="0">انتخاب کنيد</option></select></td>-->
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
	if($code_skk) $Condition.=" AND r.code_skk='$code_skk'";
	if($code_kala) $Condition.=" AND r_k_d.code_kala>='$code_kala'";//از کد کالا
    if($code_kala2) $Condition.=" AND r_k_d.code_kala<='$code_kala2'";//تا کد کالا
	if($code_keshvar) $Condition.=" AND r_k_d.code_keshvar='$code_keshvar'";//کد کشور 
	if($code_tolidkonande)$Condition.=" AND r_k_d.code_tolidkonande='$code_tolidkonande'";//کد تولیدکننده  
	if($code_karton) $Condition.=" AND r_k_d.code_karton='$code_karton'";//کد کارتن 
	if($sal_tolid_shamsi) $Condition.=" AND r_k_d.sal_tolid_shamsi='$sal_tolid_shamsi'";//سال  
	if($mah_tolid_shamsi) $Condition.=" AND r_k_d.mah_tolid_shamsi='$mah_tolid_shamsi'";//ماه 
	if($rouz_tolid_shamsi) $Condition.=" AND r_k_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";
	if($code_ziranbar) {$Condition.=" AND r_k_d.code_ziranbar='$code_ziranbar'";}//زیرانبار
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT *,sharh_mandegari,
	   (SELECT name_kala FROM kala WHERE kala.code_kala=r_k_d.code_kala)nameKala,
	   (SELECT name_ziranbar FROM list_sardkhane_detail l_a_d WHERE l_a_d.code_ostan=r_k_d.code_ostan AND l_a_d.code_anbar=r_k_d.code_anbar AND l_a_d.code_ziranbar=r_k_d.code_ziranbar)nameZiranbar,
	   (SELECT name_keshvar FROM keshvar WHERE keshvar.code_keshvar=r_k_d.code_keshvar)nameKeshvar,
	   (SELECT name_tolidkonande FROM tolidkonande WHERE tolidkonande.code_tolidkonande=r_k_d.code_tolidkonande)nameTolidkonande
		FROM resid r 
	    INNER JOIN resid_detail AS r_d ON r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year
        INNER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year 
		INNER JOIN mt_skk ON r.code_skk=mt_skk.code_skk
		INNER JOIN tarikh_mandegari ON r_k_d.code_mandegari=tarikh_mandegari.code_mandegari
		WHERE 1=1 $Condition $Condition_info  AND r.code_ostan='$mt_gl_code_ostan' AND r.code_anbar='$mt_gl_code_anbar' AND r.year='$mtActiveYear' AND r.deleted=0 AND r.status=0 order by tarikh_resid asc";	 
      
	//echo $q;
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
	 echo'
	  <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title"><td colspan="16">وضعیت نمایش ستونها در گزارش '.$str.'</td></tr>
      	<tr class="print_table-title2">
		 <td width="9%">کد فروشنده/کشتی </td>
		 <td width="9%">نام فروشنده/کشتی </td>
		 <td width="5%">شماره رسید </td>
		 <td width="5%">کد کالا </td>
		 <td width="5%">نام کالا </td>
		 <td width="5%">زیرانبار </td>
		 <td width="5%">کشور </td>
		 <td width="5%">تولیدکننده </td>
		 <td width="5%">تاریخ تولید </td>
		 <td width="5%">تاریخ ماندگاری </td>
		 <td width="8%">وزن کارتن/قوطی </td>
		 <td width="8%">موجودی اول دوره </td>
	     <td width="8%" >وارده طی دوره</td>
	     <td width="8%" >صادره طی دوره</td>
		 <td width="5%" >تعدیل</td>
		 <td width="9%" >مانده در پایان دوره</td>
	    </tr>   	
		<tr class="print_table-title2">
	     <td><input name="code_skkPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="name_skkPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="sh_residPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="code_kalaPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="name_kalaPr" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="ziranbarPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="keshvarPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="tolidkonandePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="tarikh_tolidPr" class="count_sum_tarikh" type="checkbox" checked ></td>
	     <td><input name="mandegariPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="vazn_k_ghPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="mande_beforPr" type="checkbox" checked ></td>
	     <td><input name="varedePr" type="checkbox" checked ></td>
	     <td><input name="saderePr" type="checkbox" checked ></td>
		 <td><input name="tadilPr" type="checkbox" checked></td>
		 <td><input name="mandePr" type="checkbox" checked ></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if($code_skk) {$nameKeshty=$db->get_from_where("name_skk","mt_skk","code_skk='$code_skk'");$filter_string.=' نام فروشنده/کشتی : '.$nameKeshty.'&nbsp;';}     
	 if($code_keshvar) {$nameKeshvar=$db->get_from_where("name_keshvar","keshvar","code_keshvar='$code_keshvar'"); $filter_string.=' کشور : '.$nameKeshvar.'&nbsp;';}     
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_karton) {$filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';}     
	 if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}     
	 if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if($mah_tolid_shamsi) {$filter_string.=' ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
     IF($code_skk OR $code_keshvar OR $code_tolidkonande OR $code_karton OR $code_ziranbar OR $sal_tolid_shamsi OR $mah_tolid_shamsi OR $rouz_tolid_shamsi)
	 IF($namayesh_info==2) {$filter_string.=' نمایش : تحت کلید گمرک';}	 
     echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  //اضافه کردن صفر پشت کد استان
	  if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
      else $code_a=$row['code_ostan'];
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
	  ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
	  ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
	  ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
	  /****************محاسبه مانده از قبل*******************/		  
        $mojodyKhalesAval=$db->get_from_where("SUM($avalField)","$table_mojody","code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");     
        $jameKhalesVaderebef=$db->get_from_where("SUM($residField)","resid_kala_detail r_k_d INNER JOIN resid as r ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year","r_k_d.code_kala=".$row['code_kala']." AND r_k_d.code_keshvar=".$row['code_keshvar']." AND r_k_d.code_tolidkonande=".$row['code_tolidkonande']." AND r_k_d.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND r_k_d.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND r_k_d.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND r_k_d.code_karton=".$row['code_karton']." AND r_k_d.code_mandegari='".$row['code_mandegari']."' AND r_k_d.code_ziranbar=".$row['code_ziranbar']." AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition_info AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid<'$date1'");     
	    $jameKhalesSaderebef=$db->get_from_where("SUM($havaleField)","havale_detail h_d INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_kala=".$row['code_kala']." AND h_d.code_keshvar=".$row['code_keshvar']." AND h_d.code_tolidkonande=".$row['code_tolidkonande']." AND h_d.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND h_d.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND h_d.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND h_d.code_karton=".$row['code_karton']." AND h_d.code_mandegari='".$row['code_mandegari']."' AND h_d.code_ziranbar=".$row['code_ziranbar']." AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition_info AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");     
		$khalesTadilEzafebef=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=1 AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition_info AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	    $khalesTadilKasrybef=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=2 AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition_info AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	    $mande_az_ghabl=$mojodyKhalesAval+$jameKhalesVaderebef-$jameKhalesSaderebef+$khalesTadilEzafebef-$khalesTadilKasrybef;
	  /****************محاسبات بین دوره*******************/		  
	    $jameVadere=$db->get_from_where("SUM($residField)","resid_kala_detail r_k_d INNER JOIN resid as r ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year","r_k_d.code_kala=".$row['code_kala']." AND r_k_d.code_keshvar=".$row['code_keshvar']." AND r_k_d.code_tolidkonande=".$row['code_tolidkonande']." AND r_k_d.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND r_k_d.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND r_k_d.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND r_k_d.code_karton=".$row['code_karton']." AND r_k_d.code_mandegari='".$row['code_mandegari']."' AND r_k_d.code_ziranbar=".$row['code_ziranbar']." AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition_info AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");     
	    $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail h_d INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_kala=".$row['code_kala']." AND h_d.code_keshvar=".$row['code_keshvar']." AND h_d.code_tolidkonande=".$row['code_tolidkonande']." AND h_d.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND h_d.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND h_d.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND h_d.code_karton=".$row['code_karton']." AND h_d.code_mandegari='".$row['code_mandegari']."' AND h_d.code_ziranbar=".$row['code_ziranbar']." AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition_info AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");     
		$TadilEzafe=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=1 AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition_info AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");     
	    $TadilKasry=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=2 AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ziranbar=".$row['code_ziranbar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition_info AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");     
		$mande_payane_dore=$mande_az_ghabl+$jameVadere-$jameSadere+$TadilEzafe-$TadilKasry;//مانده طی دوره انتخاب شده

	    echo'
	  	   <td >'.$radif++.'</td>
	       <td class="code_skkPr">'.$row['code_skk'].'</td>
	       <td class="name_skkPr">'.$row['name_skk'].'</td>
	       <td class="sh_residPr">'.$code_a.$row['code_anbar'].$row['shomare_resid'].'</td>
	       <td class="code_kalaPr">'.$row['code_kala'].'</td>
	       <td class="name_kalaPr">'.$row['nameKala'].'</td>
	       <td class="ziranbarPr">'.$row['nameZiranbar'].'</td>
	       <td class="keshvarPr">'.$row['nameKeshvar'].'</td>
	       <td class="tolidkonandePr">'.$row['nameTolidkonande'].'</td>
	       <td class="tarikh_tolidPr">'.$row['sal_tolid_shamsi'].'</td>
	       <td class="tarikh_tolidPr">'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
	       <td class="tarikh_tolidPr">'.$row['rouz_tolid_shamsi'].'</td>
	       <td class="mandegariPr">'.$row['sharh_mandegari'].'</td>
	       <td class="vazn_k_ghPr">'.$row['vazn_karton_this'].'</td>
		   <td class="mande_beforPr">'.round($mande_az_ghabl,3).'</td>
	       <td class="varedePr">'.round($jameVadere,3).'</td>
	       <td class="saderePr">'.round($jameSadere,3).'</td>
	       <td class="tadilPr">'.round($TadilEzafe,3).'</td>
	       <td class="tadilPr">'.round($TadilKasry,3).'</td>
	       <td class="mandePr">'.round($mande_payane_dore,3).'</td>
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
	   $sumTadilEzafe+=$TadilEzafe;
	   $sumTadilKasry+=$TadilKasry;
	   $sum_mande_payane_dore+=$mande_payane_dore;
	  }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td id="sum_row" colspan="14">جمع مقادیر</td>
	    <td class="mande_beforPr">'.round($sum_mande_az_ghabl,3).'</td>
	    <td class="varedePr">'.round($sum_jameVadere,3).'</td>
	    <td class="saderePr">'.round($sum_jameSadere,3).'</td>
	    <td class="tadilPr">'.round($sumTadilEzafe,3).'</td>
	    <td class="tadilPr">'.round($sumTadilKasry,3).'</td>
	    <td class="mandePr">'.round($sum_mande_payane_dore,3).'</td>
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
         var count_for_sum=14;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var numberNotChecked_tarikh  = $(".count_sum_tarikh:not(:checked)").length; //tarikh_tolid 3 ta sotun ast 
		 var count_for_sum=count_for_sum-numberNotChecked-(numberNotChecked_tarikh*3);
		 $("#sum_row").attr("colspan",count_for_sum);
        }); 	  		
});
</script>