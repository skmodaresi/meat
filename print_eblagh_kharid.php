<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_eblagh_kharid.php";
$TableName="eblagh_kharid";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$radif=1;
$titr='ابلاغ خرید';
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
$columns='	
    <tr class="print_table-title2">
	 <td width="5%">رديف</td>
	 <td width="20%">شماره ابلاغ</td>
	 <td width="10%">تاریخ ابلاغ</td>
	 <td width="10%">نوع محموله</td>
	 <td width="10%">گروه کالا</td>
	 <td width="15%">مقدار خرید (کیلوگرم)</td>
	 <td width="15%">جمع کل سهمیه تخصیصی</td>
	 <td width="15%">مانده از سهمیه تخصیصی</td>
	</tr> ';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!--هدر-->
 <br/>
 <table width="99%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2">'.$titr.' &nbsp&nbsp(صفحه : 1)
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
   $q1="SELECT T.*,
	    (SELECT name_group_kala_top From bzacc.group_kala_top g WHERE g.code_group_kala_top=T.code_group_kala_top) nameGroupKala,
	    (SELECT COUNT(*) FROM sahmiebandy_kharid WHERE sahmiebandy_kharid.id_eblagh=T.id_eblagh AND deleted=0 $condition_ostan) sahmiecount,
	    (SELECT COUNT(*) FROM dastorolamal_kharid WHERE dastorolamal_kharid.id_eblagh=T.id_eblagh AND deleted=0) dastorolcount
		From $TableName T WHERE 1=1 ".$_SESSION['mt_search_eblagh']." AND T.deleted=0 order by id_eblagh asc";
   $all = $db->query($q1);
   $cntr =mysql_num_rows($all);
   while($row1=$db->fetch_assoc($all))
   {
     $line++;
	 if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
	 $sum_sahmie=$db->get_from_where("SUM(max_kharid_ostan)","meat.sahmiebandy_kharid","id_eblagh=".$row1['id_eblagh']." AND deleted=0");
	 $mande_sahmie=$row1['meghdar_kharid_keshvar']-$sum_sahmie;
	 echo'
	  <td>'.$radif++.'</td>
	  <td '.$edtClick.'>'.$row1['shomare_eblagh'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_eblagh'].'</td>
	  <td '.$edtClick.'>'.$mahmuletypeArr[$row1['mahmule_type']].'</td>
	  <td '.$edtClick.'>'.$row1['nameGroupKala'].'</td>
	  <td '.$edtClick.'>'.virgul($row1['meghdar_kharid_keshvar']).'</td>
	  <td '.$edtClick.'>'.virgul($sum_sahmie).'</td>
	  <td '.$edtClick.'>'.virgul($mande_sahmie).'</td>
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
      <tr><td class="print_title_2">'.$titr.'&nbsp&nbsp(صفحه : '.$page.')</td></tr>
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