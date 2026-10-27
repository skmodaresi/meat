<?php
require_once __DIR__ . '/mysql_compat.php';
//قسمت مربوط به فروش در حالت اتصال به فروش
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_tamin.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش تأمین براساس خروجی مجوز فروش';
require_once('head.html');
//پیدا کردن آی دی سال مربوط به سیستم فروش
      $sellYearCode=substr($mtActiveYear,2);
      $res_sal=mysql_query("SELECT year_id FROM sell.dm_year WHERE year_code='$sellYearCode'");
      $sellYearId=mysql_result($res_sal, 0, 'year_id');

$columns='
	<tr class="print_table-title2" style="height:60px;">
	   <td width="2%">ردیف</td>
	   <td class="ostanPr" width="4%">استان</td>
	   <td class="sardkhanePr" width="9%">سردخانه</td>
	   <td class="sh_havalePr" width="4%">شماره حواله</td>
	   <td class="date_havalePr" width="4%">تاریخ حواله</td>
	   <td class="kalaPr" width="10%">نام کالا</td>	
	   <td class="sh_forushPr" width="5%">شماره حواله فروش</td>
	   <td class="date_forushPr" width="5%">تاریخ حواله فروش</td>
	   <td class="sh_mojavezPr" width="5%">شماره مجوز</td>
	   <td class="nerkhPr" width="4%">نرخ فروش</td> 
	   <td class="mandePr" width="4%">مانده حواله فروش</td> 
	   <td class="moshtaryPr" width="9%">نام مشتری</td>
	   <td class="tolidkonandePr" width="5%">تولید کننده</td>
	   <td class="statusPr" width="3%">وضعیت</td>
	   <td class="tedadPr" width="5%">تعداد</td> 
	   <td class="nakhalesPr" width="6%">وزن ناخالص</td>
	   <td class="khalesPr" width="6%">وزن خالص</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo' 
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
     <td align="left" width="140px"> از تاریخ :&nbsp;</td><td align="right" width="180px"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
     <td align="left" width="140px"> تا تاریخ :&nbsp;</td><td align="right" ><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>';
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{echo'
       <tr class="tr1"><td align="left" > استان :&nbsp;</td><td align="right">'.listbox_ostan("code_ostan","$code_ostan","code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4' onChange='myform.submit()' ").'</td>';	  	  	    
	   if(($code_ostan)) echo'<td align="left"> سردخانه :&nbsp;</td><td align="right">'.listbox_anbar("code_anbar",$code_anbar,"code_anbar","name_anbar","list_sardkhane","1=1 and code_ostan=$code_ostan ORDER BY list_sardkhane.name_anbar ASC","class='text4'").'</td>';
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
	  $result_sardkhane = $db->query("SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']." ORDER BY list_sardkhane.name_anbar ASC");
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
	  $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']."</option>";
	  echo $kala_options;
	  echo'
	  </select>
	 </td>
	</tr>
	<tr class="tr1">	   
     <td align="left"> سال تولید :&nbsp;</td>
	 <td align="right" colspan="3">
	  <input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  &nbsp; ماه تولید :
	  <select name="mahchoice[]" class="easyui-combobox" multiple="true" style="width:30%">
	   <option value="-1" selected>همه ماه ها</option>';
       //array_shift($mahshamsiArr);
	   foreach (array_slice($mahshamsiArr,'1','12',true) as $mah_key => $mah_value)
        echo "<option value=".$mah_key.">".$mah_value."</option>";
	   echo'
	  </select>
	  &nbsp; روز تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
	</tr>
    <tr class="tr1">
     <td align="left" height="40px"> وضعیت حواله :&nbsp;</td>
	 <td align="right">'.static_listbox("status","-1","statusFormArr",1,"class='easyui-combobox text4' data-options=panelHeight:100").'</td>						 
	 <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>&nbsp;';
     include('img_helptolid.php');
     echo'
     </td>
    </tr>
	<tr class="tr1">
	 <td align="left" height="40px"> کد مشتری :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" name="code_customer" value="'.$code_customer.'" onkeypress="return isNumber(event)" onblur="enterCodeMoshtary(this.value)" style="width:50px;"/>
	  <img border="0" src="images/help.png" onClick="window.open(\'help_moshtary.php\',\'_blank\',\'width=500px,left=20px,scrollbars=yes\')" title="جدول کد مشتری" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
	 </td>
	 <td align="left" ><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
    </tr>
	<tr class="tr1">	
	 <td align="left"> شماره مجوز :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="ph_mojavez" value="'.$ph_mojavez.'" /></td>
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
    $Condition_havale="";
	$Condition_anbar="1=1"; 
	$Condition_kala="1=1";
	$Condition_mah="1=1";
    /****************فیلترها روی گزارش******************/
    if ($date1) $Condition_havale.=" AND T.tarikh_havale_anbar>='$date1'";//از تاریخ
    if ($date2) $Condition_havale.=" AND T.tarikh_havale_anbar<='$date2'";//تا تاریخ 
	/*******استان ها*******/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
    {  
	  if($code_ostan==-1){$Condition_ostan.="1=1";}
	  else{$Condition_ostan=' T.code_ostan='.$code_ostan.'';}
	}
	else 
    {
	  $Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';
    }
	/******سردخانه ها******/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
    {
     if(($code_ostan==-1)or($code_anbar==-1)){$Condition_anbar='1=1';}
     else{$Condition_anbar=' T.code_anbar='.$code_anbar.'';}
    }
    else //بقیه کاربران براساس انبار قابل دسترسیشان وانتخاب یکی یا چند تا
    {  
      if(is_array($sardkhanechoice))
     {
       $Condition_anbar="";//شرط را خالی میکنم
	   foreach($sardkhanechoice as $anbar_key => $anbar_val) {$Condition_anbar_temp.=" T.code_anbar='$anbar_val' OR";}
       if($anbar_val==-1) $Condition_anbar.="1=1 OR";
       else $Condition_anbar.=" $Condition_anbar_temp";
       $lastSpacePosition = strrpos($Condition_anbar," ");
       $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     }    
	}
	/******کد های کالا******/
    if(is_array($kalachoice))
    {
	  $Condition_kala="";//شرط را خالی میکنم
	  foreach($kalachoice as $kala_key => $kala_val) {$Condition_kala_temp.=" T.code_kala='$kala_val' OR";}
      if($kala_val==-1) $Condition_kala.="1=1 OR";
      else $Condition_kala.=" $Condition_kala_temp";
      $lastSpacePosition = strrpos($Condition_kala," ");
      $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
    }
    if ($code_customer) $Condition_havale.=" AND h_customer_code='$code_customer'";//کد مشتری 
    if ($ph_mojavez) $Condition_havale.=" AND ph_mojavez like '%$ph_mojavez%'";//کد مشتری 
	//if ($code_kala) $Condition_havale.=" AND T.code_kala='$code_kala'";//کد کالا 
    if ($sal_tolid_shamsi) $Condition_h_d.=" AND h_d.sal_tolid_shamsi='$sal_tolid_shamsi'";//سال تولید 
    /******آرایه ی انتخاب ماه ها******/
	//if ($mah_tolid_shamsi) $Condition_h_d.=" AND h_d.mah_tolid_shamsi='$mah_tolid_shamsi'";//ماه تولید 
    // if(is_array($mahchoice))
    // {
	  // $Condition_mah="";//شرط را خالی میکنم
	  // foreach($mahchoice as $mah_key => $mah_value) {$Condition_mah_temp.=" h_d.mah_tolid_shamsi='$mah_value' OR";}
      // if(($mah_value=='-1')) $Condition_mah.="1=1 OR";
      // else $Condition_mah.=" $Condition_mah_temp";
	  // $lastSpacePosition = strrpos($Condition_mah," ");
      // $Condition_mah =substr($Condition_mah,0,$lastSpacePosition);
    // }
	//echo $Condition_mah.'<br/>';
	if ($rouz_tolid_shamsi) $Condition_h_d.=" AND h_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";//روز تولید 
	if ($code_tolidkonande) $Condition_h_d.=" and h_d.code_tolidkonande='$code_tolidkonande'";//کد تولیدکننده 
	//if ($noe_tahvil_bar) $Condition_havale.=" AND noe_tahvil_bar='$noe_tahvil_bar'";//نوع تحویل بار
    if (isset($status)and($status=='0')) $Condition_havale.=" AND T.status=0";//وضعیت حواله 	 
    if (isset($status)and($status=='1')) $Condition_havale.=" AND T.status=1";//وضعیت حواله 	 
    if (isset($status)and($status=='-1')) $Condition_havale.="";//وضعیت حواله
	/******************نمایش یا عدم نمایش سردخانه های غیرفعال******************/
    if($chkactivate=='on') {$Condition_anbar_activate="1=1";}
    else {$Condition_anbar_activate="list_sardkhane.activate=1";}
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
	$q_ostan="SELECT  distinct(ostan.code_ostan),ostan.name_ostan 
		FROM $mydatabase.havale T
	    INNER JOIN $mydatabase.havale_detail h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year    
		INNER JOIN $mydatabase.ostan ON ostan.code_ostan=T.code_ostan
		INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
		INNER JOIN sell.dm_havale ON dm_havale.h_id=T.h_id
		INNER JOIN sell.dm_pish_havale_det ON h_phd_id=phd_id
	    INNER JOIN sell.dm_pish_havale ON ph_code=phd_ph_code AND ph_id_province=phd_id_province
		WHERE 1=1 $Condition_havale $Condition_h_d AND($Condition_anbar_activate) AND($Condition_ostan) AND($Condition_anbar) AND ($Condition_kala) AND($Condition_mah) AND T.h_code!=0 AND T.year='$mtActiveYear' AND T.deleted=0 ORDER BY name_ostan,name_anbar,T.tarikh_havale_anbar";		
	//echo $q;
	$res_ostan=$db->query($q_ostan);
	$cntr=mysql_num_rows($res_ostan);
	if(mysql_num_rows($res_ostan)>0)
	{
	 echo'
     <br>
       <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title2 "><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
		<tr class="print_table-title2 select_all">
		 <td width="5%" >سردخانه</td>
		 <td width="5%" >شماره حواله</td>
		 <td width="5%" >تاریخ حواله</td>
		 <td width="5%" >نام کالا</td>
		 <td width="8%" >شماره حواله فروش</td>
		 <td width="8%" >تاریخ حواله فروش</td>
		 <td width="5%" >شماره مجوز</td>
		 <td width="5%" >نرخ فروش</td>
		 <td width="5%" >مانده حواله فروش</td>
	     <td width="5%" >نام مشتری</td>
	     <td width="5%" >تولیدکننده</td> 
	     <td width="4%" >وضعیت</td>
	     <td width="4%" >تعداد</td>
	     <td width="5%" >وزن ناخالص</td>
	     <td width="5%" >وزن خالص</td>
	    </tr>   	
		<tr class="print_table-title2">
	     <td><input name="sardkhanePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="sh_havalePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="date_havalePr" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="kalaPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="sh_forushPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="date_forushPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="sh_mojavezPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="nerkhPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="mandePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="moshtaryPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="tolidkonandePr" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="statusPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="tedadPr" type="checkbox"  checked></td>
	     <td><input name="nakhalesPr" type="checkbox" checked ></td>
	     <td><input name="khalesPr" type="checkbox" checked ></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if($code_ostan) {if($code_ostan=='-1'){$nameOstan='همه استانها';}else{$nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$code_ostan'");}$filter_string.=' استان : '.$nameOstan.'&nbsp;';}     
	 if($code_anbar) {if($code_anbar=='-1'){$nameAnbar='همه سردخانه ها';}else{$nameAnbar=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$code_ostan' AND code_anbar='$code_anbar'");}$filter_string.=' سردخانه : '.$nameAnbar.'&nbsp;';}     
	 if(is_array($sardkhanechoice))//بقیه کاربران
	 {
	  if($anbar_val==-1)$filter_string2=' سردخانه : همه سردخانه ها ';
	  else $filter_string2=' سردخانه : ';
	  foreach($sardkhanechoice as $anbar_key => $anbar_val) {
	  $nameAnbar=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$anbar_val'");
	  $filter_string2.=''.$nameAnbar.'&nbsp;';
      }
	 }
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if(is_array($kalachoice))
	 {
	  if($kala_val==-1)$filter_string.=' کالا : همه کالاها';
	  else $filter_string.=' کالا : ';
	  foreach($kalachoice as $kala_key => $kala_val) {
	  $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
	  $filter_string.=''.$nameKala.'&nbsp;';
      }
	 }
	 if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if(is_array($mahchoice))
	 {
	  //if($mah_val=='-1')$filter_string4=' ماه تولید : همه ماهها';
	  //if(($mah_val=='')or($mah_val=='-1')){$filter_string4=' ماه تولید : همه ماهها';}
	  echo $mah_val1;
	  if(($mah_val=='')or($mah_val=='-1')){$filter_string4=''.$mah_val.'';}
	  else 
	  {$filter_string4=' ماه تولید : ';
	   foreach($mahchoice as $mah_key => $mah_val) $filter_string4.=''.$mahshamsiArr[$mah_val].'&nbsp;';
      }
	 }
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}        
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","$mydatabase.tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_customer)$filter_string.=' کد مشتری : '.$code_customer.'&nbsp;';    
	 if($ph_mojavez)$filter_string.=' شماره مجوز : '.$ph_mojavez.'&nbsp;';    
	 if($status!='-1')
	 { 
	  if($status=='0') $filter_string.=' وضعیت حواله : '.$statusFormArr[$status].'&nbsp;';    
	  if($status=='1') $filter_string.=' وضعیت حواله : '.$statusFormArr[$status].'&nbsp;';    
     }
	 if(($code_ostan)or($sardkhanechoice)or($kalachoice)or($sal_tolid_shamsi)or($mahchoice)or($rouz_tolid_shamsi)or($status!='-1'))
	 {echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.$filter_string2.$filter_string4.'</td></tr>';}
	 echo $columns;

	 while($row_ostan=$db->fetch_assoc($res_ostan))
	 {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  $tedad=$db->get_from_where("COUNT(*)",
              "$mydatabase.havale T
             INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala    		
	         INNER JOIN $mydatabase.havale_detail h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year    
	     	INNER JOIN $mydatabase.ostan ON ostan.code_ostan=T.code_ostan
	     	INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
	     	INNER JOIN $mydatabase.tolidkonande ON tolidkonande.code_tolidkonande=h_d.code_tolidkonande
	     	INNER JOIN sell.dm_havale ON dm_havale.h_id=T.h_id
			INNER JOIN sell.dm_pish_havale_det ON h_phd_id=phd_id
	     	INNER JOIN sell.dm_pish_havale ON ph_code=phd_ph_code AND ph_id_province=phd_id_province",
			"T.code_ostan=".$row_ostan['code_ostan']."   $Condition_havale $Condition_h_d AND($Condition_anbar_activate)  AND($Condition_anbar) AND ($Condition_kala) AND($Condition_mah) AND T.h_code!=0 AND T.year='$mtActiveYear' AND T.deleted=0 ORDER BY name_ostan,name_anbar,T.tarikh_havale_anbar");		
	  $rowanbar=$tedad;
	  $t=$rowanbar;
	  echo'   
		 <td rowspan="'.$rowanbar.'">'.$radif++.'</td>
	     <td rowspan="'.$rowanbar.'" >'.$row_ostan['name_ostan'].'</td>';
		 //حواله هایی که حواله فروش دارند و جزئیات برایشان ثبت شده
	     $q="SELECT T.*,kala.name_kala,ostan.name_ostan,list_sardkhane.name_anbar,name_tolidkonande,h_d.sal_tolid_shamsi,h_d.mah_tolid_shamsi,h_d.rouz_tolid_shamsi,h_d.code_karton,h_d.vazn_karton_this,h_d.tedad_karton_h_d,h_d.vazn_nakhales_h_d,h_d.sum_karton_h_d,h_d.vazn_khales_h_d,ph_mojavez,h_mande_havale, 
	        (SELECT SUM(tedad_karton_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year $Condition_h_d)tedadKarton,
	        (SELECT SUM(sum_karton_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year $Condition_h_d)vaznKartonha,
	        (SELECT SUM(vazn_nakhales_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year $Condition_h_d)vaznNaKhales,
	        (SELECT SUM(vazn_khales_h_d) FROM havale_detail h_d WHERE h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year $Condition_h_d)vaznKhales
	     	FROM $mydatabase.havale T
            INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala    		
	        INNER JOIN $mydatabase.havale_detail h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year    
	     	INNER JOIN $mydatabase.ostan ON ostan.code_ostan=T.code_ostan
	     	INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
	     	INNER JOIN $mydatabase.tolidkonande ON tolidkonande.code_tolidkonande=h_d.code_tolidkonande
	     	INNER JOIN sell.dm_havale ON dm_havale.h_id=T.h_id
	        INNER JOIN sell.dm_pish_havale_det ON h_phd_id=phd_id
	     	INNER JOIN sell.dm_pish_havale ON ph_code=phd_ph_code AND ph_id_province=phd_id_province   
	     	WHERE T.code_ostan=".$row_ostan['code_ostan']."   $Condition_havale $Condition_h_d AND($Condition_anbar_activate)  AND($Condition_anbar) AND ($Condition_kala) AND($Condition_mah) AND T.h_code!=0 AND T.year='$mtActiveYear' AND T.deleted=0 ORDER BY name_ostan,name_anbar,T.tarikh_havale_anbar";		

		 $res=$db->query($q);
		 $sum_tedad_karton_ostan=0;
	     $sum_vazn_nakhales_ostan=0;
	     $sum_vazn_khales_ostan=0;
		 while($row=$db->fetch_assoc($res))
		 {	   
		   $j=$i+1;
	       if($row['status']==0)//اگر حواله جاری است 
	       {
	        $sum_karton_h_jary+=$row['tedad_karton_h_d'];
	        $sum_vazn_nakhales_h_jary+=$row['vazn_nakhales_h_d'];
	        $sum_vazn_khales_h_jary+=$row['vazn_khales_h_d'];
	       }
	       if($row['status']==1)//اگر حواله ابطالی است 
	       {
	       	$sum_karton_h_ebtaly+=$row['tedad_karton_h_d'];
	        	$sum_vazn_nakhales_h_ebtaly+=$row['vazn_nakhales_h_d'];
	         $sum_vazn_khales_h_ebtaly+=$row['vazn_khales_h_d'];
	       }

	       $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='".$row['code_ostan']."'");//تبدیل کد به آی دی
		   //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
           $res_anbar=mysql_query("SELECT l_id FROM sell.dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code=".$row['code_anbar']."");
           $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
		   //بدست آوردن کد مشتری
           $q_havale_forush="SELECT h_customer_code,h_reg_date,h_p_price FROM sell.dm_havale WHERE h_code='".$row['h_code']."' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";
		   $res_havale_forush=mysql_query($q_havale_forush);
           $row_havale_forush=mysql_fetch_array($res_havale_forush);
		   //نام مشتری
	       $q_moshtary="SELECT name_customer FROM sell.dm_customer_asli WHERE code_customer=".$row_havale_forush['h_customer_code']."";
           $res_moshtary=mysql_query($q_moshtary);
           $row_moshtary=mysql_fetch_array($res_moshtary);
           $nameMoshtary=$row_moshtary['name_customer'];
      	   //تبدیل تاریخ میلادی به شمسی
	       $sql_tarikh=$row_havale_forush['h_reg_date'];
           $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
           $shamsi=gregorian_to_jalali($y,$m,$d);
           $sal=$shamsi[0];$mah=$shamsi[1];$rouz=$shamsi[2];
           $tarikh_forush=$sal.'/'.$mah.'/'.$rouz;
		   //$ph_mojavez=$db->get_from_where("ph_mojavez","sell.dm_havale INNER JOIN sell.dm_pish_havale_det ON h_phd_id=phd_id INNER JOIN sell.dm_pish_havale ON ph_code=phd_ph_code AND ph_id_province=phd_id_province","h_code='".$row['h_code']."' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'");     
		 

	       //اضافه کردن صفر پشت کد استان
	       if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
           else $code_a=$row['code_ostan'];	

	       echo'
	        <td class="sardkhanePr">'.$row['name_anbar'].'</td>
		    <td class="sh_havalePr">'.$code_a.$row['code_anbar'].$row['shomare_havale_anbar'].'</td>
	        <td class="date_havalePr">'.$row['tarikh_havale_anbar'].'</td>
	        <td class="kalaPr">'.$row['name_kala'].'</td>
	        <td class="sh_forushPr">'.$row['h_code'].'</td>
	        <td class="date_forushPr">'.$tarikh_forush.'</td>
	        <td class="sh_mojavezPr">'.$row['ph_mojavez'].'</td>
		    <td class="nerkhPr">'.virgul($row_havale_forush['h_p_price']).'</td>
		    <td class="mandePr">'.round($row['h_mande_havale'],3).'</td>
		    <td class="moshtaryPr">'.$nameMoshtary.'</td>
		    <td class="tolidkonandePr">'.$row['name_tolidkonande'].'</td>
		    <td class="statusPr">'.$statusFormArr[$row['status']].'</td>
		    <td class="tedadPr">'.virgul($row['tedad_karton_h_d']).'</td>
	        <td class="nakhalesPr">'.round($row['vazn_nakhales_h_d'],3).'</td>
	        <td class="khalesPr">'.round($row['vazn_khales_h_d'],3).'</td>'; 
	  		$t--;
			if($t==0) echo'';
			else 
			{
			   echo'</tr>';
			   if($j++%2)echo'<tr class="print_table-odd">';
               else echo'<tr class="print_table-even">';
			}
			//جمع استانی
			$sum_tedad_karton_ostan+=$row['tedad_karton_h_d'];
	        $sum_vazn_nakhales_ostan+=$row['vazn_nakhales_h_d'];
	        $sum_vazn_khales_ostan+=$row['vazn_khales_h_d'];
		    //جمع کلی
			$sum_tedad_karton+=$row['tedad_karton_h_d'];
	        $sum_vazn_nakhales+=$row['vazn_nakhales_h_d'];
	        $sum_vazn_khales+=$row['vazn_khales_h_d'];
	  
		   }//END havale while
	  echo'
	  </tr>';
	  echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td class="sum_row" colspan="14">جمع مقادیر استان '.$row_ostan['name_ostan'].'</td>
	   <td class="tedadPr">'.virgul($sum_tedad_karton_ostan).'</td>
	   <td class="nakhalesPr">'.round($sum_vazn_nakhales_ostan,3).'</td>
	   <td class="khalesPr">'.round($sum_vazn_khales_ostan,3).'</td>
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
	 }//END ostan while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td class="sum_row" colspan="14">جمع مقادیر</td>
	   <td class="tedadPr">'.virgul($sum_tedad_karton).'</td>
	   <td class="nakhalesPr">'.round($sum_vazn_nakhales,3).'</td>
	   <td class="khalesPr">'.round($sum_vazn_khales,3).'</td>
	  </tr>';	  
	 //مجموع وزن خالص و ناخالص و کارتن های جاری
	 echo'<tr class="print_table-even sum-row-white"><td colspan="19" align="right">&nbsp;&nbsp;&nbsp; مجموع تعداد کارتن حواله های جاری : '.virgul($sum_karton_h_jary).' - مجموع وزن ناخالص حواله های جاری : '.round($sum_vazn_nakhales_h_jary,3).' - مجموع وزن خالص حواله های جاری : '.round($sum_vazn_khales_h_jary,3).'</td></tr>'; 
	 //مجموع وزن خالص و ناخالص و کارتن های ابطالی
	 echo'<tr class="print_table-even sum-row-white"><td colspan="19" align="right">&nbsp;&nbsp;&nbsp; مجموع تعداد کارتن حواله های ابطالی : '.virgul($sum_karton_h_ebtaly).' - مجموع وزن ناخالص حواله های ابطالی : '.round($sum_vazn_nakhales_h_ebtaly,3).' - مجموع وزن خالص حواله های ابطالی : '.round($sum_vazn_khales_h_ebtaly,3).'</td></tr>'; 

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
		 var count_for_sum=count_for_sum-numberNotChecked;
		 $(".sum_row").attr("colspan",count_for_sum);
        }); 
   $("[name=code_ostan]").change(function() {
	  myform.submit();
    });  
});
<!-- تعویض انبار با انتخاب استان-->
function getAnbareOstan(code_ostan)
{
   $("#loading").fadeIn("fast");  
   $.post("ajax_re_resid.php",{codeOSTAN1:code_ostan},function(data){$("[name=code_anbar]").html(data);});
   $("#loading").fadeOut("fast");		
}
</script> 