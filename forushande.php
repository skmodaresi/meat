<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="forushande.php";
$logtime=date('H:i:s');
$TableName="forushande";
$titr='فروشندگان'; 
 $right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;
 if (right(412)) $right_ins=1;
 if (right(413)) $right_edt=1;
 if (right(414)) $right_del=1;
 if (right(415)) $right_prt=1; 
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
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
		showButtonPanel: true
    });
 });
 function enterIE()
 {
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
 }
</script>
</head>';
if(!(isset($Mode))) $Mode='';
//echo "<script>alert('".$_SESSION['mt_systemforush']."');</script>";
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_forushande']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x=""; 
 $temp="";
 if($code_forushande)      $temp.=" and code_forushande LIKE '%$code_forushande%'";
 if($name_forushande)      $temp.=" and name_forushande LIKE '%$name_forushande%'";
 if($shomare_moarefiname)  $temp.=" and shomare_moarefiname LIKE '%$shomare_moarefiname%'";
 if($tarikh_moarefiname)   $temp.=" and tarikh_moarefiname LIKE '%$tarikh_moarefiname%'";
 if ($temp) {$PageNo=1;$_SESSION['mt_search_forushande']=$temp;} else $_SESSION['mt_search_forushande']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_forushande']."");
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

/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id_forushande=$id_forushande_ AND
        ($code_skk_ NOT IN(SELECT code_forushande FROM shomare_safar WHERE code_forushande=$code_skk_))AND
		($code_skk_ NOT IN(SELECT code_forushande FROM resid WHERE code_forushande=$code_skk_ AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0) $message ='<span style=" color:red;font: bold 12px tahoma;"> * این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید! *</span>';
 else if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['sard_user_id']."','$TableName','$id_forushande_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
 else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';
 }
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_forushande.focus();">
<form method="post" name="myform" id="myform" onkeydown="enterIE()">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
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
  <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
  <table  width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <!--<td width="33%"><img src="images/sort_up.png" '.$sortCodeA.' style="width:15px;height:15px;cursor:pointer;"/> کد کشتی <img src="images/sort_down.png" '.$sortCodeD.' style="width:15px;height:15px;cursor:pointer;"/></td>
	     <td width="33%" ><img src="images/sort_up.png" '.$sortNameA.' style="width:15px;height:15px;cursor:pointer;"/> نام کشتی <img src="images/sort_down.png" '.$sortNameD.' style="width:15px;height:15px;cursor:pointer;"/></td>-->
     ';
