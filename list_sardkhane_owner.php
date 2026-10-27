<?php
session_start();
error_reporting(0);
include("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="list_sardkhane_owner.php";
$TableName="list_sardkhane_owner";
$q_anbar="SELECT * FROM list_sardkhane WHERE id='$id_'";
$res_anbar=$db->query($q_anbar);
$row_anbar=$db->fetch_assoc($res_anbar);
$code_ostan=$row_anbar['code_ostan'];
$code_anbar=$row_anbar['code_anbar'];
$warehouse_id=$row_anbar['warehouse_id'];
$titr='اطلاعات صاحب سردخانه '.$row_anbar['name_anbar'].'';
$right_ins=0;$right_edt=0;
if (right(19)) $right_ins=1;
if (right(20)) $right_edt=1;
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
    $(".datepicker6").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
	 });
});
function personInfo(code_meli,tarikh_tavalod)<!-- اطلاعات شخص از ثبت احوال-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax_codemeli.php",{codeMeli: code_meli,tarikhTavalod:tarikh_tavalod},function(data){
		   var splPerson = data.split("^");
		   $("[name=firstName]").val(splPerson[0]);
		   $("[name=lastName]").val(splPerson[1]);
		   $("[name=fatherName]").val(splPerson[2]);
		   $("[name=gender]").val(splPerson[3]);
		   $("[name=identityCertificateID]").val(splPerson[4]);
		   $("[name=identityCertificateSerial]").val(splPerson[5]);
		   $("[name=identityCertificateSeries]").val(splPerson[6]);
		   $("[name=lifeStatus]").val(splPerson[7]);
		   $("[name=deathDate]").val(splPerson[8]);   
		   $("[name=jensiat]").val(splPerson[9]);   
		   $("[name=Err]").val(splPerson[10]);   
		   $("[name=status]").val(splPerson[11]);   
		   $("#loading").fadeOut("fast");
		 });
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_anbar_owner']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x="";
 $temp=""; 
 if($code_anbar)         $temp.=" and code_anbar LIKE '%$code_anbar%'";
 if ($temp){$PageNoOwner=1;$_SESSION['mt_search_anbar_owner']=$temp;} else $_SESSION['mt_search_anbar_owner']="";
 }
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_anbar_owner']." ");
$row = mysql_fetch_array($res);
$cnt = $row[0]; 
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNoOwner)) $PageNoOwner=1; //$PageNoOwner=$MaxPage;
$NextPage=$PageNoOwner+1;
$PrevPage=$PageNoOwner-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNoOwner==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNoOwner==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0;
$Limit="Limit ".$FirstRow.",".$RowPerPage;
/******************** Insert- Edit- Delete ************/
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($nationalId,$birthDate,$mobile,$expire_date,$Err)
{
 $flag=false;
 if(!($nationalId and $birthDate and $mobile and $expire_date))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
 } 
 else $flag=true;
 if ((!justNumber($nationalId)) or (strlen($nationalId)>10) or (strlen($nationalId)<10) )//صحت کدملی
 {
   $flag=false;
   echo"<script>alert('کدملی در در 10 رقم وارد نمایید')</script>";
   return $flag;
 }
 else $flag=true;
 if ((!justNumber($birthDate)) or (strlen($birthDate)>8) or (strlen($birthDate)<8) )//صحت تاریخ تولد
 {
   $flag=false;
   echo"<script>alert('تاریخ تولد را در 8 رقم وارد نمایید')</script>";
   return $flag;
 }
 else $flag=true;
 IF(!fnValidateMobile($mobile))
 {
   $flag=false;
   echo"<script>alert('فرمت تلفن همراه نادرست است')</script>";
   return $flag; 
 }
 else $flag=true;
 IF(($nationalId)and($birthDate))//چک کردن 
 {
    IF($Err!=0)//ErrorCode:2 or 100
    {
      echo"<script>alert('اطلاعاتی از وب سرویس ثبت احوال دریافت نشد')</script>";
	  $flag=false;
	  return $flag;
    }
    else//درست  
    {
	 $flag=true;
	 return $flag;
    }
 } 
 return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($nationalId,$birthDate,$mobile,$expire_date,$Err,$this_id)
{
 $flag=false;
 if(!($nationalId and $birthDate and $mobile and $expire_date))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
 } 
 else $flag=true;
 if ((!justNumber($nationalId)) or (strlen($nationalId)>10) or (strlen($nationalId)<10) )//صحت کدملی
 {
   $flag=false;
   echo"<script>alert('کدملی در در 10 رقم وارد نمایید')</script>";
   return $flag;
 }
 else $flag=true;
 if ((!justNumber($birthDate)) or (strlen($birthDate)>8) or (strlen($birthDate)<8) )//صحت تاریخ تولد
 {
   $flag=false;
   echo"<script>alert('تاریخ تولد را در 8 رقم وارد نمایید')</script>";
   return $flag;
 }
 else $flag=true;
 IF(!fnValidateMobile($mobile))
 {
   $flag=false;
   echo"<script>alert('فرمت تلفن همراه نادرست است')</script>";
   return $flag; 
 }
 else $flag=true;
 IF(($nationalId)and($birthDate))//چک کردن 
 {
    IF($Err!=0)//ErrorCode:2 or 100
    {
      echo"<script>alert('اطلاعاتی از وب سرویس ثبت احوال دریافت نشد')</script>";
	  $flag=false;
	  return $flag;
    }
    else//درست  
    {
	 $flag=true;
	 return $flag;
    }
 } 
 return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات
