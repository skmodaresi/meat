<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="shomare_safar.php";
$titr='شماره قرارداد/ سفر';
$logtime=date('H:i:s');
if($_SESSION['mt_systemmabadi']==0)//اطلاعات از سیستم انبار
{
 $TableName="shomare_safar";
 $right_ins=0;$right_edt=0;$right_del=0;
 if (right(111)) $right_ins=1;
 if (right(112)) $right_edt=1;
 if (right(113)) $right_del=1; 
}
if($_SESSION['mt_systemmabadi']==1)//اطلاعات از سیستم مبادی
{
 $db->selectDb('mabadi');
 $TableName="mbd_kharid";
}
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
 function getDetailKeshty(code_skk)<!--اطلاعات کشتی / شرکت-->
 { 
    $("#loading").fadeIn("fast");
	$.post("ajax.php",{codeKESHTY : code_skk},function(data){			 
			  var splKeshty = data.split("^");
			  $("#name_skk").val(splKeshty[0]);
		 });
    $("#loading").fadeOut("fast");
 } 
 function enterIE()
 {
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
 }
</script>
</head>';
$message='';
if(!(isset($Mode))) $Mode='';	
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_sh_safar']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($_SESSION['mt_systemmabadi']==0)//اطلاعات از سیستم انبار
 {
  if($code_skk)      $temp.=" and code_skk LIKE '$code_skk'";
  if($shomare_safar) $temp.=" and shomare_safar LIKE '%$shomare_safar%'";
  if($etmam_safar)   $temp.=" and etmam_safar LIKE '%$etmam_safar%'";
  if($code_ostan)    $temp.=" and T.code_ostan='$code_ostan'";
 }
 if($_SESSION['mt_systemmabadi']==1)//اطلاعات از سیستم مبادی
 {
  if($skk)     $temp.=" and skk LIKE '$skk'";
  if($sharh)   $temp.=" and sharh LIKE '%$sharh%'";
  if($shomare) $temp.=" and shomare LIKE '%$shomare%'";
  if($bargiri_et!=NULL)
  {if($bargiri_et==0) $temp.=" and bargiri_et=''";
   if($bargiri_et==1) $temp.=" and bargiri_et<>''";}
 }
 if($temp) {$PageNo=1;$_SESSION['mt_search_sh_safar']=$temp;} else $_SESSION['mt_search_sh_safar']="";
 }
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName T where 1=1 ".$_SESSION['mt_search_sh_safar']."");
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo))  $PageNo=1; //$PageNo=$MaxPage;
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
function isPermitSave($a,$b,$c_ostan)
{
 $flag=false;
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($b))//شماره سفر تکراری نباشد
 { 
   $q10="SELECT * FROM shomare_safar WHERE shomare_safar='$b' AND code_ostan='$c_ostan'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if(mysql_num_rows($res10)>0){
   echo"<script>alert('اين شماره سفر قبلا ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$c_ostan,$this_id)
{
 $flag=false;
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($b))//شماره سفر تکراری نباشد
 { 
   $q10="SELECT * FROM shomare_safar WHERE shomare_safar='$b' AND code_ostan='$c_ostan' AND id_safar!=$this_id";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if(mysql_num_rows($res10)>0){
   echo"<script>alert('اين شماره سفر قبلا ثبت شده است !')</script>";
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
 if(isPermitSave($code_skk,$shomare_safar,$code_ostan)) 
 {
  $Mode='';
  $insert_q=("INSERT INTO $TableName(code_skk,shomare_safar,etmam_safar,code_ostan)VALUES('$code_skk',TRIM('$shomare_safar'),'$etmam_safar','$code_ostan')");  
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id_safar)","$TableName","");   
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");  
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_skk,$shomare_safar,$code_ostan,$id_safar_)) 
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET code_skk='$code_skk',shomare_safar=TRIM('$shomare_safar'),etmam_safar='$etmam_safar',code_ostan='$code_ostan' WHERE `id_safar`='$id_safar_'; ");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_safar_','ویرایش',".($yymmdd).",'$logtime')");
  else if(mysql_affected_rows==0) echo $message='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>'; 
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id_safar=$id_safar_ AND
         ($id_safar_ NOT IN(SELECT id_safar FROM resid WHERE id_safar=$id_safar_ AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_skk.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title"><div style="position:absolute;top:5px;left:45%;">'.$titr.'</div>
  <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div></td> 	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
   <img src="images/loading.gif" id="loading" class="loading_img"/>
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order)) {if($_SESSION['mt_systemmabadi']==0)$order='id_safar DESC'; if($_SESSION['mt_systemmabadi']==1)$order='kharid_id DESC';}
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($sortsafar)) $sortsafar='1';
if(!isset($show_img)) $show_img='';
	 echo'<td width="10%">شناسه</td>';
	 if($sortcode=='1')
	 {
	   if($_SESSION['mt_systemmabadi']==0)echo'<td width="15%" title="مرتب سازی صعودی کد فروشنده / کشتی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_skk ASC&sortcode=2&show_img=1\'"/> کد فروشنده / کشتی ';
	   if($_SESSION['mt_systemmabadi']==1)echo'<td width="15%" title="مرتب سازی صعودی کد فروشنده / کشتی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=skk ASC&sortcode=2&show_img=1\'"/> کد فروشنده / کشتی  ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {
	   if($_SESSION['mt_systemmabadi']==0)echo'<td width="15%" title="مرتب سازی نزولی کد فروشنده / کشتی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_skk DESC&sortcode=1&show_img=1\'"/> کد فروشنده / کشتی ';
	   if($_SESSION['mt_systemmabadi']==1)echo'<td width="15%" title="مرتب سازی نزولی کد فروشنده / کشتی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=skk DESC&sortcode=1&show_img=1\'"/> کد فروشنده / کشتی ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='1')
	 {
	   if($_SESSION['mt_systemmabadi']==0) echo'<td width="25%" title="مرتب سازی صعودی نام فروشنده / کشتی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameSKK ASC&sortname=2&show_img=2\'"/> نام فروشنده / کشتی ';
	   if($_SESSION['mt_systemmabadi']==1) echo'<td width="25%" title="مرتب سازی صعودی نام فروشنده / کشتی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sharh ASC&sortname=2&show_img=2\'"/> نام فروشنده / کشتی ';
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {
	   if($_SESSION['mt_systemmabadi']==0)echo'<td width="25%" title="مرتب سازی نزولی نام فروشنده / کشتی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameSKK DESC&sortname=1&show_img=2\'"/> نام فروشنده / کشتی ';
	   if($_SESSION['mt_systemmabadi']==1)echo'<td width="25%" title="مرتب سازی نزولی نام فروشنده / کشتی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sharh DESC&sortname=1&show_img=2\'"/> نام فروشنده / کشتی ';
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortsafar=='1')
	 {
	   if($_SESSION['mt_systemmabadi']==0)echo'<td width="15%" title="مرتب سازی صعودی شماره قرارداد / سفر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare_safar ASC&sortsafar=2&show_img=3\'"/> شماره قرارداد / سفر'; 
	   if($_SESSION['mt_systemmabadi']==1)echo'<td width="15%" title="مرتب سازی صعودی شماره قرارداد / سفر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare ASC&sortsafar=2&show_img=3\'"/> شماره قرارداد / سفر'; 
	   if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortsafar=='2')
	 { 
	   if($_SESSION['mt_systemmabadi']==0)echo'<td width="15%" title="مرتب سازی نزولی شماره قرارداد / سفر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare_safar DESC&sortsafar=1&show_img=3\'"/> شماره قرارداد / سفر '; 
	   if($_SESSION['mt_systemmabadi']==1)echo'<td width="15%" title="مرتب سازی نزولی شماره قرارداد / سفر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare DESC&sortsafar=1&show_img=3\'"/> شماره قرارداد / سفر '; 
	   if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 echo'
	 <td width="15%">خاتمه عمليات تخليه</td>
	 <td width="10%">استان</td>';
	 if($_SESSION['mt_systemmabadi']==0)
	 {
	  if(($right_del)and($Mode==NULL)) echo'<td width="10%">حذف</td>';
      else if($Mode!=NULL) echo'<td width="10%">دستورات</td>';
	 }
	 if(($_SESSION['mt_systemmabadi']==1)and($Mode=='Search')) echo'<td width="15%">دستورات</td>';
	 echo'
	</tr>';
	if($Mode=='Insert')
	{
	  $button_value="ايجاد"; $button_name="Insert_x"; 
	  echo'
	  <tr class="table-odd">
	   <!--<td>'.listbox("code_skk",$code_skk,"code_skk","name_skk","mt_skk","","class='text4'").'</td>-->
	   <td></td>
	   <td><input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onfocus="getDetailKeshty(this.value)" onchange="getDetailKeshty(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/> ';
	   include ("img_helpskk.php");
	   echo'
	   </td>
	   <td><input type="text" name="name_skk" class="textboxme" readonly id="name_skk" value="'.$name_skk.'"/></td>
	   <td><input type="text" class="textboxme2" name="shomare_safar" value="'.$shomare_safar.'"/></td>
	   <td><input type="radio" name="etmam_safar" value="1"/>بلی<input type="radio" name="etmam_safar" checked="checked" value="0"/>خير</td>
	   <td>'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
	   <td colspan="2"><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	if($Mode=='Search')
	{
      $button_value="جستجو"; $button_name="Search_x";
	  if($_SESSION['mt_systemmabadi']==0)//اطلاعات از سیستم انبار
	  {
	   echo'
	   <tr class="table-odd">
	    <!--<td>'.listbox("code_skk",$code_skk,"code_skk","name_skk","mt_skk","","class='text4'").'</td>-->
	    <td></td>
		<td><input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onfocus="getDetailKeshty(this.value)" onchange="getDetailKeshty(this.value)" onkeypress="return isNumber(event)" style="width:50px;"/> ';
	    include ("img_helpskk.php");
	    echo'
	    </td>
	    <td><input type="text" name="name_skk" class="textboxme" readonly id="name_skk" value="'.$name_skk.'"/></td>
	    <td><input type="text" class="textboxme2" name="shomare_safar" value="'.$shomare_safar.'"/></td>
	    <td><input type="radio" name="etmam_safar" value="1"/>بلی<input type="radio" name="etmam_safar" value="0"/>خير</td>
	    <td>'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
		<td colspan="2"><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	    </td>
	   </tr>';
	  }
	  if($_SESSION['mt_systemmabadi']==1)//اطلاعات از سیستم مبادی
	  {
	   echo'
	   <tr class="table-odd">
	    <td><input type="text" class="textboxme2" name="skk" value="'.$skk.'" onkeypress="return isNumber(event)" style="width:50px;"/> ';
	   // include ("img_helpskk.php");
	    echo'
	    </td>
	    <td><input type="text" name="sharh" class="textboxme" value="'.$sharh.'"/></td>
	    <td><input type="text" class="textboxme2" name="shomare" value="'.$shomare.'"/></td>
	    <td><input type="radio" name="bargiri_et" value="1"/>بلی<input type="radio" name="bargiri_et" value="0"/>خير</td>
	    <td>'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
		<td colspan="2"><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	    </td>
	   </tr>';
	  }
	}
	$i=0;
	if($_SESSION['mt_systemmabadi']==0)
	{$q1="SELECT *,ostan.name_ostan,
	     (SELECT name_skk From mt_skk WHERE mt_skk.code_skk=T.code_skk) nameSKK, 	
	     (SELECT count(id_safar) FROM resid r WHERE r.id_safar=T.id_safar AND r.deleted=0) exist_resid
		  From $TableName T LEFT JOIN ostan ON T.code_ostan=ostan.code_ostan
		  WHERE 1=1 ".$_SESSION['mt_search_sh_safar']." order by $order $Limit";	
    }
	if($_SESSION['mt_systemmabadi']==1)$q1="SELECT * From $TableName T WHERE 1=1 ".$_SESSION['mt_search_sh_safar']." order by $order $Limit";	
	$allSafar = $db->query($q1);
    while($row1=$db->fetch_assoc($allSafar))
	{
     //if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_safar_='.$row1['id_safar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id_safar']==$id_safar_)
	 {
	  if($row1['exist_resid'])
	  {
	    echo '
	    <td>'.$row1['id_safar'].'</td>
		<td><input type="text" class="textboxme2" name="code_skk" readonly value="'.$row1['code_skk'].'" onfocus="getDetailKeshty(this.value)" onchange="getDetailKeshty(this.value)" style="width:50px"/> 
         <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/>
	    </td>
	    <td><input type="text" name="name_skk" class="textboxme" readonly  id="name_skk" value="'.$row1['nameSKK'].'"/></td>
	    <td><input type="text" class="textboxme2" readonly name="shomare_safar" value="'.$row1['shomare_safar'].'"/></td>';
	  }
	  else
	  {
	    echo '
	    <td>'.$row1['id_safar'].'</td>
		<td><input type="text" class="textboxme2" name="code_skk"  value="'.$row1['code_skk'].'" onfocus="getDetailKeshty(this.value)" onchange="getDetailKeshty(this.value)" style="width:50px"/> ';
	    include ("img_helpskk.php");
        echo'
	    </td>
	    <td><input type="text" name="name_skk" class="textboxme" readonly  id="name_skk" value="'.$row1['nameSKK'].'"/></td>
	    <td><input type="text" class="textboxme2" name="shomare_safar" value="'.$row1['shomare_safar'].'"/></td>';
	  }
	  echo'
	  <td>
	   <input type="radio" name="etmam_safar" value="1"';if($row1['etmam_safar']==1) echo 'checked="checked"';echo' />بلی
	   <input type="radio" name="etmam_safar" value="0"';if($row1['etmam_safar']==0) echo 'checked="checked"';echo' />خير	      
	  </td>
	  <td>'.listbox("code_ostan",$row1['code_ostan'],"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>

	  <td colspan="2">
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {
	  if($_SESSION['mt_systemmabadi']==0)
	  {
	   echo'
	   <td '.$edtClick.'>'.$row1['id_safar'].'</td>
	   <td '.$edtClick.'>'.$row1['code_skk'].'</td>
	   <td '.$edtClick.'>'.$row1['nameSKK'].'</td>
	   <td '.$edtClick.'>'.$row1['shomare_safar'].'</td>
	   <td '.$edtClick.'>';if ($row1['etmam_safar']==1) echo 'بلی'; else echo 'خير';echo'</td>';
	   echo'<td '.$edtClick.'>'.$row1['name_ostan'].'</td>';

	   if($right_del)
	   {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	        onmouseOver="this.src=\'images/trash_hover.png\'" 
		    onmouseOut="this.src=\'images/trash.png\'" 	  
	        onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_safar_='.$row1['id_safar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف شماره سفر '.$row1['shomare_safar'].' متعلق به کشتی  '.$row1['nameSKK'].' \')" /></td>';
	   }
	   else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	   else echo'';
	  }
	  if($_SESSION['mt_systemmabadi']==1)
	  {
	   echo'
	   <td '.$edtClick.'>'.$row1['skk'].'</td>
	   <td '.$edtClick.'>'.$row1['sharh'].'</td>
	   <td '.$edtClick.'>'.$row1['shomare'].'</td>
	   <td '.$edtClick.'>';if ($row1['bargiri_et']==NULL) echo 'خیر'; else echo 'بلی';echo'</td>';
	   if($Mode=='Search')echo'<td>&nbsp;</td>';
	  }
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
	 <td width="24"><div onClick="window.open(\'print_shomare_safar.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
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
     if ($_SESSION['mt_search_sh_safar']) 
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