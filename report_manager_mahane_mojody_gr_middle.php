<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mahane_mojody_gr_middle.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش موجودی ماهانه (گروه کالا میانی)';
require_once('head.html');

/**************انتخاب گروه کالا****************/
if(is_array($groupkala_middle_choice))
{
 foreach($groupkala_middle_choice as $key_grp => $grp_val) {
  $Condition_Gkala.=" code_group_kala_middle='$grp_val' OR";
 }
  if($grp_val==-1) $Condition_gr_k.="";
  else $Condition_gr_k.=" and $Condition_Gkala";
  $lastSpacePosition = strrpos($Condition_gr_k," ");
  $Condition_gr_k =substr($Condition_gr_k,0,$lastSpacePosition);
}
/****************هدر******************/
$columns='
    <tr class="print_table-title2">
     <td width="5%">ردیف</td>
     <td width="15%">ماه</td>';
	 $q_grkala="SELECT code_group_kala_middle,name_group_kala_middle FROM group_kala_middle WHERE 1=1 $Condition_gr_k  ORDER BY name_group_kala_middle";
	 $res_grkala=$db->query($q_grkala);
	 while($row_grkala=$db->fetch_assoc($res_grkala))//grkala WHILE	
	 {$columns.='<td>'.$row_grkala['name_group_kala_middle'].'</td>';}
	  $columns.='
	</tr>';
Function print_header()
{global $titr,$mtActiveYear,$mt_gl_owner,$FileName,$page,$db;
 echo'
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" >
    <tr class="noExl"><td class="print_title_2" colspan="56">'.$mt_gl_owner.'</td></tr>
	<tr>
	  <td class="print_title_2" colspan="56">'.$titr.' سال '.$mtActiveYear.'
	  <span style="float:left;"><button  class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></span>
	 </td>
	</tr>
	<tr '; IF($page!=1) echo 'class="noExl"'; echo'>
	 <td class="print_title_2" colspan="56">';
	   IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
	   }
	   echo'
	  </td>
	 </tr>';
}	
/****************فیلترها روی گزارش******************/
if($code_bastebandy)     $Condition_bastebandy.=" AND kala.code_bastebandy LIKE '$code_bastebandy'";

/*******استان ها*******/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
 if(is_array($ostanchoice))//کد های استان
 {
   foreach($ostanchoice as $key => $val ) 
   {
     $Condition_ostan_temp.=" T.code_ostan='$val' OR";
     $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='$val'");//تبدیل کد به آی دی
     $Condition_ostan_temp_sell.=" dm_havale.h_id_province='$sell_id_ostan' OR";
	 $Condition_ostan_ebtal_temp_sell.=" dm_his_havale.his_id_province='$sell_id_ostan' OR";
   }
   if($val==-1){$Condition_ostan.="1=1 OR";$Condition_ostan_sell.="1=1 OR";$Condition_ostan_ebtal_sell.="1=1 OR";}
   else {$Condition_ostan.=" $Condition_ostan_temp";$Condition_ostan_sell.=" $Condition_ostan_temp_sell";$Condition_ostan_ebtal_sell.=" $Condition_ostan_ebtal_temp_sell";}
     $lastSpacePosition = strrpos($Condition_ostan," ");
     $lastSpacePosition_sell = strrpos($Condition_ostan_sell," ");
     $lastSpacePosition_ebtal_sell = strrpos($Condition_ostan_ebtal_sell," ");
     $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     $Condition_ostan_sell =substr($Condition_ostan_sell,0,$lastSpacePosition_sell);
     $Condition_ostan_ebtal_sell =substr($Condition_ostan_ebtal_sell,0,$lastSpacePosition_ebtal_sell);    
 }
}
else 
{
	  $Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';
	  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='".$_SESSION['mt_code_ostan']."'");//تبدیل کد به آی دی
	  $Condition_ostan_sell=' dm_havale.h_id_province='.$sell_id_ostan.'';
	  $Condition_ostan_ebtal_sell=' dm_his_havale.his_id_province='.$sell_id_ostan.'';
}
/******انبارها******/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
	 $Condition_anbar_ebtal_sell.="  $Condition_anbar_ebtal_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $lastSpacePosition_ebtal_sell = strrpos($Condition_anbar_ebtal_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
     $Condition_anbar_ebtal_sell =substr($Condition_anbar_ebtal_sell,0,$lastSpacePosition_ebtal_sell);
}

