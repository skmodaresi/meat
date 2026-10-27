<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="typesigns.php";
$TableName="mt_typesign";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(326)) $right_ins=1;
if (right(327)) $right_edt=1;
if (right(328)) $right_del=1;
$titr='امضا کنندگان'; 
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepicker6").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
    });
 });
   function doNow(ch)
   { if(ch=="on") ck=1; else ck=0;
   void(d=document);
   void(el=d.getElementsByTagName("INPUT"));
   for(i=0;i<el.length;i++)
   void(el[i].checked=ck)
   if(ch=="on") ch="off"; else if(ch=="off")ch="on";
   return ch;
   }
</script>
</head>';
// mt_type خواندن اطلاعات جدول
$q_type=$db->query("SELECT form_name FROM mt_type WHERE type_id='$typeID_'");
$res_type=$db->fetch_assoc($q_type);
$form_NAME=$res_type['form_name'];
//تعداد افراد امضاکننده این فرم
$q_count=$db->query("SELECT count(*) FROM mt_typesign WHERE type_id='$typeID_' AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");
$res_count=$db->fetch_array($q_count);
$sign_count=$res_count[0];
$message='';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_typesigns']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($dpt_id)  $temp.=" and T.dpt_id LIKE '$dpt_id'";
 if($manager) $temp.=" and T.manager LIKE '%$manager%'";
 if($expire_date)  $temp.=" and T.expire_date LIKE '%$expire_date%'";
 if($turn)  $temp.=" and T.turn LIKE '$turn'";
 if($activate)  $temp.=" and activate LIKE '$activate'";
 if($temp) {
 $PageNo_detail=1;
 $_SESSION['mt_search_typesigns']=$temp;} else $_SESSION['mt_search_typesigns']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName T INNER JOIN mt_dpt ON mt_dpt.dpt_id=T.dpt_id AND mt_dpt.code_ostan=T.code_ostan AND mt_dpt.code_anbar=T.code_anbar WHERE T.type_id='$typeID_' ".$_SESSION['mt_search_typesigns']." AND T.code_ostan=$mt_gl_code_ostan AND T.code_anbar=$mt_gl_code_anbar AND T.deleted=0");
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo_detail)) $PageNo_detail=1; //$PageNo_detail=$MaxPage;   
$NextPage=$PageNo_detail+1;
$PrevPage=$PageNo_detail-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNo_detail==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNo_detail==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0;
$Limit="Limit ".$FirstRow.",".$RowPerPage; 
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode=''; 
 $del_q = "UPDATE $TableName SET deleted=1 WHERE sign_id=$sign_id_"; 
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$sign_id_','حذف',".($yymmdd).",'$logtime')");
}
/***************************************** MAIN*****************************************/
echo'
<body>
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:40%;">امضا کنندگان '.$form_NAME.' تعداد '.$sign_count.' امضا</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo_detail.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='T.sign_id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($show_img)) $show_img='';
	echo'
	 <td width="5%">شناسه</td>
	 <td width="22%">پست سازمانی امضاکننده</td>
	 <td width="23%">نام امضاکننده</td>
	 <td width="15%">تاریخ پایان خدمت</td>
	 <td width="10%">ترتیب در چاپ</td>
	 <td width="10%">وضعیت</td>';
	 if(($right_del)and($Mode==NULL)) echo'<td width="15%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="15%">دستورات</td>';
	 echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ايجاد"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td>-</td>	  
	   <td>'.listbox("dpt_id",$dpt_id,"dpt_id","dpt_name","mt_dpt","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar","class='text4'").'</td>
	   <td><input type="text" class="textboxme" name="manager" value="'.$manager.'" "/></td>
	   <td><input type="text" class="textboxme2" id="datepicker6" maxlength=10 name="expire_date" value="'.$expire_date.'""/></td>
	   <td><input type="text" class="textboxme" name="turn" value="'.$turn.'" onkeypress="return isNumber(event)" size=1 maxlength=2/></td>
	   <td>'.static_listbox("activate",$activate,"activateArr",1,"class='text4'").'</td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0; 
	$q1="SELECT T.*,mt_dpt.dpt_name From $TableName T INNER JOIN mt_dpt ON mt_dpt.dpt_id=T.dpt_id AND mt_dpt.code_ostan=T.code_ostan AND mt_dpt.code_anbar=T.code_anbar WHERE T.type_id='$typeID_' ".$_SESSION['mt_search_typesigns']." and T.code_ostan=$mt_gl_code_ostan AND T.code_anbar=$mt_gl_code_anbar order by $order $Limit";	
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&sign_id_='.$row1['sign_id'].'&typeID_='.$row1['type_id'].'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['sign_id']==$sign_id_)
	 {
	  echo'
	  <td>'.$row1['sign_id'].'</td>
	  <td>'.listboxMe("dpt_id",$row1['dpt_id'],"dpt_id","dpt_name","mt_dpt","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar","class='text4'").'</td>	  
	  <td><input type="text" class="textboxme" name="manager" value="'.$row1['manager'].'"/></td>
	  <td><input type="text" class="textboxme2" id="datepicker6" name="expire_date" value="'.$row1['expire_date'].'" maxlength=10/></td>
	  <td><input type="text" class="textboxme" name="turn" value="'.$row1['turn'].'" onkeypress="return isNumber(event)"/></td>
	  <td>'.static_listbox("activate",$row1['activate'],"activateArr",1,"class='text4'").'</td>
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['sign_id'].'</td>
	  <td '.$edtClick.'>'.$row1['dpt_name'].'</td>
	  <td '.$edtClick.'>'.$row1['manager'].'</td>
	  <td '.$edtClick.'>'.$row1['expire_date'].'</td>
	  <td '.$edtClick.'>'.$row1['turn'].'</td>
	  <td '.$edtClick.'>'.$activateArr[$row1['activate']].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&sign_id_='.$row1['sign_id'].'&typeID_='.$typeID_.'&code_kala_='.$row1['code_kala'].'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\',\'برای حذف قیمت '.$row1['nameKala'].'\')" /></td>';
	  }
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
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
	  if($right_del) echo'<td>&nbsp;</td>';
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
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
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'types.php?PageNo='.$pageMaster.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail=1&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$PrevPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$NextPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$MaxPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_typesigns']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$pageMaster.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>	 
	</tr>';
    }	
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->';
echo'	
</table>
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($dpt,$type,$m_g,$ex_date,$nobat,$gl_c_o,$gl_c_a)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار موردنظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($dpt and $type and $m_g))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if($dpt and $type and $m_g)//تکراری نبودن شخص با یک پست
 {
   $m_g = trim(preg_replace('/\s+/', ' ', $m_g));
   $q8="SELECT * FROM mt_typesign WHERE type_id='$type' AND dpt_id='$dpt' AND manager='$m_g' AND code_ostan=$gl_c_o AND code_anbar=$gl_c_a";
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('این فرد با این پست قبلا در این فرم ثبت شده است')</script>";
   $flag=false;
   return $flag;
  } 
  else $flag=true;
 }
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($s_id,$dpt,$type,$m_g,$ex_date,$nobat,$gl_c_o,$gl_c_a)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار موردنظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($dpt and $type and $m_g))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if($dpt and $type and $m_g)//تکراری نبودن شخص با یک پست
 {
   $m_g = trim(preg_replace('/\s+/', ' ', $m_g));
   $q8="SELECT * FROM mt_typesign WHERE type_id='$type' AND dpt_id='$dpt' AND manager='$m_g' AND code_ostan=$gl_c_o AND code_anbar=$gl_c_a AND sign_id!='$s_id'";
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('این فرد با این پست قبلا در این فرم ثبت شده است')</script>";
   $flag=false;
   return $flag;
  } 
  else $flag=true;
 }
 return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 if(isPermitSave($dpt_id,$typeID_,$manager,$expire_date,$turn,$mt_gl_code_ostan,$mt_gl_code_anbar))
 { 
  $Mode='';
  $manager=str_replace("ي","ی",$manager);
  $manager=str_replace("ك","ک",$manager);
  $manager = trim(preg_replace('/\s+/', ' ', $manager));
  $insert_q=("INSERT INTO $TableName(type_id,dpt_id,manager,expire_date,turn,code_ostan,code_anbar,activate,deleted)VALUES('$typeID_','$dpt_id','$manager','$expire_date','$turn','$mt_gl_code_ostan','$mt_gl_code_anbar','$activate',0)");  
  $insert_res=mysql_query($insert_q);
  if($insert_res)
  {
   $max_id=$db->get_from_where("Max(sign_id)","$TableName","");  
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");  
   echo '<script>window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$pageMaster.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($sign_id_,$dpt_id,$typeID_,$manager,$expire_date,$turn,$mt_gl_code_ostan,$mt_gl_code_anbar))
 {
  $Mode=''; 
  $manager=str_replace("ي","ی",$manager);
  $manager=str_replace("ك","ک",$manager);
  $manager = trim(preg_replace('/\s+/', ' ', $manager));
  $edit_q=("UPDATE $TableName SET type_id='$typeID_',dpt_id='$dpt_id',manager='$manager',expire_date='$expire_date',turn='$turn',code_ostan=$mt_gl_code_ostan,code_anbar=$mt_gl_code_anbar,activate='$activate' WHERE `sign_id`='$sign_id_';");	
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$sign_id_','ویرایش',".($yymmdd).",'$logtime')");  
   echo '<script>window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$pageMaster.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else if(mysql_affected_rows()==0)   echo '<script>window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$pageMaster.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود امده است ! *</span>';                  
 }
}
/********************END********************/	
echo'
'.$message.'
</form>
</body>
</html>';	
?>