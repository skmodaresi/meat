<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_mojavez_oftokasry_one.php";
$TableName="mojavez_oftokasry";
$today=AsLDate($yymmdd);
$logtime=date('H:i:s');
$titr='کمیسیون افت و کسری';
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
<br/>
<table width="800px" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
  <tr>
  <td>
   <table width="100%" border="0" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> نسخه ی  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
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
   <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="#747474">';
    $q1="SELECT T.*,
	     (SELECT name_kala From kala WHERE kala.code_kala=T.code_kala) nameKala,
	     (SELECT name_tolidkonande From tolidkonande WHERE tolidkonande.code_tolidkonande=T.code_tolidkonande) nameTolidkonande
		 From $TableName T WHERE 1=1 ".$_SESSION['bz_search_oft']." AND T.id_mojavez='$id_mojavez_'  AND code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 ";
	$res1=$db->query($q1);
    $row1=$db->fetch_assoc($res1);
	//اگر کد استان یک رقمی بود
	if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
    else $code_a=$row1['code_ostan'];
	echo'
	  <tr class="print_tr1" style="line-height:32px">
	   <td colspan="2">
        <table border=0  width=100%>
	     <tr>
		     <td align="right"> شماره نامه استان : '.$row1['shomare_nameh'].'</td>
	         <td align="right"> تاریخ نامه : '.$row1['tarikh_nameh'].'</td>
	         <td align="right"> نام کالا : '.$row1['nameKala'].'</td> 
		 </tr>
		 <tr>
		 	 <td align="right"> تولیدکننده : '.$row1['nameTolidkonande'].'</td> 
		 	 
			 <td align="right" colspan="2"> تاریخ تولید -
			   سال : '.$row1['sal_tolid_shamsi'].'
		 	  -ماه : '.$mahshamsiArr[$row1['mah_tolid_shamsi']].' 
		 	  -روز : '.$row1['rouz_tolid_shamsi'].'</td> 
		 </tr>
	     <tr>
		  <td align="right"> نوع : '.$tadilArr[$row1['noe_oftokasry']].'</td> 
		  <td align="right"> وضعیت : ';if($row1['status']==0) echo 'جاری';else echo 'ابطالی </td>';
         echo'
		 </tr>
         <tr>		 
		  <td align="right"> تعداد :  '.virgul($row1['tedad_oftokasry']).'</td>
		  <td align="right"> مقدار ناخالص :  '.round($row1['meghdar_nakhales_oftokasry'],3).'</td>
		  <td align="right"> مقدار خالص :  '.round($row1['meghdar_khales_oftokasry'],3).'</td>
		 </tr> 
		
		 <tr>
	      <td align="right"> شماره مجوز : '.$row1['shomare_mojavez'].'</td>
	      <td align="right"> تاریخ مجوز : '.$row1['tarikh_mojavez'].'</td>
	     </tr>
         <tr>		 
		  <td align="right">تأیید اولیه نامه : ';if($row1['chktaeed']==1)echo '<span class="fa fa-check-circle fa-2x" ></span>'; else echo '<span class="fa fa-times-circle fa-2x" ></span>'; echo'</td>';	
	      echo'
		  <td align="right">تأیید نهایی : ';if($row1['chktaeed_final']==1)echo '<span class="fa fa-check-circle fa-2x" ></span>'; else echo '<span class="fa fa-times-circle fa-2x" ></span>'; echo'</td>';	
	      echo'
		 </tr>
		 <tr>
		  <td align="right"> توضيحات نامه : '.$row1['tozihat_nameh'].'</td>
		  <td align="right"> توضیحات تکمیلی : '.$row1['tozihat_takmili'].'</td>
		 </tr>';
	    echo' 
		</table>
	   </td>
	  </tr>
   </table>
  </td>
 </tr>
 <tr class="print_footer">
  <td align="left">&nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr> 
 <!--پايان مرکز صفحه -->
<!-- چاپ زیرنویس-->
 <tr>
  <td>
   <table width="100%" border="0" height="100%" align="center" cellpadding="0" cellspacing="0">
    <tr class="print_footer" style="font-size:8pt">
     <td>نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.'</td>';
     if($row1['signiture_tadil']!='')
     {
          $signarray =explode(';',$row1['signiture_tadil']);
	      foreach($signarray as $signID)
	      {
	       $sql_q ="SELECT mt_typesign.manager,mt_dpt.dpt_name FROM mt_typesign INNER JOIN mt_dpt ON mt_typesign.dpt_id=mt_dpt.dpt_id AND mt_typesign.code_ostan=mt_dpt.code_ostan AND mt_typesign.code_anbar=mt_dpt.code_anbar WHERE sign_id=$signID ORDER BY turn";
	       $sql_res=mysql_query($sql_q);
	       $row_n=mysql_fetch_assoc($sql_res);
	       echo '<td>'.$row_n['dpt_name'].' :&nbsp;&nbsp;'.$row_n['manager'].'</td>';
	      }
     }
     echo'
    </tr>';
	 //تعداد توضیحات	
     $tozihCount=$db->get_from_where("COUNT(*)","mt_typetozih","type_id='6' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");     
	 if($tozihCount>0)
	 {
	   echo'
	   <tr class="print_footer">';
	   $tozihat_q=$db->query("SELECT form_tozihat FROM mt_typetozih WHERE type_id='6' AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");	
       while ($tozih=$db->fetch_array($tozihat_q)) echo '<td>'.$tozih[0].'</td>';
       echo'</tr>';
	 }
	 echo'
   </table>
  </td>
 </tr>
 </table>	
</body>
</html>';
?>