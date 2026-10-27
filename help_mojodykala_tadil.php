<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>window.location='mainpage.php';</script>";
$FileName="help_mojodykala_tadil.php";
$TableName="mojody_kala";
$radif=1;
if(!$inputName) $inputName='id_mojody';
//echo $id_mojody;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>جدول موجودی کالا</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
<!--هر کدام از این فیلدها در صفحه مبدأ نباشد این تابع درست کار نمیکند -->
<!--پس اگر لازم نداریم بگذاریم و آن فیلد را پنهان کنیم-->
<!--مجبور شدیم دو بار ماه تولید شمسی را ارسال کنیم در دو فیلد با اسم های مختلف-->
function substitute(id_val,c_kesh,n_kesh,sal_t_sh,mah_t_sh,sal_t_m,mah_t_m,m_khales,m_nakhales,tedad_k)
{
 window.opener.document.myform.id_mojody.value=id_val;
 window.opener.document.myform.code_keshvar.value=c_kesh;
 window.opener.document.myform.name_keshvar.value=n_kesh;
 window.opener.document.myform.sal_tolid_shamsi.value=sal_t_sh;
 window.opener.document.myform.mah_tolid_sh.value=mah_t_sh;
 window.opener.document.myform.mah_tolid_shamsi.value=mah_t_sh;
 window.opener.document.myform.sal_tolid_milady.value=sal_t_m;
 window.opener.document.myform.mah_tolid_milady.value=mah_t_m;
 window.opener.document.myform.mojody_khales.value=m_khales;
 window.opener.document.myform.mojody_nakhales.value=m_nakhales;
 window.opener.document.myform.tedad_karton.value=tedad_k;
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جدول موجودی کالا</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td rowspan="2" width=5%>رديف</td>
	 <td rowspan="2" width=5%>کد کالا</td>
	 <td rowspan="2" width=20%>نام کالا</td>
	 <td rowspan="2" width=10%>کد کشور</td>
	 <td rowspan="2" width=10%>نام کشور</td>
	 <td colspan="2" width=20%>تاریخ تولید</td>
	 <td rowspan="2" width=15%>موجودی ناخالص</td>
	 <td rowspan="2" width=15%>موجودی خالص</td>
	  <tr class="table-title">
	   <td>سال تولید</td>
	   <td>ماه تولید</td>
	  </tr>
	</tr>';
   $Cntr=0;
   $q1="SELECT *,
       (SELECT name_kala FROM kala k WHERE k.code_kala=T.code_kala) nameKala,
       (SELECT name_keshvar FROM keshvar WHERE keshvar.code_keshvar=T.code_keshvar) nameKeshvar
       From $TableName T WHERE code_kala='$code_kala_' AND code_ostan=$sard_gl_code_ostan AND code_anbar=$gl_code_sardkhane AND year=$sardActiveYear order by id asc";
   //echo $q1;
   $allMojody = $db->query($q1);
   while($row1=$db->fetch_assoc($allMojody))
   {
	//$editclick="onclick='substitute(\"".$row1['id']."\")'";   
 	$editclick="onclick='substitute(\"".$row1['id']."\",\"".$row1['code_keshvar']."\",\"".$row1['nameKeshvar']."\",\"".$row1['sal_tolid_shamsi']."\",\"".$row1['mah_tolid_shamsi']."\",\"".$row1['sal_tolid_milady']."\",\"".$row1['mah_tolid_milady']."\",\"".$row1['mojody_khales']."\",\"".$row1['mojody_nakhales']."\",\"".$row1['tedad_karton']."\")'";
	 if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['code_kala'].'</td>
	  <td '.$editclick.'>'.$row1['nameKala'].'</td>
	  <td '.$editclick.'>'.$row1['code_keshvar'].'</td>
	  <td '.$editclick.'>'.$row1['nameKeshvar'].'</td>
	  <td '.$editclick.'>'.$row1['sal_tolid_shamsi'].'-'.$row1['sal_tolid_milady'].'</td>
	  <td '.$editclick.'>'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'-'.$mahmiladyArr[$row1['mah_tolid_milady']].'</td>
	  <td '.$editclick.'>'.$row1['mojody_nakhales'].'</td>
	  <td '.$editclick.'>'.$row1['mojody_khales'].'</td>';
	 echo '
	 </tr>';
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->	
</table>
</div>
</body>
</html>';	
?>