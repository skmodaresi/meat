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
// if(!empty($_REQUEST['prov_list'])) {
// 	$prov='';
// 	
//    foreach($_REQUEST['prov_list'] as $check) {
//    	  $prov .=$check.',';
//    	  if($i==1){
//        
//    	  }   
//        $i++;   
//    }
//    $prov .='900';
//}
	$outHtml1='';  
   $queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);

	$outHtml1='<div><table     align="center"  dir="rtl"  width="90%">
                   <tr>
                      <td align="center" colspan="18" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
   
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b></td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="11" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
             </table></div>';

	
	$outHtml1 .= '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
	
        		<tr class="rw1">
        			<td colspan="12" align="center" style="height: 50px;vertical-align:middle;"><center>گزارش فروش گوشت مرغ</center> </td>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="12" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </td>
        			
        		</tr>
      			 <tr>
      			   <td colspan="2" rowspan="3" bgcolor="#99FFFF"><div align="center"><strong>نام استان</strong></div></td>
      			
			  </tr>';
	$querymorgh = "
	 	SELECT *  FROM dm_prod_morgh 
 
		WHERE 
			1"; 
		 		
	$lnkmorgh = mysql_query($querymorgh);
	$outHtml1 .= '  <tr>';
	while($rowmorgh = mysql_fetch_assoc($lnkmorgh)){
			$outHtml1 .= '  
			<td colspan="2" bgcolor="#99FFFF"><div align="center"><strong>توزیع با فی('.$rowmorgh['pm_price'].')</strong></div></td>
			          </td>
		';
	}
	$outHtml1 .= '  </tr>';
	 $outHtml1 .= ' <tr bgcolor="#99FFFF"   style="font-weight:bold;" >
						   <td width="100"   align="center">توزیع روز</td>
						    <td width="100"  align="center">توزیع کلی</td>
						    <td width="100"  align="center">توزیع روز</td>
						    <td width="100"  align="center">توزیع کلی</td>
						    <td width="100"  align="center">توزیع روز</td>
						    <td width="100"  align="center">توزیع کلی</td>
						    <td width="100"  align="center">توزیع روز</td>
						    <td width="100"  align="center">توزیع کلی</td>
						    <td width="100"  align="center">توزیع روز</td>
						    <td width="100"  align="center">توزیع کلی</td>
						  </tr>';
	
	
    $query = 'SELECT ';
	$querymorgh = "
	 	SELECT *  FROM dm_prod_morgh 
 
		WHERE 
			1"; 
		 		
	$lnkmorgh = mysql_query($querymorgh);
	while($rowmorgh = mysql_fetch_assoc($lnkmorgh)){
	$query .= 'sum( case when  h_price_code='.$rowmorgh['pm_price_code'].'   then  ifnull(h_amount,0) else 0 end ) as  "'.$rowmorgh['pm_price'].'r"

	
	,';
	
	
	$query .= 'sum( case when  h_price_code='.$rowmorgh['pm_price_code'].'   and  h_reg_date="'.$EndDate.'" then ifnull(h_amount,0) else '. 0 .' end ) as "'.$rowmorgh['pm_price'].'" 

	
	,';
		
	}
	$query .= 'h_id_province
				        ,  pp.province_code_alef,pp.province_name';
	
	$query .= "
				
				
				from (
				
				select province_code_alef ,h_reg_date,h_p_code,h_price_code,type_prod_id,h_amount,h_priceh,h_id_province,p_code,h_code,price_id_province 
				from dm_havale h left join dm_product prod on prod.p_code=h.h_p_code 
				left join dm_price price on prod.p_id=price.`price_p_id`  
				left join dm_pish_factor pf on h.h_pf_code=pf.pf_code and pf_id_province in  (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1) 
				left join dm_prod_det_t prod_t on prod_t.type_prod_id=prod.p_type 
				left join dm_province  prov on  prov.province_id=h.h_id_province
				where h_id_province in (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1) 
				and h.h_reg_date between  '".$firstDate."'  AND  '".$EndDate."'
				and price_id_province in (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1) 
				and h.`h_id_province`=price.`price_id_province` 
				GROUP BY h_id_province,h_code
				
				
				)
				 as c 
				 right join dm_province pp on c.h_id_province = pp.province_id
				group by province_id order by  pp.province_code_alef
	";
	

	
