<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$titr='جدول ابلاغ وزیر';
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_eblagh.php";
$TableName="eblagh_kharid";
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
function substitute(id_e,sh_e,kala,meghdar,gheymat)
{
 window.opener.document.myform.id_eblagh.value=id_e;
 window.opener.document.myform.shomare_eblagh.value=sh_e;
 window.opener.document.myform.meghdar_kharid_keshvar.value=meghdar;
 window.opener.document.myform.shomare_eblagh.focus();
 window.close();
}
</script>
</head>";
/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_eblagh']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($shomare_eblagh)   $temp.=" AND T.shomare_eblagh LIKE '%$shomare_eblagh%'";
	 if($code_group_kala_top)$temp.=" AND T.code_group_kala_top LIKE '%$code_group_kala_top%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_eblagh']=$temp;} else $_SESSION['mt_search_help_eblagh']="";
    }
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_eblagh.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <tr class="title title_search">
  <td align="center">&nbsp;
  شماره : &nbsp;<input type="text" class="textboxme" name="shomare_eblagh" value="'.$shomare_eblagh.'" onkeypress="return isNumber(event)" style="width:50px"/>
  گروه کالا : &nbsp;	   '.listbox("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","onchange=getKalaFromGroup(this.value) class='text4'").'  
  <button align="left" class="buttonme" type="submit" name="Search_x" id="sabt"> جستجو &nbsp;<span class="fa fa-search "></span></button>';
   if ($_SESSION['mt_search_help_eblagh']) echo'<button type="button" class="buttonme" onClick="window.location=\''.$FileName.'?open_filter=1\'">نمايش همه &nbsp;<span class="fa fa-clipboard"></span></button>';
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
	 <td width=5%>رديف</td>
	 <td width=30%>شماره ابلاغ</td>
	 <td width=15%>نوع محموله</td>
	 <td width=15%>گروه کالا</td>
	 <td width=35%>مقدار خرید</td>
	</tr>';
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT *,	    
   (SELECT name_group_kala_top From bzacc.group_kala_top g WHERE g.code_group_kala_top=T.code_group_kala_top) nameGroupKala
   From $TableName T WHERE 1=1 ".$_SESSION['mt_search_help_eblagh']." ORDER BY id_eblagh DESC";
   $allKala = $db->query($q1);
   while($row1=$db->fetch_assoc($allKala))
   {
	$editclick="onclick='substitute(\"".$row1['id_eblagh']."\" ,\"".$row1['shomare_eblagh']."\",\"".virgul($row1['meghdar_kharid_keshvar'])."\")'";   
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['shomare_eblagh'].'</td>
	  <td '.$editclick.'>'.$mahmuletypeArr[$row1['mahmule_type']].'</td>
	  <td '.$editclick.'>'.$row1['nameGroupKala'].'</td>
	  <td '.$editclick.'>'.virgul($row1['meghdar_kharid_keshvar']).'</td>';
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
</html>';	
?>