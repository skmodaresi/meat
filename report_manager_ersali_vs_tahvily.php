<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_ersali_vs_tahvily.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش مقایسه مقادیر ارسالی و تحویلی مابین استان ها ';
require_once('head.html'); 
/****************فیلترها روی گزارش******************/
/************************استان های ارسال کننده******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice_row))//کد های استان ارسال کننده
     {
       foreach($ostanchoice_row as $ostan_key => $ostan_val_row) 
      {
       $Condition_ostan_row_temp.=" T.code_ostan='$ostan_val_row' OR";
      }
      if($ostan_val_row==-1){$Condition_ostan_row.="1=1 OR";}
      else {$Condition_ostan_row.=" $Condition_ostan_row_temp";}
       $lastSpacePosition = strrpos($Condition_ostan_row," ");
       $Condition_ostan_row =substr($Condition_ostan_row,0,$lastSpacePosition);
     }
}
else 
{
 $Condition_ostan_row=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';
}
/*****************************انبارها****************************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
}
/**************انتخاب کد کالا****************/
if(is_array($kalachoice))
{
  foreach($kalachoice as $key_kala => $kala_val) {
  $Condition_kala_temp.=" h.code_kala='$kala_val' OR";
 }
 if($kala_val==-1)$Condition_kala.="1=1 OR";
 else $Condition_kala.=" $Condition_kala_temp";
 $lastSpacePosition = strrpos($Condition_kala," ");
 $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
}
/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
if($show_movaghat==1){$Condition_movaghat="list_sardkhane.situation_type=1 AND ";}
else if($show_movaghat==2){$Condition_movaghat="";}
else if($show_movaghat==3){$Condition_movaghat="list_sardkhane.situation_type=2 AND ";}
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate="";  $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND";  $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=5;
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)$date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
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
<table width="95%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px">
     <td align="left"> از تاریخ  : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>	
     <td align="left"> تا تاریخ  : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <!--<td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; همراه با اطلاعات انبار موقت </td>-->
     <td align="left"> وضعیت نمایش سردخانه های موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='text4'").'</td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp;  نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
	<tr class="tr1" style="height:45px" >	
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>	
	 <td align="left"> تعداد استان در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1" style="height:45px">
     <td align="left">نام کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="kalachoice[]" class="easyui-combobox" size="6" style="width:300px;" multiple>';
	  $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']." (".$row_kala['code_kala'].")</option>";
	  echo $kala_options;
	  echo'
	  </select>
     </td>
	</tr>
	<tr class="tr1" style="height:45px" >';
	  echo'
	   <td align="left">استان ارسال کننده : </td>
       <td align="right" colspan="3">
	    &nbsp;<select name="ostanchoice_row[]" class="easyui-combobox text4" size="4" style="width:300px;" multiple>';
	    $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
        $ostan_options = "<option value='-1' selected>همه استانها</option>";
        while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	    echo $ostan_options;
	    echo'
	    </select>
	   </td>
	  </tr>';
	echo'  
	<tr class="footer"><td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
  </td>
 </tr>
