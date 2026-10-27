<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_keshvar.php";
$TableName="keshvar";
$radif=1;
if(!$inputName) $inputName='code_keshvar';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جدول کد کشور</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(code_val)
{
 window.opener.document.myform.".$inputName.".value=code_val;
 window.opener.document.myform.".$inputName.".focus();
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_keshvar.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جدول کد کشور</td>	 
 </tr>
 <tr>
  <td class="title title_search" style="background-color:#3d9bb9;"><div onClick="window.location=\''.$FileName.'?Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=20%>رديف</td>
	 <td width=20%>کد کشور</td>
	 <td width=60%>نام کشور</td>
	</tr>';
	/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_keshvar']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($code_keshvar)   $temp.=" AND code_keshvar LIKE '$code_keshvar'";
     if($name_keshvar)   $temp.=" AND name_keshvar LIKE '%$name_keshvar%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_keshvar']=$temp;} else $_SESSION['mt_search_help_keshvar']="";
    }
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mt_search_help_keshvar']."  order by id asc";
   $allKeshvar = $db->query($q1);
   while($row1=$db->fetch_assoc($allKeshvar))
   {
	 $editclick="onclick='substitute(\"".$row1['code_keshvar']."\")'";   	
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['code_keshvar'].'</td>
	  <td '.$editclick.'>'.$row1['name_keshvar'].'</td>';
	 echo '
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_keshvar']) 
 echo '
 <!-- فوتر-->
 <tr class="footer">
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
	  <table border="0" bgcolor="#E9F7FD" align="center" width="100%" cellpadding="0" cellspacing="0" style="position:absolute;top:150px;">
       <tr class="title"><td colspan="4" align="center">جستجوی کشور</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left">کد کشور : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="code_keshvar" value="'.$code_keshvar.'"  onkeypress="return isNumber(event)" style="width:50px"/></td>
	    <td align="left">نام کشور : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_keshvar" value="'.$name_keshvar.'"/></td>
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