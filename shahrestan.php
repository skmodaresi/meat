<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="shahrestan.php";
$TableName="shahrestan";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(7)) $right_ins=1;
if (right(8)) $right_edt=1;
if (right(9)) $right_del=1;
$titr='شهرستان ها';
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
// خواندن اطلاعات جدول استان ها
$c=$db->query("SELECT * FROM ostan WHERE code_ostan='$codeOstan_'");
$r=$db->fetch_array($c);
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_shahrestan']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($city_code) $temp.=" and city_code LIKE '%$city_code%'";
 if($city_name) $temp.=" and city_name LIKE '%$city_name%'";
 if($temp) {
 $PageNo_detail=1;
 $_SESSION['mt_search_shahrestan']=$temp;} else $_SESSION['mt_search_shahrestan']="";
}
/******************** Insert- Edit- Delete ************/
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($a,$b,$c)
{
 $flag=false;
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if (!justNumber($a))//عدد بودن کد شهرستان
 {
   $flag=false;
   echo"<script>alert('فيلد کد شهرستان نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if(!empty($a))//تکراری نبودن کد شهرستان برای هر استان
 { 
  $q8="SELECT city_code FROM shahrestan WHERE city_code='$a' AND code_ostan='$c'";
  $res8=mysql_query($q8);
  if(mysql_num_rows($res8)>0){
  echo"<script>alert('اين کد شهر قبلاً برای این استان ثبت شده است !')</script>";
  $flag=false;
  return $flag;
  }
  else $flag=true;
 }
 else $flag=true;  
 if(!empty($b))//تکراري نبودن نام شهرستان
 {
   $q9="SELECT * FROM shahrestan WHERE code_ostan='$c' and city_name='$b'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام شهرستان قبلاً برای این استان ثبت شده است !')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
$myMessage='';
function isPermitEdit($a,$b,$c,$d)
{
  $flag=false;
  if(!($a and $b))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   //echo $myMessage.='<span style="color:red">لطفا تمام فيلد ها را تکميل نماييد</span>';
   return $flag;
  } 
  else $flag=true;
  if (!justNumber($a))//عدد بودن کدشهرستان
  {
   $flag=false;
   echo"<script>alert('فيلد کد شهرستان نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($a))//تکراری نبودن کد شهرستان برای هر استان
  { 
   $q10="SELECT * FROM shahrestan WHERE city_code='$a' AND code_ostan='$c'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$d)){
   echo"<script>alert('اين کد شهر قبلاً برای این استان ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;  
  if(!empty($b))//تکراري نبودن نام شهرستان
  {
    $q10="SELECT * FROM shahrestan WHERE code_ostan='$c' and city_name='$b'";
    $res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
    if((mysql_num_rows($res10)>0) and ($row10['id']!=$d)){
      echo"<script>alert('اين نام شهرستان قبلاً برای این استان ثبت شده است !')</script>";
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
  if(isPermitSave($city_code,$city_name,$codeOstan_))
 {
  $Mode='';
  $city_name=str_replace("ي","ی",$city_name);
  $city_name=str_replace("ك","ک",$city_name);
  $insert_q=("INSERT INTO $TableName(code_ostan,city_code,city_name) VALUES('$codeOstan_','$city_code',TRIM('$city_name'))");
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت شهرستان به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($city_code,$city_name,$codeOstan_,$id_))
 {
  $Mode='';
  $city_name=str_replace("ي","ی",$city_name);
  $city_name=str_replace("ك","ک",$city_name);
  $edit_q=("UPDATE $TableName SET code_ostan='$codeOstan_',city_code='$city_code',city_name=TRIM('$city_name') WHERE id='$id_';");
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
        ($city_code_ NOT IN(SELECT city_code FROM moshtary WHERE city_code=$city_code_ AND code_ostan=$codeOstan_))";
 $del_res=$db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
    echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res=$db->query("SELECT COUNT(*) FROM $TableName WHERE code_ostan='$codeOstan_' ".$_SESSION['mt_search_shahrestan']."");
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo_detail)) $PageNo_detail=$MaxPage;  //$PageNo_detail=1; 
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
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.city_code.focus();">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="700px" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:45%;">شهرستانهای استان&nbsp;'.$r['name_ostan'].'</div>
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
if(!isset($order))    $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="33%" title="مرتب سازی صعودی کد شهرستان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=city_code ASC&sortcode=2&show_img=1\'"/> کد شهرستان ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="33%" title="مرتب سازی نزولی کد شهرستان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=city_code DESC&sortcode=1&show_img=1\'"/> کد شهرستان ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="33%" title="مرتب سازی صعودی نام شهرستان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=city_name ASC&sortname=2&show_img=2\'"/> نام شهرستان '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="33%" title="مرتب سازی نزولی نام شهرستان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=city_name DESC&sortname=1&show_img=2\'"/> نام شهرستان '; 
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
	   <td><input type="text" class="textboxme2" name="city_code" value="'.$city_code.'" onkeypress="return isNumber(event)"/></td>
	   <td><input type="text" class="textboxme2" name="city_name" value="'.$city_name.'" ></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT *,(SELECT count(city_code) FROM moshtary m WHERE m.city_code=T.city_code AND m.code_ostan='$code_ostan_') exist_moshtary
	     From $TableName T WHERE code_ostan='$codeOstan_' ".$_SESSION['mt_search_shahrestan']." order by $order $Limit";	
	$allShahr=$db->query($q1);
    while($row1=$db->fetch_assoc($allShahr))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&codeOstan_='.$row1['code_ostan'].'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  if($row1['exist_moshtary']) echo'<td><input type="text" class="textboxme2" name="city_code" readonly value="'.$row1['city_code'].'" style:width:100%></td>';
	  else echo'<td><input type="text" class="textboxme2" name="city_code" value="'.$row1['city_code'].'" onkeypress="return isNumber(event)" style:width:100%></td>';
	  echo'<td><input type="text" class="textboxme2" name="city_name" value="'.$row1['city_name'].'" style:width:100%></td>
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['city_code'].'</td>
	  <td '.$edtClick.'>'.$row1['city_name'].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" title="حذف"  
	       onmouseOver="this.src=\'images/trash_hover.png\'"  
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&city_code_='.$row1['city_code'].'&codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\',\'براي حذف شهرستان '.$row1['city_name'].' \')" /></td>';
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
	 <td width="24"><div onClick="window.open(\'print_shahrestan.php?codeOstan_='.$codeOstan_.'\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'ostan.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail=1&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$PrevPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$NextPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$MaxPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_shahrestan']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?codeOstan_='.$codeOstan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'&open_filter=1\'"></td>';	 
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
'.$message.'
</form>
</body>
</html>';	
?>