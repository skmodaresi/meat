<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="years.php";
$TableName="mt_docs";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(302)) $right_ins=1;
if (right(303)) $right_edt=1;
if (right(304)) $right_del=1;
//echo $yymmdd;
//$maxYear=92;
//echo $maxYear."0101";
//echo $yymmdd.'<br/>'.$yy.'/'.$mm.'/'.$dd;
//echo $yymmdd;
  //$start_from=str_replace('/', '',$_POST['start_from']);
  //$end_to    =str_replace('/', '',$_POST['end_to']);
//$bzActiveYear  = $db->get_from_where("year","mt_docs","status=0");
//echo $bzActiveYear;
//echo "<script>alert(".$bzActiveYear.")</script>";
//echo $yymmdd.'<br/>';
//echo Asdate($yymmdd).'<br/>';
//echo AsLDate($yymmdd).'<br/>';
  //$da='13890812';
 // echo AsLDate($da)."<br/>";
 // $r='891123';
 // echo AsDate($r)."<br/>";
// echo revdate($r)."<br/>";
//echo revdate($da);
//$daw=str_replace("/","","1234/56");
//echo $daw;
//$wdate=$da/1000000;
//$wdate1=$da%1000000;
//echo $wdate.'<br/>';
//echo $wdate1;
//if ($date1) {$date1=str_replace("/","",$date1);$date1=$date1%1000000;}
//if ($date2) {$date2=str_replace("/","",$date2);$date2=$date2%1000000;}
//echo $yy.'/'.$mm.'/'.$dd;
//echo $mt_gl_code_ostan;
//echo $mt_gl_code_anbar;
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>تعریف سال</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
   $("input").not( $(":button") ).keypress(function (evt){
    if (evt.keyCode == 13) {
    iname = $(this).val();
     if (iname !== "Submit"){
     var fields = $(this).parents("form:eq(0),body").find("button, input, textarea, select");
     <!--var fields = $("input:text,input:checkbox,select,textarea");-->
	 var index = fields.index( this );
     if ( index > -1 && ( index + 1 ) < fields.length ) {
      fields.eq( index + 1 ).focus();}
     return false;
     }
    }
   });
  });
