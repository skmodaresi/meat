<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head> 

<style type="text/css">
#hcss{
       border-top-width: 1px;
       border-right-width: 1px;
       border-bottom-width: 1px;
       border-left-width: 1px;
       border-top-style: solid;
       border-right-style: solid;
       border-bottom-style: solid;
       border-bottom-width: 1px;
       border-left-style: solid;
       border-top-color: #000000;
       border-right-color: #000000;
       border-bottom-color: #000000;
       border-left-color: #000000;
       font-family: Verdana, Tahoma, Sans-Serif;
       font-size: 10pt;
       line-height: normal;
}
body {
	font: 16px Arial,Verdana,Arial, Helvetica, sans-serif;
	margin: 10px auto;
	 
	
}

</style>
<?php
include_once 'lib/php/jdf.php';
include_once 'lib/php/db_connect.php';
include_once 'lib/php/gen_def.php';
 header('Content-Type: text/html; charset=UTF-8');

$i=1;
for ( ; $i <20; ++$i ){
$query2 = "select * from dm_havale 
           where   
		h_id_province=" . $i ." 
			and  
		h_p_price=" . 0 ." ";	
		$lnk2 = mysql_query($query2);
	//print 	$query2;
	if(mysql_num_rows($lnk2)>0){
		while($row2= mysql_fetch_assoc($lnk2)){
		
$lnkp = mysql_query("SELECT * FROM dm_product product
								left join dm_price price
								on product.p_id=price.price_p_id
								 WHERE p_code=".$row2['h_p_code']." AND p_price_code=".$row2['h_price_code']."
								 AND
								  price_id_province=".$i."");
$queryp="SELECT * FROM dm_product product
								left join dm_price price
								on product.p_id=price.price_p_id
								 WHERE p_code=".$row2['h_p_code']." AND p_price_code=".$row2['h_price_code']."
								 AND
								  price_id_province=".$i."";
//print $queryp;
 $rowp= mysql_fetch_assoc($lnkp);
								  $priceh=$row2['h_amount'] * ($rowp['p_sellprice']+$row2['h_p_add']); 
								  $price=$row2['h_amount'] * $rowp['p_sellprice']; 
		
			$query = "
		UPDATE dm_havale 
		SET 
			`h_p_price` = ".$rowp['p_sellprice'].",
			`h_price` = ".$price.",
			`h_priceh` = ".$priceh."
			
		WHERE 
			h_id = ".$row2['h_id']." 
	";

	$lnk = mysql_query($query);
//	print $query;
//	if(mysql_error()) print mysql_error();
//print $query1;
		}
	}
	
}
	
function havale($sharh){
	$day_number = jdate('j');
	$month_number = jdate('n');
	$year_number = jdate('y');
	$day_name = jdate('l');
	
	$day_number=farsinum($day_number);
    $month_number=farsinum($month_number);
    $year_number=farsinum($year_number);
	 
$phd_code = isset($_REQUEST['phd_code']) ? $_REQUEST['phd_code'] : '';
$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
$h_code = isset($_REQUEST['h_code']) ? $_REQUEST['h_code'] : '';
$province_name = isset($_REQUEST['province_name']) ? $_REQUEST['province_name'] : '';
$province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
$name_customer = isset($_REQUEST['name_customer']) ? $_REQUEST['name_customer'] : '';
$price_code = isset($_REQUEST['price_code']) ? $_REQUEST['price_code'] : '';
$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
$l_id = isset($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
$year_id = isset($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';
$h_id = isset($_REQUEST['h_id']) ? $_REQUEST['h_id'] : '';
 $hdate='';
$queryHavale = "
				SELECT *  FROM dm_havale 			 
					WHERE 
				h_id = ".$h_id."  ";
					
			$lnkHavale = mysql_query($queryHavale);
		//	print $queryHavale;
			$Havale= mysql_fetch_assoc($lnkHavale);	
				
			$gdate=$Havale['h_reg_date'];
			$amount=formatMoney($Havale['h_amount']);
			$amount1=farsinum($amount);
			 $hdate=farsinum($hdate);
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$hdate = $jyear."/".$jmonth."/".$jday;
            $hdate=farsinum($hdate);
            $num=$Havale['h_num_print']+1;
            $queryn = "
				UPDATE dm_havale 
				SET 
					`h_num_print` = ".$num."
					
					
				WHERE 
					h_id = ".$h_id.""; 
			
	$lnkn = mysql_query($queryn);
//print $queryHavale;
$queryph = "
		SELECT *  FROM dm_pish_havale 			 
			WHERE 
		ph_code = ".$ph_code." 
			AND
		ph_id_province=".$province_id."
             AND
				ph_id_year=".$year_id."
		
		";
//print $queryph;
			$lnkph = mysql_query($queryph);
			$rowph= mysql_fetch_assoc($lnkph);	
		
	$queryacc = "
		SELECT *  FROM dm_operation_acc 			 
			WHERE 
		g_id = ".$rowph['ph_operation_id']." 
			
		";
//print $queryacc;
			$lnkacc = mysql_query($queryacc);
			$rowacc= mysql_fetch_assoc($lnkacc);	
			$querycus = "
					SELECT *  FROM dm_customer cus
					left join dm_city city on city.city_id=cus.customer_cusid_city			 
						WHERE 
					code_customer = ".$Havale['h_customer_code']." 
						AND
					customer_code_org=".$province_id."
					AND 
					   city_province=".$province_id."
					
					";
            
		$lnkcus = mysql_query($querycus);
			$rowcus= mysql_fetch_assoc($lnkcus);
		//	print $querycus;	
		$querycc = "
					SELECT *  FROM dm_customer_asli
					where
					
					code_customer = ".$Havale['h_customer_code']." 
						
					
					";
            
		$lnkcc = mysql_query($querycc);
			$rowcc= mysql_fetch_assoc($lnkcc);
		
					if($rowph['ph_customer_type']=='n'){
						$Type='معمولي';
					}else{
						$Type='متفرقه';
					}
$queryphd = "
		SELECT *  FROM dm_pish_havale_det 			 
			WHERE 
			phd_ph_code = ".$ph_code."  
		AND 
			phd_id_province=".$province_id." 
	  AND   
	     phd_id_year=".$year_id." 
	 		";
			$lnkphd = mysql_query($queryphd);
			$rowphd= mysql_fetch_assoc($lnkphd);
//			print $queryphd;
			 $gdate=$rowph['cm_req_date'];	
			// echo $gdate;
			  list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	          list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	         $cm_req_date = $jyear."/".$jmonth."/".$jday; 	                                    		
              $h_code1=farsinum($h_code);	
 //change to farsi date
    $ph_reg_date=$rowph['ph_reg_date'];
   
  
	list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $ph_reg_date ); 
	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	$ph_reg_date = $jyear."/".$jmonth."/".$jday;
	$ph_reg_date =farsinum($ph_reg_date);
	
	 $cm_req_date=$rowph['cm_req_date'] ;
	list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $cm_req_date ); 
	list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	$cm_req_date = $jyear."/".$jmonth."/".$jday;
	
	$cm_req_date=farsinum($cm_req_date); 
    $cm_req_num=farsinum($rowph['cm_req_num']); 
    $ph_code1=farsinum($ph_code); 
    $customer_code=farsinum($Havale['h_customer_code']);
    $ph_mojavez=farsinum($rowph['ph_mojavez']);
//for unit
      $queryunit = "
				 	SELECT *  FROM  dm_prod_det_u 
			 
					WHERE 
						unit_prod_id = ".$Havale['h_id_unit']." 
				";
				$lnkunit = mysql_query($queryunit);
				$rowunit= mysql_fetch_assoc($lnkunit);
						        
	$out='<table id="hcss" align="center"  dir="rtl"   width=85% >
                   <tr>
                      <td align="center" colspan="16" style="text-shadow: -1px 0 black, 0 1px black;"><img src="images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
                     
   
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $province_name .'</b> </td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
                    <tr> 
                         <td colspan="8" ><center><b> حواله تحويل كالا</b></center></td>
                        
                    </tr>
                    <tr>
					
                    <td align="left" colspan="4">
                        <table  align="left" >
                                 <tr>
                                    <td ><font color="red"><b>مقدار : '.$amount1.'كيلوگرم </b></font></td>
                                    
                                </tr>
                                 <tr>
                                    <td ><font color="red"><b>مقدار : '.num_str_float($Havale['h_amount']).'كيلوگرم </b></font></td>
                                    
                               </tr>
                              
                                <tr>
                                    <td ><font color="red"><b> '.$sharh.' </b></font></td>
                                    
                                </tr>
                        </table>
                        </td>
                     </tr>
                    <tr> 
                         <td colspan="8" ><center>&nbsp;</center></td>
                        
                    </tr>
                    <tr >  
                     <td  width=15%><b>شماره حواله:</b></td>
				         <td  width=10%><b>'.$h_code1.'('.$h_code.')</b></td>
                     <td  width=10%><b>تاريخ  حواله:</b></td>
				         <td  width=10%>'.$hdate.'</td>
                     </tr>
                      <tr>				      
				       <td  width=20% ><b>شماره پيش حواله:</b></td>
				       <td    width=10%>'.$ph_code1.'</td>
				       <td  width=20% ><b>تاریخ پیش حواله:</b></td>
				       <td  >'.$ph_reg_date.'</td>
                    </tr>
                    <tr> 
                         <td colspan="8">&nbsp;&nbsp;&nbsp;</td>
                        
                    </tr>
                    
                    <tr>
                    <td   width=20%><b>شماره درخواست :</b></td><td width="25%" ><b>'.$cm_req_num.'</b></td>
				         <td  width=15% ><b>تاريخ درخواست :</b></td><td width="15%"><b>'.$cm_req_date.'</b></td> 				    
  
                    </tr>
                    <tr>
                         <td  ><b> نام مشتري :</b></td>
					     <td align="right" ><b>'.$name_customer.'</b></td>	
					     <td > <b>كد مشتري :</b></td>
					     <td >'.$customer_code.'</td> 			     
					     
					  </tr>
					  <tr>
                             <td  ><b> مجوز :</b></td>
					     <td align="right" ><b>'.$ph_mojavez.'</b></td>
					      <td  ><b> نوع عمليات :</b></td>
					     <td align="right" ><b>'.$rowacc['g_acc_name'].'('.$rowacc['g_code'].')</b></td>		     
					  </tr>
				 <tr>  
                       <td  width="20%"><b> شناسه ملی :</b></td><td width="10%"><b>'.$rowcc['customer_national_tax'].'</b></td>
				       <td align="center" width="15%"><b>کد/شماره ملی</b></td><td width="15%"><b>'.$rowcc['customer_gl_code'].'</b></td>				      
				       <td align="center" width="15%"><b>کد اقتصادی</b></td>
				       <td  align="center" >'.$rowcc['customer_gl_economic'].'</td> 
                    </tr>
                    
                    </table><br><br>';
		
$queryp = "
		SELECT *  FROM dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id 			 
			WHERE 
			     p_code = ".$p_code." 
			 AND p_price_code=".$price_code." 
			 AND price_id_province=". $province_id ."
			 "; 
				 $lnkp = mysql_query($queryp);
				 $rowp= mysql_fetch_assoc($lnkp);
//print $queryp;

	
	  	
	  	$hazine=$Havale['h_p_add'];
	 
					
				 $querycat = "
		SELECT *  FROM dm_prod_det_c  			 
			WHERE 
			     cat_prod_id = ".$rowp['p_category']." 
			
			 "; 
				 $lnkcat = mysql_query($querycat);
				 $rowcat= mysql_fetch_assoc($lnkcat);
//				 print $querycat;
				 $queryl = "
		SELECT *  FROM dm_location_goods 			 
			WHERE 
			     l_id = ".$l_id." 
			  
			 "; 
				 $lnkl = mysql_query($queryl);
				 $rowl= mysql_fetch_assoc($lnkl);
               
		//print $queryl;
         $l_code=farsinum($rowl['l_code']); 
		$p_sellprice1=farsinum($rowp['p_sellprice']);
    	$price=formatMoney($Havale['h_priceh']);
    	$amount=formatMoney($Havale['h_amount']);
    	$p_code=farsinum($rowp['p_code']); 
    	$p_price_code=farsinum($rowp['p_price_code']); 
    	$amount1=farsinum($amount);
    	$price1=farsinum($price);
    	
    	$hhazine=$Havale['h_p_add'] * $Havale['h_amount'];
    	$hhazine=urlencode($hhazine);
    	$hhazine=formatMoney($hhazine);
    	$hhazine=farsinum($hhazine);
		$out .='<table  border="1" dir="rtl" style=" border-top-style: solid;
       border-right-style: solid;
       border-bottom-style: solid;" cellpadding="2px;" align="center" width=85%>
				
		       <tr>
		         <td width=20% align="center" style="font-weight:bold;">نام كالا:</td>
				 <td >'.$rowp['p_name'].'</td>
				 <td align="center" style="font-weight:bold;">كد كالا:</td>
				 <td >'.$p_code.'</td>
				 <td width=10% align="center" style="font-weight:bold;">كد قيمت:</td>
				 <td colspan="10">'.$p_price_code.'</td>
			</tr>
			<tr>
			
				<td align="center" style="font-weight:bold;">نوع بسته بندي :</td>
				<td  > '.$rowcat['cat_prod_name'].'</td>
				<td style="font-weight:bold;" align="center">مقدار خريد:</td>
				<td   >'.$amount1.''.$rowunit['unit_prod_name'].'</td>
				<td  colspan="2" style="font-weight:bold;" align="center">قيمت واحد:</td>
				<td  colspan="3" >'.$p_sellprice1.'ريال</td>
				<td  colspan="3" style="font-weight:bold;" align="center">هزينه هر واحد</td>
				<td  colspan="1" >'.$hazine.'ريال</td>
				
			</tr>
			<tr>
			    <td align="center" style="font-weight:bold;">كد محل تحويل:</td>
				<td >'.$l_code.'</td>
				<td width=15% style="font-weight:bold;" align="center">نام محل تحويل:</td>
				<td ><b>'.$rowl['l_name'].'</b></td>
				<td align="center" style="font-weight:bold;" align="center">بهاي كالا  :
			    <td >'.$price1.'ريال </td>
			   <td align="center" style="font-weight:bold;" align="center">بهای هزينه اضافی  :
			    <td >'.$hhazine.'ريال </td>
			    <td align="center" style="font-weight:bold;"colspan="4" align="center">نام تحويل گيرنده: </td>
			    <td  >'.$Havale['h_deli_name'].'</td>
				
			</tr>
			   
			</tr>
			
			</table>
	        </td>
	       </tr>
	
			</table>
			</div>  ';
		      			 
	
					if($rowp['p_category']==7){
						$querys = "
					SELECT *  FROM dm_signature_g 
						 
								WHERE 
									sig_status = ". 1 ." 
									AND
								   sig_id_province=".$province_id  ."
							";
					$lnks = mysql_query($querys);
					$rows= mysql_fetch_assoc($lnks);
						$sig1_h=$rows['sig1_h'];
						$sig2_h=$rows['sig2_h'];
						$sig3_h=$rows['sig3_h'];
						$sigs1_h=$rows['sigs1_h'];
						$sigs2_h=$rows['sigs2_h'];
						$sigs3_h=$rows['sigs3_h'];
						$text_h=$rows['text_h'];
					}else{
							$querys = "
					SELECT *  FROM dm_signature_o 
						 
								WHERE 
									sig_ostatus = ". 1 ." 
									AND
								   sig_oid_province=".$province_id  ."";
							
							
					$lnks = mysql_query($querys);
					$rows= mysql_fetch_assoc($lnks);
						
					   $sig1_h=$rows['sig1_oh'];
						$sig2_h=$rows['sig2_oh'];
						$sig3_h=$rows['sig3_oh'];
						$sigs1_h=$rows['sigs1_oh'];
						$sigs2_h=$rows['sigs2_oh'];
						$sigs3_h=$rows['sigs3_oh'];
						$text_h=$rows['text_oh'];
					
					}
		 $out.= '<table    dir="rtl" align="center"   width=75%>
           <tr>
               <td ><b>'.$sig1_h.'</b></td>
               <td width=20%>&nbsp;</td>
               <td><b>'.$sig2_h.'</b></td>
                <td width=20%>&nbsp;</td>
                 <td><b>'.$sig3_h.'</b></td>
           </tr>
           <tr>
               <td ><b>'.$sigs1_h.'</b></td>
               <td width=20%>&nbsp;</td>
               <td><b>'.$sigs2_h.'</b></td>
                <td width=20%>&nbsp;</td>
                 <td><b>'.$sigs3_h.'</b></td>
           </tr>
           <tr>
              <td style="height:40px;"> &nbsp;</td>
             
           </tr>
           <tr>
		        <td colspan="5" align="center">'.$text_h.'</td>
		     </tr>
            <tr>
		        <td colspan="5" align="center"><font color="red">  خانم/آقای/شرکت <font color="blue">'.$Havale['h_deli_name'].'</font>       به عنوان نماینده <font color="blue">'.$name_customer.'</font> ،جهت تحویل موضوع این حواله معرفی می گردد.تحویل به نامبرده به منزله قبض مبیع و فراغت ذمه تلقی می شود.</font> </td>
		     </tr>
		     <tr>
		        <td colspan="5" align="center"><font color="red"> محل امضا و اثر انگشت</font> </td>
		     </tr>
           </table><br>';
		 echo $out;
}
$sharh='نسخه اول/ مخصوص انبار';		
 havale($sharh);
 echo '<div style="page-break-before:always";>&nbsp;</div>'; 
 $sharh='نسخه دوم/ مخصوص حسابداری';
havale($sharh);
 echo '<div style="page-break-before:always";>&nbsp;</div>';
 $sharh='نسخه سوم/ مخصوص فروش';
havale($sharh);
?>

 <style type="text/css" media="print">
      div.page
      {
        page-break-after: always;
        page-break-inside: avoid;
      }
    </style>
<?php 
if($rowp['p_category']==7)
{
$outhtml='';
	$outhtml='<table id="hcss" align="center"  dir="rtl"   width=85% >
                  
                    <tr> 
                         <td colspan="8" ><center><b> ضمیمه حواله</b></center></td>
                        
                    </tr>
                     <tr >  
                     <td  width=15%><b>شماره حواله:</b></td>
				         <td  width=10%><b>'.$h_code1.'('.$h_code.')</b></td>
                    <td  width=10%><b>تاريخ  حواله:</b></td>
				         <td  width=10%>'.$hdate.'</td>
                     </tr>
                    <tr> 
                         <td colspan="8" ><center>&nbsp;</center></td>
                        
                    </tr>
                   
                    </table><br><br>';

$querydad="SELECT * FROM dm_anbar_det WHERE dad_phd_id=".$Havale['h_phd_id']." 
			 ";
								        
			$lnkdad = mysql_query($querydad);
			//$rowdad = mysql_fetch_assoc($lnkdad);
			//$dad_anbar_id=$rowdad['dad_anbar_id'];
			//echo $querydad;
			$dad_anbar_id='';
			while($rowdad = mysql_fetch_assoc($lnkdad))
			{
				
				$dad_anbar_id .= ' or mojody_kala.id='.$rowdad['dad_anbar_id'].' ';
				
			}
			
			
		//echo 	$querydad;
		$query222="SELECT * FROM dm_location_goods WHERE l_id=".$Havale['h_l_code']."
										           ";
										
									//	print $querych;
										$lnk222 = mysql_query($query222);
										$row222 = mysql_fetch_assoc($lnk222);			
										$l_code= $row222['l_code'];	
			
				
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());
			
	$queryanbar = "
		select 
		 mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton From mojody_kala
          INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala
          INNER JOIN keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
          LEFT JOIN karton ON mojody_kala.code_karton=karton.code_karton 
          INNER JOIN tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar  	  
	      WHERE mojody_kala.code_kala='". $Havale['h_p_code'] ."' AND mojody_kala.code_ostan='". $Havale['h_id_province'] ."'  AND  mojody_kala.code_anbar='". $l_code ."'  AND mojody_kala.year='1396' AND mojody_kala.deleted=0
	      and mojody_kala.id= 123654 $dad_anbar_id
		 order by sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi asc ";

	
	$outhtml .='  <table width="763" border="1" align="center">
    <tr>
      <td width="115" rowspan="2"><div align="center">مقدار خرید </div></td>
      <td width="100" rowspan="2"><div align="center">وزن کارتن </div></td>
      <td colspan="3"><div align="center">تاریخ تولید </div></td>
      <td width="97" rowspan="2"><div align="center">تولید کننده </div></td>
       <td width="97" rowspan="2"><div align="center">کشور </div></td>
      <td width="97" rowspan="2"><div align="center">زیر انبار </div></td>
      <td width="86" rowspan="2"><div align="center">ردیف</div></td>
    </tr>
    <tr>
      <td width="71">روز</td>
      <td width="63">ماه</td>
      <td width="82">سال</td>
    </tr>';
//echo $queryanbar;
$inx=1;
			$lnkanbar = mysql_query($queryanbar);
			while($rowanbar = mysql_fetch_assoc($lnkanbar))
			{
			
			$queryu="SELECT * FROM sell.dm_anbar_det WHERE dad_anbar_id=".$rowanbar['id']."  
			and dad_phd_id=".$Havale['h_phd_id']."
			 ";
	//echo $queryu;		
				
             $lnku = mysql_query($queryu);
			$rowu = mysql_fetch_assoc($lnku); 
			if($rowu['dad_no']==8){
				
				$vazn_karton=$rowu['dad_tedad'];
				
			}else{
				
				if(($rowp['p_code']==50) or ($rowp['p_code']==54)){
				
					$vazn_karton=$rowu['dad_tedad'];
					
				}else{
					
				$vazn_karton=$rowu['dad_vazn_kh'];
				}
			}
				
			$outhtml .=' <tr>
				      
						    <td>'.$vazn_karton.'</td>
						    <td>'.$rowanbar['vazn_karton_this'].'</td>
						    <td>'.$rowanbar['rouz_tolid_shamsi'].'</td>
						    <td>'.$mahshamsiArr[$rowanbar['mah_tolid_shamsi']].'</td>
						    <td>'.$rowanbar['sal_tolid_shamsi'].'</td>
						    <td>'.$rowanbar['name_tolidkonande'].'</td>
						    <td>'.$rowanbar['name_keshvar'].'</td>
						    <td>'.$rowanbar['name_ziranbar'].'</td>
			                 <td>'.$inx.'</td>
					    </tr>';
					    
        $inx++;    
			}

$outhtml .=' 
                    
                    <table>';
echo $outhtml;
}

