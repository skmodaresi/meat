<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="mt_skk.php";
$titr='فروشنده / کشتی';
if($_SESSION['mt_systemmabadi']==0)//اطلاعات مبادی ورودی از سیستم انبار
{
 $TableName="mt_skk";
 $right_ins=0;$right_edt=0;$right_del=0;
 if (right(107)) $right_ins=1;
 if (right(108)) $right_edt=1;
 if (right(109)) $right_del=1;
}
// if($_SESSION['mt_systemmabadi']==1)//اطلاعات مبادی ورودی از سیستم مبادی
// {
 // $db->selectDb('mabadi');
 // $TableName="mbd_skk";
// }
// echo $mt_gl_code_ostan.'<br/>';
// echo $mt_gl_code_anbar.'<br/>';
// echo $_SESSION['mt_all_ostan'];
//echo date('w');
//echo "<script>alert(".$_SESSION['mt_systemforush'].")</script>"; 
//echo $_SESSION['mt_systemforush']; 
 // else if((!empty($name_kala)) and (preg_match('/^[پچجحخهعغفقثصضشسيبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u',$name_kala)))//farsi
 // echo"<script>alert('gfhg')</script>";
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 
<script type="text/javascript">
$(function(){	    
    $("#datepicker6").datepicker({
        defaultDate:"'.$today.'",
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
  $_SESSION['mt_search_skk']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x=""; 
 $temp="";
 if($code_skk)      $temp.=" and code_skk LIKE '%$code_skk%'";
 if($name_skk)      $temp.=" and name_skk LIKE '%$name_skk%'";
 if($shomare_moarefiname)  $temp.=" and shomare_moarefiname LIKE '%$shomare_moarefiname%'";
 if($tarikh_moarefiname)   $temp.=" and tarikh_moarefiname LIKE '%$tarikh_moarefiname%'";
 if ($temp) {$PageNo=1;$_SESSION['mt_search_skk']=$temp;} else $_SESSION['mt_search_skk']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_skk']."");
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
 $del_q="DELETE FROM $TableName WHERE id=$id_ AND
        ($code_skk_ NOT IN(SELECT code_skk FROM shomare_safar WHERE code_skk=$code_skk_))AND
		($code_skk_ NOT IN(SELECT code_skk FROM resid WHERE code_skk=$code_skk_ AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0) $message ='<span style=" color:red;font: bold 12px tahoma;"> * این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید! *</span>';
 else if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['sard_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");//کوئری لاگ 
 else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';
 }
/********************sort field***********************/
 //switch ($order_)
//{ case 1:$order_by="order by code_skk ASC";break;
  //case 2:$order_by="order by code_skk DESC";break;
  //case 3:$order_by="order by ";break;
//} 
  // $sortCodeA='onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_skk ASC \'"';  if($sortCodeA) $f='1';  
  // $sortCodeD='onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_skk DESC\'"';  if($sortCodeD) $f='2';
  // $sortNameA='onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_skk ASC\'"'; 
  // $sortNameD='onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_skk DESC\'"'; 
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_skk.focus();">
<form method="post" name="myform" id="myform" onkeydown="enterIE()">
<div align="center">
<table width="98%" height="90%" align="center" cellpadding="0" cellspacing="0">
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
  <table  width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <!--<td width="33%"><img src="images/sort_up.png" '.$sortCodeA.' style="width:15px;height:15px;cursor:pointer;"/> کد کشتی <img src="images/sort_down.png" '.$sortCodeD.' style="width:15px;height:15px;cursor:pointer;"/></td>
	     <td width="33%" ><img src="images/sort_up.png" '.$sortNameA.' style="width:15px;height:15px;cursor:pointer;"/> نام کشتی <img src="images/sort_down.png" '.$sortNameD.' style="width:15px;height:15px;cursor:pointer;"/></td>-->
     ';
/********************sort field***********************/
if(!isset($order)) {if($_SESSION['mt_systemmabadi']==0)$order='id DESC';
 //if($_SESSION['mt_systemmabadi']==1)$order='code_skk DESC';
 }
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	echo '<td width="10%">شناسه</td>';
	if($sortcode=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی کد " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_skk ASC&sortcode=2&show_img=1\'"/> کد ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی کد " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_skk DESC&sortcode=1&show_img=1\'"/> کد  ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="30%" title="مرتب سازی صعودی نام " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_skk ASC&sortname=2&show_img=2\'"/> نام  '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="30%" title="مرتب سازی نزولی نام " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_skk DESC&sortname=1&show_img=2\'"/> نام  '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	<td width="15%">نوع فروشنده/کشتی</td>
	<td width="10%">شماره معرفی نامه</td>
	<td width="10%">تاریخ معرفی نامه</td>';
	if($_SESSION['mt_systemmabadi']==0)//سیستم انبار
	{
	  if(($right_del)and($Mode==NULL)) echo'<td width="15%">حذف</td>';
      else if($Mode!=NULL) echo'<td width="15%">دستورات</td>';
    }
	//سیستم مبادی
    if(($_SESSION['mt_systemmabadi']==1)and($Mode=='Search')) echo'<td width="34%">دستورات</td>';	 	
	echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ثبت"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td>-</td> ';
	   if ($Mode=='Insert')echo'<td><span class="star">*</span><input type="text" class="textboxme2" readonly name="code_skk" value="'.$code_skk.'" maxlength="5" onkeypress="return isNumber(event)" style="width:50px"/>';
	   if ($Mode=='Search')echo'<td><input type="text" class="textboxme2"  name="code_skk" value="'.$code_skk.'" maxlength="5" onkeypress="return isNumber(event)" style="width:50px"/>';
	   include('img_ashkhas.php');
	   echo'
	   </td>
	   <td><span class="star">*</span><input type="text" class="textboxme" name="name_skk" value="'.$name_skk.'" /></td>
	   <td><span class="star">*</span> '.listbox("skk_type_code",$skk_type_code,"skk_type_code","skk_type_name","mt_skk_type","1=1 ORDER BY skk_type_name ASC","class='easyui-combobox text4'").'</td>
	   <td><input type="text" class="textboxme" name="shomare_moarefiname" value="'.$shomare_moarefiname.'" /></td>
	   <td><input type="text" class="textboxme2" name="tarikh_moarefiname" id="datepicker6" maxlength="10" value="'.$tarikh_moarefiname.'" /></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" />
	   </td>
	  </tr>';
	}
	$i=0;
	$q1="SELECT *,(SELECT skk_type_name From mt_skk_type WHERE mt_skk_type.skk_type_code=T.skk_type_code) skk_type_name
	From $TableName T WHERE 1=1 ".$_SESSION['mt_search_skk']." order by $order $Limit";	  		  
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
	  $exist_sh_safar=$db->get_from_where("code_skk","shomare_safar","code_skk='".$row1['code_skk']."'");     
	  $exist_resid=$db->get_from_where("code_skk","resid","code_skk='".$row1['code_skk']."' AND deleted=0"); 
	  $exist_mali=$db->get_from_where("code_skk","coding_mali_keshty","code_skk='".$row1['code_skk']."'"); 
	  $exist_jabejae=$db->get_from_where("code_skk","mojavez_jabejae","code_skk='".$row1['code_skk']."'"); 
	  $exist_dastorolamal=$db->get_from_where("code_skk","dastorolamal_kharid","code_skk='".$row1['code_skk']."'"); 
	  $exist_gharardad=$db->get_from_where("code_skk","gharardad_kharid","code_skk='".$row1['code_skk']."'"); 
      echo'<td><input type="text" class="textboxme2" name="id" value="'.$row1['id'].'" readonly /></td>';
	  echo'<td><span class="star">*</span>';
	  if(($exist_sh_safar)or($exist_resid)or($exist_mali)or($exist_jabejae)or($exist_dastorolamal)or($exist_gharardad)) {echo'<input type="text" class="textboxme2" readonly title="غیر قابل تغییر" name="code_skk" value="'.$row1['code_skk'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"'; if(!SuperUser()) echo'readonly';    echo'/>';}
	  else echo'<input type="text" class="textboxme2" readonly name="code_skk" value="'.$row1['code_skk'].'" maxlength="5" onkeypress="return isNumber(event)" style="width:50px"/>';
	  include('img_ashkhas.php');
	  echo'
	  </td>
	  <td><span class="star">*</span><input type="text" class="textboxme" name="name_skk" value="'.$row1['name_skk'].'"/></td>
	  <td><span class="star">*</span> '.listbox("skk_type_code",$row1['skk_type_code'],"skk_type_code","skk_type_name","mt_skk_type","1=1 ORDER BY skk_type_name ASC","class='easyui-combobox text4'").'</td>
	  <td><input type="text" class="textboxme" name="shomare_moarefiname" value="'.$row1['shomare_moarefiname'].'" /></td>
	  <td><input type="text" class="textboxme2" name="tarikh_moarefiname" id="datepicker6" maxlength="10" value="'.$row1['tarikh_moarefiname'].'" /></td>
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات"/>
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['id'].'</td>
	  <td '.$edtClick.'>'.$row1['code_skk'].'</td>
	  <td '.$edtClick.'>'.$row1['name_skk'].'</td>
	  <td '.$edtClick.'>'.$row1['skk_type_name'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_moarefiname'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_moarefiname'].'</td>';
	  if($_SESSION['mt_systemmabadi']==0)//سیستم انبار
      { 
	   if($right_del)
	   {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_skk_='.$row1['code_skk'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف کشتی  '.$row1['name_skk'].' \')"/></td>';
	   }
	   	else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	    else echo'';
	  }
	  if(($_SESSION['mt_systemmabadi']==1)and($Mode=='Search'))echo'<td>&nbsp;</td>';
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($_SESSION['mt_systemmabadi']==0)	  
	  {if($right_del) echo'<td>&nbsp;</td>';
	   else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	   else echo'';
	  } 
	  if(($_SESSION['mt_systemmabadi']==1)and($Mode=='Search'))echo'<td>&nbsp;</td>';
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
     if ($_SESSION['mt_search_skk']) 
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
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($c_f,$n_f,$type,$sh_m,$ta_m)
{
 $flag=false;
 if(!($c_f and $n_f and $type))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if (!justNumber($c_f))//عدد بودن کد کشتي
 {
   $flag=false;
   echo"<script>alert('فيلد کد نامعتبر است !')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!empty($c_f))//تکراری نبودن کد کشتی
 { 
   $q8="SELECT code_skk FROM mt_skk WHERE code_skk='$c_f'";
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('اين کد کشتی/فروشنده قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if(!empty($n_f))//تکراري نبودن نام کشتي
 {
   $q9="SELECT * FROM mt_skk WHERE name_skk='$n_f'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام کشتی / فروشنده قبلاً ثبت شده است !')</script>";
     //$flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($c_f,$n_f,$type,$sh_m,$ta_m,$this_id)
{
  $flag=false;
  if(!($c_f and $n_f and $type))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if (!justNumber($c_f))//عدد بودن کد کشتي
  {
   $flag=false;
   echo"<script>alert('فيلد کد نامعتبر است !')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($c_f))//تکراری نبودن کد کشتی
  { 
   $q10="SELECT * FROM mt_skk WHERE code_skk='$a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$this_id)){
   echo"<script>alert('اين کد کشتی/فروشنده قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
  if(!empty($n_f))//تکراري نبودن نام کشتی
  {
    $q11="SELECT * FROM mt_skk WHERE name_skk='$n_f'";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);	
    if((mysql_num_rows($res11)>0) and ($row11['id']!=$this_id)){
      echo"<script>alert('اين نام کشتی / فروشنده قبلاً ثبت شده است !')</script>";
      //$flag=false;
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
 if(isPermitSave($code_skk,$name_skk,$skk_type_code,$shomare_moarefiname,$tarikh_moarefiname)) 
 {
  $Mode='';
  $name_skk=str_replace("ي","ی",$name_skk);
  $name_skk=str_replace("ك","ک",$name_skk);
  $insert_q=("INSERT INTO $TableName(code_skk,name_skk,skk_type_code,shomare_moarefiname,tarikh_moarefiname)VALUES('$code_skk',TRIM('$name_skk'),'$skk_type_code','$shomare_moarefiname','$tarikh_moarefiname')");
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
    echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> *مشکلی در ثبت کشتی به وجود امده است ! *</span>';  
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_skk,$name_skk,$skk_type_code,$shomare_moarefiname,$tarikh_moarefiname,$id_))
 {
  $Mode='';
  $name_skk=str_replace("ي","ی",$name_skk);
  $name_skk=str_replace("ك","ک",$name_skk);
  $code_skk_befor=$db->get_from_where("code_skk","mt_skk","id=$id_");
  //echo"<script>alert($code_skk_befor)</script>";
  //echo"<script>alert($code_skk)</script>";
  if($code_skk_befor!=$code_skk)
  {
	$q1=("UPDATE shomare_safar SET code_skk='$code_skk' WHERE code_skk='$code_skk_befor';");
    $res1=mysql_query($q1);
    $q2=("UPDATE coding_mali_keshty SET code_skk='$code_skk' WHERE code_skk='$code_skk_befor';");
    $res2=mysql_query($q2); 
    $q3=("UPDATE resid SET code_skk='$code_skk' WHERE code_skk='$code_skk_befor';");
    $res3=mysql_query($q3);
    $q4=("UPDATE mojavez_jabejae SET code_skk='$code_skk' WHERE code_skk='$code_skk_befor';");
    $res4=mysql_query($q4);
    $q5=("UPDATE dastorolamal_kharid SET code_skk='$code_skk' WHERE code_skk='$code_skk_befor';");
    $res5=mysql_query($q5);
    $q6=("UPDATE gharardad_kharid SET code_skk='$code_skk' WHERE code_skk='$code_skk_befor';");
    $res6=mysql_query($q6);	  
  }	  
  $edit_q=("UPDATE $TableName SET code_skk='$code_skk',name_skk=TRIM('$name_skk'),skk_type_code='$skk_type_code',shomare_moarefiname='$shomare_moarefiname',tarikh_moarefiname='$tarikh_moarefiname' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)){
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['sard_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
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