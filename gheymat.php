<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="gheymat.php";
$TableName="mt_gheymat";
//$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;$right_detail=0;
if (right(60)) $right_ins=1;
if (right(61)) $right_edt=1;
if (right(62)) $right_del=1;  
if (right(63)) $right_detail=1;  
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جدول قیمت خرید</title>
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
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
    });
 });
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_gheymat']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($Gh_Shomare)    $temp.=" and Gh_Shomare LIKE '$Gh_Shomare'";
 if($Gh_TarikhEtebar) $temp.=" and Gh_TarikhEtebar LIKE '%$Gh_TarikhEtebar%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_gheymat']=$temp;} else $_SESSION['mt_search_gheymat']="";
}
 /********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;$count=1;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_gheymat']." AND Gh_Deleted=0");
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
 $del_q = "UPDATE $TableName SET Gh_Deleted=1 WHERE Gh_ID=$Gh_ID_ AND
          ($Gh_Shomare_ NOT IN(SELECT Gh_Shomare FROM bz_gheymat_jarime_detail WHERE Gh_Shomare='$Gh_Shomare_')AND
		  ($Gh_Shomare_ NOT IN (SELECT Ja_Shomare_this FROM resid WHERE Ja_Shomare_this='$Gh_Shomare_'))";
  $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
  if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
  else if($del_res)
   $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$Gh_ID_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.Gh_TarikhEtebar.focus();">
<form method="post" name="myform" onkeydown="enter();">
<div align="center">
<table width="800px" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">جدول قيمت خرید</div>
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
if(!isset($order))    $order='Gh_Shomare DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی شماره جدول" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=Gh_Shomare ASC&sortcode=2&show_img=1\'"/> شماره جدول ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی شماره جدول" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=Gh_Shomare DESC&sortcode=1&show_img=1\'"/> شماره جدول ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="25%" title="مرتب سازی صعودی تاريخ اعتبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=Gh_TarikhEtebar ASC&sorttarikh=2&show_img=2\'"/> تاریخ اعتبار '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="25%" title="مرتب سازی نزولی تاريخ اعتبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=Gh_TarikhEtebar DESC&sorttarikh=1&show_img=2\'"/> تاریخ اعتبار '; 
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
	  $Gh_Shomare=$db->get_from_where("Max(Gh_Shomare)","$TableName","");
	  if($Gh_Shomare==0)$Gh_Shomare=1000;
	  else $Gh_Shomare++;
	  echo'
	  <tr class="table-odd">
	   <td>'.$radif++.'</td>
	   <td><input type="text" class="textboxme2" readonly name="Gh_Shomare" value="'.$Gh_Shomare.'" ></td>
	   <td><input type="text" class="textboxme2" name="Gh_TarikhEtebar" id="datepicker6" maxlength="10" value="'.$Gh_TarikhEtebar.'"></td>
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
	   <td><input type="text" class="textboxme2" name="Gh_Shomare" value="'.$Gh_Shomare.'" ></td>
	   <td><input type="text" class="textboxme2" name="Gh_TarikhEtebar" id="datepicker6" maxlength="10" value="'.$Gh_TarikhEtebar.'"></td>
	   <td colspan="2"><input type="submit" class="buttonme" name="Search_x" value="جستجو"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT *,(SELECT count(*) FROM mt_gheymat_detail gh_d WHERE gh_d.Gd_GheymatID=T.Gh_ID AND gh_d.Gd_Deleted=0) detailcount
	     From $TableName T WHERE 1=1 ".$_SESSION['mt_search_gheymat']." AND Gh_Deleted=0 order by $order $Limit";
	$allGheymat = $db->query($q1);
    while($row1=$db->fetch_assoc($allGheymat))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&Gh_ID_='.$row1['Gh_ID'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['Gh_ID']==$Gh_ID_)
	 {
	 echo '
	  <td>'.$radif++.'</td>
	  <td><input type="text" class="textboxme2" readonly name="Gh_Shomare" value="'.$row1['Gh_Shomare'].'"></td>
	  <td><input type="text" class="textboxme2" id="datepicker6" name="Gh_TarikhEtebar" id="datepicker6" maxlength="10" value="'.$row1['Gh_TarikhEtebar'].'" ></td>	  
	  <td colspan="2">
	    <input class="buttonme" type="submit" name="Edit_x" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {
	  echo'
	  <td>'.$radif++.'</td>
	  <td '.$edtClick.'>'.$row1['Gh_Shomare'].'</td>
	  <td '.$edtClick.'>'.$row1['Gh_TarikhEtebar'].'</td>
	  <td>';
	  if($right_detail) {echo'<input type="button" class="buttonme"  value="جزئيات['.$row1['detailcount'].']" onClick="window.location=\'gheymat_detail.php?PageNo='.$PageNo.'&Gh_ID_='.$row1['Gh_ID'].'\'">';}
	  echo'
	  </td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&Gh_ID_='.$row1['Gh_ID'].'&Gh_Shomare_='.$row1['Gh_Shomare'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف جدول شماره '.$row1['Gh_Shomare'].' \')" /></td>';
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
     if ($_SESSION['mt_search_gheymat']) 
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
function isPermitSave($a,$b)
{
 $flag=false; 
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true; 
 if(!empty($b))//تکراری نبودن تاریخ اعتبار
 {
   $q9="SELECT * FROM mt_gheymat WHERE Gh_TarikhEtebar='$b' and Gh_Deleted=0";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('این تاریخ اعتبار قبلا ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if(!empty($b))
 {
   $q10="SELECT Gh_TarikhEtebar FROM mt_gheymat WHERE Gh_TarikhEtebar>='$b' and Gh_Deleted=0";
   $res10=mysql_query($q10);
   if(mysql_num_rows($res10)>0){
     echo"<script>alert('تاریخ اعتبار این جدول از جداول قبلی کمتر است و معتبر نمی باشد')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$this_id)
{
 $flag=false;
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($b))//تکراری نبودن تاریخ اعتبار
 {
   $q11="SELECT * FROM mt_gheymat WHERE Gh_TarikhEtebar='$b' and Gh_Deleted=0 and Gh_ID!=$this_id";
   $res11=mysql_query($q11);
   if(mysql_num_rows($res11)>0){
     echo"<script>alert('این تاریخ اعتبار قبلا ثبت شده است')</script>";
     $flag=false;
     return $flag;
    }
    else $flag=true;
 }
 else $flag=true;
 if(!empty($b))
 {
   $q12="SELECT Gh_TarikhEtebar FROM mt_gheymat WHERE Gh_TarikhEtebar>='$b' AND Gh_Shomare<'$a' AND Gh_Deleted=0 and Gh_ID!=$this_id";
   $res12=mysql_query($q12);
   if(mysql_num_rows($res12)>0){
     echo"<script>alert('تاریخ اعتبار این جدول از جداول قبلی کمتر است و معتبر نمی باشد')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
  $q13="SELECT Gh_TarikhEtebar FROM mt_gheymat WHERE Gh_TarikhEtebar<'$b' AND Gh_Shomare>'$a' AND Gh_Deleted=0 and Gh_ID!=$this_id";
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
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($Gh_Shomare,$Gh_TarikhEtebar))
 {
   $Mode='';
   $insert_q=("INSERT INTO $TableName(Gh_Shomare,Gh_TarikhEtebar,Gh_Deleted)VALUES('$Gh_Shomare','$Gh_TarikhEtebar',0)");
   $insert_res=mysql_query($insert_q);
   if($insert_res)
   {
    $max_id=$db->get_from_where("Max(Gh_ID)","$TableName","");  
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   	echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
   }   
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت جدول قیمت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($Gh_Shomare,$Gh_TarikhEtebar,$Gh_ID_))
 {
  $Mode='';	
  $edit_q=("UPDATE $TableName SET Gh_TarikhEtebar='$Gh_TarikhEtebar' WHERE Gh_ID='$Gh_ID_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$Gh_ID_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
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