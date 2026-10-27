<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="havale_forush_new.php";
$TableName="havale_forush";
//$logtime=date('H:i:s');
//ایجاد شماره حواله فروش - با توجه به استان و انبار و سال
// $q2="SELECT h_code FROM $TableName WHERE code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' order by h_code DESC LIMIT 0,1";
// $res2=$db->query($q2);
// $row2=$db->fetch_assoc($res2);
// $w=$row2['h_code'];
// if($w){
  // $h_code=$w; 
  // $h_code++;
  // //$h_code=make_pattern($h_code,6);
  // //$sal=substr($yy,2,2);//دورقم سال
  // //$h_code=$sal.$h_code;
// }
// else {
  // $h_code=1;
  // $h_code=make_pattern($h_code,6);
  // $sal=substr($yy,2,2);//دورقم سال
  // $h_code=$sal.$h_code;
// }
$q3="SELECT name_anbar,address_anbar FROM list_sardkhane WHERE code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar'";
$res3=$db->query($q3);
$row3=$db->fetch_assoc($res3);
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ایجاد حواله فروش جدید</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepicker6").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true
    });
 });
</script>
<script type="text/javascript">
 function enterIE()
 {
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
 }
 function getDetailKala(code_kala)<!--اطلاعات کالا-->
 { 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKALA : code_kala},function(data){			 
			 <!--$("[name=name_kala]").val(data[0]);-->			 
			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#sharh_vahedkala").val(splKala[1]);
		 });
    $("#loading").fadeOut("fast");
 }
 function getDetailMoshtary(code_customer)<!--اطلاعات مشتری-->
 {
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeMOSHTARY: code_customer},function(data){
              var splMoshtary = data.split("^");
			  $("#name_customer").val(splMoshtary[0]);
              $("#code_ostan").val(splMoshtary[1]);
              $("#customer_address_office").val(splMoshtary[3]);
		 });
   $("#loading").fadeOut("fast");	
 }
 function getDetailAnbar(code_mahal_tahvil)<!--اطلاعات انبار-->
 {
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeANBAR: code_mahal_tahvil},function(data){            
              var splAnbar = data.split("^");
              $("#name_anbar").val(splAnbar[0]);
              $("#address_anbar").val(splAnbar[1]);
		 });
   $("#loading").fadeOut("fast");	
 }
