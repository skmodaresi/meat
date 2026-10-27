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
$code_ostan=$db->get_from_where("code_ostan","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal'");

$noe_gheymat=$db->get_from_where("noe_gheymat","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal' AND deleted=0");
$mahmule_type=$db->get_from_where("mahmule_type","eblagh_kharid INNER JOIN dastorolamal_kharid ON dastorolamal_kharid.id_eblagh=eblagh_kharid.id_eblagh","id_dastorolamal='$id_dastorolamal'");

$titr="قیمت خرید کالا (شماره دستورالعمل  $shomare_dastorolamal)";
$code_group_kala_top=$db->get_from_where("code_group_kala_top","dastorolamal_kharid INNER JOIN eblagh_kharid ON dastorolamal_kharid.id_eblagh=eblagh_kharid.id_eblagh","id_dastorolamal='$id_dastorolamal'");
$gosht_type=$db->get_from_where("gosht_type","dastorolamal_kharid INNER JOIN eblagh_kharid ON dastorolamal_kharid.id_eblagh=eblagh_kharid.id_eblagh","id_dastorolamal='$id_dastorolamal'");
$activate_dastor=$db->get_from_where("activate","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal'");
$activate_eblagh=$db->get_from_where("activate_eblagh","eblagh_kharid","id_eblagh='$id_eblagh'");

