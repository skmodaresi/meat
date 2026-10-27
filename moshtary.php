<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$TableName="dm_customer_asli";
$titr='مشتريان';
if($_SESSION['mt_systemforush']==0)//اطلاعات مشتری از سیستم سردخانه
{
 $TableName="moshtary";
 $right_ins=0;$right_edt=0;$right_del=0;
 if (right(81)) $right_ins=1;
 if (right(82)) $right_edt=1;
 if (right(83)) $right_del=1; 
}
if($_SESSION['mt_systemforush']==1)//اطلاعات مشتری از سیستم فروش
{
  mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
  $TableName="dm_customer_asli";
  //پیدا کردن آی دی کد استان مربوط به سیتم فروش
  $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
  $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
}
$logtime=date('H:i:s'); 
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<link rel="stylesheet" href="jquery-ui-1.10.3/themes/base/jquery-ui.css"/> 
<script src="jquery-ui-1.10.3/ui/jquery-ui.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){
   <!--tooltip  -->
   $(function(){
   $(document).tooltip();
   });
 });
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
}
function getCodeShahr(code_ostan)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{codeOSTANforSHAHR:code_ostan},function(data){$("#city_code").html(data);});
  $("#loading").fadeOut("fast");		
}
function getIdShahr(province_id)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{idPROVINCEforCITY:province_id},function(data){$("#city_id").html(data);});
  $("#loading").fadeOut("fast");		
}
</script>
</head>';
$message='';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_moshtary']="";
} 
if(isset($Search_x))
{
  // if($_SESSION['mt_systemforush']==0)//انبار
  // {
   // $Mode="";
   // $Search_x="";
   // $temp="";
   // if($code_customer)           $temp.=" and code_customer LIKE '%$code_customer%'";
   // if($name_customer)           $temp.=" and name_customer LIKE '%$name_customer%'";
   // if($code_ostan)              $temp.=" and $TableName.code_ostan LIKE '$code_ostan'";//انبار
   // if($city_code)               $temp.=" and $TableName.city_code LIKE '$city_code'";//انبار
   // if($code_economic_customer)  $temp.=" and code_economic_customer LIKE '%$code_economic_customer%'";
   // if($customer_address_office) $temp.=" and customer_address_office LIKE '%$customer_address_office%'";
   // if($temp){$PageNo=1;$_SESSION['mt_search_moshtary']=$temp;} else $_SESSION['mt_search_moshtary']="";
 // }
 //if($_SESSION['mt_systemforush']==1)//فروش
 //{
   $name_customer=str_replace("ی","ي",$name_customer);
   $name_customer=str_replace("ک","ك",$name_customer);
   $Mode="";
   $Search_x="";
   $temp="";
   if($code_customer)           $temp.=" and $TableName.code_customer LIKE '%$code_customer%'";
   if($name_customer)           $temp.=" and $TableName.name_customer LIKE '%$name_customer%'";
   //if($province_id)             $temp.=" and $TableName.customer_province_id LIKE '$province_id'";//فروش
   //if($city_id)                 $temp.=" and $TableName.customer_city_id LIKE '$city_id'";//فروش
   //if($code_economic_customer)  $temp.=" and code_economic_customer LIKE '%$code_economic_customer%'";
   if($customer_national_tax)  $temp.=" and $TableName.customer_national_tax LIKE '%$customer_national_tax%'";
   if($customer_gl_code)       $temp.=" and $TableName.customer_gl_code LIKE '%$customer_gl_code%'";
   if($customer_tel)           $temp.=" and dm_customer_det.customer_tel LIKE '%$customer_tel%'";
   if($customer_address_office)$temp.=" and dm_customer_det.customer_address_office LIKE '%$customer_address_office%'";
   if($temp){$PageNo=1;$_SESSION['mt_search_moshtary']=$temp;} else $_SESSION['mt_search_moshtary']="";
 //}
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
if($_SESSION['mt_systemforush']==0) $res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_moshtary']."");
if($_SESSION['mt_systemforush']==1) $res=mysql_query("SELECT COUNT(*) FROM $TableName LEFT OUTER JOIN dm_customer_det ON $TableName.code_customer=dm_customer_det.code_customer  WHERE 1=1 ".$_SESSION['mt_search_moshtary']." AND dm_customer_det.customer_code_org='$mt_gl_code_ostan' AND (LENGTH(trim(customer_national_tax))>=10 OR LENGTH(trim(customer_gl_code))>=10)");	
$row = mysql_fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo)) $PageNo=1; //$PageNo=$MaxPage;  
$NextPage=$PageNo+1;
$PrevPage=$PageNo-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNo==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNo==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0;
$Limit="Limit ".$FirstRow.",".$RowPerPage; 
/******************** Insert- Edit- Delete ************/
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($a,$b,$shenase_meli,$code_meli,$gl_c_o)
{
 $flag=false;
 if(!($gl_c_o) or $gl_c_o==-1)//اگر سشن استان خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان مورد نظر خور را از پایین صفحه انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفاً فیلدهای ستاره دار را تکمیل نمایید !');</script>";
   return $flag;
 } 
 else $flag=true;
 // if ((!justNumber($a)) or (strlen($a)>5) or ($a<=12000) or ($a>99000))//بررسی کد مشتری
 // {
   // $flag=false;
   // echo"<script>alert('فيلد کد مشتری نامعتبر است!')</script>";
   // return $flag;
 // }
 // else $flag=true;
 if(!empty($a))//تکراری نبودن کد مشتری
 {  
    //$q8="SELECT code_customer FROM moshtary WHERE code_customer='$a' AND code_ostan='$gl_c_o'";
    $q8="SELECT code_customer FROM moshtary WHERE code_customer='$a'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين کد مشتری قبلاً ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
 // if ((!justNumber($code_meli)) or (strlen($code_meli)<10))//بررسی کد ملی 
 // {
   // $flag=false;
   // echo"<script>alert('فيلد کد ملی نامعتبر است!')</script>";
   // return $flag;
 // }
 // else $flag=true; 
return $flag;
}
// /**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$shenase_meli,$code_meli,$gl_c_o,$e)

