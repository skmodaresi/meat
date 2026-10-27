<?php
include_once 'includer.php';
$queryy = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnky = mysql_query($queryy);
	//	print $query1;
		$rowy= mysql_fetch_assoc($lnky);
		$year_code=$rowy['year_code'];
$query = "SELECT * FROM mali.acc_mofaser_detail WHERE mk=4 AND attrib=41  AND year=1397  and org=3 and code=377";	
		$lnk = mysql_query($query);

	if(mysql_affected_rows()>0){
		
		while($row= mysql_fetch_assoc($lnk)){
						 
			$name = iconv("windows-1256", "UTF-8", $row['name']);
		
	//	$code=iconv("windows-1256","UTF-8",$row['code']);
		
			$query1 = "INSERT INTO  dm_operation_acc 
			( 
				`g_id_acc`, 
			    `g_acc_name`, 
    			`g_acc_org` ,
    			`g_year` ,
    			`g_code` 
					
			)
			
		VALUES
			(
				'".$row['id']."', 
				'".$name."', 
				'".$row['org']."' ,
				'". $year_code ."' ,
				'".$row['code']."' 
					
			)
	";

	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();
		print $query1;		
		
		}
	}else{
		echo nadare;
	}
	print $query1;
	
 function unescape($source, $iconv_to = 'UTF-8') {
    $decodedStr = '';
    $pos = 0;
    $len = strlen ($source);
    while ($pos < $len) {
        $charAt = substr ($source, $pos, 1);
        if ($charAt == '%') {
            $pos++;
            $charAt = substr ($source, $pos, 1);
            if ($charAt == 'u') {
                // we got a unicode character
                $pos++;
                $unicodeHexVal = substr ($source, $pos, 4);
                $unicode = hexdec ($unicodeHexVal);
                $decodedStr .= code2utf($unicode);
                $pos += 4;
            }
            else {
                // we have an escaped ascii character
                $hexVal = substr ($source, $pos, 2);
                $decodedStr .= chr (hexdec ($hexVal));
                $pos += 2;
            }
        }
        else {
            $decodedStr .= $charAt;
            $pos++;
        }
    }

    if ($iconv_to != "UTF-8") {
        $decodedStr = iconv("UTF-8", $iconv_to, $decodedStr);
    }
   
    return $decodedStr;
}

?>
		