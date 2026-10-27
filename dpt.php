<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="dpt.php";
$TableName="mt_dpt";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(321)) $right_ins=1;
if (right(322)) $right_edt=1;
if (right(323)) $right_del=1; 
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>پست های سازمانی</title>
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
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['search_dpt']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x="";
 $temp=""; 
 if($dpt_id)   $temp.=" and dpt_id LIKE '%$dpt_id%'";
 if($dpt_name) $temp.=" and dpt_name LIKE '%$dpt_name%'";
 //if($manager)  $temp.=" and manager LIKE '%$manager%'";
 if($temp) {$PageNo=1; $_SESSION['search_dpt']=$temp;} else  $_SESSION['search_dpt']="";
} 
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['search_dpt']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
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
function isPermitSave($a,$dpt_n,$gl_c_o,$gl_c_s)
{
 $flag=false;
  if(!($gl_c_o and $gl_c_s) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار مورد نظر خود را از پایین صفحه انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($a and $dpt_n))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 }
 else $flag=true;  
 if(!empty($dpt_n))//تکراری نبودن پست سازمانی
 {
   $dpt_n = trim(preg_replace('/\s+/', ' ', $dpt_n));
   $q9="SELECT * FROM mt_dpt WHERE dpt_name=TRIM('$dpt_n') AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين پست سازمانی قبلاً ثبت شده است !')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$dpt_n,$gl_c_o,$gl_c_s,$d)
{
  $flag=false;
  if(!($gl_c_o and $gl_c_s) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار خالی بود
  {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار مورد نظر خود را از پایین صفحه انتخاب نمایید!')</script>";
   return $flag;
  }
  else $flag=true; 
  if(!($a and $dpt_n))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true; 
  if(!empty($dpt_n))//تکراری نبودن پست سازمانی
  {
	$dpt_n = trim(preg_replace('/\s+/', ' ', $dpt_n));
	$q11="SELECT * FROM mt_dpt WHERE dpt_name='$dpt_n' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s'";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);
    if((mysql_num_rows($res11)>0) and ($row11['id']!=$d)){
      echo"<script>alert('اين پست سازمانی قبلاً ثبت شده است !')</script>";
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
 if(isPermitSave($dpt_id,$dpt_name,$mt_gl_code_ostan,$mt_gl_code_anbar))
 {
   $Mode='';
   $dpt_name=str_replace("ي","ی",$dpt_name);
   $dpt_name=str_replace("ك","ک",$dpt_name);
   //$manager=str_replace("ي","ی",$manager);
   //$manager=str_replace("ك","ک",$manager);
   $dpt_name = trim(preg_replace('/\s+/', ' ', $dpt_name));
   $insert_q=("INSERT INTO $TableName(dpt_id,dpt_name,code_ostan,code_anbar)VALUES('$dpt_id','$dpt_name','".$_SESSION['mt_code_ostan']."','".$_SESSION['mt_code_anbar']."')");
   $insert_res=$db->query($insert_q,'مشکلي در ثبت به وجود آمده است');
   if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
   }
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($dpt_id,$dpt_name,$mt_gl_code_ostan,$mt_gl_code_anbar,$id_))
 {
  $Mode='';
  $dpt_name=str_replace("ي","ی",$dpt_name);
  $dpt_name=str_replace("ك","ک",$dpt_name);
  //$manager=str_replace("ي","ی",$manager);
  //$manager=str_replace("ك","ک",$manager);
  $dpt_name = trim(preg_replace('/\s+/', ' ', $dpt_name));
  $edit_q=("UPDATE $TableName SET dpt_id='$dpt_id',dpt_name='$dpt_name' WHERE id='$id_';");
  $edit_res=$db->query($edit_q,'مشکلي در ويرايش مشخصات به وجود آمده است');
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");    
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id=$id_";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.dpt_name.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="700px" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:46%;">پست های سازمانی</div>
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
if(!isset($sortmanager)) $sortmanager='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی کد استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=dpt_id ASC&sortcode=2&show_img=1\'"/> کد  ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی کد استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=dpt_id DESC&sortcode=1&show_img=1\'"/> کد  ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="30%" title="مرتب سازی صعودی نام استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=dpt_name ASC&sortname=2&show_img=2\'"/> پست سازمانی امضا کننده'; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="30%" title="مرتب سازی نزولی نام استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=dpt_name DESC&sortname=1&show_img=2\'"/> پست سازمانی امضا کننده'; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	// if($sortmanager=='1')
	// {echo'<td width="25%" title="مرتب سازی صعودی نام استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=manager ASC&sortmanager=2&show_img=3\'"/> نام امضا کننده '; 
	  // if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	// if($sortmanager=='2')
	// {echo'<td width="25%" title="مرتب سازی نزولی نام استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=manager DESC&sortmanager=1&show_img=3\'"/> نام امضا کننده '; 
	  // if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	if(($right_del)and($Mode==NULL)) echo'<td width="25%">حذف</td>';
    else if($Mode!=NULL) echo'<td width="25%">دستورات</td>';
    echo'	 
	</tr>';
	if($Mode=='Insert')
	{
	  $res_dptID = $db->query("SELECT Max(dpt_id) FROM $TableName WHERE code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");
	  $row_dptID = $db->fetch_array($res_dptID);
	  $dpt_id=$row_dptID[0];
	  $dpt_id++;
	  echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme2" readonly name="dpt_id" value="'.$dpt_id.'" onkeypress="return isNumber(event)" style=width:50px;/></td>
	   <td><input type="text" class="textboxme" name="dpt_name" value="'.$dpt_name.'"></td>
	   <!--<td><input type="text" class="textboxme" name="manager" value="'.$manager.'"></td>-->
	   <td colspan="2">
	    <input type="submit" class="buttonme" name="Insert_x" id="sabt" value="ايجاد"/>
		<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	if($Mode=='Search')
    {
	 echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme2" name="dpt_id" value="'.$dpt_id.'" onkeypress="return isNumber(event)" style=width:50px;/></td>
	   <td><input type="text" class="textboxme" name="dpt_name" value="'.$dpt_name.'"></td>
	   <!--<td><input type="text" class="textboxme" name="manager" value="'.$manager.'"></td>-->
	   <td colspan="2">
	    <input type="submit" class="buttonme" name="Search_x" id="sabt" value="جستجو"/>
		<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
    }	
	$i=0;
    $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['search_dpt']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' order by $order $Limit ";
	$allDpt = $db->query($q1);
    while($row1=$db->fetch_assoc($allDpt))
	{
     if ($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {echo '
	  <td><input type="text" class="textboxme2" readonly name="dpt_id" value="'.$row1['dpt_id'].'" onkeypress="return isNumber(event)" style=width:50px;></td>
	  <td><input type="text" class="textboxme" name="dpt_name" value="'.$row1['dpt_name'].'" style:width:100%></td>
	  <!--<td><input type="text" class="textboxme2" name="manager" value="'.$row1['manager'].'" style:width:100%></td>-->
	  <td colspan="2">
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {
	  echo'
	  <td '.$edtClick.'>'.$row1['dpt_id'].'</td>
	  <td '.$edtClick.'>'.$row1['dpt_name'].'</td>
	  <!--<td '.$edtClick.'>'.$row1['manager'].'</td>-->
	  ';
	  if($right_del)
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف" 
	  	   onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&dpt_id_='.$row1['dpt_id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف پست '.$row1['dpt_name'].' \')" /></td>';
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
     if ($_SESSION['search_dpt']) 
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