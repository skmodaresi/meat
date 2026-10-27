<?php
require_once __DIR__ . '/../mysql_compat.php';
include_once 'includer.php';
 $query = "
			UPDATE dm_year 
			SET 
				`year_status` = '". 0 ."'
				
									 
			WHERE 
				year_id ='". 8 ."' 	";  
    $lnk = mysql_query($query);
	 	if(mysql_error()) print mysql_error();
		print $query;
	 	$query = "
						UPDATE dm_year 
						SET 
							`year_status` = '". 1 ."'
							
												 
						WHERE 
							year_id = '". 9 ."' 	";  
	    $lnk = mysql_query($query);
	 	if(mysql_error()) print mysql_error();
	 	$query = "
						UPDATE dm_user_profile 
						SET 
							u_year_id = '". 9 ."' 
							
												 
						WHERE 
						
							u_year_id = '". 8 ."' 	"; 
print $query;							
	    $lnk = mysql_query($query);
	 	if(mysql_error()) print mysql_error();
	 	

	 	
	 //az enja

$i=1;
for ( ; $i <37; ++$i ){
	

	 $query1 = "select * from dm_pish_havale_det phd
	            left join dm_pish_havale ph
	            on phd.phd_ph_code=ph.ph_code and phd_id_province=ph_id_province
	            left join dm_pish_factor pf on ph.ph_code=pf.pf_ph_code and pf_id_province=ph_id_province
	            where
	            phd_status=0
	            and
	             phd_id_province=".$i."
	             and
	             ph_id_province=".$i."
	             and
	              ph_reg_date between '2018-07-19'   and    '2019-03-19' 
	              group by phd_id 
	             order by phd_id desc";
	 	$lnk1 = mysql_query($query1);
		
			while($row1 = mysql_fetch_assoc($lnk1))
			{
	$ph_phm_id=$row1['ph_phm_id'];
	
		$querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$row1['ph_phm_id']."  ";
          
					$lnkmm = mysql_query($querymm);
					$rowmm = mysql_fetch_assoc($lnkmm);
				echo 	$rowmm['phm_amount'];
				echo '/';
				echo $rowd['phd_amount'];
				echo '/';
				echo $rowmm['phm_amountes'];
					
	$phm_amount=($rowmm['phm_amount']+$row1['phd_amount']);
	$phm_amountes=($rowmm['phm_amountes']-$row1['phd_amount']);	
						
					$queryphm = "
							UPDATE dm_op_mojavez 
							SET 
								  			 
								`phm_amount` = '".$phm_amount."',
								`phm_amountes` = '".$phm_amountes."'   			
													 
							WHERE 
								phm_id = ".$ph_phm_id." 	";
								
						$lnkphm = mysql_query($queryphm);
					print ($queryphm);
					if(mysql_error()) print mysql_error();			

				$querypf = "
					DELETE FROM dm_pish_factor
				 
						WHERE 
							pf_ph_code = ".$row1['ph_code']." 
					AND
					        pf_id_province=".$i."";

					$lnkpf = mysql_query($querypf);
					
					if(mysql_error()) print mysql_error();
				print $querypf;
				$queryph = "
					DELETE FROM dm_pish_havale
				 
						WHERE 
							ph_id = ".$row1['ph_id']." 
					AND
					        ph_id_province=".$i."
					";
					
					$lnkph = mysql_query($queryph);
					if(mysql_error()) print mysql_error();
			print $queryph;
				
					
				$queryphd = "
					DELETE FROM dm_pish_havale_det
				 
						WHERE 
							phd_id = ".$row1['phd_id']." 
					AND
					        phd_id_province=".$i."
					  and
					  phd_status=0      
					        
					        ";

					$lnkphd = mysql_query($queryphd);
					
					if(mysql_error()) print mysql_error();
				

	
	
					}	
}
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
    
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ايجاد سال جديد</title>
<script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
<script type="text/javascript">
<!--//---------------------------------+
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
// --------------------------------->
$(document).ready(function()
{
	//first slide down and blink the alert box
    $("#object").animate({ 
        top: "100px"
      }, 2000 ).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
   
   //close the message box when the cross image is clicked 
   $("#close_message").click(function()
	{
	   $("#object").fadeOut("slow");
	});
});
</script>
<style type="text/css">
body {
	font: 30px Verdana,Arial, Helvetica, sans-serif;
	margin: 10px auto;
	width: 300px;
	
	
}
.message{
    border:1px solid #CCCCCC;
    align:center;
	position:absolute;
	width:1000px;
	border:1px solid #c93;
	background:orange;
	padding:5px;
	right:0px;
	top : -170px;
}


</style>
</head>
<body>

<div id="object" class="message"> 
  
    <strong> <b> سال نو مبارك </b></strong>
  <p >!!!!!!!! سال جديد ايجاد شد </p>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div style="color:#0000FF "><strong></strong></div>
  

</body>
</html>