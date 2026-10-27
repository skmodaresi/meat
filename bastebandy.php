<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="bastebandy.php";
$TableName="bastebandy";
$logtime=date('H:i:s');
$titr='نوع بسته بندی';
$right_ins=0;$right_edt=0;$right_del=0;
if (right(33)) $right_ins=1;
if (right(34)) $right_edt=1;
if (right(35)) $right_del=1; 
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
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
$message='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['search_baste']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x=""; 
 $temp="";
 if($code_bastebandy)  $temp.=" and code_bastebandy LIKE '%$code_bastebandy%'";
 if($sharh_bastebandy) $temp.=" and sharh_bastebandy LIKE '%$sharh_bastebandy%'";
 if ($temp) {$PageNo=1;$_SESSION['search_baste']=$temp;} else $_SESSION['search_baste']="";
}
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['search_baste']."");
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
 if (!justNumber($a))//عدد بودن کد نوع بسته بندی
 {
   $flag=false;
   echo"<script>alert('فيلد کد نوع بسته بندی نامعتبر است !')</script>";
   return $flag;
 }
 else $flag=true;
 if(!empty($a))//تکراری نبودن کد نوع بسته بندی
 { 
  //$code_a=make_pattern($a,2); 
  $q8="SELECT code_bastebandy FROM bastebandy WHERE code_bastebandy='$a'";
  $res8=mysql_query($q8);
  if(mysql_num_rows($res8)>0){
  echo"<script>alert('اين کد نوع بسته بندی قبلاً ثبت شده است !')</script>";
  $flag=false;
  return $flag;
  }
  else $flag=true;
 }
 else $flag=true; 
 if(!empty($b))//تکراري نبودن شرح نوع بسته بندی
 {
   $q9="SELECT * FROM bastebandy WHERE sharh_bastebandy='$b'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين شرح نوع بسته بندی قبلاً ثبت شده است!')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$c)
{
  $flag=false;
  if(!($a and $b))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if (!justNumber($a))//عدد بودن کد نوع بسته بندی
  {
   $flag=false;
   echo"<script>alert('فيلد کد نوع بسته بندی نامعتبر است ')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($a))//تکراری نبودن کد نوع بسته بندی
  { 
   //$code_a=make_pattern($a,2); 
   $q10="SELECT * FROM bastebandy WHERE code_bastebandy='$a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$c)){
   echo"<script>alert('اين کد نوع بسته بندی قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;  
  if(!empty($b))//تکراري نبودن شرح نوع بسته بندی
  {
    $q11="SELECT * FROM bastebandy WHERE sharh_bastebandy='$b'";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);
    if((mysql_num_rows($res11)>0) and ($row11['id']!=$c)){
      echo"<script>alert('اين شرح نوع بسته بندی قبلاً ثبت شده است!')</script>";
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
 if(isPermitSave($code_bastebandy,$sharh_bastebandy)) 
 {
  $Mode='';
  $sharh_bastebandy=str_replace("ي","ی",$sharh_bastebandy);
  $sharh_bastebandy=str_replace("ك","ک",$sharh_bastebandy);
  $insert_q=("INSERT INTO $TableName(code_bastebandy,sharh_bastebandy)VALUES('$code_bastebandy',TRIM('$sharh_bastebandy'))");
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");//کوئری لاگ  header('location:'.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'');   
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت بسته بندی به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_bastebandy,$sharh_bastebandy,$id_))
 {
  $Mode='';
  $sharh_bastebandy=str_replace("ي","ی",$sharh_bastebandy);
  $sharh_bastebandy=str_replace("ك","ک",$sharh_bastebandy);
  $edit_q=("UPDATE $TableName SET code_bastebandy='$code_bastebandy',sharh_bastebandy=TRIM('$sharh_bastebandy') WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");//کوئری لاگ 
  else if(mysql_affected_rows==0) $message='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>'; 
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id=$id_ AND
        ($code_bastebandy_ NOT IN(SELECT code_bastebandy FROM kala WHERE code_bastebandy=$code_bastebandy_))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
 }
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_bastebandy.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="700px" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">'.$titr.'</div>
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
if(!isset($order)) $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	 if($sortcode=='1')
	 {echo'<td width="33%" title="مرتب سازی صعودی کد نوع بسته بندی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_bastebandy ASC&sortcode=2&show_img=1\'"/> کد نوع بسته بندی ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {echo'<td width="33%" title="مرتب سازی نزولی کد نوع بسته بندی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_bastebandy DESC&sortcode=1&show_img=1\'"/> کد نوع بسته بندی ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='1')
	 {echo'<td width="33%" title="مرتب سازی صعودی شرح نوع بسته بندی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sharh_bastebandy ASC&sortname=2&show_img=2\'"/> شرح نوع بسته بندی '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {echo'<td width="33%" title="مرتب سازی نزولی شرح نوع بسته بندی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sharh_bastebandy DESC&sortname=1&show_img=2\'"/> شرح نوع بسته بندی '; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if(($right_del)and($Mode==NULL)) echo'<td width="34%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="34%">دستورات</td>';
	echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ايجاد"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme2" name="code_bastebandy" value="'.$code_bastebandy.'" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme2" name="sharh_bastebandy" value="'.$sharh_bastebandy.'" /></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['search_baste']." order by $order $Limit ";
	$allBastebandy = $db->query($q1);
    while($row1=$db->fetch_assoc($allBastebandy))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  $exist_kala=$db->get_from_where("count(code_bastebandy)","kala","code_bastebandy=".$row1['code_bastebandy']."");
      if($exist_kala)echo '<td><input type="text" class="textboxme2" title="غیر قابل تغییر" name="code_bastebandy" readonly value="'.$row1['code_bastebandy'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
	  else echo '<td><input type="text" class="textboxme2" name="code_bastebandy" value="'.$row1['code_bastebandy'].'" onkeypress="return isNumber(event)" style="width:50px"/></td>';
	  echo'
	  <td><input type="text" class="textboxme2" name="sharh_bastebandy" value="'.$row1['sharh_bastebandy'].'"></td>
	  <td>
	   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['code_bastebandy'].'</td>
	  <td '.$edtClick.'>'.$row1['sharh_bastebandy'].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف" 
	   	  onmouseOver="this.src=\'images/trash_hover.png\'" 
		  onmouseOut="this.src=\'images/trash.png\'" 
	      onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_bastebandy_='.$row1['code_bastebandy'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف '.$row1['sharh_bastebandy'].' \')" /></td>';
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
	  <td>&nbsp;</td>';
	  if($right_del) echo'<td>&nbsp;</td>';
	  else if($Mode!=NULL) echo'<td>&nbsp;</td>';
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
   <table width="100%" border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_bastebandy.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
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
     if ($_SESSION['search_baste']) 
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