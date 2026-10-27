<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_varede_sadere.php";
Function print_header()
{global $code_kala,$code_anbar,$date1,$date2,$FileName;
 echo'
   	<tr>
     <td class=title colspan="10">گزارش کالای وارده و صادره از تاریخ : '.$date1.' تا تاریخ : '.$date2.'
      <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	 </td>
	</tr>
	<tr class=table-title>
	 <td rowspan="2" width=10%>نام کالا</td>
	 <td rowspan="2" width=10%>مبدأ</td>
	 <td rowspan="2" width=10%>نام کشتی</td>
	 <td colspan="2" width=20%>تعداد کامیونها</td>
	 <td rowspan="2" width=10%>وزن مبدأ</td>
	 <td rowspan="2" width=10%>وزن مقصد</td>
	 <td rowspan="2" width=10%>وزن تخلیه شده</td>
	 <td rowspan="2" width=10%>وزن روباری</td>
	 <td rowspan="2" width=10%>بارگیری از انبار</td>
	</tr>
	<tr class=table-title>
	 <td>تخلیه</td>
	 <td>روباری</td>
	</tr>';
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>گزارش کالای وارده و صادره</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   $("input").not( $(":button") ).keypress(function (evt){
    if (evt.keyCode == 13) {
    iname = $(this).val();
     if (iname !== "Submit"){
     var fields = $(this).parents("form:eq(0),body").find("button, input, textarea, select");
     <!--var fields = $("input:text,input:checkbox,select,textarea");-->
	 var index = fields.index( this );
     if ( index > -1 && ( index + 1 ) < fields.length ) {
      fields.eq( index + 1 ).focus();}
     return false;
     }
    }
   });
});
$(function(){	    
    $("#datepickerfrom").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true}
	  );
});
</script> 
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">';
if(!$ok)
{
 echo'
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">گزارش کالای وارده و صادره</td>	 
    </tr>
	<tr class="tr1">	
     <td align="left" width="12%"> از تاریخ : </td><td align="right" width="38%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td>
     <td align="left" width="12%"> تا تاریخ : </td><td align="right" width="38%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
     <td align="left"> کد کالا : </td>
     <td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>
	 	   	   <img border="0" src="images/help.png" onClick="window.open(\'help_kala.php\',\'_blank\',\'width=400px,left=20px,scrollbars=yes\')" title="جدول کد کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td>
	 <td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<!-- <td align="left">مبدأ ورودی : </td>
	  <td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_mabda.'" name="code_mabda" onkeypress="return isNumber(event)" style="width:50px;"/>
	   <tr class="tr1">
	    <td align="left">نام کشتی :</td>
	    <td align="right">&nbsp;'.listbox("code_skk",$code_skk,"code_skk","name_skk","keshty","","class='text4'","").'
	    &nbsp;<input type="text" class="textboxme2" value="'.$name_skk.'" name="name_skk"/>
	    <td align="left">&nbsp;</td><td align="right">&nbsp;</td>
	   </tr>-->
    <tr class="tr1">	
	 <td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>
	</tr> 
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>';
}
else
{
 echo'
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
	//if(!$code_kala){echo"<script>alert('لطفاً کد کالا را وارد کنید !')</script>";
                  //  echo"<script>window.location='$FileName';</script>";}
   $Page=0;
   $Line=100;
   $Cntr=0;
   $RowPerPage=20;
   $Condition="";
   //اگر کاربر تاریخ اول را وارد نکرده بود
   if(!$date1)
   {
    $q_d1="SELECT MIN(AllRecords.tarikh) FROM
           ((SELECT tarikh_resid as tarikh FROM resid WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0)
  	          UNION
  	        (SELECT tarikh_havale_anbar FROM havale WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0)) AS AllRecords";
    $res_d1=$db->query($q_d1);
    $row_d1=$db->fetch_array($res_d1);
	$date1=$row_d1[0];
    }
	//اگر کاربر تاریخ دوم را وارد نکرده بود
	if(!$date2)
	{
     $q_d2="SELECT MAX(AllRecords.tarikh) FROM
            ((SELECT tarikh_resid as tarikh FROM resid WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0)
  	          UNION
  	         (SELECT tarikh_havale_anbar FROM havale WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0)) AS AllRecords";
     $res_d2=$db->query($q_d2);
     $row_d2=$db->fetch_array($res_d2);
     $date2=$row_d2[0];
	}
    /****************فیلترها روی گزارش*******************/
    //if ($date1) $Condition.=" and tarikh>='$date1'";//تاریخ اول
    //if ($date2) $Condition.=" and tarikh<='$date2'";//تاریخ دوم 
    if ($date1) $Condition.=" and tarikh_resid>='$date1'";//تاریخ اول
    if ($date2) $Condition.=" and tarikh_resid<='$date2'";//تاریخ دوم   
    if ($code_kala) $Condition.=" AND code_kala='$code_kala'";//کد کالا
	/****************شروع نمایش گزارش*******************/	
	// $q="SELECT AllRecords.* FROM
        // ((SELECT id,shomare_resid as shomare,code_kala,tarikh_resid as tarikh,code_mabda as c_mabda,vazn_mabda as v_mabda,vazn_khales as v_maghsad,1 as type FROM resid
          // WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0 AND status=0)
  	     // UNION
  	     // (SELECT id,shomare_havale_anbar,code_kala,tarikh_havale_anbar,code_anbar,vazn_kamiyon_bar_h,vazn_khales_h,2 as type FROM havale 
  	      // WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0 AND status=0)
  		 // )AS AllRecords WHERE 1=1 $Condition order by tarikh,type";   	 	   
	$q="SELECT code_kala,code_mabda,code_skk,sum(vazn_mabda) AS s_v_mabda,sum(vazn_khales) AS s_v_khales 
        FROM resid WHERE 1=1 $Condition AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0 group by code_mabda,code_skk";
	$res=$db->query($q);
    while($row=$db->fetch_assoc($res))
    {if ($Line>=$RowPerPage)
	 {	    
	  print_header();
	  $Line=0; 
	 }
	 $Line++;
	 //اطلاعات برای رسید
	 $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row['code_kala']."");//نام کالای مورد نظر
     $Mabda_resid=$db->get_from_where("name_mabda","mabady_vorudy","code_mabda=".$row['code_mabda']."");//مبدأ ورودی
	 $nameKeshty=$db->get_from_where("name_skk","keshty","code_skk=".$row['code_skk']."");//نام آن کشتی
	 $tedadKamiyon_takhlie_r=$db->get_from_where("count(noe_tahvil_bar)","resid","noe_tahvil_bar=1 AND code_mabda=".$row['code_mabda']." AND code_skk=".$row['code_skk']." AND code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");//تعداد کامیون تخلیه در انبار
	 $tedadKamiyon_robary_r=$db->get_from_where("count(noe_tahvil_bar)","resid","noe_tahvil_bar=2 AND code_mabda=".$row['code_mabda']." AND code_skk=".$row['code_skk']." AND code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");//تعداد کامیون روباری در انبار
	 $vazn_takhlie=$db->get_from_where("sum(vazn_khales)","resid","noe_tahvil_bar=1 AND code_mabda=".$row['code_mabda']." AND code_skk=".$row['code_skk']." AND code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");//مجموع وزن خالص با نوع تحویل بارتخلیه در انبار
	 $vazn_robary=$db->get_from_where("sum(vazn_khales)","resid","noe_tahvil_bar=2 AND code_mabda=".$row['code_mabda']." AND code_skk=".$row['code_skk']." AND code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");//مجموع وزن خالص با نوع تحویل بار روباری 
	 //بارگیری از حواله ی انبار
	 $vazn_bargiry=$db->get_from_where("sum(vazn_khales_h)","havale","noe_tahvil_bar=1 AND code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");//مجموع وزن خالص با نوع تحویل بار روباری 
	 
	 // $code_skk_resid=$db->get_from_where("code_skk","resid","id=".$row['id']."");//بدست آوردن کد کشتی هر رسید
	 // $nameKeshty=$db->get_from_where("name_skk","keshty","code_skk=".$code_skk_resid."");//نام آن کشتی
     // $Mabda_resid=$db->get_from_where("name_mabda","mabady_vorudy","code_mabda=".$row['c_mabda']."");//مبدأ ورودی
     // $Mabda_havale=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
	 // $tedadKamiyon_takhlie_h=$db->get_from_where("count(noe_tahvil_bar)","havale","noe_tahvil_bar=1 AND id=".$row['id']." AND shomare_havale_anbar=".$row['shomare']." AND code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0 AND status=0");
	 // $tedadKamiyon_robary_h=$db->get_from_where("count(noe_tahvil_bar)","havale","noe_tahvil_bar=2 AND id=".$row['id']." AND shomare_havale_anbar=".$row['shomare']." AND code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0 AND status=0");
	 if($Cntr++%2)echo'<tr class="print_table-odd"/>';
     else echo'<tr class="print_table-even"/>';
	 echo'
	 <td>'.$nameKala.'</td>
	 <td>'.$Mabda_resid.'</td>
	 <td>'.$nameKeshty.'</td>
	 <td>'.$tedadKamiyon_takhlie_r.'</td>
	 <td>'.$tedadKamiyon_robary_r.'</td>
	 <td>'.$row['s_v_mabda'].'</td>
	 <td>'.$row['s_v_khales'].'</td>
	 <td>'.$vazn_takhlie.'</td>
	 <td>'.$vazn_robary.'</td>
	 <td>'.$vazn_bargiry.'</td>';	 	 
	}
	echo'
	 </tr>
    </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
}
echo'	
</table>
</div>
</form>
</body>
</html>';	
?>