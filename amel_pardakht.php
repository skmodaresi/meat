<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="amel_pardakht.php";
$TableName="amel_pardakht";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(127)) $right_ins=1;
if (right(128)) $right_edt=1;
if (right(129)) $right_del=1;
$titr='عامل پرداخت پسکرایه';
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
  $_SESSION['mt_search_amel_p']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x=""; 
 $temp="";
 if($amel_p_accnting_code)  $temp.=" and amel_p_accnting_code LIKE '%$amel_p_accnting_code%'";
 if($amel_p_code_personely) $temp.=" and amel_p_code_personely LIKE '%$amel_p_code_personely%'";
 if($amel_p_name)           $temp.=" and amel_p_name LIKE '%$amel_p_name%'";
 if($amel_p_lastname)       $temp.=" and amel_p_lastname LIKE '%$amel_p_lastname%'";
 if($status_amel_p)         $temp.=" and status_amel_p LIKE '$status_amel_p'";
 if ($temp) {$PageNo=1;$_SESSION['mt_search_amel_p']=$temp;} else $_SESSION['mt_search_amel_p']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_amel_p']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
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
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($gl_c_o,$gl_c_a,$acc_c,$c_p,$a_p_n,$a_p_ln,$s_a_p)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار مورد نظر خود را از پایین صفحه انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($acc_c and $a_p_n and $a_p_ln and $s_a_p))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفاً فیلد های ستاره دار را تکمیل نمایید !')</script>";
   return $flag;
 } 
 else $flag=true;
 if ((!justNumber($acc_c))or(strlen($acc_c)>6)or(strlen($acc_c)<6))//صحت کد حسابداری
 {
   $flag=false;
   echo"<script>alert('فيلد کد حسابداری نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!empty($acc_c))//تکراری نبودن کد حسابداری
 { 
   $q8="SELECT amel_p_accnting_code FROM amel_pardakht WHERE amel_p_accnting_code='$acc_c' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a'";
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('اين کد حسابداری قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if($s_a_p==2)//اگر وضعیت را غیرجاری گذاشته و هیچکدام از افراد جاری نیستند
 {
  $q9="SELECT status_amel_p FROM amel_pardakht WHERE status_amel_p=1 AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a'";
  $res9=mysql_query($q9);
  if(mysql_num_rows($res9)==0){
   echo"<script>alert('باید وضعیت یکی از عاملین پرداخت جاری باشد!')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($gl_c_o,$gl_c_a,$acc_c,$c_p,$a_p_n,$a_p_ln,$s_a_p,$this_id)
{
  $flag=false;
  if(!($gl_c_o and $gl_c_a) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار خالی بود
  {   
    $flag=false;
    echo"<script> alert('لطفاً استان و انبار مورد نظر خود را از پایین صفحه انتخاب نمایید!')</script>";
    return $flag;
  }
  else $flag=true;  
  if(!($acc_c and $a_p_n and $a_p_ln and $s_a_p))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفاً فیلد های ستاره دار را تکمیل نمایید !')</script>";
   return $flag;
  } 
  else $flag=true;
  if((!justNumber($acc_c))or(strlen($acc_c)>6)or(strlen($acc_c)<6))//صحت کد حسابداری
  {
   $flag=false;
   echo"<script>alert('فيلد کد حسابداری نامعتبر است !')</script>";
   return $flag;
  }
  else $flag=true;
  if($s_a_p==2)//اگر وضعیت را غیرجاری گذاشته و هیچکدام از افراد جاری نیستند
  {
   $q11="SELECT status_amel_p FROM amel_pardakht WHERE status_amel_p=1 AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a' AND id<>$this_id";
   $res11=mysql_query($q11);
   if(mysql_num_rows($res11)==0){
    echo"<script>alert('باید وضعیت یکی از عاملین پرداخت جاری باشد!')</script>";
    $flag=false;
    return $flag;
   }
   else $flag=true;   
  }
  else $flag=true;
  if(!empty($acc_c))//تکراری نبودن کد حسابداری
  { 
   $q10="SELECT * FROM amel_pardakht WHERE amel_p_accnting_code='$acc_c' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$this_id)){
   echo"<script>alert('اين کد حسابداری قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
 return $flag;
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id=$id_ AND 
        ($amel_p_accnting_code_ NOT IN (SELECT amel_p_accnting_code FROM resid WHERE amel_p_accnting_code=$amel_p_accnting_code_ AND deleted=0))";      
 $del_res = mysql_query($del_q);
 if(mysql_affected_rows()==0) $message ='<span style=" color:red;font: bold 12px tahoma;"> * این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید! *</span>';
 else if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['sard_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
 else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';
} 
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.amel_p_accnting_code.focus();">
<form method="post" name="myform" id="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:45%;">عامل پرداخت پسکرایه</div>
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
if(!isset($order))      $order='id DESC';
if(!isset($sortcode))   $sortcode='1';
if(!isset($sort_pcode)) $sort_pcode='1';
if(!isset($sortname))   $sortname='1';
if(!isset($sortlastname)) $sortlastname='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="15%" title="مرتب سازی صعودی کد حسابداری" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=amel_p_accnting_code ASC&sortcode=2&show_img=1\'"/> کد حسابداری ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="15%" title="مرتب سازی نزولی کد حسابداری" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=amel_p_accnting_code DESC&sortcode=1&show_img=1\'"/> کد حسابداری ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sort_pcode=='1')
	{echo'<td width="15%" title="مرتب سازی صعودی کد پرسنلی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=amel_p_code_personely ASC&sortcode=2&show_img=2\'"/> کد پرسنلی ';
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sort_pcode=='2')
	{echo'<td width="15%" title="مرتب سازی نزولی کد پرسنلی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=amel_p_code_personely DESC&sortcode=1&show_img=2\'"/> کد پرسنلی ';
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{
	 echo'<td width="20%" title="مرتب سازی صعودی نام " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=amel_p_name ASC&sortname=2&show_img=3\'"/> نام  '; 
	 if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{
	 echo'<td width="20%" title="مرتب سازی نزولی نام " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=amel_p_name DESC&sortname=1&show_img=3\'"/> نام  '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortlastname=='1')
	{ 
	 echo'<td width="25%" title="مرتب سازی صعودی نام خانوادگی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=amel_p_lastname ASC&sortlastname=2&show_img=4\'"/> نام خانوادگی '; 
	  if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortlastname=='2')
	{ 
	  echo'<td width="25%" title="مرتب سازی نزولی نام خانوادگی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=amel_p_lastname DESC&sortlastname=1&show_img=4\'"/> نام خانوادگی '; 
	  if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'<td width="10%">وضعیت</td>';
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
	   <td>';if($Mode=='Insert')echo'<span style="color:red">*</span> ';echo'<input type="text" class="textboxme2" name="amel_p_accnting_code" value="'.$amel_p_accnting_code.'" maxlength="6" onkeypress="return isNumber(event)" style="width:50px"/>	
	    <img border="0" src="images/Info1.png" title="کد حسابداری رادر 6 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
       </td>
	   <td><input type="text" class="textboxme2" name="amel_p_code_personely" value="'.$amel_p_code_personely.'"  onkeypress="return isNumber(event)"/></td>
	   <td>';if($Mode=='Insert')echo'<span style="color:red">*</span> ';echo'<input type="text" class="textboxme" name="amel_p_name" value="'.$amel_p_name.'" /></td>
	   <td>';if($Mode=='Insert')echo'<span style="color:red">*</span> ';echo'<input type="text" class="textboxme" name="amel_p_lastname" value="'.$amel_p_lastname.'" /></td>
	   <td>';
	    if($Mode=='Insert'){echo'<span style="color:red">*</span> '.static_listbox("status_amel_p",$status_amel_p,"statusAmelArr",1,"class='text4'").'';}
	    if($Mode=='Search'){echo'<select name="status_amel_p" class="text4">
		                         <option value="0">انتخاب کنید</option>
		                         <option value="1">جاری</option>
		                         <option value="2">غیرجاری</option>
								</select>';}
		echo'
	   </td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" />
	   </td>
	  </tr>';
	}
	$i=0;
	//$q1="SELECT * From $TableName T WHERE 1=1 ".$_SESSION['mt_search_amel_p']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' order by $order $Limit";
	$q1="SELECT *,
	     (SELECT count(amel_p_accnting_code) FROM resid r WHERE r.amel_p_accnting_code=T.amel_p_accnting_code AND r.deleted=0) exist_resid
	     From $TableName T WHERE 1=1 ".$_SESSION['mt_search_amel_p']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' order by $order $Limit";		  		  
	$allAmelP = $db->query($q1);
    while($row1=$db->fetch_assoc($allAmelP))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
      if($row1['exist_resid']) echo'<td><input type="text" class="textboxme2" title="غیر قابل تغییر" name="amel_p_accnting_code" readonly value="'.$row1['amel_p_accnting_code'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
	  else{
	   echo'
	   <td><span style="color:red">*</span> <input type="text" class="textboxme2" name="amel_p_accnting_code" value="'.$row1['amel_p_accnting_code'].'" maxlength="6" onkeypress="return isNumber(event)" style="width:50px"/>
	   	 <img border="0" src="images/Info1.png" title="کد حسابداری رادر 6 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	   </td>';
	   }
	  echo'
	  <td><input type="text" class="textboxme2" name="amel_p_code_personely" value="'.$row1['amel_p_code_personely'].'" onkeypress="return isNumber(event)"/></td>
	  <td><span style="color:red">*</span> <input type="text" class="textboxme" name="amel_p_name" value="'.$row1['amel_p_name'].'"/></td>
	  <td><span style="color:red">*</span> <input type="text" class="textboxme" name="amel_p_lastname" value="'.$row1['amel_p_lastname'].'"/></td>
	  <td><span style="color:red">*</span> '.static_listbox("status_amel_p",$row1['status_amel_p'],"statusAmelArr",1,"class='text4'").'</td>
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات"/>
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['amel_p_accnting_code'].'</td>
	  <td '.$edtClick.'>'.$row1['amel_p_code_personely'].'</td>
	  <td '.$edtClick.'>'.$row1['amel_p_name'].'</td>
	  <td '.$edtClick.'>'.$row1['amel_p_lastname'].'</td>
	  <td '.$edtClick.'>'.$statusAmelArr[$row1['status_amel_p']].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&amel_p_accnting_code_='.$row1['amel_p_accnting_code'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف  '.$row1['amel_p_name'].' '.$row1['amel_p_lastname'].' \')"/></td>';
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
	 <td width="24"><div onClick="window.open(\'print_amel_pardakht.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
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
     if ($_SESSION['mt_search_amel_p']) 
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
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($mt_gl_code_ostan,$mt_gl_code_anbar,$amel_p_accnting_code,$amel_p_code_personely,$amel_p_name,$amel_p_lastname,$status_amel_p)) 
 {
  $Mode='';
  $amel_p_name=str_replace("ي","ی",$amel_p_name);
  $amel_p_name=str_replace("ك","ک",$amel_p_name);
  $amel_p_lastname=str_replace("ي","ی",$amel_p_lastname);
  $amel_p_lastname=str_replace("ك","ک",$amel_p_lastname);
  $insert_q=("INSERT INTO $TableName(code_ostan,code_anbar,amel_p_accnting_code,amel_p_code_personely,amel_p_name,amel_p_lastname,status_amel_p)
              VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar',TRIM('$amel_p_accnting_code'),TRIM('$amel_p_code_personely'),TRIM('$amel_p_name'),TRIM('$amel_p_lastname'),'$status_amel_p')");
  $insert_res=mysql_query($insert_q);
  if($insert_res)
  {
	$max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
    // if($status_amel_p==1)//اگر وضعیت جاری انتخاب شده باشد بقیه راغیرجاری می کنیم
	// {
	 // $edit_q_after=("UPDATE $TableName SET status_amel_p=2 WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND id<>'$max_id';");
	 // $edit_res_after=mysql_query($edit_q_after);
	// }
	echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> *مشکلی در ثبت عامل پرداخت به وجود آمده است ! *</span>';  
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($mt_gl_code_ostan,$mt_gl_code_anbar,$amel_p_accnting_code,$amel_p_code_personely,$amel_p_name,$amel_p_lastname,$status_amel_p,$id_))
 {
  $Mode='';
  $amel_p_name=str_replace("ي","ی",$amel_p_name);
  $amel_p_name=str_replace("ك","ک",$amel_p_name);
  $amel_p_lastname=str_replace("ي","ی",$amel_p_lastname);
  $amel_p_lastname=str_replace("ك","ک",$amel_p_lastname);
  $edit_q=("UPDATE $TableName SET code_ostan='$mt_gl_code_ostan',code_anbar='$mt_gl_code_anbar',amel_p_accnting_code=TRIM('$amel_p_accnting_code'),
            amel_p_code_personely=TRIM('$amel_p_code_personely'),amel_p_name=TRIM('$amel_p_name'),amel_p_lastname=TRIM('$amel_p_lastname'),status_amel_p='$status_amel_p' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);   
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   // if($status_amel_p==1)//اگر وضعیت جاری انتخاب شده باشد بقیه راغیرجاری می کنیم
   // {
	// $edit_q_after=("UPDATE $TableName SET status_amel_p=2 WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND id<>'$id_';");
	// $edit_res_after=mysql_query($edit_q_after);
   // }
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");
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