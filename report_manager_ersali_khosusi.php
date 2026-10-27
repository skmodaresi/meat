<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_ersali_khosusi.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش مجوز های جابه جایی جایگزینی با بخش خصوصی';
require_once('head.html');
$columns='<tr class="print_table-title2">
	       <td width="5%">ردیف</td>
	       <td width="6%">استان</td>
	       <td width="9%">سردخانه</td>
	       <td width="10%">شماره مجوز جابه جایی</td>
	       <td width="5%">تاریخ</td>
	       <td width="5%">کد مشتری</td>
	       <td width="12%">مشتری</td>
		   <td width="12%">کالا</td>
		   <td width="5%">بسته بندی</td>
	       <td width="10%">مقدار مجوز</td>
	       <td width="8%">مقدار تحویلی</td>
	       <td width="5%">مقدار باطله</td>
	       <td width="8%">مقدار مانده</td>
	     </tr>';
/****************هدر******************/
Function print_header()
{global $titr,$mt_gl_owner,$code_kala,$code_kala2,$date1,$date2,$FileName,$page;
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
	</tr> ';
}
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
	<tr><td colspan="4" class="title">'.$titr.'</td></tr>
	<tr class="tr1" style="height:45px;">	
     <td align="left" width=""> از تاریخ مجوز :&nbsp;</td><td align="right" ><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom"  placeholder="'.$date1.'"/></td>
     <td align="left" width=""> تا تاریخ مجوز :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto"  placeholder="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
     <td align="left"> تعداد استان در صفحه : </td><td align="right" >&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">
     <td align="left" height="40px">نام کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="kalachoice[]" class="easyui-combobox" style="width:330px;" multiple>';
	  $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']."</option>";
	  echo $kala_options;
	  echo'
	  </select>
	 </td>
	</tr>
	';
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1"> 
	  <td align="left" height="40px">استان مبدأ : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" style="width:330px;" multiple>';
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
/****************فیلترها روی گزارش******************/
/******************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $ostan_val) 
      {
       $Condition_ostan_temp.=" ostan.code_ostan='$ostan_val' OR";
      }
      if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{$Condition_ostan=' ostan.code_ostan='.$_SESSION['mt_code_ostan'].'';}
/////////////////////////////////////////////////////////////////
//کد های کالا
if(is_array($kalachoice))
{
foreach($kalachoice as $key_kala => $kala_val ) {
  $Condition_kala_temp.=" T.code_kala='$kala_val' OR";
 }
  if($kala_val==-1)$Condition_kala.="1=1 OR";
  if($kala_val==-1)$Condition_kala.="";
  //else $Condition_kala.=" AND $Condition_kala_temp";
  else $Condition_kala.=" $Condition_kala_temp";
 $lastSpacePosition = strrpos($Condition_kala," ");
 $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
}
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; }
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND"; }
//تاریخ
$Condition="AND tarikh_jabejae BETWEEN '$date1' AND '$date2'";
$radif=1;
/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	//استانهایی که مجوز جابه جایی به انبار موقت دارند را نمایش می دهیم

	$q="SELECT ostan.* FROM ostan INNER JOIN mojavez_jabejae T ON T.code_ostan=ostan.code_ostan INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar WHERE $Condition_anbar_activate noe_mojavez=4 AND T.year=$mtActiveYear  $Condition AND($Condition_ostan) AND($Condition_kala) GROUP BY ostan.code_ostan ORDER BY name_ostan";
	//echo $q;
	$res=$db->query($q);
	$cntr=mysql_num_rows($res);
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
	 if(is_array($kalachoice))
	 {
	  if($kala_val==-1)$filter_string2='همه کالاها';
	  else $filter_string2=' کالا : ';
	  foreach($kalachoice as $key_kala => $kala_val) {
	  $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
	  $filter_string2.=''.$nameKala.'&nbsp;';
      }
	 }
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string. $filter_string2.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))//ostan while
	 {
	  $line++;
	  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","$Condition_anbar_activate list_sardkhane.code_ostan=".$row['code_ostan']." AND code_anbar IN(select code_anbar from mojavez_jabejae T where code_ostan=".$row['code_ostan']." AND year=$mtActiveYear AND noe_mojavez=4 $Condition AND($Condition_kala))");//تعداد انبارهای هر استان 
	  else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","$Condition_anbar_activate user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." AND list_sardkhane.code_anbar IN(select code_anbar from mojavez_jabejae T where code_ostan=".$row['code_ostan']." AND year=$mtActiveYear AND noe_mojavez=4 $Condition AND($Condition_kala))");//تعداد انبارهای هر استان     
	  $rowanbar=$tedadanbar;
	  $t=$rowanbar; 
	  $tedadmojavez_ostan=$db->get_from_where("COUNT(*)","mojavez_jabejae T INNER JOIN kala USING (code_kala) INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar","$Condition_anbar_activate T.code_ostan=".$row['code_ostan']." AND year=$mtActiveYear AND noe_mojavez=4 $Condition AND($Condition_kala)");
	  $ostanspan=$tedadmojavez_ostan+($rowanbar*3);
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		 <td rowspan="'.$ostanspan.'">'.$radif++.'</td>
	     <td rowspan="'.$ostanspan.'" style="font-weight:bold">'.$row['name_ostan'].'</td>';
		 if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT list_sardkhane.* FROM list_sardkhane INNER JOIN mojavez_jabejae T ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar INNER JOIN kala ON kala.code_kala=T.code_kala WHERE $Condition_anbar_activate noe_mojavez=4 AND list_sardkhane.code_ostan=".$row['code_ostan']." AND T.year=$mtActiveYear $Condition AND($Condition_kala) GROUP BY list_sardkhane.code_anbar ORDER BY name_anbar";
		 else $q2="SELECT list_sardkhane.* FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar INNER JOIN mojavez_jabejae T ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar WHERE $Condition_anbar_activate noe_mojavez=4 AND list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." AND T.year=$mtActiveYear $Condition AND($Condition_kala) GROUP BY list_sardkhane.code_anbar ORDER BY name_anbar ";
		 $res2=$db->query($q2);
		 $jame_meghdar_jabejae_per_ostan_kartoni=0;
		 $jame_meghdar_tahvily_j_per_ostan_kartoni=0;
		 $jame_maghadir_batele_j_per_ostan_kartoni=0;
		 $jame_mande_az_jabejae_per_ostan_kartoni=0;
		 $jame_meghdar_jabejae_per_ostan_ghoti=0;
		 $jame_meghdar_tahvily_j_per_ostan_ghoti=0;
		 $jame_maghadir_batele_j_per_ostan_ghoti=0;
		 $jame_mande_az_jabejae_per_ostan_ghoti=0;
		 while($row2=$db->fetch_assoc($res2))//حلقه انبارها
		 {	   
		  $j=$i+1;
	      $tedadmojavez_anbar=$db->get_from_where("COUNT(*)","mojavez_jabejae T INNER JOIN kala USING (code_kala) INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar","$Condition_anbar_activate T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND year=$mtActiveYear AND noe_mojavez=4 $Condition AND($Condition_kala)");
		  $t2=$tedadmojavez_anbar;
		  echo'
		     <td rowspan="'.$tedadmojavez_anbar.'">'.$row2['name_anbar'].'</td>';
			 $q3="SELECT * FROM mojavez_jabejae T INNER JOIN kala USING (code_kala) INNER JOIN bastebandy USING (code_bastebandy)  WHERE noe_mojavez=4 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year=$mtActiveYear $Condition AND($Condition_kala) ORDER BY tarikh_jabejae";
			 //echo $q3;
			 $res3=$db->query($q3);
		     $jame_meghdar_jabejae_per_anbar_kartoni=0;
			 $jame_meghdar_tahvily_j_per_anbar_kartoni=0;
			 $jame_maghadir_batele_j_per_anbar_kartoni=0;
			 $jame_mande_az_jabejae_per_anbar_kartoni=0;
			 $jame_meghdar_jabejae_per_anbar_shane=0;
			 $jame_meghdar_tahvily_j_per_anbar_shane=0;
			 $jame_maghadir_batele_j_per_anbar_shane=0;
			 $jame_mande_az_jabejae_per_anbar_shane=0;
			 $jame_meghdar_jabejae_per_anbar_ghoti=0;
			 $jame_meghdar_tahvily_j_per_anbar_ghoti=0;
			 $jame_maghadir_batele_j_per_anbar_ghoti=0;
			 $jame_mande_az_jabejae_per_anbar_ghoti=0;
			 
			 while($row3=$db->fetch_assoc($res3))//حلقه روی مجوز جابه جایی 
             {			  		     
			  $k=$i+1;
			  //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	          $meghdar_tahvily_j=tahvily_az_jabejae($row3['shomare_jabejae'],$row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_bastebandy'],$row3['code_kala']);
              //محاسبه مقادیر باطله مجوز جابه جایی با استفاده از تابع
	          $maghadir_batele_j=batele_jabejae($row3['shomare_jabejae'],$row3['code_ostan'],$row3['code_anbar'],$row3['year']);
			  //مشتری از سیستم فروش
			  $name_customer=$db->get_from_where("name_customer","sell.dm_customer_asli","code_customer=".$row3['code_customer']."");  

			  echo'<td>'.$row3['shomare_jabejae'].'</td>
			  <td>'.$row3['tarikh_jabejae'].'</td>
			  <td>'.$row3['code_customer'].'</td>
			  <td>'.$name_customer.'</td>
			  <td>'.$row3['name_kala'].'</td>
			  <td>'.$row3['sharh_bastebandy'].'</td>
			  <td>'.round($row3['meghdar_jabejae'],3).'</td>
			  <td>'.round($meghdar_tahvily_j,3).'</td>
			  <td>'.round($maghadir_batele_j,3).'</td>
			  <td>'.round($row3['mande_az_jabejae'],3).'</td>';
			   $t2--;
			   if($t2==0) echo'';
			   else 
			   {
			    echo'</tr>';
			    if($k++%2)echo'<tr class="print_table-odd">';
                else echo'<tr class="print_table-even">';
			   }
			   IF($row3['code_bastebandy']==1)//کارتن
			   {
				IF(($row3['code_kala']==50)OR($row3['code_kala']==54))//تخم مرغ خوراکی
				{
				 $jame_meghdar_jabejae_per_anbar_shane+=$row3['meghdar_jabejae'];
			     $jame_meghdar_tahvily_j_per_anbar_shane+=$meghdar_tahvily_j;
			     $jame_maghadir_batele_j_per_anbar_shane+=$maghadir_batele_j;
			     $jame_mande_az_jabejae_per_anbar_shane+=$row3['mande_az_jabejae']; 
				}
				ELSE
				{
				 $jame_meghdar_jabejae_per_anbar_kartoni+=$row3['meghdar_jabejae'];
			     $jame_meghdar_tahvily_j_per_anbar_kartoni+=$meghdar_tahvily_j;
			     $jame_maghadir_batele_j_per_anbar_kartoni+=$maghadir_batele_j;
			     $jame_mande_az_jabejae_per_anbar_kartoni+=$row3['mande_az_jabejae'];	
				}	
			   }
			   ELSE IF($row3['code_bastebandy']==2)//قوطی
			   {$jame_meghdar_jabejae_per_anbar_ghoti+=$row3['meghdar_jabejae'];
			    $jame_meghdar_tahvily_j_per_anbar_ghoti+=$meghdar_tahvily_j;
			    $jame_maghadir_batele_j_per_anbar_ghoti+=$maghadir_batele_j;
			    $jame_mande_az_jabejae_per_anbar_ghoti+=$row3['mande_az_jabejae'];
			   }
			   
			  }//END while mojavez
 			  //سطر جمع موجودی هر کالا در هر انبار
			  echo'
			  <tr class="print_table-even sum-row" style="background-color:#FFF;">
			   <td colspan="7">جمع '.$row2['name_anbar'].' (کیلوگرم)</td>
			   <td>'.round($jame_meghdar_jabejae_per_anbar_kartoni,3).'</td>
			   <td>'.round($jame_meghdar_tahvily_j_per_anbar_kartoni,3).'</td>
			   <td>'.round($jame_maghadir_batele_j_per_anbar_kartoni,3).'</td>
			   <td>'.round($jame_mande_az_jabejae_per_anbar_kartoni,3).'</td>
			  </tr>
			  <tr class="print_table-even sum-row" style="background-color:#FFF;">
			   <td colspan="7">جمع '.$row2['name_anbar'].' (تعداد شانه)</td>
			   <td>'.virgul($jame_meghdar_jabejae_per_anbar_shane).'</td>
			   <td>'.virgul($jame_meghdar_tahvily_j_per_anbar_shane).'</td>
			   <td>'.virgul($jame_maghadir_batele_j_per_anbar_shane).'</td>
			   <td>'.virgul($jame_mande_az_jabejae_per_anbar_shane).'</td>
			  </tr>
			  <tr class="print_table-even sum-row" style="background-color:#FFF;">
			   <td colspan="7">جمع '.$row2['name_anbar'].' (تعداد قوطی)</td>
			   <td>'.virgul($jame_meghdar_jabejae_per_anbar_ghoti).'</td>
			   <td>'.virgul($jame_meghdar_tahvily_j_per_anbar_ghoti).'</td>
			   <td>'.virgul($jame_maghadir_batele_j_per_anbar_ghoti).'</td>
			   <td>'.virgul($jame_mande_az_jabejae_per_anbar_ghoti).'</td>
			  </tr>';
			  $t--;
			  if($t==0) echo'';
			  else 
			  {
			   echo'</tr>';
			   if($j++%2)echo'<tr class="print_table-odd">';
               else echo'<tr class="print_table-even">';
			  }
			  $jame_meghdar_jabejae_per_ostan_kartoni+=$jame_meghdar_jabejae_per_anbar_kartoni;
			  $jame_meghdar_tahvily_j_per_ostan_kartoni+=$jame_meghdar_tahvily_j_per_anbar_kartoni;
			  $jame_maghadir_batele_j_per_ostan_kartoni+=$jame_maghadir_batele_j_per_anbar_kartoni;
			  $jame_mande_az_jabejae_per_ostan_kartoni+=$jame_mande_az_jabejae_per_anbar_kartoni;
			  $jame_meghdar_jabejae_per_ostan_shane+=$jame_meghdar_jabejae_per_anbar_shane;
			  $jame_meghdar_tahvily_j_per_ostan_shane+=$jame_meghdar_tahvily_j_per_anbar_shane;
			  $jame_maghadir_batele_j_per_ostan_shane+=$jame_maghadir_batele_j_per_anbar_shane;
			  $jame_mande_az_jabejae_per_ostan_shane+=$jame_mande_az_jabejae_per_anbar_shane;
			  $jame_meghdar_jabejae_per_ostan_ghoti+=$jame_meghdar_jabejae_per_anbar_ghoti;
			  $jame_meghdar_tahvily_j_per_ostan_ghoti+=$jame_meghdar_tahvily_j_per_anbar_ghoti;
			  $jame_maghadir_batele_j_per_ostan_ghoti+=$jame_maghadir_batele_j_per_anbar_ghoti;
			  $jame_mande_az_jabejae_per_ostan_ghoti+=$jame_mande_az_jabejae_per_anbar_ghoti;
		   }//END anbar while
		   /*****سطر جمع کل استان*****/
		   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
		   { 
	        echo'
		    <tr class="print_table-even sum-row" style="background-color:#FFF;">
		     <td colspan="9" >جمع کل استان (کیلوگرم)</td>
			 <td>'.round($jame_meghdar_jabejae_per_ostan_kartoni,3).'</td>
			 <td>'.round($jame_meghdar_tahvily_j_per_ostan_kartoni,3).'</td>
			 <td>'.round($jame_maghadir_batele_j_per_ostan_kartoni,3).'</td>
			 <td>'.round($jame_mande_az_jabejae_per_ostan_kartoni,3).'</td>	
		    </tr>';
			echo'
		    <tr class="print_table-even sum-row" style="background-color:#FFF;">
		     <td colspan="9" >جمع کل استان (تعداد شانه)</td>
			 <td>'.virgul($jame_meghdar_jabejae_per_ostan_shane).'</td>
			 <td>'.virgul($jame_meghdar_tahvily_j_per_ostan_shane).'</td>
			 <td>'.virgul($jame_maghadir_batele_j_per_ostan_shane).'</td>
			 <td>'.virgul($jame_mande_az_jabejae_per_ostan_shane).'</td>	
		    </tr>';
		    echo'
		    <tr class="print_table-even sum-row" style="background-color:#FFF;">
		     <td colspan="9" >جمع کل استان (تعداد قوطی)</td>
			 <td>'.virgul($jame_meghdar_jabejae_per_ostan_ghoti).'</td>
			 <td>'.virgul($jame_meghdar_tahvily_j_per_ostan_ghoti).'</td>
			 <td>'.virgul($jame_maghadir_batele_j_per_ostan_ghoti).'</td>
			 <td>'.virgul($jame_mande_az_jabejae_per_ostan_ghoti).'</td>	
		    </tr>';
			$jame_meghdar_jabejae_ostanha_kartoni+=$jame_meghdar_jabejae_per_ostan_kartoni;
		   	$jame_meghdar_tahvily_j_ostanha_kartoni+=$jame_meghdar_tahvily_j_per_ostan_kartoni;
		   	$jame_maghadir_batele_j_ostanha_kartoni+=$jame_maghadir_batele_j_per_ostan_kartoni;
		   	$jame_mande_az_jabejae_ostanha_kartoni+=$jame_mande_az_jabejae_per_ostan_kartoni;
		   	$jame_meghdar_jabejae_ostanha_shane+=$jame_meghdar_jabejae_per_ostan_shane;
		   	$jame_meghdar_tahvily_j_ostanha_shane+=$jame_meghdar_tahvily_j_per_ostan_shane;
		   	$jame_maghadir_batele_j_ostanha_shane+=$jame_maghadir_batele_j_per_ostan_shane;
		   	$jame_mande_az_jabejae_ostanha_shane+=$jame_mande_az_jabejae_per_ostan_shane;
			$jame_meghdar_jabejae_ostanha_ghoti+=$jame_meghdar_jabejae_per_ostan_ghoti;
		   	$jame_meghdar_tahvily_j_ostanha_ghoti+=$jame_meghdar_tahvily_j_per_ostan_ghoti;
		   	$jame_maghadir_batele_j_ostanha_ghoti+=$jame_maghadir_batele_j_per_ostan_ghoti;
		   	$jame_mande_az_jabejae_ostanha_ghoti+=$jame_mande_az_jabejae_per_ostan_ghoti;
		   }
		   //اگر دسترسی به تمام استان ها ندارد
		   else
		   {
		    echo'
		    <tr class="print_table-even sum-row" style="background-color:#FFF;">
		     <td colspan="9">جمع کل (کیلوگرم)</td>
			  <td>'.round($jame_meghdar_jabejae_per_ostan_kartoni,3).'</td>
			  <td>'.round($jame_meghdar_tahvily_j_per_ostan_kartoni,3).'</td>
			  <td>'.round($jame_maghadir_batele_j_per_ostan_kartoni,3).'</td>
			  <td>'.round($jame_mande_az_jabejae_per_ostan_kartoni,3).'</td>		
		    </tr>
			<td colspan="9">جمع کل (تعداد شانه)</td>
			  <td>'.virgul($jame_meghdar_jabejae_per_ostan_shane).'</td>
			  <td>'.virgul($jame_meghdar_tahvily_j_per_ostan_shane).'</td>
			  <td>'.virgul($jame_maghadir_batele_j_per_ostan_shane).'</td>
			  <td>'.virgul($jame_mande_az_jabejae_per_ostan_shane).'</td>		
		    </tr>
			<tr class="print_table-even sum-row" style="background-color:#FFF;">
		     <td colspan="9">جمع کل (تعداد قوطی)</td>
			  <td>'.virgul($jame_meghdar_jabejae_per_ostan_ghoti).'</td>
			  <td>'.virgul($jame_meghdar_tahvily_j_per_ostan_ghoti).'</td>
			  <td>'.virgul($jame_maghadir_batele_j_per_ostan_ghoti).'</td>
			  <td>'.virgul($jame_mande_az_jabejae_per_ostan_ghoti).'</td>		
		    </tr>';
		   }
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
	 }//END FIRST while,ostan while
	//اگر همه استانها انتخاب شده است $ostan_val==-1
    if((($_SESSION['mt_all_ostan']==1)or(SuperUser()))and($ostan_val==-1))
	{
	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" >
	  <td colspan="9">جمع کل استان ها(کیلوگرم)</td>
	   <td>'.round($jame_meghdar_jabejae_ostanha_kartoni,3).'</td>
	   <td>'.round($jame_meghdar_tahvily_j_ostanha_kartoni,3).'</td>
	   <td>'.round($jame_maghadir_batele_j_ostanha_kartoni,3).'</td>
	   <td>'.round($jame_mande_az_jabejae_ostanha_kartoni,3).'</td>
	 </tr>';
	 echo'
	 <tr class="print_table-even sum-row" >
	  <td colspan="9">جمع کل استان ها(تعداد شانه)</td>
	   <td>'.virgul($jame_meghdar_jabejae_ostanha_shane).'</td>
	   <td>'.virgul($jame_meghdar_tahvily_j_ostanha_shane).'</td>
	   <td>'.virgul($jame_maghadir_batele_j_ostanha_shane).'</td>
	   <td>'.virgul($jame_mande_az_jabejae_ostanha_shane).'</td>
	 </tr>';
	 echo'
	 <tr class="print_table-even sum-row" >
	  <td colspan="9">جمع کل استان ها(تعداد قوطی)</td>
	   <td>'.virgul($jame_meghdar_jabejae_ostanha_ghoti).'</td>
	   <td>'.virgul($jame_meghdar_tahvily_j_ostanha_ghoti).'</td>
	   <td>'.virgul($jame_maghadir_batele_j_ostanha_ghoti).'</td>
	   <td>'.virgul($jame_mande_az_jabejae_ostanha_ghoti).'</td>
	 </tr>';
	 }
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
<script type="text/javascript" src="scripts/elevator.min.js"></script>