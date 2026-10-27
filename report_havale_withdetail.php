<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_havale_withdetail.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش براساس حواله سردخانه با جزئیات';
require_once('head.html');
/*سیستم فروش*/
$columns='
	<tr class="print_table-title2" style="height:60px;">
	   <td width="3%">ردیف</td>
	   <td width="5%">شماره حواله</td>
	   <td width="4%">تاریخ حواله</td>
	   <td width="10%" class="kalaPr">نام کالا</td>	
	   <td width="10%" class="forush_jabejaePr">حواله فروش/مجوز جابجایی</td>
	   <td width="10%" class="customerPr">نام مشتری/استان مقصد</td>
	   <td width="5%" class="tolidkonandePr">تولیدکننده</td>
	   <td width="10%" class="toliddatePr">تاریخ تولید</td>
	   <td width="4%" class="mandegariPr">تاریخ ماندگاری</td>
	   <td width="7%" class="kartonPr">وزن کارتن/قوطی</td>
	   <td width="4%" class="statusPr">وضعیت</td>
	   <td width="5%" class="tedadPr">تعداد</td> 
	   <td width="5%" class="sumkartonPr">وزن کارتن ها</td> 
	   <td width="7%" class="nakhalesPr">وزن ناخالص</td>
	   <td width="7%" class="khalesPr">وزن خالص</td>
	   <td width="4%" class="shanePr">تعداد شانه</td>
	</tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'
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
	     '.$titr.' از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
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
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
 <tr>
  <td height="100%">
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr><td colspan="4" class="title">'.$titr.'</td></tr>
	<tr class="tr1">	
     <td align="left" width="20%" height="40px"> از تاریخ :&nbsp;</td><td align="right" width="30%"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
     <td align="left" width="20%"> تا تاریخ :&nbsp;</td><td align="right" width="30%"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">';
	   //اضافه کردن صفر پشت کد استان		
	   if(strlen($mt_gl_code_ostan)==1) {$code_a=make_pattern($mt_gl_code_ostan,2);}
       else{$code_a=$mt_gl_code_ostan;}	
     echo'
	 <td align="left" > از شماره حواله :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="5" name="shomare1" value="'.$shomare1.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
     <td align="left"> تا شماره حواله :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="5" name="shomare2" value="'.$shomare2.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>	
	</tr>
	<tr class="tr1">
	 <td align="left">نام کالا : </td>
     <td align="right">
	  &nbsp;<select name="kalachoice[]" class="easyui-combobox" size="6" style="width:200px;" multiple>';
	  $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row['code_kala'].">".$row['name_kala']."</option>";
	  echo $kala_options;
	  echo'
	  </select>
	 </td>
     <!--
	 <td align="left"> کد کالا :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	  include ("img_helpkala.php");
	 echo'
	 </td>
	 -->
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
     <td align="left"> سال تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	 <td align="left"> ماه تولید :&nbsp;</td><td align="right">'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	</tr>
	<tr class="tr1">
	 <td align="left"> روز تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
     <td align="left"> نام زیرانبار :&nbsp;</td><td align="right">'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar","class='easyui-combobox text4' style=width:100px","").'</td>
	</tr>
    <tr class="tr1">	
	 <td align="left"> نوع تحویل بار :&nbsp;</td><td align="right">'.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr_h",1,"class='text4'").'</td>
	 <td colspan="2">&nbsp;</td>
	</tr>
	<tr class="tr1">	
     <td align="left"> شماره حواله فروش :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="h_code" value="'.$h_code.'" onkeypress="return isNumber(event)"/>&nbsp;';
	  include ("img_helphavaleforush_report.php");
	 echo'
	 </td>
	 <td align="left"> شماره مجوز جابه جایی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shomare_jabejae" value="'.$shomare_jabejae.'"/>&nbsp;';
      include ("img_helpjabejae_report.php");
	 echo'
	 </td>
	</tr>
    <tr class="tr1">	
	 <td align="left"> کد مشتری :&nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme2" name="code_customer" value="'.$code_customer.'" onkeypress="return isNumber(event)"/>&nbsp;';
 	  include ("img_searchmoshtary.php");
      echo'
	  </td>
	</tr>
	<tr class="tr1">
     <td align="left"> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","","class='easyui-combobox text4' style=width:100px").'</td>	
     <td align="left"> وضعیت حواله :&nbsp;</td>
	 <td align="right">'.static_listbox("status","-1","statusFormArr",1,"class='easyui-combobox text4' style=width:100px  data-options=panelHeight:100").'</td>						 
	</tr>
	<tr class="tr1">
     <td align="left"> شماره کاميون :&nbsp;</td><td align="right"><input type="text" class="textboxme2"  name="shomare_kamiyon_h" value="'.$shomare_kamiyon_h.'"/></td>
     <td align="left"> پلاک خودرو :&nbsp;</td>
	 <td align="right">
	 		   <sup>ایران</sup>
			   <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/> |
			   <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" style="width:30px;"/>
			   <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" style="width:20px;"/>
			   <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/>
	 </td>
	</tr>
	<tr class="tr1">
	 <td align="left"> شماره باسکول :&nbsp;</td><td align="right"><input type="text" class="textboxme2"  name="bsk_no" value="'.$bsk_no.'"/></td>
	 <td align="left"> وزن خالص :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="vazn_khales_h"  value="'.$vazn_khales_h.'" onkeypress="return isNumber(event)"/></td>
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
    $Condition_havale="";
    /****************فیلترها روی گزارش******************/
    if ($date1) $Condition_havale.=" and havale.tarikh_havale_anbar>='$date1'";//از تاریخ
    if ($date2) $Condition_havale.=" and havale.tarikh_havale_anbar<='$date2'";//تا تاریخ  
    if ($shomare1)//از شماره حواله
    { 
	 if(strlen($shomare1)!=5) $shomare1=make_pattern($shomare1,5);
     $Condition_havale.=" and havale.shomare_havale_anbar>='$shomare1'";     
    }
    if ($shomare2)//تا شماره حواله 
    {
     if(strlen($shomare2)!=5) $shomare2=make_pattern($shomare2,5);
     $Condition_havale.=" and havale.shomare_havale_anbar<='$shomare2'";
    }
    //انتخاب یک کالا    
    //if ($code_kala) $Condition_havale.=" and havale.code_kala='$code_kala'";//کد کالا 
    //انتخاب چند تا کالا
	if(is_array($kalachoice))
    {
       foreach($kalachoice as $key_kala => $kala_val ) {
        $Condition_kala_temp.=" havale.code_kala='$kala_val' OR";
       }
       if($kala_val==-1)$Condition_kala.="1=1 OR";
       else $Condition_kala.=" $Condition_kala_temp";
       $lastSpacePosition = strrpos($Condition_kala," ");
       $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
    }
	
	if ($code_keshvar) $Condition_h_d.=" and h_d.code_keshvar='$code_keshvar'";//کد کشور 
    if ($code_tolidkonande) $Condition_h_d.=" and h_d.code_tolidkonande='$code_tolidkonande'";//کد تولیدکننده 
    if ($code_karton) $Condition_h_d.=" and h_d.code_karton='$code_karton'";//کد کارتن 
    if ($sal_tolid_shamsi) $Condition_h_d.=" and h_d.sal_tolid_shamsi='$sal_tolid_shamsi'";//سال تولید 
    if ($mah_tolid_shamsi) $Condition_h_d.=" and h_d.mah_tolid_shamsi='$mah_tolid_shamsi'";//ماه تولید 
    if ($rouz_tolid_shamsi) $Condition_h_d.=" and h_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";//روز تولید 
    if ($code_ziranbar) $Condition_h_d.=" and h_d.code_ziranbar='$code_ziranbar'";//زیرانبار 
	if ($noe_tahvil_bar) $Condition_havale.=" and noe_tahvil_bar='$noe_tahvil_bar'";//نوع تحویل بار
    //شماره حواله فروش
	if ($h_code) 
	{
	    $Condition_havale.=" and havale.h_code='$h_code'";
	        /**///مقدار مانده به صورت محاسباتی
	    	//محاسبه مقدار تحویلی $meghdar_tahvily=$db->get_from_where("SUM(vazn_khales_h)","havale","h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
     /*سیستم سردخانه*/
       if($_SESSION['mt_systemforush']==0)
       {
            /**///محاسبه مقدار باطله
            //$meghdar_batele=$db->get_from_where("SUM(meghdar_batele)","ebtal","h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
            /**///مقدار حواله فروش
	        //$meghdar_forush=$db->get_from_where("meghdar_havale_forush","havale_forush","h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
	        /**///$mande_az_forush=$meghdar_forush-$meghdar_tahvily-$meghdar_batele;//محاسبه مقدار مانده از حواله فروش	
	    //مقدار مانده از حواله فروش change
		$mande_az_forush=$db->get_from_where("mande_az_forush","$mydatabase.havale_forush","h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
	   }
     /*سیستم فروش*/
        if($_SESSION['mt_systemforush']==1)
       {
		// mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
        // //پیدا کردن آی دی کد استان مربوط به سیتم فروش
        // $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
        // $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
        // //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
         // $res_anbar=mysql_query("SELECT l_id FROM dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code='$mt_gl_code_anbar'");
         // $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
        // //پیدا کردن آی دی سال مربوط به سیستم فروش
         // $sellYearCode=substr($mtActiveYear,2);
         // $res_sal=mysql_query("SELECT year_id FROM dm_year WHERE year_code='$sellYearCode'");
         // $sellYearId=mysql_result($res_sal, 0, 'year_id');	
		   
		   /**///مقدار مانده به صورت محاسباتی
		   /**///مجموع مقدار ابطالی های این حواله فروش در سیستم فروش
	       // $q_batele_f="SELECT SUM(his_eb_amount) FROM dm_his_havale WHERE his_h_code='$h_code' AND his_id_province='$sell_id_ostan' AND his_l_code='$sell_id_anbar' And his_id_year='$sellYearId'";	   
	       // $res_batele_f=mysql_query($q_batele_f);
	       // $row_batele_f=mysql_fetch_array($res_batele_f);
	       // $batele_forush=$row_batele_f[0];
	       // /**///مقدار حواله فروش
	       // $q_pre_amount="SELECT h_pre_amount FROM dm_havale WHERE h_code='$h_code' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";	   
	       // $res_pre_amount=mysql_query($q_pre_amount);
	       // $row_pre_amount=mysql_fetch_array($res_pre_amount);
	       // $meghdar_forush=$row_pre_amount[0];
	       // $mande_az_forush=$meghdar_forush-$meghdar_tahvily-$batele_forush;//محاسبه مقدار مانده از حواله فروش
		//مقدار مانده از حواله فروش change
		$q_mande="SELECT h_mande_havale FROM sell.dm_havale WHERE h_code='$h_code' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";	   
	    $res_mande=mysql_query($q_mande);
	    $row_mande=mysql_fetch_array($res_mande);   
	    $mande_az_forush=$row_mande[0];
	   }
    }
	if ($shomare_jabejae) $Condition_havale.=" and havale.shomare_jabejae='$shomare_jabejae'";//مجوزجابهجایی
	if($code_customer)//کد مشتری
	{
	   /*سیستم سردخانه*/
       if($_SESSION['mt_systemforush']==0)
       {
	 	  $q_mojavez="SELECT shomare_jabejae FROM $mydatabase.mojavez_jabejae WHERE code_customer='$code_customer' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";
		  $res_mojavez=mysql_query($q_mojavez);
          $r1=1;
		  $tedad_moj=mysql_num_rows($res_mojavez);
		  while($row_mojavez=mysql_fetch_array($res_mojavez))
		  {
		    $Condition3.=" havale.shomare_jabejae='".$row_mojavez['shomare_jabejae']."'";
		    if($r1<$tedad_moj) {$Condition3.=" or";}
		    else if($r1==$tedad_moj) {$Condition3.="";}
		    $r1++;
		   }
		 if($tedad_moj>0) $Condition_havale.=" AND ($Condition3)";//اگر برای مشتری مجوز جابه جایی داریم
		 //بدست آوردن شماره حواله فروشهای کد مشتری فیلتر شده
         $q_havale_forush_mt="SELECT h_code FROM $mydatabase.havale_forush WHERE code_customer='$code_customer' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";
         $res_havale_forush=mysql_query($q_havale_forush_mt);
		 $s1=1;
		 $tedad_for=mysql_num_rows($res_havale_forush);
		 while($row_havale_forush=mysql_fetch_array($res_havale_forush))
		 {
		  $Condition2.=" havale.h_code='".$row_havale_forush['h_code']."'";
		  if($s1<$tedad_for) {$Condition2.=" or";}
		  else if($s1==$tedad_for) {$Condition2.="";}
		  $s1++;
		 }
		 if($tedad_for>0) $Condition_havale.=" AND ($Condition2)";//اگر برای مشتری حواله فروش داریم
		 if(($tedad_for==0)AND($tedad_moj==0)) $Condition_havale.=" AND (1=2)";//اگر برای مشتری حواله فروش ومجوز نداریم	  	 
	   }
	   /*سیستم فروش*/
       else
       {	   	 
		 //if($noe_tahvil_bar==5)//جابه جایی کالای امانی
		 //{
		   $q_mojavez="SELECT shomare_jabejae FROM $mydatabase.mojavez_jabejae WHERE code_customer='$code_customer' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";
		   $res_mojavez=mysql_query($q_mojavez);
           $r1=1;
		   $tedad_moj=mysql_num_rows($res_mojavez);
		   while($row_mojavez=mysql_fetch_array($res_mojavez))
		   {
		    $Condition3.=" havale.shomare_jabejae='".$row_mojavez['shomare_jabejae']."'";
		    if($r1<$tedad_moj) {$Condition3.=" or";}
		    else if($r1==$tedad_moj) {$Condition3.="";}
		    $r1++;
		   }
		   if($tedad_moj>0) $Condition_havale.=" AND ($Condition3)";//اگر برای مشتری مجوز جابه جایی داریم
		 //}
     	 //else
		 //{		
		   //بدست آوردن شماره حواله فروشهای کد مشتری فیلتر شده
           $q_havale_forush_sell="SELECT h_code FROM sell.dm_havale WHERE h_customer_code='$code_customer' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";
		   $res_havale_forush=mysql_query($q_havale_forush_sell);
           $s1=1;
		   $tedad_for=mysql_num_rows($res_havale_forush);
		   while($row_havale_forush=mysql_fetch_array($res_havale_forush))
		   {
		    $Condition2.=" havale.h_code='".$row_havale_forush['h_code']."'";
		    if($s1<$tedad_for) {$Condition2.=" or";}
		    else if($s1==$tedad_for) {$Condition2.="";}
		    $s1++;
		   }
		   if($tedad_for>0) $Condition_havale.=" AND ($Condition2)";//اگر برای مشتری حواله فروش داریم
		   if(($tedad_for==0)AND($tedad_moj==0)) $Condition_havale.=" AND (1=2)";//اگر برای مشتری حواله فروش ومجوز نداریم	  	 
		 //}			 
	   }
	}
    if ($code_bastebandy) $Condition_havale.=" and kala.code_bastebandy='$code_bastebandy'";//کد بسته بندی
    if (isset($status)and($status=='0')) $Condition_havale.=" and havale.status=0";//وضعیت حواله 	 
    if (isset($status)and($status=='1')) $Condition_havale.=" and havale.status=1";//وضعیت حواله 	 
    if (isset($status)and($status=='-1')) $Condition_havale.="";//وضعیت حواله
	if ($shomare_kamiyon_h) $Condition_havale.=" and shomare_kamiyon_h='$shomare_kamiyon_h'";//شماره کامیون 
    if ($plak1) $Condition_havale.=" and plak1='$plak1'";//پلاک خودرو 
    if ($plak2) $Condition_havale.=" and plak2='$plak2'";//پلاک خودرو 
    if ($plak3) $Condition_havale.=" and plak3='$plak3'";//پلاک خودرو 
    if ($plak4) $Condition_havale.=" and plak4='$plak4'";//پلاک خودرو 
	if ($bsk_no!='') $Condition_havale.=" and bsk_no='$bsk_no'";//شماره باسکول 
	if ($vazn_khales_h) $Condition_havale.=" and vazn_khales_h='$vazn_khales_h'";//وزن خالص حواله 
	/****************شروع نمایش گزارش*******************/		
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	$sum_vazn_khales_h_jary=0;//مجموع وزن خالص های جاری
	$sum_vazn_nakhales_h_jary=0;//مجموع وزن ناخالص های جاری
	$sum_karton_h_jary=0;//مجموع کارتن های جاری
    $sum_vazn_khales_h_ebtaly=0;//مجموع وزن خالص های ابطالی
    $sum_vazn_nakhales_h_ebtaly=0;//مجموع وزن ناخالص های ابطالی
    $sum_karton_h_ebtaly=0;//مجموع کارتن های ابطالی
	$q="SELECT havale.*,kala.name_kala,name_tolidkonande,h_d.sal_tolid_shamsi,h_d.mah_tolid_shamsi,h_d.rouz_tolid_shamsi,h_d.code_karton,h_d.vazn_karton_this,sharh_mandegari,h_d.tedad_karton_h_d,h_d.vazn_nakhales_h_d,h_d.sum_karton_h_d,h_d.vazn_khales_h_d,h_d.tedad_shane_h_d,  
	   (SELECT SUM(tedad_karton_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=havale.shomare_havale_anbar AND h_d.code_ostan=havale.code_ostan AND h_d.code_anbar=havale.code_anbar AND h_d.year=havale.year $Condition_h_d)tedadKarton,
	   (SELECT SUM(sum_karton_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=havale.shomare_havale_anbar AND h_d.code_ostan=havale.code_ostan AND h_d.code_anbar=havale.code_anbar AND h_d.year=havale.year $Condition_h_d)vaznKartonha,
	   (SELECT SUM(vazn_nakhales_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=havale.shomare_havale_anbar AND h_d.code_ostan=havale.code_ostan AND h_d.code_anbar=havale.code_anbar AND h_d.year=havale.year $Condition_h_d)vaznNaKhales,
	   (SELECT SUM(vazn_khales_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=havale.shomare_havale_anbar AND h_d.code_ostan=havale.code_ostan AND h_d.code_anbar=havale.code_anbar AND h_d.year=havale.year $Condition_h_d)vaznKhales,
	   (SELECT SUM(tedad_shane_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=havale.shomare_havale_anbar AND h_d.code_ostan=havale.code_ostan AND h_d.code_anbar=havale.code_anbar AND h_d.year=havale.year $Condition_h_d)tedadShane
		FROM $mydatabase.havale
        INNER JOIN $mydatabase.kala ON havale.code_kala=kala.code_kala    		
	    LEFT JOIN $mydatabase.havale_detail h_d ON h_d.shomare_havale_anbar=havale.shomare_havale_anbar AND h_d.code_ostan=havale.code_ostan AND h_d.code_anbar=havale.code_anbar AND h_d.year=havale.year    
		LEFT JOIN $mydatabase.tolidkonande ON h_d.code_tolidkonande=tolidkonande.code_tolidkonande    		
		LEFT JOIN $mydatabase.tarikh_mandegari ON h_d.code_mandegari=tarikh_mandegari.code_mandegari    		
		WHERE 1=1 $Condition_havale $Condition_h_d AND($Condition_kala) AND havale.code_ostan='$mt_gl_code_ostan' AND havale.code_anbar='$mt_gl_code_anbar' AND havale.year='$mtActiveYear' AND havale.deleted=0 ORDER BY havale.tarikh_havale_anbar";		
	//echo $q;
	$res=$db->query($q);
	$cntr=mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
	{
     echo'
     <br>
      <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title2"><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
		<tr class="print_table-title2 select_all">
		 <td width="6%" >نام کالا</td>
		 <td width="12%" >حواله فروش / مجوز جابه جایی</td>
		 <td width="10%" >نام مشتری/استان مقصد</td>
		 <td width="9%" >تولیدکننده</td>
		 <td width="5%" >تاریخ تولید</td>
		 <td width="5%" >تاریخ ماندگاری</td>
	     <td width="11%" >وزن کارتن / قوطی(کیلوگرم)</td>
	     <td width="7%" >وضعیت</td>
	     <td width="6%" >تعداد (عدد)</td>
	     <td width="9%" >وزن کارتن ها (کیلوگرم)</td>
	     <td width="9%" >وزن ناخالص (کیلوگرم)</td>
	     <td width="8%" >وزن خالص (کیلوگرم)</td>
		 <td width="4%" >تعداد شانه</td>
	    </tr>   	
		<tr class="print_table-title2 print_table-title_small">
	     <td><input name="kalaPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="forush_jabejaePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="customerPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="tolidkonandePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="toliddatePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="mandegariPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="kartonPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="statusPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="tedadPr" type="checkbox"  checked></td>
	     <td><input name="sumkartonPr" type="checkbox"  checked></td>
	     <td><input name="nakhalesPr" type="checkbox" checked ></td>
	     <td><input name="khalesPr" type="checkbox" checked ></td>
		 <td><input name="shanePr" type="checkbox" checked ></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
     else $code_a=$mt_gl_code_ostan;
	 if($shomare1) $filter_string.=' ازشماره حواله : '.$code_a.$mt_gl_code_anbar.$shomare1.'&nbsp;';    
	 if($shomare2) $filter_string.=' تا شماره حواله : '.$code_a.$mt_gl_code_anbar.$shomare2.'&nbsp;';    
	 //if($code_kala) {$nameKala=$db->get_from_where("name_kala","$mydatabase.kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
	 if(is_array($kalachoice))
     {
      if($kala_val==-1)$filter_string.='همه کالاها';
      else $filter_string.=' کالا : ';
      foreach($kalachoice as $key_kala => $kala_val) {
      $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
      $filter_string.=''.$nameKala.'&nbsp;';
         }
     } 
	 if($code_keshvar) {$nameKeshvar=$db->get_from_where("name_keshvar","$mydatabase.keshvar","code_keshvar='$code_keshvar'"); $filter_string.=' کشور : '.$nameKeshvar.'&nbsp;';}     
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","$mydatabase.tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_karton) $filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';    
	 if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","$mydatabase.list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}     
	 if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if($mah_tolid_shamsi) {$filter_string.=' ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
	 if($noe_tahvil_bar) $filter_string.=' نوع تحویل بار : '.$tahvilbarArr_h[$noe_tahvil_bar].'&nbsp;';    
	 if($h_code) $filter_string.=' شماره حواله فروش : '.$h_code.'&nbsp;';     
	 if($shomare_jabejae) $filter_string.=' مجوزجابه جایی : '.$shomare_jabejae.'&nbsp;';     
	 if($code_customer) $filter_string.=' کد مشتری : '.$code_customer.'&nbsp;';     
	 if($code_bastebandy) {$sharhBastebandy=$db->get_from_where("sharh_bastebandy","$mydatabase.bastebandy","code_bastebandy='$code_bastebandy'"); $filter_string.=' بسته بندی : '.$sharhBastebandy.'&nbsp;';}     
	 if($status!='-1')
	 { 
	  if($status=='0') $filter_string.=' وضعیت حواله : '.$statusFormArr[$status].'&nbsp;';    
	  if($status=='1') $filter_string.=' وضعیت حواله : '.$statusFormArr[$status].'&nbsp;';    
     }
	 if ($shomare_kamiyon_h) $filter_string.=' شماره کامیون : '.$shomare_kamiyon_h.'&nbsp;';
	 if(($plak1)or($plak2)or($plak3)or($plak4)) 
	 {
	  $filter_string.=' پلاک خودرو :&nbsp;';
	  $filter_string.='  '.$plak1.'&nbsp;';
	  $filter_string.='  '.$plak2.'&nbsp;';
	  $filter_string.='  '.$plak3.'&nbsp;';
	  $filter_string.='  '.$plak4.'&nbsp;';}
	 if ($bsk_no!='') $filter_string.=' شماره باسکول : '.$bsk_no.'&nbsp;';
	 if ($vazn_khales_h) $filter_string.=' وزن خالص : '.$vazn_khales_h.'&nbsp;'; 	 
	 echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  //وزن ناخالص و تعداد کارتن با استفاده از تابع
	  //$vazn_nakhales_h=nakhales_havale($row['shomare_havale_anbar'],$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear);
	  //$tedad_karton_h=karton_havale($row['shomare_havale_anbar'],$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear);
	  $meghdar_tahvily=$db->get_from_where("SUM(vazn_khales_h)","$mydatabase.havale","h_code='".$row6['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
	  if($row['status']==0)//اگر حواله جاری است 
	  {
	   $sum_karton_h_jary+=$row['tedad_karton_h_d'];
	   $sum_vazn_nakhales_h_jary+=$row['vazn_nakhales_h_d'];
	   $sum_vazn_khales_h_jary+=$row['vazn_khales_h_d'];
	   $sum_shane_h_jary+=$row['tedad_shane_h_d'];
	  }
	  if($row['status']==1)//اگر حواله ابطالی است 
	  {
	  	$sum_karton_h_ebtaly+=$row['tedad_karton_h_d'];
	   	$sum_vazn_nakhales_h_ebtaly+=$row['vazn_nakhales_h_d'];
	    $sum_vazn_khales_h_ebtaly+=$row['vazn_khales_h_d'];
	    $sum_shane_h_ebtaly+=$row['tedad_shane_h_d'];
	  }
	  /*نام مشتری از سیستم سردخانه*/
	  if($_SESSION['mt_systemforush']==0)
	  {
	     //بدست آوردن کد مشتری
         if(($row['noe_tahvil_bar']==5)OR($row['noe_tahvil_bar']==7))
		 {
		  $q_jabejae="SELECT code_customer FROM $mydatabase.mojavez_jabejae WHERE shomare_jabejae='".$row['shomare_jabejae']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";
		  $res_jabejae=mysql_query($q_jabejae);
          $row_jabejae=mysql_fetch_array($res_jabejae);
		  $codeCustomer=$row_jabejae['code_customer'];
		 }
		 else 
		 {
		  $q_havale_forush="SELECT code_customer FROM $mydatabase.havale_forush WHERE h_code='".$row['h_code']."' AND code_ostan=".$row['code_ostan']." AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
          $res_havale_forush=mysql_query($q_havale_forush);
          $row_havale_forush=mysql_fetch_array($res_havale_forush);
	      $codeCustomer=$row_havale_forush['code_customer'];	 
		 }
	    //نام مشتری
	    $q_moshtary="SELECT name_customer FROM moshtary WHERE code_customer=".$codeCustomer." AND code_ostan=".$row['code_ostan']."";
        $res_moshtary=mysql_query($q_moshtary);
        $row_moshtary=mysql_fetch_array($res_moshtary);
        $nameMoshtary=$row_moshtary['name_customer'];	  
	  }
	  /*نام مشتری از سیستم فروش*/
      if($_SESSION['mt_systemforush']==1)
      {
	     //بدست آوردن کد مشتری
         if(($row['noe_tahvil_bar']==5)OR($row['noe_tahvil_bar']==7))
		 {
		  $q_jabejae="SELECT code_customer FROM $mydatabase.mojavez_jabejae WHERE shomare_jabejae='".$row['shomare_jabejae']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";
		  $res_jabejae=mysql_query($q_jabejae);
          $row_jabejae=mysql_fetch_array($res_jabejae);
		  $codeCustomer=$row_jabejae['code_customer'];
		 }
		 else
		 {
		  $q_havale_forush="SELECT h_customer_code FROM sell.dm_havale WHERE h_code='".$row['h_code']."' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";
		  $res_havale_forush=mysql_query($q_havale_forush);
          $row_havale_forush=mysql_fetch_array($res_havale_forush);
		  $codeCustomer=$row_havale_forush['h_customer_code'];
		  
		 }
	     //نام مشتری
	     //$q_moshtary="SELECT name_customer FROM dm_customer_asli WHERE code_customer=".$row_havale_forush['h_customer_code']." AND customer_code_org='$mt_gl_code_ostan'";
	     $q_moshtary="SELECT name_customer FROM sell.dm_customer_asli WHERE code_customer=".$codeCustomer."";
         $res_moshtary=mysql_query($q_moshtary);
         $row_moshtary=mysql_fetch_array($res_moshtary);
         $nameMoshtary=$row_moshtary['name_customer'];
      }
	  //اضافه کردن صفر پشت کد استان
	    if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
        else $code_a=$row['code_ostan'];	
       if($i++%2)echo'<tr class="print_table-odd_small">';
       else echo'<tr class="print_table-even_small">';  
	   echo'
	    <td>'.$radif++.'</td>
	    <td>'.$code_a.$row['code_anbar'].$row['shomare_havale_anbar'].'</td>
	    <td>'.$row['tarikh_havale_anbar'].'</td>
	    <td class="kalaPr">'.$row['name_kala'].'</td>';
	    IF(($row['noe_tahvil_bar']==4)OR($row['noe_tahvil_bar']==5)OR($row['noe_tahvil_bar']==7))
		  echo'<td class="forush_jabejaePr">'.$row['shomare_jabejae'].'</td>';
		ELSE 
		  echo'<td class="forush_jabejaePr">'.$row['h_code'].'</td>';
		IF($row['noe_tahvil_bar']==4)
		{
		 $ostan_maghsad=$db->get_from_where("name_ostan","$mydatabase.mojavez_jabejae INNER JOIN $mydatabase.ostan ON mojavez_jabejae.code_ostan_maghsad_j=ostan.code_ostan","mojavez_jabejae.code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year=".$row['year']." AND shomare_jabejae='".$row['shomare_jabejae']."'"); 
		 echo'
		 <td class="customerPr">'.$ostan_maghsad.'</td>';
		}
		ELSE 
		{echo'
		 <td class="customerPr">'.$nameMoshtary.'</td>';
		}
	    echo'
	    <td class="tolidkonandePr">'.$row['name_tolidkonande'].'</td>
		<td class="toliddatePr">'.$row['rouz_tolid_shamsi'].''.$mahshamsiArr[$row['mah_tolid_shamsi']].''.$row['sal_tolid_shamsi'].'</td>
		<td class="mandegariPr">'.$row['sharh_mandegari'].'</td>
		<td class="kartonPr">'.$row['vazn_karton_this'].'</td>
	    <td class="statusPr">'.$statusFormArr[$row['status']].'</td>
		<td class="tedadPr">'.virgul($row['tedad_karton_h_d']).'</td>
	    <td class="sumkartonPr">'.round($row['sum_karton_h_d'],3).'</td>
	    <td class="nakhalesPr">'.round($row['vazn_nakhales_h_d'],3).'</td>
	    <td class="khalesPr">'.round($row['vazn_khales_h_d'],3).'</td>
		<td class="shanePr">'.virgul($row['tedad_shane_h_d']).'</td>
		<!--<td>'.virgul($row['tedadKarton']).'</td>
	    <td>'.round($row['vaznKartonha'],3).'</td>
	    <td>'.round($row['vaznNaKhales'],3).'</td>
	    <td>'.round($row['vaznKhales'],3).'</td>-->
		'; 
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
	  $sum_tedad_karton+=$row['tedad_karton_h_d'];
	  $sum_vazn_kartonha+=$row['sum_karton_h_d'];
	  $sum_vazn_nakhales+=$row['vazn_nakhales_h_d'];
	  $sum_vazn_khales+=$row['vazn_khales_h_d'];
	  $sum_shane+=$row['tedad_shane_h_d'];
	 }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td id="sum_row" colspan="11">جمع مقادیر</td>
	   <td class="tedadPr">'.virgul($sum_tedad_karton).'</td>
	   <td class="sumkartonPr">'.round($sum_vazn_kartonha,3).'</td>
	   <td class="nakhalesPr">'.round($sum_vazn_nakhales,3).'</td>
	   <td class="khalesPr">'.round($sum_vazn_khales,3).'</td>
	   <td class="shanePr">'.virgul($sum_shane).'</td>
	  </tr>';	  
	 //مجموع وزن خالص و ناخالص و کارتن های جاری
	 echo'<tr class="print_table-even sum-row-white">
	       <td colspan="16" align="right">
		   &nbsp;&nbsp;&nbsp; مجموع تعداد کارتن حواله های جاری : '.($sum_karton_h_jary).' - مجموع وزن ناخالص حواله های جاری : '.round($sum_vazn_nakhales_h_jary,3).' - مجموع وزن خالص حواله های جاری : '.round($sum_vazn_khales_h_jary,3).'
		   - مجموع تعداد شانه حواله های جاری : '.($sum_shane_h_jary).'
		   </td>
		  </tr>'; 
	 //مجموع وزن خالص و ناخالص و کارتن های ابطالی
	 echo'<tr class="print_table-even sum-row-white">
	       <td colspan="16" align="right">
		   &nbsp;&nbsp;&nbsp; مجموع تعداد کارتن حواله های ابطالی : '.($sum_karton_h_ebtaly).' - مجموع وزن ناخالص حواله های ابطالی : '.round($sum_vazn_nakhales_h_ebtaly,3).' - مجموع وزن خالص حواله های ابطالی : '.round($sum_vazn_khales_h_ebtaly,3).'
		   - مجموع تعداد شانه حواله های ابطالی : '.($sum_shane_h_ebtaly).'
		   </td>
		  </tr>'; 
	 //اگر کاربر شماره حواله فروش را فیلتر کرده بود 
	 if($h_code) 
	 {
	   $bastebandy=$db->get_from_where("code_bastebandy","kala INNER JOIN havale ON havale.code_kala=kala.code_kala","h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0 ");
	   $c_kala=$db->get_from_where("havale.code_kala","kala INNER JOIN havale ON havale.code_kala=kala.code_kala","h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0 ");
	   if(($bastebandy==2)OR($bastebandy==5)OR($bastebandy==6))$havaleField='tedad_karton_h_d';
       else if(($c_kala==50)OR($c_kala==54)) $havaleField='tedad_shane_h_d';
       else $havaleField='vazn_khales_h_d';
	   echo'<tr class="print_table-even sum-row-white"><td colspan="16" align="right">&nbsp;&nbsp;&nbsp;&nbsp; مقدار مانده از حواله فروش : '.round($mande_az_forush,3).'</td></tr>'; 
	   if($noe_tahvil_bar)//اگر نوع تحویل بار را فیلتر کرده
	   {
	    //$tahvilCondition.=" and noe_tahvil_bar='$noe_tahvil_bar'";
		   $meghdar_tahvily=$db->get_from_where("SUM($havaleField)","$mydatabase.havale INNER JOIN $mydatabase.havale_detail ON havale.shomare_havale_anbar=havale_detail.shomare_havale_anbar AND havale.code_ostan=havale_detail.code_ostan AND havale.code_anbar=havale_detail.code_anbar AND havale.year=havale_detail.year","havale.code_ostan='$mt_gl_code_ostan' AND havale.code_anbar='$mt_gl_code_anbar' AND havale.year='$mtActiveYear' AND havale.deleted=0 AND havale.status=0 AND havale.h_code='$h_code' $Condition_havale");
	   	   echo'
		   <tr class="print_table-even sum-row-white">
	         <td colspan="16">
			  <table>
			   <tr>
	            <td align="right">&nbsp;&nbsp;&nbsp; مقدار تحویلی ('.$tahvilbarArr_h[$noe_tahvil_bar].') : '.round($meghdar_tahvily,3).'</td>
			   </tr>
			  </table>
			 </td>
			</tr>'; 
	   }
	   else//اگر نوع تحویل بار را نزده همه را نمایش می دهیم
	   {
	     //محاسبه مقدار تحویلی
         $meghdar_tahvily_1=$db->get_from_where("SUM($havaleField)","$mydatabase.havale INNER JOIN $mydatabase.havale_detail ON havale.shomare_havale_anbar=havale_detail.shomare_havale_anbar AND havale.code_ostan=havale_detail.code_ostan AND havale.code_anbar=havale_detail.code_anbar AND havale.year=havale_detail.year","havale.code_ostan='$mt_gl_code_ostan' AND havale.code_anbar='$mt_gl_code_anbar' AND havale.year='$mtActiveYear' AND havale.deleted=0 AND havale.status=0 AND havale.h_code='$h_code' AND noe_tahvil_bar=1 $Condition_havale");
         $meghdar_tahvily_2=$db->get_from_where("SUM($havaleField)","$mydatabase.havale INNER JOIN $mydatabase.havale_detail ON havale.shomare_havale_anbar=havale_detail.shomare_havale_anbar AND havale.code_ostan=havale_detail.code_ostan AND havale.code_anbar=havale_detail.code_anbar AND havale.year=havale_detail.year","havale.code_ostan='$mt_gl_code_ostan' AND havale.code_anbar='$mt_gl_code_anbar' AND havale.year='$mtActiveYear' AND havale.deleted=0 AND havale.status=0 AND havale.h_code='$h_code' AND noe_tahvil_bar=2 $Condition_havale");
         $meghdar_tahvily_3=$db->get_from_where("SUM($havaleField)","$mydatabase.havale INNER JOIN $mydatabase.havale_detail ON havale.shomare_havale_anbar=havale_detail.shomare_havale_anbar AND havale.code_ostan=havale_detail.code_ostan AND havale.code_anbar=havale_detail.code_anbar AND havale.year=havale_detail.year","havale.code_ostan='$mt_gl_code_ostan' AND havale.code_anbar='$mt_gl_code_anbar' AND havale.year='$mtActiveYear' AND havale.deleted=0 AND havale.status=0 AND havale.h_code='$h_code' AND noe_tahvil_bar=3 $Condition_havale");
         //این حالت ربطی به حواله فروش ندارد جابهجایی است
		 //$meghdar_tahvily_4=$db->get_from_where("SUM(vazn_khales_h)","havale","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0 AND h_code='$h_code' AND noe_tahvil_bar=4 $Condition_havale");
	     echo'
		 <tr class="print_table-even sum-row-white">
	      <td colspan="16">
	  	   <table>
	  	    <tr>
	              <td align="right">&nbsp;&nbsp;&nbsp; مقدار تحویلی (بارگیری از انبار) : '.round($meghdar_tahvily_1,3).'</td>
	              <td align="right">&nbsp;&nbsp;&nbsp; مقدار تحویلی (تحویل روباری) : '.round($meghdar_tahvily_2,3).'</td> 
	              <td align="right">&nbsp;&nbsp;&nbsp; مقدار تحویلی (حمل با راه آهن) : '.round($meghdar_tahvily_3,3).'</td>
	                <!--<td align="right">&nbsp;&nbsp;&nbsp;&nbsp; مقدار تحویلی (جابه جایی) : '.round($meghdar_tahvily_4,3).'</td>-->
	  	    </tr>
	  	   </table>
	  	  </td>
	  	 </tr>'; 
        }
	  }
 echo'
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
   <tr class="print_footer noExl">
    <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
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
         var count_for_sum=11;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var count_for_sum=count_for_sum-numberNotChecked;
		 $("#sum_row").attr("colspan",count_for_sum);
        }); 
});
</script>