$(function(){	    
    $("#datepicker5,#datepicker6").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
	 });
}); 
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['sard_search_years']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x="";
 $temp=""; 
 if($year)        $temp.=" and year LIKE '%$year%'";
 //if($year_titr) $temp.=" and year_titr LIKE '%$year_titr%'";
 if($start_from)  $temp.=" and start_from LIKE '%$start_from%'";
 if($end_to)      $temp.=" and end_to LIKE '%$end_to%'";
 if($status)      $temp.=" and status LIKE '%$status%'";
 if ($temp){$PageNo=1;$_SESSION['sard_search_years']=$temp;} else $_SESSION['sard_search_years']="";
 }
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['sard_search_years']."");
$row = mysql_fetch_array($res);
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
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($a,$b,$c)
{
 $flag=false;
 if(!($a and $b and $c))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if((!justNumber($a)) or($a<1392) or ($a>1450))//بررسی صحت سال
 {
   $flag=false;
   echo"<script>alert('فیلد سال نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 // if((!justNumber($b) or (strlen($b)>4) or strlen($b)<4))//چهار رقم بودن عنوان سال
 // {
   // $flag=false;
   // echo"<script>alert('فیلد عنوان سال نامعتبر است')</script>";
   // return $flag;
 // }
 // else $flag=true;
 if(!empty($a))//تکراری نبودن سال
 { 
  $q8="SELECT year FROM mt_docs WHERE year='$a'";
  $res8=mysql_query($q8);
  if(mysql_num_rows($res8)>0){
  echo"<script>alert('اين سال قبلاً ثبت شده است!')</script>";
  $flag=false;
  return $flag;
  }
  else $flag=true;
 }
 else $flag=true; 
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$c,$d)
{
  $flag=false;
  if(!($a and $b and $c and $d))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if((!justNumber($a)) or($a<1392) or ($a>1450))//بررسی صحت سال
  {
   $flag=false;
   echo"<script>alert('فیلد سال نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;
  // if((!justNumber($b) or (strlen($b)>4) or strlen($b)<4))//چهار رقم بودن عنوان سال
 // {
   // $flag=false;
   // echo"<script>alert('فیلد عنوان سال نامعتبر است')</script>";
   // return $flag;
 // }
 // else $flag=true;
  if(!empty($a))//تکراری نبودن سال
  { 
   $q10="SELECT * FROM mt_docs WHERE year='$a'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$d)){
   echo"<script>alert('اين سال قبلاً ثبت شده است!')</script>";
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
 if(isPermitSave($year,$start_from,$end_to))
 {
   $Mode='';
   $insert_q=("INSERT INTO $TableName(year,start_from,end_to,status)VALUES('$year','$start_from','$end_to','$status')");
   $insert_res=$db->query($insert_q,'مشکلي در ثبت سال به وجود آمده است!');
   if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
   }  
 }
}    
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($year,$start_from,$end_to,$id_))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET year='$year',start_from='$start_from',end_to='$end_to',status='$status' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) 
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");  /*کوئری لاگ*/      
   //ست کردن دوباره سشن شروع سال
   $_SESSION['mtstart_date_sh']=$db->get_from_where("start_from","$TableName","year=".$_SESSION['mtActiveYear']."");//تاریخ شروع سال
   $sql_tarikh=$_SESSION['mtstart_date_sh'];//تبدیل تاریخ شروع سال به میلادی
   $d=substr($sql_tarikh,8,2);
   $m=substr($sql_tarikh,5,2);
   $y=substr($sql_tarikh,0,4);
   $milady=jalali_to_gregorian($y,$m,$d);
   $sal=$milady[0];
   $mah=$milady[1];
   $rouz=$milady[2];
   $_SESSION['mtstart_date_mi']=$sal.'-'.$mah.'-'.$rouz;
   $mtStartDateSh=$_SESSION['mtstart_date_sh'];
   $mtStartDateMi=$_SESSION['mtstart_date_mi'];
   if($year==$_SESSION['mtActiveYear']) $_SESSION['mtStatusYear']=$status;//سشن وضعیت سال
  }
  else if(mysql_affected_rows()==0)  $message ='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';   
 }
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode=''; 
 $del_q="DELETE FROM $TableName WHERE id=$id_";
 $del_res=$db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES (".$_SESSION['mt_user_id'].",'$TableName','$id_','حذف',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.year.focus();">
<form method="post" name="myform">
<div align="center">
<table width="850px" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title"><div style="position:absolute;top:5px;left:47%;">تعریف سال</div>
  <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div></td> 	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order)) $order='id DESC';
