<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="saghf_kharid.php";
$TableName="saghf_kharid";
$logtime=date('H:i:s');
$right_ins=1;$right_edt=1;$right_del=1;
if (right(342)) $right_ins=1;
if (right(343)) $right_edt=1;
if (right(344)) $right_del=1;  
// if (right(51)) $right_detail=1;  
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>تعیین سقف خرید کالا</title>
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
	    $("#datepickerfrom1").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto1").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto1").datepicker(
	  { showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true}
	  );
	  $("#datepickerfrom2").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto2").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto2").datepicker(
	  { showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true}
	  );
 });
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_saghfkharid']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($shomare_jadval)    $temp.=" and shomare_jadval LIKE '%$shomare_jadval%'";
 if($az_tarikh_etebar) $temp.=" and az_tarikh_etebar LIKE '%$az_tarikh_etebar%'";
 if($ta_tarikh_etebar) $temp.=" and ta_tarikh_etebar LIKE '%$ta_tarikh_etebar%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_saghfkharid']=$temp;} else $_SESSION['mt_search_saghfkharid']="";
}
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;$count=1;
$res = $db->query("SELECT COUNT(*) FROM meat.$TableName T INNER JOIN bzacc.group_kala_top ON T.code_group_kala_top=group_kala_top.code_group_kala_top  WHERE 1=1 ".$_SESSION['mt_search_saghfkharid']." AND code_ostan='$mt_gl_code_ostan' AND deleted=0");
//$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_saghfkharid']." AND code_ostan='$mt_gl_code_ostan' AND deleted=0");
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
if(isset($Delete_x))
{
 $Mode='';
 $del_q = "UPDATE $TableName SET deleted=1 WHERE id_saghf_kharid=$id_";
 $del_res = mysql_query($del_q);
 if($del_res)
  $log_d=mysql_query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.ta_tarikh_etebar.focus();">
<form method="post" name="myform" onkeydown="enter();">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">تعیین سقف خرید کالا</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td width="4%">رديف</td>';
/********************sort field***********************/
if(!isset($order))    $order='shomare_jadval DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="9%" title="مرتب سازی صعودی شماره جدول" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare_jadval ASC&sortcode=2&show_img=1\'"/> شماره جدول ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="9%" title="مرتب سازی نزولی شماره جدول" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=shomare_jadval DESC&sortcode=1&show_img=1\'"/> شماره جدول ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	 echo'
	 <td width="12%">از تاریخ</td>
	 <td width="12%">تا تاریخ</td>
	 <td width="8%">گروه کالا</td>
	 <td width="20%">حداکثر خرید</td>
	 <td width="12%">از تاریخ تولید</td>
	 <td width="12%">تا تاریخ تولید</td>';
	 if(($right_del)and($Mode==NULL)) echo'<td width="11%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="11%">دستورات</td>';
	 echo'
	</tr>';
	if($Mode=='Insert')
	{
	  $shomare_jadval=$db->get_from_where("Max(shomare_jadval)","$TableName","code_ostan=$mt_gl_code_ostan");
	  if($shomare_jadval==0)$shomare_jadval=1000;
	  else $shomare_jadval++;
	  echo'
	  <tr class="table-odd">
	   <td>'.$radif++.'</td>
	   <td><input type="text" class="textboxme2" readonly name="shomare_jadval" value="'.$shomare_jadval.'" ></td>
	   <td><input type="text" class="textboxme2" readonly name="az_tarikh_etebar" id="datepickerfrom1" maxlength="10" value="'.$az_tarikh_etebar.'"></td>
	   <td><input type="text" class="textboxme2" readonly name="ta_tarikh_etebar" id="datepickerto1" maxlength="10" value="'.$ta_tarikh_etebar.'"></td>
	   <td>'.listboxMe("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='text4'").'</td>
	   <td><input type="text" class="textboxme2" name="max_meghdar_kharid" value="'.$max_meghdar_kharid.'" onkeypress="return isNumber(event)"/></td>
       <td><input type="text" readonly class="textboxme2" maxlength="10" name="az_tarikh_tolid" id="datepickerfrom2" value="'.$az_tarikh_tolid.'"/></td>
       <td><input type="text" readonly class="textboxme2" maxlength="10" name="ta_tarikh_tolid" id="datepickerto2" value="'.$ta_tarikh_tolid.'"/></td>
	   <td colspan="2"><input type="submit" class="buttonme" name="Insert_x" value="ايجاد"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
    // if($Mode=='Search')	 
	// {  
	  // echo'
	  // <tr class="table-odd">
	   // <td>'.$radif++.'</td>
	   // <td><input type="text" class="textboxme2" name="shomare_jadval" value="'.$shomare_jadval.'" ></td>
	   // <td><input type="text" class="textboxme2" name="ta_tarikh_etebar" id="datepicker6" maxlength="10" value="'.$ta_tarikh_etebar.'"></td>
	   // <td colspan="2"><input type="submit" class="buttonme" name="Search_x" value="جستجو"/>
		   // <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   // </td>
	  // </tr>';
	// }
	$i=0;
    $q1="SELECT T.*,group_kala_top.name_group_kala_top From meat.$TableName T INNER JOIN bzacc.group_kala_top ON T.code_group_kala_top=group_kala_top.code_group_kala_top  WHERE 1=1 ".$_SESSION['mt_search_saghfkharid']." AND code_ostan='$mt_gl_code_ostan' AND deleted=0 ORDER BY $order $Limit";
	$allGheymat = $db->query($q1);
    while($row1=$db->fetch_assoc($allGheymat))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id_saghf_kharid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id_saghf_kharid']==$id_)
	 {
	 echo '
	  <td>'.$radif++.'</td>
	  <td><input type="text" class="textboxme2" readonly name="shomare_jadval" value="'.$row1['shomare_jadval'].'"></td>
	  <td><input type="text" class="textboxme2" name="az_tarikh_etebar" id="datepickerfrom1" readonly maxlength="10" value="'.$row1['az_tarikh_etebar'].'" /></td>	  
	  <td><input type="text" class="textboxme2" name="ta_tarikh_etebar" id="datepickerto1" readonly maxlength="10" value="'.$row1['ta_tarikh_etebar'].'" /></td>	  
	  <td>'.listboxMe("code_group_kala_top",$row1['code_group_kala_top'],"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='text4'").'</td>
	  <td><input type="text" class="textboxme2" name="max_meghdar_kharid" value="'.$row1['max_meghdar_kharid'].'" onkeypress="return isNumber(event)"/></td>
	  <td><input type="text" class="textboxme2" readonly maxlength="10" name="az_tarikh_tolid" id="datepickerfrom2" value="'.$row1['az_tarikh_tolid'].'"/></td>
	  <td><input type="text" class="textboxme2" readonly maxlength="10" name="ta_tarikh_tolid" id="datepickerto2" value="'.$row1['ta_tarikh_tolid'].'"/></td>
	  <td colspan="2">
	    <input class="buttonme" type="submit" name="Edit_x" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {
	  echo'
	  <td>'.$radif++.'</td>
	  <td '.$edtClick.'>'.$row1['shomare_jadval'].'</td>
	  <td '.$edtClick.'>'.$row1['az_tarikh_etebar'].'</td>
	  <td '.$edtClick.'>'.$row1['ta_tarikh_etebar'].'</td>
	  <td '.$edtClick.'>'.$row1['name_group_kala_top'].'</td>
	  <td '.$edtClick.'>'.$row1['max_meghdar_kharid'].'</td>
	  <td '.$edtClick.'>'.$row1['az_tarikh_tolid'].'</td>
	  <td '.$edtClick.'>'.$row1['ta_tarikh_tolid'].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id_saghf_kharid'].'&shomare_jadval_='.$row1['shomare_jadval'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف جدول شماره '.$row1['shomare_jadval'].' \')" /></td>';
	  }
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
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
	  if($right_del) echo'<td>&nbsp;</td>';
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
     echo'
	 </tr>';
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
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10px">&nbsp;</td>';}
	 echo'
	 <!--<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>-->
	 <td width="70px"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
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
     if ($_SESSION['mt_search_saghfkharid']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>	 	 
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
function isPermitSave($sh,$gl_c_o,$az_etebar,$ta_etebar,$c_gr,$m_mojody,$az_tolid,$ta_tolid)
{
 $flag=false;
 if((!$gl_c_o) or $gl_c_o==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار موردنظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($sh and $az_etebar and $ta_etebar and $c_gr and $m_mojody and $az_tolid and $ta_tolid))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(($az_etebar)and($ta_etebar))//از تاریخ
 {
   $q9="SELECT * FROM saghf_kharid WHERE (('$az_etebar' BETWEEN az_tarikh_etebar AND ta_tarikh_etebar)OR('$az_etebar'<az_tarikh_etebar AND '$ta_etebar'>az_tarikh_etebar)) AND code_ostan=$gl_c_o  AND code_group_kala_top=$c_gr and deleted=0";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('محدوده تاریخ تکراری است !')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 if($ta_etebar)//تا تاریخ
 {
   //$q9="SELECT * FROM saghf_kharid WHERE ta_tarikh_etebar>='$ta_etebar' AND code_ostan=$gl_c_o  AND code_group_kala_top=$c_gr and deleted=0";
   $q9="SELECT * FROM saghf_kharid WHERE (('$ta_etebar' BETWEEN az_tarikh_etebar AND ta_tarikh_etebar)OR(az_tarikh_etebar>'$ta_etebar' AND ta_tarikh_etebar<'$ta_etebar')) AND code_ostan=$gl_c_o  AND code_group_kala_top=$c_gr and deleted=0";
   //echo $q9;
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('محدوده تا تاریخ قبلاً برای این کالا ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true; 
 // if(!empty($ta_etebar))//تکراری نبودن تاریخ اعتبار
 // {
   // $q9="SELECT * FROM saghf_kharid WHERE ta_tarikh_etebar='$ta_etebar' AND code_ostan=$gl_c_o  AND code_group_kala_top=$c_gr and deleted=0";
   // $res9=mysql_query($q9);
   // if(mysql_num_rows($res9)>0){
     // echo"<script>alert('این تاریخ اعتبار قبلا ثبت شده است')</script>";
     // $flag=false;
     // return $flag;
  // }
 // else $flag=true;
 // }
 // else $flag=true;
 // if(!empty($ta_etebar))
 // {
   // $q10="SELECT ta_tarikh_etebar FROM saghf_kharid WHERE ta_tarikh_etebar>='$ta_etebar' AND code_ostan=$gl_c_o AND code_group_kala_top=$c_gr and deleted=0";
   // $res10=mysql_query($q10);
   // if(mysql_num_rows($res10)>0){
     // echo"<script>alert('تاریخ اعتبار این جدول از جداول قبلی کمتر است و معتبر نمی باشد')</script>";
     // $flag=false;
     // return $flag;
  // }
  // else $flag=true;
 // }
 // else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($sh,$gl_c_o,$az_etebar,$ta_etebar,$c_gr,$m_mojody,$az_tolid,$ta_tolid,$this_id)
{
 $flag=false;
    // echo"<script> alert($m_mojody)</script>";

 if((!$gl_c_o) or ($gl_c_o==-1))//اگر سشن استان و انبار خالی بود
 {   
    $flag=false;
    echo"<script> alert('لطفاً استان مورد نظر خود را از پایین صفحه انتخاب کنید!')</script>";
    return $flag;
 }
 else $flag=true; 
 if(!($sh and $az_etebar and $ta_etebar and $c_gr and $m_mojody and $az_tolid and $ta_tolid))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($m_mojody))//مقدار خرید را کمتر نزند
 {
   $q1="SELECT max_meghdar_kharid FROM saghf_kharid WHERE id_saghf_kharid=$this_id";
   $res1=mysql_query($q1);
   $row1=mysql_fetch_assoc($res1);
   if($row1['max_meghdar_kharid']>$m_mojody){
     echo"<script>alert('حداقل مقدار خرید از مقدار ثبت شده قبلی کمتر است امکان ثبت وجود ندارد')</script>";
     $flag=false;
     return $flag;
    }
    else $flag=true;
 }
 else $flag=true;
 if(($az_etebar)and($ta_etebar))//از تاریخ
 {
   $q9="SELECT * FROM saghf_kharid WHERE (('$az_etebar' BETWEEN az_tarikh_etebar AND ta_tarikh_etebar)OR('$az_etebar'<az_tarikh_etebar AND '$ta_etebar'>az_tarikh_etebar)) AND code_ostan=$gl_c_o  AND code_group_kala_top=$c_gr and deleted=0 and id_saghf_kharid!=$this_id";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('محدوده تاریخ تکراری است !')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 if($ta_etebar)//تا تاریخ
 {
   $q9="SELECT * FROM saghf_kharid WHERE (('$ta_etebar' BETWEEN az_tarikh_etebar AND ta_tarikh_etebar)OR(az_tarikh_etebar>'$ta_etebar' AND ta_tarikh_etebar<'$ta_etebar')) AND code_ostan=$gl_c_o  AND code_group_kala_top=$c_gr and deleted=0 and id_saghf_kharid!=$this_id";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('محدوده تا تاریخ قبلاً برای این کالا ثبت شده است')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
   if($ta_etebar<$az_etebar){
     echo"<script>alert('محدوده تاریخ صحیح انتخاب نشده است')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
 }
 else $flag=true; 
 if(($az_tolid)and($ta_tolid))//از تولید کمتر از تا تولید باشد
 {
   if($ta_tolid<$az_tolid){
     echo"<script>alert('محدوده تاریخ تولید صحیح انتخاب نشده است')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
 }
 else $flag=true; 

 
 
 // if(!empty($ta_etebar))
 // {
   // $q12="SELECT ta_tarikh_etebar FROM saghf_kharid WHERE ta_tarikh_etebar>='$ta_etebar' AND code_ostan=$gl_c_o AND code_group_kala_top=$c_gr AND shomare_jadval<'$sh' and deleted=0 and id_saghf_kharid!=$this_id";
   // $res12=mysql_query($q12);
   // if(mysql_num_rows($res12)>0){
     // echo"<script>alert('تاریخ اعتبار این جدول از جداول قبلی کمتر است و معتبر نمی باشد')</script>";
     // $flag=false;
     // return $flag;
  // }
  // else $flag=true;
  // $q13="SELECT ta_tarikh_etebar FROM saghf_kharid WHERE ta_tarikh_etebar<'$ta_etebar' AND code_ostan=$gl_c_o AND shomare_jadval>'$sh' and deleted=0 and id_saghf_kharid!=$this_id";
  // $res13=mysql_query($q13);
  // if(mysql_num_rows($res13)>0){
     // echo"<script>alert('تاریخ اعتبار این جدول از جداول بعدی بیشتر است و معتبر نمی باشد')</script>";
     // $flag=false;
     // return $flag;
  // }
  // else $flag=true;
 // }
 // else $flag=true;
 
return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($shomare_jadval,$mt_gl_code_ostan,$az_tarikh_etebar,$ta_tarikh_etebar,$code_group_kala_top,$max_meghdar_kharid,$az_tarikh_tolid,$ta_tarikh_tolid))
 {
   $Mode='';
   $insert_q=("INSERT INTO $TableName(shomare_jadval,code_ostan,az_tarikh_etebar,ta_tarikh_etebar,code_group_kala_top,max_meghdar_kharid,az_tarikh_tolid,ta_tarikh_tolid,deleted)VALUES('$shomare_jadval','$mt_gl_code_ostan','$az_tarikh_etebar','$ta_tarikh_etebar','$code_group_kala_top','$max_meghdar_kharid','$az_tarikh_tolid','$ta_tarikh_tolid',0)");
   $insert_res=mysql_query($insert_q);
   if($insert_res)
   {
    $max_id=$db->get_from_where("Max(id_saghf_kharid)","$TableName","");  
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
    echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
   }   
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($shomare_jadval,$mt_gl_code_ostan,$az_tarikh_etebar,$ta_tarikh_etebar,$code_group_kala_top,$max_meghdar_kharid,$az_tarikh_tolid,$ta_tarikh_tolid,$id_))
 {
  $Mode='';	
  $edit_q=("UPDATE $TableName SET az_tarikh_etebar='$az_tarikh_etebar',ta_tarikh_etebar='$ta_tarikh_etebar',code_group_kala_top='$code_group_kala_top',max_meghdar_kharid='$max_meghdar_kharid',az_tarikh_tolid='$az_tarikh_tolid',ta_tarikh_tolid='$ta_tarikh_tolid' WHERE id_saghf_kharid='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");
   echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else if(mysql_affected_rows()==0) echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';                
 } 
}
/********************END********************/	
echo'
'.$message.'
</form>
</body>
</html>';	
?>