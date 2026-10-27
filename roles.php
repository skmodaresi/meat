<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="roles.php";
$TableName="roles";
$logtime=date('H:i:s');
$titr='نقشهای کاربران';
$right_ins=0;$right_edt=0;$right_del=0;$right_access=0;
if (right(307)) $right_ins=1;
if (right(308)) $right_edt=1;
if (right(309)) $right_del=1; 
if (right(310)) $right_access=1; 
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_roles']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($role_id)          $temp.=" and role_id LIKE '%$role_id%'";
 if($role_description) $temp.=" and role_description LIKE '%$role_description%'";
 if($chk_adminsee)     $temp.=" and chk_adminsee LIKE '$chk_adminsee'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_roles']=$temp;} else $_SESSION['mt_search_roles']="";
 }
/********************PAGING***********************/
//if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if ($_POST['wRowPerPage'] and $wRowPerPage!=$RowPerPage) $RowPerPage=$wRowPerPage;
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_roles']."");
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
function isPermitSave($a,$b)
{
 $flag=false;
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($b))//تکراری نبودن نقش کاربران
 {
   $q9="SELECT * FROM roles WHERE role_description='$b'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('این نقش قبلاً ثبت شده است !')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$this_id)
{
  $flag=false;
  if(!($a and $b))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if(!empty($b))//تکراری نبودن نقش کاربران
  {
    $q10="SELECT * FROM roles WHERE role_description='$b'";
    $res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
    if((mysql_num_rows($res10)>0) and ($row10['id']!=$this_id)){
      echo"<script>alert('این نقش قبلاً ثبت شده است !')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
  }
 else $flag=true;
 return $flag;
}	
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($role_id,$role_description)) 
 {
   $Mode='';
   if ($chk_adminsee=='on') $chk_adminsee=1; else $chk_adminsee=0;
   $role_description=str_replace("ي","ی",$role_description);
   $role_description=str_replace("ك","ک",$role_description);
   $insert_q="INSERT INTO $TableName(role_id,role_description,chk_adminsee) VALUES ('$role_id','$role_description','$chk_adminsee')";
   $insert_res=$db->query($insert_q,'مشکلي در ثبت به وجود آمده است');
   if($insert_res){
    $max_id=$db->get_from_where("Max(role_id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");//کوئری لاگ 
   }
   header('location:'.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'');   
}
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($role_id,$role_description,$id_))
 {
  $Mode='';
  if ($chk_adminsee=='on') $chk_adminsee=1; else $chk_adminsee=0;
  $role_description=str_replace("ي","ی",$role_description);
  $role_description=str_replace("ك","ک",$role_description);
  $edit_q=("UPDATE $TableName SET role_description='$role_description',chk_adminsee='$chk_adminsee' WHERE role_id='$role_id_';");
  $edit_res=$db->query($edit_q,'مشکلي در ويرايش مشخصات به وجود آمده است');
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");//کوئری لاگ 
 // header('location:'.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.''); 
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q ="DELETE FROM $TableName WHERE role_id=$role_id_";
 $del_res = $db->query($del_q);
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاد شده است ، شما مجاز به حذف آن نیستید!')</script>";
 else
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.role_id.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="90%" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:48%;">'.$titr.'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>
 </tr> 
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	 if($sortcode=='1')
	 {echo'<td width="15%" title="مرتب سازی صعودی کد نقش کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=role_id ASC&sortcode=2&show_img=1\'"/> کد نقش کاربر ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {echo'<td width="15%" title="مرتب سازی نزولی کد نقش کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=role_id DESC&sortcode=1&show_img=1\'"/> کد نقش کاربر ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='1')
	 {echo'<td width="25%" title="مرتب سازی صعودی شرح نقش کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=role_description ASC&sortname=2&show_img=2\'"/> شرح نقش کاربر '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {echo'<td width="25%" title="مرتب سازی نزولی شرح نقش کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=role_description DESC&sortname=1&show_img=2\'"/> شرح نقش کاربر '; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }	
	echo'
	 <td width="20%">مشاهده توسط ادمین استان</td>
	 <td width="25%">دسترسی</td>';
	 if($Mode==NULL)echo'<td width="15%">حذف</td>';
	 else echo'<td width="15%">دستورات</td>';
	echo'
	</tr>';
    if($Mode=='Insert')
	{ 
	 $q_roleID="SELECt MAX(role_id) FROM roles";
	 $res_roleID = $db->query($q_roleID);
	 $row_roleID = $db->fetch_array($res_roleID);
	 $role_id=$row_roleID[0];
	 $role_id++;
	 echo'
	 <tr class="table-odd">
	  <td><input type="text" class="textboxme2" readonly name="role_id" value="'.$role_id.'"/></td>
	  <td><input type="text" class="textboxme2" name="role_description" value="'.$role_description.'"/></td>
	  <td><input type="checkbox" name="chk_adminsee"/></td>
	  <td colspan="2"><input type="submit" class="buttonme" name="Insert_x"  id="sabt" value="ثبت"/>
	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>
	 </tr>';
	}
    if($Mode=='Search')	 
	{  
	 echo'
	 <tr class="table-odd">
	  <td><input type="text" class="textboxme2" name="role_id" value="'.$role_id.'" onkeypress="return isNumber(event)"/></td>
	  <td><input type="text" class="textboxme2" name="role_description" value="'.$role_description.'"/></td>
	  <td><input type="checkbox" name="chk_adminsee"/></td>
	  <td colspan="2"><input type="submit" class="buttonme" name="Search_x"  id="sabt" value="جستجو"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>
	 </tr>';
    }
	$i=0;
    $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mt_search_roles']." order by $order $Limit ";
	$allRole = $db->query($q1);
    while($row1=$db->fetch_assoc($allRole))
	{
     //مدیر را نتوانیم عوض کنیم
	 if($row1['role_id']==1) $edtClick='';
	 //ادیت برای سایر نقش ها
	 else if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&role_id_='.$row1['role_id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['role_id']==$role_id_)
	 {
	  if($row1['role_id']==1){echo'<td><input type="text" class="textboxme2" name="role_id" value="'.$row1['role_id'].'" readonly onkeypress="return isNumber(event)"></td>';}
	  else {echo'<td><input type="text" class="textboxme2" name="role_id" value="'.$row1['role_id'].'"  onkeypress="return isNumber(event)"></td>';}
	  echo'<td><input type="text" class="textboxme2" name="role_description" value="'.$row1['role_description'].'"></td>
	  <td><input type="checkbox" name="chk_adminsee"';if($row1['chk_adminsee']==1) echo 'checked="checked"'; else ''; echo'/></td>
	  <td colspan=2>
	   <input class="buttonme" type="submit" name="Edit_x"  id="sabt" value="ثبت تغييرات" >
	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {
	 $accessCount=$db->get_from_where("count(*)","role_access","role_id='".$row1['role_id']."'");
	 echo'
	  <td '.$edtClick.'>'.$row1['role_id'].'</td>
	  <td '.$edtClick.'>'.$row1['role_description'].'</td>
	  <td '.$edtClick.'>';if($row1['chk_adminsee'] == 1)echo '<img src="images/ok2.png" />';else echo '<img src="images/dont.png" />'; echo'</td>	  
	  <td>';
	  if($right_access){echo'<input type="button" class="button-inline" value="دسترسی['.$accessCount.']" onClick="window.location=\'role_access.php?PageNo='.$PageNo.'&wrole_id='.$row1['role_id'].'\'">';}
	  echo'
	  </td>
	  <td>';
	  if(($right_del)and($row1['role_id']!=1))
	  {
	   echo'<img border="0" src="images/trash.png" width="20" height="20" title="حذف" 
	   	  onmouseOver="this.src=\'images/trash_hover.png\'" 
		  onmouseOut="this.src=\'images/trash.png\'" 
	      onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&role_id_='.$row1['role_id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف '.$row1['role_description'].' \')" />';
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
   <table width="100%" border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
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
     if ($_SESSION['mt_search_roles']) 
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
</form>
</body>
</html>';	
?>