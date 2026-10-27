<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_log.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش ثبت اطلاعات'; 
require_once('head.html');
$columns='	
	<tr class="print_table-title">
	 <td width=5%>ردیف</td>
	 <td width=10%>فرم</td>
	 <td width=5%>کدکاربر</td>
	 <td width=10%>نام کاربری</td>
	 <td width=10%>نام</td>
	 <td width=10%>نام خانوادگی</td>
	 <td width=10%>آی پی</td>
	 <td width=5%>شناسه فرم</td>	
	 <td width=10%>شماره</td>	
	 <td width=8%>تاریخ</td>
	 <td width=7%>زمان</td>
	 <td width=10%>عملیات</td>
	 <!--<td width=10%>تعداد فرم</td>-->
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$date1,$date2,$FileName,$page;
 echo'
   <br>
   <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
      	<tr class="noExl">
         <td class="print_title_2">';
	     IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo'
	     '.$titr.' از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
		 <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
		</td>
	   </tr>
      </table>
     </td>
    </tr>';  
}
/***************************************** MAIN*****************************************/
echo <<<_END
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
_END;
if(!$MaxLines)$MaxLines=15;
if(!$ok)
{
 echo'
 <table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">'.$titr.'</td></tr>
    <tr class="tr1">	
     <td align="left" width="20%" height="40px"> از تاریخ : </td><td align="right" width="30%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td>
     <td align="left" width="20%"> تا تاریخ : </td><td align="right" width="30%">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
     <td align="left"> شناسه فرم :&nbsp;</td><td align="right" colspan="3"><input class="textboxme2" type="text" name="record_id" value="'.$record_id.'"/>
	 </td>
    </tr>
	<tr class="tr1">
     <td align="left"> کد کاربر :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="user_id" value="'.$user_id.'"/>
	  <img border="0" src="images/help.png" onClick="popupwindow(\'help_user.php\',\'\',850,400)" title="جدول کاربران سیستم" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
	 </td>
	 <td align="left"> نام کاربری :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="user_name" value="'.$user_name.'"  />
    </tr>
	<tr class="tr1">
     <td align="left"> نام :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="first_name" value="'.$first_name.'"/></td> 	
	 <td align="left">  نام خانوادگی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="last_name" value="'.$last_name.'"/></td>
	</tr>
	<tr class="tr1">	
	 <td align="left" height="40px"> فرم :&nbsp;</td>
	 <td align="right"><select name="form_log" class="easyui-combobox text4" style=width:200px  data-options=panelHeight:150>
	                            <option value="1">وارده به سردخانه</option>
	                            <option value="2">صادره از سردخانه</option>
	                            <option value="3">تعدیل موجودی</option>
	                            <option value="4">مجوز جابه جایی</option>
	 </td>
	 <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right" ><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>    
    <tr class="footer">	
	 <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr> 
   </table>
  </td>
 </tr>
 </table>';
}
else
{
	$Condition="";

	if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
	{
	  $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
	} 
    //اگر کاربر تاریخ دوم را وارد نکرده بود
	if(!$date2)
	{
	 $date2=$today;
	}
	/****************فیلترها روی گزارش******************/
    if ($date1) $Condition.=" and log_date>='$date1'";//از تاریخ            
    if ($date2) $Condition.=" and log_date<='$date2'";//تا تاریخ            		
    IF ($record_id)   $Condition.=" and log.record_id='$record_id'";
    IF ($user_id)     $Condition.=" and log.user_id='$user_id'";
	IF ($user_name)   $Condition.=" and user_name LIKE '%$user_name%'";
	IF ($first_name)  $Condition.=" and first_name LIKE '%$first_name%'";
	IF ($last_name)   $Condition.=" and last_name LIKE '%$last_name%'";
	IF ($form_log==1) $Condition.=" and tbl_name='resid'";
    IF ($form_log==2) $Condition.=" and tbl_name='havale'";
    IF ($form_log==3) $Condition.=" and tbl_name='tadil_mojody'";
    IF ($form_log==4) $Condition.=" and tbl_name='mojavez_jabejae'";
	/****************شروع نمایش گزارش*******************/				
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	$q="SELECT log.*,user_name,first_name,last_name FROM log LEFT JOIN users ON log.user_id=users.user_id
	    WHERE 1=1  $Condition  ORDER BY log_id";
	//echo $q;
	$res=$db->query($q);
	$cntr =$db->num_rows($res);
	if($cntr>0)
    {
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if ($form_log==1)$filter_string.=' فرم : وارده به سردخانه';
	 if ($form_log==2)$filter_string.=' فرم : صادره از سردخانه';
	 if ($form_log==3)$filter_string.=' فرم : تعدیل موجودی';
	 if ($form_log==4)$filter_string.=' فرم : مجوز جابه جایی';
	 if ($recorde_id) $filter_string.=' شناسه فرم : '.$recorde_id.'&nbsp;';
	 if ($user_id)    $filter_string.=' کد کاربر : '.$user_id.'&nbsp;';
	 if ($user_name)  $filter_string.=' نام کاربری : '.$user_name.'&nbsp;';
	 if ($first_name) $filter_string.=' نام : '.$first_name.'&nbsp;';
	 if ($last_name)  $filter_string.=' نام خانوادگی : '.$last_name.'&nbsp;';

	 echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	  echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
      if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  IF($row['user_id']=='0') $user_name='superuser';
	  ELSE $user_name=$row['user_name'];
	  IF($row['tbl_name']=='resid') 
	  {
		   $tbl_name='فرم وارده به سردخانه';
		   $q2="SELECT code_ostan,code_anbar,shomare_resid FROM resid WHERE id=".$row['record_id']."";
	       $res2=mysql_query($q2);
	       $row2=mysql_fetch_assoc($res2);
	       if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
           else $code_a=$row2['code_ostan'];
		   $shomare=$code_a.$row2['code_anbar'].$row2['shomare_resid'];
	  }
	  ELSE IF($row['tbl_name']=='havale') 
	  {
		  $tbl_name='فرم صادره از سردخانه';
		  $q2="SELECT code_ostan,code_anbar,shomare_havale_anbar FROM havale WHERE id=".$row['record_id']."";
	      $res2=mysql_query($q2);
	      $row2=mysql_fetch_assoc($res2);
	      if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
          else $code_a=$row2['code_ostan'];
		  $shomare=$code_a.$row2['code_anbar'].$row2['shomare_havale_anbar'];
	  }
	  ELSE IF($row['tbl_name']=='tadil_mojody')
	  {	  
		  $tbl_name='فرم تعدیل موجودی ';
		  $q2="SELECT code_ostan,code_anbar,shomare_barge_tadil FROM tadil_mojody WHERE id=".$row['record_id']."";
	      $res2=mysql_query($q2);
	      $row2=mysql_fetch_assoc($res2);
	      if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
          else $code_a=$row2['code_ostan'];
		  $shomare=$code_a.$row2['code_anbar'].$row2['shomare_barge_tadil'];
	  }
	  ELSE IF($row['tbl_name']=='mojavez_jabejae') 
	  {  
	   $tbl_name='فرم مجوز جابه جایی ';
	   $q2="SELECT code_ostan,code_anbar,shomare_havale_anbar FROM mojavez_jabejae WHERE id=".$row['record_id']."";
	   $res2=mysql_query($q2);
	   $row2=mysql_fetch_assoc($res2);
	   $shomare=$row2['shomare_jabejae'];
	  } 
	  ELSE  $tbl_name='-';
	  
	  //$tedad=$db->get_from_where("COUNT(*)","log","user_id=".$row['user_id']." and tbl_name='".$row['tbl_name']."' and amaliyat='".$row['amaliyat']."'");
	  echo'
	    <td>'.$radif++.'</td>
		<td>'.$tbl_name.'</td>
	    <td>'.$row['user_id'].'</td>
	    <td>'.$user_name.'</td>
	    <td>'.$row['first_name'].'</td>
	    <td>'.$row['last_name'].'</td>
	    <td>'.$row['user_ip'].'</td>
	    <td>'.$row['record_id'].'</td>
	    <td>'.$shomare.'</td>
	    <td>'.$row['log_date'].'</td>
	    <td>'.$row['log_time'].'</td>
	    <td>'.$row['amaliyat'].'</td>
	    <!--<td>'.$tedad.'</td>-->
	  </tr>';
	   if($line>=$MaxLines && $i <$cntr) 
	   {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
			echo $columns;
	   }

	 }//END while
	 echo'
	 <!--پايان مرکز صفحه -->
	 <!-- چاپ زیرنویس-->
      <tr class="print_footer noExl">
       <td colspan="15">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
      </tr>
	 </table>'; 
	}
	ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'
</div>
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript">
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width="+w+", height="+h+", top="+top+", left="+left);
}
</script>