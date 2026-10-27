<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="pardakhti_list.php";
$TableName="pardakht_gharardad";
$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;
if (right(447)) $right_ins=1;
if (right(448)) $right_edt=1;
if (right(449)) $right_del=1;  
if (right(449)) $right_prt=1;
$titr='درخواست پرداخت وجه قرارداد';
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$condition_ostan='';}
else {$condition_ostan=' AND gh_kh.code_ostan='.$mt_gl_code_ostan.'';}
// $q3="SELECT g_kh.*,e_kh.code_group_kala_top From meat.gharardad_kharid g_kh
	    // INNER JOIN meat.dastorolamal_kharid d_kh ON g_kh.id_dastorolamal=d_kh.id_dastorolamal
	    // INNER JOIN meat.eblagh_kharid e_kh ON d_kh.id_eblagh=e_kh.id_eblagh
		// INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=e_kh.code_group_kala_top
 // WHERE g_kh.id_gharardad='$id_gharardad' AND g_kh.deleted=0";

// $res3=$db->query($q3);
// $row3=$db->fetch_assoc($res3);
// $shomare_gharardad=$row3['shomare_gharardad'];
// $titr.=" (شماره قرارداد $shomare_gharardad)";
// $exist_elhaghie=$db->get_from_where("COUNT(*)","meat.elhaghie_kharid","id_gharardad='".$id_gharardad."' AND gheymat_elhaghie>0 AND deleted=0 ");
// if($exist_elhaghie>0)//اگر الحاقیه دارد
// {
  // $gheymat_elhaghie=$db->get_from_where("gheymat_elhaghie","meat.elhaghie_kharid","id_gharardad='$id_gharardad' AND gheymat_elhaghie>0 AND deleted=0 ORDER BY tarikh_elhaghie,id_elhaghie DESC"); 
  // $akharin_gheymat=$gheymat_elhaghie;
// }
// else//اگر الحاقیه ندارد
// {
  // $akharin_gheymat=$row3['gheymat_har_kilo'];
  // IF($row3['gheymat_har_kilo']=='0') { $akharin_gheymat=$db->get_from_where("gheymat_kharid","meat.gheymat_kharid","id_dastorolamal='".$row3['id_dastorolamal']."' AND deleted=0 ");}
// }
// //محاسبه مانده مقدار جهت پرداخت
// $meghdar_gharardad=$row3['meghdar_gharardad'];	
// $mazad_gharardad=$row3['mazad_gharardad'];	
// $meghdar_gharardad_nahayi=$row3['meghdar_gharardad']+$row3['mazad_gharardad'];
// $sum_meghdar_pardakhti=$db->get_from_where("SUM(meghdar)","meat.$TableName","id_gharardad='$id_gharardad' AND deleted=0 AND pardakht_type=1");

// $mande_meghdar=$meghdar_gharardad_nahayi-$sum_meghdar_pardakhti;
// $mande_meghdar=round($mande_meghdar,3);
// //محاسبه مانده مبلغ جهت پرداخت
// //$mablagh_kol=$meghdar_gharardad_nahayi*$akharin_gheymat;
// $mablagh_kol_array=compute_ghardad_payment($id_gharardad,$db); 
// $mablagh_kol=($mablagh_kol_array[1] +($row3['meghdar_gharardad_avaliye']+$row3['mazad_gharardad']-$mablagh_kol_array[0])*$akharin_gheymat);
// $sum_mablagh_pardakht=$db->get_from_where("SUM(mablagh_pardakht)","meat.$TableName","id_gharardad='$id_gharardad' AND deleted=0 ");
// $mande_pardakht=$mablagh_kol-$sum_mablagh_pardakht;
// //قوطی-کنسرو مرغ
// if($row3['code_group_kala_top']==6) $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row3['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row3['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
// //کارتن یا لاشه
// else $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row3['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND  r_k_d.code_ostan=".$row3['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0"); 
// $sum_tahvily_gharardad=round($sum_tahvily_gharardad,3);
// //مانده قرارداد
// $mande_tahvily_gharardad=$row3['meghdar_gharardad']+$row3['mazad_gharardad']-round($sum_tahvily_gharardad,3);
// $mande_tahvily_gharardad=round($mande_tahvily_gharardad,3);	 

