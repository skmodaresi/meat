<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_faravardeha.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش وضعیت فرآورده ها به تفکیک محل نگهداری';
require_once('head.html');
/****************هدر******************/
Function print_header()
{global $titr,$mt_gl_owner,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$kalaName,$code_kala,$Condition,$namayesh_info;
  IF($namayesh_info==2) $info='نمایش : تحت کلید گمرک';
  ELSE $info='نمایش : سایر';
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
	       از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')-'.$info.'
	      <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	     </td>
	   </tr>
	  </table>
	 </td>
    </tr>
	<tr class="print_table-title2">
	  <td width="5%">ردیف</td>
	  <td width="10%">استان</td>
	  <td width="15%">سردخانه</td>
	  <td width="5%">وضعیت</td>
	  <td width="5%">نوع مالکیت</td>';
         $q_column="SELECT name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
	     $res_column=$db->query($q_column);
	     while($column=$db->fetch_assoc($res_column))
	     {echo'<td >'.$column['name_kala'].'</td>';}
	     echo'
	   <td width="15%">جمع</td>
	</tr>';
}
/****************فیلترها روی گزارش******************/
/******************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $ostan_val) 
      {
       $Condition_ostan_temp.=" T.code_ostan='$ostan_val' OR";
      }
      if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{$Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';}
///////////////////////////////////////////////////////////////
//کد های کالا
if(is_array($kalachoice))
{
//{while (list ($key, $val) = each ($kalachoice)) {
foreach($kalachoice as $key_kala => $kala_val) {
  //echo "$key <br>";echo "$kala_val <br>";
  $Condition_kala.=" code_kala='$kala_val' OR";
 }
  if($kala_val==-1)$Condition.="";
  else $Condition.=" and $Condition_kala";
 $lastSpacePosition = strrpos($Condition," ");
 //$textWithoutLastWord =substr($Condition,0,$lastSpacePosition);
 $Condition =substr($Condition,0,$lastSpacePosition);
}
/******************مالکیت انبارها******************/  
if(is_array($malekiyatchoice))
{
    foreach($malekiyatchoice as $key => $mal_val) 
    {
       $Condition_malekiyat_temp.=" noe_malekiyat='$mal_val' OR";
    }
    if($mal_val==-1){$Condition_malekiyat.="1=1 OR";}
    else {$Condition_malekiyat.=" $Condition_malekiyat_temp";}
    $lastSpacePosition = strrpos($Condition_malekiyat," ");
    $Condition_malekiyat =substr($Condition_malekiyat,0,$lastSpacePosition);
}
/******************نمایش یا عدم نمایش سردخانه های موقت******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش سردخانه های غیرفعال******************/
if($anbar_show==1){$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
else if($anbar_show==2){$Condition_anbar_activate="activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
else if($anbar_show==3){$Condition_anbar_activate="activate=2 AND"; $Condition_anbar_activate_ostan="activate=2";}

//if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
//else {$Condition_anbar_activate="activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date2.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=1;
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
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px;">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>	
	 <td align="left" style="height:45px">نوع مالکیت : </td>
	 <td align="right">
	 &nbsp;<select name="malekiyatchoice[]" class="easyui-combobox" size="6" style="width:100px;" data-options=panelHeight:155 multiple>';
	 $malekiyat_options = "<option value='-1' selected>همه</option>";
	 foreach($noe_malekiyatArr AS $key=>$val)
	 {
	  IF($key==0)continue;
	  $malekiyat_options .= "<option value=".$key.">".$val."</option>";
	 }
	 echo $malekiyat_options;
	 echo'
	   </select>      
	 </td>
	</tr>
	<tr class="tr1">	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right" colspan="3">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت </td>
	 <td align="left">وضعیت نمایش اطلاعات سردخانه ها : </td>
	 <td align="right">
	 &nbsp;<select name="anbar_show" class="easyui-combobox" style="width:140px;" data-options=panelHeight:100 >
	        <option value="1">هردو</option>
	        <option value="2">سردخانه های فعال</option>
	        <option value="3">سردخانه های غیرفعال</option>
		   </select>
	 </td>
	 <!--<td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>-->
	</tr>
	<tr class"tr1">
    </tr>';	
	echo'
	<tr class="tr1">
     <td align="left" height="40px"> نام کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="kalachoice[]" class="easyui-combobox" size="6" style="width:330px;" multiple>';
	  $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
	  while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']." (".$row_kala['code_kala'].")</option>";
	  echo $kala_options;
	  echo'
	  </select>';
      //include ("img_helpkala.php");
	  echo'
	 </td>
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left" height="40px">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" size="6" style="width:330px;" multiple>';
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
	<tr class="tr1">
	    <td align="left" height="40px"> نمایش :</td><td align="right" colspan="3">&nbsp;
		'.static_listbox("namayesh_info",$namayesh_info,"namayesh_infoArr",1,"class='easyui-combobox text4' style=width:100px").'
		</td>	
    </tr> 
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>
   </table>
  </td>
 </tr>
</table> ';
}
else
{
   IF($namayesh_info==2){$table_mojody='mojody_kala_gomrok'; $Condition_info=" AND noe_tahvil_bar=9";}
    ELSE {$table_mojody='mojody_kala'; $Condition_info=" AND noe_tahvil_bar!=9";}
	$dateCond="";
    $radif=1;
	/****************فیلترها روی گزارش******************/	
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
    //if(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $ostan_condition='';
	//else $ostan_condition=' AND code_ostan='.$_SESSION['mt_code_ostan'].'';
	//$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane) $ostan_condition ORDER BY name_ostan";
    $q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan AND($Condition_malekiyat)) AND($Condition_ostan) ORDER BY name_ostan";
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
     echo'
     <br>
    <div class="table2excel">	 
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
	 /*سطر نمایش فیلترها*/ 
	 if(is_array($ostanchoice))
     {
	  if($ostan_val==-1)$filter_string='همه استانها';
	  else $filter_string=' استان : ';
	  foreach($ostanchoice as $key => $ostan_val) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
     }
	 if(is_array($kalachoice))
	 {
	  if($kala_val==-1)$filter_string.=' همه کالاها';
	  else $filter_string.=' کالا : ';
	  foreach($kalachoice as $key_kala => $kala_val) {
	  $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
	  $filter_string.=''.$nameKala.'&nbsp;';
      }
	 }
	 //if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت -';
     //if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت -';
	 IF($anbar_show==1)$filter_string.=' - سردخانه های فعال و غیرفعال  ';
	 IF($anbar_show==2)$filter_string.=' - سردخانه های فعال  ';
	 IF($anbar_show==3)$filter_string.=' - سردخانه های غیرفعال  ';
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
   if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if(is_array($malekiyatchoice))
     {
  	   $filter_string.=' - نوع مالکیت  : ';
       if($mal_val==-1)$filter_string.=' همه ';
  	   else{
  	 	 foreach($malekiyatchoice as $mal_key => $mal_val) {
  	       $nameMalekiyat=$noe_malekiyatArr[$mal_val];
  	       $filter_string.=''.$nameMalekiyat.'&nbsp;';
            }	 
       } 
     }
	 if($noe_namayesh) {$filter_string.=' نوع نمایش براساس : '.$namayeshArr[$noe_namayesh].'&nbsp;';}     
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 //تعیین فیلدها براساس نوع نمایش
	 IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
	 ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
	 ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
	 ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
	 echo'  
	  <tr class="print_table-title2" >
	   <td  width="5%">ردیف</td>
	   <td  width="10%">استان</td>
	   <td  width="15%">سردخانه</td>
	   <td  width="5%">وضعیت</td>
	   <td  width="5%">نوع مالکیت</td>';
       $q_column="SELECT name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
       $res_column=$db->query($q_column);
	   while($column=$db->fetch_assoc($res_column))
	   {echo'<td>'.$column['name_kala'].'</td>';}
	   echo'
	   <td  width="15%">جمع</td>
	  </tr>';
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  //تعداد انبار ها
	  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","$Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND code_ostan=".$row['code_ostan']."");//تعداد انبارهای هر استان 
	  else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای هر استان     
	  $rowanbar=$tedadanbar;
	  $t=$rowanbar;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		 <td rowspan="'.$rowanbar.'">'.$radif++.'</td>
	     <td rowspan="'.$rowanbar.'">'.$row['name_ostan'].'</td>';
		   /**///حلقه روی انبار ها
		   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND code_ostan=".$row['code_ostan']."";
		   else $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."";
		   $res2=$db->query($q2);
		   while($row2=$db->fetch_assoc($res2))
		   {	   
			$j=$i+1;
			echo'
		     <td>'.$row2['name_anbar'].'</td>
			 <td>'.$activateArr[$row2['activate']].'</td>
			 <td>'.$noe_malekiyatArr[$row2['noe_malekiyat']].'</td>';
			  $jame_mojody_anbar=0;//جمع موجودی کل کالاها در هر انبار
			  $s1=0;
			  $q3="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
              $res3=$db->query($q3);
	          while($row3=$db->fetch_assoc($res3))
	          {
			   //موجودی هر کالا در هر انبار
			     $mojodyAval=$db->get_from_where("SUM($avalField)","$table_mojody","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
			     $Varede_bef=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row3['code_kala']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<'$date1' $Condition_info ");
			     $Sadere_bef=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row3['code_kala']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1' $Condition_info ");
			     $Tadil_Ezafe_bef=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' $Condition_info ");
			     $Tadil_Kasry_bef=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'$date1' $Condition_info ");
			     $mojodyAval_bef=$mojodyAval+$Varede_bef-$Sadere_bef+$Tadil_Ezafe_bef-$Tadil_Kasry_bef;
			     /**/			   
			     $Varede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row3['code_kala']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $Condition_info ");
			     $Sadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala=".$row3['code_kala']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' $Condition_info ");
			     $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $Condition_info ");
			     $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_kala=".$row3['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $Condition_info ");
                 $mojodyKala=$mojodyAval_bef+$Varede-$Sadere+$Tadil_Ezafe-$Tadil_Kasry;			   
			   echo '<td>'.round($mojodyKala,3).'</td>';
			   $jame_mojody_anbar+=$mojodyKala;//جمع موجودی کل کالاها در هر انبار  
			  }//END kala while
			  echo '<td>'.round($jame_mojody_anbar,3).'</td>';
			  $t--;
			  if($t==0) echo'';
			  else 
			  {
			   echo'</tr>';
			   if($j++%2)echo'<tr class="print_table-odd">';
               else echo'<tr class="print_table-even">';
			  }
		   }//END anbar while
		   /*****سطر جمع کل انبارهای هر استان*****/ 
		   $malekiyatArr=array();//آرایه جدید برای ایجاد حلقه سطرهای مجموع استان
		   IF((count($malekiyatchoice)==1)AND(in_array(-1,$malekiyatchoice)))//اگر فقط همه انتخاب شده باشد
		   {
			//$malekiyatArr=array('-1','1','2','3','4');
			foreach($noe_malekiyatArr AS $key=>$val)
			{
			 array_push($malekiyatArr,$key);
			}
			//array_shift($malekiyatArr);//عنصر - را از آرایه حذف کردم
			array_unshift($malekiyatArr,'-1');//عنصر (-1) را به اول آرایه اضافه کردم
		   }
		   ELSE $malekiyatArr=$malekiyatchoice;//در بقیه موارد همان آرایه ایی که از انتخاب کاربر شکل گرفته 
		   /*****شروع حلقه سطر های جمع هر استان*****/
		   foreach(array_reverse($malekiyatArr) as $mal_key => $mal_val) 
		   {
			$mojodyKalaOstan=0;
			$jame_mojodyKalaOstan=0;
			IF($mal_val=='-1') // سطر کل استان
			{
			  $MalekiyatCondition='';
              foreach($malekiyatArr as $mal_key2 => $mal_val2) 
              {$MalekiyatCondition_temp.=" noe_malekiyat='$mal_val2' OR"; }
			  $MalekiyatCondition.=" $MalekiyatCondition_temp";
			  $lastSpacePosition = strrpos($MalekiyatCondition," ");
              $MalekiyatCondition =substr($MalekiyatCondition,0,$lastSpacePosition);
              $MalekiyatCondition='('.$MalekiyatCondition.') AND';
			}
			ELSE $MalekiyatCondition='noe_malekiyat='.$mal_val.' AND';
		    $count_anbar_with_malekiyat=$db->get_from_where("count(code_anbar)","list_sardkhane","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition code_ostan=".$row['code_ostan']."");
			IF($count_anbar_with_malekiyat>0)
			{
		     echo'
		     <tr class="print_table-even sum-row" style="background-color:#FFF;">
			  <td colspan="5">جمع کل انبارهای '.$noe_malekiyatArr[$mal_val].' استان '.$row['name_ostan'].'  </td>';
			  $q_kala="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
              $res_kala=$db->query($q_kala);
	          while($row_kala=$db->fetch_assoc($res_kala))
	          {   
			    //مجموع موجودی هر کالا در هر استان
			    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
		       {
			     $mojodyAval2=$db->get_from_where("SUM($avalField)","$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition T.code_ostan=".$row['code_ostan']." AND code_kala=".$row_kala['code_kala']." AND year='$mtActiveYear' AND deleted=0");        	
			     $Varede2=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition T.code_ostan=".$row['code_ostan']." AND T.code_kala=".$row_kala['code_kala']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<='$date2' $Condition_info ");
			     $Sadere2=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition T.code_ostan=".$row['code_ostan']." AND T.code_kala=".$row_kala['code_kala']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2' $Condition_info ");
			     $Tadil_Ezafe2=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition noe_tadil=1 AND T.code_ostan=".$row['code_ostan']." AND code_kala=".$row_kala['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' $Condition_info ");
			     $Tadil_Kasry2=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition noe_tadil=2 AND T.code_ostan=".$row['code_ostan']." AND code_kala=".$row_kala['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' $Condition_info ");
			    // echo $mojodyAval2.'<br>';
			    // echo $Varede2.'<br>';
			    // echo $Sadere2.'<br>';
			    // echo $Tadil_Ezafe2.'<br>';
			    // echo $Tadil_Kasry2.'<br>';
				}
			    else//اگر دسترسی به تمام استان ها ندارد
			    {
			  	  $mojodyKhalesAval2=$db->get_from_where("SUM($avalField)","$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=T.code_ostan AND user_ostan_anbar.code_anbar=T.code_anbar","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row_kala['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND user_id=".$_SESSION['mt_user_id']."");        	
			      $jameKhalesVarede2=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=r.code_ostan AND user_ostan_anbar.code_anbar=r.code_anbar INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition T.code_ostan=".$row['code_ostan']." AND T.code_kala=".$row_kala['code_kala']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<='$date2' AND user_id=".$_SESSION['mt_user_id']." $Condition_info ");
			      $jameKhalesSadere2=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=h.code_ostan AND user_ostan_anbar.code_anbar=h.code_anbar INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition T.code_ostan=".$row['code_ostan']." AND T.code_kala=".$row_kala['code_kala']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2' AND user_id=".$_SESSION['mt_user_id']." $Condition_info ");
			      $KhalesTadil_Ezafe2=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=T.code_ostan AND user_ostan_anbar.code_anbar=T.code_anbar","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition noe_tadil=1 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row_kala['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND user_id=".$_SESSION['mt_user_id']." $Condition_info ");
			      $KhalesTadil_Kasry2=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN user_ostan_anbar ON user_ostan_anbar.code_ostan=T.code_ostan AND user_ostan_anbar.code_anbar=T.code_anbar","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition noe_tadil=2 AND user_ostan_anbar.code_ostan=".$row['code_ostan']." AND code_kala=".$row_kala['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND user_id=".$_SESSION['mt_user_id']." $Condition_info ");			   	  
			    }
			     $mojodyKalaOstan=$mojodyAval2+$Varede2-$Sadere2+$Tadil_Ezafe2-$Tadil_Kasry2;			   
			     echo '<td>'.round($mojodyKalaOstan,3).'</td>';
			     $jame_mojodyKalaOstan+=$mojodyKalaOstan;//جمع موجودی کل کالاها در هر استان
			  }//END kala while
			  echo '<td>'.round($jame_mojodyKalaOstan,3).'</td>	
		     </tr>';
			}//END IF
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
	  }	
	 }//END FIRST while,ostan while
	/*****سطر جمع موجودی کل کشور*****/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 /*****شروع حلقه سطر های جمع کل کشور*****/
	 foreach(array_reverse($malekiyatArr) as $mal_key => $mal_val) 
	 {
	  $mojodyKala=0;
	  $jame_mojodyKala=0;
	  IF($mal_val=='-1') // سطر کل استان
	  {
			  $MalekiyatCondition='';
              foreach($malekiyatArr as $mal_key2 => $mal_val2) 
              {$MalekiyatCondition_temp.=" noe_malekiyat='$mal_val2' OR"; }
			  $MalekiyatCondition.=" $MalekiyatCondition_temp";
			  $lastSpacePosition = strrpos($MalekiyatCondition," ");
              $MalekiyatCondition =substr($MalekiyatCondition,0,$lastSpacePosition);
              $MalekiyatCondition='('.$MalekiyatCondition.') AND';
	  }
	  ELSE $MalekiyatCondition='noe_malekiyat='.$mal_val.' AND';
	  echo'
	  <tr class="print_table-even sum-row" >
	   <td colspan="5">جمع موجودی انبارهای '.$noe_malekiyatArr[$mal_val].' استان ها</td>';
	   $q_kala="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
       $res_kala=$db->query($q_kala);
	   while($row_kala=$db->fetch_assoc($res_kala))
	   {
		   $mojodyAval4=$db->get_from_where("SUM($avalField)","$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition code_kala=".$row_kala['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND($Condition_ostan)");        	
		   $Varede4=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition T.code_kala=".$row_kala['code_kala']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<='$date2' AND($Condition_ostan) $Condition_info ");
	       $Sadere4=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition T.code_kala=".$row_kala['code_kala']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2' AND($Condition_ostan) $Condition_info ");
	       $Tadil_Ezafe4=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition noe_tadil=1 AND code_kala=".$row_kala['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_ostan) $Condition_info ");
	       $Tadil_Kasry4=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition noe_tadil=2 AND code_kala=".$row_kala['code_kala']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_ostan) $Condition_info ");
		   $mojodyKala=$mojodyAval4+$Varede4-$Sadere4+$Tadil_Ezafe4-$Tadil_Kasry4;
		 echo '<td>'.round($mojodyKala,3).'</td>';
		 $jame_mojodyKala+=$mojodyKala;//جمع موجودی کل کالاها درهمه انبارهای ملکی
	   }//END kala while
	   echo '<td>'.round($jame_mojodyKala,3).'</td>
	 </tr>';
	 }//END foreach	
	 /*****سطر جمع کل استان ها*****/
	 // echo'
	 // <tr class="print_table-even sum-row" >
	  // <td colspan="4">جمع کل استان ها</td>';
	   // $jame_mojody_ostanha=0;//جمع موجودی کل کالاها درهمه استانها
	   // $q5="SELECT code_kala,name_kala FROM kala WHERE 1=1 $Condition ORDER BY name_kala";
       // $res5=$db->query($q5);
	   // while($row5=$db->fetch_assoc($res5))
	   // {
	     // //$mojodyKalaOstanha=0;
		 // //مجموع موجودی هر کالادر تمام استان ها
	     // if($noe_namayesh==1)//درحالت خالص
	     // {	 
		   // $mojodyKhalesAval6=$db->get_from_where("SUM(mojody_khales_aval)","$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND($Condition_ostan)");        	
		   // $jameKhalesVarede6=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate T.code_kala=".$row5['code_kala']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<='$date2' AND($Condition_ostan)");
	       // $jameKhalesSadere6=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate T.code_kala=".$row5['code_kala']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2' AND($Condition_ostan)");
	       // $KhalesTadil_Ezafe6=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=1 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_ostan)");
	       // $KhalesTadil_Kasry6=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=2 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_ostan)");
		   // $mojodyKalaOstanha=$mojodyKhalesAval6+$jameKhalesVarede6-$jameKhalesSadere6+$KhalesTadil_Ezafe6-$KhalesTadil_Kasry6;
		   // //mojody as field//$mojodyKalaOstanha=$db->get_from_where("SUM(mojody)","$table_mojody","code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 GROUP BY code_kala");     
	     // }
		 // if($noe_namayesh==2)//درحالت ناخالص
	     // {	 
		   // $mojodyNaKhalesAval6=$db->get_from_where("SUM(mojody_nakhales_aval)","$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND($Condition_ostan)");        	
		   // $jameNakhalesVarede6=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate T.code_kala=".$row5['code_kala']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<='$date2' AND($Condition_ostan)");
	       // $jameNakhalesSadere6=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate T.code_kala=".$row5['code_kala']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2' AND($Condition_ostan)");
	       // $NakhalesTadil_Ezafe6=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=1 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_ostan)");
	       // $NakhalesTadil_Kasry6=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=2 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_ostan)");
		   // $mojodyKalaOstanha=$mojodyNaKhalesAval6+$jameNakhalesVarede6-$jameNakhalesSadere6+$NakhalesTadil_Ezafe6-$NakhalesTadil_Kasry6;
		 // }
		 // if($noe_namayesh==3)//درحالت تعداد کارتن
	     // {	 
		   // $tedadKartonAval6=$db->get_from_where("SUM(tedad_karton_aval)","$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND($Condition_ostan)");        	
		   // $jameKartonVarede6=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate T.code_kala=".$row5['code_kala']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<='$date2' AND($Condition_ostan)");
	       // $jameKartonSadere6=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate T.code_kala=".$row5['code_kala']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<='$date2' AND($Condition_ostan)");
	       // $KartonTadil_Ezafe6=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=1 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_ostan)");
	       // $KartonTadil_Kasry6=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_movaghat $Condition_anbar_activate noe_tadil=2 AND code_kala=".$row5['code_kala']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_ostan)");
		   // $mojodyKalaOstanha=$tedadKartonAval6+$jameKartonVarede6-$jameKartonSadere6+$KartonTadil_Ezafe6-$KartonTadil_Kasry6;
	     // }
		 // echo '<td>'.round($mojodyKalaOstanha,3).'</td>';
		 // $jame_mojody_ostanha+=$mojodyKalaOstanha;//جمع موجودی کل کالاها درهمه استانها
	   // }//END kala while
	   // echo '<td>'.round($jame_mojody_ostanha,3).'</td>';
	 // echo'
	 // </tr>';
	}//END IF
	//END//
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
<script type="text/javascript" src="scripts/elevator.min.js"></script