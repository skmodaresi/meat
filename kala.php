<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="kala.php";
$TableName="kala";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;$right_detail=0;
if (right(41)) $right_ins=1;
if (right(42)) $right_edt=1;
if (right(43)) $right_del=1;
if (right(44)) $right_detail=1;
$titr='کالا';
// $number__=1213.4545;
 // $num1=number_format($number__,4);
 // echo $num1.'<br/>';
 // echo virgul(($number__),'2');
//echo $_SESSION['mt_user_id'];
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 
<script type="text/javascript">
$(document).ready(function() {		
		<!--تغییر براساس گروه کالا-->
        $("[name=code_group_kala_top]").bind("change", function (){
        if($(this).val() == 5)<!--انتخاب گروه گوشت --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".goshtshow").show();
	        $("#loading").fadeOut("fast");	
        }
        else
		{
		 	$("#loading").fadeIn("fast");
	        $(".goshtshow").hide();
	        $("#loading").fadeOut("fast");	
		}
      });		
});
function enterIE(evt)
{
   evt = (evt) ? evt : window.event;
   var charCode = (evt.which) ? evt.which : evt.keyCode;
   if (charCode==13 && charCode.srcElement.id!= \'sabt\') {charCode=9;}
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_kala']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x="";
 $temp=""; 
 if($code_kala)           $temp.=" AND code_kala LIKE '%$code_kala%'";
 if($name_kala)           $temp.=" AND name_kala LIKE '%$name_kala%'";
 if($code_vahedkala)      $temp.=" AND code_vahedkala LIKE '$code_vahedkala'";
 if($code_bastebandy)     $temp.=" AND code_bastebandy LIKE '$code_bastebandy'";
 if($code_group_kala)     $temp.=" AND code_group_kala LIKE '$code_group_kala'";
 if($code_group_kala_middle)     $temp.=" AND code_group_kala_middle LIKE '$code_group_kala_middle'";
 if($code_group_kala_top) $temp.=" AND code_group_kala_top LIKE '$code_group_kala_top'";
 if($mahmule_type)        $temp.=" AND mahmule_type LIKE '$mahmule_type'";
 //if($iran_code)           $temp.=" AND iran_code LIKE '%$iran_code%'";
 //if($onvan_iran_code)     $temp.=" AND onvan_iran_code LIKE '%$onvan_iran_code%'";
 //if($code_shabnam)        $temp.=" AND code_shabnam LIKE '%$code_shabnam%'";
 //if($onvan_shabnam)       $temp.=" AND onvan_shabnam LIKE '%$onvan_shabnam%'";
 //if($az_serial_shabnam)   $temp.=" AND az_serial_shabnam LIKE '%$az_serial_shabnam%'";
 //if($ta_serial_shabnam)   $temp.=" AND ta_serial_shabnam LIKE '%$ta_serial_shabnam%'";
 //if($code_gs1)            $temp.=" AND code_gs1 LIKE '%$code_gs1%'";
 //if($onvan_gs1)           $temp.=" AND onvan_gs1 LIKE '%$onvan_gs1%'";
 //if($code_hs)             $temp.=" AND code_hs LIKE '%$code_hs%'";
 //if($onvan_hs)            $temp.=" AND onvan_hs LIKE '%$onvan_hs%'";
 if($code_nerkh_standard) $temp.=" AND code_nerkh_standard LIKE '%$code_nerkh_standard%'";
 if($nerkh_standard)      $temp.=" AND nerkh_standard LIKE '%$nerkh_standard%'";
 if($tozihat_kala)        $temp.=" AND tozihat_kala LIKE '%$tozihat_kala%'";
 if($activate_resid)      $temp.=" AND activate_resid LIKE '$activate_resid'";
 if($activate_havale)     $temp.=" AND activate_havale LIKE '$activate_havale'";
 if($general_goods_id)    $temp.=" AND general_goods_id LIKE '%$general_goods_id%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_kala']=$temp;} else $_SESSION['mt_search_kala']="";
 }
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName WHERE 1=1 ".$_SESSION['mt_search_kala']." AND kala_type=2");
$row = $db->fetch_array($res);
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
//$myMessage='';
function isPermitSave($c_kala,$n_kala,$c_vahed,$c_baste,$c_group,$c_group_middle,$c_grp_top,$k_type,$c_nerkh_s,$nerk_s,$general_goods_id)
{
 $flag=false;
 if(!($c_kala and $n_kala and $c_vahed and $c_baste and $c_group and $c_group_middle and $c_grp_top and $k_type and $c_nerkh_s and $nerk_s and $general_goods_id))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>"; 
   return $flag;
 } 
 else $flag=true;
 if(!justNumber($c_kala) or strlen($c_kala)>3)//عدد بودن کدکالا
 {
   $flag=false;
   echo"<script>alert('فيلد کد کالا نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if(!empty($c_kala))//تکراری نبودن کد کالا
 { 
    $q8="SELECT code_kala FROM kala WHERE code_kala='$c_kala'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين کد کالا قبلاً ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
 if(!empty($n_kala))//تکراري نبودن نام کالا
 {
   $q9="SELECT * FROM kala WHERE name_kala='$n_kala'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام کالا قبلا ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($c_kala,$n_kala,$c_vahed,$c_baste,$c_group,$c_group_middle,$c_grp_top,$k_type,$c_nerkh_s,$nerk_s,$general_goods_id,$this_id)
{
  $flag=false;
  if(!($c_kala and $n_kala and $c_vahed and $c_baste and $c_group and $c_grp_top and $k_type and $c_nerkh_s and $nerk_s and $general_goods_id))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>"; 
   return $flag;
  } 
  else $flag=true;
  if (!justNumber($c_kala) or strlen($c_kala)>3)//عدد بودن کدکالا
  {
   $flag=false;
   echo"<script>alert('فيلد کد کالا نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true; 
  if(!empty($c_kala))//تکراری نبودن کد کالا
  { 
   //$code_a=make_pattern($c_kala,3); 
   $q10="SELECT * FROM kala WHERE code_kala='$c_kala'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$this_id)){
   echo"<script>alert('اين کد کالا قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
  if(!empty($n_kala))//تکراري نبودن نام کالا
  {
    $q10="SELECT * FROM kala WHERE name_kala='$n_kala'";
    $res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
	$idk=$row10['id'];
    if((mysql_num_rows($res10)>0) and ($idk!=$this_id)){
      echo"<script>alert('اين نام کالا قبلا ثبت شده است')</script>";
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
 if(isPermitSave($code_kala,$name_kala,$code_vahedkala,$code_bastebandy,$code_group_kala,$code_group_kala_middle,$code_group_kala_top,$kala_type,$code_nerkh_standard,$nerkh_standard,$general_goods_id))
 {
   $Mode='';
   $name_kala=str_replace("ي","ی",$name_kala);
   $name_kala=str_replace("ك","ک",$name_kala);
   $mandegari='';   
   if(is_array($mandegarichoice))//تاریخ ماندگاری
   {
      foreach($mandegarichoice as $mandegari_key => $mandegari_val) 
      {
       $mandegari.= $mandegari_val.';' ;
      }
	  $mandegari=rtrim($mandegari, ";"); 
   }
   //echo var_dump($mandegarichoice) .'<br>';
   //echo $mandegari;
   $insert_q=("INSERT INTO $TableName(code_kala,name_kala,code_vahedkala,code_bastebandy,code_group_kala,code_group_kala_middle,code_group_kala_top,gosht_type,kala_type,mahmule_type,iran_code,onvan_iran_code,
               code_shabnam,onvan_shabnam,az_serial_shabnam,ta_serial_shabnam,code_gs1,onvan_gs1,code_hs,onvan_hs,code_nerkh_standard,nerkh_standard,tozihat_kala,activate_resid,activate_havale,mandegari,general_goods_id)
              VALUES('$code_kala',TRIM('$name_kala'),'$code_vahedkala','$code_bastebandy','$code_group_kala','$code_group_kala_middle','$code_group_kala_top','$gosht_type','$kala_type','$mahmule_type',TRIM('$iran_code'),TRIM('$onvan_iran_code'),
			  TRIM('$code_shabnam'),TRIM('$onvan_shabnam'),TRIM('$az_serial_shabnam'),TRIM('$ta_serial_shabnam'),TRIM('$code_gs1'),TRIM('$onvan_gs1'),TRIM('$code_hs'),
			  TRIM('$onvan_hs'),'$code_nerkh_standard','$nerkh_standard',TRIM('$tozihat_kala'),$activate_resid,$activate_havale,'$mandegari',TRIM('$general_goods_id'))");          
   $insert_res=mysql_query($insert_q);
   if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName","");   
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/  
   }
   else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت کالا به وجود آمده است ! *</span>';
   
   //header('location:'.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'');
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_kala,$name_kala,$code_vahedkala,$code_bastebandy,$code_group_kala,$code_group_kala_middle,$code_group_kala_top,$kala_type,$code_nerkh_standard,$nerkh_standard,$general_goods_id,$id_))
 {
  $Mode='';
  $name_kala=str_replace("ي","ی",$name_kala);
  $name_kala=str_replace("ك","ک",$name_kala);
  if(is_array($mandegarichoice))//تاریخ ماندگاری
  {
      foreach($mandegarichoice as $mandegari_key => $mandegari_val) 
      {
       $mandegari.= $mandegari_val.';' ;
      }
	  $mandegari=rtrim($mandegari, ";"); 
  }
  $edit_q="UPDATE $TableName SET code_kala='$code_kala',name_kala= '$name_kala',code_vahedkala='$code_vahedkala',code_bastebandy='$code_bastebandy',
           code_group_kala='$code_group_kala',code_group_kala_middle='$code_group_kala_middle',code_group_kala_top='$code_group_kala_top',gosht_type='$gosht_type',kala_type='$kala_type',mahmule_type='$mahmule_type',iran_code=TRIM('$iran_code'),onvan_iran_code=TRIM('$onvan_iran_code'),code_shabnam=TRIM('$code_shabnam'),onvan_shabnam=TRIM('$onvan_shabnam'),
           az_serial_shabnam=TRIM('$az_serial_shabnam'),ta_serial_shabnam=TRIM('$ta_serial_shabnam'),code_gs1=TRIM('$code_gs1'),
		   onvan_gs1=TRIM('$onvan_gs1'),code_hs=TRIM('$code_hs'),onvan_hs=TRIM('$onvan_hs'),code_nerkh_standard='$code_nerkh_standard',nerkh_standard='$nerkh_standard',tozihat_kala=TRIM('$tozihat_kala'),activate_resid='$activate_resid',activate_havale='$activate_havale',good_id='$good_id',
           mandegari='$mandegari',general_goods_id='$general_goods_id' WHERE id='$id_'";
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/    
  else if(mysql_affected_rows==0) $message='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';      
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q = "DELETE FROM $TableName WHERE id=$id_ AND 
          ($code_kala_ NOT IN (SELECT code_kala FROM resid_detail WHERE code_kala=$code_kala_ AND resid_deleted=0))AND
          ($code_kala_ NOT IN (SELECT code_kala FROM resid_kala_detail WHERE code_kala=$code_kala_ AND resid_deleted=0))AND
		  ($code_kala_ NOT IN (SELECT code_kala FROM havale_forush WHERE code_kala=$code_kala_ AND deleted=0))AND
		  ($code_kala_ NOT IN (SELECT code_kala FROM mojody_kala WHERE code_kala=$code_kala_ AND deleted=0))AND
		  ($code_kala_ NOT IN (SELECT code_kala FROM gheymat_detail WHERE code_kala=$code_kala_ AND deleted=0))AND
		  ($code_kala_ NOT IN (SELECT code_kala FROM havale WHERE code_kala=$code_kala_ AND deleted=0))AND
		  ($code_kala_ NOT IN (SELECT code_kala FROM tadil_mojody WHERE code_kala=$code_kala_ AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ
}
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
if (($Mode=="Insert")or($Mode=="Search")) $load="document.myform.code_kala.focus();";
if ($Mode=="Edit") $load="document.myform.name_kala.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE(event);">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:48%;">کالا</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td> 
 </tr>
  <!--<td class="title">
  <div style="position:relative;width:100%;height:100%;>
   <div style="position:absolute;top:5px;left:45%;" >کالا</div>
  <div class="pagecover"><div style="position:absolute;top:1px;right:15%;">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div></div>
  </div>
  </td>-->
  <!--<td class="title">
   <div style="position:absolute;top:5px;left:45%;background-color:red;">کالا</div>
   <div class="pagecover">555</div></div>
  </td>-->
  <!--<td class="title">
  <table><tr><td>کالا</td><td>[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</td></tr></table>
  </td>-->
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
	 {echo'<td width="4%" title="مرتب سازی صعودی کد کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_kala ASC&sortcode=2&show_img=1\'"/> کد کالا ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {echo'<td width="4%" title="مرتب سازی نزولی کد کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_kala DESC&sortcode=1&show_img=1\'"/> کد کالا ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='1')
	 {echo'<td width="25%" title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_kala ASC&sortname=2&show_img=2\'"/> نام کالا '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {echo'<td width="25%" title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_kala DESC&sortname=1&show_img=2\'"/> نام کالا '; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }	
	 echo'
	 <td width="4%">واحد کالا</td>
	 <td width="5%">بسته بندی</td>
	 <td width="8%">گروه کالا اصلی</td>
	 <td width="14%">گروه کالا</td>
	 <td width="5%">نوع محموله</td>
	 <td width="10%">شناسه عمومی کالا</td>
	 <td width="10%">کد نرخ استاندارد</td>
	 <td width="10%">نرخ استاندارد</td>';
	 if($right_detail)echo'<td width="10%">جزئيات</td>';
	 if($right_del) echo'<td width="5%">حذف</td>';
     echo'
	</tr>';
	$i=0;
    $q1="SELECT *,
	          (SELECT name_group_kala_top FROM bzacc.group_kala_top WHERE group_kala_top.code_group_kala_top=T.code_group_kala_top) groupTopName,
	          (SELECT name_group_kala FROM meat.group_kala WHERE group_kala.code_group_kala=T.code_group_kala) groupName,
		      (SELECT sharh_vahedkala FROM meat.vahed_kala WHERE vahed_kala.code_vahedkala=T.code_vahedkala) vahed,
		      (SELECT sharh_bastebandy FROM meat.bastebandy WHERE bastebandy.code_bastebandy=T.code_bastebandy) bastebandy,
			  (SELECT count(*) FROM kala_detail k_d WHERE k_d.code_kala=T.code_kala) detailcount
 	   From meat.$TableName T WHERE 1=1 ".$_SESSION['mt_search_kala']." AND kala_type=2 order by $order $Limit";
	$allKala = $db->query($q1);
    while($row1=$db->fetch_assoc($allKala))
	{
     if ($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&code_kala_='.$row1['code_kala'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     //$delClick=''; if ($right_del) $delClick='<img border="0"  src="images/trash.png" width="20" height="20" title="حذف" onmouseOver="this.src=\'images/trash_hover.png\'" onmouseOut="this.src=\'images/trash.png\'" onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_kala_='.$row1['code_kala'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف '.$row1['name_kala'].' \')" />';
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
     echo'
	  <td '.$edtClick.'>'.$row1['code_kala'].'</td>
	  <td '.$edtClick.'>'.$row1['name_kala'].'</td>
	  <td '.$edtClick.'>'.$row1['vahed'].'</td>
	  <td '.$edtClick.'>'.$row1['bastebandy'].'</td>
	  <td '.$edtClick.'>'.$row1['groupTopName'].'</td>
	  <td '.$edtClick.'>'.$row1['groupName'].'</td>
	  <td '.$edtClick.'>'.$mahmuletypeKalaArr[$row1['mahmule_type']].'</td>
	  <td '.$edtClick.'>'.$row1['general_goods_id'].'</td>
	  <td '.$edtClick.'>'.$row1['code_nerkh_standard'].'</td>
	  <td '.$edtClick.'>'.$row1['nerkh_standard'].'</td>';
	  if($right_detail) {IF($row1['code_bastebandy']==1)echo'<td><input type="button" class="button-inline"  value="جزئيات['.$row1['detailcount'].']" onClick="window.location=\'kala_detail.php?PageNo='.$PageNo.'&code_kala_='.$row1['code_kala'].'\'"></td>';ELSE echo'<td>&nbsp;</td>';}
	  if($right_del)
	  {echo'<td><img border="0"  src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_kala_='.$row1['code_kala'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف '.$row1['name_kala'].' \')" /></td>';
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
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($right_del)echo'<td>&nbsp;</td>';
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
	 <td width="10px">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_kala.php\',\'\',\'scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10px">&nbsp;</td>';}
	 echo'
	 <td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوی اصلی"><a href="#"></a></div></td>
	 <td width="20px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"  id="btn-perevius" title="رفتن به صفحه قبلی" ><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدی"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()"  onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_kala']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td> 	 
	</tr>';
    }
    if ($Mode=="Insert")  //Insert Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0"> <tr class="title"><td colspan="10" align="center">ايجاد کالای جدید</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left" width="150px"><span class="star">*</span> کد کالا :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" name="code_kala" value="'.$code_kala.'" maxlength="3" onkeypress="return isNumber(event)" style="width:50px"/></td>
		<td align="left" width="110px"><span class="star">*</span> نام کالا :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="name_kala" value="'.$name_kala.'"/></td>
	    <td align="left" width="110px"><span class="star">*</span> گروه کالا :&nbsp;</td><td align="right" >'.listboxMe("code_group_kala",$code_group_kala,"code_group_kala","name_group_kala","group_kala order by name_group_kala","","class='text4'").'</td>
	    <td align="left" width="110px"><span class="star">*</span> گروه کالا میانی :&nbsp;</td><td align="right">'.listboxMe("code_group_kala_middle",$code_group_kala_middle,"code_group_kala_middle","name_group_kala_middle","group_kala_middle order by name_group_kala_middle","","class='text4'").'</td>
	   </tr>
       <tr>';
	   $kala_type_default=2;//گوشتی
	   $mahmule_type_default=1;//داخلی
	   echo'
	    <td align="left"><span class="star">*</span> گروه کالای اصلی :&nbsp;</td><td align="right">'.listboxMe("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='text4'").'</td>
	    <td align="left"><span class="star">*</span> واحد کالا :&nbsp;</td><td align="right" >'.listboxMe("code_vahedkala",$code_vahedkala,"code_vahedkala","sharh_vahedkala","vahed_kala","","class='text4'").'</td>
	   	<td align="left"><span class="star">*</span> نوع بسته بندی :&nbsp;</td><td align="right">'.listboxMe("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","","class='text4'").'</td>
		<td align="left"><span class="star">*</span> نوع کالا :&nbsp;</td><td align="right">'.static_listbox("kala_type",$kala_type_default,"kalatypeArr",1,"class='text4'").'</td>
	   </tr>
       <tr>	   
		<td align="left" width="100px"><span class="star">*</span> نوع محموله :&nbsp;</td><td align="right">'.static_listbox("mahmule_type",$mahmule_type_default,"mahmuletypeKalaArr",1,"class='text4'").'</td>
	    <td align="left"><span class="star">*</span> وضعیت در رسید :&nbsp;</td><td align="right">'.static_listbox("activate_resid",$activate_resid,"activateArr",1,"class='text4'").'(به غیر از جابه جایی)</td>
	   	<td align="left"><span class="star">*</span> وضعیت در حواله :&nbsp;</td><td align="right">'.static_listbox("activate_havale",$activate_havale,"activateArr",1,"class='text4'").'</td>
	   	<td align="left" class="goshtshow" style="display:none;"><span class="star">*</span> نوع گوشت : &nbsp;</td><td align="right" class="goshtshow" style="display:none;">'.static_listbox("gosht_type",$gosht_type,"goshttypeArr",1,"class='text4'").'</td>';	   
	    //اگر ارروری در صفحه ظاهر شد
	    if($code_group_kala_top==5)//اگر گوشت
		  echo'<td align="left" class="goshtshow"><span class="star">*</span> نوع گوشت : &nbsp;</td><td align="right" class="goshtshow">'.static_listbox("gosht_type",$gosht_type,"goshttypeArr",1,"class='text4'").'</td>';
		echo'
	   </tr>
       <tr>	   
		<td align=left>ايران کد  :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="iran_code" value="'.$iran_code.'" onkeypress="return isNumber(event)"/></td>
        <td align=left>عنوان ايران کد  :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="onvan_iran_code" value="'.$onvan_iran_code.'"/></td>       
        <td align=left>کد شبنم :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="code_shabnam" value="'.$code_shabnam.'" onkeypress="return isNumber(event)"/></td>
        <td align=left>عنوان شبنم :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="onvan_shabnam" value="'.$onvan_shabnam.'"/></td>
		<td>&nbsp;</td><td>&nbsp;</td>	
       </tr>
	   <tr>
	    <td align=left>از سريال شبنم :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="az_serial_shabnam" value="'.$az_serial_shabnam.'" onkeypress="return isNumber(event)"/></td>
	    <td align=left>تا سريال شبنم :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="ta_serial_shabnam" value="'.$ta_serial_shabnam.'" onkeypress="return isNumber(event)"/></td>
	    <td align=left>کد GS1 :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="code_gs1" value="'.$code_gs1.'" onkeypress="return isNumber(event)"/></td>
		<td align=left>عنوان GS1 :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="onvan_gs1" value="'.$onvan_gs1.'"/></td>
        <td>&nbsp;</td><td>&nbsp;</td>			    
	   </tr>
	   <tr>
	    <td align="left">کد HS :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="code_hs" value="'.$code_hs.'" onkeypress="return isNumber(event)"/></td>
	    <td align=left>عنوان HS :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="onvan_hs" value="'.$onvan_hs.'"/></td>
	    <td align=left><span class="star">*</span> کد نرخ استاندارد :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="code_nerkh_standard" value="'.$code_nerkh_standard.'"/></td>
	    <td align=left><span class="star">*</span> نرخ استاندارد :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="nerkh_standard" value="'.$nerkh_standard.'"/></td>
	   </tr>
       <tr>	   
		<td align="left" width="100px">توضيحات کالا :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tozihat_kala" value="'.$tozihat_kala.'"/></td>	    
	    <td align="left"><span class="star">*</span>شناسه عمومی کالا :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="general_goods_id" value="'.$general_goods_id.'"/></td>	    
		<td align="left" width="100px">تاریخ ماندگاری :&nbsp; </td>
		<td align="right">
		  <select name="mandegarichoice[]" class="easyui-combobox" size="5" style="width:250px;" multiple >';
	       $result_tm = $db->query("SELECT * FROM tarikh_mandegari");
           //$tm_options = "<option value='-1' selected>همه</option>";
           while($row_tm=$db->fetch_assoc($result_tm)) $tm_options .= "<option value='".$row_tm['code_mandegari']."' > ".$row_tm['sharh_mandegari']." </option>";
	       echo $tm_options;
	       echo'
	       </select>
		</td>
	   </tr>
	   <tr>
        <td colspan="10" align="center"  class="title">
		 <input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
    if ($Mode=="Edit")//Edit Mode
    {
     $q2="SELECT *,
	 	 (SELECT count(code_kala) FROM resid_detail r_d WHERE r_d.code_kala=T.code_kala AND r_d.resid_deleted=0) exist_resid_detail,
	 	 (SELECT count(code_kala) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=T.code_kala AND r_k_d.resid_deleted=0) exist_resid_k_detail,
	     (SELECT count(code_kala) FROM havale_forush h_f WHERE h_f.code_kala=T.code_kala AND h_f.deleted=0) exist_havale_forush,
	     (SELECT count(code_kala) FROM mojody_kala m_k WHERE m_k.code_kala=T.code_kala AND m_k.deleted=0) exist_mojody_kala,
	     (SELECT count(code_kala) FROM gheymat_detail gh_d WHERE gh_d.code_kala=T.code_kala AND gh_d.deleted=0) exist_gheymat_detail,
	     (SELECT count(code_kala) FROM havale h WHERE h.code_kala=T.code_kala AND h.deleted=0) exist_havale,
	     (SELECT count(code_kala) FROM tadil_mojody t_m WHERE t_m.code_kala=T.code_kala AND t_m.deleted=0) exist_tadil
	      FROM $TableName T WHERE id='$id_'";
	 $res2=$db->query($q2);
	 $row2=$db->fetch_assoc($res2);
	 echo'
     <tr> 
	  <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	   <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0"><tr class="title"><td colspan="10" align="center">ويرايش '.$row2['name_kala'].'</td></tr>
        <tr><td>&nbsp;</td></tr>	   
	    <tr>';
	    if(($row2['exist_resid_detail'])or($row2['exist_resid_k_detail'])or($row2['exist_havale_forush'])or($row2['exist_mojody_kala'])or($row2['exist_gheymat_detail'])or($row2['exist_havale'])or($row2['exist_tadil']))
		 {echo'<td align="left" width=150px><span class="star">*</span> کد کالا  :&nbsp;</td><td align="right"><input class="textboxme2" type="text" title="غیر قابل تغییر" name="code_kala" readonly value="'.$row2['code_kala'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';}
	    else echo'<td align="left" width=150px><span class="star">*</span> کد کالا  :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="code_kala" value="'.$row2['code_kala'].'" maxlength="3" onkeypress="return isNumber(event)" style="width:50px"/></td>';
		echo'
 		 <td align="left" width=110px><span class="star">*</span> نام کالا :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="name_kala" value="'.$row2['name_kala'].'" /></td>
         <td align="left" width=110px><span class="star">*</span> گروه کالا :&nbsp;</td><td align="right" >'.listbox("code_group_kala",$row2['code_group_kala'],"code_group_kala","name_group_kala","group_kala order by name_group_kala","","class='text4'").'</td>
	     <td align="left" width="110px"> گروه کالا میانی :&nbsp;</td><td align="right">'.listbox("code_group_kala_middle",$row2['code_group_kala_middle'],"code_group_kala_middle","name_group_kala_middle","group_kala_middle order by name_group_kala_middle","","class='text4'").'</td>		
        </tr>
        <tr>
		 <td align="left"><span class="star">*</span> گروه کالای اصلی :&nbsp;</td><td align="right">'.listboxMe("code_group_kala_top",$row2['code_group_kala_top'],"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='text4'").'</td>
         <td align="left"><span class="star">*</span> واحد کالا :&nbsp;</td><td align="right">'.listboxMe("code_vahedkala",$row2['code_vahedkala'],"code_vahedkala","sharh_vahedkala","vahed_kala","","class='text4'").'</td>
         <td align="left"><span class="star">*</span> نوع بسته بندی :&nbsp;</td><td align="right">'.listboxMe("code_bastebandy",$row2['code_bastebandy'],"code_bastebandy","sharh_bastebandy","bastebandy","","class='text4'").'</td>
	     <td align="left"><span class="star">*</span> نوع کالا :&nbsp;</td><td align="right">'.static_listbox("kala_type",$row2['kala_type'],"kalatypeArr",1,"class='text4'").'</td>
	    </tr>
        <tr>		
		 <td align="left" ><span class="star">*</span> نوع محموله :&nbsp;</td><td align="right">'.static_listbox("mahmule_type",$row2['mahmule_type'],"mahmuletypeKalaArr",1,"class='text4'").'</td>
	     <td align="left"><span class="star">*</span> وضعیت در رسید :&nbsp;</td><td align="right">'.static_listbox("activate_resid",$row2['activate_resid'],"activateArr",1,"class='text4'").'(به غیر از جابه جایی)</td>
	     <td align="left"><span class="star">*</span> وضعیت در حواله :&nbsp;</td><td align="right">'.static_listbox("activate_havale",$row2['activate_havale'],"activateArr",1,"class='text4'").'</td>';
	     if($row2['code_group_kala_top']==5)//اگر گوشت
		  echo'<td align="left" class="goshtshow"><span class="star">*</span> نوع گوشت : &nbsp;</td><td align="right" class="goshtshow">'.static_listbox("gosht_type",$row2['gosht_type'],"goshttypeArr",1,"class='text4'").'</td>';	
		echo'
		</tr>
        <tr>		
		 <td align=left>ايران کد  :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="iran_code" value="'.$row2['iran_code'].'" onkeypress="return isNumber(event)"/></td>
         <td align=left>عنوان ايران کد  :&nbsp;</td><td align="right"><input class="textboxme"  type="text" name="onvan_iran_code" value="'.$row2['onvan_iran_code'].'"/></td>       
         <td align=left>کد شبنم :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="code_shabnam" value="'.$row2['code_shabnam'].'" onkeypress="return isNumber(event)"/></td>
         <td align=left>عنوان شبنم :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="onvan_shabnam" value="'.$row2['onvan_shabnam'].'"/></td>
		 <td>&nbsp;</td><td>&nbsp;</td>	
        </tr>
	    <tr>
	     <td align=left>از سريال شبنم :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="az_serial_shabnam" value="'.$row2['az_serial_shabnam'].'" onkeypress="return isNumber(event)"/></td>
	     <td align=left>تا سريال شبنم :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="ta_serial_shabnam" value="'.$row2['ta_serial_shabnam'].'" onkeypress="return isNumber(event)"/></td>
	     <td align=left>کد GS1 :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="code_gs1" value="'.$row2['code_gs1'].'" onkeypress="return isNumber(event)"/></td>
		 <td align=left>عنوان GS1 :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="onvan_gs1" value="'.$row2['onvan_gs1'].'"/></td>
         <td>&nbsp;</td><td>&nbsp;</td>			    
	    </tr>
	    <tr>
	     <td align="left">کد HS :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="code_hs" value="'.$row2['code_hs'].'" onkeypress="return isNumber(event)"/></td>
	     <td align=left>عنوان HS :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="onvan_hs" value="'.$row2['onvan_hs'].'"/></td>
		 <td align=left><span class="star">*</span> کد نرخ استاندارد :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="code_nerkh_standard" value="'.$row2['code_nerkh_standard'].'"/></td>
		 <td align=left><span class="star">*</span> نرخ استاندارد :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="nerkh_standard" value="'.$row2['nerkh_standard'].'"/></td>
		</tr>
        <tr>		
		 <td align="left" width="100px">توضيحات کالا :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tozihat_kala" value="'.$row2['tozihat_kala'].'"/></td>	    
	     <td align="left">شناسه عمومی کالا :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="general_goods_id" value="'.$row2['general_goods_id'].'"/></td>	    
	     <td align="left" width="100px">تاریخ ماندگاری :&nbsp; </td>
		 <td align="right">';
		 $mandegariarray=explode(';',$row2['mandegari']);
	     //echo var_dump($mandegariarray);
		 echo'
		   <select name="mandegarichoice[]" class="easyui-combobox" size="5" style="width:250px;" multiple >';
	       $result_tm = $db->query("SELECT * FROM tarikh_mandegari");
           while($row_tm=$db->fetch_assoc($result_tm))
		   {			   
			   IF (in_array($row_tm['code_mandegari'], $mandegariarray)) $mandegari_select='selected';
			   ELSE $mandegari_select='';
			   IF($row_tm['code_mandegari'])
			   $tm_options .= "<option value='".$row_tm['code_mandegari']."' $mandegari_select> ".$row_tm['sharh_mandegari']."  (".$row_tm['code_mandegari'].") </option>";
	       }
		   echo $tm_options;
	       echo'
	       </select>
		 </td> 
		</tr>
	    <tr>
         <td colspan="10" align="center"  class="title">
		  <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
          <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
         </td>
        </tr>
       </table>
	  </td>
     </tr>';
    }
	if ($Mode=="Search") //Search Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0"> <tr class="title"><td colspan="10" align="center">جستجوی کالا</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left">کد کالا :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="code_kala" maxlength="3" onkeypress="return isNumber(event)" style="width:50px"/></td>
		<td align="left">نام کالا  :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="name_kala"/></td>
        <td align="left">گروه کالا :&nbsp;</td><td align="right">'.listbox("code_group_kala",$code_group_kala,"code_group_kala","name_group_kala","group_kala order by name_group_kala","","class='text4'").'</td>
	    <td align="left" width="110px"> گروه کالا میانی :&nbsp;</td><td align="right">'.listbox("code_group_kala_middle",$code_group_kala_middle,"code_group_kala_middle","name_group_kala_middle","group_kala_middle order by name_group_kala_middle","","class='text4'").'</td>	   
       </tr>
	   <tr>
		<td align="left"> گروه کالای اصلی :&nbsp;</td><td align="right">'.listbox("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='text4'").'</td>
		<td align="left">واحد کالا  :&nbsp;</td><td align="right">'.listbox("code_vahedkala",$code_vahedkala,"code_vahedkala","sharh_vahedkala","vahed_kala","1=1","class='text4'").'</td>
		<td align="left">نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","","class='text4'").'</td>
	   </tr>
	   <tr>
        <td align="left">نوع محموله :&nbsp;</td><td align="right">'.static_listbox("mahmule_type",$mahmule_type,"mahmuletypeKalaArr",1,"class='text4'").'</td>
		<td align="left">وضعیت در رسید :&nbsp;</td><td align="right">
		 <select name="activate_resid" class="text4">
					          <option value="0">انتخاب کنید</option>
					          <option value="1">فعال</option>
					          <option value="2">غیرفعال</option>
					         </select>
		</td>
       	<td align="left">وضعیت در حواله :&nbsp;</td><td align="right">
				 <select name="activate_havale" class="text4">
					          <option value="0">انتخاب کنید</option>
					          <option value="1">فعال</option>
					          <option value="2">غیرفعال</option>
					         </select>
		</td>
	   </tr>
	   <tr>
        <td align=left>کد نرخ استاندارد :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="code_nerkh_standard"/></td>
     	<td align=left>نرخ استاندارد :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="nerkh_standard" /></td>
		<td align="left">توضيحات کالا :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tozihat_kala"/></td>	    
	   	<td align="left">شناسه عمومی کالا :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="general_goods_id" value="'.$general_goods_id.'"/></td>	    
	   </tr>
	   <tr>
        <td colspan="10" align="center"  class="title">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو" >
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
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