function mandeAzForush()
{
 var natije;
 document.myform.mande_az_forush.value=Number(document.myform.meghdar_havale_forush.value)-Number(document.myform.meghdar_tahvily.value)-Number(document.myform.meghdar_batele.value); 
 natije=document.myform.mande_az_forush.value;
 return natije;
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/************اجازه براي ذخيره اطلاعات************/ 
function isPermitSave($h_c,$h_date,$n_h_f,$code_k,$code_c,$m_h_f,$h_deli,$gl_c_o,$gl_c_s,$gl_year)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($h_c and $h_date and $n_h_f and $code_k and $code_c and $m_h_f and $h_deli))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا تمام فيلد ها را تکميل نماييد');</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($code_k))//وجود داشتن کد کالا در جدول کالا
 {
   $q8="SELECT COUNT(code_kala) FROM kala WHERE code_kala='$code_k'";
   $res8=mysql_query($q8);
   $row8=mysql_fetch_array($res8);   
   if($row8[0]==0)
   {
     echo"<script>alert('کالایی با این کد کالا در جدول کالا وجود ندارد')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true; 
 }
 else $flag=true; 
 if(!empty($code_c))//وجود داشتن کد مشتری در جدول مشتریان
 {
   $q9="SELECT COUNT(code_customer) FROM moshtary WHERE code_customer='$code_c'";
   $res9=mysql_query($q9);
   $row9=mysql_fetch_array($res9);   
   if($row9[0]==0)
   {
     echo"<script>alert('مشتری با این کد مشتری در جدول مشتریان وجود ندارد !')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true; 
 }
else $flag=true; 
return $flag;
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.h_reg_date.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">ایجاد حواله فروش جدید</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>
    <tr class="tr1">
	 <td colspan="2">
      <table width="100%" border="0">
	   <tr>
        <td align="left" width="160px"><span class="star">*</span> شماره حواله فروش : </td><td align="right"><input type="text" class="textboxme2"  name="h_code" value="'.$h_code.'" onkeypress="return isNumber(event)" /></td>
	    <td align="left" width="150px"><span class="star">*</span> تاريخ حواله فروش : </td><td align="right"><input type="text" class="textboxme2" id="datepicker6" maxlength="10" name="h_reg_date" value="'.$h_reg_date.'"/></td>	 
	    <td align="left" width="30px" style="color:red">توجه</td><td align="left"  width="30px"><img border="0" src="images/Info1.png" title="لطفاً در ثبت مقادیر دقت نمایید ، بعد از کلیک روی گزینه ثبت امکان ویرایش مقادیر وجود ندارد" style="cursor:pointer" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'"/></span></td>
	   </tr>
	   <tr>
	    <td align="left" width="160px"><span class="star">*</span> نوع حواله فروش : </td><td align="right">'.static_listbox("noe_havale_forush",$noe_havale_forush,"noe_havale_forushArr",1,"class='text4'").'</td>
	    <!--<td align="left" width="200px"><span class="star">*</span> کد نرخ فروش : </td><td align="right"><input type="text" class="textboxme2" name="h_price_code" value="'.$h_price_code.'" onkeypress="return isNumber(event)"/></td>-->
	    <td align="left" width="200px"><span class="star">*</span> تحویل گیرنده : </td><td align="right"><input type="text" class="textboxme2" name="h_deli_name" value="'.$h_deli_name.'" "/></td>
	   </tr>
	  </table>
	 </td>
	</tr>
	<tr class="tr1">
	 <td valign="top">
	  <fieldset>
	   <legend>کالا</legend>
	   <table width="100%">
	    <tr><td align="left" width="150px"><span class="star">*</span> کد کالا :</td><td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onfocus="getDetailKala(this.value)" onchange="getDetailKala(this.value)" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>&nbsp;';
		include ("img_helpkala.php");
		echo'
		  </td>
		</tr>
		<tr><td align="left" width="150px">نام کالا : </td><td align="right"><input type="text" class="textboxme" readonly id="name_kala" name="name_kala" value="'.$name_kala.'"/></td></tr>
        <tr><td align="left" width="150px">واحد کالا : </td><td align="right"><input type="text" class="textboxme" readonly id="sharh_vahedkala" name="sharh_vahedkala" value="'.$sharh_vahedkala.'"/></td></tr>
	   </table>
	  </fieldset>
	 </td>
     <td valign="top">
	  <fieldset>
	   <legend>مشتری</legend>
	   <table width="100%" border="0">
	    <tr> 
	     <!--<td align="left">کد مشتری : </td><td align="right">'.listbox("code_customer",$code_customer,"code_customer","code_customer","moshtary","","onchange=getDetailMoshtary(this.value) class='text4'").'</td>-->
	     <td align="left" width="150px"><span class="star">*</span> کد مشتری : </td><td align="right"><input type="text" class="textboxme" name="code_customer" value="'.$code_customer.'" onfocus="getDetailMoshtary(this.value)" onchange="getDetailMoshtary(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;';
		  include ("img_searchmoshtary.php");
		  echo'
		  </td></tr>
		<tr><td align="left" width="150px">نام مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="name_customer" name="name_customer" value="'.$name_customer.'"/></td></tr>
	    <!--<tr><td align="left" width="150px">استان مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="code_ostan" name="code_ostan" value="'.$code_ostan.'"/></td></tr>-->
	    <tr><td align="left" width="150px">آدرس مشتری :</td><td align="right"><input type="text" class="textboxme" readonly id="customer_address_office" name="customer_address_office" value="'.$customer_address_office.'"/></td></tr>
	   </table>
	  </fieldset>
     </td>
	</tr>
    <tr class="tr1">
	 <td colspan="" valign="top">
	  <fieldset>
	   <legend>آدرس</legend>
	   <table border="0" width="100%">
		            <!--<tr><td align="left"><span class="star">*</span> کد محل تحویل : </td><td align="right"><input type="text" class="textboxme2" name="code_mahal_tahvil" value="'.$code_mahal_tahvil.'" onfocus="getDetailAnbar(this.value)" onchange="getDetailAnbar(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/>
			    	<img border="0" src="images/help.png" onClick="window.open(\'help_list_sardkhane.php\',\'_blank\',\'width=500px\')" title="جدول کد انبار" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td></tr>-->
		<tr><td align="left" width="150px"><span class="star">*</span> کد محل تحویل : </td><td align="right"><input type="text" readonly class="textboxme2" name="code_anbar" value="'.$mt_gl_code_anbar.'" style="width:50px;"/></td></tr>
		<tr><td align="left">نام سردخانه : </td><td align="right"><input type="text" class="textboxme" readonly id="name_anbar" name="name_anbar" value="'.$row3['name_anbar'].'"/></td></tr>
	    <tr><td align="left">آدرس سردخانه : </td><td align="right"><input type="text" class="textboxme" readonly id="address_anbar" name="address_anbar" value="'.$row3['address_anbar'].'"/></td></tr>
	   	<tr><td>&nbsp</td></tr>
	   </table>
      </fieldset>
	 </td>
	 <td colspan="" valign="top">
	  <fieldset>
	   <legend>مقادیر</legend>
	   <table width="100%" border="0">';
	    if(SuperUser())
		{echo'
		 <tr><td align="left" width="200px"><span class="star">*</span> مقدار حواله فروش : </td><td align="right"><input type="text" class="textboxme2" name="meghdar_havale_forush" value="'.$meghdar_havale_forush.'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
	     <tr><td align="left">مقدار تحویلی از حواله : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_tahvily" value="0"/></td></tr>
		 <tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_batele" value="0"/></td></tr>
	     <tr><td align="left"><span class="star">*</span> مقدار مانده از حواله فروش : </td><td align="right"><input type="text" class="textboxme2"  name="mande_az_forush" value="'.$mande_az_forush.'" onKeydown="return PressfloatOnly(event,this)"/>
	         <img border="0" src="images/Info1.png" title="اگر برای این حواله فروش در سیستم انبار قبلی حواله ایی صادر شده مقدار فعلی حواله فروش را در این فیلد وارد نمایید در غیر این صورت مقدار اولیه حواله فروش را به عنوان مقدار مانده وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></span></td>
		 </tr>
		';
		}
		else
	    {echo'
         <tr><td align="left" width="200px"><span class="star">*</span> مقدار حواله فروش : </td><td align="right"><input type="text" class="textboxme2" name="meghdar_havale_forush" value="'.$meghdar_havale_forush.'" onblur="return mandeAzForush();" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
	     <tr><td align="left">مقدار تحویلی از حواله : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_tahvily" value="0"/></td></tr>
		 <tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_batele" value="0"/></td></tr>
	     <tr><td align="left"><span class="star">*</span> مقدار مانده از حواله فروش : </td><td align="right"><input type="text" class="textboxme2" readonly name="mande_az_forush" value="'.virgul($mande_az_forush).'" onfocus="return mandeAzForush();" onKeydown="return PressfloatOnly(event,this)"/>
		 	<img border="0" src="images/Info1.png" title="اگر این حواله فروش همچنان باز است مقدار فعلی را در این فیلد وارد نمایید ، در غیر اینصورت مقدار اولیه حواله فروش را به عنوان مقدار مانده از حواله فروش وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></span></td>
		 </tr>
		';
		}
		echo'
	   </table>
	  </fieldset>
     </td>
	</tr>';
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table  width="100%"  border="0" cellspacing="0" cellpadding="0" height="100%"  style="margin-bottom:20px;">
    <tr>
	 <td align="center">
	  <input type="submit" class="buttonme" name="Insert_x" id="sabt" value="ثبت اطلاعات">
	  <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'havale_forush.php?PageNo='.$PageNo.'\'">
	 </td> 
	</tr>
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->	
</table>
</div>
</form>
</body>
</html>';
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 if(isPermitSave($h_code,$h_reg_date,$noe_havale_forush,$code_kala,$code_customer,$meghdar_havale_forush,$h_deli_name,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {
   $insert_q=("INSERT INTO $TableName
            (code_ostan,code_anbar,h_code,year,h_reg_date,noe_havale_forush,code_kala,code_customer,meghdar_havale_forush,mande_az_forush,h_price_code,h_deli_name,deleted)
             VALUES
			('$mt_gl_code_ostan','$mt_gl_code_anbar','$h_code','$mtActiveYear','$h_reg_date',
			 '$noe_havale_forush','$code_kala','$code_customer','$meghdar_havale_forush','$mande_az_forush','$h_price_code','$h_deli_name',0)");         
  $insert_res=$db->query($insert_q,'مشکلي در ثبت حواله به وجود آمده است');
  if($insert_res){
	$max_id=$db->get_from_where("MAX(id)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
  }
  echo "<script>alert(' حواله فروش به شماره".$h_code." به ثبت رسید  ')</script>"; 
  echo "<script>window.location='havale_forush.php?PageNo=1&RowPerPage=".$RowPerPage."';</script>";   
 }
} 	
?>