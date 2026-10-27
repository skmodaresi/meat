<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$titr='جدول پیمانکاران حمل';
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_peymankar_haml.php";
$TableName="peymankar_haml";
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
function substitute(code_val)
{
 window.opener.document.myform.code_peymankar_haml.value=code_val;
 window.opener.document.myform.name_peymankar_haml.focus();
 window.close();
}
</script>
</head>";
/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_peymankar']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($code_peymankar_haml)   $temp.=" AND code_peymankar_haml LIKE '$code_peymankar_haml'";
     if($name_peymankar_haml)   $temp.=" AND name_peymankar_haml LIKE '%$name_peymankar_haml%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_peymankar']=$temp;} else $_SESSION['mt_search_help_peymankar']="";
    }
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_peymankar_haml.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <tr class="title title_search">
  <td align="center">&nbsp;
  کد : &nbsp;<input type="text" class="textboxme" name="code_peymankar_haml" value="'.$code_peymankar_haml.'"  onkeypress="return isNumber(event)" style="width:50px"/>
  نام : &nbsp;<input type="text" class="textboxme" name="name_peymankar_haml" value="'.$name_peymankar_haml.'" style="width:200px"/>
   <button align="left" class="buttonme" type="submit" name="Search_x" id="sabt"> جستجو &nbsp;<span class="fa fa-search "></span></button>';
   if ($_SESSION['mt_search_help_peymankar']) echo'<button type="button" class="buttonme" onClick="window.location=\''.$FileName.'?open_filter=1\'">نمايش همه &nbsp;<span class="fa fa-clipboard"></span></button>';
   echo'
  </td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=10%>رديف</td>
	 <td width=20%>کد</td>
	 <td width=70%>نام</td>
	</tr>';
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mt_search_help_peymankar']." order by name_peymankar_haml asc";
   $allKala = $db->query($q1);
   while($row1=$db->fetch_assoc($allKala))
   {
	$editclick="onclick='substitute(\"".$row1['code_peymankar_haml']."\")'";   
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['code_peymankar_haml'].'</td>
	  <td '.$editclick.'>'.$row1['name_peymankar_haml'].'</td>';
	 echo '
	 </tr>';
	}
	echo'
   </table>
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