	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 header('Content-Type: text/html; charset=UTF-8');
    include_once '../lib/php/jdf.php';
    include_once '../lib/php/db_connect.php';
    include_once '../lib/php/gen_def.php';
  
    $day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');    
	$day_number=farsinum($day_number);
    $month_number=farsinum($month_number);
	$year_number=farsinum( $year_number);
	
         $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] :'2010-01-01' ;
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '2018-03-01';
		 $firstDatef = !empty($_REQUEST['firstDatef']) ? $_REQUEST['firstDatef'] :'' ;
		 $EndDatef = !empty($_REQUEST['EndDatef']) ? $_REQUEST['EndDatef'] : '';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '2';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2' ;
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $u_id = !empty($_REQUEST['u_id']) ? $_REQUEST['u_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $firstHour = !empty($_REQUEST['firstHour']) ? $_REQUEST['firstHour'] : '24';     
		 $EndHour = !empty($_REQUEST['EndHour']) ? $_REQUEST['EndHour'] : '24';	
		 $firstHour = !empty($_REQUEST['firstHour']) ? $_REQUEST['firstHour'] : '13';     
		 $EndHour = !empty($_REQUEST['EndHour']) ? $_REQUEST['EndHour'] : '13';	
		// echo $firstDate;
		 //echo  $EndDate;
		// global $outHtml;
		// global $outHtml1;
		// global $outHtml2;
		
		
	$firsttime=$firstDate.' '.$firstHour.':00:00';
		$Endtime=$EndDate.' '.$EndHour.':00:00';
$queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);

	$outHtml2='<div><table     align="center"  dir="rtl"  width="90%">
                   <tr>
                      <td align="center" colspan="16"  style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
   
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
             </table></div>';
	//echo $outHtml2;
	 $firstDatef1=farsinum($firstDatef);
	 $EndDatef1=farsinum($EndDatef);
	$outHtml = '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش روزانه </center> </th>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="16" style="height: 50px;vertical-align:middle;">از تاریخ  '.$firstDatef1.'   تا تاریخ '.$EndDatef1.'   (از ساعت '.$firstHour.'تا ساعت '.$EndHour.')
        			  </td>
        			
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			         <td align="center">رديف </td>			      
			        <td align="center"> شماره حواله</td>
			        <td align="center"> شماره پيش نويس</td>
			        <td align="center"> تاريخ حواله</td>
			        <td align="center"> شماره مجوز</td>
			        <td align="center"> نام کالا</td>
			        <td align="center">مقدار اولیه خرید</td>
			        <td align="center">مقدار ابطالی</td>
			        <td align="center"> مقدار جاری</td>
			        <td align="center"> قيمت واحد</td>
			        <td align="center"> مبلغ قابل پرداخت</td>
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			        <td align="center">دسته بندي مشتری</td>
			        <td align="center">نام شهر</td>	
			          <td align="center">آدرس</td>	
			        <td align="center">وضعیت</td>			    		        		        
				</tr>';
		
	$query1 = " 
	select c.* ,cus2.* ,cuscat.category_name
