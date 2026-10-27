<?php
require_once __DIR__ . '/../mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="gheymat_kharid.php";
$TableName="gheymat_kharid";
//$logtime=date('H:i:s');
$shomare_dastorolamal=$db->get_from_where("shomare_dastorolamal","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal'");
$mahmule_type=$db->get_from_where("mahmule_type","eblagh_kharid INNER JOIN dastorolamal_kharid ON dastorolamal_kharid.id_eblagh=eblagh_kharid.id_eblagh","id_dastorolamal='$id_dastorolamal'");

$titr="قیمت خرید کالا (شماره دستورالعمل  $shomare_dastorolamal)";
$code_group_kala_top=$db->get_from_where("code_group_kala_top","dastorolamal_kharid INNER JOIN eblagh_kharid ON dastorolamal_kharid.id_eblagh=eblagh_kharid.id_eblagh","id_dastorolamal='$id_dastorolamal'");
$activate_dastor=$db->get_from_where("activate","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal'");

$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;
if (right(417)) $right_ins=1;
if (right(418)) $right_edt=1;
if (right(419)) $right_del=1;  
if (right(420)) $right_prt=1;  
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepicker6").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
    });
 });
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_gheymat_kharid']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($code_kala)     $temp.=" and T.code_kala LIKE '$code_kala'";
 if($gheymat_kharid) $temp.=" and T.gheymat_kharid LIKE '%$gheymat_kharid%'";
 if($code_kh_mali) $temp.=" and T.code_kh_mali LIKE '%$code_kh_mali%'";
 if($meyar) $temp.=" and T.meyar LIKE '$meyar'";
 if($darsad) $temp.=" and T.darsad LIKE '%$darsad%'";
 if($temp) {$PageNo_detail_gh=1;$_SESSION['mt_search_gheymat_kharid']=$temp;} else $_SESSION['mt_search_gheymat_kharid']="";
}
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;$count=1;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_gheymat_kharid']." AND deleted=0");
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo_detail_gh)) $PageNo_detail_gh=1; //$PageNo=$MaxPage; 
$NextPage=$PageNo_detail_gh+1;
$PrevPage=$PageNo_detail_gh-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNo_detail_gh==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNo_detail_gh==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0; 
$Limit="Limit ".$FirstRow.",".$RowPerPage; 
$radif=($PrevPage*$RowPerPage)+1;//محاسبه ردیف
if ($radif<0) $radif=1;
/******************** Insert- Edit- Delete ************/
/************DELETE BUTTON********/// حذف اطلاعات
// if (isset($Delete_x))
// {
 // $Mode='';
 // $del_q = "UPDATE $TableName SET deleted=1 WHERE id_gheymat_kharid=$id_gheymat_kharid_ AND
          // ($Gh_Shomare_ NOT IN(SELECT shomare_mojavez FROM bz_gheymat_jarime_detail WHERE shomare_mojavez='$Gh_Shomare_')AND
		  // ($Gh_Shomare_ NOT IN (SELECT Ja_Shomare_this FROM resid WHERE Ja_Shomare_this='$Gh_Shomare_'))";
  // $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
  // if(mysql_affected_rows()==0)
   // echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
  // else if($del_res)
   // $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_gheymat_kharid_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
// }
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enter();">
<div align="center">
<table width="98%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:37%;">'.$titr.'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td width="5%">رديف</td>
	 <td width="5%">شناسه</td>';
