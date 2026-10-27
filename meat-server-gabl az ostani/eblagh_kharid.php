<?php
require_once __DIR__ . '/../mysql_compat.php';
//ALTER TABLE `eblagh_kharid` ADD `gosht_type` TINYINT( 1 ) NULL AFTER `code_group_kala_top` 
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="eblagh_kharid.php";
$TableName="eblagh_kharid";
$titr='ابلاغ از سوی وزیر/ستاد تنظیم بازار/ هیأت مدیره';
$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;$right_sahmiebandy=0;$right_dastorolamal=0;
if (right(402)) $right_ins=1;
if (right(403)) $right_edt=1;
if (right(404)) $right_del=1; 
if (right(405)) $right_prt=1;
if (right(406)) $right_sahmiebandy=1;
if (right(411)) $right_dastorolamal=1;
//$logtime=date('H:i:s');
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
		showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true
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
   $.post("ajax.php",{codeGrK_T:code_gr_kala},function(data){$("[name=code_kala]").html(data);});
   $("#loading").fadeOut("fast");		
 }
 $(document).ready(function() {		
		<!--تغییر براساس وضعیت پیمانکار-->
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
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_eblagh']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($shomare_eblagh)     $temp.=" and shomare_eblagh LIKE '%$shomare_eblagh%'";
 if($tarikh_eblagh)      $temp.=" and tarikh_eblagh LIKE '%$tarikh_eblagh%'";
 if($code_group_kala_top)$temp.=" and code_group_kala_top LIKE '%$code_group_kala_top%'";
 if($meghdar_kharid_keshvar)     $temp.=" and meghdar_kharid_keshvar LIKE '%$meghdar_kharid_keshvar%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_eblagh']=$temp;} else $_SESSION['mt_search_eblagh']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName T WHERE 1=1 ".$_SESSION['mt_search_eblagh']." AND deleted=0");
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
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
 mysql_query('START TRANSACTION'); 
 $del_q="update $TableName set deleted=1 WHERE id_eblagh=$id_eblagh_ AND ($id_eblagh_ NOT IN (SELECT id_eblagh FROM sahmiebandy_kharid WHERE id_eblagh=$id_eblagh_ AND deleted=0))";
 $del_res=mysql_query($del_q);
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 /*لاگ*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_eblagh_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
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
/************EBTAL BUTTON********/// ابطال 
if (isset($ebtal_x))
{
   //echo"<script>alert($idMojody)</script>";
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $ebtal_r_q ="UPDATE $TableName SET status=1 WHERE id=$id_";
   $ebtal_res=mysql_query($ebtal_r_q);
   /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ابطال برگه تعدیل',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   //خواندن موجودی با استفاده از تابع 
   $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
   $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
   $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);

	//آپدیت موجودی کالا    
	$update_mojody_res=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton' WHERE id='$idMojody'");  
    /*لاگ موجودی*/$log_m_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala','$idMojody','ابطال برگه تعدیل و برگشت موجودی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/   
	if($ebtal_res and $log_d and $update_mojody_res and $log_m_e)
    {
          mysql_query("COMMIT"); 
	      echo "<script>window.location='".$FileName."?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
    }
    else
    {
	      mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	      echo "<script>alert(' مشکلی در ابطال برگه تعدیل به وجود آمده است ')</script>";  
    }
  mysql_query('SET AUTOCOMMIT=1');  		   
}//END EBTAL 

/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
$load="document.myform.shomare_eblagh.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE()">
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
	<tr class="table-title">';
	/********************sort field***********************/