if(!isset($sortyear)) $sortyear='1';
//if(!isset($sortyeartitr)) $sortyeartitr='1';
if(!isset($show_img)) $show_img='';
	 if($sortyear=='1')
	 {echo'<td width="13%" title="مرتب سازی صعودی سال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=year ASC&sortyear=2&show_img=1\'"/> سال ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortyear=='2')
	 {echo'<td width="13%" title="مرتب سازی نزولی سال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=year DESC&sortyear=1&show_img=1\'"/> سال ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 // if($sortyeartitr=='1')
	 // {echo'<td width="13%" title="مرتب سازی صعودی عنوان" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=year_titr ASC&sortyeartitr=2&show_img=2\'"/> عنوان '; 
	   // if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 // }
	 // if($sortyeartitr=='2')
	 // {echo'<td width="13%" title="مرتب سازی نزولی عنوان" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=year_titr DESC&sortyeartitr=1&show_img=2\'"/> عنوان '; 
	   // if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 // }
	echo'
	 <td width="15%">تاریخ شروع</td>
	 <td width="20%">تاریخ پایان</td>
	 <td width="20%">آخرین وضعیت</td>';
	 if($Mode==NULL)echo'<td width="19%">حذف</td>';
	 else echo'<td width="19%">دستورات</td>';
	 echo'
	 </tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') 
	 {
	  //$maxYear=$db->get_from_where("max(year)","mt_docs","code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar'");$maxYear++;
      // $maxYear=$db->get_from_where("max(year)","mt_docs","");
	  // if($maxYear){
	   // $maxYear++;
       // $year=$maxYear;
       // $year_titr=$maxYear;
       // $start_from=$maxYear."0101";
       // $end_to=$maxYear."1229";}
	  // else
	  // {
	   // $year=$yy;
	   // $year_titr="$yy";
	   // $start_from=$yy.'0101';
	   // $end_to=$yy.'1229';
	  // }
	  $button_value="ثبت"; $button_name="Insert_x";
	 } 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme2" name="year" maxlength=4 value="'.$year.'" title="برای سال چهار رقم وارد نمایید" onkeypress="return isNumber(event)" placeholder=" 1397" style="width:50px"/></td>
	      <!--<td><input type="text" class="textboxme2" name="year_titr" value="'.$year_titr.'" onkeypress="return isNumber(event)" style="width:60px"/></td>-->
	   <td><input type="text" class="textboxme2" name="start_from" id="datepicker5" maxlength=10 /></td>
	   <td><input type="text" class="textboxme2" name="end_to" id="datepicker6" maxlength=10 /></td>';
	  // <!--<td><input type="text" class="textboxme2" name="start_from" id="datepicker5" maxlength=10 value="'.AsLDate($start_from).'" /></td>-->
	   //<!--<td><input type="text" class="textboxme2" name="end_to" id="datepicker6" maxlength=10 value="'.AsLDate($end_to).'" /></td>-->
       if ($Mode=='Insert') echo'<td>'.static_listbox("status",$status,"yearstatArr",1,"class='text4'").'</td>';
	   if ($Mode=='Search') echo'<td><select name="status" class="text4">
	                                  <option value="-1">انتخاب کنید</option>
	                                  <option value="0">فعال</option>
	                                  <option value="1">غیر فعال</option>
									 </select></td>';
	  	echo'
         <!--<td><select name="curr" class="text4"><option value="0">-</option>
	                                         <option value="1">بلی</option></td>-->		
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" value="'.$button_value.'"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT * From $TableName T WHERE 1=1 ".$_SESSION['sard_search_years']." order by $order $Limit ";
	$allAnbar = $db->query($q1);
    while($row1=$db->fetch_assoc($allAnbar))
	{
     $edtClick=''; if (($right_edt)and($row1['status']!=2)) {$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     $delClick=''; if (($right_del)and($row1['status']!=2)) $delClick='onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف کلیه اطلاعات سال'.$row1["year"].' \')"';
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {echo '
	  <td><input type="text" class="textboxme2" name="year" maxlength=4 value="'.$row1['year'].'" title="برای سال چهار رقم وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/></td>
	  <td><input type="text" class="textboxme2" name="start_from" id="datepicker5" maxlength=10 value="'.$row1['start_from'].'" ></td>
	  <td><input type="text" class="textboxme2" name="end_to" id="datepicker6" maxlength=10 value="'.$row1['end_to'].'" ></td>
	  <td>'.static_listbox("status",$row1['status'],"yearstatArr",1,"class='text4'").'</td>
	      <!--<td><select name="curr" class="text4"><option value="0">-</option>
	                                             <option value="1">بلی</option>
	      </td>-->
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {
	 echo'
	  <td '.$edtClick.'>'.$row1['year'].'</td>
	  <td '.$edtClick.'>'.$row1['start_from'].'</td>
	  <td '.$edtClick.'>'.$row1['end_to'].'</td>
	  <td '.$edtClick.'>'.$yearstatArr[$row1['status']].'</td>
	  <td '.$delClick.'>';
	  if($right_del){
	   echo'<img border="0" src="images/trash.png" width="20" height="20" title="حذف" onmouseOver="this.src=\'images/trash_hover.png\'" onmouseOut="this.src=\'images/trash.png\'"/>';}
	  echo'</td>';
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
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
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
     if ($_SESSION['sard_search_years']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
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