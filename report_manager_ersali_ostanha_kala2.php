<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_ersali_ostanha_kala.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش مقادیر ارسالی استانها به تفکیک کالا';
require_once('head.html'); 
/****************فیلترها روی گزارش******************/
/************************استان های ارسال کننده******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice_row))//کد های استان ارسال کننده
     {
       foreach($ostanchoice_row as $ostan_key => $ostan_val_row) 
      {
       $Condition_ostan_row_temp.=" T.code_ostan='$ostan_val_row' OR";
      }
      if($ostan_val_row==-1){$Condition_ostan_row.="1=1 OR";}
      else {$Condition_ostan_row.=" $Condition_ostan_row_temp";}
       $lastSpacePosition = strrpos($Condition_ostan_row," ");
       $Condition_ostan_row =substr($Condition_ostan_row,0,$lastSpacePosition);
     }
}
else 
{
 $Condition_ostan_row=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';

}
/************************استان های دریافت کننده******************/
if(is_array($ostanchoice_col))//کد های استان دریافت کننده
{
       foreach($ostanchoice_col as $ostan_key => $ostan_val_col ) 
      {
       $Condition_ostan_col_temp.=" T.code_ostan='$ostan_val_col' OR";
      }
      if($ostan_val_col==-1){$Condition_ostan_col.="1=1 OR";}
      else {$Condition_ostan_col.=" $Condition_ostan_col_temp";}
       $lastSpacePosition = strrpos($Condition_ostan_col," ");
       $Condition_ostan_col =substr($Condition_ostan_col,0,$lastSpacePosition);
}
/*****************************انبارها****************************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_ebtal='1=1';$Condition_anbar_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
   $Condition_anbar_ebtal_temp.=" ebtal.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_ebtal.="  $Condition_anbar_ebtal_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_ebtal = strrpos($Condition_anbar_ebtal," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     $Condition_anbar_ebtal =substr($Condition_anbar_ebtal,0,$lastSpacePosition_ebtal);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
}
/**************انتخاب گروه کالا****************/
if(is_array($groupkalachoice))
{
 $grpkalaArrChoice=array();//کالاهای انتخاب شده داخل این آرایه قرار میگیرد
 foreach($groupkalachoice as $grp_val) 
 {
  if($grp_val=='همه'){$grpkalaArrChoice=array();$grpkalaArrChoice=$kalagroupArr;break;}
  else array_push($grpkalaArrChoice,$grp_val);
 }
}
/**************انتخاب کد کالا****************/
if(is_array($kalachoice))
{
  foreach($kalachoice as $key_kala => $kala_val) {
  $Condition_kala_temp.=" code_kala='$kala_val' OR";
 }
 if($kala_val==-1)$Condition_kala.="1=1 OR";
 else $Condition_kala.=" $Condition_kala_temp";
 $lastSpacePosition = strrpos($Condition_kala," ");
 $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
}
/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
if($show_movaghat==1){$Condition_movaghat="list_sardkhane.situation_type=1 AND ";}
else if($show_movaghat==2){$Condition_movaghat="";}
else if($show_movaghat==3){$Condition_movaghat="list_sardkhane.situation_type=2 AND ";}
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate="";  $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND";  $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=5;
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)$date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
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
<table width="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="800px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px">
     <td align="left" width="180px"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>	
     <td align="left" width="110px"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1" style="height:45px">
	 <td align="left"> وضعیت نمایش سردخانه های موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='easyui-combobox text4' data-options=panelHeight:100").'</td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
    <tr class="tr1">
		 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>	
    	 <td align="left"> تعداد استان در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1" style="height:45px">';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	  echo'
	   <td align="left">استان ارسال کننده : </td>
       <td align="right">
	    &nbsp;<select name="ostanchoice_row[]" class="easyui-combobox text4" size="4" style="width:200px;" multiple>';
	    $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
        $ostan_options = "<option value='-1' selected>همه استانها</option>";
        while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	    echo $ostan_options;
	    echo'
	    </select>
	   </td>
	   <td align="left">استان دریافت کننده : </td>
       <td align="right">';
	}
	else
	echo'<td align="left">استان دریافت کننده : </td><td colspan="3" align="right">';
    echo'
	    &nbsp;<select name="ostanchoice_col[]" class="easyui-combobox text4" size="4" style="width:200px;" multiple>';
	    $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
        $ostan_options = "<option value='-1' selected>همه استانها</option>";
        while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	    echo $ostan_options;
	    echo'
	    </select>
	   </td>
	</tr>
	<tr class="tr1" style="height:45px">
     <td align="left">نام کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="kalachoice[]" class="easyui-combobox" size="6" style="width:330px;" multiple>';
	  $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']." (".$row_kala['code_kala'].")</option>";
	  echo $kala_options;
	  echo'
	  </select>
     </td>
	</tr>	
	<tr class="footer"><td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
  </td>
 </tr>
