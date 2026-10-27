<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="ebtal_jabejae.php";
$TableName="ebtal_jabejae";
$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;
if (right(151)) $right_ins=1;
if (right(152)) $right_edt=1;
if (right(153)) $right_del=1;
if (right(154)) $right_prt=1;
$logtime=date('H:i:s'); 
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ابطال مقادیر مجوز جابه جایی</title>
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
function getDetailJabejae(sh_j)<!-- اطلاعات مجوز جابه جایی-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax_ebtal_jabejae.php",{shomareJABEJAE: sh_j},function(data){
		   var splJabejae = data.split("^");
		   $("#tarikh_jabejae").val(splJabejae[0]);
		   $("#code_ostan_maghsad_j").val(splJabejae[1]);
		   $("#code_anbar_maghsad_j").val(splJabejae[2]);
		   $("#code_kala").val(splJabejae[3]);
		   $("#name_kala").val(splJabejae[4]);
		   $("#name_customer").val(splJabejae[5]);
		   $("#meghdar_jabejae").val(splJabejae[6]);
		   $("#meghdar_tahvily_j").val(splJabejae[7]);
		   $("#mande_az_jabejae").val(splJabejae[8]);
           $("#idJabejae").val(splJabejae[9]);
		   $("#rahnama").html(splJabejae[10]);		   
		 });
    $("#loading").fadeOut("fast");
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_ebtal_jabejae']="";
} 
if(isset($Search_x))
{
  $Mode='';
  $Search_x=""; 
  $temp="";
  if($shomare_barge_ebtal_j)    $temp.=" and T.shomare_barge_ebtal_j  LIKE '%$shomare_barge_ebtal_srch%'";
  if($tarikh_barge_ebtal_j)     $temp.=" and T.tarikh_barge_ebtal_j LIKE '%$tarikh_barge_ebtal_j%'";
  if($shomare_mojavez_ebtal)    $temp.=" and T.shomare_mojavez_ebtal LIKE '%$shomare_mojavez_ebtal%'";
  if($shomare_jabejae)          $temp.=" and T.shomare_jabejae LIKE '%$shomare_jabejae%'";
  if($meghdar_batele_j)         $temp.=" and T.meghdar_batele_j LIKE '%$meghdar_batele_j%'";
  if($temp) {$PageNo=1;$_SESSION['mt_search_ebtal_jabejae']=$temp;} else $_SESSION['mt_search_ebtal_jabejae']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
//$res = mysql_query("SELECT COUNT(*) FROM $TableName T INNER JOIN mojavez_jabejae m_j ON m_j.shomare_jabejae=T.shomare_jabejae WHERE 1=1 ".$_SESSION['mt_search_ebtal_jabejae']." AND T.tarikh_barge_ebtal_j>='$mtStartDateSh' AND m_j.tarikh_jabejae>='$mtStartDateSh' AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0");
$res = mysql_query("SELECT COUNT(*) FROM $TableName T INNER JOIN mojavez_jabejae m_j ON m_j.shomare_jabejae=T.shomare_jabejae AND m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year WHERE 1=1 ".$_SESSION['mt_search_ebtal_jabejae']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0");
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
/**********اجازه براي ويرايش اطلاعات********/
 function isPermitEdit($sh_e,$tarikh_e,$sh_j,$meghdar_b,$gl_c_o,$gl_c_a,$gl_year)
{
  $flag=false;
  if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
  {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
  }
  else $flag=true; 
  if(!($sh_e and $tarikh_e and $sh_j and $meghdar_b))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";  
   return $flag;
  }  
  else $flag=true;
 return $flag;
}

/************EDIT BUTTON********/// اصلاح اطلاعات
if(isset($Edit_x))
{
 if(isPermitEdit($shomare_barge_ebtal_j,$tarikh_barge_ebtal_j,$shomare_jabejae,$meghdar_batele_j,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET tarikh_barge_ebtal_j='$tarikh_barge_ebtal_j' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");
  else if(mysql_affected_rows()==0)  $message ='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if(isset($Delete_x))
{
 $Mode='';
 $del_q ="update $TableName set deleted=1 WHERE id=$id_";
 $del_res =mysql_query($del_q);
 if($del_res)
 {
   //آپدیت مانده مقدار مجوز جابه جایی در جدول جابه جایی
   $update_mande2=$mande_az_jabejae_+$meghdar_batele_; 
   $res_update_mande2=$db->query("UPDATE mojavez_jabejae SET mande_az_jabejae='$update_mande2' WHERE shomare_jabejae='$shomare_jabejae_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");    
   /*لاگ ها*/
   $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");
   if($res_update_mande2) {$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','mojavez_jabejae','$idJabejae_','حذف برگه ابطال و برگشت مقدار مانده',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/}
 }
 else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';
 }
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
if ($Mode=="Insert") $load="document.myform.shomare_jabejae.focus();";
if ($Mode=="Edit")   $load="document.myform.tarikh_barge_ebtal_j.focus();";
if ($Mode=="Search") $load="document.myform.shomare_barge_ebtal_j.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">';
   if($_SESSION['mt_search_ebtal_jabejae']) echo'<div style="position:absolute;top:5px;left:40%;"> نتایج جستجوی فرم ابطال مقادیر حواله فروش</div>';
   else echo'<div style="position:absolute;top:5px;left:43%;"> فرم ابطال مقادیر مجوز جابه جایی</div>';  
   echo'<div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
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
if(!isset($order)) $order='T.id DESC';
if(!isset($sortcode))   $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sortjabejae)) $sortjabejae='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="15%" title="مرتب سازی صعودی شماره برگه ابطال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan ASC,code_anbar ASC,shomare_barge_ebtal_j ASC&sortcode=2&show_img=1\'"/> شماره برگه ابطال جابه جایی ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="15%" title="مرتب سازی نزولی شماره برگه ابطال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan DESC,code_anbar DESC,shomare_barge_ebtal_j DESC&sortcode=1&show_img=1\'"/> شماره برگه ابطال جابه جایی ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="13%" title="مرتب سازی صعودی تاریخ برگه ابطال جابه جایی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_barge_ebtal_j ASC&sorttarikh=2&show_img=2\'"/> تاریخ برگه ابطال جابه جایی '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="13%" title="مرتب سازی نزولی تاریخ برگه ابطال جابه جایی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_barge_ebtal_j DESC&sorttarikh=1&show_img=2\'"/> تاریخ برگه ابطال جابه جایی '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortjabejae=='1')
	{echo'<td width="15%" title="مرتب سازی صعودی شماره مجوز جابه جایی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.shomare_jabejae ASC&sortjabejae=2&show_img=3\'"/> شماره مجوز جابه جایی '; 
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortjabejae=='2')
	{echo'<td width="15%" title="مرتب سازی نزولی شماره مجوز جابه جایی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.shomare_jabejae DESC&sortjabejae=1&show_img=3\'"/> شماره مجوز جابه جایی '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="25%" title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.shomare_jabejae ASC&sortname=2&show_img=4\'"/> نام کالا '; 
	  if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="25%" title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.shomare_jabejae DESC&sortname=1&show_img=4\'"/> نام کالا '; 
	  if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	 <td width="15%">مقدار اولیه مجوز جابه جایی</td>
	 <td width="12%">مقدار باطله</td>';
	 if(($right_del)and($_SESSION['mtStatusYear']==0))echo'<td width="5%">حذف</td>';
	echo'
	</tr>';
	$i=0;
    $q1="SELECT T.*,m_j.id mojavez_id,m_j.shomare_jabejae,m_j.tarikh_jabejae,m_j.code_kala,m_j.meghdar_jabejae,m_j.mande_az_jabejae,kala.name_kala FROM $TableName T 
	     INNER JOIN mojavez_jabejae m_j ON m_j.shomare_jabejae=T.shomare_jabejae AND m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year
		 INNER JOIN kala ON kala.code_kala=m_j.code_kala
		 WHERE 1=1 ".$_SESSION['mt_search_ebtal_jabejae']." AND T.code_ostan='$mt_gl_code_ostan' and T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 order by $order $Limit"; 	
	$allEbtal=mysql_query($q1);
    while($row1=mysql_fetch_assoc($allEbtal))
	{
     if($right_edt) $edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&shomare_barge_ebtal_j_='.$row1['shomare_barge_ebtal_j'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	  echo'
	   <td '.$edtClick.'>'.$row1['shomare_barge_ebtal_j'].'</td>
	   <td '.$edtClick.'>'.$row1['tarikh_barge_ebtal_j'].'</td>
	   <td '.$edtClick.'>'.$row1['shomare_jabejae'].'</td>
	   <td '.$edtClick.'>'.$row1['name_kala'].'</td>
	   <td '.$edtClick.'>'.($row1['meghdar_jabejae']).'</td>
	   <td '.$edtClick.'>'.round($row1['meghdar_batele_j'],3).'</td>';   
	   if(($right_del)and($_SESSION['mtStatusYear']==0))
	   {
	     echo'<td><img border="0"  src="images/trash.png" width="20" height="20" title="حذف"
	          onmouseOver="this.src=\'images/trash_hover.png\'" 
	 	     onmouseOut="this.src=\'images/trash.png\'" 
	 	     onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&shomare_jabejae_='.$row1['shomare_jabejae'].'&mande_az_jabejae_='.$row1['mande_az_jabejae'].'&idJabejae_='.$row1['mojavez_id'].'&meghdar_batele_='.$row1['meghdar_batele_j'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف برگه ابطال شماره '.$row1['shomare_barge_ebtal_j'].' \')" /></td>';
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
	  if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td>&nbsp;</td>';
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
	 if($right_prt) echo'<td width="24"><div onClick="window.open(\'print_ebtal_jabejae.php\',\'_blank\',\'scrollbars=yes\')" id="printer" title="چاپ"><a href="#"></a></div></td>';
     //اگر اجازه ایجاد رسید را دارد و وضعیت سال فعال است و سال فعال سال جاری است
	 //if(($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION["mtActiveYear"]==$yy))
	 if(($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION['mt_anbar_activate']==1))
	 {
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
     if ($_SESSION['mt_search_ebtal_jabejae']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td><span class="tedadcover" align="center" > تعداد ['.$cnt.']</span></td>	 	 
	</tr>';
    }
    if ($Mode=="Insert")  //Insert Mode
    {echo '
     <tr> 
	  <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	   <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
	   <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center">ايجاد فرم جديد</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	    <input type="hidden" name="idJabejae" id="idJabejae" value="'.$idJabejae.'"/>
	   <tr>';
	   	$shomare_barge_ebtal_j=$db->get_from_where("Max(shomare_barge_ebtal_j)","$TableName","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
	    //echo "select Max(CONVERT(shomare_barge_ebtal_j,SIGNED INTEGER) AS shomare_barge_ebtal_j from $TableName where code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear";
		$shomare_barge_ebtal_j++;
	   echo'
		<td align="left" width="170px"><span class="star">*</span>شماره برگه ابطال جابه جایی : &nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" readonly name="shomare_barge_ebtal_j" value="'.$shomare_barge_ebtal_j.'"/></td>
        <td align="left" width="170px"><span class="star">*</span> تاریخ برگه ابطال جابه جایی : &nbsp; </td>';
		if($_SESSION["mtActiveYear"]==$yy)echo'<td align="right"><input type="text" readonly class="textboxme2" maxlength="10" name="tarikh_barge_ebtal_j" value="'.AsLDate($yymmdd).'"/></td>';
		else echo'<td align="right"><input type="text" readonly class="textboxme2" maxlength="10" name="tarikh_barge_ebtal_j" value="'.$mtEndDateSh.'"/></td>';
	   	echo'
		<td align="left" width="150px"><span class="star">*</span> شماره مجوز جابه جایی : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shomare_jabejae" value="'.$shomare_jabejae.'" onfocus="getDetailJabejae(this.value)" onblur="getDetailJabejae(this.value)"/>&nbsp';
        include ("img_helpjabejae_report.php");
	    echo'
        </td>		
	    <td align="left" width="150px">تاريخ مجوز جابه جایی  : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" value="'.$tarikh_jabejae.'" name="tarikh_jabejae" id="tarikh_jabejae"/></td>	 	   
	   </tr>
	   <tr>	 
		</td>
	    <td align="left">استان مقصد : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="code_ostan_maghsad_j" id="code_ostan_maghsad_j" value="'.$code_ostan_maghsad_j.'"/></td>
	    <td align="left">انبار مقصد : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="code_anbar_maghsad_j" id="code_anbar_maghsad_j" value="'.$code_anbar_maghsad_j.'"/></td>
	    <td align="left">نام کالا : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="name_kala" id="name_kala" value="'.$name_kala.'" /></td>	   
	   	<td align="left">نام مشتری : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="name_customer" id="name_customer" value="'.$name_customer.'"/></td>
	   </tr>
	   <tr>
	    <td align="left">مقدار اولیه مجوز جابه جایی : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_jabejae" id="meghdar_jabejae" value="'.($meghdar_jabejae).'" /><span name="rahnama" id="rahnama" class="rahnama"></span></td>
	    <td align="left">مقدار تحویلی از جابه جایی : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_tahvily_j" id="meghdar_tahvily_j" value="'.($meghdar_tahvily_j).'" /></td>
	    <td align="left">مقدار مانده از مجوز : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mande_az_jabejae" id="mande_az_jabejae" value="'.($mande_az_jabejae).'"/></td>
	  	<td align="left"><span class="star">*</span> مقدار باطله : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="meghdar_batele_j" value="'.$meghdar_batele_j.'" onKeydown="return PressfloatOnly(event,this)"/></td>
	   </tr>
	   <tr class="footer" align="center">
        <td colspan="8">
		<input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
        <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
    if($Mode=="Edit")  //Edit Mode
    {
	 if($_SESSION['mt_systemforush']==0)//سردخانه
     {	
       $q3=("SELECT $TableName.*,m_j.shomare_jabejae,m_j.tarikh_jabejae,m_j.code_kala,m_j.meghdar_jabejae,m_j.mande_az_jabejae,kala.name_kala,kala.code_bastebandy,o.name_ostan AS ostan_maghsad,l_a.name_anbar AS anbar_maghsad,moshtary.name_customer FROM $TableName
	   	     INNER JOIN mojavez_jabejae m_j ON $TableName.shomare_jabejae=m_j.shomare_jabejae AND $TableName.code_ostan=m_j.code_ostan AND $TableName.code_anbar=m_j.code_anbar AND $TableName.year=m_j.year  
		     INNER JOIN kala ON m_j.code_kala=kala.code_kala
             INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
			 LEFT JOIN moshtary ON m_j.code_customer=moshtary.code_customer
		     LEFT JOIN ostan o ON o.code_ostan=m_j.code_ostan_maghsad_j
             LEFT JOIN list_sardkhane l_a ON l_a.code_ostan=m_j.code_ostan_maghsad_j AND l_a.code_anbar=m_j.code_anbar_maghsad_j 		  
             WHERE $TableName.id='$id_' AND $TableName.shomare_barge_ebtal_j='$shomare_barge_ebtal_j_' AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0");
     }
	 if($_SESSION['mt_systemforush']==1)//فروش
     {
   	   $q3=("SELECT $TableName.*,m_j.shomare_jabejae,m_j.tarikh_jabejae,m_j.code_kala,m_j.meghdar_jabejae,m_j.mande_az_jabejae,kala.name_kala,kala.code_bastebandy,o.name_ostan AS ostan_maghsad,l_a.name_anbar AS anbar_maghsad,dm_customer_asli.name_customer FROM $TableName
	   	     INNER JOIN mojavez_jabejae m_j ON $TableName.shomare_jabejae=m_j.shomare_jabejae AND $TableName.code_ostan=m_j.code_ostan AND $TableName.code_anbar=m_j.code_anbar AND $TableName.year=m_j.year  
	   	     INNER JOIN kala ON m_j.code_kala=kala.code_kala
             INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
			 LEFT JOIN sell.dm_customer_asli ON m_j.code_customer=sell.dm_customer_asli.code_customer
	   	     LEFT JOIN ostan o ON o.code_ostan=m_j.code_ostan_maghsad_j
             LEFT JOIN list_sardkhane l_a ON l_a.code_ostan=m_j.code_ostan_maghsad_j AND l_a.code_anbar=m_j.code_anbar_maghsad_j 		  
             WHERE $TableName.id='$id_' AND $TableName.shomare_barge_ebtal_j='$shomare_barge_ebtal_j_' AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0");
     }	
	 $res3=$db->query($q3);
     $row3=$db->fetch_assoc($res3);
	 //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	 $meghdar_tahvily_j=tahvily_az_jabejae($row3['shomare_jabejae'],$row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_bastebandy'],$row3['code_kala']);
	echo '
     <tr> 
	  <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	   <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات برگه '.$row3['shomare_barge_ebtal_j'].'</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
		<td align="left"><span class="star">*</span> شماره برگه ابطال جابه جایی : &nbsp; </td><td align="right"><input type="text" readonly class="textboxme2" value="'.$row3['shomare_barge_ebtal_j'].'" name="shomare_barge_ebtal_j" /></td>
        <td align="left"><span class="star">*</span> تاریخ برگه ابطال جابه جایی : &nbsp; </td><td align="right"><input class="textboxme2" type="text" id="datepicker6" maxlength="10" name="tarikh_barge_ebtal_j" value="'.$row3['tarikh_barge_ebtal_j'].'"/></td>
	   	<td align="left"><span class="star">*</span> شماره مجوز جابه جایی : &nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly value="'.$row3['shomare_jabejae'].'" name="shomare_jabejae" onfocus="getDetailJabejae(this.value)" onblur="getDetailJabejae(this.value)"/></td>
		<td align="left">تاريخ مجوز جابه جایی : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" value="'.$row3['tarikh_jabejae'].'" name="tarikh_jabejae" id="tarikh_jabejae"/></td>	 	 
	   </tr>
	   <tr>	 
	   	<td align="left">استان مقصد : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="code_ostan_maghsad_j" id="code_ostan_maghsad_j" value="'.$row3['ostan_maghsad'].'" /></td>
	   	<td align="left">انبار مقصد : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="code_anbar_maghsad_j" id="code_anbar_maghsad_j" value="'.$row3['anbar_maghsad'].'" /></td>
	    <td align="left">نام کالا : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="name_kala" id="name_kala" value="'.$row3['name_kala'].'"/></td>
	    <td align="left">نام مشتری : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="name_customer" id="name_customer" value="'.$row3['name_customer'].'"/></td>
	   </tr>
	   <tr>
	    <td align="left">مقدار اولیه مجوز جابه جایی : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_jabejae" id="meghdar_jabejae" value="'.($row3['meghdar_jabejae']).'" />
		 <span name="rahnama" id="rahnama" class="rahnama">';
		  if($row3['code_bastebandy']==1)
		  {
			if($row3['code_kala']==50) echo'(تعداد شانه)';
			else echo'(کیلوگرم)';
		  }	  
		  else echo'(تعداد قوطی)';
		  echo'
		 </span>
	    </td>
		<td align="left">مقدار تحویلی از مجوز : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_tahvily_j" id="meghdar_tahvily_j" value="'.round($meghdar_tahvily_j,3).'"/></td>
	    <td align="left">مقدار مانده از مجوز : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mande_az_jabejae" id="mande_az_jabejae" value="'.($row3['mande_az_jabejae']).'"/></td>
	       <!--<td align="left">مقادیر باطله قبلی : &nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="meghdar_batele_ghabl" id="meghdar_batele_ghabl" value="'.$meghdar_batele_ghabl.'"/></td>-->
	   	<td align="left"><span class="star">*</span> مقدار باطله : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="meghdar_batele_j" readonly value="'.round($row3['meghdar_batele_j'],3).'" onKeydown="return PressfloatOnly(event,this)"/></td>
	   </tr>
	   <tr class="footer" align="center">
        <td colspan="8">';
		 if(($_SESSION['mtStatusYear']==0)or(SuperUser()))echo'<input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">';
         echo'<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if ($Mode=="Search") //Search Mode
    {
	  echo '
     <tr> 
	  <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	   <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
        <img src="images/loading.gif" id="loading" class="loading_img"/>
	     <tr class="title" style="font-weight:normal"><td colspan="6" align="center">جستجوی فرم ابطال</td></tr>
         <tr><td>&nbsp;</td></tr>	   
	     <tr>
		  <td align="left">شماره برگه ابطال جابه جایی : &nbsp; </td>
		  <td align="right"><input type="text" class="textboxme2" name="shomare_barge_ebtal_j" value="" onkeypress="return isNumber(event)"/></td>
          <td align="left">تاریخ برگه ابطال جابه جایی : &nbsp; </td><td align="right"><input type="text" class="textboxme2" maxlength="10" id="datepicker6" name="tarikh_barge_ebtal_j" value=""/></td>
	     </tr>
	     <tr>	 
	      <td align="left">شماره مجوز جابه جایی : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shomare_jabejae" value="'.$shomare_jabejae.'"/>&nbsp';
		    include ("img_helpjabejae_report.php");
		 echo'
		  </td>
		  <td align="left">مقدار باطله : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="meghdar_batele_j" value="'.$meghdar_batele_j.'" onKeydown="return PressfloatOnly(event,this)"/></td>
	     </tr>	 
	     <tr class="footer" align="center">
          <td colspan="6" >
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
 /************اجازه براي ذخيره اطلاعات************/
 function isPermitSave($sh_e,$tarikh_e,$sh_j,$meghdar_b,$mande,$gl_c_o,$gl_c_a,$gl_year)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($sh_e and $sh_j and $meghdar_b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";  
   return $flag;
 } 
 else $flag=true;
 if($mande<=0)
 {$flag=false;
  echo"<script>window.alert('مقدار مانده از حواله فروش صفر است !امکان ثبت برگه ابطال وجود ندارد')</script>";
  return $flag;
 }
 else $flag=true;
 if($mande<$meghdar_b)
 {$flag=false;
  echo"<script>window.alert('مقدار باطله از مقدار مانده از حواله فروش بیشتر است !امکان ثبت این برگه ابطال وجود ندارد')</script>";
  return $flag;
 }
 else $flag=true;
return $flag;
}
 /*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($shomare_barge_ebtal_j,$tarikh_barge_ebtal_j,$shomare_jabejae,$meghdar_batele_j,$mande_az_jabejae,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {
   $Mode='';
   $insert_q=("INSERT INTO $TableName(code_ostan,code_anbar,shomare_barge_ebtal_j,year,tarikh_barge_ebtal_j,
               shomare_jabejae,meghdar_batele_j,deleted)
              VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_barge_ebtal_j','$mtActiveYear','$tarikh_barge_ebtal_j',
			  '$shomare_jabejae','$meghdar_batele_j',0)");         
   $insert_res=mysql_query($insert_q);
   if($insert_res)
   {
     //آپدیت مانده مقدار جابه جایی در جدول جابه جایی
	 $update_mande=$mande_az_jabejae-$meghdar_batele_j; 
     $res_update_mande=$db->query("UPDATE mojavez_jabejae SET mande_az_jabejae='$update_mande' WHERE shomare_jabejae='$shomare_jabejae' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");   
     $max_id=$db->get_from_where("Max(id)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0"); 
     /*لاگ ها*/
	 $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
     if($res_update_mande) {$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','mojavez_jabejae','$idJabejae','ایجاد برگه ابطال جابه جایی  وکاهش مانده ',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/}
     echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
   }
   else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت برگه ابطال به وجود آمده است ! *</span>';    
 }
}
/**************************************************************/
echo'	
</table>
</div>
'.$message.'
</form>
</body>
</html>';	
?>