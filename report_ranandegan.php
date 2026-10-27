<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_ranandegan.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش رانندگان ';
require_once('head.html');
$columns='
	<tr class="print_table-title2">
       <td width="5%">ردیف</td>
       <td width="10%">تاریخ بارنامه</td>
	   <td width="10%">شماره بارنامه</td>
	   <td width="10%">شماره رسید</td>
	   <!--<td width="8%">نام کالا</td>
	       <td width="5%">نام زیرانبار</td>-->
	   <td width="10%">شماره کامیون</td>
	   <td width="10%">پلاک خودرو</td>
	   <td width="10%">نام راننده</td>
	   <td width="10%">کد ملی راننده</td>
	   <td width="8%">شماره حساب</td>
	   <td width="7%">بانک راننده</td>
	   <td width="10%">مبلغ پرداختی</td>
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
       <tr class="noExl"><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr> 
	   <tr class="noExl">
	    <td class="print_title_2">';
	     IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
	     echo'
	     '.$titr.' از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
         <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
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
	 $today=AsLDate($yymmdd); 
 	 $end_date_session=$db->get_from_where("end_to","mt_docs","year='$mtActiveYear'");
	 if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
}
if(!$MaxLines) $MaxLines=15;
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
    <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
     <tr class="tr1">	
      <td align="left" height="40px"> از تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	 </tr>
	 <tr class="tr1">
      <td align="left"> کد کالا :&nbsp;</td>
      <td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>&nbsp;';
 	   include ("img_helpkala.php");
	 echo'
	 </td>
      <td align="left"> زیرانبار :&nbsp;</td><td align="right">'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY name_ziranbar ASC","class='easyui-combobox text4'","").'</td>
 	 </tr>
	 <tr class="tr1">	
      <td align="left"> نام راننده :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="ranande_name" value="'.$ranande_name.'"/></td>
      <td align="left"> نام بانک :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="bank_ranande" value="'.$bank_ranande.'"/></td>
     </tr>
     <tr class="tr1">
	  <td align="left" height="40px"> شماره رسید :&nbsp;</td><td align="right"><input type="text" maxlength="5" class="textboxme2" name="shomare_resid" value="'.$shomare_resid.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
	  <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	 </tr>
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    </table>
    </div>
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
	if($code_kala)     $Condition.=" AND r_d.code_kala='$code_kala'";//کد کالا
    if($code_ziranbar) $Condition.=" AND r_k_d.code_ziranbar='$code_ziranbar'";//کد زیرانبار 	
    if($ranande_name)  $Condition.=" AND r.ranande_name LIKE '%$ranande_name%'";//نام راننده	
    if($bank_ranande)  $Condition.=" AND r.bank_ranande LIKE '%$bank_ranande%'";//بانک راننده 	
	if($shomare_resid)//شماره رسید
	{
	  $sh_part1_1=substr($shomare_resid,0,2);
      $sh_part1_2=substr($shomare_resid,2,3);
      $sh_part1_3=substr($shomare_resid,5,5);
      if(strlen($shomare_resid)!=5) $shomare_resid=make_pattern($shomare_resid,5);
	  $Condition.=" AND r.shomare_resid LIKE '%$shomare_resid%'";	
	}
	if($date1) $Condition.=" and r.tarikh_resid>='$date1'";
    if($date2) $Condition.=" and r.tarikh_resid<='$date2'";
