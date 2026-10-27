<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
  <head>
    <title>Smart Pagination</title>
    <script src="jquery-1.4.4.min.js" type="text/javascript"></script>
    <script src="smartpaginator.js" type="text/javascript"></script>
    <link href="smartpaginator.css" rel="stylesheet" type="text/css" />
    
    <style type="text/css">
        body
        {
            padding: 20px;
        }
        #wrapper
        {
            margin: auto;
            width: 1000px;
        }
        .contents
        {
            width: 91%; /*height: 150px;*/
            margin: 0;
        }
        .contents > p
        {
            padding: 8px;
        }
        .table
        {
            width: 100%;
            border-right: solid 1px #5f9000;
            align:center;
        }
        .table th, .table td
        {
            width: 16%;
            height: 20px;
            padding: 4px;
            text-align: left;
        }
        .table th
        {
            border-left: solid 1px #5f9000;
        }
        .table td
        {
            border-left: solid 1px #5f9000;
            border-bottom: solid 1px #5f9000;
        }
        .header
        {
            background-color: #4f7305;
            color: White;
        }
        #divs
        {
            margin: 0;
            height: 200px;
            font: verdana;
            font-size: 14px;
            background-color: White;
        }
        #divs > div
        {
            width: 98%;
            padding: 8px;
        }
        #divs > div p
        {
            width: 95%;
            padding: 8px;
        }
        ul.tab
        {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        ul.tab li
        {
            display: inline;
            padding: 10px;
            color: White;
            cursor: pointer;
        }
        #container
        {
            width: 100%;
            border: solid 1px red;
        }
    </style>
</head>
</head> 	
<?php
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
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '-2';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '-2';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '-2';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2' ;
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '-2';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $prov_list = !empty($_REQUEST['prov_list']) ? $_REQUEST['prov_list'] : '-2';
		 $u_id = !empty($_REQUEST['u_id']) ? $_REQUEST['u_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 
$i=1;
 if(!empty($_REQUEST['prov_list'])) {
 	$prov='';
 	
    foreach($_REQUEST['prov_list'] as $check) {
    	  $prov .=$check.',';
    	  if($i==1){
        
    	  }   
        $i++;   
    }
    $prov .='900';
}
	$outHtml1='';  
   $queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);

	$outHtml1='<div><table     align="center"  dir="rtl"  style="width:900px">
                   <tr>
                     <td align="center" colspan="18" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
   
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b></td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="11" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
                    	<tr  >
        			<th colspan="14"> گزارش تجمعى فروش كالا  </th>
        		</tr>
        		<tr class="header">
        			<th colspan="14"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </th>
        			
        		</tr>
             </table></div>';

	$outHtml1 .= '	<div id="wrapper">
        <div style="height: 30px;">
           
        </div>
      
        <div id="green-contents" class="contents" style="border: solid 1px #5f9000;">
         
            <table  dir="rtl"  id="mt" cellpadding="0" cellspacing="0" border="0" style="width:1000px" align="center" class="table">
           
            

      			<tr class="header">
			        <th align="center">رديف </th>
			        <th align="center"> كد كالا</th>
			        <th align="center"> كد قيمت</th>
			        <th align="center"> نام كالا</th>
			        <th align="center"> قيمت واحد</th>
			          <th align="center"> هزينه اضافی</th>
			        <th align="center"> دسته کالا</th>
			       <th align="center">مقدار صادره اوليه</th>
	                <th align="center">مقدار ابطالی </th>
	                <th align="center">مقدار خالص صادره </th>	          
			        <th align="center">* مبلغ پرداختی* براساس صادره اوليه </th>
			             <th align="center">* مبلغ پرداختی* ابطالی </th>
			          <th align="center">* مبلغ پرداختی* خالص </th>
			        <th align="center">استان </th>				      		        	        			      		      				    		        		        
				</tr>';
//        		<tr class="rw1">
//        			<td colspan="15" align="center" style="height: 50px;vertical-align:middle;"><center> گزارش تجمعى فروش كالا </center> </td>
//        		</tr>
//        		<tr class="rw1">
//        			<td   colspan="15" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
//        			&nbsp;&nbsp;&nbsp;
//        			&nbsp;&nbsp;&nbsp;
//        			  تا تاريخ    :
//        			 '.$EndDatef.'  </td>
//        			
//        		</tr>
//      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
//			        <td align="center">رديف </td>
//			        <td align="center"> كد كالا</td>
//			        <td align="center"> كد قيمت</td>
//			        <td align="center"> نام كالا</td>
//			        <td align="center"> قيمت واحد</td>
//			          <td align="center"> هزينه اضافی</td>
//			        <td align="center"> دسته کالا</td>
//			       <td align="center">مقدار صادره اوليه</td>
//	                <td align="center">مقدار ابطالی </td>
//	                <td align="center">مقدار خالص صادره </td>	          
//			        <td align="center">* مبلغ پرداختی* براساس صادره اوليه </td>
//			             <td align="center">* مبلغ پرداختی* ابطالی </td>
//			          <td align="center">* مبلغ پرداختی* خالص </td>
//			        <td align="center">استان </td>				      		        	        			      		      				    		        		        
//				</tr>';
$query = "  select p_name,p_sellprice,h_p_add,province_code_alef,p_sellpriceh, p_price_code,`cat_prod_name`,`h_id_province`

		 ,sum(case when havaleinBaze = 1  then shavale else 0 end)  -- /ebtcnt

		 
		 shavale
		, sum(shavalepr) shavalepre	  
		 ,sum(case when EbtalInBaze = 0 then sebtal else 0 end ) sebtalkharej 
		 ,sum(case when EbtalInBaze = 1 then sebtal else 0 end ) sebtalDakhel
		 ,sum(SUM_price)  sprice
         ,p_code
         ,h_p_type

 from ( select h_code ,h_p_type,province_code_alef,h_p_add,province_name, ph_code , h_reg_date ,IFNULL(ebt.`ebh_id`,ebt2.`ebh_id`) as ebh_id,h_id_province, ph_mojavez , p_name , p_code, p_sellprice ,p_sellpriceh , h_amount , l_name,p_price_code ,cat_prod_name
  , h_customer_code , case when h.`h_status` = 1 then 'ابطال کلي' else case when his.his_h_id is null
   then 'ابطال نشده' else 'ابطال جزئي' end end as STATUS_EBTAL ,

	  case when ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."'    or ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."'   then case when h.`h_status` = 1
	  then h.`h_amount` else case when his.his_h_id is null then 0 else his.`his_eb_amount` end end  else 0 end as sebtal ,    
	  CASE when h_reg_date between '".$firstDate."'  AND  '".$EndDate."'  then case when h.`h_status` = 1 then  0     else  h.`h_amount`  end  end  as shavale, 
	  CASE when h_reg_date between '".$firstDate."'  AND  '".$EndDate."'  then   h.`h_pre_amount`    end  as shavalepr, 

    (case when (  ( (`ebt2`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."' ) or (`ebt`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."' )) and (`h`.`h_reg_date` between '".$firstDate."'  AND  '".$EndDate."' )) then (case when (`h`.`h_status` = 1) then `h`.`h_amount` else (case when isnull(`his`.`his_h_id`) then 0 else `his`.`his_eb_amount` end) end) else 0 end) AS `sebtalBaze`,
    
     case when h.`h_status` = 1 
      then 0 else case when his.his_h_id is null then h.h_price else h.h_price end end as SUM_price ,
      
          (case when (((`ebt2`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."'  ) or (`ebt`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."'  ))) then 1 else 0 end) AS `EbtalInBaze`,
    (case when (`h`.`h_reg_date` between '".$firstDate."'  AND  '".$EndDate."') then 1 else 0 end) AS `havaleInBaze`
      ,h.h_status
      
      ,count(ebt.ebh_h_id) + count(ebt2.ebh_h_id) +1   as ebtcnt
      from dm_havale h 
      left join dm_product p on h.h_p_code=p.p_code and h_id_province in (".$prov.") 
      left join dm_price price on p.p_id=price.price_p_id and price.`p_price_code`=h.`h_price_code`
	  and price_id_province= h_id_province 
	  left join dm_province prov on h.h_id_province=prov.province_id and h_id_province in (".$prov.") 
      left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type 
      left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
      left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
      left join dm_location_goods l on l.l_id=h.h_l_code 
      left join dm_pish_factor pf on h.h_pf_code=pf.pf_code and pf_id_province in (".$prov.") and pf_id_province = h_id_province
      left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code and ph_id_province in (".$prov.") and ph_id_province = h_id_province
	  and ph_id_province=pf_id_province
      left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` 
      left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1 and ebt.ebh_id_province in (".$prov.")  
	  and ebt.ebh_id_province=h.h_id_province
	  and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."' ) 
      left join dm_ebtal_h ebt2 on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 and ebt2.ebh_id_province in (".$prov.") 
	  and ebt2.ebh_id_province=h.h_id_province
	  and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
        where (( h_id_province in (".$prov.") and (ebt.ebh_id_province in (".$prov.") or ebt.ebh_id_province is null)
  and price_id_province in (".$prov.") and l_id_province in (".$prov.") and pf_id_province in (".$prov.")
  and ph_id_province in (".$prov.") )and(  ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
  and price_id_province=ph_id_province
  
  or

   ( h_id_province in (".$prov.") and ( ebt2.ebh_id_province in (".$prov.") or ebt2.ebh_id_province is null)
  and price_id_province in (".$prov.") and l_id_province in (".$prov.")  and pf_id_province in (".$prov.") and
  ph_id_province in (".$prov.") )
and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
and price_id_province=h.h_id_province
  ) ";
	
			
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
	
	$query .= "		group by `h_code`,ebt.`ebh_id`,ebt2.`ebh_id`,h_id_province )  ";
	$query .= " as c ";			
    $query .= " left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` in (".$prov.")
                and cus2.`customer_province_id`= h_id_province
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
	$query .= " group by  p_code, p_price_code,h_p_add,h_id_province 
         ORDER BY  province_code_alef,p_name, p_price_code asc";
	
//	print $query;	
	$lnk = mysql_query($query);
	$num=mysql_num_rows($lnk );
	
	global $inx1;
	global $inx11;
	$inx1=1;
	$inx11=1;
	
	if(mysql_num_rows($lnk)>0){
		$amount=0;
	    $ebtal=0;
	    $sadere=0;
	    $jam=0;
	   $sumpriceakhar=0;
	   $sumpriceebakhar=0;
	   $pricekhakhar=0;
		while($row = mysql_fetch_assoc($lnk)){
			$query1= " select * from dm_province 
			            where 
			              province_code=".$row['h_id_province']."	";

			$lnk1 = mysql_query($query1);
			$row1 = mysql_fetch_assoc($lnk1);
					
		if ( $p_category != -2){
		
		$daste = "   p_category= ".$p_category ." ";
	}else{
		
		$daste = " 1 ";
	}
$sezaf=0;	
$sezafpre=0;
	
	$quer="select sum(h_pre_amount) as ss from dm_havale
	          where 
	          h_price_code=".$row['p_price_code']."
	          and
	          h_p_code=".$row['p_code']."
	          and
	          h_p_add=".$row['h_p_add']."
	        
	          
	          and
	          h_id_province=".$row['h_id_province']."
	          
	          and h_reg_date between '".$firstDate."'  AND  '".$EndDate."'

	";
	
	//echo $quer;
			$ln = mysql_query($quer);
			$ro = mysql_fetch_assoc($ln);
         $ss=formatMoney($ro['ss']);
	     $ss=farsinum( $ss);
	//echo $sezafpre;				
		if($inx11==10000){
				
				$inx11=1;
				
//				$outHtml1 .= '<tr colspan="24" align="center" style="height: 50px;vertical-align:middle;"><td colspan="14">&nbsp;</td>
//				       </tr>
//				   <tr><td colspan="14">&nbsp;</td>
//				       </tr>
//				         <td colspan="14">
//								<table     align="center"  dir="rtl"  width="90%">
//				                   <tr>
//				                      <td align="center" colspan="16" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
//				   
//				                   </tr>
//				                   
//				                    <tr> 
//				                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
//				                        
//				                    </tr>
//				                    </table>
//				              </td>
//				</tr></table></div>';
			
//				$outHtml1 .= '<div id="wrapper">
//        <div style="height: 30px;">
//           
//        </div>
//      
//        <div id="green-contents" class="contents" style="border: solid 1px #5f9000;">';
         
	 
			$outHtml1 .= '	

		<table  align="center" id="mt" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="header">
        			<th colspan="25" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش حواله به صورت تجمعى </center> </th>
        		</tr>
        		<tr class="header">
        			<th   colspan="13" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </th>
        			
        		</tr>
        		<tr class="header">
        			<th   colspan="6" style="height: 50px;vertical-align:middle;"> كد اقتصادي فروشنده  : '.$rowp['province_ecode'].'  </th>
        			
        			<th   colspan="8" style="height: 50px;vertical-align:middle;">  آدرس فروشنده   :
        			 '.$rowp['province_address'].'  </th>
        			
        		</tr>
      			<tr  class="header"  style="font-weight:bold;background-color:#BBF0F7;">
			       <th align="center">رديف </th>
			        <th align="center"> كد كالا</th>
			        <th align="center"> كد قيمت</th>
			        <th align="center"> نام كالا</th>
			         <td align="center"> قيمت واحد</th>
			          <th align="center"> هزينه اضافی</th>
			        <th align="center"> دسته کالا</th>
			        <th align="center">مقدار صادره اوليه</th>
	                <th align="center">مقدار ابطالی </th>
	                <th align="center">مقدار خالص صادره </th>	          
			        <th align="center">* مبلغ پرداختی* براساس صادره اوليه </th>
			          <th align="center">* مبلغ پرداختی* ابطالی </th>
			          <th align="center">* مبلغ پرداختی* خالص </th>
			         <th align="center">استان </th>				      		        	        
	    		        		        
				</tr>';
									            
			}	

					if(($inx1)%2==1){
							$color='#C5DED0';
							
						
						}
							else{
								$color='#BBB';
							   
							}
				
		 $inx11 =urlencode($inx1);
	     $inx11=farsinum($inx11);
	     $p_code =urlencode($row['p_code']);
	     $p_code=farsinum($p_code);
	     $p_price_code =urlencode($row['p_price_code']);
	     $p_price_code=farsinum($p_price_code);
		 
	     $shavale= $row['shavale'] - $sezaf;
		  $shavalepre=$row['shavalepre']-$sezafpre;
		  $shavale =urlencode($shavale);
		  $sadere1=$shavale;
	     $shavale=formatMoney($shavale);
	     $shavale=farsinum( $shavale);
	     $shavale= $row['shavale'] - $sezaf;
		 $shavalepre=$row['shavalepre']-$sezafpre;
	     $shavale=formatMoney($shavale);
	     $shavale=farsinum( $shavale);			
		 $sebtal=formatMoney($row['sebtal']);	
		 $sebtal=farsinum($sebtal);
	     $mande1 =urlencode($mande);
		 $mande1=formatMoney($mande1);
	      $mande1=farsinum($mande1);
	
	    $sebtalDakhel=farsinum( $row['sebtalDakhel']);
		$p_sellpriceh=farsinum( $row['p_sellprice']);
	    $hazineh=$row['h_p_add'];
        $hazineh = urlencode($hazineh);
		$hazineh1 =farsinum($hazineh);	
	    $sumprice = ($ro['ss']* ($row['p_sellprice']+$row['h_p_add']));
	    $sumpriceeb = ($row['sebtalDakhel']* ($row['p_sellprice']+$row['h_p_add']));
	    
	    $pricekh =urlencode(($sumprice)-($sumpriceeb));
	    $khales =$ro['ss'] - $row['sebtalDakhel'];
	    $khales1 = urlencode($khales);
        $khales1=formatMoney($khales1);
		$khales2=farsinum($khales1);
	    $shavalepre = urlencode($shavalepre);
        $shavalepre1=formatMoney($shavalepre);
		$shavalepre1=farsinum($shavalepre1);
		$sumprice1=formatMoney($sumprice);
		$sumprice1=farsinum($sumprice1);
		
		$sumpriceeb1=formatMoney($sumpriceeb);
		$sumpriceeb1=farsinum($sumpriceeb1);
		$pricekh1=formatMoney($pricekh);
		$pricekh2=farsinum($pricekh1);
		
			$outHtml1 .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx11.'</td>
					<td align="center" style="vertical-align:middle;">'.$p_code.'</td>
					<td  align="center" style="vertical-align:middle;">'.$p_price_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$p_sellpriceh.'</td>
					<td align="center" style="vertical-align:middle;">'.$hazineh1.'</td>		
					<td align="center" style="vertical-align:middle;">'.$row['cat_prod_name'].'</td>	
					<td align="center" style="vertical-align:middle;">'.$ss.'</td>
					
					<td align="center" style="vertical-align:middle;">'.$sebtalDakhel.'</td>
					<td align="center" style="vertical-align:middle;">'.$khales2.'</td>				  
					<td align="center" style="vertical-align:middle;">'.$sumprice1.'</td>
					<td align="center" style="vertical-align:middle;">'.$sumpriceeb1.'</td>
					<td align="center" style="vertical-align:middle;">'.$pricekh2.'</td>
					<td align="center" style="vertical-align:middle;">'.$row1['province_name'].'</td>
				
				</tr>';			
			$inx1++;
			$inx11++;
			$amount=$amount+$mande;
			$ebtal=$ebtal+$row['sebtalDakhel'];
			//mablagh
			$sumpriceakhar=$sumpriceakhar+$sumprice;
			$sumpriceebakhar=$sumpriceebakhar+$sumpriceeb;
			$pricekhakhar=$pricekhakhar+$pricekh;

			$amount1=formatMoney($amount);
			$ebtal1=formatMoney($ebtal);
			$sadere=$sadere1+$sadere;
			$jam=$jam+$ro['ss'];
			
		}
		$khales= $jam - $ebtal;
		//$khales=formatMoney($khales);
		//$khales=farsinum($khales);
		//$jam=formatMoney($jam);
		//$jam1=farsinum($jam);
		$ebtal1=formatMoney($ebtal1);
		$ebtal1=farsinum($ebtal1);		
		$outHtml1.= '</table>';
		
		$outHtml1000.= '<div>&nbsp;</div>
	                  <span style="background-color:red" width="70%">مقدار صادره اوليه:'.$jam.'كيلوگرم </span>
		                   <span style="background-color:red" width="70%">مبلغ صادره اولیه:'.$sumpriceakhar.'ریال </span>
		                  ' ;		
		$outHtml1.= '  <div id="green" style="margin: auto;">
            </div>
        </div>
       
        </div>
    </div>';
		$outHtml1000.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدار ابطالی:'.$ebtal.'كيلوگرم </span>
		                  <span style="background-color:red" width="70%">مبلغ ابطالی:'.$sumpriceebakhar.'ریال </span>
		                  ' ;
		$outHtml1000.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدار خالص دريافتی:'.$khales.'كيلوگرم </span>
		                   <span style="background-color:red" width="70%">مبلغ خالص دریافتی:'.$pricekhakhar.'ریال </span>
		                  ' ;								
    }else{
    	$outHtml1000 .= '<tr><td colspan="8">هيچ اطلاعاتي موجود نيست</td></tr></table>';
    }
    
    $queryu="SELECT * FROM dm_user_profile			 
			     WHERE u_id=".$u_id." ";	   
		$lnku = mysql_query($queryu);
		$rowu = mysql_fetch_assoc($lnku);
    $outHtml1 .= '<div align="right"> '.$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'</div>';
        $outHtml1 .= '<div align="right">توسط کاربر: '.$rowu['u_family'].' </div>';
        $outHtml .= '<div style="page-break-before:always";>&nbsp;</div>'; 
        echo $outHtml;
     echo $outHtml1; 
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
 
  function farsichar( $data )
{
$newstr = "";
$i = 0;
for ( ; $i <= strlen( $data ); ++$i )
{
$str = $data[$i];
$nstr = $str;
if ( $str == "ی" )
{
$nstr = str_replace( "ي", "ی", $str );
}
if ( $str == "۱" )
{
$nstr = str_replace( "ا", "۱", $str );
}
if ( $str == "ک" )
{
$nstr = str_replace( "ك", "ک", $str );
}

$newstr .= $nstr;
}
return $newstr;
}
function datesys(){
	
 return gmdate('Y-m-d');
//return	gmdate('Y-m-d H:i:s', strtotime('+6 days'));

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
$num=$num-2;
?>
    <script type="text/javascript">
        $(document).ready(function () {
            
     
           var d="<?php echo $num; ?>";
            $('#green').smartpaginator({ totalrecords:d, recordsperpage: 10, datacontainer: 'mt', dataelement: 'tr', initval: 0, next: 'Next', prev: 'Prev', first: 'First', last: 'Last', theme: 'green' });


            $('#red').smartpaginator({ totalrecords: 32, recordsperpage: 4, length: 4, next: 'Next', prev: 'Prev', first: 'First', last: 'Last', theme: 'red', controlsalways: true, onchange: function (newPage) {
                $('#r').html('Page # ' + newPage);
            }
            });

        });
    </script>