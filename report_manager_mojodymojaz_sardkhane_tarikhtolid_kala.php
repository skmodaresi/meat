<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojodymojaz_sardkhane_tarikhtolid_kala.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش موجودی مجاز سردخانه ها به تفکیک تاریخ تولید کالا';
require_once('head.html');
/****************هدر******************/
Function print_header()
{global $count,$titr,$mahshamsiArr,$mt_gl_owner,$code_kala,$sal_tolid_shamsi_1,$sal_tolid_shamsi_2,$mah_tolid_shamsi_1,$mah_tolid_shamsi_2,$FileName,$page,$groupkalaName;
 echo'
  <br>   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
	   <tr class="noExl"> 
		<td class="print_title_2">'; 
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo'
         '.$titr.' : '.$kalaName.' (کد کالا : '.$code_kala.') &nbsp&nbsp(صفحه : '.$page.')
	     <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
       </tr>
      </table>
	 </td>
	</tr>
	<tr class="print_table-title2">
	 <td width="5%">ردیف</td>
	 <td width="10%">استان</td>
	 <td width="15%">سردخانه</td>'; 
	 $sal=$sal_tolid_shamsi_1;
	 $mah=$mah_tolid_shamsi_1;
	 $counter=0;
	 $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	 if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	 else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	 {	  	   	  
	   echo'<td>'.$mahshamsiArr[$mah].$sal.'</td>';
	   if($mah==12)
	   {$mah=1;$sal++;}
	  else $mah++;
	  $counter++;
	 }
	 echo'
	 <td width="15%">جمع</td>
	</tr>';	
}
/****************فیلترها روی گزارش******************/
/************************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $val ) 
      {
       $Condition_ostan_temp.=" T.code_ostan='$val' OR";
      }
      if($val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{$Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';}
/*****************************انبارها****************************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
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
/******************نمایش یا عدم نمایش سردخانه های موقت******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate="";$Condition_anbar_activate_ostan="1=1"; }
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND";$Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.code_group_kala_top.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=5;
if(!$ok)
{
echo'
<table width="95%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1">
	 <td align="left" height="40px"><span class="star">*</span> کد کالا : </td>
     <td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	  include ("img_helpkala.php");
 	  echo'&nbsp;<span style="color:red" id="codeK_Error">&nbsp;</span></td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>	
    </tr>
    <tr class="tr1">	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">	   
     <td align="left"> از تاریخ تولید : </td>
	 <td align="right">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_1" value="'.$sal_tolid_shamsi_1.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_1",$mah_tolid_shamsi_1,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	</tr>
	<tr class="tr1">	   
     <td align="left"> تا تاریخ تولید : </td>
	 <td align="right">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_2" value="'.$sal_tolid_shamsi_2.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_2",$mah_tolid_shamsi_2,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	</tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right" colspan="3">&nbsp; همراه با اطلاعات سردخانه موقت </td>
	</tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
    </tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left" height="40px"> نام استان : </td>
      <td align="right">
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
	echo'
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>    
   </table>
  </td>
 </tr>
</table> ';
}
else
{
 if(!$code_kala){echo"<script>alert('لطفاً کد کالا را وارد کنید !')</script>";
                   echo"<script>window.location='$FileName';</script>";}
 //اگر کاربر تاریخ اول را وارد نکرده بود
 if(!$sal_tolid_shamsi_1)$sal_tolid_shamsi_1=$mtActiveYear-1;  
 if(!$mah_tolid_shamsi_1)$mah_tolid_shamsi_1='1';  
 //اگر کاربر تاریخ دوم را وارد نکرده بود
 if(!$sal_tolid_shamsi_2) $sal_tolid_shamsi_2=$mtActiveYear;	  
 if(!$mah_tolid_shamsi_2){IF($mtActiveYear==$yy) $mah_tolid_shamsi_2=intval($mm); ELSE $mah_tolid_shamsi_2=12;}  	  
/****************شروع نمایش گزارش*******************/	
$radif=1;
$page=1;
$line=0;
$i=0;
$cntr=0;
//تعیین فیلدها براساس نوع نمایش
IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
//$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan) AND($Condition_ostan) ORDER BY name_ostan";
$kalaName=$db->get_from_where("name_kala","kala","code_kala='$code_kala'");
$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane) AND($Condition_ostan) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
  <br>
  <div class="table2excel">  
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
	   <tr class="noExl"> 
		<td class="print_title_2">'; 
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo'
         '.$titr.' : '.$kalaName.' (کد کالا : '.$code_kala.') &nbsp&nbsp(صفحه : '.$page.')
	     <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
       </tr>
      </table>
	 </td>
	</tr>';
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
 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت -';
 if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت -';
 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
 if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
 if($noe_namayesh==1) $filter_string.=" نمایش اطلاعات : خالص";
 if($noe_namayesh==2) $filter_string.=" نمایش اطلاعات : ناخالص";
 if($noe_namayesh==3) $filter_string.=" نمایش اطلاعات : تعداد";
 if($noe_namayesh==4) $filter_string.=" نمایش اطلاعات : شانه";
 if($mah_tolid_shamsi_1)$filter_string.=" از : $mahshamsiArr[$mah_tolid_shamsi_1]";
 if($sal_tolid_shamsi_1)$filter_string.=" $sal_tolid_shamsi_1";
 if($mah_tolid_shamsi_2)$filter_string.=" نا : $mahshamsiArr[$mah_tolid_shamsi_2]";
 if($sal_tolid_shamsi_2)$filter_string.=" $sal_tolid_shamsi_2";
  echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
  echo'
   <tr class="print_table-title2">
	 <td width="5%">ردیف</td>
	 <td width="10%">استان</td>
	 <td width="15%">سردخانه</td>';
	 //ایجاد حلقه ماه تولید
	 $sal=$sal_tolid_shamsi_1;
	 $mah=$mah_tolid_shamsi_1;
	 $counter=0;
	 $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	 if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	 else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	 {	  	   	  
	   echo'<td>'.$mahshamsiArr[$mah].$sal.'</td>';
	   if($mah==12)
	   {$mah=1;$sal++;}
	  else $mah++;
	  $counter++;
	 }
	 echo'
	 <td width="15%">جمع</td>'; 
     while($row=$db->fetch_array($res))//ostan while
     {	
       $line++;
	   //تعداد سردخانه در هر استان
	   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","$Condition_anbar_activate $Condition_movaghat code_ostan=".$row['code_ostan']."");//تعداد انبارهای هر استان 
	   else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای هر استان     
	   $rowanbar=$tedadanbar;
	   $t=$rowanbar;
  	   if($i++%2)echo'<tr class="print_table-odd">';
       else echo'<tr class="print_table-even">';
       echo'   
       <td rowspan="'.$rowanbar.'">'.$radif++.'</td>
	   <td rowspan="'.$rowanbar.'">'.$row['name_ostan'].'</td>';
	   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM list_sardkhane WHERE $Condition_anbar_activate $Condition_movaghat code_ostan=".$row['code_ostan']."";
       else $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id'].""; 
	   $res2=$db->query($q2);
	   while($row2=$db->fetch_assoc($res2))//حلقه روی سردخانه ها
      {	   
	   $j=$i+1;
	   echo'
	   <td>'.$row2['name_anbar'].'</td>';	
	   /**************************ایجاد حلقه ماه تولید**************************/
	   $sal=$sal_tolid_shamsi_1;
	   $mah=$mah_tolid_shamsi_1;
	   $counter=0;
	   $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	   if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	   else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	   else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	   $jame_mojody_PerAnbar=0;//جمع موجودی کل کالاها در هر استان
	   while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	   {	  	   	  
		 /****************محاسبه مانده موجودی*******************/		  
	      $mojody_mojaz=0;
          $mojody_mojaz_per=0;
	      $q_mojody=("SELECT * FROM $mydatabase.mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala WHERE year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0");
	      $res_mojody=$db->query($q_mojody);
	      while($row_mojody=$db->fetch_array($res_mojody))//به ازای هر موجودی 
	      {  
		   IF($row_mojody['code_bastebandy']==2)
		   {
			  $mojody=mojodyKarton($row_mojody['code_ostan'],$row_mojody['code_anbar'],$row_mojody['year'],$row_mojody['code_ziranbar'],$row_mojody['code_kala'],$row_mojody['code_keshvar'],$row_mojody['code_tolidkonande'],$row_mojody['sal_tolid_shamsi'],$row_mojody['mah_tolid_shamsi'],$row_mojody['rouz_tolid_shamsi'],$row_mojody['code_karton']);  
			  $selldetail='dad_tedad_khanbar';
			  $havaleField='tedad_karton_h_d';
		   }
	       ELSE 
		   {
			  $mojody=mojodyKhales($row_mojody['code_ostan'],$row_mojody['code_anbar'],$row_mojody['year'],$row_mojody['code_ziranbar'],$row_mojody['code_kala'],$row_mojody['code_keshvar'],$row_mojody['code_tolidkonande'],$row_mojody['sal_tolid_shamsi'],$row_mojody['mah_tolid_shamsi'],$row_mojody['rouz_tolid_shamsi'],$row_mojody['code_karton']);  
			  $selldetail='dad_vazn_khanbar';
			  $havaleField='vazn_khales_h_d';
		   }
	       $mojody=round($mojody,3);
		   $sold_this_id_without_ebtal=$db->get_from_where("SUM($selldetail)","sell.dm_anbar_det","dad_anbar_id=".$row_mojody['id']."");
	       $sold_this_id_without_ebtal=round($sold_this_id_without_ebtal,3);	  
		   $ebtal_this_id=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=".$row_mojody['id']."");
	       $ebtal_this_id=round($ebtal_this_id,3);
	       $sold_this_id=$sold_this_id_without_ebtal-$ebtal_this_id;
		   $tahvily_detail=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","id_mojody=".$row_mojody['id']." AND status=0 AND dad_id!=''");
	       $tahvily_detail=round($tahvily_detail,3);
		   $mojody_mojaz_per=$mojody-$sold_this_id-$tahvily_detail;
	       $mojody_mojaz_per=round($mojody_mojaz_per,3);
           $mojody_mojaz+=$mojody_mojaz_per;		   
		  }
		  // $mojodyKala=0;
	      // $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala","year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0");     	  
	      // $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN kala ON T.code_kala=kala.code_kala","year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND resid_deleted=0 AND status=0");
          // $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN kala ON T.code_kala=kala.code_kala","year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND havale_deleted=0 AND status=0 ");
	      // $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 AND status=0");
	      // $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 AND status=0");
		  // $mojodyKala=round($mojodyAval+$jameVarede-$jameSadere+$Tadil_Ezafe-$Tadil_Kasry,3);	      
		 //نمایش اطلاعات
		 echo'<td>'.round($mojody_mojaz,3).'</td>';
	     if($mah==12){$mah=1;$sal++;}
	     else $mah++;
	    $counter++;
	    $jame_mojody_PerAnbar+=$mojody_mojaz;//جمع موجودی کل گروه کالا در هر سردخانه  
	   }//END mah while
	   echo'<td>'.round($jame_mojody_PerAnbar,3).'</td>';
		$t--;
		if($t==0) echo'';
		else 
		{
		  echo'</tr>';
		  if($j++%2)echo'<tr class="print_table-odd">';
          else echo'<tr class="print_table-even">';
		}
	  }//END anbar while 
	  /*****تکرار سرصفحه و ستون ها*****/
	  if($line>=$MaxLines && $i <$cntr) 
	  {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
	  }  
   }//END ostan while
   /*****سطر جمع کل استان ها*****/
   echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="3">جمع کل</td>';
	   $sal=$sal_tolid_shamsi_1;
	   $mah=$mah_tolid_shamsi_1;
	   $counter=0;
	   $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	   if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	   else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	   else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	   $jame_mojody_Kol=0;//جمع موجودی کل گروه کالا در استانها
	   while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	   {	  	   	  
		 /****************محاسبه مانده موجودی*******************/
	      $mojodyKalaKol=0;//جمع کل استانها در هر ستون تاریخ
	      $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 AND($Condition_ostan) and($Condition_anbar)");     	  
	      $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND resid_deleted=0 AND status=0 AND($Condition_ostan) and($Condition_anbar)");
          $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND havale_deleted=0 AND status=0 AND($Condition_ostan) and($Condition_anbar)");
	      $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear'  AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0  AND status=0 AND($Condition_ostan) and($Condition_anbar)");
	      $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND T.code_kala='$code_kala' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0  AND status=0 AND($Condition_ostan) and($Condition_anbar)");
	      $mojodyKalaKol=round($mojodyAval+$jameVarede-$jameSadere+$Tadil_Ezafe-$Tadil_Kasry,3);	     
		 //نمایش اطلاعات
		 echo'<td>'.round($mojodyKalaKol,3).'</td>';
	     if($mah==12){$mah=1;$sal++;}
	     else $mah++;
	    $counter++;
	    $jame_mojody_Kol+=$mojodyKalaKol;//جمع موجودی کل گروه کالا در استانها
	   }  
	   echo '<td>'.round($jame_mojody_Kol,3).'</td>
	 </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنوس-->';
  require_once('prt-footer.php');
 echo' 
 </table>';
 }//END IF//وجود اطلاعات
  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'
</div>	
</form>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript">
function enterCodeKala(code_kala)
{
  $("#loading").fadeIn("fast");
  $.post("ajax_error.php",{codeKALA_Error:code_kala},function(data){$("#codeK_Error").html(data);});
  $("#loading").fadeOut("fast");				
}
</script> 