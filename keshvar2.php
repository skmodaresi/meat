<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
//error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="keshvar.php";
$TableName="keshvar";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(19)) $right_ins=1;
if (right(20)) $right_edt=1;
if (right(21)) $right_del=1;
$today=AsLDate($yymmdd);
function mojodyMojazTedad($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailkartonCondition='';
  if($c_ziranbar) $detailkartonCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailkartonCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailkartonCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailkartonCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailkartonCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailkartonCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailkartonCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(tedad_karton_aval) FROM meat.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $tedadKartonAval=$row[0];	
  $q_varede="SELECT SUM(tedad_karton_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKartonVarede=$row_varede[0]; 
  $q_sadere="SELECT SUM(tedad_karton_h_d) FROM meat.havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKartonSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(tedad_karton_tadil) FROM meat.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $kartonTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(tedad_karton_tadil) FROM meat.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar  AND year=$sal AND code_kala='$c_kala'  $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $kartonTadilKasry=$row_tadil_kasry[0];
  $tedadKarton=$tedadKartonAval+$jameKartonVarede-$jameKartonSadere+$kartonTadilEzafe-$kartonTadilKasry;
  $q_forush_detail="SELECT SUM(dad_vazn_kh) FROM sell.dm_anbar_det WHERE dad_anbar_id='$id'";
  $res_forush_detail=mysql_query($q_forush_detail);
  $row_forush_detail=mysql_fetch_array($res_forush_detail);
  $jameForukhte=$row_forush_detail[0];
  $q_ebtal_detail="SELECT SUM(deh_amount) FROM sell.dm_ebtal_hdet WHERE deh_anbar_id='$id'";
  $res_ebtal_detail=mysql_query($q_ebtal_detail);
  $row_ebtal_detail=mysql_fetch_array($res_ebtal_detail);
  $jameEbtali=$row_ebtal_detail[0];
  $q_tahvily_detail="SELECT SUM(tedad_karton_h_d) FROM meat.havale_detail WHERE id_mojody='$id' AND status=0 AND dad_id!=''";
  $res_tahvily_detail=mysql_query($q_tahvily_detail);
  $row_tahvily_detail=mysql_fetch_array($res_tahvily_detail);
  $jameTahvily=$row_tahvily_detail[0];
  $mandeForush_detail=$jameForukhte-$jameEbtali-$jameTahvily;
  $tedadMojaz=$tedadKarton-$mandeForush_detail;
  return $tedadMojaz;
}
//موجودی خالص مجاز
function mojodyMojazKhales($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailkhalesCondition='';
  if($c_ziranbar) $detailkhalesCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailkhalesCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailkhalesCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailkhalesCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailkhalesCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailkhalesCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailkhalesCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(mojody_khales_aval) FROM meat.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $mojodyKhalesAval=$row[0];	
  $q_varede="SELECT SUM(vazn_khales_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKhalesVadere=$row_varede[0]; 
  $q_sadere="SELECT SUM(vazn_khales_h_d) FROM meat.havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition  AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKhalesSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(meghdar_khales_tadil) FROM meat.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $khalesTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(meghdar_khales_tadil) FROM meat.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $khalesTadilKasry=$row_tadil_kasry[0];
  $khales=$mojodyKhalesAval+$jameKhalesVadere-$jameKhalesSadere+$khalesTadilEzafe-$khalesTadilKasry;
  $khales=round($khales,3);
  $q_forush_detail="SELECT SUM(dad_vazn_kh) FROM sell.dm_anbar_det WHERE dad_anbar_id='$id'";
  $res_forush_detail=mysql_query($q_forush_detail);
  $row_forush_detail=mysql_fetch_array($res_forush_detail);
  $jameForukhte=$row_forush_detail[0];
  $q_ebtal_detail="SELECT SUM(deh_amount) FROM sell.dm_ebtal_hdet WHERE deh_anbar_id='$id'";
  $res_ebtal_detail=mysql_query($q_ebtal_detail);
  $row_ebtal_detail=mysql_fetch_array($res_ebtal_detail);
  $jameEbtali=$row_ebtal_detail[0];
  $q_tahvily_detail="SELECT SUM(vazn_khales_h_d) FROM meat.havale_detail WHERE id_mojody='$id' AND status=0 AND dad_id!=''";
  $res_tahvily_detail=mysql_query($q_tahvily_detail);
  $row_tahvily_detail=mysql_fetch_array($res_tahvily_detail);
  $jameTahvily=$row_tahvily_detail[0];
  $mandeForush_detail=$jameForukhte-$jameEbtali-$jameTahvily;
  $khalesMojaz=$khales-$mandeForush_detail;
  $khalesMojaz=round($khalesMojaz,3);
  return $khalesMojaz;
}