//print $query;	
	$lnk = mysql_query($query);
	global $inx1;
	global $inx11;
	$inx1=1;
	$inx11=1;
	$gosfandv=0;
				$gosfandda=0;
				$gosalev=0;
				$gosaled=0;
				$morghv=0;
				$morghd=0;
	if(mysql_affected_rows()>0){
		
		$in1=0;
		$in2=0;
		$in3=0;
		$in4=0;
		$in5=0;
		$in6=0;
		$in7=0;
		$in8=0;
		$in9=0;
		$in10=0;
	
		while($row = mysql_fetch_assoc($lnk)){
			
			$query1= " select * from dm_province 
			            where 
			              province_code=".$row['h_id_province']."	";

			$lnk1 = mysql_query($query1);
			$row1 = mysql_fetch_assoc($lnk1);
			
			$h_id_province=$row['h_id_province'];
		if( $code_customer != -2){
		$shart = "   h_customer_code= ". $code_customer ."";	
	}else{
$shart = "  1 ";	
}	

//print $query2;


		if($inx11==2000){
				
				$inx11=1;
				
				$outHtml1 .= '<tr colspan="24" align="center" style="height: 50px;vertical-align:middle;"><td colspan="14">&nbsp;</td>
				       </tr>
				   <tr><td colspan="14">&nbsp;</td>
				       </tr>
				         <td colspan="14">
								<table     align="center"  dir="rtl"  width="90%">
				                   <tr>
				                      <td align="center" colspan="16" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
				                    </table>
				              </td>
                   
				
				</tr></table></div>';
			
	 	//	<div align = "center">
		//<div align = "center" style="direction:rtl;">
			
									            
			}	
		
					if(($inx1)%2==1){
							$color='#C5DED0';
							
						
						}
							else{
								$color='#BBB';
							   
							}
		                    // if($row['shavale']> $row['sebtal']){
								//}else{
								 
									
							//	}				
							
	     $inx11 =urlencode($inx1);
	     $inx11=farsinum($inx11);
	     $querymorgh1 = "
	 	SELECT *  FROM dm_prod_morgh 
 
		WHERE 
			pm_col=1"; 
		 		$outHtml1 .= '	
				     
						 <tr style="background-color:'.$color.';">
						 <td width="100" colspan="2" align="center" >'.$row['province_name'].'</td>
						 ';
	$lnkmorgh1 = mysql_query($querymorgh1);
	 $j=1;
	 	
	while($rowmorgh1 = mysql_fetch_assoc($lnkmorgh1)){
	 
		
		
		   $outHtml1 .= '	
						    <td width="100" align="center">'.round($row[$rowmorgh1['pm_price']]).'</td>
						    <td width="100"  align="center">'.round($row[$rowmorgh1['pm_price'].'r']).'</td> ';	
						    
						    
						  
								
			//$amount=$amount+$mande;
//			echo  $in.$j;
//			echo '/';
//				$in.$j=$in.$j+$row[$rowmorgh1['pm_price']];
//				$in.$j.$j=$in.$j.$j+$row[$rowmorgh1['pm_price'].'r'];
//				
				
				$j++;
				$inx1++;
			$inx11++;
	}		
		$outHtml1 .= ' </tr>';
		}
		
//bara jam		
		$query1 = 'SELECT ';
	$querymorgh = "
	 	SELECT *  FROM dm_prod_morgh 
 
		WHERE 
			1"; 
		 		
	$lnkmorgh = mysql_query($querymorgh);
	while($rowmorgh = mysql_fetch_assoc($lnkmorgh)){
	$query1 .= 'sum( case when  h_price_code='.$rowmorgh['pm_price_code'].'   then  h_amount else 0 end ) as  "'.$rowmorgh['pm_price'].'r"

	
	,';
	
	
	$query1 .= 'sum( case  h_price_code='.$rowmorgh['pm_price_code'].'   and  h_reg_date="'.$EndDate.'" then h_amount else '. 0 .' end ) as "'.$rowmorgh['pm_price'].'" 

	
	,';
		
	}
	$query1 .= 'h_id_province
				        ,  province_code_alef';
	
	$query1 .= "
				
				
				from (
				
				select province_code_alef ,h_reg_date,h_p_code,h_price_code,type_prod_id,h_amount,h_priceh,h_id_province,p_code,h_code,price_id_province 
				from dm_havale h left join dm_product prod on prod.p_code=h.h_p_code 
				left join dm_price price on prod.p_id=price.`price_p_id`  
				left join dm_pish_factor pf on h.h_pf_code=pf.pf_code 
				left join dm_prod_det_t prod_t on prod_t.type_prod_id=prod.p_type 
				left join dm_province  prov on  prov.province_id=h.h_id_province
				where  
			 h.h_reg_date between  '".$firstDate."'  AND  '".$EndDate."'
				
				and h.`h_id_province`=price.`price_id_province` 
				GROUP BY h_id_province,h_code
				
				
				)
				 as c  order by  province_code_alef
	";
	

	
//print $query1;	
	$lnk1 = mysql_query($query1);
		
$row1 = mysql_fetch_assoc($lnk1);
	
	  $querymorgh1 = "
	 	SELECT *  FROM dm_prod_morgh 
 
		WHERE 
			1"; 
		 		$outHtml1 .= '	
				     
						 <tr style="background-color:#E69CCB;">
						   
						    <td width="100" colspan="2" align="center" >جمع کل:</td>
						 ';
	$lnkmorgh1 = mysql_query($querymorgh1);
	 $j=1;
	 	
	while($rowmorgh1 = mysql_fetch_assoc($lnkmorgh1)){
	 
		
		
		   $outHtml1 .= '	
						    <td width="100" align="center">'.$row1[$rowmorgh1['pm_price']].'</td>
						    <td width="100"  align="center">'.$row1[$rowmorgh1['pm_price'].'r'].'</td> ';	
		   
		   
	
		
	
		
	
	
    }
    	$outHtml1 .= ' </tr>';	
	}

    $queryu="SELECT * FROM dm_user_profile
			 
			     WHERE u_id=".$u_id."
			     ";
		   
		$lnku = mysql_query($queryu);
		$rowu = mysql_fetch_assoc($lnku);
  //  $outHtml1 .= '<div align="right"> '.$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'</div>';
     //   $outHtml1 .= '<div align="right">توسط کاربر: '.$rowu['u_family'].' </div>';
        
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
    