<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="ostan.php";
$TableName="ostan";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;$right_shahr=0;
if (right(3)) $right_ins=1;
if (right(4)) $right_edt=1;
if (right(5)) $right_del=1; 
if (right(6)) $right_shahr=1;
function mojodyMojazShane($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailShaneCondition='';
  if($c_ziranbar)     $detailShaneCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar)      $detailShaneCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailShaneCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid)      $detailShaneCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid)      $detailShaneCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid)     $detailShaneCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton)       $detailShaneCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(tedad_shane_aval) FROM meat.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $tedadShaneAval=$row[0];	
  $q_varede="SELECT SUM(tedad_shane_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameShaneVarede=$row_varede[0]; 
  $q_sadere="SELECT SUM(tedad_shane_h_d) FROM meat.havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameShaneSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(tedad_shane_tadil) FROM meat.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $ShaneTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(tedad_shane_tadil) FROM meat.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar  AND year=$sal AND code_kala='$c_kala'  $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $ShaneTadilKasry=$row_tadil_kasry[0];
  $tedadShane=$tedadShaneAval+$jameShaneVarede-$jameShaneSadere+$ShaneTadilEzafe-$ShaneTadilKasry;
  $q_forush_detail="SELECT SUM(dad_tedad_khanbar) FROM sell.dm_anbar_det WHERE dad_anbar_id='$id'";
  $res_forush_detail=mysql_query($q_forush_detail);
  $row_forush_detail=mysql_fetch_array($res_forush_detail);
  $jameForukhte=$row_forush_detail[0];
  $q_ebtal_detail="SELECT SUM(deh_amount) FROM sell.dm_ebtal_hdet WHERE deh_anbar_id='$id'";
  $res_ebtal_detail=mysql_query($q_ebtal_detail);
  $row_ebtal_detail=mysql_fetch_array($res_ebtal_detail);
  $jameEbtali=$row_ebtal_detail[0];
  $q_tahvily_detail="SELECT SUM(tedad_shane_h_d) FROM meat.havale_detail WHERE id_mojody='$id' AND status=0 AND dad_id!=''";
  $res_tahvily_detail=mysql_query($q_tahvily_detail);
  $row_tahvily_detail=mysql_fetch_array($res_tahvily_detail);
  $jameTahvily=$row_tahvily_detail[0];
  $mandeForush_detail=$jameForukhte-$jameEbtali-$jameTahvily;
  $shaneMojaz=$tedadShane-$mandeForush_detail;
  return $shaneMojaz;
}
//$r=mojodyMojazShane('99076','4','103','1396','1','50','4','362','1396','02','09','196');
echo mojodyMojazShane('99022','4','103','1396','1','50','3','356','1396','11','12','196');

// $val = 121444.05447;
// function splitter($val)
// {
  // $str = (string) $val ;
  // $splitted = explode(".",$str);
  // $whole = (integer)$splitted[0] ;
  // $dec = $splitted[1];
  // $dec =round($dec,3);
  // $whole=virgul($whole);
  // $num=$whole.'.'.$dec;
  // return $num;
// }

      	 // //تبدیل تاریخ میلاد
	     // $sql_tarikh='1395/10/15';
         // $d=substr($sql_tarikh,8,2);
         // $m=substr($sql_tarikh,5,2);
         // $y=substr($sql_tarikh,0,4);
         // $milady=jalali_to_gregorian($y,$m,$d);
         // $sal=$milady[0];
         // $mah=$milady[1];
         // $rouz=$milady[2];
         // $tarikh_forush=$sal.'-'.$mah.'-'.$rouz;
      	 // //تبدیل تاریخ میلاد
	     // $sql_tarikh2='1395/03/11';
         // $d=substr($sql_tarikh2,8,2);
         // $m=substr($sql_tarikh2,5,2);
         // $y=substr($sql_tarikh2,0,4);
         // $milady=jalali_to_gregorian($y,$m,$d);
         // $sal=$milady[0];
         // $mah=$milady[1];
         // $rouz=$milady[2];
         // $tarikh_forush2=$sal.'-'.$mah.'-'.$rouz;



 // $date1 = new DateTime($tarikh_forush);
 // $date2 = new DateTime($tarikh_forush2);

// $date1 = new DateTime("2017-03-21");
// $date2 = new DateTime("2016-05-18");
// $diff = $date1->diff($date2);
 // echo "difference " . $diff->y . " years, " . $diff->m." months, ".$diff->d." days ";




// $datetime1 = new DateTime($tarikh_forush);
// $datetime2 = new DateTime($tarikh_forush2);
// $interval = $datetime1->diff($datetime2);
//echo $interval->format('%y سال %m ماه and %d روز');

