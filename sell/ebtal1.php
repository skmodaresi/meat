<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head> 
<body style="background-image: url(images/ebtal.PNG);background-position:center;background-attachment:fixed;background-repeat:no-repeat;">
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
.blind {

font-size:20px;


}
</style>
<?php
require_once __DIR__ . '/../mysql_compat.php';
 header('Content-Type: text/html; charset=UTF-8');
include_once 'lib/php/jdf.php';
include_once 'lib/php/db_connect.php';
include_once 'lib/php/gen_def.php';

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
$his_id = isset($_REQUEST['his_id']) ? $_REQUEST['his_id'] : '';
$ebh_code = isset($_REQUEST['ebh_code']) ? $_REQUEST['ebh_code'] : '';
$customer_code = isset($_REQUEST['customer_code']) ? $_REQUEST['customer_code'] : '';
$queryebt = "
				SELECT *  FROM dm_ebtal_h 			 
					WHERE 
				ebh_code = ".$ebh_code."
                and
                  ebh_id_province=".$province_id ."";				
			$lnkebt= mysql_query($queryebt);
			$ebt= mysql_fetch_assoc($lnkebt);
$queryr = "
				SELECT *  FROM dm_reason_eb 			 
					WHERE 
				reb_id = ".$ebt['ebh_reb_id']."
                ";				
			$lnkr= mysql_query($queryr);
			$rowr= mysql_fetch_assoc($lnkr);
			
	$queryha = "
				SELECT *  FROM dm_havale 			 
					WHERE 
				h_code = ".$h_code."
                and
                  h_id_province=".$province_id ."";				
			$lnkha= mysql_query($queryha);
			$ha= mysql_fetch_assoc($lnkha);	
		
$queryH = "
				SELECT *  FROM dm_his_havale 			 
					WHERE 
				his_id = ".$his_id."  ";
					
			$lnkH= mysql_query($queryH);
			$H= mysql_fetch_assoc($lnkH);	
//print $queryH;
$queryph = "
		SELECT *  FROM dm_pish_havale 			 
			WHERE 
		ph_code = ".$ph_code." 
			AND
		ph_id_province=".$province_id."
             
		
		";
//print $queryph;
			$lnkph = mysql_query($queryph);
			$rowph= mysql_fetch_assoc($lnkph);
			  $ph_mojavez=farsinum($rowph['ph_mojavez']);	
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
			phd_id=".$ha['h_phd_id']."
	  
	 		";
//print $queryphd;
			$lnkphd = mysql_query($queryphd);
			$rowphd= mysql_fetch_assoc($lnkphd);
//			print $queryphd;
			 $gdate=$rowph['cm_req_date'];	
			  list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	          list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	         $cm_req_date = $jyear."/".$jmonth."/".$jday; 	                                    		
              $h_code1=farsinum($h_code);	
 //change to farsi date
              $ph_reg_date=$rowph['ph_reg_date'];
  
              $gdate=$ebt['ebh_reg_date'];	
			  list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	          list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	          $ebh_reg_date = $jyear."/".$jmonth."/".$jday; 	                                    		
              $ebh_reg_date=farsinum($ebh_reg_date);
              
              $gdate=$ha['h_reg_date'];	
			  list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	          list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	          $h_reg_date = $jyear."/".$jmonth."/".$jday; 	                                    		
              $h_reg_date=farsinum($h_reg_date);		
    
    
    
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
  
