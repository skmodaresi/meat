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
	       
	 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		

$queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);
$query = " 
				SELECT  * from dm_customer
					
 		 
	WHERE 
	   customer_code_org=".$province_id."
         ";
				
	//print $query;
	$lnk = mysql_query($query);
	$inx2=0;
    if(mysql_num_rows($lnk)>0){
	
    	$outHtml1 = '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
			 <tr>
				                      <td align="center" colspan="16" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="12" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
      			<tr class="rw1">
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش مشتريان </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			        <td align="center">رديف </td>			      
			        <td align="center"> کد مشتری</td>
			        <td align="center"> نام مشتری</td>			    
			        <td align="center">تلفن</td>
			        <td align="center">آدرس</td>
			        
			        			    		        		        
				</tr>';
    	$price=0;
    	
		while($row = mysql_fetch_assoc($lnk)){
			
		if(($inx2)%2==1){
							$color='#C5DED0';
							
						
						}
							else{
								$color='#BBB';
							   
							}
if($inx2==26){
	
		$outHtml1 .='</table><div class="page"></div>';
				
				$inx2=0;
				
				$outHtml1 .= '
				<table      align="center"  dir="rtl"  width="90%">
				                   <tr>
				                      <td align="center" colspan="16" style="text-shadow: -1px 0 black, 0 1px black  ;">&nbsp;</td>
				   
				                   </tr>
				                   
				                    </table>
				             </table>
								<table     style="height:90px;" align="center"  dir="rtl"  width="90%">
				                   <tr>
				                      <td align="center" colspan="16" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="12" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
				                    </table>
				             </table></div>';
			
	 	//<div align = "center">
				$outHtml1 .= '	
	
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="25" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش مشتريان </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			        <td align="center">رديف </td>			      
			        <td align="center"> کد مشتری</td>
			        <td align="center"> نام مشتری</td>			    
			        <td align="center">تلفن</td>
			        <td align="center">آدرس</td>			    		        		        
				</tr>';
									            
			}	
							
							
							
        $inx2 ++;
        $inx3 =urlencode($inx2);
       $inx3=farsinum($inx3);
       
          $code_customer=farsinum($row['code_customer']);
     
          $customer_tel=farsinum($row['customer_tel']);
          $code_identificate_customer=farsinum($row['code_identificate_customer']);
		$outHtml1 .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx3.'</td>
					<td align="center" style="vertical-align:middle;">'.$code_customer.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['name_customer'].'</td>
					<td  align="center" style="vertical-align:middle;">'. $customer_tel.'</td>	
					<td align="center" style="vertical-align:middle;">'.$row['customer_address_office'].'</td>
				</tr>';	
		
		}
		 
			
    }
    
    $queryu="SELECT * FROM dm_user_profile
			 
			     WHERE u_id=".$u_id."
			     ";
		   
		$lnku = mysql_query($queryu);
		$rowu = mysql_fetch_assoc($lnku);
  //  $outHtml .= '<div align="right"> '.$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'</div>';
    //    $outHtml .= '<div align="right">توسط کاربر: '.$rowu['u_family'].' </div>';
    
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
     