<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="mojavez_oftokasry.php";
$TableName="mojavez_oftokasry";
$right_ins=0;$right_edt=0;$right_takmil=0;$right_del=0;$right_prt=0;$right_ebtal=0;
if (right(181))  $right_ins=1;
if (right(182))  $right_edt=1;
if (right(183)) $right_del=1; 
if (right(184)) $right_prt=1; 
if (right(185)) $right_ebtal=1;
if (right(186))  $right_takmil=1; 
$titr='طرح در کمیسیون افت و کسری';
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
    $("#datepickerfrom").datepicker({
	    defaultDate:"'.$today.'",
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { 
	    defaultDate:"'.$today.'",
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true,
		});		
 });
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
   window.event.keyCode = 9;
}
function getDetailKala(code_kala)<!--اطلاعات کالا-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKALA:code_kala},function(data){			 
			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#sharh_vahedkala").val(splKala[1]);
		 });
    $("#loading").fadeOut("fast");
}
function getDetailKala3(code_kala)<!--اطلاعات کالا-->
{ 
  $("#loading").fadeIn("fast");
  $.ajax({
  type: "POST",
  url: "ajax.php",
  data: {codeKALA3:code_kala},
  success: function(data) {
  			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#img_mojody").html(splKala[1]);
			  //$("[name=code_bastebandy]").val(splKala[2]);
              if(code_kala==50) $(".shane").show();
              else  $(".shane").hide();
  },
 });
 $("#loading").fadeOut("fast");
}
function sumkarton()<!--محاسبه مجموع وزن کارتن ها-->
{
 var sum_k;
 sum_k=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_oftokasry.value)).toFixed(3);
 document.myform.sum_karton_oftokasry.value=sum_k;
}
function vazn_khales()<!--محاسبه وزن خالص-->
{
 var natije_vazn;
 natije_vazn=parseFloat((document.myform.meghdar_nakhales_oftokasry.value)-(document.myform.sum_karton_oftokasry.value)).toFixed(3);                                      
 if(natije_vazn<0) natije_vazn=0;
 document.myform.meghdar_khales_oftokasry.value=natije_vazn;
}
function sumghooti()<!--محاسبه وزن قوطی ها یا همان موجودی خالص-->
{
 var sum_k2;
 sum_k2=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_oftokasry.value)).toFixed(3);
 document.myform.meghdar_khales_oftokasry.value=sum_k2;
}
<!--چک کردن کدبسته بندی کالا و نوع بسته بندی انتخاب شده--> 
function validateCodeKala(code_kala,code_bastebandy)
{   
  $("#loading").fadeIn("fast"); 
       $.ajax({
        url: "ajax_validate.php",
        type: "post",
        data:{codekalaForValidate:code_kala,bastebandyForValidate:code_bastebandy},
        success: function(data){$("#codekalaError").html(data);}
    });
  $("#loading").fadeOut("fast");				
}
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_oft']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($shomare_nameh) $temp.=" and shomare_nameh LIKE '%$shomare_nameh%'";
 if($tarikh_nameh)  $temp.=" and tarikh_nameh LIKE '%$tarikh_nameh%'";
 if($shomare_mojavez)  $temp.=" and shomare_mojavez LIKE '%$shomare_mojavez%'";
 if($tarikh_mojavez)   $temp.=" and tarikh_mojavez LIKE '%$tarikh_mojavez%'";
 if($code_kala)              $temp.=" and T.code_kala LIKE '$code_kala'";
 if($noe_oftokasry)              $temp.=" and noe_oftokasry LIKE '$noe_oftokasry'";
 if($meghdar_oftokasry)  $temp.=" and meghdar_oftokasry LIKE '%$meghdar_oftokasry%'";
 if($tozihat_nameh)                $temp.=" and tozihat_nameh LIKE '%$tozihat_nameh%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_oft']=$temp;} else $_SESSION['mt_search_oft']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName T WHERE 1=1 ".$_SESSION['mt_search_oft']." AND code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
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
$tedad_jary=$db->get_from_where("COUNT(*)","$TableName T","1=1 ".$_SESSION['mt_search_oft']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
$tedad_ebtaly=$db->get_from_where("COUNT(*)","$TableName T","1=1 ".$_SESSION['mt_search_oft']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=1"); 
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
}//END DELETE
/************EBTAL BUTTON********/// ابطال 
if (isset($ebtal_x))
{
  mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
  mysql_query('START TRANSACTION');
  $ebtal_res=$db->query("UPDATE $TableName SET status=1 WHERE id_mojavez=$id_mojavez_ ");
  /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_mojavez_','ابطال فرم کمیسیون افت و کسری',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
  if($ebtal_res and $log_d)
  {
    mysql_query("COMMIT"); 
	echo "<script>window.location='".$FileName."?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
  }
  else
  {
	mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	echo "<script>alert(' مشکلی در ابطال به وجود آمده است ')</script>";  
  }
  mysql_query('SET AUTOCOMMIT=1');  
}//END EBTAL 
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
$load="document.myform.shomare_nameh.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:45%;">'.$titr.'</div>
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
if(!isset($order))      $order='id_mojavez  DESC';
if(!isset($sortcode))   $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sortname))   $sortname='1';
if(!isset($sortstatus)) $sortstatus='1';
if(!isset($show_img))   $show_img='';
    echo'<td width="4%" rowspan="2">شناسه</td>';
    echo'<td width="7%" rowspan="2">شماره نامه</td>';
    echo'<td width="7%" rowspan="2">تاریخ نامه</td>';
	if($sortname=='1')
	{echo'<td width="10%" rowspan="2" title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameKala ASC&sortname=2&show_img=3\'"/> نام کالا '; 
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="10%" rowspan="2" title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameKala DESC&sortname=1&show_img=3\'"/> نام کالا '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	 <td width="8%" rowspan="2">تولیدکننده</td>
	 <td width="10%" colspan="3">تاریخ تولید</td>
	 <td width="3%" rowspan="2">نوع</td>
	 <td width="10%" colspan="3">مقادیر</td>
	 <td width="5%" rowspan="2">وضعیت</td>';
	 if($sortcode=='1')
	 {echo'<td width="10%" rowspan="2" title="مرتب سازی صعودی شماره مجوز" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan ASC,code_anbar ASC,shomare_mojavez ASC&sortcode=2&show_img=1\'"/> شماره مجوز ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {echo'<td width="10%" rowspan="2" title="مرتب سازی نزولی شماره مجوز" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan DESC,code_anbar DESC,shomare_mojavez DESC&sortcode=1&show_img=1\'"/> شماره مجوز ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sorttarikh=='1')
	 {echo'<td width="10%" rowspan="2" title="مرتب سازی صعودی تاریخ مجوز" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_mojavez ASC&sorttarikh=2&show_img=2\'"/> تاریخ مجوز '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sorttarikh=='2')
	 {echo'<td width="10%" rowspan="2" title="مرتب سازی نزولی تاریخ مجوز" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_mojavez DESC&sorttarikh=1&show_img=2\'"/> تاریخ مجوز '; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 Echo'
	 <td width="10%" rowspan="2">اطلاعات تکمیلی</td>
	 <td width="3%" colspan="2">تأیید </td>
	 ';
	 if($right_prt)echo'<td width="3%" rowspan="2">چاپ</td>';
	 if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td width="3%" rowspan="2">حذف</td>';
	 echo'
	</tr>
	<tr class="table-title">
	 <td>سال</td>
	 <td>ماه</td>
	 <td>روز</td>
	 <td>تعداد</td>
	 <td>ناخالص</td>
	 <td>خالص</td>
	 <td>اولیه</td>
	 <td>نهایی</td>
	</tr>';
	$i=0;
	$q1="SELECT T.*,(SELECT name_kala From kala WHERE kala.code_kala=T.code_kala) nameKala,
		(SELECT name_tolidkonande From tolidkonande WHERE tolidkonande.code_tolidkonande=T.code_tolidkonande) nameTolidkonande
		 From $TableName T WHERE 1=1 ".$_SESSION['mt_search_oft']." AND code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by $order $Limit";
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
	 IF(($right_edt)AND($row1['chktaeed']==0)){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_mojavez_='.$row1['id_mojavez'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
	 if($i++%2)
	 {echo'<tr '; if($row1['status']==0) echo' class="table-odd"'; else echo 'class="row-ebtal"';echo'>';}	 
     else
	 {echo'<tr '; if($row1['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo'>';}
	 if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
     else $code_a=$row1['code_ostan'];
     echo'
	  <td '.$edtClick.'>'.$row1['id_mojavez'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_nameh'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_nameh'].'</td>
	  <td '.$edtClick.'>'.$row1['nameKala'].'</td>
	  <td '.$edtClick.'>'.$row1['nameTolidkonande'].'</td>
	  <td '.$edtClick.'>'.$row1['sal_tolid_shamsi'].'</td>
	  <td '.$edtClick.'>'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'</td>
	  <td '.$edtClick.'>'.$row1['rouz_tolid_shamsi'].'</td>
	  <td '.$edtClick.'>'.$tadilArr[$row1['noe_oftokasry']].'</td>
	  <td '.$edtClick.'>'.virgul($row1['tedad_oftokasry']).'</td>
	  <td '.$edtClick.'>'.round($row1['meghdar_nakhales_oftokasry'],3).'</td>
	  <td '.$edtClick.'>'.round($row1['meghdar_khales_oftokasry'],3).'</td>
	  ';
	  echo'<td '.$edtClick.'>';if($row1['status']==0) echo 'جاری';else echo 'ابطالی </td>';	  
	  echo'
	  <td '.$edtClick.'>'.$row1['shomare_mojavez'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_mojavez'].'</td>';
	  if($right_takmil) {echo'<td><input type="button" class="button-inline"  value="تکمیل فرم توسط ستاد مرکزی"  onClick="window.location=\''.$FileName.'?Mode=Takmil&id_mojavez_='.$row1['id_mojavez'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" ></td>';}
	  echo'<td '.$edtClick.'>';if($row1['chktaeed']==1)echo '<span class="fa fa-check-circle fa-2x" style="color:YellowGreen"></span>'; else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>';	
	  echo'<td '.$edtClick.'>';if($row1['chktaeed_final']==1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>'; else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>';	
	  echo'
	  <td align="center">';
	  if($right_prt){echo'<div onClick="window.open(\'print_mojavez_oftokasry_one.php?id_mojavez_='.$row1['id_mojavez'].'\',\'_blank\',\'scrollbars=yes\')"';if($row1['status']==0) echo'id="printer_T"'; if($row1['status']==1) echo'id="printer_T_ebtal"'; echo'title="چاپ"><a href="#"></a></div>';}
      echo'</td>'; 
	  if(($right_del)and($_SESSION['mtStatusYear']==0))
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" title="حذف" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_mojavez_='.$row1['id_mojavez'].'&code_kala_='.$row1['code_kala'].'&noe_tadil_='.$row1['noe_oftokasry'].'&meghdar_tadil_='.$row1['meghdar_oftokasry'].'&code_ziranbar_='.$row1['shomare_nameh'].'&status_='.$row1['status'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف برگه '.$code_a.$row1['code_anbar'].$row1['shomare_mojavez'].' \')" /></td>';
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
	  <td>&nbsp;</td>';
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
	 <td width="10px">&nbsp;</td>';
	 if(($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION['mt_anbar_activate']==1)and($mt_gl_code_anbar!=301))
	 {echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
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
     if ($_SESSION['mt_search_oft']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td>
	  <span class="tedadcover" align="center" > تعداد کل ['.$cnt.'] <br/>
	  جاری ['.$tedad_jary.']&nbsp; / ابطالی ['.$tedad_ebtaly.']</span>  
	 </td>  	 
	</tr>';
    }
	if ($Mode=="Insert" )  //Insert Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="10" align="center">ايجاد نامه جدید</td></tr>
       <tr><td>&nbsp;</td></tr>
	   <tr>	   
	   	<td align="left" width="200px"><span class="star">*</span> شماره نامه (درخواست استان) : &nbsp; </td>
		<td align="right">
		<input type="text" class="textboxme2" value="'.$shomare_nameh.'" name="shomare_nameh"/></td>
        <td align="left" width="150px"><span class="star">*</span> تاریخ نامه  : &nbsp; </td><td align="right"><input class="textboxme2" type="text" maxlength="10" id="datepickerfrom" name="tarikh_nameh" value="'.$tarikh_nameh.'"/></td>
	    <td width="250px">&nbsp;</td>
	   </tr>
	   <tr>
	    <td align="left"><span class="star">*</span> نوع : &nbsp; </td><td align="right">'.static_listbox("noe_oftokasry",$noe_oftokasry,"tadilArr",1,"class='text4' onchange=myform.submit()").'</td>
	    <td align="left"><span class="star">*</span> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","1=1 ORDER BY sharh_bastebandy ASC","class='text4' onchange=myform.submit()","").'
		   <img border="0" src="images/Info1.png" title="در صورت تغییر مجدد بسته بندی دوباره درفیلد کد کالا کلیک نمایید و اطلاعات را دوباره انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>
	   </tr>';
       if(!$code_bastebandy)echo '<tr><td colspan="10" align="center">برای مشاهده سایراطلاعات نوع بسته بندی راانتخاب نمایید</td></tr>';		
	   if($code_bastebandy)
	   {
		echo'
		<tr>
		 <td align="left"><span class="star">*</span> کد کالا :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="code_kala" value="'.$code_kala.'" maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onfocus="getDetailKala3(this.value);" onchange="getDetailKala3(this.value)" onblur="validateCodeKala(this.value,document.myform.code_bastebandy.value)" style="width:50px"/>&nbsp;';
		  $code_bastebandy_=$code_bastebandy;
		  include('img_helpkalabastebandy.php');
		 echo'
		  <span id="codekalaError">&nbsp;</span>
		 ';
		 echo' <td  width="30px" align="center"><span id="img_mojody"></span></td>';
		 echo' <input type="hidden" id="id_mojody" name="id_mojody" value="'.$id_mojody.'"/>';
		 echo'
		</tr>
       <tr>
	    <td colspan="8">
		 <table border="0" width="100%">
		  <tr>
		   <td width="70%">
		    <fieldset>
	        <legend>مقادیر لازم از جدول موجودی کالا</legend>
	         <table width="100%" border="0">
	          <tr>
		       <td align="left">نام کالا :&nbsp;</td><td align="right" ><input type="text" class="textboxme" readonly name="name_kala" id="name_kala" value="'.$name_kala.'"/></td>';
			   echo'
			   <td align="left"><span class="star">*</span> تاریخ تولید شمسی  :&nbsp;</td>
	     	   <td align="right" colspan="3">
	     	        سال : <input class="textboxme2" readonly type="text" name="sal_tolid_shamsi"  style="width:40px;"/>
                    <!-- شدن disabled برای --> 
					ماه : '.static_listbox("mah_tolid_sh","","mahshamsiArr",1,"class='text4' disabled").'
                     <input type="hidden" name="mah_tolid_shamsi" />
	     	   	    روز : <input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" readonly/>
			         <input type="hidden" name="sal_tolid_milady" />
	     	         <input type="hidden" name="mah_tolid_milady" />
	     	         <input type="hidden" name="rouz_tolid_milady" />
			   </td>
              </tr>
		      <tr>			
				<input type=hidden name="code_keshvar"/>
			   <td align="left"><span class="star">*</span> نام کشور :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_keshvar" name="name_keshvar"/></td>
	           	<input type=hidden name="code_tolidkonande"/>
			   <td align="left"><span class="star">*</span> نام تولیدکننده :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande"/></td>   
			   	<input type=hidden name="code_ziranbar"/>
	           <td align="left"><span class="star">*</span> نام زیرانبار :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_ziranbar" name="name_ziranbar" /></td>
			  </tr>';
			  if($code_bastebandy==1)//کارتن
			  {
			   echo'
			   <tr>
			    <td align="left"><span class="star">*</span> کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" /></td>
			    <td align="left"><span class="star">*</span> وزن کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" /></td>
			   </tr>
			   <tr> 			  
			   <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" /></td>';
			   echo'<td align="left" class="shane">تعداد شانه :&nbsp; </td><td align="right"><input type="text" class="textboxme2 shane" readonly name="tedad_shane" /></td>';
			   echo'<td align="left">موجودی ناخالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_nakhales" /></td>
	           <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" /></td>
			  </tr>'; 
			  }
			  if($code_bastebandy==2)//قوطی
			  {
			   echo'
			   <tr>
			    <td align="left"><span class="star">*</span> کد قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" /></td>
			    <td align="left"><span class="star">*</span> وزن قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" /></td>
			   </tr>
			   <tr> 			  
			   <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" /></td>
	            <input type="hidden" name="tedad_shane" value="'.$tedad_shane.'"/>
	            <input type="hidden" name="mojody_nakhales" value="'.$mojody_nakhales.'"/>
			   <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" /></td>
			  </tr>';
			  }
			  if($code_bastebandy==3)//لاشه
			  {
			   echo'
			   <tr> 			  
			    <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" /></td>
	             <input type="hidden" name="code_karton"/>
	             <input type="hidden" name="vazn_karton_this"/>
	             <input type="hidden" name="tedad_shane"/>
				 <input type="hidden" name="mojody_nakhales"/>
			    <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" /></td>
			   </tr>';
			  }
			  echo'
		     </table> 
		    </fieldset>
	       </td>
		   <td width="30%" valign="top">
		    <fieldset>
	        <legend>مقادیر</legend>
		     <table width="100%" border="0">';
			  if($code_bastebandy==1)//کارتن
			  {echo'
	           <tr><td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_oftokasry" value="'.$tedad_oftokasry.'" onblur="return sumkarton()" onfocus="return sumkarton()" onkeypress="return isNumber(event)"/></td></tr>
	           <tr><td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_oftokasry" value="'.$sum_karton_oftokasry.'" onfocus="return sumkarton()"/></td></tr>		
			   <tr><td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="meghdar_nakhales_oftokasry" value="'.$meghdar_nakhales_oftokasry.'" onblur="return vazn_khales()" onfocus="return vazn_khales()" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
		       <tr><td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="meghdar_khales_oftokasry" value="'.$meghdar_khales_oftokasry.'" onfocus="return vazn_khales()" onKeydown="return PressfloatOnly(event,this)"/></td></tr>';
			  }
			  if($code_bastebandy==2)//قوطی
			  {echo'
	           <tr><td align="left"><span class="star">*</span> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_oftokasry" value="'.$tedad_oftokasry.'" onblur="return sumghooti()" onfocus="return sumghooti()" onkeypress="return isNumber(event)"/></td></tr>
		       <tr><td align="left"><span class="star">*</span> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="meghdar_khales_oftokasry" value="'.$meghdar_khales_oftokasry.'"/></td></tr>';
			  }
			  if($code_bastebandy==3)//لاشه
			  {echo'
	           <tr><td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_oftokasry" value="'.$tedad_oftokasry.'" onkeypress="return isNumber(event)"/></td></tr>
		       <tr><td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="meghdar_khales_oftokasry" value="'.$meghdar_khales_oftokasry.'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>';
			  }
			  echo'
			  <tr><td align="left">توضيحات نامه :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tozihat_nameh" value="'.$tozihat_nameh.'"/></td></tr>
			 </table>
		    </fieldset>
		   </td>
	      </tr>
	     </table>
		</td>
	   </tr>';
	   }//END code_bastebandy
	   echo'	   
	   <tr>
	    <td colspan="10" align="center" class="title">
		 <input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
		</td>	
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if($Mode=="Edit")//Edit Mode
    {
	 $q3=("SELECT T.*,kala.code_kala,name_kala,kala.code_group_kala_top,bastebandy.code_bastebandy,bastebandy.sharh_bastebandy,name_keshvar,name_tolidkonande,name_ziranbar,m_k.id AS id_Mojody
		  FROM $TableName T
		  INNER JOIN kala ON T.code_kala=kala.code_kala
		  INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy
		  INNER JOIN keshvar ON T.code_keshvar=keshvar.code_keshvar
		  INNER JOIN tolidkonande ON T.code_tolidkonande=tolidkonande.code_tolidkonande
		  INNER JOIN list_sardkhane_detail l_s_d ON T.code_ziranbar=l_s_d.code_ziranbar AND T.code_ostan=l_s_d.code_ostan AND T.code_anbar=l_s_d.code_anbar
		  INNER JOIN mojody_kala m_k ON T.code_kala=m_k.code_kala AND T.code_keshvar=m_k.code_keshvar AND T.code_tolidkonande=m_k.code_tolidkonande AND T.sal_tolid_shamsi=m_k.sal_tolid_shamsi AND T.mah_tolid_shamsi=m_k.mah_tolid_shamsi AND T.rouz_tolid_shamsi=m_k.rouz_tolid_shamsi AND T.code_karton=m_k.code_karton AND T.code_ostan=m_k.code_ostan AND T.code_anbar=m_k.code_anbar AND T.year=m_k.year
		  WHERE T.id_mojavez='$id_mojavez_' AND T.deleted=0"); 
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
	//با استفاده از تابع
     $tedad_karton=mojodyKarton($row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_ziranbar'],$row3['code_kala'],$row3['code_keshvar'],$row3['code_tolidkonande'],$row3['sal_tolid_shamsi'],$row3['mah_tolid_shamsi'],$row3['rouz_tolid_shamsi'],$row3['code_karton']);
     $mojody_nakhales=mojodyNakhales($row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_ziranbar'],$row3['code_kala'],$row3['code_keshvar'],$row3['code_tolidkonande'],$row3['sal_tolid_shamsi'],$row3['mah_tolid_shamsi'],$row3['rouz_tolid_shamsi'],$row3['code_karton']);
	 $mojody_khales=mojodyKhales($row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_ziranbar'],$row3['code_kala'],$row3['code_keshvar'],$row3['code_tolidkonande'],$row3['sal_tolid_shamsi'],$row3['mah_tolid_shamsi'],$row3['rouz_tolid_shamsi'],$row3['code_karton']);  
	 if($row3['code_group_kala_top']==7) $tedad_shane=$tedad_karton*$_SESSION["mtShane"];
	echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="10" align="center"> ويرايش اطلاعات نامه '.$row3['shomare_nameh'].' با شناسه '.$row3['id_mojavez'].'</td></tr>
       <tr>
	    <td colspan="8" align="left">
		 <table>
		  <tr>';
	      //اگر اجازه ابطال داشته و این فرم هنوز ابطال نشده و سال فعال است و تعدیل جاری نداریم
	      if(($right_ebtal)and($row3['status']==0)and($_SESSION['mtStatusYear']==0)and($row3['exist_tadil_jary']==0))
	      {
		   echo'<td align="left"><input type="button" class="buttonme" name="ebtal_x" value="ابطال مجوز" onClick="iconfirm(\''.$FileName.'?ebtal_x=1&id_mojavez_='.$row3['id_mojavez'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای ابطال مجوز تعدیل  '.$row3['shomare_mojavez_tadil'].' \')"/></td>      
		         <td width="20px"><img border="0" src="images/button-cross_basic.png" width="20" height="20" /></td>';}
		   if($row3['status']==1) echo'<td style="font-weight:bold;color:red;">وضعیت این فرم : ابطالی</td>';	
	      echo'
	      </tr>
		 </table>
		</td>
	   </tr>  	   
	   <tr>	   
	   	<td align="left" width="200px"><span class="star">*</span> شماره نامه (درخواست استان) : &nbsp; </td><td align="right"><input type="text" class="textboxme2" value="'.$row3['shomare_nameh'].'" name="shomare_nameh"/></td>
        <td align="left" width="150px"><span class="star">*</span> تاریخ نامه  : &nbsp; </td><td align="right"><input class="textboxme2" type="text" maxlength="10" id="datepickerfrom" name="tarikh_nameh" value="'.$row3['tarikh_nameh'].'"/></td>
	   </tr>
       <tr>
	   	<td align="left"><span class="star">*</span> نوع :&nbsp;</td><td align="right">'.static_listbox("noe_tadil",$row3['noe_tadil'],"tadilArr",1,"class='text4' disabled").'</td>
		<td align="left"><span class="star">*</span> کد کالا :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="code_kala" value="'.$row3['code_kala'].'" readonly maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px"/>&nbsp;';
		echo'
		</td>';
		IF(($row3['noe_tadil']==2)AND($row3['code_kala']==50))echo'<td align="left" class="changeCode"><input type="checkbox" name="chkchangeCode" '.$change_checked.'/></td><td align="right" class="changeCode"> تعویض کد کالا (مخصوص تخم مرغ)</td>';
		echo' <td width="30px"><span id="img_mojody"></span></td>';
		echo' <input type="hidden" id="id_mojody" name="id_mojody" value="'.$id_mojody.'"/>
	   </tr>
       <tr>
	    <td colspan="8">
	     <table border="0" width="100%">
	      <tr>
	       <td width="70%" valign="top">
		    <fieldset>
	        <legend>مقادیر لازم از جدول موجودی کالا</legend>
	         <table width="100%" border="0" height="115px">
	          <tr>
		       <td align="left">نام کالا :&nbsp;</td><td align="right" ><input type="text" class="textboxme" readonly name="name_kala" id="name_kala" value="'.$row3['name_kala'].'"/></td>
	           <td align="left">تاریخ تولید شمسی :&nbsp;</td>
	     	   <td align="right" colspan="3">
	     	        سال : <input class="textboxme2" readonly type="text" name="sal_tolid_shamsi" value="'.$row3['sal_tolid_shamsi'].'" style="width:40px;"/>
                    <!-- شدن disabled برای --> 
					ماه : '.static_listbox("mah_tolid_sh",$row3['mah_tolid_shamsi'],"mahshamsiArr",1,"class='text4' disabled").'
                     <input type="hidden" name="mah_tolid_shamsi" value="'.$row3['mah_tolid_shamsi'].'"/>
	     	   	    روز : <input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" readonly value="'.$row3['rouz_tolid_shamsi'].'"/>
			         <input type="hidden" name="sal_tolid_milady" value="'.$row3['sal_tolid_milady'].'"/>
	     	         <input type="hidden" name="mah_tolid_milady" value="'.$row3['mah_tolid_milady'].'"/>
	     	         <input type="hidden" name="rouz_tolid_milady" value="'.$row3['rouz_tolid_milady'].'"/>
			   </td>	
              </tr>
		      <tr>
			   	<input type=hidden name="code_keshvar" value="'.$row3['code_keshvar'].'"/>
	           <td align="left">نام کشور :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_keshvar" name="name_keshvar" value="'.$row3['name_keshvar'].'"/></td>
	           	<input type=hidden name="code_tolidkonande" value="'.$row3['code_tolidkonande'].'"/>
			   <td align="left">نام تولیدکننده :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande" value="'.$row3['name_tolidkonande'].'"/></td>   
				<input type=hidden name="code_ziranbar" value="'.$row3['code_ziranbar'].'"/>
	           <td align="left">نام زیرانبار :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_ziranbar" name="name_ziranbar" value="'.$row3['name_ziranbar'].'"/></td>
			  </tr>';
	          if($row3['code_bastebandy']==1)//کارتن
			  {echo'
			   <tr>
			    <td align="left">کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" value="'.$row3['code_karton'].'"/></td>
			    <td align="left">وزن کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" value="'.$row3['vazn_karton_this'].'"/></td>
			   </tr>
               <tr> 			  
			    <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>';
			    if($row3['code_group_kala_top']==7)echo'<td align="left">تعداد شانه :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_shane" value="'.$tedad_shane.'"/></td>';
			    echo'
				<td align="left">موجودی ناخالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_nakhales" value="'.round($mojody_nakhales,3).'"/></td>
	            <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" value="'.round($mojody_khales,3).'" /></td>
			   </tr>
			   <tr><td>&nbsp;</td></tr>';
			  }
	          if($row3['code_bastebandy']==2)//قوطی
			  {echo'
			   <tr>
			    <td align="left">کد قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" value="'.$row3['code_karton'].'"/></td>
			    <td align="left">وزن قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" value="'.$row3['vazn_karton_this'].'"/></td>
			   </tr>
               <tr> 			  
			    <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>
	            <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" value="'.round($mojody_khales,3).'"/></td>
			   </tr>';
			  }
	          if($row3['code_bastebandy']==3)//لاشه
			  {echo'
               <tr> 			  
			    <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>
	            <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" value="'.round($mojody_khales,3).'"/></td>
			   </tr>';
			  }
			  echo'
		     </table> 
		    </fieldset>		   
	       </td>
	       <td width="30%" valign="top"> 
		    <fieldset>
	        <legend>مقادیر</legend>
		     <table width="100%" border="0" height="115px">';
			  if($row3['code_bastebandy']==1)//کارتن
			  {echo'
	           <tr><td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" '; IF($row3['exist_tadil_jary']==1) echo' readonly'; echo' name="tedad_oftokasry" value="'.$row3['tedad_oftokasry'].'" onkeypress="return isNumber(event)"/></td></tr>';
	           if($row3['code_group_kala_top']==7)echo'<tr><td align="left"> تعداد شانه :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  readonly name="tedad_shane_mojavez" value="'.$row3['tedad_shane_mojavez'].'" onkeypress="return isNumber(event)"/></td></tr>';
	           echo'
			   <tr><td align="left">مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_oftokasry" value="'.$row3['sum_karton_oftokasry'].'" onfocus="return sumkarton()"/></td></tr>		
			   <tr><td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" '; IF($row3['exist_tadil_jary']==1) echo' readonly'; echo'  name="meghdar_nakhales_oftokasry" value="'.$row3['meghdar_nakhales_oftokasry'].'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
		       <tr><td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" '; IF($row3['exist_tadil_jary']==1) echo' readonly'; echo'  name="meghdar_khales_oftokasry" value="'.$row3['meghdar_khales_oftokasry'].'"  onfocus="return vazn_khales()" onKeydown="return PressfloatOnly(event,this)"/></td></tr>';
			  }
			  if($row3['code_bastebandy']==2)//قوطی
			  {echo'
	           <tr><td align="left" height="30px;"><span class="star">*</span> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" '; IF($row3['exist_tadil_jary']==1) echo' readonly'; echo' name="tedad_oftokasry" value="'.$row3['tedad_oftokasry'].'" onkeypress="return isNumber(event)"/></td></tr>
		       <tr><td align="left" height="35px;"><span class="star">*</span> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" '; IF($row3['exist_tadil_jary']==1) echo' readonly'; echo' name="meghdar_khales_oftokasry" value="'.$row3['meghdar_khales_oftokasry'].'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
			   ';
			  }
			  if($row3['code_bastebandy']==3)//لاشه
			  {echo'
	           <tr><td align="left" height="30px;"><span class="star">*</span> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" '; IF($row3['exist_tadil_jary']==1) echo' readonly'; echo' name="tedad_oftokasry" value="'.$row3['tedad_oftokasry'].'" onkeypress="return isNumber(event)"/></td></tr>
		       <tr><td align="left" height="35px;"><span class="star">*</span> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" '; IF($row3['exist_tadil_jary']==1) echo' readonly'; echo'  name="meghdar_khales_oftokasry" value="'.$row3['meghdar_khales_oftokasry'].'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
			   ';
			  }
			  echo'
		      <tr><td align="left">توضيحات تکمیلی :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tozihat_tadil" value="'.$row3['tozihat_tadil'].'"/></td></tr>
			 </table>
		    </fieldset>
		   </td>
	      </tr>
         </table>
        </td>
       </tr>		
	   <tr>
	   <tr>
        <td colspan="8" align="center" class="title">';
		if((($right_edt)and($_SESSION['mtStatusYear']==0)and($row3['exist_tadil']==0))or((SuperUser())and($row3['exist_tadil_jary']==0)))
		echo'<input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">';
        echo' 
		<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&mt_gl_code_ostan='.$mt_gl_code_ostan.'&mt_gl_code_anbar='.$mt_gl_code_anbar.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
    if ($Mode=="Takmil" )  //Takmil Mode
    {
	 $q3=("SELECT T.*,kala.code_kala,kala.name_kala,kala.code_vahedkala,vahed_kala.code_vahedkala,vahed_kala.sharh_vahedkala
		  FROM $TableName T
		  INNER JOIN kala ON T.code_kala=kala.code_kala
		  INNER JOIN vahed_kala ON vahed_kala.code_vahedkala=kala.code_vahedkala
		  WHERE T.id_mojavez='$id_mojavez_' AND T.deleted=0"); 
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
	 if($row3['chktaeed'] == 1) $taeed_checked = 'checked';
     else $taeed_checked = '';
	 if($row3['chktaeed_final'] == 1) $taeed_final_checked = 'checked';
     else $taeed_final_checked = '';
	 echo '
     <tr> 
	  <td width="70%" class="borderall" style="position:absolute;bottom:10px;left:15%;">	 
	   <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	    <tr class="title"><td colspan="10" align="center"> تکمیل اطلاعات نامه '.$row3['shomare_nameh'].' با شناسه '.$row3['id_mojavez'].'</td></tr>
	    <tr height="60px">
         <td align="left">';
		 if($row3['chktaeed'] == 1) echo'<span class="star">*</span> '; 
		 echo'
		 شماره مجوز : &nbsp;</td>		
	 	 <td align="right"><input type="text" class="textboxme2" value="'.$row3['shomare_mojavez'].'" name="shomare_mojavez"/></td>
         <td align="left">';
		 if($row3['chktaeed'] == 1) echo'<span class="star">*</span>  ';
		 echo'
		 تاریخ مجوز  : &nbsp;</td>
		 <td align="right"><input class="textboxme2" type="text" maxlength="10" id="datepickerto" name="tarikh_mojavez" value="'.$row3['tarikh_mojavez'].'"/></td>
	    </tr>
	    <tr>
	     <td align="left"><input type="checkbox" name="chktaeed" '.$taeed_checked.' />: &nbsp;</td>
		 <td align="right">تأیید اولیه نامه </td>
		 <td align="left">توضيحات تکمیلی : &nbsp; </td><td colspan="3" align="right"><input class="textboxme" type="text" name="tozihat_takmili" value="'.$row3['tozihat_takmili'].'"/></td>	    
	    </tr>
	    <tr>
	     <td align="left"><input type="checkbox" name="chktaeed_final" '.$taeed_final_checked.' />: &nbsp;</td>
		 <td align="right" style="font-weight:bold">تأیید نهایی و اجازه برای ثبت مجوز تعدیل </td>
	    </tr>
	    <tr>
        <td colspan="8" align="center" class="title">';
		//کاربر خانم میرحسینی
	 	if((($right_takmil)and($_SESSION['mtStatusYear']==0)and($row3['chktaeed_final']!=1))OR(($_SESSION['mt_user_id']==438)and($right_takmil)))
	 	echo'<input class="buttonme" type="submit" name="Takmil_x" id="sabt" value="ثبت تغييرات">';
        echo' 
	 	<input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&mt_gl_code_ostan='.$mt_gl_code_ostan.'&mt_gl_code_anbar='.$mt_gl_code_anbar.'\'">
        </td>
       </tr>
      </table>
	  </td>
     </tr>';
    }
	if ($Mode=="Search" )//Search Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 
	   <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0"><tr class="title"><td colspan="10" align="center">جستجوی فرم طرح در کمیسیون افت وکسری</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>	   
	   	<td align="left"> شماره نامه (درخواست استان) : &nbsp; </td>
		<td align="right">
		<input type="text" class="textboxme2" value="'.$shomare_nameh.'" name="shomare_nameh"/></td>
        <td align="left"> تاریخ نامه  : &nbsp; </td><td align="right"><input class="textboxme2" type="text" maxlength="10" id="datepickerfrom" name="tarikh_nameh" value="'.$tarikh_nameh.'"/></td>
	   </tr>
	   <tr>	   
	   	<td align="left"> شماره مجوز : &nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" value="'.$shomare_mojavez.'" name="shomare_mojavez"/></td>
        <td align="left"> تاریخ مجوز  : &nbsp; </td><td align="right"><input class="textboxme2" type="text" maxlength="10" id="datepickerto" name="tarikh_mojavez" value="'.$tarikh_mojavez.'"/></td>
	   </tr>
	   <tr>
	    <td align="left"> کد کالا : &nbsp; </td><td align="right"><input type="text" class="textboxme2" name="code_kala" id="code_kala" value="'.$code_kala.'" onfocus="getDetailKala(this.value)" onchange="getDetailKala(this.value)" onKeyUp="F10desc(event)" style="width:50px;"/>&nbsp;';
		include ("img_helpkala.php");
		echo'
		</td>
	    <td align="left">نام کالا : &nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="name_kala" id="name_kala" value="'.$name_kala.'"/></td>
		<td align="left">واحد کالا : &nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="sharh_vahedkala" id="sharh_vahedkala" value="'.$sharh_vahedkala.'"/></td>
	   </tr>
	   <tr>
	    <td align="left"> نوع : &nbsp; </td><td align="right">'.static_listbox("noe_oftokasry",$noe_oftokasry,"tadilArr",1,"class='text4'").'</td>
	    <td align="left"> مقدار : &nbsp; </td><td align="right"><input class="textboxme2" type="text" name="meghdar_oftokasry" value="'.$meghdar_oftokasry.'" onkeypress="return isNumber(event)"/></td>
	    <td align="left">توضيحات نامه : &nbsp; </td><td colspan="3" align="right"><input class="textboxme" type="text" name="tozihat_nameh" value="'.$tozihat_nameh.'"/></td>	    
	   </tr>
	   <tr>
        <td colspan="8" align="center" class="title">
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
 <!-- پايان فوتر-->	
</table>
</div>';
/************اجازه براي ذخيره اطلاعات************/ 
function isPermitSave($sh_nameh,$date_nameh,$n_oft,$code_baste,$code_zir_a,$c_kala,$c_keshvar,$c_tolid,$sal_t_sh,$mah_t_sh,$rouz_t_sh,$c_karton,$ted_k_m,$m_nakha_m,$m_kha_m,$gl_c_o,$gl_c_s,$gl_year)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($sh_nameh and $date_nameh and $n_oft and $code_zir_a and $c_kala and $c_keshvar and $c_tolid and $sal_t_sh and $mah_t_sh and $rouz_t_sh))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($code_baste!=3)and(!($c_karton)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($c_kala))//موجود نبودن کد کالا در جدول کد کالا
 {
   $q12="SELECT code_kala FROM kala WHERE code_kala='$c_kala'";
   $res12=mysql_query($q12);
   if(mysql_num_rows($res12)==0){
     echo"<script>alert('این کد کالا در جدول کالا ثبت نشده است!')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }  
 else $flag=true;
 if((checkdatejalali($date_nameh)==false))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(!empty($sh_nameh))//تکراری نبودن شماره نامه در هر استان
 { 
    $q8="SELECT shomare_nameh FROM mojavez WHERE shomare_nameh='$sh_nameh' AND code_ostan=$gl_c_o";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين شماره نامه قبلا در این استان ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($sh_nameh,$date_nameh,$gl_c_o,$gl_c_a,$gl_year,$this_id)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($sh_nameh and $date_nameh))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((checkdatejalali($date_nameh)==false))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(!empty($sh_nameh))//تکراری نبودن شماره نامه در هر استان
 { 
    $q8="SELECT shomare_nameh FROM mojavez WHERE shomare_nameh='$sh_nameh' AND code_ostan=$gl_c_o AND id_mojavez!=$this_id";
	$res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين شماره نامه قبلا در این استان ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
return $flag;
}/**********اجازه براي تکمیل********/
function isPermitTakmil($chktaeed,$chktaeed_final,$sh_mojavez,$date_mojavez,$gl_c_o,$gl_c_a,$gl_year,$this_id)
{
 if($chktaeed_final==1)//در تایید اولیه اطلاعات مجوز لازم نیست
 {
   $flag=false;
   if(!($sh_mojavez and $date_mojavez))//پر بودن فيلدها
   {
     $flag=false;
     echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
     return $flag;
   } 
   else $flag=true;
   if((checkdatejalali($date_mojavez)==false))//صحت فرمت تاریخ
   {
  	$flag=false;
  	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
      return $flag;
   }
   else $flag=true;
   if(!empty($sh_mojavez))//تکراری نبودن شماره نامه در هر استان
   { 
      $q8="SELECT shomare_mojavez FROM mojavez WHERE shomare_mojavez='$sh_mojavez' AND code_ostan=$gl_c_o AND id_mojavez!=$this_id";
  	$res8=mysql_query($q8);
      if(mysql_num_rows($res8)>0){
      echo"<script>alert('اين شماره مجوز قبلا در این استان ثبت شده است !')</script>";
      $flag=false;
      return $flag;
     }
    else $flag=true;
   }
   else $flag=true;
 }
 else $flag=true;   
return $flag;
}
/*************INSERT  BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 $shomare_nameh = trim(preg_replace('/\s+/', ' ', $shomare_nameh));
 IF($code_kala==50)$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane"];
 ELSE $tedad_shane_oftokasry=0;
 if(isPermitSave($shomare_nameh,$tarikh_nameh,$noe_oftokasry,$code_bastebandy,$code_ziranbar,$code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$tedad_karton_oftokasry,$meghdar_nakhales_oftokasry,$meghdar_khales_oftokasry,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 { 
  $Mode='';
  $insert_q=("INSERT INTO $TableName
            (code_ostan,code_anbar,year,shomare_nameh,tarikh_nameh,
			 id_mojody,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,
			 code_karton,vazn_karton_this,noe_oftokasry,tedad_oftokasry,sum_karton_oftokasry,meghdar_nakhales_oftokasry,meghdar_khales_oftokasry,tedad_shane_oftokasry,tozihat_nameh,deleted)
             VALUES
			('$mt_gl_code_ostan','$mt_gl_code_anbar','$mtActiveYear',TRIM('$shomare_nameh'),'$tarikh_nameh',
			 '$id_mojody','$code_ziranbar','$code_kala','$code_keshvar','$code_tolidkonande','$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi',
			 '$code_karton','$vazn_karton_this','$noe_oftokasry','$tedad_oftokasry','$sum_karton_oftokasry','$meghdar_nakhales_oftokasry','$meghdar_khales_oftokasry','$tedad_shane_oftokasry',TRIM('$tozihat_nameh'),0)");
  echo $insert_q;
  $insert_res=mysql_query($insert_q);
   if($insert_res)
   {
    /*لاگ*/
    $max_id=$db->get_from_where("MAX(id_mojavez)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
	$log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	if($log_i)echo '<script>window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
   }
   else $message='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>'; 
 } 
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 $shomare_nameh = trim(preg_replace('/\s+/', ' ', $shomare_nameh));
 IF($code_kala==50)$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane"];
 ELSE $tedad_shane_oftokasry=0;
 if(isPermitEdit($shomare_nameh,$tarikh_nameh,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$id_mojavez_))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET shomare_nameh=TRIM('$shomare_nameh'),tarikh_nameh='$tarikh_nameh',
            tedad_oftokasry='$tedad_oftokasry',sum_karton_oftokasry='$sum_karton_oftokasry',meghdar_nakhales_oftokasry='$meghdar_nakhales_oftokasry',meghdar_khales_oftokasry='$meghdar_khales_oftokasry',tedad_shane_oftokasry='$tedad_shane_oftokasry',tozihat_nameh=TRIM('$tozihat_nameh') WHERE id_mojavez='$id_mojavez_';");         
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  { $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_mojavez_tadil_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  /*کوئری لاگ*/ 
	echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';      
 }
}
/************EDIT BUTTON********/// تکمیل اطلاعات
if (isset($Takmil_x))
{
 if ($chktaeed=='on') $chktaeed=1; else $chktaeed=0;
 if ($chktaeed_final=='on') $chktaeed_final=1; else $chktaeed_final=0;
 $shomare_mojavez = trim(preg_replace('/\s+/', ' ', $shomare_mojavez));
 if(isPermitTakmil($chktaeed,$chktaeed_final,$shomare_mojavez,$tarikh_mojavez,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$id_mojavez_))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET shomare_mojavez=TRIM('$shomare_mojavez'),tarikh_mojavez='$tarikh_mojavez',chktaeed='$chktaeed',chktaeed_final='$chktaeed_final',tozihat_takmili=TRIM('$tozihat_takmili') WHERE id_mojavez='$id_mojavez_';");         
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  { $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_mojavez_','تکمیل فرم کمیسیون',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  /*کوئری لاگ*/ 
	echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';      
 }
}
///////////////////////////////////////////////////////////////////
echo'
<br/><br/>
'.$message.'
</form>
</body>
</html>';	
?>