<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="sahmiebandy_kharid.php";
$TableName="sahmiebandy_kharid";
$titr='سهمیه بندی خرید استانها';
$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;$right_gharardad=0;
if (right(407)) $right_ins=1;
if (right(408)) $right_edt=1;
if (right(409)) $right_del=1; 
if (right(410)) $right_prt=1; 
if (right(421)) $right_gharardad=1; 
//$logtime=date('H:i:s');
//از صفحه ابلاغ آمده یا  نه
if($id_eblagh=='')$condition="";
else 
{
 $condition=" AND T.id_eblagh=$id_eblagh"; 
 $shomare_eblagh=$db->get_from_where("shomare_eblagh","eblagh_kharid","id_eblagh='$id_eblagh'");
 $titr.=" (شماره ابلاغ $shomare_eblagh)"; 
}
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$condition_ostan='';}
else {$condition_ostan=' AND T.code_ostan='.$mt_gl_code_ostan.'';}
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
<!-- تعویض کالا با انتخاب گروه کالا-->
 function getKalaFromGroup(code_gr_kala)
 {
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeGrK_T:code_gr_kala},function(data){$("[name=code_ostan]").html(data);});
   $("#loading").fadeOut("fast");		
 }
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_sahmiebandy']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 // if($shomare_dastorolamal)  $temp.=" and T.shomare_dastorolamal LIKE '%$shomare_dastorolamal%'";
 // if($tarikh_dastorolamal)   $temp.=" and T.tarikh_dastorolamal LIKE '%$tarikh_dastorolamal%'";
 if($shomare_eblagh)  $temp.=" and eblagh_kharid.shomare_eblagh LIKE '%$shomare_eblagh%'";
 if($code_ostan)            $temp.=" and T.code_ostan LIKE '$code_ostan'";
 if($max_kharid_ostan)      $temp.=" and T.max_kharid_ostan LIKE '%$max_kharid_ostan%'";
 if($kharid_type)           $temp.=" and T.kharid_type LIKE '%$kharid_type%'";
 if($temp) {$PageNoSahm=1;$_SESSION['mt_search_sahmiebandy']=$temp;} else $_SESSION['mt_search_sahmiebandy']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
//$res = $db->query("SELECT COUNT(*) FROM $TableName T WHERE 1=1 ".$_SESSION['mt_search_sahmiebandy']." $condition $condition_ostan AND year='$mtActiveYear' AND deleted=0");
$res = $db->query("SELECT COUNT(*) FROM $TableName T
      	INNER JOIN eblagh_kharid ON T.id_eblagh=eblagh_kharid.id_eblagh
		INNER JOIN bzacc.group_kala_top g ON g.code_group_kala_top=eblagh_kharid.code_group_kala_top
		INNER JOIN ostan ON ostan.code_ostan=T.code_ostan
		WHERE 1=1 ".$_SESSION['mt_search_sahmiebandy']." $condition $condition_ostan AND T.deleted=0");	
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNoSahm)) $PageNoSahm=1; //$PageNoSahm=$MaxPage;  
$NextPage=$PageNoSahm+1;
$PrevPage=$PageNoSahm-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNoSahm==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNoSahm==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0;
$Limit="Limit ".$FirstRow.",".$RowPerPage;
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
 mysql_query('START TRANSACTION'); 
 $del_q = "UPDATE $TableName SET deleted=1 WHERE id_sahmiebandy=$id_sahmiebandy_ AND ($id_sahmiebandy_ NOT IN (SELECT id_sahmiebandy FROM gharardad_kharid WHERE id_sahmiebandy=$id_sahmiebandy_))";
 $del_res = mysql_query($del_q);
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 /*لاگ*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_sahmiebandy_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
 if($del_res and $log_d)
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
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
$load="document.myform.shomare_dastorolamal.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:40%;">'.$titr.' </div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNoSahm.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title" >';
	/********************sort field***********************/
