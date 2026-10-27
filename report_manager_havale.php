<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_havale.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش وضعیت ارسال حواله ها به سامانه جامع انبارها';
require_once('head.html');
$columns='
 <tr class="print_table-title2" style="height:70px;">
     <td width="2%">ردیف</td>
     <td width="5%">استان</td>
     <td width="5%">سردخانه</td>
     <td width="5%"  class="activateanbarPr">وضعیت سردخانه</td>
     <td width="5%"  class="postalPr">کدپستی</td>
     <td width="10%" class="warehousePr">آیدی واحد(صمت)</td>
	 <td width="5%">شماره حواله</td>
	 <td width="5%">تاریخ حواله</td>
	 <td width="5%" class="noe_tahvilPr">نوع تحویل بار</td>
	 <td width="10%" class="goodsPr">شناسه عمومی کالا</td>
	 <td width="4%" class="kalaPr">نام کالا</td>
	 <td width="4%" class="bastebandyPr">بسته بندی</td>
	 <td width="4%" class="mahmule_typePr">نوع محموله</td>
	 <td width="4%" class="sh_barnamePr">شماره بارنامه</td>
	 <td width="4%" class="date_barnamePr">تاریخ بارنامه</td>
	 <td width="4%" class="ranande_namePr">نام راننده</td>
	 <td width="4%" class="pelakPr">پلاک خودرو</td>
	 <td width="4%" class="vaznPr">وزن خالص</td>
	 <td width="4%" class="statusPr">وضعیت</td>
	 <td width="4%" class="sabtPr">ثبت نهایی</td>
	 <td width="10%">شناسه یکتا وزارت صمت</td>
	 <td width="5%">کد خطا</td>
	 <td width="5%">متن خطا</td>
 </tr>';
