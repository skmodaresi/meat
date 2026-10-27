<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_tadil.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش براساس تعدیل موجودی';
require_once('head.html');
$columns='	
    <tr class="print_table-title2">
	 <td rowspan="2" width="5%">ردیف</td>
	 <td rowspan="2" width="8%">شماره برگه تعدیل</td>
	 <td rowspan="2" width="7%">تاریخ تعدیل</td>
	 <td rowspan="2" width="10%">کالا</td>	
	 <td rowspan="2" width="5%">کشور</td>	
	 <td rowspan="2" width="8%">تولیدکننده</td>	
	 <td rowspan="2" width="7%">زیرانبار</td>
	 <td colspan="3" width="15%">تاریخ تولید</td>
	 <td rowspan="2" width="5%">کد کارتن/قوطی</td>
	 <td rowspan="2" width="6%">نوع تعدیل</td>
	 <td rowspan="2" width="4%">نوع کسری</td>
	 <td rowspan="2" width="5%">وضعیت</td>
	 <td colspan="3" width="15%">مقدار تعدیل</td>
	</tr>
    <tr class="print_table-title2">
	 <td>سال</td>
	 <td>ماه</td>
	 <td>روز</td>
	 <td>تعداد</td>
	 <td>ناخالص</td>
	 <td>خالص</td>
	</tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
   	   <tr class="noExl">
	    <td class="print_title_2">';
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo'
	    '.$titr.' &nbsp&nbsp(صفحه : '.$page.')
        <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>  
	   </tr>
      </table>
	 </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.shomare1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=15;
