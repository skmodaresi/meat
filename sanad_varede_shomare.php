<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="sanad_varede_shomare.php";
$titr='ایجاد سند حسابداری وارده به سردخانه براساس شماره رسید';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body onload="document.myform.shomare1.focus();">
<form method="POST" action="downfile.php" name="myform">
<div align="center">
<table width="700px" align="center" cellpadding="0" cellspacing="0">
<img src="images/loading.gif" id="loading" class="loading_img"/>
 <tr>
  <td height="100%">
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">'.$titr.'</td></tr>
	<tr class="tr1" style="height:70px">';	
    //اضافه کردن صفر پشت کد استان		
	 if(strlen($mt_gl_code_ostan)==1) {$code_a=make_pattern($mt_gl_code_ostan,2);}
     else{$code_a=$mt_gl_code_ostan;}	
     echo'
	 <td align="left"> از شماره رسید : </td><td align="right">&nbsp;<input type="text" maxlength="5" class="textboxme2" name="resid_from" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
     <td align="left"> تا شماره رسید : </td><td align="right">&nbsp;<input type="text" maxlength="5" class="textboxme2" name="resid_to" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>	
	 <input type="text" name="status" value="varede" hidden/>
	</tr>
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="ایجاد سند"></td></tr> 
   </table>
  </td>
 </tr>	
</table>
</div>
</form>
</body>
</html>';	
?>