$mandemojaz_khales=mojodyMojazKhales(10704,3,122,1395,1,410,1,16,1394,9,25,159);
$mandemojaz_khales=mojodyMojazTedad(11280,4,103,1395,1,406,1,251,1394,4,1,7);


echo $mandemojaz_khales.'<br>';
// $DateE=date("Ymd");
// echo $DateE.'<br/>';
// $fromDate = date("Ymd", strtotime("-3 months"));
// echo $fromDate;

//$date = date('2016-01-16');
	  // $sql_tarikh='1395/07/25';
      // $d=substr($sql_tarikh,8,2);
      // $m=substr($sql_tarikh,5,2);
      // $y=substr($sql_tarikh,0,4);
      // $milady=jalali_to_gregorian($y,$m,$d);
      // $sal=$milady[0];
      // $mah=$milady[1];
      // $rouz=$milady[2];
      // $date2_sell=$sal.'-'.$mah.'-'.$rouz;
// //$date = '2016-02-16';
// echo $date2_sell.'<br/>';
// $newdate = strtotime ( '-3 month' , strtotime ( $date2_sell ) ) ;
// $newdate = date ( 'Y-m-j' , $newdate );

// $d=substr($newdate,8,2);
// $m=substr($newdate,5,2);
// $y=substr($newdate,0,4);
         // $DateF=gregorian_to_jalali($y,$m,$d);
         // $salF=$DateF[0];$mahF=$DateF[1];$rouzF=$DateF[2];
         // $tarikh_gharardad_varedati=AsLDate($salF.$mahF.$rouzF);