/******************نمایش یا عدم نمایش انبارهای موقت******************/
// if($chkmovaghat=='on') {$Condition_movaghat="";$Condition_movaghat_mj="";}
// else {$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_a.situation_type=1 AND";}
/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
if($show_movaghat==1){$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_a.situation_type=1 AND";}
else if($show_movaghat==2){$Condition_movaghat="";$Condition_movaghat_mj="";}
else if($show_movaghat==3){$Condition_movaghat="list_sardkhane.situation_type=2 AND ";$Condition_movaghat_mj="";}//خودش موقت ولی مقصد هر انباری
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_mj="";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND"; $Condition_anbar_activate_mj="l_a.activate=1 AND"; }
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=15; 
if(!$ok)
{
echo'
<table width="95%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="750px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1"> 
	 <td align="left" height="40px">گروه کالا (میانی) : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="groupkala_middle_choice[]" class="easyui-combobox text4" style="width:200px;" multiple>';
	   $result_gr_kala = $db->query("SELECT * FROM group_kala_middle ORDER BY name_group_kala_middle");
       $gr_kala_options = "<option value='-1' selected>همه کالاها</option>";
       while($row_gr_kala=$db->fetch_assoc($result_gr_kala)) $gr_kala_options .= "<option value=".$row_gr_kala['code_group_kala_middle'].">".$row_gr_kala['name_group_kala_middle']."</option>";
	   echo $gr_kala_options;
	   echo'
	   </select>
	 </td>
	</tr>
    <tr class="tr1" >
		 <td align="left"  height="40px"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>	
         <td align="left"> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","","class='easyui-combobox text4' style=width:100px ").'</td>	 
	</tr>
	<tr class="tr1" >
	 <!--<td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; همراه با اطلاعات انبار موقت </td>-->
     <td align="left" height="40px"> وضعیت نمایش سردخانه های موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='text4'").'</td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
	<tr class="tr1"> 
	 <td align="left" height="40px"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>';
	 if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox text4" style="width:200px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>
	  </td>';
	}
	else echo'<td colspan="2"></td>';
	echo'
	</tr>
	<tr class="footer">	
	 <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
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
	 IF($mtActiveYear==$yy) $conditon=" AND code_mah<=$mm ";
	 echo'
     <br/>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if(($ostanchoice))
	 {
	      if($ostan_val==-1)$filter_string='همه استانها';
	      else $filter_string=' استان : ';
	      foreach($ostanchoice as $ostan_key => $ostan_val) {
	       $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	       $filter_string.=''.$nameOstan.'&nbsp;';
          }
	 }
     if($show_movaghat==1) $filter_string.=' بدون اطلاعات سردخانه موقت';
     else if($show_movaghat==2) $filter_string.=' با اطلاعات سردخانه موقت';
     else if($show_movaghat==3) $filter_string.=' فقط اطلاعات سردخانه موقت';
     if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
     if($noe_namayesh==1) $filter_string.=" نمایش اطلاعات : خالص";
     if($noe_namayesh==2) $filter_string.=" نمایش اطلاعات : ناخالص";
     if($noe_namayesh==3) $filter_string.=" نمایش اطلاعات : تعداد";
	 IF($code_bastebandy)
	 {		
	   $sharhBastebandy=$db->get_from_where("sharh_bastebandy","bastebandy","code_bastebandy='$code_bastebandy'"); 
	   $filter_string.=' بسته بندی '.$sharhBastebandy.'';
	 }
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 
	 IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';$vahed='کیلوگرم';}
	 ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';$vahed='کیلوگرم';}
	 ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';$vahed='تعداد';}				 
	 ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';$vahed='شانه';}				 
     
	
	 $q="SELECT * FROM mah_shamsi WHERE 1=1 $conditon ORDER BY code_mah";
     $res=$db->query($q);
	 while($row=$db->fetch_array($res))//mah while
	 { 
	   $line++;
       if($i++%2)echo'<tr class="print_table-odd">';
       else echo'<tr class="print_table-even">';
	   echo'   
		 <td>'.$radif++.'</td>
	     <td>'.$row['sharh_mah'].'</td>'; 
		$q_grkala="SELECT code_group_kala_middle,name_group_kala_middle FROM group_kala_middle WHERE 1=1 $Condition_gr_k  ORDER BY name_group_kala_middle";
	    $res_grkala=$db->query($q_grkala);
	    $count_gr =mysql_num_rows($res_grkala);
		
		$max_gr_array=array();
	    while($row_grkala=$db->fetch_assoc($res_grkala))//grkala WHILE	
	    {	
		  $mojodyAval=0;
		  $jameVarede=0;
		  $jameSadere=0;
		  $Tadil_Ezafe=0;
		  $Tadil_Kasry=0;
		  $mojody=0;
		  
		  $mojodyAval =$db->get_from_where("SUM($avalField)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat      T.year='$mtActiveYear' AND deleted=0  AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']."  AND($Condition_ostan)  $Condition_bastebandy");        				   
		  $jameVarede =$db->get_from_where("SUM($residField)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat    T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.status=0  AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']." AND SUBSTRING(tarikh_resid,6,2)<=".$row['code_mah']." AND($Condition_ostan)  $Condition_bastebandy");
		  $jameSadere =$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat    T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']." AND SUBSTRING(tarikh_havale_anbar,6,2)<=".$row['code_mah']." AND($Condition_ostan)  $Condition_bastebandy");
		  $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=1  AND T.year='$mtActiveYear' AND deleted=0  AND status=0  AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']." AND SUBSTRING(tarikh_barge_tadil,6,2)<=".$row['code_mah']." AND($Condition_ostan)  $Condition_bastebandy");
		  $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=2  AND T.year='$mtActiveYear' AND deleted=0  AND status=0  AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']." AND SUBSTRING(tarikh_barge_tadil,6,2)<=".$row['code_mah']." AND($Condition_ostan)  $Condition_bastebandy");
		  //جمع 
	      $mojody=$mojodyAval+$jameVarede-$jameSadere+$Tadil_Ezafe-$Tadil_Kasry;
		  //IF($mojody=='-0') $mojody=0;
		 //نمایش اطلاعات
		 echo' <td >'.round($mojody,3).'</td>';
         
		 // $max_gr_array1=array(
		 		   // $row_grkala['code_group_kala_middle'] => $mojody );
		 // //print_r($max_gr_array1);
		 // array_push($max_gr_array,$max_gr_array1);
		 // $encodedData = json_encode($params);
         // print_r($max_gr_array);
		 //echo '<br>';		
        
		 
		}//END group_kala while

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
	 }//END mah while
	 // /*****سطر جمع کل *****/
	 // echo'
	 // <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  // <td colspan="2">جمع کل (کیلوگرم)</td>';
	 // $q_grkala="SELECT code_group_kala_middle,name_group_kala_middle FROM group_kala_middle WHERE 1=1 $Condition_gr_k  ORDER BY name_group_kala_middle";
	 // $res_grkala=$db->query($q_grkala);
	 // $count_gr =mysql_num_rows($res_grkala);
	 // while($row_grkala=$db->fetch_assoc($res_grkala))//grkala WHILE	
	    // {	
	
		  // $majmo_mojodyAval=0;
		  // $majmo_jameVarede=0;
		  // $majmo_jameSadere=0;
		  // $majmo_Tadil_Ezafe=0;
		  // $majmo_Tadil_Kasry=0;
		  // $majmo_mojody=0;
		  // $majmo_mojodyAval=$db->get_from_where("SUM($avalField)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat      T.year='$mtActiveYear' AND deleted=0   AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']." AND($Condition_ostan) $Condition_bastebandy");        				   
		  // $majmo_jameVarede=$db->get_from_where("SUM($residField)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat   T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']." AND($Condition_ostan) $Condition_bastebandy");
		  // $majmo_jameSadere=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat   T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']." AND($Condition_ostan) $Condition_bastebandy");
		  // $majmo_Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=1  AND T.year='$mtActiveYear' AND deleted=0  AND status=0  AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']."  AND($Condition_ostan)  $Condition_bastebandy");
		  // $majmo_Tadil_Kasry=$db->get_from_where("SUM($tadilField)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=1  AND T.year='$mtActiveYear' AND deleted=0  AND status=0  AND code_group_kala_middle=".$row_grkala['code_group_kala_middle']."  AND($Condition_ostan)  $Condition_bastebandy");
		  // //جمع 
		  // $majmo_mojody=$majmo_mojodyAval+$majmo_jameVarede-$majmo_jameSadere+$majmo_Tadil_Ezafe-$majmo_Tadil_Kasry;
		 
		 // //نمایش اطلاعات
		 // echo' <td >'.round($majmo_mojody,3).'</td>'; 
		// }//END group_kala while 
	 // echo'
	 // </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
   <tr class="print_footer noExl">
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
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
   function doNow(ch)
   { if(ch=="on") ck=1; else ck=0;
   void(d=document);
   void(el=d.getElementsByTagName("INPUT"));
   for(i=0;i<el.length;i++)
   void(el[i].checked=ck)
   if(ch=="on") ch="off"; else if(ch=="off")ch="on";
   return ch;
   }
$(function(){	    
	  //نمایش ستونها
	  $("input:checkbox:not(:checked)").each(function() {
       var column = "table ." + $(this).attr("name");
       $(column).hide();
      });
      $("input:checkbox").click(function(){
       var column = "table ." + $(this).attr("name");
       $(column).toggle();
      });  
});
</script> 