/********************sort field***********************/
if(!isset($order)) $order='id_forushande DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی کد " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_forushande ASC&sortcode=2&show_img=1\'"/> کد فروشنده ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی کد " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_forushande DESC&sortcode=1&show_img=1\'"/> کد فروشنده  ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="25%" title="مرتب سازی صعودی نام " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_forushande ASC&sortname=2&show_img=2\'"/> نام فروشنده '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="25%" title="مرتب سازی نزولی نام " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_forushande DESC&sortname=1&show_img=2\'"/> نام فروشنده  '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	<td width="20%">شماره معرفی نامه</td>
	<td width="20%">تاریخ معرفی نامه</td>
	';
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
	   <td><input type="text" class="textboxme2" name="code_forushande" value="'.$code_forushande.'" maxlength="5" onkeypress="return isNumber(event)"/></td>
	   <td><input type="text" class="textboxme" name="name_forushande" value="'.$name_forushande.'" /></td>
	   <td><input type="text" class="textboxme" name="shomare_moarefiname" value="'.$shomare_moarefiname.'" /></td>
	   <td><input type="text" class="textboxme2" name="tarikh_moarefiname" id="datepicker6" maxlength="10" value="'.$tarikh_moarefiname.'" /></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" />
	   </td>
	  </tr>';
	}
	$i=0;
	$q1="SELECT * From $TableName T WHERE 1=1 ".$_SESSION['mt_search_forushande']." order by $order $Limit";
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_forushande_='.$row1['id_forushande'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id_forushande']==$id_forushande_)
	 {
	  echo'<td><input type="text" class="textboxme2" name="code_forushande" value="'.$row1['code_forushande'].'" maxlength="5" onkeypress="return isNumber(event)" style="width:50px"/></td>';
	  echo'
	   <td><input type="text" class="textboxme" name="name_forushande" value="'.$row1['name_forushande'].'"/></td>
	   <td><input type="text" class="textboxme" name="shomare_moarefiname" value="'.$row1['shomare_moarefiname'].'" /></td>
	   <td><input type="text" class="textboxme2" name="tarikh_moarefiname" id="datepicker6" maxlength="10" value="'.$row1['tarikh_moarefiname'].'" /></td>

	   <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات"/>
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
	   </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['code_forushande'].'</td>
	  <td '.$edtClick.'>'.$row1['name_forushande'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_moarefiname'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_moarefiname'].'</td>';

	   if($right_del)
	   {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_forushande_='.$row1['id_forushande'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف کشتی  '.$row1['name_forushande'].' \')"/></td>';
	   }
	   	else if($Mode!=NULL)echo'<td>&nbsp;</td>';
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
   </div>
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
	 <td width="24"><div onClick="window.open(\'print_skk.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
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
     if ($_SESSION['mt_search_forushande']) 
	 echo '
	 <td width="70"><input type="Button" class="buttonme" value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
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
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($c_f,$n_f,$sh_m,$ta_m)
{
 $flag=false;
 if(!($c_f and $n_f and $sh_m and $ta_m))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if (!justNumber($c_f))//عدد بودن کد
 {
   $flag=false;
   echo"<script>alert('فيلد کد فروشنده نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!empty($c_f))//تکراری نبودن کد
 { 
   $q8="SELECT code_forushande FROM forushande WHERE code_forushande='$c_f'";
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('اين کد فروشنده قبلا ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if(!empty($n_f))//تکراري نبودن نام 
 {
   $q9="SELECT * FROM forushande WHERE name_forushande='$n_f'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام فروشنده قبلا ثبت شده است !')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($c_f,$n_f,$sh_m,$ta_m,$this_id)
{
  $flag=false;
  if(!($c_f and $n_f and $sh_m and $ta_m))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if (!justNumber($c_f))//عدد بودن کد 
  {
   $flag=false;
   echo"<script>alert('فيلد کد کشتی نامعتبر است !')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($c_f))//تکراری نبودن کد کشتی
  { 
   $q10="SELECT * FROM forushande WHERE code_forushande='$c_f'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id_forushande']!=$this_id)){
   echo"<script>alert('اين کد فروشنده قبلا ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
  if(!empty($n_f))//تکراري نبودن نام
  {
    $q11="SELECT * FROM forushande WHERE name_forushande='$n_f'";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);	
    if((mysql_num_rows($res11)>0) and ($row11['id_forushande']!=$this_id)){
      echo"<script>alert('اين نام فروشنده قبلا ثبت شده است !')</script>";
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
 if(isPermitSave($code_forushande,$name_forushande,$shomare_moarefiname,$tarikh_moarefiname)) 
 {
  $Mode='';
  $name_forushande=str_replace("ي","ی",$name_forushande);
  $name_forushande=str_replace("ك","ک",$name_forushande);
  $insert_q=("INSERT INTO $TableName(code_forushande,name_forushande,shomare_moarefiname,tarikh_moarefiname)VALUES('$code_forushande',TRIM('$name_forushande'),'$shomare_moarefiname','$tarikh_moarefiname')");
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id_forushande)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
    echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> *مشکلی در ثبت کشتی به وجود امده است ! *</span>';  
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_forushande,$name_forushande,$shomare_moarefiname,$tarikh_moarefiname,$id_forushande_))
 {
  $Mode='';
  $name_forushande=str_replace("ي","ی",$name_forushande);
  $name_forushande=str_replace("ك","ک",$name_forushande);
  $edit_q=("UPDATE $TableName SET code_forushande='$code_forushande',name_forushande=TRIM('$name_forushande'),shomare_moarefiname='$shomare_moarefiname',tarikh_moarefiname='$tarikh_moarefiname' WHERE id_forushande='$id_forushande_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)){
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['sard_user_id']."','$TableName','$id_forushande_','ویرایش',".($yymmdd).",'$logtime')");
   echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else if(mysql_affected_rows()==0) echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';
 } 
}
/********************END********************/
echo'
'.$message .'
</form>
</body>
</html>';	
?>