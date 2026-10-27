<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_sahmiebandy_one.php";
$TableName=" sahmiebandy_kharid";
$today=AsLDate($yymmdd);
$logtime=date('H:i:s');
$titr="سهمیه بندی خرید استانها";
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
<table width="650px" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
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
   // $q1="SELECT *,
	    // (SELECT name_group_kala_top From bzacc.group_kala_top g WHERE g.code_group_kala_top=T.code_group_kala_top) nameGroupKala,
	    // (SELECT name_kala From meat.kala k WHERE k.code_kala=T.code_kala) nameKala
	    // From $TableName T WHERE T.year='$mtActiveYear' AND T.deleted=0";
	
	$q1="SELECT T.*,eblagh_kharid.*,ostan.name_ostan FROM $TableName T 
		  INNER JOIN eblagh_kharid ON T.id_eblagh=eblagh_kharid.id_eblagh
		  INNER JOIN ostan ON ostan.code_ostan=T.code_ostan
		  WHERE T.id_sahmiebandy='$id_sahmiebandy_' AND T.deleted=0";
	
	$all = $db->query($q1);
    $row1=$db->fetch_assoc($all);
	echo'
	  <tr class="print_tr1">
	   <td colspan="2">
        <table border=0 width=100% class="boldtext" style="line-height:30px;">
	     <tr>		 
		  <td align="right"> شماره ابلاغ : '.$row1['shomare_eblagh'].'</td> 
		 </tr>
	     <tr>
	      <td align="right"> مقدار خرید : '.virgul($row1['meghdar_kharid_keshvar']).'</td>	 
	      <td align="right"> قیمت خرید : '.virgul($row1['gheymat_kharid']).'</td>	 
		 </tr>
	     <tr>
	      <td align="right"> استان : '.$row1['name_ostan'].'</td>	 
	      <td align="right"> سهمیه تخصیص یافته : '.virgul($row1['max_kharid_ostan']).'</td>	 
		 </tr>
	     <tr>
		  <td align="right"> وضعیت خرید : '.$kharidTypeArr[$row1['kharid_type']].'</td>	 
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
<table width="650px" border="1" height="100%" align="center" cellpadding="0" cellspacing="0">
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