	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require_once __DIR__ . '/../../mysql_compat.php';
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
		// global $outHtml;
		// global $outHtml1;
		// global $outHtml2;
		
$queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);
$query = " 
				SELECT 
						h_code ,
						
						h_reg_date ,
						ph_mojavez ,
						p_name ,
						
						pf_code ,
						ph_code ,
						
						p_sellprice ,
						h_amount ,
						l_name ,
						h_customer_code ,
						name_customer ,
						
						category_name               
  FROM dm_havale h left join dm_product p 
  on h.h_p_code=p.p_code
  
		left join dm_price price
		on p.p_id=price.price_p_id
        left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type
        left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type
        left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category
        left join dm_location_goods l on l.l_id=h.h_l_code
        inner join dm_customer cus on  cus.code_customer=h.h_customer_code
        left join dm_pish_factor pf on h.h_pf_code=pf.pf_code
        inner join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code 
        left join dm_customer_category cuscat
        on cus.customer_category=cuscat.category_id
 		 
	WHERE 
	   price_id_province=".$province_id."
       and h_id_province=".$province_id."
       and ph_id_province=".$province_id."
       and pf_id_province=".$province_id."
       and p_price_code=h_price_code
       and customer_code_org=".$province_id."
      
         ";
		
			
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
if ($code_customer != -2){
		
		$query .= " AND  h_customer_code= ".$code_customer ." ";
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

	if ($category_id != -2){
		 
		$query .= "  AND   category_id= ". $category_id ." ";
	}
	$query .= "	AND
		     h_reg_date =   '".$firstDate."'  ";
	$query .= " group by  `pf_code` ORDER BY pf_code asc ";
	
	$lnkh = mysql_query($query);
	//print $query;
	$inx2=0;
    if(mysql_num_rows($lnkh)>0){
	
    	$outHtml1 = '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش پرداختى </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			        <td align="center">رديف </td>			      
			        <td align="center"> شماره پیش فاکتور</td>
			        <td align="center"> شماره پیش نویس</td>
			        <td align="center"> نام مشتری</td>
			        <td align="center">کد سند</td>
			        <td align="center">نوع سند</td>
			        <td align="center">نام بانک</td>
			        <td align="center"> نام شعبه</td>
			        <td align="center">تاریخ /شماره سررسید</td>
			        <td align="center">مبلغ</td>
			        			    		        		        
				</tr>';
    	$price=0;
    	
		while($row1 = mysql_fetch_assoc($lnkh)){
			
			$querydpf="select *
							from dm_pf_document 
							where 
							dpf_id_province='".$province_id."'
							and
							dpf_pf_code='".$row1['pf_code']."'";			
				               $lnkdpf = mysql_query($querydpf);
				              
				               
				  while($rowdpf = mysql_fetch_assoc($lnkdpf)){
			
			$queryd="select *
							from dm_documentk doc 
							left join dm_doc_det_b  doc_b
							on doc_b.doc_b_id=doc.d_bank 
							left join  dm_doc_det_t doc_t
							on doc_t.doc_t_id=doc.d_documenttype
							where 
							d_id='".$rowdpf['dpf_d_id']."'";					
				               $lnkd = mysql_query($queryd);
				               $rowd = mysql_fetch_assoc($lnkd);
				             
        $inx2 ++;
        $inx3 =urlencode($inx2);
       $inx3=farsinum($inx3);
       $price=formatMoney($price);
       $price=farsinum($price);
          $ph_code=farsinum($row1['ph_code']);
          $pf_code=farsinum($row1['pf_code']);
          $d_code=farsinum($rowd['d_code']);
          $dpf_sarresid=farsinum($rowdpf['dpf_sarresid']);
          $dpf_price=formatMoney($rowdpf['dpf_price']);
       $dpf_price=farsinum($dpf_price);
		$outHtml1 .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx3.'</td>
					<td align="center" style="vertical-align:middle;">'.$pf_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$ph_code.'</td>
					<td  align="center" style="vertical-align:middle;">'.$row1['name_customer'].'</td>	
					<td  align="center" style="vertical-align:middle;">'. $d_code.'</td>	
					<td align="center" style="vertical-align:middle;">'.$rowd['doc_t_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowd['doc_b_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowd['d_branch'].'</td>
					
					<td align="center" style="vertical-align:middle;">'.$dpf_sarresid.'</td>
					<td align="center" style="vertical-align:middle;">'.$dpf_price.'ريال </td>
				</tr>';	
		$price1=$price1 +	$rowdpf['dpf_price'];	
		}
		}
		 $price1=formatMoney($price1);
         $price1=farsinum($price1);
		$outHtml1.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%"> مبلغ کل:'.$price1.'ریال </span>' ;	
	
		
		
    }
    
    $queryu="SELECT * FROM dm_user_profile
			 
			     WHERE u_id=".$u_id."
			     ";
		   
		$lnku = mysql_query($queryu);
		$rowu = mysql_fetch_assoc($lnku);
    $outHtml .= '<div align="right"> '.$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'</div>';
        $outHtml .= '<div align="right">توسط کاربر: '.$rowu['u_family'].' </div>';
    
    echo $outHtml;
     echo $outHtml1;
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
     