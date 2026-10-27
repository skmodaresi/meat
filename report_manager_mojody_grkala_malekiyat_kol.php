<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_grkala_malekiyat_kol.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش مانده موجودی کلی کالاها براساس مالکیت سردخانه ها و تحت کلید (مرغ و گوشت)';
require_once('head.html');
$columns='
 	<tr class="print_table-title2">
	 <td width="5%" rowspan="3">ردیف</td>
	 <td width="15%" rowspan="3">استان</td>
	 <td width="25%" colspan="9">موجودی گوشت</td>
	 <td width="25%" colspan="9">موجودی مرغ</td>
	 <td width="30%" colspan="9">موجودی کل</td>
	</tr>
	<tr class="print_table-title2">';
	for($count=1;$count<=3;$count++)
	{
         $columns.='
		 <td colspan="2">سردخانه ملکی</td>
		 <td colspan="2">سردخانه استیجاری</td>
		 <td colspan="2">موجودی استان تحت کلید</td>
		 <td colspan="2">بار تحت کلید</td>
    	 <td rowspan="2">موجودی ملکی و استیجاری و موجودی استان</td>';
    }
    $columns.='</tr>
	<tr class="print_table-title2">';
    for($count=1;$count<=12;$count++)
	{
         $columns.='
		 <td >داخلی</td>
    	 <td >وارداتی</td>';
		 }
     $columns.='</tr>';
	 
