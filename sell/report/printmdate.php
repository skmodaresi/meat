	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
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
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		  $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 global $outHtml;
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
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center>  </center> </th>
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
			        <td align="center"> شماره معرفی نامه</td>
			        <td align="center"> تاريخ معرفی نامه</td>
			        <td align="center"> شماره مجوز</td>
			        <td align="center"> نام کالا</td>
			        <td align="center"> مقدار كالا</td>			        
			        <td align="center"> قيمت واحد</td>
			        <td align="center"> هزینه هر واحد</td>
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			        <td align="center">نام شهر</td>	
			        <td align="center">وضعيت</td>	 				    		        		        
				</tr>';
		
	$query = " 
				 SELECT * From dm_pish_factor pf left join dm_pish_havale ph 
			on ph.ph_code=pf.pf_ph_code
			 left join dm_pish_havale_det ph_det 
			on ph_det.phd_ph_code=ph.ph_code
			left join dm_product prod on ph_det.`phd_pid`=prod.p_code
			left join dm_price price on  prod.p_id = price.price_p_id  and price_id_province=".$province_id."
			left join dm_location_goods l 
			on l.l_id=ph_det.phd_l_id 
			left join dm_prod_det_t prod_t on prod_t.type_prod_id=prod.p_type
			
			inner join dm_prod_det_p prod_p on prod_p.pack_prod_id=prod.p_pakage_type
			inner join dm_prod_det_c prod_c on prod_c.cat_prod_id=prod.p_category
			
			
			where  
			
			
			ph_id_province=".$province_id."
			and 
			  pf_id_province=".$province_id."
			and
			phd_id_province=".$province_id."
			and 
			pf_type=1
			and
			pf_id_year=".$year_id."
			and
			 phd_id_year=".$year_id."
			and
			pf_reg_date between  '".$firstDate."'  AND  '".$EndDate."'
			and l_id_province=".$province_id."
			AND price_id_province=".$province_id."
	

			
         ";
		
			
if ($p_code != -2){
		
		$query .= "  AND p_code= ". $p_code ." ";
	}
if ($p_price_code != -2){
		
		$query .= " AND p_price_code= ". $p_price_code ." ";
	}
if ($p_type != -2){
		
		$query .= " AND p_type= ". $p_type ." ";
	}
if ( $p_category != -2){
		
		$query .= " AND  p_category= ".$p_category ." ";
	}
if ($l_id != -2){
		
		$query .= " AND  phd_l_id= ".$l_id ." ";
	}

if ($p_pakage_type != -2){
		
		$query .= " AND   p_pakage_type= ".$p_pakage_type ." ";
	}
if ($p_subsidies != -2){
		
		$query .= " AND   p_subsidies= ". $p_subsidies ." ";
	}	
	
	if ($ph_mojavez != -2){
		 
		$query .= "  AND   ph_mojavez= ". $ph_mojavez ." ";
	}
	
	
	if ($code_customer != -2){
		
		$query .= " AND  ph_customer_code= ". $code_customer ." ";
	}if ($city_id != -2){
		 
		$query .= "  AND   customer_cusid_city= ". $city_id ." ";
	}
	
//	$query .= "left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id  ";
         
	if ($category_id != -2){
		 
		$query .= "  AND   category_id= ". $category_id ." ";
	}
	
	
	$query .= " group by pf_code order by pf_code";
//print $query;	
	
	$lnk = mysql_query($query);
	global $inx;
	global $inx1;
	$inx=1;
	$inx1=1;
	$amount=0;
	$price=0;
    $amountebtal=0;
    $meghdarkol=0;
	if(mysql_affected_rows()>0){
			
		while($row = mysql_fetch_assoc($lnk)){
					
				$gdate=$row['ph_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			if ($row['pf_type_m']==0){
				$amount=$amount+$row['phd_amount'];
				
				
				$status='فعال';
			}else if($row['pf_type_m']==1){
				
				$amountebtal=$amountebtal+$row['phd_amount'];
					$status='ابطالي';
				
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
        			<th colspan="25" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش معرفی نامه </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			       <td align="center">رديف </td>			      
			        <td align="center"> شماره معرفی نامه</td>
			        <td align="center"> تاريخ معرفی نامه</td>
			        <td align="center"> شماره مجوز</td>
			        <td align="center"> نام کالا</td>
			       <td align="center"> مقدار كالا</td>			        
			         <td align="center"> قيمت واحد</td>
			          <td align="center"> هزینه هر واحد</td>
			      
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			        
			        <td align="center">نام شهر</td>	
			        <td align="center">وضعيت</td>	
			      
			    
			       				    		        		        
				</tr>';
									            
			}	
			
			$queryc="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['ph_customer_code']."
									    AND
									     customer_code_org=".$province_id."";									     	     											
								$lnkc = mysql_query($queryc);
								$rowc = mysql_fetch_assoc($lnkc);	
								//print  $queryc;
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
					
			$outHtml .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pf_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['ph_mojavez'].'</td>	
					<td  align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>	
					
					<td align="center" style="vertical-align:middle;">'.$row['phd_amount'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['phd_p_price'].'ريال</td>
					<td align="center" style="vertical-align:middle;">'.$row['phd_p_add'].'ريال</td>
					
				    <td align="center" style="vertical-align:middle;">'.$row['l_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['ph_customer_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$status.'</td>
					
					
				</tr>';		
			
			$inx++;
			$inx1++;
			
			$meghdarkol=$meghdarkol+$row['phd_amount'];
			      		
			
		}
		//$meghdar=formatMoney($meghdar);
				 	
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدار کل :'.$meghdarkol.'كيلوگرم </span>' ;	
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدار ابطالي:'.$amountebtal.'كيلوگرم </span>' ;			
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدار مانده :'.$amount.'كيلوگرم </span>' ;		
    }else{
    	$outHtml .= '<tr><td colspan="12">هيچ اطلاعاتي موجود نيست</td></tr></table>';
    }
     
   
    $queryu="SELECT * FROM dm_user_profile
			 
			     WHERE u_id=".$u_id."";  
			     
		$lnku = mysql_query($queryu);
		$rowu = mysql_fetch_assoc($lnku);
    $outHtml1 .= '<div align="right"> '.$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'</div>';
        $outHtml1 .= '<div align="right">توسط کاربر: '.$rowu['u_family'].' </div>';
        $outHtml .= '<div style="page-break-before:always";>&nbsp;</div>'; 
        echo $outHtml;
   //  echo $outHtml1; 
       
    