if(!$ok)
{
 echo'
 <table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
	<tr class="tr1">';
     //اضافه کردن صفر پشت کد استان		
	 if(strlen($mt_gl_code_ostan)==1) {$code_a=make_pattern($mt_gl_code_ostan,2);}
     else{$code_a=$mt_gl_code_ostan;}	
     echo'
	 <td align="left" height="40px"> از شماره برگه تعدیل :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="5" name="shomare1" value="'.$shomare1.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
     <td align="left"> تا شماره برگه تعدیل :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="5" name="shomare2" value="'.$shomare2.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>	
	</tr>
	<tr class="tr1">
     <td align="left"> کد کالا :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	 include ("img_helpkala.php");
	 echo'
	 <td align="left" > کد کشور :&nbsp;</td>
	 <td align="right"><input class="textboxme2" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);" style="width:50px"/>&nbsp;';
     include ("img_helpkeshvar.php");
	 echo'
	 </td>
	</tr>
	<tr class="tr1"> 
	 <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>&nbsp;';
     include('img_helptolid.php');
     echo'
     </td>
	 <td align="left"> کد کارتن / قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>&nbsp;';
	  include('img_helpkartonghooti.php');
	 echo'
	 </td>
	</tr>	
	<tr class="tr1">	 
	  <td align="left" height="40px"> زیرانبار :&nbsp;</td><td align="right">'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY code_ziranbar,name_ziranbar ASC","class='easyui-combobox text4' style=width:100px","").'</td>
 	  <td align="left"> سال تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	</tr>
	<tr class="tr1">
 	  <td align="left"> ماه تولید :&nbsp;</td><td align="right">'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'	</td>	
	  <td align="left"> روز تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
	</tr>
	<tr class="tr1">
	  <td align="left" height="40px"> نوع تعدیل :&nbsp;</td>
	  <td align="right"><select name="noe_tadil" class="easyui-combobox text4" style=width:100px data-options=panelHeight:100>
	                            <option value="0">انتخاب کنید</option>
	                            <option value="1">اضافه</option>
	                            <option value="2">کسری</option>
	  </td>
	  <td align="left"> نوع فرم تعدیل :&nbsp; </td>
	  <td align="right"><select name="noe_form_tadil" class="easyui-combobox text4" style=width:100px data-options=panelHeight:100>
	                            <option value="0">انتخاب کنید</option>
	                            <option value="1">دائم</option>
	                            <option value="2">موقت</option>
	   </td>
    </tr>
	<tr class="tr1">
	  <td align="left" height="40px"> وضعیت :&nbsp;</td>
	  <td align="right">'.static_listbox("status","-1","statusFormArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:100 ").'</td>						 
	  <td align="left"> نوع کسری :&nbsp; </td>
	  <td align="right"><select name="noe_kasry" class="easyui-combobox text4" style=width:100px  data-options=panelHeight:100>
	                            <option value="0">انتخاب کنید</option>
	                            <option value="1">عادی</option>
	                            <option value="2">امحاء</option>
	  </td>
     </tr>
	 <tr class="tr1">
	  <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme2 textbox50" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	 </tr>
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>    
   </table>
  </td>
 </tr>
 </table>';
}
else
{
    $Condition="";
    if (!$date1) $date1=$db->get_from_where("min(tarikh_barge_tadil)","tadil_mojody","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");//اگر کاربر تاریخ اول را وارد نکرده بود
    if (!$date2) $date2=$db->get_from_where("max(tarikh_barge_tadil)","tadil_mojody","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");//اگر کاربر تاریخ دوم را وارد نکرده بود    
    /****************فیلترها روی گزارش******************/
    //if ($date1) $Condition.=" and tarikh_havale_anbar>='$date1'";//از تاریخ
    //if ($date2) $Condition.=" and tarikh_havale_anbar<='$date2'";//تا تاریخ   
    if ($shomare1)//از شماره
    { 
	 if(strlen($shomare1)!=5) $shomare1=make_pattern($shomare1,5);
     $Condition.=" and T.shomare_barge_tadil>='$shomare1'";     
    }
    if ($shomare2)//تا شماره 
    {
     if(strlen($shomare2)!=5) $shomare2=make_pattern($shomare2,5);
     $Condition.=" and T.shomare_barge_tadil<='$shomare2'";
    }   
	if($code_kala)$Condition.=" and T.code_kala='$code_kala'";//کد کالا
    if($code_keshvar) $Condition.=" AND T.code_keshvar='$code_keshvar'";//کد کشور 
	if($code_tolidkonande)$Condition.=" AND T.code_tolidkonande='$code_tolidkonande'";//کد تولیدکننده  
	if($code_karton) $Condition.=" AND T.code_karton='$code_karton'";//کد کارتن 
	if($sal_tolid_shamsi) $Condition.=" AND T.sal_tolid_shamsi='$sal_tolid_shamsi'";//سال  
	if($mah_tolid_shamsi) $Condition.=" AND T.mah_tolid_shamsi='$mah_tolid_shamsi'";//ماه 
	if($rouz_tolid_shamsi) $Condition.=" AND T.rouz_tolid_shamsi='$rouz_tolid_shamsi'";
    if($noe_tadil)  $Condition.=" and T.noe_tadil='$noe_tadil'";//نوع تعدیل
    if($noe_kasry) $Condition.=" and T.noe_kasry='$noe_kasry'";//نوع کسری
	if($noe_form_tadil) $Condition.=" and T.noe_form_tadil='$noe_form_tadil'";//نوع فرم
    if($code_ziranbar) $Condition.=" AND T.code_ziranbar='$code_ziranbar'";//زیرانبار
    if (isset($status)and($status=='0')) $Condition.=" and T.status=0";//وضعیت  	 
    if (isset($status)and($status=='1')) $Condition.=" and T.status=1";//وضعیت  	 
    if (isset($status)and($status=='-1')) $Condition.="";//وضعیت	
    /****************شروع نمایش گزارش*******************/			
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	$q="SELECT T.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.name_ziranbar FROM tadil_mojody T 
	    INNER JOIN kala ON kala.code_kala=T.code_kala    
	    INNER JOIN keshvar ON keshvar.code_keshvar=T.code_keshvar    
	    INNER JOIN tolidkonande ON tolidkonande.code_tolidkonande=T.code_tolidkonande     
	    INNER JOIN list_sardkhane_detail l_s_d ON l_s_d.code_ostan=T.code_ostan AND l_s_d.code_anbar=T.code_anbar AND l_s_d.code_ziranbar=T.code_ziranbar   
	    WHERE 1=1 $Condition AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 ORDER BY shomare_barge_tadil";
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
    $myAnbarName=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");//نام انبار خودمان
	if(mysql_num_rows($res)>0)
    {
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if($shomare1) $filter_string.=' ازشماره برگه : '.$code_a.$mt_gl_code_anbar.$shomare1.'&nbsp;';    
	 if($shomare2) $filter_string.=' تا شماره برگه : '.$code_a.$mt_gl_code_anbar.$shomare2.'&nbsp;';  
	 if($code_kala) {$nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
	 if($code_keshvar) {$nameKeshvar=$db->get_from_where("name_keshvar","keshvar","code_keshvar='$code_keshvar'"); $filter_string.=' کشور : '.$nameKeshvar.'&nbsp;';}     
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_karton) {$filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';}     
	 if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}     
	 if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if($mah_tolid_shamsi) {$filter_string.=' ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
     if($noe_tadil) {$filter_string.=' نوع تعدیل : '.$tadilArr[$noe_tadil].'&nbsp;';} 
     if($noe_kasry) {$filter_string.=' نوع کسری : '.$tadilkasryArr[$noe_kasry].'&nbsp;';} 
	 if($noe_form_tadil) {$filter_string.=' نوع فرم : '.$tadilformArr[$noe_form_tadil].'&nbsp;';} 
	 if($status!='-1')
	 { 
	  if($status=='0') $filter_string.=' وضعیت برگه : '.$statusFormArr[$status].'&nbsp;';    
	  if($status=='1') $filter_string.=' وضعیت برگه : '.$statusFormArr[$status].'&nbsp;';    
     }
     echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
      if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  //اضافه کردن صفر پشت کد استان
	     if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
         else $code_a=$row['code_ostan'];
	  echo'
	    <td>'.$radif++.'</td>
		<td>'.$code_a.$row['code_anbar'].$row['shomare_barge_tadil'].'</td>
	    <td>'.$row['tarikh_barge_tadil'].'</td>
	    <td>'.$row['name_kala'].'</td>
	    <td>'.$row['name_keshvar'].'</td>
	    <td>'.$row['name_tolidkonande'].'</td>
	    <td>'.$row['name_ziranbar'].'</td>
	    <td>'.$row['sal_tolid_shamsi'].'</td>
	    <td>'.$row['mah_tolid_shamsi'].'</td>
	    <td>'.$row['rouz_tolid_shamsi'].'</td>
	    <td>'.$row['code_karton'].'</td>
	    <td>'.$tadilArr[$row['noe_tadil']].'</td>
	    <td>'; IF($row['noe_tadil']==1) echo '-'; ELSE echo''.$tadilkasryArr[$row['noe_kasry']].'</td>';
		echo'
		<td>'.$statusFormArr[$row['status']].'</td>
	    <td>'.virgul($row['tedad_karton_tadil']).'</td>
	    <td>'.($row['meghdar_nakhales_tadil']).'</td>
	    
	    <td>'.($row['meghdar_khales_tadil']).'</td>';
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
	    if($row['status']==0)
		{
		$sum_tedad_karton+=$row['tedad_karton_tadil'];
	    $sum_vazn_nakhales+=$row['meghdar_nakhales_tadil'];
	    $sum_vazn_khales+=$row['meghdar_khales_tadil'];
		}
	  }//END while
	  echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="14">جمع مقادیر (جاری) (کیلوگرم)</td>
	   <td>'.virgul($sum_tedad_karton).'</td>
	   <td>'.round($sum_vazn_nakhales,3).'</td>
	   <td>'.round($sum_vazn_khales,3).'</td>
	  </tr>
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