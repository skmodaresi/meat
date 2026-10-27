<?php 

include_once 'Pfactor_mgmt_lib.php';

switch ($cmd){
		
	case 'dspPreFactorFrm':
		
		echo dspPreFactorFrm();
		 break;
			
	case 'moarefinameh':
		
		echo moarefinameh();
		break;

	case 'dspPishHavale':	
	  
		   echo dspPishHavale();
		  break;
		  case 'moarefi':	
	     
		   echo moarefi();
		  break;    
	case'dspInfPardakht':
		dspInfPardakht();
		break;
		
	 case 'dspFactorFrm':
		echo dspFactorFrm();
		break;
		
	case'dspFactor':
		echo dspFactor();
		break;  
   case'dspFactor1':
		echo dspFactor1();
		break;  
	case 'dspPreFactorList':
		$_SESSION['srchStr'] = '';
		echo dspPreFactorList();
		break;
	 case 'searchCodePfactor':
        $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		$_SESSION['srchStr1'] = isset($_REQUEST['search1']) ? $_REQUEST['search1'] : '';	  echo	dspPreFactorList();
		break;
		
	case 'dspFactorList':
        $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		$_SESSION['srchStr1'] = isset($_REQUEST['search1']) ? $_REQUEST['search1'] : '';		echo dspFactorList();
		break;
    case 'searchCodefactor':
	   $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
	   $_SESSION['srchStr1'] = isset($_REQUEST['search1']) ? $_REQUEST['search1'] : '';
	    echo	dspFactorList();
		break;
	 case'sucessRegH':
	 	 sucessRegH();
	 	break;
	  case'sucessRegF':
	 	 sucessRegF();
	 	break;
	  case 'ShowAfactor':
	  	ShowAfactor();
	  	break;
	  case	'ShowAPfactor':
	  echo	ShowAPfactor();
	  	break;
	  case 'dspmoarefi':
	  echo	dspmoarefi();
	    break;
	  case 'dspPishFactor':
	  echo	dspPishFactor();
	    break;
	 
}

