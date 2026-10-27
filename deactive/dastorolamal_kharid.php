<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="dastorolamal_kharid.php";
$TableName="dastorolamal_kharid";
//$logtime=date('H:i:s');
//echo $id_eblagh;
$shomare_eblagh=$db->get_from_where("shomare_eblagh","eblagh_kharid","id_eblagh='$id_eblagh'");
$mahmule_type=$db->get_from_where("mahmule_type","eblagh_kharid","id_eblagh='$id_eblagh'");

$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;$right_gheymat_kharid=0;
if (right(412)) $right_ins=1;
if (right(413)) $right_edt=1;
if (right(414)) $right_del=1;  
if (right(415)) $right_prt=1;
if (right(416)) $right_gheymat_kharid=1;
$titr='دستورالعمل خرید';
$shomare_eblagh=$db->get_from_where("shomare_eblagh","eblagh_kharid","id_eblagh='$id_eblagh'");
$titr.=" (شماره ابلاغ $shomare_eblagh)";  

if(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $Condition_ostan='';
else $Condition_ostan=' AND T.code_ostan='.$_SESSION['mt_code_ostan'].'';
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
    $("#datepickerfrom").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true
	  });
	  $("#datepicker6").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true
    });
    <!--تغییر براساس قیمت گذاری-->
    $("[name=noe_gheymat]").bind("change", function (){
        if($(this).val() == 2)<!--استانی --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".ostanshow").show();
	        $("#loading").fadeOut("fast");	
        }
        else
		{
		 	$("#loading").fadeIn("fast");
	        $(".ostanshow").hide();
	        $("#loading").fadeOut("fast");	
		}
    });
});
function blinker() {
    $(".blink_me").fadeOut(500);
    $(".blink_me").fadeIn(500);
	}
