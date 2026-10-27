<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_detail.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش موجودی سردخانه ها با جزئیات';
require_once('head.html');
if($noe_namayesh==1)$str='(خالص)';
if($noe_namayesh==2)$str='(ناخالص)';
if($noe_namayesh==3)$str='(تعداد)';
ELSE IF($noe_namayesh==4)$str='(شانه)';
$columns='
	<tr class="print_table-title2" style="height:70px;">
	   <td rowspan="2" width=5%>ردیف</td>
	   <td rowspan="2" width=5%>استان</td>
	   <td rowspan="2" width=5%>سردخانه</td>
	   <td rowspan="2" width=10%>نام کالا</td>
	   <td colspan="3" width=10%>تاریخ تولید</td>
	   <td rowspan="2" width=5%>تولیدکننده</td>
	   <td rowspan="2" width=5%>تاریخ ماندگاری</td>
	   <td rowspan="2" width=9%>موجودی اول دوره '.$str.'</td>
	   <td rowspan="2" width=9%>وارده طی دوره '.$str.'</td>
	   <td rowspan="2" width=9%>صادره طی دوره '.$str.'</td>
	   <td colspan="2" width=9%>تعدیل '.$str.'</td>
	   <td rowspan="2" width=9%>مانده در پایان دوره '.$str.'</td> 
	</tr>
	<tr class="print_table-title2">
	 <td>سال</td>
	 <td>ماه</td>
	 <td>روز</td>
	 <td>اضافه</td>
	 <td>کسری</td>
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
       <tr class="noExl"><td class="print_title_2">از تاریخ : '.$date1.' تا تاریخ : '.$date2.'</td></tr>
	   <tr class="noExl">
	    <td class="print_title_2">';
	    IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
          echo'
         از کد کالای : '.$code_kala.' تا کد کالای : '.$code_kala2.'&nbsp&nbsp(صفحه : '.$page.')
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
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
	 $Condition_anbar_ebtal_sell.="  $Condition_anbar_ebtal_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $lastSpacePosition_ebtal_sell = strrpos($Condition_anbar_ebtal_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
     $Condition_anbar_ebtal_sell =substr($Condition_anbar_ebtal_sell,0,$lastSpacePosition_ebtal_sell);
}
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
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
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
     <td align="left">از کد کالا :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
     include ("img_helpkala.php");
	 echo'
	 </td>
	 <td align="left">تا کد کالا :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" name="code_kala2" value="'.$code_kala2.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>
	 	   	   <img border="0" src="images/help.png" onClick="window.open(\'help_kala.php?inputName=code_kala2\',\'_blank\',\'width=400px,left=500px,top=100px,scrollbars=yes\')" title="جدول کد کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>&nbsp;';
     include('img_helptolid.php');
     echo'
     </td>
     <td align="left"> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","","class='easyui-combobox text4' style=width:100px ").'</td>	 
	</tr>
    <tr class="tr1">	   
     <td align="left"> سال تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	 <td align="left"> ماه تولید :&nbsp;</td><td align="right">'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	</tr>	
	<tr class="tr1">
	 <td align="left"> روز تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
	 <td align="left"> نمایش اطلاعات :&nbsp;</td><td align="right">'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>	
    </tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right" colspan="3">&nbsp; نمایش اطلاعات سردخانه موقت </td>
	</tr>
    <tr class="tr1">	
     <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	 <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right" ><input type="text" class="textboxme2 textbox50" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left" height="40px"> نام استان : </td>
      <td align="right"  colspan="3">
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
	if($code_kala) $Condition.=" AND code_kala>='$code_kala'";//از کد کالا
    if($code_kala2) $Condition.=" AND code_kala<='$code_kala2'";//تا کد کالا
	if($code_tolidkonande)$Condition.=" AND code_tolidkonande='$code_tolidkonande'";//کد تولیدکننده  
	if($code_karton) $Condition.=" AND code_karton='$code_karton'";//کد کارتن 
	if($sal_tolid_shamsi) $Condition.=" AND sal_tolid_shamsi='$sal_tolid_shamsi'";//سال  
	if($mah_tolid_shamsi) $Condition.=" AND mah_tolid_shamsi='$mah_tolid_shamsi'";//ماه 
	if($rouz_tolid_shamsi) $Condition.=" AND rouz_tolid_shamsi='$rouz_tolid_shamsi'";//روز
    /******************نمایش یا عدم نمایش سردخانه های موقت******************/
    if($chkmovaghat=='on') $Condition.="";
    else $Condition.=" AND situation_type=1";
	/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
    if($chkactivate=='on') {$Condition.=""; }
    else {$Condition.=" AND list_sardkhane.activate=1";}
    /******************بسته بندی******************/
    if($code_bastebandy)   $Condition_bastebandy.=" AND code_bastebandy LIKE '$code_bastebandy'";
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT *,
	   (SELECT name_ostan FROM ostan WHERE ostan.code_ostan=T.code_ostan)nameOstan,
	   (SELECT name_anbar FROM list_sardkhane WHERE list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar)nameAnbar,
	   (SELECT name_kala FROM kala WHERE kala.code_kala=T.code_kala)nameKala,
	   (SELECT name_tolidkonande FROM tolidkonande WHERE tolidkonande.code_tolidkonande=T.code_tolidkonande)nameTolidkonande,
	   (SELECT sharh_mandegari FROM tarikh_mandegari WHERE tarikh_mandegari.code_mandegari=T.code_mandegari)sharhMandegari
	   FROM mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan WHERE 1=1 $Condition $Condition_bastebandy AND year='$mtActiveYear' AND deleted=0 AND($Condition_ostan) AND($Condition_anbar) order by nameOstan,nameAnbar,nameKala,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,nameTolidkonande asc";	 

	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
	 echo'<div class="table2excel">';
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
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_karton) {$filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';}     
	 if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if($mah_tolid_shamsi) {$filter_string.=' ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
     IF($code_bastebandy)
	 {		
	   $sharhBastebandy=$db->get_from_where("sharh_bastebandy","bastebandy","code_bastebandy='$code_bastebandy'"); 
	   $filter_string.=' بسته بندی '.$sharhBastebandy.'';
	 }
	 
	 //if(($code_tolidkonande)or($code_karton)or($sal_tolid_shamsi)or($mah_tolid_shamsi)or($rouz_tolid_shamsi))
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  /****************محاسبه مانده از قبل*******************/		  
        $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_ziranbar=".$row['code_ziranbar']." AND code_mandegari='".$row['code_mandegari']."' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND deleted=0");     
        $jameVaderebef=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_kala=".$row['code_kala']." AND T.code_keshvar=".$row['code_keshvar']." AND T.code_tolidkonande=".$row['code_tolidkonande']." AND T.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND T.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND T.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND T.code_karton=".$row['code_karton']." AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_mandegari='".$row['code_mandegari']."' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<'$date1'");     
	    $jameSaderebef=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_kala=".$row['code_kala']." AND T.code_keshvar=".$row['code_keshvar']." AND T.code_tolidkonande=".$row['code_tolidkonande']." AND T.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND T.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND T.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND T.code_karton=".$row['code_karton']." AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_mandegari='".$row['code_mandegari']."' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");     
		$TadilEzafebef=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=1 AND T.code_kala=".$row['code_kala']." AND T.code_keshvar=".$row['code_keshvar']." AND T.code_tolidkonande=".$row['code_tolidkonande']." AND T.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND T.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND T.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND T.code_karton=".$row['code_karton']." AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_mandegari='".$row['code_mandegari']."' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	    $TadilKasrybef=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=2 AND T.code_kala=".$row['code_kala']." AND T.code_keshvar=".$row['code_keshvar']." AND T.code_tolidkonande=".$row['code_tolidkonande']." AND T.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND T.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND T.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND T.code_karton=".$row['code_karton']." AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_mandegari='".$row['code_mandegari']."' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	    $mande_az_ghabl=$mojodyAval+$jameVaderebef-$jameSaderebef+$TadilEzafebef-$TadilKasrybef;
	  /****************محاسبات بین دوره*******************/		  
	    $varede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_kala=".$row['code_kala']." AND T.code_keshvar=".$row['code_keshvar']." AND T.code_tolidkonande=".$row['code_tolidkonande']." AND T.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND T.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND T.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND T.code_karton=".$row['code_karton']." AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_mandegari='".$row['code_mandegari']."' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");     
	    $sadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_kala=".$row['code_kala']." AND T.code_keshvar=".$row['code_keshvar']." AND T.code_tolidkonande=".$row['code_tolidkonande']." AND T.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND T.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND T.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND T.code_karton=".$row['code_karton']." AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_mandegari='".$row['code_mandegari']."' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");     
		$tadil_ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=1 AND T.code_kala=".$row['code_kala']." AND T.code_keshvar=".$row['code_keshvar']." AND T.code_tolidkonande=".$row['code_tolidkonande']." AND T.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND T.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND T.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND T.code_karton=".$row['code_karton']." AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_mandegari='".$row['code_mandegari']."' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");     
	    $tadil_kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=2 AND T.code_kala=".$row['code_kala']." AND T.code_keshvar=".$row['code_keshvar']." AND T.code_tolidkonande=".$row['code_tolidkonande']." AND T.sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND T.mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND T.rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND T.code_karton=".$row['code_karton']." AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_mandegari='".$row['code_mandegari']."' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");     
		$mande_payane_dore=$mande_az_ghabl+$varede-$sadere+$tadil_ezafe-$tadil_kasry;//مانده طی دوره انتخاب شده
        if($i++%2)echo'<tr class="print_table-odd">';
        else echo'<tr class="print_table-even">'; 
	    echo'
	       <td>'.$radif++.'</td>
	       <td>'.$row['nameOstan'].'</td>
	       <td>'.$row['nameAnbar'].'</td>
	       <td>'.$row['nameKala'].'</td>
	       <td>'.$row['sal_tolid_shamsi'].'</td>
	       <td>'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
	       <td>'.$row['rouz_tolid_shamsi'].'</td>
		   <td>'.$row['nameTolidkonande'].'</td>
		   <td>'.$row['sharhMandegari'].'</td>';
	       IF(($noe_namayesh==1)OR($noe_namayesh==2))//در حالت خالص و ناخالص
	       {
		    echo'
	        <td>'.round($mande_az_ghabl,3).'</td>
	        <td>'.round($varede,3).'</td>
	        <td>'.round($sadere,3).'</td>
	        <td>'.round($tadil_ezafe,3).'</td>
	        <td>'.round($tadil_kasry,3).'</td>
	        <td>'.round($mande_payane_dore,3).'</td>';
		   }//END khales
		   IF(($noe_namayesh==3)OR($noe_namayesh==4))//در حالت تعداد و شانه
	   	   {
			echo'
		    <td>'.virgul($mande_az_ghabl).'</td>
	        <td>'.virgul($varede).'</td>
	        <td>'.virgul($sadere).'</td>
	        <td>'.virgul($tadil_ezafe).'</td>
	        <td>'.virgul($tadil_kasry).'</td>
	        <td>'.virgul($mande_payane_dore).'</td>';  
		   }
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
	   $sum_jameKhalesVadere+=$varede;
	   $sum_jameKhalesSadere+=$sadere;
	   $sum_khalesTadilEzafe+=$tadil_ezafe;
	   $sum_khalesTadilKasry+=$tadil_kasry;
	   $sum_mande_payane_dore+=$mande_payane_dore;
	  }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="9">جمع مقادیر</td>';
	   IF(($noe_namayesh==1)OR($noe_namayesh==2))//در حالت خالص ,ناخالص
	   {
	    echo'
	    <td>'.round($sum_mande_az_ghabl,3).'</td>
	    <td>'.round($sum_jameKhalesVadere,3).'</td>
	    <td>'.round($sum_jameKhalesSadere,3).'</td>
	    <td>'.round($sum_khalesTadilEzafe,3).'</td>
	    <td>'.round($sum_khalesTadilKasry,3).'</td>
	    <td>'.round($sum_mande_payane_dore,3).'</td>';
	   }
	   IF(($noe_namayesh==3)OR($noe_namayesh==4))//در حالت کارتن
	   {
	    echo'
	    <td>'.virgul($sum_mande_az_ghabl).'</td>
	    <td>'.virgul($sum_jameKartonVadere).'</td>
	    <td>'.virgul($sum_jameKartonSadere).'</td>
	    <td>'.virgul($sum_kartonTadilEzafe).'</td>
	    <td>'.virgul($sum_kartonTadilKasry).'</td>
	    <td>'.virgul($sum_mande_payane_dore).'</td>';
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