// //$mablagh_pardakht=$mablagh_kol_array[1]-$sum_mablagh_pardakht;
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
	
	<!--
		<!--تغییر براساس تحویل-->
        $("[name=pardakht_type]").bind("change", function (){
        if($(this).val() == 1)<!--تحویل جاری --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".vaznshow").show();
	        $("#loading").fadeOut("fast");	
        }
        else<!--مابه التفاوت --> 
		{
		 	$("#loading").fadeIn("fast");
	        $(".vaznshow").hide();
	        $("#loading").fadeOut("fast");	
		}
      });
	  -->
});
function pardakhty()<!--محاسبه مبلغ پرداختی-->
{
 var natije_mablagh;
 natije_mablagh=((document.myform.gheymat_pardakht.value)*(document.myform.meghdar.value)).toFixed();
 if(natije_mablagh<0) natije_mablagh=0;
 document.myform.mablagh_pardakht.value=natije_mablagh;
}
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_pardakhti_li']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($shomare_nameh)    $temp.=" and shomare_nameh LIKE '%$shomare_nameh%'";
 if($tarikh_nameh)     $temp.=" and tarikh_nameh LIKE '$tarikh_nameh'";
 if($pardakht_type)     $temp.=" and pardakht_type='$pardakht_type'";
 if($shomare_gharardad) $temp.=" and shomare_gharardad LIKE '%$shomare_gharardad%'";
 if($code_ostan) $temp.=" and ostan.code_ostan='$code_ostan'";
 if($meghdar)          $temp.=" and meghdar LIKE '%$meghdar%'";
 if($mablagh_pardakht) $temp.=" and mablagh_pardakht LIKE '%$mablagh_pardakht%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_pardakhti_li']=$temp;} else $_SESSION['mt_search_pardakhti_li']="";
}
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;$count=1;
$res = $db->query("SELECT COUNT(*) FROM $TableName T 
                   INNER JOIN meat.gharardad_kharid gh_kh USING(id_gharardad)
	               INNER JOIN meat.sahmiebandy_kharid s_kh ON gh_kh.id_sahmiebandy=s_kh.id_sahmiebandy
	               INNER JOIN meat.eblagh_kharid e_kh ON s_kh.id_eblagh=e_kh.id_eblagh
		           INNER JOIN meat.ostan ON gh_kh.code_ostan=ostan.code_ostan
		           INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=e_kh.code_group_kala_top
                   where 1=1 ".$_SESSION['mt_search_pardakhti_li']." AND T.deleted=0");
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
$radif=($PrevPage*$RowPerPage)+1;//محاسبه ردیف
if ($radif<0) $radif=1;
/******************** Insert- Edit- Delete ************/
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q = "UPDATE $TableName SET deleted=1 WHERE id_pardakht='$id_pardakht_'";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_pardakht_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_nameh.focus();">
<form method="post" name="myform" onkeydown="enter();">
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
if(!isset($order))    $order='id_pardakht DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sorttarikhshoro)) $sorttarikhshoro='1';
if(!isset($show_img)) $show_img='';
	echo '<td width="4%">شناسه</td>';
	if($sortcode=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی شماره" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare_nameh ASC&sortcode=2&show_img=1\'"/> شماره نامه';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی شماره" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare_nameh DESC&sortcode=1&show_img=1\'"/> شماره نامه';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی تاریخ " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_shoro_etebar ASC&sorttarikh=2&show_img=2\'"/> تاریخ نامه '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی تاریخ" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_shoro_etebar DESC&sorttarikh=1&show_img=2\'"/> تاریخ نامه '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	 echo'
	 <td width="8%" >نوع پرداخت</td>
	 <td width="10%" >شماره قرارداد</td>
	 <td width="8%" >استان</td>
	 <td width="8%" >گروه کالا</td>
	 <td width="10%" >شماره ابلاغ</td>
	 <td width="10%" >مقدار تحویلی جهت پرداخت</td>
	 <td width="8%" >قیمت پرداخت</td>
	 <td width="10%" >مبلغ پرداختی</td>';
	 if((($right_del)AND($role_id==10))OR(SuperUser())) echo'<td width="4%">حذف</td>';
	 echo'
	</tr>';
	$i=0;
	$jame_meghdar_tahviljari=0;
    $jame_mablagh_tahviljari=0;
    $jame_meghdar_mabetafavot=0;
    $jame_mablagh_mabetafavot=0;
    $q1="SELECT T.*,shomare_gharardad,shomare_eblagh,name_ostan,name_group_kala_top,ostan.code_ostan From meat.$TableName T
	     INNER JOIN meat.gharardad_kharid gh_kh USING(id_gharardad)
	     INNER JOIN meat.sahmiebandy_kharid s_kh ON gh_kh.id_sahmiebandy=s_kh.id_sahmiebandy
	     INNER JOIN meat.eblagh_kharid e_kh ON s_kh.id_eblagh=e_kh.id_eblagh
		 INNER JOIN meat.ostan ON gh_kh.code_ostan=ostan.code_ostan
		 INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=e_kh.code_group_kala_top
		 WHERE 1=1 ".$_SESSION['mt_search_pardakhti_li']." $condition_ostan AND T.deleted=0 order by $order $Limit";
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_pardakht_='.$row1['id_pardakht'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	  echo'
	  
	  <td '.$edtClick.'>'.$row1['id_pardakht'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_nameh'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_nameh'].'</td>
	  <td '.$edtClick.'>'.$pardakhtGrArr[$row1['pardakht_type']].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_gharardad'].'</td>
	  <td '.$edtClick.'>'.$row1['name_ostan'].'</td>
	  <td '.$edtClick.'>'.$row1['name_group_kala_top'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_eblagh'].'</td>
	  <td '.$edtClick.'>'.$row1['meghdar'].'</td>
	  <td '.$edtClick.'>'.virgul($row1['gheymat_pardakht']).'</td>
	  <td '.$edtClick.'>'.virgul($row1['mablagh_pardakht']).'</td>';
	  if((($right_del)AND($role_id==10))OR(SuperUser()))
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_pardakht_='.$row1['id_pardakht'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف پرداختی با شماره نامه '.$row1['shomare_nameh'].' \')" /></td>';
	  }
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
	 echo '
	 </tr>';
     IF($row1['pardakht_type']==1)
	 {
		 $jame_meghdar_tahviljari+=$row1['meghdar'];
		 $jame_mablagh_tahviljari+=$row1['mablagh_pardakht'];
     }
	 ELSE IF($row1['pardakht_type']==2)
	 {
		 $jame_meghdar_mabetafavot+=$row1['meghdar'];
		 $jame_mablagh_mabetafavot+=$row1['mablagh_pardakht'];
	 }
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
	  if((($right_del)AND($role_id==10))OR(SuperUser())) echo'<td>&nbsp;</td>';
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
     echo'
	 </tr>';
	}
	echo'
	<tr class="table-title">
     <td colspan="8">مجموع (نوع پرداخت : بابت تحویل جاری کالا)</td>
	  <td>'.round($jame_meghdar_tahviljari,3).'</td>
	  <td>-</td>
	  <td>'.virgul($jame_mablagh_tahviljari).'</td>
	  <td>-</td>
    </tr>
	<tr class="table-title">
     <td colspan="8">مجموع (نوع پرداخت : مابه التفاوت)</td>
	  <td>'.round($jame_meghdar_mabetafavot,3).'</td>
	  <td>-</td>
	  <td>'.virgul($jame_mablagh_mabetafavot).'</td>
	  <td>-</td>
    </tr>';
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
	 <td width="24"><div onClick="window.open(\'print_pardakhti_list.php\',\'\',\'\')" id="printer" title="چاپ"><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>';
	 if($right_ins)
	 {
	  echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	  <td width="10px">&nbsp;</td>';}
	 echo'
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
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?&PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_pardakhti_li']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
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
	   <tr class="title"><td colspan="10" align="center"> ایجاد '.$titr.'</td></tr>	   
	   <tr><td>&nbsp;</td></tr>
	   <tr>
		<td align="left"><span class="star">*</span> شماره نامه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_nameh" value="'.$shomare_nameh.'"/></td>
        <td align="left""><span class="star">*</span> تاریخ نامه :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_nameh" value="'.$tarikh_nameh.'"/></td>
       	<td align="left"><span class="star">*</span> نوع پرداخت : &nbsp;</td><td align="right">'.static_listbox("pardakht_type",$pardakht_type,"pardakhtGrArr",1,"class='text4'").'</td>
	    <td colspan="2">&nbsp;</td>
	   </tr>
	   <tr>
	    <td align="left"><span class="star">*</span> شماره قرارداد :&nbsp; </td>
		<td align="right">
		 <input type="text" class="textboxme2" name="shomare_gharardad" readonly value="'.$shomare_gharardad.'"/>
		 <input type="hidden" class="textboxme2" name="id_gharardad" value="'.$id_gharardad.'" />
	      <img border="0" src="images/help.png" onClick="popupwindow(\'help_gharardad.php?parentFileName='.$FileName.'\',\'\',800,600)" title="جدول قراردادها" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
		</td>
	   </tr>
	   <tr>
		<td align="left" > آخرین قیمت : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="akharin_gheymat" value="'.$akharin_gheymat.'"  /> (ریال) </td>
		<td align="left" > مقدار قرارداد : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="meghdar_gharardad" value="'.$meghdar_gharardad.'" /> (کیلوگرم) </td>
	    <td align="left" > مقدار الحاقیه : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="mazad_gharardad" value="'.$mazad_gharardad.'" /> (کیلوگرم) </td>
	   </tr>
       <tr>
	    <td colspan="2">&nbsp;</td>	   
		<td align="left" > مقدار قرارداد والحاقیه : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="meghdar_gharardad_nahayi" value="'.$meghdar_gharardad_nahayi.'" /> (کیلوگرم) </td>
		<td align="left" > مبلغ کل قرارداد : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="mablagh_kol" value="'.($mablagh_kol).'" /> (ریال) </td>
	   </tr>
	   <tr>
	    <td align="left" > مقدار تحویلی از قرارداد(رسیدهای ثبت شده) : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="sum_tahvily_gharardad" value="'.$sum_tahvily_gharardad.'" /> (کیلوگرم) </td>
        <td align="left" > مانده از مقدار قرارداد جهت پرداخت : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="mande_meghdar" value="'.$mande_meghdar.'" /> (کیلوگرم) </td>
		<td align="left" > مانده از مبلغ پرداختی : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="mande_pardakht" value="'.($mande_pardakht).'" /> (ریال) </td>
	   </tr>
	   <tr >
        <td align="left" > مقدار مانده از قرارداد (رسید های ثبت نشده) : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="mande_tahvily_gharardad" value="'.$mande_tahvily_gharardad.'" /> (کیلوگرم) </td>
		<td align="left" ><span class="star">*</span> مقدار تحویلی جهت پرداخت : &nbsp;</td>
		<td align="right" ><input type="text" class="textboxme2" name="meghdar" value="'.$meghdar.'" onblur="return pardakhty()"  onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم) </td>';
		// <td align="left" class="vaznshow" style="display:none;"><span class="star">*</span> مقدار تحویلی جهت پرداخت : &nbsp;</td>
		// <td align="right" class="vaznshow" style="display:none;"><input type="text" class="textboxme2" name="meghdar" value="'.$meghdar.'" onblur="return pardakhty()"  onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم) </td>';

		echo'
		<td align="left" > قیمت پرداختی : &nbsp;</td>
		<td align="right" ><input type="text"  class="textboxme2" name="gheymat_pardakht" value="'.$gheymat_pardakht.'" onblur="return pardakhty()"  /> (ریال) </td>
		
      </tr>
	  <tr>
	  	<td align="left">توضیحات :&nbsp; </td>
		<td align="right" colspan="3"><input type="text" class="textboxme" name="tozihat" value="'.$tozihat.'"/></td>
	  	<td align="left"><span class="star">*</span> مبلغ پرداختی :&nbsp; </td>
	    <td align="right"><input type="text" class="textboxme2" name="mablagh_pardakht" value="'.$mablagh_pardakht.'"  onkeypress="return isNumber(event)"/> (ریال) </td>
      </tr>  
	  <tr>
        <td colspan="8" align="center" class="title">
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
	 $q3="SELECT T.*,shomare_gharardad,tarikh_etmam,meghdar_gharardad,mazad_gharardad,meghdar_gharardad_avaliye From $TableName T INNER JOIN gharardad_kharid gh_kh USING(id_gharardad) 
	      WHERE id_pardakht=$id_pardakht_ AND gh_kh.deleted=0";
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
	 $exist_elhaghie_date=$db->get_from_where("COUNT(*)","meat.elhaghie_kharid","id_gharardad='".$row3['id_gharardad']."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ");
     if($exist_elhaghie_date>0)//اگر الحاقیه دارد
     {
      $tarikh_etmam_elhaghie=$db->get_from_where("tarikh_etmam_elhaghie","meat.elhaghie_kharid","id_gharardad='".$row3['id_gharardad']."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ORDER BY tarikh_elhaghie,id_elhaghie DESC"); 
      $tarikh_etmam=$tarikh_etmam_elhaghie;
     }
     else//اگر الحاقیه ندارد
     {
      $tarikh_etmam=$row3['tarikh_etmam'];
     }
     //محاسبه مانده مقدار جهت پرداخت
     $meghdar_gharardad=$row3['meghdar_gharardad'];	
     $mazad_gharardad=$row3['mazad_gharardad'];	
     $meghdar_gharardad_nahayi=$row3['meghdar_gharardad']+$row3['mazad_gharardad'];
     $sum_meghdar_pardakhti=$db->get_from_where("SUM(meghdar)","meat.$TableName","id_gharardad='".$row3['id_gharardad']."' AND deleted=0 AND pardakht_type=1");

     $mande_meghdar=$meghdar_gharardad_nahayi-$sum_meghdar_pardakhti;
     $mande_meghdar=round($mande_meghdar,3);
     //محاسبه مانده مبلغ جهت پرداخت
     //$mablagh_kol=$meghdar_gharardad_nahayi*$akharin_gheymat;
     $mablagh_kol_array=compute_ghardad_payment($row3['id_gharardad'],$db); 
     $mablagh_kol=($mablagh_kol_array[1] +($row3['meghdar_gharardad_avaliye']+$row3['mazad_gharardad']-$mablagh_kol_array[0])*$row3['akharin_gheymat']);
     $sum_mablagh_pardakht=$db->get_from_where("SUM(mablagh_pardakht)","meat.$TableName","id_gharardad='".$row3['id_gharardad']."' AND deleted=0 ");
     $mande_pardakht=$mablagh_kol-$sum_mablagh_pardakht;

	echo'
	<tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات شماره نامه  '.$row3['shomare_nameh'].'</td></tr>';
	   IF($today<=$tarikh_etmam)echo'<tr><td colspan="10">&nbsp;</td></tr>';
	   ELSE echo'<tr><td colspan="10">تاریخ اتمام قرارداد به پایان رسید است</td></tr>';
	   echo'
	   <tr>
		<td align="left"><span class="star">*</span> شماره نامه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_nameh" value="'.$row3['shomare_nameh'].'"/></td>
        <td align="left""><span class="star">*</span> تاریخ نامه :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_nameh" value="'.$row3['tarikh_nameh'].'"/></td>
        <td align="left"><span class="star">*</span> نوع پرداخت : &nbsp;</td><td align="right">'.static_listbox("pardakht_type",$row3['pardakht_type'],"pardakhtGrArr",1,"class='text4'").'</td>
	    <td colspan="2">&nbsp;</td>
	   </tr>
	   <tr>
		<td align="left" > آخرین قیمت : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="akharin_gheymat" value="'.$row3['akharin_gheymat'].'"  /> (ریال) </td>
		<td align="left" > مقدار قرارداد : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="meghdar_gharardad" value="'.$meghdar_gharardad.'" /> (کیلوگرم) </td>
	    <td align="left" > مقدار الحاقیه : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="mazad_gharardad" value="'.$mazad_gharardad.'" /> (کیلوگرم) </td>
	   </tr>
       <tr>
        <td align="left"> شماره قرارداد :&nbsp; </td>
		<td align="right">
		 <input type="text" class="textboxme2" name="shomare_gharardad" readonly value="'.$row3['shomare_gharardad'].'"/>
		</td>
		<td align="left" > مقدار قرارداد والحاقیه : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="meghdar_gharardad_nahayi" value="'.$meghdar_gharardad_nahayi.'" /> (کیلوگرم) </td>		
		<td align="left" > مبلغ کل قرارداد : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="mablagh_kol" value="'.virgul($mablagh_kol).'" /> (ریال) </td>
	   </tr>
	   <!--<tr>
        <td align="left" > مقدار تحویلی از قرارداد(رسیدهای ثبت شده) : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="sum_tahvily_gharardad" value="'.$sum_tahvily_gharardad.'" /> (کیلوگرم) </td>
		<td align="left" > مانده از مقدار قرارداد جهت پرداخت : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="mande_meghdar" value="'.$mande_meghdar.'" /> (کیلوگرم) </td>
		<td align="left" > مانده از مبلغ پرداختی : &nbsp;</td>
		<td align="right" ><input type="text" readonly class="textboxme2" name="mande_pardakht" value="'.virgul($mande_pardakht).'" /> (ریال) </td>
	   </tr>-->
	   <tr >
	     <!--<td align="left" > مقدار مانده از قرارداد (رسید های ثبت نشده) : &nbsp;</td>
		 <td align="right" ><input type="text" readonly class="textboxme2" name="mande_tahvily_gharardad" value="'.$mande_tahvily_gharardad.'" /> (کیلوگرم) </td>
		 -->
		 <td colspan="2"></td>
		 <td align="left">
		  <span class="star">*</span> مقدار تحویلی جهت پرداخت  : &nbsp;</td>
		  <td align="right">
		   <input type="text" readonly class="textboxme2" name="meghdar" value="'.$row3['meghdar'].'"  onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم) 
		 </td>
		 <td align="left" > قیمت پرداختی : &nbsp;</td>
		 <td align="right" ><input type="text" class="textboxme2" name="gheymat_pardakht" value="'.$row3['gheymat_pardakht'].'"  /> (ریال) </td>
		
       </tr>
	   <tr>
		<td align="left">توضیحات :&nbsp; </td>
		<td align="right" colspan="3"><input type="text" class="textboxme" name="tozihat" value="'.$row3['tozihat'].'"/></td>
       	<td align="left"><span class="star">*</span> مبلغ پرداختی :&nbsp; </td>
	    <td align="right"><input type="text" readonly class="textboxme2" name="mablagh_pardakht" value="'.$row3['mablagh_pardakht'].'"  onkeypress="return isNumber(event)"/> (ریال) </td>
	   </tr> 
	   <tr>';
	     //به غیر از سوپریوزر و کاربر ارشد خرید 	   
	   	 if((($right_edt)AND($today<=$tarikh_etmam))OR(($right_edt)AND($role_id==10))OR(SuperUser()))
		 {echo'
		  <td colspan="8" align="center" class="title">
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
	 <td width="100%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">جستجوی فرم</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
		<td align="left" > شماره نامه :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_nameh" value="'.$shomare_nameh.'"/></td>
        <td align="left"> تاریخ نامه :&nbsp;</td>
		<td align="right"><input class="textboxme2 datepicker6" type="text" maxlength="10" name="tarikh_nameh" value="'.$tarikh_nameh.'"/></td>
        <td align="left"> نوع پرداخت : &nbsp;</td><td align="right">'.static_listbox("pardakht_type",$pardakht_type,"pardakhtGrArr",1,"class='text4'").'</td>
	   </tr>   
	   <tr>
	   	<td align="left">شماره قرارداد :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_gharardad" value="'.$shomare_gharardad.'"/></td>
	    <td align="left">استان :&nbsp; </td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").' </td> 

		<td align="left"> مقدار تحویلی جهت پرداخت  : &nbsp;</td>
		<td align="right"><input type="text" class="textboxme2" name="meghdar" value="'.$meghdar.'"  onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم) </td>
	    <td align="left"> مبلغ پرداختی :&nbsp;</td>
	    <td align="right"><input type="text" class="textboxme2" name="mablagh_pardakht" onkeypress="return isNumber(event)"/> (ریال) </td>
	   </tr>
	   <tr>
        <td colspan="10" align="center" class="title">
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
function isPermitSave($gharardad,$shomare,$tarikh,$type,$meghdar,$sum_meghdar_pardakhti_new,$mande_meghdar,$mande_tahvily_gharardad,$mablagh,$sum_mablagh_pardakhti_new,$sum_mablagh_etebar)
{
 $flag=false;  
 //echo"<script>window.alert('$gharardad');</script>";
 if(!($gharardad and $shomare and $tarikh and $type and $mablagh))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($type==1)and(!$meghdar))
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
 if(!empty($shomare))//تکراری نبودن شماره مجوز
 { 
    $q7="SELECT shomare_nameh FROM pardakht_gharardad WHERE shomare_nameh='$shomare' AND id_gharardad='$gharardad' AND deleted=0 ";
    $res7=mysql_query($q7);
    if(mysql_num_rows($res7)>0){
    echo"<script>alert('اين شماره نامه قبلا ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
 if(($type==1)and($mande_meghdar<$meghdar))
 {
    $flag=false;
	echo"<script>window.alert('مقدار وارد شده از مقدار مانده از قرارداد بیشتر است!');</script>";
    return $flag; 
 }
 else $flag=true;
 if($sum_mablagh_etebar<$sum_mablagh_pardakhti_new)
 {
    $flag=false;
	echo"<script>window.alert('مجموع مبالغ پرداختی از مبلغ تأمین اعتبار بیشتر است!');</script>";
    return $flag; 
 }
 else $flag=true;
 // if($mande_tahvily_gharardad<$sum_meghdar_pardakhti_new)
 // {
    // $flag=false;
	// echo"<script>window.alert('مقدار وارد شده از مقدار مانده از قرارداد (رسیدهای ثبت نشده ) بیشتر است!');</script>";
    // return $flag; 
 // }
 // else $flag=true;  
return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
IF(isset($Insert_x))
{ 
 $sum_meghdar_pardakhti_new=$sum_meghdar_pardakhti+$meghdar;
 $sum_mablagh_pardakhti=$db->get_from_where("SUM(mablagh_pardakht)","meat.$TableName","id_gharardad='$id_gharardad' AND deleted=0");
 $sum_mablagh_pardakhti_new=$sum_mablagh_pardakhti+$mablagh_pardakht;
 $sum_mablagh_etebar=$db->get_from_where("SUM(mablagh_tamin)","meat.tamin_etebar","id_gharardad='$id_gharardad' AND deleted=0");

 //IF($pardakht_type==2)$meghdar=0;
 IF(isPermitSave($id_gharardad,$shomare_nameh,$tarikh_nameh,$pardakht_type,$meghdar,$sum_meghdar_pardakhti_new,$mande_meghdar,$mande_tahvily_gharardad,$mablagh_pardakht,$sum_mablagh_pardakhti_new,$sum_mablagh_etebar))
 {
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $insert_res=true;$log_i=true;$res_update_gharardad=true;
   $insert_q=("INSERT INTO $TableName(id_gharardad,shomare_nameh,tarikh_nameh,gheymat_pardakht,akharin_gheymat,meghdar,mablagh_pardakht,pardakht_type,deleted)
               VALUES('$id_gharardad','$shomare_nameh','$tarikh_nameh','$gheymat_pardakht','$akharin_gheymat','$meghdar','$mablagh_pardakht','$pardakht_type',0)");
   $insert_res=mysql_query($insert_q);
   $max_id=$db->get_from_where("Max(id_pardakht)","$TableName","");  
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   if(($insert_res and $log_i and $res_update_gharardad))
    {
      mysql_query("COMMIT");
	  echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
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
function isPermitEdit($shomare,$tarikh,$type,$meghdar,$mande_meghdar,$mande_tahvily_gharardad,$mablagh,$this_id)
{
 $flag=false;  
 if(!($shomare and $tarikh and $type and $mablagh))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($type==1)and(!$meghdar))
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
 if(!empty($shomare))//تکراری نبودن شماره مجوز
 { 
    $q7="SELECT shomare_nameh FROM pardakht_gharardad WHERE shomare_nameh='$shomare' AND id_gharardad='$gharardad' AND deleted=0 AND id_pardakht!='$this_id'";
    $res7=mysql_query($q7);
    if(mysql_num_rows($res7)>0){
    echo"<script>alert('اين شماره نامه قبلا ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
 // if($mande_meghdar<$meghdar)
 // {
    // $flag=false;
	// echo"<script>window.alert('مقدار وارد شده از مقدار مانده از قرارداد بیشتر است!');</script>";
    // return $flag; 
 // }
 // else $flag=true;
 // if($mande_tahvily_gharardad<$meghdar)
 // {
    // $flag=false;
	// echo"<script>window.alert('مقدار وارد شده از مقدار مانده از قرارداد (رسیدهای ثبت نشده ) بیشتر است!');</script>";
    // return $flag; 
 // }
 // else $flag=true; 
return $flag;
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 $sum_meghdar_pardakhti=$db->get_from_where("SUM(meghdar)","meat.$TableName","id_gharardad='$id_gharardad' AND deleted=0 AND pardakht_type=1 AND id_pardakht!='$id_pardakht_' ");
 //echo"<script>window.alert('$sum_meghdar_pardakhti');</script>";
 $mande_meghdar=$meghdar_gharardad_nahayi-($sum_meghdar_pardakhti+$meghdar);
 $mande_meghdar=round($mande_meghdar,3);
 //echo"<script>window.alert('$mande_meghdar');</script>"; 
 $mablagh_pardakht=$meghdar*$gheymat_pardakht;
 if(isPermitEdit($shomare_nameh,$tarikh_nameh,$pardakht_type,$meghdar,$mande_meghdar,$mande_tahvily_gharardad,$mablagh_pardakht,$id_pardakht_))
 {
  $Mode='';	
  $edit_q=("UPDATE $TableName SET shomare_nameh='$shomare_nameh',tarikh_nameh='$tarikh_nameh',
            meghdar='$meghdar',gheymat_pardakht='$gheymat_pardakht',mablagh_pardakht='$mablagh_pardakht',pardakht_type='$pardakht_type' WHERE id_pardakht='$id_pardakht_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_pardakht_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else if(mysql_affected_rows()==0) echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
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