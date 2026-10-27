<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_dastorolamal_kharid.php";
$radif=1;
$todaydate=$yy.'/'.$mm.'/'.$dd;
$titr='دستورالعمل خرید';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(id,shomare_dastor,shomare_gh,tarikh_gh,code_skk,name_skk)
{
 window.opener.document.myform.id_dastorolamal.value=id;
 window.opener.document.myform.shomare_dastorolamal.value=shomare_dastor;
 window.opener.document.myform.shomare_gharardad.value=shomare_gh;
 window.opener.document.myform.tarikh_gharardad.value=tarikh_gh;
 window.opener.document.myform.code_skk.value=code_skk;
 window.opener.document.myform.name_skk.value=name_skk;
 window.opener.document.myform.shomare_dastorolamal.focus();
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
	 <td>رديف</td>
	 <td>شناسه دستورالعمل</td>
	 <td>شماره دستورالعمل</td>
	 <td>تاریخ دستورالعمل</td>
	 <td>تاریخ شروع اعتبار</td>
	 <td>گروه کالا</td>
	 <td>نوع قیمت گذاری</td>
	 <td>استان</td>
	 <td>قیمت کالا</td>
	 ';
	 if($mahmule_type==2)//وارداتی
	 {echo'
	  <td>شماره قرارداد</td>
	  <td>تاریخ قرارداد</td>
	  <td>نام فروشنده</td>';
	 }
	echo'
	</tr>';
	/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_dastorolamal']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($code_kala)     $temp.=" AND code_kala LIKE '$code_kala'";
     if($name_kala)     $temp.=" AND name_kala LIKE '%$name_kala%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_dastorolamal']=$temp;} else $_SESSION['mt_search_help_dastorolamal']="";
    }
	/*************END SEARCH ******/
   $Cntr=0;
   $q1="SELECT dastorolamal_kharid.*,mt_skk.name_skk,name_group_kala_top,name_ostan From dastorolamal_kharid 
        LEFT JOIN mt_skk ON mt_skk.code_skk=dastorolamal_kharid.code_skk
		INNER JOIN eblagh_kharid USING(id_eblagh)
        INNER JOIN bzacc.group_kala_top USING(code_group_kala_top)
	    LEFT JOIN ostan USING(code_ostan)
		WHERE 1=1 ".$_SESSION['mt_search_help_dastorolamal']." AND id_eblagh=$id_eblagh  AND activate=1 AND dastorolamal_kharid.deleted=0 order by id_dastorolamal asc";
   //if(SuperUser())echo $q1;
   $all = $db->query($q1);
   while($row1=$db->fetch_assoc($all))
   {
	 //نوع قیمت گذاری اگر استانی باشد
	 IF($row1['noe_gheymat']==2) $Condition="AND code_ostan='$code_ostan'";
	 ELSE $Condition=" ";
	 $q2="SELECT * FROM gheymat_kharid WHERE id_dastorolamal=".$row1['id_dastorolamal']." $Condition AND deleted=0 ORDER BY id_gheymat_kharid DESC";
	 $res2=mysql_query($q2);
	 $row2=mysql_fetch_assoc($res2);
     $exist_gheymat=$db->get_from_where("count(*)","gheymat_kharid","id_dastorolamal=".$row1['id_dastorolamal']." AND deleted=0");
	 IF($exist_gheymat>0)//اگر قیمت داشته باشد میشود رویش کلیک کرد
	 {
	  $editclick="onclick='substitute(\"".$row1['id_dastorolamal']."\",\"".$row1['shomare_dastorolamal']."\",\"".$row1['shomare_gharardad']."\",\"".$row1['tarikh_gharardad']."\",\"".$row1['code_skk']."\",\"".$row1['name_skk']."\")'";   
	 }
     ELSE	$editclick='title="برای این دستورالعمل قیمت کالا مشخص نشده است , مجاز به انتخاب این دستورالعمل نیستید"'; 
	      if($Cntr++%2) echo'<tr class="table-odd"/>';
          else echo '<tr class="table-even" />';
	      echo'
	       <td '.$editclick.'>'.$radif++.'</td>
	       <td '.$editclick.'>'.$row1['id_dastorolamal'].'</td>
	       <td '.$editclick.'>'.$row1['shomare_dastorolamal'].'</td>
	       <td '.$editclick.'>'.$row1['tarikh_dastorolamal'].'</td>
	       <td '.$editclick.'>'.$row1['tarikh_shoro_etebar'].'</td>
	       <td '.$editclick.'>'.$row1['name_group_kala_top'].'</td>
	       <td '.$editclick.'>'.$noegheymatArr[$row1['noe_gheymat']].'</td>
	       <td '.$editclick.'>'.$row1['name_ostan'].'</td>
	       <td '.$editclick.'>'.virgul($row2['gheymat_kharid']).'</td>
	       ';
	       if($mahmule_type==2)//وارداتی
	       {
	        echo'
	        <td '.$editclick.'>'.$row1['shomare_gharardad'].'</td>
	        <td '.$editclick.'>'.$row1['tarikh_gharardad'].'</td>
	        <td '.$editclick.'>'.$row1['name_skk'].'</td>';
	       }
	       echo'
	      </tr>';
	 
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_dastorolamal']) 
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