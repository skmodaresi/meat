<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_karton.php";
$TableName="karton";
$radif=1;
if(!$inputName) $inputName='code_karton';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جدول کد کارتن</title>
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
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_karton.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جدول کد کارتن</td>	 
 </tr>
 <tr>
  <td class="title title_search"><div onClick="window.location=\''.$FileName.'?Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=10%>رديف</td>
	 <td width=20%>کد کارتن</td>
	 <td width=40%>شرح کارتن</td>
	 <td width=30%>وزن کارتن</td>
	</tr>';
    /*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_karton']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($code_karton)    $temp.=" AND code_karton LIKE '$code_karton'";
     if($sharh_karton)   $temp.=" AND sharh_karton LIKE '%$sharh_karton%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_karton']=$temp;} else $_SESSION['mt_search_help_karton']="";
    }
	/*************END SEARCH ******/
   $Cntr=0;
   //$q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mt_search_help_karton']." AND code_ostan=$mt_gl_code_ostan AND code_bastebandy=1 order by id asc";
   $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mt_search_help_karton']." AND code_bastebandy=1 order by id asc";
   $allKarton = $db->query($q1);
   while($row1=$db->fetch_assoc($allKarton))
   {
	$editclick="onclick='substitute(\"".$row1['code_karton']."\")'";   	
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['code_karton'].'</td>
	  <td '.$editclick.'>'.$row1['sharh_karton'].'</td>
	  <td '.$editclick.'>'.$row1['vazn_karton'].'</td>
	  ';
	 echo '
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_karton']) 
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
       <tr class="title"><td colspan="4" align="center">جستجوی کارتن</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left">کد کارتن : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="code_karton" value="'.$code_karton.'"  onkeypress="return isNumber(event)" style="width:50px"/></td>
	    <td align="left">شرح کارتن : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="sharh_karton" value="'.$sharh_karton.'"/></td>
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