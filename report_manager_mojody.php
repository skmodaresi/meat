<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش موجودی و ورودی خروجی سردخانه ها';
require_once('head.html');
IF($noe_namayesh==1){$str='(خالص)';$sum_str='کیلوگرم';}
ELSE IF($noe_namayesh==2){$str='(ناخالص)';$sum_str='کیلوگرم';}
ELSE IF($noe_namayesh==3){$str='(تعداد)';$sum_str='تعداد';}
ELSE IF($noe_namayesh==4){$str='(شانه)';$sum_str='شانه';}
$columns='
	<tr class="print_table-title2" style="height:70px;">
	   <td rowspan="2" width=3%>ردیف</td>
	   <td rowspan="2" width=5%>کد استان</td>
	   <td rowspan="2" width=5%>استان</td>
	   <td rowspan="2" width=5%>کد سردخانه</td>
	   <td rowspan="2" width=15%>سردخانه</td>
	   <td rowspan="2" width=4%>وضعیت</td>
	   <td rowspan="2" width=3%>کد کالا</td>
	   <td rowspan="2" width=10%>نام کالا</td>
	   <td rowspan="2" width=10% class="mande_beforPr">مانده موجودی از قبل '.$str.'</td>
	   <td rowspan="2" width=10% class="varedePr">وارده طی دوره '.$str.'</td>
	   <td rowspan="2" width=10% class="saderePr">صادره طی دوره '.$str.'</td>
	   <td colspan="2" width=10% class="tadilPr">تعدیل '.$str.'</td>
	   <td rowspan="2" width=10% class="mandePr">مانده در پایان دوره '.$str.'</td> 
	</tr>
	<tr class="print_table-title2">
	 <td class="tadilPr">اضافه</td>
	 <td class="tadilPr">کسری</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$code_kala,$code_kala2,$date1,$date2,$FileName,$page,$noe_namayesh;
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
/************************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $ostan_val ) 
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
/*****************************انبارها****************************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
}
/******************بسته بندی******************/
if($code_bastebandy)  $Condition_bastebandy.=" AND code_bastebandy LIKE '$code_bastebandy'";
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.code_kala.focus();">
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
<table width="95%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>';
	echo'
    <tr class="tr1" style="height:45px;">	
     <td align="left"> از تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
     <td align="left"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> وضعیت نمایش سردخانه های موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='text4'").'</td>
	 <!--<td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right" colspan="3">&nbsp; نمایش اطلاعات سردخانه موقت </td>-->
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
    <!--<tr class="tr1">
	 <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>&nbsp;';
     include('img_helptolid.php');
     echo'
     </td>
	 <td colspan="2">&nbsp;</td>
	</tr>
    <tr class="tr1">	   
     <td align="left"> سال تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	 <td align="left"> ماه تولید :&nbsp;</td><td align="right">'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	 <td align="left"> روز تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
	</tr>-->	
    <tr class="tr1" style="height:40px">
	 <td align="left"> نمایش اطلاعات :&nbsp;</td><td align="right" >'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>		
	 <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right" ><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1" style="height:40px">
     <td align="left"> نوع بسته بندی :&nbsp;</td><td align="right" colspan="3">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","","class='easyui-combobox text4' style=width:100px ").'</td>	 
    </tr>
	<tr class="tr1" style="height:40px">
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
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left" height="40px"> نام استان : </td>
      <td align="right"  colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" style="width:300px;" multiple>';
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
	$Condition="";
    $radif=1;
    if(!$code_kala)  $code_kala=$db->get_from_where("min(code_kala)","mojody_kala","year='$mtActiveYear' AND deleted=0");//اگر کاربر از کد کالا را انتخاب نکرده بود
    if(!$code_kala2) $code_kala2=$db->get_from_where("max(code_kala)","mojody_kala","year='$mtActiveYear' AND deleted=0");//اگر کاربر تا کد کالا را انتخاب نکرده بود
	//تعیین فیلدها براساس نوع نمایش
    IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
    ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
    ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
    ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
	/****************فیلترها روی گزارش******************/
    /******************کد های کالا**********************/
    if(is_array($kalachoice))
    {
      foreach($kalachoice as $key_kala => $kala_val ) {
      $Condition_kala_temp.=" T.code_kala='$kala_val' OR";
      }
      if($kala_val==-1)$Condition_kala.="1=1 OR";
      else $Condition_kala.=" $Condition_kala_temp";
      $lastSpacePosition = strrpos($Condition_kala," ");
      $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
    }
	
	//if($code_kala) $Condition.=" AND code_kala>='$code_kala'";//از کد کالا
    //if($code_kala2) $Condition.=" AND code_kala<='$code_kala2'";//تا کد کالا
	//if($code_tolidkonande)$Condition.=" AND code_tolidkonande='$code_tolidkonande'";//کد تولیدکننده  
	//if($code_karton) $Condition.=" AND code_karton='$code_karton'";//کد کارتن 
	//if($sal_tolid_shamsi) $Condition.=" AND sal_tolid_shamsi='$sal_tolid_shamsi'";//سال  
	//if($mah_tolid_shamsi) $Condition.=" AND mah_tolid_shamsi='$mah_tolid_shamsi'";//ماه 
	//if($rouz_tolid_shamsi) $Condition.=" AND rouz_tolid_shamsi='$rouz_tolid_shamsi'";
    /******************نمایش یا عدم نمایش سردخانه های موقت******************/
    //if($chkmovaghat=='on') $Condition.="";
    //else $Condition.=" AND situation_type=1";
	/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
    if($show_movaghat==1){$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_a.situation_type=1 AND";}
    else if($show_movaghat==2){$Condition_movaghat="";$Condition_movaghat_mj="";}
    else if($show_movaghat==3){$Condition_movaghat="list_sardkhane.situation_type=2 AND ";$Condition_movaghat_mj="";}
	/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
    if($chkactivate=='on') {$Condition.=""; }
    else {$Condition.=" AND list_sardkhane.activate=1";}
   
    if($noe_namayesh==1)$str='(خالص)';
    if($noe_namayesh==2)$str='(ناخالص)';
    if($noe_namayesh==3)$str='(تعداد)';	
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT *,
	   (SELECT name_ostan FROM ostan WHERE ostan.code_ostan=T.code_ostan) AS nameOstan,
	   (SELECT name_anbar FROM list_sardkhane WHERE list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar) AS nameAnbar,
	   (SELECT activate FROM list_sardkhane WHERE list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar) AS activateAnbar,
	   (SELECT name_kala FROM kala WHERE kala.code_kala=T.code_kala) AS nameKala
	   FROM mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan WHERE 1=1 $Condition $Condition_bastebandy AND $Condition_movaghat year='$mtActiveYear' AND deleted=0 AND($Condition_ostan) AND($Condition_anbar) AND($Condition_kala) GROUP BY T.code_ostan,T.code_anbar,code_kala order by nameOstan,nameAnbar,code_kala asc";	 
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
	  echo'
	  <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title"><td colspan="6">وضعیت نمایش ستونها در گزارش '.$str.'</td></tr>
      	<tr class="print_table-title">
		 <td width="10%">مانده موجودی از قبل </td>
	     <td width="10%" >وارده طی دوره</td>
	     <td width="10%" >صادره طی دوره</td>
		 <td width="10%" >تعدیل</td>
		 <td width="10%" >مانده در پایان دوره</td>
	    </tr>   	
		<tr class="print_table-title2">
	     <td><input name="mande_beforPr" type="checkbox" checked ></td>
	     <td><input name="varedePr" type="checkbox" checked ></td>
	     <td><input name="saderePr" type="checkbox" checked ></td>
		 <td><input name="tadilPr" type="checkbox" checked></td>
		 <td><input name="mandePr" type="checkbox" checked ></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
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
	 if($show_movaghat==1) $filter_string.=' بدون اطلاعات سردخانه موقت -';
     else if($show_movaghat==2) $filter_string.=' با اطلاعات سردخانه موقت -';
     else if($show_movaghat==3) $filter_string.=' فقط اطلاعات سردخانه موقت -';
     if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if(is_array($kalachoice))
     {
      if($kala_val==-1)$filter_string.='همه کالاها';
      else $filter_string.=' کالا : ';
      foreach($kalachoice as $key_kala => $kala_val) {
      $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
      $filter_string.=''.$nameKala.'&nbsp;-';
         }
     }
     if($noe_namayesh==1) $filter_string.="نمایش اطلاعات : خالص";
     if($noe_namayesh==2) $filter_string.="نمایش اطلاعات : ناخالص";
     if($noe_namayesh==3) $filter_string.="نمایش اطلاعات : تعداد";
     if($noe_namayesh==4) $filter_string.="نمایش اطلاعات : شانه";
	 IF($code_bastebandy)
	 {		
	   $sharhBastebandy=$db->get_from_where("sharh_bastebandy","bastebandy","code_bastebandy='$code_bastebandy'"); 
	   $filter_string.=' بسته بندی '.$sharhBastebandy.'';
	 }
	 // if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 // if($code_karton) {$filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';}     
	 // if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 // if($mah_tolid_shamsi) {$filter_string.=' ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 // if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  /****************محاسبه مانده از قبل*******************/		  
        $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND deleted=0");     		
		$jameVaderebef=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND T.year='$mtActiveYear' AND (r.noe_tahvil_bar!=9) AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<'$date1'");     
	    $jameSaderebef=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND T.year='$mtActiveYear' AND (h.noe_tahvil_bar!=9) AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");     
		$TadilEzafebef=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=1 AND code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	    $TadilKasrybef=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=2 AND code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	    $mande_az_ghabl=$mojodyAval+$jameVaderebef-$jameSaderebef+$TadilEzafebef-$TadilKasrybef;
	  /****************محاسبات بین دوره*******************/		  
	    $varede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND T.year='$mtActiveYear' AND (r.noe_tahvil_bar!=9) AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");     
	    $sadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND T.year='$mtActiveYear' AND (h.noe_tahvil_bar!=9) AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");     
		$tadil_ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=1 AND code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");     
	    $tadil_kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=2 AND code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");     
	    $mande_payane_dore=$mande_az_ghabl+$varede-$sadere+$tadil_ezafe-$tadil_kasry;//مانده طی دوره انتخاب شده
		if($i++%2)echo'<tr class="print_table-odd">';
        else echo'<tr class="print_table-even">'; 
	    if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
        else $code_a=$row['code_ostan'];
		echo'
	       <td>'.$radif++.'</td>
	       <td>'.$row['code_ostan'].'</td>
	       <td>'.$row['nameOstan'].'</td>
	       <td>'.$row['code_anbar'].'</td>';
		   IF(SuperUser())echo'<td rowspan="'.$rowkala.'">'.$code_a.$row['code_anbar'].'-'.$row['nameAnbar'].'</td>';
		   ELSE echo'<td>'.$row['nameAnbar'].'</td>';
		   echo'
		   <td>'.$activateArr[$row['activateAnbar']].'</td>
		   <td>'.$row['code_kala'].'</td>
	       <td>'.$row['nameKala'].'</td>
	       <td class="mande_beforPr">'.round($mande_az_ghabl,3).'</td>
	       <td class="varedePr">'.round($varede,3).'</td>
	       <td class="saderePr">'.round($sadere,3).'</td>
	       <td class="tadilPr">'.round($tadil_ezafe,3).'</td>
	       <td class="tadilPr">'.round($tadil_kasry,3).'</td>
	       <td class="mandePr">'.round($mande_payane_dore,3).'</td>';
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
	   $sum_mande_az_ghabl+=$mande_az_ghabl;
	   $sum_jameVadere+=$varede;
	   $sum_jameSadere+=$sadere;
	   $sum_TadilEzafe+=$tadil_ezafe;
	   $sum_TadilKasry+=$tadil_kasry;
	   $sum_mande_payane_dore+=$mande_payane_dore;
	  }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="8">جمع کل ('.$sum_str.')</td>';
	   IF(($noe_namayesh==1)OR($noe_namayesh==2))//در حالت خالص ,ناخالص
	   {
	    echo'
	    <td class="mande_beforPr">'.round($sum_mande_az_ghabl,3).'</td>
	    <td class="varedePr">'.round($sum_jameVadere,3).'</td>
	    <td class="saderePr">'.round($sum_jameSadere,3).'</td>
	    <td class="tadilPr">'.round($sum_TadilEzafe,3).'</td>
	    <td class="tadilPr">'.round($sum_TadilKasry,3).'</td>
	    <td class="mandePr">'.round($sum_mande_payane_dore,3).'</td>';
	   }
	   IF(($noe_namayesh==3)OR($noe_namayesh==4))//در حالت کارتن
	   {
	    echo'
	    <td class="mande_beforPr">'.virgul($sum_mande_az_ghabl).'</td>
	    <td class="varedePr">'.virgul($sum_jameVadere).'</td>
	    <td class="saderePr">'.virgul($sum_jameSadere).'</td>
	    <td class="tadilPr">'.virgul($sum_TadilEzafe).'</td>
	    <td class="tadilPr">'.virgul($sum_TadilKasry).'</td>
	    <td class="mandePr">'.virgul($sum_mande_payane_dore).'</td>';
	   }
	  echo'
	  </tr>
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
      });  	  
});
</script> 