//for unit
      $queryunit = "
				 	SELECT *  FROM  dm_prod_det_u 
			 
					WHERE 
						unit_prod_id = ".$H['his_id_unit']." 
				";
				$lnkunit = mysql_query($queryunit);
				$rowunit= mysql_fetch_assoc($lnkunit);
		 
		$his_h_code=farsinum($H['his_h_code']);			   
        $customer_code =farsinum($customer_code );			
	$out='<table id="hcss" align="center"  dir="rtl"  width=85% >
                   <tr>
                      <td align="center" colspan="16"v style="text-shadow: -1px 0 black, 0 1px black
                                    ;"><img src="images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
                      
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b>اداره كل استان   '.$province_name .'-  شركت سهامي پشتيبان امور دام كشور  </b></td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
                    <tr> 
                         <td colspan="8" style="font-size:25px;" ><center> ابطال حواله</center></td>
                        
                    </tr>
                    <tr> 
                         <td colspan="8" ><center>&nbsp;</center></td>
                        
                    </tr>
                    <tr>  
                        <td  width=15%><b>شماره ابطالي:</b></td>
				        <td  width=10%>'.$ebh_code.'</td>
				        <td  width=10%><b>تاريخ  ابطال:</b></td>
				        <td  width=10%>'.$ebh_reg_date.'</td>
                     
                    </tr>
                    <tr>  
                     <td  width=15%><b>شماره حواله:</b></td>
				     <td  width=10%>'.$his_h_code.'</td>
                     <td  width=10%><b>تاريخ  حواله:</b></td>
				     <td  width=10%>'. $h_reg_date.'</td>
                    </tr>
                    <tr>				      
				      <td  width=20% ><b>شماره پيش حواله:</b></td>
				      <td  width=10% style="font-size:20px;color:red;">'.$ph_code1.'</td>
				      <td  width=20% ><b>تاریخ پیش حواله:</b></td>
				      <td>'.$ph_reg_date.'</td>
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
					     <td > <b>كد مشتری  :</b></td>
					     <td style="font-size:20px;color:red;">'.$customer_code.'</td> 			     
					     
					  </tr>
					   <tr>
					     <td > <b>علت ابطال :</b></td>
					     <td >'.$rowr['reb_reason'].'</td> 			     
					     <td > <b>شماره مجوز :</b></td>
					     <td >'.$ph_mojavez.'</td> 
					  </tr>
                    
                    </table><br><br>';
		
$queryp = "
		SELECT *  FROM dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id 			 
			WHERE 
			     p_code = ".$H['his_p_code']." 
			 AND p_price_code=".$H['his_p_pcode']." 
			 and price_id_province=".$province_id."
			 
			 "; 
				 $lnkp = mysql_query($queryp);
				 $rowp= mysql_fetch_assoc($lnkp);
