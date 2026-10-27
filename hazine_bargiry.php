<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="hazine_bargiry.php";
$TableName="hazine_bargiry";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;$right_detail=0;
if (right(82)) $right_ins=1;
if (right(83)) $right_edt=1;
if (right(84)) $right_del=1;  
if (right(85)) $right_detail=1;  
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>جدول هزینه بارگیری</title>
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
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_h_bargiry']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($sh_jadval_bargiry) $temp.=" and sh_jadval_bargiry LIKE '%$sh_jadval_bargiry%'";
 if($tarikh_etebar)     $temp.=" and tarikh_etebar LIKE '%$tarikh_etebar%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_h_bargiry']=$temp;} else $_SESSION['mt_search_h_bargiry']="";
}
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;$count=1;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_h_bargiry']." and code_ostan='$mt_gl_code_ostan' and deleted=0");
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
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($gl_c_o,$a,$b)
{
 $flag=false;
 if((!$gl_c_o) or ($gl_c_o==-1))//اگر سشن استان خالی بود
 {   
    $flag=false;
    echo"<script> alert('لطفاً استان مورد نظر خود را از پایین صفحه انتخاب کنید!')</script>";
    return $flag;
 }
 else $flag=true; 
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true; 
 if(!empty($b))//تکراری نبودن تاریخ اعتبار
 {
   $q9="SELECT * FROM hazine_bargiry WHERE tarikh_etebar='$b' AND code_ostan='$gl_c_o' AND deleted=0";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('این تاریخ اعتبار قبلا ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($gl_c_o,$a,$b,$this_id)
{
 $flag=false;
 if((!$gl_c_o) or ($gl_c_o==-1))//اگر سشن استان خالی بود
 {   
    $flag=false;
    echo"<script> alert('لطفاً استان مورد نظر خود را از پایین صفحه انتخاب کنید!')</script>";
    return $flag;
 }
 else $flag=true; 
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($b))//تکراری نبودن تاریخ اعتبار
 {
   $q10="SELECT * FROM hazine_bargiry WHERE tarikh_etebar='$b' AND code_ostan='$gl_c_o' AND deleted=0 AND id!=$this_id";
   $res10=mysql_query($q10);
   if(mysql_num_rows($res10)>0){
     echo"<script>alert('این تاریخ اعتبار قبلا ثبت شده است')</script>";
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
 if(isPermitSave($mt_gl_code_ostan,$sh_jadval_bargiry,$tarikh_etebar))
 {
   $Mode='';
   $insert_q=("INSERT INTO $TableName(sh_jadval_bargiry,code_ostan,tarikh_etebar,deleted)VALUES('$sh_jadval_bargiry','$mt_gl_code_ostan','$tarikh_etebar',0)");
   $insert_res=mysql_query($insert_q);
   if($insert_res){
    $max_id=$db->get_from_where("Max(sh_jadval_bargiry)","$TableName","");  
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
   }   
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($mt_gl_code_ostan,$sh_jadval_bargiry,$tarikh_etebar,$id_))
 {
  $Mode='';	
  $edit_q=("UPDATE $TableName SET tarikh_etebar='$tarikh_etebar' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");
  else if(mysql_affected_rows==0) $message='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';               
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode=''; 
 $del_q = "update $TableName set deleted=1 WHERE id=$id_ AND
           ($sh_jadval_bargiry_ NOT IN (SELECT sh_jadval_bargiry FROM hazine_bargiry_detail WHERE sh_jadval_bargiry=$sh_jadval_bargiry_ AND code_ostan=$mt_gl_code_ostan AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.tarikh_etebar.focus();">
<form method="post" name="myform" onkeydown="enter();">
<div align="center">
<table width="800px" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">جدول هزینه بارگیری</div>
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
	 <td width="10%">رديف</td>';
/********************sort field***********************/
if(!isset($order))    $order='sh_jadval_bargiry DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی شماره جدول" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sh_jadval_bargiry ASC&sortcode=2&show_img=1\'"/> شماره جدول ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی شماره جدول" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sh_jadval_bargiry DESC&sortcode=1&show_img=1\'"/> شماره جدول ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="25%" title="مرتب سازی صعودی تاريخ اعتبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_etebar ASC&sorttarikh=2&show_img=2\'"/> تاریخ اعتبار '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="25%" title="مرتب سازی نزولی تاريخ اعتبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_etebar DESC&sorttarikh=1&show_img=2\'"/> تاریخ اعتبار '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	 echo'
	 <td width="20%">جزئيات</td>';
	 if(($right_del)and($Mode==NULL)) echo'<td width="25%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="25%">دستورات</td>';
	 echo'
	</tr>';
	if($Mode=='Insert')
	{
	  $sh_jadval_bargiry=$db->get_from_where("Max(sh_jadval_bargiry)","$TableName","code_ostan='$mt_gl_code_ostan'");
	  $sh_jadval_bargiry++;
	  echo'
	  <tr class="table-odd">
	   <td>'.$radif++.'</td>
	   <td><input type="text" class="textboxme2" readonly name="sh_jadval_bargiry" value="'.$sh_jadval_bargiry.'" ></td>
	   <td><input type="text" class="textboxme2" name="tarikh_etebar" id="datepicker6" maxlength="10" value="'.$tarikh_etebar.'"></td>
	   <td colspan="2"><input type="submit" class="buttonme" name="Insert_x" value="ايجاد"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
    if($Mode=='Search')	 
	{  
	  echo'
	  <tr class="table-odd">
	   <td>'.$radif++.'</td>
	   <td><input type="text" class="textboxme2" name="sh_jadval_bargiry" value="'.$sh_jadval_bargiry.'" ></td>
	   <td><input type="text" class="textboxme2" name="tarikh_etebar" id="datepicker6" maxlength="10" value="'.$tarikh_etebar.'"></td>
	   <td colspan="2"><input type="submit" class="buttonme" name="Search_x" value="جستجو"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT *,(SELECT count(*) FROM hazine_bargiry_detail b_d WHERE b_d.sh_jadval_bargiry=T.sh_jadval_bargiry AND b_d.code_ostan=T.code_ostan) detailcount
	     From $TableName T WHERE 1=1 ".$_SESSION['mt_search_h_bargiry']." AND code_ostan='$mt_gl_code_ostan' AND deleted=0 order by $order $Limit";
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&sh_jadval_bargiry_='.$row1['sh_jadval_bargiry'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	 echo '
	  <td>'.$radif++.'</td>
	  <td><input type="text" class="textboxme2" readonly name="sh_jadval_bargiry" value="'.$row1['sh_jadval_bargiry'].'"></td>
	  <td><input type="text" class="textboxme2" id="datepicker6" name="tarikh_etebar" id="datepicker6" maxlength="10" value="'.$row1['tarikh_etebar'].'" ></td>	  
	  <td colspan="2">
	    <input class="buttonme" type="submit" name="Edit_x" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {
	  echo'
	  <td>'.$radif++.'</td>
	  <td '.$edtClick.'>'.$row1['sh_jadval_bargiry'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_etebar'].'</td>
	  <td>';
	  if($right_detail) {echo'<input type="button" class="buttonme"  value="جزئيات['.$row1['detailcount'].']" onClick="window.location=\'hazine_bargiry_detail.php?PageNo='.$PageNo.'&sh_jadval_bargiry_='.$row1['sh_jadval_bargiry'].'&code_ostan_='.$row1['code_ostan'].'\'">';}
	  echo'
	  </td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&sh_jadval_bargiry_='.$row1['sh_jadval_bargiry'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف جدول شماره '.$row1['sh_jadval_bargiry'].' \')" /></td>';
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
	 <td width="10px">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_hazine_bargiry.php\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10px">&nbsp;</td>';}
	 echo'
	 <td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
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
     if ($_SESSION['mt_search_h_bargiry']) 
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
</div>
'.$message.'
</form>
</body>
</html>';	
?>