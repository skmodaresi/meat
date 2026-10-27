<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
if(isset($_POST['codeKALA']))//اطلاعات کالا
{
  $res0 =$db->query("SELECT kala.name_kala,vahed_kala.sharh_vahedkala,kala.code_bastebandy,bastebandy.sharh_bastebandy FROM kala 
                      INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala 
					  INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy WHERE code_kala='$codeKALA'");
  $row0=$db->fetch_assoc($res0); 
  if($row0['code_bastebandy']==2)$vahed_andazegiry=' (تعداد قوطی)';
  else if($row0['code_bastebandy']==5)$vahed_andazegiry=' (تعداد دست)';
  else if($row0['code_bastebandy']==6)$vahed_andazegiry=' (تعداد)';
  else if(($codeKALA==50)OR($codeKALA==54)) $vahed_andazegiry=' (تعداد شانه)';
  else  $vahed_andazegiry=' (کیلوگرم)';
  echo $row0['name_kala'].'^'.$row0['sharh_vahedkala'].'^'.$row0['sharh_bastebandy'].'^'.$vahed_andazegiry;   
}
/*************************************************************/
if(isset($_POST['codeKESHVAR']))//اطلاعات کشوردر فایل موجودی کالا
{
  $res_keshvar =$db->query("SELECT name_keshvar FROM keshvar WHERE code_keshvar='$codeKESHVAR'");
  $row_keshvar=$db->fetch_assoc($res_keshvar);  
  echo $row_keshvar['name_keshvar'];   
}
/*************************************************************/
if(isset($_POST['codeTOLID']))//اطلاعات تولیدکننده در فایل موجودی کالا
{
  //$res_tolid =$db->query("SELECT name_tolidkonande FROM tolidkonande WHERE code_tolidkonande='$codeTOLID' AND code_ostan=$mt_gl_code_ostan");
  $res_tolid =$db->query("SELECT name_tolidkonande FROM tolidkonande WHERE code_tolidkonande='$codeTOLID'");
  $row_tolid=$db->fetch_assoc($res_tolid);  
  echo $row_tolid['name_tolidkonande'];   
}
/*************************************************************/
if(isset($_POST['codeKALA3']))//اطلاعات کالا و موجودی در فایل تعدیل
{
  $res_kala3 =$db->query("SELECT kala.name_kala FROM kala WHERE code_kala='$codeKALA3'");
  $row_kala3=$db->fetch_assoc($res_kala3);
  //بسته بندی این کالا در جدول بسته بندی
  $code_bastebandy=$db->get_from_where("code_bastebandy","kala","code_kala='$codeKALA3'");
  if($codeKALA3==null)$mojody_img='';  
  else 
  {$mojody_img='<span style="color:red;">کلیک کنید </span><img border="0" src="images/image(7).gif" onClick="window.popupwindow(\'help_mojodykala.php?code_kala_='.$codeKALA3.'&code_bastebandy_='.$code_bastebandy.'\',\'\',800,500)" title="جدول موجودی کالا" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/>';
   // if($code_bastebandy==1)
   // {
     // $show_data='<td align="left">کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" value="'.$code_karton.'"/></td>
			      // <td align="left">وزن کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" value="'.$vazn_karton_this.'"/></td>
                 // ';
   // }
   // if($code_bastebandy==2)
   // {
     // $show_data='<td align="left">کد قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" value="'.$code_karton.'"/></td>
			     // <td align="left">وزن قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" value="'.$vazn_karton_this.'"/></td>
			     // ';
   // }
  }
  echo $row_kala3['name_kala'].'^'.$mojody_img.'^'.$code_bastebandy;   
}
/*************************************************************/
if((isset($_POST['codeKESHVAR2']))and(isset($_POST['codeKALA2'])))//اطلاعات کشوردر فرم تعدیل موجودی
{
  $res_keshvar2 =$db->query("SELECT name_keshvar FROM keshvar WHERE code_keshvar='$codeKESHVAR2'");
  $row_keshvar2=$db->fetch_assoc($res_keshvar2);  
  //$mojody_img='<img border="0" src="images/image(7).gif" onClick="window.open(\'help_mojodykala.php?code_kala_='.$codeKALA2.'&code_keshvar='.$codeKESHVAR2.'\',\'_blank\',\'width=750px,left=400px,top=100px,scrollbars=yes\')" title="جدول موجودی کالا" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/>';
  $mojody_img="image-mojody";
  echo $row_keshvar2['name_keshvar'].'^'.$mojody_img;     
}
/*************************************************************/
//ظاهر شدن اطلاعات براساس انتخاب نوع محموله در فایل موجودی کالا 
if(isset($_POST['noeMAHMULE']))//فقط در حالت ویرایش استفاده شده
{
  if($noeMAHMULE==1)//اگر نوع محموله داخلی باشد
  {echo'
        <td align="left" style="font-weight:bold;"><span style="color:red">*</span> تاریخ تولید شمسی  :&nbsp;</td>
		<td align="right">
		 <span style="color:red">*</span> سال : <input class="textboxme2" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" onkeypress="return isNumber(event)" style="width:40px;"/>
		 <span style="color:red">*</span> ماه : '.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='text4'").'
		 روز : '.static_listbox("rouz_tolid_shamsi",$rouz_tolid_shamsi,"rouzArr",1,"class='text4'").'
		</td>';		
  }
  if($noeMAHMULE==2)//اگر نوع محموله خارجی باشد
  {echo'
        <td align="left" style="font-weight:bold;"><span style="color:red">*</span> تاریخ تولید میلادی  :&nbsp;</td>
		<td align="right">
		  <span style="color:red">*</span> سال : <input class="textboxme2" type="text" name="sal_tolid_milady" value="'.$sal_tolid_milady.'" maxlength="4" onkeypress="return isNumber(event)" style="width:40px;"/>
		  <span style="color:red">*</span> ماه : '.static_listbox("mah_tolid_milady",$mah_tolid_milady,"mahmiladyArr",1,"class='text4'").'
		  روز : '.static_listbox("rouz_tolid_milady",$rouz_tolid_milady,"rouzArr",1,"class='text4'").'
	    </td>';	   
  }
  else//در غیر اینصورت
  {echo'<td colspan="6">&nbsp;</td>';}
}
/*************************************************************/ 
if(isset($_POST['vaznKHALES']))//اطلاعات باسکول برای فایل رسید
{
	$result_baskul=mysql_query("SELECT nerkh_baskul FROM hazine_baskul WHERE az_vazn<='$vaznKHALES' AND ta_vazn>='$vaznKHALES'");
	$row_baskul=mysql_fetch_array($result_baskul);
	echo $row_baskul['nerkh_baskul'];
}
/*************************************************************/
if(isset($_POST['codeMOSHTARY']))//اطلاعات مشتری
{
 if($_SESSION['mt_systemforush']==0)//اطلاعات از سیستم سردخانه
 { 
  $TableName="moshtary";
  // $result2=mysql_query("SELECT $TableName.*,ostan.name_ostan,shahrestan.city_name FROM $TableName 
                       // INNER JOIN ostan ON $TableName.code_ostan=ostan.code_ostan 
					   // INNER JOIN shahrestan ON $TableName.city_code=shahrestan.city_code and ostan.code_ostan=shahrestan.code_ostan						  
					   // WHERE code_customer='$codeMOSHTARY'");
  $result2=mysql_query("SELECT * FROM $TableName WHERE code_customer='$codeMOSHTARY'");
  $row2=mysql_fetch_assoc($result2);
  echo $row2['name_customer'].'^'.$row2['name_ostan'].'^'.$row2['city_name'].'^'.$row2['customer_address_office'];
 }
 if($_SESSION['mt_systemforush']==1)//اطلاعات از سیستم فروش
 { 
  mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
  $TableName="dm_customer_asli";
  $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
  $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
  // $result2=mysql_query("SELECT $TableName.*,dm_province.province_name,dm_city.city_name FROM $TableName
	        // LEFT OUTER JOIN dm_province ON dm_province.province_id=$TableName.customer_province_id 
	        // LEFT OUTER JOIN dm_city ON $TableName.customer_city_id=dm_city.city_id AND dm_city.city_province=dm_province.province_id 
	        // WHERE  $TableName.code_customer='$codeMOSHTARY' AND $TableName.customer_province_id='$sell_id_ostan'");
 // $result2=mysql_query("SELECT $TableName.*,dm_province.province_name,dm_city.city_name FROM $TableName
	        // LEFT OUTER JOIN dm_province ON dm_province.province_id=$TableName.customer_province_id 
	        // LEFT OUTER JOIN dm_city ON $TableName.customer_city_id=dm_city.city_id AND dm_city.city_province=dm_province.province_id 
	        // WHERE  $TableName.code_customer='$codeMOSHTARY'");	
  $result2=mysql_query("SELECT * FROM $TableName WHERE code_customer='$codeMOSHTARY'");	
  $row2=mysql_fetch_assoc($result2);
  echo $row2['name_customer'].'^'.$row2['province_name'].'^'.$row2['city_name'].'^'.$row2['customer_address_office'];
 }
}
/*************************************************************/
if(isset($_POST['codeANBAR']))//اطلاعات انبار
{
  $result3 =$db->query("SELECT name_anbar,address_anbar FROM list_sardkhane WHERE code_anbar='$codeANBAR' AND code_ostan='$mt_gl_code_ostan'");
  $row3=$db->fetch_assoc($result3);
  echo $row3['name_anbar'].'^'.$row3['address_anbar'];
}
/*************************************************************/
if(isset($_POST['codeKARTON']))//آمدن وزن کارتن در حواله انبار
{
 //$res_karton=$db->query("SELECT * FROM karton WHERE code_karton='$codeKARTON' AND code_ostan='$mt_gl_code_ostan' AND code_bastebandy=1");
 $res_karton=$db->query("SELECT * FROM karton WHERE code_karton='$codeKARTON' AND code_bastebandy=1");
 $row_karton=$db->fetch_assoc($res_karton);
 echo $row_karton['sharh_karton'].'^'.$row_karton['vazn_karton'];
}
/*************************************************************/
if(isset($_POST['codeGHOOTI']))//آمدن وزن قوطی
{
 //$res_ghooti=$db->query("SELECT * FROM karton WHERE code_karton='$codeGHOOTI' AND code_ostan='$mt_gl_code_ostan' AND code_bastebandy=2");
 $res_ghooti=$db->query("SELECT * FROM karton WHERE code_karton='$codeGHOOTI' AND code_bastebandy=2");
 $row_ghooti=$db->fetch_assoc($res_ghooti);
 echo $row_ghooti['sharh_karton'].'^'.$row_ghooti['vazn_karton'];
}
/*************************************************************/
//dont use
if(isset($_POST['idMOJODY']))//آمدن اطلاعات موجودی کالا در حواله انبار
{
 $result_mo=$db->query("SELECT *,(SELECT name_keshvar FROM keshvar WHERE code_keshvar=m.code_keshvar) nameKeshvar FROM mojody_kala m WHERE id='$idMOJODY'");
 $row_mo=$db->fetch_assoc($result_mo);
 echo $row_mo['code_keshvar'].'^'.$row_mo['nameKeshvar'].'^'.$row_mo['tarikh_tolid'].'^'.$row_mo['mojody_khales'];
}
/*************************************************************/
if(isset($_POST['shomareHAVALEFORUSH2']))//اطلاعات حواله فروش برای فایل ابطال
{
  $result6 =$db->query("SELECT * FROM havale_forush WHERE h_code='$shomareHAVALEFORUSH2' AND h_reg_date>='$mtStartDateSh' AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."' AND year=".$_SESSION["mtActiveYear"]." AND deleted=0"); 
  $row6=$db->fetch_assoc($result6);
  //محاسبه مقدار تحویلی
  $meghdar_tahvily=$db->get_from_where("SUM(vazn_khales_h)","havale","h_code='".$row6['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
  //$meghdar_tahvily=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail","h_code='".$row6['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");
  //محاسبه مقدار باطله
  $meghdar_batele=$db->get_from_where("SUM(meghdar_batele)","ebtal","h_code='".$row6['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
  $mande_az_forush=$row6['mande_az_forush'];
  echo $row6['h_reg_date'].'^'.$row6['code_customer'].'^'.$row6['code_kala'].'^'.$row6['meghdar_havale_forush'].'^'.$meghdar_tahvily.'^'.$meghdar_batele.'^'.$mande_az_forush;;
}
/*************************************************************/
//فعلا استفاده نمی شود
//اطلاعات استان و شهر در جدول مشتریان برای سیستم انبار
if(isset($_POST['codeOSTANforSHAHR']))
{
  $result_shahr = $db->query("SELECT * FROM shahrestan WHERE code_ostan='$codeOSTANforSHAHR'");
  $shahr_options = "<option value=0>انتخاب کنید</option>";
  while($row_shahr=$db->fetch_assoc($result_shahr))  
   $shahr_options .= "<option value=".$row_shahr['city_code'].">".$row_shahr['city_name']."</option>";
  echo $shahr_options; 
}
/*************************************************************/
//فعلا استفاده نمی شود
//اطلاعات استان و شهر در جدول مشتریان برای سیستم فروش
if(isset($_POST['idPROVINCEforCITY']))
{
  mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
  $result_city = $db->query("SELECT * FROM dm_city WHERE city_province='$idPROVINCEforCITY'");
  $city_options="<option value=0>انتخاب کنید</option>";
  while($row_city=$db->fetch_assoc($result_city))  
  $city_options .= "<option value=".$row_city['city_id'].">".$row_city['city_name']."</option>";
  echo $city_options; 
}
/*************************************************************/
if(isset($_POST['codeOSTANforANBAR']))//اطلاعات استان وانبار برای سوپریوزر در صفحه اول
{
  $result_anbar = $db->query("SELECT * FROM list_sardkhane WHERE code_ostan='$codeOSTANforANBAR'");
  while($row_anbar=$db->fetch_assoc($result_anbar))  
   $anbar_options .= "<option value=".$row_anbar['code_anbar'].">".$row_anbar['name_anbar']."</option>";
  echo $anbar_options; 
}
/*************************************************************/
//ظاهر شدن اطلاعات براساس انتخاب نوع خرید در رسید انبار
if(isset($_POST['noeKHARID']))
{
  if($noeKHARID==1)//اگر نوع خرید داخلی باشد
  {echo'
        <td align="left"><span style="color:red">*</span> نام فروشنده : </td><td align="right"><input type="text" class="textboxme2" name="name_forushande" value="'.$name_forushande.'"/>
		</td>';
  }
  else //اگر نوع خرید خارجی باشد
  {echo'
  	   <td align="left"><span style="color:red">*</span> مبدأ بارگيری : </td><td align="right">'.listbox("code_mabda",$code_mabda,"code_mabda","name_mabda","mabady_vorudy","","class='text4'","").'</td>
       <td align="left"><span style="color:red">*</span> نام کشتی : </td><td align="right">'.listbox("code_skk",$code_skk,"code_skk","name_skk","keshty","1=1","onchange=getShomareSafar(this.value) class='text4'","").'</td>
	   <td align="left"><span style="color:red">*</span> شماره سفر :</td><td align="right"><select name="id_safar" id="shomare_safar" class="text4"><option value="0">انتخاب کنيد</option></select></td>
       <td align="left"><span style="color:red">*</span> نام کشور مبدأ : </td><td align="right">'.listbox("code_keshvar",$code_keshvar,"code_keshvar","name_keshvar","keshvar","","class='text4'","").'</td>';
  }
}
/*************************************************************/
if(isset($_POST['codeOSTAN1']))//آمدن لیست انبارها با کلیک روی استان
{
  $result7 = $db->query("SELECT code_anbar,name_anbar FROM list_sardkhane WHERE code_ostan='$codeOSTAN1' ORDER BY name_anbar");
  while($row7=$db->fetch_assoc($result7))  
   $anbar_options .= "<option value=".$row7['code_anbar'].">".$row7['name_anbar']."</option>";
  echo $anbar_options;   
}
/*************************************************************/
if(isset($_POST['noeZIRANBAR']))//اطلاعات زیرانبار
{
  $res_zir_a=$db->query("SELECT code_ziranbar,name_ziranbar FROM list_sardkhane_detail WHERE noe_ziranbar='$noeZIRANBAR' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
  $ziranbar_options="<option value=0>انتخاب کنيد</option>";
  while($row_zir_a=$db->fetch_assoc($res_zir_a))  
   $ziranbar_options .= "<option value=".$row_zir_a['code_ziranbar'].">".$row_zir_a['name_ziranbar']."</option>";
  echo $ziranbar_options;   
}

/*************************************************************/
if(isset($_POST['codeKESHTY']))//اطلاعات فروشنده/کشتی و شماره سفر و قرارداد در فرم رسید
{
  $res_keshty=$db->query("SELECT name_skk FROM mt_skk WHERE code_skk='$codeKESHTY'");
  $row_keshty=$db->fetch_assoc($res_keshty);
  $name_skk=$row_keshty['name_skk'];
  //شرط فعال و غیرفعال ابلاغ چک نشه
   //IF(($codeKESHTY==42970))//کد فروشنده
   //{
	    //فقط شماره قرارداد خاص فعال باشد
		//$result = $db->query("SELECT shomare_safar.* FROM shomare_safar 
                         // INNER JOIN gharardad_kharid ON shomare_gharardad=shomare_safar AND gharardad_kharid.code_ostan=shomare_safar.code_ostan
                         // INNER JOIN sahmiebandy_kharid ON sahmiebandy_kharid.id_sahmiebandy=gharardad_kharid.id_sahmiebandy
						 // INNER JOIN eblagh_kharid ON sahmiebandy_kharid.id_eblagh=eblagh_kharid.id_eblagh 
                         // WHERE shomare_safar.code_skk='$codeKESHTY' AND etmam_safar=0 AND shomare_safar.code_ostan='$mt_gl_code_ostan'
						 // AND (gharardad_kharid.shomare_gharardad='14/200905') AND eblagh_kharid.deleted=0 AND sahmiebandy_kharid.deleted=0 AND gharardad_kharid.deleted=0");
   //}
   //فقط استان خاص فعال باشد
    //IF($_SESSION["mt_code_ostan"]==4)
	//{ 
     //$result = $db->query("SELECT * FROM shomare_safar WHERE code_skk='$codeKESHTY' AND etmam_safar=0 AND code_ostan='$mt_gl_code_ostan'");
	//}	
    //ELSE //اونهایی که ابلاغشون فعال است
    //{ 
     $result = $db->query("SELECT shomare_safar.* FROM shomare_safar 
                        INNER JOIN gharardad_kharid ON shomare_gharardad=shomare_safar AND gharardad_kharid.code_ostan=shomare_safar.code_ostan
                        INNER JOIN sahmiebandy_kharid ON sahmiebandy_kharid.id_sahmiebandy=gharardad_kharid.id_sahmiebandy
						INNER JOIN eblagh_kharid ON sahmiebandy_kharid.id_eblagh=eblagh_kharid.id_eblagh 
                        WHERE shomare_safar.code_skk='$codeKESHTY' AND etmam_safar=0 AND shomare_safar.code_ostan='$mt_gl_code_ostan'
						AND eblagh_kharid.activate_eblagh=1 AND eblagh_kharid.deleted=0 AND sahmiebandy_kharid.deleted=0 AND gharardad_kharid.deleted=0");
   //}
  while($row=$db->fetch_assoc($result))  
   $shomare_safar_options .= "<option value=".$row['id_safar'].">".$row['shomare_safar']."</option>";
  echo $name_skk.'^'.$shomare_safar_options;   
}
/*************************************************************/
if(isset($_POST['noeKHODRO']))//نرخ باسکول با انتخاب خودرو
{
  $res1_1=$db->query("SELECT sh_jadval_baskul FROM hazine_baskul WHERE code_ostan='$mt_gl_code_ostan' AND deleted=0 order by sh_jadval_baskul DESC LIMIT 0,1");//شماره آخرین جدول هزینه باسکول
  if(mysql_num_rows($res1_1)>0)
  {
   $row1_1=$db->fetch_assoc($res1_1);
   $res_bas=mysql_query("SELECT nerkh_baskul FROM hazine_baskul_detail WHERE sh_jadval_baskul=".$row1_1['sh_jadval_baskul']." AND noe_khodro='$noeKHODRO' AND code_ostan='$mt_gl_code_ostan'");
   $row_bas=mysql_fetch_assoc($res_bas);
  echo $row_bas['nerkh_baskul'];
 }  
}

/*************************************************************/
if(isset($_POST['codeGrK_T']))//آمدن لیست انبارها با کلیک روی استان به جز خود همان انبار
{
  $result_kala = $db->query("SELECT code_kala,name_kala FROM kala WHERE code_group_kala_top='$codeGrK_T' ORDER BY name_kala"); 
  while($row_kala=$db->fetch_assoc($result_kala))  
   $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']."</option>";
  echo $kala_options;   
}
/*************************************************************/
if(isset($_POST['codeKALA_Error']))//در گزارش ها
{
  if(empty($_POST['codeKALA_Error']))
  echo 'لطفاً کد کالا را وارد کنید !';
}
/*************************************************************/
if(isset($_POST['codeMOSHTARY_Error']))//در گزارش ها
{
  if(empty($_POST['codeMOSHTARY_Error']))
  echo 'لطفاً کد مشتری را وارد کنید !';
}
/*************************************************************/
if(isset($_POST['shomare_Error']))//در گزارش ها
{
  if(empty($_POST['shomare_Error']))
  echo 'لطفاً شماره ابلاغ را وارد نمایید !';
}
?>