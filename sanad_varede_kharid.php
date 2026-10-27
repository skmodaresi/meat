<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="sanad_varede_kharid.php";
$titr='ایجاد سند حسابداری وارده به سردخانه خرید';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
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
/***************************************** MAIN*****************************************/
echo'
<body onload="document.myform.date_from.focus();">
<form method="POST" action="downfile.php" name="myform">
<div align="center">
<table width="700px" align="center" cellpadding="0" cellspacing="0">
<img src="images/loading.gif" id="loading" class="loading_img"/>
 <tr>
  <td height="100%">
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">'.$titr.'</td></tr>
	<tr class="tr1" style="height:70px">	
     <!--
	  <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date_from" id="datepickerfrom"/></td>
      <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date_to" id="datepickerto"/></td>
	 -->
	 <td align="center"> شماره قرارداد :&nbsp; 
		 <input type="text" class="textboxme2" name="shomare_gharardad"  value="'.$shomare_gharardad.'"/>
		 <input type="hidden" name="id_gharardad" value="'.$id_gharardad.'" />
		 <input type="hidden" name="akharin_gheymat" value="'.$akharin_gheymat.'" />
		 <input type="hidden" name="meghdar_gharardad" value="'.$meghdar_gharardad.'" />
		 <input type="hidden" name="mazad_gharardad" value="'.$mazad_gharardad.'" />
		 <input type="hidden" name="meghdar_gharardad_nahayi" value="'.$meghdar_gharardad_nahayi.'" />
		 <input type="hidden" name="mablagh_kol" value="'.$mablagh_kol.'" />
		 <input type="hidden" name="sum_tahvily_gharardad" value="'.$sum_tahvily_gharardad.'" />
		 <input type="hidden" name="mande_meghdar" value="'.$mande_meghdar.'" />
		 <input type="hidden" name="mande_pardakht" value="'.$mande_pardakht.'" />
		 <input type="hidden" name="mande_tahvily_gharardad" value="'.$mande_tahvily_gharardad.'" />
		 <img border="0" src="images/help.png" onClick="popupwindow(\'help_gharardad.php?parentFileName='.$FileName.'\',\'\',800,600)" title="جدول قراردادها" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
         ';
		 //include('img_help_gharardad.php');
		 echo'
	 </td>
	 <input type="text" name="status" value="gharardad" hidden/>
	</tr>
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="ایجاد سند"></td></tr> 
   </table>
  </td>
 </tr>	
</table>
</div>
</form>
</body>
</html>';	
?>