/****************شروع نمایش گزارش*******************/	
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
    $radif=1;
	$sum_mablagh_per_page=0;//مجموع مبلغ در هر صفحه
	$sum_mablagh_pardakhty=0;//مجموع مبلغ کل
	$q="SELECT r.*,kala.name_kala,ostan.name_ostan,list_sardkhane.name_anbar,list_sardkhane_detail.name_ziranbar,r_d.code_kala,r_k_d.code_ziranbar FROM resid AS r 
	    LEFT OUTER JOIN resid_detail AS r_d ON  r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year
        LEFT OUTER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande 
		LEFT JOIN kala ON r_d.code_kala=kala.code_kala    
        LEFT JOIN ostan ON ostan.code_ostan=r.code_ostan_mabda    
        LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar_mabda AND list_sardkhane.code_ostan=r.code_ostan_mabda    
        LEFT JOIN list_sardkhane_detail ON list_sardkhane_detail.code_ziranbar=r_k_d.code_ziranbar AND list_sardkhane_detail.code_ostan=r_k_d.code_ostan AND list_sardkhane_detail.code_anbar=r_k_d.code_anbar    
        WHERE 1=1 $Condition AND r.code_ostan='$mt_gl_code_ostan' AND r.code_anbar='$mt_gl_code_anbar' AND r.year='$mtActiveYear' AND r.deleted=0 GROUP BY r.shomare_resid,r.code_ostan,r.code_anbar,r.year ORDER BY r.tarikh_resid,r.shomare_resid";			
	//echo $q;		
	$res=$db->query($q);
    $cntr =mysql_num_rows($res);
	//$MaxPage=(intval($cntr/$MaxLines));
	//if($MaxPage*$MaxLines==$cntr) $MaxPage=$MaxPage;
	//else $MaxPage++;
	if(mysql_num_rows($res)>0)//وجود داشتن
	{
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/ 
	  if($code_kala) {$nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
      if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}      
	  if($ranande_name) $filter_string.=' نام راننده : '.$ranande_name.'&nbsp;';    
	  if($bank_ranande) $filter_string.=' بانک راننده : '.$bank_ranande.'&nbsp;';    
	  if($shomare_resid) $filter_string.=' شماره رسید : '.$code_a.$mt_gl_code_anbar.$shomare_resid.'&nbsp;';    
	  if(($code_kala)or($code_ziranbar)or($ranande_name)or($bank_ranande)or($shomare_resid))
	  {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
     {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  echo'  
	    <td>'.$radif++.'</td>
	    <td>'.$row['barname_tarikh'].'</td>
	    <td>'.$row['barname_no'].'</td>
		<td>'.$code_a.$mt_gl_code_anbar.$row['shomare_resid'].'</td>		 
		 <!--<td>'.$row['name_kala'].'</td>
		      <td>'.$row['name_ziranbar'].'</td>-->
		<td>'.$row['kamion_no'].'</td>
	    <td dir="rtl">'.$row['plak2'].'-'.$row['plak1'].''.$row['plak3'].''.$row['plak4'].'</td>
		<td>'.$row['ranande_name'].'</td>
		<td>'.$row['ranande_melicode'].'</td>
		<td>'.$row['shomare_hesab_ranande'].'</td>
		<td>'.$row['bank_ranande'].'</td>';
		$mablagh_pardakhty=paskeraye($row['shomare_resid'],$row['code_ostan'],$row['code_anbar'],$row['year']);
		echo'
		<td>'.virgul($mablagh_pardakhty).'</td>';
		echo'
		</tr>';
		$sum_mablagh_per_page+=$mablagh_pardakhty;//مجموع مبلغ در هر صفحه
		//if($line>=$MaxLines && $page<=$MaxPage && $i<$cntr)//تکرار هدر در صفحات بعد
		if($line>=$MaxLines && $i<$cntr)//تکرار هدر در صفحات بعد
	    {
	     $line=0;
         $page++;
		 echo'
	     <tr class="print_table-even sum-row-white-b">
	      <td colspan="10">جمع مقادیر</td>
	      <td>'.virgul($sum_mablagh_per_page).'</td>
	     </tr>';
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
	        echo $columns;
			$sum_mablagh_per_page=0;//مجموع مبلغ در هر صفحه
	    }	
	 /****************محاسبه مجموع مقادیر در سطر آخر*******************/
	 $sum_mablagh_pardakhty+=$mablagh_pardakhty;
     }//END while
	 echo'
	     <tr class="print_table-even sum-row-white-b">
	      <td colspan="10">جمع مقادیر</td>
	      <td>'.virgul($sum_mablagh_per_page).'</td>
	     </tr>';
	 echo'
	  <tr class="print_table-even sum-row-white-b"><td colspan="11" align="right">&nbsp;&nbsp;&nbsp;&nbsp; مجموع مبلغ پرداختی : '.virgul($sum_mablagh_pardakhty).'</td></tr>
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
<script type="text/javascript">
function enterCodeKala(code_kala)
{
  $("#loading").fadeIn("fast");
  $.post("ajax.php",{codeKALA_Error:code_kala},function(data){$("#codeK_Error").html(data);});
  $("#loading").fadeOut("fast");				
}
</script> 