{
  $flag=false;
  if(!($gl_c_o) or $gl_c_o==-1)//اگر سشن استان خالی بود
  {   
   $flag=false;
   echo"<script> alert('لطفاً استان مورد نظر خود را از پایین صفحه انتخاب نمایید!')</script>";
   return $flag;
  }
  else $flag=true;
  if(!($a and $b))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفاً فیلدهای ستاره دار را تکمیل نمایید !')</script>";
   return $flag;
  } 
  else $flag=true;
  if(!empty($a))//تکراری نبودن کد مشتری
  { 
   $q10="SELECT * FROM moshtary WHERE code_customer='$a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['customer_id']!=$e)){
   echo"<script>alert('اين کد مشتری قبلاً ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
  // if ((!justNumber($c_e_c)) or (strlen($c_e_c)<10))//بررسی کد ملی 
  // {
   // $flag=false;
   // echo"<script>alert('فيلد کد ملی -شناسه ملی نامعتبر است!')</script>";
   // return $flag;
  // }
  // else $flag=true;   
 return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if((isset($Insert_x))and ($_SESSION['mt_systemforush']==0))
{
 //if(isPermitSave($code_customer,$name_customer,$customer_national_tax,$mt_gl_code_ostan,$city_code)) 
 if(isPermitSave($code_customer,$name_customer,$customer_national_tax,$customer_gl_code,$mt_gl_code_ostan)) 
 {
  $Mode='';
  $name_customer=str_replace("ي","ی",$name_customer);
  $name_customer=str_replace("ك","ک",$name_customer);
  //$code_customer=make_pattern($code_customer,5);
  $insert_q=("INSERT INTO $TableName(code_customer,name_customer,customer_national_tax,customer_gl_code,customer_tel,code_economic_customer,customer_address_office)
             VALUES('$code_customer',TRIM('$name_customer'),'$customer_national_tax','$customer_gl_code','$customer_tel','$code_economic_customer',TRIM('$customer_address_office'))");  
  $insert_res=mysql_query($insert_q);
  if($insert_res){
     // $q_for_id="SELECT MAX(customer_id) FROM $TableName";
	 // $res_for_id=mysql_query($q_for_id);
	 // $max_id=mysql_fetch_array($res_for_id);
	 $max_id=$db->get_from_where("Max(customer_id)","$TableName",""); 
     $log_i=mysql_query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id[0]','ثبت',".($yymmdd).",'$logtime')");
   }
   else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ثبت مشتری به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if((isset($Edit_x))and($_SESSION['mt_systemforush']==0))
{
 //if(isPermitEdit($code_customer,$name_customer,$code_economic_customer,$mt_gl_code_ostan,$city_code,$customer_id_))
 if(isPermitEdit($code_customer,$name_customer,$customer_national_tax,$customer_gl_code,$mt_gl_code_ostan,$customer_id_)) 
 {
  $Mode='';
  $name_customer=str_replace("ي","ی",$name_customer);
  $name_customer=str_replace("ك","ک",$name_customer);
  $edit_q=("UPDATE $TableName SET code_customer='$code_customer',name_customer=TRIM('$name_customer'),customer_national_tax='$customer_national_tax',customer_gl_code='$customer_gl_code',customer_tel='$customer_tel',code_economic_customer='$code_economic_customer',customer_address_office=TRIM('$customer_address_office') WHERE customer_id='$customer_id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=mysql_query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$customer_id_','ویرایش',".($yymmdd).",'$logtime')");
  else if(mysql_affected_rows==0) $message='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>'; 
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if(isset($Delete_x))
{
 $del_q="DELETE FROM $TableName WHERE customer_id=$customer_id_ AND 
        ($code_customer_ NOT IN (SELECT code_customer FROM havale WHERE code_customer=$code_customer_ AND code_ostan='$mt_gl_code_ostan' AND deleted=0))AND
        ($code_customer_ NOT IN (SELECT code_customer FROM havale_forush WHERE code_customer=$code_customer_  AND code_ostan='$mt_gl_code_ostan' AND deleted=0))";
 $del_res=mysql_query($del_q);
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=mysql_query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$customer_id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_customer.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">';
   if($_SESSION['mt_systemforush']==1)echo'<div class="etesal">متصل به سیستم فروش</div>';
   echo'<div style="position:absolute;top:5px;left:47%;"> مشتريان</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='customer_id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	 if($sortcode=='1')
	 {echo'<td width="7%" title="مرتب سازی صعودی کد مشتری" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_customer ASC&sortcode=2&show_img=1\'"/> کد مشتری ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {echo'<td width="7%" title="مرتب سازی نزولی کد مشتری" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_customer DESC&sortcode=1&show_img=1\'"/> کد مشتری ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='1')
	 {echo'<td width="25%" title="مرتب سازی صعودی نام مشتری" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_customer ASC&sortname=2&show_img=2\'"/> نام مشتری '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {echo'<td width="25%" title="مرتب سازی نزولی نام مشتری" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_customer DESC&sortname=1&show_img=2\'"/> نام مشتری '; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	echo'
	 <!--<td width="16%">استان مشتری</td>
	     <td width="10%">شهر مشتری</td>-->
	 <td width="9%">شناسه ملی</td> 
	 <td width="9%">کد / شماره ملی</td>
	 <td width="10%">تلفن</td> 	 	 
	 <td width="30%">آدرس مشتری</td>';
	 if($_SESSION['mt_systemforush']==0)//سیستم انبار
	 {
	  if($Mode==NULL)echo'<td width="15%">حذف</td>';
	  else echo'<td width="15%">دستورات</td>';
	 }
	 //if(($_SESSION['mt_systemforush']==1)and($Mode=='Search')) echo'<td width="12%">دستورات</td>';
	 if($Mode=='Search') echo'<td width="10%">دستورات</td>';
	echo'
	</tr>';
	if(($Mode=='Insert')and($_SESSION['mt_systemforush']==0))
	{
	 echo'
	  <tr class="table-odd">
	   <td><span style="color:red">*</span> <input type="text" class="textboxme" name="code_customer" value="'.$code_customer.'"   onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><span style="color:red">*</span> <input type="text" class="textboxme" name="name_customer" value="'.$name_customer.'"/></td>';
	   // if(!$mt_gl_code_ostan) echo'<td colspan="2">ابتدا باید استان را تعریف کرده و سپس از گزینه پایین صفحه انتخاب کنید</td>';
	   // else 
	    // {echo'<td>'.$mt_gl_name_ostan.'</td>
	        // <td><span style="color:red">*</span> '.listboxMe("city_code",$city_code,"city_code","city_name","shahrestan","code_ostan=$mt_gl_code_ostan ORDER BY city_name ASC","class='text4'").'</td>';
	    // }
	   echo'
	   <td><input type="text" class="textboxme" name="customer_national_tax" value="'.$customer_national_tax.'" onkeypress="return isNumber(event)" style="width:110px;"/>
	   		<img border="0" src="images/Info1.png" title="کد ملی شناسه ملی را حداقل در 10 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	   </td>
	   <td><input type="text" class="textboxme" name="customer_gl_code" value="'.$customer_gl_code.'" onkeypress="return isNumber(event)" style="width:110px;"/>
	   		<img border="0" src="images/Info1.png" title="کد ملی شناسه ملی را حداقل در 10 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	   </td>
	   <td><input type="text" class="textboxme" name="customer_tel" value="'.$customer_tel.'"/></td>
	   <td><input type="text" class="textboxme" name="customer_address_office" value="'.$customer_address_office.'"/></td>
	   <td><input type="submit" class="buttonme" name="Insert_x" id="sabt" value="ثبت"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
    if($Mode=='Search')
	{
	 echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme" name="code_customer" value="'.$code_customer.'" maxlength="5" title="برای کد مشتری عددی مابین 12000 تا 99000 وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme" name="name_customer" value="'.$name_customer.'"/></td>';
	   // if($_SESSION['mt_systemforush']==0){
	    // echo '<td>'.$mt_gl_name_ostan.'</td>
		 	  // <td>'.listbox("city_code",$city_code,"city_code","city_name","shahrestan","code_ostan=$mt_gl_code_ostan ORDER BY city_name ASC","class='text4'").'</td>';

		// }
	   // else{
	    // echo '<td>'.$mt_gl_name_ostan.'</td>
			  // <td>'.listbox("city_id",$city_id,"city_id","city_name","dm_city","city_province=$sell_id_ostan ORDER BY city_name ASC","class='text4'").'</td>';
		// }
	   echo'
	   <td><input type="text" class="textboxme" name="customer_national_tax" value="'.$customer_national_tax.'" onkeypress="return isNumber(event)" /></td>
	   <td><input type="text" class="textboxme" name="customer_gl_code" value="'.$customer_gl_code.'" onkeypress="return isNumber(event)" /></td>
	   <td><input type="text" class="textboxme" name="customer_tel" onkeypress="return isNumber(event)"/></td>
	   <td><input type="text" class="textboxme" name="customer_address_office" value="'.$customer_address_office.'"/></td>
	   <td><input type="submit" class="buttonme" name="Search_x" id="sabt" value="جستجو"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
	//سیستم انبار
	if($_SESSION['mt_systemforush']==0)
	{

	  $q1="SELECT * FROM $TableName WHERE 1=1 ".$_SESSION['mt_search_moshtary']." order by $order $Limit";
	}
	//سیستم فروش
	else
	{
	  $q1="SELECT $TableName.code_customer,$TableName.name_customer,$TableName.customer_national_tax,$TableName.customer_gl_code,dm_customer_det.customer_address_office,dm_customer_det.customer_tel FROM $TableName LEFT OUTER JOIN dm_customer_det ON $TableName.code_customer=dm_customer_det.code_customer  WHERE 1=1 ".$_SESSION['mt_search_moshtary']." AND dm_customer_det.customer_code_org='$mt_gl_code_ostan' AND (LENGTH(trim(customer_national_tax))>=10 OR LENGTH(trim(customer_gl_code))>=10) order by $order $Limit";	

    }
	$allMoshtary = mysql_query($q1);
    while($row1=mysql_fetch_assoc($allMoshtary))
	{
     if(($_SESSION['mt_systemforush']==0)and($right_edt)){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&customer_id_='.$row1['customer_id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['customer_id']==$customer_id_)
	 {
	  //$exist_havale=$db->get_from_where("count(code_customer)","havale","code_customer=".$row1['code_customer']." AND code_ostan=".$row1['code_ostan']." AND deleted=0");
	  $exist_havale=$db->get_from_where("count(code_customer)","havale","code_customer=".$row1['code_customer']." AND deleted=0");
	  //$exist_havale_forush=$db->get_from_where("count(code_customer)","havale_forush","code_customer=".$row1['code_customer']." AND code_ostan=".$row1['code_ostan']." AND deleted=0");
	  $exist_havale_forush=$db->get_from_where("count(code_customer)","havale_forush","code_customer=".$row1['code_customer']." AND deleted=0");
	  $exist_mojavez_jabejae=$db->get_from_where("count(code_customer)","mojavez_jabejae","code_customer=".$row1['code_customer']." AND deleted=0");
	  if(($exist_havale_forush)or($exist_havale)or($exist_mojavez_jabejae)) echo'<td><input type="text" class="textboxme" name="code_customer" readonly value="'.$row1['code_customer'].'" title="غیر قابل تغییر" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
	  else echo'<td><input type="text" class="textboxme" name="code_customer" value="'.$row1['code_customer'].'" maxlength="5" title="برای کد مشتری عددی مابین 12000 تا 99000 وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/></td>';
	  echo'
	   <td><input type="text" class="textboxme" name="name_customer" value="'.$row1['name_customer'].'"/></td>
	   <!--<td>'.$mt_gl_name_ostan.'</td>
	       <td>'.listbox("city_code",$row1['city_code'],"city_code","city_name","shahrestan","code_ostan=$mt_gl_code_ostan ORDER BY city_name ASC","class='text4'").'</td>-->
	   <td><input type="text" class="textboxme" name="customer_national_tax" value="'.$row1['customer_national_tax'].'" onkeypress="return isNumber(event)" style="width:110px;"/>
	   	   <img border="0" src="images/Info1.png" title="کد ملی شناسه ملی را حداقل در 10 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	   </td>
	   <td><input type="text" class="textboxme" name="customer_gl_code" value="'.$row1['customer_gl_code'].'" onkeypress="return isNumber(event)" style="width:110px;"/>
	   	   <img border="0" src="images/Info1.png" title="کد ملی شناسه ملی را حداقل در 10 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	   </td>
	   <td><input type="text" class="textboxme" name="customer_tel" value="'.$row1['customer_tel'].'"/></td>
	   <td><input type="text" class="textboxme" name="customer_address_office" value="'.$row1['customer_address_office'].'"/></td>
	   <td>
	     <input type="hidden" name="idMoshtary"  value="'.$row1['customer_id'].'"/>
	     <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	     <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['code_customer'].'</td>
	  <td '.$edtClick.'>'.$row1['name_customer'].'</td>';
	  // if($_SESSION['mt_systemforush']==0) echo'<td '.$edtClick.'>'.$row1['name_ostan'].'</td>';
	  // else echo'<td>'.$row1['province_name'].'</td>';
	  // echo'<td '.$edtClick.'>'.$row1['city_name'].'</td>
	  //<td '.$edtClick.'>'.$row1['code_economic_customer'].'</td>
	  echo'
	  <td '.$edtClick.'>'.$row1['customer_national_tax'].'</td>
	  <td '.$edtClick.'>'.$row1['customer_gl_code'].'</td>
	  <td '.$edtClick.'>'.$row1['customer_tel'].'</td>
	  <td '.$edtClick.'>'.$row1['customer_address_office'].'</td>';
	  if($_SESSION['mt_systemforush']==0)//دیدن دکمه حذف اطلاعات در سیستم انبار
	  {
	    echo'<td>';
		if($right_del)
		{echo'<img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	         onmouseOver="this.src=\'images/trash_hover.png\'" 
		     onmouseOut="this.src=\'images/trash.png\'" 	  
	         onClick="iconfirm(\''.$FileName.'?Delete_x=1&customer_id_='.$row1['customer_id'].'&code_customer_='.$row1['code_customer'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف '.$row1['name_customer'].' \')"/>';
	    }
		echo'</td>';
	  }
	  //ناپدید شدن دکمه حذف برای سیستم فروش	
	  if(($_SESSION['mt_systemforush']==1)and($Mode=='Search'))echo'<td>&nbsp;</td>';
	  else echo'';
	  if($Mode=='Search')echo'<td>&nbsp;</td>';
	  else echo'';
	 }
	echo '
	</tr>';
	}
    for ($r=$i+1; $r<=$RowPerPage; $r++)
    {if($r%2) echo '
     <tr class="table-even">';
     else echo '
     <tr class="table-odd">';
     echo '
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($_SESSION['mt_systemforush']==0)echo'<td>&nbsp;</td>';
	  // if(($_SESSION['mt_systemforush']==1)and($Mode=='Search'))echo'<td>&nbsp;</td>';
	  // else echo'';
	  if($Mode=='Search')echo'<td>&nbsp;</td>';
	  else echo'';
	 echo'
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_moshtary.php\',\'\',\'scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>';
     if(($_SESSION['mt_systemforush']==0)and($right_ins))//در انبار می بینیم
	 { echo'<td width="10">&nbsp;</td>	 
	   <td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>';
 	 }
	 echo'
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'my_frame.php\'" id="btn-back"   title="بازگشت به منوی اصلی"  ><a href="#"></a></div></td>
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_moshtary']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>		 
	</tr>';
    }	
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->	
</table>
</div>
'.$message.'
</form>
</body>
</html>';	
?>