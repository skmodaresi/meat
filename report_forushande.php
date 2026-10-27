<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_forushande.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr="گزارش فروشندگان کالا";
require_once('head.html');
$columns='
	<tr class="print_table-title2">
       <td width="10%">ردیف</td>
       <td width="20%">فروشنده/ کشتی</td>
	   <td width="20%">نام کالا</td>
	   <td width="15%">مجموع تعداد دریافتی</td>
	   <td width="20%">مجموع وزن ناخالص دریافتی</td>
	   <td width="15%">مجموع وزن خالص دریافتی</td>

	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$code_kala,$code_anbar,$date1,$date2,$FileName,$nameKala,$page;
 echo'   
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> انبار : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr> 
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
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
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
if(!$MaxLines)$MaxLines=15;
//اضافه کردن صفر پشت کد استان		
if(strlen($mt_gl_code_ostan)==1) {$code_a=make_pattern($mt_gl_code_ostan,2);}
else{$code_a=$mt_gl_code_ostan;}
if(!$ok)
{
 echo'
 <table width="90%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
   <td height="100%">
    <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr>
      <td colspan="4" class="title">'.$titr.'</td>	 
     </tr>
     <tr class="tr1">	
      <td align="left" height="40px"> از تاریخ : &nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ : &nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	 </tr>
     <tr class="tr1">	 
      <td align="left" height="40px">  فروشنده / کشتی: &nbsp;</td>
 	  <td align="right" colspan="3">'.listbox("code_skk",$code_skk,"code_skk","name_skk","mt_skk","1=1 ORDER BY name_skk ASC","class='easyui-combobox text4' style=width:300px ","").'
 	 </tr>
	 <tr class="tr1">
      <td align="left" height="40px"> کد کالا : &nbsp;</td>
      <td align="right" width="36%"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>';
 	  	include ("img_helpkala.php");
	  echo'
	  </td>
	  <td align="left" height="40px"> تعداد خط در صفحه : &nbsp;</td><td align="right" colspan="3"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	 </tr>
     <tr class="footer"><td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td> 	</tr> 
    </table>
   </td>
  </tr>
 </table>';
}
else
{
    $nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'");
    $dateCond="";
	$Condition="";
    /****************فیلترها روی گزارش*******************/	
	if($code_kala)     $Condition.=" AND r_k_d.code_kala='$code_kala'";//کد کالا
    if($code_skk) $Condition.=" AND resid.code_skk='$code_skk'";//کد فروشنده/کشتی 	

	if ($date1) $Condition.=" and resid.tarikh_resid>='$date1'";
    if ($date2) $Condition.=" and resid.tarikh_resid<='$date2'";
/****************شروع نمایش گزارش*******************/	
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
    $radif=1;
	$sum_mablagh_pardakhty=0;
	$q="SELECT r_k_d.*,SUM(tedad_karton_r_d_sub) AS Tedad,SUM(vazn_nakhales_r_d_sub) AS vaznNaKhales,SUM(vazn_khales_r_d_sub) AS vaznKhales,kala.name_kala,mt_skk.name_skk 
	    FROM resid_kala_detail r_k_d
	    INNER JOIN resid_detail r_d ON r_k_d.code_kala=r_d.code_kala AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year   
        INNER JOIN resid ON resid.shomare_resid=r_d.shomare_resid AND resid.code_ostan=r_d.code_ostan AND resid.code_anbar=r_d.code_anbar AND resid.year=r_d.year   
        INNER JOIN kala ON r_k_d.code_kala=kala.code_kala    
        INNER JOIN mt_skk ON mt_skk.code_skk=resid.code_skk   
        WHERE 1=1 $Condition AND resid.code_ostan='$mt_gl_code_ostan' AND resid.code_anbar='$mt_gl_code_anbar' AND resid.year='$mtActiveYear' AND resid.deleted=0 AND resid.status=0 GROUP BY resid.code_skk,r_k_d.code_kala ORDER BY resid.code_skk,r_k_d.code_kala asc";			
	//echo $q;
	$res=$db->query($q);
    $cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)//وجود داشتن
	{
     echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/ 
	  if($code_kala) {$nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
      if($code_skk) {$nameSkk=$db->get_from_where("name_skk","mt_skk","code_skk='$code_skk'");$filter_string.=' فروشنده/کشتی : '.$nameSkk.'&nbsp;';}      
	  if(($code_kala)or($code_skk))
	  {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
     echo $columns;
	 while($row=$db->fetch_assoc($res))
     {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  echo'
	    <td>'.$radif++.'</td>
		<td>'.$row['name_skk'].'</td>
		<td>'.$row['name_kala'].'</td>
		<td>'.virgul($row['Tedad']).'</td>
		<td>'.round($row['vaznNaKhales'],3).'</td>
		<td>'.round($row['vaznKhales'],3).'</td>
		';
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
	  <!-- چاپ زیرنویس-->
      <tr class="print_footer noExl">
       <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
      </tr>
	 </table>'; 
	}//END IF //وجود داشتن
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