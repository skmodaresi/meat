<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_daryafti.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش جزئیات مقادیر دریافتی';
require_once('head.html');
/****************هدر******************/
$columns='
	   <tr class="print_table-title2">
	    <td width=2% rowspan="2">ردیف</td>
	    <td width=9% rowspan="2">سردخانه مقصد</td>
	    <td width=5% rowspan="2">شماره رسید</td>
		<td width=5% rowspan="2">تاریخ دریافت</td>
	    <td width=6% rowspan="2">استان مبدأ</td>
	    <td width=10% rowspan="2">سردخانه مبدأ</td>
	    <td width=9% rowspan="2">نام کالا</td>
	    <td width=8% rowspan="2">تاریخ تولید</td>
	    <td width=5% rowspan="2">تولید کننده</td>
	    <td width=12% colspan="4">مقادیر دریافتی</td>
	    <td width=6% rowspan="2">شماره حواله مرتبط</td>
	    <td width=5% rowspan="2">تاریخ حواله</td>
		<td width=6% rowspan="2">شماره مجوز جابه جایی</td>
		<td width=12% colspan="4">مقادیر حواله</td>
	   </tr>
	   <tr class="print_table-title2">
	    <td>تعداد</td>
	    <td>شانه</td>
	    <td>ناخالص</td>
	    <td>خالص</td>
		<td>تعداد</td>
	    <td>شانه</td>
	    <td>ناخالص</td>
	    <td>خالص</td>
	   </tr>';
