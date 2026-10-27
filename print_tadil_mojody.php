<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_tadil_mojody.php";
$TableName="tadil_mojody";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$radif=1;
$page=1;
$line=0;
$i=0;$cntr=0;
$MaxLines=25;
$titr='چاپ تعدیل موجودی';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
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
/***************************************** MAIN*****************************************/
$columns='
	 <tr class="print_table-title">
	  <td width="3%" rowspan="2">رديف</td>
	  <td width="7%" rowspan="2">شماره برگه تعدیل</td>
	  <td width="7%" rowspan="2">تاریخ برگه تعدیل </td>
	  <td width="10%" rowspan="2">نام کالا</td>	 
	  <td width="5%" rowspan="2">زیرانبار</td>	 
	  <td width="4%" rowspan="2">کشور</td>
	  <td width="5%" rowspan="2">تولیدکننده</td>
	  <td width="15%" colspan="3">تاریخ تولید </td>	 	 	  	  
	  <td width="5%" rowspan="2">نوع تعدیل</td>
	  <td width="5%" rowspan="2">نوع فرم تعدیل</td>
	  <td width="5%" rowspan="2">شماره مجوز </td> 	  	 
	  <td width="15%" colspan="3">مقادیر تعدیل</td>
	  <td width="4%" rowspan="2">وضعیت</td>
	  <td width="10%" rowspan="2">توضيحات</td>
	 </tr>
  	 <tr class="print_table-title">
		  <td>سال</td>
		  <td>ماه</td>
		  <td>روز</td>
	      <td width="%">تعداد</td>	
	      <td width="%">ناخالص</td>
		  <td width="%">خالص</td>
	  </tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$page;
 echo'   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr>
	 <td colspan="40">
      <table width="100%" align="center">
       <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>';
	   echo'
	   <tr><td class="print_title_2">';  
		 IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>';
		 }
		 echo $titr.' &nbsp&nbsp(صفحه : '.$page.')';
	     echo'
	    </td>
	   </tr>
      </table>
     </td>
    </tr>';
	echo $columns;
}
echo'
<body>
 <br>
 <!--هدر-->';
 print_header();
echo' 
<!--پايان هدر-->
<!-- مرکز صفحه-->';
   $q1="SELECT *,
        (SELECT name_kala From kala k WHERE k.code_kala=T.code_kala) nameKala,
	    (SELECT name_keshvar From keshvar kesh WHERE kesh.code_keshvar=T.code_keshvar) nameKeshvar,
	    (SELECT name_tolidkonande From tolidkonande WHERE tolidkonande.code_tolidkonande=T.code_tolidkonande) nameTolidkonande,
		(SELECT name_ziranbar From list_sardkhane_detail l_s_d WHERE l_s_d.code_ziranbar=T.code_ziranbar AND T.code_ostan=l_s_d.code_ostan AND T.code_anbar=l_s_d.code_anbar ) nameZiranbar
	    From $TableName T WHERE T.code_ostan='$mt_gl_code_ostan' and T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0";
   $allTadil = $db->query($q1);
   $cntr =mysql_num_rows($allTadil);
   while($row1=$db->fetch_assoc($allTadil))
   {
     $line++;
	 if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
     else $code_a=$row1['code_ostan'];
	 if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
	 echo'
	  <td>'.$radif++.'</td>
	  <td>'.$code_a.$row1['code_anbar'].$row1['shomare_barge_tadil'].'</td>
	  <td>'.$row1['tarikh_barge_tadil'].'</td>
	  <td>'.$row1['nameKala'].'</td>
	  <td>'.$row1['nameZiranbar'].'</td>
	  <td>'.$row1['nameKeshvar'].'</td>
	  <td>'.$row1['nameTolidkonande'].'</td>
	  <td>'.$row1['sal_tolid_shamsi'].'</td>
	  <td>'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'</td>	
	  <td>'.$row1['rouz_tolid_shamsi'].'</td>	
	  <td>'.$tadilArr[$row1['noe_tadil']].'</td>
	  <td>'.$tadilformArr[$row1['noe_form_tadil']].'</td>
	  <td>'.$row1['shomare_mojavez_tadil'].'</td>
	  <td>'.($row1['tedad_karton_tadil']).'</td>
	  <td>'.round($row1['meghdar_nakhales_tadil'],3).'</td>
	  <td>'.round($row1['meghdar_khales_tadil'],3).'</td>
	  <td>'.$statusFormArr[$row1['status']].'</td>
	  <td>'.$row1['tozihat_tadil'].'</td>
	 </tr>';
	  if ($line>=$MaxLines && $i <$cntr) 
	  {
		 $line=0;
         $page++;
	     echo'
		   </table>
		   <br class="pbreak">';
		   print_header();
	  }	 
   }//END while
   echo'
<!--پايان مرکز صفحه -->
<!-- چاپ زیرنویس-->';
  require_once('prt-footer.php');
 echo' 
</table> 
</body>
</html>';	
?>