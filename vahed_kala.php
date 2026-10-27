<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="vahed_kala.php";
$TableName="vahed_kala";
$logtime=date('H:i:s');
$titr='واحد کالا';
$right_ins=0;$right_edt=0;$right_del=0;
if (right(29)) $right_ins=1;
if (right(30)) $right_edt=1;
if (right(31)) $right_del=1; 
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
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_vahed_k']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x=""; 
 $temp="";
 if($code_vahedkala)  $temp.=" and code_vahedkala LIKE '%$code_vahedkala%'";
 if($sharh_vahedkala) $temp.=" and sharh_vahedkala LIKE '%$sharh_vahedkala%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_vahed_k']=$temp;} else $_SESSION['mt_search_vahed_k']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_vahed_k']."");
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
 if (!justNumber($a))//عدد بودن کد واحد کالا
 {
   $flag=false;
   echo"<script>alert('فيلد کد واحد کالا نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if(!empty($a))//تکراری نبودن کد واحد کالا
 { 
    //$code_a=make_pattern($a,2); 
    $q8="SELECT code_vahedkala FROM vahed_kala WHERE code_vahedkala='$a'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين کد واحد کالا قبلاً ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;  
 if(!empty($b))//تکراري نبودن شرح واحد کالا
 {
   $q9="SELECT * FROM vahed_kala WHERE sharh_vahedkala='$b'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين واحد کالا قبلا ثبت شده است')</script>";
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
  if (!justNumber($a))//عدد بودن کد واحد کالا
  {
   $flag=false;
   echo"<script>alert('فيلد کد واحد کالا نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($a))//تکراری نبودن کد واحد کالا
  { 
   //$code_a=make_pattern($a,2); 
   $q10="SELECT * FROM vahed_kala WHERE code_vahedkala='$a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$c)){
   echo"<script>alert('اين کد واحد کالا قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;  
  if(!empty($b))//تکراري نبودن شرح واحد کالا
  {
    $q10="SELECT * FROM vahed_kala WHERE sharh_vahedkala='$b'";
    $res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
    if((mysql_num_rows($res10)>0) and ($row10['id']!=$c)){
      echo"<script>alert('اين واحد کالا قبلا ثبت شده است')</script>";
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
 if(isPermitSave($code_vahedkala,$sharh_vahedkala)) 
 {
  $Mode='';
  $sharh_vahedkala=str_replace("ي","ی",$sharh_vahedkala);
  $sharh_vahedkala=str_replace("ك","ک",$sharh_vahedkala);
  $insert_q=("INSERT INTO $TableName(code_vahedkala,sharh_vahedkala)
             VALUES('$code_vahedkala',TRIM('$sharh_vahedkala'))");
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
 if(isPermitEdit($code_vahedkala,$sharh_vahedkala,$id_))
 {
  $Mode='';
  $sharh_vahedkala=str_replace("ي","ی",$sharh_vahedkala);
  $sharh_vahedkala=str_replace("ك","ک",$sharh_vahedkala);
  $edit_q=("UPDATE $TableName SET code_vahedkala='$code_vahedkala',sharh_vahedkala=TRIM('$sharh_vahedkala') WHERE id='$id_';");
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
 $del_q ="DELETE FROM $TableName WHERE id=$id_ AND
         ($code_vahedkala_ NOT IN(SELECT code_vahedkala FROM kala WHERE code_vahedkala=$code_vahedkala_))";
 $del_res = $db->query($del_q);
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ
} 
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_vahedkala.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="700px" height="90%" align="center" cellpadding="0" cellspacing="0">
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
if(!isset($order)) $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	 if($sortcode=='1')
	 {echo'<td width="33%" title="مرتب سازی صعودی کد واحد کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_vahedkala ASC&sortcode=2&show_img=1\'"/> کد واحد کالا ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {echo'<td width="33%" title="مرتب سازی نزولی کد واحد کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_vahedkala DESC&sortcode=1&show_img=1\'"/> کد واحد کالا ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='1')
	 {echo'<td width="33%" title="مرتب سازی صعودی شرح واحد کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sharh_vahedkala ASC&sortname=2&show_img=2\'"/> شرح واحد کالا '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {echo'<td width="33%" title="مرتب سازی نزولی شرح واحد کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sharh_vahedkala DESC&sortname=1&show_img=2\'"/> شرح واحد کالا '; 
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
	   <td><input type="text" class="textboxme2" name="code_vahedkala" value="'.$code_vahedkala.'" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme2" name="sharh_vahedkala" value="'.$sharh_vahedkala.'" /></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT *,(SELECT count(code_vahedkala) FROM kala k WHERE k.code_vahedkala=T.code_vahedkala) exist_kala 
	     From $TableName T WHERE 1=1 ".$_SESSION['mt_search_vahed_k']." order by $order $Limit";
	$allVahedkala = $db->query($q1);
    while($row1=$db->fetch_assoc($allVahedkala))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  if($row1['exist_kala']) echo'<td><input type="text" class="textboxme2" title="غیر قابل تغییر" name="code_vahedkala" readonly value="'.$row1['code_vahedkala'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
	  else echo'<td><input type="text" class="textboxme2" name="code_vahedkala" value="'.$row1['code_vahedkala'].'" onkeypress="return isNumber(event)" style="width:50px"/></td>';
	  echo '
	  <td><input type="text" class="textboxme2" name="sharh_vahedkala" value="'.$row1['sharh_vahedkala'].'"></td>
	  <td>
	   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['code_vahedkala'].'</td>
	  <td '.$edtClick.'>'.$row1['sharh_vahedkala'].'</td>';
	  if(($right_del))
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف" 
	   	  onmouseOver="this.src=\'images/trash_hover.png\'" 
		  onmouseOut="this.src=\'images/trash.png\'" 
	      onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_vahedkala_='.$row1['code_vahedkala'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'\',\'براي حذف '.$row1['sharh_vahedkala'].' \')" /></td>';
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
   <table width="100%" border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_vahed_kala.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
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
     if ($_SESSION['mt_search_vahed_k']) 
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