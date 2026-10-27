<?php

include_once 'havale_mgmt_lib.php';
switch ($cmd){
	case 'dspPreFactorFrm':
		
		echo dspPreFactorFrm();
		 break;
		
	    case 'dspPreHavaleFrm':
	    	
		    dspPreHavaleFrm();
		    break;
		 case 'dsppHavaleFrm':
	    	
		    dsppHavaleFrm();
		    break;
	    case 'dspPreHavaleFrm2':
	    	$cType = isset($_REQUEST['cType']) ? $_REQUEST['cType'] : 'mot';
	    	$custId = isset($_REQUEST['cId']) ? $_REQUEST['cId'] : 0;
	    	$cm_req_num = isset($_REQUEST['cus_req_num']) ? $_REQUEST['cus_req_num'] : '';
	        $cm_req_date = isset($_REQUEST['cm_req_date']) ? $_REQUEST['cm_req_date'] : '';
	        $phm_id = isset($_REQUEST['phm_id']) ? $_REQUEST['phm_id'] : '';
	    
	    	$_SESSION['shomarePishHavale'] = '';
	    	
	    	dspPreHavaleFrm2($custId, $cm_req_num, $cm_req_date, $cType,$phm_id);
		    break;
	    case 'dspPishHavale1':	    		
		     echo dspPishHavale1();
		   break;			  
	   case 'dspPishHavale':	
	   
		   echo dspPishHavale();
		  break;
		
		case'regMotCustomer':
			$custId = regMotCustomer();
			$_SESSION['shomarePishHavale'] = '';
	    	$cm_req_num = isset($_REQUEST['cm_req_num']) ? $_REQUEST['cm_req_num'] : '';
	        $cm_req_date = isset($_REQUEST['cm_req_date']) ? $_REQUEST['cm_req_date'] : '';
	    	
		    dspPreHavaleFrm2($custId, $cm_req_num, $cm_req_date , 'mot');
			break;
		
		case 'addedprod':
			addedprod();
			break; 
		case 'editopr':
			editopr();
			break;  
			
		         	
	   case'dspHavaleProdFrm':
	   	dspHavaleProdFrm();
	   		break;
	   case 'dspPreHavaleList':
	  	  $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
	       echo	 dspPreHavaleList();
	   	      break;
	   	case 'searchCodePhavale':
		$_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		 echo	dspPreHavaleList();
		
		    break;
	   case 'ListMoarefi':
	   		 $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';	   	
	    echo 	ListMoarefi();
	    	break;
	     case 'ListMoarefieb':
	   		 $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';	   	
	    echo 	ListMoarefieb();
	    	break;
	   	case 'searchMoarefi':
		$_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		 echo 	ListMoarefi();
		     	    break;
		case 'searchMoarefieb':
		$_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		 echo 	ListMoarefieb();
		     	    break;
	   	case 'ShowAmoarefi':
	   		echo ShowAmoarefi();
	   		break;
	   	case 'sabthavaler':
	   	echo sabthavaler();
	   		break;
	   case	'ShowAhavale':
	     echo ShowAhavale();
	   	            break; 
	   	case 'searchCodePhavale':
	   $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		 echo dspPreHavaleList();
		     	    break;
	   case'EbtalHavale':
	   	echo EbtalHavale();
	   	break;
	   case 'ShowAPhavale':
	       	ShowAPhavale();
	            	break;  	   
	   case	'addAPrice2Bill':
	   	addAPrice2Bill();
	   	            break; 
	   	            	
	    case 'dspHavaleFrm':
		  echo dspHavaleFrm();
		break;
		
	case'dspPHavale1':
		echo dspPHavale1();
		break; 
	case'dspPHavale2':
		echo dspPHavale2();
		break;
	case 'dspHavaleList':
		$_SESSION['srchStr'] = '';
		$_SESSION['srchStr1'] = '';
		echo dspHavaleList();
		break;  	
	case 'searchCodehavale':
		$_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		$_SESSION['srchStr1'] = isset($_REQUEST['search1']) ? $_REQUEST['search1'] : '';
		$_SESSION['srchStr2'] = isset($_REQUEST['search2']) ? $_REQUEST['search2'] : '';
	  echo	dspHavaleList();
		     break;
	
	case 'ebtalList':
	echo	 ebtalList();
		break;
	case 'searchCodeebtal':
        $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		$_SESSION['srchStr1'] = isset($_REQUEST['search1']) ? $_REQUEST['search1'] : '';
		$_SESSION['srchStr2'] = isset($_REQUEST['search2']) ? $_REQUEST['search2'] : '';		
		echo ebtalList();
	//	$_SESSION['srchStr'] = '';
		break;
	case 'ebtalHavaleFrm':
		ebtalHavaleFrm();
		break;
	case 'ebtalHavale1':	
	echo ebtalHavale1();
		break; 
	case 'ebtalHavale2':	
	echo ebtalHavale2();
		break;
	case 'ShowAebtal':
	echo ShowAebtal();
		break; 
		
		case 'ebtalPage':
		
		ebtalPage();
		break; 
	case 'done':
		done();
		break;
	case 'ebtalMPage':
		ebtalMPage();
		break; 
	case 'ebtalMoarefi':
	echo ebtalMoarefi();
		 break; 
	case 'ebtalMoarefiname':
		ebtalMoarefiname();
		break;  
	case 'ebtalHavale3':
	  echo  ebtalHavale3();
		break; 
	 	
	case 'createNewH' :
		createNewH();
		break;
   case 'EbtalMessage' :
	 echo EbtalMessage();
		break;	
   case 'Ebtalafew_h' :
   	echo Ebtalafew_h();
   	    break; 
   	 case 'Ebtalafew_ht' :
   	echo Ebtalafew_ht();
   	    break;
   	    
   	     case 'delebtali' :
   	echo delebtali();
   	    break;
   	case 'getMenuInfo':
		$menu_id = isset($_REQUEST['menu_id']) ? $_REQUEST['menu_id'] : 0;
		$res = getListMenuInfo($menu_id);
		print_r($res);
	   $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$res['ug_id'].';'.$res['ug_category'].';';
		break;        
   	case 'getMenuInfo':
   		validateAndSave2();
   		break;
   	case 'EditPishHavaleFrm':
   		echo EditPishHavaleFrm();
   		break;
   	case 'EditHavaleFrm':
   		echo EditHavaleFrm();
   		break;
   	case 'EditPishHavale':
   		EditPishHavale();
   		break;
   	case 'EditHavale':
   		EditHavale();
   		break;
   	case 'editmasterphFrm':
   	echo	editmasterphFrm();
   		break;
   	case 'Editphprod':
   	echo	Editphprod();
   		break;
   	case 'editnewopr':
   		editnewopr();
   		break;
   	case 'createNewProd':
   		createNewProd();
   		break;
}
?>