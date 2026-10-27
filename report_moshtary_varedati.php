<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_moshtary_varedati.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش اطلاعات مصرف کننده نهایی کالای وارداتی';
require_once('head.html');
$columns='
	<tr class="print_table-title2" style="height:60px;">
	 <td width="3%">ردیف</td>
	 <td class="kalaPr" width="5%">نام کالا</td>
	 <td class="varedkonandePr" width="5%">نام واردکننده</td>
	 <td class="customerPr" width="10%">نام مشتری</td>
	 <td class="meliPr" width="4%">شناسه ملی</td>
	 <td class="meliPr2" width="4%">شماره ملی</td>
	 <td class="tamasPr" width="4%">شماره تماس</td> 
	 <td class="addressPr" width="13%">آدرس</td>
	 <td class="sh_sabtPr" width="3%">شماره ثبت سفارش</td>
	 <td class="sh_havalePr" width="5%">شماره حواله انبار</td>
	 <td class="date_havalePr" width="5%">تاریخ حواله انبار</td>
	 <td class="tedadPr" width="4%">تعداد</td>
	 <td class="nakhalesPr" width="4%">وزن ناخالص</td>
	 <td class="khalesPr" width="5%">وزن خالص</td>
	 <td class="sh_forushPr" width="4%">شماره حواله فروش</td>
	 <td class="sh_reqPr" width="5%">شماره درخواست</td>
	 <td class="date_reqPr" width="4%">تاریخ درخواست</td>
	 <td class="gheymatPr" width="5%">قیمت خرید مصرف کننده نهایی (هر کیلوگرم)</td>
	 <td class="datebarPr" width="4%">تاریخ بارنامه</td>
	 <td class="sh_barnamePr" width="4%">شماره بارنامه</td>
	</tr>';	 
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> انبار : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr> 
	   <tr class="noExl">
	    <td class="print_title_2">';
	     IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
	     echo'
	     '.$titr.' از تاریخ حواله : '.$date1.' تا تاریخ حواله : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
         <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>	    </td>
	   </tr>
      </table>
     </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=15;
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
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
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0" border="0">
 <tr>
  <td height="100%">
   <table width="750px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr><td colspan="4" class="title">'.$titr.'</td></tr>
	<tr class="tr1">	
     <td align="left" width="100px" style="height:45px"> از تاریخ حواله :&nbsp;</td><td align="right" width="200px"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom"  placeholder="'.$date1.'" /></td>
     <td align="left" width="100px"> تا تاریخ حواله :&nbsp;</td><td align="right" width="300px"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto"  placeholder="'.$date2.'" /></td>
	</tr>
    <tr class="tr1">';
	   //اضافه کردن صفر پشت کد استان		
	   if(strlen($mt_gl_code_ostan)==1) {$code_a=make_pattern($mt_gl_code_ostan,2);}
       else{$code_a=$mt_gl_code_ostan;}	
     echo'
	 <td align="left"> از شماره حواله :&nbsp;</td><td align="right"><input type="text" maxlength="5" class="textboxme2" name="shomare1" value="'.$shomare1.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
     <td align="left"> تا شماره حواله :&nbsp;</td><td align="right"><input type="text" maxlength="5" class="textboxme2" name="shomare2" value="'.$shomare2.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>	
	</tr>
	<tr class="tr1">
     <td align="left" style="height:45px"> کد کالا :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>';
	  include ("img_helpkala.php");
	 echo'</td>
	 <td align="left"> کد مشتری :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_customer" value="'.$code_customer.'" onkeypress="return isNumber(event)"/>';
	  include ("img_searchmoshtary.php");
	 echo' 
	 </td>
	</tr>
	<tr class="tr1">
     <!--<td align="left"> وضعیت حواله :&nbsp;</td>
	 <td align="right">'.static_listbox("status","-1","statusFormArr",1,"class='easyui-combobox text4' style=width:100px  data-options=panelHeight:100").'</td>-->	
     <td align="left" style="height:45px"> پلاک خودرو :&nbsp;</td>
	 <td align="right" colspan="3">
	 		   <sup>ایران</sup>
			   <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/> |
			   <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" style="width:30px;"/>
			   <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" style="width:20px;"/>
			   <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/>
	 </td>
	</tr>
	<tr class="tr1">	
	 <td align="left"> تعداد :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="tedad_karton_h"  onkeypress="return isNumber(event)"/></td>
	 <td align="left"> وزن ناخالص :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="vazn_nakhales_h"  onkeypress="return PressfloatOnly(event)"/></td>
	</tr>
    <tr class="tr1">	
	 <td align="left" style="height:45px"> وزن خالص :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="vazn_khales_h"  value="'.$vazn_khales_h.'" onkeypress="return PressfloatOnly(event)"/></td>
	 <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="footer">	
	 <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
  </td>
 </tr>
