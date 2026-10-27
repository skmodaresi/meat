<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_keyfiyat_zakhayer.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش پایش کیفیت ذخایر فرآورده ها';
require_once('head.html');
$columns='
	<tr class="print_table-title2" style="height:60px;">
	   <td width="2%">ردیف</td>
	   <td width="5%" class="ostanPr">استان</td>
	   <td width="9%" class="sardkhanePr" >سردخانه</td>
	   <td width="5%" class="date_bazdidPr" >تاریخ هفته منتهی به بازدید</td>
	   <td width="5%" class="name_bazdidkonandePr" >نام بازدیدکننده</td>
	   <td width="5%" class="zir_anbarPr" >زیر انبار</td>
	   <td width="5%" class="borodat_salonPr" >برودت سالن</td>
	   <td width="5%" class="borodat_mahmulePr" >برودت عمق محموله</td>
	   <td width="5%" class="favaselPr" >رعایت فواصل از دیوار و سقف</td>
	   <td width="5%" class="rahroPr">ایجاد راهروی دسترسی</td>
	   <td width="5%" class="sehat_amalkardPr" >صحت عملکرد سیستم سرمایشی</td>
	   <td width="5%" class="fifoPr" >رعایت تقدم و تأخر (FIFO)</td>
	   <td width="5%" class="difrastPr" >عملکرد لوله دیفراست</td>
	   <td width="5%" class="kalaPr" >نام کالا</td>	
	   <td width="9%" class="tarikh_tolidPr" >تاریخ تولید</td>
       <td width="7%" nowrap>
	    گزارش بارگیری از مبدأ
	    <br>
	    و کلیه مستندات مربوطه
	   </td>
	   <td  width="7%" nowrap>
	    مطابقت مشخصات موجودی
        <br>	 
	    با اطلاعات مندرج در سیستم
	   </td>
       <td  width="7%" nowrap>
	    نوع چیدمان
        <br>	  
	     در سالن
	   </td>
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
	<!--<tr class="tr1" >
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
	   foreach (array_slice($mahshamsiArr,'1','12',true) as $mah_key => $mah_value)
        echo "<option value=".$mah_key.">".$mah_value."</option>";
	   echo'
	  </select>
	  &nbsp; روز تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
	</tr>-->
	<tr class="tr1">
	 <td align="left" ><input type="checkbox" name="chkactivate" checked/></td><td align="right" colspan="3">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
    </tr>
	<!--<tr class="tr1">	
	 <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>-->
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
    if ($date1) $Condition_havale.=" AND T.tarikh_bazdid>='$date1'";//از تاریخ
    if ($date2) $Condition_havale.=" AND T.tarikh_bazdid<='$date2'";//تا تاریخ 
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
    // if(is_array($kalachoice))
    // {
	  // $Condition_kala="";//شرط را خالی میکنم
	  // foreach($kalachoice as $kala_key => $kala_val) {$Condition_kala_temp.=" k_d.code_kala='$kala_val' OR";}
      // if($kala_val==-1) $Condition_kala.="1=1 OR";
      // else $Condition_kala.=" $Condition_kala_temp";
      // $lastSpacePosition = strrpos($Condition_kala," ");
      // $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
    // }
    //if ($sal_tolid_shamsi) $Condition_h_d.=" AND k_d.sal_tolid_shamsi='$sal_tolid_shamsi'";//سال تولید 
    /******آرایه ی انتخاب ماه ها******/
	//if ($rouz_tolid_shamsi) $Condition_h_d.=" AND k_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";//روز تولید 
	//if ($code_tolidkonande) $Condition_h_d.=" and k_d.code_tolidkonande='$code_tolidkonande'";//کد تولیدکننده 
	 
	/******************نمایش یا عدم نمایش سردخانه های غیرفعال******************/
    if($chkactivate=='on') {$Condition_anbar_activate="1=1";}
    else {$Condition_anbar_activate="list_sardkhane.activate=1";}
	/****************شروع نمایش گزارش*******************/		
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	// $q="SELECT T.*,k_d.*,kala.name_kala,name_ostan,name_anbar,name_ziranbar,k_d.sal_tolid_shamsi,k_d.mah_tolid_shamsi,k_d.rouz_tolid_shamsi,k_d.code_karton,k_d.vazn_karton_this 
		// FROM $mydatabase.keyfiyat_zakhayer T
	    // INNER JOIN $mydatabase.keyfiyat_zakhayer_detail k_d ON k_d.id_keyfiyat=T.id_keyfiyat   
        // INNER JOIN $mydatabase.ostan ON ostan.code_ostan=T.code_ostan
	    // INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
		// INNER JOIN list_sardkhane_detail l_s_d ON T.code_ziranbar=l_s_d.code_ziranbar AND T.code_ostan=l_s_d.code_ostan AND T.code_anbar=l_s_d.code_anbar 
		// INNER JOIN $mydatabase.kala ON k_d.code_kala=kala.code_kala    		
		// WHERE 1=1 $Condition_havale $Condition_h_d AND($Condition_anbar_activate) AND($Condition_ostan) AND($Condition_anbar) AND ($Condition_kala) AND($Condition_mah)  AND T.year='$mtActiveYear' AND T.deleted=0 ORDER BY name_ostan,name_anbar,T.tarikh_bazdid";		
	
	$q="SELECT T.*,name_ostan,name_anbar,name_ziranbar
		FROM $mydatabase.keyfiyat_zakhayer T
        INNER JOIN $mydatabase.ostan ON ostan.code_ostan=T.code_ostan
	    INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
		INNER JOIN list_sardkhane_detail l_s_d ON T.code_ziranbar=l_s_d.code_ziranbar AND T.code_ostan=l_s_d.code_ostan AND T.code_anbar=l_s_d.code_anbar 
		WHERE 1=1 $Condition_havale $Condition_h_d AND($Condition_anbar_activate) AND($Condition_ostan) AND($Condition_anbar) AND ($Condition_kala) AND($Condition_mah)  AND T.year='$mtActiveYear' AND T.deleted=0 ORDER BY name_ostan,name_anbar,T.tarikh_bazdid";		
	
	//if(SuperUser()) echo $q;
	$res=$db->query($q);
	$cntr=$db->num_rows($res);
	if($db->num_rows($res)>0)
	{
	 echo'
     <br>
       <!--<table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title2 "><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
		<tr class="print_table-title2 select_all">
		 <td width="4%" >استان</td>
		 <td width="5%" >سردخانه</td>
		 <td width="5%" >شماره حواله</td>
		 <td width="5%" >تاریخ حواله</td>
		 <td width="5%" >نام کالا</td>
		 <td width="8%" >شماره حواله فروش</td>
		 <td width="8%" >تاریخ حواله فروش</td>
		 <td width="5%" >شماره مجوز</td>
		 <td width="5%" >نرخ فروش</td>
	     <td width="5%" >نام مشتری</td>
	     <td width="12%" >اختلاف تاریخ خواله فروش و حواله</td> 
	     <td width="5%" >تولیدکننده</td> 
	     <td width="5%" >تاریخ تولید</td> 
	     <td width="5%" >مانده انقضا</td> 
	     <td width="4%" >وضعیت</td>
	     <td width="4%" >تعداد</td>
	     <td width="5%" >وزن ناخالص</td>
	     <td width="5%" >وزن خالص</td>
	    </tr>   	
		<tr class="print_table-title2">
	     <td><input name="ostanPr" type="checkbox" checked ></td>
	     <td><input name="sardkhanePr"  type="checkbox" checked ></td>
	     <td><input name="date_bazdidPr" type="checkbox" checked ></td>
	     <td><input name="name_bazdidkonandePr"  type="checkbox" checked ></td>
	     <td><input name="zir_anbarPr"  type="checkbox" checked></td>
	     <td><input name="borodat_salonPr"  type="checkbox" checked ></td>
	     <td><input name="borodat_mahmulePr"  type="checkbox" checked ></td>
	     <td><input name="favaselPr"  type="checkbox" checked ></td>
	     <td><input name="rahroPr"  type="checkbox" checked ></td>
	     <td><input name="sehat_amalkardPr"  type="checkbox" checked ></td>
	     <td><input name="fifoPr"  type="checkbox" checked ></td>
	     <td><input name="difrastPr"  type="checkbox" checked ></td>
	     <td><input name="kalaPr"  type="checkbox" checked ></td>
		 <td><input name="tarikh_tolidPr"  type="checkbox" checked ></td>
	    </tr>	
     </table>-->
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
	  echo $mah_val1;
	  if(($mah_val=='')or($mah_val=='-1')){$filter_string4=''.$mah_val.'';}
	  else 
	  {$filter_string4=' ماه تولید : ';
	   foreach($mahchoice as $mah_key => $mah_val) $filter_string4.=''.$mahshamsiArr[$mah_val].'&nbsp;';
      }
	 }
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}        
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","$mydatabase.tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     

	 if(($code_ostan)or($sardkhanechoice)or($kalachoice)or($sal_tolid_shamsi)or($mahchoice)or($rouz_tolid_shamsi)or($status!='-1'))
	 {echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.$filter_string2.$filter_string4.'</td></tr>';}
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	    $line++;	
	    //تعداد جزِییات
	    $tedad_detail=$db->get_from_where("COUNT(*)","keyfiyat_zakhayer_detail","id_keyfiyat=".$row['id_keyfiyat']." AND deleted=0");//    
	    if($tedad_detail>0)$row_detail=$tedad_detail;
	    else $row_detail=1;//detail empty
	    $t=$row_detail;
		if($i++%2)echo'<tr class="print_table-odd_small">';
        else echo'<tr class="print_table-even_small">';  
	   echo'
	    <td rowspan="'.$row_detail.'" >'.$radif++.'</td>
	    <td rowspan="'.$row_detail.'" class="ostanPr">'.$row['name_ostan'].'</td>
	    <td rowspan="'.$row_detail.'" class="sardkhanePr">'.$row['name_anbar'].'</td>
	    <td rowspan="'.$row_detail.'" class="date_bazdidPr">'.$row['tarikh_bazdid'].'</td>
	    <td rowspan="'.$row_detail.'" class="name_bazdidkonandePr">'.$row['name_bazdidkonande'].'</td>
	    <td rowspan="'.$row_detail.'" class="zir_anbarPr">'.$row['name_ziranbar'].'</td>
	    <td rowspan="'.$row_detail.'" class="borodat_salonPr">'.$row['borodat_salon'].'</td>
	    <td rowspan="'.$row_detail.'" class="borodat_mahmulePr">'.$row['borodat_mahmule'].'</td>
		<td rowspan="'.$row_detail.'" class="favaselPr">';IF($row['favasel'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	    <td rowspan="'.$row_detail.'" class="rahroPr">';IF($row['rahro'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	  	<td rowspan="'.$row_detail.'" class="sehat_amalkardPr">';IF($row['sehat_amalkard'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	    <td rowspan="'.$row_detail.'" class="fifoPr">';IF($row['fifo'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	    <td rowspan="'.$row_detail.'" class="difrastPr">';IF($row['difrast'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>';
	    //حلقه روی جزِییات
		 $q2="SELECT *,name_kala FROM keyfiyat_zakhayer_detail INNER JOIN kala USING(code_kala) WHERE id_keyfiyat=".$row['id_keyfiyat']." AND deleted=0";
		 $res2=$db->query($q2);
		 if($db->num_rows($res2)>0)
		 {
		  while($row2=$db->fetch_assoc($res2))
		  {	   
		   $j=$i+1;
		   echo'
		   <td class="kalaPr">'.$row2['name_kala'].'</td>
	       <td class="tarikh_tolidPr">'.$row2['rouz_tolid_shamsi'].''.$mahshamsiArr[$row2['mah_tolid_shamsi']].''.$row2['sal_tolid_shamsi'].'</td>
	       <td class="difrastPr">';IF($row2['chkmostanadat'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	       <td class="difrastPr">';IF($row2['chkmotabeghat'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
           <td class="kalaPr">'.$noechidemanArr[$row2['noe_chideman']].'</td>';
		   $t--;
		   if($t==0) echo'';
		   else 
		   {
			   echo'</tr>';
			   if($j++%2)echo'<tr class="print_table-odd">';
               else echo'<tr class="print_table-even">';
		   }
          }//END while
		 }//END IF
		 ELSE echo'<td colspan="5">اطلاعات جزِییات محموله تعیین نشده است</td>';

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
	 }//END while
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
         var count_for_sum=16;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var count_for_sum=count_for_sum-numberNotChecked;
		 $("#sum_row").attr("colspan",count_for_sum);
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