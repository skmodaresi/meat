<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_mojody_mojaz.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش موجودی مجاز سردخانه';
require_once('head.html');
$columns='	  
    <tr class="print_table-title2" style="height:70px;">
	   <td rowspan="2" width=2%>ردیف</td>
	   <td rowspan="2" width=5%>شناسه</td>
	   <td rowspan="2" width=3%>کد کالا</td>
	   <td rowspan="2" width=9%>نام کالا</td>
	   <td rowspan="2" width=4%>زیرانبار</td>
	   <td rowspan="2" width=4%>کشور</td>
	   <td rowspan="2" width=5%>تولیدکننده</td>
	   <td colspan="3" width=10%>تاریخ تولید</td>
	   <td rowspan="2" width=6%>تاریخ ماندگاری</td>
	   <td rowspan="2" width=5%>وزن کارتن/قوطی</td>
	   <td rowspan="2" width=5%>موجودی اول دوره </td>
	   <td rowspan="2" width=8%>مانده موجودی </td>
	   <td rowspan="2" width=8%>مانده موجودی مجاز</td>
	   <td rowspan="2" width=8%>مقدار فروخته شده</td>
	   <td rowspan="2" width=5%>مقدار ابطال شده</td>
	   <td rowspan="2" width=5%>مقدار تحویلی</td>
	   <td rowspan="2" width=8%>مقدار مانده از جزئیات فروش</td>
	</tr>
	<tr class="print_table-title2">
	 <td>سال</td>
	 <td>ماه</td>
	 <td>روز</td>
	</tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$code_kala,$code_kala2,$FileName,$page;
 echo'
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
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
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
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
	 <td align="left"> کد کارتن / قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>&nbsp;';
	  include('img_helpkartonghooti.php');
	  echo'
	 </td>
	 <td align="left"> زیرانبار :&nbsp;</td>
	 <td align="right">'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY code_ziranbar,name_ziranbar ASC","class='easyui-combobox text4'","").'&nbsp;
    </tr>
    <tr class="tr1">	   
     <td align="left"> سال تولید :&nbsp;</td>
	 <td align="right" colspan="3">
	  <input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	  روز تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/>
	 </td>	
	 <!--<td align="left"> نمایش اطلاعات :&nbsp;</td><td align="right">'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>-->
    </tr>
	<tr class="tr1">
	 <td align="left" height="40px"> تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme2 textbox50" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
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
    if($noe_namayesh==1)$str='(خالص)';
    if($noe_namayesh==2)$str='(ناخالص)';
    if($noe_namayesh==3)$str='(تعداد)';	
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
	   FROM mojody_kala m WHERE 1=1 $Condition AND (m.code_kala!=50 AND m.code_kala!=51) AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by code_kala,code_ziranbar,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton asc";	 
	//echo $q;
	$res=$db->query($q);
	$cntr=mysql_num_rows($res);
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
		if($i++%2)echo'<tr class="print_table-odd">';
        else echo'<tr class="print_table-even">'; 
		echo'
	       <td>'.$radif++.'</td>
		   <td>'.$row['id'].'</td>
		   <td>'.$row['code_kala'].'</td>
	       <td>'.$row['nameKala'].'</td>
	       <td>'.$row['nameZiranbar'].'</td>
	       <td>'.$row['nameKeshvar'].'</td>
	       <td>'.$row['nameTolidkonande'].'</td>
	       <td>'.$row['sal_tolid_shamsi'].'</td>
	       <td>'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
	       <td>'.$row['rouz_tolid_shamsi'].'</td>
	       <td>'.$row['sharhMandegari'].'</td>
	       <td>'.$row['vazn_karton_this'].'</td>
	       <td>'.($mojodyAval).'</td>
	       <td>'.($mojody).'</td>
		   <td>'.($meghdar_mojaz).'</td>
	       <td>'.($sold_this_id_without_ebtal).'</td>
	       <td>'.($ebtal_this_id).'</td>
	       <td>'.($tahvily_detail).'</td>
	       <td>'.($mande_az_detail_forush).'</td>';
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
	   IF($row['code_bastebandy']==2)//قوطی
       {	
	    $sum_mojodyAval_ghoti+=$mojodyAval;
	    $sum_mojody_ghoti+=$mojody;
	    $sum_meghdar_mojaz_ghoti+=$meghdar_mojaz;
	    $sum_sold_this_id_without_ebtal_ghoti+=$sold_this_id_without_ebtal;
	    $sum_ebtal_this_id_ghoti+=$ebtal_this_id;
	    $sum_tahvily_detail_ghoti+=$tahvily_detail;
	    $sum_mande_az_detail_forush_ghoti+=$mande_az_detail_forush;
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
	   }   
	  }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="12">جمع خالص (کارتنی ها یا لاشه)</td>
	    <td>'.round($sum_mojodyAval_kartoni,3).'</td>
	    <td>'.round($sum_mojody_kartoni,3).'</td>
	    <td>'.round($sum_meghdar_mojaz_kartoni,3).'</td>
	    <td>'.round($sum_sold_this_id_without_ebtal_kartoni,3).'</td>
	    <td>'.round($sum_ebtal_this_id_kartoni,3).'</td>
	    <td>'.round($sum_tahvily_detail_kartoni,3).'</td>
	    <td>'.round($sum_mande_az_detail_forush_kartoni,3).'</td>
	   </tr>
	   <tr class="print_table-even sum-row-white-b">
	    <td colspan="12">جمع تعداد (قوطی ها)</td>
	    <td>'.virgul($sum_mojodyAval_ghoti).'</td>
	    <td>'.virgul($sum_mojody_ghoti).'</td>
	    <td>'.virgul($sum_meghdar_mojaz_ghoti).'</td>
	    <td>'.virgul($sum_sold_this_id_without_ebtal_ghoti).'</td>
	    <td>'.virgul($sum_ebtal_this_id_ghoti).'</td>
	    <td>'.virgul($sum_tahvily_detail_ghoti).'</td>
	    <td>'.virgul($sum_mande_az_detail_forush_ghoti).'</td>
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