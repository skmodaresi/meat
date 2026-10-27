<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="elhaghie_kharid.php";
$TableName="elhaghie_kharid";
$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;$right_tamin=0;
if (right(428)) $right_ins=1;
if (right(429)) $right_edt=1;
if (right(430)) $right_del=1;  
if (right(431)) $right_prt=1;
if (right(441)) $right_tamin=1;
$titr='الحاقیه قرارداد';
$q3="SELECT * From gharardad_kharid WHERE id_gharardad='$id_gharardad'";
$res3=$db->query($q3);
$row3=$db->fetch_assoc($res3);
$shomare_gharardad=$row3['shomare_gharardad'];
$tarikh_gharardad=$row3['tarikh_gharardad'];
$meghdar_gharardad=$row3['meghdar_gharardad'];
$gheymat=$row3['gheymat_har_kilo'];

$exist_elhaghie_date=$db->get_from_where("COUNT(*)","meat.elhaghie_kharid","id_gharardad='".$id_gharardad."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ");
if($exist_elhaghie_date>0)//اگر الحاقیه دارد
{
  //$tarikh_etmam_elhaghie=$db->get_from_where("tarikh_etmam_elhaghie","meat.elhaghie_kharid","id_gharardad='$id_gharardad' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ORDER BY tarikh_elhaghie,id_elhaghie DESC"); 
  //$tarikh_etmam=$tarikh_etmam_elhaghie;
  $tarikh_etmam=$db->get_from_where("tarikh_etmam_elhaghie","meat.elhaghie_kharid","id_gharardad='$id_gharardad' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ORDER BY tarikh_elhaghie,id_elhaghie DESC");  
}
else//اگر الحاقیه ندارد
{
 $tarikh_etmam=$row3['tarikh_etmam'];
}
$titr.=" (شماره قرارداد $shomare_gharardad)";
//برای وقتی از صفحه قرارداد امدیم
$id_eblagh=$db->get_from_where("id_eblagh","eblagh_kharid INNER JOIN sahmiebandy_kharid USING(id_eblagh)","id_sahmiebandy=".$row3['id_sahmiebandy']." AND sahmiebandy_kharid.deleted=0");
$activate_eblagh=$db->get_from_where("activate_eblagh","eblagh_kharid","id_eblagh='$id_eblagh'");
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
	  $(".datepicker6").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true
    });
});
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_elhaghie_kharid']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($shomare_elhaghie)    $temp.=" and shomare_elhaghie LIKE '%$shomare_elhaghie%'";
 if($tarikh_elhaghie)    $temp.=" and tarikh_elhaghie LIKE '$tarikh_elhaghie'";
 if($meghdar_type)  $temp.=" and meghdar_type LIKE '$meghdar_type'";
 if($meghdar_elhaghie)    $temp.=" and meghdar_elhaghie LIKE '%$meghdar_elhaghie%'";
 if($modat_type)  $temp.=" and modat_type LIKE '$modat_type'";
 if($modat_gharardad_elhaghie)    $temp.=" and modat_gharardad_elhaghie LIKE '%$modat_gharardad_elhaghie%'";
 if($tarikh_etmam_elhaghie)    $temp.=" and tarikh_etmam_elhaghie LIKE '$tarikh_etmam_elhaghie'";
 if($gheymat_type)  $temp.=" and gheymat_type LIKE '$gheymat_type'";
 if($gheymat_elhaghie)    $temp.=" and gheymat_elhaghie LIKE '%$gheymat_elhaghie%'";
 if($temp) {$PageNo_detail=1;$_SESSION['mt_search_elhaghie_kharid']=$temp;} else $_SESSION['mt_search_elhaghie_kharid']="";
}
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;$count=1;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_elhaghie_kharid']." AND id_gharardad=$id_gharardad AND deleted=0");
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo_detail)) $PageNo_detail=1; //$PageNo_detail=$MaxPage; 
$NextPage=$PageNo_detail+1;
$PrevPage=$PageNo_detail-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNo_detail==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNo_detail==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0; 
$Limit="Limit ".$FirstRow.",".$RowPerPage; 
$radif=($PrevPage*$RowPerPage)+1;//محاسبه ردیف
if ($radif<0) $radif=1;
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_elhaghie.focus();">
<form method="post" name="myform" onkeydown="enter();">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:37%;">'.$titr.'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo_detail.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id_elhaghie DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sorttarikhshoro)) $sorttarikhshoro='1';
if(!isset($show_img)) $show_img='';
	echo '<td width="5%">شناسه</td>';
	if($sortcode=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی شماره" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&order=shomare_elhaghie ASC&sortcode=2&show_img=1\'"/> شماره الحاقیه ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی شماره" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&order=shomare_elhaghie DESC&sortcode=1&show_img=1\'"/> شماره الحاقیه ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی تاریخ " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&order=tarikh_shoro_etebar ASC&sorttarikh=2&show_img=2\'"/> تاریخ الحاقیه '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی تاریخ" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&order=tarikh_shoro_etebar DESC&sorttarikh=1&show_img=2\'"/> تاریخ الحاقیه '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	 echo'
	 <td width="8%">وضعیت مقدار</td>
	 <td width="8%">مقدار الحاقیه</td>
	 <td width="8%">میزان اثربخشی</td>
	 <td width="8%">وضعیت مدت قرارداد</td>
	 <td width="8%">مدت قرارداد الحاقیه</td>
	 <td width="8%">تاریخ اتمام قرارداد</td>
	 <td width="8%">وضعیت قیمت</td>
	 <td width="8%">قیمت هر کیلوگرم</td>';
     if($right_tamin)echo'<td width="7%">درخواست تأمین اعتبار</td>';
	 if((($right_del)AND($today<=$tarikh_etmam))OR(($right_del)AND($role_id==10))OR(SuperUser())) echo'<td width="4%">حذف</td>';
	 echo'
	</tr>';
	$i=0;
    $q1="SELECT * From $TableName T WHERE 1=1 ".$_SESSION['mt_search_elhaghie_kharid']." AND id_gharardad=$id_gharardad AND deleted=0 order by $order $Limit";
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     $tamincount=$db->get_from_where("COUNT(*)","tamin_etebar","id_elhaghie='".$row1['id_elhaghie']."' AND deleted='0'");
	 if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_elhaghie_='.$row1['id_elhaghie'].'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	  echo'
	  <td '.$edtClick.'>'.$row1['id_elhaghie'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_elhaghie'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_elhaghie'].'</td>
	  <td '.$edtClick.'>'.$elhaghtypeArr[$row1['meghdar_type']].'</td>
	  <td '.$edtClick.'>'.$row1['meghdar_elhaghie'].'</td>
	  <td '.$edtClick.'>'.$row1['mizan_asar'].'</td>
	  <td '.$edtClick.'>'.$elhaghtypeArr[$row1['modat_type']].'</td>
	  <td '.$edtClick.'>'.$row1['modat_gharardad_elhaghie'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_etmam_elhaghie'].'</td>
	  <td '.$edtClick.'>'.$elhaghtypeArr[$row1['gheymat_type']].'</td>
	  <td '.$edtClick.'>'.$row1['gheymat_elhaghie'].'</td>';
	  if($right_tamin) {echo'<td><input type="button" class="button-inline"  style="min-width:50px;" value=" ['.$tamincount.']" onClick="window.location=\'tamin_etebar_el.php?PageNo='.$PageNo.'&id_elhaghie='.$row1['id_elhaghie'].'&id_gharardad='.$row1['id_gharardad'].'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'"></td>';}
	  if((($right_del)AND($today<=$tarikh_etmam))OR(($right_del)AND($role_id==10))OR(SuperUser()))
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_elhaghie_='.$row1['id_elhaghie'].'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\',\'برای حذف الحاقیه با شماره  '.$row1['shomare_elhaghie'].' \')" /></td>';
	  }
	echo '
	</tr>';
	}
    for ($r=$i+1; $r<=$RowPerPage; $r++)
    {if($r%2) echo '
     <tr class="table-even">';
     else echo '
     <tr class="table-odd">';
     echo'
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
	  if($right_tamin) echo'<td>&nbsp;</td>';
	  if((($right_del)AND($today<=$tarikh_etmam))OR(($right_del)AND($role_id==10))OR(SuperUser())) echo'<td>&nbsp;</td>';
     echo'
	 </tr>';
	}
	//هشدار
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
	 	 // if(
	  // (($right_ins)AND($role_id!=10)AND($today<=$tarikh_etmam)AND($activate_eblagh==1)AND($_SESSION["mt_code_ostan"]!=4))OR
	  // (($right_ins)AND($role_id!=10)AND($today<=$tarikh_etmam)AND($_SESSION["mt_code_ostan"]==4))OR
	  // (($right_ins)AND($role_id==10)AND($activate_eblagh==1))OR
	  // ((SuperUser())AND($activate_eblagh==1))
	  // )
	 
	 if(
	  (($right_ins)AND($today<=$tarikh_etmam)AND($activate_eblagh==1)AND($_SESSION["mt_code_ostan"]!=4))OR
	  (($right_ins)AND($today<=$tarikh_etmam)AND($_SESSION["mt_code_ostan"]==4))OR
	  ((SuperUser())AND($activate_eblagh==1))
	  )
	 {
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10px">&nbsp;</td>';}
	 echo'
	 <td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'gharardad_kharid.php?PageNo='.$PageNo.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-back"  title="بازگشت"  ><a href="#"></a></div></td> 
	 <td width="20px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail=1&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$PrevPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$NextPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$MaxPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_elhaghie_kharid']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>	 	 
	</tr>';
    }
	if ($Mode=="Insert" )  //Insert Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="6" align="center">ايجاد الحاقیه جدید</td></tr>	   
	   <tr>
		<td align="left"> شماره قرارداد :&nbsp; </td>
		<td align="right"><input type="text" readonly class="textboxme2" name="shomare_gharardad" value="'.$shomare_gharardad.'"/></td>
        <td align="left""> تاریخ قرارداد :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" readonly name="tarikh_gharardad" value="'.$tarikh_gharardad.'"/></td>
        <td align="left""> مقدار قرارداد :&nbsp;</td>
        <td align="right"><input class="textboxme2" type="text" readonly name="meghdar_gharardad" value="'.$meghdar_gharardad.'"/></td>       
	   </tr>
	   <tr>
		<td align="left"><span class="star">*</span> شماره الحاقیه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_elhaghie" value="'.$shomare_elhaghie.'"/></td>
        <td align="left"><span class="star">*</span> تاریخ الحاقیه :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_elhaghie" value="'.$tarikh_elhaghie.'"/></td>
        <td align="left"><span class="star">*</span> تاریخ شروع الحاقیه :&nbsp; </td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_shoro_elhaghie" value="'.$tarikh_shoro_elhaghie.'"/></td> 
	   </tr>
	   <tr>
        <td align="left"> وضعیت مقدار :&nbsp; </td>
		<td align="right">'.static_listbox("meghdar_type",$meghdar_type,"elhaghtypeArr",1,"class='text4'").'</td> 
        <td align="left"> مقدار الحاقیه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_elhaghie" value="'.$meghdar_elhaghie.'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم)</td>
	   	<td align="left"> میزان اثربخشی :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="mizan_asar" value="'.$mizan_asar.'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم)</td>
	   </tr>
	   <tr>
        <td align="left"> وضعیت مدت قرارداد :&nbsp; </td>
		<td align="right">'.static_listbox("modat_type",$modat_type,"elhaghtypeArr",1,"class='text4'").'</td> 
	    <td align="left">تاریخ اتمام قرارداد :&nbsp; </td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_etmam_elhaghie" value="'.$tarikh_etmam_elhaghie.'"/></td>	  
		<!--<td align="left"> مدت قرارداد الحاقیه :&nbsp; </td>
		    <td align="right"><input type="text" class="textboxme2" name="modat_gharardad_elhaghie" value="'.$modat_gharardad_elhaghie.'" onkeypress="return isNumber(event)" /> (روز)</td>-->
	  </tr>
	  <tr>
	   <td align="left"> وضعیت قیمت :&nbsp; </td>
	   <td align="right">'.static_listbox("gheymat_type",$gheymat_type,"elhaghtypeArr",1,"class='text4'").'</td>';
	   //اگر از صفحه قرارداد خرید بیاید آی دی ابلاغ را بدست بیاورم
		$id_eblagh=$db->get_from_where("id_eblagh","gharardad_kharid INNER JOIN sahmiebandy_kharid USING(id_sahmiebandy) INNER JOIN eblagh_kharid USING(id_eblagh)","id_gharardad='$id_gharardad'");
		echo'
		<td align="left"> شماره دستورالعمل :&nbsp; </td>
	    <td align="right">
		  <input type="hidden" name="id_dastorolamal" value="'.$id_dastorolamal.'" />
		  <input type="text" class="textboxme2" readonly name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'"/> 
       	  <img border="0" src="images/help.png" onClick="popupwindow(\'help_dastorolamal_elhagh.php?id_gharardad='.$id_gharardad.'&id_eblagh='.$id_eblagh.'\',\'\',800,400)" title="شماره دستورالعمل" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
	
		</td>
	   <td align="left"> قیمت نهایی کالا پس از اعمال الحاقیه :&nbsp; </td>
	   <td align="right"><input type="text" readonly class="textboxme2" name="gheymat_elhaghie" value="'.$gheymat_elhaghie.'" onkeypress="return isNumber(event)"/> (ریال) </td>

	  </tr>
	  <tr>
        <td colspan="8" align="center" class="title">
		<input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
        <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if($Mode=="Edit")  //Edit Mode
    {
	 $q3="SELECT * From $TableName T LEFT JOIN dastorolamal_kharid USING(id_dastorolamal) WHERE id_elhaghie=$id_elhaghie_";
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
	echo'
	<tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات شماره الحاقیه  '.$row3['shomare_elhaghie'].'</td></tr>        
	   <tr>
		<td align="left"> شماره قرارداد :&nbsp; </td>
		<td align="right"><input type="text" readonly class="textboxme2" name="shomare_gharardad" value="'.$shomare_gharardad.'"/></td>
        <td align="left""> تاریخ قرارداد :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" readonly name="tarikh_gharardad" value="'.$tarikh_gharardad.'"/></td>
        <td align="left""> مقدار قرارداد :&nbsp;</td>
        <td align="right"><input class="textboxme2" type="text" readonly name="meghdar_gharardad" value="'.$meghdar_gharardad.'"/></td>       
	   </tr>
	   <tr>
		<td align="left"><span class="star">*</span> شماره الحاقیه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="shomare_elhaghie" value="'.$row3['shomare_elhaghie'].'"/></td>
        <td align="left""><span class="star">*</span> تاریخ الحاقیه :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_elhaghie" value="'.$row3['tarikh_elhaghie'].'"/></td>
        <td align="left"><span class="star">*</span> تاریخ شروع الحاقیه :&nbsp; </td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_shoro_elhaghie" value="'.$row3['tarikh_shoro_elhaghie'].'"/></td> 
	   </tr>
	   <tr>
        <td align="left"> وضعیت مقدار :&nbsp; </td>
		<td align="right">'.static_listbox("meghdar_type",$row3['meghdar_type'],"elhaghtypeArr",1,"class='text4'").'</td> 
	   	<td align="left"> مقدار الحاقیه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_elhaghie" value="'.$row3['meghdar_elhaghie'].'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم)</td>
	   	<td align="left"> میزان اثربخشی :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="mizan_asar" value="'.$row3['mizan_asar'].'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم)</td>
	   </tr>
	   <tr>
        <td align="left"> وضعیت مدت قرارداد :&nbsp; </td>
		<td align="right">'.static_listbox("modat_type",$row3['modat_type'],"elhaghtypeArr",1,"class='text4'").'</td> 
	    <td align="left">تاریخ اتمام قرارداد :&nbsp; </td>
        <td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_etmam_elhaghie" value="'.$row3['tarikh_etmam_elhaghie'].'"/></td>	  
		<!--<td align="left"> مدت قرارداد الحاقیه :&nbsp; </td>
		    <td align="right"><input type="text" class="textboxme2" name="modat_gharardad_elhaghie" value="'.$row3['modat_gharardad_elhaghie'].'" onkeypress="return isNumber(event)" /> (روز)</td>-->
	  </tr>
	  <tr>
	   <td align="left"> وضعیت قیمت :&nbsp; </td>
	   <td align="right">'.static_listbox("gheymat_type",$row3['gheymat_type'],"elhaghtypeArr",1,"class='text4'").'</td>';
	   //اگر از صفحه قرارداد خرید بیاید آی دی ابلاغ را بدست بیاورم
		$id_eblagh=$db->get_from_where("id_eblagh","gharardad_kharid INNER JOIN sahmiebandy_kharid USING(id_sahmiebandy) INNER JOIN eblagh_kharid USING(id_eblagh)","id_gharardad='$id_gharardad'");
		echo'
		<td align="left"> شماره دستورالعمل :&nbsp; </td>
	    <td align="right">
		  <input type="hidden" name="id_dastorolamal" value="'.$row3['id_dastorolamal'].'" />
		  <input type="text" class="textboxme2" readonly name="shomare_dastorolamal" value="'.$row3['shomare_dastorolamal'].'"/> 
       	  <img border="0" src="images/help.png" onClick="popupwindow(\'help_dastorolamal_elhagh.php?id_eblagh='.$id_eblagh.'&mahmule_type='.$mahmule_type.'\',\'\',800,400)" title="شماره دستورالعمل" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
		</td>
	   <td align="left"> قیمت نهایی کالا پس از اعمال الحاقیه :&nbsp; </td>
	   <td align="right"><input type="text" class="textboxme2" readonly name="gheymat_elhaghie" value="'.$row3['gheymat_elhaghie'].'" onkeypress="return isNumber(event)"/> (ریال) </td>
	  </tr>
	  <tr>'; 
	  	 if((($right_edt)AND($today<=$tarikh_etmam))OR(($right_edt)AND($role_id==10))OR(SuperUser()))
		 {echo'
		  <td colspan="8" align="center" class="title">
		   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
           <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'">
		  </td>';
		 }
         else echo'<td  colspan="8" align="center" class="title"><div onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"></a></div></td> ';
         echo'
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if ($Mode=="Search" )//Search Mode
    {echo '
    <tr> 
	 <td width="100%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">جستجوی فرم الحاقیه</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
		<td align="left" > شماره الحاقیه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_elhaghie" value="'.$shomare_elhaghie.'"/></td>
        <td align="left"> تاریخ الحاقیه :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_elhaghie" value="'.$tarikh_elhaghie.'"/></td>
        <td align="left"> تاریخ شروع الحاقیه :&nbsp; </td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_shoro_elhaghie" value="'.$tarikh_shoro_elhaghie.'"/></td> 
	   </tr>
	   <tr>
        <td align="left"> وضعیت مقدار :&nbsp; </td>
		<td align="right">'.static_listbox("meghdar_type",$meghdar_type,"elhaghtypeArr",1,"class='text4'").'</td> 
	    <td align="left"> مقدار الحاقیه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_elhaghie" value="'.$meghdar_elhaghie.'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم)</td>  
	   </tr>
	   <tr>
        <td align="left"> وضعیت مدت قرارداد :&nbsp; </td>
		<td align="right">'.static_listbox("modat_type",$modat_type,"elhaghtypeArr",1,"class='text4'").'</td> 
	    <td align="left">تاریخ اتمام قرارداد :&nbsp; </td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_etmam_elhaghie" value="'.$tarikh_etmam_elhaghie.'"/></td>	  
		<!--<td align="left"> مدت قرارداد الحاقیه :&nbsp; </td>
		    <td align="right"><input type="text" class="textboxme2" name="modat_gharardad_elhaghie" value="'.$modat_gharardad_elhaghie.'" onkeypress="return isNumber(event)" /> (روز)</td>-->
	  </tr>	   
	  <tr>
	   <td align="left"> وضعیت قیمت :&nbsp; </td>
	   <td align="right">'.static_listbox("gheymat_type",$gheymat_type,"elhaghtypeArr",1,"class='text4'").'</td>  
	   <td align="left"> قیمت نهایی کالا پس از اعمال الحاقیه :&nbsp; </td>
	   <td align="right"><input type="text" class="textboxme2" name="gheymat_elhaghie" value="'.$gheymat_elhaghie.'" onkeypress="return isNumber(event)"/> (ریال) </td>
	  </tr>
	   <tr>
        <td colspan="10" align="center" class="title">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'">
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
 <!-- پايان فوتر-->	
