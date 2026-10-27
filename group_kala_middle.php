<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="group_kala_middle.php";
$TableName="group_kala_middle";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(37)) $right_ins=1;
if (right(38)) $right_edt=1;
if (right(39)) $right_del=1;
$titr='گروه کالا میانی';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
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
  $_SESSION['search_group_kala_middle']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x=""; 
 $temp="";
 if($code_group_kala_middle) $temp.=" and code_group_kala_middle LIKE '%$code_group_kala_middle%'";
 if($name_group_kala_middle) $temp.=" and name_group_kala_middle LIKE '%$name_group_kala_middle%'";
 if ($temp) {$PageNo=1;$_SESSION['search_group_kala_middle']=$temp;} else $_SESSION['search_group_kala_middle']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['search_group_kala_middle']." AND group_type_middle=2");
$row = $db->fetch_array($res);
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
function isPermitSave($c_gr,$n_gr,$gr_ty)
{
 $flag=false;
 if(!($c_gr and $n_gr and $gr_ty))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if (!justNumber($c_gr))//عدد بودن کد گروه کالا
 {
   $flag=false;
   echo"<script>alert('فيلد کد گروه کالا نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!empty($c_gr))//تکراری نبودن کد گروه کالا
 { 
   $code_a=make_pattern($c_gr,5); 
   $q8="SELECT code_group_kala_middle FROM group_kala WHERE code_group_kala_middle='$code_a'";
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('اين کد گروه کالا قبلاً ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if(!empty($n_gr))//تکراري نبودن نام گروه کالا
 {
   $q9="SELECT * FROM group_kala WHERE name_group_kala_middle='$n_gr'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام گروه کالا قبلاً ثبت شده است!')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($c_gr,$n_gr,$gr_ty,$this_id)
{
  $flag=false;
  if(!($c_gr and $n_gr and $gr_ty))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if (!justNumber($c_gr))//عدد بودن کد گروه کالا
  {
   $flag=false;
   echo"<script>alert('فيلد کد گروه کالا نامعتبر است!')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($c_gr))//تکراری نبودن کد گروه کالا
  { 
   $code_a=make_pattern($c_gr,5); 
   $q10="SELECT * FROM group_kala WHERE code_group_kala_middle='$code_a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$this_id)){
   echo"<script>alert('اين کد گروه کالا قبلاً ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
  if(!empty($n_gr))//تکراري نبودن نام گروه کالا
  {
    $q11="SELECT * FROM group_kala WHERE name_group_kala_middle='$n_gr'";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);	
    if((mysql_num_rows($res11)>0) and ($row11['id']!=$this_id)){
      echo"<script>alert('اين نام گروه کالا قبلاً ثبت شده است!')</script>";
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
 if(isPermitSave($code_group_kala_middle,$name_group_kala_middle,$group_type_middle)) 
 {
  $Mode='';
  $name_group_kala_middle=str_replace("ي","ی",$name_group_kala_middle);
  $name_group_kala_middle=str_replace("ك","ک",$name_group_kala_middle);
  $insert_q=("INSERT INTO $TableName(code_group_kala_middle,name_group_kala_middle,group_type_middle)VALUES('$code_group_kala_middle',TRIM('$name_group_kala_middle'),'$group_type_middle')");
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت گروه کالا به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_group_kala_middle,$name_group_kala_middle,$group_type_middle,$id_))
 {
  $Mode='';
  $name_group_kala_middle=str_replace("ي","ی",$name_group_kala_middle);
  $name_group_kala_middle=str_replace("ك","ک",$name_group_kala_middle);
  $edit_q=("UPDATE $TableName SET code_group_kala_middle='$code_group_kala_middle',name_group_kala_middle=TRIM('$name_group_kala_middle'),group_type_middle='$group_type_middle' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");
  else if(mysql_affected_rows==0) $message='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>'; 
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id=$id_ AND
        ($code_group_kala_ NOT IN(SELECT code_group_kala_middle FROM kala WHERE code_group_kala_middle=$code_group_kala_))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_group_kala_middle.focus();">
<form method="post" name="myform" id="myform" onkeydown="enterIE()">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:48%;">گروه کالا میانی</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td> 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->
 <tr>
  <td height="100%">
  <table  width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="15%" title="مرتب سازی صعودی کد گروه کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_group_kala_middle ASC&sortcode=2&show_img=1\'"/> کد گروه کالا ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="15%" title="مرتب سازی نزولی کد گروه کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_group_kala_middle DESC&sortcode=1&show_img=1\'"/> کد گروه کالا ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="45%" title="مرتب سازی صعودی نام گروه کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_group_kala_middle ASC&sortname=2&show_img=2\'"/> نام گروه کالا '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="45%" title="مرتب سازی نزولی نام گروه کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_group_kala_middle DESC&sortname=1&show_img=2\'"/> نام گروه کالا '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'<td width="20">نوع گروه کالا</td>';
	if(($right_del)and($Mode==NULL)) echo'<td width="20%">حذف</td>';
    else if($Mode!=NULL) echo'<td width="20%">دستورات</td>';
	echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 $group_type_default=2;//گوشتی
	 if ($Mode=='Insert') {$button_value="ايجاد"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme2" name="code_group_kala_middle" value="'.$code_group_kala_middle.'" maxlength="5" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme" name="name_group_kala_middle" value="'.$name_group_kala_middle.'" /></td>
	   <td>'.static_listbox("group_type_middle",$group_type_default,"grouptypeArr",1,"class='text4'").'</td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" />
	   </td>
	  </tr>';
	}
	$i=0;
	$q1="SELECT *,(SELECT count(code_group_kala_middle) FROM kala k WHERE k.code_group_kala_middle=T.code_group_kala_middle) exist_kala
	     From $TableName T WHERE 1=1 ".$_SESSION['search_group_kala_middle']." AND group_type_middle=2 order by $order $Limit ";
	$allKeshty = $db->query($q1);
    while($row1=$db->fetch_assoc($allKeshty))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  if($row1['exist_kala']) echo'<td><input type="text" class="textboxme2" title="غیر قابل تغییر" name="code_group_kala_middle" readonly value="'.$row1['code_group_kala_middle'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
      else echo'<td><input type="text" class="textboxme2" name="code_group_kala_middle" value="'.$row1['code_group_kala_middle'].'" maxlength="5" onkeypress="return isNumber(event)" style="width:50px"/></td>';
	  echo'
	  <td><input type="text" class="textboxme" name="name_group_kala_middle" value="'.$row1['name_group_kala_middle'].'"/></td>
	  <td>'.static_listbox("group_type_middle",$row1['group_type_middle'],"grouptypeArr",1,"class='text4'").'</td>
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات"/>
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['code_group_kala_middle'].'</td>
	  <td '.$edtClick.'>'.$row1['name_group_kala_middle'].'</td>
	  <td '.$edtClick.'>'.$grouptypeArr[$row1['group_type_middle']].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_group_kala_='.$row1['code_group_kala_middle'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف گروه کالا  '.$row1['name_group_kala_middle'].' \')"/></td>';
	  }
	  else if($Mode!=NULL) echo'<td>&nbsp;</td>';
	  else echo'';
	 }
	echo '
	</tr>';
	}
    for ($r=$i+1; $r<=$RowPerPage; $r++)
    {if($r%2) echo'
     <tr class="table-even">';
     else echo '
     <tr class="table-odd">';
     echo '
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
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_group_kala.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';
	 }
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوی اصلی"  ><a href="#"></a></div></td> 
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
     if ($_SESSION['search_group_kala_middle']) 
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