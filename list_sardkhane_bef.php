<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="list_sardkhane.php";
$TableName="list_sardkhane";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;$right_detail=0;
if (right(11)) $right_ins=1;
if (right(12)) $right_edt=1;
if (right(13)) $right_del=1;
if (right(14)) $right_detail=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>سردخانه ها</title>
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
  $_SESSION['mt_search_li_sardkhane']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x="";
 $temp=""; 
 if($code_anbar)         $temp.=" and code_anbar LIKE '%$code_anbar%'";
 if($shenase_meli_anbar) $temp.=" and shenase_meli_anbar LIKE '%$shenase_meli_anbar%'";
 if($name_anbar)         $temp.=" and name_anbar LIKE '%$name_anbar%'";
 if($code_ostan)         $temp.=" and code_ostan LIKE '$code_ostan'";
 if($noe_malekiyat)      $temp.=" and noe_malekiyat LIKE '$noe_malekiyat'";
 if($status_peymankar)   $temp.=" and status_peymankar LIKE '$status_peymankar'";
 if($shenase_peymankar)  $temp.=" and shenase_peymankar LIKE '%$shenase_peymankar%'";
 if($name_peymankar)     $temp.=" and name_peymankar LIKE '%$name_peymankar%'";
 if($address_anbar)      $temp.=" and address_anbar LIKE '%$address_anbar%'";
 if ($temp){$PageNo=1;$_SESSION['mt_search_li_sardkhane']=$temp;} else $_SESSION['mt_search_li_sardkhane']="";
 }
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_li_sardkhane']." AND location_type=2");
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
function isPermitSave($a,$b,$c,$d,$l_type,$status_p)
{
 $flag=false;
 if(!($a and $b and $c and $d and $l_type and $status_p))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
 } 
 else $flag=true;
 if ((!justNumber($a)) or ($a<100) or ($a>300))//صحت کد انبار
 {
   $flag=false;
   echo"<script>alert('فیلد کد انبار نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if(!empty($a))//تکراری نبودن کد انبار برای هر استان
 { 
    $code_a=make_pattern($a,3); 
    $q8="SELECT code_anbar FROM list_sardkhane WHERE code_anbar='$code_a' AND code_ostan='$d'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين کد انبار قبلاً برای این استان ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
 if (!justNumber($b))//عدد بودن شناسه ملی انبار
 {
   $flag=false;
   echo"<script>alert('فیلد شناسه ملی انبار نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!empty($c))//تکراري نبودن نام انبار
 {
   $q9="SELECT * FROM list_sardkhane WHERE name_anbar='$c' AND code_ostan='$d'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('این نام انبار قبلاً برای این استان ثبت شده است !')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$c,$d,$l_type,$status_p,$f)
{
  $flag=false;
  if(!($a and $b and $c and $d and $l_type and $status_p))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
  } 
  else $flag=true;
  if ((!justNumber($a)) or ($a<100) or ($a>300))//صحت کد انبار
  {
   $flag=false;
   echo"<script>alert('فیلد کد انبار نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($a))//تکراری نبودن کد انبار برای هر استان
  { 
   $code_a=make_pattern($a,3); 
   $q10="SELECT * FROM list_sardkhane WHERE code_anbar='$code_a' AND code_ostan='$d'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$f)){
   echo"<script>alert('اين کد انبار قبلاً برای این استان ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
  if (!justNumber($b))//عدد بودن شناسه ملی انبار
  {
   $flag=false;
   echo"<script>alert('فیلد شناسه ملی انبار نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;  
  if(!empty($c))//تکراري نبودن نام انبار
  {
    $q11="SELECT * FROM list_sardkhane WHERE name_anbar='$c' AND code_ostan='$d'";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);
    if((mysql_num_rows($res11)>0) and ($row11['id']!=$f)){
      echo"<script>alert('این نام انبار قبلاً برای این استان ثبت شده است !')</script>";
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
 if(isPermitSave($code_anbar,$shenase_meli_anbar,$name_anbar,$code_ostan,$location_type,$status_peymankar))
 {
   $Mode='';
   if ($chkforush=='on') $chkforush=1; else $chkforush=0;
   //if($status_peymankar){$_SESSION['mt_status_peymankar']=$status_peymankar;}
   $insert_q=("INSERT INTO $TableName(code_anbar,shenase_meli_anbar,name_anbar,code_ostan,noe_malekiyat,location_type,status_peymankar,chkforush,address_anbar)
              VALUES('$code_anbar',TRIM('$shenase_meli_anbar'),TRIM('$name_anbar'),'$code_ostan','$noe_malekiyat','$location_type','$status_peymankar','$chkforush',TRIM('$address_anbar'))");
   $insert_res=mysql_query($insert_q);
   if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
   }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت انبار به وجود آمده است ! *</span>';
 }
}    
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_anbar,$shenase_meli_anbar,$name_anbar,$code_ostan,$location_type,$status_peymankar,$id_))
 {
  $Mode='';
  if ($chkforush=='on') {$chkforush=1;$_SESSION['mt_systemforush']=1;} 
  else {$chkforush=0;$_SESSION['mt_systemforush']=0;}
  if($status_peymankar){$_SESSION['mt_status_peymankar']=$status_peymankar;}
  $edit_q=("UPDATE $TableName SET code_anbar='$code_anbar',shenase_meli_anbar=TRIM('$shenase_meli_anbar'),name_anbar=TRIM('$name_anbar'),
            code_ostan='$code_ostan',noe_malekiyat='$noe_malekiyat',location_type='$location_type',status_peymankar='$status_peymankar',
			chkforush='$chkforush',address_anbar=TRIM('$address_anbar') WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/    
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود امده است ! *</span>';
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode=''; 
 $del_q="DELETE FROM $TableName WHERE id=$id_ AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM mojody_kala WHERE code_anbar=$code_anbar_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM resid WHERE code_anbar=$code_anbar_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM havale WHERE code_anbar=$code_anbar_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM havale_forush WHERE code_anbar=$code_anbar_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM ebtal WHERE code_anbar=$code_anbar_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM tadil_mojody WHERE code_anbar=$code_anbar_ AND deleted=0))";
 $del_res=$db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_anbar.focus();">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="99%" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">سردخانه ها</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td> 	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden; ">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order)) $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($sortostan)) $sortostan='1';
if(!isset($show_img)) $show_img='';
	 if($sortcode=='1')
	 {echo'<td width="7%" title="مرتب سازی صعودی کد انبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_anbar ASC&sortcode=2&show_img=1\'"/> کد انبار ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {echo'<td width="7%" title="مرتب سازی نزولی کد انبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_anbar DESC&sortcode=1&show_img=1\'"/> کد انبار ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 echo'<td width="10%">شناسه ملی انبار</td>';
	 if($sortname=='1')
	 {echo'<td width="15%" title="مرتب سازی صعودی نام انبار" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_anbar ASC&sortname=2&show_img=2\'"/> نام انبار '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {echo'<td width="15%" title="مرتب سازی نزولی نام انبار" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_anbar DESC&sortname=1&show_img=2\'"/> نام انبار '; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortostan=='1')
	 {echo'<td width="15%" title="مرتب سازی صعودی استان انبار" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameOstan ASC&sortostan=2&show_img=3\'"/> استان انبار'; 
	   if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortostan=='2')
	 {echo'<td width="15%" title="مرتب سازی نزولی استان انبار" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameOstan DESC&sortostan=1&show_img=3\'"/> استان انبار '; 
	   if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	echo'
	 <td width="8%">نوع مالکیت</td>
	 <td width="8%">وضعیت پیمانکار</td>
	 <td width="10%">نام پیمانکار</td>
	 <td width="12%">اتصال به سیستم فروش</td>
	 <td width="10%">جزئیات</td>';
	 if($right_del) echo'<td width="5%">حذف</td>';
	 echo'
	</tr>';
	$i=0;
    $q1="SELECT *,
     (SELECT COUNT(*) FROM list_sardkhane_detail l_s_d WHERE l_s_d.code_ostan=T.code_ostan AND l_s_d.code_anbar=T.code_anbar) detailcount,
	 (SELECT name_ostan FROM ostan WHERE ostan.code_ostan=T.code_ostan) nameOstan
	 From $TableName T WHERE 1=1 ".$_SESSION['mt_search_li_sardkhane']." AND location_type=2 order by $order $Limit ";
	$allAnbar = $db->query($q1);
    while($row1=$db->fetch_assoc($allAnbar))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($row1['chkforush'] == 1) $checked = 'checked = "checked"';
     else $checked = '';
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';   
     echo'
	  <td '.$edtClick.'>'.$row1['code_anbar'].'</td>
	  <td '.$edtClick.'>'.$row1['shenase_meli_anbar'].'</td>
	  <td '.$edtClick.'>'.$row1['name_anbar'].'</td>
	  <td '.$edtClick.'>'.$row1['nameOstan'].'</td>
	  <td '.$edtClick.'>'.$noe_malekiyatArr[$row1['noe_malekiyat']].'</td>
	  <td '.$edtClick.'>'.$status_peymankarArr[$row1['status_peymankar']].'</td>
	  <td '.$edtClick.'>'.$row1['name_peymankar'].'</td>
	    <!--<td '.$edtClick.'><input type="checkbox" '.$checked.'/></td>-->
	  <td '.$edtClick.'>';if($row1['chkforush'] == 1)echo '<img src="images/ok2.png" />';else echo '<img src="images/dont.png" />'; echo'</td>
	  <td>';
	   if($right_detail) {echo'<input type="button" class="buttonme"  value="جزئيات['.$row1['detailcount'].']" onClick="window.location=\'list_sardkhane_detail.php?PageNo='.$PageNo.'&code_anbar_='.$row1['code_anbar'].'&code_ostan_='.$row1['code_ostan'].'\'">';}
      echo'
	  </td>';
	  if($right_del)
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_anbar_='.$row1['code_anbar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف '.$row1['name_anbar'].' \')" /></td>';
	  }	 
	echo'
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
	  <td>&nbsp;</td>';
	  if($right_del)echo'<td>&nbsp;</td>';
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
	 <td width="24"><div onClick="window.open(\'print_list_sardkhane.php\',\'\',\'scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
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
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_li_sardkhane']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>		 
	</tr>';
    }
	if ($Mode=="Insert")  //Insert Mode
    {echo '
    <tr> 
	 <td> 	 
	  <table border="0" bgcolor="#E9F7FD" align="center" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px">
       <tr class="title"><td colspan="10" align="center">ايجاد سردخانه جدید</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left"><span style="color:red">*</span> کد انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_anbar" value="'.$code_anbar.'"  maxlength="3" title="برای کد انبار سه رقم وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/><span> عددی بین 100 تا 300</span></td>
	    <td align="left"><span style="color:red">*</span> شناسه ملی انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_meli_anbar" value="'.$shenase_meli_anbar.'" onkeypress="return isNumber(event)"/></td>
	    <td align="left"><span style="color:red">*</span> نام انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_anbar" value="'.$name_anbar.'" ></td>
        <td align="left"><span style="color:red">*</span> نام استان : &nbsp;</td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
       </tr>
	   	<td align="left">نوع مالکیت : &nbsp;</td><td align="right">'.static_listbox("noe_malekiyat",$noe_malekiyat,"noe_malekiyatArr",1,"class='text4'").'</td>';  
	   	$location_type_default=2;//سردخانه
		echo'
		<td align="left"><span style="color:red">*</span> نوع انبار : &nbsp;</td><td align="right">'.static_listbox("location_type",$location_type_default,"locationtypeArr",1,"class='text4'").'</td>  
       <tr>
        <td align="left"><span style="color:red">*</span> وضعیت پیمانکار : &nbsp;</td><td align="right">'.static_listbox("status_peymankar",$status_peymankar,"status_peymankarArr",1,"class='text4'").'</td>
	    <td align="left">شناسه پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_peymankar" value="'.$shenase_peymankar.'"/></td>
	    <td align="left">نام پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="name_peymankar" value="'.$name_peymankar.'"/></td>
       </tr>
	   <tr>
	    <td align="left" colspan="2">آیا اطلاعات از سیستم فروش وارد شود؟ : &nbsp;</td><td align="right"><input type="checkbox" name="chkforush"/></td>
	    <td>&nbsp;</td>
		<td align="left">آدرس انبار : &nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme" name="address_anbar" value="'.$address_anbar.'" /></td>		    
	   </tr>
	   <tr>
        <td colspan="8" align="center">
		 <input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ايجاد">
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
	     (SELECT count(code_anbar) FROM mojody_kala m_k WHERE m_k.code_anbar=T.code_anbar AND m_k.code_ostan=T.code_ostan AND m_k.deleted=0) exist_mojody,
	     (SELECT count(code_anbar) FROM resid r WHERE r.code_anbar=T.code_anbar AND r.code_ostan=T.code_ostan AND r.deleted=0) exist_resid,
	     (SELECT count(code_anbar) FROM havale_forush h_f WHERE h_f.code_anbar=T.code_anbar AND h_f.code_ostan=T.code_ostan AND h_f.deleted=0) exist_havale_forush,
	     (SELECT count(code_anbar) FROM havale h WHERE h.code_anbar=T.code_anbar AND h.code_ostan=T.code_ostan AND h.deleted=0) exist_havale,
	     (SELECT count(code_anbar) FROM ebtal e WHERE e.code_anbar=T.code_anbar AND e.code_ostan=T.code_ostan AND e.deleted=0) exist_ebtal,
	     (SELECT count(code_anbar) FROM tadil_mojody t_m WHERE t_m.code_anbar=T.code_anbar AND t_m.code_ostan=T.code_ostan AND t_m.deleted=0) exist_tadil
	      FROM $TableName T WHERE id='$id_'";
	 $res2=$db->query($q2);
	 $row2=$db->fetch_assoc($res2);
	 if($row2['chkforush'] == 1) $checked = 'checked = "checked"';
     else $checked = '';
	 echo'
     <tr> 
	  <td> 	 
	   <table border="0" bgcolor="#E9F7FD" align="center" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px">
        <tr class="title"><td colspan="10" align="center">ويرايش '.$row2['name_anbar'].'</td></tr>
        <tr><td>&nbsp;</td></tr>	   
	    <tr>';
	    if(($row2['exist_mojody'])or($row2['exist_resid'])or($row2['exist_havale_forush'])or($row2['exist_havale'])or($row2['exist_ebtal'])or($row2['exist_tadil']))
		{echo'<td align="left"><span style="color:red">*</span> کد انبار  :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_anbar" readonly value="'.$row2['code_anbar'].'" title="غیر قابل تغییر" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';}
	    else echo'<td align="left"><span style="color:red">*</span> کد انبار  :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_anbar" value="'.$row2['code_anbar'].'" maxlength="3" title="برای کد انبار سه رقم وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/><span> عددی بین 100 تا 300</span></td>';
		echo'
		 <td align="left"><span style="color:red">*</span> شناسه ملی انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_meli_anbar" value="'.$row2['shenase_meli_anbar'].'" onkeypress="return isNumber(event)"/></td>
	     <td align="left"><span style="color:red">*</span> نام انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_anbar" value="'.$row2['name_anbar'].'"/></td>
	     <td align="left"><span style="color:red">*</span> نام استان : &nbsp;</td><td align="right">'.listboxMe("code_ostan",$row2['code_ostan'],"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
		</tr>
		 <td align="left">نوع مالکیت : &nbsp;</td><td align="right">'.static_listbox("noe_malekiyat",$row2['noe_malekiyat'],"noe_malekiyatArr",1,"class='text4'").'</td>
	     <td align="left"><span style="color:red">*</span> نوع انبار : &nbsp;</td><td align="right">'.static_listbox("location_type",$row2['location_type'],"locationtypeArr",1,"class='text4'").'</td>  
        <tr>
	     <td align="left"><span style="color:red">*</span> وضعیت پیمانکار : &nbsp;</td><td align="right">'.static_listbox("status_peymankar",$row2['status_peymankar'],"status_peymankarArr",1,"class='text4'").'</td>
	     <td align="left">شناسه پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_peymankar" value="'.$row2['shenase_peymankar'].'"/></td>
	     <td align="left">نام پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="name_peymankar" value="'.$row2['name_peymankar'].'"/></td>	    
        </tr>
	    <tr>
		 <td align="left" colspan="2">آیا اطلاعات از سیستم فروش وارد شود؟ : &nbsp;</td><td align="right"><input type="checkbox" name="chkforush" '.$checked.'/></td>
	     <td>&nbsp;</td>
		 <td align="left">آدرس انبار : &nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme" name="address_anbar" value="'.$row2['address_anbar'].'" ></td>			    
	    </tr>
	    <tr>
         <td colspan="8" align="center">
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
	 <td> 	 
	  <table border="0" bgcolor="#E9F7FD" align="center" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px">
       <tr class="title"><td colspan="10" align="center">جستجوی سردخانه</td></tr>
       <tr><td>&nbsp;</td></tr>	   
       <tr>
	    <td align="left"> کد انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_anbar" value="'.$code_anbar.'"  maxlength="3" title="برای کد انبار سه رقم وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/><span> عددی بین 100 تا 300</span</td>
	    <td align="left"> شناسه ملی انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_meli_anbar" value="'.$shenase_meli_anbar.'" onkeypress="return isNumber(event)"/></td>
	    <td align="left"> نام انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_anbar" value="'.$name_anbar.'" ></td>
        <td align="left"> نام استان : &nbsp;</td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
       </tr>
       <tr>
	    <td align="left">نوع مالکیت : &nbsp;</td><td align="right">
		                             <select name="noe_malekiyat" class="text4">
	                                  <option value="0">انتخاب کنید</option>
	                                  <option value="1">ملکی</option>
	                                  <option value="2">استیجاری</option>
	                                  <option value="3">امانی</option>
	                                  <option value="4">مرکز خرید</option>
									 </select></td>  
        <td align="left">وضعیت پیمانکار : &nbsp;</td><td align="right">'.static_listbox("status_peymankar",$status_peymankar,"status_peymankarArr",1,"class='text4'").'</td>
	    <td align="left">شناسه پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_peymankar" value="'.$shenase_peymankar.'"/></td>
	    <td align="left">نام پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="name_peymankar" value="'.$name_peymankar.'"/></td>
       </tr>
	   <tr>
	    <td align="left">آدرس انبار : &nbsp;</td><td align="right"  colspan="2"><input type="text" class="textboxme" name="address_anbar" value="'.$address_anbar.'" /></td>  			    
	   </tr>
	   <tr>
        <td colspan="8" align="center">
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