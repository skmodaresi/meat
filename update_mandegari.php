<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="update_mandegari.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>update_mandegari</title>
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
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.sal_mabda.focus();">
<form method="POST" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">اصلاح ماندگاری '.$mt_gl_name_ostan.' و '.$mt_gl_name_anbar.'</td></tr>
	<tr class="tr1" style="height:70px">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom"/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> کد کالا :&nbsp;</td>
     <td align="right" ><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	 include ("img_helpkala.php");
	 echo'</td>
	  <td align="left" height="40px">تاریخ ماندگاری :&nbsp;</td><td align="right" >'.listbox("code_mandegari",$code_mandegari,"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='easyui-combobox text4' style=width:100px","").'</td>
	 </tr>
    <tr class="footer" align="center">
	 <td height="40px"><input class="buttonme" type="submit" name="ok_resid" value="اصلاح ماندگاری رسیدها"></td> 
     <td height="40px"><input class="buttonme" type="submit" name="ok_havale" value="اصلاح ماندگاری حواله ها"></td>
     <td height="40px"><input class="buttonme" type="submit" name="ok_tadil" value="اصلاح ماندگاری تعدیلها"></td>
     <td height="40px"></td></tr> 
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';

//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($ok_resid))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q="SELECT r_k_d.* From meat.resid r
	    INNER JOIN meat.resid_kala_detail AS r_k_d ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year 
	    WHERE r.code_ostan=$mt_gl_code_ostan and r.code_anbar=$mt_gl_code_anbar AND r.tarikh_resid>='$date1' and r.tarikh_resid<='$date2'
		AND  r_k_d.code_tolidkonande=341 and code_skk=37400 and (r_k_d.code_kala=75 OR r_k_d.code_kala=76 OR r_k_d.code_kala=77 OR r_k_d.code_kala=78)";
    echo $q.'<br>';
	$all = $db->query($q);
	while($row=$db->fetch_assoc($all))
    {
	   $update_q=("UPDATE meat.resid_kala_detail SET code_mandegari='$code_mandegari' WHERE code_kala=".$row['code_kala']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year='".$row['year']."' AND shomare_resid='".$row['shomare_resid']."'");
	   echo $update_q.'<br>'; 
	   $update_res=mysql_query($update_q);
	   $update_q2=("UPDATE meat.mojody_kala SET code_mandegari='$code_mandegari' WHERE code_ziranbar=".$row['code_ziranbar']." AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");      	
	   	   echo $update_q2.'<br>';

	   $update_res2=mysql_query($update_q2);
	   $update_q3=("UPDATE meat.havale_detail SET code_mandegari='$code_mandegari' WHERE code_ziranbar=".$row['code_ziranbar']." AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND havale_deleted=0");      	
	   	   	   echo $update_q3.'<br>'; 

	   $update_res3=mysql_query($update_q3);
    }
	if(($update_res)and($update_res2)and($update_res3))
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('error!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');
   	  
}

if(isset($ok_havale))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
	$q_h="SELECT * From havale h
	    INNER JOIN havale_detail AS h_d ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year 
	    WHERE h.code_ostan=$mt_gl_code_ostan and h.code_anbar=$mt_gl_code_anbar and h_d.code_kala='$code_kala' AND h.tarikh_havale_anbar>='$date1' and h.tarikh_havale_anbar<='$date2'";
    
	$all_h = $db->query($q_h);
	while($row_h=$db->fetch_assoc($all_h))
    {
	   $update_q=("UPDATE havale_detail SET code_mandegari='$code_mandegari' WHERE code_kala=".$row_h['code_kala']." code_ostan=".$row_h['code_ostan']." AND code_anbar=".$row_h['code_anbar']."  AND year='".$row_h['year']."' AND id=".$row_h['id']."");
	   $update_res=mysql_query($update_q);
	   $update_q2=("UPDATE mojody_kala SET code_mandegari='$code_mandegari' WHERE code_ziranbar=".$row_h['code_ziranbar']." AND code_kala=".$row_h['code_kala']." AND code_keshvar=".$row_h['code_keshvar']." AND code_tolidkonande=".$row_h['code_tolidkonande']." AND sal_tolid_shamsi=".$row_h['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_h['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row_h['rouz_tolid_shamsi']." AND code_karton=".$row_h['code_karton']." AND code_mandegari='".$code_mandegari."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");      	
	   $update_res2=mysql_query($update_q2);
    }
	if(($update_res)and($update_res2))
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('error!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');
   	  
}

if(isset($ok_tadil))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q="SELECT * From tadil_mojody
	    WHERE code_ostan=$mt_gl_code_ostan and code_anbar=$mt_gl_code_anbar and code_kala='$code_kala' AND tarikh_barge_tadil>='$date1' and r.tarikh_barge_tadil<='$date2'";
    
	$all = $db->query($q);
	while($row=$db->fetch_assoc($all))
    {
	   $update_q=("UPDATE tadil_mojody SET code_mandegari='$code_mandegari' WHERE code_kala=".$row['code_kala']." code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year='".$row['year']."' AND id=".$row['id']."");
	   $update_res=mysql_query($update_q);
	   $update_q2=("UPDATE mojody_kala SET code_mandegari='$code_mandegari' WHERE code_ziranbar=".$row['code_ziranbar']." AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$code_mandegari."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");      	
	   $update_res2=mysql_query($update_q2);
    }
	if(($update_res)and($update_res2))
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('error!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');
   	  
}




////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>