setInterval(blinker, 2000);
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_dastorolamal_kharid']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($shomare_dastorolamal)    $temp.=" and shomare_dastorolamal LIKE '$shomare_dastorolamal'";
 if($tarikh_dastorolamal)    $temp.=" and tarikh_dastorolamal LIKE '$tarikh_dastorolamal'";
 if($tarikh_shoro_etebar) $temp.=" and tarikh_shoro_etebar LIKE '$tarikh_shoro_etebar'";
 if($name_saderkonande_dastorolamal) $temp.=" and name_saderkonande_dastorolamal LIKE '%$name_saderkonande_dastorolamal%'";
 if($code_ostan)         $temp.=" and code_ostan='$code_ostan'";
 if($activate)  $temp.=" and activate LIKE '$activate'";
 if($temp) {$PageNo_detail=1;$_SESSION['mt_search_dastorolamal_kharid']=$temp;} else $_SESSION['mt_search_dastorolamal_kharid']="";
}
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;$count=1;
$res = $db->query("SELECT COUNT(*) FROM $TableName T where 1=1 ".$_SESSION['mt_search_dastorolamal_kharid']." $Condition_ostan AND id_eblagh=$id_eblagh AND deleted=0");
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
if (isset($Delete_x))
{
 $Mode='';
 $del_q = "UPDATE $TableName SET deleted=1 WHERE id_dastorolamal=$id_dastorolamal_ AND
          ($id_dastorolamal_ NOT IN(SELECT id_dastorolamal FROM gheymat_kharid WHERE id_dastorolamal='$id_dastorolamal_' AND deleted=0))AND
		  ($id_dastorolamal_ NOT IN(SELECT id_dastorolamal FROM gharardad_kharid WHERE id_dastorolamal='$id_dastorolamal_' AND deleted=0))";
  $del_res = $db->query($del_q);
  if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها (قیمت خرید یا قرارداد خرید استفاده شده است ، شما مجاز به حذف آن نیستید)!')</script>";
  else if($del_res)
   $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_dastorolamal_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_dastorolamal.focus();">
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
if(!isset($order))    $order='id_dastorolamal DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sorttarikhshoro)) $sorttarikhshoro='1';
if(!isset($show_img)) $show_img='';
	echo '<td width="4%">شناسه</td>';
	if($sortcode=='1')
	{echo'<td width="13%" title="مرتب سازی صعودی شماره دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=shomare_dastorolamal ASC&sortcode=2&show_img=1\'"/> شماره دستورالعمل ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="13%" title="مرتب سازی نزولی شماره دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=shomare_dastorolamal DESC&sortcode=1&show_img=1\'"/> شماره دستورالعمل ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="13%" title="مرتب سازی صعودی تاریخ دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=tarikh_shoro_etebar ASC&sorttarikh=2&show_img=2\'"/> تاریخ دستورالعمل '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="13%" title="مرتب سازی نزولی تاریخ دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=tarikh_shoro_etebar DESC&sorttarikh=1&show_img=2\'"/> تاریخ دستورالعمل '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikhshoro=='1')
	{echo'<td width="13%" title="مرتب سازی صعودی تاریخ شروع اعتبار دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=tarikh_shoro_etebar ASC&sorttarikhshoro=2&show_img=2\'"/> تاریخ شروع اعتبار دستورالعمل '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikhshoro=='2')
	{echo'<td width="13%" title="مرتب سازی نزولی تاریخ شروع اعتبار دستورالعمل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&id_eblagh='.$id_eblagh.'&order=tarikh_shoro_etebar DESC&sorttarikhshoro=1&show_img=2\'"/> تاریخ شروع اعتبار دستورالعمل '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	 echo'
	 <td width="13%">نام صادر کننده</td>
	 <td width="6%">وضعیت</td>
	 <td width="8%">نوع قیمت گذاری</td>
	 <td width="8%">استان</td>
	 <td width="13%">قیمت خرید کالا</td>';
	 if(($right_del)and($Mode==NULL)) echo'<td width="10%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="10%">دستورات</td>';
	 echo'
	</tr>';
	$i=0;
    $q1="SELECT *,name_ostan,
	     (SELECT count(*) FROM gheymat_kharid gy_kh WHERE gy_kh.id_dastorolamal=T.id_dastorolamal AND deleted=0) gheymatcount
	     From $TableName T LEFT JOIN ostan USING(code_ostan)
		 WHERE 1=1 ".$_SESSION['mt_search_dastorolamal_kharid']." $Condition_ostan AND id_eblagh=$id_eblagh AND deleted=0 order by $order $Limit";
	$allGheymat = $db->query($q1);
    while($row1=$db->fetch_assoc($allGheymat))
	{
	 if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_dastorolamal_='.$row1['id_dastorolamal'].'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	  echo'
	  <td '.$edtClick.'>'.$row1['id_dastorolamal'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_dastorolamal'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_dastorolamal'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_shoro_etebar'].'</td>
	  <td '.$edtClick.'>'.$row1['name_saderkonande_dastorolamal'].'</td>
	  <td '.$edtClick.'>'.$activateArr[$row1['activate']].'</td>
	  <td '.$edtClick.'>'.$noegheymatArr[$row1['noe_gheymat']].'</td>
	  <td '.$edtClick.'>'.$row1['name_ostan'].'</td>
	  <td>';
	  if($right_gheymat_kharid) {echo'<input type="button" class="buttonme"  value="قیمت خرید کالا ['.$row1['gheymatcount'].']" onClick="window.location=\'gheymat_kharid.php?PageNo='.$PageNo.'&PageNo_detail='.$PageNo_detail.'&id_dastorolamal='.$row1['id_dastorolamal'].'&id_eblagh='.$id_eblagh.'\'">';}
	  echo'
	  </td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_dastorolamal_='.$row1['id_dastorolamal'].'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\',\'براي حذف دستورالعمل شماره '.$row1['shomare_dastorolamal'].' \')" /></td>';
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($right_gheymat_kharid) echo'<td>&nbsp;</td>';
	  if($right_del) echo'<td>&nbsp;</td>';
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
	 //if((($right_ins)and($activate_eblagh==1))OR(SuperUser()))//سوپریوزر بتواند بزند
	 if((($right_ins)and($activate_eblagh==1)))
	 {
	  echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	      <td width="10px">&nbsp;</td>';
	 }
	 echo'
	 <td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'eblagh_kharid.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
	 <td width="20px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail=1&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$PrevPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$NextPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo_detail='.$MaxPage.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_dastorolamal_kharid']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'&open_filter=1\'"></td>';	 
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
	   <tr class="title"><td colspan="6" align="center">ايجاد دستورالعمل جدید</td></tr>	   
	   <tr><td>&nbsp;</td></tr>
	   <tr>
		<td align="left"><span class="star">*</span> شماره دستورالعمل :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'"/></td>
        <td align="left""><span class="star">*</span> تاریخ دستورالعمل :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_dastorolamal" id="datepickerfrom" value="'.$tarikh_dastorolamal.'"/></td>
        <td align="left"><span class="star">*</span> تاریخ شروع اعتبار دستورالعمل :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_shoro_etebar" id="datepickerto" value="'.$tarikh_shoro_etebar.'"/></td>	   
	   </tr>
	   <tr>
		<td align="left"><span class="star">*</span> نام صادرکننده :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="name_saderkonande_dastorolamal" value="'.$name_saderkonande_dastorolamal.'"/></td>
	    <td align="left"><span class="star">*</span> وضعیت :&nbsp; </td>
		<td align="right">'.static_listbox("activate",$activate,"activateArr",1,"class='text4'").'</td> 
	    <td align="left"><span class="star">*</span> نوع قیمت گذاری :&nbsp; </td>
		<td align="right" >'.static_listbox("noe_gheymat",$noe_gheymat,"noegheymatArr",1,"class='text4'").'</td> 
	   </tr>
	   <tr  class="ostanshow" style="display:none;"><td align="left" ><span class="star">*</span>استان :&nbsp; </td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan T","1=1 $Condition_ostan AND code_ostan IN(SELECT code_ostan FROM sahmiebandy_kharid WHERE id_eblagh='$id_eblagh' AND deleted=0) ORDER BY T.name_ostan ASC","class='text4'","").'</td></tr>';

	   IF($noe_gheymat==2)echo' <tr class="ostanshow"><td align="left"><span class="star">*</span>استان :&nbsp; </td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan T","1=1 $Condition_ostan AND code_ostan IN(SELECT code_ostan FROM sahmiebandy_kharid WHERE id_eblagh='$id_eblagh' AND deleted=0) ORDER BY T.name_ostan ASC","class='text4'","").'</td></tr>';
       if($mahmule_type==2)//وارداتی
	   {echo'
	   <tr>
	    <td align="left"><span class="star">*</span> شماره قرارداد / سفر  :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="shomare_gharardad" value="'.$shomare_gharardad.'"/></td>
        <td align="left"><span class="star">*</span> تاریخ قرارداد :&nbsp;</td>
		<td align="right"><input type="text" class="textboxme2" maxlength="10" name="tarikh_gharardad" id="datepicker6" value="'.$tarikh_gharardad.'"/></td>
	   </tr>
	   <tr>
	   	<td align="left"><span class="star">*</span> کد طرف قرارداد (فروشنده/کشتی) :&nbsp; </td>
	    <td align="right">
		 <input type="text" class="textboxme2" readonly name="code_skk" value="'.$row3['code_skk'].'" onchange="getForushande(this.value)" />';
		 include('img_helpcoding_mali.php');
		 //include('img_help_acc_mofaser.php');
		echo'
		</td>
	   	<td align="left"><span class="star">*</span> طرف قرارداد (فروشنده/کشتی) :&nbsp; </td>
	    <td align="right" colspan="3"><!--<input type="hidden" class="textboxme2" readonly name="id_skk" value="'.$id_skk.'"/>-->
		 <input type="text" class="textboxme" readonly name="name_skk" value="'.$name_skk.'" onfocus="getForushande(document.myform.code_skk.value)" onchange="getForushande(document.myform.code_skk.value)"/>
		</td>
	   </tr>';
	   }
	   echo'
	   <tr>
        <td colspan="8" align="center" class="title">
		<input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
        <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if($Mode=="Edit")  //Edit Mode
    {
	 $q3="SELECT *,mt_skk.name_skk,name_ostan,
	     (SELECT count(*) FROM gharardad_kharid WHERE gharardad_kharid.id_dastorolamal=T.id_dastorolamal) gharardadcount From $TableName T 
		 LEFT JOIN mt_skk ON mt_skk.code_skk=T.code_skk 
		 LEFT JOIN ostan ON ostan.code_ostan=T.code_ostan
		 WHERE id_dastorolamal=$id_dastorolamal_";
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);   
	echo'
	<tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات شماره دستورالعمل  '.$row3['shomare_dastorolamal'].'</td></tr>        
	   <tr><td>&nbsp;</td></tr>
	   <tr>
		<td align="left"><span class="star">*</span> شماره دستورالعمل :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="shomare_dastorolamal" value="'.$row3['shomare_dastorolamal'].'"/></td>
        <td align="left""><span class="star">*</span> تاریخ دستورالعمل :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_dastorolamal" id="datepickerfrom" value="'.$row3['tarikh_dastorolamal'].'"/></td>
        <td align="left"><span class="star">*</span> تاریخ شروع اعتبار دستورالعمل :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_shoro_etebar" id="datepickerto" value="'.$row3['tarikh_shoro_etebar'].'"/></td>	   
	   </tr>
	   <tr>
		<td align="left"><span class="star">*</span> نام صادرکننده :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="name_saderkonande_dastorolamal" value="'.$row3['name_saderkonande_dastorolamal'].'"/></td>
	    <td align="left"><span class="star">*</span> وضعیت :&nbsp; </td>
		<td align="right">'.static_listbox("activate",$row3['activate'],"activateArr",1,"class='text4'").'</td>
	    <td align="left"><span class="star">*</span> نوع قیمت گذاری :&nbsp; </td>
		<td align="right">'.static_listbox("noe_gheymat",$row3['noe_gheymat'],"noegheymatArr",1,"class='text4'").'</td> 		
	   </tr>';
	   IF($row3['noe_gheymat']==2)echo' <tr class="ostanshow"><td align="left"><span class="star">*</span>استان :&nbsp; </td><td align="right">'.listbox("code_ostan",$row3['code_ostan'],"code_ostan","name_ostan","ostan T","1=1 $Condition_ostan  AND code_ostan IN(SELECT code_ostan FROM sahmiebandy_kharid WHERE id_eblagh='$id_eblagh' AND deleted=0) ORDER BY T.name_ostan ASC","class='text4'","").'</td></tr>';
       if($mahmule_type==2)//وارداتی
	   {echo'
	   <tr>
	    <td align="left"><span class="star">*</span> شماره قرارداد / سفر  :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme" name="shomare_gharardad" value="'.$row3['shomare_gharardad'].'"'; if($row3['gharardadcount']>0) echo'readonly';  echo' /></td>
        <td align="left"><span class="star">*</span> تاریخ قرارداد :&nbsp;</td>
		<td align="right"><input type="text" class="textboxme2" maxlength="10" name="tarikh_gharardad" id="datepicker6" value="'.$row3['tarikh_gharardad'].'"'; if($row3['gharardadcount']>0) echo'readonly';  echo'  /></td>
	   </tr>
	   <tr>
	   	<td align="left"><span class="star">*</span> کد طرف قرارداد (فروشنده/کشتی) :&nbsp; </td>
	    <td align="right">
		 <input type="text" class="textboxme2" readonly name="code_skk" value="'.$row3['code_skk'].'" onchange="getForushande(this.value)" />
		</td>
	   	<td align="left"><span class="star">*</span> طرف قرارداد (فروشنده/کشتی) :&nbsp; </td>
		<td align="right" colspan="3"> 
		 <input type="text" class="textboxme" readonly name="name_skk" value="'.$row3['name_skk'].'" onfocus="getForushande(document.myform.code_skk.value)" onchange="getForushande(document.myform.code_skk.value)"/>';
		  if($row3['gharardadcount']==0) include('img_helpcoding_mali.php');  //include('img_help_acc_mofaser.php');
		echo'
		</td>
	   </tr>';
	   }
	   echo'
	   <tr>'; 
		 if((($right_edt)and($row3['status']==0)and($_SESSION['mtStatusYear']==0)and($activate_eblagh==1) )or((SuperUser())and($row3['status']==0)and($activate_eblagh==1)))
		 {echo'
		  <td colspan="8" align="center" class="title">
		   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
           <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'">
		  </td>';
		 }
         else echo'<td  colspan="8" align="center" class="title"><div onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"></a></div></td> ';
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
       <tr class="title"><td colspan="10" align="center">جستجوی فرم دستورالعمل</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
		<td align="left" > شماره دستورالعمل :&nbsp; </td>
		<td align="right"><input type="text" class="textboxme2" name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'"/></td>
        <td align="left"> تاریخ دستورالعمل :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_eblagh" id="datepicker6" value="'.$tarikh_eblagh.'"/></td>
	    <td align="left"> تاریخ شروع اعتبار دستورالعمل :&nbsp;</td>
		<td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_shoro_etebar" id="datepickerto" value="'.$tarikh_shoro_etebar.'"/></td>	   
	   </tr>
	   <tr>	   
		<td align="left"> نام صادرکننده :&nbsp; </td>
		<td align="right" ><input type="text" class="textboxme" name="name_saderkonande" value="'.$name_saderkonande.'"/></td>
        <td align="left"> استان :&nbsp;</td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
	   </tr>   
	   <tr><td>&nbsp;</td></tr>
	   <tr>
        <td colspan="10" align="center" class="title">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\'">
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
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($eblagh,$shomare,$tarikh,$tarikh_etebar,$name_s_ds,$sh_gh,$date_gh,$code_skk,$mahmule,$gl_year,$act,$noe_gheymat,$c_ostan)
{
 $flag=false;  
 if(!($gl_year))//اگر سشن سال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً سال مورد نظر خود راانتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($eblagh and $shomare and $tarikh and $tarikh_etebar and $name_s_ds and $act and $noe_gheymat))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(($mahmule==2)and(!($sh_gh and $date_gh and $code_skk)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($noe_gheymat==2)and(!($c_ostan)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((checkdatejalali($tarikh)==false)or(checkdatejalali($tarikh_etebar)==false))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را با فرمت صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if((!empty($tarikh_etebar))and($mahmule==1))//تکراری نبودن تاریخ اعتبار
 {
   if($noe_gheymat==1)$q9="SELECT * FROM dastorolamal_kharid WHERE tarikh_shoro_etebar='$tarikh_etebar' AND id_eblagh=$eblagh and deleted=0";
   else if($noe_gheymat==2)$q9="SELECT * FROM dastorolamal_kharid WHERE tarikh_shoro_etebar='$tarikh_etebar' AND code_ostan='$c_ostan' AND id_eblagh=$eblagh and deleted=0";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('این تاریخ اعتبار قبلا ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 if((!empty($tarikh_etebar))and($mahmule==1))
 {
   if($noe_gheymat==1)$q10="SELECT tarikh_shoro_etebar FROM dastorolamal_kharid WHERE tarikh_shoro_etebar>='$tarikh_etebar' AND id_eblagh=$eblagh and deleted=0";
   else if($noe_gheymat==2)$q10="SELECT tarikh_shoro_etebar FROM dastorolamal_kharid WHERE tarikh_shoro_etebar>='$tarikh_etebar' AND code_ostan='$c_ostan' AND id_eblagh=$eblagh and deleted=0";
   $res10=mysql_query($q10);
   if(mysql_num_rows($res10)>0){
     echo"<script>alert('تاریخ اعتبار این جدول از جداول قبلی کمتر است و معتبر نمی باشد')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 if($act==2)
 {
   $q11="SELECT * FROM dastorolamal_kharid WHERE activate=1 AND id_eblagh=$eblagh and deleted=0";
   $res11=mysql_query($q11);
   if(mysql_num_rows($res11)==0)
   {
	 echo"<script>alert('وضعیت دستورالعمل را فعال قرار دهید')</script>";
     $flag=false;
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
 if(isPermitSave($id_eblagh,$shomare_dastorolamal,$tarikh_dastorolamal,$tarikh_shoro_etebar,$name_saderkonande_dastorolamal,$shomare_gharardad,$tarikh_gharardad,$code_skk,$mahmule_type,$mtActiveYear,$activate,$noe_gheymat,$code_ostan))
 {
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $insert_res=true;$log_i=true;$edit_res_das=true;$log_deactive=true;$edit_res_terminate=true;$log_faskh=true;$edit_res_safar=true;
   // if($activate==1)//اگر وضعیت فعال انتخاب شده باشد بقیه را غیرفعال می کنیم
   // {
	 // $q_das="SELECT id_dastorolamal FROM $TableName WHERE id_eblagh=$id_eblagh AND activate=1";
	 // $res_das=mysql_query($q_das);
	 // while($row_das=mysql_fetch_assoc($res_das))
	 // {
	  // //غیرفعال شدن دستورالعمل ها
	  // $edit_q_das=("UPDATE $TableName SET activate=2 WHERE id_dastorolamal=".$row_das['id_dastorolamal'].";");
	  // $edit_res_das=mysql_query($edit_q_das);
	  // /*log*/$log_deactive=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','".$row_das['id_dastorolamal']."','غیرفعال شدن دستورالعمل',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	  // //قراردادها ی فسخ نشده 
	  // $q_gharardad="SELECT * FROM gharardad_kharid INNER JOIN kala ON kala.code_kala=gharardad_kharid.code_kala WHERE id_dastorolamal=".$row_das['id_dastorolamal']." AND year=$mtActiveYear AND termination=1";
	  // $res_gharardad=mysql_query($q_gharardad);
	  // while($row_gharardad=mysql_fetch_assoc($res_gharardad))
	  // {
	    // //کل تحویلی قرارداد
        // //قوطی
        // if($row_gharardad['code_bastebandy']==2) $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row_gharardad['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
        // //کارتن یا لاشه
        // else $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row_gharardad['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
        // $sum_tahvily_gharardad=round($sum_tahvily_gharardad,3);
        // $meghdar_gharardad=round($row_gharardad['meghdar_gharardad'],3);
		// if($meghdar_gharardad!=$sum_tahvily_gharardad)//اگر تحویلی و اولیه یکی نبودند
		// { 
		  // //قراردادها فسخ و مقادیر آپدیت
		  // $terminate_q ="UPDATE gharardad_kharid SET termination=2,meghdar_gharardad=$sum_tahvily_gharardad WHERE id_gharardad =".$row_gharardad['id_gharardad']."";
          // $edit_res_terminate=mysql_query($terminate_q);
		  // /*log*/$log_faskh=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','gharardad_kharid','".$row_gharardad['id_gharardad']."','فسخ قرارداد',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
		  // //در شماره سفر اتمام سفر بلی می شود
		  // $edit_safar=("UPDATE shomare_safar SET etmam_safar=1 WHERE shomare_safar='".$row_gharardad['shomare_gharardad']."'");         
	      // $edit_res_safar=mysql_query($edit_safar);
		// }
	  // }//END while gharardad
	 // }//END while dastorolamal
   // }
   
    
   $insert_q=("INSERT INTO $TableName(id_eblagh,shomare_dastorolamal,tarikh_dastorolamal,tarikh_shoro_etebar,name_saderkonande_dastorolamal,shomare_gharardad,tarikh_gharardad,code_skk,year,activate,noe_gheymat,code_ostan,deleted)
               VALUES('$id_eblagh','$shomare_dastorolamal','$tarikh_dastorolamal','$tarikh_shoro_etebar',TRIM('$name_saderkonande_dastorolamal'),'$shomare_gharardad','$tarikh_gharardad','$code_skk',$mtActiveYear,'$activate','$noe_gheymat','$code_ostan',0)");
   $insert_res=mysql_query($insert_q);
   $max_id=$db->get_from_where("Max(id_dastorolamal)","$TableName","");  
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
    //if(($insert_res and $log_i and ($activate==1) and $edit_res_das and $log_deactive and $edit_res_terminate and $edit_res_safar)or($insert_res and $log_i and ($activate==2)))
    if(($insert_res and $log_i and $edit_res_das and $log_deactive and $edit_res_terminate and $log_faskh and $edit_res_safar))
    {
	  // $mahmule_type=$db->get_from_where("mahmule_type","eblagh_kharid","id_eblagh='$id_eblagh' AND deleted=0"); 
	  // IF($mahmule_type==4)
	  // {
	    // $max_dastorolamal=$db->get_from_where("Max(id_dastorolamal)","$TableName","id_eblagh='$id_eblagh' AND id_dastorolamal!='$max_id' AND deleted=0"); 
		// $q1="SELECT * FROM gharardad_kharid WHERE id_dastorolamal=$max_dastorolamal AND tarikh_gharardad>='$tarikh_shoro_etebar' AND deleted=0";
        // $res1=mysql_query($q1);
	    // while($row1=$db->fetch_assoc($res1))
	    // {
		   // $edit_q=("UPDATE gharardad_kharid SET id_dastorolamal='$max_id' WHERE id_gharardad=".$row1['id_gharardad']."");
           // $edit_res=mysql_query($edit_q); 		
	    // }
        // echo"<script>alert('شماره دستورالعمل در قراردادهای قبلی تغییر یافت')</script>";		
	  // }
      mysql_query("COMMIT");
	  echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\' </script>';
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
function isPermitEdit($eblagh,$shomare,$tarikh,$tarikh_etebar,$name_s_ds,$sh_gh,$date_gh,$code_skk,$mahmule,$gl_year,$act,$noe_gheymat,$c_ostan,$this_id)
{
// if(SuperUser())   
// {   echo"<script> alert('$eblagh')</script>";
    // echo"<script> alert('$shomare')</script>";
   // echo"<script> alert('$tarikh')</script>";
   // echo"<script> alert('$tarikh_etebar')</script>";
   // echo"<script> alert('$name_s_ds')</script>";
   // echo"<script> alert('$sh_gh')</script>";
    // echo"<script> alert('$date_gh')</script>";
	// echo"<script> alert('$code_skk')</script>";
	// echo"<script> alert('$mahmule')</script>";
// }

 $flag=false;
 if(!($gl_year))//اگر سشن سال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً سال مورد نظر خود راانتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($eblagh and $shomare and $tarikh and $tarikh_etebar and $name_s_ds and $noe_gheymat))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(($mahmule==2)and(!($sh_gh and $date_gh and $code_skk)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($noe_gheymat==2)and(!($c_ostan)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((checkdatejalali($tarikh)==false)or(checkdatejalali($tarikh_etebar)==false))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را با فرمت صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if((!empty($tarikh_etebar))and($mahmule==1))//تکراری نبودن تاریخ اعتبار
 {
   $q11="SELECT * FROM dastorolamal_kharid WHERE tarikh_shoro_etebar='$tarikh_etebar' AND id_eblagh=$eblagh and deleted=0 and id_dastorolamal!=$this_id";
   $res11=mysql_query($q11);
   if(mysql_num_rows($res11)>0){
     echo"<script>alert('این تاریخ اعتبار قبلا ثبت شده است')</script>";
     $flag=false;
     return $flag;
    }
    else $flag=true;
 }
 else $flag=true;
 if((!empty($tarikh_etebar))and($mahmule==1))
 {
   if($noe_gheymat==1)$q12="SELECT tarikh_shoro_etebar FROM dastorolamal_kharid WHERE tarikh_shoro_etebar>='$tarikh_etebar' AND id_eblagh='$eblagh' AND id_dastorolamal<'$this_id' AND deleted=0 and id_dastorolamal!='$this_id'";
   else if($noe_gheymat==2)$q12="SELECT tarikh_shoro_etebar FROM dastorolamal_kharid WHERE tarikh_shoro_etebar>='$tarikh_etebar' AND id_eblagh='$eblagh' AND code_ostan='$c_ostan' AND id_dastorolamal<'$this_id' AND deleted=0 and id_dastorolamal!='$this_id' ";
   $res12=mysql_query($q12);
   if(mysql_num_rows($res12)>0){
     echo"<script>alert('تاریخ اعتبار این جدول از جداول قبلی کمتر است و معتبر نمی باشد')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
  
  if($noe_gheymat==1)$q13="SELECT tarikh_shoro_etebar FROM dastorolamal_kharid WHERE tarikh_shoro_etebar<'$tarikh_etebar' AND id_eblagh='$eblagh' AND id_dastorolamal>'$this_id' AND deleted=0 and id_dastorolamal!='$this_id'";
  else if($noe_gheymat==2)$q13="SELECT tarikh_shoro_etebar FROM dastorolamal_kharid WHERE tarikh_shoro_etebar<'$tarikh_etebar' AND id_eblagh='$eblagh' AND code_ostan='$c_ostan' AND id_dastorolamal>'$this_id' AND deleted=0 and id_dastorolamal!='$this_id'";
  $res13=mysql_query($q13);
  if(mysql_num_rows($res13)>0){
     echo"<script>alert('تاریخ اعتبار این جدول از جداول بعدی بیشتر است و معتبر نمی باشد')</script>";
     $flag=false;
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
 if(isPermitEdit($id_eblagh,$shomare_dastorolamal,$tarikh_dastorolamal,$tarikh_shoro_etebar,$name_saderkonande_dastorolamal,$shomare_gharardad,$tarikh_gharardad,$code_skk,$mahmule_type,$mtActiveYear,$activate,$noe_gheymat,$code_ostan,$id_dastorolamal_))
 {
   $Mode='';	
   // if($activate==1)//اگر وضعیت فعال انتخاب شده باشد 
   // { 
	  // $q_gharardad="SELECT * FROM gharardad_kharid WHERE termination=1 AND id_dastorolamal=".$id_dastorolamal_." AND year=$mtActiveYear";
	  // $res_gharardad=mysql_query($q_gharardad);
	  // while($row_gharardad=mysql_fetch_assoc($res_gharardad))
	  // {
        // //در شماره سفر اتمام سفر خیر می شود
		  // $edit_safar=("UPDATE shomare_safar SET etmam_safar=0 WHERE shomare_safar='".$row_gharardad['shomare_gharardad']."'");         
	      // $edit_res_safar=mysql_query($edit_safar);
	   // }//END while gharardad
	// }
	// else //اگر وضعیت غیرفعال 
    // { 
	  // $q_gharardad="SELECT * FROM gharardad_kharid WHERE id_dastorolamal=".$id_dastorolamal_." AND year=$mtActiveYear";
	  // $res_gharardad=mysql_query($q_gharardad);
	  // while($row_gharardad=mysql_fetch_assoc($res_gharardad))
	  // {
        // //در شماره سفر اتمام سفر بلی می شود
		  // $edit_safar=("UPDATE shomare_safar SET etmam_safar=1 WHERE shomare_safar='".$row_gharardad['shomare_gharardad']."'");         
	      // $edit_res_safar=mysql_query($edit_safar);
	   // }//END while gharardad
	// }
  $edit_q=("UPDATE $TableName SET shomare_dastorolamal='$shomare_dastorolamal',tarikh_dastorolamal='$tarikh_dastorolamal',tarikh_shoro_etebar='$tarikh_shoro_etebar',name_saderkonande_dastorolamal='$name_saderkonande_dastorolamal',
            shomare_gharardad='$shomare_gharardad',tarikh_gharardad='$tarikh_gharardad',code_skk='$code_skk',activate='$activate',noe_gheymat='$noe_gheymat',code_ostan='$code_ostan'
            WHERE id_dastorolamal='$id_dastorolamal_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_dastorolamal_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\' </script>';
  }
  else if(mysql_affected_rows()==0) echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_eblagh='.$id_eblagh.'\' </script>';
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