/****************هدر******************/
Function print_header()
{global $titr,$count,$mt_gl_owner,$date1,$date2,$FileName,$page,$db;
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
	       از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
	      <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	     </td>
	   </tr>
	  </table>
	 </td>
    </tr>';
}
/****************فیلترها روی گزارش******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
  if(is_array($ostanchoice))//کد های استان
  {
    foreach($ostanchoice as $key => $val ) {
    $Condition_ostan.=" code_ostan='$val' OR";
    }
    if($val==-1)$Condition.="";
    else $Condition.=" and $Condition_ostan";
   $lastSpacePosition = strrpos($Condition," ");
   $Condition =substr($Condition,0,$lastSpacePosition);
  }
}
else $Condition=' AND code_ostan='.$_SESSION['mt_code_ostan'].'';
/******************نمایش یا عدم نمایش سردخانه های موقت******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND";  $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date2.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=15;
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)
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
   <table width="800px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px;">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:100").'</td>	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; همراه با اطلاعات سردخانه موقت </td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	  echo'
	 <tr class="tr1">
	  <td align="left" height="40px">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" style="width:200px;" multiple>';
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
	$dateCond="";
    $radif=1;
	/****************فیلترها روی گزارش******************/	
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_anbar_activate_ostan) $Condition ORDER BY name_ostan";
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if(($ostanchoice))
	 {
	  if($val==-1)$filter_string='همه استانها';
	  else $filter_string=' استان : ';
	  foreach($ostanchoice as $key => $val) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$val'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
	 }
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت -';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت -';
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if($noe_namayesh) {$filter_string.=' نوع نمایش براساس : '.$namayeshArr[$noe_namayesh].'&nbsp;';}     
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		 <td>'.$radif++.'</td>
	     <td>'.$row['name_ostan'].'</td>';
		 if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';}
		 else //بقیه کاربران براساس انبار قابل دسترسیشان
		 {
		  $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."";
		  $res2=$db->query($q2);
		  while($row2=$db->fetch_assoc($res2))//انبارهای قابل دسترسی
		  {
		   $Condition_anbar_temp.=" T.code_anbar=".$row2['code_anbar']." OR";

		  }
		   $Condition_anbar.="  $Condition_anbar_temp";

           $lastSpacePosition = strrpos($Condition_anbar," ");

           $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);

		 }
		 $kalaArray = array("11"=>"گوشت داخلی ملکی","12"=>"گوشت وارداتی ملکی","13"=>"گوشت داخلی استیجاری","14"=>"گوشت وارداتی استیجاری","15"=>"گوشت داخلی موجودی تحت کلید","16"=>"گوشت وارداتی موجودی تحت کلید","17"=>"گوشت داخلی بار تحت کلید","18"=>"گوشت وارداتی بار تحت کلید","19"=>"جمع",
		                    "29"=>"گوشت مرغ داخلی ملکی","30"=>"گوشت مرغ وارداتی ملکی","31"=>"گوشت مرغ داخلی استیجاری","32"=>"گوشت مرغ وارداتی استیجاری","33"=>"گوشت مرغ داخلی موجودی تحت کلید","34"=>"گوشت مرغ وارداتی موجودی تحت کلید","35"=>"گوشت مرغ داخلی بار تحت کلید","36"=>"گوشت مرغ وارداتی بار تحت کلید","37"=>"جمع",
		                    "38"=>"موجودی داخلی ملکی","39"=>"موجودی وارداتی ملکی","40"=>"موجودی داخلی استیجاری","41"=>"موجودی وارداتی استیجاری","42"=>"موجودی داخلی تحت کلید","43"=>"موجودی وارداتی تحت کلید","44"=>"بار تحت کلید داخلی","45"=>"بار تحت کلید وارداتی","46"=>"جمع"
							);
         foreach($kalaArray as $x => $x_value)
		 {		  
		   $kalaCondition="";
		   if($x_value!="جمع")
		   {
		    if(($x=="11")or($x=="13")or($x=="15")or($x=="17"))//گوشت داخلی
			{
			 $kalaCondition=" AND (T.code_kala=81 OR T.code_kala=82 OR T.code_kala=83 OR T.code_kala=84 OR T.code_kala=85 OR T.code_kala=86 OR T.code_kala=89 OR T.code_kala=105 OR T.code_kala=106 OR T.code_kala=107 OR T.code_kala=108 OR T.code_kala=109 OR T.code_kala=144 OR T.code_kala=148 OR T.code_kala=149 OR T.code_kala=150 OR T.code_kala=151 OR T.code_kala=88 OR T.code_kala=205 OR T.code_kala=206 OR T.code_kala=207 OR T.code_kala=208 OR T.code_kala=209 OR T.code_kala=210 OR T.code_kala=41 OR T.code_kala=42 OR T.code_kala=43 OR T.code_kala=44 OR T.code_kala=45)";
			 //شروط مالکیت روی کویری تحت کلید اعمال نمیشود
			 IF(($x=="11"))$malekiyatCondition=" noe_malekiyat=1";
			 IF(($x=="13"))$malekiyatCondition=" noe_malekiyat=2";
			}
		    if(($x=="12")or($x=="14")or($x=="16")or($x=="18"))//گوشت وارداتی
			{
			 $kalaCondition=" AND (T.code_kala=72 OR T.code_kala=73 OR T.code_kala=74 OR T.code_kala=75 OR T.code_kala=76 OR T.code_kala=77 OR T.code_kala=78 OR T.code_kala=79 OR T.code_kala=92 OR T.code_kala=87 OR  T.code_kala=113 OR T.code_kala=173 OR T.code_kala=174 OR T.code_kala=60 OR T.code_kala=61 OR T.code_kala=62 OR T.code_kala=63 OR T.code_kala=64)";
			 IF(($x=="12"))$malekiyatCondition=" noe_malekiyat=1";
			 IF(($x=="14"))$malekiyatCondition=" noe_malekiyat=2";
			}	
			// if(($x=="20")or($x=="22")or($x=="24")or($x=="26"))//گوسفند داخلی
			// {
			 // $kalaCondition=" AND (T.code_kala=144 OR T.code_kala=148 OR T.code_kala=149 OR T.code_kala=150 OR T.code_kala=151 OR T.code_kala=88 OR T.code_kala=205 OR T.code_kala=206 OR T.code_kala=207 OR T.code_kala=208 OR T.code_kala=209 OR T.code_kala=210 OR T.code_kala=41 OR T.code_kala=42 OR T.code_kala=43 OR T.code_kala=44 OR T.code_kala=45)";
		     // IF(($x=="20"))$malekiyatCondition=" noe_malekiyat=1";
			 // IF(($x=="22"))$malekiyatCondition=" noe_malekiyat=2";
			// }
			// if(($x=="21")or($x=="23")or($x=="25")or($x=="27"))//گوسفند وارداتی
			// {
			 // $kalaCondition="AND (T.code_kala=87 OR  T.code_kala=113 OR T.code_kala=173 OR T.code_kala=174 OR T.code_kala=60 OR T.code_kala=61 OR T.code_kala=62 OR T.code_kala=63 OR T.code_kala=64)";
			 // IF(($x=="21"))$malekiyatCondition=" noe_malekiyat=1";
			 // IF(($x=="23"))$malekiyatCondition=" noe_malekiyat=2";
			// }
			if(($x=="29")or($x=="31")or($x=="33")or($x=="35"))//مرغ داخلی
			{
			 $kalaCondition=" AND (T.code_kala=38 OR T.code_kala=401 OR T.code_kala=402 OR T.code_kala=403 OR T.code_kala=404 OR T.code_kala=410 OR T.code_kala=411 OR T.code_kala=412 OR T.code_kala=197 OR T.code_kala=198 OR T.code_kala=413 OR T.code_kala=414 OR T.code_kala=415 OR T.code_kala=416)";
			 IF(($x=="29"))$malekiyatCondition=" noe_malekiyat=1";
			 IF(($x=="31"))$malekiyatCondition=" noe_malekiyat=2";
			}
			if(($x=="30")or($x=="32")or($x=="34")or($x=="36"))//مرغ وارداتی
			{
			 $kalaCondition=" AND (T.code_kala=154 OR T.code_kala=91)";
			 IF(($x=="30"))$malekiyatCondition=" noe_malekiyat=1";
			 IF(($x=="32"))$malekiyatCondition=" noe_malekiyat=2";
			}
			if(($x=="38")or($x=="40")or($x=="42")or($x=="44"))//موجودی داخلی 
			{
			 $kalaCondition=" AND (T.code_kala=81 OR T.code_kala=82 OR T.code_kala=83 OR T.code_kala=84 OR T.code_kala=85 OR T.code_kala=86 OR T.code_kala=89 OR T.code_kala=105 OR T.code_kala=106 OR T.code_kala=107 OR T.code_kala=108 OR T.code_kala=109 OR T.code_kala=144 OR T.code_kala=148 OR T.code_kala=149 OR T.code_kala=150 OR T.code_kala=151 OR T.code_kala=88 OR T.code_kala=205 OR T.code_kala=206 OR T.code_kala=207 OR T.code_kala=208 OR T.code_kala=209 OR T.code_kala=210 OR T.code_kala=41 OR T.code_kala=42 OR T.code_kala=43 OR T.code_kala=44 OR T.code_kala=45 OR T.code_kala=38 OR T.code_kala=401 OR T.code_kala=402 OR T.code_kala=403 OR T.code_kala=404 OR T.code_kala=410 OR T.code_kala=411 OR T.code_kala=412 OR T.code_kala=197 OR T.code_kala=198 OR T.code_kala=413 OR T.code_kala=414 OR T.code_kala=415 OR T.code_kala=416)";
			 if($x=="38")$malekiyatCondition=" noe_malekiyat=1";	
			 if($x=="40")$malekiyatCondition=" noe_malekiyat=2";	
			}
			if(($x=="39")or($x=="41")or($x=="43")or($x=="45"))//موجودی وارداتی 
			{
			 $kalaCondition=" AND (T.code_kala=72 OR T.code_kala=73 OR T.code_kala=74 OR T.code_kala=75 OR T.code_kala=76 OR T.code_kala=77 OR T.code_kala=78 OR T.code_kala=79 OR T.code_kala=92 OR T.code_kala=87 OR  T.code_kala=113 OR T.code_kala=173 OR T.code_kala=174 OR T.code_kala=60 OR T.code_kala=61 OR T.code_kala=62 OR T.code_kala=63 OR T.code_kala=64 OR T.code_kala=154 OR T.code_kala=91)";
			 if($x=="39")$malekiyatCondition=" noe_malekiyat=1";	
			 if($x=="41")$malekiyatCondition=" noe_malekiyat=2";	
				
			}
			
		   }
		   
		   IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';$vahed='کیلوگرم';}
	       ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';$vahed='کیلوگرم';}
	       ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';$vahed='تعداد';}				 
	       ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';$vahed='شانه';}				 
	     
		   
		   
			//مجموع موجودی هر کالا در هر استان
			//تحت کلید
			if(($x=="15")or($x=="16")or($x=="17")or($x=="18")or($x=="24")or($x=="25")or($x=="26")or($x=="27")or($x=="33")or($x=="34")or($x=="35")or($x=="36")or($x=="42")or($x=="43")or($x=="44")or($x=="45"))
			{
				  if(($x=="17")or($x=="18")or($x=="26")or($x=="27")or($x=="35")or($x=="36")or($x=="44")or($x=="45"))//رسیدها
				  {
				   $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND noe_tahvil_bar=9 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition  and($Condition_anbar)");  
				   //$mojodyKalaOstan=$jameVarede;			   			   			  		   
				   $bartahtkelid=$jameVarede;			   			   			  		   
				  }
				  else//موجودی
				  {	  
				   $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala_gomrok T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 $kalaCondition  and($Condition_anbar)");        				   
				   $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND noe_tahvil_bar=9 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition  and($Condition_anbar)");
				   $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND noe_tahvil_bar=9 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' $kalaCondition  and($Condition_anbar)"); 
				   $mojodyKalaOstan=$mojodyAval+$jameVarede-$jameSadere;
				  }				   
			}
			else//موجودی عادی
		    {	 
				  $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 $kalaCondition and($malekiyatCondition) and($Condition_anbar)");        				   
				  $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND noe_tahvil_bar!=9 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition and($malekiyatCondition) and($Condition_anbar)");
				  $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND noe_tahvil_bar!=9 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' $kalaCondition and($malekiyatCondition) and($Condition_anbar)");
				  $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition and($malekiyatCondition) and($Condition_anbar)");
			      $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition and($malekiyatCondition) and($Condition_anbar)");
			      $mojodyKalaOstan=$mojodyAval+$jameVarede-$jameSadere+$Tadil_Ezafe-$Tadil_Kasry;			   			   			  		   
			}
	   
			if($x_value!="جمع")
			{
			     if(($x=="17")or($x=="18")or($x=="26")or($x=="27")or($x=="35")or($x=="36")or($x=="44")or($x=="45"))
					 echo '<td>'.round($bartahtkelid,3).'</td>';
                 else
				 {				 
				     echo '<td>'.round($mojodyKalaOstan,3).'</td>';
				     $jame_mojody_ostan+=$mojodyKalaOstan;//بار تحت کلید در ستون جمع حساب نشود
				  }
			     
				 //محاسبه مجموع مقادیر در سطر آخر
				 if($x=="11")$jame_mojody_gushtdakeli_melki+=$mojodyKalaOstan;
			     if($x=="12")$jame_mojody_gushtvaredati_melki+=$mojodyKalaOstan;
				 if($x=="13")$jame_mojody_gushtdakeli_estijari+=$mojodyKalaOstan;
			     if($x=="14")$jame_mojody_gushtvaredati_estijari+=$mojodyKalaOstan;
				 if($x=="15")$jame_mojody_gushtdakeli_tahtkelid+=$mojodyKalaOstan;
			     if($x=="16")$jame_mojody_gushtvaredati_tahtkelid+=$mojodyKalaOstan;
				 if($x=="17")$jame_bar_gushtdakeli_tahtkelid+=$bartahtkelid;
			     if($x=="18")$jame_bar_gushtvaredati_tahtkelid+=$bartahtkelid;
				 if(($x=="11")OR($x=="12")OR($x=="13")OR($x=="14")OR($x=="15")OR($x=="16"))$jame_mojody_gusht+=$mojodyKalaOstan;
			     
				 
				 if($x=="29")$jame_mojody_morghdakeli_melki+=$mojodyKalaOstan;
			     if($x=="30")$jame_mojody_morghvaredati_melki+=$mojodyKalaOstan;
				 if($x=="31")$jame_mojody_morghdakeli_estijari+=$mojodyKalaOstan;
			     if($x=="32")$jame_mojody_morghvaredati_estijari+=$mojodyKalaOstan;
				 if($x=="33")$jame_mojody_morghdakeli_tahtkelid+=$mojodyKalaOstan;
			     if($x=="34")$jame_mojody_morghvaredati_tahtkelid+=$mojodyKalaOstan;
				 if($x=="35")$jame_bar_morghdakeli_tahtkelid+=$bartahtkelid;
			     if($x=="36")$jame_bar_morghvaredati_tahtkelid+=$bartahtkelid;
				 if(($x=="29")OR($x=="30")OR($x=="31")OR($x=="32")OR($x=="33")OR($x=="34"))$jame_mojody_morgh+=$mojodyKalaOstan;
				 
				 if($x=="38")$jame_mojody_dakeli_melki+=$mojodyKalaOstan;
			     if($x=="39")$jame_mojody_varedati_melki+=$mojodyKalaOstan;
				 if($x=="40")$jame_mojody_dakeli_estijari+=$mojodyKalaOstan;
			     if($x=="41")$jame_mojody_varedati_estijari+=$mojodyKalaOstan;
				 if($x=="42")$jame_mojody_dakeli_tahtkelid+=$mojodyKalaOstan;
			     if($x=="43")$jame_mojody_varedati_tahtkelid+=$mojodyKalaOstan;
				 if($x=="44")$jame_bar_dakeli_tahtkelid+=$bartahtkelid;
			     if($x=="45")$jame_bar_varedati_tahtkelid+=$bartahtkelid;
				 if(($x=="38")OR($x=="39")OR($x=="40")OR($x=="41")OR($x=="42")OR($x=="43"))$jame_mojody+=$mojodyKalaOstan;

			}
			if($x_value=="جمع")
			{
				 echo '<td>'.round($jame_mojody_ostan,3).'</td>';
				 $jame_mojody_ostan=0;
            } 
		  }//END foreach		
		 echo'
	  </tr>';
	  /*****تکرار سرصفحه و ستون ها*****/
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
	 }//END WHILE
	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;"" >
	  <td colspan="2">جمع کل</td>
	  <td>'.round($jame_mojody_gushtdakeli_melki,3).'</td>
	  <td>'.round($jame_mojody_gushtvaredati_melki,3).'</td>
	  <td>'.round($jame_mojody_gushtdakeli_estijari,3).'</td>
	  <td>'.round($jame_mojody_gushtvaredati_estijari,3).'</td>
	  <td>'.round($jame_mojody_gushtdakeli_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_gushtvaredati_tahtkelid,3).'</td>
	  <td>'.round($jame_bar_gushtdakeli_tahtkelid,3).'</td>
	  <td>'.round($jame_bar_gushtvaredati_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_gusht,3).'</td>
	  
	  <td>'.round($jame_mojody_morghdakeli_melki,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_melki,3).'</td>
	  <td>'.round($jame_mojody_morghdakeli_estijari,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_estijari,3).'</td>
	  <td>'.round($jame_mojody_morghdakeli_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_tahtkelid,3).'</td>
	  <td>'.round($jame_bar_morghdakeli_tahtkelid,3).'</td>
	  <td>'.round($jame_bar_morghvaredati_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_morgh,3).'</td>
	  
	  <td>'.round($jame_mojody_dakeli_melki,3).'</td>
	  <td>'.round($jame_mojody_varedati_melki,3).'</td>
	  <td>'.round($jame_mojody_dakeli_estijari,3).'</td>
	  <td>'.round($jame_mojody_varedati_estijari,3).'</td>
	  <td>'.round($jame_mojody_dakeli_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_varedati_tahtkelid,3).'</td>
	  <td>'.round($jame_bar_dakeli_tahtkelid,3).'</td>
	  <td>'.round($jame_bar_varedati_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody,3).'</td>

	 </tr>';
	 echo'
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