</table>
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($gharardad,$shomare,$tarikh,$gheymat_type,$gheymat_elhaghie,$id_dastorolamal)
{
 $flag=false;  
 if(!($gharardad and $shomare and $tarikh))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(checkdatejalali($tarikh)==false)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را با فرمت صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if($gheymat_type>0)
 {	
	if((!$id_dastorolamal)and(!$gheymat_elhaghie))
	{
	 $flag=false;
	 echo"<script>window.alert('لطفا دستورالعمل قیمت کالا را انتخاب نمایید!');</script>";
     return $flag;	 
	}
	else $flag=true;
 }
 else $flag=true;
 if($id_dastorolamal>0)
 {
	if($gheymat_type==0)
	{
	 $flag=false;
	 echo"<script>window.alert('لطفا وضعیت قیمت را انتخاب نمایید!');</script>";
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
 if(isPermitSave($id_gharardad,$shomare_elhaghie,$tarikh_elhaghie,$gheymat_type,$gheymat_elhaghie,$id_dastorolamal))
 {
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   if($gheymat_type==0){$id_dastorolamal=0;$gheymat_elhaghie=0;}
   $insert_res=true;$log_i=true;$res_update_gharardad=true;
   $insert_q=("INSERT INTO $TableName(id_gharardad,shomare_elhaghie,tarikh_elhaghie,meghdar_type,meghdar_elhaghie,modat_type,modat_gharardad_elhaghie,tarikh_shoro_elhaghie,tarikh_etmam_elhaghie,gheymat_type,gheymat_elhaghie,id_dastorolamal,deleted,mizan_asar)
               VALUES('$id_gharardad','$shomare_elhaghie','$tarikh_elhaghie','$meghdar_type','$meghdar_elhaghie','$modat_type','$modat_gharardad_elhaghie','$tarikh_shoro_elhaghie','$tarikh_etmam_elhaghie','$gheymat_type','$gheymat_elhaghie','$id_dastorolamal',0,'$mizan_asar')");
   $insert_res=mysql_query($insert_q);
   $max_id=$db->get_from_where("Max(id_elhaghie)","$TableName","");  
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   $mazad_gharardad_befor=$db->get_from_where("mazad_gharardad","gharardad_kharid","id_gharardad='$id_gharardad'");  
   IF($meghdar_type==1)$mazad_gharardad=$mazad_gharardad_befor+$meghdar_elhaghie;	
   ELSE IF($meghdar_type==2)$mazad_gharardad=$mazad_gharardad_befor-$meghdar_elhaghie;	
   $res_update_gharardad=$db->query("UPDATE gharardad_kharid SET mazad_gharardad='$mazad_gharardad' WHERE id_gharardad='$id_gharardad' AND deleted=0");    
	if(($insert_res and $log_i and $res_update_gharardad))
    {
      mysql_query("COMMIT");
	  echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\' </script>';
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
function isPermitEdit($gharardad,$shomare,$tarikh,$gheymat_type,$gheymat_elhaghie,$id_dastorolamal,$this_id)
{
 $flag=false;  
 if(!($gharardad and $shomare and $tarikh))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(checkdatejalali($tarikh)==false)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را با فرمت صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if($gheymat_type>0)
 {	
	if((!$id_dastorolamal)and(!$gheymat_elhaghie))
	{
	 $flag=false;
	 echo"<script>window.alert('لطفا دستورالعمل قیمت کالا را انتخاب نمایید!');</script>";
     return $flag;	 
	}
	else $flag=true;
 }
 else $flag=true;
 if($id_dastorolamal>0)
 {
	if($gheymat_type==0)
	{
	 $flag=false;
	 echo"<script>window.alert('لطفا وضعیت قیمت را انتخاب نمایید!');</script>";
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
 if(isPermitEdit($id_gharardad,$shomare_elhaghie,$tarikh_elhaghie,$gheymat_type,$gheymat_elhaghie,$id_dastorolamal,$id_elhaghie_))
 {
  $Mode='';	
  if($gheymat_type==0){$id_dastorolamal=0;$gheymat_elhaghie=0;}
  $edit_q=("UPDATE $TableName SET shomare_elhaghie='$shomare_elhaghie',tarikh_elhaghie='$tarikh_elhaghie',meghdar_type='$meghdar_type',meghdar_elhaghie='$meghdar_elhaghie',
            modat_type='$modat_type',modat_gharardad_elhaghie='$modat_gharardad_elhaghie',tarikh_shoro_elhaghie='$tarikh_shoro_elhaghie',
			tarikh_etmam_elhaghie='$tarikh_etmam_elhaghie',gheymat_type='$gheymat_type',gheymat_elhaghie='$gheymat_elhaghie',id_dastorolamal='$id_dastorolamal',mizan_asar='$mizan_asar' WHERE id_elhaghie='$id_elhaghie_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_elhaghie_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   $sum_elhaghie_afzayesh=$db->get_from_where("SUM(meghdar_elhaghie)","$TableName","id_gharardad='$id_gharardad' AND deleted=0 AND meghdar_type=1");  
   $sum_elhaghie_kahesh=$db->get_from_where("SUM(meghdar_elhaghie)","$TableName","id_gharardad='$id_gharardad' AND deleted=0 AND meghdar_type=2");  
   //echo"<script>window.alert('$sum_elhaghie_afzayesh');</script>";
   //echo"<script>window.alert('$sum_elhaghie_kahesh');</script>";
   $mazad_gharardad=$sum_elhaghie_afzayesh-$sum_elhaghie_kahesh; 
   $res_update_gharardad=$db->query("UPDATE gharardad_kharid SET mazad_gharardad='$mazad_gharardad' WHERE id_gharardad='$id_gharardad' AND deleted=0");     
   echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\' </script>';
  }
  else if(mysql_affected_rows()==0) echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\' </script>';
  else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود امده است ! *</span>';                
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q = "UPDATE $TableName SET deleted=1 WHERE id_elhaghie='$id_elhaghie_' AND
          ($id_elhaghie_ NOT IN(SELECT id_elhaghie FROM tamin_etebar WHERE id_elhaghie='$id_elhaghie_' AND deleted=0))";
  $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
  if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
  else if($del_res){
   $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_elhaghie_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\' </script>';
  }
}
/********************END********************/	
echo'
'.$message.'
</form>
</body>
</html>';	
?>