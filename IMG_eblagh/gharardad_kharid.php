<?php
require_once __DIR__ . '/../mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="gharardad_kharid.php";
$TableName="gharardad_kharid";
$titr='قرارداد خرید';
$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;$right_vaziyat=0;$right_elhagh=0;$right_tamin=0;$right_tazmin=0;$right_ins_tazmin=0;$right_edt_tazmin=0;$right_pardakhti=0;$right_tarikh_etmam=0;
if (right(422)) $right_ins=1;
if (right(423)) $right_edt=1;
if (right(424)) $right_del=1; 
if (right(425)) $right_prt=1;
if (right(426)) $right_vaziyat=1;
if (right(427)) $right_elhagh=1;
if (right(432)) $right_tamin=1;
if (right(437)) $right_tazmin=1;
if (right(438)) $right_ins_tazmin=1;
if (right(439)) $right_edt_tazmin=1;
if (right(446)) $right_pardakhti=1;
if (right(466)) $right_tarikh_etmam=1;
$logtime=date('H:i:s');
$mahmule_type=$db->get_from_where("mahmule_type","sahmiebandy_kharid INNER JOIN eblagh_kharid ON sahmiebandy_kharid.id_eblagh=eblagh_kharid.id_eblagh","id_sahmiebandy='$id_sahmiebandy'");
$codeGroupKalaTop=$db->get_from_where("code_group_kala_top","sahmiebandy_kharid INNER JOIN eblagh_kharid ON sahmiebandy_kharid.id_eblagh=eblagh_kharid.id_eblagh","id_sahmiebandy='$id_sahmiebandy'");
$code_ostan=$db->get_from_where("code_ostan","sahmiebandy_kharid","id_sahmiebandy='$id_sahmiebandy' AND deleted=0");
//echo $codeGroupKalaTop;
//از صفحه سهمیه بندی آمده یا نه
if($id_sahmiebandy=='')$condition="";
else 
{
 $condition=" AND T.id_sahmiebandy=$id_sahmiebandy";
 $titr.=" (شماره سهمیه $id_sahmiebandy)";
 $id_eblagh=$db->get_from_where("id_eblagh","sahmiebandy_kharid","id_sahmiebandy='$id_sahmiebandy'");
}
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$condition_ostan='';}
else {$condition_ostan=' AND T.code_ostan='.$mt_gl_code_ostan.'';}
$activate_eblagh=$db->get_from_where("activate_eblagh","eblagh_kharid","id_eblagh='$id_eblagh'");
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">	
$(function(){	    
    $(".datepickerfrom").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
	  onSelect: function(dateText, inst){
	  $(".datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $(".datepickerto").datepicker(
	  { showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true}
	  );
});
function OpenWindowDialog(url, w, h)
{
	 var features = "resizable:no;status:yes;dialogwidth:" + w + "px;dialogheight:" + h + "px;help:no";
     features = features + ";dialogtop:" + (window.screen.availHeight - w) /2;
	 features = features + ";dialogleft:" + (window.screen.availWidth - h) /2;	 
	 window.showModalDialog(url, this, features);	 
}
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
   window.event.keyCode = 9;
}
function getSahmie(id_sa)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_gharardad.php",{idSAHMIE:id_sa},function(data)
  {
    var spl_s = data.split("^");
    $("[name=shomare_dastorolamal]").val(spl_s[0]);
  });
  $("#loading").fadeOut("fast");		
}
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width="+w+", height="+h+", top="+top+", left="+left);
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_gharardad']="";
  
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($id_gharardad)  $temp.=" and T.id_gharardad LIKE '$id_gharardad'";
 if($shomare_gharardad)  $temp.=" and T.shomare_gharardad LIKE '%$shomare_gharardad%'";
 if($tarikh_gharardad)   $temp.=" and T.tarikh_gharardad LIKE '%$tarikh_gharardad%'";
 if($tarikh_shoro)   $temp.=" and T.tarikh_shoro LIKE '%$tarikh_shoro%'";
 if($shomare_dastorolamal)  $temp.=" and d_kh.shomare_dastorolamal LIKE '%$shomare_dastorolamal%'";
 if($shomare_eblagh)  $temp.=" and e_kh.shomare_eblagh LIKE '%$shomare_eblagh%'";
 if($code_ostan_search)         $temp.=" and T.code_ostan='$code_ostan_search'";
 //if($id_sahmiebandy)     $temp.=" and T.id_sahmiebandy LIKE '%$id_sahmiebandy%'";
 if($code_skk)             $temp.=" and T.code_skk LIKE '%$code_skk%'";
 if($tarikh_etmam)       $temp.=" and T.tarikh_etmam LIKE '%$tarikh_etmam%'";
 if($modat_gharardad)    $temp.=" and T.modat_gharardad LIKE '%$modat_gharardad%'";
 if($meghdar_gharardad)  $temp.=" and T.meghdar_gharardad LIKE '%$meghdar_gharardad%'";
 if($percentage_changes) $temp.=" and T.percentage_changes LIKE '%$percentage_changes%'";
 if($gheymat_har_kilo)   $temp.=" and T.gheymat_har_kilo LIKE '%$gheymat_har_kilo%'";
 if($meghdar_jarime)     $temp.=" and T.meghdar_jarime LIKE '%$meghdar_jarime%'";
 if($termination)        $temp.=" and T.termination LIKE '$termination'";
 //if($noe_khat)           $temp.=" and T.noe_khat LIKE '$noe_khat'";
 if($temp) {$PageNoGhr=1;$_SESSION['mt_search_gharardad']=$temp;} else $_SESSION['mt_search_gharardad']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
//$res = $db->query("SELECT COUNT(*) FROM $TableName T INNER JOIN dastorolamal_kharid d_kh ON d_kh.id_dastorolamal=T.id_dastorolamal WHERE 1=1 ".$_SESSION['mt_search_gharardad']." $condition AND T.year='$mtActiveYear' AND T.deleted=0");
$res = $db->query("SELECT COUNT(*) From meat.$TableName T 
		INNER JOIN meat.sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
	    INNER JOIN meat.dastorolamal_kharid d_kh ON T.id_dastorolamal=d_kh.id_dastorolamal
	    INNER JOIN meat.eblagh_kharid e_kh ON d_kh.id_eblagh=e_kh.id_eblagh
		INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=e_kh.code_group_kala_top
		INNER JOIN meat.mt_skk ON T.code_skk=mt_skk.code_skk
		INNER JOIN meat.ostan ON T.code_ostan=ostan.code_ostan
		LEFT JOIN meat.kala ON T.code_kala=kala.code_kala
		WHERE 1=1 ".$_SESSION['mt_search_gharardad']." $condition $condition_ostan AND T.deleted=0");
	
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNoGhr)) $PageNoGhr=1; //$PageNoGhr=$MaxPage;  
$NextPage=$PageNoGhr+1;
$PrevPage=$PageNoGhr-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNoGhr==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNoGhr==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0;
$Limit="Limit ".$FirstRow.",".$RowPerPage;
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
 mysql_query('START TRANSACTION'); 
 $del_q = "update $TableName set deleted=1 WHERE id_gharardad=$id_gharardad_";
 $del_res = mysql_query($del_q);
 /*لاگ*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_gharardad_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
 $exist_safar=$db->get_from_where("count(*)","shomare_safar","id_safar='$id_safar_'");	
 if($exist_safar==0)$delete_safar=mysql_query("DELETE FROM shomare_safar WHERE id_safar='$id_safar_'");   
 /*لاگ*/$log_d_safar=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','shomare_safar','$id_safar_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/ 
 if($del_res and $log_d and $delete_safar and $log_m_e and $log_d_safar)
 {
	  mysql_query("COMMIT");
 }
 else
 {
	  mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	  $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';
 }
  mysql_query('SET AUTOCOMMIT=1');   
}//END DELETE 
/************terminate BUTTON********/// اتمام قرارداد 
// if(isset($terminate_x))
// {
   // mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   // mysql_query('START TRANSACTION');
   // $ebtal_r_q ="UPDATE $TableName SET termination=2,meghdar_gharardad=$sum_tahvily_gharardad WHERE id_gharardad=$id_gharardad_";
   // $ebtal_res=mysql_query($ebtal_r_q);
   // /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_gharardad_','فسخ قرارداد',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   // //در شماره سفر اتمام سفر بلی می شود
   // $edit_safar=("UPDATE shomare_safar SET etmam_safar=1 WHERE shomare_safar='".$shomare_gharardad_."'");         
   // $edit_res_safar=mysql_query($edit_safar);	
   // if($ebtal_res and $log_d and $edit_res_safar)
   // {
          // mysql_query("COMMIT"); 
	      // echo "<script>window.location='".$FileName."?PageNoGhr=".$PageNoGhr."&PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."'&PageNoSahm=".$PageNoSahm.";</script>";   
   // }
   // else
   // {
	      // mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	      // echo "<script>alert(' مشکلی در فسخ قرارداد به وجود آمده است ')</script>";  
   // }
  // mysql_query('SET AUTOCOMMIT=1');  		   
// }//END EBTAL 
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس  
IF($Mode=="Search")$load="document.myform.id_gharardad.focus();";
ELSE $load="document.myform.shomare_dastorolamal.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:40%;">'.$titr.'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNoGhr.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
	/********************sort field***********************/
