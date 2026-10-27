<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_oftokasry.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش  طرح در کمیسیون افت و کسری';
require_once('head.html');
$TableName="mojavez_oftokasry";
$columns='
	<tr class="print_table-title2" style="height:60px;">
	   <td width="5%" rowspan="2">ردیف</td>
	   <td width="5%" rowspan="2">شناسه</td>
	   <td width="5%" rowspan="2">استان</td>
	   <td width="5%" rowspan="2">سردخانه</td>
	   <td width="5%" rowspan="2">وضعیت سردخانه</td>
	   <td width="5%" rowspan="2">شماره نامه</td>
	   <td width="5%" rowspan="2">تاریخ نامه</td>
	   <td width="5%" rowspan="2">نام کالا</td>
	   <td width="5%" rowspan="2">تولیدکننده</td>
	   <td width="10%" colspan="3">تاریخ تولید</td>
	   <td width="5%" rowspan="2">نوع</td>
	   <td width="10%" colspan="3">مقادیر</td>
	   <td width="5%" rowspan="2">وضعیت</td>
	   <td width="5%" rowspan="2">شماره مجوز</td>
	   <td width="5%" rowspan="2">تاریخ مجوز</td>
	   <td width="5%" rowspan="2">تأیید اولیه</td>
	   <td width="5%" rowspan="2">تأیید نهایی</td>
	</tr>
    <tr class="print_table-title2">
	   <td>سال</td>
	   <td>ماه</td>
	   <td>روز</td>
	   <td>تعداد</td>
	   <td>ناخالص</td>
	   <td>خالص</td>';
