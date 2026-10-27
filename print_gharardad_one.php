<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_sahmiebandy_one.php";
$TableName="gharardad_kharid";
$today=AsLDate($yymmdd);
$logtime=date('H:i:s');
$titr="قرارداد خرید";
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
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
echo'
<body>
<br>
<table width="70%" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
  <tr>
  <td>
   <table width="100%" border="0" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2">'.$titr.'
	    <a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
	 </td>
	</tr>	
   </table>
  </td>
 </tr> 
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';  
   $q1=("SELECT T.*,kala.name_kala,kala.code_bastebandy,d_kh.shomare_dastorolamal,d_kh.tarikh_dastorolamal,s_kh.max_kharid_ostan,mt_skk.name_skk,ostan.name_ostan,e_kh.code_group_kala_top,name_group_kala_top
         From $mydatabase.$TableName T 
		    INNER JOIN $mydatabase.sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
		    INNER JOIN $mydatabase.dastorolamal_kharid d_kh ON T.id_dastorolamal=d_kh.id_dastorolamal
			INNER JOIN $mydatabase.eblagh_kharid e_kh ON d_kh.id_eblagh=e_kh.id_eblagh
			LEFT JOIN $mydatabase.gheymat_kharid ON gheymat_kharid.id_gheymat_kharid=T.id_gheymat_kharid
			INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=e_kh.code_group_kala_top
			INNER JOIN $mydatabase.mt_skk ON mt_skk.code_skk=T.code_skk
		    INNER JOIN $mydatabase.ostan ON ostan.code_ostan=s_kh.code_ostan
			LEFT JOIN $mydatabase.kala ON kala.code_kala=T.code_kala
		   WHERE T.id_gharardad='$id_gharardad_' AND T.deleted=0");
	//echo $q1;
	$all = $db->query($q1);
    $row1=$db->fetch_assoc($all);
	//کل تحویلی قرارداد
	 //قوطی /کنسرو
	 if($row1['code_group_kala_top']==6) $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
	 //کارتن یا لاشه
	 else $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
	 $sum_tahvily_gharardad=round($sum_tahvily_gharardad,3);
	
	// //کل تحویلی قرارداد
	 // //قوطی
	 // if($row1['code_bastebandy']==2) $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
	 // //کارتن یا لاشه
	 // else $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
	 // //مانده قرارداد
	 //$mande_tahvily_gharardad=$row1['meghdar_gharardad']+$row1['mazad_gharardad']-$sum_tahvily_gharardad;
	 $mande_tahvily_gharardad=$row1['meghdar_gharardad_avaliye']+$row1['mazad_gharardad']-round($sum_tahvily_gharardad,3);
	 
	echo'
	  <tr class="print_tr1">
	   <td colspan="2">
        <table border=0 width=100%  style="line-height:30px;">
	     <tr>
		  <td align="right"> شماره دستورالعمل : '.$row1['shomare_dastorolamal'].'</td>
	      <td align="right"> تاريخ دستورالعمل : '.$row1['tarikh_dastorolamal'].'</td>	 
	      <td align="right"> وضعیت : ';if($row1['termination']==1) echo 'جاری'; else echo 'بسته شده </td>';	 
         echo'
		 </tr>
		 <tr>		 
		  <td align="right"> شماره قرارداد : '.$row1['shomare_gharardad'].'</td> 
	      <td align="right"> تاریخ قرارداد : '.$row1['tarikh_gharardad'].'</td>	 
	      <td align="right"> تاریخ شروع قرارداد : '.$row1['tarikh_shoro'].'</td>	 
		 </tr>
		 <tr>		 
		  <td align="right"> تاریخ اتمام قرارداد : '.$row1['tarikh_etmam'].'</td> 
	      <td align="right"> مدت قرارداد : '.$row1['modat_gharardad'].' (روز)</td>	 
		 </tr>
		 <tr>		 
		  <td align="right"> طرف قرارداد (فروشنده) : '.$row1['name_skk'].'</td> 
		  <td align="right"> استان : '.$row1['name_ostan'].'</td>	 
		 </tr>
		 <tr>';		 
		  echo'<td align="right"> کالا : '.$row1['name_kala'].'</td>';
          IF($row1['noe_khat']!=0) echo'<td align="right"> نوع خط : '.$noeKhatArr[$row1['noe_khat']].'</td>	';		  
	      ELSE  echo'<td align="right"> نوع خط : -</td>	';
		 echo'
		 </tr>
		 <tr>
	      <td align="right"> مقدار اولیه قرارداد : '.$row1['meghdar_gharardad_avaliye'].' (کیلوگرم)</td>	 
         </tr>
		 <tr>
	      <td align="right"> مقدار قرارداد : '.$row1['meghdar_gharardad'].' (کیلوگرم)</td>	 
	      <td align="right"> مقادیر الحاقیه : '.$row1['mazad_gharardad'].' (کیلوگرم)</td>	 
	      <td align="right"> میزان کاهش یا افزایش حجم  : '.($row1['percentage_changes']).'</td>	 
         </tr>
	     <tr>
	      <td align="right"> قیمت هر کیلوگرم : '.virgul($row1['gheymat_har_kilo']).' (ریال)</td>	 
		  <td align="right"> مقدار جریمه : '.virgul($row1['meghdar_jarime']).'</td>	 
		 </tr>
	     <tr>
	      <td align="right"> جمع کل تحویلی قرارداد : '.round($sum_tahvily_gharardad,3).' (کیلوگرم)</td>	 
	      <td align="right"> جمع کل مانده از قرارداد : '.round($mande_tahvily_gharardad,3).' (کیلوگرم)</td>	 
		 </tr> 
	    </table>
	   </td>
	  </tr>
	 <tr><td>&nbsp;</td></tr>
   </table>
  </td>
 </tr>
 <tr class="print_footer">
  <td align="left">&nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr> 
 <!--پايان مرکز صفحه -->
</table>
<!-- چاپ زیرنویس-->
<table width="70%" border="1" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr class="print_footer">
  <td>نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.'</td>';
   $dc=mysql_query("SELECT dpt_id FROM mt_typesign WHERE type_id='3' AND code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' order by turn");	
   while ($dr=mysql_fetch_array($dc))
   {
	$vahed=$db->get_from_where("dpt_name,manager","mt_dpt","dpt_id=".$dr[0]." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
    echo '<td>'.$vahed[0].' :&nbsp;&nbsp;'.$vahed[1].'</td>';
   }
  echo'
  </td>
 </tr>
</table>
</body>
</html>';
?>