<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_users.php";
$TableName="users";
$radif=1;
$titr='چاپ کاربران سیستم سردخانه';
IF(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $Condition="";
ELSE  $Condition="AND code_ostan='$mt_gl_code_ostan'";
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
 .pbreak{ page-break-after : always } ;
</style>
</head>';
$columns='
   <tr class="print_table-title2">
	 <td width="5%">رديف</td>
	 <td width="5%">کد کاربر</td>
	 <td width="9%">نام</td>
	 <td width="9%">نام خانوادگی</td>
	 <td width="9%">نام کاربر</td>
	 <td width="9%">گروه کاربر</td>
	 <td width="9%">استان کاربر</td>
	 <td width="9%">تلفن همراه</td>
	 <td width="9%">تلفن تماس</td>
	 <td width="9%">پست الکترونیک</td>
	 <td width="9%">دسترسی به کل انبارها</td>
	 <td width="9%">تعداد انبارهای قابل دسترسی</td>
	</tr>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
 <!--هدر-->
  <br/>
  <table width="99%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2">'.$titr.'&nbsp&nbsp(صفحه : 1)
	 <a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
	</td>
	</tr>
  </table>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
  <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
   echo $columns;
   $q1="SELECT *,
		(SELECT count(*) FROM user_ostan_anbar u_o_a WHERE u_o_a.user_id=T.user_id AND u_o_a.code_ostan=T.code_ostan) detailcount,
	    (SELECT name_ostan FROM ostan WHERE ostan.code_ostan=T.code_ostan)nameOstan, 
	    (SELECT role_description FROM roles WHERE roles.role_id=T.role_id)roleDescription 
		From $TableName T WHERE 1=1 $condition ".$_SESSION['mt_search_users']." order by id";
	$allUsers = $db->query($q1);
   $page=1;
   $line=0;
   $i=0;$cntr=0;
   $MaxLines=20;
   $cntr =mysql_num_rows($allUsers);
   while($row1=$db->fetch_assoc($allUsers))
   {
     $line++;
	 if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     if($row1['chkforush'] == 1) $checked ='بلی';
     else $checked ='خیر';
	 echo'
	  <td>'.$radif++.'</td>
	  <td>'.$row1['user_id'].'</td>
	  <td>'.$row1['first_name'].'</td>
	  <td>'.$row1['last_name'].'</td>
	  <td>'.$row1['user_name'].'</td>
	  <td>'.$row1['roleDescription'].'</td>
	  <td>'.$row1['nameOstan'].'</td>
	  <td>'.$row1['mobile'].'</td>
	  <td>'.$row1['tel'].'</td>
	  <td>'.$row1['email'].'</td>
	  <td>'; IF ($row1['chkallostan']==1) echo 'بلی' ; ELSE echo 'خیر';echo'</td>
	  <td>'.$row1['detailcount'].'</td>
	  
	</tr>';
	 if ($line>=$MaxLines && $i <$cntr) 
	 {
	    $line=0;
        $page++;
	    echo'
		  </table>
		  <br class="pbreak">
		  <table width="99%" border="1" align="center">
           <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
           <tr><td class="print_title_2">'.$titr.'&nbsp&nbsp(صفحه : '.$page.')
	       	</td>
	       </tr>
          </table>
		  <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
          echo $columns;		  
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