if(isset($Insert_x))
{ 
 if(isPermitSave($nationalId,$birthDate,$mobile,$contractor_expire_date,$Err))
 {
   $Mode='';
   $insert_q=("INSERT INTO $TableName(id_anbar,code_ostan,code_anbar,nationalId,birthDate,mobile,firstName,lastName,fatherName,gender,identityCertificateID,identityCertificateSerial,identityCertificateSeries,lifeStatus,deathDate,Err,activate,contractor_expire_date)
              VALUES('$id_','$code_ostan','$code_anbar',TRIM('$nationalId'),TRIM('$birthDate'),TRIM('$mobile'),'$firstName','$lastName','$fatherName','$gender','$identityCertificateID','$identityCertificateSerial','$identityCertificateSeries','$lifeStatus','$deathDate','$Err','$activate','$contractor_expire_date')");
   $insert_res=mysql_query($insert_q);
   if($insert_res){
    $max_id=$db->get_from_where("Max(id_owner)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت انبار به وجود آمده است ! *</span>';
 }
}    
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($nationalId,$birthDate,$mobile,$contractor_expire_date,$Err,$id_owner_))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET nationalId=TRIM('$nationalId'),birthDate=TRIM('$birthDate'),mobile=TRIM('$mobile'),firstName='$firstName',
            lastName='$lastName',fatherName='$fatherName',gender='$gender',identityCertificateID=TRIM('$identityCertificateID'),identityCertificateSerial=('$identityCertificateSerial'),
			identityCertificateSeries=TRIM('$identityCertificateSeries'),lifeStatus='$lifeStatus',deathDate='$deathDate',Err='$Err',activate='$activate',contractor_expire_date='$contractor_expire_date'
			 WHERE id_owner='$id_owner_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
    $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_owner_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/    
    if($activate==1)//اگر وضعیت جاری انتخاب شده باشد بقیه راغیرجاری می کنیم
    {
	 $edit_q_after=("UPDATE $TableName SET activate=2 WHERE code_ostan='$code_ostan' AND code_anbar='$code_anbar' AND id_owner<>'$id_owner_';");
	 $edit_res_after=mysql_query($edit_q_after);
    }
  } 
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>'; 
 } 
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_anbar.focus();">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="99%" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'
   <!--<div class="pagecover">[صفحه:&nbsp'.$PageNoOwner.' از '.$MaxPage.']</div>-->
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
if(!isset($order)) $order='id_owner DESC';
	echo'
	 <td width="5%">شناسه</td>
	 <td width="5%">نام</td>
	 <td width="10%">نام خانوادگی</td>
	 <td width="10%">نام پدر</td>
	 <td width="10%">کدملی</td>
	 <td width="10%">تاریخ تولد</td>
	 <td width="10%">شماره شناسنامه</td>
	 <td width="10%">تلفن همراه</td>
	 <td width="10%">تاریخ انقضا</td>
	</tr>';
	$i=0;
	$cntr=0;
    $q1="SELECT * From $TableName T WHERE 1=1 ".$_SESSION['mt_search_anbar_owner']." AND id_anbar=$id_ order by $order $Limit ";
	//echo $q1;
	$all = $db->query($q1);
	while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_owner_='.$row1['id_owner'].'&PageNoOwner='.$PageNoOwner.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNo='.$PageNo.'&id_='.$id_.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';   
	 echo'
	  <td '.$edtClick.'>'.$row1['id_owner'].'</td>
	  <td '.$edtClick.'>'.$row1['firstName'].'</td>
	  <td '.$edtClick.'>'.$row1['lastName'].'</td>
	  <td '.$edtClick.'>'.$row1['fatherName'].'</td>
	  <td '.$edtClick.'>'.$row1['nationalId'].'</td>
	  <td '.$edtClick.'>'.$row1['birthDate'].'</td>
	  <td '.$edtClick.'>'.$row1['identityCertificateID'].'</td>
	  <td '.$edtClick.'>'.$row1['mobile'].'</td>
	  <td '.$edtClick.'>'.$row1['contractor_expire_date'].'</td>
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
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  echo'
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 echo'
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="15%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
     <td width="10">&nbsp;</td>';
	 //$countOwner=$db->get_from_where("COUNT(*)","list_sardkhane_owner","id_anbar=$id_");
	 //if(($right_ins)and($countOwner==0)){
	 if(($right_ins)and(!$warehouse_id)){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNoOwner='.$PageNoOwner.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNo='.$PageNo.'&id_='.$id_.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'
	 <td width="70"><div onClick="window.location=\'list_sardkhane.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <!--<td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNoOwner=1&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNo='.$PageNo.'&id_='.$id_.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNoOwner='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNo='.$PageNo.'&id_='.$id_.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNoOwner" value="'.$PageNoOwner.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td> 		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNoOwner='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNo='.$PageNo.'&id_='.$id_.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNoOwner='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNo='.$PageNo.'&id_='.$id_.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_anbar_owner']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNoOwner='.$PageNoOwner.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNo='.$PageNo.'&id_='.$id_.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>-->		 
	</tr>';
    }
	if ($Mode=="Insert")  //Insert Mode
    {echo '
    <tr> 
	 <td> 	 
	  <table class="footer-panel" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:10px">
       <tr class="title"><td colspan="10" align="center">ثبت صاحب سردخانه</td></tr>';

		 echo'
	     <tr><td colspan="10" class="notice">کد ملی و تاریخ تولد را بدون هیچ گونه علامت اضافه وارد نمایید تا اطلاعات شخص از 
	                       سامانه ثبت احوال دریافت شود
	     </td></tr>';
			
		
       echo'
	   <tr>
	    <td align="left" width="140px"><span class="star">*</span> کد ملی صاحب سردخانه : &nbsp;</td><td align="right" width="150px"><input type="text" class="textboxme2" name="nationalId" value="'.$nationalId.'"  maxlength="10"  onkeypress="return isNumber(event)" placeholder="0071234567"/></td>
	    <td align="left" width="130px"><span class="star">*</span> تاریخ تولد : &nbsp;</td><td align="right" width="150px"><input type="text" class="textboxme2" name="birthDate" value="'.$birthDate.'" onblur="personInfo(document.myform.nationalId.value,this.value)"  maxlength="8" onkeypress="return isNumber(event)" placeholder="13560725"/></td>
	    <td align="left" width="100px"><span class="star">*</span> تلفن همراه : &nbsp;</td><td align="right" width="150px"><input type="text" class="textboxme2" name="mobile" value="'.$mobile.'" onkeypress="return isNumber(event)" maxlength="11" placeholder="09121234567"></td>
       	<td align="left" width="70px"><span class="star">*</span> وضعیت : &nbsp;</td><td align="right" width="100px">'.static_listbox("activate",$activate,"activateArr",1,"class='text4'").'</td>
	   	<td align="left" width="150px"><span class="star">*</span> تاریخ انقضای بهره بردار : &nbsp;</td><td align="right" width="150px"><input type="text" class="textboxme2 datepicker6" name="contractor_expire_date" value="'.$contractor_expire_date.'"  maxlength="10" onkeypress="return isNumber(event)" placeholder="" readonly /></td>
	   </tr>
	   <tr>
	    <td colspan="10">
	     <fieldset>
	      <legend>اطلاعات شخص از سامانه ثبت احوال</legend>
	       <table width="100%" height="100px">
	        <tr>
	        	<td align="left"> نام : </td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="firstName" value="'.$firstName.'"/></td>
	        	<td align="left"> نام خانوادگی : </td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="lastName" value="'.$lastName.'"/></td>
	        	<td align="left"> نام پدر : </td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="fatherName" value="'.$fatherName.'"/></td>
            </tr>
	        <tr>
	        	<td align="left"> جنسیت : </td><td align="right"><input type="hidden" readonly class="textboxme inputreadonly" name="gender" value="'.$gender.'"/><input type="text" readonly class="textboxme inputreadonly" name="jensiat" value="'.$jensiat.'"/></td>
	        	<td align="left"> شماره شناسنامه : </td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="identityCertificateID" value="'.$identityCertificateID.'"/></td>
	        	<td align="left"> سریال شناسنامه : </td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="identityCertificateSerial" value="'.$identityCertificateSerial.'"/></td>
	        	<td align="left"> سری شناسنامه : </td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="identityCertificateSeries" value="'.$identityCertificateSeries.'"/></td>
			    <input type="hidden" readonly class="textboxme inputreadonly" name="lifeStatus" value="'.$lifeStatus.'"/>
			    <input type="hidden" readonly class="textboxme inputreadonly" name="deathDate" value="'.$deathDate.'"/>
			    <input type="hidden" readonly class="textboxme inputreadonly" name="Err" value="'.$Err.'"/>
			    <input type="hidden" readonly class="textboxme inputreadonly" name="status" value="'.$status.'"/>
			</tr>
		   </table>
		  </fieldset>
		 </td>
	   </tr> 
	   <tr class="title">
        <td colspan="10" align="center">
		 <input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNoOwner='.$PageNoOwner.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNo='.$PageNo.'&id_='.$id_.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if ($Mode=="Edit")//Edit Mode
    { 
	 $q2="SELECT * FROM $TableName T WHERE id_owner='$id_owner_'";
	 $res2=$db->query($q2);
	 $row2=$db->fetch_assoc($res2);
	 if ($row2['gender']==1) $jensiat = 'مرد' ;
     if ($row2['gender']==0) $jensiat = 'زن' ;
	 echo'
     <tr> 
	  <td> 	 
	   <table class="footer-panel" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:10px">
        <tr class="title"><td colspan="10" align="center">ويرايش '.$row2['firstName'].$row2['lastName'].'</td></tr>';
        IF($warehouse_id)echo'<tr><td colspan="8" class="notice">سردخانه شما با شناسه ملی '.$warehouse_id.' در سامانه صمت ثبت شده است</td></tr>';
		ELSE
		{
		 echo'
	     <tr><td colspan="10" class="notice">کد ملی و تاریخ تولد را بدون هیچ گونه علامت اضافه وارد نمایید تا اطلاعات شخص از 
	                       سامانه ثبت احوال دریافت شود
	     </td></tr>';
			
		}
		echo'
	   <tr>
	    <td align="left" width="140px"><span class="star">*</span> کد ملی صاحب سردخانه : &nbsp;</td><td align="right" width="150px"><input type="text" class="textboxme2" name="nationalId" value="'.$row2['nationalId'].'"  maxlength="10"  onkeypress="return isNumber(event)" placeholder="0071234567"/></td>
	    <td align="left" width="130px"><span class="star">*</span> تاریخ تولد : &nbsp;</td><td align="right" width="150px"><input type="text" class="textboxme2" name="birthDate" value="'.$row2['birthDate'].'" onblur="personInfo(document.myform.nationalId.value,this.value)" maxlength="8"  onkeypress="return isNumber(event)" placeholder="13560725"/></td>
	    <td align="left" width="100px"><span class="star">*</span> تلفن همراه : &nbsp;</td><td align="right" width="150px"><input type="text" class="textboxme2" name="mobile" value="'.$row2['mobile'].'" onkeypress="return isNumber(event)" maxlength="11" placeholder="09121234567"></td>
	    <td align="left" width="70px"><span class="star">*</span> وضعیت : &nbsp;</td><td align="right" width="150px">'.static_listbox("activate",$row2['activate'],"activateArr",1,"class='text4'").'</td>
	   	<td align="left" width="150px"><span class="star">*</span> تاریخ انقضای بهره بردار : &nbsp;</td><td align="right" width="150px"><input type="text" class="textboxme2 datepicker6" name="contractor_expire_date" value="'.$row2['contractor_expire_date'].'"  maxlength="10" onkeypress="return isNumber(event)" placeholder="" readonly /></td>
	   </tr>
	   <tr>
	    <td colspan="10">
	     <fieldset>
	      <legend>اطلاعات شخص از سامانه ثبت احوال</legend>
	       <table width="100%" height="100px">
	        <tr>
	        	<td align="left"> نام : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="firstName" value="'.$row2['firstName'].'"/></td>
	        	<td align="left"> نام خانوادگی : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2 inputreadonly" name="lastName" value="'.$row2['lastName'].'"/></td>
	        	<td align="left"> نام پدر : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="fatherName" value="'.$row2['fatherName'].'"/></td>
            </tr>
	        <tr>
	        	<td align="left"> جنسیت : &nbsp;</td><td align="right"><input type="hidden" readonly class="textboxme inputreadonly" name="gender" value="'.$row2['gender'].'"/><input type="text" readonly class="textboxme inputreadonly" name="jensiat" value="'.$jensiat.'" /></td>
	        	<td align="left"> شماره شناسنامه : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="identityCertificateID" value="'.$row2['identityCertificateID'].'"/></td>
	        	<td align="left"> سریال شناسنامه : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="identityCertificateSerial" value="'.$row2['identityCertificateSerial'].'"/></td>
            	<td align="left"> سری شناسنامه : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme inputreadonly" name="identityCertificateSeries" value="'.$row2['identityCertificateSeries'].'"/></td>
				<input type="hidden" readonly class="textboxme inputreadonly" name="lifeStatus" value="'.$row2['lifeStatus'].'"/>
			    <input type="hidden" readonly class="textboxme inputreadonly" name="deathDate" value="'.$row2['deathDate'].'"/>
			    <input type="hidden" readonly class="textboxme inputreadonly" name="Err" value="'.$row2['Err'].'"/>
			    <input type="hidden" readonly class="textboxme inputreadonly" name="status" value="'.$status.'"/>
			</tr>
		   </table>
		  </fieldset>
		 </td>
	   </tr> 
		<tr class="title">
         <td colspan="10" align="center">';
		  if(!$warehouse_id)echo'<input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">';
          echo'<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNoOwner='.$PageNoOwner.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNo='.$PageNo.'&id_='.$id_.'\'">
         </td>
        </tr>
       </table>
	  </td>
     </tr>';
    }
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->';
echo'	
</table>
</div>
'.$message.'
</form>
</body>
</html>';
?>