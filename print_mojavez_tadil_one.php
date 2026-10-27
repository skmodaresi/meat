<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_mojavez_tadil_one.php";
$TableName="mojavez_tadil";
$today=AsLDate($yymmdd);
$logtime=date('H:i:s');
$titr='چاپ مجوز تعدیل موجودی';
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
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<br/>
<table width="80%" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
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
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
    $q1=("SELECT T.*,kala.name_kala,bastebandy.code_bastebandy,bastebandy.sharh_bastebandy,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.name_ziranbar
		  FROM $TableName T 
		  INNER JOIN kala ON T.code_kala=kala.code_kala
		  INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy
		  INNER JOIN keshvar ON T.code_keshvar=keshvar.code_keshvar
		  INNER JOIN tolidkonande ON T.code_tolidkonande=tolidkonande.code_tolidkonande
		  INNER JOIN list_sardkhane_detail l_s_d ON T.code_ziranbar=l_s_d.code_ziranbar AND T.code_ostan=l_s_d.code_ostan AND T.code_anbar=l_s_d.code_anbar
		  WHERE T.id_mojavez_tadil='$id_mojavez_tadil_'");
	$res1=$db->query($q1);
    $row1=$db->fetch_assoc($res1);
	echo'
	  <tr class="print_tr1">
	   <td colspan="2">
        <table border=0  width=100%>
	     <tr><td align="right"> شماره نامه (درخواست استان) : '.$row1['shomare_nameh_darkhast'].'</td>
	         <td align="right"> تاريخ نامه : '.$row1['tarikh_nameh_darkhast'].'</td>
		     <td align="right"> وضعیت : ';if($row1['status']==0) echo 'جاری'; else echo 'ابطالی </td>';
		 echo'	 
		 </tr>
	     <tr>
		  <td align="right"> شماره مجوز تعدیل : '.$row1['shomare_mojavez_tadil'].'</td>       
		  <td align="right"> تاریخ مجوز تعدیل : '.$row1['shomare_mojavez_tadil'].'</td>       
		  <td align="right"> نوع تعديل : '.$tadilArr[$row1['noe_tadil']].'</td> 
		 </tr>
	    </table>
	   </td>
	  </tr>
	  <tr><td>&nbsp;</td></tr>
	  <tr class="print_tr1">
	   <td valign="top" width="60%">
	    <fieldset class="print-fieldset">
	     <legend>اطلاعات کالا</legend>
	     <table width="100%" height="120px">
	      <tr><td align="right"> کد کالا : '.$row1['code_kala'].'</td><td align="right"> نام کالا : '.$row1['name_kala'].'</td></tr>
	  	  <tr><td align="right"> نوع بسته بندی : '.$row1['sharh_bastebandy'].'</td><td align="right"> نام زیرانبار : '.$row1['name_ziranbar'].'</td></tr>
          <tr><td align="right"> نام کشور : '.$row1['name_keshvar'].'</td><td align="right"> نام تولید کننده : '.$row1['name_tolidkonande'].'</td></tr>
          <tr><td align="right"> کد کارتن : '.$row1['code_karton'].'</td><td align="right"> وزن کارتن : '.$row1['vazn_karton_this'].'</td></tr>
	      		  <tr><td align="right"> تاریخ تولید : '.$row1['sal_tolid_shamsi'].' - '.$mahshamsiArr[$row1['mah_tolid_shamsi']].' - '.$row1['rouz_tolid_shamsi'].'</td></tr>
         </table>
	    </fieldset>
	   </td>
	   <td colspan="" valign="top" width="40%">
	    <fieldset class="print-fieldset">
	     <legend>مقادیر تعدیل</legend>
	     <table width="100%" border="0" height="120px">';
		  if($row1['code_bastebandy']==1)//کارتن
		  {echo'
	  	   <tr><td align="right"> تعداد کارتن : '.($row1['tedad_karton_mojavez']).'</td></tr>
	       <tr><td align="right"> مجموع وزن کارتن ها  : '.$row1['sum_karton_mojavez'].'</td></tr>
	  	   <tr><td align="right"> مقدار ناخالص : '.$row1['meghdar_nakhales_mojavez'].'</td></tr>
	       <tr><td align="right"> مقدار خالص :  '.($row1['meghdar_khales_mojavez']).'</td></tr>';
		  }
		  if($row1['code_bastebandy']==2)//قوطی
		  {
		  echo'
	  	   <tr><td align="right"> تعداد قوطی : '.($row1['tedad_karton_mojavez']).'</td></tr>
	       <tr><td align="right"> مقدار خالص :  '.($row1['meghdar_khales_mojavez']).'</td></tr>';
		  }
		  if($row1['code_bastebandy']==3)//لاشه
		  {
		  echo'
	  	   <tr><td align="right"> تعداد : '.($row1['tedad_karton_mojavez']).'</td></tr>
	       <tr><td align="right"> مقدار خالص :  '.($row1['meghdar_khales_mojavez']).'</td></tr>';
		  }
		  echo'
	      <tr><td align="right"> توضیحات :  '.($row1['tozihat']).'</td></tr>
	     </table>
	    </fieldset>
       </td>
	  </tr>
   </table>
  </td>
 </tr>
 <tr class="print_footer">
  <td align="left">&nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr> 
 <!--پايان مرکز صفحه -->
</table>
<!-- چاپ زیرنویس-->
<table width="80%" border="1" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr class="print_footer">
  <td>نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.'</td>';
   // $dc=mysql_query("SELECT dpt_id FROM mt_typesign WHERE type_id='3' AND code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' order by turn");	
   // while ($dr=mysql_fetch_array($dc))
   // {
	// $vahed=$db->get_from_where("dpt_name,manager","mt_dpt","dpt_id=".$dr[0]." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
    // echo '<td>'.$vahed[0].' :&nbsp;&nbsp;'.$vahed[1].'</td>';
   // }
  echo'
  </td>
 </tr>
</table>
</body>
</html>';
?>