<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_kala.php";
$TableName="kala";
$radif=1;
$titr='جدول کد کالا';
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
function substitute(code_val)
{
 window.opener.document.myform.".$inputName.".value=code_val;
 window.opener.document.myform.".$inputName.".focus();
 window.close();
}
</script>
</head>";
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_help_kala']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($code_kala)     $temp.=" AND code_kala LIKE '$code_kala'";
 if($name_kala)     $temp.=" AND name_kala LIKE '%$name_kala%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_help_kala']=$temp;} else $_SESSION['mt_search_help_kala']="";
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr><td class="title">'.$titr.'</td></tr>
 <tr class="title title_search">
   <td align="center">&nbsp;
    کد : &nbsp;<input type="text" class="textboxme" name="code_kala" value="'.$code_kala.'"  onkeypress="return isNumber(event)" style="width:50px"/>
    نام : &nbsp;<input type="text" class="textboxme" name="name_kala" value="'.$name_kala.'" style="width:200px"/>
    <button align="left" class="buttonme" type="submit" name="Search_x" id="sabt"> جستجو &nbsp;<span class="fa fa-search "></span></button>';
    if ($_SESSION['mt_search_help_kala']) echo'<button type="button" class="buttonme" onClick="window.location=\''.$FileName.'?open_filter=1\'">نمايش همه &nbsp;<span class="fa fa-clipboard"></span></button>';
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
	 <td width=10%>رديف</td>
	 <td width=20%>کد کالا</td>
	 <td width=70%>نام کالا</td>
	</tr>';
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mt_search_help_kala']." order by id asc";
   $allKala = $db->query($q1);
   while($row1=$db->fetch_assoc($allKala))
   {
	$editclick="onclick='substitute(\"".$row1['code_kala']."\")'";   
	//$edtClick='onClick="window.location=\''.$FileName_.'?mysess_="'.$_SESSION['codeKala'].'"\'"';	
	//$edtClick='onClick="window.location=\''.$FileName_.'?&id_='.$row1['id'].'\'"';	
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['code_kala'].'</td>
	  <td '.$editclick.'>'.$row1['name_kala'].'</td>';
	 echo '
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
</html>	
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript">
   function doNow(ch)
   { if(ch=="on") ck=1; else ck=0;
   void(d=document);
   void(el=d.getElementsByTagName("INPUT"));
   for(i=0;i<el.length;i++)
   void(el[i].checked=ck)
   if(ch=="on") ch="off"; else if(ch=="off")ch="on";
   return ch;
   }
</script>