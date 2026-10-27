<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="ebtal.php";
if($_SESSION['mt_systemforush']==0)
{
 $TableName="ebtal";
 $right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;
 if (right(107)) $right_ins=1;
 if (right(108)) $right_edt=1;
 if (right(109)) $right_del=1;
 if (right(110)) $right_prt=1;
}//اطلاعات ابطال از سیستم انبار
if($_SESSION['mt_systemforush']==1)//اطلاعات ابطال از سیستم فروش
{
 mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
 $TableName="dm_ebtal_h";
 //پیدا کردن آی دی کد استان مربوط به سیتم فروش
  $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
  $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
 //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
  $res_anbar=mysql_query("SELECT l_id FROM dm_location_goods WHERE l_code='$mt_gl_code_anbar'");
  $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
 //پیدا کردن آی دی سال مربوط به سیستم فروش
  $sellYearCode=substr($mtActiveYear,2);
  $res_sal=mysql_query("SELECT year_id FROM dm_year WHERE year_code='$sellYearCode'");
  $sellYearId=mysql_result($res_sal, 0, 'year_id');
}
$logtime=date('H:i:s'); 
if($_SESSION['mt_systemforush']==0)//ایجاد شماره برگه ابطال در سیستم انبار
{
 $q2="SELECT shomare_barge_ebtal FROM $TableName WHERE code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'
      order by shomare_barge_ebtal DESC LIMIT 0,1";
 $res2=$db->query($q2);
 $row2=$db->fetch_assoc($res2);
 $w=$row2['shomare_barge_ebtal'];
 if($w) {$shomare_barge_ebtal=$w; $shomare_barge_ebtal++;}
 else $shomare_barge_ebtal=1;
 $shomare_barge_ebtal=make_pattern($shomare_barge_ebtal,5);
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>ابطال مقادیر حواله فروش</title>
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
		showButtonPanel: true
    });
 });
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
   window.event.keyCode = 9;
}
function getDetailForush2(s_h_f)<!-- اطلاعات حواله فروش-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{shomareHAVALEFORUSH2: s_h_f},function(data){
		   var splForush = data.split("^");
		   $("#h_reg_date").val(splForush[0]);		   		   
		   $("#code_customer").val(splForush[1]);
		   $("#code_kala").val(splForush[2]);
		   $("#meghdar_havale_forush").val(splForush[3]);
		   $("#meghdar_tahvily").val(splForush[4]);
		   <!--$("#meghdar_batele").val(splForush[5]);-->
		   $("#mande_az_forush").val(splForush[6]);
		   $("#idForush").val(splForush[7]);
		 });
   $("#loading").fadeOut("fast");	
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['search_ebtal']="";
} 
if(isset($Search_x))
{
 if($_SESSION['mt_systemforush']==0)//سیستم انبار
 {
  $Mode='';
  $Search_x=""; 
  $temp="";
  if($shomare_barge_ebtal_srch) $temp.=" and shomare_barge_ebtal  LIKE '%$shomare_barge_ebtal_srch%'";
  if($tarikh_barge_ebtal)       $temp.=" and tarikh_barge_ebtal LIKE '%$tarikh_barge_ebtal%'";
  if($shomare_mojavez_ebtal)    $temp.=" and shomare_mojavez_ebtal LIKE '%$shomare_mojavez_ebtal%'";
  if($h_code)                   $temp.=" and h_code LIKE '%$h_code%'";
  if($meghdar_batele)           $temp.=" and meghdar_batele LIKE '%$meghdar_batele%'";
  if($temp) {$PageNo=1;$_SESSION['search_ebtal']=$temp;} else $_SESSION['search_ebtal']="";
 }
 if($_SESSION['mt_systemforush']==1)//سیستم فروش
 {
  $Mode='';
  $Search_x=""; 
  $temp="";
  if($ebh_code)        $temp.=" and ebh_code  LIKE '%$ebh_code%'";
  if($ebh_reg_date)
  {
    //تبدیل تاریخ شمسی به میلادی
	$sql_tarikh=$ebh_reg_date;
    $d=substr($sql_tarikh,8,2);
    $m=substr($sql_tarikh,5,2);
    $y=substr($sql_tarikh,0,4);
    $milady=jalali_to_gregorian($y,$m,$d);
    $sal=$milady[0];
    $mah=$milady[1];
    $rouz=$milady[2];
    $tarikh_ebtal=$sal.'-'.$mah.'-'.$rouz;
   $temp.=" and ebh_reg_date LIKE '%$tarikh_ebtal%'";
  }
  if($his_h_code)      $temp.=" and his_h_code LIKE '%$his_h_code%'";
  if($his_eb_amount)   $temp.=" and his_eb_amount LIKE '%$his_eb_amount%'";
  if($temp) {$PageNo=1;$_SESSION['search_ebtal']=$temp;} else $_SESSION['search_ebtal']="";
 }
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
if($_SESSION['mt_systemforush']==0) $res = mysql_query("SELECT COUNT(*) FROM $TableName WHERE 1=1 ".$_SESSION['search_ebtal']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
else                             $res = mysql_query("SELECT COUNT(*) FROM dm_his_havale INNER JOIN dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id WHERE 1=1 ".$_SESSION['search_ebtal']." AND dm_his_havale.his_id_province='$sell_id_ostan' AND dm_his_havale.his_l_code='$sell_id_anbar' AND dm_his_havale.his_id_year='$sellYearId'");
//else                             $res = $db->query("SELECT COUNT(*) FROM $TableName WHERE 1=1 ".$_SESSION['search_ebtal']." AND ebh_id_province='$sell_id_ostan' ");
$row = $db->fetch_array($res);
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
function isPermitSave($a,$b,$c,$d,$e,$f,$gl_c_o,$gl_c_a,$gl_year)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($a and $b and $c and $d and $e))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";  
   return $flag;
 } 
 else $flag=true;
 if($f<=0)
 {$flag=false;
  echo"<script>window.alert('مقدار مانده از حواله فروش صفر است !امکان ثبت برگه ابطال وجود ندارد')</script>";
  return $flag;
 }
 else $flag=true;
 if($f<$e)
 {$flag=false;
  echo"<script>window.alert('مقدار باطله از مقدار مانده از حواله فروش بیشتر است !امکان ثبت این برگه ابطال وجود ندارد')</script>";
  return $flag;
 }
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$c,$d,$e,$gl_c_o,$gl_c_a,$gl_year)
{
  $flag=false;
  if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
  {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
  }
  else $flag=true; 
  if(!($a and $b and $c and $d and $e))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";  
   return $flag;
  }  
  else $flag=true;
 return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if((isset($Insert_x))and ($_SESSION['mt_systemforush']==0))
{ 
 if(isPermitSave($shomare_barge_ebtal,$tarikh_barge_ebtal,$shomare_mojavez_ebtal,$h_code,$meghdar_batele,$mande_az_forush,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {
   $Mode='';
   $insert_q=("INSERT INTO $TableName(code_ostan,code_anbar,shomare_barge_ebtal,year,tarikh_barge_ebtal,
               shomare_mojavez_ebtal,h_code,meghdar_batele,deleted)
              VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_barge_ebtal','$mtActiveYear','$tarikh_barge_ebtal',
			  '$shomare_mojavez_ebtal','$h_code','$meghdar_batele',0)");         
   $insert_res=mysql_query($insert_q);
   if($insert_res)
   {
     //آپدیت مانده مقدار حواله فروش در جدول حواله فروش
	 $update_mande=$mande_az_forush-$meghdar_batele; 
     $res_update_mande=$db->query("UPDATE havale_forush SET mande_az_forush='$update_mande' WHERE h_code='$h_code' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");   
     $max_id=$db->get_from_where("Max(id)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0"); 
     /*لاگ ها*/
	 $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
     if($res_update_mande) {$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush','ایجاد برگه ابطال فروش و کاهش مانده ',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/}
     echo "<script>alert(' برگه ابطال شما به شماره".$_SESSION['code_ostan'].$_SESSION['code_anbar'].$shomare_barge_ebtal." به ثبت رسید  ');
                window.location=".$FileName."?PageNo=".$MaxPage."&RowPerPage=".$RowPerPage.";
           </script>"; 
   }
   else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت برگه ابطال به وجود آمده است ! *</span>';    
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if((isset($Edit_x))and($_SESSION['mt_systemforush']==0))
{
 if(isPermitEdit($shomare_barge_ebtal,$tarikh_barge_ebtal,$shomare_mojavez_ebtal,$h_code,$meghdar_batele,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET tarikh_barge_ebtal='$tarikh_barge_ebtal',shomare_mojavez_ebtal='$shomare_mojavez_ebtal' WHERE id='$id_';");
  $edit_res=$db->query($edit_q,'مشکلي در ويرايش مشخصات به وجود آمده است');
  $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");  
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if((isset($Delete_x))and ($_SESSION['mt_systemforush']==0))
{
 $Mode='';
 // echo "<script>alert($h_code_)</script>"; 
 $del_q = "update $TableName set deleted=1 WHERE id=$id_";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if($del_res)
 {
   //آپدیت مانده مقدار حواله فروش در جدول حواله فروش
   $update_mande2=$mande_az_forush_+$meghdar_batele_; 
   $res_update_mande2=$db->query("UPDATE havale_forush SET mande_az_forush='$update_mande2' WHERE h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");    
   /*لاگ ها*/
   $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");
   if($res_update_mande2) {$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush_','حذف برگه ابطال و برگشت مقدار مانده',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/}
 }
}
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
if ($Mode=="Insert") $load="document.myform.shomare_mojavez_ebtal.focus();";
if ($Mode=="Edit") $load="document.myform.tarikh_barge_ebtal.focus();";
if (($Mode=="Search")and($_SESSION['mt_systemforush']==0)) $load="document.myform.shomare_barge_ebtal_srch.focus();";
if (($Mode=="Search")and($_SESSION['mt_systemforush']==1)) $load="document.myform.ebh_code.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="1000px" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">';
   if($_SESSION['mt_systemforush']==1)echo'<div class="etesal">متصل به سیستم فروش</div>';
   echo'<div style="position:absolute;top:5px;left:43%;"> فرم ابطال مقادیر حواله فروش</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
 </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if((!isset($order))and($_SESSION['mt_systemforush']==0)) $order='id DESC';
if((!isset($order))and($_SESSION['mt_systemforush']==1)) $order='ebh_id DESC';
if(!isset($sortcode))   $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sortforush)) $sortforush='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی شماره برگه ابطال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan ASC,code_anbar ASC,shomare_barge_ebtal ASC&sortcode=2&show_img=1\'"/> شماره برگه ابطال ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی شماره برگه ابطال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan DESC,code_anbar DESC,shomare_barge_ebtal DESC&sortcode=1&show_img=1\'"/> شماره برگه ابطال ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی تاریخ برگه ابطال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_barge_ebtal ASC&sorttarikh=2&show_img=2\'"/> تاریخ برگه ابطال '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی تاریخ برگه ابطال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_barge_ebtal DESC&sorttarikh=1&show_img=2\'"/> تاریخ برگه ابطال '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortforush=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی شماره حواله فروش" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=h_code ASC&sortforush=2&show_img=3\'"/> شماره حواله فروش '; 
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortforush=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی شماره حواله فروش" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=h_code DESC&sortforush=1&show_img=3\'"/> شماره حواله فروش '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	 <td width="20%">مقدار باطله</td>'; 
	 if($_SESSION['mt_systemforush']==0) echo'<td width="20%">حذف</td>';
	echo'
	</tr>';
	$i=0;
	//کوئری کلی سیستم انبار
	if($_SESSION['mt_systemforush']==0)
	{
     $q1="SELECT *,
	      (SELECT mande_az_forush FROM havale_forush h_f WHERE h_f.h_code=T.h_code AND h_f.code_ostan=T.code_ostan and h_f.code_anbar=T.code_anbar AND h_f.year=T.year AND h_f.deleted=0) mande
		  From $TableName T WHERE 1=1 ".$_SESSION['search_ebtal']." AND code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by $order $Limit"; 
	}	
	//کوئری کلی سیستم فروش
	else{
	   // $q1="SELECT $TableName.*,dm_havale.h_code From $TableName
		     //LEFT OUTER JOIN dm_havale ON $TableName.ebh_h_id=dm_havale.h_id
		    // WHERE 1=1 ".$_SESSION['search_ebtal']." AND ebh_id_province='$mt_gl_code_ostan' order by $order $Limit";
    	//$q1="SELECT dm_ebtal_h.ebh_code,dm_ebtal_h.ebh_reg_date,dm_his_havale.his_h_code,dm_his_havale.his_eb_amount
	    // FROM dm_his_havale INNER JOIN dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id 
		 //WHERE 1=1 ".$_SESSION['search_ebtal']." AND dm_his_havale.his_id_province='$sell_id_ostan' AND dm_his_havale.his_l_code='$sell_id_anbar' AND dm_his_havale.his_id_year='$sellYearId' order by $order $Limit";
		 $q1="SELECT dm_ebtal_h.ebh_code,dm_ebtal_h.ebh_reg_date,dm_his_havale.his_h_code,dm_his_havale.his_eb_amount
	     FROM dm_ebtal_h  INNER JOIN dm_his_havale ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id 
		 WHERE 1=1 ".$_SESSION['search_ebtal']." AND dm_his_havale.his_id_province='$sell_id_ostan' AND dm_his_havale.his_l_code='$sell_id_anbar' AND dm_his_havale.his_id_year='$sellYearId' order by $order $Limit";
	//echo $q1;
	}
	$allEbtal=mysql_query($q1);
    while($row1=mysql_fetch_assoc($allEbtal))
	{
     if(($_SESSION['mt_systemforush']==0)and($right_edt)) $edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&shomare_barge_ebtal_='.$row1['shomare_barge_ebtal'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
     if($_SESSION['mt_systemforush']==0)
	 {
	  if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
	  else $code_a=$row1['code_ostan'];
	  echo'
	   <td '.$edtClick.'>'.$code_a.$row1['code_anbar'].$row1['shomare_barge_ebtal'].'</td>
	   <td '.$edtClick.'>'.$row1['tarikh_barge_ebtal'].'</td>
	   <td '.$edtClick.'>'.$row1['h_code'].'</td>
	   <td '.$edtClick.'>'.virgul($row1['meghdar_batele']).'</td>
	   <td>';
	   
	    if($right_del)
	    {
	     echo'<img border="0"  src="images/trash.png" width="20" height="20" title="حذف"
	          onmouseOver="this.src=\'images/trash_hover.png\'" 
	 	     onmouseOut="this.src=\'images/trash.png\'" 
	 	     onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&h_code_='.$row1['h_code'].'&mande_az_forush_='.$row1['mande'].'&idForush_='.$row1['idForush'].'&meghdar_batele_='.$row1['meghdar_batele'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف برگه ابطال شماره '.$code_a.$row1['code_anbar'].$row1['shomare_barge_ebtal'].' \')" />';
	    }
	   echo'
	   </td>';
	 }
	 else
	 {
	   //تبدیل تاریخ میلادی به شمسی
	   $sql_tarikh=$row1['ebh_reg_date'];
       $d=substr($sql_tarikh,8,2);
       $m=substr($sql_tarikh,5,2);
       $y=substr($sql_tarikh,0,4);
       $shamsi=gregorian_to_jalali($y,$m,$d);
       $sal=$shamsi[0];
       $mah=$shamsi[1];
       $rouz=$shamsi[2];
       $tarikh_ebtal=$sal.'/'.$mah.'/'.$rouz;
	  echo'
	   <td '.$edtClick.'>'.$row1['ebh_code'].'</td>
	   <td '.$edtClick.'>'.$tarikh_ebtal.'</td>
	   <td '.$edtClick.'>'.$row1['his_h_code'].'</td>
	   <td '.$edtClick.'>'.virgul($row1['his_eb_amount']).'</td>';
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
	  <td>&nbsp;</td>';
	  if($_SESSION['mt_systemforush']==0)echo'<td>&nbsp;</td>';
	 echo'</tr>';
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
	 <td width="10px">&nbsp;</td>';
	 if($_SESSION['mt_systemforush']==0) echo'<td width="24"><div onClick="window.open(\'print_ebtal.php\',\'\',\'\')" id="printer" title="چاپ"><a href="#"></a></div></td>';
     if(($right_ins)and($_SESSION['mt_systemforush']==0)){//در انبار می بینیم
	   echo'<td width="10">&nbsp;</td>
	   <td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>'; 	 
	 }
	 echo'<td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'my_frame.php\'" id="btn-back" title="بازگشت به منوی اصلی"><a href="#"></a></div></td>
	 <td width="20px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['search_ebtal']) 
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
	 <td> 	 
	  <table border="0" bgcolor="#E9F7FD" align="center" width="1000px" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center">ايجاد فرم جديد</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
		<td align="left"><span style="color:red">*</span> شماره برگه ابطال : &nbsp; </td>
		<td align="right">
		<input type="text" readonly class="textboxme" name="shomare_barge_ebtal" value="'.$shomare_barge_ebtal.'" style="width:50px;"/>&nbsp;/&nbsp;';
		if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
		else $code_a=$mt_gl_code_ostan;
		echo'<input type="text" readonly class="textboxme" value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
        <td align="left"><span style="color:red">*</span> تاریخ برگه ابطال : &nbsp; </td><td align="right"><input type="text" readonly class="textboxme2" maxlength="10" name="tarikh_barge_ebtal" value="'.AsLDate($yymmdd).'"/></td>
	   	<td align="left"><span style="color:red">*</span> طبق شماره مجوز  : &nbsp; </td><td align="right"><input type="text" class="textboxme2" name="shomare_mojavez_ebtal" value="'.$shomare_mojavez_ebtal.'" onkeypress="return isNumber(event)"/></td>       
	   </tr>
	   <tr>	 
	    <td align="left"><span style="color:red">*</span> شماره حواله فروش : &nbsp;</td><td align="right"><input type="text" class="textboxme2" value="'.$h_code.'" name="h_code" onfocus="getDetailForush2(this.value)" onblur="getDetailForush2(this.value)" onkeypress="return isNumber(event)"/>&nbsp';
         include ("img_helphavaleforush.php");
		echo' 
		</td>
		<td align="left">تاريخ حواله فروش : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" value="'.$h_reg_date.'" name="h_reg_date" id="h_reg_date"/></td>	 	   
	    <td align="left">کد مشتری : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="code_customer" id="code_customer" value="'.$code_customer.'" style="width:50px;"/></td>
	    <td align="left">کد کالا : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="code_kala" id="code_kala" value="'.$code_kala.'" style="width:50px;"/></td>	   
	   </tr>
	   <tr>
	    <td align="left">مقدار حواله فروش اصلی : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_havale_forush" id="meghdar_havale_forush" value="'.virgul($meghdar_havale_forush).'" /></td>
	    <td align="left">مقدار تحویلی از حواله : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_tahvily" id="meghdar_tahvily" value="'.virgul($meghdar_tahvily).'" /></td>
	     <input type="hidden"  name="idForush" id="idForush"/>
	    <td align="left">مقدار مانده از حواله فروش : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mande_az_forush" id="mande_az_forush" value="'.virgul($mande_az_forush).'"/></td>
	  	<td align="left"><span style="color:red">*</span> مقدار باطله : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="meghdar_batele" value="'.$meghdar_batele.'" onkeypress="return isNumber(event)"/></td>
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
    if($Mode=="Edit")  //Edit Mode
    {
	$q3=("SELECT $TableName.*,havale_forush.h_code,havale_forush.h_reg_date,havale_forush.code_kala,havale_forush.code_customer,havale_forush.meghdar_havale_forush,havale_forush.mande_az_forush
	      FROM $TableName INNER JOIN havale_forush ON $TableName.h_code=havale_forush.h_code 
          WHERE $TableName.id='$id_' AND $TableName.shomare_barge_ebtal='$shomare_barge_ebtal_' AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0");
	$res3=$db->query($q3);
    $row3=$db->fetch_assoc($res3);
	if(strlen($row3['code_ostan'])==1) $code_a=make_pattern($row3['code_ostan'],2);
    else $code_a=$row3['code_ostan'];
    //محاسبه مقدار تحویلی
    $meghdar_tahvily=$db->get_from_where("SUM(vazn_khales_h)","havale","h_code='".$row3['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0 AND status=0");
    //محاسبه مقدار باطله
    $meghdar_batele=$db->get_from_where("SUM(meghdar_batele)","ebtal","h_code='".$row3['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND deleted=0");
    /**///$mande_az_forush=$row3['meghdar_havale_forush']-$meghdar_tahvily-$meghdar_batele;//محاسبه مقدار مانده از حواله فروش 
	$mande_az_forush=$row3['mande_az_forush'];
	echo '
    <tr> 
	 <td> 	 
	  <table border="0" bgcolor="#E9F7FD" align="center" width="1000px" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات برگه '.$code_a.$row3['code_anbar'].$row3['shomare_barge_ebtal'].'</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
		<td align="left"><span style="color:red">*</span> شماره برگه ابطال : &nbsp; </td><td align="right"><input type="text" readonly class="textboxme" value="'.$row3['shomare_barge_ebtal'].'" name="shomare_barge_ebtal" style="width:50px;"/>&nbsp;/&nbsp;
		                                                                 <input type="text" readonly class="textboxme" value="'.$row3['code_ostan'].$row3['code_anbar'].'" name="ostan_anbar" style="width:50px;"/></td>
        <td align="left"><span style="color:red">*</span> تاریخ برگه ابطال : &nbsp; </td><td align="right"><input class="textboxme2" type="text" id="datepicker6" maxlength="10" name="tarikh_barge_ebtal" value="'.$row3['tarikh_barge_ebtal'].'"/></td>
	   	<td align="left"><span style="color:red">*</span> طبق شماره مجوز  : &nbsp; </td><td align="right"><input class="textboxme2"  type="text" name="shomare_mojavez_ebtal" value="'.$row3['shomare_mojavez_ebtal'].'" onkeypress="return isNumber(event)"/></td>       
	   </tr>
	   <tr>	 
	    <td align="left"><span style="color:red">*</span> شماره حواله فروش : &nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly value="'.$row3['h_code'].'" name="h_code" onfocus="getDetailForush2(this.value)" onblur="getDetailForush2(this.value)" onkeypress="return isNumber(event)"/>';
		//include ("img_helphavaleforush.php");
		echo'
		</td>
		<td align="left">تاريخ حواله فروش : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" value="'.$row3['h_reg_date'].'" name="h_reg_date" id="h_reg_date"/></td>	 
	   	<td align="left">کد مشتری : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="code_customer" id="code_customer" value="'.$row3['code_customer'].'" style="width:50px;"/></td>
	    <td align="left">کد کالا : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="code_kala" id="code_kala" value="'.$row3['code_kala'].'" style="width:50px;"/></td>
	   </tr>
	   <tr>
	    <td align="left">مقدار حواله فروش اصلی : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_havale_forush" id="meghdar_havale_forush" value="'.virgul($row3['meghdar_havale_forush']).'" /></td>
	    <td align="left">مقدار تحویلی از حواله : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_tahvily" id="meghdar_tahvily" value="'.virgul($meghdar_tahvily).'"/></td>
	    <td align="left">مقدار مانده از حواله فروش : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mande_az_forush" id="mande_az_forush" value="'.virgul($mande_az_forush).'"/></td>
	       <!--<td align="left">مقادیر باطله قبلی : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_batele_ghabl" id="meghdar_batele_ghabl" value="'.$meghdar_batele_ghabl.'"/></td>-->
	   	<td align="left"><span style="color:red">*</span> مقدار باطله : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="meghdar_batele" readonly value="'.$row3['meghdar_batele'].'" onkeypress="return isNumber(event)"/></td>
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
    {
	 if($_SESSION['mt_systemforush']==0)//سیستم انبار
	 {
	  echo '
      <tr> 
	   <td> 
        <table border="0" bgcolor="#E9F7FD" align="center" width="1000px" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px">
        <img src="images/loading.gif" id="loading" class="loading_img"/>
	     <tr class="title"><td colspan="6" align="center">جستجوی فرم ابطال</td></tr>
         <tr><td>&nbsp;</td></tr>	   
	     <tr>
		  <td align="left">شماره برگه ابطال : &nbsp; </td>
		  <td align="right"><input type="text" class="textboxme" name="shomare_barge_ebtal_srch" value="" style="width:50px;"/>&nbsp;/&nbsp;';
		  if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
		  else $code_a=$mt_gl_code_ostan;
		  echo'<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/>                                              
		  </td>
          <td align="left">تاریخ برگه ابطال : &nbsp; </td><td align="right"><input type="text" class="textboxme2" maxlength="10" id="datepicker6" name="tarikh_barge_ebtal" value=""/></td>
	      <td align="left">طبق شماره مجوز  : &nbsp; </td><td align="right"><input type="text" class="textboxme2" name="shomare_mojavez_ebtal" value="'.$shomare_mojavez_ebtal.'" onkeypress="return isNumber(event)"/></td>       
	     </tr>
	     <tr>	 
	      <td align="left">شماره حواله فروش : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="h_code" value="'.$h_code.'" onkeypress="return isNumber(event)"/>&nbsp';
		   include ("img_helphavaleforush.php");
		 echo'
		  </td>
		  <td align="left">مقدار باطله : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="meghdar_batele" value="'.$meghdar_batele.'" onkeypress="return isNumber(event)"/></td>
	     </tr>	 
	     <tr>
          <td colspan="6" align="center">
		   <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو" >
           <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
          </td>
         </tr>
        </table>
	   </td>
      </tr>';
	 }
	 if($_SESSION['mt_systemforush']==1)//سیستم فروش
	 {
	  echo '
      <tr> 
	   <td> 
        <table border="0" bgcolor="#E9F7FD" align="center" width="1000px" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px">
        <img src="images/loading.gif" id="loading" class="loading_img"/>
	     <tr class="title"><td colspan="8" align="center">جستجوی فرم ابطال</td></tr>
         <tr><td>&nbsp;</td></tr>	   
	     <tr>
		  <td align="left">شماره برگه ابطال : &nbsp; </td>
		  <td align="right"><input type="text" class="textboxme" name="ebh_code" value="" style="width:50px;"/></td>
          <td align="left">تاریخ برگه ابطال : &nbsp; </td><td align="right"><input type="text" class="textboxme2" maxlength="10" id="datepicker6" name="ebh_reg_date" value="'.$ebh_reg_date.'" /></td>	 
	      <td align="left">شماره حواله فروش : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="his_h_code" value="'.$his_h_code.'" onkeypress="return isNumber(event)"/>
	   	  	              <img border="0" src="images/help.png" onClick="window.open(\'help_havaleforush.php?inputName=his_h_code\',\'_blank\',\'width=500px,left=20px,scrollbars=yes\')" title="جدول شماره حواله فروش" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/></td>
		  <td align="left">مقدار باطله : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="his_eb_amount" value="'.$his_eb_amount.'" onkeypress="return isNumber(event)"/></td>
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