function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
} 
function farsinum( $data )
{
$newstr = "";
$i = 0;
for ( ; $i < strlen( $data ); ++$i )
{
$str = $data[$i];
$nstr = $str;
if ( $str == "0" )
{
$nstr = str_replace( "0", "۰", $str );
}
if ( $str == "1" )
{
$nstr = str_replace( "1", "۱", $str );
}
if ( $str == "2" )
{
$nstr = str_replace( "2", "۲", $str );
}
if ( $str == "3" )
{
$nstr = str_replace( "3", "۳", $str );
}
if ( $str == "4" )
{
$nstr = str_replace( "4", "۴", $str );
}
if ( $str == "5" )
{
$nstr = str_replace( "5", "۵", $str );
}
if ( $str == "6" )
{
$nstr = str_replace( "6", "۶", $str );
}
if ( $str == "7" )
{
$nstr = str_replace( "7", "۷", $str );
}
if ( $str == "8" )
{
$nstr = str_replace( "8", "۸", $str );
}
if ( $str == "9" )
{
$nstr = str_replace( "9", "۹", $str );
}
$newstr .= $nstr;
}
return $newstr;
}

                           
function num_str_float($number){
	$arr_number[]='';
	$arr_number ['2']='';
	$number_to_alphabet_0='';
$pos=strpos($number,".");
	
if($pos>0){
	$sub=  substr($number,0, $pos );

   $sub=	asli($sub);
	$sub= $sub .  " ممیز " . asli(substr($number, $pos +1,strlen($number)-$pos )); 
	$ashar = strlen($number)-$pos -1;
	if($ashar == 1) $sub.= " دهم ";
	if($ashar == 2) $sub.= " صدم  ";
	if($ashar == 3) $sub.= " هزارم ";
	if($ashar == 4) $sub.= " دهزارم ";
	 return $sub;
}	
else
{return asli($number);}
	
	
}		
echo num_str_float($number);	
function change_to_alphabet ( $new_number )
{
$arr_alphabet = array ( 'صفر' , 'یک' , 'دو' , 'سه' , 'چهار' , 'پنج' , 'شش' , 'هفت' , 'هشت' , 'نه' , 'ده' , 'یازده' , 'دوازده' , 'سیزده' , 'چهارده' , 'پانزده' , 'شانزده' , 'هفده' , 'هجده' , 'نوزده' , 'بیست' , 'سی' , 'چهل' , 'پنجاه' , 'شصت' , 'هفتاد' , 'هشتاد' , 'نود' , 'یکصد' , 'دویست' , 'سیصد' , 'چهارصد' , 'پانصد' , 'ششصد' , 'هفتصد' , 'هشتصد' , 'نهصد' ) ;
$arr_number = str_split ( $new_number , 1 ) ;
//================================================== =========================
if ( $arr_number ['0'] != 0 )
{
$arr_location_0 = 28 ;
$number_location_0 = $arr_location_0 + $arr_number ['0'] - 1 ;
$number_to_alphabet_0 = $arr_alphabet [$number_location_0] ;
$number_to_alphabet_0 = "$number_to_alphabet_0" ;
}
else
$number_to_alphabet_0 = "" ;
if ( $arr_number ['1'] == 1 )
{
$number_location_1 = $arr_number ['1'].$arr_number ['2'] ;
$number_to_alphabet_1 = $arr_alphabet [$number_location_1] ;
$number_to_alphabet_1 = "$number_to_alphabet_1" ;
$number_to_alphabet_2 = "" ;
}
else
{
if ( $arr_number ['1'] != 0 )
{
$arr_location_1 = 20 ;
$number_location_1 = $arr_location_1 + $arr_number ['1'] - 2 ;
$number_to_alphabet_1 = $arr_alphabet [$number_location_1] ;
$number_to_alphabet_1 = "$number_to_alphabet_1" ;
}
else
$number_to_alphabet_1 = "" ;
if ( $arr_number ['2'] != 0 )
{
$number_location_2 = $arr_number ['2'] ;
$number_to_alphabet_2 = $arr_alphabet [$number_location_2] ;
$number_to_alphabet_2 = "$number_to_alphabet_2" ;
}
else
$number_to_alphabet_2 = "" ;
}
$number_to_alphabet = "" ;

if ( strlen ($number_to_alphabet_2) > 1 )
$number_to_alphabet = "$number_to_alphabet_2" ;

if ( (strlen ($number_to_alphabet_1) > 1) and (strlen ($number_to_alphabet) > 1) )
$number_to_alphabet = "$number_to_alphabet_1"." و $number_to_alphabet" ;
else if ( strlen ($number_to_alphabet_1) > 1 )
$number_to_alphabet = "$number_to_alphabet_1" ;

if ( (strlen ($number_to_alphabet_0) > 1) and (strlen ($number_to_alphabet) > 1) )
$number_to_alphabet = "$number_to_alphabet_0"." و $number_to_alphabet" ;
else if ( strlen ($number_to_alphabet_0) > 1 )
$number_to_alphabet = "$number_to_alphabet_0" ;

//================================================== =========================

return $number_to_alphabet ;
}
function asli($number)
{
$division = strlen ( $number ) % 3 ;

if ( $division > 0 )
if ( $division == 1 )
$number = "00$number" ;
else if ( $division == 2 )
$number = "0$number" ;

$split_number = str_split ( $number , 3 ) ;

$count = count ( $split_number ) ;
//==================== Taqsim Kardane A`dad Be DasteHaye 3 Taee ...........
$result_change_2 = "" ;

for ( $i = $count - 1 , $m = 1 ; $i >= 0 ; $i -- , $m ++ )
{
$result_change = change_to_alphabet ( $split_number [$i] ) ;

if ( strlen ( $result_change ) > 3 )
switch ( $m )
{
case 2 :
$add_to_result_change = "هزار" ;
break ;

case 3 :
$add_to_result_change = "میلیون" ;
break ;

case 4 :
$add_to_result_change = "میلیارد" ;
break ;

default :
$add_to_result_change = "" ;
}
else
$add_to_result_change = "" ;

$result_change = "$result_change $add_to_result_change" ;

if ( ($count > 1) and ($i != 0) and (strlen($result_change) > 3) )
$result_change_2 = " و $result_change"."$result_change_2" ;
else
$result_change_2 = "$result_change"."$result_change_2" ;
}	
return   $result_change_2;	
}

?>

</html>
