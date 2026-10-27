<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_mojavez_tadil.php";
$TableName="mojavez_tadil";
$radif=1;
$titr='مجوز تعدیل موجودی';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(sh_mojavez)
{
 window.opener.document.myform.shomare_mojavez_tadil.value=sh_mojavez;
 window.opener.document.myform.shomare_mojavez_tadil.focus();
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
 <!--<tr><td class="title title_search"><div onClick="window.location=\''.$FileName.'?Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td></tr>-->
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width="" rowspan="2">رديف</td>
	 <td width="" rowspan="2">شماره مجوز</td>
	 <td width="" rowspan="2">تاریخ مجوز</td>
	 <td width="" rowspan="2">نام کالا</td>
	 <td width="" rowspan="2">تولید کننده</td>
	 <td width="" colspan="3">تاریخ تولید</td>
	 <td width="" rowspan="2">تاریخ ماندگاری</td>
	 <td width="" rowspan="2">وزن کارتن</td>
	 <td width="" rowspan="2">نوع تعدیل</td>
	 <td width="" colspan="3">مقادیر مجوز</td>
	</tr>
	<tr class=table-title>
	 <td>سال</td>
	 <td>ماه</td>
	 <td>روز</td> 
	 <td>تعداد</td>
	 <td>ناخالص</td>
	 <td>خالص</td>
	</tr>';
	/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_mojavez_tadil']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($code_kala)     $temp.=" AND code_kala LIKE '$code_kala'";
     if($name_kala)     $temp.=" AND name_kala LIKE '%$name_kala%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_mojavez_tadil']=$temp;} else $_SESSION['mt_search_help_mojavez_tadil']="";
    }
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT $TableName.*,name_kala,name_tolidkonande,sharh_mandegari
        From $TableName INNER JOIN kala ON $TableName.code_kala=kala.code_kala
        INNER JOIN tolidkonande ON tolidkonande.code_tolidkonande=$TableName.code_tolidkonande  
        INNER JOIN tarikh_mandegari ON $TableName.code_mandegari=tarikh_mandegari.code_mandegari
		WHERE 1=1 ".$_SESSION['mt_search_help_mojavez_tadil']." AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND status=0 AND shomare_mojavez_tadil NOT IN(SELECT shomare_mojavez_tadil FROM tadil_mojody WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND status=0 AND deleted=0) order by id_mojavez_tadil asc";
   $all = $db->query($q1);
   while($row1=$db->fetch_assoc($all))
   {
	$editclick="onclick='substitute(\"".$row1['shomare_mojavez_tadil']."\")'";   
	//$edtClick='onClick="window.location=\''.$FileName_.'?mysess_="'.$_SESSION['codeKala'].'"\'"';	
	//$edtClick='onClick="window.location=\''.$FileName_.'?&id_='.$row1['id'].'\'"';	
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['shomare_mojavez_tadil'].'</td>
	  <td '.$editclick.'>'.$row1['tarikh_mojavez_tadil'].'</td>
	  <td '.$editclick.'>'.$row1['name_kala'].'</td>
	  <td '.$editclick.'>'.$row1['name_tolidkonande'].'</td>
	  <td '.$editclick.'>'.$row1['sal_tolid_shamsi'].'</td>
	  <td '.$editclick.'>'.$row1['mah_tolid_shamsi'].'</td>
	  <td '.$editclick.'>'.$row1['rouz_tolid_shamsi'].'</td>
	  <td '.$editclick.'>'.$row1['sharh_mandegari'].'</td>
	  <td '.$editclick.'>'.$row1['vazn_karton_this'].'</td>
	  <td '.$editclick.'>'.$tadilArr[$row1['noe_tadil']].'</td>
	  <td '.$editclick.'>'.virgul($row1['tedad_karton_mojavez']).'</td>
	  <td '.$editclick.'>'.round($row1['meghdar_nakhales_mojavez'],3).'</td>
	  <td '.$editclick.'>'.round($row1['meghdar_khales_mojavez'],3).'</td>
	 </tr>';
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_mojavez_tadil']) 
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
	  <table border="0" bgcolor="#f3f3f3" align="center" width="100%" cellpadding="0" cellspacing="0" style="position:absolute;top:150px;">
       <tr class="title"><td colspan="4" align="center">جستجوی کالا</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left">کد کالا : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="code_kala" value="'.$code_kala.'"  onkeypress="return isNumber(event)" style="width:50px"/></td>
	    <td align="left">نام کالا : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_kala" value="'.$name_kala.'"/></td>
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