<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_grkala.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش مانده موجودی کلی کالاها';
require_once('head.html');
$columns='
 	<tr class="print_table-title2">
	 <td width="5%" rowspan="2">ردیف</td>
	 <td width="15%" rowspan="2">استان</td>
	 <td width="20%" colspan="3">گوشت گاو</td>
	 <td width="20%" colspan="3">گوشت گوسفند</td>
	 <td width="20%" colspan="3">گوشت مرغ</td>
	 <td width="20%" colspan="3">کنسرو مرغ</td>
	</tr>
	<tr class="print_table-title2">';
	for($count=1;$count<=4;$count++)
	{
         $columns.='
		 <td >داخلی</td>
    	 <td >وارداتی</td>
    	 <td >جمع</td>';
		 }
     $columns.='</tr>';
/****************هدر******************/
Function print_header()
{global $titr,$count,$mt_gl_owner,$date1,$date2,$FileName,$page,$db;
  echo'
   <br>   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2">'.$titr.'</td></tr>
	   <tr class="noExl">
	    <td class="print_title_2">';
	    IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
         echo' 
	       از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
	      <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	     </td>
	   </tr>
	  </table>
	 </td>
    </tr>';
}
/****************فیلترها روی گزارش******************/
/****************استان ها***************************/
////////////////آرایه انتخاب استانها///////////////////
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
  if(is_array($ostanchoice))//کد های استان
  {
    foreach($ostanchoice as $key => $val ) {
    $Condition_ostan_1.=" code_ostan='$val' OR";
    }
    if($val==-1)$Condition_ostan.="";
    else $Condition_ostan.=" AND $Condition_ostan_1";
   $lastSpacePosition = strrpos($Condition_ostan," ");
   $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
  }
}
else $Condition_ostan=' AND code_ostan='.$_SESSION['mt_code_ostan'].'';