</table> ';
}
else
{  
/****************شروع نمایش گزارش*******************/	
$radif=1;
$page=1;
$line=0;
$i=0;
$cntr=0;
$columns='
    <tr class="print_table-title2">
     <td width="8%" >ردیف</td>
     <td width="11%" >استان ارسال کننده</td>
	 <td width="11%" >استان دریافت کننده</td>
	 <td width="14%" >وزن ارسالی مبدأ</td>
	 <td width="14%" >جمع ارسالی استان</td>
	 <td width="14%" >وزن تحویلی مقصد</td>
	 <td width="14%" >جمع تحویلی استان</td>
	 <td width="14%" >اختلاف وزن مبدأ و مقصد</td>
	</tr>'; 
Function print_header()
{global $titr,$columns,$mt_gl_owner,$date1,$date2,$FileName,$page;
  echo'   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
	   <tr class="noExl"><td class="print_title_2">'.$titr.' - واحد کالا : (کیلوگرم)</td></tr>
	   <tr class="noExl">
	    <td class="print_title_2">';
	     IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
	     echo'
	      از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
         <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>	    </td>
	   </tr>
      </table>
     </td>
    </tr>';
}
	 
$q="SELECT distinct h.code_ostan,name_ostan AS name_ostan_mabda FROM ostan T
	INNER JOIN havale h ON T.code_ostan=h.code_ostan 
	WHERE (noe_tahvil_bar=4 OR noe_tahvil_bar=5) AND year='$mtActiveYear'
	AND tarikh_havale_anbar>='".$date1."' AND tarikh_havale_anbar<='".$date2."'
	AND($Condition_ostan_row) AND($Condition_kala) AND h.status=0 AND h.deleted=0 ORDER BY name_ostan";

$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
 <br/>
 <div class="table2excel">';
  print_header();
  /*سطر نمایش فیلترها*/
  if(is_array($ostanchoice_row))
  {
	  $filter_string='استان ارسال کننده :';
	  if($ostan_val_row==-1)$filter_string.='همه استانها';
	  foreach($ostanchoice_row as $ostan_key => $ostan_val_row) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val_row'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
  }
  IF($anbar_show==1)$filter_string.=' - سردخانه های فعال و غیرفعال  ';
  IF($anbar_show==2)$filter_string.=' - سردخانه های فعال  ';
  IF($anbar_show==3)$filter_string.=' - سردخانه های غیرفعال  ';
  if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
  if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
  if(is_array($kalachoice))
  {
	  if($kala_val==-1)$filter_string.=' همه کالاها';
	  else $filter_string.=' کالا : ';
	  foreach($kalachoice as $key_kala => $kala_val) {
	  $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
	  $filter_string.=''.$nameKala.'&nbsp;';
      }
  }
  if($noe_namayesh) {$filter_string.=' نوع نمایش براساس : '.$namayeshArr[$noe_namayesh].'&nbsp;';}     
  echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
  echo $columns;
  //تعیین فیلدها براساس نوع نمایش
  IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
  ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
  ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
  ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}

  while($row=$db->fetch_array($res))//OSTAN MABDA WHILE IN ROW
 {	  
   $line++;
   $q2="SELECT distinct mojavez_jabejae.code_ostan_maghsad_j,name_ostan AS name_ostan_maghsad FROM havale h
        INNER JOIN mojavez_jabejae ON h.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND h.code_ostan = mojavez_jabejae.code_ostan AND h.code_anbar = mojavez_jabejae.code_anbar AND h.year = mojavez_jabejae.year
	    INNER JOIN ostan ON mojavez_jabejae.code_ostan_maghsad_j=ostan.code_ostan 
	    INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=mojavez_jabejae.code_ostan_maghsad_j AND list_sardkhane.code_anbar=mojavez_jabejae.code_anbar_maghsad_j
	    WHERE  h.code_ostan=".$row['code_ostan']."  AND h.year=$mtActiveYear AND tarikh_havale_anbar>='".$date1."' AND tarikh_havale_anbar<='".$date2."'
        AND h.status=0 AND h.deleted=0 AND($Condition_kala) 
        ORDER BY name_ostan";
   //echo $q2;
   $res2=$db->query($q2);
   $code_ostan=$row['code_ostan'] ; // کد استان مبدا 
   $row_ostanmaghsad=$db->num_rows($res2);//تعداد استانهای گیرنده
   $t=$row_ostanmaghsad;    
   if($i++%2)echo'<tr class="print_table-odd_small">';
   else echo'<tr class="print_table-even_small">';
   echo'   
   <td rowspan="'.$row_ostanmaghsad.'">'.$radif++.'</td>
   <td rowspan="'.$row_ostanmaghsad.'" >'.$row['name_ostan_mabda'].'</td>';
   
	$jame_vazn_ersali_mabda=0;//کل جمع ارسالی استان مبدأ
	$jame_vazn_daryaftee_maghsad=0;//کل جمع دریافتی استان مقصد
	$ekhtelaf_ersali_daryafti=0;
	$first_row=true ;
	//حلقه استانهای مقصد
	while($row2=$db->fetch_assoc($res2))//ostan WHILE	
	{	
	 $j=$i+1;
	 if ($first_row==false)
	 {
		if($j++%2)echo'<tr class="print_table-odd_small">';
        else echo'<tr class="print_table-even_small">'; 
	 }
	 echo'
	 <td>'.$row2['name_ostan_maghsad'].'</td>';
	 //محاسبه جمع ارسالی ها 
	 $vazn_ersali_mabda=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=h.code_anbar AND list_sardkhane.code_ostan=h.code_ostan INNER JOIN mojavez_jabejae m_j ON m_j.shomare_jabejae=h.shomare_jabejae AND m_j.code_ostan=h.code_ostan AND m_j.code_anbar=h.code_anbar AND m_j.year=h.year","$Condition_movaghat $Condition_anbar_activate h.year='$mtActiveYear' AND h.code_ostan=".$row['code_ostan']." AND code_ostan_maghsad_j=".$row2['code_ostan_maghsad_j']." AND tarikh_havale_anbar>='".$date1."' AND tarikh_havale_anbar<='".$date2."' AND (noe_tahvil_bar=4 OR noe_tahvil_bar=5) AND h.deleted=0 AND h.status=0 AND($Condition_kala) AND($Condition_anbar)");
	 $vazn_ersali_mabda=round($vazn_ersali_mabda,3);
	 echo'<td >'.$vazn_ersali_mabda.'</td>'; 
	 $jame_vazn_ersali_mabda+=$vazn_ersali_mabda;//جمع ارسالی  
	 if ($first_row)
		  echo '<td rowspan='.$row_ostanmaghsad.' ><span id="jamersali_'.$code_ostan.'"></span>'.'</td>';// برای جمع ارسالی
	 $vazn_daryaftee_maghsad=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar AND list_sardkhane.code_ostan=r.code_ostan INNER JOIN havale h ON r.id_havale=h.id","$Condition_movaghat $Condition_anbar_activate r.year='$mtActiveYear' AND r.code_ostan=".$row2['code_ostan_maghsad_j']." AND h.code_ostan=".$row['code_ostan']." AND tarikh_resid>='".$date1."' AND tarikh_resid<='".$date2."' AND (r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r.deleted=0 AND r.status=0 AND($Condition_kala) AND($Condition_anbar)");
	 $vazn_daryaftee_maghsad=round($vazn_daryaftee_maghsad,3);
	 echo'<td >'.$vazn_daryaftee_maghsad.'</td>';
	 $jame_vazn_daryaftee_maghsad+=$vazn_daryaftee_maghsad;//جمع دریافتی  
     if ($first_row)
		 echo '<td rowspan='.$row_ostanmaghsad.' ><span id="jamedaryaftee_'.$code_ostan.'"></span>'.'</td>';// برای جمع دریافتی
     $ekhtelaf_ersali_daryafti=$vazn_ersali_mabda-$vazn_daryaftee_maghsad;
	 echo'<td >'.round($ekhtelaf_ersali_daryafti,3).'</td>';
	 
	 $sum_vazn_ersali_mabda+=$vazn_ersali_mabda;
	 $sum_jame_vazn_ersali_mabda+=$vazn_ersali_mabda;//عملا با بالایی یکی ست
	 $sum_vazn_daryaftee_maghsad+=$vazn_daryaftee_maghsad;
	 $sum_jame_vazn_daryaftee_maghsad+=$vazn_daryaftee_maghsad;//عملا با بالایی یکی ست
	 $sum_ekhtelaf_ersali_daryafti+=$ekhtelaf_ersali_daryafti;
	 $first_row=false ;
	 echo '</tr>';
   }//END ostan WHILE
   ?>
		   <script type="text/javascript">
		        var php_var = "<?php echo 'jamersali_'.$code_ostan ?>";
				$("#"+php_var).html(<?php echo round($jame_vazn_ersali_mabda,3) ?>);
		   </script>
		   
		    <script type="text/javascript">
		        var php_var = "<?php echo 'jamedaryaftee_'.$code_ostan ?>";
				$("#"+php_var).html(<?php echo round($jame_vazn_daryaftee_maghsad,3) ?>);
		   </script>
	<?php

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
 }//END WHILE OSTAN IN row
 /*****سطر جمع کل استان ها*****/
   echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	   <td colspan="3">جمع کل </td>
	   <td>'.round($sum_vazn_ersali_mabda,3).'</td>
	   <td>'.round($sum_jame_vazn_ersali_mabda,3).'</td>
	   <td>'.round($sum_vazn_daryaftee_maghsad,3).'</td>
	   <td>'.round($sum_jame_vazn_daryaftee_maghsad,3).'</td>
	   <td>'.round($sum_ekhtelaf_ersali_daryafti,3).'</td>
	 </tr>';
	// END
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
   <tr class="print_footer noExl">
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
 }//END IF//وجود اطلاعات
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