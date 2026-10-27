<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_ebtal_forush.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش براساس فرم ابطال حواله فروش ';
require_once('head.html');
if($_SESSION['mt_systemforush']==0){$TableName="ebtal";}//اطلاعات ابطال از سیستم انبار
if($_SESSION['mt_systemforush']==1)//اطلاعات ابطال از سیستم فروش
{
 mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
 $TableName="dm_ebtal_h";
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
}
$columns='
	 <tr class="print_table-title2">
	  <td width="5%">ردیف</td>
	  <td width=15%>شماره برگه ابطال</td>
	  <td width=15%>تاریخ برگه ابطال</td>
	  <td width=15%>شماره حواله فروش</td>
	  <td width=20%>نام کالا</td>	
	  <td width=20%>نام مشتری</td>
	  <td width=10%>مقدار باطله</td>
	 </tr>';
Function print_header()
{global $mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$date1_titr,$date2_titr,$FileName,$page;
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
	     '.$titr.' از تاریخ : '.$date1_titr.' تا تاریخ : '.$date2_titr.'&nbsp&nbsp(صفحه : '.$page.')
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
/*نمایش اطلاعات در حالت سیستم انبار*/
if($_SESSION['mt_systemforush']==0)
{
 if(!$ok)
 {
 echo'
 <table width="95%" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td height="100%">
    <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
     <tr>
      <td colspan="4" class="title">'.$titr.'</td>	 
     </tr>
 	<tr class="tr1">	
      <td align="left" width="20%" height="40px"> از تاریخ : </td><td align="right" width="30%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td>
      <td align="left" width="15%" height="40px"> تا تاریخ : </td><td align="right" width="35%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
 	</tr>
 	<tr class="tr1">
      <td align="left" height="30px"> کد کالا : </td>
      <td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>
 	 	   	   <img border="0" src="images/help.png" onClick="window.open(\'help_kala.php\',\'_blank\',\'width=400px,left=20px,scrollbars=yes\')" title="جدول کد کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
 			   <!--<span style="color:red" id="codeK_Error">&nbsp;</span>--></td>
      <td align="left" height="30px"> کد مشتری : </td><td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_customer.'" name="code_customer" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;';
 			   include ("img_searchmoshtary.php");
	 echo'
	 </td>
	<tr>
 	<tr class="tr1">
 	 <td align="left"> شماره حواله فروش : </td>
 	 <td align="right">&nbsp;<input type="text" class="textboxme2" name="h_code" value="'.$h_code.'" onkeypress="return isNumber(event)"/>
 	           	       <img border="0" src="images/help.png" onClick="window.open(\'help_havaleforush.php\',\'_blank\',\'width=500px,left=20px,scrollbars=yes\')" title="جدول شماره حواله فروش" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td>
 	 </td> 
	 <td align="left" height="40px"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
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
    //if (!$date1) $date1=$db->get_from_where("min(tarikh_barge_ebtal)","ebtal","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");//اگر کاربر تاریخ اول را وارد نکرده بود
    //if (!$date2) $date2=$db->get_from_where("max(tarikh_barge_ebtal)","ebtal","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");//اگر کاربر تاریخ دوم را وارد نکرده بود    
    /****************فیلترها روی گزارش******************/
    if ($date1) $Condition.=" and tarikh_barge_ebtal>='$date1'";//از تاریخ
    if ($date2) $Condition.=" and tarikh_barge_ebtal<='$date2'";//تا تاریخ 
	if ($h_code) $Condition.=" and ebtal.h_code='$h_code'";//شماره حواله فروش	
    if ($code_kala) $Condition.=" and h_f.code_kala='$code_kala'";//کد کالا
    if ($code_customer) $Condition.=" and code_customer='$code_customer'";//کد مشتری	
    /****************شروع نمایش گزارش*******************/  
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	// $q=("SELECT ebtal.*,havale_forush.code_kala,havale_forush.code_customer FROM ebtal 
         // INNER JOIN havale_forush ON havale_forush.h_code=ebtal.h_code 
	     // WHERE 1=1 $Condition AND ebtal.deleted=0 ORDER BY tarikh_barge_ebtal");//برای ادمین
    $q=("SELECT ebtal.*,kala.name_kala,h_f.code_kala,h_f.code_customer FROM ebtal     
		 INNER JOIN havale_forush h_f ON h_f.h_code=ebtal.h_code AND h_f.code_ostan=ebtal.code_ostan AND h_f.code_anbar=ebtal.code_anbar AND h_f.year=ebtal.year
         LEFT JOIN kala ON h_f.code_kala=kala.code_kala		 
	     WHERE 1=1 $Condition AND ebtal.tarikh_barge_ebtal>='$mtStartDateSh' AND h_f.h_reg_date>='$mtStartDateSh' AND ebtal.code_ostan='$mt_gl_code_ostan' AND ebtal.code_anbar='$mt_gl_code_anbar' AND ebtal.year='$mtActiveYear' AND ebtal.deleted=0 ORDER BY tarikh_barge_ebtal");
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
	{
	 echo'<div class="table2excel">';
	 print_header();
	  /*سطر نمایش فیلترها*/
	  if($code_kala) {$nameKala=$db->get_from_where("name_kala","meat.kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
	  if($code_customer) {$nameCustomer=$db->get_from_where("name_customer","moshtary","code_ostan='$mt_gl_code_ostan' AND code_customer='$code_customer'");$filter_string.=' مشتری : '.$nameCustomer.'&nbsp;';}         
      if($h_code) {$filter_string.=' شماره حواله فروش : '.$h_code.'&nbsp;';}     
	  if(($code_kala)or($code_customer)or($h_code))
	  {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
     echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  $nameMoshtary=$db->get_from_where("name_customer","moshtary","code_customer=".$row['code_customer']." AND code_ostan='$mt_gl_code_ostan'");//نام مشتری مورد نظر
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  echo'
	    <td>'.$radif++.'</td>
	    <td>'.$row['code_ostan'].$row['code_anbar'].$row['shomare_barge_ebtal'].'</td>
	    <td>'.$row['tarikh_barge_ebtal'].'</td>
	    <td>'.$row['h_code'].'</td>
	    <td>'.$row['name_kala'].'</td>
	    <td>'.$nameMoshtary.'</td>
	    <td>'.($row['meghdar_batele']).'</td>';
     echo'</tr>';
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
	  $sum+=$row['meghdar_batele'];	   
	 }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b"><td colspan="6" align="right">&nbsp;&nbsp;&nbsp;&nbsp; جمع مقادیر : </td><td>'.($sum).'</td></tr>	 
	 <!--پايان مرکز صفحه -->
	 <!-- چاپ زیرنویس-->
      <tr class="print_footer noExl">
       <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
      </tr>
	 </table>';
	}
	 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
 }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*نمایش اطلاعات در حالت سیستم فروش*/
if($_SESSION['mt_systemforush']==1)
{
 if(!$ok)
 {
 echo'
  <table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td height="100%">
     <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr><td colspan="4" height="20px">&nbsp;</td></tr>
      <tr>
       <td colspan="4" class="title">'.$titr.'</td>	 
      </tr>
   	<tr class="tr1">';
      echo'	
       <td align="left" height="40px"> از تاریخ : </td><td align="right" width="30%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td>
       <td align="left" height="40px"> تا تاریخ : </td><td align="right" width="35%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
   	</tr>
   	<tr class="tr1">
       <td align="left" height="30px"> کد کالا : </td>
       <td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>
   	 	   	   <img border="0" src="images/help.png" onClick="window.open(\'help_kala.php\',\'_blank\',\'width=400px,left=20px,scrollbars=yes\')" title="جدول کد کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
       <td align="left" height="30px"> کد مشتری : </td><td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_customer.'" name="code_customer" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;';
	   	include ("img_searchmoshtary.php");
		echo'
	   </td>
   	<tr>
   	<tr class="tr1">
   	 <td align="left"> شماره حواله فروش : </td><td align="right">&nbsp;<input type="text" class="textboxme2" name="h_code" value="'.$h_code.'" onkeypress="return isNumber(event)"/></td> 
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
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
	  mysql_select_db("$mydatabase") or die('no Select Db BECAUSE: ' . mysql_error());
	  if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
	  {
	   $res_y1=mysql_query("select start_from FROM mt_docs WHERE year='$mtActiveYear'");
	   $row_y1=mysql_fetch_array($res_y1);
	   $date1_titr=$row_y1[0];
	   //$date1_titr=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
	  } 
     //اگر کاربر تاریخ دوم را وارد نکرده بود
	 if(!$date2)
	 {
	  $today=AsLDate($yymmdd); 
	  $res_y2=mysql_query("select end_to FROM mt_docs WHERE year='$mtActiveYear'");
	  $row_y2=mysql_fetch_array($res_y2);
	  $end_date_session=$row_y2[0];
 	  //$end_date_session=$db->get_from_where("end_to","mt_docs","year='$mtActiveYear'");
	  if($today<$end_date_session) $date2_titr=$today;
      else  $date2_titr=$end_date_session;	 
	 } 
     mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
    /****************فیلترها روی گزارش******************/
    if ($date1)//از تاریخ
	{     
	 //تبدیل تاریخ شمسی به میلادی
	 $sql_tarikh=$date1;
     $d=substr($sql_tarikh,8,2);
     $m=substr($sql_tarikh,5,2);
     $y=substr($sql_tarikh,0,4);
     $milady=jalali_to_gregorian($y,$m,$d);
     $sal=$milady[0];
     $mah=$milady[1];
     $rouz=$milady[2];
     $date1=$sal.'-'.$mah.'-'.$rouz;
	 $Condition.=" and ebh_reg_date>='$date1'";
	}
     if ($date2)//تا تاریخ 
	 {
	  //تبدیل تاریخ شمسی به میلادی
	  $sql_tarikh=$date2;
      $d=substr($sql_tarikh,8,2);
      $m=substr($sql_tarikh,5,2);
      $y=substr($sql_tarikh,0,4);
      $milady=jalali_to_gregorian($y,$m,$d);
      $sal=$milady[0];
      $mah=$milady[1];
      $rouz=$milady[2];
      $date2=$sal.'-'.$mah.'-'.$rouz;
	  $Condition.=" and ebh_reg_date<='$date2'";
	 }
	 if ($h_code) $Condition.=" and dm_his_havale.his_h_code='$h_code'";//شماره حواله فروش	
     if ($code_kala) $Condition.=" and h_p_code='$code_kala'";//کد کالا
     if ($code_customer) $Condition.=" and h_customer_code='$code_customer'";//کد مشتری	
    /****************شروع نمایش گزارش*******************/  
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	$q="SELECT dm_ebtal_h.ebh_code,dm_ebtal_h.ebh_reg_date,dm_his_havale.his_h_code,dm_his_havale.his_eb_amount,dm_havale.h_customer_code,dm_havale.h_p_code
	     FROM dm_ebtal_h
		 INNER JOIN dm_his_havale ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id 
		 INNER JOIN dm_havale ON  dm_havale.h_id=dm_his_havale.his_h_id
		 WHERE 1=1 $Condition AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' order by ebh_reg_date";
	$res=mysql_query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
	{
	 //تبدیل تاریخ میلادی به شمسی
	    if($date1){
	    $sql_tarikh=$date1;
        $d=substr($sql_tarikh,8,2);
        $m=substr($sql_tarikh,5,2);
        $y=substr($sql_tarikh,0,4);
        $shamsi=gregorian_to_jalali($y,$m,$d);
        $sal=$shamsi[0];
        $mah=$shamsi[1];
        $rouz=$shamsi[2];
        $date1_titr=$sal.'/'.$mah.'/'.$rouz;}
	  //تبدیل تاریخ میلادی به شمسی
	    if($date2){
	    $sql_tarikh=$date2;
        $d=substr($sql_tarikh,8,2);
        $m=substr($sql_tarikh,5,2);
        $y=substr($sql_tarikh,0,4);
        $shamsi=gregorian_to_jalali($y,$m,$d);
        $sal=$shamsi[0];
        $mah=$shamsi[1];
        $rouz=$shamsi[2];
        $date2_titr=$sal.'/'.$mah.'/'.$rouz;}
	    echo'<div class="table2excel">';
	    print_header();
		/*سطر نمایش فیلترها*/
	    if($code_kala) {$nameKala=$db->get_from_where("name_kala","meat.kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
	    if($code_customer) {$nameCustomer=$db->get_from_where("name_customer","sell.dm_customer_asli","customer_code_org='$mt_gl_code_ostan' AND code_customer='$code_customer'");$filter_string.=' مشتری : '.$nameCustomer.'&nbsp;';}         
        if($h_code) {$filter_string.=' شماره حواله فروش : '.$h_code.'&nbsp;';}     
	    if(($code_kala)or($code_customer)or($h_code))
	    {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
     echo $columns;		
	 while($row=mysql_fetch_assoc($res))
	 {
	  $line++;
	  //تبدیل تاریخ میلادی به شمسی
	   $sql_tarikh=$row['ebh_reg_date'];
       $d=substr($sql_tarikh,8,2);
       $m=substr($sql_tarikh,5,2);
       $y=substr($sql_tarikh,0,4);
       $shamsi=gregorian_to_jalali($y,$m,$d);
       $sal=$shamsi[0];
       $mah=$shamsi[1];
       $rouz=$shamsi[2];
       $tarikh_ebtal=$sal.'/'.$mah.'/'.$rouz;
	  /*نام مشتری از سیستم فروش*/
	   $q_moshtary="SELECT name_customer FROM dm_customer_asli WHERE code_customer=".$row['h_customer_code']."";
	   $res_moshtary=mysql_query($q_moshtary);
       $row_moshtary=mysql_fetch_array($res_moshtary);
       $nameMoshtary=$row_moshtary['name_customer'];
     /*اطلاعات لازم از سیستم انبار*/
      mysql_select_db("$mydatabase") or die('no Select Db BECAUSE: ' . mysql_error());
  	  //نام کالای مورد نظر	 	
  	  $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row['h_p_code']."");
      mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
	
	 if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  echo'
	   <td>'.$radif++.'</td>
	   <td>'.$row['ebh_code'].'</td>
	   <td>'.$tarikh_ebtal.'</td>
	   <td>'.$row['his_h_code'].'</td>
	   <td>'.$nameKala.'</td>
	   <td>'.$nameMoshtary.'</td>
	   <td>'.($row['his_eb_amount']).'</td>';   
	  echo'</tr>';
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
	  $sum+=$row['his_eb_amount'];	  
	 }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b"><td colspan="6" align="right">&nbsp;&nbsp;&nbsp;&nbsp; جمع مقادیر : </td><td>'.($sum).'</td></tr>
	<!--پايان مرکز صفحه -->
	<!-- چاپ زیرنویس-->
	 <!-- چاپ زیرنویس-->
     <tr class="print_footer noExl">
      <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
     </tr>
	</table>';
	}
	 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
 }
}
echo'
</div>	
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>