/********************sort field***********************/
if(!isset($order))    $order='code_kala DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($show_img)) $show_img='';

	 echo'
	 <td width="30%">کالا</td>
	 <td width="10%">قیمت (ریال)</td>
	 <td width="10%">کد حسابداری قیمت</td>
	 <td width="10%">معیار آنالیز</td>
	 <td width="10%">درصد آنالیز</td>';
	 if(($right_del)and($Mode==NULL)and($activate_dastor==1)) echo'<td width="20%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="20%">دستورات</td>';
	 echo'
	</tr>';
    //اگر وارداتی قرارداد استانی باشد
	IF($mahmule_type==3)$condition_kala="AND mahmule_type=2";
	ELSE IF($mahmule_type==4)$condition_kala="AND mahmule_type=1";
	ELSE                $condition_kala="AND mahmule_type=$mahmule_type";
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ثبت"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td>'.$radif++.'</td>
	   <td>&nbsp;</td>
	   <td><span class="star">*</span>&nbsp;'.listbox("code_kala",$code_kala,"code_kala","name_kala","kala","code_group_kala_top='$code_group_kala_top' $condition_kala ORDER BY name_kala","class='text4'").'</td>
	   <td><span class="star">*</span>&nbsp;<input type="text" class="textboxme2" name="gheymat_kharid" value="'.$gheymat_kharid.'" onkeypress="return isNumber(event)"/></td>
	   <td><input type="text" class="textboxme2" name="code_kh_mali" value="'.$code_kh_mali.'" onkeypress="return isNumber(event)"/></td>
	   <td>'.static_listbox("meyar",$meyar,"meyarArr",1,"class='text4'").'</td>
	   <td><input type="text" class="textboxme2" name="darsad" value="'.$darsad.'" onkeypress="return isNumber(event)"/></td>
	   <td colspan="2">
	   	   <input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail_gh='.$PageNo_detail_gh.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT T.*,kala.name_kala,(SELECT count(*) FROM gharardad_kharid gh_kh WHERE gh_kh.gheymat_har_kilo=T.gheymat_kharid) existgharardad
	     From $TableName T INNER JOIN kala ON kala.code_kala=T.code_kala WHERE 1=1 ".$_SESSION['mt_search_gheymat_kharid']." AND T.id_dastorolamal='$id_dastorolamal' AND deleted=0 order by $order $Limit";
	$allGheymat = $db->query($q1);
    while($row1=$db->fetch_assoc($allGheymat))
	{
     if(($right_edt)and($activate_dastor==1)){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_gheymat_kharid_='.$row1['id_gheymat_kharid'].'&PageNo_detail_gh='.$PageNo_detail_gh.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id_gheymat_kharid']==$id_gheymat_kharid_)
	 {
	 echo '
	  <td>'.$radif++.'</td>
	  <td>'.$row1['id_gheymat_kharid'].'</td>
	  <td><span class="star">*</span>&nbsp;'.listbox("code_kala",$row1['code_kala'],"code_kala","name_kala","kala","code_group_kala_top='$code_group_kala_top' $condition_kala ORDER BY name_kala","class='text4'").'</td>
	  <td><span class="star">*</span>&nbsp;<input type="text" class="textboxme2" name="gheymat_kharid" value="'.$row1['gheymat_kharid'].'" ';  if($row1['existgharardad']>0) echo' readonly '; echo'onkeypress="return isNumber(event)"/></td>
	  <td><input type="text" class="textboxme2" name="code_kh_mali" value="'.$row1['code_kh_mali'].'" onkeypress="return isNumber(event)"/></td>
	  <td>'.static_listbox("meyar",$row1['meyar'],"meyarArr",1,"class='text4'").'</td>
	  <td><input type="text" class="textboxme2" name="darsad" value="'.$row1['darsad'].'" onkeypress="return isNumber(event)"/></td>
	  <td colspan="2">
	    <input class="buttonme" type="submit" name="Edit_x" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail_gh='.$PageNo_detail_gh.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'">
	  </td>';
	 }
     else
     {
	  echo'
	  <td '.$edtClick.'>'.$radif++.'</td>
	  <td '.$edtClick.'>'.$row1['id_gheymat_kharid'].'</td>
	  <td '.$edtClick.'>'.$row1['code_kala'].' - '.$row1['name_kala'].'</td>
	  <td '.$edtClick.'>'.virgul($row1['gheymat_kharid']).'</td>
	  <td '.$edtClick.'>'.$row1['code_kh_mali'].'</td>
	  <td '.$edtClick.'>'.$meyarArr[$row1['meyar']].'</td>
	  <td '.$edtClick.'>'.$row1['darsad'].'</td>';
	  if(($right_del)and($activate_dastor==1))
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_gheymat_kharid_='.$row1['id_gheymat_kharid'].'&PageNo_detail_gh='.$PageNo_detail_gh.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\',\'براي حذف جدول شماره '.$row1['shomare_mojavez'].' \')" /></td>';
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if(($right_del)and($activate_dastor==1)) echo'<td>&nbsp;</td>';
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
	 if(($right_ins)and($activate_dastor==1))
	 {
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo_detail_gh='.$PageNo_detail_gh.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10px">&nbsp;</td>';}
	 echo'
	 <td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo_detail_gh='.$PageNo_detail_gh.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'dastorolamal_kharid.php?PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
	 <td width="20px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail_gh=1&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail_gh='.$PrevPage.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail_gh='.$NextPage.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail_gh='.$MaxPage.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_gheymat_kharid']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&PageNo_detail_gh='.$PageNo_detail_gh.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'&open_filter=1\'"></td>';	 
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
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($dastorolamal,$c_kala,$gheymat)
{
 $flag=false; 
 if(!($dastorolamal and $c_kala and $gheymat))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true; 


return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($id_dastorolamal,$code_kala,$gheymat_kharid))
 {
   $Mode='';
   $insert_q=("INSERT INTO $TableName(id_dastorolamal,code_kala,gheymat_kharid,code_kh_mali,meyar,darsad,deleted)VALUES('$id_dastorolamal','$code_kala',TRIM('$gheymat_kharid'),TRIM('$code_kh_mali'),'$meyar','$darsad',0)");
   $insert_res=mysql_query($insert_q);
   if($insert_res)
   {
    $max_id=$db->get_from_where("Max(id_gheymat_kharid)","$TableName","");  
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   	echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&PageNo_detail_gh='.$PageNo_detail_gh.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\' </script>';
   }   
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت جدول قیمت به وجود آمده است ! *</span>';
 }
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($dastorolamal,$c_kala,$gheymat,$this_id)
{
 $flag=false;
 if(!($dastorolamal and $c_kala and $gheymat))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
return $flag;
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($id_dastorolamal,$code_kala,$gheymat_kharid,$id_gheymat_kharid_))
 {
  $Mode='';	
  $edit_q=("UPDATE $TableName SET code_kala='$code_kala',gheymat_kharid=TRIM('$gheymat_kharid'),code_kh_mali=TRIM('$code_kh_mali'),meyar='$meyar',darsad='$darsad' WHERE id_gheymat_kharid='$id_gheymat_kharid_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_gheymat_kharid_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&PageNo_detail_gh='.$PageNo_detail_gh.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\' </script>';
  }
  else if(mysql_affected_rows()==0) echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&PageNo_detail_gh='.$PageNo_detail_gh.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\' </script>';
  else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود امده است ! *</span>';                
 } 
}
/********************END********************/	
echo'
'.$message.'
</form>
</body>
</html>';	
?>