if(!isset($order))      $order='T.id_gharardad DESC';
if(!isset($sortshomare))$sortshomare='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sortdastor))  $sortdastor='1';
if(!isset($sortkala))   $sortkala='1';
if(!isset($show_img))   $show_img='';
	echo'<td width="3%" rowspan="2">شناسه</td>';
	if($sortshomare=='1')
	{echo'<td width="7%" rowspan="2" title="مرتب سازی صعودی شماره قرارداد " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_sahmiebandy='.$id_sahmiebandy.'&PageNoSahm='.$PageNoSahm.'&order=T.shomare_gharardad ASC&sortshomare=2&show_img=1\'"/> شماره قرارداد ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortshomare=='2')
	{echo'<td width="7%" rowspan="2" title="مرتب سازی نزولی شماره قرارداد" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_sahmiebandy='.$id_sahmiebandy.'&PageNoSahm='.$PageNoSahm.'&order=T.shomare_gharardad DESC&sortshomare=1&show_img=1\'"/> شماره قرارداد ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="5%" rowspan="2" title="مرتب سازی صعودی تاریخ قرارداد" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_sahmiebandy='.$id_sahmiebandy.'&PageNoSahm='.$PageNoSahm.'&order=tarikh_gharardad ASC&sorttarikh=2&show_img=2\'"/> تاریخ قرارداد '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="5%" rowspan="2" title="مرتب سازی نزولی تاریخ قرارداد" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_sahmiebandy='.$id_sahmiebandy.'&PageNoSahm='.$PageNoSahm.'&order=tarikh_gharardad DESC&sorttarikh=1&show_img=2\'"/> تاریخ قرارداد '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
    if($id_sahmiebandy=='') echo'<td width="7%" rowspan="2">اتمام قرارداد</td>';
    else
	{
		if($codeGroupKalaTop!=5)echo'<td width="7%" rowspan="2">اتمام قرارداد</td>';
	}	 
	// if($sortdastor=='1')
	// {echo'<td width="10%" title="مرتب سازی صعودی شماره دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_sahmiebandy='.$id_sahmiebandy.'&order=shomare_dastorolamal ASC&sortdastor=2&show_img=3\'"/> شماره دستورالعمل '; 
	  // if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	// if($sortdastor=='2')
	// {echo'<td width="10%" title="مرتب سازی نزولی شماره دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_sahmiebandy='.$id_sahmiebandy.'&order=shomare_dastorolamal DESC&sortdastor=1&show_img=3\'"/> شماره دستورالعمل '; 
	  // if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	echo'
	 <td width="10%" rowspan="2">نام فروشنده</td>
	 <td width="5%" rowspan="2">گروه کالا</td>
	 <td width="5%" rowspan="2">نام کالا</td>
	 <td width="5%" rowspan="2">استان</td>
	 <td width="7%" rowspan="2">مقدار اولیه قرارداد</td>
	 <td width="4%" rowspan="2">مقادیر الحاقیه</td>
	 <td width="4%" rowspan="2">مجموع قرارداد و الحاقیه</td>
	 <td width="4%" colspan="2">قیمت</td>
	 <td width="7%" rowspan="2">مبلغ کل قرارداد</td>
	 <td width="7%" rowspan="2">مبلغ درخواست تأمین اعتبار</td>
	 <td width="6%" rowspan="2">مبلغ درخواست پرداختی</td>
	 <td width="7%" colspan="2">تحویلی از قرارداد</td>
	 <td width="7%" rowspan="2">مانده از قرارداد</td>
	 <td width="3%" rowspan="2">وضعیت</td>';
	 if($right_elhagh)echo'<td width="3%" rowspan="2">الحاقیه</td>';
	 if($right_tamin)echo'<td width="3%" rowspan="2">درخواست تأمین اعتبار</td>';
	 if($right_tazmin)echo'<td width="3%" rowspan="2">تضامین</td>';
	 if($right_pardakhti)echo'<td width="3%" rowspan="2">درخواست پرداخت وجه</td>';
	 echo'<td width="7%" rowspan="2">نمایش رسیدها</td>';
	 if($right_prt)echo'<td width="3%" rowspan="2">چاپ</td>';
	 if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td width="2%" rowspan="2">حذف</td>';
    echo'
	</tr>
	<tr class="table-title">
	 <td>اولیه</td>
	 <td>الحاقیه</td>

	 <td>ثبت نهایی شده</td>
	 <td>ثبت نهایی نشده</td>
	</tr>';
	$i=0;

	$q1="SELECT T.*,kala.name_kala,kala.code_bastebandy,d_kh.shomare_dastorolamal,mt_skk.name_skk,ostan.name_ostan,e_kh.code_group_kala_top,name_group_kala_top
	    From meat.$TableName T 
		INNER JOIN meat.sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
	    INNER JOIN meat.dastorolamal_kharid d_kh ON T.id_dastorolamal=d_kh.id_dastorolamal
	    INNER JOIN meat.eblagh_kharid e_kh ON d_kh.id_eblagh=e_kh.id_eblagh
		INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=e_kh.code_group_kala_top
		INNER JOIN meat.mt_skk ON T.code_skk=mt_skk.code_skk
		INNER JOIN meat.ostan ON T.code_ostan=ostan.code_ostan
		LEFT JOIN meat.kala ON T.code_kala=kala.code_kala
		WHERE 1=1 ".$_SESSION['mt_search_gharardad']." $condition $condition_ostan  AND T.deleted=0 order by $order $Limit";
	
	//if(SuperUser())echo $q1;
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
	 //if(($right_edt)AND($id_sahmiebandy!='')){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_gharardad_='.$row1['id_gharardad'].'&shomare_eblagh_='.$row1['shomare_gharardad'].'&PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'\'"';}	 
	 $edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_gharardad_='.$row1['id_gharardad'].'&shomare_eblagh_='.$row1['shomare_gharardad'].'&PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'"';
     if($i++%2)
	 {echo'<tr  class="table-odd">';}	 
     else
	 {echo'<tr  class="table-even">';}
	 //کل تحویلی قرارداد
	 // $q_resid="SELECT * FROM resid WHERE id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND noe_tahvil_bar!=4 AND noe_tahvil_bar!=5 AND noe_tahvil_bar!=6 AND code_ostan=".$row1['code_ostan']." AND deleted=0 AND status=0";
	 // $all_resid= $db->query($q_resid);
	 // while($row_resid=$db->fetch_assoc($all_resid))
     //قوطی یا دست یا عدد
	 if(($row1['code_bastebandy']==2)OR($row1['code_bastebandy']==5)OR($row1['code_bastebandy']==6))
	 {
		 $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
		 $sum_tahvily_gharardad_sabt=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND sabt_nahayi=1 AND noe_tahvil_bar!=8");
		 $sum_tahvily_gharardad_nosabt=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND sabt_nahayi=0 AND noe_tahvil_bar!=8");
     } 
     //کارتن یا لاشه یا کیسه
	 //if(($row1['code_bastebandy']==1)or($row1['code_bastebandy']==3)or($row1['code_bastebandy']==4))
	 else
	 {
		 $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND  r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
		 $sum_tahvily_gharardad_sabt=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND  r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND sabt_nahayi=1 AND noe_tahvil_bar!=8");
		 $sum_tahvily_gharardad_nosabt=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND  r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND sabt_nahayi=0 AND noe_tahvil_bar!=8");
	 }

	 //مانده قرارداد
	 $mande_tahvily_gharardad=$row1['meghdar_gharardad_avaliye']+$row1['mazad_gharardad']-round($sum_tahvily_gharardad,3);
	 
	 $id_safar=$db->get_from_where("id_safar","shomare_safar","shomare_safar='".$row1['shomare_gharardad']."'");
	 $elhaghiecount=$db->get_from_where("COUNT(*)","elhaghie_kharid","id_gharardad='".$row1['id_gharardad']."' AND deleted='0'");
	 $tamincount=$db->get_from_where("COUNT(*)","tamin_etebar","id_gharardad='".$row1['id_gharardad']."' AND whatform=1 AND deleted='0'");
	 $tazmincount=$db->get_from_where("COUNT(*)","tazmin","id_gharardad='".$row1['id_gharardad']."' AND deleted=0");
	 $pardakhtcount=$db->get_from_where("COUNT(*)","pardakht_gharardad","id_gharardad='".$row1['id_gharardad']."' AND deleted='0'");
	 $residcount=$db->get_from_where("COUNT(*)","resid","id_safar='".$id_safar."' AND code_ostan='".$row1['code_ostan']."'");
	 $mablaghtamin=$db->get_from_where("SUM(mablagh_tamin)","tamin_etebar","id_gharardad='".$row1['id_gharardad']."' AND deleted='0'");
	 $mablaghpardakht=$db->get_from_where("SUM(mablagh_pardakht)","pardakht_gharardad","id_gharardad='".$row1['id_gharardad']."' AND deleted='0'");
	 echo'
	  <td '.$edtClick.'>'.$row1['id_gharardad'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_gharardad'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_gharardad'].'</td>'; 
	  if($id_sahmiebandy=='') echo'<td '.$edtClick.'>'.$row1['tarikh_etmam'].'</td>';
      else
	  {
	  	if($codeGroupKalaTop!=5)echo'<td '.$edtClick.'>'.$row1['tarikh_etmam'].'</td>';
	  }
	  //echo'<td '.$edtClick.'>'.$row1['shomare_dastorolamal'].'</td>';
	  echo'<td '.$edtClick.'>'.$row1['name_skk'].'</td>';
	  
	  // if($id_sahmiebandy=='') echo'<td '.$edtClick.'>'.$row1['name_kala'].'</td>';
      // else
	  // {
	  	// if($codeGroupKalaTop!=5)echo'<td '.$edtClick.'>'.$row1['name_kala'].'</td>';
	    // //else echo'<td '.$edtClick.'>'.$row1['name_group_kala_top'].'</td>';
	  // }
	  //if(($row1['code_group_kala_top']!=5)AND($row1['code_group_kala_top']!=7)) echo'<td '.$edtClick.' > '.$row1['name_kala'].'</td>';
	  echo'<td '.$edtClick.' >'.$row1['name_group_kala_top'].'</td>';
	  echo'<td '.$edtClick.' > '.$row1['name_kala'].'</td>';
	  $ezafe_gharardad=(($row1['meghdar_gharardad']*$row1['percentage_changes'])/100);
	  $mablagh_kol=compute_gheymat_gharardad($row1['id_gharardad'],$db);
	  
	  $gheymat_elhaghie=$db->get_from_where("gheymat_elhaghie","elhaghie_kharid","id_gharardad='".$row1['id_gharardad']."' AND deleted=0 AND gheymat_type!=0 ORDER BY id_elhaghie desc ");

	  echo'
	  <td '.$edtClick.'>'.$row1['name_ostan'].'</td>
	  <td '.$edtClick.'>'.round($row1['meghdar_gharardad_avaliye'],3).'</td>
	  <td '.$edtClick.' dir="ltr">'.round($row1['mazad_gharardad'],3).'</td>
	  <td '.$edtClick.'>'.round($row1['meghdar_gharardad_avaliye']+$row1['mazad_gharardad'],3).'</td>
	  <td '.$edtClick.'>'.virgul($row1['gheymat_har_kilo']).'</td>
	  <td '.$edtClick.'>'.virgul($gheymat_elhaghie).'</td>
	  <td '.$edtClick.'>'.virgul($mablagh_kol).'</td>
	  <td '.$edtClick.'>'.virgul($mablaghtamin).'</td>
	  <td '.$edtClick.'>'.virgul($mablaghpardakht).'</td>
	  ';
	  //IF(SuperUser()) echo'<td '.$edtClick.'>'.round($ezafe_gharardad,3).'</td>';   
	  echo'<td '.$edtClick.'>'.round($sum_tahvily_gharardad_sabt,3).'</td>
	  <td '.$edtClick.'>'.round($sum_tahvily_gharardad_nosabt,3).'</td>
	  <td '.$edtClick.'>'.round($mande_tahvily_gharardad,3).'</td>
	  <td '.$edtClick.'>'.$typeGrArr[$row1['termination']].'</td>';
	  if($right_elhagh) {echo'<td><input type="button" class="button-inline"  style="min-width:50px;" value=" ['.$elhaghiecount.']" onClick="window.location=\'elhaghie_kharid.php?PageNo='.$PageNo.'&id_gharardad='.$row1['id_gharardad'].'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'"></td>';}
	  if($right_tamin) {echo'<td><input type="button" class="button-inline"  style="min-width:50px;" value=" ['.$tamincount.']" onClick="window.location=\'tamin_etebar_gh.php?PageNo='.$PageNo.'&id_gharardad='.$row1['id_gharardad'].'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'"></td>';}
	  if($right_tazmin) {echo'<td><input type="button" class="button-inline"  style="min-width:50px;" value=" ['.$tazmincount.']" onClick="window.location=\''.$FileName.'?Mode=Tazmin&id_gharardad_='.$row1['id_gharardad'].'&shomare_eblagh_='.$row1['shomare_gharardad'].'&PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'"></td>';}
	  if($right_pardakhti) {echo'<td><input type="button" class="button-inline"  style="min-width:50px;" value=" ['.$pardakhtcount.']" onClick="window.location=\'pardakhti.php?PageNo='.$PageNo.'&id_gharardad='.$row1['id_gharardad'].'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'"></td>';}
 
	  echo'<td align="center"><input type="button" class="button-inline" style="min-width:50px;" value="['.$residcount.']" onClick="window.open(\'resid_gharardad.php?id_safar_='.$id_safar.'&id_gh_='.$row1['id_gharardad'].'\',\'_blank\',\'scrollbars=yes\')"/></td>';
	  echo'<td align="center">';
	  if($right_prt){echo'<div onClick="window.open(\'print_gharardad_one.php?id_gharardad_='.$row1['id_gharardad'].'\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ تعدیل موجودی"><a href="#"></a></div>';}
      echo'</td>'; 
	  if(($right_del)and($_SESSION['mtStatusYear']==0))
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" title="حذف" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_gharardad_='.$row1['id_gharardad'].'&id_safar_='.$id_safar.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNoSahm='.$PageNoSahm.'\',\'برای حذف قرارداد '.$row1['shomare_gharardad'].' \')" /></td>';
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
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($right_elhagh) echo'<td>&nbsp;</td>';
	  if($right_tamin) echo'<td>&nbsp;</td>';
	  if($right_tazmin) echo'<td>&nbsp;</td>';
	  if($codeGroupKalaTop!=5)echo'<td>&nbsp;</td>';
	  if(($right_del)and($_SESSION['mtStatusYear']==0))echo'<td>&nbsp;</td>';
      echo'
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10px">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_gharardad.php?id_sahmiebandy='.$id_sahmiebandy.'\',\'\',\'\')" id="printer" title="چاپ"><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>';
	 //if((($right_ins)and($_SESSION['mtStatusYear']==0)and($id_sahmiebandy)and($activate_eblagh==1))OR(SuperUser()and($_SESSION['mtStatusYear']==0)and($id_sahmiebandy)))//سوپریوزر بتواند بزند
	 //if(($id_eblagh!=187)and ($id_eblagh!=189))
	 //{
	  if(
	    (($right_ins)and($_SESSION['mtStatusYear']==0)and($id_sahmiebandy)and($activate_eblagh==1)and($_SESSION["mt_code_ostan"]!=4)and($_SESSION["mt_code_ostan"]!=8))OR
		(($right_ins)and($_SESSION['mtStatusYear']==0)and($id_sahmiebandy)and($_SESSION["mt_code_ostan"]==4))OR
		(($right_ins)and($_SESSION['mtStatusYear']==0)and($id_sahmiebandy)and($_SESSION["mt_code_ostan"]==8))OR
		(SuperUser()and($_SESSION['mtStatusYear']==0)and($id_sahmiebandy)and($activate_eblagh==1))
	    )
	    { echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	        <td width="10px">&nbsp;</td>';}
	 //}
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'sahmiebandy_kharid.php?id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'&PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت به منوی اصلی"  ><a href="#"></a></div></td> 
	 <td width="40px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNoGhr=1&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNoGhr='.$PrevPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNoGhr" value="'.$PageNoGhr.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNoGhr='.$NextPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNoGhr='.$MaxPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_gharardad']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'&open_filter=1\'"></td>';	 
	 echo'
     <td>
	  <span class="tedadcover" align="center" > تعداد کل ['.$cnt.'] 
	 </td> 	 
	</tr>';
    }
	if ($Mode=="Insert")  //Insert Mode
    {
	 $id_eblagh=$db->get_from_where("id_eblagh","sahmiebandy_kharid","id_sahmiebandy='$id_sahmiebandy'");
	 $max_kharid_ostan=$db->get_from_where("max_kharid_ostan","sahmiebandy_kharid","id_sahmiebandy='$id_sahmiebandy'");
     //وارداتی
	 if(($mahmule_type==2)or($mahmule_type==5)) $meghdar_gharardad_default=$max_kharid_ostan;
	//echo $id_eblagh;
	echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="6" align="center">ايجاد قرارداد جدید</td></tr>	   
	   <tr><td>&nbsp;</td></tr>
	   <tr>
		 <td align="left"';if(($mahmule_type==2)or($mahmule_type==5)) echo' width="240px" '; else  echo' width="140px" '; echo'><span class="star">*</span> شماره دستورالعمل :&nbsp; </td>
		 <td align="right" width="320px">
		  <input type="hidden" name="id_dastorolamal" value="'.$id_dastorolamal.'" />
		  <input type="text" class="textboxme" readonly name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'"/> 
       	  <img border="0" src="images/help.png" onClick="popupwindow(\'help_dastorolamal_kharid.php?id_eblagh='.$id_eblagh.'&mahmule_type='.$mahmule_type.'&code_ostan='.$code_ostan.'\',\'\',800,400)" title="شماره دستورالعمل" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
		 </td>
		 <td align="left"><span class="star">*</span> شماره سهمیه :&nbsp; </td>
		 <td align="right">
		   <input type="text" class="textboxme2" readonly name="id_sahmiebandy" value="'.$id_sahmiebandy.'"/>
		 </td>
		 <td align="left"> مقدار سهمیه:&nbsp; </td>
		 <td align="right"><input type="text" class="textboxme2" readonly name="max_kharid_ostan" value="'.$max_kharid_ostan.'"/> (کیلوگرم/عدد)</td>
		</tr>';
	   if(($mahmule_type==2)or($mahmule_type==5)) //وارداتی
	   {echo'
       <tr>
		<td align="left"><span class="star">*</span> شماره قرارداد  :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="shomare_gharardad" readonly value="'.$shomare_gharardad.'"  /></td>
        <td align="left"><span class="star">*</span> تاریخ قرارداد :&nbsp;</td>
		<td align="right"><input type="text" class="textboxme2" maxlength="10" name="tarikh_gharardad" readonly value="'.$tarikh_gharardad.'"/></td>
	    <td align="left"><span class="star">*</span> مقدار قرارداد :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_gharardad"  value="'.$meghdar_gharardad_default.'" onkeypress="return isNumber(event)" /> (کیلوگرم/عدد)</td>
	   </tr>
       <tr>
	    <td align="left"><span class="star">*</span> کد طرف قرارداد(فروشنده/کشتی) :&nbsp; </td>
	    <td align="right"><input type="text" class="textboxme2" readonly name="code_skk" value="'.$code_skk.'" /></td>
		<td align="left"><span class="star">*</span> طرف قرارداد (فروشنده /کشتی) :&nbsp; </td>
	    <td align="right" colspan="3"><input type="text" class="textboxme" readonly name="name_skk" value="'.$name_skk.'" /></td>
	   </tr>
	   <tr>
	   	<td align="left" width="110px"><span class="star">*</span> تاریخ شروع قرارداد :&nbsp; </td>
		<td align="right" width="150px"><input class="textboxme2 datepickerfrom" type="text" maxlength="10" name="tarikh_shoro"  value="'.$tarikh_shoro.'"/></td>	  
	   </tr>';
	   }
	   else //داخلی
	   {echo'
       <tr>
		<td align="left" width="150px"><span class="star">*</span> شماره قرارداد  :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="shomare_gharardad" value="'.$shomare_gharardad.'"/></td>
        <td align="left" width="150px"><span class="star">*</span> تاریخ قرارداد :&nbsp;</td>
		<td align="right" width="150px"><input type="text" class="textboxme2 datepickerfrom" maxlength="10" name="tarikh_gharardad"  value="'.$tarikh_gharardad.'"/></td>
		<td align="left" width="110px"><span class="star">*</span> تاریخ شروع قرارداد :&nbsp; </td>
		<td align="right" width="150px"><input class="textboxme2 datepickerfrom" type="text" maxlength="10" name="tarikh_shoro" value="'.$tarikh_shoro.'"/></td>	  
       </tr>
       <tr>
		<td align="left"><span class="star">*</span> طرف قرارداد (فروشنده) :&nbsp; </td>
	    <td align="right">
		 <input type="hidden" class="textboxme2" readonly name="code_skk" value="'.$code_skk.'"  />
		 <input type="text" class="textboxme" readonly name="name_skk" value="'.$name_skk.'" />';
		 include('img_helpcoding_mali.php');
		 //include('img_help_acc_mofaser.php');
		 echo'
		</td>
	    <td align="left" width="110px"><span class="star">*</span> تاریخ اتمام قرارداد :&nbsp; </td>
		<td align="right" width="150px"><input class="textboxme2 datepickerto" type="text" maxlength="10" name="tarikh_etmam" value="'.$tarikh_etmam.'"/></td>	  
	   

	    <!--<td align="left"><span class="star">*</span> مدت قرارداد :&nbsp; </td>
		    <td align="right"><input type="text" class="textboxme2" name="modat_gharardad" value="'.$modat_gharardad.'" onkeypress="return isNumber(event)" /> (روز)</td>-->
	   </tr>';
	   if($mahmule_type==1)
	   {
		 echo'	   
	     <tr>
	      <td align="left" width="140px">';if($mahmule_type==1)echo'<span class="star">*</span>';echo' کالا :&nbsp;</td>
		  <td align="right" width="320px">
		   <input type="hidden" name="id_gheymat_kharid" value="'.$id_gheymat_kharid.'" />
		   <input type="hidden" name="code_kala" value="'.$code_kala.'" />
		   <input type="text" class="textboxme" readonly name="name_kala" value="'.$name_kala.'"/>
	       <img border="0" src="images/help.png" onClick="popupwindow(\'help_gheymat_kharid.php?id_eblagh='.$id_eblagh.'&code_ostan='.$code_ostan.'&id_dastorolamal=\'+document.myform.id_dastorolamal.value+\'\',\'\',600,400)" title="جدول قیمت خرید" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
		  </td>
		  <td align="left">';if($mahmule_type==1)echo'<span class="star">*</span>';echo' قیمت هر کیلوگرم/عدد :&nbsp; </td>
		  <td align="right">
		   <input type="hidden" name="id_gheymat_kharid_this" value="'.$id_gheymat_kharid_this.'" />
		   <input type="text" class="textboxme2" readonly name="gheymat_har_kilo" value="'.$gheymat_har_kilo.'" onkeypress="return isNumber(event)"/> (ریال) 
		  </td>
	     </tr>';   
	   }
	   echo'
	   <tr>
		<td align="left"><span class="star">*</span> مقدار قرارداد :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_gharardad" value="'.$meghdar_gharardad.'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم/عدد)</td>
	    <!--<td align="left"> میزان افزایش حجم :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" readonly name="percentage_changes" value=0 onkeypress="return isNumber(event)" /> (%)</td>-->
		<td align="left"> مقدار جریمه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_jarime" value="'.$meghdar_jarime.'" onkeypress="return isNumber(event)" /> (ریال)</td>
		<td align="left"> نوع خط :&nbsp;</td><td align="right">'.static_listbox("noe_khat",$noe_khat,"noeKhatArr",1,"class='text4'").'</td>
	   </tr>
	   <tr>
	   	<td align="left"> میزان اثربخشی :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="mizan_asar" value="'.$mizan_asar.'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم/عدد)</td>
	   </tr>';
	   }
	   IF(($mahmule_type==2)OR($mahmule_type==3)OR($mahmule_type==5))   
	   { echo'
	     <tr>
	    	<td align="left"><span class="star">*</span> شماره ثبت سفارش :&nbsp; </td>
		    <td align="right"><input type="text" class="textboxme2" name="shomare_sabt_sefaresh" value="'.$shomare_sabt_sefaresh.'" onkeypress="return isNumber(event)" /> </td>
   	     </tr>';
	   }
	   echo'
	   <tr class="footer">
        <td colspan="8" align="center">
		 <input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if($Mode=="Edit")  //Edit Mode
    {
	 $q3=("SELECT T.*,kala.name_kala,kala.code_bastebandy,e_kh.shomare_eblagh,e_kh.activate_eblagh,e_kh.mahmule_type,d_kh.shomare_dastorolamal,s_kh.max_kharid_ostan,mt_skk.name_skk,e_kh.code_group_kala_top,
	      (SELECT shomare_safar FROM shomare_safar WHERE shomare_safar=T.shomare_gharardad) exist_safar_mojavez
	       From $TableName T 
		    INNER JOIN sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
		    INNER JOIN dastorolamal_kharid d_kh ON T.id_dastorolamal=d_kh.id_dastorolamal
		    INNER JOIN eblagh_kharid e_kh ON d_kh.id_eblagh=e_kh.id_eblagh
			INNER JOIN mt_skk ON T.code_skk=mt_skk.code_skk
			INNER JOIN ostan ON T.code_ostan=ostan.code_ostan
			LEFT JOIN kala ON kala.code_kala=T.code_kala
			LEFT JOIN gheymat_kharid ON gheymat_kharid.id_gheymat_kharid=T.id_gheymat_kharid
		   WHERE T.id_gharardad='$id_gharardad_' AND T.deleted=0");
	 //echo $id_gharardad_;
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
	 //کل تحویلی قرارداد
	 //قوطی /کنسرو
	 if($row3['code_group_kala_top']==6) $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row3['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$row3['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
	 //کارتن یا لاشه
	 else $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row3['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row3['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
	 $sum_tahvily_gharardad=round($sum_tahvily_gharardad,3);
	 //مانده قرارداد
	 //$mande_tahvily_gharardad=$row3['meghdar_gharardad']+$row3['mazad_gharardad']-$sum_tahvily_gharardad;
	 $mande_tahvily_gharardad=$row3['meghdar_gharardad_avaliye']+$row3['mazad_gharardad']-$sum_tahvily_gharardad;

	echo'
	<tr> 
	 <td width="99%" class="borderall"  style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات قرارداد شماره  '.$row3['shomare_gharardad'].'</td></tr>        
       <tr>
		<td align="left">شناسه قرارداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2 inputreadonly" name="id_gharardad" value='.$row3['id_gharardad'].' readonly  /></td>
		<td align="left">شماره ابلاغ :&nbsp; </td><td align="right"><input type="text" class="textboxme inputreadonly" name="shomare_eblagh" value="'.$row3['shomare_eblagh'].'" readonly  /></td>
	    <td colspan="8" align="left">
		 <table>
		  <tr style="line-height:30px">';		
	      //اگر اجازه ابطال داشته و این فرم هنوز ابطال نشده و سال فعال است
		  // if(($right_vaziyat)and($row3['termination']==1)and($_SESSION['mtStatusYear']==0))
		  // {
		    // echo'<td align="left"><input type="button" class="buttonme" name="terminate_x" value="اتمام قرارداد" onClick="iconfirm(\''.$FileName.'?terminate_x=1&id_gharardad_='.$row3['id_gharardad'].'&shomare_gharardad_='.$row3['shomare_gharardad'].'&sum_tahvily_gharardad='.$sum_tahvily_gharardad.'&PageNoGhr='.$PageNoGhr.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای فسخ قرارداد شماره  '.$row3['shomare_gharardad'].' \')"/></td>      
		         // <td width="20px"><img border="0" src="images/button-cross_basic.png" width="20" height="20" /></td>';}
		  
		  if($row3['termination']==1) echo'<td style="font-weight:bold;color:red;">وضعیت این فرم : جاری</td>';	
		  else echo'<td style="font-weight:bold;color:red;">وضعیت این فرم : بسته شده</td>';	
	      
		  echo'
           </tr>
		  </table>
		 </td>
	    </tr>
		<tr>
		 <td align="left" ';if(($row3['mahmule_type']==2)OR($row3['mahmule_type']==5)) echo' width="240px" '; else  echo' width="140px" '; echo'><span class="star">*</span> شماره دستورالعمل :&nbsp; </td>
		 <td align="right" width="320px"><input type="hidden" name="id_dastorolamal" value="'.$row3['id_dastorolamal'].'" /><input type="text" class="textboxme inputreadonly" readonly name="shomare_dastorolamal" value="'.$row3['shomare_dastorolamal'].'"/> ';
       	 //echo'<img border="0" src="images/help.png" onClick="popupwindow(\'help_dastorolamal_kharid.php?id_eblagh='.$row3['id_eblagh'].'\',\'\',600,600)" title="شماره دستورالعمل" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>';
         echo'
		 </td>
		 <td align="left"><span class="star">*</span> شناسه سهمیه :&nbsp; </td>
		 <td align="right"><input type="text" class="textboxme2 inputreadonly" readonly name="id_sahmiebandy" value="'.$row3['id_sahmiebandy'].'"/></td>
		 <td align="left" width="110px"> مقدار سهمیه :&nbsp; </td>
		 <td align="right" ><input type="text" class="textboxme2 inputreadonly" readonly name="max_kharid_ostan" value="'.$row3['max_kharid_ostan'].'"/> (کیلوگرم/عدد)</td>
        </tr>';
		if(($row3['mahmule_type']==2)OR($row3['mahmule_type']==5)) //وارداتی
	   {echo'
        <tr>
		 <td align="left"><span class="star">*</span> شماره قرارداد  :&nbsp; </td>
		 <td align="right"><input type="text" class="textboxme inputreadonly" name="shomare_gharardad" readonly value="'.$row3['shomare_gharardad'].'" /></td>
         <td align="left"><span class="star">*</span> تاریخ قرارداد :&nbsp;</td>
		 <td align="right"><input type="text" class="textboxme2" maxlength="10" name="tarikh_gharardad" value="'.$row3['tarikh_gharardad'].'" '; IF($right_edt) echo 'class="textboxme2 datepickerfrom"';  echo' readonly  /></td>
	     <td align="left"><span class="star">*</span> مقدار قرارداد :&nbsp; </td>
		 <td align="right"><input  type="text" class="textboxme2" name="meghdar_gharardad"  value="'.round($row3['meghdar_gharardad'],3).'" onKeydown="return PressfloatOnly(event,this)"    /> (کیلوگرم/عدد)</td>
		</tr>
        <tr>
	     <td align="left" width="120px"><span class="star">*</span> کد طرف قرارداد(فروشنده/کشتی) :&nbsp; </td>
	     <td align="right"><input type="text" class="textboxme2 inputreadonly" readonly name="code_skk" value="'.$row3['code_skk'].'" /></td>
		 <td align="left"><span class="star">*</span> طرف قرارداد (فروشنده /کشتی) :&nbsp; </td>
	     <td align="right" colspan="3"><input type="text" class="textboxme inputreadonly" readonly name="name_skk" value="'.$row3['name_skk'].'" /></td>
	    </tr>';
	   }
	   else
	   {
		echo'
	    <tr>
		 <td align="left" width="130px"><span class="star">*</span> شماره قرارداد  :&nbsp; </td>
		 <td align="right" ><input type="text" class="textboxme inputreadonly" name="shomare_gharardad" value="'.$row3['shomare_gharardad'].'"  readonly /></td>
         <td align="left" ><span class="star">*</span> تاریخ قرارداد :&nbsp;</td>
		 <td align="right"><input type="text" maxlength="10" name="tarikh_gharardad"  value="'.$row3['tarikh_gharardad'].'" '; IF($right_edt) echo 'class="textboxme2 datepickerfrom"';  echo' readonly   /></td>';
         if(($row3['mahmule_type']==4)OR($row3['mahmule_type']==5))//با آنالیز
	     {
		  $q_kala="SELECT * FROM gheymat_kharid INNER JOIN kala USING(code_kala) WHERE id_dastorolamal=".$row3['id_dastorolamal']."";
		  $res_kala=$db->query($q_kala);
		  echo'
	      <td rowspan="4" colspan="2">
		   <table width="99%" style="border:1px solid #000;font-size: 11px;">
		    <tr style="background-color:#A1dFF6;">
		     <td >کالا</td>
		     <td>معیار</td>
		     <td>درصد</td>
		     <td>میزان از قرارداد</td>
		    </tr>';
		    while($row_kala=$db->fetch_assoc($res_kala))
		    {
		 	  $meghdar=round($row3['meghdar_gharardad']+$row3['mazad_gharardad'],3);
			  $mizan=($row_kala['darsad']*$meghdar)/100;
		      echo'
		 	 <tr>
		       <td>'.$row_kala['name_kala'].'</td>
		       <td>'.$meyarArr[$row_kala['meyar']].'</td>
		       <td>'.$row_kala['darsad'].'</td>
		       <td>'.$mizan.'</td>
		      </tr>';
		    }
		    echo'
		   </table>
		  </td>';
	     }
		 echo'
		</tr>
		<tr>
		 <td align="left"><span class="star">*</span> طرف قرارداد (فروشنده) :&nbsp; </td>
	     <td align="right"><!--<input type="hidden" class="textboxme2" readonly name="id_skk" value="'.$row3['id_skk'].'"/>-->
		 <input type="hidden" class="textboxme2" readonly name="code_skk" value="'.$row3['code_skk'].'"/>
		 <input type="text" class="textboxme inputreadonly" readonly name="name_skk" value="'.$row3['name_skk'].'('.$row3['code_skk'].') "  />';
		 echo'
		 </td>
         <!--<td align="left"><span class="star">*</span> مدت قرارداد :&nbsp; </td>
		     <td align="right"><input type="text" class="textboxme2" name="modat_gharardad" value="'.$row3['modat_gharardad'].'" onkeypress="return isNumber(event)"/> (روز)</td>-->
		  <td align="left" width="120px"><span class="star">*</span> تاریخ شروع قرارداد :&nbsp; </td>
		  <td align="right"><input type="text" maxlength="10" name="tarikh_shoro" value="'.$row3['tarikh_shoro'].'" '; IF($right_edt) echo 'class="textboxme2 datepickerto"';  echo' readonly   /></td>
		 ';
		 echo'
		</tr>';
		if(($row3['mahmule_type']==1)OR($row3['mahmule_type']==3))
		{
		 echo'
	     <tr>
	      <td align="left" width="140px">';if($row3['mahmule_type']==1)echo'<span class="star">*</span>'; echo' کالا :&nbsp;</td>
		  <td align="right" width="320px">
		   <input type="hidden" name="id_gheymat_kharid" value="'.$row3['id_gheymat_kharid'].'" />
		   <input type="hidden" name="code_kala" value="'.$row3['code_kala'].'" />
		   <input  type="text" class="textboxme" readonly name="name_kala" value="'.$row3['name_kala'].'"/> ';
	      //echo'<img border="0" src="images/help.png" onClick="popupwindow(\'help_gheymat_kharid.php?id_eblagh='.$id_eblagh.'&id_dastorolamal=\'+document.myform.id_dastorolamal.value+\'\',600,600)" title="جدول قیمت خرید" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>';
          echo'
		  </td>
         </tr>
	     ';	
		}
		echo'<tr>';
	    if($row3['termination']!=1)//اگر فسخ شده مقدار اولیه قرارداد را نمایش بدهد
	    {echo'
		 <td align="left"><span class="star">*</span> مقدار اولیه قرارداد :&nbsp; </td>
		 <td align="right"><input type="text" class="textboxme2" name="meghdar_gharardad_avaliye" value="'.$row3['meghdar_gharardad_avaliye'].'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم/عدد)</td>';
		}
		echo'
		 <td align="left"><span class="star">*</span> مقدار قرارداد :&nbsp; </td>
		 <td align="right"><input readonly type="text" class="textboxme2 inputreadonly" name="meghdar_gharardad" value="'.round($row3['meghdar_gharardad'],3).'" onKeydown="return PressfloatOnly(event,this)"'; IF(!$right_edt) echo'readonly'; echo'  /> (کیلوگرم/عدد)';
		 IF($row3['percentage_changes']>0)echo'(میزان افزایش حجم :&nbsp;'.$row3['percentage_changes'].' %)';
		 echo'
		 </td>
	     <td align="left" width="100px"><span class="star">*</span> تاریخ اتمام قرارداد :&nbsp; </td>
		 <td align="right" width="150px"><input type="text" maxlength="10" name="tarikh_etmam" value="'.$row3['tarikh_etmam'].'" '; IF(($right_edt)OR($right_tarikh_etmam)) echo 'class="textboxme2 datepickerto"';  echo' readonly /></td>		
        </tr>
        <tr>	
	     <td align="left"> مقدار جریمه :&nbsp; </td>
		 <td align="right"><input type="text" class="textboxme2" name="meghdar_jarime" value="'.$row3['meghdar_jarime'].'" onkeypress="return isNumber(event)" /> (ریال)</td>
		 <td align="left"> نوع خط :&nbsp;</td><td align="right">'.static_listbox("noe_khat",$row3['noe_khat'],"noeKhatArr",1,"class='text4'").'</td>
	    </tr>';
	   }
	   echo'
	   <tr>
		<td align="left"> جمع کل تحویلی قرارداد :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2 inputreadonly" readonly name="sum_tahvily_gharardad" value="'.round($sum_tahvily_gharardad,3).'" /> (کیلوگرم/عدد)</td>
	   	<td align="left" > جمع کل مانده از قرارداد :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2 inputreadonly" readonly name="sum_tahvily_gharardad" value="'.round($mande_tahvily_gharardad,3).'" /> (کیلوگرم/عدد)</td>
	   </tr>
       <tr>
	    <td align="left">';if($row3['mahmule_type']==1)echo'<span class="star">*</span>'; echo' قیمت هر کیلوگرم/عدد :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2 inputreadonly" readonly name="gheymat_har_kilo" value="'.$row3['gheymat_har_kilo'].'" onkeypress="return isNumber(event)" /> (ریال)</td>
	    <td align="left"><span class="star">*</span> وضعیت قرارداد :&nbsp;</td><td align="right">'.static_listbox("termination",$row3['termination'],"typeGrArr",1,"class='text4'").'
		  	 <input type="hidden" name="mazad_gharardad" value="'.$row3['mazad_gharardad'].'" /> 

		</td>
	   	<td align="left"> میزان اثربخشی :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="mizan_asar" value="'.$row3['mizan_asar'].'" onkeypress="return PressfloatOnly(event,this)" /> (کیلوگرم/عدد)</td>
	   </tr>';
       IF(($row3['mahmule_type']==2)OR($row3['mahmule_type']==3)OR($row3['mahmule_type']==5))   
	   { echo'
	     <tr>
	    	<td align="left"><span class="star">*</span> شماره ثبت سفارش :&nbsp; </td>
		    <td align="right"><input type="text" class="textboxme2" name="shomare_sabt_sefaresh" value="'.$row3['shomare_sabt_sefaresh'].'" onkeypress="return isNumber(event)" /> </td>
   	     </tr>';
	   }
	   echo'
	   <tr class="footer">'; 
		 //if((SuperUser())and($row3['termination']==1)and($row3['activate']==1))
		 if(
	        (($right_edt)and($row3['termination']==1)and($_SESSION['mtStatusYear']==0)and($row3['activate_eblagh']==1))or
	        (($right_vaziyat)and($row3['termination']==1)and($_SESSION['mtStatusYear']==0)and($row3['activate_eblagh']==1))or
	        (($right_tarikh_etmam)and($row3['termination']==1)and($_SESSION['mtStatusYear']==0)and($row3['activate_eblagh']==1))or
	        ((SuperUser())and($row3['termination']==1)and($row3['activate_eblagh']==1))
		   )
		 {echo'
		  <td colspan="8" align="center">
		   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
           <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'">
		  </td>';
		 }
         else echo'<td  colspan="8" align="center" class="title"><div onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"></a></div></td> ';
         echo'
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if ($Mode=="Search" )//Search Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">جستجوی فرم قرارداد</td></tr>
       <tr>	
	    <td align="left" > شناسه قرارداد  :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="id_gharardad" value="'.$id_gharardad.'"/></td>
		<td align="left" > شماره قرارداد  :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_gharardad" value="'.$shomare_gharardad.'"/></td>
        <td align="left"> تاریخ قرارداد :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepickerfrom" type="text" maxlength="10" name="tarikh_gharardad" value="'.$tarikh_gharardad.'"/></td>
	   </tr>
	   <tr>
	   	<td align="left"> شماره ابلاغ :&nbsp; </td>
	    <td align="right">
	     <input type="hidden" name="id_eblagh" value="'.$id_eblagh.'"/>
	     <input type="hidden" name="meghdar_kharid_keshvar" value="'.$meghdar_kharid_keshvar.'"/>
	     <input type="text" class="textboxme2" name="shomare_eblagh" value="'.$shomare_eblagh.'"/>';
         include('img_eblagh.php');
	     echo'
		<td align="left"> شماره دستورالعمل :&nbsp; </td>
		<td align="right"><input type="hidden" class="textboxme2" name="id_sahmiebandy" value="'.$id_sahmiebandy.'"/>
		 <input type="text" class="textboxme2" name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'"/>';
		 include('img_dastor_search.php');
		 echo'
		</td>
		<td align="left"> تاریخ شروع قرارداد :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepickerfrom" type="text" maxlength="10" name="tarikh_shoro" value="'.$tarikh_shoro.'"/></td>
	   </tr>
	   <tr>
	    <td align="left"> استان :&nbsp;</td><td align="right">'.listbox("code_ostan_search",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
		<td align="left"> طرف قرارداد (فروشنده) :&nbsp; </td>
	    <td align="right"><!--<input type="hidden" class="textboxme2" readonly name="id_skk" value="'.$id_skk.'"/>-->
		 <input type="hidden" class="textboxme2" readonly name="code_skk" value="'.$code_skk.'"/>
		 <input type="text" class="textboxme2" readonly name="name_skk" value="'.$name_skk.'" />';
		 include('img_helpcoding_mali.php');
		 //include('img_help_acc_mofaser.php'); 
		echo'
		</td>
		<td align="left"> تاریخ اتمام قرارداد :&nbsp; </td>
		<td align="right"><input class="textboxme2 datepickerto" type="text" maxlength="10" name="tarikh_etmam" value="'.$tarikh_etmam.'"/></td>
	   </tr>
	   <tr>
	    <td align="left"> مدت قرارداد :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="modat_gharardad" value="'.$modat_gharardad.'"/> (روز)</td>
		<td align="left"> مقدار قرارداد :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_gharardad" value="'.$meghdar_gharardad.'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم/عدد)</td>
	    <td align="left"> میزان افزایش حجم :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="percentage_changes" value="'.$percentage_changes.'" onkeypress="return isNumber(event)" /> (%)</td>
	   </tr>
       <tr>	
		<td align="left"> قیمت هر کیلوگرم/عدد :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="gheymat_har_kilo" value="'.$gheymat_har_kilo.'" onkeypress="return isNumber(event)" /> (ریال)</td>
	    <td align="left"> مقدار جریمه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_jarime" value="'.$meghdar_jarime.'" onkeypress="return isNumber(event)" /> (ریال)</td>
	    <td align="left"> وضعیت :&nbsp;</td><td align="right">'.static_listbox("termination",-1,"typeGrArr",1,"class='text4'").'</td>
		<!--<td align="left"> نوع خط :&nbsp;</td><td align="right">'.static_listbox("noe_khat",$noe_khat,"noeKhatArr",1,"class='text4'").'</td>-->
	   </tr>   
	   <tr><td>&nbsp;</td></tr>
	   <tr class="footer">
        <td colspan="10" align="center">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if($Mode=="Tazmin")  //Tazmin Mode
    {
	 $q4=("SELECT * FROM tazmin WHERE id_gharardad='$id_gharardad_' AND deleted=0");
	 $res4=$db->query($q4);
	 echo'
	 <tr> 
	  <td width="80%"  class="borderall"  style="position:absolute;bottom:10px;left:10%;">	 	 
	   <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
	   <tr class="title"><td colspan="8" align="center"> تضامین قرارداد  '.$row3['shomare_gharardad'].'</td></tr>
	   <tr>
		 <td align="left"><span class="star">*</span> توضیحات تضمین :&nbsp;</td>
		 <td align="right">
		 <textarea required name="tozihat" value="'.$row3['tozihat'].'"  rows="3" cols="100" >
		 </textarea>
		 </td>
	   </tr>';
	   if(mysql_num_rows($res4)>0)
	   {
	    echo'
	    <tr>
		 <td colspan="2" >
		  <table width="100%" style="border:1px solid #000" >
		   <tr style="background-color:#A1dFF6;"><td colspan="3">تضامین ثبت شده</td></tr>
		   <tr style="background-color:#A1dFF6;">
		    <td width="20%">تاریخ ثبت</td>
		    <td width="70%">توضیحات تضمین</td>';
		    if($right_del)echo'<td width="10%">حذف</td>';
	        echo'
		   </tr>'; 
	       while($row4=$db->fetch_assoc($res4))
	       {
            echo'
	         <tr>
		      <td >'.$row4['tarikh_tazmin'].'</td>
		      <td >'.$row4['tozihat'].'</td>';
			  if($right_del)
	          {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" title="حذف" 
	               onmouseOver="this.src=\'images/trash_hover.png\'" 
	  	           onmouseOut="this.src=\'images/trash.png\'" 
	  	           onClick="iconfirm(\''.$FileName.'?Delete_T_x=1&id_tazmin_='.$row4['id_tazmin'].'&id_gharardad_='.$row1['id_gharardad'].'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&PageNoSahm='.$PageNoSahm.'\',\'برای حذف متن تضمین شماره '.$row4['id_tazmin'].' \')" /></td>';
	          }
			  echo'
	         </tr>';   
	        }
		   echo '
		   </table>
		  </td>
		 </tr>';   
	   }
       echo' 	   
	   <tr class="footer">'; 
		 if($right_ins_tazmin)
		 {echo'
		  <td colspan="8" align="center">
		   <input class="buttonme" type="submit" name="Tazmin_x" id="sabt" value="ثبت">
           <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'">
		  </td>';
		 }
         else echo'<td  colspan="8" align="center" class="title"><div onClick="window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"></a></div></td> ';
         echo'
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
</div>';
/**********اجازه براي ويرايش اطلاعات********/
function isPermitSave($sh_gh,$date_gh,$id_sahm,$code_skk,$date_shoro,$date_etmam,$modat,$meghdar,$percentage,$id_dastor,$id_gheymat,$gheymat,$meghdar_jar,$khat,$max_kh_ost,$mahmule,$date_dastor,$date_shoro_dastor,$gl_year,$today,$sh_sabt_sefaresh)
{
  //echo"<script>alert('".$date_dastor."')</script>";
  //echo"<script>alert($max_kh_ost)</script>";
  //echo"<script>alert($sh_gh)</script>";
  // echo"<script>alert($date_gh)</script>";
  //echo"<script>alert($id_sahm)</script>";
  // echo"<script>alert($code_skk)</script>";
  // echo"<script>alert($date_etmam)</script>";
  // echo"<script>alert($modat)</script>";
  // echo"<script>alert($meghdar)</script>";
  // echo"<script>alert($percentage)</script>";
  // echo"<script>alert($gheymat)</script>";
  // echo"<script>alert($meghdar_jar)</script>";
  //echo"<script>alert($id_gheymat)</script>";
  $flag=false;
  //مجموع قراردادهای این سهمیه
  $q_1="SELECT sum(meghdar_gharardad)AS SUMGHARARDAD FROM gharardad_kharid WHERE id_sahmiebandy=$id_sahm AND deleted=0";
  $res_1=mysql_query($q_1);
  $row_1=mysql_fetch_assoc($res_1);
  //مجموع مازاد قراردادهای این سهمیه 
  $q_2="SELECT sum(mazad_gharardad)AS SUMMAZAD FROM gharardad_kharid WHERE id_sahmiebandy=$id_sahm AND deleted=0";
  $res_2=mysql_query($q_2);
  $row_2=mysql_fetch_assoc($res_2);
  //مجموع مازاد قراردادهای این سهمیه (بسته شده ها) 
  $q_3="SELECT sum(mazad_gharardad)AS SUMMAZAD FROM gharardad_kharid WHERE id_sahmiebandy=$id_sahm AND deleted=0 AND terminatin!=1";
  $res_3=mysql_query($q_3);
  $row_3=mysql_fetch_assoc($res_3);
  //مازاد بسته شده هار ا کم میکنیم
  //$mazad=(($meghdar*$percentage)/100);
  $sum_Maghdair=$row_1['SUMGHARARDAD']+$row_2['SUMMAZAD']-$row_3['SUMMAZAD']+$meghdar+$mazad;
 if(!($gl_year))//اگر سشن سال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً سال مورد نظر خود راانتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($sh_gh and $date_gh and $date_shoro and $id_sahm and $code_skk and $meghdar and $id_dastor))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($mahmule==1)and(!($date_etmam and $id_gheymat and $gheymat)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 // if((($mahmule==2)OR($mahmule=4))and(!($sh_sabt_sefaresh)))//پر بودن فيلدها
 // {
   // $flag=false;
   // echo"<script>window.alert('$mahmule!');</script>";
   // echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   // return $flag;
 // } 
 // else $flag=true;
 // if(($mahmule==1)and($percentage>25))//پر بودن فيلدها
 // {
   // $flag=false;
   // echo"<script>window.alert('امکان میزان افزایش حجم بیشتر از 25 درصد وجود ندارد!');</script>";
   // return $flag;
 // } 
 // else $flag=true;
 if(!empty($sh_gh))//تکراري نبودن 
 {
   $q9="SELECT shomare_gharardad FROM gharardad_kharid WHERE shomare_gharardad='$sh_gh' AND deleted=0";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين شماره قرارداد قبلاً ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 if((checkdatejalali($date_gh)==false)or($date_gh>$today))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ قرارداد را با فرمت صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if($date_gh<$date_shoro_dastor)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('تاریخ قرارداد قبل از تاریخ شروع دستورالعمل است لطفا محدوده تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(($mahmule==1)and(checkdatejalali($date_etmam)==false))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ اتمام قرارداد را با فرمت صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(($mahmule==1)and($date_gh>$date_etmam))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('تاریخ اتمام قرارداد از تاریخ عقد قرارداد کمتر است!');</script>";
    return $flag;
 }
 else $flag=true;
 if($max_kh_ost<$sum_Maghdair)//
 {
  echo"<script>window.alert('مقادیر قرارداد از مقدار سهمیه بیشتر است !')</script>";
  $flag=false;
  return $flag;
 }
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($sh_gh,$date_gh,$id_sahm,$code_skk,$date_shoro,$date_etmam,$modat,$meghdar,$mazad,$percentage,$id_dastor,$id_gheymat,$gheymat,$meghdar_jar,$khat,$max_kh_ost,$gl_year,$mande_gharardad,$mahmule,$date_dastor,$date_shoro_dastor,$today,$sh_sabt_sefaresh,$this_id)
{
  $flag=false;
  //مجموع قراردادهای این سهمیه
  $q_1="SELECT sum(meghdar_gharardad)AS SUMGHARARDAD FROM gharardad_kharid WHERE id_sahmiebandy=$id_sahm AND deleted=0 AND id_gharardad!=$this_id";
  $res_1=mysql_query($q_1);
  $row_1=mysql_fetch_assoc($res_1);
  //مجموع مازاد قراردادهای این سهمیه 
  $q_2="SELECT sum(mazad_gharardad)AS SUMMAZAD FROM gharardad_kharid WHERE id_sahmiebandy=$id_sahm AND deleted=0  AND id_gharardad!=$this_id";
  $res_2=mysql_query($q_2);
  $row_2=mysql_fetch_assoc($res_2);
  //مجموع مازاد قراردادهای این سهمیه (بسته شده ها) 
  $q_3="SELECT sum(mazad_gharardad)AS SUMMAZAD FROM gharardad_kharid WHERE id_sahmiebandy=$id_sahm AND deleted=0  AND id_gharardad!=$this_id AND terminatin!=1";
  $res_3=mysql_query($q_3);
  $row_3=mysql_fetch_assoc($res_3);
  //مازاد بسته شده هار ا کم میکنیم
  //$mazad=(($meghdar*$percentage)/100);
  $sum_Maghdair=$row_1['SUMGHARARDAD']+$row_2['SUMMAZAD']-$row_3['SUMMAZAD']+$meghdar+$mazad;
  //echo"<script>alert($max_kh_ost)</script>";
  //echo"<script>alert($sum_Maghdair)</script>";

 if(!($gl_year))//اگر سشن سال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً سال مورد نظر خود راانتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($sh_gh and $date_gh and $code_skk and $meghdar and $id_dastor))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($mahmule==1)and(!($date_etmam  and $id_gheymat and $gheymat)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 // if((($mahmule==2)OR($mahmule=3))and(!($sh_sabt_sefaresh)))//پر بودن فيلدها
 // {
   // $flag=false;
   // echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   // return $flag;
 // } 
 // else $flag=true;
 if(($mahmule==1)and($percentage>25))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('امکان میزان افزایش حجم بیشتر از 25 درصد وجود ندارد!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($sh_gh))//تکراري نبودن 
 {
    $q10="SELECT shomare_gharardad FROM gharardad_kharid WHERE shomare_gharardad='$sh_gh' AND deleted=0 AND id_gharardad!=$this_id";
    $res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
	$idk=$row10['id'];
    if(mysql_num_rows($res10)>0){
      echo"<script>alert('اين شماره قرارداد قبلاً ثبت شده است')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
  }
 else $flag=true;
 if((checkdatejalali($date_gh)==false)or($date_gh>$today))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ قرارداد را با فرمت صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if($date_gh<$date_shoro_dastor)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('تاریخ قرارداد قبل از تاریخ شروع دستورالعمل است لطفا محدوده تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(($mahmule==1)and(checkdatejalali($date_etmam)==false))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ اتمام قرارداد را با فرمت صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
  if(($mahmule==1)and($date_gh>$date_etmam))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('تاریخ اتمام قرارداد از تاریخ عقد قرارداد کمتر است!');</script>";
    return $flag;
 }
 else $flag=true;
 //disabled in 1395/11/24
 // if(($mahmule==1)and($date_etmam))
 // {	
	// $q_2="SELECT COUNT(*) AS exist_resid FROM resid WHERE id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$sh_gh."') AND tarikh_resid>'$date_etmam'";
    // $res_2=mysql_query($q_2);
    // $row_2=mysql_fetch_assoc($res_2);
	// if($row_2['exist_resid']>0)
	// {
	 // $flag=false;
	 // echo"<script>window.alert('این قرارداد شامل رسیدهایی مابین این تاریخ است، لطفاً محدوده تاریخ معتبر را وارد نمایید!');</script>";
	 // return $flag;
	// }
	// else $flag=true; 
 // }
 // else $flag=true;
 
 //قراردادها از سهمیه بیشتر نباشد
 if(($termination==1)AND($max_kh_ost<$sum_Maghdair))
 {
  $flag=false;
  echo"<script>window.alert('مقادیر قرارداد از مقدار سهمیه بیشتر است !')</script>";
  return $flag;
 }
 else $flag=true;
 
 if($mande_gharardad<0)//اگر مقدار مانده منفی شد
 {
    //echo"<script>window.alert('$meghdar')</script>";
  echo"<script>window.alert('$mande_gharardad')</script>";
  $flag=false;
  echo"<script>window.alert('مقدار مانده از قرارداد منفی است امکان ثبت وجود ندارد !')</script>";
  return $flag;
 }
 else $flag=true;
return $flag;
}
/*************INSERT  BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
  $max_kharid_ostan=$db->get_from_where("max_kharid_ostan","sahmiebandy_kharid","id_sahmiebandy='$id_sahmiebandy'");
  $tarikh_dastorolamal=$db->get_from_where("tarikh_dastorolamal","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal'");
  $tarikh_shoro_dastorolamal=$db->get_from_where("tarikh_shoro_etebar","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal'");
  $mazad_gharardad=(($meghdar_gharardad*$percentage_changes)/100);
  if(isPermitSave($shomare_gharardad,$tarikh_gharardad,$id_sahmiebandy,$code_skk,$tarikh_shoro,$tarikh_etmam,$modat_gharardad,$meghdar_gharardad,$percentage_changes,$id_dastorolamal,$id_gheymat_kharid,$gheymat_har_kilo,$meghdar_jarime,$noe_khat,$max_kharid_ostan,$mahmule_type,$tarikh_dastorolamal,$tarikh_shoro_dastorolamal,$mtActiveYear,$today,$shomare_sabt_sefaresh))
  { 
   //if(SuperUser())echo"<script>window.alert('$gheymat_har_kilo')</script>";
   if($gheymat_har_kilo=='')
   {
	   $q="SELECT * FROM gheymat_kharid WHERE id_dastorolamal='$id_dastorolamal' AND deleted=0 ORDER BY id_gheymat_kharid DESC";
	   $res=mysql_query($q);
	   $row=mysql_fetch_assoc($res);
	   $gheymat_har_kilo=$row['gheymat_kharid'];
	   $id_gheymat_kharid=$row['id_gheymat_kharid'];
   }
	   
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $code_ostan=$db->get_from_where("code_ostan","sahmiebandy_kharid","id_sahmiebandy=$id_sahmiebandy");   
   //اگر وارداتی کد استان را قبل از شماره قرارداد میگذاریم 
   if(($mahmule_type=='2')OR($mahmule_type=='5')) $shomare_gharardad=$code_ostan.'-'.$shomare_gharardad;
   $insert_q=("INSERT INTO $TableName(shomare_gharardad,tarikh_gharardad,year,id_sahmiebandy,code_ostan,code_skk,tarikh_shoro,tarikh_etmam,modat_gharardad,meghdar_gharardad_avaliye,meghdar_gharardad,percentage_changes,mazad_gharardad,id_dastorolamal,id_gheymat_kharid,code_kala,gheymat_har_kilo,meghdar_jarime,noe_khat,termination,deleted,mizan_asar)
              VALUES('$shomare_gharardad','$tarikh_gharardad','$mtActiveYear','$id_sahmiebandy','$code_ostan','$code_skk','$tarikh_shoro','$tarikh_etmam','$modat_gharardad','$meghdar_gharardad','$meghdar_gharardad','$percentage_changes','$mazad_gharardad','$id_dastorolamal','$id_gheymat_kharid','$code_kala','$gheymat_har_kilo','$meghdar_jarime','$noe_khat',1,0,'$mizan_asar')"); 		 
   //echo $insert_q;
   $insert_res=mysql_query($insert_q);
    /*لاگ*/
    $max_id=$db->get_from_where("MAX(id_gharardad)","$TableName","");   
	$log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	//اگر در شماره سفر نبود
	$exist_mojavez=$db->get_from_where("count(*)","shomare_safar","shomare_safar='$shomare_gharardad' AND code_skk='$code_skk'");	
	if($exist_mojavez==0)$insert_safar=mysql_query("INSERT INTO shomare_safar(code_skk,shomare_safar,etmam_safar,code_ostan)VALUES('$code_skk',TRIM('$shomare_gharardad'),'0',$code_ostan)");  
	else $insert_safar=1;
	if($insert_res and $log_i and $insert_safar)
	{
	  mysql_query("COMMIT");
      echo '<script>window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\' </script>';
	}
	else  
    {
      mysql_query('ROLLBACK');
      echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";
    }
	mysql_query('SET AUTOCOMMIT=1');
 }//END isPermitSave
}//END INSERT	
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
 mysql_query('START TRANSACTION');
 //خواندن آی دی سهمیه برای فرم مستقیم قرارداد
 $id_sahmiebandy=$db->get_from_where("id_sahmiebandy","$TableName","id_gharardad='$id_gharardad_' AND deleted=0");
 $max_kharid_ostan=$db->get_from_where("max_kharid_ostan","sahmiebandy_kharid","id_sahmiebandy='$id_sahmiebandy'");
 //$code_bastebandy=$db->get_from_where("code_bastebandy","kala INNER JOIN eblagh_kharid ON eblagh_kharid.code_kala=kala.code_kala INNER JOIN sahmiebandy_kharid ON sahmiebandy_kharid.id_eblagh=eblagh_kharid.id_eblagh","id_sahmiebandy='$id_sahmiebandy'");
 $code_group_kala_top=$db->get_from_where("code_group_kala_top","$TableName T INNER JOIN dastorolamal_kharid d_kh ON T.id_dastorolamal=d_kh.id_dastorolamal INNER JOIN eblagh_kharid e_kh ON d_kh.id_eblagh=e_kh.id_eblagh","id_gharardad=$id_gharardad_");
 //کل تحویلی قرارداد
 //قوطی-کنسرو مرغ
 if($code_group_kala_top==6) $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$shomare_gharardad."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
 //کارتن یا لاشه
 else $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$shomare_gharardad."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
 $tarikh_dastorolamal=$db->get_from_where("tarikh_dastorolamal","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal'");
 $tarikh_shoro_dastorolamal=$db->get_from_where("tarikh_shoro_etebar","dastorolamal_kharid","id_dastorolamal='$id_dastorolamal'");
 //$mazad_gharardad=(($meghdar_gharardad*$percentage_changes)/100);
 //مانده قرارداد
 $mande_tahvily_gharardad=$meghdar_gharardad+$mazad_gharardad-$sum_tahvily_gharardad; 
 $mande_tahvily_gharardad=round($mande_tahvily_gharardad,3);
 if(isPermitEdit($shomare_gharardad,$tarikh_gharardad,$id_sahmiebandy,$code_skk,$tarikh_shoro,$tarikh_etmam,$modat_gharardad,$meghdar_gharardad,$mazad_gharardad,$percentage_changes,$id_dastorolamal,$id_gheymat_kharid,$gheymat_har_kilo,$meghdar_jarime,$noe_khat,$max_kharid_ostan,$mtActiveYear,$mande_tahvily_gharardad,$mahmule_type,$tarikh_dastorolamal,$tarikh_shoro_dastorolamal,$today,$shomare_sabt_sefaresh,$id_gharardad_))
 {
  $Mode='';
  $ebtal_res=TRUE;$log_d=TRUE;$edit_res_safar=TRUE;
  $edit_q=("UPDATE $TableName SET shomare_gharardad='$shomare_gharardad',tarikh_gharardad='$tarikh_gharardad',year='$mtActiveYear',id_sahmiebandy='$id_sahmiebandy',
            code_skk='$code_skk',tarikh_shoro='$tarikh_shoro',tarikh_etmam='$tarikh_etmam',modat_gharardad='$modat_gharardad',meghdar_gharardad_avaliye='$meghdar_gharardad',meghdar_gharardad='$meghdar_gharardad',
			percentage_changes='$percentage_changes',mazad_gharardad='$mazad_gharardad',id_dastorolamal='$id_dastorolamal',id_gheymat_kharid='$id_gheymat_kharid',code_kala='$code_kala',gheymat_har_kilo='$gheymat_har_kilo',
			meghdar_jarime='$meghdar_jarime',noe_khat='$noe_khat',termination='$termination',mizan_asar='$mizan_asar',shomare_sabt_sefaresh='$shomare_sabt_sefaresh' WHERE id_gharardad='$id_gharardad_';");         
  $edit_res=mysql_query($edit_q);
  $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_gharardad_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  /*کوئری لاگ*/ 
  //اتمام قرارداد
  if($termination!=1)
  {
    $ebtal_r_q ="UPDATE $TableName SET termination='$termination',meghdar_gharardad='$sum_tahvily_gharardad' WHERE id_gharardad='$id_gharardad_'";
    $ebtal_res=mysql_query($ebtal_r_q);
    /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_gharardad_','پایان قرارداد',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
    //در شماره سفر اتمام سفر بلی می شود
    $edit_safar=("UPDATE shomare_safar SET etmam_safar=1 WHERE shomare_safar='".$shomare_gharardad."'");         
    $edit_res_safar=mysql_query($edit_safar);		   
  }//END termination
  if($edit_res and $log_e and $ebtal_res and $log_d and $edit_res_safar)  
  { 
      mysql_query("COMMIT");
	  echo '<script>window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\' </script>';
  }
  else
  {
	  mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	  echo "<script>alert(' مشکلی در ویرایش مشخصات به وجود آمده است ')</script>";  
  }
  mysql_query('SET AUTOCOMMIT=1'); 
 }
}
/*****************************************************/
if (isset($Tazmin_x))
{
	  $insert_tazmin=("INSERT INTO tazmin(id_gharardad,tarikh_tazmin,tozihat)
               VALUES('$id_gharardad_','$today','$tozihat')");    
      $insert_tazmin=mysql_query($insert_tazmin);   
   echo '<script>window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\' </script>';
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_T_x))
{
 $Mode=''; 
 $del_q = "update tazmin set deleted=1 WHERE id_tazmin=$id_tazmin_";
 $del_res = mysql_query($del_q);
 echo '<script>window.location=\''.$FileName.'?PageNoGhr='.$PageNoGhr.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&PageNoSahm='.$PageNoSahm.'\' </script>';
   
}//END DELETE 
/*****************************************************/
echo'
</form>
</body>
</html>';	
?>