<?php
session_start();
error_reporting(1);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="resid_gharardad.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$shomare_gharardad=$db->get_from_where("shomare_gharardad","gharardad_kharid","id_gharardad='".$id_gh_."'");
//$name_kala=$db->get_from_where("name_kala","kala INNER JOIN gharardad_kharid ON gharardad_kharid.code_kala=kala.code_kala","id_gharardad='".$id_gh_."'");
//$titr='رسیدهای قرارداد '.$shomare_gharardad.' - کالای '.$name_kala.'';
$titr='رسیدهای قرارداد '.$shomare_gharardad.'';
$radif=1;
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
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
$columns='<tr class="print_table-title">
	       <td width="3%">رديف</td>
	       <td width="6%">شماره رسید</td>
	       <td width="6%">تاریخ رسید</td>
	       <td width="8%">استان</td>
	       <td width="15%">سردخانه</td>
	       <td width="5%">شماره کانتینر</td>
		   <td width="6%">نوع تحویل بار</td>
		   <td width="4%">وضعیت</td>
		   <td width="4%">ثبت نهایی</td>
	       <td width="10%">کالا</td>
	       <td width="7%">تولیدکننده</td>
	       <td width="4%">تعداد</td>
	       <td width="8%">وزن ناخالص</td>
	       <td width="8%">وزن خالص</td>
	       <td width="6%">قیمت</td>
	    </tr>';
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!--هدر-->
 <br/>
 <table width="99%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2">'.$titr.' &nbsp&nbsp(صفحه : 1)
	    <a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
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
   $TableName='resid';	
   $q1="SELECT T.*,ostan.name_ostan,list_sardkhane.name_anbar From $TableName T INNER JOIN ostan ON T.code_ostan=ostan.code_ostan INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar WHERE id_safar=$id_safar_  AND T.deleted=0 ORDER BY tarikh_resid,code_ostan,code_anbar,shomare_resid";				  
   //$q1="SELECT T.*,ostan.name_ostan,list_sardkhane.name_anbar From $TableName T INNER JOIN ostan ON T.code_ostan=ostan.code_ostan INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar INNER JOIN resid_detail r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year WHERE id_safar=$id_safar_ AND T.year=$mtActiveYear AND T.deleted=0 ORDER BY tarikh_resid,code_ostan,code_anbar,shomare_resid";				  
   $allResid = $db->query($q1);    
   $cntr =mysql_num_rows($allResid);
   while($row1=$db->fetch_assoc($allResid))
   {
     $tedaddetail=$db->get_from_where("count(code_kala)","resid_detail","code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']." AND shomare_resid='".$row1['shomare_resid']."'");//تعداد      
	 if($tedaddetail>0)$rowdetail=$tedaddetail;
	 else $rowdetail=1;//detail empty
	 $t=$rowdetail;
	 $line++;
	 if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
	 if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
     else $code_a=$row1['code_ostan'];
	 echo'
	   <td rowspan="'.$rowdetail.'">'.$radif++.'</td>
	   <td rowspan="'.$rowdetail.'">'.$code_a.$row1['code_anbar'].$row1['shomare_resid'].'</td>
	   <td rowspan="'.$rowdetail.'">'.$row1['tarikh_resid'].'</td>
	   <td rowspan="'.$rowdetail.'">'.$row1['name_ostan'].'</td>
	   <td rowspan="'.$rowdetail.'">'.$row1['name_anbar'].'</td>
	   <td rowspan="'.$rowdetail.'">'.$row1['shomare_container'].'</td>
	   <td rowspan="'.$rowdetail.'">'.$tahvilbarArr[$row1['noe_tahvil_bar']].'</td>';
	   if($row1['status']==0) echo '<td rowspan="'.$rowdetail.'"> جاری </td>';else echo '<td rowspan="'.$rowdetail.'" style="color:red;"> ابطالی </td>';
	   if($row1['sabt_nahayi']==1) echo '<td rowspan="'.$rowdetail.'"> شده </td>';else echo '<td rowspan="'.$rowdetail.'" style="color:red;"> نشده </td>';
	   /**///حلقه روی جزئیات رسید
	   $q2="SELECT r_d.*,name_kala,name_tolidkonande,
		   	   (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year AND r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande)tedadKarton,
	           (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year AND r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande)vaznNaKhales,
	           (SELECT SUM(vazn_khales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year AND r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande)vaznKhales
		       FROM resid_detail r_d INNER JOIN kala ON r_d.code_kala=kala.code_kala INNER JOIN tolidkonande ON r_d.code_tolidkonande=tolidkonande.code_tolidkonande    
			   WHERE r_d.code_ostan=".$row1['code_ostan']." AND r_d.code_anbar=".$row1['code_anbar']." AND r_d.year=".$row1['year']." AND r_d.shomare_resid='".$row1['shomare_resid']."'";
	   $res2=$db->query($q2);
	   if(mysql_num_rows($res2)>0)
	   { 
	       while($row2=$db->fetch_assoc($res2))
		   {	   
			$gheymat=compute_resid_price_test($row1['tarikh_resid'],$id_gh_,$db);
			$j=$i+1;
			 echo'
	         <td>'.$row2['name_kala'].'</td>
	         <td>'.$row2['name_tolidkonande'].'</td>
	         <td>'.virgul($row2['tedadKarton']).'</td>
	         <td>'.round($row2['vaznNaKhales'],3).'</td>
		     <td>'.round($row2['vaznKhales'],3).'</td>
		     <td>'.$gheymat.'</td>
			 ';

			  $t--;
			  if($t==0) echo'';
			  else 
			  {
			   echo'</tr>';
			   if($j++%2) echo'<tr class="print_table-odd">';
               else echo'<tr class="print_table-even">';
			  }
		   }//END resid_detail while
	   }
	   else echo'<td colspan="6">اطلاعات کالا تعیین نشده است</td>';
	echo'
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
      <tr><td class="print_title_2">'.$titr.' &nbsp&nbsp(صفحه : '.$page.')</td></tr>
     </table>
	 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
     '.$columns.'';
	}
	 /****************محاسبه مجموع مقادیر در سطر آخر*******************/ 
	  if($row1['status']==0)//جاری ها
	  {
	   $sum_tedad_karton+=$row1['tedad_karton_r'];
	   $sum_vazn_nakhales+=$row1['vazn_nakhales_r'];
	   $sum_vazn_khales+=$row1['vazn_khales_r'];
	  }
	  if(($row1['sabt_nahayi']==1)and($row1['status']==0))//ثبت نهایی شده
	  {
	   $sum_tedad_karton_sabt+=$row1['tedad_karton_r'];
	   $sum_vazn_nakhales_sabt+=$row1['vazn_nakhales_r'];
	   $sum_vazn_khales_sabt+=$row1['vazn_khales_r'];
	  }
	  if(($row1['sabt_nahayi']==0)and($row1['status']==0))//ثبت نهایی نشده
	  {
	   $sum_tedad_karton_nosabt+=$row1['tedad_karton_r'];
	   $sum_vazn_nakhales_nosabt+=$row1['vazn_nakhales_r'];
	   $sum_vazn_khales_nosabt+=$row1['vazn_khales_r'];
	  }
   }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="11">جمع مقادیر  (ثبت نهایی شده)</td>
	   <td>'.virgul($sum_tedad_karton_sabt).'</td>
	   <td>'.($sum_vazn_nakhales_sabt).'</td>
	   <td>'.($sum_vazn_khales_sabt).'</td>
	   <td>-</td>
	  </tr>
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="11">جمع مقادیر  (ثبت نهایی نشده)</td>
	   <td>'.virgul($sum_tedad_karton_nosabt).'</td>
	   <td>'.($sum_vazn_nakhales_nosabt).'</td>
	   <td>'.($sum_vazn_khales_nosabt).'</td>
	   <td>-</td>
	  </tr>
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="11">جمع مقادیر  (جاری)</td>
	   <td>'.virgul($sum_tedad_karton).'</td>
	   <td>'.($sum_vazn_nakhales).'</td>
	   <td>'.($sum_vazn_khales).'</td>
	   <td>-</td>
	  </tr>';
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