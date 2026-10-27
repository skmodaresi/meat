<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_resid.php";
$TableName="resid";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$count=1;
$titr='رسیدهای سردخانه';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform">
<div align="center">
<table width="98%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td>
   <table width="100%" border="0" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> رسید های انبار : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
   </table>
  </td>
 </tr> 
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
   $RowPerPage=25;
   $Page=0;
   $Line=100;
   $Cntr=0;
   $q1="SELECT *,
   (SELECT name_skk FROM keshty WHERE keshty.code_skk=T.code_skk) nameKeshty,  
   (SELECT shomare_safar FROM shomare_safar WHERE shomare_safar.id_safar=T.id_safar) shomareSafar,  
   (SELECT name_mabda FROM mabady_vorudy WHERE mabady_vorudy.code_mabda=T.code_mabda) nameBandar,   
   (SELECT sharh_takhlie FROM takhlie WHERE takhlie.code_takhlie=T.code_takhlie) sharhTakhlie,
   (SELECT name_peymankar_haml FROM peymankar_haml WHERE peymankar_haml.code_peymankar_haml=T.code_peymankar_haml) namePeymankar  
    From $TableName T WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by id desc";
   $allResid = $db->query($q1);
   while($row1=$db->fetch_assoc($allResid))
   {if ($Line>=$RowPerPage)
    {if ($Page) echo "<br>";
     $Line=0; 
	 echo'
	 <tr class="print_table-title" style="height:60px;">
	  <td width="%">رديف</td>
	  <td width="%">شماره رسيد</td>
	  <td width="%">نام کشتی</td>
	  <td width="%">شماره سفر</td>
	  <td width="%">مبدأ بارگیری</td>
	  <td width="%">نوع تخلیه</td>
	  <td width="%">شماره باسکول</td>
	  <td width="%">شماره بارنامه</td>
	  <td width="%">تاریخ بارنامه</td>
	  <td width="%">شماره کامیون</td>
	  <td width="%">نام راننده</td>
	  <td width="%">کدملی راننده</td>
	  <td width="%">نوع تحویل بار</td>
	  <td width="%">کد کالا</td>
	  <td width="%">شرکت حمل کننده</td>	  
	  <td width="%">وزن مبدأ</td>	  
	  <td width="%">وزن کامیون بابار</td>	  
	  <td width="%">وزن کامیون</td>	  
	  <td width="%">وزن خالص</td>	  	  
	  <td width="%">مبلغ پردلختی</td>
	  <td width="%">وضعیت</td>	  
	 </tr>';
      }
     $Line++;
     if($Cntr++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
	 if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
     else $code_a=$row1['code_ostan'];
	 echo'	  
	  <td>'.$count++.'</td>
	  <td>'.$code_a.$row1['code_anbar'].$row1['shomare_resid'].'</td>
	  <td>'.$row1['nameKeshty'].'</td>
	  <td>'.$row1['shomareSafar'].'</td>
	  <td>'.$row1['nameBandar'].'</td>
	  <td>'.$row1['sharhTakhlie'].'</td>
	  <td>'.$row1['bsk_no'].'</td>
      <td>'.$row1['barname_no'].'</td>
	  <td>'.$row1['barname_tarikh'].'</td>
	  <td>'.$row1['kamion_no'].'</td>
	  <td>'.$row1['ranande_name'].'</td>
	  <td>'.$row1['ranande_melicode'].'</td>
	  <td>'.$tahvilbarArr[$row1['noe_tahvil_bar']].'</td>
	  <td>'.$row1['code_kala'].'</td>
	  <td>'.$row1['namePeymankar'].'</td>
	  <td>'.$row1['vazn_mabda'].'</td>
	  <td>'.$row1['vazn_kamiyon_bar'].'</td>
	  <td>'.$row1['vazn_kamiyon'].'</td>
	  <td>'.$row1['vazn_khales'].'</td>
	  <td>'.($row1['mablagh_pardakhty']).'</td>
	  <td>';if($row1['status']==0) echo 'جاری';else echo 'ابطالی </td>';
	 echo '
	 </tr>';
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
 <tr class="print_footer">
  <td colspan="3">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr> 
</table>
</div>
</form>
</body>
</html>';	
?>