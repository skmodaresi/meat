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
$titr='';
if($_SESSION['mt_systemforush']==0){$TableName="havale_forush";}
if($_SESSION['mt_systemforush']==1)
{
 $db->selectDb('sell');
 $TableName="dm_havale";
 }
$radif=1;
if(!$inputName) $inputName='h_code';
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
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
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
     <tr class="table-title">
	  <td width="5%">رديف</td>
	  <td width="15%">شماره حواله فروش</td>
	  <td width="12%">تاریخ</td>
	  <td width="33%">نام مشتری</td>
	  <td width="23%">نام کالا</td>
	  <td width="12%">مقدار مانده</td>
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
     if($_SESSION['mt_systemforush']==0)//سردخانه
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
   /********************************************************/
         //befor
		 // //تاریخ از انبار خوانده میشود
	      // $date_havaleshow=$db->get_from_where("date_havaleshow","$mydatabase.list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ");
         	// IF($date_havaleshow>0)
          // {
           // //تبدیل تاریخ شمسی به میلادی
	       // $sql_tarikh=$date_havaleshow;
           // $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
           // $milady=jalali_to_gregorian($y,$m,$d);
           // $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
           // $Condition_Date_m=$sal.'-'.$mah.'-'.$rouz;
          // }
	      // ELSE
          // { 
     //شرط تاریخ برای مشاهده حواله فروشها
	 //استان تهران	  
     //IF($mt_gl_code_ostan==4)$Condition_Date_m = strtotime ( '-3 month' , strtotime ( $today_milady ) ) ;//3 month ago
     IF($mt_gl_code_ostan==4)$Condition_Date_m = strtotime ( '-10 day' , strtotime ( $today_milady ) ) ;//10 days ago
	 ELSE  $Condition_Date_m = strtotime ( '-10 day' , strtotime ( $today_milady ) ) ;//10 days ago
     $Condition_Date_m = date ( 'Y-m-j' , $Condition_Date_m );
	//}
   //سردخانه
   if($_SESSION['mt_systemforush']==0)
   {
	 $d2=substr($Condition_Date_m,8,2);$m2=substr($Condition_Date_m,5,2);$y2=substr($Condition_Date_m,0,4);
     $DateF2=gregorian_to_jalali($y2,$m2,$d2);
     $yy2=$DateF2[0];
     $mm2=$DateF2[1];
     $dd2=$DateF2[2];
     $Condition_Date_sh=$yy2.'/'.$mm2.'/'.$dd2;   //سردخانه
     //$q1="SELECT $TableName.*,m.name_customer,k.name_kala,h_reg_date From meat.$TableName INNER JOIN meat.moshtary m ON m.code_customer=$TableName.code_customer INNER JOIN meat.kala k ON k.code_kala=$TableName.code_kala WHERE 1=1 ".$_SESSION['mt_search_help_havale_f']." AND h_reg_date>='$mtStartDateSh' AND mande_az_forush>0 AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND k.activate_havale=1 AND (h_reg_date>='$Condition_Date_sh' OR h_show=1) order by id asc";
     $q1="SELECT $TableName.*,m.name_customer,k.name_kala,h_reg_date From meat.$TableName INNER JOIN meat.moshtary m ON m.code_customer=$TableName.code_customer INNER JOIN meat.kala k ON k.code_kala=$TableName.code_kala WHERE 1=1 ".$_SESSION['mt_search_help_havale_f']." AND h_reg_date>='$mtStartDateSh' AND mande_az_forush>0 AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND k.activate_havale=1  order by id asc";
     //echo $q1;
   }
   //فروش
   IF($_SESSION['mt_systemforush']==1)
   {
	    //befor
		// IF($_SESSION['mt_havaleshow'] == 1)
		    // $q1="SELECT $TableName.*,dm_customer_asli.name_customer,k.name_kala,h_reg_date FROM sell.$TableName LEFT OUTER JOIN sell.dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer INNER JOIN meat.kala k ON k.code_kala=$TableName.h_p_code WHERE 1=1 ".$_SESSION['mt_search_help_havale_f']." AND h_reg_date>='$mtStartDateMi' AND h_mande_havale>0 AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' AND k.activate_havale=1 order by h_id asc";
	    // ELSE IF($_SESSION['mt_havaleshow'] == 0)
			// $q1="SELECT $TableName.*,dm_customer_asli.name_customer,k.name_kala,h_reg_date FROM sell.$TableName LEFT OUTER JOIN sell.dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer INNER JOIN meat.kala k ON k.code_kala=$TableName.h_p_code WHERE 1=1 ".$_SESSION['mt_search_help_havale_f']." AND h_reg_date>='$mtStartDateMi' AND h_mande_havale>0 AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' AND k.activate_havale=1 AND h_reg_date>='$Condition_Date_m' order by h_id asc";
	
	//فعلا شزط ده روز قبل و تیک رو غیرفعال کردیم 
    //$q1="SELECT $TableName.*,dm_customer_asli.name_customer,k.name_kala,h_reg_date FROM sell.$TableName LEFT OUTER JOIN sell.dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer INNER JOIN meat.kala k ON k.code_kala=$TableName.h_p_code WHERE 1=1 ".$_SESSION['mt_search_help_havale_f']." AND h_reg_date>='$mtStartDateMi' AND h_mande_havale>0 AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' AND k.activate_havale=1  order by h_id asc";
	//شرط برقرار
	$q1="SELECT $TableName.*,dm_customer_asli.name_customer,k.name_kala,h_reg_date FROM sell.$TableName LEFT OUTER JOIN sell.dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer INNER JOIN meat.kala k ON k.code_kala=$TableName.h_p_code WHERE 1=1 ".$_SESSION['mt_search_help_havale_f']." AND h_reg_date>='$mtStartDateMi' AND h_mande_havale>0 AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' AND k.activate_havale=1 AND (h_reg_date>='$Condition_Date_m' OR h_show=1) AND h_activate=1 order by h_id asc";
   }
   $allHavale = $db->query($q1);
   while($row1=$db->fetch_assoc($allHavale))
   {
   	 $editclick="onclick='substitute(\"".$row1['h_code']."\")'";   
	 if($_SESSION['mt_systemforush']==0) $tarikh_forush=$row1['h_reg_date'];
	 else if($_SESSION['mt_systemforush']==1)
	 {
	 //تبدیل تاریخ میلادی به شمسی
	   $sql_tarikh=$row1['h_reg_date'];
       $d=substr($sql_tarikh,8,2);
       $m=substr($sql_tarikh,5,2);
       $y=substr($sql_tarikh,0,4);
       $shamsi=gregorian_to_jalali($y,$m,$d);
       $sal=$shamsi[0];
       $mah=$shamsi[1];
       $rouz=$shamsi[2];
       $tarikh_forush=$sal.'/'.$mah.'/'.$rouz;
	 }
	 if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even"/>';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['h_code'].'</td>
	  <td '.$editclick.'>'.$tarikh_forush.'</td>
	  <td '.$editclick.'>'.$row1['name_customer'].'</td>
      <td '.$editclick.'>'.$row1['name_kala'].'</td>';
      if($_SESSION['mt_systemforush']==0)echo'<td '.$editclick.'>'.$row1['mande_az_forush'].'</td>';
      else if($_SESSION['mt_systemforush']==1)echo'<td '.$editclick.'>'.$row1['h_mande_havale'].'</td>';
	echo'
	</tr>';
   }
   echo'
   </table>
   </div>
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