Function print_header()
{global $titr,$mt_gl_owner,$date1,$date2,$FileName,$page;
 echo'
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
   	   <tr class="noExl">
        <td class="print_title_2">';
	    IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
	     echo'
	     '.$titr.' از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
         <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>	    </td>
	   </tr>
      </table>
	 </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" class="land" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<img src="images/loading.gif" id="loading" class="loading_img"/>';
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
if((!$ok)and(!$clkbut))
{
$_SESSION['bz_residcondition']='';
echo'
<table width="90%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="850px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{echo'
       <tr class="tr1" style="height:45px"><td align="left" > استان :&nbsp;</td><td align="right">'.listbox_ostan("code_ostan","$code_ostan","code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4' onChange='myform.submit()' ").'</td>';	  	  	    
	   if(($code_ostan)) echo'<td align="left"> سردخانه :&nbsp;</td><td align="right">'.listbox_anbar("code_anbar",$code_anbar,"code_anbar","name_anbar","list_sardkhane","1=1 and code_ostan=$code_ostan ORDER BY list_sardkhane.name_anbar ASC","class='text4'").'</td>';
	   else echo'<td colspan="2"></td>';
	}
	else 
	{
	 echo'
	 <tr class="tr1" style="height:45px">
	 <td align="left"> سردخانه :&nbsp;</td>
     <td align="right" colspan="3">
	  <select name="anbarchoice[]" class="easyui-combobox" multiple="true" style="width:50%;">';
	  $result_anbar = $db->query("SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["bz_code_ostan"]." AND user_id=".$_SESSION['bz_user_id']." ORDER BY list_sardkhane.name_anbar ASC");
      $anbar_options = "<option value='-1' selected>همه سردخانه ها</option>";
      while($row_anbar=$db->fetch_assoc($result_anbar)) $anbar_options.= "<option value=".$row_anbar['code_anbar'].">".$row_anbar['name_anbar']."</option>";
	  echo $anbar_options;
	  echo'
	  </select>
	 </tr>';
	}
	echo'
	<tr class="tr1" style="height:45px">	
     <td align="left" width="140px"> از تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
     <td align="left" width="140px"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left">آیدی واحد(صمت) :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="warehouse_id" value="'.$warehouse_id.'"  /></td>
	 <td align="left">کدپستی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="postal_code" value="'.$postal_code.'" onkeypress="return isNumber(event)" /></td>
    </tr>
	<tr class="tr1" style="height:40px">
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
	 <td align="left"> وضعیت حواله : </td>
	 <td align="right">&nbsp;<select name="status" class="easyui-combobox text4" style=width:100px  data-options=panelHeight:95>
					          <option value="-1">انتخاب کنید</option>
					          <option value="0" selected>جاری</option>
					          <option value="1">ابطالی</option>
					         </select>
	 </td>
	</tr>
    <tr class="tr1">	
	 <td align="left"> نوع تحویل بار :&nbsp;</td><td align="right">'.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr",1,"class='text4' style=width:200px").'</td>
	 <td align="left"> وضعیت ثبت نهایی : </td>
	 <td align="right">&nbsp;<select name="sabt_nahayi" class="easyui-combobox text4" style=width:100px  data-options=panelHeight:95>
					          <option value="-1">انتخاب کنید</option>
					          <option value="1" selected>ثبت شده</option>
					          <option value="0">ثبت نشده</option>
					         </select>
	 </td>
	</tr>
    <tr class="tr1">	
     <td align="left"> شماره بارنامه : </td><td align="right">&nbsp;<input type="text" class="textboxme2" name="shomare_barname_h" value="'.$shomare_barname_h.'"/></td>
     <td align="left"> پلاک خودرو : </td>
	 <td align="right">&nbsp;
	 		   <sup>ایران</sup>
			   <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/> |
			   <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" style="width:30px;"/>
			   <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" style="width:20px;"/>
			   <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/>
	 </td>
	</tr>
	<tr class="tr1">
	 <td align="left"> تاریخ بارنامه  : </td><td align="right">&nbsp;<input type="text" class="textboxme2 datepicker6"  name="tarikh_barname_h" value="'.$tarikh_barname_h.'"/></td>
	 <td align="left"> وضعیت خطا : </td>
	 <td align="right">&nbsp;<select name="wb_error_code_status" class="easyui-combobox text4" style=width:100px  data-options=panelHeight:125>
					          <option value="-1">انتخاب کنید</option>
					          <option value="0">ندارد</option>
					          <option value="1">دارد</option>
					          <option value="2">نامعلوم</option>
					         </select>
	 </td>
     <!--<td align="left"> کدخطا :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="wb_error_code" value="'.$wb_error_code.'" onkeypress="return isNumber(event)" /></td>-->

	</tr> 
	<tr class="tr1">
	 <td align="left" height="40px"><input type="checkbox" name="chkactivate" /></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	 <td align="left" height="40px"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="footer">	
	 <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>
	</tr> 
   </table>
  </td>
 </tr>
</table>';
}
else
{	
    /****************فیلترها روی گزارش******************/
    /*******استان ها*******/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
    {  
	  if($code_ostan==-1){$Condition_ostan.="1=1";}
	  else{$Condition_ostan=' havale.code_ostan='.$code_ostan.'';}
	}
	else 
    {
	  $Condition_ostan=' havale.code_ostan='.$_SESSION['bz_code_ostan'].'';
    }
	/******انبارها******/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
    {
     if(($code_ostan==-1)or($code_anbar==-1)){$Condition_anbar='1=1';}
     else{$Condition_anbar=' havale.code_anbar='.$code_anbar.'';}
    }
    else //بقیه کاربران براساس انبار قابل دسترسیشان وانتخاب یکی یا چند تا
    {  
     if(is_array($anbarchoice))
     {
       $Condition_anbar="";//شرط را خالی میکنم
	   foreach($anbarchoice as $anbar_key => $anbar_val) {$Condition_anbar_temp.=" T.code_anbar='$anbar_val' OR";}
       if($anbar_val==-1) $Condition_anbar.="1=1 OR";
       else $Condition_anbar.=" $Condition_anbar_temp";
       $lastSpacePosition = strrpos($Condition_anbar," ");
       $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     }    
	}
	if ($date1) $Condition.=" and tarikh_havale_anbar>='$date1'";//از تاریخ         
    if ($date2) $Condition.=" and tarikh_havale_anbar<='$date2'";//تا تاریخ        				
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
	if ($warehouse_id) $Condition.=" and warehouse_id LIKE '%$warehouse_id%'";//ایدی واحد
	if ($postal_code) $Condition.=" and postal_code=$postal_code";//کد پستی 
	if ($noe_tahvil_bar) $Condition.=" and noe_tahvil_bar=$noe_tahvil_bar";//نوع تحویل بار
	if (isset($status)and($status=='0')) $Condition.=" and status=0";//وضعیت رسید 	 
    if (isset($status)and($status=='1')) $Condition.=" and status=1";//وضعیت رسید 	 
    if (isset($status) and ($status=='2')) $Condition.="";//وضعیت رسید
    if (isset($sabt_nahayi)and($sabt_nahayi=='0')) $Condition.=" and sabt_nahayi=0";//وضعیت ثبت نهایی 	 
    if (isset($sabt_nahayi)and($sabt_nahayi=='1')) $Condition.=" and sabt_nahayi=1";//وضعیت ثبت نهایی 	 
    if (isset($sabt_nahayi) and ($sabt_nahayi=='2')) $Condition.="";//وضعیت ثبت نهایی
	if ($shomare_barname_h) $Condition.=" and shomare_barname_h='$shomare_barname_h'";//شماره بارنامه
	if ($tarikh_barname_h) $Condition.=" and tarikh_barname_h='$tarikh_barname_h'";//تاریخ بارنامه
    if ($plak1)  $Condition.=" and plak1='$plak1'";//پلاک خودرو 
    if ($plak2)  $Condition.=" and plak2='$plak2'";//پلاک خودرو 
    if ($plak3)  $Condition.=" and plak3='$plak3'";//پلاک خودرو 
    if ($plak4)  $Condition.=" and plak4='$plak4'";//پلاک خودرو 
        
	if ($wb_error_code)  $Condition.=" and wb_error_code='$wb_error_code'";//کدخطا 
    
	if (isset($wb_error_code_status)and($wb_error_code_status=='0')) $Condition.=" and wb_error_code=0";//خطا ندارد 	 
    if (isset($wb_error_code_status)and($wb_error_code_status=='1')) $Condition.=" and (wb_error_code!=0 and wb_error_code!='')";//خطا دارد 	 
    if (isset($wb_error_code_status) and ($wb_error_code_status=='2')) $Condition.=" and wb_error_code=''";//نامعلوم
	
	/******************نمایش یا عدم نمایش سردخانه های غیرفعال******************/
    if($chkactivate=='on') {$Condition_anbar_activate="1=1";}
    else {$Condition_anbar_activate="list_sardkhane.activate=1";}
	/****************شروع نمایش گزارش*******************/				
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	$q=("SELECT havale.*,name_ostan,name_anbar,postal_code,warehouse_id,list_sardkhane.activate,
	    general_goods_id,name_kala,kala.code_bastebandy,bastebandy.sharh_bastebandy,kala.mahmule_type
	    FROM havale  
        INNER JOIN ostan ON ostan.code_ostan=havale.code_ostan    
        INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=havale.code_anbar AND list_sardkhane.code_ostan=havale.code_ostan    
		INNER JOIN kala ON havale.code_kala=kala.code_kala    
        INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy    
		WHERE 1=1 AND havale.year=$mtActiveYear AND havale.deleted=0 AND($Condition_anbar_activate) AND($Condition_ostan) AND($Condition_anbar) AND ($Condition_kala) $Condition ORDER BY name_ostan,name_anbar,tarikh_havale_anbar,shomare_havale_anbar");			
	//echo $q.'<br/>';
	$res=mysql_query($q);
    $cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
	{		
	 echo'
     <br>
     <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      <tr class="print_table-title2"><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
      <tr class="print_table-title2">
		 <td width="5%">وضعیت سردخانه</td>
		 <td width="5%">کدپستی</td>
		 <td width="5%">آیدی واحد</td>
		 <td width="5%">نوع تحویل بار</td>
	     <td width="5%">شناسه عمومی کالا</td>
	     <td width="5%">نام کالا</td>
	     <td width="5%">بسته بندی</td>
	     <td width="5%">نوع محموله</td>
	     <td width="5%">شماره بارنامه</td>
	     <td width="5%">تاریخ بارنامه</td>
	     <td width="5%">نام راننده</td>
	     <td width="5%">پلاک خودرو</td>
	     <td width="5%">وزن خالص</td>
	     <td width="3%">وضعیت</td>
	    </tr>   	
		<tr class="print_table-title2 print_table-title_small">
	     <td><input name="activateanbarPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="postalPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="warehousePr" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="noe_tahvilPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="goodsPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="kalaPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="bastebandyPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="mahmule_typePr" class="count_sum" type="checkbox" checked></td>
		 <td><input name="sh_barnamePr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="date_barnamePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="ranande_namePr" class="count_sum" type="checkbox" checked></td>
		 <td><input name="pelakPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="vaznPr" type="checkbox"  checked></td>
		 <td><input name="statusPr" class="count_sum" type="checkbox" checked></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
     if($code_ostan) {if($code_ostan=='-1'){$nameOstan='همه استانها';}else{$nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$code_ostan'");}$filter_string.=' استان : '.$nameOstan.'&nbsp;';}     
	 if($code_anbar) {if($code_anbar=='-1'){$nameAnbar='همه سردخانه ها';}else{$nameAnbar=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$code_ostan' AND code_anbar='$code_anbar'");}$filter_string.=' سردخانه : '.$nameAnbar.'&nbsp;';}     
	 if(is_array($anbarchoice))//بقیه کاربران
	 {
	  if($anbar_val==-1)$filter_string2=' سردخانه : همه سردخانه ها';
	  else $filter_string2=' انبار : ';
	  foreach($anbarchoice as $anbar_key => $anbar_val) {
	  $nameAnbar=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$bz_gl_code_ostan' AND code_anbar='$anbar_val'");
	  $filter_string2.=''.$nameAnbar.'&nbsp;';
      }
	 }
	 if(is_array($kalachoice))
     {
      if($kala_val==-1)$filter_string.='همه کالاها';
      else $filter_string.=' کالا : ';
      foreach($kalachoice as $key_kala => $kala_val) {
      $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
      $filter_string.=''.$nameKala.'&nbsp;';
         }
     } 
	 if ($warehouse_id) $filter_string.=' آیدی واحد : '.$warehouse_id.'&nbsp;';    
	 if ($postal_code) $filter_string.=' کدپستی : '.$postal_code.'&nbsp;';    
	 if ($noe_tahvil_bar) $filter_string.=' نوع تحویل بار : '.$tahvilbarArr[$noe_tahvil_bar].'&nbsp;';    
	 if ($shomare_barname_h) $filter_string.=' شماره بارنامه : '.$shomare_barname_h.'&nbsp;';
	 if ($tarikh_barname_h) $filter_string.='تاریخ بارنامه : '.$tarikh_barname_h.'&nbsp;';  
	 if(($plak1)or($plak2)or($plak3)or($plak4)) 
	 {
	  $filter_string.=' پلاک خودرو :&nbsp;';
	  $filter_string.='  '.$plak1.'&nbsp;';
	  $filter_string.='  '.$plak2.'&nbsp;';
	  $filter_string.='  '.$plak3.'&nbsp;';
	  $filter_string.='  '.$plak4.'&nbsp;';
	 }
	 if($status!='-1')
	 { 
	  if($status=='0') $filter_string.=' وضعیت حواله : '.$statusFormArr[$status].'&nbsp;';    
	  if($status=='1') $filter_string.=' وضعیت حواله : '.$statusFormArr[$status].'&nbsp;';    
     }
	 if($sabt_nahayi!='-1')
	 { 
	  if($sabt_nahayi=='0') $filter_string.=' ثبت نهایی نشده &nbsp;';    
	  if($sabt_nahayi=='1') $filter_string.=' ثبت نهایی شده &nbsp;';    
     }
	 
	 if($wb_error_code_status!='-1')
	 { 
	  if($wb_error_code_status=='0') $filter_string.=' وضعیت خطا : ندارد&nbsp;';    
	  if($wb_error_code_status=='1') $filter_string.=' وضعیت خطا : دارد&nbsp;';    
	  if($wb_error_code_status=='2') $filter_string.=' وضعیت خطا : نامعلوم&nbsp;';    
     }
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 

	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd_small">';
      else echo'<tr class="print_table-even_small">';
	  //اضافه کردن صفر پشت کد استان
	  if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
      else $code_a=$row['code_ostan'];
      echo'
	    <td>'.$radif++.'</td>
	    <td class="ostanPr">'.$row['name_ostan'].'</td>
	    <td class="anbarPr">'.$row['name_anbar'].'</td>
	    <td class="activateanbarPr">'.$activateArr[$row['activate']].'</td>
		<td class="postalPr">'.$row['postal_code'].'</td>
		<td class="warehousePr">'.$row['warehouse_id'].'</td>
		<td class="shomarePr">'.$code_a.$row['code_anbar'].$row['shomare_havale_anbar'].'</td>
	    <td class="tarikhPr">'.$row['tarikh_havale_anbar'].'</td>
	    <td class="noe_tahvilPr" >'.$tahvilbarArr[$row['noe_tahvil_bar']].'</td>
	    <td class="goodsPr">'.$row['general_goods_id'].'</td>
	    <td class="kalaPr">'.$row['name_kala'].'</td>
	    <td class="bastebandyPr">'.$row['sharh_bastebandy'].'</td>
	    <td class="mahmule_typePr">'.$mahmuletypeArr[$row['mahmule_type']].'</td>
	    <td class="sh_barnamePr">'.$row['shomare_barname_h'].'</td>
	    <td class="date_barnamePr">'.$row['tarikh_barname_h'].'</td>
	    <td class="ranande_namePr">'.$row['ranande_name'].'</td>
	    <td dir="rtl" class="pelakPr">'.$row['plak2'].'-'.$row['plak1'].''.$row['plak3'].''.$row['plak4'].'</td>
	    <td class="vaznPr">'.virgul($row['vazn_khales_h']).'</td>
		<td class="statusPr">';if($row['status']==0) echo 'جاری';else echo 'ابطالی </td>';
	    echo'
		<td rowspan="'.$rowdetail.'" class="sabtPr">';if($row['sabt_nahayi']==0) echo 'نشده';else echo 'شده </td>';
		echo'
		<td class="wb_idPr">'.$row['wb_id'].'</td>
	    <td class="wb_error_codePr">'.$row['wb_error_code'].'</td>
	    <td class="wb_error_messagePr">'.$row['wb_error_message'].'</td>
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
	 }//END while
	 echo'
      <!--پايان مرکز صفحه -->
      <!-- چاپ زیرنویس-->
      <tr class="print_footer noExl">
        <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$bzuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
      </tr>
	 </table>
	 <br/>'; 	 	 
}	
ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}//END else
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
		//var numberNotChecked  = $(":checkbox:not(:checked)").length;//All of the not checked
		var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		var count_for_sum=count_for_sum-numberNotChecked;
		$("#sum_row").attr("colspan",count_for_sum);
       });	   
});
<!-- نوع تحویل بار-->
 $( document ).ready(function() {
 $("[name=noe_tahvil_bar]").bind("change", function () {
    if(($(this).val() == 4)||($(this).val() == 5)) { 
     $(".ostananbar").slideDown("fast");
	 $(".keshavarz").slideUp("fast");
	}
	else if($(this).val() == 6) {
		$(".keshavarz").slideDown("fast");
	    $(".ostananbar").slideUp("fast");
    }
	else {
		 $(".ostananbar").slideUp("fast");
		 $(".keshavarz").slideUp("fast");
		}
  });
 }); 
<!-- تعویض انبار با انتخاب استان-->
function getAnbareOstan(code_ostan)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_re_resid.php",{codeOSTAN1:code_ostan},function(data){$("#anbar_mabda").html(data);});
  $("#loading").fadeOut("fast");		
}
<!-- تعویض اطلاعات شماره سفر با انتخاب کشتی-->
function getShomareSafar(code_skk)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_re_resid.php",{codeKESHTY:code_skk},function(data){$("[name=id_safar]").html(data);});
  $("#loading").fadeOut("fast");		
}
    
$(".datepicker6").datepicker({
        defaultDate:"'.$today.'",
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true,
    });

</script> 