// echo $tarikh_gharardad_varedati;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>کشور تولید کننده</title>
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
  $_SESSION['mt_search_keshvar']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x=""; 
 $temp="";
 if($code_keshvar)      $temp.=" and code_keshvar LIKE '%$code_keshvar%'";
 if($name_keshvar)      $temp.=" and name_keshvar LIKE '%$name_keshvar%'";
 if ($temp) {$PageNo=1;$_SESSION['mt_search_keshvar']=$temp;} else $_SESSION['mt_search_keshvar']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_keshvar']."");
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
 if (!justNumber($a))//عدد بودن کد کشور
 {
   $flag=false;
   echo"<script>alert('فيلد کد کشور نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!empty($a))//تکراری نبودن کد کشور
 { 
   $q8="SELECT code_keshvar FROM keshty WHERE code_keshvar='$a'";
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('اين کد کشور قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if(!empty($b))//تکراري نبودن نام کشور
 {
   $q9="SELECT * FROM keshty WHERE name_keshvar='$b'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام کشور قبلاً ثبت شده است !')</script>";
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
  if (!justNumber($a))//عدد بودن کد کشور
  {
   $flag=false;
   echo"<script>alert('فيلد کد کشور نامعتبر است !')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($a))//تکراری نبودن کد کشور
  { 
   $q10="SELECT * FROM keshty WHERE code_keshvar='$a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$c)){
   echo"<script>alert('اين کد کشور قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
  if(!empty($b))//تکراري نبودن نام کشور
  {
    $q11="SELECT * FROM keshty WHERE name_keshvar='$b'";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);	
    if((mysql_num_rows($res11)>0) and ($row11['id']!=$c)){
      echo"<script>alert('اين نام کشور قبلاً ثبت شده است!')</script>";
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
 if(isPermitSave($code_keshvar,$name_keshvar)) 
 {
  $Mode='';
  $name_keshvar=str_replace("ي","ی",$name_keshvar);
  $name_keshvar=str_replace("ك","ک",$name_keshvar);
  $insert_q=("INSERT INTO $TableName(code_keshvar,name_keshvar)VALUES(TRIM('$code_keshvar'),TRIM('$name_keshvar'))");
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> *مشکلی در ثبت کشور به وجود آمده است ! *</span>';  
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_keshvar,$name_keshvar,$id_))
 {
  $Mode='';
  $name_keshvar=str_replace("ي","ی",$name_keshvar);
  $name_keshvar=str_replace("ك","ک",$name_keshvar);
  $edit_q=("UPDATE $TableName SET code_keshvar=TRIM('$code_keshvar'),name_keshvar=TRIM('$name_keshvar') WHERE id='$id_';");
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
        ($code_keshvar_ NOT IN(SELECT code_keshvar FROM mojody_kala WHERE code_keshvar=$code_keshvar_ AND deleted=0))AND
		($code_keshvar_ NOT IN(SELECT code_keshvar FROM resid_detail WHERE code_keshvar=$code_keshvar_))
		($code_keshvar_ NOT IN(SELECT code_keshvar FROM resid_kala_detail WHERE code_keshvar=$code_keshvar_))
		($code_keshvar_ NOT IN(SELECT code_keshvar FROM tadil_mojody WHERE code_keshvar=$code_keshvar_ AND deleted=0))
		($code_keshvar_ NOT IN(SELECT code_keshvar FROM havale_detail WHERE code_keshvar=$code_keshvar_))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
} 
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_keshvar.focus();">
<form method="post" name="myform" id="myform" onkeydown="enterIE()">
<div align="center">
<table width="700px" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:48%;">کشور تولید کننده</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td> 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->
 <tr>
  <td height="100%">
  <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
  <table  width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="33%" title="مرتب سازی صعودی کد کشور" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_keshvar ASC&sortcode=2&show_img=1\'"/> کد کشور ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="33%" title="مرتب سازی نزولی کد کشور" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_keshvar DESC&sortcode=1&show_img=1\'"/> کد کشور ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="33%" title="مرتب سازی صعودی نام کشور" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_keshvar ASC&sortname=2&show_img=2\'"/> نام کشور '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="33%" title="مرتب سازی نزولی نام کشور" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_keshvar DESC&sortname=1&show_img=2\'"/> نام کشور '; 
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
	   <td><input type="text" class="textboxme2" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme2" name="name_keshvar" value="'.$name_keshvar.'" /></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" />
	   </td>
	  </tr>';
	}
	$i=0;
	$q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mt_search_keshvar']." order by $order $Limit ";
	$allKeshvar = $db->query($q1);
    while($row1=$db->fetch_assoc($allKeshvar))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	   $exist_mojody=$db->get_from_where("count(code_keshvar)","mojody_kala","code_keshvar=".$row1['code_keshvar']."");
	   $exist_resid_detail=$db->get_from_where("count(code_keshvar)","resid_detail","code_keshvar=".$row1['code_keshvar']."");
	   $exist_resid_kala_detail=$db->get_from_where("count(code_keshvar)","resid_kala_detail","code_keshvar=".$row1['code_keshvar']."");
	   $exist_havale_detail=$db->get_from_where("count(code_keshvar)","havale_detail","code_keshvar=".$row1['code_keshvar']."");
	   $exist_tadil=$db->get_from_where("count(code_keshvar)","tadil_mojody","code_keshvar=".$row1['code_keshvar']." AND deleted=0");
	  if(($exist_mojody)or($exist_resid_detail)or($exist_havale_detail)or($exist_resid_kala_detail)or($exist_tadil)) echo'<td><input type="text" class="textboxme2" title="غیر قابل تغییر" name="code_keshvar" readonly value="'.$row1['code_keshvar'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
      else echo'<td><input type="text" class="textboxme2" name="code_keshvar" value="'.$row1['code_keshvar'].'" maxlength="5" onkeypress="return isNumber(event)" style="width:50px"/></td>';
	  echo'
	  <td><input type="text" class="textboxme2" name="name_keshvar" value="'.$row1['name_keshvar'].'"/></td>
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات"/>
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['code_keshvar'].'</td>
	  <td '.$edtClick.'>'.$row1['name_keshvar'].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_keshvar_='.$row1['code_keshvar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف کشتی  '.$row1['name_keshvar'].' \')"/></td>';
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
	  <td>&nbsp;</td>';
	  if($right_del) echo'<td>&nbsp;</td>';
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
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
	 <td width="24"><div onClick="window.open(\'print_keshvar.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
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
     if ($_SESSION['mt_search_keshvar']) 
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
</div>
'.$message .'
</form>
</body>
</html>';	
?>