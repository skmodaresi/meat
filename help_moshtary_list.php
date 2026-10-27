<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_moshtary.php";
if($_SESSION['mt_systemforush']==0){$TableName="moshtary";}
if($_SESSION['mt_systemforush']==1)
{
 mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
 $TableName="dm_customer_asli";
 //پیدا کردن آی دی کد استان مربوط به سیتم فروش
 //$res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
 //$sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
}
$radif=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>جدول کد مشتریان</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>';
echo"
<script type='text/javascript'>
function substitute(code_val)
{
 window.opener.document.myform.code_customer.value=code_val;
 window.opener.document.myform.code_customer.focus();
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_customer.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جدول کد مشتریان</td>
 </tr>	 
 <tr>
  <td class="title" style="background-color:#3d9bb9;"><div onClick="window.location=\''.$FileName.'?Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden; ">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	 <tr class="table-title">
	  <td width="15%">رديف</td>
	  <td width="30%">کد مشتری</td>
	  <td width="55%">نام مشتری</td>
	 </tr>';
	/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mtsearch_help_moshtary']="";
    } 
    if(isset($Search_x))
    {
	 if($_SESSION['mt_systemforush']==0)//سردخانه
     {
       $Mode='';
       $Search_x=""; 
       $temp='';
       if($code_customer) $temp.=" and code_customer LIKE '%$code_customer%'";
       if($name_customer) $temp.=" and name_customer LIKE '%$name_customer%'";
       if($temp) {$PageNo=1;$_SESSION['mtsearch_help_moshtary']=$temp;} else $_SESSION['mtsearch_help_moshtary']="";
     }
	 if($_SESSION['mt_systemforush']==1)//فروش
     {
        $name_customer=str_replace("ی","ي",$name_customer);
        $name_customer=str_replace("ک","ك",$name_customer);
        $Mode="";
        $Search_x="";
        $temp="";
        if($code_customer)           $temp.=" and code_customer LIKE '%$code_customer%'";
        if($name_customer)           $temp.=" and name_customer LIKE '%$name_customer%'";
        if($temp) {$PageNo=1;$_SESSION['mtsearch_help_moshtary']=$temp;} else $_SESSION['mtsearch_help_moshtary']="";
     }
    }
	/*************END SEARCH ******/
   $Cntr=0;
   if($_SESSION['mt_systemforush']==0) $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mtsearch_help_moshtary']." order by customer_id asc";
   //if($_SESSION['mt_systemforush']==1) $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mtsearch_help_moshtary']." AND customer_code_org='$mt_gl_code_ostan' AND LENGTH(trim(code_economic_customer))>=10  order by customer_id asc";
   //if($_SESSION['mt_systemforush']==1) $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mtsearch_help_moshtary']." AND customer_province_id='$sell_id_ostan' AND LENGTH(trim(code_economic_customer))>=10  order by customer_id asc";
   if($_SESSION['mt_systemforush']==1) $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mtsearch_help_moshtary']." AND LENGTH(trim(code_economic_customer))>=10 order by customer_id asc";
   $allMoshtary = $db->query($q1);
   while($row1=$db->fetch_assoc($allMoshtary))
   {
   	$editclick="onclick='substitute(\"".$row1['code_customer']."\")'";   
	 if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even"/>';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['code_customer'].'</td>
	  <td '.$editclick.'>'.$row1['name_customer'].'</td>';
	echo '
	</tr>';
   }
   echo'
   </table>
   </div>
  </td>
 </tr>
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mtsearch_help_moshtary']) 
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
       <tr class="title"><td colspan="4" align="center">جستجوی مشتریان</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left">کد مشتری : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="code_customer" value="'.$code_customer.'" maxlength="5" title="برای کد مشتری عددی مابین 12000 تا 99000 وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/></td>
	    <td align="left">نام مشتری : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_customer" value="'.$name_customer.'"/></td>
	   </tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr>
        <td colspan="4" align="center">
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