</table> ';
}
else
{  
/****************شروع نمایش گزارش*******************/	
$radif=1;
$page=1;
$line=0;
$i=0;
$cntr=0;
//تعیین فیلدها براساس نوع نمایش
IF($noe_namayesh==1){$havaleField='vazn_khales_h_d';}
ELSE IF($noe_namayesh==2){$havaleField='vazn_nakhales_h_d';}
ELSE IF($noe_namayesh==3){$havaleField='tedad_karton_h_d';}
ELSE IF($noe_namayesh==4){$havaleField='tedad_shane_h_d';}
$count_ostan_col=$db->get_from_where("count(code_ostan)","ostan T","1=1 AND($Condition_ostan_col)");
$columns='
    <tr class="print_table-title2">
     <td width="%" rowspan="2">ردیف</td>
     <td width="%" rowspan="2">استان ارسال کننده</td>
	 <td width="%" rowspan="2">کد کالا</td>
	 <td width="%" rowspan="2">نام کالا</td>
	 <td width="%" colspan="'.$count_ostan_col.'">استان دریافت کننده- واحد:کیلوگرم</td>
	 <td width="%" rowspan="2">جمع کل دریافتی</td>
	</tr>
	<tr class="print_table-title2">';
	 $q_column="SELECT name_ostan FROM ostan T WHERE 1=1 AND($Condition_ostan_col) ORDER BY name_ostan";
	 $res_column=$db->query($q_column);
	 while($column=$db->fetch_assoc($res_column))
	 {$columns.='<td >'.$column['name_ostan'].'</td>';}
	  $columns.='
	</tr>'; 
Function print_header()
{global $titr,$columns,$mt_gl_owner,$date1,$date2,$code_anbar,$FileName,$page;
  echo'   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
	   <tr class="noExl"><td class="print_title_2">'.$titr.' - واحد کالا : (کیلوگرم)</td></tr>
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
//$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan) AND($Condition_ostan_row) ORDER BY name_ostan";
$q="SELECT * FROM ostan T WHERE 1=1 AND($Condition_ostan_row) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
 <br/>
 <div class="table2excel">';
  print_header();
  /*سطر نمایش فیلترها*/
  if(is_array($ostanchoice_row))
  {
	  $filter_string='استان ارسال کننده :';
	  if($ostan_val_row==-1)$filter_string.='همه استانها';
	  foreach($ostanchoice_row as $ostan_key => $ostan_val_row) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val_row'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
  }
  if(is_array($ostanchoice_col))
  {
	  $filter_string.='- استان دریافت کننده:';
	  if($ostan_val_col==-1)$filter_string.='همه استانها';
	  foreach($ostanchoice_col as $ostan_key => $ostan_val_col) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val_col'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
  }
  if($show_movaghat==1) $filter_string.=' بدون اطلاعات سردخانه موقت -';
  else if($show_movaghat==2) $filter_string.=' با اطلاعات سردخانه موقت -';
  else if($show_movaghat==3) $filter_string.=' فقط اطلاعات سردخانه موقت -';
  if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
  if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال-';
  if(is_array($kalachoice))
  {
	  if($kala_val==-1)$filter_string.=' همه کالاها';
	  else $filter_string.=' کالا : ';
	  foreach($kalachoice as $key_kala => $kala_val) {
	  $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
	  $filter_string.=''.$nameKala.'&nbsp;';
      }
  }
  if($noe_namayesh) {$filter_string.=' نوع نمایش براساس : '.$namayeshArr[$noe_namayesh].'&nbsp;';}     
  echo'<tr class="noExl"><td class="filter_text" colspan="50">
  راهنما : مقادیر این گزارش مجموع حواله هایی است که در استان ارسال کننده به مقصد استان دریافت کننده ثبت شده است .
  </td></tr>';
  echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
  echo $columns;
  while($row=$db->fetch_array($res))//OSTAN WHILE IN ROW
 {	  
   $line++;
   //$rowkala=count($grpkalaArrChoice);
   //$rowkala=count($kalachoice);
   $q_kala="SELECT code_kala,name_kala FROM kala WHERE 1=1 AND($Condition_kala) ORDER BY name_kala";
   $res_kala=$db->query($q_kala);
   $rowkala=$db->num_rows($res_kala);//تعداد کالاهای انتخابی
   $t=$rowkala;
   if($i++%2)echo'<tr class="print_table-odd_small">';
   else echo'<tr class="print_table-even_small">';
   echo'   
   <td rowspan="'.$rowkala.'">'.$radif++.'</td>
   <td rowspan="'.$rowkala.'" >'.$row['name_ostan'].'</td>';
   //foreach($grpkalaArrChoice as $x => $x_value ) 
   //حلقه کالاها در هر سطر
   //foreach($kalachoice as $x => $x_value) 
    while($row_kala=$db->fetch_assoc($res_kala))//kala WHILE	
	{	
	 $j=$i+1;
	 echo'
	 <!--<td>'.$x_value.'</td>-->
	 <td>'.$row_kala['code_kala'].'</td>
	 <td>'.$row_kala['name_kala'].'</td>';
	 $jame_meghdar_jabejae=0;//جمع دریافتی هر کالا در هر استان
     //حلقه استانها در ستونها
	 $q_column="SELECT code_ostan FROM ostan T WHERE 1=1 AND($Condition_ostan_col) ORDER BY name_ostan";
	 $res_column=$db->query($q_column);
	 while($column=$db->fetch_assoc($res_column))
	 {
	  $meghdar_jabejae=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.mojavez_jabejae m_j ON m_j.shomare_jabejae=h.shomare_jabejae AND m_j.code_ostan=h.code_ostan AND m_j.code_anbar=h.code_anbar AND m_j.year=h.year","$Condition_movaghat $Condition_anbar_activate T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND code_ostan_maghsad_j=".$column['code_ostan']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_havale_anbar>='".$date1."' AND tarikh_havale_anbar<='".$date2."' AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND($Condition_anbar)");     
	  echo'<td >'.round($meghdar_jabejae,3).'</td>'; 
	  $jame_meghdar_jabejae+=$meghdar_jabejae;//جمع دریافتی هر کالا در هر استان  

	 }//END WHILE OSTAN IN column
	 echo'<td>'.round($jame_meghdar_jabejae,3).'</td>'; 

	 $t--;
	 if($t==0) echo'';
	 else 
	 {
		 echo'</tr>';
		 if($j++%2)echo'<tr class="print_table-odd_small">';
         else echo'<tr class="print_table-even_small">';
	 }
	 $jame_mande_befor_dakheli+=$mande_befor_dakheli;	
   }//END KALA WHILE
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
 }//END WHILE OSTAN IN row
 /*****سطر جمع کل استان ها*****/
   echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	    <td colspan="4">جمع کل ارسالی</td>';
		$res_column=$db->query($q_column);
		while($column=$db->fetch_assoc($res_column))
	    {
		 $sum_meghdar_jabejae=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN mojavez_jabejae m_j ON m_j.shomare_jabejae=h.shomare_jabejae AND m_j.code_ostan=h.code_ostan AND m_j.code_anbar=h.code_anbar AND m_j.year=h.year","$Condition_movaghat $Condition_anbar_activate T.year='$mtActiveYear' AND code_ostan_maghsad_j=".$column['code_ostan']." AND tarikh_havale_anbar>='".$date1."' AND tarikh_havale_anbar<='".$date2."' AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND($Condition_ostan_row) AND ($Condition_kala) AND ($Condition_anbar)");     
		 echo'<td >'.round($sum_meghdar_jabejae,3).'</td>'; 
	     $sum_meghdar_jabejae_kol+=$sum_meghdar_jabejae;//جمع دریافتی هر کالا در هر استان  
        
	    }
	   echo'<td>'.round($sum_meghdar_jabejae_kol,3).'</td>
	 </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
   <tr class="print_footer noExl">
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
 }//END IF//وجود اطلاعات
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