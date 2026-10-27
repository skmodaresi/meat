<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$titr='اطلاعات اشخاص';
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_ashkhas.php";
$TableName="acc_mofaser_detail";
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
function substitute(code_val,name_val)
{
 window.opener.document.myform.code_skk.value=code_val;
 window.opener.document.myform.name_skk.value=name_val;
 window.opener.document.myform.code_skk.focus();
 window.close();
}
</script>
</head>";
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_help_acc_ashkhas']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($code)  $temp.=" AND code LIKE '$code'";
 //در مالی اطلاعات هم با ی عربی هم با ی فارسی ذخیره شده
 $name2=str_replace("ی","ي",$name);
 $name2=str_replace("ک","ك",$name2);
 if($name)  $temp.=" AND (name LIKE '%$name%' OR name LIKE '%$name2%') ";
 if($temp) {$PageNo=1;$_SESSION['mt_search_help_acc_ashkhas']=$temp;} else $_SESSION['mt_search_help_acc_ashkhas']="";
}
/*************END SEARCH ******/
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code.focus();">
<form method="post" name="myform">
<div class="loader"></div>
<div align="center" class="content">
<table width="100%" border="0" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title" >
   <div class="etesal">'.$_SESSION["acc_etesal"].'</div>
   <div style="position:absolute;top:5px;left:40%;">'.$titr.'</div>
  </td>	 
 </tr>
 <tr class="title title_search">
  <td align="center">&nbsp;
  کد : &nbsp;<input type="text" class="textboxme" name="code" value="'.$code.'"  onkeypress="return isNumber(event)" style="width:50px"/>
  شرح : &nbsp;<input type="text" class="textboxme" name="name" value="'.$name.'" style="width:200px"/>
   <button align="left" class="buttonme" type="submit" name="Search_x" id="sabt"> جستجو &nbsp;<span class="fa fa-search "></span></button>';
   if ($_SESSION['mt_search_help_acc_ashkhas']) echo'<button type="button" class="buttonme" onClick="window.location=\''.$FileName.'?open_filter=1\'">نمايش همه &nbsp;<span class="fa fa-clipboard"></span></button>';
   echo'
  </td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->';
 if ($_SESSION['mt_search_help_acc_ashkhas'])
 {
 echo'  
 <tr>
  <td height="100%" >
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=10%>رديف</td>
	 <td width=15%>کد</td>
	 <td width=75%>شرح</td>
	</tr>';
   $Cntr=0;
   $q1="SELECT * From $accDB.$TableName WHERE 1=1 ".$_SESSION['mt_search_help_acc_ashkhas']." AND org=3 AND year=1395 AND (mk=16 OR mk=20 OR mk=27) AND name!='' ORDER BY name ASC ";
   //echo $q1;
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
  </td>
 </tr>';
 }
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
<script type="text/javascript">
$(window).load(function(){
   // PAGE IS FULLY LOADED  
   // FADE OUT YOUR OVERLAYING DIV
   $('.loader').fadeOut();
});
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