<?php
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

 $queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);
	$province_ecode=farsinum($rowp['province_ecode']);
	$province_postal=farsinum($rowp['province_postal']);
	$province_tel=farsinum($rowp['province_tel']);
	$province_sabt=farsinum($rowp['province_sabt']);
	$queryy = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnky = mysql_query($queryy);
	//	print $query1;
		$rowy= mysql_fetch_assoc($lnky);
		$year_code=$rowy['year_code'];
 
	
	$query = "select p_name,code_customer,l_name,h_p_add,p_sellprice,p_sellpriceh, p_price_code,`cat_prod_name`

		 ,sum(case when havaleinBaze = 1  then shavale else 0 end) 
     		 
		 shavale ,
		
(

   select sum(h_pre_amount) from `dm_havale` hh 
    left join dm_customer cust on cust.code_customer=hh.h_customer_code 
    
    and cust.`customer_province_id` = ".$province_id."
    left join dm_customer_category cuscat on cust.customer_category=cuscat.category_id 
    
    
    
   left join dm_pish_factor pf on hh.h_pf_code=pf.pf_code and pf_id_province=".$province_id."
      left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code and ph_id_province=".$province_id." 
   where ";
   if ($category_id != -2){
		 
		$query .= "    category_id= ". $category_id ." and ";
	}
   
  $query .= " hh.`h_reg_date`
      between '".$firstDate."'  AND  '".$EndDate."' 
      and  h_id_province=".$province_id." 
      and hh.h_p_code= p_code
      and hh.h_price_code = p_price_code 
      and hh.h_p_add = h_p_add2
      ";
      if ($l_id != -2){
		
		$query .= " AND  h_l_code= ".$l_id ." ";
	}
    if ($code_customer != -2 AND $city_id != -2){
		
		$query .= " And  h_customer_code= ". $code_customer ."  AND   customer_cusid_city= ". $city_id ." ";
	}else if( $code_customer != -2){
		$query .= " And  h_customer_code= ". $code_customer ."";
		
	}else if ($city_id != -2){
		 
		$query .= " And   customer_cusid_city= ". $city_id ." ";
	}
	if ($ph_mojavez != -2){
		 
		$query .= "  AND   ph_mojavez = '". $ph_mojavez ."' ";
	}
	if ($ph_operation_id != -2){
		 
		$query .= "  AND   ph_operation_id = '". $ph_operation_id ."' ";
	}
	if ($phd_deli_name != -2){
		 
		$query .= " AND   h_deli_name like '%".$phd_deli_name."%'  ";
	}
	
	//print $query;
$query .= ") as shavalepre
				  
		 ,sum(case when EbtalInBaze = 0 then sebtal else 0 end ) sebtalkharej 
		 ,sum(case when EbtalInBaze = 1 then sebtal else 0 end ) sebtalDakhel
		 ,sum(SUM_price)  sprice
         ,p_code

 from ( select h_code ,h_p_add, ph_code ,p_sellpriceh,IFNULL(ebt.`ebh_id`,ebt2.`ebh_id`) as ebh_id,h_reg_date , ph_mojavez , p_name , p_code, p_sellprice , h_amount , l_name,p_price_code ,cat_prod_name
  , h_customer_code , case when h.`h_status` = 1 then 'ابطال کلي' else case when his.his_h_id is null
   then 'ابطال نشده' else 'ابطال جزئي' end end as STATUS_EBTAL ,

  case when ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."'    or ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."'   then case when h.`h_status` = 1
  then h.`h_amount` else case when his.his_h_id is null then 0 else his.`his_eb_amount` end end  else 0 end as sebtal ,    
  CASE when h_reg_date between '".$firstDate."'  AND  '".$EndDate."'  then case when h.`h_status` = 1 then  0     else  h.`h_amount`  end  end  as shavale, 
   CASE when h_reg_date between '".$firstDate."'  AND  '".$EndDate."'  then   h.`h_pre_amount`  else  0  end  as shavalepr , 

         
    (case when (  ( (`ebt2`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."' ) or (`ebt`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."' )) and (`h`.`h_reg_date` between '".$firstDate."'  AND  '".$EndDate."' )) then (case when (`h`.`h_status` = 1) then `h`.`h_amount` else (case when isnull(`his`.`his_h_id`) then 0 else `his`.`his_eb_amount` end) end) else 0 end) AS `sebtalBaze`,
    
     case when h.`h_status` = 1 
      then 0 else case when his.his_h_id is null then h.h_price else h.h_price end end as SUM_price ,
      
          (case when (((`ebt2`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."'  ) or (`ebt`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."'  ))) then 1 else 0 end) AS `EbtalInBaze`,
    (case when (`h`.`h_reg_date` between '".$firstDate."'  AND  '".$EndDate."') then 1 else 0 end) AS `havaleInBaze`
      ,h.h_status
      
      ,count(ebt.ebh_h_id)+1   as ebtcnt  
      
      , h_p_add h_p_add2
      
      
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
and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')

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
if ($phd_deli_name != -2){
		 
		$query .= " AND   h_deli_name like '%".$phd_deli_name."%'  ";
	}
if ($p_pakage_type != -2){
		
		$query .= " AND   p_pakage_type= ".$p_pakage_type ." ";
	}
if ($p_subsidies != -2){
		
		$query .= " AND   p_subsidies= ". $p_subsidies ." ";
	}	
	if ($ph_mojavez != -2){
		 
		$query .= "  AND   ph_mojavez = '". $ph_mojavez ."' ";
	}
	if ($ph_operation_id != -2){
		 
		$query .= "  AND   ph_operation_id = '". $ph_operation_id ."' ";
	}
	$query .= "	group by `h_code`,ebt.`ebh_id`,ebt2.`ebh_id` )  ";
	$query .= " as c ";			
    $query .= " left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$province_id."
          ";


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
	$query .= " group by  code_customer
         ORDER BY  p_name, p_price_code asc";
	print $query;	
	$lnk = mysql_query($query);
	global $inx;
	
	$inx=0;
	
	$out ='';
	 $queryostan="SELECT * FROM dm_prov_finanace
                                        WHERE
                                         prov_code=".$province_id."  ";   
                                                                                                                               
                                $lnkostan = mysql_query($queryostan);
                                $rowostan = mysql_fetch_assoc($lnkostan); 
     
	if(mysql_num_rows($lnk)> 0){
	 // echo mysql_num_rows($lnk);
		$amount=0;
	    $ebtal=0;
	    $sumprice=0;
		$jamkol=0;
		while($row = mysql_fetch_assoc($lnk)){
		
		
	
		if ($row['personality_customer']=='')
		{
			
				    	 $personality_customer=1;
				    	
		}else{
			$personality_customer=$row['personality_customer'];
		}	
		if($row['city_code']==''){
		$city_code=1000;		
		}else{
			
			$city_code=$row['city_code'];
			
			
		}
			   
	
	
		                 //    if($row['personality_customer']==2 or $row['personality_customer']==3){
		                     	$melishenase2=$row['code_economic_customer'];
		                     	$melishenase1='';
		                     	
		                     	
		                   //  }else{
		                     	
		                   //  	$melishenase1=$row['code_economic_customer'];
		                   //  	$melishenase2='';
		                   //  }

								$melishenase=$row['code_economic_customer'];
							
		

							$mande=($row['shavalepre']-$row['sebtal'])- $sezafpre;
							
							
							$spriceh=$mande * $row['h_p_price'];
							
							
							$spriceh=formatMoney($spriceh);
							
							$shavale=formatMoney($row['shavale']);
							$mande1=formatMoney($mande1);
					$sprice1=farsinum($spriceh);
					$customer_tel=farsinum($row['customer_tel']);
					$code_postal_costumer=farsinum($row['code_postal_costumer']);
					$p_code=farsinum($row['p_code']);
						
				    $code_economic_customer=farsinum($row['code_economic_customer']);
		
				    
					if($row['shavalepre'] !=0  AND $row['sebtalDakhel']!=0 )
					  {   $inx++;	 
					  	//echo $inx; 
						 $mande=($row['shavalepre']-$row['sebtal'])- $sezafpre;
					     $spriceh=$mande * $row['h_p_price'];
					      $spriceh = intval($spriceh); 
					     $name_customer=str_replace("ی","ي", $row['name_customer']);
					     $name_customer = substr($name_customer,0,100); 
						 $name_customer=str_replace("&#1740","", $name_customer);
						 $name_customer=str_replace(";","", $name_customer);
					//echo $row['h_p_price'];
						 $p_name=str_replace("ی","ي",$row['p_name']);
					     $out .=''. $inx .';'. $p_name .';'. $row['p_code'] .';'. 0 .';'. $spriceh .';'.  0 .';'.  0 .';'. $personality_customer .';'. $row['code_postal_costumer'] .';'. $rowostan['prov_pish_code'] .';'. $row['customer_tel'] .';'. $row['customer_address_office'] .';'. $name_customer .';'. $name_customer .';'. $melishenase1 .';'. $melishenase2 .';'. 2 .';;'. $rowostan['prov_code_finance'] .';'. $city_code .';;;'. 0 .'';
					     	 $out .="\n"; 				      
				
								$mande=$row['sebtalDakhel'];
					
								$spriceh=$mande * $row['h_p_price'];
								 $spriceh = intval($spriceh); 
								$inx++;									
							    
						       
						         $p_name=str_replace("ی","ي",$row['p_name']);
								 $name_customer=str_replace("ی","ي", $row['name_customer']);
							     $name_customer = substr($name_customer,0,100); 
								 $name_customer=str_replace("&#1740","", $name_customer);
								 $name_customer=str_replace(";","", $name_customer);
					//	echo $inx;
						 $p_name=str_replace("ی","ي",$row['p_name']);
			                
								     $out .=''. $inx .';'. $p_name .';'. $row['p_code'] .';'. 1 .';'. $spriceh .';'.  0 .';'.  0 .';'. $personality_customer .';'. $row['code_postal_costumer'] .';'. $rowostan['prov_pish_code'] .';'. $row['customer_tel'] .';'. $row['customer_address_office'] .';'. $name_customer .';'. $name_customer .';'. $melishenase1 .';'. $melishenase2 .';'. 2 .';;'. $rowostan['prov_code_finance'] .';'. $city_code .';;;'. 0 .'';
								     $out .="\n";  
						        
					
					}else if($row['shavalepre'] !=0  )
					
                       {
                       	
                       $inx++;
					   //   echo $inx;
						$mande=($row['shavalepre']-$row['sebtal'])- $sezafpre;
					     $spriceh=$mande * $row['h_p_price'];
					      $spriceh = intval($spriceh); 
					     $name_customer=str_replace("ی","ي", $row['name_customer']);
					     $name_customer = substr($name_customer,0,500); 
						 $name_customer=str_replace("&#1740","", $name_customer);
						 $name_customer=str_replace(";","", $name_customer);
						 
						 $customer_address_office=str_replace("ی","ي", $row['customer_address_office']);
						 $customer_address_office=str_replace("&#1740","",$customer_address_office);
						 $customer_address_office=str_replace(";","", $customer_address_office);
						 $p_name=str_replace("ی","ي",$row['p_name']);
						   $out .=''. $inx .';'. $p_name .';'. $row['p_code'] .';'. 0 .';'. $spriceh .';'.  0 .';'.  0 .';'. $personality_customer .';'. $row['code_postal_costumer'] .';'. $rowostan['prov_pish_code'] .';'. $row['customer_tel'] .';'. $customer_address_office .';'. $name_customer .';'. $name_customer .';'. $melishenase1 .';'. $melishenase2 .';'. 2 .';;'. $rowostan['prov_code_finance'] .';'. $city_code .';;;'. 0 .'';

							//   $out .=''. $inx .';'. 2 .';'. 3 .';'. 4 .';'. 5 .';'.  6 .';'.  7 .';'. 8 .';'. 9 .';'. 10 .';'. 11 .';'. 12 .';'. 13 .';'. 14 .';'. 15 .';'. 16 .';'. 17 .';'. 18 .' ;'. 19 .';'. 20 .';'. 21 .';22;';
						   
					  //   $out .=''. $inx .';'. $p_name .';'. $row['p_code'] .';'. 0 .';'. $spriceh .';'.  0 .';'.  0 .';'. $row['personality_customer'] .';'. $row['code_postal_costumer'] .';'. $rowostan['prov_pish_code'] .';'. $row['customer_tel'] .';'. $row['customer_address_office'] .';'. $name_customer .';'. $name_customer .';'. $melishenase .';'. $melishenase .';'. 1 .';'. 1 .' ;'. $rowostan['prov_code_finance'] .';'. $rowcity['city_code'] .';'. yes .';;';
					     $out .="\n";  
						     
                             
					    }else if( $row['sebtalDakhel']!=0 )
		                   { 
		                   	$mande=$row['sebtalDakhel'];
					
								$spriceh=$mande * $row['h_p_price'];
								 $spriceh = intval($spriceh); 
								
								$inx++;	
							
							      $p_name=str_replace("ی","ي",$row['p_name']);
								 $name_customer=str_replace("ی","ي", $row['name_customer']);
								 // $name_customer=str_replace("تابان","", $row['name_customer']);
							     $name_customer = substr($name_customer,0,100); 
								 $name_customer=str_replace("&#1740","", $name_customer);
								 $name_customer=str_replace(";","", $name_customer);
								 //$name_customer=str_replace("ن","", $name_customer);
						
						 $p_name=str_replace("ی","ي",$row['p_name']);
			                
								     $out .=''. $inx .';'. $p_name .';'. $row['p_code'] .';'. 1 .';'. $spriceh .';'.  0 .';'.  0 .';'. $personality_customer .';'. $row['code_postal_costumer'] .';'. $rowostan['prov_pish_code'] .';'. $row['customer_tel'] .';'. $row['customer_address_office'] .';'. $name_customer .';'. $name_customer .';'. $melishenase1 .';'. $melishenase2 .';'. 2 .';;'. $rowostan['prov_code_finance'] .';'. $city_code .';;;'. 0 .'';
								     $out .="\n";  
						}
									
					}
	
	}
	
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=\"finance92.csv\"");
        echo  $out;
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
for ( ; $i <= strlen( $data ); ++$i )
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