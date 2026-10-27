<?php
//این گزارش برای سایر کاربران در لوکال به خاطر وجود کوئری های فروش اررور دارد در هاست درست است
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_rozane.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش سری زمانی مانده موجودی گروه کالا ';
require_once('head.html');
if($noe_namayesh==1)$str='(خالص)';
if($noe_namayesh==2)$str='(ناخالص)';
if($noe_namayesh==3)$str='(کارتن)';
$columns='
	<tr class="print_table-title2">
	 <td width=20%>تاریخ</td>
	 <td width=30% class="mojodyebtedaPr">مانده موجودی ابتدای دوره '.$str.'</td>
	 <td width=30% class="mojodyentehaPr">مانده موجودی در پایان دوره '.$str.'</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$code_kala,$code_anbar,$date1,$date2,$FileName,$nameKala,$page,$noe_namayesh;
  echo'
   <br>   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> '.$titr.' '.$nameKala.' </td></tr>
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
	   </tr>';
       echo'
      </table>
	 </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=15;
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
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
 <table width="85%" align="center" cellpadding="0" cellspacing="0">
 <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
   <td height="100%">
    <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
	 <tr class="tr1" style="height:45px">
     <td align="left">گروه کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="grkalachoice[]" class="easyui-combobox" size="6" style="width:150px;" >';
	  $result_grkala = $db->query("SELECT * FROM bzacc.group_kala_top WHERE group_type_top=2");
      //$grkala_options = "<option value='-1' selected>همه</option>";
      while($row_grkala=$db->fetch_assoc($result_grkala)) $grkala_options .= "<option value=".$row_grkala['code_group_kala_top'].">".$row_grkala['name_group_kala_top']."</option>";
	  echo $grkala_options;
	  echo'
	  </select>
	 </td>
	</tr>
     <tr class="tr1">	
      <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	</tr>
    <tr class="tr1">
	  <td align="left" height="40px"> نمایش اطلاعات :&nbsp;</td><td align="right">'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:100").'</td>	
      <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; همراه با اطلاعات سردخانه موقت </td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>';
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left" height="40px">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" size="6" style="width:200px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>      
	  </td>
	 </tr>'; 
	 }
	 echo'
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    </table>
   </td>
  </tr>
 </table>';
}
else
{
    //$codeBastebandy=$db->get_from_where("code_bastebandy","$mydatabase.kala","code_kala=$code_kala");
	//if(!$code_kala){echo"<script>alert('لطفاً کد کالا را وارد کنید !')</script>";
                    //echo"<script>window.location='$FileName';</script>";}
    //$nameKala=$db->get_from_where("name_kala","$mydatabase.kala","code_kala='$code_kala'");
   /**************انتخاب گروه کالا****************/
   if(is_array($grkalachoice))
   {
    foreach($grkalachoice as $grkala_key => $grkala_val) {
     $Condition_grkala_temp.=" code_group_kala_top='$grkala_val' OR";
    }
     if($grkala_val==-1)$Condition_grkala.="1=1 OR";
     else $Condition_grkala.=" $Condition_grkala_temp";
    $lastSpacePosition = strrpos($Condition_grkala," ");
    $Condition_grkala =substr($Condition_grkala,0,$lastSpacePosition);
   }
   //تبدیل تاریخ شمسی به میلادی
     $sql_tarikh1=$date1;//تاریخ اول
       $d1=substr($sql_tarikh1,8,2);
       $m1=substr($sql_tarikh1,5,2);
       $y1=substr($sql_tarikh1,0,4);
       $milady1=jalali_to_gregorian($y1,$m1,$d1);
       $sal1=$milady1[0];
       $mah1=$milady1[1];
       $rouz1=$milady1[2];
       $date1_milady=$sal1.'-'.$mah1.'-'.$rouz1;
    $sql_tarikh2=$date2;//تاریخ دوم
       $d2=substr($sql_tarikh2,8,2);  
       $m2=substr($sql_tarikh2,5,2);
       $y2=substr($sql_tarikh2,0,4);
       $milady2=jalali_to_gregorian($y2,$m2,$d2);
       $sal2=$milady2[0];
       $mah2=$milady2[1];
       $rouz2=$milady2[2];
       $date2_milady=$sal2.'-'.$mah2.'-'.$rouz2;
	/****************فیلترها روی گزارش******************/
     //استان ها
	 if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
     {  
       if(is_array($ostanchoice))//کد های استان
       {
         foreach($ostanchoice as $key => $val ) 
		 {          		  
		  $Condition_ostan_temp.=" T.code_ostan='$val' OR";
		  //$Condition_ostan_resid_temp.=" T.code_ostan='$val' OR";
		  //$Condition_ostan_havale_temp.=" T.code_ostan='$val' OR";
		  $Condition_ostan_ebtal_temp.=" ebtal.code_ostan='$val' OR";
		  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='$val'");//تبدیل کد به آی دی
		  $Condition_ostan_temp_sell.=" dm_havale.h_id_province='$sell_id_ostan' OR";
		  $Condition_ostan_ebtal_temp_sell.=" dm_his_havale.his_id_province='$sell_id_ostan' OR";
         }
		if($val==-1){$Condition_ostan.="1=1 OR";$Condition_ostan_resid.="1=1 OR";$Condition_ostan_havale.="1=1 OR";$Condition_ostan_ebtal.="1=1 OR";$Condition_ostan_sell.="1=1 OR";}
        else {$Condition_ostan.=" $Condition_ostan_temp";$Condition_ostan_resid.=" $Condition_ostan_resid_temp";$Condition_ostan_havale.=" $Condition_ostan_havale_temp";$Condition_ostan_ebtal.=" $Condition_ostan_ebtal_temp";$Condition_ostan_sell.=" $Condition_ostan_temp_sell";}
        $lastSpacePosition = strrpos($Condition_ostan," ");
        //$lastSpacePosition_resid = strrpos($Condition_ostan_resid," ");
        //$lastSpacePosition_havale = strrpos($Condition_ostan_havale," ");
        $lastSpacePosition_ebtal = strrpos($Condition_ostan_ebtal," ");
        $lastSpacePosition_sell = strrpos($Condition_ostan_sell," ");
        $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
        //$Condition_ostan_resid =substr($Condition_ostan_resid,0,$lastSpacePosition_resid);
        //$Condition_ostan_havale =substr($Condition_ostan_havale,0,$lastSpacePosition_havale);
        $Condition_ostan_ebtal =substr($Condition_ostan_ebtal,0,$lastSpacePosition_ebtal);
        $Condition_ostan_sell =substr($Condition_ostan_sell,0,$lastSpacePosition_sell);
       }
     }
     else 
	 {
	  $Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';
	  //$Condition_ostan_resid=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';
	  //$Condition_ostan_havale=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';
	  $Condition_ostan_ebtal=' ebtal.code_ostan='.$_SESSION['mt_code_ostan'].'';
	  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='".$_SESSION['mt_code_ostan']."'");//تبدیل کد به آی دی
	  $Condition_ostan_sell=' dm_havale.h_id_province='.$sell_id_ostan.'';
	 }
	 //انبارها
	 if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_resid='1=1';$Condition_anbar_havale='1=1';$Condition_anbar_ebtal='1=1';$Condition_anbar_sell='1=1';}
	 else //بقیه کاربران براساس انبار قابل دسترسیشان
	 {
	  $q2="SELECT * FROM $mydatabase.user_ostan_anbar INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat  list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
	  $res2=$db->query($q2);
	  while($row2=$db->fetch_assoc($res2))//انبارهای قابل دسترسی
	  {
		   $Condition_anbar_temp.=" T.code_anbar=".$row2['code_anbar']." OR";
		   //$Condition_anbar_resid_temp.=" T.code_anbar=".$row2['code_anbar']." OR";
		   //$Condition_anbar_havale_temp.=" T.code_anbar=".$row2['code_anbar']." OR";
		   $Condition_anbar_ebtal_temp.=" ebtal.code_anbar=".$row2['code_anbar']." OR";
		   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
		   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row2['code_anbar']."");//تبدیل کد به آی دی 
		   if($sell_id_anbar)//اگر نظیرش در فروش بود
		   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
		    $Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
	  }//end while
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
	 /******************نمایش یا عدم نمایش سردخانه های موقت******************/
     if($chkmovaghat=='on') $Condition_movaghat="";
     else $Condition_movaghat="situation_type=1 AND ";
	 /******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
     if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_sell="";}
     else {$Condition_anbar_activate="activate=1 AND";$Condition_anbar_activate_sell="activate=1 AND";}
/****************محاسبه مانده موجودی قبل از تاریخ برای اولین سطر*******************/		  
/****************حالت خالص*******************/		
	if($noe_namayesh==1)
	{
	  $mande=$db->get_from_where("SUM(mojody_khales_aval)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear'  AND deleted=0 AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");     
	  $jameKhalesVarede_befor=$db->get_from_where("SUM(vazn_khales_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	  $jameKhalesSadere_befor=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");	
	  $KhalesTadil_Ezafe_befor=$db->get_from_where("SUM(meghdar_khales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'".$date1."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala) AND($Condition_grkala)");
	  $KhalesTadil_Kasry_befor=$db->get_from_where("SUM(meghdar_khales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'".$date1."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	  $mande=$mande+$jameKhalesVarede_befor-$jameKhalesSadere_befor+$KhalesTadil_Ezafe_befor-$KhalesTadil_Kasry_befor;	
	}//END khales
/****************حالت ناخالص*******************/	  
	if($noe_namayesh==2)
	{
	  $mande=$db->get_from_where("SUM(mojody_nakhales_aval)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND deleted=0 AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");     
	  $jameNaKhalesVarede_befor=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	  $jameNaKhalesSadere_befor=$db->get_from_where("SUM(vazn_nakhales_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");	
	  $NaKhalesTadil_Ezafe_befor=$db->get_from_where("SUM(meghdar_nakhales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'".$date1."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	  $NaKhalesTadil_Kasry_befor=$db->get_from_where("SUM(meghdar_nakhales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'".$date1."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	  $mande=$mande+$jameNaKhalesVarede_befor-$jameNaKhalesSadere_befor+$NaKhalesTadil_Ezafe_befor-$NaKhalesTadil_Kasry_befor;	
	}//END Nakhales
/****************حالت کارتن*******************/	  
	if($noe_namayesh==3)
	{
	  $mande=$db->get_from_where("SUM(tedad_karton_aval)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND deleted=0 AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");     
	  $jameKartonVarede_befor=$db->get_from_where("SUM(tedad_karton_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	  $jameKartonSadere_befor=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");	
	  $kartonTadil_Ezafe_befor=$db->get_from_where("SUM(tedad_karton_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'".$date1."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	  $kartonTadil_Kasry_befor=$db->get_from_where("SUM(tedad_karton_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<'".$date1."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	  $mande=$mande+$jameKartonVarede_befor-$jameKartonSadere_befor+$kartonTadil_Ezafe_befor-$kartonTadil_Kasry_befor;	
	}//END Karton
	


/****************شروع نمایش گزارش*******************/	
    $db->selectDb($mydatabase);
	$page=1;
    $line=0;
    $i=0;
    if($noe_namayesh==1)$str='(خالص)';
    if($noe_namayesh==2)$str='(ناخالص)';
    if($noe_namayesh==3)$str='(تعداد)';
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if(($ostanchoice))
	 {
	  if($val==-1)$filter_string='همه استانها';
	  else $filter_string=' استان : ';
	  foreach($ostanchoice as $key => $val) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$val'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
	 }
	 if(is_array($grkalachoice))
     {
	  if($grkala_val==-1)$filter_string.=' همه کالاها';
	  else $filter_string.=' گروه کالا : ';
	  foreach($grkalachoice as $grkala_key => $grkala_val) {
	  $nameGrKala=$db->get_from_where("name_group_kala_top","bzacc.group_kala_top","code_group_kala_top='$grkala_val'");
	  $filter_string.=''.$nameGrKala.'&nbsp;';
      }
     }
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت';
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if($noe_namayesh) {$filter_string.=' نوع نمایش براساس : '.$namayeshArr[$noe_namayesh].'&nbsp;';}     
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 //حلقه روی تاریخ ها
	 $tarikh_milady=$date1_milady;
	 while($tarikh_milady<=$date2_milady)
	 {
	  //تبدیل تاریخ میلادی به شمسی
	  $sql_tarikh3=$tarikh_milady;
        $d3=substr($sql_tarikh3,8,2);
        $m3=substr($sql_tarikh3,5,2);
        $y3=substr($sql_tarikh3,0,4);
        $shamsi=gregorian_to_jalali($y3,$m3,$d3);
        $sal3=$shamsi[0];
        $mah3=$shamsi[1];
        $rouz3=$shamsi[2];
        $tarikh_shamsi=$sal3.'/'.$mah3.'/'.$rouz3;
	 
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  echo'
	    <td>'.$tarikh_shamsi.'</td>
		<td>'.round($mande,3).'</td>';
		/****************حالت خالص*******************/	  		
		if($noe_namayesh==1)
	   {
	     $jameKhalesVarede=$db->get_from_where("SUM(vazn_khales_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear'  AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid='".$tarikh_shamsi."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");		
		 $jameKhalesSadere=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear'  AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar='".$tarikh_shamsi."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");	
	     $KhalesTadil_Ezafe=$db->get_from_where("SUM(meghdar_khales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear'  AND deleted=0  AND status=0 AND tarikh_barge_tadil='".$tarikh_shamsi."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	     $KhalesTadil_Kasry=$db->get_from_where("SUM(meghdar_khales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear'  AND deleted=0  AND status=0 AND tarikh_barge_tadil='".$tarikh_shamsi."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
		 $mande=$mande+$jameKhalesVarede-$jameKhalesSadere+$KhalesTadil_Ezafe-$KhalesTadil_Kasry;
		}//END Khales
		/****************حالت ناخالص*******************/	  		
		if($noe_namayesh==2)
	   {
	     $jameNaKhalesVarede=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear'  AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid='".$tarikh_shamsi."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");		
		 $jameNaKhalesSadere=$db->get_from_where("SUM(vazn_nakhales_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear'  AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar='".$tarikh_shamsi."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");	
	     $NaKhalesTadil_Ezafe=$db->get_from_where("SUM(meghdar_nakhales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear'  AND deleted=0  AND status=0 AND tarikh_barge_tadil='".$tarikh_shamsi."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	     $NaKhalesTadil_Kasry=$db->get_from_where("SUM(meghdar_nakhales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear'  AND deleted=0  AND status=0 AND tarikh_barge_tadil='".$tarikh_shamsi."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
		 $mande=$mande+$jameNaKhalesVarede-$jameNaKhalesSadere+$NaKhalesTadil_Ezafe-$NaKhalesTadil_Kasry;
		}//END Nakhales
		/****************حالت کارتن*******************/	  		
		if($noe_namayesh==3)
	   {
	     $jameKartonVarede=$db->get_from_where("SUM(tedad_karton_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid='".$tarikh_shamsi."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");		
		 $jameKartonSadere=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear'  AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar='".$tarikh_shamsi."' AND($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");	
	     $kartonTadil_Ezafe=$db->get_from_where("SUM(tedad_karton_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear'  AND deleted=0  AND status=0 AND tarikh_barge_tadil='".$tarikh_shamsi."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
	     $kartonTadil_Kasry=$db->get_from_where("SUM(tedad_karton_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear'  AND deleted=0  AND status=0 AND tarikh_barge_tadil='".$tarikh_shamsi."' AND ($Condition_ostan) AND($Condition_anbar) AND($Condition_grkala)");
		 $mande=$mande+$jameKartonVarede-$jameKartonSadere+$kartonTadil_Ezafe-$kartonTadil_Kasry;
		}//END Karton
		/*********************************************/	  
		echo'<td>'.round($mande,3).'</td>';
        echo'
		</tr>';
		$tarikh_milady=date('Y-m-d',strtotime("+1 day", strtotime($tarikh_milady)));//یکی به روز اضافه شود
		//if($line>=$MaxLines && $i <$cntr) 
		if($line>=$MaxLines) 
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
     <!-- چاپ زیرنوس-->';
     require_once('prt-footer.php');
	 echo' 
    </table>';
	//}//END IF
	// ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
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
function enterCodeKala(code_kala)
{
  $("#loading").fadeIn("fast");
  $.post("ajax.php",{codeKALA_Error:code_kala},function(data){$("#codeK_Error").html(data);});
  $("#loading").fadeOut("fast");				
}
</script> 