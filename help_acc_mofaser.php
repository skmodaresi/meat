<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$titr='جدول کد مالی فروشنده / کشتی';
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_acc_mofaser.php";
$TableName="acc_mofaser_detail";
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
function substitute(code_val,name_val)
{
 window.opener.document.myform.code_skk.value=code_val;
 window.opener.document.myform.name_skk.value=name_val;
 window.opener.document.myform.code_skk.focus();
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <tr>
  <td class="title title_search"><div onClick="window.location=\''.$FileName.'?parent_page=resid&Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=10%>رديف</td>
	 <td width=20%>کد مالی</td>
	 <td width=70%>نام فروشنده</td>
	</tr>';
	/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_acc_mofaser']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($code_skk)   $temp.=" AND code LIKE '$code'";
     if($name_skk)   $temp.=" AND name LIKE '%$name%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_acc_mofaser']=$temp;} else $_SESSION['mt_search_help_acc_mofaser']="";
    }
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT code,name From mali.acc_mofaser_detail WHERE 1=1 ".$_SESSION['mt_search_help_acc_mofaser']." AND mk=16 order by name asc";
   echo $q1;
   $all = $db->query($q1);
   while($row1=$db->fetch_assoc($all))
   {
	 $editclick="onclick='substitute(\"".$row1['code']."\",\"".$row1['name']."\")'";   
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['code'].'</td>
	  <td '.$editclick.'>'.$row1['name'].'</td>
	 </tr>';
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_acc_mofaser']) 
 echo '
 <!-- فوتر-->
 <tr class="footer" >
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">
    <tr>
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?parent_page=resid&open_filter=1\'"></td>
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
	    <td align="left">کد فروشنده/کشتی : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="code_skk" value="'.$code_skk.'"  onkeypress="return isNumber(event)" style="width:50px"/></td>
	    <td align="left">نام فروشنده/کشتی : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_skk" value="'.$name_skk.'"/></td>
	   </tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr>
        <td colspan="4" align="center" class="title">
		 <input class="buttonme" type="submit" name="Search_x" value="جستجو" >
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?parent_page=resid\'">
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