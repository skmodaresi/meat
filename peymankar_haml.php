<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="peymankar_haml.php";
//echo "<script>alert(".$_SESSION['mt_systemmabadi'].")</script>";
if($_SESSION['mt_systemmabadi']==0)//اطلاعات پیمانکار حمل از سیستم انبار
{
 $TableName="peymankar_haml";
 $right_ins=0;$right_edt=0;$right_del=0;
 if (right(123)) $right_ins=1;
 if (right(124)) $right_edt=1;
 if (right(125)) $right_del=1; 
}
if($_SESSION['mt_systemmabadi']==1)//اطلاعات پیمانکار حمل از سیستم مبادی
{
 $db->selectDb('mabadi');
 $TableName="mbd_pymnkr";
}
$logtime=date('H:i:s');
$titr='پيمانکاران حمل';
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
  $_SESSION['mt_search_peymankar_haml']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($_SESSION['mt_systemmabadi']==0)//انبار
 { 
  if($code_peymankar_haml) $temp.=" and code_peymankar_haml LIKE '%$code_peymankar_haml%'";
  if($name_peymankar_haml) $temp.=" and name_peymankar_haml LIKE '%$name_peymankar_haml%'";
 }
 if($_SESSION['mt_systemmabadi']==1)//مبادی
 {
  if($pymnkr_id) $temp.=" and pymnkr_id LIKE '%$pymnkr_id%'";
  if($pymnkr_name) $temp.=" and pymnkr_name LIKE '%$pymnkr_name%'";
 }
 if($temp) {$PageNo=1;$_SESSION['mt_search_peymankar_haml']=$temp;} else $_SESSION['mt_search_peymankar_haml']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_peymankar_haml']."");
