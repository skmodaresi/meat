<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="tarh_o_barname_gh.php";
$TableName="tarh_o_barname";
$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;
if (right(457)) $right_ins=1;
if (right(458)) $right_edt=1;
if (right(459)) $right_del=1;  
if (right(460)) $right_prt=1;

$titr='درخواست طرح و برنامه';
$q3="SELECT * From gharardad_kharid WHERE id_gharardad='$id_gharardad'";
$res3=$db->query($q3);
$row3=$db->fetch_assoc($res3);
$shomare_gharardad=$row3['shomare_gharardad'];
$titr.="(درخواست تأمین اعتبار با شناسه $id_tamin) (شماره قرارداد $shomare_gharardad)";

$exist_elhaghie_date=$db->get_from_where("COUNT(*)","meat.elhaghie_kharid","id_gharardad='".$id_gharardad."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ");
if($exist_elhaghie_date>0)//اگر الحاقیه دارد
{
  $tarikh_etmam_elhaghie=$db->get_from_where("tarikh_etmam_elhaghie","meat.elhaghie_kharid","id_gharardad='$id_gharardad' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ORDER BY tarikh_elhaghie,id_elhaghie DESC"); 
  $tarikh_etmam=$tarikh_etmam_elhaghie;
}
else//اگر الحاقیه ندارد
{
 $tarikh_etmam=$row3['tarikh_etmam'];
}
$mablagh_tamin=$db->get_from_where("mablagh_tamin","tamin_etebar","id_tamin='$id_tamin'");
$mablagh_tarh_ghabl=$db->get_from_where("mablagh_tarh","$TableName","id_tamin='$id_tamin' AND deleted=0");
$mablagh_tamin_placeholder=$mablagh_tamin-$mablagh_tarh_ghabl;
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
  $_SESSION['mt_search_tarh']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($shomare_tarh)    $temp.=" and shomare_tarh LIKE '%$shomare_tarh%'";
 if($tarikh_tarh)    $temp.=" and tarikh_tarh LIKE '$tarikh_tarh'";
 if($mablagh_tarh)    $temp.=" and mablagh_tarh LIKE '%$mablagh_tarh%'";
 if($temp) {$PageNo_detail=1;$_SESSION['mt_search_tarh']=$temp;} else $_SESSION['mt_search_tarh']="";
}
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;$count=1;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_tarh']." AND id_gharardad=$id_gharardad AND whatform=1 AND deleted=0");
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
/******************** Insert- Edit- Delete ************/
/************DELETE BUTTON********/// حذف اطلاعات
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q = "UPDATE $TableName SET deleted=1 WHERE id_tarh='$id_tarh_'";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if($del_res)$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_tarh_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_tarh.focus();">
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
if(!isset($order))    $order='id_tarh DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sorttarikhshoro)) $sorttarikhshoro='1';
if(!isset($show_img)) $show_img='';
	echo '<td width="10%">شناسه</td>';
	if($sortcode=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی شماره" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&order=shomare_tarh ASC&sortcode=2&show_img=1\'"/> شماره نامه';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی شماره" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&order=shomare_tarh DESC&sortcode=1&show_img=1\'"/> شماره نامه';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی تاریخ " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&order=tarikh_shoro_etebar ASC&sorttarikh=2&show_img=2\'"/> تاریخ نامه '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی تاریخ" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&order=tarikh_shoro_etebar DESC&sorttarikh=1&show_img=2\'"/> تاریخ نامه '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	 echo'
	 <td width="20%" >مبلغ طرح و برنامه</td>';
	 if((($right_del)AND($today<=$tarikh_etmam))OR(($right_del)AND($role_id==10))OR(SuperUser())) echo'<td width="20%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="20%">دستورات</td>';
	 echo'
	</tr>';
	$i=0;
    $q1="SELECT * From $TableName T WHERE 1=1 ".$_SESSION['mt_search_tarh']." AND id_tamin=$id_tamin AND whatform=1  AND deleted=0 order by $order $Limit";
	$allGheymat = $db->query($q1);
    while($row1=$db->fetch_assoc($allGheymat))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_tarh_='.$row1['id_tarh'].'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	  echo'
	  
	  <td '.$edtClick.'>'.$row1['id_tarh'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_tarh'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_tarh'].'</td>
	  <td '.$edtClick.'>'.virgul($row1['mablagh_tarh']).'</td>';
	  if((($right_del)AND($today<=$tarikh_etmam))OR(($right_del)AND($role_id==10))OR(SuperUser()))
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_tarh_='.$row1['id_tarh'].'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\',\'برای حذف درخواست طرح و برنامه با شماره نامه '.$row1['shomare_tarh'].' \')" /></td>';
	  }
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
	
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
	  <td>&nbsp;</td>';
	  if((($right_del)AND($today<=$tarikh_etmam))OR(($right_del)AND($role_id==10))OR(SuperUser())) echo'<td>&nbsp;</td>';
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
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
	 if((($right_ins)AND($today<=$tarikh_etmam))OR(($right_ins)AND($role_id==10))OR(SuperUser()))
	 {
	  echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	  <td width="10px">&nbsp;</td>';}
	 echo'
	 <td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'tamin_etebar_gh.php?PageNo='.$PageNo.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-back"  title="بازگشت"  ><a href="#"></a></div></td> 
	 <td width="20px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail=1&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$PrevPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$NextPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$MaxPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_tarh']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'&open_filter=1\'"></td>';	 
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
	   <tr class="title"><td colspan="6" align="center"> ایجاد '.$titr.'</td></tr>	   
	   <tr><td>&nbsp;</td></tr>
	   <tr>
		<td align="left"><span class="star">*</span> شماره نامه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_tarh" value="'.$shomare_tarh.'"/></td>
        <td align="left""><span class="star">*</span> تاریخ نامه :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_tarh" value="'.$tarikh_tarh.'"/></td>
       </tr>
	  <tr>
	   <td align="left">مبلغ طرح و برنامه :&nbsp; </td>
	   <td align="right"><input type="text" class="textboxme2" name="mablagh_tarh" placeholder="'.$mablagh_tamin_placeholder.'"  value="'.$mablagh_tarh.'"   onkeypress="return isNumber(event)"/> (ریال) </td>
	  </tr>
	  <tr>
        <td colspan="8" align="center" class="title">
		<input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
        <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if($Mode=="Edit")  //Edit Mode
    {
	 $q3="SELECT * From $TableName T WHERE id_tarh=$id_tarh_";
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
	echo'
	<tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات شماره نامه  '.$row3['shomare_tarh'].'</td></tr>        
	   <tr><td>&nbsp;</td></tr>
	   <tr>
		<td align="left"><span class="star">*</span> شماره نامه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_tarh" value="'.$row3['shomare_tarh'].'"/></td>
        <td align="left""><span class="star">*</span> تاریخ نامه :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_tarh" value="'.$row3['tarikh_tarh'].'"/></td>
       </tr>
	  <tr>
	   <td align="left">مبلغ طرح و برنامه:&nbsp; </td>
	   <td align="right"><input type="text" class="textboxme2" name="mablagh_tarh" value="'.$row3['mablagh_tarh'].'" onkeypress="return isNumber(event)"/> (ریال) </td>
	  </tr>
	  <tr>'; 
	  	 if((($right_edt)AND($today<=$tarikh_etmam))OR(($right_edt)AND($role_id==10))OR(SuperUser()))
		 {echo'
		  <td colspan="8" align="center" class="title">
		   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
           <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'">
		  </td>';
		 }
         else echo'<td  colspan="8" align="center" class="title"><div onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"></a></div></td> ';
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
       <tr class="title"><td colspan="10" align="center">جستجوی فرم</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
		<td align="left" > شماره نامه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_tarh" value="'.$shomare_tarh.'"/></td>
        <td align="left"> تاریخ نامه :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_tarh" value="'.$tarikh_tarh.'"/></td>
       </tr>   
	   <tr>
	    <td align="left">مبلغ طرح و برنامه:&nbsp; </td>
	    <td align="right"><input type="text" class="textboxme2" name="mablagh_tarh" value="'.$mablagh_tarh.'" onkeypress="return isNumber(event)"/> (ریال) </td>
	   </tr>
	   <tr>
        <td colspan="10" align="center" class="title">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\'">
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
function isPermitSave($gharardad,$shomare,$tarikh,$mablagh_tarh,$mablagh_tamin)
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
 
 if($mablagh_tarh!=$mablagh_tamin)
 {
  $flag=true;
  echo"<script>window.alert('دقت کنید مبلغ طرح و برنامه وارد شده با مبلغ تأمین اعتبار مغایرت دارد');</script>";
  return $flag; 
 }
 
return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($id_gharardad,$shomare_tarh,$tarikh_tarh,$mablagh_tarh,$mablagh_tamin))
 {
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $insert_res=true;$log_i=true;$res_update_gharardad=true;
   $insert_q=("INSERT INTO $TableName(id_tamin,id_gharardad,shomare_tarh,tarikh_tarh,mablagh_tarh,whatform,deleted)
               VALUES('$id_tamin','$id_gharardad','$shomare_tarh','$tarikh_tarh','$mablagh_tarh','1',0)");
   $insert_res=mysql_query($insert_q);
   $max_id=$db->get_from_where("Max(id_tarh)","$TableName","");  
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   if(($insert_res and $log_i and $res_update_gharardad))
    {
      mysql_query("COMMIT");
	  echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\' </script>';
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
function isPermitEdit($gharardad,$shomare,$tarikh,$mablagh_tarh,$mablagh_tamin,$this_id)
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
 if($mablagh_tarh!=$mablagh_tamin)
 {
  $flag=true;
  echo"<script>window.alert('دقت کنید مبلغ طرح و برنامه وارد شده با مبلغ تأمین اعتبار مغایرت دارد');</script>";
  return $flag; 
 }
 
return $flag;
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($id_gharardad,$shomare_tarh,$tarikh_tarh,$id_tarh_))
 {
  $Mode='';	
  $edit_q=("UPDATE $TableName SET shomare_tarh='$shomare_tarh',tarikh_tarh='$tarikh_tarh',
            mablagh_tarh='$mablagh_tarh' WHERE id_tarh='$id_tarh_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_tarh_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\' </script>';
  }
  else if(mysql_affected_rows()==0) echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_tamin='.$id_tamin.'&id_gharardad='.$id_gharardad.'&id_sahmiebandy='.$id_sahmiebandy.'&id_eblagh='.$id_eblagh.'\' </script>';
  else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود امده است ! *</span>';                
  } 
}
/********************END********************/	
echo'
'.$message.'
</form>
</body>
</html>';	
?>