$queryno = "
		 	SELECT *  FROM  dm_prod_det_t 
	 
			WHERE 
				type_prod_id = ".$rowp['p_type']." 
		";
		$lnkno = mysql_query($queryno);
		$rowno= mysql_fetch_assoc($lnkno);				 
				 $queryl = "
		SELECT *  FROM dm_location_goods 			 
			WHERE 
			     l_id = ".$rowphd['phd_l_id']." 
			  AND
			   l_id_province=".$province_id."
			 "; 
				// print $queryl;
				 $lnkl = mysql_query($queryl);
				 $rowl= mysql_fetch_assoc($lnkl);
				// print $queryl;
				//echo $rowphd['phd_l_id'];
                 global $p_types;
            $p_types1 = $pkTypes[$rowp['p_type']]['title'];
			$p_types2 = $pkTypes[$rowp['p_type']]['cmnt'];
		//print $queryl;
		$queryk="SELECT * FROM dm_product product
			  left join dm_price price
			  on product.p_id=price.price_p_id
			     WHERE p_code=".$H['his_p_code']." AND p_price_code=".$H['his_p_pcode']."
			     AND
			      price_id_province=".$province_id."";
			$lnk1 = mysql_query($queryk);
			//print $queryk;
		$row1 = mysql_fetch_assoc($lnk1);
		$queryunit="SELECT * FROM dm_prod_det_u 
	        WHERE unit_prod_id=".$H['his_id_unit']." ";
	        		           
		$lnkunit=mysql_query($queryunit);
		print mysql_error();
		//print $queryunit;
		$rowunit=mysql_fetch_assoc($lnkunit);
	    $unitName=$rowunit['unit_prod_name'];
		$ratio=$rowunit['unit_prod_ratio'];
		//echo $rowunit['unit_prod_ratio'];

	//	$phd_price=(($ratio)*($H['his_eb_amount']))*($row1['p_sellprice']);
	$ratio=1;
	$phd_price=(($ratio)*($H['his_eb_amount']))*($row1['p_sellprice']);
		$phd_price=urlencode($phd_price);
		$phd_price=formatMoney($phd_price);
    	$phd_price=farsinum($phd_price); 
    	
        $phd_p_price=$row1['p_sellprice'];
       $hhazineh= $ha['h_p_add']* $H['his_eb_amount'];
       $hhazineh=urlencode($hhazineh);
       $hhazineh=formatMoney($hhazineh);
    	$hhazineh=farsinum($hhazineh); 
    
		if($H['his_eb_amount']==0){
			
			$his_eb_amount=$H['his_pre_amount'];
		}else{
		       $his_eb_amount=$H['his_eb_amount'];	
			
		}if($phd_price==0){
			$price=$H['his_price_pre'];
		}else{
			
			$price=$phd_price;
		}
	    $meghdarpre=$H['his_pre_amount'];
    	$price=formatMoney($price);
    	$amount=formatMoney($his_eb_amount);
    	$p_code=farsinum($H['his_p_code']); 
    	$p_price_code=farsinum($H['his_p_pcode']); 
    	$amount1=farsinum($amount);
    	$meghdarpre=farsinum($meghdarpre);   	
    	$price1=formatMoney($price);
    	$price1=farsinum($price1);
    	$l_code=farsinum($rowl['l_code']); 
		$out .='<table  border="1" dir="rtl" style=" border-top-style: solid;
       border-right-style: solid;
       border-bottom-style: solid;" cellpadding="2px;" align="center" width=85%>
				
		       <tr>
		         <td width=20% align="center" style="font-weight:bold;">نام كالا:</td>
				 <td >'.$rowp['p_name'].'</td>
				 <td align="center" style="font-weight:bold;">كد كالا:</td>
				 <td >'.$p_code.'</td>
				 <td width=10% align="center" style="font-weight:bold;">كد قيمت:</td>
				 <td >'.$p_price_code.'</td>
			</tr>
			<tr>
				<td align="center" style="font-weight:bold;">نوع كالا :</td>
				<td  > '.$rowno['type_prod_name'].'</td>
				<td style="font-weight:bold;" align="center">مقدار اوليه:</td>
				<td  >'.$meghdarpre.''.$rowunit['unit_prod_name'].'</td>
				<td style="font-weight:bold;" align="center">مقدار ابطالی:</td>
				<td  >'.$amount1.''.$rowunit['unit_prod_name'].'</td>				
			</tr>
			<tr>
			    <td align="center" style="font-weight:bold;">كد محل تحويل:</td>
				<td >'.$l_code.'</td>
				<td width=15% style="font-weight:bold;" align="center">نام محل تحويل:</td>
				<td colspan="0" >'.$rowl['l_name'].'</td>
				<td width=15% style="font-weight:bold;" align="center">هزينه اضافی هرواحد</td>
				<td colspan="3" >'.$ha['h_p_add'].'ريال</td>
				
			</tr>
			<tr>
			<td align="center" style="font-weight:bold;" align="center">بهاي مقدار كالايی كه ابطال شده   :
			<td >'.$phd_price.'ريال </td>
			<td align="center" style="font-weight:bold;" align="center">بهای هزينه اضافی كالا   :
			<td >'.$hhazineh.'ريال </td>
			
			<td align="center" style="font-weight:bold;" align="center">نام تحويل گيرنده: </td>
			 <td colspan="3" >'.$H['his_deli_name'].'</td>
			
			<tr>
			   
			</tr>
			<tr> 
			   <td colspan="8"> نام و امضاي مشتري
			   ...............</td>
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
						$sig1_eb=$rows['sig1_eb'];
						$sig2_eb=$rows['sig2_eb'];
						$sig3_eb=$rows['sig3_eb'];
						$sigs1_eb=$rows['sigs1_eb'];
						$sigs2_eb=$rows['sigs2_eb'];
						$sigs3_eb=$rows['sigs3_eb'];
						$text_eb=$rows['text_eb'];
					}else{
							$querys = "
					SELECT *  FROM dm_signature_o 
						 
								WHERE 
									sig_ostatus = ". 1 ." 
									AND
								   sig_oid_province=".$province_id  ."";
							
							
					$lnks = mysql_query($querys);
					$rows= mysql_fetch_assoc($lnks);
						
					   $sig1_eb=$rows['sig1_oeb'];
						$sig2_eb=$rows['sig2_oeb'];
						$sig3_eb=$rows['sig3_oeb'];
						$sigs1_eb=$rows['sigs1_oeb'];
						$sigs2_eb=$rows['sigs2_oeb'];
						$sigs3_eb=$rows['sigs3_oeb'];
						$text_eb=$rows['text_oeb'];
					
					}
		 $out.= '<table    dir="rtl" align="center"   width=75%>
           <tr>
               <td ><b>'.$sig1_eb.'</b></td>
               <td width=20%>&nbsp;</td>
               <td><b>'.$sig2_eb.'</b></td>
                <td width=20%>&nbsp;</td>
                 <td><b>'.$sig3_eb.'</b></td>
           </tr>
           <tr>
               <td ><b>'.$sigs1_eb.'</b></td>
               <td width=20%>&nbsp;</td>
               <td><b>'.$sigs2_eb.'</b></td>
                <td width=20%>&nbsp;</td>
                 <td><b>'.$sigs3_eb.'</b></td>
           </tr>
           <tr>
              <td style="height:40px;"> &nbsp;</td>
             
           </tr>
           <tr>
		        <td colspan="5" align="center">'.$text_eb.'</td>
		     </tr>
           
           </table><br><br>';
echo $out;
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
?>

</body>
</html>