// $datetime1 = new DateTime('2 Jan 2008');
// $datetime2 = new DateTime('5 July 2012');
// $interval = $datetime1->diff($datetime2);

 //echo $interval->format('%y years %m months and %d days');




//print_r(splitter($val));

//echo number_format($r,3,'.',',');

// echo $_SESSION['mtActiveYear'].'<br/>';
// echo $_SESSION['mtStatusYear'].'<br/>';
// echo $_SESSION['mtstart_date_sh'].'<br/>';
//echo  date('H:i');

 //echo $_SESSION['mt_webservice'];
 	$IssuedDate=date("Y-m-d");

// echo $IssuedDate;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>استان ها</title>
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
  $_SESSION['mt_search_ostan']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x="";
 $temp=""; 
 if($code_ostan) $temp.=" and code_ostan LIKE '%$code_ostan%'";
 if($name_ostan) $temp.=" and name_ostan LIKE '%$name_ostan%'";
 if ($temp) {$PageNo=1;$_SESSION['mt_search_ostan']=$temp;} else $_SESSION['mt_search_ostan']="";
 }
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_ostan']."");
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
function isPermitSave($a,$b)
{
 $flag=false;
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 }
 else $flag=true; 
 if((!justNumber($a)) or (strlen($a)>2))//صحت کد استان
 {
   $flag=false;
   echo"<script>alert('فيلد کد استان نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if(!empty($a))//تکراری نبودن کد استان
 { 
    //$code_a=make_pattern($a,2); 
    $q8="SELECT code_ostan FROM ostan WHERE code_ostan='$a'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين کد استان قبلاً ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;  
 if(!empty($b))//تکراري نبودن نام استان
 {
   $q9="SELECT * FROM ostan WHERE name_ostan='$b'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام استان قبلا ثبت شده است')</script>";
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
  if((!justNumber($a)) or (strlen($a)>2))//صحت کد استان
  {
   $flag=false;
   echo"<script>alert('فيلد کد استان نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($a))//تکراری نبودن کد استان
  { 
   //$code_a=make_pattern($a,2); 
   $q10="SELECT * FROM ostan WHERE code_ostan='$a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$c)){
   echo"<script>alert('اين کد استان قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;  
  if(!empty($b))//تکراري نبودن نام استان
  {
    $q11="SELECT * FROM ostan WHERE name_ostan='$b'";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);
    if((mysql_num_rows($res11)>0) and ($row11['id']!=$c)){
      echo"<script>alert('اين نام استان قبلا ثبت شده است')</script>";
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
 if(isPermitSave($code_ostan,$name_ostan))
 {
   $Mode='';
   $name_ostan=str_replace("ي","ی",$name_ostan);
   $name_ostan=str_replace("ك","ک",$name_ostan);
   //$code_ostan=make_pattern($code_ostan,2);
   $insert_q=("INSERT INTO $TableName(code_ostan,name_ostan)VALUES('$code_ostan',TRIM('$name_ostan'))");
   $insert_res=mysql_query($insert_q);
   if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
   }
   else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت استان به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_ostan,$name_ostan,$id_))
 {
  $Mode='';
  $name_ostan=str_replace("ي","ی",$name_ostan);
  $name_ostan=str_replace("ك","ک",$name_ostan);
  $edit_q=("UPDATE $TableName SET code_ostan='$code_ostan',name_ostan=TRIM('$name_ostan') WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");    
  else if(mysql_affected_rows==0) $message='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>'; 
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id=$id_ AND
        ($code_ostan_ NOT IN(SELECT code_ostan FROM shahrestan WHERE code_ostan=$code_ostan_))AND
        ($code_ostan_ NOT IN(SELECT code_ostan FROM list_sardkhane WHERE code_ostan=$code_ostan_))AND
        ($code_ostan_ NOT IN(SELECT code_ostan FROM users WHERE code_ostan=$code_ostan_))AND
        ($code_ostan_ NOT IN(SELECT code_ostan FROM mojody_kala WHERE code_ostan=$code_ostan_ AND deleted=0))AND
        ($code_ostan_ NOT IN(SELECT code_ostan FROM resid WHERE code_ostan=$code_ostan_ AND deleted=0))AND
        ($code_ostan_ NOT IN(SELECT code_ostan FROM havale WHERE code_ostan=$code_ostan_ AND deleted=0))AND
        ($code_ostan_ NOT IN(SELECT code_ostan FROM havale_forush WHERE code_ostan=$code_ostan_ AND deleted=0))AND
        ($code_ostan_ NOT IN(SELECT code_ostan FROM ebtal WHERE code_ostan=$code_ostan_ AND deleted=0))AND
        ($code_ostan_ NOT IN(SELECT code_ostan FROM tadil_mojody WHERE code_ostan=$code_ostan_ AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_ostan.focus();">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="700px" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">استان ها</div> 
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
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی کد استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan ASC&sortcode=2&show_img=1\'"/> کد استان ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی کد استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan DESC&sortcode=1&show_img=1\'"/> کد استان ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="35%" title="مرتب سازی صعودی نام استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_ostan ASC&sortname=2&show_img=2\'"/> نام استان '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="35%" title="مرتب سازی نزولی نام استان" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_ostan DESC&sortname=1&show_img=2\'"/> نام استان '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'	 
	<td width="25%">شهرستانها</td>';
	if(($right_del)and($Mode==NULL)) echo'<td width="20%">حذف</td>';
    else if($Mode!=NULL) echo'<td width="20%">دستورات</td>';	
	echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ثبت"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme2" name="code_ostan" value="'.$code_ostan.'" maxlength="2" onkeypress="return isNumber(event)"/></td>
	   <td><input type="text" class="textboxme2" name="name_ostan" value="'.$name_ostan.'"></td>';
	   echo'
	   <td colspan="2">
	       <input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT *,(SELECT count(*) FROM shahrestan as sh WHERE sh.code_ostan=T.code_ostan) shahrCount,
	    (SELECT count(code_ostan) FROM list_sardkhane as l_a WHERE l_a.code_ostan=T.code_ostan) exist_list_sardkhane,
	    (SELECT count(code_ostan) FROM users as u WHERE u.code_ostan=T.code_ostan) exist_users,
	    (SELECT count(code_ostan) FROM mojody_kala as m_k WHERE m_k.code_ostan=T.code_ostan AND m_k.deleted=0) exist_mojody,
	    (SELECT count(code_ostan) FROM resid as r WHERE r.code_ostan=T.code_ostan AND r.deleted=0) exist_resid,
	    (SELECT count(code_ostan) FROM havale_forush as h_f WHERE h_f.code_ostan=T.code_ostan AND h_f.deleted=0) exist_havale_forush,
	    (SELECT count(code_ostan) FROM havale as h WHERE h.code_ostan=T.code_ostan AND h.deleted=0) exist_havale,
	    (SELECT count(code_ostan) FROM ebtal as e WHERE e.code_ostan=T.code_ostan AND e.deleted=0) exist_ebtal,
	    (SELECT count(code_ostan) FROM tadil_mojody as t_m WHERE t_m.code_ostan=T.code_ostan AND t_m.deleted=0) exist_tadil
	     From $TableName T WHERE 1=1 ".$_SESSION['mt_search_ostan']." order by $order $Limit";
	$allOstan = $db->query($q1);
    while($row1=$db->fetch_assoc($allOstan))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  if(($row1['shahrCount'])or($row1['exist_list_sardkhane'])or($row1['exist_users'])or($row1['exist_mojody'])or($row1['exist_resid'])or($row1['exist_havale_forush'])or($row1['exist_havale'])or($row1['exist_ebtal'])or($row1['exist_tadil']))echo '<td><input type="text" class="textboxme2" title="غیر قابل تغییر" name="code_ostan" readonly value="'.$row1['code_ostan'].'" style="cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
	  else echo'<td><input type="text" class="textboxme2" name="code_ostan" value="'.$row1['code_ostan'].'" maxlength="2" title="برای کد استان دو رقم وارد نمایید" onkeypress="return isNumber(event)"/></td>';
	  echo'<td><input type="text" class="textboxme2" name="name_ostan" value="'.$row1['name_ostan'].'" style:width:100%></td>
	  <td colspan="2">
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {
	  echo'
	  <td '.$edtClick.'>'.$row1['code_ostan'].'</td>
	  <td '.$edtClick.'>'.$row1["name_ostan"].'</td>
	  <td>';
	  if($right_shahr) echo'<input type="button" class="button-inline" value="شهرستان ها ['.$row1['shahrCount'].']" onClick="window.location=\'shahrestan.php?PageNo='.$PageNo.'&codeOstan_='.$row1['code_ostan'].'\'">';	  
	  echo'
	  </td>';
	  if($right_del)
	  {echo'
	    <td><img border="0" src="images/trash.png" width="20" height="20" title="حذف" 
	  	   onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_ostan_='.$row1['code_ostan'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف استان '.$row1['name_ostan'].' \')" /></td>';
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
	 <td width="24"><div onClick="window.open(\'print_ostan.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
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
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()"  onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_ostan']) 
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
'.$message.'
</form>
</body>
</html>';	
?>