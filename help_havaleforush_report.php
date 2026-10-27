<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_havaleforush.php";
//$after_sell_date='2014-08-08';
//$after_sell_date='2012-05-02';
if($_SESSION['mt_systemforush']==0){$TableName="havale_forush";}
if($_SESSION['mt_systemforush']==1)
{
 $db->selectDb('sell');
 $TableName="dm_havale";
 // //پیدا کردن آی دی کد استان مربوط به سیتم فروش
  // $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
  // $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
 // //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
  // $res_anbar=mysql_query("SELECT l_id FROM dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code='$mt_gl_code_anbar'");
  // $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
 // //پیدا کردن آی دی سال مربوط به سیستم فروش
  // $sellYearCode=substr($mtActiveYear,2);
  // $res_sal=mysql_query("SELECT year_id FROM dm_year WHERE year_code='$sellYearCode'");
  // $sellYearId=mysql_result($res_sal, 0, 'year_id');
 }
$radif=1;
if(!$inputName) $inputName='h_code';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جدول شماره حواله فروش</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepickerfrom").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
		}
	  );
});
</script>
</head>';
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
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.h_code.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جدول حواله فروش</td>	 
 </tr>
 <tr>
  <td class="title title_search"><div onClick="window.location=\''.$FileName.'?Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
     <tr class="table-title">
	  <td width="10%">رديف</td>
	  <td width="20%">شماره حواله فروش</td>
	  <td width="35%">نام مشتری</td>
	  <td width="35%">نام کالا</td>
	 </tr>';
    /*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_havale_f']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($h_code) $temp.=" and h_code LIKE '%$h_code%'";
     if($_SESSION['mt_systemforush']==0)//سیستم انبار
    {
      if($date1)  $temp.=" and h_reg_date>='$date1'";
      if($date2)  $temp.=" and h_reg_date<='$date2'";
    }
    if($_SESSION['mt_systemforush']==1)//سیستم فروش
    {
     if($date1)
     {
      //تبدیل تاریخ شمسی به میلادی
	  $sql_tarikh=$date1;
      $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
      $milady=jalali_to_gregorian($y,$m,$d);
      $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
      $date1=$sal.'-'.$mah.'-'.$rouz;
      $temp.=" and h_reg_date>='$date1'";
     }
     if($date2)
     {
      //تبدیل تاریخ شمسی به میلادی
	  $sql_tarikh=$date2;
      $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
      $milady=jalali_to_gregorian($y,$m,$d);
      $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
      $date2=$sal.'-'.$mah.'-'.$rouz;
      $temp.=" and h_reg_date<='$date2'";
     }
     if($date2)  $temp.=" and h_reg_date<='$date2'"; 
    }
	 if($temp) {$PageNo=1;$_SESSION['mt_search_help_havale_f']=$temp;} else $_SESSION['mt_search_help_havale_f']="";
    }
	/*************END SEARCH ******/	 
   $Cntr=0;
   //انبار
   if($_SESSION['mt_systemforush']==0) $q1="SELECT $TableName.*,m.name_customer,k.name_kala From $TableName INNER JOIN moshtary m ON m.code_customer=$TableName.code_customer INNER JOIN kala k ON k.code_kala=$TableName.code_kala WHERE 1=1 ".$_SESSION['mt_search_help_havale_f']." AND h_reg_date>='$mtStartDateSh' AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' order by id asc";
   //فروش
   //if($_SESSION['mt_systemforush']==1) $q1="SELECT $TableName.*,dm_customer_asli.name_customer FROM $TableName LEFT OUTER JOIN dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer AND customer_code_org='$mt_gl_code_ostan' WHERE 1=1 ".$_SESSION['mt_search_help_havale_f']." AND h_reg_date>='$mtStartDateMi' AND h_mande_havale>0 AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' order by h_id asc";
   if($_SESSION['mt_systemforush']==1) $q1="SELECT $TableName.*,dm_customer_asli.name_customer FROM $TableName LEFT OUTER JOIN dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer WHERE 1=1 ".$_SESSION['mt_search_help_havale_f']." AND h_reg_date>='$mtStartDateMi' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' order by h_id asc";
   $allHavale = $db->query($q1);
   while($row1=$db->fetch_assoc($allHavale))
   {
   	$editclick="onclick='substitute(\"".$row1['h_code']."\")'";   
	 if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even"/>';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['h_code'].'</td>
	  <td '.$editclick.'>'.$row1['name_customer'].'</td>';
	  if($_SESSION['mt_systemforush']==0)//انبار
	  {echo'<td '.$editclick.'>'.$row1['name_kala'].'</td>';}	  
	  if($_SESSION['mt_systemforush']==1)//فروش 
	  {//اطلاعات لازم از سیستم انبار
       $db->selectDb($mydatabase);         
       //نام کالا از سیستم انبار
	   $res_kala=mysql_query("SELECT kala.name_kala FROM kala WHERE kala.code_kala=".$row1['h_p_code']."");
       $row_kala=mysql_fetch_assoc($res_kala);
	   $nameKALA=$row_kala['name_kala'];
	   echo'
	  <td '.$editclick.'>'.$nameKALA.'</td>';
	  }
	echo '
	</tr>';
   }
   echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_havale_f']) 
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
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0" style="position:absolute;top:150px;">
       <tr class="title"><td colspan="4"align="center">جستجوی حواله فروش</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr><td align="left">شماره حواله فروش :&nbsp;</td><td align="right">&nbsp;<input class="textboxme2" type="text" name="h_code" value="'.$h_code.'" onkeypress="return isNumber(event)"/></td></tr>
	   <tr><td align="left"> از تاریخ :&nbsp;</td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td></tr>
       <tr><td align="left"> تا تاریخ :&nbsp;</td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td></tr>
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