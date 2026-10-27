<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_dastorolamal_search.php";
$radif=1;
$titr='دستورالعمل خرید';
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(shomare_dastor)
{
 window.opener.document.myform.shomare_dastorolamal.value=shomare_dastor;
 window.opener.document.myform.shomare_dastorolamal.focus();
 window.close();
}
</script>
</head>";
/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_dastorolamal_s']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($shomare_dastorolamal)   $temp.=" AND shomare_dastorolamal LIKE '%$shomare_dastorolamal%'";
     if($tarikh_dastorolamal)   $temp.=" AND tarikh_dastorolamal LIKE '%$tarikh_dastorolamal%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_dastorolamal_s']=$temp;} else $_SESSION['mt_search_help_dastorolamal_s']="";
    }
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <tr class="title title_search">
  <td align="center">&nbsp;
  شماره : &nbsp;<input type="text" class="textboxme2" name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'" onkeypress="return isNumber(event)" style="width:50px"/>
  تاریخ : &nbsp;<input type="text" class="textboxme2" name="tarikh_dastorolamal" value="'.$tarikh_dastorolamal.'" onkeypress="return isNumber(event)" style="width:50px"/>
  <button align="left" class="buttonme" type="submit" name="Search_x" id="sabt"> جستجو &nbsp;<span class="fa fa-search "></span></button>';
   if ($_SESSION['mt_search_help_dastorolamal_s']) echo'<button type="button" class="buttonme" onClick="window.location=\''.$FileName.'?open_filter=1\'">نمايش همه &nbsp;<span class="fa fa-clipboard"></span></button>';
   echo'
  </td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td>رديف</td>
	 <td>شماره دستورالعمل</td>
	 <td>تاریخ دستورالعمل</td>
	 <td>تاریخ شروع اعتبار</td>
	</tr>';
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT * From dastorolamal_kharid WHERE 1=1 ".$_SESSION['mt_search_help_dastorolamal_s']." AND activate=1 order by id_dastorolamal asc";
   $all = $db->query($q1);
   while($row1=$db->fetch_assoc($all))
   {
	 $editclick="onclick='substitute(\"".$row1['shomare_dastorolamal']."\")'";   
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['shomare_dastorolamal'].'</td>
	  <td '.$editclick.'>'.$row1['tarikh_dastorolamal'].'</td>
	  <td '.$editclick.'>'.$row1['tarikh_shoro_etebar'].'</td>
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
</form>
</body>
</html>';	
?>