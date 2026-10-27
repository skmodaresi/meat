<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojodysardkhane_tarikhtolid_grkala.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش موجودی واقعی/ موجودی مجاز سردخانه ها به تفکیک تاریخ تولید گروه کالا';
require_once('head.html');
/****************هدر******************/
Function print_header()
{global $count,$titr,$mahshamsiArr,$mt_gl_owner,$code_group_kala_top,$sal_tolid_shamsi_1,$sal_tolid_shamsi_2,$mah_tolid_shamsi_1,$mah_tolid_shamsi_2,$FileName,$page,$groupkalaName,$namayesh_info;
 IF($namayesh_info==2) $info='نمایش : تحت کلید گمرک';
 ELSE $info='نمایش : سایر';
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
         '.$titr.' : '.$groupkalaName.' &nbsp&nbsp(صفحه : '.$page.')-'.$info.'
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
/***********************************************************/
IF($code_mandegari) $Condition=" AND code_mandegari='".$code_mandegari."' ";
IF($code_tolidkonande)$Condition.=" AND code_tolidkonande='".$code_tolidkonande."'";//کد تولیدکننده  

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
	<tr class="tr1" style="height:45px;">
	 <td align="left"><span class="star">*</span> گروه کالای سردخانه :</td><td align="right">&nbsp;'.listboxMe("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='easyui-combobox text4' style=width:100px data-options=panelHeight:200").'</td>
	</tr>
	<tr class="tr1" > 
	 <td align="left"> نمایش موجودی : </td><td align="right" >&nbsp; <select name="namayesh_info_mojody" class="text4"><option value="1">موجودی واقعی</option><option value="2">موجودی مجاز</option> </select></td>	
	</tr>
    <tr class="tr1"  style="height:45px;" id="changeinfo">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:100").'</td>	
    </tr>
    <tr class="tr1" style="height:40px;">	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">	   
     <td align="left"> از تاریخ تولید : </td>
	 <td align="right">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_1" value="'.$sal_tolid_shamsi_1.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_1",$mah_tolid_shamsi_1,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	</tr>
	<tr class="tr1" style="height:40px;">	   
     <td align="left"> تا تاریخ تولید : </td>
	 <td align="right">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_2" value="'.$sal_tolid_shamsi_2.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_2",$mah_tolid_shamsi_2,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	</tr>
    <tr class="tr1">
	 <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>&nbsp;';
     include('img_helptolid.php');
     echo'
     </td>
	</tr> 
    <tr class="tr1">
     <td align="left">تاریخ ماندگاری :&nbsp;</td><td align="right" >'.listbox("code_mandegari",$code_mandegari,"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='easyui-combobox text4' style=width:100px","").'</td>
    </tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right" colspan="3">&nbsp; نمایش اطلاعات سردخانه موقت </td>
	</tr>
	<tr class="tr1" style="height:40px;">
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
	<tr class="tr1">
		<td align="left" height="40px"> نمایش :</td><td align="right" >&nbsp;
		'.static_listbox("namayesh_info",$namayesh_info,"namayesh_infoArr",1,"class='easyui-combobox text4' style=width:100px").'
		</td>	
    </tr>
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
 if(!$code_group_kala_top){echo"<script>alert('لطفاً گروه کالا را انتخاب نمایید !')</script>";
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
$groupkalaName=$db->get_from_where("name_group_kala_top","bzacc.group_kala_top","code_group_kala_top='$code_group_kala_top'");
$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan) AND($Condition_ostan) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{
  IF($namayesh_info==2) $info='نمایش : تحت کلید گمرک';
  ELSE $info='نمایش : سایر';
  echo'
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
         '.$titr.' : '.$groupkalaName.' &nbsp&nbsp(صفحه : '.$page.')-'.$info.'
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
 if($namayesh_info_mojody==1){
  if($noe_namayesh==1) $filter_string.=" نمایش اطلاعات : خالص";
  if($noe_namayesh==2) $filter_string.=" نمایش اطلاعات : ناخالص";
  if($noe_namayesh==3) $filter_string.=" نمایش اطلاعات : تعداد";
  if($noe_namayesh==4) $filter_string.=" نمایش اطلاعات : شانه";
 }
 if($namayesh_info_mojody==1) $filter_string.=" نمایش اطلاعات موجودی واقعی";
 if($namayesh_info_mojody==2) $filter_string.=" نمایش اطلاعات موجودی مجاز";
 if($code_mandegari){
	 $mandegari=$db->get_from_where("sharh_mandegari","tarikh_mandegari","code_mandegari='$code_mandegari'");
	 $filter_string.=" تاریخ ماندگاری : $mandegari  ";
 }
 if($mah_tolid_shamsi_1)$filter_string.=" از : $mahshamsiArr[$mah_tolid_shamsi_1]";
 if($sal_tolid_shamsi_1)$filter_string.=" $sal_tolid_shamsi_1";
 if($mah_tolid_shamsi_2)$filter_string.=" نا : $mahshamsiArr[$mah_tolid_shamsi_2]";
 if($sal_tolid_shamsi_2)$filter_string.=" $sal_tolid_shamsi_2";
 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
 
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
	   //if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM list_sardkhane WHERE $Condition_anbar_activate $Condition_movaghat code_ostan=4 AND code_anbar=124";
       else $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id'].""; 
	   $res2=$db->query($q2);
	   while($row2=$db->fetch_assoc($res2))//حلقه روی سردخانه ها
      {	   
	   $j=$i+1;
	   echo'
	   <td>'.$row2['code_anbar'].'-'.$row2['name_anbar'].'</td>';	
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
	     IF($namayesh_info_mojody==1)//موجودی 
	     {
		  $mojodyKala=0;
	      $mojodyAval=$db->get_from_where("SUM($avalField)","$table_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 $Condition");     	  
	      $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND resid_deleted=0 AND T.status=0 $Condition $Condition_info");
          $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala","T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND havale_deleted=0 AND T.status=0 $Condition $Condition_info");
	      $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 AND status=0 $Condition $Condition_info");
	      $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 AND status=0 $Condition $Condition_info");
		  $mojodyKala=round($mojodyAval+$jameVarede-$jameSadere+$Tadil_Ezafe-$Tadil_Kasry,3);	      
		  //نمایش اطلاعات
		  echo'<td>'.round($mojodyKala,3).'</td>';
		  $jame_mojody_PerAnbar+=$mojodyKala;//جمع موجودی کل گروه کالا در هر سردخانه  
		 }
		 ELSE//موجودی مجاز
		 { 
	        $mojody_mojaz=0;
			$mojody=0;
			$sold_this_id_without_ebtal=0;
			$ebtal_this_id=0;
			$sold_this_id=0;
			$tahvily_detail=0;
			$q_mojody=("SELECT T.* FROM $mydatabase.$table_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala WHERE year='$mtActiveYear' AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 $Condition");
	        $res_mojody=$db->query($q_mojody);
	        while($row_mojody=$db->fetch_array($res_mojody))//به ازای هر موجودی 
	        {  
		      
              $mojody_per=0;
			  $mojody_mojaz_per=0;
			  $sold_this_id_without_ebtal_per=0;
			  $ebtal_this_id_per=0;
			  $sold_this_id_per=0;
			  $tahvily_detail_per=0;
			  IF($row_mojody['code_bastebandy']==2)
		      {
				 $mojody_per=mojodyKarton($row_mojody['code_ostan'],$row_mojody['code_anbar'],$row_mojody['year'],$row_mojody['code_ziranbar'],$row_mojody['code_kala'],$row_mojody['code_keshvar'],$row_mojody['code_tolidkonande'],$row_mojody['sal_tolid_shamsi'],$row_mojody['mah_tolid_shamsi'],$row_mojody['rouz_tolid_shamsi'],$row_mojody['code_karton'],$row_mojody['code_mandegari']);  
			     $selldetail='dad_tedad_khanbar';
			     $havaleField='tedad_karton_h_d';
		      }
	          ELSE 
		      {
				 $mojody_per=mojodyKhales($row_mojody['code_ostan'],$row_mojody['code_anbar'],$row_mojody['year'],$row_mojody['code_ziranbar'],$row_mojody['code_kala'],$row_mojody['code_keshvar'],$row_mojody['code_tolidkonande'],$row_mojody['sal_tolid_shamsi'],$row_mojody['mah_tolid_shamsi'],$row_mojody['rouz_tolid_shamsi'],$row_mojody['code_karton'],$row_mojody['code_mandegari']);  
		         $mojody_per=round($mojody_per,3);
				 $selldetail='dad_vazn_khanbar';
		         $havaleField='vazn_khales_h_d';
		      }
	          $mojody+=$mojody_per;
		      $sold_this_id_without_ebtal_per=$db->get_from_where("SUM($selldetail)","sell.dm_anbar_det","dad_anbar_id=".$row_mojody['id']."");
	          $sold_this_id_without_ebtal_per=round($sold_this_id_without_ebtal_per,3);	  
		      $sold_this_id_without_ebtal+=$sold_this_id_without_ebtal_per;
			  $ebtal_this_id_per=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=".$row_mojody['id']."");
	          $ebtal_this_id_per=round($ebtal_this_id_per,3);
			  $ebtal_this_id+=$ebtal_this_id_per;
	          
			  
			  $tahvily_detail_per=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","id_mojody=".$row_mojody['id']." AND status=0 AND dad_id!=''");
	          $tahvily_detail_per=round($tahvily_detail_per,3);
		      $tahvily_detail+=$tahvily_detail_per;
			  $mande_az_detail_forush=$sold_this_id_without_ebtal-$ebtal_this_id-$tahvily_detail;
			  $mojody_mojaz=$mojody-$mande_az_detail_forush;
			  
			  // $sold_this_id=$sold_this_id_without_ebtal-$ebtal_this_id;
			  // $mojody_mojaz_per=$mojody-$sold_this_id-$tahvily_detail;
	          // $mojody_mojaz_per=round($mojody_mojaz_per,3);
			  
              // $mojody_mojaz+=$mojody_mojaz_per;		  
		    }
			// echo "<script>alert($mojody)</script>";
			// echo "<script>alert($sold_this_id_without_ebtal)</script>";
			// echo "<script>alert($ebtal_this_id)</script>";
			// echo "<script>alert($sold_this_id)</script>";
			// echo "<script>alert($tahvily_detail)</script>";
			// echo "<script>alert($mojody_mojaz_per)</script>";
		    //نمایش اطلاعات
		    //echo'<td>'.round($mojody,3).'-'.round($sold_this_id_without_ebtal,3).'-'.round($ebtal_this_id,3).'-'.round($tahvily_detail,3).'-'.round($mojody_mojaz,3).'</td>';
		    echo'<td>'.round($mojody_mojaz,3).'</td>';
		    $jame_mojody_PerAnbar+=$mojody_mojaz;//جمع موجودی کل کالا در هر سردخانه  
		 }
	     if($mah==12){$mah=1;$sal++;}
	     else $mah++;
	     $counter++;
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
	     IF($namayesh_info_mojody==1)//موجودی 
	     { 
		  $mojodyKalaKol=0;//جمع کل استانها در هر ستون تاریخ
	      $mojodyAval=$db->get_from_where("SUM($avalField)","$table_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 AND($Condition_ostan) and($Condition_anbar) $Condition");     	  
	      $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND resid_deleted=0 AND T.status=0 AND($Condition_ostan) and($Condition_anbar) $Condition $Condition_info");
          $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND havale_deleted=0 AND T.status=0 AND($Condition_ostan) and($Condition_anbar) $Condition $Condition_info");
	      $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear'  AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0  AND status=0 AND($Condition_ostan) and($Condition_anbar) $Condition $Condition_info");
	      $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0  AND status=0 AND($Condition_ostan) and($Condition_anbar) $Condition $Condition_info");
		  $mojodyKalaKol=round($mojodyAval+$jameVarede-$jameSadere+$Tadil_Ezafe-$Tadil_Kasry,3);	     
		  //نمایش اطلاعات
		  echo'<td>'.round($mojodyKalaKol,3).'</td>';
		  $jame_mojody_Kol+=$mojodyKalaKol;//جمع موجودی کل گروه کالا در استانها
		 }
		 ELSE//موجودی مجاز
		 {
			$mojody_mojaz_kol=0;
            $mojody_mojaz_kol_per=0;
	        $q_mojody_kol=("SELECT T.* FROM $mydatabase.$table_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan WHERE $Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 AND($Condition_ostan) and($Condition_anbar) $Condition");
	        $res_mojody_kol=$db->query($q_mojody_kol);
	        while($row_mojody_kol=$db->fetch_array($res_mojody_kol))//به ازای هر موجودی 
	        {  
		     IF($row_mojody_kol['code_bastebandy']==2)
		     {
			    $mojody=mojodyKarton($row_mojody_kol['code_ostan'],$row_mojody_kol['code_anbar'],$row_mojody_kol['year'],$row_mojody_kol['code_ziranbar'],$row_mojody_kol['code_kala'],$row_mojody_kol['code_keshvar'],$row_mojody_kol['code_tolidkonande'],$row_mojody_kol['sal_tolid_shamsi'],$row_mojody_kol['mah_tolid_shamsi'],$row_mojody_kol['rouz_tolid_shamsi'],$row_mojody_kol['code_karton'],$row_mojody_kol['code_mandegari']);  
			    $selldetail='dad_tedad_khanbar';
			    $havaleField='tedad_karton_h_d';
		     }
	         ELSE 
		     {
		        $mojody=mojodyKhales($row_mojody_kol['code_ostan'],$row_mojody_kol['code_anbar'],$row_mojody_kol['year'],$row_mojody_kol['code_ziranbar'],$row_mojody_kol['code_kala'],$row_mojody_kol['code_keshvar'],$row_mojody_kol['code_tolidkonande'],$row_mojody_kol['sal_tolid_shamsi'],$row_mojody_kol['mah_tolid_shamsi'],$row_mojody_kol['rouz_tolid_shamsi'],$row_mojody_kol['code_karton'],$row_mojody_kol['code_mandegari']);  
		        $selldetail='dad_vazn_khanbar';
		        $havaleField='vazn_khales_h_d';
		     }
	          $mojody=round($mojody,3);
		      $sold_this_id_without_ebtal=$db->get_from_where("SUM($selldetail)","sell.dm_anbar_det","dad_anbar_id=".$row_mojody_kol['id']."");
	          $sold_this_id_without_ebtal=round($sold_this_id_without_ebtal,3);	  
		      $ebtal_this_id=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=".$row_mojody_kol['id']."");
	          $ebtal_this_id=round($ebtal_this_id,3);
	          $sold_this_id=$sold_this_id_without_ebtal-$ebtal_this_id;
		      $tahvily_detail=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","id_mojody=".$row_mojody_kol['id']." AND status=0 AND dad_id!=''");
	          $tahvily_detail=round($tahvily_detail,3);
			  $mande_az_detail_forush=$sold_this_id-$tahvily_detail;
		      $mojody_mojaz_kol_per=$mojody-$mande_az_detail_forush;
	          $mojody_mojaz_kol_per=round($mojody_mojaz_kol_per,3);
              $mojody_mojaz_kol+=$mojody_mojaz_kol_per;		   
		    }
		    //نمایش اطلاعات
		    echo'<td>'.round($mojody_mojaz_kol,3).'</td>';
		    $jame_mojody_Kol+=$mojody_mojaz_kol;//جمع موجودی کل کالا در استان ها 	  
		 }
	     if($mah==12){$mah=1;$sal++;}
	     else $mah++;
	     $counter++;
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
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
 $("[name=namayesh_info_mojody]").bind("change", function () {
    if($(this).val() == 1) $("#changeinfo").slideDown("fast");
	else {$("#changeinfo").slideUp("fast");}
  });
});
</script>