$row = mysql_fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo)) $PageNo=1;  //$PageNo=$MaxPage;
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
 if (!justNumber($a))//عدد بودن کد پيمانکار
 {
   $flag=false;
   echo"<script>alert('فيلد کد پيمانکار نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if(!empty($a))//تکراری نبودن کد پیمانکار
 { 
    //$code_a=make_pattern($a,5); 
    $q8="SELECT code_peymankar_haml FROM peymankar_haml WHERE code_peymankar_haml='$a'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين کد پیمانکار قبلاً ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;  
 if(!empty($b))//تکراري نبودن نام پيمانکار
 {
   $q9="SELECT * FROM peymankar_haml WHERE name_peymankar_haml='$b'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام پيمانکار قبلا ثبت شده است')</script>";
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
  if (!justNumber($a))//عدد بودن کد پيمانکار
  {
   $flag=false;
   echo"<script>alert('فيلد کد پيمانکار نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($a))//تکراری نبودن کد پیمانکار
  { 
   //$code_a=make_pattern($a,5); 
   $q10="SELECT * FROM peymankar_haml WHERE code_peymankar_haml='$a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$c)){
   echo"<script>alert('اين کد پیمانکار قبلاً ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;   
  if(!empty($b))//تکراري نبودن نام پيمانکار
  {
    $q10="SELECT * FROM peymankar_haml WHERE name_peymankar_haml='$b'";
    $res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
    if((mysql_num_rows($res10)>0) and ($row10['id']!=$c)){
      echo"<script>alert('اين نام کشتي قبلا ثبت شده است')</script>";
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
 if(isPermitSave($code_peymankar_haml,$name_peymankar_haml))
 {
   $Mode='';
   $name_peymankar_haml=str_replace("ي","ی",$name_peymankar_haml);
   $name_peymankar_haml=str_replace("ك","ک",$name_peymankar_haml);
   $insert_q=("INSERT INTO $TableName(code_peymankar_haml,name_peymankar_haml)VALUES('$code_peymankar_haml',TRIM('$name_peymankar_haml'))");
   $insert_res=mysql_query($insert_q);
   if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");//کوئری لاگ    
   }
   else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت پیمانکار به وجود آمده است ! *</span>';
 }
}    
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_peymankar_haml,$name_peymankar_haml,$id_))
 {
  $Mode='';
  $name_peymankar_haml=str_replace("ي","ی",$name_peymankar_haml);
  $name_peymankar_haml=str_replace("ك","ک",$name_peymankar_haml);
  $edit_q=("UPDATE $TableName SET code_peymankar_haml='$code_peymankar_haml',name_peymankar_haml=TRIM('$name_peymankar_haml') WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");//کوئری لاگ   
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود امده است ! *</span>';
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id=$id_ AND
        ($code_peymankar_haml_ NOT IN(SELECT code_peymankar_haml FROM resid WHERE code_peymankar_haml=$code_peymankar_haml_ AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
}
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
if($_SESSION['mt_systemmabadi']==0) $load="document.myform.code_peymankar_haml.focus();";
if($_SESSION['mt_systemmabadi']==1) $load="document.myform.pymnkr_id.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="800px" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">';
   if($_SESSION['mt_systemmabadi']==1)echo'<div class="etesal">متصل به سیستم مبادی</div>';
   echo'<div style="position:absolute;top:5px;left:47%;"> پیمانکاران حمل</div>
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
if(!isset($order))    {if($_SESSION['mt_systemmabadi']==0)$order='id DESC'; if($_SESSION['mt_systemmabadi']==1)$order='pymnkr_id DESC';}
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{
	 if($_SESSION['mt_systemmabadi']==0) echo'<td width="30%" title="مرتب سازی صعودی کد پيمانکار حمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_peymankar_haml ASC&sortcode=2&show_img=1\'"/> کد پيمانکار حمل ';
	 if($_SESSION['mt_systemmabadi']==1) echo'<td width="30%" title="مرتب سازی صعودی کد پيمانکار حمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=pymnkr_id ASC&sortcode=2&show_img=1\'"/> کد پيمانکار حمل ';
	 if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{
	 if($_SESSION['mt_systemmabadi']==0)echo'<td width="30%" title="مرتب سازی نزولی کد پيمانکار حمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_peymankar_haml DESC&sortcode=1&show_img=1\'"/> کد پيمانکار حمل ';
	 if($_SESSION['mt_systemmabadi']==1)echo'<td width="30%" title="مرتب سازی نزولی کد پيمانکار حمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=pymnkr_id DESC&sortcode=1&show_img=1\'"/> کد پيمانکار حمل ';
	 if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{
	 if($_SESSION['mt_systemmabadi']==0)echo'<td width="40%" title="مرتب سازی صعودی نام پيمانکار حمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_peymankar_haml ASC&sortname=2&show_img=2\'"/> نام پيمانکار حمل '; 
	 if($_SESSION['mt_systemmabadi']==1)echo'<td width="40%" title="مرتب سازی صعودی نام پيمانکار حمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=pymnkr_name ASC&sortname=2&show_img=2\'"/> نام پيمانکار حمل '; 
	 if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{
	 if($_SESSION['mt_systemmabadi']==0)echo'<td width="40%" title="مرتب سازی نزولی نام پيمانکار حمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_peymankar_haml DESC&sortname=1&show_img=2\'"/> نام پيمانکار حمل '; 
	 if($_SESSION['mt_systemmabadi']==1)echo'<td width="40%" title="مرتب سازی نزولی نام پيمانکار حمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=pymnkr_name DESC&sortname=1&show_img=2\'"/> نام پيمانکار حمل '; 
	 if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
    if($_SESSION['mt_systemmabadi']==0)//سیستم انبار
	{
	  if(($right_del)and($Mode==NULL)) echo'<td width="30%">حذف</td>';
      else if($Mode!=NULL) echo'<td width="30%">دستورات</td>';
	}
	//سیستم مبادی
	if(($_SESSION['mt_systemmabadi']==1)and($Mode=='Search')) echo'<td width="34%">دستورات</td>';
	echo'
	</tr>';
	if($Mode=='Insert')
	{
	 echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme2" name="code_peymankar_haml" value="'.$code_peymankar_haml.'" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme" name="name_peymankar_haml" value="'.$name_peymankar_haml.'" /></td>
	   <td><input type="submit" class="buttonme" name="Insert_x" id="sabt" value="ايجاد">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}//END Insert
    if($Mode=='Search')
	{
	 echo'
	  <tr class="table-odd">';
	  if($_SESSION['mt_systemmabadi']==0){
	  echo'
	   <td><input type="text" class="textboxme2" name="code_peymankar_haml" value="'.$code_peymankar_haml.'" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme" name="name_peymankar_haml" value="'.$name_peymankar_haml.'" /></td>';
	  }
	  if($_SESSION['mt_systemmabadi']==1){
	  echo'
	   <td><input type="text" class="textboxme2" name="pymnkr_id" value="'.$pymnkr_id.'" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme" name="pymnkr_name" value="'.$pymnkr_name.'" /></td>';
	  }
      echo'	  
	   <td><input type="submit" class="buttonme" name="Search_x" id="sabt" value="جستجو">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}//END Search
	$i=0;
	$q1="SELECT * From $TableName T WHERE 1=1 ".$_SESSION['mt_search_peymankar_haml']." order by $order $Limit";
	$allPeymankar = $db->query($q1);
    while($row1=$db->fetch_assoc($allPeymankar))
	{
     if(($right_edt)and($_SESSION['mt_systemmabadi']==0)){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  $exist_resid=$db->get_from_where("count(code_peymankar_haml)","resid","code_peymankar_haml=".$row1['code_peymankar_haml']." AND deleted=0");
	  if($exist_resid) echo'<td><input type="text" class="textboxme2" title="غیر قابل تغییر" name="code_peymankar_haml" readonly value="'.$row1['code_peymankar_haml'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
	  else echo'<td><input type="text" class="textboxme2" name="code_peymankar_haml" value="'.$row1['code_peymankar_haml'].'" onkeypress="return isNumber(event)" style="width:50px"/></td>';  
	  echo'<td><input type="text" class="textboxme" name="name_peymankar_haml" value="'.$row1['name_peymankar_haml'].'"></td>
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {
	  if($_SESSION['mt_systemmabadi']==0)//سیستم انبار
	  { echo'
	    <td '.$edtClick.'>'.$row1['code_peymankar_haml'].'</td>
	    <td '.$edtClick.'>'.$row1['name_peymankar_haml'].'</td>';
	    if($right_del)
	    {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	         onmouseOver="this.src=\'images/trash_hover.png\'" 
		     onmouseOut="this.src=\'images/trash.png\'" 	  
	         onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_peymankar_haml_='.$row1['code_peymankar_haml'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف پیمانکار '.$row1['name_peymankar_haml'].' \')" /></td>';
	    }
	    else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	    else echo'';
	  }
	  if($_SESSION['mt_systemmabadi']==1)//سیستم مبادی
	  { echo'
	    <td '.$edtClick.'>'.$row1['pymnkr_id'].'</td>
	    <td '.$edtClick.'>'.$row1['pymnkr_name'].'</td>';
	    if($Mode=='Search')echo'<td>&nbsp;</td>';
	  }  
	 }//END else
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
	  if($_SESSION['mt_systemmabadi']==0)	  
	  {if($right_del) echo'<td>&nbsp;</td>';
	   else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	   else echo'';
	  } 
	  if(($_SESSION['mt_systemmabadi']==1)and($Mode=='Search'))echo'<td>&nbsp;</td>';
	  //else echo'';
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
	 <td width="24"><div onClick="window.open(\'print_peymankar_haml.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
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
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_peymankar_haml']) 
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
'.$message.'
</form>
</body>
</html>';	
?>