<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="keyfiyat_zakhayer.php";
$TableName="keyfiyat_zakhayer";
$titr='پایش کیفیت ذخایر فرآورده های پروتئینی';
$right_ins=0;$right_edt=0;$right_del=0;$right_detail=0;
if (right(512)) $right_ins=1;
if (right(513)) $right_edt=1;
if (right(514)) $right_del=1;
if (right(516)) $right_detail=1;

IF(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $Condition="";
ELSE  $Condition="AND T.code_ostan='$mt_gl_code_ostan'";
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
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_keyfiyat']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x="";
 $temp=""; 
 if($tarikh_bazdid) $temp.=" and tarikh_bazdid LIKE '%$tarikh_bazdid%'";
 if($code_ostan)    $temp.=" and T.code_ostan LIKE '$code_ostan'";
 if($code_anbar)    $temp.=" and T.code_anbar LIKE '$code_anbar'";
 if($name_bazdidkonande) $temp.=" and name_bazdidkonande LIKE '%$name_bazdidkonande%'";
 if($favasel)       $temp.=" and favasel LIKE '$favasel'";
 if($rahro)         $temp.=" and rahro LIKE '$rahro'";
 if($sehat_amalkard)$temp.=" and sehat_amalkard LIKE '$sehat_amalkard'";
 if($fifo)          $temp.=" and fifo LIKE '%$fifo%'";
 if($borodat_salon)     $temp.=" and borodat_salon LIKE '%$borodat_salon%'";
 if($borodat_mahmule)   $temp.=" and borodat_mahmule LIKE '%$borodat_mahmule%'";
 if($difrast)           $temp.=" and difrast LIKE '$difrast'";
 if ($temp){$PageNo=1;$_SESSION['mt_search_keyfiyat']=$temp;} else $_SESSION['mt_search_keyfiyat']="";
 }
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT * From $TableName T WHERE 1=1 ".$_SESSION['mt_search_keyfiyat']." $Condition ");
$row = $db->fetch_array($res);
$cnt = mysql_num_rows($res);
//$cnt = $row[0];
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
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode=''; 
 $del_q="DELETE FROM $TableName WHERE id_keyfiyat=$id_keyfiyat_ AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM user_ostan_anbar WHERE code_anbar=$code_anbar_ AND code_ostan=$code_ostan_ ))";
 $del_res=$db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_keyfiyat_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
}
/***************************************** MAIN*****************************************/
echo'
<body onload="document.myform.code_anbar.focus();">
<form method="post" name="myform">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:40%;">'.$titr.'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td> 	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<img src="images/loading.gif" id="loading" class="loading_img"/>
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order)) $order='id_keyfiyat DESC';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sortname)) $sortname='1';
if(!isset($sortostan)) $sortostan='1';
if(!isset($show_img)) $show_img='';
	 echo'<td width="3%">شناسه</td>';
	 if($sorttarikh=='1')
	 {echo'<td width="8%" title="مرتب سازی صعودی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_bazdid ASC&sorttarikh=2&show_img=2\'"/> تاریخ هفته منتهی به بازدید '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sorttarikh=='2')
	 {echo'<td width="8%" title="مرتب سازی نزولی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_bazdid DESC&sorttarikh=1&show_img=2\'"/> تاریخ هفته منتهی به بازدید '; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='1')
	 {echo'<td width="12%" title="مرتب سازی صعودی" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_bazdidkonande ASC&sortname=2&show_img=2\'"/> نام بازدیدکننده '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {echo'<td width="12%" title="مرتب سازی نزولی" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_bazdidkonande DESC&sortname=1&show_img=2\'"/> نام بازدیدکننده'; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	echo'
	 <td width="6%">استان</td>
	 <td width="8%">سردخانه</td>
	 <td width="6%">زیرانبار</td>
	 <td width="8%">رعایت فواصل از دیوار و سقف</td>
	 <td width="6%">ایجاد راهروی دسترسی</td>
	 <td width="5%">برودت سالن</td>
	 <td width="6%">برودت عمق محموله</td>
	 <td width="7%">صحت عملکرد سیستم سرمایشی</td>
	 <td width="7%">رعایت تقدم و تأخر (FIFO)</td>
	 <td width="5%">عملکرد لوله دیفراست</td>
	 <td width="5%">جزئیات محموله</td>
	 ';
	 if($right_del) echo'<td width="3%">حذف</td>';
	 echo'
	</tr>';
	$i=0;
	$cntr=0;
    $q1="SELECT T.*,name_ostan,name_anbar,name_ziranbar,
	     (SELECT COUNT(*) FROM keyfiyat_zakhayer_detail WHERE id_keyfiyat=T.id_keyfiyat AND deleted=0)AS detailcount 
	     From $TableName T
		 INNER JOIN ostan USING(code_ostan)
	     INNER JOIN list_sardkhane l_s USING(code_ostan,code_anbar)
		 INNER JOIN list_sardkhane_detail l_s_d ON T.code_ziranbar=l_s_d.code_ziranbar AND T.code_ostan=l_s_d.code_ostan AND T.code_anbar=l_s_d.code_anbar  	  
	     WHERE 1=1 ".$_SESSION['mt_search_keyfiyat']." $Condition order by $order $Limit ";
	//echo $q1;
	$all = $db->query($q1);
	while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_keyfiyat_='.$row1['id_keyfiyat'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';   
	 echo'
	  <td '.$edtClick.'>'.$row1['id_keyfiyat'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_bazdid'].'</td>
	  <td '.$edtClick.'>'.$row1['name_bazdidkonande'].'</td>
	  <td '.$edtClick.'>'.$row1['name_ostan'].'</td>
	  <td '.$edtClick.'>'.$row1['name_anbar'].'</td>
	  <td '.$edtClick.'>'.$row1['name_ziranbar'].'</td>
	  <td '.$edtClick.'>';IF($row1['favasel'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	  <td '.$edtClick.'>';IF($row1['rahro'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	  <td '.$edtClick.'>'.$row1['borodat_salon'].'</td>
	  <td '.$edtClick.'>'.$row1['borodat_mahmule'].'</td>
	  <td '.$edtClick.'>';IF($row1['sehat_amalkard'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	  <td '.$edtClick.'>';IF($row1['fifo'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	  <td '.$edtClick.'>';IF($row1['difrast'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>';
	  if($right_detail) {echo'<td><input type="button" class="button-inline"  value="['.$row1['detailcount'].']" style="min-width:50px;" onClick="window.location=\'keyfiyat_zakhayer_detail.php?PageNo='.$PageNo.'&id_keyfiyat_='.$row1['id_keyfiyat'].'&code_ostan_='.$row1['code_ostan'].'&code_anbar_='.$row1['code_anbar'].'&code_ziranbar_='.$row1['code_ziranbar'].'\'"></td>';}
	  if($right_del)
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_keyfiyat_='.$row1['id_keyfiyat'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف فرم پایش با شناسه '.$row1['id_keyfiyat'].' \')" /></td>';
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
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_keyfiyat_zakhayer.php\',\'\',\'scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
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
     if ($_SESSION['mt_search_keyfiyat']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>		 
	</tr>';
    }
	if ($Mode=="Insert")  //Insert Mode
    {
	echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">ايجاد '.$titr.'</td></tr>';   
	   IF(($mt_gl_name_ostan=='')OR($mt_gl_name_anbar==''))
		echo'<td colspan="10"><span class="star">لطفاً استان و سردخانه رااز پایین صفحه انتخاب نمایید</span></td>';   
	   echo'
       <tr style="height:40px">
		<td align="left"><span class="star">*</span> تاریخ هفته منتهی به بازدید : &nbsp;</td><td align="right" ><input type="text" class="textboxme2 datepicker6" value="'.AsLDate($yymmdd).'"  name="tarikh_bazdid" /></td>	 
	    <td align="left"><span class="star">*</span> نام بازدیدکننده : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_bazdidkonande" value="'.$name_bazdidkonande.'" ></td>
        <td align="left"> استان : &nbsp;</td><td align="right"><input type="text" readonly name="name_ostan" value="'.$mt_gl_name_ostan.'" ></td>
	   	<td align="left"> سردخانه : &nbsp;</td><td align="right"><input type="text" readonly name="name_anbar" value="'.$mt_gl_name_anbar.'" ></td>
	   </tr>
       <tr>	   
		<td align="left"><span class="star">*</span> زیرانبار : &nbsp;</td><td align="right">'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY name_ziranbar ASC","class='text4'").'</td>
	   	<td align="left"><span class="star">*</span> برودت سالن : &nbsp;</td><td align="right" ><input type="text" class="textboxme" name="borodat_salon" value="'.$borodat_salon.'"  onkeypress="return isNumberWithNegative(event)"  /></td>	 
	    <td align="left"><span class="star">*</span> برودت عمق محموله : &nbsp;</td><td align="right" ><input type="text" class="textboxme" name="borodat_mahmule" value="'.$borodat_mahmule.'" onkeypress="return isNumberWithNegative(event)" /></td>	 
	    <td align="left"><span class="star">*</span> رعایت فواصل از دیوار و سقف : &nbsp;</td><td align="right">'.static_listbox("favasel",$favasel,"status_peymankarArr",1,"class='text4'").'</td>  
	   </tr>
	   <tr>
	   	<td align="left"><span class="star">*</span> ایجاد راهروی دسترسی : &nbsp;</td><td align="right">'.static_listbox("rahro",$rahro,"status_peymankarArr",1,"class='text4'").'</td>  	
	   	<td align="left"><span class="star">*</span> صحت عملکرد سیستم سرمایشی : &nbsp;</td><td align="right">'.static_listbox("sehat_amalkard",$sehat_amalkard,"status_peymankarArr",1,"class='text4'").'</td>  	
	   	<td align="left"><span class="star">*</span> رعایت تقدم و تأخر (FIFO) : &nbsp;</td><td align="right">'.static_listbox("fifo",$fifo,"status_peymankarArr",1,"class='text4'").'</td>  	
	   	<td align="left"><span class="star">*</span> عملکرد لوله دیفراست : &nbsp;</td><td align="right">'.static_listbox("difrast",$difrast,"status_peymankarArr",1,"class='text4'").'</td>  
	   </tr>
	   <tr class="title">
        <td colspan="8" align="center">
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
	 $q2="SELECT * FROM $TableName T WHERE id_keyfiyat='$id_keyfiyat_'";
	 $res2=$db->query($q2);
	 $row2=$db->fetch_assoc($res2);
	 echo'
     <tr> 
	  <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	   <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
        <tr class="title"><td colspan="10" align="center">ويرايش '.$titr.$id_keyfiyat_.'</td></tr>	   
	    <tr  style="height:40px">
		 <td align="left"><span class="star">*</span> تاریخ هفته منتهی به بازدید : &nbsp;</td><td align="right" ><input type="text" class="textboxme2 datepicker6" value="'.$row2['tarikh_bazdid'].'"  name="tarikh_bazdid" /></td>	 
	     <td align="left"><span class="star">*</span> نام بازدیدکننده : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_bazdidkonande" value="'.$row2['name_bazdidkonande'].'" ></td>
         <td align="left"> استان : &nbsp;</td><td align="right"><input type="text" readonly name="name_ostan" value="'.$mt_gl_name_ostan.'" ></td>
	   	 <td align="left"> سردخانه : &nbsp;</td><td align="right"><input type="text" readonly name="name_anbar" value="'.$mt_gl_name_anbar.'" ></td>
	    </tr>
        <tr>	   
		 <td align="left"><span class="star">*</span> زیرانبار : &nbsp;</td><td align="right">'.listbox("code_ziranbar",$row2['code_ziranbar'],"code_ziranbar","name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY name_ziranbar ASC","class='text4'").'</td>
	   	 <td align="left"><span class="star">*</span> برودت سالن : &nbsp;</td><td align="right" ><input type="text" class="textboxme" name="borodat_salon" value="'.$row2['borodat_salon'].'"  onkeypress="return isNumberWithNegative(event)"  /></td>	 
	     <td align="left"><span class="star">*</span> برودت عمق محموله : &nbsp;</td><td align="right" ><input type="text" class="textboxme" name="borodat_mahmule" value="'.$row2['borodat_mahmule'].'" onkeypress="return isNumberWithNegative(event)" /></td>	 
	     <td align="left"><span class="star">*</span> رعایت فواصل از دیوار و سقف : &nbsp;</td><td align="right">'.static_listbox("favasel",$row2['favasel'],"status_peymankarArr",1,"class='text4'").'</td>  
	    </tr>
	    <tr>
	   	 <td align="left"><span class="star">*</span> ایجاد راهروی دسترسی : &nbsp;</td><td align="right">'.static_listbox("rahro",$row2['rahro'],"status_peymankarArr",1,"class='text4'").'</td>  	
	   	 <td align="left"><span class="star">*</span> صحت عملکرد سیستم سرمایشی : &nbsp;</td><td align="right">'.static_listbox("sehat_amalkard",$row2['sehat_amalkard'],"status_peymankarArr",1,"class='text4'").'</td>  	
	   	 <td align="left"><span class="star">*</span> رعایت تقدم و تأخر (FIFO) : &nbsp;</td><td align="right">'.static_listbox("fifo",$row2['fifo'],"status_peymankarArr",1,"class='text4'").'</td>  	
	   	 <td align="left"><span class="star">*</span> عملکرد لوله دیفراست : &nbsp;</td><td align="right">'.static_listbox("difrast",$row2['difrast'],"status_peymankarArr",1,"class='text4'").'</td>  
	    </tr>
	    <tr class="title">
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
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">جستجو '.$titr.'</td></tr>  
       <tr style="height:40px">
		<td align="left"> تاریخ هفته منتهی به بازدید : &nbsp;</td><td align="right" ><input type="text" class="textboxme2 datepicker6" name="tarikh_bazdid" /></td>	 
	    <td align="left"> نام بازدیدکننده : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_bazdidkonande" value="'.$name_bazdidkonande.'" ></td>
	   	<td align="left"> استان :&nbsp;</td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
	   	<td align="left"> سردخانه :&nbsp;</td><td align="right">'.listbox("code_anbar",$code_anbar,"code_anbar","name_anbar","list_sardkhane","code_anbar!=301 ORDER BY list_sardkhane.name_anbar ASC","class='text4'").'</td>
	   </tr>
       <tr>	   
		<td align="left"> زیرانبار : &nbsp;</td><td align="right">'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY name_ziranbar ASC","class='text4'").'</td>
	   	<td align="left"> برودت سالن : &nbsp;</td><td align="right" ><input type="text" class="textboxme" name="borodat_salon" value="'.$borodat_salon.'"  onkeypress="return isNumberWithNegative(event)"  /></td>	 
	    <td align="left"> برودت عمق محموله : &nbsp;</td><td align="right" ><input type="text" class="textboxme" name="borodat_mahmule" value="'.$borodat_mahmule.'" onkeypress="return isNumberWithNegative(event)" /></td>	 
	    <td align="left"> رعایت فواصل از دیوار و سقف : &nbsp;</td><td align="right">'.static_listbox("favasel",$favasel,"status_peymankarArr",1,"class='text4'").'</td>  
	   </tr>
	   <tr style="height:40px">
	   	<td align="left"> ایجاد راهروی دسترسی : &nbsp;</td><td align="right">'.static_listbox("rahro",$rahro,"status_peymankarArr",1,"class='text4'").'</td>  	
	   	<td align="left"> صحت عملکرد سیستم سرمایشی : &nbsp;</td><td align="right">'.static_listbox("sehat_amalkard",$sehat_amalkard,"status_peymankarArr",1,"class='text4'").'</td>  	
	   	<td align="left"> رعایت تقدم و تأخر (FIFO) : &nbsp;</td><td align="right">'.static_listbox("fifo",$fifo,"status_peymankarArr",1,"class='text4'").'</td>  	
	   	<td align="left"> عملکرد لوله دیفراست : &nbsp;</td><td align="right">'.static_listbox("difrast",$difrast,"status_peymankarArr",1,"class='text4'").'</td>  
	   </tr>
	   <tr class="title">
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
/**********اجازه براي ثبت اطلاعات********/
function isPermitSave($code_zir_a,$date_b,$name_b,$favasel,$rahro,$sehat_amalkard,$fifo,$borodat_salon,$borodat_mahmule,$difrast,$gl_c_o,$gl_c_a,$gl_year)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($code_zir_a and $date_b and $name_b and $favasel and $rahro and $sehat_amalkard and $fifo and $borodat_salon and $borodat_mahmule and $difrast))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(checkdatejalali($date_b)==false)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($code_zir_a,$date_b,$name_b,$favasel,$rahro,$sehat_amalkard,$fifo,$borodat_salon,$borodat_mahmule,$difrast,$gl_c_o,$gl_c_a,$gl_year)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($code_zir_a and $date_b and $name_b and $favasel and $rahro and $sehat_amalkard and $fifo and $borodat_salon and $borodat_mahmule and $difrast))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(checkdatejalali($date_b)==false)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 return $flag;
}
/*************INSERT  BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 if(isPermitSave($code_ziranbar,$tarikh_bazdid,$name_bazdidkonande,$favasel,$rahro,$sehat_amalkard,$fifo,$borodat_salon,$borodat_mahmule,$difrast,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 { 
  mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
  mysql_query('START TRANSACTION');
  $Mode='';
  $insert_q=("INSERT INTO $TableName
            (code_ostan,code_anbar,year,code_ziranbar,tarikh_bazdid,name_bazdidkonande,favasel,rahro,sehat_amalkard,fifo,borodat_salon,borodat_mahmule,difrast,deleted)
             VALUES
			('$mt_gl_code_ostan','$mt_gl_code_anbar','$mtActiveYear','$code_ziranbar','$tarikh_bazdid','$name_bazdidkonande','$favasel','$rahro','$sehat_amalkard','$fifo','$borodat_salon','$borodat_mahmule','$difrast',0)"); 		 
   $insert_res=mysql_query($insert_q);
   /*لاگ*/
   $max_id=$db->get_from_where("MAX(id_keyfiyat)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['bz_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['bz_user_ip']."')");
   if($insert_res and $log_i)
   {
	mysql_query("COMMIT");
	echo '<script>window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
   }
   else  
   {
     mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
     echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";  
   }
   mysql_query('SET AUTOCOMMIT=1');
 }//END isPermitSave 
}//END INSERT

/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_ziranbar,$tarikh_bazdid,$name_bazdidkonande,$favasel,$rahro,$sehat_amalkard,$fifo,$borodat_salon,$borodat_mahmule,$difrast,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET tarikh_bazdid='$tarikh_bazdid',name_bazdidkonande='$name_bazdidkonande',
            favasel='$favasel',rahro='$rahro',sehat_amalkard='$sehat_amalkard',fifo='$fifo',borodat_salon='$borodat_salon',borodat_mahmule='$borodat_mahmule',difrast='$difrast'
            WHERE id_keyfiyat='$id_keyfiyat_';");         
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  { 
	$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_keyfiyat_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  /*کوئری لاگ*/ 
    echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else  echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";     
 }
}
echo'	
</table>
</div>';
echo'
'.$message.'
</form>
</body>
</html>';	
?>