if(!isset($order))      $order='id_sahmiebandy DESC';
if(!isset($sortid))     $sortid='1';
if(!isset($sortshomare))$sortshomare='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sorteblagh))  $sorteblagh='1';
if(!isset($sortkala))   $sortkala='1';
if(!isset($show_img))   $show_img='';
	// if($sortshomare=='1')
	// {echo'<td width="10%" title="مرتب سازی صعودی شماره دستورالعمل " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=shomare_dastorolamal ASC&sortshomare=2&show_img=1\'"/> شماره دستورالعمل ';
	  // if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	// if($sortshomare=='2')
	// {echo'<td width="10%" title="مرتب سازی نزولی شماره دستورالعمل " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=shomare_dastorolamal DESC&sortshomare=1&show_img=1\'"/> شماره دستورالعمل ';
	  // if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	// if($sorttarikh=='1')
	// {echo'<td width="10%" title="مرتب سازی صعودی تاریخ دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=tarikh_dastorolamal ASC&sorttarikh=2&show_img=2\'"/> تاریخ دستورالعمل '; 
	  // if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	// if($sorttarikh=='2')
	// {echo'<td width="10%" title="مرتب سازی نزولی تاریخ دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=tarikh_dastorolamal DESC&sorttarikh=1&show_img=2\'"/> تاریخ دستورالعمل '; 
	  // if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	// if($sortkala=='1')
	// {echo'<td width="10%" title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=name_kala ASC&sortkala=2&show_img=4\'"/> نام کالا '; 
	  // if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	// if($sortkala=='2')
	// {echo'<td width="10%" title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=name_kala DESC&sortkala=1&show_img=4\'"/> نام کالا '; 
	  // if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
    if($sortid=='1')
	{echo'<td rowspan="2" width="3%" title="مرتب سازی صعودی شناسه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'&order=T.id_sahmiebandy ASC&sortid=2&show_img=1\'"/> شناسه '; 
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortid=='2')
	{echo'<td rowspan="2" width="3%" title="مرتب سازی نزولی شناسه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'&order=T.id_sahmiebandy DESC&sortid=1&show_img=1\'"/> شناسه '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
    if($sorteblagh=='1')
	{echo'<td rowspan="2" width="10%" title="مرتب سازی صعودی شماره ابلاغ" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'&order=T.shomare_eblagh ASC&sorteblagh=2&show_img=3\'"/> شماره ابلاغ '; 
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorteblagh=='2')
	{echo'<td rowspan="2" width="10%" title="مرتب سازی نزولی شماره ابلاغ" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'&order=T.shomare_eblagh DESC&sorteblagh=1&show_img=3\'"/> شماره ابلاغ '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}

	echo'
	 <td width="5%" rowspan="2">گروه کالا</td>
	 <td width="5%" rowspan="2">استان</td>
	 <td width="10%" rowspan="2">سهمیه تخصیص یافته (کیلوگرم/عدد)</td>
	 <td width="10%" rowspan="2">جمع قراردادهای منعقده</td>
	 <td width="10%" colspan="3">قراردادهای خاتمه یافته</td>
	 <td width="10%" colspan="3">قراردادهای جاری</td>
	 
	 
	 <!--<td width="10%" rowspan="2">جمع کل قراردادهای جاری و الحاقیه ها</td>
	 <td width="10%" rowspan="2">جمع کل مقدار تحویل شده از قراردادها(بسته شده)</td>
	 <td width="10%" rowspan="2">جمع کل (قراردادهای جاری والحاقیه ها و مقدار تحویلی قراردادهای بسته شده)</td>-->
	 <td width="5%" rowspan="2" nowrap >
	  مانده مجاز جهت انعقاد قرارداد
      <br/>
      از سهمیه تخصیص یافته	  
	 </td>

	 <td width="5%" rowspan="2">قرارداد</td>';
	 if($right_prt)echo'<td width="3%" rowspan="2">چاپ</td>';
	 if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td width="3%" rowspan="2">حذف</td>';
    echo'
	</tr>
	<tr class="table-title">
	 <td>جمع قرارداد</td>
	 <td>وزن تحویل شده</td>
	 <td>مقدار تحقق نشده از قرارداد</td>
	 <td>جمع قرارداد</td>
	 <td>وزن تحویل شده</td>
	 <td>مانده تعهدات قراردادهای جاری</td>
	</tr>';
	$i=0;

	$q1="SELECT *,ostan.name_ostan,name_group_kala_top From $TableName T
      	INNER JOIN eblagh_kharid ON T.id_eblagh=eblagh_kharid.id_eblagh
		INNER JOIN bzacc.group_kala_top g ON g.code_group_kala_top=eblagh_kharid.code_group_kala_top
		INNER JOIN ostan ON ostan.code_ostan=T.code_ostan
		WHERE 1=1 ".$_SESSION['mt_search_sahmiebandy']." $condition $condition_ostan AND T.deleted=0 order by $order $Limit";
	$all = $db->query($q1);
	while($row1=$db->fetch_assoc($all))
	{
     if(($right_edt)AND($id_eblagh!='')){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_sahmiebandy_='.$row1['id_sahmiebandy'].'&shomare_eblagh_='.$row1['shomare_dastorolamal'].'&PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'"';}	 
     if($i++%2)
	 {echo'<tr '; if($row1['status']==0) echo' class="table-odd"'; else echo 'class="row-ebtal"';echo'>';}	 
     else
	 {echo'<tr '; if($row1['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo'>';}
      $gharardadcount=$db->get_from_where("COUNT(*)","gharardad_kharid T","T.id_sahmiebandy='".$row1['id_sahmiebandy']."' AND deleted=0 $condition_ostan");
	  $sum_gharardad_avaliye=$db->get_from_where("SUM(meghdar_gharardad_avaliye)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0");
	  $sum_gharardad=$db->get_from_where("SUM(meghdar_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0");
	  $sum_gharardad_jari=$db->get_from_where("SUM(meghdar_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination=1");
	  $sum_gharardad_basteshode=$db->get_from_where("SUM(meghdar_gharardad_avaliye)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination!=1");
	  $sum_tahvil_basteshode=$db->get_from_where("SUM(meghdar_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination!=1");
	  $sum_mazad_gharardad_basteshode=$db->get_from_where("SUM(mazad_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination!=1");
	  $sum_mazad_gharardad_jari=$db->get_from_where("SUM(mazad_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination=1");
	  $sum_mazad_gharardad=$db->get_from_where("SUM(mazad_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0");
	  
	  $total_sum_resid_jari=0;
	  $q_gharardad="SELECT shomare_gharardad FROM gharardad_kharid WHERE id_sahmiebandy=".$row1['id_sahmiebandy']." AND deleted=0 AND termination=1";
 	  $all_gharardad = $db->query($q_gharardad);
	  while($row_g=$db->fetch_assoc($all_gharardad))
	  {
		$id_safar=$db->get_from_where("id_safar","shomare_safar","shomare_safar='".$row_g['shomare_gharardad']."'");  
	    $sum_resid=$db->get_from_where("SUM(vazn_khales_r)","meat.resid","id_safar='".$id_safar."' AND deleted=0 AND status=0");
	    $total_sum_resid_jari+=$sum_resid;
	  }
	  //$mande_gharardad=$row1['max_kharid_ostan']-$sum_gharardad-$sum_mazad_gharardad;
	  $mande_gharardad=$row1['max_kharid_ostan']-$sum_tahvil_basteshode-$sum_gharardad_jari-$sum_mazad_gharardad_jari;

	 echo'
	  <td '.$edtClick.'>'.$row1['id_sahmiebandy'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_eblagh'].'</td>
	  <td '.$edtClick.'>'.$row1['name_group_kala_top'].'</td>
	  <td '.$edtClick.'>'.$row1['name_ostan'].'</td>
	  <td '.$edtClick.'>'.($row1['max_kharid_ostan']).'</td>
	  <td '.$edtClick.'>'.round($sum_gharardad_avaliye+$sum_mazad_gharardad,3).'</td>
	  <td '.$edtClick.'>'.round($sum_gharardad_basteshode+$sum_mazad_gharardad_basteshode,3).'</td>
	  <td '.$edtClick.'>'.round($sum_tahvil_basteshode,3).'</td>
	  <td '.$edtClick.'>'.round($sum_gharardad_basteshode+$sum_mazad_gharardad_basteshode-$sum_tahvil_basteshode,3).'</td>
	  <td '.$edtClick.'>'.round($sum_gharardad_jari+$sum_mazad_gharardad_jari,3).'</td>
	  <td '.$edtClick.'>'.round($total_sum_resid_jari,3).'</td>
	  <td '.$edtClick.'>'.round($sum_gharardad_jari+$sum_mazad_gharardad_jari-$total_sum_resid_jari,3).'</td>
	  <!--<td '.$edtClick.'>'.round(($sum_gharardad_jari+$sum_mazad_gharardad),3).'</td>
	  <td '.$edtClick.'>'.round($sum_gharardad_basteshode,3).'</td>
	  <td '.$edtClick.'>'.round($sum_gharardad+$sum_mazad_gharardad,3).'</td>-->
	  <td '.$edtClick.'>'.round($mande_gharardad,3).'</td>
	  <td>';
	  if($right_gharardad) {echo'<input type="button" class="button-inline"  value="قرارداد['.$gharardadcount.']" onClick="window.location=\'gharardad_kharid.php?PageNoSahm='.$PageNoSahm.'&id_sahmiebandy='.$row1['id_sahmiebandy'].'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'">';}
	  echo'
	  </td>';
	  if($right_prt){echo'<td align="center"><div onClick="window.open(\'print_sahmiebandy_one.php?id_sahmiebandy_='.$row1['id_sahmiebandy'].'\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ تعدیل موجودی"><a href="#"></a></div></td>';}
	  if(($right_del)and($_SESSION['mtStatusYear']==0))
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" title="حذف" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_sahmiebandy_='.$row1['id_sahmiebandy'].'&PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\',\'برای حذف سهمیه بندی با شناسه '.$row1['id_sahmiebandy'].' \')" /></td>';
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
	  <td>&nbsp;</td>';
	  if($right_prt)echo'<td>&nbsp;</td>';
	  if(($right_del)and($_SESSION['mtStatusYear']==0))echo'<td>&nbsp;</td>';
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
	 <td width="24"><div onClick="window.open(\'print_sahmiebandy.php?id_sahmiebandy='.$id_sahmiebandy.'\',\'\',\'\')" id="printer" title="چاپ"><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>';
	 //اگر اجازه ایجاد رسید را دارد و وضعیت سال فعال است و سال فعال سال جاری است
	 //if(($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION["mtActiveYear"]==$yy))
	 if(($right_ins)and($_SESSION['mtStatusYear']==0)and($id_eblagh))
	 //if(($right_ins)and($_SESSION['mtStatusYear']==0))
	 { echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	        <td width="10px">&nbsp;</td>';}
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'eblagh_kharid.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت به منوی اصلی"  ><a href="#"></a></div></td> 
	 <td width="40px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNoSahm=1&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNoSahm='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNoSahm" value="'.$PageNoSahm.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNoSahm='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNoSahm='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_sahmiebandy']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'"></td>';	 
	 echo'
     <td>
	  <span class="tedadcover" align="center" > تعداد کل ['.$cnt.'] 
	 </td> 	 
	</tr>';
    }
	if ($Mode=="Insert" )  //Insert Mode
    {echo '
    <tr> 
	 <td width="90%" class="borderall" style="position:absolute;bottom:10px;left:5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="6" align="center">ايجاد سهمیه جدید</td></tr>	   
	   <tr><td>&nbsp;</td></tr>    
	   <tr>
	     <td align="left" width="150px"><span class="star">*</span> شماره ابلاغ :&nbsp; </td>
	     <td align="right"><input type="hidden" class="textboxme2" name="id_eblagh" value="'.$id_eblagh.'"/>
	   	 <input type="text" class="textboxme" readonly name="shomare_eblagh" value="'.$shomare_eblagh.'"/>';
	   if($id_eblagh=='')
	   {
	     include('img_eblagh.php');
	     echo'
	     </td>
	     <td align="left"> مقدار خرید :&nbsp;</td>
	     <td align="right"><input class="textboxme2" type="text" readonly name="meghdar_kharid_keshvar" value="'.$meghdar_kharid_keshvar.'"/> (کیلوگرم/عدد)</td>
        </tr>';
	   }
	   else
	   {
	     $q_eblagh="SELECT shomare_eblagh,meghdar_kharid_keshvar FROM eblagh_kharid WHERE id_eblagh=$id_eblagh";
	     $this_eblagh = $db->query($q_eblagh);
         $row_eblagh=$db->fetch_assoc($this_eblagh);
		 echo'
	      <td align="left"> مقدار خرید ابلاغ :&nbsp;</td>
	      <td align="right"><input class="textboxme2" type="text" readonly name="meghdar_kharid_keshvar" value="'.$row_eblagh['meghdar_kharid_keshvar'].'"/> (کیلوگرم/عدد)</td>
		</tr>';
	   }
	   
       echo'
	   <!--<tr>	
		<td align="left" ><span class="star">*</span> شماره دستورالعمل  :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'"/></td>
        <td align="left"><span class="star">*</span> تاریخ دستورالعمل :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_dastorolamal" id="datepicker6" value="'.$tarikh_dastorolamal.'"/></td>
       </tr>-->
	   <tr>
		<td align="left"><span class="star">*</span> استان :&nbsp;</td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
		<td align="left" ><span class="star">*</span> سهمیه تخصیص یافته :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="max_kharid_ostan" value="'.$max_kharid_ostan.'" onkeypress="return isNumber(event)" /> (کیلوگرم/عدد)</td>
	    <td align="left"><span class="star">*</span> وضعیت خرید :&nbsp;</td><td align="right">'.static_listbox("kharid_type",$kharid_type,"kharidTypeArr",1,"class='text4'").'</td>
	   </tr>
	   <tr><td>&nbsp;</td></tr>    
	   <tr class="footer">
        <td colspan="8" align="center">
		<input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
        <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if($Mode=="Edit")  //Edit Mode
    {
	 $q3=("SELECT T.*,eblagh_kharid.* FROM $TableName T 
		  INNER JOIN eblagh_kharid ON T.id_eblagh=eblagh_kharid.id_eblagh
		  WHERE T.id_sahmiebandy='$id_sahmiebandy_' AND T.deleted=0"); 
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
	 $sum_gharardad=$db->get_from_where("SUM(meghdar_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$row3['id_sahmiebandy']."");
	 $mande_gharardad=$row3['max_kharid_ostan']-$sum_gharardad;
	echo'
	<tr> 
	 <td width="90%" class="borderall" style="position:absolute;bottom:10px;left:5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات سهمیه شماره '.$row3['id_sahmiebandy'].'</td></tr>        
	   <tr><td>&nbsp;</td></tr>
	   <tr>
		<td align="left" width="150px"><span class="star">*</span> شماره ابلاغ :&nbsp; </td>
		<td align="right"><input type="hidden" class="textboxme2" readonly name="id_eblagh" value="'.$row3['id_eblagh'].'"/>
		<input type="text" class="textboxme" readonly name="shomare_eblagh" value="'.$row3['shomare_eblagh'].'"/>';
		//include('img_eblagh.php');
		echo'
		</td>
		<td align="left"> مقدار خرید ابلاغ :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" readonly name="meghdar_kharid_keshvar" value="'.virgul($row3['meghdar_kharid_keshvar']).'"/> (کیلوگرم/عدد)</td>
		<!--<td align="left"> قیمت خرید :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" readonly name="gheymat_kharid" value="'.virgul($row3['gheymat_kharid']).'"/> (ریال)</td>-->
       </tr>
	   <tr>
		<td align="left"><span class="star">*</span> استان :&nbsp;</td><td align="right">'.listbox("code_ostan",$row3['code_ostan'],"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
		<td align="left" ><span class="star">*</span> سهمیه تخصیص یافته :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="max_kharid_ostan" value="'.$row3['max_kharid_ostan'].'" onkeypress="return isNumber(event)" /> (کیلوگرم/عدد)</td>
	    <td align="left"><span class="star">*</span> وضعیت خرید :&nbsp;</td><td align="right">'.static_listbox("kharid_type",$row3['kharid_type'],"kharidTypeArr",1,"class='text4'").'</td>
	   </tr>
	   <tr>
		<td align="left" > جمع کل قراردادها :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" readonly name="sum_kharid_ostan" value="'.$sum_gharardad.'" /> (کیلوگرم/عدد)</td>
	   	<td align="left" > مانده از تخصیص :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" readonly name="sum_kharid_ostan" value="'.$mande_gharardad.'" /> (کیلوگرم/عدد)</td>
	   </tr>
	   <tr class="footer">'; 
		 if((($right_edt)and($row3['status']==0)and($_SESSION['mtStatusYear']==0))or((SuperUser())and($row3['status']==0)))
		 {echo'
		  <td colspan="8" align="center">
		   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
           <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'">
		  </td>';
		 }
         else echo'<td  colspan="8" align="center" class="title"><div onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"></a></div></td> ';
         echo'
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if ($Mode=="Search" )//Search Mode
    {echo '
    <tr> 
	 <td width="90%" class="borderall" style="position:absolute;bottom:10px;left:5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">جستجوی فرم سهمیه بندی</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>';
	   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	   echo'<td align="left"> استان :&nbsp;</td><td align="right">'.listbox("code_ostan",$row3['code_ostan'],"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>';
	   echo'
		<td align="left"> شماره ابلاغ :&nbsp; </td>
	    <td align="right">
	     <input type="hidden" name="id_eblagh" value="'.$id_eblagh.'"/>
	     <input type="hidden" name="meghdar_kharid_keshvar" value="'.$meghdar_kharid_keshvar.'"/>
	     <input type="text" class="textboxme2" name="shomare_eblagh" value="'.$shomare_eblagh.'"/>';
         include('img_eblagh.php');
        echo'
        </td>
	   </tr>
	   <tr>			
		<td align="left"> سهمیه تخصیص یافته :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="max_kharid_ostan" value="'.$row3['max_kharid_ostan'].'" onkeypress="return isNumber(event)" /> (کیلوگرم/عدد)</td>
	    <td align="left"> وضعیت خرید :&nbsp;</td><td align="right">'.static_listbox("kharid_type",$row3['kharid_type'],"kharidTypeArr",1,"class='text4'").'</td>
       </tr>	   
	   <tr><td>&nbsp;</td></tr>
	   <tr class="footer">
        <td colspan="10" align="center">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\'">
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
</div>';
/**********اجازه براي ويرايش اطلاعات********/
function isPermitSave($eblagh,$c_ostan,$meghdar,$type,$meghdar_kharid_kesh,$gl_year)
{
  //echo"<script>window.alert('$eblagh')</script>";
 
  $flag=false;
  $q_1="SELECT sum(max_kharid_ostan)AS SUMKHARID FROM sahmiebandy_kharid WHERE id_eblagh=$eblagh AND deleted=0";
  $res_1=mysql_query($q_1);
  $row_1=mysql_fetch_assoc($res_1);
  $sum_Maghdair=$row_1['SUMKHARID']+$meghdar;
  //echo"<script>window.alert('$sum_Maghdair')</script>";

 if(!($gl_year))//اگر سشن سال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً سال مورد نظر خود راانتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($eblagh and $c_ostan and $meghdar and $type))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if($eblagh and $c_ostan)//تکراري نبودن 
 {
	$q10="SELECT * FROM sahmiebandy_kharid WHERE id_eblagh='$eblagh' AND code_ostan=$c_ostan AND deleted=0";
    $res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
    if(mysql_num_rows($res10)>0){
      echo"<script>alert('برای این ابلاغ در این استان سهمیه تعیین شده است!')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
 }
 else $flag=true;
 
 if($meghdar_kharid_kesh<$sum_Maghdair)//
 {
  echo"<script>window.alert('مقدار سهمیه از مقدار خرید بیشتر است !')</script>";
  $flag=false;
  return $flag;
 }
 else $flag=true;
return $flag;
}
/*************INSERT  BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
  $meghdar_kharid_keshvar=str_replace(",","",$meghdar_kharid_keshvar);
  if(isPermitSave($id_eblagh,$code_ostan,$max_kharid_ostan,$kharid_type,$meghdar_kharid_keshvar,$mtActiveYear))
  { 
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $insert_q=("INSERT INTO $TableName
             (id_eblagh,code_ostan,max_kharid_ostan,kharid_type,year,deleted)
              VALUES
			 ('$id_eblagh','$code_ostan','$max_kharid_ostan','$kharid_type','$mtActiveYear',0)"); 		 
   echo $insert_q;
   $insert_res=mysql_query($insert_q);
    /*لاگ*/
    $max_id=$db->get_from_where("MAX(id_sahmiebandy)","$TableName","");   
	$log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	if($insert_res and $log_i)
	{
	  mysql_query("COMMIT");
      echo "<script>window.location='".$FileName."?PageNoSahm=".$PageNoSahm."&RowPerPage=".$RowPerPage."&order=".$order."&id_eblagh=".$id_eblagh."&PageNo=".$PageNo."';</script>";  
	}
	else  
    {
      mysql_query('ROLLBACK');
      echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";
    }
	mysql_query('SET AUTOCOMMIT=1');
 }//END isPermitSave
}//END INSERT	
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($eblagh,$c_ostan,$meghdar,$type,$meghdar_kharid_kesh,$gl_year,$this_id)
{
  $flag=false;
  $q_1="SELECT sum(max_kharid_ostan)AS SUMKHARID FROM sahmiebandy_kharid WHERE id_eblagh=$eblagh AND id_sahmiebandy!=$this_id  AND deleted=0";
  $res_1=mysql_query($q_1);
  $row_1=mysql_fetch_assoc($res_1);
  $sum_Maghdair=$row_1['SUMKHARID']+$meghdar;
    //echo"<script>window.alert(".$row_1['SUMKHARID'].")</script>";
    //echo"<script>window.alert('$sum_Maghdair')</script>";
 if(!($gl_year))//اگر سشن سال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً سال مورد نظر خود راانتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 //echo"<script>alert($c_ostan)</script>";
 if(!($eblagh and $c_ostan and $meghdar and $type))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if($eblagh and $c_ostan)//تکراري نبودن 
 {
	$q10="SELECT * FROM sahmiebandy_kharid WHERE id_eblagh='$eblagh' AND code_ostan=$c_ostan AND deleted=0 AND id_sahmiebandy!=$this_id";
    $res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
    if(mysql_num_rows($res10)>0){
      echo"<script>alert('برای این ابلاغ در این استان سهمیه تعیین شده است!')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
 }
 else $flag=true;
 if($meghdar_kharid_kesh<$sum_Maghdair)//
 {
  $flag=false;
  echo"<script>window.alert('مقدار سهمیه از مقدار خرید بیشتر است !')</script>";
  return $flag;
 }
 else $flag=true;
 
return $flag;
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 $meghdar_kharid_keshvar=str_replace(",","",$meghdar_kharid_keshvar);
 $sum_gharardad=$db->get_from_where("SUM(meghdar_gharardad)","meat.gharardad_kharid","id_sahmiebandy=".$id_sahmiebandy_."");
 if(isPermitEdit($id_eblagh,$code_ostan,$max_kharid_ostan,$kharid_type,$meghdar_kharid_keshvar,$mtActiveYear,$id_sahmiebandy_))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET id_eblagh='$id_eblagh',code_ostan='$code_ostan',max_kharid_ostan='$max_kharid_ostan',kharid_type='$kharid_type' WHERE id_sahmiebandy='$id_sahmiebandy_';");         
  $edit_res=mysql_query($edit_q);
  $edit_res_safar=true;
    
	if($kharid_type==2)//اتمام سهمیه بندی
    {  
     $q_gharardad="SELECT shomare_gharardad FROM gharardad_kharid WHERE id_sahmiebandy=$id_sahmiebandy_";
     $result=mysql_query($q_gharardad);
     while($row_gharardad=mysql_fetch_assoc($result))
     {
       $edit_safar=("UPDATE shomare_safar SET etmam_safar=1 WHERE shomare_safar='".$row_gharardad['shomare_gharardad']."'");         
	   $edit_res_safar=mysql_query($edit_safar);
     }
    }
	else //ادامه دار
	{  
     $q_gharardad="SELECT shomare_gharardad FROM gharardad_kharid WHERE termination=1 AND id_sahmiebandy=$id_sahmiebandy_";
     $result=mysql_query($q_gharardad);
     while($row_gharardad=mysql_fetch_assoc($result))
     {
       $edit_safar=("UPDATE shomare_safar SET etmam_safar=0 WHERE shomare_safar='".$row_gharardad['shomare_gharardad']."'");         
	   $edit_res_safar=mysql_query($edit_safar);
     }
    }
  if(($edit_res) and ($edit_res_safar))
  { 
	$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_sahmiebandy_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  /*کوئری لاگ*/ 
    echo '<script>window.location=\''.$FileName.'?PageNoSahm='.$PageNoSahm.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&PageNo='.$PageNo.'\' </script>';
  }
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';      
 }
}
/*****************************************************/
echo'
</form>
</body>
</html>';	
?>