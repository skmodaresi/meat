<?php 
    header('Content-Type: text/html; charset=UTF-8');
	global $pg, $cmd;
//	if(isset($_REQUEST['pg'])){
//		$pg = $_REQUEST['pg'];
//	}else{
//		$pg = 'home';
//	}
	
    
	$pg = (isset($_REQUEST['pg'])) ? $_REQUEST['pg'] : 'login_pg';
	$cmd = (isset($_REQUEST['cmd'])) ? $_REQUEST['cmd'] : 'dspFrm';
	$bgcolor = (isset($_REQUEST['bgcolor'])) ? $_REQUEST['bgcolor'] : '87AFE6';
	$htablecolor = (isset($_REQUEST['htablecolor'])) ? $_REQUEST['htablecolor'] : 'EBE9B9';
	
	include_once 'includer.php';

	preProcess();
	if($_SESSION['isLogged'] == false ){

		$pg='login_pg';
		$cmd='dspFrm';
	}
	$querys="select * from  dm_setting 
				where
			s_u_id='".$_SESSION['dm_user_profile']['u_id']."'";
			
	$lnks = mysql_query($querys);
	//print $querys;
	$rows=mysql_fetch_assoc($lnks);
	//echo $rows['s_bgcolor'];
	if($rows['s_bgcolor']==''){
		$bgcolor='87AFE6';
		$htablecolor='EBE9B9';
		
	}else{
	$bgcolor=$rows['s_bgcolor'];
	$htablecolor=$rows['s_htablecolor'];
	}
	$bgcolor='#'.$bgcolor;
	//echo $bgcolor;
$htablecolor='#'.$htablecolor;
$_SESSION['bgcolor']=$bgcolor;
$_SESSION['htablecolor']=$htablecolor;

?>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="styles/main.css" type="text/css" >
   <link rel="stylesheet" href="styles/main1.css" type="text/css" >
   <title><?php echo getTitle(); ?></title>
   <script type="text/javascript" src="lib/js/general.js"></script>
   <script type="text/javascript" language="" src="lib/js/jquery-1.2.6.min.js"></script> 
   <script src='lib/js/jquery.min.js'></script> 	
   <script type="text/javascript" src="lib/js/jscolor.js"></script>   
   <script type="text/javascript" src="lib/js/jquery.ui.core.js"></script>
   <script type="text/javascript" src="lib/js/jquery.ui.datepicker-cc.js"></script>
   <script type="text/javascript" src="lib/js/calendar.js"></script>
   <script type="text/javascript" src="lib/js/jquery.ui.datepicker-cc-ar.js"></script>
   <script type="text/javascript" src="lib/js/jquery.ui.datepicker-cc-fa.js"></script>
   <script type="text/javascript" src="lib/assets/js/js.js"></script>
   <link rel="stylesheet" type="text/css" media="screen" href="lib/css/screen.css" />
   <link href="lib/css/dropdown/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
   <link href="lib/css/dropdown/themes/default/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />
   <link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
   <link rel="stylesheet" href="styles/standard-style.css" type="text/css" media="screen" />
     
   <link rel="stylesheet" type="text/css" href="styles/buttons.css"/>
</head>

<?php //<link rel="stylesheet" type="text/css" href="styles/sreset-min.css"/>  ?> 
<script >
</script>


<table  style="background-color:<?php echo $_SESSION['bgcolor'] ?>;" align="center">
	<tr style="height:600px;" >
      <td>
			<table   class="tblMain">
			     <tr>
					<td style="width:100%;" align="center">
						<table border="1" style="width:980px;flate;">
						    <tr style="height:100px;"><td><img src="images/banner.JPG" width=100% style="height:150px;"></img></td>  </tr>
							<tr style="height:20px;background-color:#dddddd;"><td colspan="2" style="vertical-align:middle;background-color:#dddddd;"><?php echo getTopMenu(); ?></td></tr>	
							<tr style="height:500px;"><td><?php echo getBody(); ?></td></tr>							
			                
							<tr style=" background-color:#dddddd;"><td colspan="2" align="left"> <?php echo getFooter(); ?></td></tr>
						</table>
					</td>
					
				</tr>				
			</table>
		</td>	
	</tr>
</table>
<body>
</body>
</html>
