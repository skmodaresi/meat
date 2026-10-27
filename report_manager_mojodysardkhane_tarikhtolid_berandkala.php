<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojodysardkhane_tarikhtolid_berandkala.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش موجودی سردخانه ها به تفکیک تاریخ تولید و تولیدکننده کالا';
//پیدا کردن آی دی سال مربوط به سیستم فروش
//$sellYearCode=substr($mtActiveYear,2);
//$sellYearId=$db->get_from_where("year_id","sell.dm_year","year_code='$sellYearCode'");
/****************هدر******************/
Function print_header()
{global $count,$titr,$mahshamsiArr,$mt_gl_owner,$code_kala,$sal_tolid_shamsi_1,$sal_tolid_shamsi_2,$mah_tolid_shamsi_1,$mah_tolid_shamsi_2,$FileName,$page,$kalaName;
 if($noe_namayesh==1)$str='(خالص)';
 if($noe_namayesh==2)$str='(ناخالص)';
 if($noe_namayesh==3)$str='(تعداد)';
 echo'
   <br/>   
   <table width="98%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
   	<tr><td class="print_title_2">'.$titr.' : '.$kalaName.'</td></tr>
	<tr>
	 <td class="print_title_2"> &nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	 </td>
    </tr>
   </table>
   <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
   <tr class="print_table-title2">
	 <td rowspan="2" width="5%">ردیف</td>
	 <td rowspan="2" width="10%">استان</td>
	 <td rowspan="2" width="10%">انبار</td>	
	 <td rowspan="2" width=5%>تولیدکننده</td>
	 <td colspan="3" width=10%>تاریخ تولید</td>
	 <td rowspan="2" width=10%>موجودی اول دوره '.$str.'</td>
	 <td rowspan="2" width=10%>وارده طی دوره '.$str.'</td>
	 <td rowspan="2" width=10%>صادره طی دوره '.$str.'</td>
	 <td colspan="2" width=10%>تعدیل '.$str.'</td>
	 <td rowspan="2" width=10%>مانده در پایان دوره '.$str.'</td> 
	</tr>
	<tr class="print_table-title2">
	 <td>سال</td>
	 <td>ماه</td>
	 <td>روز</td>
	 <td>اضافه</td>
	 <td>کسری</td>
	</tr>';
	
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<style>
       @media screen
       {
           .hideatprint
           {
           }
       }
       @media print
       {
           .hideatprint
           {
               display: none;
           }
       }
</style>
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
	    changeYear: true}
	  );
});
function enterCodeKala(code_kala)
{
  $("#loading").fadeIn("fast");
  $.post("ajax_error.php",{codeKALA_Error:code_kala},function(data){$("#codeK_Error").html(data);});
  $("#loading").fadeOut("fast");				
}
</script> 
</head>';
/****************فیلترها روی گزارش******************/
/************************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $val ) 
      {
       $Condition_ostan_temp.=" code_ostan='$val' OR";
      }
      if($val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{$Condition_ostan=' code_ostan='.$_SESSION['mt_code_ostan'].'';}
/*****************************انبارها****************************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_resid='1=1';$Condition_anbar_havale='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" code_anbar=".$row_user['code_anbar']." OR";
   $Condition_anbar_resid_temp.=" r_k_d.code_anbar=".$row_user['code_anbar']." OR";
   $Condition_anbar_havale_temp.=" h_d.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_resid.="  $Condition_anbar_resid_temp";
	 $Condition_anbar_havale.="  $Condition_anbar_havale_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
	 $Condition_anbar_ebtal_sell.="  $Condition_anbar_ebtal_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_resid = strrpos($Condition_anbar_resid," ");
     $lastSpacePosition_havale = strrpos($Condition_anbar_havale," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $lastSpacePosition_ebtal_sell = strrpos($Condition_anbar_ebtal_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
	 $Condition_anbar_resid =substr($Condition_anbar_resid,0,$lastSpacePosition_resid);
     $Condition_anbar_havale =substr($Condition_anbar_havale,0,$lastSpacePosition_havale);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
     $Condition_anbar_ebtal_sell =substr($Condition_anbar_ebtal_sell,0,$lastSpacePosition_ebtal_sell);
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=10;
if(!$ok)
{
echo'
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1">
	 <td align="left"><span class="star">*</span> کد کالا : </td>
     <td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	  include ("img_helpkala.php");
 	  echo'&nbsp;<span style="color:red" id="codeK_Error">&nbsp;</span></td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>	
    </tr>
    <tr class="tr1">	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">	   
     <td align="left"> از تاریخ تولید : </td>
	 <td align="right">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_1" value="'.$sal_tolid_shamsi_1.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_1",$mah_tolid_shamsi_1,"mahshamsiArr",1,"class='text4'").'
	</tr>
	<tr class="tr1">	   
     <td align="left"> تا تاریخ تولید : </td>
	 <td align="right">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_2" value="'.$sal_tolid_shamsi_2.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_2",$mah_tolid_shamsi_2,"mahshamsiArr",1,"class='text4'").'
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left"> نام استان : </td>
      <td align="right">
	   &nbsp;<select name="ostanchoice[]" size="6" style="width:200px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>
	   <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و استانهای موردنظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  &nbsp;
	  </td>
	 </tr>';
	} 
	echo'
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    
   </table>
   </div>
  </td>
 </tr>
</table> ';
}
else
{
 if(!$code_kala){echo"<script>alert('لطفاً کد کالا را وارد کنید !')</script>";
                   echo"<script>window.location='$FileName';</script>";}
 //اگر کاربر تاریخ اول را وارد نکرده بود
 if(!$sal_tolid_shamsi_1)$sal_tolid_shamsi_1='1394';  
 if(!$mah_tolid_shamsi_1)$mah_tolid_shamsi_1='1';  
 //اگر کاربر تاریخ دوم را وارد نکرده بود
 if(!$sal_tolid_shamsi_2)$sal_tolid_shamsi_2=$yy; 	  
 if(!$mah_tolid_shamsi_2)$mah_tolid_shamsi_2=$mm; 	 
/****************شروع نمایش گزارش*******************/	
$radif=1;
$page=1;
$line=0;
$i=0;
$cntr=0;
$kalaName=$db->get_from_where("name_kala","kala","code_kala='$code_kala'");
$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM mojody_kala WHERE code_kala='$code_kala' AND year='$mtActiveYear' AND deleted=0) AND code_ostan IN(SELECT code_ostan FROM list_sardkhane) AND($Condition_ostan) ORDER BY name_ostan";
//echo $q;
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
 <br/>
 <table width="98%" border="1" align="center">
  <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
  <tr><td class="print_title_2">'.$titr.' : '.$groupkalaName.'</td></tr>
  <tr>
	<td class="print_title_2">
	   	<span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
	     &nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	</td>
   </tr>
  </table>';
