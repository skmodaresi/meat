<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_jabejae.php";
$TableName="mojavez_jabejae";
$radif=1;
$titr='جدول مجوز جابه جایی';
if(!$inputName) $inputName='shomare_jabejae';
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>'.$titr.'</title>
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
 <tr>';
  if($noe_tahvil_bar_==4)
   echo'<td class="title">جدول مجوز جابه جایی (فی مابین مناطق)</td>';
  if($noe_tahvil_bar_==5)
    echo'<td class="title">جدول مجوز جابه جایی (کالای امانی)</td>';
  if($noe_tahvil_bar_==6)
    echo'<td class="title">جدول مجوز جابه جایی (مرجوعی)</td>';
  if($noe_tahvil_bar_==7)
    echo'<td class="title">جدول مجوز جابه جایی (جایگزینی با بخش خصوصی)</td>';
  if($noe_tahvil_bar_==9)
    echo'<td class="title">جدول مجوز جابه جایی (تحت کلید گمرک)</td>';
 echo'  
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
	  <td width="20%">شماره مجوز جابه جایی</td>';
	  if(($noe_tahvil_bar_==4)OR($noe_tahvil_bar_==9))
      {
	   echo'
	   <td width="20%">نام استان مقصد</td>
	   <td width="20%">نام انبار مقصد</td>';
	  }
	  if(($noe_tahvil_bar_==5)OR($noe_tahvil_bar_==7))
      {
	   echo'
	   <td width="10%">کد مشتری</td>
	   <td width="30%">نام مشتری</td>';
	  }
	  if($noe_tahvil_bar_==6)
      {
	   echo'
	   <td width="10%">کد کشتی / فروشنده</td>
	   <td width="30%">نام کشتی / فروشنده</td>';
	  }
	  echo'
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
   if(($noe_tahvil_bar_==4)OR($noe_tahvil_bar_==9))//جابه جایی بین مناطق
   {
	  if($noe_tahvil_bar_==4)$Cond=" AND noe_mojavez=1";
	  else if($noe_tahvil_bar_==9)$Cond=" AND noe_mojavez=5";
	  $q1="SELECT $TableName.shomare_jabejae,kala.name_kala,ostan.name_ostan,list_sardkhane.name_anbar FROM $TableName
           INNER JOIN kala ON kala.code_kala=$TableName.code_kala
           INNER JOIN ostan ON ostan.code_ostan=$TableName.code_ostan_maghsad_j
    	   INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=$TableName.code_ostan_maghsad_j AND list_sardkhane.code_anbar=$TableName.code_anbar_maghsad_j 
    	   WHERE 1=1 ".$_SESSION['mt_search_help_jabejae']." AND code_anbar_maghsad_j!=301  $Cond AND mande_az_jabejae>0 AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 order by $TableName.id asc";
	  
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
   }
   if(($noe_tahvil_bar_==5)OR($noe_tahvil_bar_==7))//جابه جایی کالای امانی
   {
      if($noe_tahvil_bar_==5){
		$q1="SELECT $TableName.shomare_jabejae,$TableName.code_customer,kala.name_kala FROM $mydatabase.$TableName
           INNER JOIN $mydatabase.kala ON kala.code_kala=$TableName.code_kala
  	 	   WHERE 1=1 ".$_SESSION['mt_search_help_jabejae']." AND mande_az_jabejae>0 AND noe_mojavez=2 AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 order by $TableName.id asc";  
	  }
	  else  if($noe_tahvil_bar_==7){
		$q1="SELECT $TableName.shomare_jabejae,$TableName.code_customer,kala.name_kala FROM $TableName
           INNER JOIN kala ON kala.code_kala=$TableName.code_kala
  	 	   WHERE 1=1 ".$_SESSION['mt_search_help_jabejae']." AND mande_az_jabejae>0 AND noe_mojavez=4 AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 order by $TableName.id asc";  
	  }
      $allJabejae = $db->query($q1);
	  while($row1=$db->fetch_assoc($allJabejae))
      {
      	$editclick="onclick='substitute(\"".$row1['shomare_jabejae']."\")'";   
  	    if($_SESSION['mt_systemforush']==0) $name_customer=$db->get_from_where("name_customer","$mydatabase.moshtary","code_customer='".$row1['code_customer']."'");
  	    if($_SESSION['mt_systemforush']==1) 
		{
		 $db->selectDb('sell');
		 $name_customer=$db->get_from_where("name_customer","sell.dm_customer_asli","code_customer='".$row1['code_customer']."'");
		
		}
		if($Cntr++%2) echo'<tr class="table-odd"/>';
        else echo '<tr class="table-even"/>';
        echo'
  	   <td '.$editclick.'>'.$radif++.'</td>
  	   <td '.$editclick.'>'.$row1['shomare_jabejae'].'</td>
  	   <td '.$editclick.'>'.$row1['code_customer'].'</td>
  	   <td '.$editclick.'>'.$name_customer.'</td>
  	   <td '.$editclick.'>'.$row1['name_kala'].'</td>';
  	  echo '
  	  </tr>';
     }
   }
   if($noe_tahvil_bar_==6)//جابه جایی مرجوعی
   {
      $q1="SELECT $TableName.shomare_jabejae,$TableName.code_skk,name_skk,shomare_safar,name_kala FROM $TableName
           INNER JOIN kala ON kala.code_kala=$TableName.code_kala
		   INNER JOIN mt_skk ON mt_skk.code_skk=$TableName.code_skk
           INNER JOIN shomare_safar ON shomare_safar.id_safar=$TableName.id_safar
  	 	   WHERE 1=1 ".$_SESSION['mt_search_help_jabejae']." AND mande_az_jabejae>0 AND noe_mojavez=3 AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 AND activate_havale=1 order by $TableName.id asc";
      $allJabejae = $db->query($q1);
	  while($row1=$db->fetch_assoc($allJabejae))
      {
      	$editclick="onclick='substitute(\"".$row1['shomare_jabejae']."\")'";    
		if($Cntr++%2) echo'<tr class="table-odd"/>';
        else echo '<tr class="table-even"/>';
        echo'
  	   <td '.$editclick.'>'.$radif++.'</td>
  	   <td '.$editclick.'>'.$row1['shomare_jabejae'].'</td>
  	   <td '.$editclick.'>'.$row1['code_skk'].'</td>
  	   <td '.$editclick.'>'.$row1['name_skk'].'</td>
  	   <td '.$editclick.'>'.$row1['name_kala'].'</td>';
  	  echo '
  	  </tr>';
     }
   }
   echo'
   </table>
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