Function print_header()
{global $titr,$name_ostan_maghsad,$group_name,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'
  <br>   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
	   <tr class="noExl"><td class="print_title_2">'.$titr.' '.$group_name.' به  '.$name_ostan_maghsad.' </td></tr>
	   <tr class="noExl">	
		<td class="print_title_2">';
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo'
		 از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
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
if(!$MaxLines) $MaxLines=15;
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
//اضافه کردن صفر پشت کد استان		
if(strlen($mt_gl_code_ostan)==1) {$code_a=make_pattern($mt_gl_code_ostan,2);}
else{$code_a=$mt_gl_code_ostan;}
if(!$ok)
{
 echo'
 <table width="95%" align="center" cellpadding="0" cellspacing="0">
  <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
   <td height="100%">
    <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
     <tr class="tr1" style="height:45px;">	
      <td align="left"> از تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	 </tr>
	 <tr class="tr1">
      <td align="left"><span class="star">*</span> گروه کالا :&nbsp;</td><td align="right">'.listboxMe("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='easyui-combobox text4' style=width:100px data-options=panelHeight:170").'</td>';
	  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))echo'<td align="left"><span class="star">*</span> استان مقصد  :&nbsp;</td><td align="right">'.listbox("code_ostan_maghsad",$code_ostan_maghsad,"code_ostan","name_ostan","ostan","1=1 ORDER BY name_ostan ASC"," class='easyui-combobox text4'","").'</td>';
	  else echo'<td align="left"><span class="star">*</span> استان مقصد  :&nbsp;</td><td align="right">'.listboxMe("code_ostan_maghsad",$code_ostan_maghsad,"code_ostan","name_ostan","ostan","code_ostan='$mt_gl_code_ostan' ORDER BY name_ostan ASC","disabled class=' text4' style=width:100px","").'<input type="hidden" name="code_ostan_maghsad" value="'.$mt_gl_code_ostan.'" /></td>';
	 echo'
	 </tr>
	 <tr class="tr1">
	  <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت </td>
	  <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	 </tr>
	 <tr class="tr1">
	  <td align="left" height="40px"> تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>	
	 </tr>
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    </table>
   </td>
  </tr>
 </table>';
}
else
{
    if(!$code_ostan_maghsad){echo"<script>alert('لطفاً استان مقصد را انتخاب نمائید !')</script>";
                   echo"<script>window.location='$FileName';</script>";}
    $name_ostan_maghsad=$db->get_from_where("name_ostan","ostan","code_ostan='".$code_ostan_maghsad."'");     
    $group_name=$db->get_from_where("name_group_kala_top","bzacc.group_kala_top","code_group_kala_top='".$code_group_kala_top."'");     
	$dateCond="";
	$Condition="";
    /****************فیلترها روی گزارش*******************/		
	if($date1) $Condition.=" and r.tarikh_resid>='$date1'";
    if($date2) $Condition.=" and r.tarikh_resid<='$date2'";
	/******************نمایش یا عدم نمایش سردخانه های موقت******************/
    if($chkmovaghat=='on') $Condition_movaghat="";
    else $Condition_movaghat="AND ls1.situation_type=1";
	/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
    if($chkactivate=='on') {$Condition_anbar_activate="";}
    else {$Condition_anbar_activate="AND ls1.activate=1"; }
/****************شروع نمایش گزارش*******************/	
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
    $radif=1;
	$sum=0;//مجموع 
	$sum_tedad=0;//مجموع
    $sum_resid=0;
    $sum_tedad_resid=0;

	$q="SELECT r_k_d.*,tarikh_resid,kala.code_group_kala_top,ostan.name_ostan AS name_ostan_mabda,ls1.name_anbar AS name_anbar_maghsad,ls2.name_anbar AS name_anbar_mabda,
	    havale.id,havale.shomare_havale_anbar,havale.tarikh_havale_anbar,havale.shomare_jabejae,tedad_karton_h_d,tedad_shane_h_d,vazn_nakhales_h_d,vazn_khales_h_d 
	    FROM resid_kala_detail r_k_d
	    INNER JOIN resid r ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year
	    INNER JOIN ostan ON ostan.code_ostan=r.code_ostan_mabda    
	    INNER JOIN list_sardkhane ls1 ON ls1.code_ostan=r.code_ostan AND ls1.code_anbar=r.code_anbar     
	    INNER JOIN list_sardkhane ls2 ON ls2.code_ostan=r.code_ostan_mabda AND ls2.code_anbar=r.code_anbar_mabda     
	    INNER JOIN kala ON kala.code_kala=r_k_d.code_kala    
        INNER JOIN havale ON havale.id=r.id_havale
        INNER JOIN havale_detail h_d ON havale.shomare_havale_anbar=h_d.shomare_havale_anbar AND havale.code_ostan=h_d.code_ostan AND havale.code_anbar=h_d.code_anbar AND havale.year=h_d.year
        AND h_d.code_kala=r_k_d.code_kala AND h_d.code_keshvar=r_k_d.code_keshvar AND h_d.code_tolidkonande=r_k_d.code_tolidkonande AND h_d.sal_tolid_shamsi=r_k_d.sal_tolid_shamsi AND h_d.mah_tolid_shamsi=r_k_d.mah_tolid_shamsi AND h_d.rouz_tolid_shamsi=r_k_d.rouz_tolid_shamsi AND h_d.code_karton=r_k_d.code_karton
  		
		WHERE 1=1 $Condition_movaghat $Condition_anbar_activate $Condition AND (r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r_k_d.code_ostan='$code_ostan_maghsad' AND r_k_d.year='$mtActiveYear' AND kala.code_group_kala_top='$code_group_kala_top' AND r.status=0 ORDER By tarikh_resid,shomare_resid";
	
	//echo $q;
	$res=$db->query($q);
    $cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)//وجود داشتن
	{
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/ 
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت -';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت -';
     if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال ';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال ';
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
     {
	  if(strlen($row_resid['code_ostan'])==1) $code_ostan_maghsad=make_pattern($row_resid['code_ostan'],2);
      else $code_ostan_maghsad=$row_resid['code_ostan'];
	  
	 
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  //اضافه کردن صفر پشت کد استان
	  if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
      else $code_a=$row['code_ostan'];
	  $name_kala=$db->get_from_where("name_kala","kala","code_kala='".$row['code_kala']."'");     
	  $code_bastebandy=$db->get_from_where("code_bastebandy","kala","code_kala='".$row['code_kala']."'");     
	  $name_tolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='".$row['code_tolidkonande']."'");     
	  echo'  
	    <td>'.$radif++.'</td>
	    <td>'.$row['name_anbar_maghsad'].'</td>
	    <td>'.$code_a.$row['code_anbar'].$row['shomare_resid'].'</td>
	    <td>'.$row['tarikh_resid'].'</td>
	    <td>'.$row['name_ostan_mabda'].'</td>
	    <td>'.$row['name_anbar_mabda'].'</td>
		<td>'.$name_kala.'</td>
	    <td>'.$row['rouz_tolid_shamsi'].' '.$mahshamsiArr[$row['mah_tolid_shamsi']].' '.$row['sal_tolid_shamsi'].'</td>
	    <td>'.$name_tolidkonande.'</td>
	    <td>'.virgul($row['tedad_karton_r_d_sub']).'</td>
	    <td>'.virgul($row['tedad_shane_r_d_sub']).'</td>
		<td>'.round($row['vazn_nakhales_r_d_sub'],3).'</td>
		<td>'.round($row['vazn_khales_r_d_sub'],3).'</td>
		<td>'.$code_a.$row['code_anbar'].$row['shomare_havale_anbar'].'</td>
		<td>'.$row['tarikh_havale_anbar'].'</td>
		<td>'.$row['shomare_jabejae'].'</td>';
		echo'<td>'.virgul($row['tedad_karton_h_d']).'</td>';
		echo'<td>'.virgul($row['tedad_shane_h_d']).'</td>';
		echo'<td>'.round($row['vazn_nakhales_h_d'],3).'</td>';
		echo'<td>'.round($row['vazn_khales_h_d'],3).'</td>';
		echo'
		</tr>';
		if($line>=$MaxLines && $i<$cntr)//تکرار هدر در صفحات بعد
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
	 $sum_tedad+=$row['tedad_karton_r_d_sub'];
	 $sum_shane+=$row['tedad_shane_r_d_sub'];
	 $sum_nakhales+=$row['vazn_nakhales_r_d_sub'];
	 $sum_khales+=$row['vazn_khales_r_d_sub'];
	 $sum+=$row['vazn_khales_h_d'];
     $sum_tedad_havale+=$row['tedad_karton_h_d'];
     $sum_shane_havale+=$row['tedad_shane_h_d'];
     $sum_nakhales_havale+=$row['vazn_nakhales_h_d'];
     $sum_khales_havale+=$row['vazn_khales_h_d'];
     
	 }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">';
	   echo'<td colspan="9">جمع مقادیر</td>
	   <td>'.virgul($sum_tedad).'</td>
	   <td>'.virgul($sum_shane).'</td>
	   <td>'.round($sum_nakhales,3).'</td>
	   <td>'.round($sum_khales,3).'</td>
	   <td></td><td></td><td></td>
	   <td>'.virgul($sum_tedad_havale).'</td>
	   <td>'.virgul($sum_shane_havale).'</td>
	   <td>'.round($sum_nakhales_havale,3).'</td>
	   <td>'.round($sum_khales_havale,3).'</td>';
	   echo'
	  </tr>
	 <!--پايان مرکز صفحه -->
     <!-- چاپ زیرنوس-->';
     require_once('prt-footer.php');
     echo' 
     </table>'; 
	}//END IF //وجود داشتن
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