<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
  
</head> 	
<?php
require_once __DIR__ . '/../../mysql_compat.php';
 header('Content-Type: text/html; charset=UTF-8');
	include_once '../lib/php/jdf.php';
    include_once '../lib/php/db_connect.php';
    include_once '../lib/php/gen_def.php';

         $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] :'2010-01-01' ;
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '2018-03-01';
		 $firstDatef = !empty($_REQUEST['firstDatef']) ? $_REQUEST['firstDatef'] :'2010-01-01' ;
		 $EndDatef = !empty($_REQUEST['EndDatef']) ? $_REQUEST['EndDatef'] : '2018-03-01';
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
		
		 global $outHtml;
$queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);

	$outHtml1='<div>
	           <table   align="center"  dir="rtl"  width="90%">
                   <tr>
                      <td align="center" colspan="18" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
   
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="11" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
             </table></div>';
	echo $outHtml1;
	
	$outHtml .= '	
		<div align = "center" style="direction:rtl;">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<td colspan="23" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center>  گزارش حواله براي اداره دارائي </center> </td>
        		</tr>
        		
        		<tr class="rw1">
        			<td   colspan="13" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </td>
        			
        		</tr>
        		<tr >
        			<td   colspan="6" style="height: 50px;vertical-align:middle;" > كد اقتصادي فروشنده  :<p>'.$rowp['province_ecode'].'</p></td>
        			<td   colspan="8" style="height: 50px;vertical-align:middle;">  آدرس فروشنده   : <p>'.$rowp['province_address'].'</p>  </td>

        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			        <td align="center">رديف </td>
			        <td align="center"> کد خريدار</td>
			        <td align="center"> نام خريدار</td>
			         <td align="center"> كد كالا</td>
			        <td align="center">كد قيمت</td>
			        <td align="center"> مقدار کالا</td>
			        <td align="center"> دسته کالا</td>
			        <td align="center">مقدار ابطال شده</td>
			        <td align="center">مبلغ صادره </td>
			        <td align="center">مقدار قابل پرداخت </td>			        
			        <td align="center">کد ملي خريدار</td>	
			        <td align="center">تلفن خريدار</td>
			        <td align="center">شهر</td>
			         <td align="center">كد پستی</td>
			        <td align="center">آدرس خريدار</td>	      				    		        		        
				</tr>';
		
	$query = "  select cus2.code_customer ,p_name, p_price_code,`cat_prod_name`
        ,h_customer_code
		 ,sum(shavale)   shavale
		 ,sum(sebtal)  sebtal
		 ,`name_customer`
		
		 ,`customer_tel`
		 ,p_code
		 ,`customer_cusid_city`
		 ,`customer_address_office`
		 ,sum(SUM_price)  sprice
         ,code_postal_costumer
         ,code_identificate_customer
         

 from ( select h_code , ph_code , h_reg_date , ph_mojavez , p_name ,p_code, p_sellprice , h_amount , l_name,p_price_code ,cat_prod_name
  , h_customer_code , case when h.`h_status` = 1 then 'ابطال کلي' else case when his.his_h_id is null
   then 'ابطال نشده' else 'ابطال جزئي' end end as STATUS_EBTAL , case when h.`h_status` = 1 then h.`h_amount`
    else case when his.his_h_id is null then 0 else his.`his_eb_amount` end end as sebtal ,
     case when h.`h_status` = 1 then h.`h_amount` else case when his.his_h_id is null then h.`h_amount`
      else SUM( his.`his_eb_amount`) + h.`h_amount` end end as shavale ,  case when h.`h_status` = 1 
      then 0 else case when his.his_h_id is null then h.h_price else h.h_price end end as SUM_price  
      
      
      from dm_havale h 
      left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$province_id." 
     
      left join dm_price price on p.p_id=price.price_p_id and price.`p_price_code`=h.`h_price_code`
      left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type 
      left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
      left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
      left join dm_location_goods l on l.l_id=h.h_l_code 
      left join dm_pish_factor pf on h.h_pf_code=pf.pf_code and pf_id_province=".$province_id."
      left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code and ph_id_province=".$province_id." 
      left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` 
      left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1 and ebt.ebh_id_province=".$province_id." and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."' ) 
      left join dm_ebtal_h ebt2 on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 and ebt2.ebh_id_province=".$province_id." and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
        where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
  and ph_id_province=".$province_id." )and(  ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
  
  or

   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
  ph_id_province=".$province_id." )
and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')


  )";
			
			
if ($p_code != -2){
		
		$query .= "  AND h_p_code= ". $p_code ." ";
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
		
		$query .= " AND  h_l_code= ".$l_id ." ";
	}

if ($p_pakage_type != -2){
		
		$query .= " AND   p_pakage_type= ".$p_pakage_type ." ";
	}
if ($p_subsidies != -2){
		
		$query .= " AND   p_subsidies= ". $p_subsidies ." ";
	}	
	if ($city_id != -2){
		 
		$query .= "  AND   customer_cusid_city= ". $city_id ." ";
	}
	$query .= "	group by `h_code` )  ";
	$query .= " as c left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$province_id." 
        left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id";					 
	if ($code_customer != -2){
		
		$query .= " AND  h_customer_code= ".$code_customer ." ";
	}
	$query .= " group by  cus2.code_customer , p_code, p_price_code
         ORDER BY  cus2.code_customer ,p_name, p_price_code asc";
		//print $query;	
	$lnk = mysql_query($query);
	global $inx;
	global $inx1;
	$inx=1;
	$inx1=1;
	if(mysql_affected_rows()>0){
		$amount=0;
	    $ebtal=0;
	    $sumprice=0;
		while($row = mysql_fetch_assoc($lnk)){
						
			$queryc="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['h_customer_code']."
									    AND
									     customer_code_org=".$province_id."";									     	     											
								$lnkc = mysql_query($queryc);
								$rowc = mysql_fetch_assoc($lnkc);	
								$querycity="SELECT * FROM dm_city 
									    WHERE
									      city_id=".$row['customer_cusid_city']."
									   ";									     	     											
								$lnkcity = mysql_query($querycity);
								$rowcity = mysql_fetch_assoc($lnkcity);	
							$querypro="SELECT * FROM dm_province 
									    WHERE
									      province_id=".$province_id."
									    ";									     	     											
								$lnkpro = mysql_query($querypro);
								$rowpro = mysql_fetch_assoc($lnkpro);
					if(($inx)%2==1){
							$color='#C5DED0';
							
						
						}
							else{
								$color='#BBB';
							   
							}				
							$mande=$row['shavale']-$row['sebtal'];
							$sprice=formatMoney($row['sprice']);
							$shavale=formatMoney($row['shavale']);
							$mande1=formatMoney($mande1);
//							if($row['personality_customer']==1){
//								$melishenase=$row['code_economic_customer'];
//								
//							}else{
//								
//								$melishenase=$row['code_identificate_customer'];
//							}

							
		$queryas="SELECT * FROM dm_customer_asli
                                        WHERE
                                        code_customer=".$row['h_customer_code']."  ";   
                                                                                                                               
                                $lnkas = mysql_query($queryas);
                                $rowas = mysql_fetch_assoc($lnkas); 
		//  echo  $rowas['customer_national_tax'];
		//  echo $rowas['customer_gl_code'];
		//  echo  $rowas['customer_gl_economic'];
		             if($rowas['customer_national_tax']!=0){
		             	
		             	$melishenase=$rowas['customer_national_tax'];
		                 $melishenase1='';
		             	
		             }else if($rowas['customer_gl_code']!=0){
		             	
		             	$melishenase=$rowas['customer_gl_code'];
		                $melishenase1='';
		             	
		             }else if($rowas['customer_gl_economic']!=0){
		             	
		             	$melishenase=$rowas['customer_gl_economic'];
		                $melishenase1='';
		             	
		             }
							
			$outHtml .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['h_customer_code'].'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['name_customer'].'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['p_code'].'</td>	
					<td  align="center" style="vertical-align:middle;">'.$row['p_price_code'].'</td>						
					<td align="center" style="vertical-align:middle;">'.$shavale.'</td>				  
					<td align="center" style="vertical-align:middle;">'.$row['cat_prod_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['sebtal'].'</td>
					<td align="center" style="vertical-align:middle;">'.$mande.'</td>
					<td align="center" style="vertical-align:middle;">'.$sprice.'</td>
					<td align="center" style="vertical-align:middle;">'.$melishenase.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['customer_tel'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['code_postal_costumer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['customer_address_office'].'</td>
				
				</tr>';			
			$inx++;
			$inx1++;
			$amount=$amount+$mande;
			$ebtal=$ebtal+$row['sebtal'];
			$sumprice=$sumprice+$row['sprice'];
	
			$amount1=formatMoney($amount);
			$ebtal1=formatMoney($ebtal);
		}
		$sumprice=formatMoney($sumprice);	
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">جمع صادره:'.$amount1.'كيلوگرم </span>' ;		
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">جمع ابطالي:'.$ebtal1.'كيلوگرم </span>' ;	
		       $outHtml.= ' <div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مبلغ قابل پرداخت:'.$sumprice.'ريال </span>' ;			
    }else{
    	$outHtml .= '<tr><td colspan="8">هيچ اطلاعاتي موجود نيست</td></tr></table>';
    }
    
    echo $outHtml;
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
    
    