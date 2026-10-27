<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_kharid_rozane_morgh.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش روزانه خرید مرغ داخلی';
require_once('head.html');
if($noe_namayesh==1)$str='(خالص)';
if($noe_namayesh==2)$str='(ناخالص)';
if($noe_namayesh==3)$str='(کارتن)';
$columns='
	<tr class="print_table-title2">
	 <td width=15%>ردیف</td>
	 <td width=15%>استان</td>
	 <!--<td width=15%>قیمت مرغ زنده</td>-->
	 <td width=15%>مقدار خرید مرغ سویه آرین (416)</td>
	 <td width=15%>قیمت واحد</td>
	 <td width=15%>مقدار خرید مرغ منجمد غیرآرین (410-411-412)</td>
	 <td width=15%>قیمت واحد</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$db,$page,$noe_namayesh,$str,$Condition_kala;
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
		 تـاریخ: '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
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
<form method="post" name="myform" onkeydown="enterIE()">';
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
 <table width="95%" align="center" cellpadding="0" cellspacing="0">
 <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
   <td height="100%">
    <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
     <tr class="tr1" style="height:45px;">	
 	  <!--<td align="left" width="110px"> از تاریخ :&nbsp;</td><td align="right" width="220px"><input type="text" class="textboxme2" name="date1" id="datepickerfrom" placeholder="'.$date1.'" maxlength="10"/></td>-->
      <td align="left" width="110px"> تاریخ :&nbsp;</td><td align="right" width="200px" colspan="3"><input type="text" class="textboxme2" name="date2" id="datepickerto" placeholder="'.$date2.'" maxlength="10"/></td>
 	 </tr>
	 <tr class="tr1">
	  <td align="left"> نمایش اطلاعات :&nbsp;</td><td align="right">'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:100").'</td>	
	  <td align="left"> تعداد در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme2 textbox50" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	 </tr>
	 <tr class="tr1">
	  <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت</td>
      <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	 </tr>';
	 if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
     {
	  echo'
	  <tr class="tr1">
	   <td align="left">نام استان :&nbsp;</td>
       <td align="right" colspan="3">
	    <select name="ostanchoice[]" class="easyui-combobox" style="width:330px;" multiple>';
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
 </table>';
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

	/******************نمایش یا عدم نمایش سردخانه های موقت******************/
    if($chkmovaghat=='on') $Condition_movaghat="";
    else $Condition_movaghat="situation_type=1 AND ";
    /******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
    if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";  }
    else {$Condition_anbar_activate="activate=1 AND"; $Condition_anbar_activate_ostan="activate=1"; }
    $page=1;
    $line=0;
    $i=0;
    $radif=1;
/****************شروع نمایش گزارش*******************/        
  /****************شروع نمایش گزارش*******************/	
$radif=1;
$page=1;
$line=0;
$i=0;
$cntr=0;
$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane) AND($Condition_ostan) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
  <div class="table2excel">';
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
 if($noe_namayesh==1) $filter_string.=" نمایش اطلاعات : خالص";
 if($noe_namayesh==2) $filter_string.=" نمایش اطلاعات : ناخالص";
 if($noe_namayesh==3) $filter_string.=" نمایش اطلاعات : تعداد";

 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
 echo $columns; 
   while($row=$db->fetch_array($res))//ostan while
   {	
    $line++;
	if($i++%2)echo'<tr class="print_table-odd">';
    else echo'<tr class="print_table-even">';
    echo'   
    <td>'.$radif++.'</td>
    <td>'.$row['name_ostan'].'</td>';
	   IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';$vahed='کیلوگرم';}
	   ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';$vahed='کیلوگرم';}
	   ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';$vahed='تعداد';}				 
	   ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';$vahed='شانه';}				 
	   $kharid_aryan=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_kala='416' AND (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND resid_deleted=0 AND T.status=0 AND r.tarikh_resid='".$date2."' AND sabt_nahayi=1");
	   $gheymat_vahed_aryan=$db->get_from_where("fee_this","resid_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_kala='416' AND (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND resid_deleted=0 AND T.status=0 AND r.tarikh_resid='".$date2."' AND sabt_nahayi=1 ORDER BY r.id DESC");
	   //echo "select fee_this from resid_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan where $Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND code_kala='416' AND (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND resid_deleted=0 AND T.status=0 AND r.tarikh_resid='".$date2."' AND sabt_nahayi=1 ORDER BY r.id DESC";

	   $kharid_except_aryan=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND (T.code_kala='410' OR T.code_kala='411' OR T.code_kala='412') AND (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND resid_deleted=0 AND T.status=0 AND r.tarikh_resid='".$date2."' AND sabt_nahayi=1");
	   $gheymat_vahed_except_aryan=$db->get_from_where("fee_this","resid_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND (T.code_kala='410' OR T.code_kala='411' OR T.code_kala='412') AND (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND resid_deleted=0 AND T.status=0 AND r.tarikh_resid='".$date2."' AND sabt_nahayi=1 ORDER BY r.id DESC");
	   //echo'<td>-</td>';
	   echo'<td>'.round($kharid_aryan,3).'</td>';
	   echo'<td>'.virgul($gheymat_vahed_aryan).'</td>';
	   echo'<td>'.round($kharid_except_aryan,3).'</td>';
	   echo'<td>'.virgul($gheymat_vahed_except_aryan).'</td>';
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
	  $jame_kharid_aryan+=$kharid_aryan;
	  $jame_kharid_except_aryan+=$kharid_except_aryan;
   }//END ostan while
   /*****سطر جمع کل استان ها*****/
   echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="2">جمع کل</td>';
	   //echo '<td>-</td>';
	   echo'
	   <td>'.round($jame_kharid_aryan,3).'</td>
	   <td>-</td>
	   <td>'.round($jame_kharid_except_aryan,3).'</td>
	   <td>-</td>
	 </tr>';
	 //END
  echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنوس-->';
  require_once('prt-footer.php');
 echo' 
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