/*سطر نمایش فیلترها*/
if(($ostanchoice))
{
	 if($val==-1)$filter_string1='همه استانها';
	 else $filter_string1=' استان : ';
	 foreach($ostanchoice as $key => $val) {
	  $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$val'");
	  $filter_string1.=''.$nameOstan.'&nbsp;';
     }
}
if($noe_namayesh==1) $filter_string2.="نمایش اطلاعات : خالص";
if($noe_namayesh==2) $filter_string2.="نمایش اطلاعات : ناخالص";
if($noe_namayesh==3) $filter_string2.="نمایش اطلاعات : تعداد";
if($mah_tolid_shamsi_1)$filter_string2.=" از : $mahshamsiArr[$mah_tolid_shamsi_1]";
if($sal_tolid_shamsi_1)$filter_string2.=" $sal_tolid_shamsi_1";
if($mah_tolid_shamsi_2)$filter_string2.=" نا : $mahshamsiArr[$mah_tolid_shamsi_2]";
if($sal_tolid_shamsi_2)$filter_string2.=" $sal_tolid_shamsi_2";
if($noe_namayesh==1)$str='(خالص)';
if($noe_namayesh==2)$str='(ناخالص)';
if($noe_namayesh==3)$str='(تعداد)';	
if($ostanchoice)
 {echo'<table class="filter_text" width="98%" border="0" align="center"><tr><td>فیلتر شده براساس : '.$filter_string1. $filter_string2.'</td></tr></table>';}
  echo'
  <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
   <tr class="print_table-title2">
	 <td rowspan="2" width="5%">ردیف</td>
	 <td rowspan="2" width="10%">استان</td>
	 <td rowspan="2" width="10%">انبار</td>	
	 <td rowspan="2" width=5%>تولیدکننده</td>
	 <td colspan="3" width=10%>تاریخ تولید</td>
	 <td rowspan="2" width=10%>موجودی اول دوره '.$str.'</td>
	 <td rowspan="2" width=10%>وارده طی دوره '.$str.'</td>
	 <td rowspan="2" width=10%>صادره طی دوره '.$str.'</td>
	 <td colspan="2" width=10%>تعدیل '.$str.'</td>
	 <td rowspan="2" width=10%>مانده در پایان دوره '.$str.'</td> 
	</tr>
	<tr class="print_table-title2">
	 <td>سال</td>
	 <td>ماه</td>
	 <td>روز</td>
	 <td>اضافه</td>
	 <td>کسری</td>
	</tr>'; 
     
	 
	 
	 while($row=$db->fetch_array($res))//ostan while
     {	
       $line++;
	   //تعداد سردخانه در هر استان
	   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","code_ostan=".$row['code_ostan']." AND code_anbar IN(SELECT code_anbar FROM mojody_kala WHERE code_kala='$code_kala' AND year='$mtActiveYear' AND deleted=0) ");//تعداد انبارهای هر استان 
	   else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." AND list_sardkhane.code_anbar IN(SELECT code_anbar FROM mojody_kala WHERE code_kala='$code_kala' AND year='$mtActiveYear' AND deleted=0)  ");//تعداد انبارهای هر استان     
	   //$rowanbar=$tedadanbar;
	   $countanbar=$tedadanbar;
  	   	
		$tedadkalaOstan=$db->get_from_where("count(*)","mojody_kala","code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND code_kala=".$code_kala." AND deleted=0");//تعداد    
       //$rowanbar=$tedadkalaOstan;
	   // $countanbar=$rowanbar;
	   
	   
	   if($i++%2)echo'<tr class="print_table-odd">';
       else echo'<tr class="print_table-even">';
       echo'   
       <td rowspan="'.$tedadkalaOstan.'">'.$radif++.'</td>
	   <td rowspan="'.$tedadkalaOstan.'">'.$tedadkalaOstan.'--'.$row['name_ostan'].'</td>';
	   
	   
	   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM list_sardkhane WHERE code_ostan=".$row['code_ostan']." AND code_anbar IN(SELECT code_anbar FROM mojody_kala WHERE code_kala='$code_kala' AND year='$mtActiveYear' AND deleted=0 AND code_ostan=".$row['code_ostan'].") ";
       else $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." AND list_sardkhane.code_anbar IN(SELECT code_anbar FROM mojody_kala WHERE code_kala='$code_kala' AND year='$mtActiveYear' AND deleted=0 AND code_ostan=".$row['code_ostan'].") ";
	   $res2=$db->query($q2);
	   //echo $q2;
	   while($row2=$db->fetch_assoc($res2))//حلقه روی سردخانه ها
       {	   
	    $j=$i+1;
	   	//$tedadkalaAnbar=$db->get_from_where("count(*)","mojody_kala INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=mojody_kala.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND code_kala=".$code_kala."");//تعداد    
	   	$tedadkalaAnbar=$db->get_from_where("count(*)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND code_kala=".$code_kala." AND deleted=0");//تعداد    
		$rowkala=$tedadkalaAnbar;
		$t2=$rowkala;
	    echo'
	    <td rowspan="'.$rowkala.'">'.$rowkala.'--'.$row2['code_anbar'].'-'.$row2['name_anbar'].'</td>';	
	   
	    $q3="SELECT * FROM mojody_kala WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND code_kala=".$code_kala." AND deleted=0";
	    $res3=$db->query($q3);
	    while($row3=$db->fetch_assoc($res3))//حلقه روی 
        {	
	     $j2=$i+1;
	   
         //نمایش اطلاعات
         echo'
		   <td '.$t2.'>'.$row3['code_tolidkonande'].'</td>
		   <td>'.$row3['sal_tolid_shamsi'].'</td>
	       <td>'.$mahshamsiArr[$row3['mah_tolid_shamsi']].'</td>
	       <td>'.$row3['rouz_tolid_shamsi'].'</td>
			 ';
           	$t2--;
           	if($t2==0) echo'';
           	else 
           	{
           	  echo'</tr>';
           	  if($j2++%2)echo'<tr class="print_table-odd">';
                 else echo'<tr class="print_table-even">';
           	}
		 
	    }//END while
	   
	   
	   
	    //echo'<td>'.round($jame_mojody_PerAnbar,3).'</td>';
		$countanbar--;
		if($countanbar==0) echo'';
		else 
		{
		  echo'</tr>';
		  if($j++%2)echo'<tr class="print_table-odd">';
          else echo'<tr class="print_table-even">';
		}
	  }//END sardkhane while 
	  
	  
	  
	  
	 
	  /*****تکرار سرصفحه و ستون ها*****/
	  if($line>=$MaxLines && $i <$cntr) 
	  {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
	  }  
   }//END ostan while
   
   
   
   /*****سطر جمع کل استان ها*****/

	 //END//
	 echo'
  </table>
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
  <table width="98%" border="1" align="center">
   <tr class="print_footer">
    <td colspan="9">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
 }//END IF//وجود اطلاعات
  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'	
</form>
</body>
</html>';	
?>