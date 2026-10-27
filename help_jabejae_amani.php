<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_jabejae_amani.php";
$TableName="mojavez_jabejae";
$radif=1;
if(!$inputName) $inputName='shomare_jabejae';
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>جدول مجوز جابه جایی</title>
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
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_jabejae.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جدول مجوز جابه جایی</td>	 
 </tr>
 <tr>
  <td class="title title_search"><div onClick="window.location=\''.$FileName.'?Mode=Search\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden; ">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
     <tr class="table-title">
	  <td width="10%">رديف</td>
	  <td width="20%">شماره مجوز جابه جایی</td>
	  <td width="20%">نام استان مقصد</td>
	  <td width="20%">نام انبار مقصد</td>
	  <td width="30%">نام کالا</td>
	 </tr>';
    /*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_jabejae']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($shomare_jabejae) $temp.=" and shomare_jabejae LIKE '%$shomare_jabejae%'";
     if($date1)  $temp.=" and tarikh_jabejae>='$date1'";
     if($date2)  $temp.=" and tarikh_jabejae<='$date2'";
	 if($temp) {$PageNo=1;$_SESSION['mt_search_help_jabejae']=$temp;} else $_SESSION['mt_search_help_jabejae']="";
    }
	/*************END SEARCH ******/	 
   $Cntr=0;
   $q1="SELECT $TableName.shomare_jabejae,kala.name_kala,ostan.name_ostan,list_sardkhane.name_anbar FROM $TableName
        INNER JOIN kala ON kala.code_kala=$TableName.code_kala
        INNER JOIN ostan ON ostan.code_ostan=$TableName.code_ostan_maghsad_j
		INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=$TableName.code_ostan_maghsad_j AND list_sardkhane.code_anbar=$TableName.code_anbar_maghsad_j 
		WHERE 1=1 ".$_SESSION['mt_search_help_jabejae']." AND tarikh_jabejae>='$mtStartDateSh' AND mande_az_jabejae>0 AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 order by $TableName.id asc";
   $allJabejae = $db->query($q1);
   while($row1=$db->fetch_assoc($allJabejae))
   {
   	$editclick="onclick='substitute(\"".$row1['shomare_jabejae']."\")'";   
	 if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even"/>';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['shomare_jabejae'].'</td>
	  <td '.$editclick.'>'.$row1['name_ostan'].'</td>
	  <td '.$editclick.'>'.$row1['name_anbar'].'</td>
	  <td '.$editclick.'>'.$row1['name_kala'].'</td>';
	echo '
	</tr>';
   }
   echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_jabejae']){ 
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
 </tr>';}	  
 if($Mode=="Search")
 {
   echo'
	<tr> 
	 <td> 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0" style="position:absolute;top:150px;">
       <tr class="title"><td colspan="4"align="center">جستجو</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr><td align="left">شماره مجوز جابه جایی :&nbsp;</td><td align="right">&nbsp;<input class="textboxme2" type="text" name="shomare_jabejae" value="'.$shomare_jabejae.'" onkeypress="return isNumber(event)"/></td></tr>
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