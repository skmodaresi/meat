<?php
require_once __DIR__ . '/../../../mysql_compat.php';
include_once 'jdf.php';
include_once 'db_connect.php';

    $doc_date = isset($_REQUEST['doc_date']) ? $_REQUEST['doc_date'] : '';
    $doc_date_l = isset($_REQUEST['doc_date_l']) ? $_REQUEST['doc_date_l'] : '';
    $province_id = isset($_REQUEST['id_province']) ? $_REQUEST['id_province'] : ''; 

    $date = explode('/', $doc_date);     
    $doc_date=$date[2].'/'.$date[1].'/'.$date[0] ;
    //   $doc_date1 =$doc_date;
     $date1 = explode('/', $doc_date_l);     
    $doc_date_l=$date1[2].'/'.$date1[1].'/'.$date1[0] ;
	$jdate=$doc_date;
	$jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
		
       if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
     if($gday<=9){
       $gday='0'.$gday;  
     }
    $doc_date = $gyear."-".$gmonth."-".$gday;
   //baraye doc_date_l
   $jdate1=$doc_date_l;
	$jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate1 );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
		
       if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
     if($gday<=9){
       $gday='0'.$gday;  
     }
    $doc_date_l = $gyear."-".$gmonth."-".$gday; 
	
	 
	 $day_number = $date[0];
	 $month_number = $date[1];
		$query1 = "SELECT * FROM  dm_year where
	            year_status=1 ";	
			$lnk1 = mysql_query($query1);
		//	print $query1;
			$row1= mysql_fetch_assoc($lnk1);
			$year_code=$row1['year_code'];
		 $year_number = $year_code;
		 $queryp="SELECT * FROM dm_province 
        WHERE province_id=".$province_id."";
		$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
	    $out='';	
	    				
	    $query = " 
				SELECT 
						h_code ,
						h_reg_date ,
						ph_mojavez ,
						p_name ,
						p_code ,
						p_sellprice ,
						h_amount ,
						l_name ,
						l_code ,
						condition_share_customer,
						h_customer_code ,
						
						name_customer ,
						customer_address_office ,
						address_location_delivery_c,
						category_name 
			 , case when h.`h_status` = 1 then 'ابطال کلی'
    	 else  case  when  his.his_h_id is null then 'ابطال نشده' else 'ابطال جزئی' end end as STATUS_EBTAL
 
 
 , case when h.`h_status` = 1 then h.`h_amount`
    	 else  case  when  his.his_h_id is null then 0 else his.`his_eb_amount` end end as MEGHDAR_EBTAL
         
  , case when h.`h_status` = 1 then h.`h_amount`
    	 else  case  when  his.his_h_id is null then h.`h_amount` else his.`his_pre_amount` end end as MEGHDAR_PRE       
   , case when h.`h_status` = 1 then 0 
   else  case  when  his.his_h_id is null	 
then SUM(h.h_price) else 0 end end as SUM_price       
  FROM dm_havale h inner join dm_product p
							left join dm_price price
							on p.p_id=price.price_p_id and p_category=7
        left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type
        left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type
        left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category
        left join dm_location_goods l on l.l_id=h.h_l_code
        inner join dm_customer cus on  cus.code_customer=h.h_customer_code
        left join dm_pish_factor pf on h.h_pf_code=pf.pf_code
        inner join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code 
        left join dm_customer_category cuscat
        on cus.customer_category=cuscat.category_id
        left join `dm_his_havale` his on his.`his_h_id` = h.`h_id`
        
				 
	WHERE 
	   price_id_province=".$province_id."
       and h_id_province=".$province_id."
       and ph_id_province=".$province_id."
       and pf_id_province=".$province_id."
       and p_price_code=h_price_code
       and customer_code_org=".$province_id."
         ";  
	   $query .= "	AND
		     h_reg_date between   '".$doc_date."'  AND  '".$doc_date_l."'";
	$query .= " group by  `h_code` ORDER BY h_code asc ";	
	//print $query;				   
    			$lnk = mysql_query($query);
    			while($row = mysql_fetch_assoc($lnk))
				
				{  
					$gdate=$row['h_reg_date'];
					list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate );
							
					list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
				        if($jmonth<=9){
						       $jmonth='0'.$jmonth;  
						     }
						     if($jday<=9){
						       $jday='0'.$jday;  
						     }
										
					$jdate = $jyear."/".$jmonth."/".$jday;
					$queryps = "
									 SELECT *  FROM dm_customer_status_s 			 
											 WHERE 
												 		cus_status_s_id = '".$row['condition_share_customer']."' 
												  ";						
                        $lnkps = mysql_query($queryps);
                        $rowps = mysql_fetch_assoc($lnkps);
    			//print $queryps;
    			$mande=$row['MEGHDAR_PRE']-$row['MEGHDAR_EBTAL'];
    			//print $query;
    			$l_name=str_replace("ی","ي",$row['l_name']);
    			$name_customer=str_replace("ی","ي",$row['name_customer']);
    			$address_location_delivery_c=str_replace("ی","ي",$row['address_location_delivery_c']);
    			$customer_address_office=str_replace("ی","ي",$row['customer_address_office']);
    			$cus_status_s_name=str_replace("ی","ي",$rows['cus_status_s_name']);
    			$address_location_delivery_c=str_replace("ی","ي",$row['address_location_delivery_c']);
				$address_location_delivery_c=str_replace("&#1740","", $address_location_delivery_c);
				$address_location_delivery_c=str_replace(";","", $address_location_delivery_c);
				$name_customer=str_replace("&#1740"," ", $name_customer);
                 $name_customer=str_replace(";"," ", $name_customer);
            
    		//	echo $cus_status_s_name;
     $out.=''. $row['h_code'] .';'.$jdate.';'. $row['l_code'] .';'.$row['p_code'].';'.$row['p_sellprice'].';'.$row['h_customer_code'].';'.$name_customer .';'.$row['MEGHDAR_PRE'].';'.$row['MEGHDAR_EBTAL'].';'.$mande.';'.$customer_address_office.';'.$address_location_delivery_c.';'. $rowps['cus_status_s_code'] .'';
               $out .= "\n";
				}
     $out= iconv("utf-8","windows-1256",$out);
		    	$out1= iconv("utf-8","windows-1256",$out1);		
		header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"fridge.csv\"");
			echo $out;
    			
  ?>