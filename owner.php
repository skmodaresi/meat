<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="owner.php";
$TableName="docs";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(196)) $right_ins=1;
if (right(197)) $right_edt=1;
if (right(198)) $right_del=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>اطلاعات اولیه دارنده اصلی سیستم</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
 function enterIE()
 {
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
 }
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['search_owner']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x=""; 
 $temp="";
 if($owner)  $temp.=" and owner LIKE '%$owner%'";
 if($sherkat_name) $temp.=" and sherkat_name LIKE '%$sherkat_name%'";
 if($email) $temp.=" and email LIKE '%$email%'";
 if($tel) $temp.=" and tel LIKE '%$tel%'";
 if($fax) $temp.=" and fax LIKE '%$fax%'";
 if($url) $temp.=" and url LIKE '%$url%'";
 if($temp) {$PageNo=1;$_SESSION['search_owner']=$temp;} else $_SESSION['search_owner']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['search_owner']."");
$row = mysql_fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo)) $PageNo=1;//$PageNo=$MaxPage; 
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
function isPermitSave($a,$b,$mail,$d,$e,$site)
{
 $flag=false;
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if((!empty($mail)) and (!filter_var($mail,FILTER_VALIDATE_EMAIL)))
 {
   $flag=false;
   echo"<script>alert('آدرس ایمیل نامعتبر است !')</script>";
   return $flag;
 }
 else $flag=true;
 if((!empty($site)) and (!filter_var($site,FILTER_VALIDATE_URL)))//چک کردن وب سايت		  
 {
   $flag=false;
    echo "<script>alert('آدرس سايت نامعتبر است');</script>";
    return $flag;
 }
 else $flag=true;  
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$mail,$d,$e,$site,$g)
{
  $flag=false;
  if(!($a and $b))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if((!empty($mail)) and (!filter_var($mail,FILTER_VALIDATE_EMAIL)))
  {
   $flag=false;
   echo"<script>alert('آدرس ایمیل نامعتبر است !')</script>";
   return $flag;
  }
  else $flag=true;
  if((!empty($site)) and (!filter_var($site,FILTER_VALIDATE_URL)))//چک کردن وب سايت		  
  {
   $flag=false;
    echo "<script>alert('آدرس سايت نامعتبر است');</script>";
    return $flag;
  }
  else $flag=true;  
 return $flag;
}	
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($owner,$sherkat_name,$email,$tel,$fax,$url)) 
 {
  $Mode='';
  $insert_q=("INSERT INTO $TableName(owner,sherkat_name,email,tel,fax,url)
             VALUES('$owner',TRIM('$sherkat_name'),TRIM('$email'),TRIM('$tel'),TRIM('$fax'),TRIM('$url'))");
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");//کوئری لاگ 
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت واحد کالا به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($owner,$sherkat_name,$email,$tel,$fax,$url,$id_))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET owner='$owner',sherkat_name=TRIM('$sherkat_name'),email=TRIM('$email'),tel=TRIM('$tel'),fax=TRIM('$fax'),url=TRIM('$url') WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");//کوئری لاگ 
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود امده است ! *</span>';
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q ="DELETE FROM $TableName WHERE id=$id_ AND
         ($owner_ NOT IN(SELECT owner FROM kala WHERE owner=$owner_))";
 $del_res = $db->query($del_q);
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ
} 
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.owner.focus();">
<form method="post" name="myform" onkeydown="enterIE()"
<div align="center">
<table width="98%" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:43%;">اطلاعات اولیه دارنده اصلی سیستم</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>  
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden; ">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order)) $order='id DESC';
	echo'
	 <td width="20%">عنوان دارنده اصلی سیستم</td>
	 <td width="15%">نام شرکت پشتیبان</td>
	 <td width="15%">پست الکترونیک</td>
	 <td width="10%">تلفن</td>
	 <td width="10%">دورنگار</td>
	 <td width="16%">آدرس سایت اینترنتی</td>';
	 if($Mode==NULL)echo'<td width="14%">حذف</td>';
	 else echo'<td width="14%">دستورات</td>';
	echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ايجاد"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme" name="owner" value="'.$owner.'"/></td>
	   <td><input type="text" class="textboxme" name="sherkat_name" value="'.$sherkat_name.'" /></td>
	   <td><input class="textboxme" type="text" name="email" value="'.$email.'"/></td>
       <td><input class="textboxme" type="text" name="tel" value="'.$tel.'" onkeypress="return isNumber(event)"/></td>
       <td><input class="textboxme" type="text" name="fax" value="'.$fax.'" onkeypress="return isNumber(event)"/></td>
	   <td><input class="textboxme" type="text" name="url" value="'.$url.'"/></td>       
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['search_owner']." order by $order $Limit";
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  echo'
	  <td><input type="text" class="textboxme" name="owner" value="'.$row1['owner'].'"/></td>
	  <td><input type="text" class="textboxme" name="sherkat_name" value="'.$row1['sherkat_name'].'"/></td>
	  <td><input type="text" class="textboxme" name="email" value="'.$row1['email'].'"/></td>
	  <td><input type="text" class="textboxme2" name="tel" value="'.$row1['tel'].'" onkeypress="return isNumber(event)"/></td>
	  <td><input type="text" class="textboxme2" name="fax" value="'.$row1['fax'].'" onkeypress="return isNumber(event)"/></td>
	  <td><input type="text" class="textboxme" name="url" value="'.$row1['url'].'"/></td>
	  <td>
	   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['owner'].'</td>
	  <td '.$edtClick.'>'.$row1['sherkat_name'].'</td>
	  <td '.$edtClick.'>'.$row1['email'].'</td>
	  <td '.$edtClick.'>'.$row1['tel'].'</td>
	  <td '.$edtClick.'>'.$row1['fax'].'</td>
	  <td '.$edtClick.'>'.$row1['url'].'</td>
	  <td>';
	  if($right_del)
	  {
	   echo'<img border="0" src="images/trash.png" width="20" height="20" title="حذف" 
	    	  onmouseOver="this.src=\'images/trash_hover.png\'" 
		      onmouseOut="this.src=\'images/trash.png\'" 
	          onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&owner_='.$row1['owner'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'\',\'براي حذف '.$row1['sherkat_name'].' \')" />';
	  }
	  echo'</td>';
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
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	 </tr>';
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 echo'
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'
	 <td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'
	 <td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
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
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()"  onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['search_owner']) 
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
 <!-- پايان فوتر-->';
echo'	
</table>
</div>
'.$message .'
</form>
</body>
</html>';	
?>