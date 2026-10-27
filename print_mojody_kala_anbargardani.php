<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_mojody_kala_anbargardani.php";
$TableName="mojody_kala";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$radif=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ موجودی کالا</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<style>
       @media screen
       {
           .hideatprint
           {
           }
       }
       @media print
       {
           .hideatprint
           {
               display: none;
           }
       }
</style>
</head>';
$columns='	
    <tr class="print_table-title2">
	 <td rowspan="2" width="4%">رديف</td>
	 <td rowspan="2" width="4%">کد کالا</td>
	 <td rowspan="2" width="10%">نام کالا</td>
	 <td rowspan="2" width="5%">نوع بسته بندی</td>
	 <td rowspan="2" width="5%">زیرانبار</td>
	 <td rowspan="2" width="4%">کشور</td>
	 <td rowspan="2" width="10%">تولیدکننده</td>
	 <td rowspan="2" width="5%">وزن کارتن/قوطی</td>
	 <td colspan="3" width="13%">تاریخ تولید</td>
	 <td rowspan="2" width="5%">تاریخ ماندگاری</td>
	 <td colspan="3" width="20%">مقادیر موجودی اول دوره</td>
	 <td colspan="3" width="20%">مقادیر موجودی فعلی</td>
	 <td colspan="3" width="20%">مقادیر انبارگردانی قبل</td>
	</tr> 
    <tr class="print_table-title2">
	   <td width="%">سال</td>
	   <td width="%">ماه</td>
	   <td width="%">روز</td>
	   <td width="%">تعداد</td>
	   <td width="%">مقدار ناخالص</td>
	   <td width="%">مقدار خالص</td>
	   <td width="%">تعداد</td>
	   <td width="%">مقدار ناخالص</td>
	   <td width="%">مقدار خالص</td>
	   <td width="%">تعداد</td>
	   <td width="%">مقدار ناخالص</td>
	   <td width="%">مقدار خالص</td>
	</tr>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!--هدر-->
 <br/>
 <table width="99%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> سردخانه  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">جدول موجودی کالا &nbsp&nbsp(صفحه : 1)
	    <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText--hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
		</td>
	</tr>
 </table>
<!--پايان هدر-->
<!-- مرکز صفحه-->	
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
  '.$columns.'';
   $page=1;
   $line=0;
   $i=0;$cntr=0;
   $MaxLines=25;
   $q1="SELECT $TableName.*,kala.name_kala,bastebandy.sharh_bastebandy,l_s_d.name_ziranbar,keshvar.name_keshvar,tolidkonande.name_tolidkonande,sharh_mandegari FROM $TableName
		 INNER JOIN kala ON $TableName.code_kala=kala.code_kala 
		 INNER JOIN bastebandy ON $TableName.code_bastebandy=bastebandy.code_bastebandy 
         INNER JOIN list_sardkhane_detail l_s_d ON $TableName.code_ziranbar=l_s_d.code_ziranbar AND $TableName.code_ostan=l_s_d.code_ostan AND $TableName.code_anbar=l_s_d.code_anbar  	  
		 INNER JOIN keshvar ON keshvar.code_keshvar=$TableName.code_keshvar  
         INNER JOIN tolidkonande ON $TableName.code_tolidkonande=tolidkonande.code_tolidkonande
         INNER JOIN tarikh_mandegari ON tarikh_mandegari.code_mandegari=mojody_kala.code_mandegari    
		 WHERE 1=1 ".$_SESSION['mt_search_mojody_k']." AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' And $TableName.deleted=0 order by id asc"; 
   $allMojody = $db->query($q1);
   $cntr =mysql_num_rows($allMojody);
   while($row1=$db->fetch_assoc($allMojody))
   {
     $line++;
	 if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     //با استفاده از تابع
	 $tedad_karton=mojodyKarton($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton']);
	 $mojody_nakhales=mojodyNakhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton']);
	 $mojody_khales=mojodyKhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton']);
	 $sal_maghsad=$row1['year']-1;
	 $tedad_a=$db->get_from_where("tedad_anbargardani","mt_anbargardani_detail","code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND code_ziranbar=".$row1['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row1['code_kala']." AND code_keshvar=".$row1['code_keshvar']." AND code_tolidkonande=".$row1['code_tolidkonande']." AND sal_tolid_shamsi=".$row1['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row1['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row1['rouz_tolid_shamsi']." AND code_karton=".$row1['code_karton']."");	
	 $nakhales_a=$db->get_from_where("nakhales_anbargardani","mt_anbargardani_detail","code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND code_ziranbar=".$row1['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row1['code_kala']." AND code_keshvar=".$row1['code_keshvar']." AND code_tolidkonande=".$row1['code_tolidkonande']." AND sal_tolid_shamsi=".$row1['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row1['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row1['rouz_tolid_shamsi']." AND code_karton=".$row1['code_karton']."");	
	 $khales_a=$db->get_from_where("khales_anbargardani","mt_anbargardani_detail","code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND code_ziranbar=".$row1['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row1['code_kala']." AND code_keshvar=".$row1['code_keshvar']." AND code_tolidkonande=".$row1['code_tolidkonande']." AND sal_tolid_shamsi=".$row1['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row1['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row1['rouz_tolid_shamsi']." AND code_karton=".$row1['code_karton']."");	
	 echo'
	  <td>'.$radif++.'</td>
	  <td>'.$row1['code_kala'].'</td>
	  <td>'.$row1['name_kala'].'</td>
	  <td>'.$row1['sharh_bastebandy'].'</td>
	  <td>'.$row1['name_ziranbar'].'</td>
	  <td>'.$row1['name_keshvar'].'</td>
	  <td>'.$row1['name_tolidkonande'].'</td>
	  <td>'.$row1['vazn_karton_this'].'</td>
	  <td>'.$row1['sal_tolid_shamsi'].'</td>
	  <td>'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'</td>
	  <td>'.$row1['rouz_tolid_shamsi'].'</td>
	  <td>'.$row1['sharh_mandegari'].'</td>
	  <td>'.$row1['tedad_karton_aval'].'</td>
	  <td>'.round($row1['mojody_nakhales_aval'],3).'</td>	 
	  <td>'.round($row1['mojody_khales_aval'],3).'</td>
	  <td>'.$tedad_karton.'</td>
	  <td>'.round($mojody_nakhales,3).'</td>
	  <td>'.round($mojody_khales,3).'</td>
	  <td>'.$tedad_a.'</td>
	  <td>'.round($nakhales_a,3).'</td>
	  <td>'.round($khales_a,3).'</td>';
	echo '
	</tr>';
	if($line>=$MaxLines && $i <$cntr) 
	{
	 $line=0;
     $page++;
	 echo'
 </table>
	 <br class="pbreak">
     <br/>
	 <table width="99%" border="1" align="center">
      <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
      <tr><td class="print_title_2"> سردخانه  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
      <tr><td class="print_title_2">جدول موجودی کالا&nbsp&nbsp(صفحه : '.$page.')
	    	</td>
	  </tr>
     </table>
	 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
     '.$columns.'';
	 }
	}//END while
   echo'
 </table>
<!--پايان مرکز صفحه -->
<!-- چاپ زیرنویس-->
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474"> 
 <tr class="print_footer">
  <td>&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr>
</table> 
</body>
</html>';	
?>