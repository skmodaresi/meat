	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require_once __DIR__ . '/../../mysql_compat.php';
 header('Content-Type: text/html; charset=UTF-8');
	include_once '../lib/php/jdf.php';
    include_once '../lib/php/db_connect.php';
    include_once '../lib/php/gen_def.php';
    include_once '../lib/php/general.php';
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
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez']) ? $_REQUEST['ph_mojavez'] : '-2';
         $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
         $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
        

		 global $outHtml;
		 $ph_mojavez =urlencode($ph_mojavez);
$queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);

	$outHtml1='<div><table     align="center"  dir="rtl"  width="90%">
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
	echo $outHtml1;
	
	$outHtml = '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center>گزارش حواله هاي ابطالی </center> </th>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="13" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </td>
        			
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			       <td align="center">رديف </td>			      
			        <td align="center"> شماره حواله</td>
					
			        <td align="center"> تاريخ حواله</td>
					<td align="center"> شماره ابطال</td>
			         <td align="center"> تاريخ ابطالی</td>
			         <td align="center">  پيش نويس</td>
			        <td align="center"> شماره مجوز</td>
			        <td align="center"> نام کالا</td>
			      		        
			         <td align="center"> قيمت واحد</td>
			         <td align="center"> مبلغ قابل پرداخت</td>
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			         <td align="center">دسته بندي مشتري</td>
			        <td align="center">نام شهر</td>	
			       
			        <td align="center">مقدار اولیه</td>
			        <td align="center">مقدار ابطالی</td>
			        <td align="center">مبلغ ابطالی</td>
			         <td align="center"> مقدار صادره</td>					    		        		        
				</tr>';
		
	$query = " 
	select c.* ,cus2.* ,h_id_province,cuscat.category_name,h_pre_amount,g_acc_name,ebh_code