Function print_header()
{global $columns,$chkbarname,$titr,$mt_gl_owner,$date1,$date2,$FileName,$page;
 echo' 
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2">';
       echo $titr;
	   echo'</td></tr>
	   <tr class="noExl">
	    <td class="print_title_2">';
	    IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
          echo'
	      از تاریخ  نامه : '.$date1.' تا تاریخ نامه : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
	      <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
       </tr>
      </table>
	 </td>
	</tr> ';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform" id="myform">';
if(!$MaxLines)$MaxLines=15;
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
{
	  $date1=$db->get_from_where("start_from","$mydatabase.mt_docs","year='$mtActiveYear'");  
} 
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
	 $today=AsLDate($yymmdd); 
 	 $end_date_session=$db->get_from_where("end_to","$mydatabase.mt_docs","year='$mtActiveYear'");
	 if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;
} 
if(!$ok)
{
echo'
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0" border="0">
 <tr>
  <td height="100%">
   <table width="800px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr><td colspan="4" class="title">'.$titr.'</td></tr>
	<tr class="tr1" style="height:45px">	
     <td align="left"> از تاریخ نامه :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'" value="'.$date1.'" /></td>
     <td align="left"> تا تاریخ نامه :&nbsp;</td><td align="right" ><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'" value="'.$date2.'" /></td>
	</tr>';
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{echo'
       <tr class="tr1"><td align="left" > استان :&nbsp;</td><td align="right">'.listbox_ostan("code_ostan","$code_ostan","code_ostan","name_ostan","$mydatabase.ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4' onChange='myform.submit()' ").'</td>';	  	  	    
	   if(($code_ostan)) echo'<td align="left"> سردخانه :&nbsp;</td><td align="right">'.listbox_anbar("code_anbar",$code_anbar,"code_anbar","name_anbar","$mydatabase.list_sardkhane","1=1 and code_ostan=$code_ostan ORDER BY list_sardkhane.name_anbar ASC","class='text4'").'</td>';
	   else echo'<td colspan="2"></td>';
	}
	else 
	{
	 echo'
	 <tr class="tr1">
	 <td align="left"> سردخانه :&nbsp;</td>
     <td align="right" colspan="3">
	  <select name="anbarchoice[]" class="easyui-combobox" multiple="true" style="width:50%;">';
	  $result_anbar = $db->query("SELECT * FROM $mydatabase.user_ostan_anbar INNER JOIN bzacc.list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["bz_code_ostan"]." AND user_id=".$_SESSION['bz_user_id']." ORDER BY list_sardkhane.name_anbar ASC");
      $anbar_options = "<option value='-1' selected>همه سردخانه ها</option>";
      while($row_anbar=$db->fetch_assoc($result_anbar)) $anbar_options.= "<option value=".$row_anbar['code_anbar'].">".$row_anbar['name_anbar']."</option>";
	  echo $anbar_options;
	  echo'
	  </select>
	 </tr>';
	}
	echo'  
	<tr class="tr1" >
     <td align="left" height="40px"> نام کالا :&nbsp;</td>
     <td align="right">
	  <select name="kalachoice[]" class="easyui-combobox" multiple="true" style="width:90%;">';
	  $result_kala = $db->query("SELECT * FROM $mydatabase.kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']."</option>";
	  echo $kala_options;
	  echo'
	  </select>
	 </td>
	 <td align="left">وضعیت نمایش اطلاعات سردخانه ها : </td>
     <td align="right">
	 &nbsp;<select name="anbar_show" class="easyui-combobox" style="width:140px;" data-options=panelHeight:100 >
	        <option value="1">هردو</option>
	        <option value="2">سردخانه های فعال</option>
	        <option value="3">سردخانه های غیرفعال</option>
		   </select>
	 </td>
	</tr> 
	<tr class="tr1" >
	 <td align="left">تأیید اولیه : </td>
     <td align="right">
	 &nbsp;<select name="taeed_aval" class="easyui-combobox" style="width:140px;" data-options=panelHeight:100 >
	        <option value="1">هردو</option>
	        <option value="2">تأیید شده</option>
	        <option value="3">تأیید نشده</option>
		   </select>
	 </td>
	 <td align="left">تأیید نهایی : </td>
     <td align="right">
	 &nbsp;<select name="taeed_nahayi" class="easyui-combobox" style="width:140px;" data-options=panelHeight:100 >
	        <option value="1">هردو</option>
	        <option value="2">تأیید شده</option>
	        <option value="3">تأیید نشده</option>
		   </select>
	 </td>
	</tr>
	<tr class="tr1">
	 <td align="left" height="40px"> تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="footer"><td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr> 
   </table>
  </td>
 </tr>
</table>';
}
else
{
	$Condition_anbar="1=1"; 
	$Condition_kala="1=1";
    /****************فیلترها روی گزارش******************/
	/*******استان ها*******/
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
    {  
	  if($code_ostan==-1){$Condition_ostan.="1=1";$Condition_ostan_r.="1=1";}
	  else {$Condition_ostan=' ostan.code_ostan='.$code_ostan.''; $Condition_ostan_r=' code_ostan='.$code_ostan.'';}	  
	}
	else  {$Condition_ostan=' ostan.code_ostan='.$_SESSION['bz_code_ostan'].'';$Condition_ostan_r=' code_ostan='.$_SESSION['bz_code_ostan'].'';}
	/******سردخانه ها******/
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	  if(($code_ostan==-1)or($code_anbar==-1))	{$Condition_anbar='1=1';$Condition_anbar_r='1=1';}
      else {$Condition_anbar=' list_sardkhane.code_anbar='.$code_anbar.'';$Condition_anbar_r=' code_anbar='.$code_anbar.'';}   
	}
	else //بقیه کاربران براساس انبار قابل دسترسیشان وانتخاب یکی یا چند تا
    {  
      if(is_array($anbarchoice))
      {
       $Condition_anbar="";//شرط را خالی میکنم
	   foreach($anbarchoice as $anbar_key => $anbar_val) 
	   {
		   $Condition_anbar_temp.=" list_sardkhane.code_anbar='$anbar_val' OR";
		   $Condition_anbar_r_temp.=" code_anbar='$anbar_val' OR";
	   }
       if($anbar_val==-1) {$Condition_anbar.="1=1 OR";$Condition_anbar_r.="1=1 OR";}
       else {$Condition_anbar.=" $Condition_anbar_temp";$Condition_anbar_r.=" $Condition_anbar_r_temp";}
	   $lastSpacePosition = strrpos($Condition_anbar," ");
	   $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
	   $lastSpacePosition_r = strrpos($Condition_anbar_r," ");
	   $Condition_anbar_r =substr($Condition_anbar_r,0,$lastSpacePosition_r);
     }    
	}
	/******کد های کالا******/
    if(is_array($kalachoice))
    {
	  $Condition_kala="";//شرط را خالی میکنم
	  foreach($kalachoice as $kala_key => $kala_val) {$Condition_kala_temp.=" kala.code_kala='$kala_val' OR";}
      if($kala_val==-1) $Condition_kala.="1=1 OR";
      else $Condition_kala.=" $Condition_kala_temp";
      $lastSpacePosition = strrpos($Condition_kala," ");
      $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
    }

	/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
    if($anbar_show==1){$Condition_anbar_activate="1=1";}
    else if($anbar_show==2){$Condition_anbar_activate="activate=1";}
    else if($anbar_show==3){$Condition_anbar_activate="activate=2";}
	/******************  تأیید اول******************/
    if($taeed_aval==1){$Condition_taeed_aval="1=1";}
    else if($taeed_aval==2){$Condition_taeed_aval="chktaeed=1";}
    else if($taeed_aval==3){$Condition_taeed_aval="chktaeed=0";}
	/******************  تأیید نهایی******************/
    if($taeed_nahayi==1){$Condition_taeed_nahayi="1=1";}
    else if($taeed_nahayi==2){$Condition_taeed_nahayi="chktaeed_final=1";}
    else if($taeed_nahayi==3){$Condition_taeed_nahayi="chktaeed_final=0";}
	
	/****************شروع نمایش گزارش*******************/		
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	$q="SELECT T.*,name_ostan,name_anbar,activate,name_kala,name_tolidkonande FROM $TableName AS T
          INNER JOIN kala ON kala.code_kala=T.code_kala
          INNER JOIN tolidkonande ON tolidkonande.code_tolidkonande=T.code_tolidkonande
          INNER JOIN ostan ON ostan.code_ostan=T.code_ostan	  
          INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar	  
	 	  WHERE tarikh_nameh between '$date1' AND '$date2'  AND status=0 AND deleted=0 $Condition AND($Condition_ostan) AND($Condition_anbar) AND ($Condition_kala) AND($Condition_anbar_activate) AND($Condition_taeed_aval) AND($Condition_taeed_nahayi)
		  ORDER BY name_ostan,name_anbar,tarikh_nameh;";	  
 
    //if(SuperUser()) echo $q; 	
    $res=$db->query($q);
	$cntr=mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
	{
     echo'
     <br>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if($code_ostan) {if($code_ostan=='-1'){$nameOstan='همه استانها';}else{$nameOstan=$db->get_from_where("name_ostan","$mydatabase.ostan","code_ostan='$code_ostan'");}$filter_string.=' استان : '.$nameOstan.'&nbsp;';}     
	 if($code_anbar) {if($code_anbar=='-1'){$nameAnbar='همه انبارها';}else{$nameAnbar=$db->get_from_where("name_anbar","$mydatabase.list_sardkhane","code_ostan='$code_ostan' AND code_anbar='$code_anbar'");}$filter_string.=' انبار : '.$nameAnbar.'&nbsp;';}     
	 if(is_array($anbarchoice))//بقیه کاربران
	 {
	  if($anbar_val==-1)$filter_string2=' سردخانه : همه سردخانه ها ';
	  else $filter_string2=' انبار : ';
	  foreach($anbarchoice as $anbar_key => $anbar_val) {
	  $nameAnbar=$db->get_from_where("name_anbar","$mydatabase.list_sardkhane","code_ostan='$bz_gl_code_ostan' AND code_anbar='$anbar_val'");
	  $filter_string2.=''.$nameAnbar.'&nbsp;';
      }
	 }
	 if(is_array($kalachoice))
	 {
	  if($kala_val==-1)$filter_string3=' کالا : همه کالاها';
	  else $filter_string3=' کالا : ';
	  foreach($kalachoice as $kala_key => $kala_val) {
	  $nameKala=$db->get_from_where("name_kala","$mydatabase.kala","code_kala='$kala_val'");
	  $filter_string3.=''.$nameKala.'&nbsp;';
      }
	 }
	 IF($anbar_show==1)$filter_string.=' - سردخانه های فعال و غیرفعال  ';
	 IF($anbar_show==2)$filter_string.=' - سردخانه های فعال  ';
	 IF($anbar_show==3)$filter_string.=' - سردخانه های غیرفعال  ';
	 IF($taeed_aval==1)$filter_string.=' -  ';
	 IF($taeed_aval==2)$filter_string.=' -  تأیید اولیه شده ';
	 IF($taeed_aval==3)$filter_string.=' - تأیید اولیه نشده  ';
	 IF($taeed_nahayi==1)$filter_string.=' -  ';
	 IF($taeed_nahayi==2)$filter_string.=' -  تأیید نهایی شده ';
	 IF($taeed_nahayi==3)$filter_string.=' - تأیید نهایی نشده  ';
	 
	 if(($code_ostan)or($anbarchoice)or($kalachoice))
	 {echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.$filter_string2.$filter_string3.$filter_string4.'</td></tr>';}
     echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	   $line++;
	   //اضافه کردن صفر پشت کد استان
	   if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       else $code_a=$row['code_ostan'];	
	   $barname_tarikh=AsLDate($row['barname_tarikh']);   
	   if($i++%2)echo'<tr class="print_table-odd_small">';
       else echo'<tr class="print_table-even_small">';  
       //IF(($row['chktaeed']!=1)OR(($row['chktaeed']==1)AND($row['chktaeed_final']!=1)))  $edtClick='<a  target="my_frame" href="mojavez_oftokasry.php?Mode=Edit&id_mojavez_='.$row['id_mojavez'].'&$_SESSION[\'mt_code_ostan\']='.$row['code_ostan'].'&mt_gl_code_ostan='.$row['code_ostan'].'&$_SESSION[\'mt_code_anbar\']='.$row['code_anbar'].'&mt_gl_code_anbar='.$row['code_anbar'].'" style="display:block;cursor:pointer;text-decoration:none;color:#000; "> ';
      // ELSE  $edtClick='<a  target="my_frame" href="mojavez_oftokasry.php?Mode=Takmil&id_mojavez_='.$row['id_mojavez'].'&$_SESSION[\'mt_code_ostan\']='.$row['code_ostan'].'&mt_gl_code_ostan='.$row['code_ostan'].'&$_SESSION[\'mt_code_anbar\']='.$row['code_anbar'].'&mt_gl_code_anbar='.$row['code_anbar'].'" style="display:block;cursor:pointer;text-decoration:none;color:#000; "> ';
       $edtClick='<a  target="my_frame" href="mojavez_oftokasry.php?Mode=Takmil&id_mojavez_='.$row['id_mojavez'].'&$_SESSION[\'mt_code_ostan\']='.$row['code_ostan'].'&mt_gl_code_ostan='.$row['code_ostan'].'&$_SESSION[\'mt_code_anbar\']='.$row['code_anbar'].'&mt_gl_code_anbar='.$row['code_anbar'].'" style="display:block;cursor:pointer;text-decoration:none;color:#000; "> ';
	   echo'
	    <td> '.$edtClick.'  '.$radif++.'</a></td>
	    <td> '.$edtClick.'  '.$row['id_mojavez'].'</a></td>
	    <td> '.$edtClick.''.$row['name_ostan'].' </a></td>
	    <td> '.$edtClick.''.$row['name_anbar'].'</a></td>
	    <td  '; IF($row['activate']==1) echo 'class="active"'; IF($row['activate']==2) echo 'class="deactive"';  echo'>'.$activateArr[$row['activate']].'</td>
		<td> '.$edtClick.''.$row['shomare_nameh'].'</a></td>
		<td> '.$edtClick.''.$row['tarikh_nameh'].'</a></td>
		<td> '.$edtClick.''.$row['name_kala'].'</a></td>
		<td> '.$edtClick.''.$row['name_tolidkonande'].'</a></td>
		<td> '.$edtClick.''.$row['sal_tolid_shamsi'].'</a></td>
	    <td> '.$edtClick.''.$mahshamsiArr[$row['mah_tolid_shamsi']].'</a></td>
	    <td> '.$edtClick.''.$row['rouz_tolid_shamsi'].'</a></td>
		<td> '.$edtClick.''.$tadilArr[$row['noe_oftokasry']].'</a></td>
		<td> '.$edtClick.''.virgul($row['tedad_oftokasry']).'</a></td>
	    <td> '.$edtClick.''.round($row['meghdar_nakhales_oftokasry'],3).'</a></td>
	    <td> '.$edtClick.''.round($row['meghdar_khales_oftokasry'],3).'</a></td>
	    <td> '.$edtClick.'';if($row['status']==0) echo 'جاری';else echo 'ابطالی </a></td>';
		echo'
		<td> '.$edtClick.''.$row['shomare_mojavez'].'</a></td>
	    <td> '.$edtClick.''.$row['tarikh_mojavez'].'</a></td>';
		echo'<td> '.$edtClick.' ';if($row['chktaeed']==1)echo '<span class="fa fa-check-circle fa-2x" style="color:YellowGreen"></span>'; else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo' </a></td>';	
	    echo'<td> '.$edtClick.' ';if($row['chktaeed_final']==1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>'; else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo' </a></td>';	
	  
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