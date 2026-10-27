<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_dastorolamal_elhagh.php";
$radif=1;
$todaydate=$yy.'/'.$mm.'/'.$dd;
$titr='دستورالعمل خرید';
$code_ostan_gharardad=$db->get_from_where("code_ostan","gharardad_kharid","id_gharardad='$id_gharardad'");
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(id,shomare_dastor,gheymat)
{
 window.opener.document.myform.id_dastorolamal.value=id;
 window.opener.document.myform.shomare_dastorolamal.value=shomare_dastor;
 window.opener.document.myform.gheymat_elhaghie.value=gheymat;
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
 <tr><td class="title">'.$titr.'</td></tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td>رديف</td>
	 <td>شماره دستورالعمل</td>
	 <td>تاریخ دستورالعمل</td>
	 <td>تاریخ شروع اعتبار</td>
	 <td>گروه کالا</td>
	 <!--<td>کالا</td>-->
	 <td>قیمت کالا</td>
	 <td>استان</td>
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
   $noe_gheymat=$db->get_from_where("noe_gheymat","dastorolamal_kharid","id_eblagh='$id_eblagh' AND activate=1 AND dastorolamal_kharid.deleted=0");
   IF($noe_gheymat==2) $condition_ostan=" AND code_ostan='$code_ostan_gharardad'";
   $q1="SELECT dastorolamal_kharid.*,mt_skk.name_skk,name_group_kala_top From dastorolamal_kharid LEFT JOIN mt_skk ON mt_skk.code_skk=dastorolamal_kharid.code_skk    
		INNER JOIN eblagh_kharid USING(id_eblagh)
        INNER JOIN bzacc.group_kala_top USING(code_group_kala_top)
		WHERE 1=1 ".$_SESSION['mt_search_help_dastorolamal']." AND id_eblagh=$id_eblagh AND activate=1 AND dastorolamal_kharid.deleted=0
		$condition_ostan
		order by tarikh_shoro_etebar,id_dastorolamal asc";
   //echo $q1;
   $all = $db->query($q1);

   while($row1=$db->fetch_assoc($all))
   {
	 //$count_gheymat=$db->get_from_where("COUNT(*)","gheymat_kharid","id_dastorolamal=".$row1['id_dastorolamal']." AND deleted=0");
	 //$t=$count_gheymat;
	 $q2="SELECT * FROM gheymat_kharid WHERE id_dastorolamal=".$row1['id_dastorolamal']." AND deleted=0 ORDER BY id_gheymat_kharid DESC";
	 $res2=mysql_query($q2);
	 $row2=mysql_fetch_assoc($res2);
	 $q3="SELECT name_ostan FROM ostan WHERE code_ostan=".$row1['code_ostan']."";
	 $res3=mysql_query($q3);
	 $row3=mysql_fetch_assoc($res3);
	 $editclick="onclick='substitute(\"".$row1['id_dastorolamal']."\",\"".$row1['shomare_dastorolamal']."\",\"".$row2['gheymat_kharid']."\")'";   
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.' rowspan="'.$count_gheymat.'" >'.$radif++.'</td>
	  <td '.$editclick.' rowspan="'.$count_gheymat.'" >'.$row1['shomare_dastorolamal'].'</td>
	  <td '.$editclick.' rowspan="'.$count_gheymat.'" >'.$row1['tarikh_dastorolamal'].'</td>
	  <td '.$editclick.' rowspan="'.$count_gheymat.'" >'.$row1['tarikh_shoro_etebar'].'</td>
	  <td '.$editclick.' rowspan="'.$count_gheymat.'" >'.$row1['name_group_kala_top'].'</td>
	  <td '.$editclick.' rowspan="'.$count_gheymat.'" >'.virgul($row2['gheymat_kharid']).'</td>
	  <td '.$editclick.' rowspan="'.$count_gheymat.'" >'.$row3['name_ostan'].'</td>
	  ';
	  // $q2="SELECT * FROM gheymat_kharid
	       // INNER JOIN kala USING(code_kala)
 	       // WHERE id_dastorolamal=".$row1['id_dastorolamal']." AND deleted=0";
	  // $res2=mysql_query($q2);
	  // while($row2=$db->fetch_assoc($res2))
	  // {
	    // $editclick="onclick='substitute(\"".$row1['id_dastorolamal']."\",\"".$row1['shomare_dastorolamal']."\",\"".$row2['gheymat_kharid']."\")'";   
		// echo'
		 // <td '.$editclick.'>'.$row2['name_kala'].'</td>
		 // <td '.$editclick.'>'.virgul($row2['gheymat_kharid']).'</td>';
		 // $t--;
		 // if($t==0) echo'';
		 // else 
		 // {
			  // echo'</tr>';
			  // if($Cntr++%2)echo'<tr class="table-odd">';
			  // else echo'<tr class="table-even">';
		 // }
	  // }
	  echo'</tr>';		 
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
</html>';	
?>