if(!isset($order))      $order='id_eblagh DESC';
if(!isset($sortshomare))$sortshomare='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sortmahmule)) $sortmahmule='1';
if(!isset($sortgroup))  $sortgroup='1';
if(!isset($sortkala))   $sortkala='1';
if(!isset($show_img))   $show_img='';
	if($sortshomare=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی شماره ابلاغ" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare_eblagh ASC&sortshomare=2&show_img=1\'"/> شماره ابلاغ ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortshomare=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی شماره ابلاغ" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare_eblagh DESC&sortshomare=1&show_img=1\'"/> شماره ابلاغ ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی تاریخ ابلاغ" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_eblagh ASC&sorttarikh=2&show_img=2\'"/> تاریخ ابلاغ '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی تاریخ ابلاغ" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_eblagh DESC&sorttarikh=1&show_img=2\'"/> تاریخ ابلاغ '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortmahmule=='1')
	{echo'<td width="7%" title="مرتب سازی صعودی نوع محموله" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=mahmule_type ASC&sortmahmule=2&show_img=3\'"/> نوع محموله '; 
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortmahmule=='2')
	{echo'<td width="7%" title="مرتب سازی نزولی نوع محموله" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=mahmule_type DESC&sortmahmule=1&show_img=3\'"/> نوع محموله '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
    if($sortgroup=='1')
	{echo'<td width="7%" title="مرتب سازی صعودی گروه کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameGroupKala ASC&sortgroup=2&show_img=4\'"/> گروه کالا '; 
	  if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortgroup=='2')
	{echo'<td width=7%" title="مرتب سازی نزولی گروه کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameGroupKala DESC&sortgroup=1&show_img=4\'"/> گروه کالا '; 
	  if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	// if($sortkala=='1')
	// {echo'<td width="15%" title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_kala ASC&sortkala=2&show_img=4\'"/> نام کالا '; 
	  // if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	// if($sortkala=='2')
	// {echo'<td width="15%" title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_kala DESC&sortkala=1&show_img=4\'"/> نام کالا '; 
	  // if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	// }
	echo'
	 <td width="13%">مقدار خرید (کیلوگرم/عدد)</td>
	 <td width="13%">جمع کل سهمیه تخصیصی</td>
	 <td width="10%">مانده از سهمیه تخصیصی</td>';
	 IF($right_sahmiebandy)echo'<td width="10%">سهمیه بندی</td>';
	 echo'
	 <td width="10%">دستورالعمل</td>';
	 if($right_prt)echo'<td width="5%">چاپ</td>';
	 if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td width="5%">حذف</td>';
    echo'
	</tr>';
	$i=0;
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$condition_ostan='';}
	else {$condition_ostan=' AND code_ostan='.$mt_gl_code_ostan.'';}
	$q1="SELECT T.*,
	    (SELECT name_group_kala_top From bzacc.group_kala_top g WHERE g.code_group_kala_top=T.code_group_kala_top) nameGroupKala,
	    (SELECT COUNT(*) FROM sahmiebandy_kharid WHERE sahmiebandy_kharid.id_eblagh=T.id_eblagh AND deleted=0 $condition_ostan) sahmiecount,
	    (SELECT COUNT(*) FROM dastorolamal_kharid WHERE dastorolamal_kharid.id_eblagh=T.id_eblagh AND deleted=0) dastorolcount
		From $TableName T WHERE 1=1 ".$_SESSION['mt_search_eblagh']." AND T.deleted=0 order by $order $Limit";
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_eblagh_='.$row1['id_eblagh'].'&shomare_eblagh_='.$row1['shomare_eblagh'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
	 {echo'<tr '; if($row1['status']==0) echo' class="table-odd"'; else echo 'class="row-ebtal"';echo'>';}	 
     else
	 {echo'<tr '; if($row1['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo'>';}


	 $sum_sahmie=$db->get_from_where("SUM(max_kharid_ostan)","meat.sahmiebandy_kharid","id_eblagh=".$row1['id_eblagh']." AND deleted=0");
	 $mande_sahmie=$row1['meghdar_kharid_keshvar']-$sum_sahmie;
	 echo'
	  <td '.$edtClick.'>'.$row1['shomare_eblagh'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_eblagh'].'</td>
	  <td '.$edtClick.'>'.$mahmuletypeArr[$row1['mahmule_type']].'</td>
	  <td '.$edtClick.'>'.$row1['nameGroupKala'].'</td>
	  <!--<td '.$edtClick.'>'.$row1['name_kala'].'</td>-->
	  <td '.$edtClick.'>'.virgul($row1['meghdar_kharid_keshvar']).'</td>
	  <td '.$edtClick.'>'.virgul($sum_sahmie).'</td>
	  <td '.$edtClick.'>'.virgul($mande_sahmie).'</td>';
	  if($right_sahmiebandy) {echo'<td><input type="button" class="button-inline"  value="سهمیه ['.$row1['sahmiecount'].']" onClick="window.location=\'sahmiebandy_kharid.php?PageNo='.$PageNo.'&id_eblagh='.$row1['id_eblagh'].'\'"></td>';}
	  echo'
	  <td>';
	  if($right_dastorolamal) {echo'<input type="button" class="button-inline"  value="دستورالعمل['.$row1['dastorolcount'].']" onClick="window.location=\'dastorolamal_kharid.php?PageNo='.$PageNo.'&id_eblagh='.$row1['id_eblagh'].'\'">';}
      echo'
	  </td>';
	  if($right_prt){echo'<td align="center"><div onClick="window.open(\'print_eblagh_one.php?id_eblagh_='.$row1['id_eblagh'].'\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ"><a href="#"></a></div></td>';}
	  if(($right_del)and($_SESSION['mtStatusYear']==0))
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" title="حذف" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_eblagh_='.$row1['id_eblagh'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف برگه '.$row1['shomare_eblagh'].' \')" /></td>';
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
	  <td>&nbsp;</td>';
	  if($right_sahmiebandy)echo'<td>&nbsp;</td>';
	  if($right_prt) echo'<td>&nbsp;</td>';
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
	 <td width="24"><div onClick="window.open(\'print_eblagh_kharid.php\',\'_blank\',\'scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 //اگر اجازه ایجاد رسید را دارد و وضعیت سال فعال است و سال فعال سال جاری است
	 //if(($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION["mtActiveYear"]==$yy))
	 if(($right_ins)and($_SESSION['mtStatusYear']==0))
	 { echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	        <td width="10px">&nbsp;</td>';}
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوی اصلی"  ><a href="#"></a></div></td> 
	 <td width="40px">&nbsp;</td>	   
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
     if ($_SESSION['mt_search_eblagh']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td>
	  <span class="tedadcover" align="center" > تعداد کل ['.$cnt.'] 
	 </td> 	 
	</tr>';
    }
	if ($Mode=="Insert" )  //Insert Mode
    {echo '
    <tr> 
	 <td width="80%" class="borderall" style="position:absolute;bottom:10px;left:10%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="6" align="center">ايجاد ابلاغ جدید</td></tr>	   
	   <tr>
		<td align="left" width="160px"><span class="star">*</span> شماره ابلاغ :&nbsp; </td>
		<td align="right" width="160px"><input type="text" class="textboxme" name="shomare_eblagh" value="'.$shomare_eblagh.'"/></td>
        <td align="left" width="160px"><span class="star">*</span> تاریخ ابلاغ :&nbsp;</td>
		<td align="right" width="160px"><input class="textboxme2" type="text" maxlength="10" name="tarikh_eblagh" id="datepicker6" value="'.$tarikh_eblagh.'"/></td>
	   </tr>
       <tr>
	    <td align="left"><span class="star">*</span> گروه کالا :&nbsp;</td><td align="right">'.listbox("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='text4'").'</td>
		<td align="left" class="goshtshow" style="display:none;"><span class="star">*</span> نوع گوشت : &nbsp;</td><td align="right" class="goshtshow" style="display:none;">'.static_listbox("gosht_type",$gosht_type,"goshttypeArr",1,"class='text4'").'</td>';	   
	    //اگر ارروری در صفحه ظاهر شد
	    if($code_group_kala_top==5)//اگر گوشت
		  echo'<td align="left" class="goshtshow"><span class="star">*</span> نوع گوشت : &nbsp;</td><td align="right" class="goshtshow">'.static_listbox("gosht_type",$gosht_type,"goshttypeArr",1,"class='text4'").'</td>';
		echo'
		<td align="left" ><span class="star">*</span> مقدار خرید :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_kharid_keshvar" value="'.$meghdar_kharid_keshvar.'" onkeypress="return isNumber(event)" /> (کیلوگرم/عدد)</td>
	   </tr>
	   <tr>	   
		<td align="left" width="160px"><span class="star">*</span> نام صادرکننده :&nbsp; </td>
		<td align="right" ><input type="text" class="textboxme" name="name_saderkonande" value="'.$name_saderkonande.'"/></td>
       	<td align="left"><span class="star">*</span> نوع محموله :&nbsp;</td><td align="right">'.static_listbox("mahmule_type",$mahmule_type,"mahmuletypeArr",1,"class='text4'").'</td>
	   </tr>
	   <tr class="footer">
        <td colspan="8" align="center">
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
	 $q3=("SELECT T.* FROM $TableName T WHERE T.id_eblagh='$id_eblagh_' AND T.deleted=0");
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
     $exist_sahmie=$db->get_from_where("count(id_eblagh)"," sahmiebandy_kharid ","id_eblagh='$id_eblagh_'");	

	echo'
	<tr> 
	 <td width="80%" class="borderall" style="position:absolute;bottom:10px;left:10%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات شماره ابلاغ  '.$row3['shomare_eblagh'].'</td></tr>        
	   <tr>
		<td align="left" width="160px"> شناسه ابلاغ :&nbsp; </td>
	    <td align="right" width="160px"><input type="text" class="textboxme2" readonly name="id_eblagh" value="'.$row3['id_eblagh'].'"  /></td>
		<td align="left" width="160px"><span class="star">*</span> شماره ابلاغ :&nbsp; </td>
		<td align="right" width="160px"><input type="text" class="textboxme" name="shomare_eblagh" value="'.$row3['shomare_eblagh'].'"/></td>
        <td align="left" width="160px"><span class="star">*</span> تاریخ ابلاغ :&nbsp;</td>
		<td align="right" width="160px"><input class="textboxme2" type="text" maxlength="10" name="tarikh_eblagh" id="datepicker6" value="'.$row3['tarikh_eblagh'].'"/></td>
	   </tr>
       <tr>
	    <td align="left"><span class="star">*</span> گروه کالا :&nbsp;</td><td align="right">'.listbox("code_group_kala_top",$row3['code_group_kala_top'],"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","onchange=getKalaFromGroup(this.value) class='text4'").'</td>
		<td align="left" ><span class="star">*</span> مقدار خرید :&nbsp; </td><td align="right"><input type="text" class="textboxme2" name="meghdar_kharid_keshvar" value="'.$row3['meghdar_kharid_keshvar'].'" onkeypress="return isNumber(event)" /> (کیلوگرم/عدد)</td>
	    <td align="left" ><span class="star">*</span> نوع محموله :&nbsp;</td><td align="right">'.static_listbox("mahmule_type",$row3['mahmule_type'],"mahmuletypeArr",1,"class='text4'").'</td>
	   </tr>
	   <tr>	   
		<td align="left" width="160px"><span class="star">*</span> نام صادرکننده :&nbsp; </td>
		<td align="right"  colspan="3"><input type="text" class="textboxme" name="name_saderkonande" value="'.$row3['name_saderkonande'].'"/></td>';
	   	if($row3['code_group_kala_top']==5)//اگر گوشت
		  echo'<td align="left" class="goshtshow"><span class="star">*</span> نوع گوشت : &nbsp;</td><td align="right" class="goshtshow">'.static_listbox("gosht_type",$row3['gosht_type'],"goshttypeArr",1,"class='text4'").'</td>';
		echo'
		</tr>
	   <!--<tr>
	     <td align="left"><span class="star">*</span> نام کالا :&nbsp;</td><td align="right" colspan="3">'.listbox("code_kala",$row3['code_kala'],"code_kala","name_kala","kala","code_group_kala_top=".$row3['code_group_kala_top']."","class='text4'").'
		<td align="left"><span class="star">*</span> قیمت خرید :&nbsp; </td>
		<td align=/"right" ><input type="text" class="textboxme2" name="gheymat_kharid" value="'.$row3['gheymat_kharid'].'"  onkeypress="return isNumber(event)" /> (ریال)</td>
       </tr>-->	
	   <tr class="footer">'; 
		 if((($right_edt)and($row3['status']==0)and($_SESSION['mtStatusYear']==0))or((SuperUser())and($row3['status']==0)))
		 {echo'
		  <td colspan="8" align="center">
		   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
           <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
		  </td>';
		 }
         else echo'<td  colspan="8" align="center" class="title"><div onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"></a></div></td> ';
         echo'
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if ($Mode=="Search" )//Search Mode
    {echo '
    <tr> 
	 <td width="80%" class="borderall" style="position:absolute;bottom:10px;left:10%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">جستجوی فرم ابلاغ</td></tr>
	   <tr>
		<td align="left" > شماره ابلاغ :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="shomare_eblagh" value="'.$shomare_eblagh.'"/></td>
        <td align="left"> تاریخ ابلاغ :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_eblagh" id="datepicker6" value="'.$tarikh_eblagh.'"/></td>
	   </tr>
       <tr>
	    <td align="left"> گروه کالای انباروسردخانه :&nbsp;</td><td align="right">'.listbox("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","onchange=getKalaFromGroup(this.value) class='text4'").'</td>
		<td align="left" > مقدار خرید :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar_kharid_keshvar" value="'.$meghdar_kharid_keshvar.'" onkeypress="return isNumber(event)" /> (کیلوگرم/عدد)</td>
	   </tr>
	   <tr>	   
		<td align="left"> نام صادرکننده :&nbsp; </td>
		<td align="right" ><input type="text" class="textboxme" name="name_saderkonande" value="'.$name_saderkonande.'"/></td>
       </tr>   
	   <tr><td>&nbsp;</td></tr>
	   <tr class="footer">
        <td colspan="10" align="center">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو">
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
</div>';
/**********اجازه براي ويرايش اطلاعات********/
//function isPermitSave($sh_barge,$date_barge,$name_s,$c_grp_top,$c_kala,$meghdar,$gheymat,$gl_year)
function isPermitSave($sh_barge,$date_barge,$name_s,$c_grp_top,$gosht_type,$mah_type,$meghdar,$gl_year)
{
 $flag=false;
 if(!($gl_year))//اگر سشن سال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً سال مورد نظر خود راانتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!empty($sh_barge))//تکراری نبودن شماره
 { 
    $q8="SELECT shomare_eblagh FROM eblagh_kharid WHERE shomare_eblagh='$sh_barge'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين شماره ابلاغ قبلا ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;  
 //if(!($sh_barge and $date_barge and $name_s and $c_grp_top and $c_kala and $meghdar and $gheymat))//پر بودن فيلدها
 if(!($sh_barge and $date_barge and $name_s and $c_grp_top and $mah_type and $meghdar))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($c_grp_top==5)AND(!$gosht_type))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
//function isPermitEdit($sh_barge,$date_barge,$name_s,$c_grp_top,$c_kala,$meghdar,$gheymat,$gl_year)
function isPermitEdit($sh_barge,$date_barge,$name_s,$c_grp_top,$gosht_type,$mah_type,$meghdar,$gl_year,$sum_sahm,$this_id)
{
 $flag=false;
 if(!($gl_year))//اگر سشن سال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً سال مورد نظر خود راانتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($sh_barge and $date_barge and $name_s and $c_grp_top and $mah_type and $meghdar))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($c_grp_top==5)AND(!$gosht_type))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($sh_barge))//تکراری نبودن شماره
 { 
    $q8="SELECT shomare_eblagh FROM eblagh_kharid WHERE shomare_eblagh='$sh_barge' AND id_eblagh!='$this_id'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين شماره ابلاغ قبلا ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;  
 if($meghdar<$sum_sahm)//مقدار ابلاغ از مقدار سهمیه بندی ها کمتر نباشد
 {
   $flag=false;
   echo"<script>window.alert('مقدار ابلاغ از مقادیر سهمیه بندی کمتر است!');</script>";
   return $flag;
 } 
 else $flag=true;
 
return $flag;
}
/*************INSERT  BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
  //if(isPermitSave($shomare_eblagh,$tarikh_eblagh,$name_saderkonande,$code_group_kala_top,$code_kala,$meghdar_kharid_keshvar,$gheymat_kharid,$mtActiveYear))
  if(isPermitSave($shomare_eblagh,$tarikh_eblagh,$name_saderkonande,$code_group_kala_top,$gosht_type,$mahmule_type,$meghdar_kharid_keshvar,$mtActiveYear))
  { 
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $insert_q=("INSERT INTO $TableName
             (shomare_eblagh,tarikh_eblagh,name_saderkonande,code_group_kala_top,gosht_type,mahmule_type,meghdar_kharid_keshvar,year,deleted)
              VALUES
			 ('$shomare_eblagh','$tarikh_eblagh','$name_saderkonande','$code_group_kala_top','$gosht_type','$mahmule_type','$meghdar_kharid_keshvar','$mtActiveYear',0)"); 		 
   $insert_res=mysql_query($insert_q);
    /*لاگ*/
    $max_id=$db->get_from_where("MAX(id_eblagh)","$TableName","");   
	$log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	if($insert_res and $log_i)
	{
	  mysql_query("COMMIT");
      echo "<script>window.location='".$FileName."?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";  
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
 //if(isPermitEdit($shomare_eblagh,$tarikh_eblagh,$name_saderkonande,$code_group_kala_top,$code_kala,$meghdar_kharid_keshvar,$gheymat_kharid,$mtActiveYear))
 $sum_sahmie=$db->get_from_where("SUM(max_kharid_ostan)","meat.sahmiebandy_kharid","id_eblagh=".$id_eblagh_." AND deleted=0");
 if(isPermitEdit($shomare_eblagh,$tarikh_eblagh,$name_saderkonande,$code_group_kala_top,$gosht_type,$mahmule_type,$meghdar_kharid_keshvar,$mtActiveYear,$sum_sahmie,$id_eblagh_))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET shomare_eblagh='$shomare_eblagh',tarikh_eblagh='$tarikh_eblagh',name_saderkonande='$name_saderkonande',
            code_group_kala_top='$code_group_kala_top',gosht_type='$gosht_type',mahmule_type='$mahmule_type',meghdar_kharid_keshvar='$meghdar_kharid_keshvar',year='$mtActiveYear' WHERE id_eblagh='$id_eblagh_';");         
  $edit_res=mysql_query($edit_q);
  if($edit_res)
  { $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_eblagh_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  /*کوئری لاگ*/ 
    echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
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