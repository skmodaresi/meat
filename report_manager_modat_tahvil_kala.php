<?php
require_once __DIR__ . '/mysql_compat.php';
//این گزارش در هاست با اتصال به فروش نوشته شده
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$TableName="sell.dm_havale";
$FileName="report_manager_modat_tahvil_kala.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش مدت زمان تحویل کالا به مشتری';
require_once('head.html');

/*سیستم فروش*/
//پیدا کردن آی دی سال مربوط به سیستم فروش
//$sellYearCode=substr($mtActiveYear,2);
//$res_sal=mysql_query("SELECT year_id FROM sell.dm_year WHERE year_code='$sellYearCode'");
//$sellYearId=mysql_result($res_sal, 0, 'year_id');
$columns='
	<tr class="print_table-title2" style="height:60px;">
	   <td width="2%">ردیف</td>
	   <td width="5%">استان</td>
	   <td width="9%">سردخانه</td>
	   <td width="5%">شماره حواله فروش</td>
	   <td width="5%">تاریخ حواله فروش</td>
	   <td width="5%">شماره مجوز</td>
	   <td width="5%">نرخ فروش</td> 
	   <td width="9%">نام مشتری</td>
	   <td width="11%">نام کالا</td>	   
	   <td width="5%">شماره آخرین حواله</td>
	   <td width="5%">تاریخ آخرین حواله</td>	   
	   <td width="8%">مدت زمان تحویل</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
  echo'
   <br>   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2">'.$titr.'</td></tr>
	   <tr class="noExl">
	    <td class="print_title_2">';
	    IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
         echo' 
	     از تاریخ حواله فروش : '.$date1.' تا تاریخ حواله فروش : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
        <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
	   </tr>
      </table>
	 </td>
	</tr> ';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform" id="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=10;
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
{
	  $date1=$db->get_from_where("start_from","meat.mt_docs","year='$mtActiveYear'");  
} 
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
	 $today=AsLDate($yymmdd); 
 	 $end_date_session=$db->get_from_where("end_to","meat.mt_docs","year='$mtActiveYear'");
	 if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
} 
if(!$ok)
{
echo'
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
 <tr>
  <td height="100%">
   <table width="750px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
	<tr class="tr1" style="height:45px">	
     <td align="left" width="150px"> از تاریخ حواله فروش :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
     <td align="left" width="140px"> تا تاریخ حواله فروش :&nbsp;</td><td align="right" ><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>';
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{echo'
       <tr class="tr1"><td align="left" > استان :&nbsp;</td><td align="right">'.listbox_ostan("code_ostan","$code_ostan","code_ostan","name_ostan","meat.ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4' onChange='myform.submit()' ").'</td>';	  	  	    
	   if(($code_ostan)) echo'<td align="left"> سردخانه :&nbsp;</td><td align="right">'.listbox_anbar("code_anbar",$code_anbar,"code_anbar","name_anbar","meat.list_sardkhane","1=1 and code_ostan=$code_ostan ORDER BY list_sardkhane.name_anbar ASC","class='text4'").'</td>';
	   else echo'<td colspan="2"></td>';
		//echo'<td align="left" > سردخانه :&nbsp;</td><td align="right"><select class="easyui-combobox" name="code_anbar"  onChange="$(\'#myform\').submit();"  ><option value="0">انتخاب کنيد</option><option value="1">1</option><option value="2">2</option></select></td>';
	}
	else 
	{
	 echo'
	 <tr class="tr1">
	 <td align="left"> سردخانه :&nbsp;</td>
     <td align="right" colspan="3">
	  <select name="sardkhanechoice[]" class="easyui-combobox" multiple="true" style="width:50%;">
	  <!--<select name="sardkhanechoice[]" size="4" style="width:330px;" multiple>-->';
	  $result_sardkhane = $db->query("SELECT * FROM meat.user_ostan_anbar INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']." ORDER BY list_sardkhane.name_anbar ASC");
      $sardkhane_options = "<option value='-1' selected>همه سردخانه ها</option>";
      while($row_sardkhane=$db->fetch_assoc($result_sardkhane)) $sardkhane_options.= "<option value=".$row_sardkhane['code_anbar'].">".$row_sardkhane['name_anbar']."</option>";
	  echo $sardkhane_options;
	  echo'
	  </select>
	  <!--<img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>-->
	 </tr>';
	}
	echo'  
	<!--<tr class="tr1">	
     <td align="left"> شماره حواله فروش :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="h_code" value="'.$h_code.'" onkeypress="return isNumber(event)"/>&nbsp;';
	  include ("img_helphavaleforush_report.php");
	 echo'
	 </td>
	</tr>-->
	<tr class="tr1" >
     <td align="left" height="40px"> نام کالا :&nbsp;</td>
     <td align="right" colspan="3">
	  <select name="kalachoice[]" class="easyui-combobox" multiple="true" style="width:50%;">';
	  $result_kala = $db->query("SELECT * FROM meat.kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']."</option>";
	  echo $kala_options;
	  echo'
	  </select>
	 </td>
	</tr>
	<tr class="tr1">
	 <td align="left" height="40px"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	 <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
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
	$Condition_anbar="1=1"; 
	$Condition_kala="1=1";
    /****************فیلترها روی گزارش******************/
     //if ($date1) $Condition.=" and T.h_reg_date>='$date1'";//از تاریخ
     //if ($date2) $Condition.=" and T.h_reg_date<='$date2'";//تا تاریخ 
	
    if($date1)//از تاریخ
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
     $date1_sell=$sal.'-'.$mah.'-'.$rouz;
	 $Condition.=" and h_reg_date>='$date1_sell'";
	}
    if($date2)//تا تاریخ 
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
      $date2_sell=$sal.'-'.$mah.'-'.$rouz;
	  $Condition.=" and h_reg_date<='$date2_sell'";
	}
	/*******استان ها*******/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
    {  
	  if($code_ostan==-1){$Condition_ostan.="1=1";$Condition_ostan_sell.="1=1";$Condition_ostan_ebtal_sell.="1=1";}
	  else{
		    $Condition_ostan=' h.code_ostan='.$code_ostan.'';   
			$sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='$code_ostan'");//تبدیل کد به آی دی
            $Condition_ostan_sell.=" T.h_id_province='$sell_id_ostan'";
	        $Condition_ostan_ebtal_sell.=" dm_his_havale.his_id_province='$sell_id_ostan'";  
		  }
	}
	else 
    {
	  $Condition_ostan=' h.code_ostan='.$_SESSION['mt_code_ostan'].'';
	  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='".$_SESSION['mt_code_ostan']."'");//تبدیل کد به آی دی
	  $Condition_ostan_sell=' T.h_id_province='.$sell_id_ostan.'';
	  $Condition_ostan_ebtal_sell=' dm_his_havale.his_id_province='.$sell_id_ostan.'';
    }
	/******سردخانه ها******/
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	  //if(($code_ostan==-1)or($code_anbar==-1)){$Condition_anbar='1=1';}
      //else{$Condition_anbar=' T.code_anbar='.$code_anbar.'';}
	  if(($code_ostan==-1)or($code_anbar==-1))	{$Condition_anbar='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
      else
	  {
		$Condition_anbar=' h.code_anbar='.$code_anbar.'';  
	  	$sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='$code_ostan'");//تبدیل کد به آی دی
        $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$code_anbar."");//تبدیل کد به آی دی 
        $Condition_anbar_sell.=" T.h_l_code=".$sell_id_anbar."";
	    $Condition_anbar_ebtal_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar."";
	  }
	}
	else //بقیه کاربران براساس انبار قابل دسترسیشان وانتخاب یکی یا چند تا
    {  
      if(is_array($sardkhanechoice))
     {
       $Condition_anbar="";//شرط را خالی میکنم
	   $Condition_anbar_sell="";
	   $Condition_anbar_sell="";
	   foreach($sardkhanechoice as $anbar_key => $anbar_val) 
	   {
		   $Condition_anbar_temp.=" h.code_anbar='$anbar_val' OR";
		   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
           $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$anbar_val."");//تبدیل کد به آی دی 
	       if($sell_id_anbar)//اگر نظیرش در فروش بود
           {$Condition_anbar_temp_sell.=" T.h_l_code=".$sell_id_anbar." OR";
	        $Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
	   }
       if($anbar_val==-1) {$Condition_anbar.="1=1 OR";$Condition_anbar_sell.="1=1 OR";$Condition_anbar_ebtal_sell.="1=1 OR";}
       else {$Condition_anbar.=" $Condition_anbar_temp";$Condition_anbar_sell.=" $Condition_anbar_temp_sell";$Condition_anbar_ebtal_sell.=" $Condition_anbar_ebtal_temp_sell";}

	   $lastSpacePosition = strrpos($Condition_anbar," ");
       $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
       $lastSpacePosition_ebtal_sell = strrpos($Condition_anbar_ebtal_sell," ");
	   $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
	   $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
       $Condition_anbar_ebtal_sell =substr($Condition_anbar_ebtal_sell,0,$lastSpacePosition_ebtal_sell);
     }    
	}
	/******کد های کالا******/
    if(is_array($kalachoice))
    {
	  $Condition_kala="";//شرط را خالی میکنم
	  foreach($kalachoice as $kala_key => $kala_val) {$Condition_kala_temp.=" h.code_kala='$kala_val' OR";}
      if($kala_val==-1) $Condition_kala.="1=1 OR";
      else $Condition_kala.=" $Condition_kala_temp";
      $lastSpacePosition = strrpos($Condition_kala," ");
      $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
    }
	/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
    if($chkactivate=='on') {$Condition_anbar_activate="1=1"; $Condition_anbar_activate_sell=""; }
    else {$Condition_anbar_activate="list_sardkhane.activate=1"; $Condition_anbar_activate_sell="activate=1 AND"; }
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
	// //حواله هایی که حواله فروش دارند و جزئیات برایشان ثبت شده
	// $q="SELECT T.*,kala.name_kala,ostan.name_ostan,list_sardkhane.name_anbar,h_d.sal_tolid_shamsi,h_d.mah_tolid_shamsi,h_d.rouz_tolid_shamsi,h_d.code_karton,h_d.vazn_karton_this,h_d.tedad_karton_h_d,h_d.vazn_nakhales_h_d,h_d.sum_karton_h_d,h_d.vazn_khales_h_d, 
	   // (SELECT SUM(tedad_karton_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year $Condition_h_d)tedadKarton,
	   // (SELECT SUM(sum_karton_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year $Condition_h_d)vaznKartonha,
	   // (SELECT SUM(vazn_nakhales_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year $Condition_h_d)vaznNaKhales,
	   // (SELECT SUM(vazn_khales_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year $Condition_h_d)vaznKhales
		// FROM havale T
        // INNER JOIN kala ON T.code_kala=kala.code_kala    		
	    // INNER JOIN havale_detail h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year    
		// INNER JOIN ostan ON ostan.code_ostan=T.code_ostan
		// INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
		// WHERE 1=1 $Condition_havale $Condition_h_d AND($Condition_ostan) AND($Condition_anbar) AND ($Condition_kala) AND($Condition_mah) AND T.h_code!=0 AND T.year='$mtActiveYear' AND T.deleted=0 ORDER BY name_ostan,name_anbar,T.tarikh_havale_anbar";		
	
	// $q="SELECT T.*,name_kala,name_ostan,name_anbar FROM $TableName T 
	    // INNER JOIN meat.havale h ON h.h_id=T.id
	    // INNER JOIN meat.havale_detail h_d ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year 
		// INNER JOIN meat.kala ON h.code_kala=kala.code_kala    		
		// INNER JOIN meat.ostan ON ostan.code_ostan=h.code_ostan
		// INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=h.code_ostan AND list_sardkhane.code_anbar=h.code_anbar
		// WHERE 1=1 $Condition AND($Condition_anbar) AND ($Condition_kala) AND T.year='$mtActiveYear' GROUP BY h_id ORDER BY name_ostan,name_anbar,h_code ";
	
	$q="SELECT T.*,name_kala,h.code_ostan,name_ostan,h.code_anbar,h.year,name_anbar FROM $TableName T 
	    INNER JOIN meat.havale h ON h.h_id=T.h_id
	    INNER JOIN meat.havale_detail h_d ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year 
		INNER JOIN meat.kala ON h.code_kala=kala.code_kala    		
		INNER JOIN meat.ostan ON ostan.code_ostan=h.code_ostan
		INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=h.code_ostan AND list_sardkhane.code_anbar=h.code_anbar
		WHERE 1=1 $Condition AND($Condition_anbar_activate) AND($Condition_ostan) AND($Condition_anbar) AND ($Condition_kala) AND h_id_year='$sellYearId' AND h.deleted=0 AND h.status=0 GROUP BY h_id ORDER BY name_ostan,name_anbar,h_code ";

	//echo $q;
	$res=$db->query($q);
	$cntr=mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
	{
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if($code_ostan) {if($code_ostan=='-1'){$nameOstan='همه استانها';}else{$nameOstan=$db->get_from_where("name_ostan","meat.ostan","code_ostan='$code_ostan'");}$filter_string.=' استان : '.$nameOstan.'&nbsp;';}     
	 if($code_anbar) {if($code_anbar=='-1'){$nameAnbar='همه سردخانه ها';}else{$nameAnbar=$db->get_from_where("name_anbar","meat.list_sardkhane","code_ostan='$code_ostan' AND code_anbar='$code_anbar'");}$filter_string.=' سردخانه : '.$nameAnbar.'&nbsp;';}     
	 if(is_array($sardkhanechoice))//بقیه کاربران
	 {
	  if($anbar_val==-1)$filter_string2=' سردخانه : همه سردخانه ها ';
	  else $filter_string2=' سردخانه : ';
	  foreach($sardkhanechoice as $anbar_key => $anbar_val) {
	  $nameAnbar=$db->get_from_where("name_anbar","$mydatabase.list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$anbar_val'");
	  $filter_string2.=''.$nameAnbar.'&nbsp;';
      }
	 }
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if(is_array($kalachoice))
	 {
	  if($kala_val==-1)$filter_string3=' کالا : همه کالاها';
	  else $filter_string3=' کالا : ';
	  foreach($kalachoice as $kala_key => $kala_val) {
	  $nameKala=$db->get_from_where("name_kala","$mydatabase.kala","code_kala='$kala_val'");
	  $filter_string3.=''.$nameKala.'&nbsp;';
      }
	 }
	 if(($code_ostan)or($sardkhanechoice)or($kalachoice))
	 {echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.$filter_string2.$filter_string3.$filter_string4.'</td></tr>';}
	  echo $columns;	 
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  //$q_havale_max="SELECT shomare_havale_anbar,tarikh_havale_anbar FROM havale WHERE h_code=".$row['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year=".$row['year']." AND deleted=0 AND status=0 AND tarikh_havale_anbar=(SELECT MAX(tarikh_havale_anbar) FROM havale WHERE h_code=".$row['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year=".$row['year']." AND deleted=0 AND status=0)";
	  $q_havale_max="SELECT shomare_havale_anbar,tarikh_havale_anbar FROM $mydatabase.havale WHERE h_code=".$row['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year=".$row['year']." AND deleted=0 AND status=0 ORDER BY tarikh_havale_anbar DESC,shomare_havale_anbar DESC LIMIT 1";
	  $res_havale_max=$db->query($q_havale_max);
	  $row_havale_max=$db->fetch_assoc($res_havale_max);
      //echo $q_havale_max.'<br>'; 
	  /*نام مشتری از سیستم سردخانه*/
	  // if($_SESSION['mt_systemforush']==0)
	 // {
	   // $tarikh_forush=$row['h_reg_date'];
		// //بدست آوردن کد مشتری
        // $q_havale_forush="SELECT code_customer,h_reg_date FROM meat.havale_forush WHERE h_code='".$row['h_code']."' AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year='$mtActiveYear'";
        // $res_havale_forush=mysql_query($q_havale_forush);
        // $row_havale_forush=mysql_fetch_array($res_havale_forush);
	    // $nameMoshtary=$row_havale_forush['code_customer'];
	    // $tarikh_forush=$row_havale_forush['h_reg_date'];
		// //نام مشتری
	    // //$q_moshtary="SELECT name_customer FROM moshtary WHERE code_customer=".$row_havale_forush['code_customer']." AND code_ostan=".$row['code_ostan']."";
	    // $q_moshtary="SELECT name_customer FROM meat.moshtary WHERE code_customer=".$row_havale_forush['code_customer']."";
        // $res_moshtary=mysql_query($q_moshtary);
        // $row_moshtary=mysql_fetch_array($res_moshtary);
        // $nameMoshtary=$row_moshtary['name_customer'];	  
	   //}
	  /*نام مشتری از سیستم فروش*/
      //else
      //{
		 //نام مشتری
	     $q_moshtary="SELECT name_customer FROM sell.dm_customer_asli WHERE code_customer=".$row['h_customer_code']."";
         $res_moshtary=mysql_query($q_moshtary);
         $row_moshtary=mysql_fetch_array($res_moshtary);
         $nameMoshtary=$row_moshtary['name_customer'];
      	 //تبدیل تاریخ میلادی به شمسی
	     $sql_tarikh=$row['h_reg_date'];
         $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
         $shamsi=gregorian_to_jalali($y,$m,$d);
         $sal=$shamsi[0];$mah=$shamsi[1];$rouz=$shamsi[2];
         $tarikh_forush=$sal.'/'.$mah.'/'.$rouz;
		 $ph_mojavez=$db->get_from_where("ph_mojavez","sell.dm_havale INNER JOIN sell.dm_pish_havale_det ON h_phd_id=phd_id INNER JOIN sell.dm_pish_havale ON ph_code=phd_ph_code AND ph_id_province=phd_id_province","h_code='".$row['h_code']."' AND h_id_province=".$row['h_id_province']." AND h_l_code=".$row['h_l_code']." AND h_id_year=".$row['h_id_year']."");     
		 
	  //}
	   //اضافه کردن صفر پشت کد استان
	    if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
        else $code_a=$row['code_ostan'];	
        if($i++%2)echo'<tr class="print_table-odd_small">';
        else echo'<tr class="print_table-even_small">';  
	   //اختلاف تاریخ حواله فروش با آخرین حواله سردخانه
		 $tarikh_havale=$row_havale_max['tarikh_havale_anbar'];//تاریخ حواله
		 if($tarikh_forush<$tarikh_havale)$ekhtelaf_tarikh=calculate_date_diff($tarikh_forush,$tarikh_havale);
		 else if ($tarikh_forush==$tarikh_havale) $ekhtelaf_tarikh='همان روز';
		 else $ekhtelaf_tarikh=calculate_date_diff($tarikh_havale,$tarikh_forush).'از تاریخ گذشته';
	   echo'
	    <td>'.$radif++.'</td>
	    <td>'.$row['name_ostan'].'</td>
	    <td>'.$row['name_anbar'].'</td>
		<td>'.$row['h_code'].'</td>
		<td>'.$tarikh_forush.'</td>
	    <td>'.$ph_mojavez.'</td>
		<td>'.virgul($row['h_p_price']).'</td>
		<td>'.$nameMoshtary.'</td>
		<td>'.$row['name_kala'].'</td>
		<td>'.$code_a.$row['code_anbar'].$row_havale_max['shomare_havale_anbar'].'</td>
	    <td>'.$row_havale_max['tarikh_havale_anbar'].'</td>
	    <td>'.$ekhtelaf_tarikh.'</td>
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
	  //$sum_vazn_khales+=$row['vazn_khales_h_d'];
	 }//END while
	 // echo'
	  // <tr class="print_table-even sum-row-white-b">
	   // <td colspan="12">جمع مقادیر</td>
	   // <td>'.round($sum_vazn_khales,3).'</td>
	  // </tr>';	  
 echo'
 <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنوس-->';
  require_once('prt-footer.php');
 echo' 
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
 $("[name=code_ostan]").change(function() {
	myform.submit();
 });	  
});
<!-- تعویض انبار با انتخاب استان-->
function getAnbareOstan(code_ostan)
{
   $("#loading").fadeIn("fast");  
   $.post("ajax_mojavez_jabejae.php",{codeOSTAN1:code_ostan},function(data){$("[name=code_anbar]").html(data);});
   $("#loading").fadeOut("fast");		
}
</script> 