<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$titr='سهمیه بندی خرید استانها';
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_sahmiebandy.php";
$TableName="sahmiebandy_kharid";
$radif=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(id)
{
 window.opener.document.myform.id_sahmiebandy.value=id;
 window.opener.document.myform.shomare_dastorolamal.focus();
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_forushande.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <tr>
  <td class="title title_search"><div onClick="window.location=\''.$FileName.'?Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=5%>رديف</td>
	 <td width=20%>شماره دستورالعمل</td>
	 <td width=20%>شماره ابلاغ</td>
	 <td width=30%>نام کالا</td>
	 <td width=25%>حداکثر مقدار خرید</td>
	</tr>';
	/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_forushande']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($code_forushande)   $temp.=" AND code_forushande LIKE '$code_forushande'";
     if($name_forushande)   $temp.=" AND name_forushande LIKE '$name_forushande'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_forushande']=$temp;} else $_SESSION['mt_search_help_forushande']="";
    }
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT *,kala.name_kala
	    From $TableName T INNER JOIN eblagh_kharid ON T.id_eblagh=eblagh_kharid.id_eblagh
		INNER JOIN kala ON kala.code_kala=eblagh_kharid.code_kala
		WHERE 1=1 ".$_SESSION['mt_search_help_forushande']." AND T.year='$mtActiveYear' AND T.deleted=0";
   $all = $db->query($q1);
   while($row1=$db->fetch_assoc($all))
   {
	$editclick="onclick='substitute(\"".$row1['id_sahmiebandy']."\")'";   
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['shomare_dastorolamal'].'</td>
	  <td '.$editclick.'>'.$row1['shomare_eblagh'].'</td>
	  <td '.$editclick.'>'.$row1['name_kala'].'</td>
	  <td '.$editclick.'>'.virgul($row1['max_kharid_ostan']).'</td>';
	 echo '
	 </tr>';
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_forushande']) 
 echo '
 <!-- فوتر-->
 <tr class="footer" >
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">
    <tr>
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?open_filter=1\'"></td>
    </tr>
   </table>
  </td>
 </tr>';	  
 if($Mode=="Search")
 {
   echo'
	<tr> 
	 <td> 	 
      <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0" style="position:absolute;top:150px;">
	   <tr class="title"><td colspan="4" align="center">جستجو</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left">کد : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_forushande" value="'.$code_forushande.'"/></td>
	    <td align="left">نام : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_forushande" value="'.$name_forushande.'"/></td>
	   </tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr>
        <td colspan="4" align="center" class="title">
		 <input class="buttonme" type="submit" name="Search_x" value="جستجو" >
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'\'">
        </td>
       </tr>
	  </table>
	 </td>
    </tr>';
  }
 echo' 
</table>
</div>
</form>
</body>
</html>';	
?>