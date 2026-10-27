<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_kala.php";
$TableName="kala";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$radif=1;
$titr='چاپ کالا';
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
	 <tr class="print_table-title">
	  <td width="%">رديف</td>
	  <td width="%">کد کالا</td>
	  <td width="%">نام کالا</td>
	  <td width="%">واحد کالا</td>
	  <td width="%">بسته بندی</td>
	  <td width="%">گروه کالا اصلی</td>
	  <td width="%">گروه کالا میانی</td>
	  <td width="%">گروه کالا</td>
	  <td width="">نوع گوشت</td>
	  <td width="">نوع محموله</td>
	  <td width="%">ايران کد</td>
	  <td width="%">عنوان ايران کد</td>
	  <td width="%">کد شبنم</td>
	  <td width="%">عنوان شبنم</td>
	  <td width="%">از سريال شبنم</td>
	  <td width="%">تا سريال شبنم</td>
	  <td width="%">کد GS1</td>
	  <td width="%">عنوان GS1</td>
	  <td width="%">کد HS</td>
	  <td width="%">عنوان HS</td>
	  <td width="%">کد نرخ استاندارد</td>
	  <td width="%">نرخ استاندارد</td>	 
	  <td width="%">تاریخ ماندگاری</td>
      <td width="%">توضيحات کالا</td>	  
	 </tr>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
 <!--هدر-->
   <br/>
   <table width="99%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> سردخانه  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">جدول کالا&nbsp&nbsp(صفحه : 1)
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
   $MaxLines=20;
   $q1="SELECT *,
       (SELECT name_group_kala_top FROM bzacc.group_kala_top WHERE group_kala_top.code_group_kala_top=T.code_group_kala_top) groupTopName,
       (SELECT name_group_kala_middle FROM group_kala_middle WHERE group_kala_middle.code_group_kala_middle=T.code_group_kala_middle) groupMiddleName,
	   (SELECT sharh_vahedkala FROM vahed_kala WHERE vahed_kala.code_vahedkala=T.code_vahedkala) vahed,
       (SELECT name_group_kala FROM group_kala WHERE group_kala.code_group_kala=T.code_group_kala) groupKala,
	   (SELECT sharh_bastebandy FROM bastebandy WHERE bastebandy.code_bastebandy=T.code_bastebandy) bastebandy
 		From $TableName T WHERE 1=1 ".$_SESSION['mt_search_kala']." order by code_kala ASC";
   $allKala = $db->query($q1);
   $cntr =mysql_num_rows($allKala);
   while($row1=$db->fetch_assoc($allKala))
   {
     $Line++;
     if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     echo'
	  <td>'.$radif++.'</td>
	  <td>'.$row1['code_kala'].'</td>
	  <td>'.$row1['name_kala'].'</td>
	  <td>'.$row1['vahed'].'</td>
	  <td>'.$row1['bastebandy'].'</td>
	  <td>'.$row1['groupTopName'].'</td>
	  <td>'.$row1['groupMiddleName'].'</td>
	  <td>'.$row1['groupKala'].'</td>
	  <td>'.$goshttypeArr[$row1['gosht_type']].'</td>
	  <td>'.$mahmuletypeArr[$row1['mahmule_type']].'</td>
	  <td>'.$row1['iran_code'].'</td>
	  <td>'.$row1['onvan_iran_code'].'</td>
	  <td>'.$row1['code_shabnam'].'</td>
	  <td>'.$row1['onvan_shabnam'].'</td>
	  <td>'.$row1['az_serial_shabnam'].'</td>
	  <td>'.$row1['ta_serial_shabnam'].'</td>
	  <td>'.$row1['code_gs1'].'</td>
	  <td>'.$row1['onvan_gs1'].'</td>
	  <td>'.$row1['code_hs'].'</td>
	  <td>'.$row1['onvan_hs'].'</td>
	  <td>'.$row1['code_nerkh_standard'].'</td>
	  <td>'.$row1['nerkh_standard'].'</td>
	  ';  
	  $mandegariarray=array();
	  $mandegari='';
	  $mandegariarray = explode(';',$row1['mandegari']);
	   foreach($mandegariarray as $c_mandegari)
	   {
		$sql_q ="SELECT * FROM tarikh_mandegari WHERE code_mandegari='$c_mandegari'";
	    $sql_res=mysql_query($sql_q);
	    $row_n=mysql_fetch_assoc($sql_res);
		$mandegari.=' '.$row_n['sharh_mandegari'].'';
	   }
	 echo '
	  <td>'.$mandegari.'</td>
	  <td>'.$row1['tozihat_kala'].'</td>
	 </tr>';
	  if ($line>=$MaxLines && $i <$cntr) 
	  {
	     $line=0;
         $page++;
	     echo'
		   </table>
		   <br class="pbreak">
           <br/>
		   <table width="99%" border="1" align="center">
            <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
            <tr><td class="print_title_2"> سردخانه  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
            <tr><td class="print_title_2">جدول کالا&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
           '.$columns.'';
	  }
	}
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