from (
select h_code ,h_id_province,h_deli_name,IFNULL(ebt.`ebh_code`,ebt2.`ebh_code`) as ebh_code,h_p_add,g_acc_name,h_pre_amount, ph_code ,ebt.ebh_reg_date as date1,ebt2.ebh_reg_date as date, h_reg_date , ph_mojavez , p_name , p_sellprice ,p_sellpriceh, h_amount ,
 l_name , h_customer_code 
 , case when h.`h_status` = 1
  then 'ابطال کلی' else case when his.his_h_id is null then 'ابطال نشده' else 'ابطال جزئی' end end as
   STATUS_EBTAL , case when h.`h_status` = 1 then h.`h_amount` else case when his.his_h_id is null then 
   0 else his.`his_eb_amount` end end as MEGHDAR_EBTAL
   
    , case when h.`h_status` = 1 then h.`h_amount` else case when his.his_h_id is null then h.`h_amount`
     else  his.`his_pre_amount`    end end as MEGHDAR_PRE 
     
     , case when h.`h_status` = 1 then 0 else case when his.his_h_id is null then h.h_priceh  else h.h_priceh end end as SUM_price 
     from dm_havale h left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$province_id."
    
     left join dm_price price on p.p_id=price.price_p_id and price.`p_price_code`=h.`h_price_code`
     left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type
      left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
      left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
      left join dm_location_goods l on l.l_id=h.h_l_code 
      left join dm_pish_factor pf on h.h_pf_code=pf.pf_code  and pf_id_province=".$province_id."
      left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code  and ph_id_province=".$province_id."
      left join dm_operation_acc acc on acc.g_id=ph.ph_operation_id AND g_acc_org=3
      left join dm_pish_havale_det phd  on ph.ph_code=phd.phd_ph_code  and phd_id_province=".$province_id."
      left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` AND his_id_province=".$province_id."
      left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1  and ebt.ebh_id_province=".$province_id." 
       and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."'  )
       left join dm_ebtal_h ebt2 on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 and ebt2.ebh_id_province=".$province_id." AND his_id_province=".$province_id."
        and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' )
        where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
  and ph_id_province=".$province_id." )and(  ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' )
  
  or

   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
  ph_id_province=".$province_id." )
and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' )


  )  ";
       	
//	print $query;		
			
if ($p_code != -2){
		
		$query .= "  AND h_p_code= ". $p_code ." ";
	}
if ($p_price_code != -2){
		
		$query .= " AND p_price_code = ". $p_price_code ." ";
	}
if ($p_type != -2){
		
		$query .= " AND p_type = ". $p_type ." ";
	}
if ( $p_category != -2){
		
		$query .= " AND  p_category = ".$p_category ." ";
	}
if ($l_id != -2){
		
		$query .= " AND  h_l_code = ".$l_id ." ";
	}

if ($p_pakage_type != -2){
		
		$query .= " AND   p_pakage_type = ".$p_pakage_type ." ";
	}
if ($p_subsidies != -2){
		
		$query .= " AND   p_subsidies = ". $p_subsidies ." ";
	}	
	
	if ($ph_mojavez != -2){
		 
		$query .= "  AND   ph_mojavez = '". $ph_mojavez ."' ";
	}
		
	$query .= " group by `h_code` ,ebt.ebh_h_id, ebt2.ebh_h_id
         ) as c 
          
          left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$province_id."
          ";
	
	if ($code_customer != -2){
		
		$query .= " AND  h_customer_code= ". $code_customer ." ";
	}
	
	$query .= "left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id  ";
         
	if ($category_id != -2){
		 
		$query .= "  where   category_id= ". $category_id ." ";
	}
	
	if ($code_customer != -2 AND $city_id != -2){
		
		$query .= " where  h_customer_code= ". $code_customer ."  AND   customer_cusid_city= ". $city_id ." ";
	}else if( $code_customer != -2){
		$query .= " where  h_customer_code= ". $code_customer ."";
		
	}else if ($city_id != -2){
		 
		$query .= " where   customer_cusid_city= ". $city_id ." ";
	}
//	 if ($phd_deli_name != -2){
//		 
//		$query .= " where   phd_deli_name= '%".$phd_deli_name."%'  ";
//	}
	$query .=" ORDER BY h_code asc  ";
//print $query;
	$lnk = mysql_query($query);
	global $inx;
	global $inx1;
	$inx=1;
	$inx1=1;
	$amount=0;
	$price=0;
    $amountebtal=0;
    $MEGHDAR1=0;
    $jamebtal=0;
	if(mysql_affected_rows()>0){
			
		while($row = mysql_fetch_assoc($lnk)){
					
				$gdate=$row['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if($row['ebh_reg_date']==''){
				
				$gdate=$row['date'];
				
			}else{
				
				$gdate=$row['ebh_reg_date'];
			}
			
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate1 = $jyear."/".$jmonth."/".$jday;	
				if($row['MEGHDAR_EBTAL']==0){
						
						$jdateebtal="-----";
					}else if ($row['date']==''){
						
						$gdate=$row['date1'];
						list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
						list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
						$jdateebtal = $jyear."/".$jmonth."/".$jday;
						
					}else if ($row['date1']==''){
						
						$gdate=$row['date'];
						list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
						list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
						$jdateebtal = $jyear."/".$jmonth."/".$jday;
						
					}		
		if($inx1==20){
				
				$inx1=1;
				
				$outHtml .= '<tr colspan="25" align="center" style="height: 50px;vertical-align:middle;"><td colspan="12">&nbsp;</td>
				       </tr>
				   <tr><td colspan="15">&nbsp;</td>
				       </tr>
				         <td colspan="15">
								<table     align="center"  dir="rtl"  width="90%">
				                   <tr>
				                      <td align="center" colspan="16"v style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="12" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
				                    </table>
				              </td>
                   
				
				</tr></table></div>';
			
	 	
				$outHtml .= '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="25" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش حواله هاي ابطالی </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			         <td align="center">رديف </td>			      
			        <td align="center"> شماره حواله</td>
			        <td align="center"> تاريخ حواله</td>
					<td align="center"> شماره ابطال</td>
			        <td align="center"> تاريخ ابطالی</td>
			        <td align="center">  پيش نويس</td>
			        <td align="center"> شماره مجوز</td>
			        <td align="center"> نام کالا</td>
			        <td align="center"> قيمت واحد</td>
			        <td align="center"> مبلغ قابل پرداخت</td>
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			        <td align="center">دسته بندي مشتري</td>
			        <td align="center">نام شهر</td>	
			       	
			        <td align="center">مقدار اولیه</td>
			        <td align="center">مقدار ابطالی</td>
			        <td align="center">مبلغ ابطالی</td>			        
			         <td align="center"> مقدار صادره</td>				    		        		        
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
							$MEGHDAR =($row['MEGHDAR_PRE'])-($row['MEGHDAR_EBTAL']);
							$mablaghEbtali=$row['MEGHDAR_EBTAL']* $row['p_sellprice'];			
					
			$outHtml .= '
			
				 <tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['h_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['ebh_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$jdateebtal.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['ph_code'].'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['ph_mojavez'].'</td>	
					<td  align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>		
					<td align="center" style="vertical-align:middle;">'.$row['p_sellprice'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['SUM_price'].'</td>
				    <td align="center" style="vertical-align:middle;">'.$row['l_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['h_customer_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['category_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['MEGHDAR_PRE'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['MEGHDAR_EBTAL'].'</td>
					<td align="center" style="vertical-align:middle;">'.$mablaghEbtali.'</td>
					<td align="center" style="vertical-align:middle;">'.$MEGHDAR.'</td>
				</tr>';		
			
			$inx++;
			$inx1++;
	
			$MEGHDAR1=$MEGHDAR1+$MEGHDAR;
		   $MEGHDAR =($row['MEGHDAR_PRE'])-($row['MEGHDAR_EBTAL']);
           $amount=$amount+$MEGHDAR;
           $price=($price)+($row['SUM_price']);
           $amountebtal=($amountebtal)+($row['MEGHDAR_EBTAL']);
           $jamebtal=($mablaghEbtali)+($jamebtal);
			      		
			
		}
		
				 	
		
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدار ابطالی:'.$amountebtal.'كيلوگرم </span><br/>
                           <span style="background-color:red" width="70%">مبلغ ابطالی:'.$jamebtal.'ريال </span>'
		                  ;		
    }else{
    	$outHtml .= '<tr><td colspan="12">هيچ اطلاعاتي موجود نيست</td></tr></table>';
    }
     
   
    $queryu="SELECT * FROM dm_user_profile
			 
			     WHERE u_id=".$u_id."
			     ";
		   
		$lnku = mysql_query($queryu);
		$rowu = mysql_fetch_assoc($lnku);
    $outHtml .= '<div align="right"> '.$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'</div>';
        $outHtml .= '<div align="right">توسط کاربر: '.$rowu['u_family'].' </div>';
     echo $outHtml; 
    
    