/***********فقط انتخاب یک استان*******/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
	  if($code_ostan==-1){$Condition_ostan.="";}
	  else{$Condition_ostan=' AND code_ostan='.$code_ostan.'';}
}
else 
{
	  $Condition_ostan=' AND code_ostan='.$_SESSION['mt_code_ostan'].'';
}
/***************سردخانه ها*********************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{
     if(($code_ostan==-1)or($code_anbar==-1)){$Condition_anbar='1=1';}
     else{$Condition_anbar=' T.code_anbar='.$code_anbar.'';}
}
else //بقیه کاربران براساس انبار قابل دسترسیشان وانتخاب یکی یا چند تا
{  
      if(is_array($sardkhanechoice))
     {
       $Condition_anbar="";//شرط را خالی میکنم
	   foreach($sardkhanechoice as $anbar_key => $anbar_val) {$Condition_anbar_temp.=" T.code_anbar='$anbar_val' OR";}
       if($anbar_val==-1) $Condition_anbar.="1=1 OR";
       else $Condition_anbar.=" $Condition_anbar_temp";
       $lastSpacePosition = strrpos($Condition_anbar," ");
       $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     }    
}
/******************نمایش یا عدم نمایش سردخانه های موقت******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND";  $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date2.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=15;
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)
{
  $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
}
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
     $today=AsLDate($yymmdd); 
     $end_date_session=$db->get_from_where("end_to","mt_docs","year='$mtActiveYear'");
     if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
}   
if(!$ok)
{
echo'
<table width="95%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px;">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:100").'</td>	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; همراه با اطلاعات سردخانه موقت </td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
	<tr class="tr1">
	    <td align="left" height="40px"> نمایش :</td><td align="right" colspan="3">&nbsp;
		'.static_listbox("namayesh_info",$namayesh_info,"namayesh_infoArr",1,"class='easyui-combobox text4' style=width:100px").'
		</td>	
    </tr> ';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	  echo'
	 <tr class="tr1">
	  <td align="left" height="40px">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" style="width:200px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>
	  </td>
	 </tr>';
	}
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))echo'<tr class="tr1"><td colspan="4">در صورتیکه میخواهید سردخانه خاصی را انتخاب نمایید ابتدا آیتم استان پایین را انتخاب و سپس سردخانه مدنظر را انتخاب کنید.</td></tr>';
	echo'
	<tr class="tr1" style="height:45px;">';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{echo'
       <td align="left" >نام استان : &nbsp;</td><td align="right">'.listbox_ostan("code_ostan","$code_ostan","code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4' onChange='myform.submit()' ").'</td>';	  	  	    
	   if(($code_ostan)) echo'<td align="left"> سردخانه :&nbsp;</td><td align="right">'.listbox_anbar("code_anbar",$code_anbar,"code_anbar","name_anbar","list_sardkhane","1=1 and code_ostan=$code_ostan ORDER BY list_sardkhane.name_anbar ASC","class='text4'").'</td>';
	   else echo'<td colspan="2"></td>';
		//echo'<td align="left" > سردخانه :&nbsp;</td><td align="right"><select class="easyui-combobox" name="code_anbar"  onChange="$(\'#myform\').submit();"  ><option value="0">انتخاب کنيد</option><option value="1">1</option><option value="2">2</option></select></td>';
	}
	else 
	{
	 echo'
	 
	 <td align="left"> سردخانه :&nbsp;</td>
     <td align="right" colspan="3">
	  <select name="sardkhanechoice[]" class="easyui-combobox" multiple="true" style="width:50%;">
	  <!--<select name="sardkhanechoice[]" size="4" style="width:330px;" multiple>-->';
	  $result_sardkhane = $db->query("SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']." ORDER BY list_sardkhane.name_anbar ASC");
      $sardkhane_options = "<option value='-1' selected>همه سردخانه ها</option>";
      while($row_sardkhane=$db->fetch_assoc($result_sardkhane)) $sardkhane_options.= "<option value=".$row_sardkhane['code_anbar'].">".$row_sardkhane['name_anbar']."</option>";
	  echo $sardkhane_options;
	  echo'
	  </select>
	  <!--<img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>-->
	 ';
	}
	echo'
	  </tr>
	    <!--<tr class="tr1">
         <td align="left">نام کالا : </td>
         <td align="right">
	      &nbsp;<select name="kalachoice[]" size="4" multiple>';
	      $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
          $kala_options = "<option value='-1' selected>همه کالاها</option>";
          while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']."</option>";
	      echo $kala_options;
	      echo'
	      </select>
	      <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	     &nbsp;';
	     echo'
	     </td>
	     <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	    </tr>-->

	<tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>     
   </table>
  </td>
 </tr>
</table> ';
}
else
{
	IF($namayesh_info==2){$table_mojody='mojody_kala_gomrok'; $Condition_info=" AND noe_tahvil_bar=9";}
    ELSE {$table_mojody='mojody_kala'; $Condition_info=" AND noe_tahvil_bar!=9";}
	$dateCond="";
    $radif=1;
	/****************فیلترها روی گزارش******************/	
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_anbar_activate_ostan) $Condition  $Condition_ostan  ORDER BY name_ostan";
	//echo $q;
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/  
	  //echo "<script>alert(".$ostanchoice[$key].")</script>";
	  if(($code_ostan=='-1')AND($ostanchoice[$key]=='-1')){$nameOstan='همه استانها';$filter_string_ostan=' استان : '.$nameOstan.'&nbsp;';}
	  else if(($code_ostan=='-1')AND($ostanchoice[$key]!='-1')){
		  $filter_string_ostan=' استان : ';
	      foreach($ostanchoice as $key => $val) {
	      $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$val'");
	      $filter_string_ostan.=''.$nameOstan.'&nbsp;';  
	      }
	  }
	  else if($code_ostan!='-1')
	  {
		  $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$code_ostan'");
	      $filter_string_ostan=' استان : '.$nameOstan.'&nbsp;';
	  }
	  if($code_anbar) {if($code_anbar=='-1'){$nameAnbar='همه سردخانه ها';}else{$nameAnbar=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$code_ostan' AND code_anbar='$code_anbar'");}$filter_string.=' سردخانه : '.$nameAnbar.'&nbsp;';}     
	  if(is_array($sardkhanechoice))//بقیه کاربران
	  {
	   if($anbar_val==-1)$filter_string2=' سردخانه : همه سردخانه ها ';
	   else $filter_string2=' سردخانه : ';
	   foreach($sardkhanechoice as $anbar_key => $anbar_val) {
	    $nameAnbar=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$anbar_val'");
	    $filter_string2.=''.$nameAnbar.'&nbsp;';
       }
	  }
	  
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت -';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت -';
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if($noe_namayesh) {$filter_string.=' نوع نمایش براساس : '.$namayeshArr[$noe_namayesh].'&nbsp;';}     
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string_ostan.' '.$filter_string2.' '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		 <td>'.$radif++.'</td>
	     <td>'.$row['name_ostan'].'</td>';
		 //befor add filter sardkhanes
		 // if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';}
		 // else //بقیه کاربران براساس انبار قابل دسترسیشان
		 // {
		  // $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."";
		  // $res2=$db->query($q2);
		  // while($row2=$db->fetch_assoc($res2))//انبارهای قابل دسترسی
		  // {
		   // $Condition_anbar_temp.=" T.code_anbar=".$row2['code_anbar']." OR";
		  // }
		   // $Condition_anbar.="  $Condition_anbar_temp";
           // $lastSpacePosition = strrpos($Condition_anbar," ");
           // $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
		 // }
		 $kalaArray = array("11"=>"گوشت گاو داخلی","12"=>"گوشت گاو وارداتی","13"=>"جمع","14"=>"گوشت گوسفند داخلی","15"=>"گوشت گوسفند وارداتی","16"=>"جمع","17"=>"گوشت مرغ داخلی","18"=>"گوشت مرغ وارداتی","19"=>"جمع","20"=>"کنسرو مرغ داخلی","21"=>"کنسرو مرغ وارداتی","22"=>"جمع");
         foreach($kalaArray as $x => $x_value)
		 {		  
           //echo "Key=" . $x . ", Value=" . $x_value;echo "<br>";
		   $kalaCondition="";
		   if($x_value!="جمع")
		   {
		    if($x=="11")//گاو داخلی
			{
			 $kalaCondition=" AND (T.code_kala=81 OR T.code_kala=82 OR T.code_kala=83 OR T.code_kala=84 OR T.code_kala=85 OR T.code_kala=86)";
			}
		    if($x=="12")//گاو وارداتی
			{
			 $kalaCondition=" AND (T.code_kala=72 OR T.code_kala=73 OR T.code_kala=74 OR T.code_kala=75 OR T.code_kala=76 OR T.code_kala=77 OR T.code_kala=78 OR T.code_kala=79 OR T.code_kala=92)";
		    }	
			if($x=="14")//گوسفند داخلی
			{
			 $kalaCondition=" AND (T.code_kala=144 OR T.code_kala=148 OR T.code_kala=149 OR T.code_kala=150 OR T.code_kala=151 OR T.code_kala=88 OR T.code_kala=206 OR T.code_kala=207 OR T.code_kala=208 OR T.code_kala=209 OR T.code_kala=210 OR T.code_kala=41 OR T.code_kala=42 OR T.code_kala=43 OR T.code_kala=44 OR T.code_kala=45)";
		    }
			if($x=="15")//گوسفند وارداتی
			{$kalaCondition="AND (T.code_kala=87 OR  T.code_kala=113 OR T.code_kala=173 OR T.code_kala=174 OR T.code_kala=60 OR T.code_kala=61 OR T.code_kala=62 OR T.code_kala=63 OR T.code_kala=64)";}
			if($x=="17")//مرغ داخلی
			{
			 $kalaCondition=" AND (T.code_kala=38 OR T.code_kala=401 OR T.code_kala=402 OR T.code_kala=403 OR T.code_kala=404 OR T.code_kala=410 OR T.code_kala=411 OR T.code_kala=412 OR T.code_kala=197 OR T.code_kala=198 OR T.code_kala=413 OR T.code_kala=414 OR T.code_kala=415 OR T.code_kala=416)";
			}
			if($x=="18")//مرغ وارداتی
			{
			 $kalaCondition=" AND (T.code_kala=154 OR T.code_kala=91)";
			}
			if($x=="20")//کنسرو مرغ داخلی
			{
			 $kalaCondition=" AND (T.code_kala=406 OR T.code_kala=407)";
			}
			if($x=="21")//کنسرو مرغ وارداتی
			{$kalaCondition="and 1!=1";;
			}
		   }
			   //مجموع موجودی هر کالا در هر استان
			   if($noe_namayesh==1)//درحالت خالص
	           {
			     $mojodyKhalesAval=$db->get_from_where("SUM(mojody_khales_aval)","$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 $kalaCondition and($Condition_anbar)");        				   
				 $jameKhalesVarede=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
				 $jameKhalesSadere=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
			     $KhalesTadil_Ezafe=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
			     $KhalesTadil_Kasry=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
			     $mojodyKalaOstan=$mojodyKhalesAval+$jameKhalesVarede-$jameKhalesSadere+$KhalesTadil_Ezafe-$KhalesTadil_Kasry;			   			   			  		   
			   }
			   if($noe_namayesh==2)//درحالت ناخالص
	           {
			     $mojodyNaKhalesAval=$db->get_from_where("SUM(mojody_nakhales_aval)","$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 $kalaCondition and($Condition_anbar)");        	
			     $jameNakhalesVarede=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
			     $jameNakhalesSadere=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
			     $NakhalesTadil_Ezafe=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
			     $NakhalesTadil_Kasry=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
                 $mojodyKalaOstan=$mojodyNaKhalesAval+$jameNakhalesVarede-$jameNakhalesSadere+$NakhalesTadil_Ezafe-$NakhalesTadil_Kasry;			   
			   }
			   if($noe_namayesh==3)//درحالت تعداد کارتن
	           {
			     $tedadKartonAval=$db->get_from_where("SUM(tedad_karton_aval)","$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 $kalaCondition and($Condition_anbar)");        				   
			     $jameKartonVarede=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
			     $jameKartonSadere=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year  INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
			     $kartonTadil_Ezafe=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
			     $kartonTadil_Kasry=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition and($Condition_anbar) $Condition_info");
                 $mojodyKalaOstan=$tedadKartonAval+$jameKartonVarede-$jameKartonSadere+$kartonTadil_Ezafe-$kartonTadil_Kasry;			   
			   }   
			   if($x_value!="جمع")
			   {
			     echo '<td>'.round($mojodyKalaOstan,3).'</td>';
			     $jame_mojody_ostan+=$mojodyKalaOstan;
			     //محاسبه مجموع مقادیر در سطر آخر
				 if($x=="11")$jame_mojody_gavdakeli+=$mojodyKalaOstan;
			     if($x=="12")$jame_mojody_gavvaredati+=$mojodyKalaOstan;
			     if(($x=="11")OR($x=="12"))$jame_mojody_gav+=$mojodyKalaOstan;
			     if($x=="14")$jame_mojody_gosfanddakeli+=$mojodyKalaOstan;
			     if($x=="15")$jame_mojody_gosfandvaredati+=$mojodyKalaOstan;
				 if(($x=="14")OR($x=="15"))$jame_mojody_gosfand+=$mojodyKalaOstan;
			     if($x=="17")$jame_mojody_morghdakeli+=$mojodyKalaOstan;
			     if($x=="18")$jame_mojody_morghvaredati+=$mojodyKalaOstan;
				 if(($x=="17")OR($x=="18"))$jame_mojody_morgh+=$mojodyKalaOstan;
				 if($x=="20")$jame_mojody_konservdakeli+=$mojodyKalaOstan;
			     if($x=="21")$jame_mojody_konservvaredati+=$mojodyKalaOstan;
				 if(($x=="20")OR($x=="21"))$jame_mojody_konserv+=$mojodyKalaOstan;
			   }
			   if($x_value=="جمع")
			   {
				 echo '<td>'.round($jame_mojody_ostan,3).'</td>';
				 $jame_mojody_ostan=0;
               } 
		  }//END foreach		
		 echo'
	  </tr>';
	  /*****تکرار سرصفحه و ستون ها*****/
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
	 }//END WHILE
	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;"" >
	  <td colspan="2">جمع کل</td>
	  <td>'.round($jame_mojody_gavdakeli,3).'</td>
	  <td>'.round($jame_mojody_gavvaredati,3).'</td>
	  <td>'.round($jame_mojody_gav,3).'</td>
	  <td>'.round($jame_mojody_gosfanddakeli,3).'</td>
	  <td>'.round($jame_mojody_gosfandvaredati,3).'</td>
	  <td>'.round($jame_mojody_gosfand,3).'</td>
	  <td>'.round($jame_mojody_morghdakeli,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati,3).'</td>
	  <td>'.round($jame_mojody_morgh,3).'</td>
  	  <td>'.round($jame_mojody_konservdakeli,3).'</td>
	  <td>'.round($jame_mojody_konservvaredati,3).'</td>
	  <td>'.round($jame_mojody_konserv,3).'</td>
	 </tr>';
	 $sum_gosht=$jame_mojody_gav+$jame_mojody_gosfand;
	 echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;"><td colspan="14" align="right">&nbsp;&nbsp;&nbsp; مجموع گوشت قرمز : '.round($sum_gosht,3).'</td></tr>
	 <tr class="print_table-even sum-row" style="background-color:#FFF;"><td colspan="14" align="right">&nbsp;&nbsp;&nbsp; مجموع گوشت مرغ : '.round($jame_mojody_morgh,3).'</td></tr>
	 <tr class="print_table-even sum-row" style="background-color:#FFF;"><td colspan="14" align="right">&nbsp;&nbsp;&nbsp; مجموع کنسرو مرغ : '.round($jame_mojody_konserv,3).'</td></tr>
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنوس-->';
  require_once('prt-footer.php');
 echo' 
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