<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_gharardad.php";
$TableName="gharardad_kharid";
$page=1;
$line=0;
$i=0;$cntr=0;
$MaxLines=25;
$radif=1;
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='قرارداد خرید';
$columns='	
    <tr class="print_table-title2">
	 <td width="%" rowspan="2">رديف</td>
	 <td width="%" rowspan="2">شماره قرارداد</td>
	 <td width="%" rowspan="2">تاریخ قرارداد</td>
	 <td width="%" colspan="2">تاریخ اتمام</td>
	 <td width="%" rowspan="2">مدت قرارداد</td>
	 <td width="%" rowspan="2">شماره ابلاغ</td>
	 <td width="%" rowspan="2">شماره دستورالعمل</td>
	 <td width="%" rowspan="2">نام کالا/گروه کالا</td>
	 <td width="%" rowspan="2">استان</td>
	 <td width="%" rowspan="2">طرف قرارداد(فروشنده)</td>
	 <td width="%" rowspan="2">حداکثر مقدار سهمیه</td>
	 <td width="%" rowspan="2">مقدار قرارداد</td>
	 <td width="%" rowspan="2">مقادیر الحاقیه</td>
	 <td width="%" rowspan="2">مجموع قرارداد و الحاقیه</td>
	 <td width="%" rowspan="2">مبلغ کل قرارداد</td>
	 <td width="%" rowspan="2">مبلغ درخواست تأمین اعتبار</td>
	 <td width="%" rowspan="2">مبلغ درخواست پرداختی</td>
	 <td width="%" colspan="2">تحویلی از قرارداد</td>
	 <td width="%" rowspan="2">مانده از قرارداد</td>
	 <td width="%" rowspan="2">وضعیت</td>
	</tr>
    <tr class="print_table-title2">
	 <td>قرارداد</td>
	 <td>الحاقیه</td>
	 <td>ثبت نهایی شده</td>
	 <td>ثبت نهایی نشده</td>
	</tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$page;
 echo'   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr>
	 <td colspan="40">
      <table width="100%" align="center">
       <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>';
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
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
 <!--هدر-->';
 print_header();
 echo' 
 <!--پايان هدر-->
 <!-- مرکز صفحه-->';	
   //از صفحه سهمیه بندی آمده یا نه
    if($id_sahmiebandy=='')$condition="";
    else 
    {
     $condition=" AND T.id_sahmiebandy=$id_sahmiebandy";
     $titr.=" (شماره سهمیه $id_sahmiebandy)"; 
    }
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$condition_ostan='';}
    else {$condition_ostan=' AND T.code_ostan='.$mt_gl_code_ostan.'';}
   $q1="SELECT T.*,kala.name_kala,kala.code_bastebandy,shomare_eblagh,d_kh.shomare_dastorolamal,max_kharid_ostan,mt_skk.name_skk,ostan.name_ostan,e_kh.code_group_kala_top,name_group_kala_top
	    From meat.$TableName T 
		INNER JOIN meat.sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
	    INNER JOIN meat.dastorolamal_kharid d_kh ON T.id_dastorolamal=d_kh.id_dastorolamal
	    INNER JOIN meat.eblagh_kharid e_kh ON d_kh.id_eblagh=e_kh.id_eblagh
		INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=e_kh.code_group_kala_top
		INNER JOIN meat.mt_skk ON T.code_skk=mt_skk.code_skk
		INNER JOIN meat.ostan ON T.code_ostan=ostan.code_ostan
		LEFT JOIN meat.kala ON T.code_kala=kala.code_kala
		WHERE 1=1 ".$_SESSION['mt_search_gharardad']." $condition $condition_ostan  AND T.deleted=0 order by tarikh_gharardad";
		
   $all = mysql_query($q1);
   $cntr =mysql_num_rows($all);
   while($row1=mysql_fetch_assoc($all))
   {
	 //قوطی-کنسرو مرغ
	 if($row1['code_group_kala_top']==6) 
	 {
		 $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
		 $sum_tahvily_gharardad_sabt=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND sabt_nahayi=1");
		 $sum_tahvily_gharardad_nosabt=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND sabt_nahayi=0");
     }
	 //کارتن یا لاشه
	 else
	 {
		 $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND  r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
		 $sum_tahvily_gharardad_sabt=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND  r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND sabt_nahayi=1");
		 $sum_tahvily_gharardad_nosabt=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND  r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND sabt_nahayi=0");
	 } 
	 
	 //مانده قرارداد
	 $mande_tahvily_gharardad=$row1['meghdar_gharardad_avaliye']+$row1['mazad_gharardad']-round($sum_tahvily_gharardad,3);
	 $mablaghpardakht=$db->get_from_where("SUM(mablagh_pardakht)","pardakht_gharardad","id_gharardad='".$row1['id_gharardad']."' AND deleted='0'");
	 $mablaghtamin=$db->get_from_where("SUM(mablagh_tamin)","tamin_etebar","id_gharardad='".$row1['id_gharardad']."' AND deleted='0'");
	 $mablagh_kol=compute_gheymat_gharardad($row1['id_gharardad'],$db);
	 $tarikh_etmam='';
	 $tarikh_etmam_elhaghie='';
	 $exist_elhaghie_date=$db->get_from_where("COUNT(*)","meat.elhaghie_kharid","id_gharardad='".$row1['id_gharardad']."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ");
     if($exist_elhaghie_date>0)//اگر الحاقیه دارد
     {
       $tarikh_etmam_elhaghie=$db->get_from_where("tarikh_etmam_elhaghie","meat.elhaghie_kharid","id_gharardad='".$row1['id_gharardad']."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ORDER BY tarikh_elhaghie,id_elhaghie DESC"); 
       $tarikh_etmam=$tarikh_etmam_elhaghie;
     }
     else//اگر الحاقیه ندارد
     {
      $tarikh_etmam=$row1['tarikh_etmam'];
     }
	 
     //اختلاف تاریخ شروع و پایان قرارداد
	 $ekhtelaf_tarikh='';
	 IF(strlen($tarikh_etmam)==10)$ekhtelaf_tarikh=calculate_date_diff($row1['tarikh_gharardad'],$tarikh_etmam);
	 $line++;
	 if($i++%2) echo'<tr class="print_table-odd_small"/>';
     else echo '<tr class="print_table-even_small"/>';
     echo'
	  <td>'.$radif++.'</td>
	  <td >'.$row1['shomare_gharardad'].'</td>
      <td >'.$row1['tarikh_gharardad'].'</td>
      <td >'.$row1['tarikh_etmam'].'</td>
      <td >'.$tarikh_etmam_elhaghie.'</td>
	  <td >'.$ekhtelaf_tarikh.'</td>
      <td >'.$row1['shomare_eblagh'].'</td>
      <td >'.$row1['shomare_dastorolamal'].'</td>';
	  if($row1['code_group_kala_top']!=5)echo'<td '.$edtClick.' > '.$row1['name_kala'].'</td>';
	  else echo'<td '.$edtClick.' >'.$row1['name_group_kala_top'].'</td>';
	  echo'
	  <td >'.$row1['name_ostan'].'</td>
	  <td >'.$row1['name_skk'].'</td>
	  <td >'.$row1['max_kharid_ostan'].'</td>
	  <td >'.round($row1['meghdar_gharardad_avaliye'],3).'</td>
	  <td >'.round($row1['mazad_gharardad'],3).'</td>
	  <td >'.round($row1['meghdar_gharardad_avaliye']+$row1['mazad_gharardad'],3).'</td>
	  <td >'.virgul($mablagh_kol).'</td>
	  <td >'.virgul($mablaghtamin).'</td>
	  <td >'.virgul($mablaghpardakht).'</td>
	  <td >'.round($sum_tahvily_gharardad_sabt,3).'</td>
	  <td >'.round($sum_tahvily_gharardad_nosabt,3).'</td>
	  <td >'.round($mande_tahvily_gharardad,3).'</td>
	  <td >';if($row1['termination']==1) echo 'جاری';else echo 'بسته شده </td>';
      echo'
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
	}
	echo'
   </table>
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
 <tr class="print_footer">
  <td colspan="3">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr>	 
</table>
</body>
</html>';	
?>