</table>';
}
else
{
    $Condition="";
    /****************فیلترها روی گزارش******************/
    if ($date1) $Condition.=" and havale.tarikh_havale_anbar>='$date1'";//از تاریخ
    if ($date2) $Condition.=" and havale.tarikh_havale_anbar<='$date2'";//تا تاریخ  
    if ($shomare1)//از شماره حواله
    { 
     if(strlen($shomare1)!=5) $shomare1=make_pattern($shomare1,5);
     $Condition.=" and havale.shomare_havale_anbar>='$shomare1'";     
    }
    if ($shomare2)//تا شماره حواله 
    {
	 if(strlen($shomare2)!=5) $shomare2=make_pattern($shomare2,5);
     $Condition.=" and havale.shomare_havale_anbar<='$shomare2'";
    }    
    if ($code_kala) $Condition.=" and havale.code_kala='$code_kala'";//کد کالا 
    if($code_customer)//کد مشتری
	{
	   /*سیستم انبار*/
       if($_SESSION['mt_systemforush']==0)
       {
	 	 //بدست آوردن شماره حواله فروشهای کد مشتری فیلتر شده
         $q_havale_forush_mt="SELECT h_code FROM $mydatabase.havale_forush WHERE code_customer='$code_customer' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";
         $res_havale_forush=mysql_query($q_havale_forush_mt);
		 $s1=1;
		 $s2=mysql_num_rows($res_havale_forush);
		  while($row_havale_forush=mysql_fetch_array($res_havale_forush))
		  {
		   $Condition2.=" havale.h_code='".$row_havale_forush['h_code']."'";
		   if($s1<$s2) {$Condition2.=" or";}
		   else if($s1==$s2) {$Condition2.="";}
		   $s1++;
		  }
		   if($s2>0) $Condition.=" AND ($Condition2)";//اگر برای مشتری حواله فروش داریم
		   if($s2==0) $Condition.=" AND (1=2)";//اگر برای مشتری حواله فروش نداریم
	   }
	   /*سیستم فروش*/
       if($_SESSION['mt_systemforush']==1)
       {
		 //بدست آوردن شماره حواله فروشهای کد مشتری فیلتر شده
         $q_havale_forush_sell="SELECT h_code FROM sell.dm_havale WHERE h_customer_code='$code_customer' AND h_id_province='$sell_id_ostan' AND (h_l_code='$sell_id_anbar' OR h_robari_code='$mt_gl_code_anbar') AND h_id_year='$sellYearId'";
		 $res_havale_forush=mysql_query($q_havale_forush_sell);
         $s1=1;
		 $s2=mysql_num_rows($res_havale_forush);
		 while($row_havale_forush=mysql_fetch_array($res_havale_forush))
		 {
		  $Condition2.=" havale.h_code='".$row_havale_forush['h_code']."'";
		  if($s1<$s2) {$Condition2.=" or";}
		  else if($s1==$s2) {$Condition2.="";}
		  $s1++;
		 }
		 if($s2>0) $Condition.=" AND ($Condition2)";//اگر برای مشتری حواله فروش داریم
		 if($s2==0) $Condition.=" AND (1=2)";//اگر برای مشتری حواله فروش نداریم
	   }
	}
    if (isset($status)and($status=='0')) $Condition.=" and havale.status=0";//وضعیت حواله 	 
    if (isset($status)and($status=='1')) $Condition.=" and havale.status=1";//وضعیت حواله 	 
    if (isset($status)and($status=='2')) $Condition.="";//وضعیت حواله
	if ($plak1) $Condition.=" and havale.plak1='$plak1'";//پلاک خودرو 
    if ($plak2) $Condition.=" and havale.plak2='$plak2'";//پلاک خودرو 
    if ($plak3) $Condition.=" and havale.plak3='$plak3'";//پلاک خودرو 
    if ($plak4) $Condition.=" and havale.plak4='$plak4'";//پلاک خودرو 
	if ($tzn_no!='') $Condition.=" and havale.tzn_no='$tzn_no'";//شماره باسکول 
	if ($tedad_karton_h) $Condition.=" and havale.tedad_karton_h='$tedad_karton_h'";//تعداد 
	if ($vazn_nakhales_h) $Condition.=" and havale.vazn_nakhales_h='$vazn_nakhales_h'";//وزن ناخالص حواله 
	if ($vazn_khales_h) $Condition.=" and havale.vazn_khales_h='$vazn_khales_h'";//وزن خالص حواله 
	/****************شروع نمایش گزارش*******************/		
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	$q="SELECT havale.*,kala.name_kala,cm_req_num,cm_req_date FROM $mydatabase.havale
		  INNER JOIN $mydatabase.kala ON havale.code_kala=kala.code_kala    		
		  INNER JOIN sell.dm_havale ON havale.h_id=dm_havale.h_id   		
          INNER JOIN sell.dm_pish_factor ON dm_havale.h_pf_code=dm_pish_factor.pf_code AND dm_havale.h_id_province=dm_pish_factor.pf_id_province
          INNER JOIN sell.dm_pish_havale ON dm_pish_factor.pf_ph_code=dm_pish_havale.ph_code AND dm_pish_factor.pf_id_province=dm_pish_havale.ph_id_province    		
		  WHERE 1=1 $Condition AND kala.mahmule_type=2 AND (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3 OR noe_tahvil_bar=6) AND havale.code_ostan='$mt_gl_code_ostan' AND havale.code_anbar='$mt_gl_code_anbar' AND havale.year='$mtActiveYear' AND havale.deleted=0 AND havale.status=0 ORDER BY tarikh_havale_anbar,shomare_havale_anbar";		
	$res=$db->query($q);
	//echo $q;
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
	{
	 echo'
     <br>
     <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      <tr class="print_table-title2 "><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
	  <tr class="print_table-title2  select_all">	 
		 <td width="5%" >نام کالا</td>
		 <td width="10%" >نام واردکننده</td>
		 <td width="9%" >نام مشتری</td>
		 <td width="5%" >شناسه ملی</td>
		 <td width="5%" >شماره ملی</td>
		 <td width="5%" >شماره تماس</td>
	     <td width="5%" >آدرس</td>
	     <td width="5%" >شماره ثبت سفارش</td> 
	     <td width="5%" >شماره حواله انبار</td>
	     <td width="5%" >تاریخ حواله انبار</td>
	     <td width="3%" >تعداد</td>
	     <td width="4%" >وزن ناخالص</td>
	     <td width="3%" >وزن خالص</td>
	     <td width="6%" >شماره حواله فروش</td>
	     <td width="5%" >شماره درخواست</td>
	     <td width="6%" >تاریخ درخواست</td>
	     <td width="4%" >قیمت خرید</td>
	     <td width="5%" >تاریخ بارنامه</td> 
	     <td width="5%" >شماره بارنامه</td> 
	    </tr>   	
		<tr class="print_table-title2 print_table-title_small">
	     <td><input name="kalaPr" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="varedkonandePr" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="customerPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="meliPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="meliPr2" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="tamasPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="addressPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="sh_sabtPr" class="count_sum" type="checkbox"  ></td>
	   	 <td><input name="sh_havalePr" class="count_sum" type="checkbox" checked ></td>
	   	 <td><input name="date_havalePr" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="tedadPr" type="checkbox" checked ></td>
	   	 <td><input name="nakhalesPr" type="checkbox" checked ></td>
	   	 <td><input name="khalesPr" type="checkbox" checked ></td>
		 <td><input name="sh_forushPr" type="checkbox" checked ></td>
	   	 <td><input name="sh_reqPr" type="checkbox" checked ></td>
	   	 <td><input name="date_reqPr" type="checkbox" checked ></td>
		 <td><input name="gheymatPr"  type="checkbox" checked ></td>
		 <td><input name="datebarPr"  type="checkbox" checked ></td>
		 <td><input name="sh_barnamePr"  type="checkbox" checked ></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
     else $code_a=$mt_gl_code_ostan;
	 if($shomare1) $filter_string.=' ازشماره حواله : '.$code_a.$mt_gl_code_anbar.$shomare1.'&nbsp;';    
	 if($shomare2) $filter_string.=' تا شماره حواله : '.$code_a.$mt_gl_code_anbar.$shomare2.'&nbsp;';    
	 if($code_kala) {$nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
	 if($code_customer) $filter_string.=' کد مشتری : '.$code_customer.'&nbsp;';     
	 // if($status!='-1')
	 // { 
	  // if($status=='0') $filter_string.=' وضعیت حواله : '.$statusFormArr[$status].'&nbsp;';    
	  // if($status=='1') $filter_string.=' وضعیت حواله : '.$statusFormArr[$status].'&nbsp;';    
     // }
	 if ($tedad_karton_h) $filter_string.=' تعداد : '.$tedad_karton_h.'&nbsp;'; 	 
	 if ($vazn_nakhales_h) $filter_string.=' وزن ناخالص : '.$vazn_nakhales_h.'&nbsp;'; 	 
	 if ($vazn_khales_h) $filter_string.=' وزن خالص : '.$vazn_khales_h.'&nbsp;'; 	 
	 if(($shomare1)or($shomare2)or($code_kala)or($code_customer)or($tzn_no!='')or($vazn_khales_h))
	 {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  if($row['status']==0)$sum_vazn_khales_h_jary+=$row['vazn_khales_h'];//اگر حواله جاری است
	  if($row['status']==1) $sum_vazn_khales_h_ebtaly+=$row['vazn_khales_h'];//اگر حواله ابطالی است
	  /*نام مشتری از سیستم انبار*/
	  if($_SESSION['mt_systemforush']==0)
	  {
	    //بدست آوردن کد مشتری
        $q_havale_forush="SELECT code_customer FROM $mydatabase.havale_forush WHERE h_code='".$row['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
        $res_havale_forush=mysql_query($q_havale_forush);
        $row_havale_forush=mysql_fetch_array($res_havale_forush);
	    $nameMoshtary=$row_havale_forush['code_customer'];
	    //نام مشتری
	    $q_moshtary="SELECT name_customer,customer_national_tax,customer_gl_code,customer_tel,customer_address_office FROM $mydatabase.moshtary WHERE code_customer=".$row_havale_forush['code_customer']." AND code_ostan='$mt_gl_code_ostan'";
        $res_moshtary=mysql_query($q_moshtary);
        $row_moshtary=mysql_fetch_array($res_moshtary);
        $nameMoshtary=$row_moshtary['name_customer'];	  
	  }
	  /*نام مشتری از سیستم فروش*/
      if($_SESSION['mt_systemforush']==1)
      {
	     //بدست آوردن کد مشتری
         $q_havale_forush="SELECT h_customer_code,h_p_price FROM  sell.dm_havale WHERE h_code='".$row['h_code']."' AND h_id_province='$sell_id_ostan' AND (h_l_code='$sell_id_anbar' OR h_robari_code='$mt_gl_code_anbar') AND h_id_year='$sellYearId'";
		 $res_havale_forush=mysql_query($q_havale_forush);
         $row_havale_forush=mysql_fetch_array($res_havale_forush);
	     //نام مشتری
	     $q_moshtary="SELECT dm_customer_asli.name_customer,dm_customer_asli.customer_national_tax,dm_customer_asli.customer_gl_code,dm_customer_det.customer_address_office,dm_customer_det.customer_tel FROM sell.dm_customer_asli LEFT OUTER JOIN sell.dm_customer_det ON dm_customer_asli.code_customer=dm_customer_det.code_customer WHERE dm_customer_asli.code_customer=".$row_havale_forush['h_customer_code']." AND dm_customer_det.customer_code_org='$mt_gl_code_ostan'";
         $res_moshtary=mysql_query($q_moshtary);
         $row_moshtary=mysql_fetch_array($res_moshtary);
         $nameMoshtary=$row_moshtary['name_customer'];
      }	  
	  //اضافه کردن صفر پشت کد استان
	   if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       else $code_a=$row['code_ostan'];	
       //تبدیل تاریخ میلادی به شمسی
	   $sql_tarikh=$row['cm_req_date'];
       $d=substr($sql_tarikh,8,2);
       $m=substr($sql_tarikh,5,2);
       $y=substr($sql_tarikh,0,4);
       $shamsi=gregorian_to_jalali($y,$m,$d);
       $sal=$shamsi[0];
       $mah=$shamsi[1];
       $rouz=$shamsi[2];
       $cm_req_date=$sal.'/'.$mah.'/'.$rouz;
	   if($i++%2)echo'<tr class="print_table-odd_small">';
       else echo'<tr class="print_table-even_small">';  
	   echo'
	    <td>'.$radif++.'</td>
	    <td class="kalaPr">'.$row['name_kala'].'</td>
	    <td class="varedkonandePr">شرکت پشتیبانی امور دام کشور</td>
	    <td class="customerPr">'.$row_moshtary['name_customer'].'</td>
		<td class="meliPr">'.$row_moshtary['customer_national_tax'].' </td>
		<td class="meliPr2">'.$row_moshtary['customer_gl_code'].'</td>
		<td class="tamasPr">'.$row_moshtary['customer_tel'].'</td>
		<td class="addressPr">'.$row_moshtary['customer_address_office'].'</td>
		<td class="sh_sabtPr">-</td>
	    <td class="sh_havalePr">'.$code_a.$row['code_anbar'].$row['shomare_havale_anbar'].'</td>
	    <td class="date_havalePr">'.$row['tarikh_havale_anbar'].'</td>
	    <td class="tedadPr">'.virgul($row['tedad_karton_h']).'</td>
	    <td class="nakhalesPr">'.round($row['vazn_nakhales_h'],3).'</td>
	    <td class="khalesPr">'.round($row['vazn_khales_h'],3).'</td>
	    <td class="sh_forushPr">'.$row['h_code'].'</td>
	    <td class="sh_reqPr">'.$row['cm_req_num'].'</td>
	    <td class="date_reqPr">'.$cm_req_date.'</td>
	    <td class="gheymatPr">'.virgul($row_havale_forush['h_p_price']).'</td>
		<td class="datebarPr">'.$row['tarikh_barname_h'].'</td>
		<td class="sh_barnamePr">'.$row['shomare_barname_h'].'</td>
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
	  $sum_tedad+=$row['tedad_karton_h'];
	  $sum_vazn_nakhales+=$row['vazn_nakhales_h'];
	  $sum_vazn_khales+=$row['vazn_khales_h'];
	 }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td id="sum_row" colspan="10">جمع مقادیر (کیلوگرم)</td>
	   <td class="tedadPr">'.virgul($sum_tedad).'</td>
	   <td class="nakhalesPr">'.round($sum_vazn_nakhales,3).'</td>
	   <td class="khalesPr">'.round($sum_vazn_khales,3).'</td>
	   <td class="sh_forushPr">&nbsp</td>
	   <td class="sh_reqPr">&nbsp</td>
	   <td class="date_reqPr">&nbsp</td>
	   <td class="gheymatPr">&nbsp</td>
	   <td class="datebarPr">&nbsp</td>
	   <td class="sh_barnamePr">&nbsp</td>
	  </tr>
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
  <tr class="print_footer noExl">
     <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
  </tr>';
}
//اگر اطلاعاتی نداریم	
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
         
		 //var count_for_sum1  = $(".count_sum:checked").length; //only the class count_sum 
		 //var count_for_sum=count_for_sum1+3;
		 //alert(count_for_sum);
         var count_for_sum=11;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var count_for_sum=count_for_sum-numberNotChecked;
		 $("#sum_row").attr("colspan",count_for_sum);
        });
	
});
<!-- نوع تحویل بار-->
 $( document ).ready(function() {
 $("[name=noe_tahvil_bar]").bind("change", function () {
    if(($(this).val() == 4)||($(this).val() == 5)) $("#ostananbar").slideDown("fast");
	else {$("#ostananbar").slideUp("fast");}
  });
 });

</script> 