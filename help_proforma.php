<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$titr='فرم پروفرما';
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_proforma.php";
$TableName="proforma";
$radif=1;
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link rel="stylesheet" type="text/css" href="styles.css?time()"/>
<link rel="stylesheet" type="text/css" href="styles/jquery-ui-1.8.14.css" />
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 	
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript" src="functions.js?time()"></script>';
echo"
<script type='text/javascript'>
function substitute(id_val,sh_val,tarikh,Keshvar,Forushande)
{
 window.opener.document.myform.id_proforma.value=id_val;
  window.opener.document.myform.shomare_proforma.value=sh_val;
 window.opener.document.myform.tarikh_proforma.value=tarikh;
 window.opener.document.myform.name_keshvar.value=Keshvar;
 window.opener.document.myform.name_forushande.value=Forushande;
 window.opener.document.myform.shomare_proforma.focus();
 window.close();
}
</script>
</head>";
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['ds_search_help_sabt']="";
} 
if(isset($Search_x))
{
  $Mode='';
  $Search_x=""; 
  $temp='';
  if($shomare_proforma)   $temp.=" AND shomare_proforma LIKE '%$shomare_proforma%'";
  if($code_forushande)   $temp.=" AND code_forushande LIKE '$code_forushande'";
  if($temp) {$PageNo=1;$_SESSION['ds_search_help_sabt']=$temp;} else $_SESSION['ds_search_help_sabt']="";
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_proforma.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <tr class="title title_search">
  <td align="center">&nbsp;
   شماره پروفرما : &nbsp;<input type="text" class="textboxme2" name="shomare_proforma" value="'.$shomare_proforma.'" />
   فروشنده : &nbsp;	 '.listbox("code_forushande",$code_forushande,"code_forushande","name_forushande","forushande","","class='text4' style=width:200px;height:25px").'
   <button align="left" class="buttonme" type="submit" name="Search_x" id="sabt"> جستجو &nbsp;<span class="fa fa-search "></span></button>';
   if ($_SESSION['ds_search_help_sabt']) echo'<button type="button" class="buttonme" onClick="window.location=\''.$FileName.'?open_filter=1\'">نمايش همه &nbsp;'.$Show_img.'</button>';
   echo'
  </td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=5%>شناسه</td>
	 <td width=15%>شماره پروفرما</td>
	 <td width=15%>تاریخ صدور</td>
	 <td width=20%>نام فروشنده</td>
	 <td width=10%>کشور مبدأ</td>
	</tr>';
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT T.*,
       (SELECT name_keshvar FROM keshvar where code_keshvar=T.code_keshvar) nameKeshvar,
       (SELECT name_forushande FROM forushande where code_forushande=T.code_forushande) nameForushande,
       (SELECT name_arz FROM arz where code_arz=T.code_arz) nameArz
        From $TableName T  WHERE 1=1 ".$_SESSION['ds_search_help_sabt']."  AND deleted=0";
   $all = $db->query($q1);
   if(mysql_num_rows($all)>0)
   {
	 while($row1=$db->fetch_assoc($all))
    {
	  $editclick="onclick='substitute(\"".$row1['id_proforma']."\",\"".$row1['shomare_proforma']."\",\"".$row1['tarikh_proforma']."\",\"".$row1['nameKeshvar']."\",\"".$row1['nameForushande']."\")'";   
	  if($Cntr++%2) echo'<tr class="table-odd"/>';
      else echo '<tr class="table-even" />';
      echo'
	   <td '.$editclick.'>'.$row1['id_proforma'].'</td>
	   <td '.$editclick.'>'.$row1['shomare_proforma'].'</td>
	   <td '.$editclick.'>'.$row1['tarikh_proforma'].'</td>
	   <td '.$editclick.'>'.$row1['nameKeshvar'].'</td>
	   <td '.$editclick.'>'.$row1['nameForushande'].'</td>
	  </tr>';	 
	}
   }  
   else
	echo '<tr class="table-even"><td colspan="20">اطلاعاتی یافت نشد</td></tr>';
	echo'
   </table>
  </td>
 </tr>';
   
echo'   
 <!--پايان مرکز صفحه -->
</table>
</div>
</form>
</body>
</html>	
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>