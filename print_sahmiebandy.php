<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_sahmiebandy.php";
$TableName="sahmiebandy_kharid";
$page=1;
$line=0;
$i=0;$cntr=0;
$MaxLines=25;
$radif=1;
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='سهمیه بندی خرید استانها';
$columns='	
    <tr class="print_table-title2">
	 <td width="5%" rowspan="2">رديف</td>
	 <td width="5%" rowspan="2">شناسه</td>
	 <td width="10%" rowspan="2">شماره ابلاغ</td>
	 <td width="10%" rowspan="2">گروه کالا</td>
	 <td width="10%" rowspan="2">استان</td>
	 <td width="10%" rowspan="2">سهمیه تخصیص یافته (کیلوگرم)</td>
	 <td width="10%" rowspan="2">جمع قراردادهای منعقده</td>
	 <td width="10%" colspan="3">قراردادهای خاتمه یافته</td>
	 <td width="10%" colspan="3">قراردادهای جاری</td>
	 <td width="10%" rowspan="2" nowrap >
	  مانده مجاز جهت انعقاد قرارداد
      <br/>
      از سهمیه تخصیص یافته	  
	 </td>
	</tr>
    <tr class="print_table-title2">
	 <td>جمع قرارداد</td>
	 <td>وزن تحویل شده</td>
	 <td>مقدار تحقق نشده از قرارداد</td>
	 <td>جمع قرارداد</td>
	 <td>وزن تحویل شده</td>
	 <td>مانده تعهدات قراردادهای جاری</td>
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
  //از صفحه ابلاغ آمده یا  نه
  if($id_eblagh=='')$condition="";
  else 
  {
   $condition=" AND T.id_eblagh=$id_eblagh"; 
   $shomare_eblagh=$db->get_from_where("shomare_eblagh","eblagh_kharid","id_eblagh='$id_eblagh'");
   $titr.=" (شماره ابلاغ $shomare_eblagh)"; 
  }
  if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$condition_ostan='';}
  else {$condition_ostan=' AND T.code_ostan='.$mt_gl_code_ostan.'';} 
  $q1="SELECT *,ostan.name_ostan,name_group_kala_top From $TableName T
      	INNER JOIN eblagh_kharid ON T.id_eblagh=eblagh_kharid.id_eblagh
		INNER JOIN bzacc.group_kala_top g ON g.code_group_kala_top=eblagh_kharid.code_group_kala_top
		INNER JOIN ostan ON ostan.code_ostan=T.code_ostan
		WHERE 1=1 ".$_SESSION['mt_search_sahmiebandy']." $condition $condition_ostan AND T.deleted=0 order by id_sahmiebandy";
  //echo $q1;
  $all = $db->query($q1);
  $cntr =mysql_num_rows($all);
  while($row1=$db->fetch_assoc($all))
  {
	 $line++;
	 if($i++%2) echo'<tr class="print_table-odd_small"/>';
     else echo '<tr class="print_table-even_small"/>';
       $sum_gharardad_avaliye=$db->get_from_where("SUM(meghdar_gharardad_avaliye)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0");
	   $sum_gharardad=$db->get_from_where("SUM(meghdar_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0");
	   $sum_gharardad_jari=$db->get_from_where("SUM(meghdar_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination=1");
	   $sum_gharardad_basteshode=$db->get_from_where("SUM(meghdar_gharardad_avaliye)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination!=1");
	   $sum_tahvil_basteshode=$db->get_from_where("SUM(meghdar_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination!=1");
	   $sum_mazad_gharardad_basteshode=$db->get_from_where("SUM(mazad_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination!=1");
	   $sum_mazad_gharardad_jari=$db->get_from_where("SUM(mazad_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination=1");
	   $sum_mazad_gharardad=$db->get_from_where("SUM(mazad_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0");
	  
	   $total_sum_resid_jari=0;
	   $q_gharardad="SELECT shomare_gharardad FROM gharardad_kharid WHERE id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination=1";
 	   $all_gharardad = $db->query($q_gharardad);
	   while($row_g=$db->fetch_assoc($all_gharardad))
	   {
		 $id_safar=$db->get_from_where("id_safar","shomare_safar","shomare_safar='".$row_g['shomare_gharardad']."'");  
	     $sum_resid=$db->get_from_where("SUM(vazn_khales_r)","meat.resid","id_safar='".$id_safar."' AND deleted=0 AND status=0");
	    // $total_sum_resid_jari+=$sum_resid;
	   }
	   $mande_gharardad=$row1['max_kharid_ostan']-$sum_tahvil_basteshode-$sum_gharardad_jari-$sum_mazad_gharardad_jari;

	  echo'
	   <td '.$edtClick.'>'.$radif++.'</td>
	   <td '.$edtClick.'>'.$row1['id_sahmiebandy'].'</td>
	   <td '.$edtClick.'>'.$row1['shomare_eblagh'].'</td>
	   <td '.$edtClick.'>'.$row1['name_group_kala_top'].'</td>
	   <td '.$edtClick.'>'.$row1['name_ostan'].'</td>
	   <td '.$edtClick.'>'.($row1['max_kharid_ostan']).'</td>
	   <td '.$edtClick.'>'.round($sum_gharardad_avaliye+$sum_mazad_gharardad,3).'</td>
	   <td '.$edtClick.'>'.round($sum_gharardad_basteshode+$sum_mazad_gharardad_basteshode,3).'</td>
	   <td '.$edtClick.'>'.round($sum_tahvil_basteshode,3).'</td>
	   <td '.$edtClick.'>'.round($sum_gharardad_basteshode+$sum_mazad_gharardad_basteshode-$sum_tahvil_basteshode,3).'</td>
	   <td '.$edtClick.'>'.round($sum_gharardad_jari+$sum_mazad_gharardad_jari,3).'</td>
	   <td '.$edtClick.'>'.round($total_sum_resid_jari,3).'</td>
	   <td '.$edtClick.'>'.round($sum_gharardad_jari+$sum_mazad_gharardad_jari-$total_sum_resid_jari,3).'</td>
	   <td '.$edtClick.'>'.round($mande_gharardad,3).'</td>';
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