from (
select h_code , ph_code ,ebt.ebh_reg_date as date1,ebt2.ebh_reg_date as date, h_reg_date , ph_mojavez , p_name , p_sellprice , h_amount ,
 l_name , h_customer_code 
 , case when h.`h_status` = 1
  then 'ابطال کلی' else case when his.his_h_id is null then 'ابطال نشده' else 'ابطال جزئی' end end as
   STATUS_EBTAL , case when h.`h_status` = 1 then h.`h_amount` else case when his.his_h_id is null then 
   0 else his.`his_eb_amount` end end as MEGHDAR_EBTAL
   
    , case when h.`h_status` = 1 then h.`h_amount` else case when his.his_h_id is null then h.`h_amount`
     else SUM( his.`his_pre_amount`)    end end as MEGHDAR_PRE 
     
     
     , case when h.`h_status` = 1 then 0 else case when his.his_h_id is null then h.h_price else h.h_price end end as SUM_price 
     from dm_havale h left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$province_id."
    
     left join dm_price price on p.p_id=price.price_p_id and price.`p_price_code`=h.`h_price_code`
     left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type
     left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
     left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
     left join dm_location_goods l on l.l_id=h.h_l_code 
     left join dm_pish_factor pf on h.h_pf_code=pf.pf_code  and pf_id_province=".$province_id."
     left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code  and ph_id_province=".$province_id."
     left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` 
     left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1  and ebt.ebh_id_province=".$province_id."
       and (ebt.ebh_reg_time  between  '".$firsttime."'  AND  '".$Endtime."' or h.h_reg_time  between  '".$firsttime."'  AND  '".$Endtime."'  )
     left join dm_ebtal_h ebt2 on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 and ebt2.ebh_id_province=".$province_id."
        and (ebt2.ebh_reg_time  between  '".$firsttime."'  AND  '".$Endtime."'  or h.h_reg_time  between  '".$firsttime."'  AND  '".$Endtime."' )
        where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
  and ph_id_province=".$province_id." )and(  ebt2.ebh_reg_time  between  '".$firsttime."'  AND  '".$Endtime."'  or h.h_reg_time  between  '".$firsttime."'  AND  '".$Endtime."' )
  
  or

   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
  ph_id_province=".$province_id." )
and (ebt.ebh_reg_time  between  '".$firsttime."'  AND  '".$Endtime."'  or   h.h_reg_time  between  '".$firsttime."'  AND  '".$Endtime."' )


  )  ";
       	

//	print $query;		
			
if ($p_code != -2){
		
		$query1 .= "  AND h_p_code= ". $p_code ." ";
	}
if ($p_price_code != -2){
		
		$query1 .= " AND p_price_code = ". $p_price_code ." ";
	}
if ($p_type != -2){
		
		$query1 .= " AND p_type = ". $p_type ." ";
	}
if ( $p_category != -2){
		
		$query1 .= " AND  p_category = ".$p_category ." ";
	}
if ($l_id != -2){
		
		$query1 .= " AND  h_l_code = ".$l_id ." ";
	}

if ($p_pakage_type != -2){
		
		$query1 .= " AND   p_pakage_type = ".$p_pakage_type ." ";
	}
if ($p_subsidies != -2){
		
		$query1 .= " AND   p_subsidies = ". $p_subsidies ." ";
	}	
	
	if ($ph_mojavez != -2){
		 
		$query1 .= "  AND   ph_mojavez = '". $ph_mojavez ."' ";
	}
		
	$query1 .= " group by `h_code` 
         ) as c 
          
          left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$province_id."
          ";
	if ($code_customer != -2){
		
		$query1 .= " AND  h_customer_code= ". $code_customer ." ";
	}
	
	$query1 .= "left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id  ";
         
	if ($category_id != -2){
		 
		$query1 .= "  AND   category_id= ". $category_id ." ";
	}
	
	if ($code_customer != -2 AND $city_id != -2){
		
		$query1 .= " where  h_customer_code= ". $code_customer ."  AND   customer_cusid_city= ". $city_id ." ";
	}else if( $code_customer != -2){
		$query1 .= " where  h_customer_code= ". $code_customer ."";
		
	}else if ($city_id != -2){
		 
		$query1 .= " where   customer_cusid_city= ". $city_id ." ";
	}
	$query1 .=" ORDER BY h_code asc";
	
	 
		
	$lnk1 = mysql_query($query1);
	global $inx;
	global $inx1;
	$inx=1;
	$inx1=1;
	$amount=0;
	$price=0;
    $amountebtal=0;
    $jari2=0;
  
	if(mysql_affected_rows()>0){
			
		while($row = mysql_fetch_assoc($lnk1)){
						
				$gdate=$row['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
						
		if($inx1==100000){
				
				$inx1=1;
				
				$outHtml .= '<tr colspan="29" align="center" style="height: 50px;vertical-align:middle;"><td colspan="16">&nbsp;</td>
				       </tr>
				   <tr><td colspan="19">&nbsp;</td>
				       </tr>
				         <td colspan="19">
								<table     align="center"  dir="rtl"  width="90%">
				                   <tr>
				                      <td align="center" colspan="16"v style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="20" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
				                    </table>
				              </td>
                   
				
				</tr></table></div>';
			
	 
				$outHtml .= '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="25" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center>گزارش ساعتی حواله ها </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			         <td align="center">رديف </td>			      
			        <td align="center"> شماره حواله</td>
			        <td align="center"> شماره پيش نويس</td>
			        <td align="center"> تاريخ حواله</td>
			        <td align="center"> شماره مجوز</td>
			        <td align="center"> نام کالا</td>
			        <td align="center">مقدار اولیه خرید</td>
			        <td align="center">مقدار ابطالی</td>
			        <td align="center"> مقدار جاری</td>
			        <td align="center"> قيمت واحد</td>
			        <td align="center"> مبلغ قابل پرداخت</td>
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			        <td align="center">دسته بندي مشتري</td>
			        <td align="center">نام شهر</td>	
			         <td align="center">آدرس</td>	
			        <td align="center">وضعیت</td>			    		        		        
				</tr>';
									            
			}	
			$queryc="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['h_customer_code']."
									    AND
									     customer_code_org=".$province_id."";									     	     											
								$lnkc = mysql_query($queryc);
								$rowc = mysql_fetch_assoc($lnkc);	
								$querycity="SELECT * FROM dm_city 
									    WHERE
									      city_id=".$rowc['customer_cusid_city']."
									   ";									     	     											
								$lnkcity = mysql_query($querycity);
								$rowcity = mysql_fetch_assoc($lnkcity);	
							//	print $querycity;
					if(($inx)%2==1){
							$color='#C5DED0';
							
						
						}
							else{
								$color='#BBB';
							   
							}
		$h_code=farsinum( $row['h_code']);	
	    $ph_mojavez=farsinum( $row['ph_mojavez']);
	    $ph_code=farsinum( $row['ph_code']);
		$h_amount=farsinum($row['h_amount']);
		$p_sellprice=farsinum($row['p_sellprice']);	
		$SUM_price=farsinum($row['SUM_price']);
		$h_customer_code=farsinum($row['h_customer_code']);	
		$MEGHDAR_PRE=farsinum($row['MEGHDAR_PRE']);
		$MEGHDAR_EBTAL=farsinum($row['MEGHDAR_EBTAL']);
		$jdate=farsinum($jdate);	
					$inx1 =urlencode($inx);
                    $inx1=farsinum($inx1);	
                   $jari=  $row['MEGHDAR_PRE']- $row['MEGHDAR_EBTAL'];
                   $jari1 =urlencode($jari);
                    $jari1=farsinum($jari1);
                     $SUM_price=formatMoney($SUM_price);
			$outHtml .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx1.'</td>
					<td align="center" style="vertical-align:middle;">'.$h_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$ph_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td  align="center" style="vertical-align:middle;">'.$ph_mojavez.'</td>	
					<td  align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>	
					<td align="center" style="vertical-align:middle;">'.$MEGHDAR_PRE.'</td>
					<td align="center" style="vertical-align:middle;">'.$MEGHDAR_EBTAL.'</td>
					<td align="center" style="vertical-align:middle;">'.$jari1.'</td>
					
					<td align="center" style="vertical-align:middle;">'.$p_sellprice.'ريال</td>
					<td align="center" style="vertical-align:middle;">'.$SUM_price.'ريال</td>
					
				    <td align="center" style="vertical-align:middle;">'.$row['l_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$h_customer_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['category_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['customer_address_office'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['STATUS_EBTAL'].'</td>
		
				</tr>';			
			$inx++;
			$inx1++;
			 $MEGHDAR =$row['MEGHDAR_PRE']-$row['MEGHDAR_EBTAL'];
           $amount=$amount+$MEGHDAR;
           if($row['h_reg_date']==$firstDate){
           $price=$price+$row['SUM_price'];
           $jari2=$jari+$jari2;
           
           }
           $amountebtal=$amountebtal+$row['MEGHDAR_EBTAL'];
			          		
			
		}
	     $amount =urlencode($amount);
	     $amount=formatMoney($amount);
	     $amount=farsinum($amount);
         $amountebtal =urlencode($amountebtal);
         $amountebtal=formatMoney($amountebtal);
         $amountebtal=farsinum($amountebtal);
         $price =urlencode($price);
         $price=formatMoney($price);
         $price=formatMoney($price);
         $price=farsinum($price);
       	
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدار جاری حواله هایی که فقط در این تاریخ صادر شده اند):'.$jari2.'كيلوگرم </span>' ;	
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مبلغي كه بايد پرداخت شود:'.$price.'ريال </span>' ;			
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدار ابطالی:'.$amountebtal.'كيلوگرم </span>' ;		
   }else{
    	$outHtml .= '<tr><td colspan="19">هيچ اطلاعاتي موجود نيست</td></tr></table>';
    }
 // print  $query;
 //baraye asnad
	echo $outHtml;
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
     