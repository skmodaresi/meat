<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_gheymat_kharid.php";
$radif=1;
$todaydate=$yy.'/'.$mm.'/'.$dd;
$titr='جدول قیمت خرید';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(id,c_kala,n_kala,gheymat)
{
 window.opener.document.myform.id_gheymat_kharid.value=id;
 window.opener.document.myform.code_kala.value=c_kala;
 window.opener.document.myform.name_kala.value=n_kala;
 window.opener.document.myform.gheymat_har_kilo.value=gheymat;
 window.opener.document.myform.gheymat_har_kilo.focus();
 window.close();
}
</script>
</head>";
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
 <!--<tr>
  <td class="title title_search"><div onClick="window.location=\''.$FileName.'?Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td>
 </tr>-->
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=10%>رديف</td>
	 <td width=50%>کالا</td>
	 <td width=40%>قیمت</td>
	</tr>';
	/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_gheymat']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($code_kala)     $temp.=" AND code_kala LIKE '$code_kala'";
     if($name_kala)     $temp.=" AND name_kala LIKE '%$name_kala%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_gheymat']=$temp;} else $_SESSION['mt_search_help_gheymat']="";
    }
	/*************END SEARCH ******/
   $Cntr=0;
   if($id_dastorolamal)//error midad
   {
    //نوع قیمت گذاری اگر استانی باشد
	$noe_gheymat=$db->get_from_where("noe_gheymat","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal' AND deleted=0");
	IF($noe_gheymat==2) $Condition="AND T.code_ostan='$code_ostan'";
	ELSE $Condition=" ";
	
	$q1="SELECT T.*,kala.name_kala From gheymat_kharid T 
	     INNER JOIN kala ON kala.code_kala=T.code_kala 
		 INNER JOIN dastorolamal_kharid ON T.id_dastorolamal=dastorolamal_kharid.id_dastorolamal 
		 WHERE 1=1 ".$_SESSION['mt_search_help_gheymat']." $Condition AND T.id_dastorolamal=$id_dastorolamal AND id_eblagh=$id_eblagh order by id_gheymat_kharid asc";
    $all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
    {
	 $editclick="onclick='substitute(\"".$row1['id_gheymat_kharid']."\",\"".$row1['code_kala']."\",\"".$row1['name_kala']."\",\"".$row1['gheymat_kharid']."\")'";   
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['name_kala'].'</td>
	  <td '.$editclick.'>'.$row1['gheymat_kharid'].'</td>
	  ';
	 echo '
	 </tr>';
	 }
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_gheymat']) 
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
 // if($Mode=="Search")
 // {
   // echo'
	// <tr> 
	 // <td> 	 
	  // <table border="0" bgcolor="#f3f3f3" align="center" width="100%" cellpadding="0" cellspacing="0" style="position:absolute;top:150px;">
       // <tr class="title"><td colspan="4" align="center">جستجوی</td></tr>
       // <tr><td>&nbsp;</td></tr>	   
	   // <tr>
	    // <td align="left">کد کالا : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="code_kala" value="'.$code_kala.'"  onkeypress="return isNumber(event)" style="width:50px"/></td>
	    // <td align="left">نام کالا : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_kala" value="'.$name_kala.'"/></td>
	   // </tr>
	   // <tr><td>&nbsp;</td></tr>
	   // <tr>
        // <td colspan="4" align="center" class="title">
		 // <input class="buttonme" type="submit" name="Search_x" value="جستجو" >
         // <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'\'">
        // </td>
       // </tr>
	  // </table>
	 // </td>
    // </tr>';
  // }
 echo' 
</table>
</div>
</form>
</body>
</html>';	
?>