if($noe_gheymat==2)
{
 if(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $Condition_ostan='';
 else $Condition_ostan=' AND T.code_ostan='.$_SESSION['mt_code_ostan'].'';
}


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
$res = $db->query("SELECT COUNT(*) FROM $TableName T where 1=1 ".$_SESSION['mt_search_gheymat_kharid']." $Condition_ostan AND deleted=0");
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
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
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
	 <td width="8%">قیمت (ریال)</td>
	 <td width="7%">کد حسابداری قیمت</td>
	 <td width="7%">معیار آنالیز</td>
	 <td width="7%">درصد آنالیز</td>
	 <td width="13%">استان</td>
	 ';
	 if(($right_del)and($Mode==NULL)and($activate_dastor==1)) echo'<td width="18%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="18%">دستورات</td>';
	 echo'
	</tr>';
    //اگر وارداتی قرارداد استانی باشد
	IF($mahmule_type==3)$condition_kala="AND mahmule_type=2";
	ELSE IF($mahmule_type==4)$condition_kala="AND mahmule_type=1";
	ELSE                $condition_kala="AND mahmule_type=$mahmule_type";
	IF($code_group_kala_top==5) $condition_kala.=" AND gosht_type=$gosht_type";
    if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ثبت"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	 //قبلا برای سایر کالا ها در این دستورالعمل قیمت وارد شده 
	 $exist_befor=$db->get_from_where("COUNT(*)","$TableName","id_dastorolamal='$id_dastorolamal' AND deleted=0"); 
	 //قیمت قبلی برای سایرین هم قرار بگیرد
	 IF($exist_befor>0)$gheymat_kharid=$db->get_from_where("gheymat_kharid","$TableName","id_dastorolamal='$id_dastorolamal' AND deleted=0"); 
	  echo'
	  <tr class="table-odd">
	   <td>'.$radif++.'</td>
	   <td>&nbsp;</td>
	   <td><span class="star">*</span>&nbsp;'.listbox("code_kala",$code_kala,"code_kala","name_kala","kala","code_group_kala_top='$code_group_kala_top' $condition_kala ORDER BY name_kala","class='text4'").'</td>';
	   echo'<td><span class="star">*</span>&nbsp;<input type="text" class="textboxme2"  name="gheymat_kharid" value="'.$gheymat_kharid.'" '; IF($exist_befor>0) echo 'readonly'; echo' onkeypress="return isNumber(event)"/></td>
	   <td><span class="star">*</span><input type="text" class="textboxme2" name="code_kh_mali" value="'.$code_kh_mali.'" onkeypress="return isNumber(event)"/></td>
	   <td>'.static_listbox("meyar",$meyar,"meyarArr",1,"class='text4'").'</td>
	   <td><input type="text" class="textboxme2" name="darsad" value="'.$darsad.'" onKeydown="return PressfloatOnly(event,this)"/></td>
	   <td>';
	   IF($noe_gheymat==2)echo' <span class="star">*</span>&nbsp; '.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan T","1=1 $Condition_ostan ORDER BY T.name_ostan ASC","disabled class='text4' ","").' <input type="hidden" name="code_ostan" value='.$code_ostan.'>';
	   ELSE echo '-';
	   echo'
	   </td>
	   <td colspan="2">
	   	   <input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail_gh='.$PageNo_detail_gh.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT T.*,kala.name_kala,name_ostan,(SELECT count(*) FROM gharardad_kharid gh_kh WHERE gh_kh.gheymat_har_kilo=T.gheymat_kharid) existgharardad
	     From $TableName T INNER JOIN kala ON kala.code_kala=T.code_kala
         LEFT JOIN ostan ON ostan.code_ostan=T.code_ostan		 
		 WHERE 1=1 ".$_SESSION['mt_search_gheymat_kharid']." AND T.id_dastorolamal='$id_dastorolamal' $Condition_ostan AND deleted=0 order by $order $Limit";
	$allGheymat = $db->query($q1);
    while($row1=$db->fetch_assoc($allGheymat))
	{
      if(((($_SESSION['mt_all_ostan']==1)or(SuperUser()))and($right_edt)and($activate_dastor==1))OR(($right_edt)and($activate_dastor==1)and($noe_gheymat==2)))
     {$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_gheymat_kharid_='.$row1['id_gheymat_kharid'].'&PageNo_detail_gh='.$PageNo_detail_gh.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'"';}	 
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
	  <td><span class="star">*</span><input type="text" class="textboxme2" name="code_kh_mali" value="'.$row1['code_kh_mali'].'" onkeypress="return isNumber(event)"/></td>
	  <td>'.static_listbox("meyar",$row1['meyar'],"meyarArr",1,"class='text4'").'</td>
	  <td><input type="text" class="textboxme2" name="darsad" value="'.$row1['darsad'].'" onKeydown="return PressfloatOnly(event,this)""/></td>
	  <td>';
	   IF($noe_gheymat==2) {
	    echo' <span class="star">*</span>&nbsp; '.listbox("code_ostan",$row1['code_ostan'],"code_ostan","name_ostan","ostan T","1=1 $Condition_ostan ORDER BY T.name_ostan ASC","readonly class='text4'","").'';
	   }
	   ELSE echo '-'; 
	  echo'
	  </td>
	  <td colspan="2">';
	  IF($activate_eblagh==1)echo'<input class="buttonme" type="submit" name="Edit_x" value="ثبت تغييرات" >';
	    echo'
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
	  <td '.$edtClick.'>'.$row1['darsad'].'</td>
	  <td '.$edtClick.'>'.$row1['name_ostan'].'</td>
	  ';
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
	 //if(((($_SESSION['mt_all_ostan']==1)or(SuperUser()))and($right_ins)and($activate_dastor==1))OR(($right_ins)and($activate_dastor==1)and($noe_gheymat==2)and($activate_eblagh==1)))//سوپریوزر بتواند بزند
	 if(((($_SESSION['mt_all_ostan']==1)or(SuperUser()))and($right_ins)and($activate_dastor==1)and($activate_eblagh==1))OR(($right_ins)and($activate_dastor==1)and($noe_gheymat==2)and($activate_eblagh==1)))
	 {
	  echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo_detail_gh='.$PageNo_detail_gh.'&PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_dastorolamal='.$id_dastorolamal.'&id_eblagh='.$id_eblagh.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	  <td width="10px">&nbsp;</td>';
	 }
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
function isPermitSave($dastorolamal,$c_kala,$gheymat,$code_mali,$majmoe_darsad,$noe_gheymat,$c_ostan)
{
 $flag=false; 
 if(!($dastorolamal and $c_kala and $gheymat and $code_mali))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert($dastorolamal);</script>";
   echo"<script>window.alert($c_kala);</script>";
   echo"<script>window.alert($gheymat);</script>";
   echo"<script>window.alert($code_mali);</script>";
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true; 
 if($majmoe_darsad>100)
 {
   $flag=false;
   echo"<script> alert('مجموع درصد مقادیر از 100 بیشتر است')</script>";
   return $flag;
 } 
 else $flag=true;
 if(($noe_gheymat==2)and(!$c_ostan))
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($noe_gheymat==1)and(!empty($c_kala)))//تکراري نبودن نام کالا
 {
   $q9="SELECT * FROM gheymat_kharid WHERE id_dastorolamal='$dastorolamal' AND code_kala='$c_kala' AND deleted=0";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام کالا قبلا ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 if(($noe_gheymat==2)and(!empty($c_kala))and (!empty($c_ostan)))//تکراري نبودن نام کالا
 {
   $q9="SELECT * FROM gheymat_kharid WHERE id_dastorolamal='$dastorolamal' AND code_kala='$c_kala' AND code_ostan='$c_ostan' AND deleted=0";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام کالا و استان قبلا در این دستورالعمل ثبت شده است')</script>";
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
 $majmoe_darsad_ghabliha=$db->get_from_where("SUM(darsad)","$TableName","id_dastorolamal='$id_dastorolamal' AND deleted=0");
 $majmoe_darsad=$majmoe_darsad_ghabliha+$darsad;
 if(isPermitSave($id_dastorolamal,$code_kala,$gheymat_kharid,$code_kh_mali,$majmoe_darsad,$noe_gheymat,$code_ostan))
 {
   $Mode='';
   $insert_q=("INSERT INTO $TableName(id_dastorolamal,code_kala,gheymat_kharid,code_kh_mali,meyar,darsad,code_ostan,deleted)VALUES('$id_dastorolamal','$code_kala',TRIM('$gheymat_kharid'),TRIM('$code_kh_mali'),'$meyar','$darsad','$code_ostan',0)");
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
function isPermitEdit($dastorolamal,$c_kala,$gheymat,$code_mali,$majmoe_darsad,$noe_gheymat,$c_ostan,$this_id)
{
 $flag=false;
 if(!($dastorolamal and $c_kala and $gheymat and $code_mali))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if($majmoe_darsad>100)
 {
   $flag=false;
   echo"<script> alert('مجموع درصد مقادیر از 100 بیشتر است')</script>";
   return $flag;
 } 
 else $flag=true;
 if(($noe_gheymat==2)and(!$c_ostan))
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true; 
 if(($noe_gheymat==1)and(!empty($c_kala)))//تکراري نبودن نام کالا
 {
   $q9="SELECT * FROM gheymat_kharid WHERE id_dastorolamal='$dastorolamal' AND code_kala='$c_kala' AND deleted=0 AND id_gheymat_kharid!='$this_id'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام کالا قبلا ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 if(($noe_gheymat==2)and(!empty($c_kala))and (!empty($c_ostan)))//تکراري نبودن نام کالا
 {
   $q9="SELECT * FROM gheymat_kharid WHERE id_dastorolamal='$dastorolamal' AND code_kala='$c_kala' AND code_ostan='$c_ostan' AND deleted=0 AND id_gheymat_kharid!='$this_id'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام کالا و استان قبلا در این دستورالعمل ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
return $flag;
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 $majmoe_darsad_ghabliha=$db->get_from_where("SUM(darsad)","$TableName","id_dastorolamal=$id_dastorolamal AND id_gheymat_kharid!='$id_gheymat_kharid_' AND deleted=0");
 $majmoe_darsad=$majmoe_darsad_ghabliha+$darsad;
 if(isPermitEdit($id_dastorolamal,$code_kala,$gheymat_kharid,$code_kh_mali,$majmoe_darsad,$noe_gheymat,$code_ostan,$id_gheymat_kharid_))
 {
  $Mode='';	
  $edit_q=("UPDATE $TableName SET code_kala='$code_kala',gheymat_kharid=TRIM('$gheymat_kharid'),code_kh_mali=TRIM('$code_kh_mali'),meyar='$meyar',darsad='$darsad',code_ostan='$code_ostan' WHERE id_gheymat_kharid='$id_gheymat_kharid_';");
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