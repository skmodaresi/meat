<?php

include_once 'prodMgmtPg_det_lib.php';
	
switch ($cmd){
		
	case 'category_prod':		
		echo category_prod();
		break;
	case 'regProd_catFrm':
		 regProd_catFrm();
		break;
	case 'regProd_cat':		
		 regProd_cat();
	echo category_prod();
		break;
	case 'cat_prodEditFrm':
		cat_prodEditFrm();
		break;
	case 'cat_prodDelete':
		cat_prodDelete();
	echo category_prod();
		break;
	case 'cat_prod_update':
		
		cat_prod_update();
	echo category_prod();
		break;
//category
  case 'pack_prod':	
		echo pack_prod();
		break;
	case 'regProd_packFrm':
		 regProd_packFrm();
		break;
	case 'regpack_prod':		
		 regpack_prod();
	echo pack_prod();
		break;
	case 'pack_prodEditFrm':
		pack_prodEditFrm();
		break;
	case 'pack_prodDelete':
		pack_prodDelete();
	echo pack_prod();
		break;
	case 'pack_prod_update':
		
		pack_prod_update();
	echo pack_prod();
		break;
//type
 case 'type_prod':	
  
		echo type_prod();
		break;
	case 'regProd_typeFrm':
		 regProd_typeFrm();
		break;
	case 'regtype_prod':		
		 regtype_prod();
	echo type_prod();
		break;
	case 'type_prodEditFrm':
		type_prodEditFrm();
		break;
	case 'type_prod_update':
		
		type_prod_update();
	echo type_prod();
		break;
	case 'type_prodDelete':
		type_prodDelete();
	echo type_prod();
		break;
		//unit
 case 'unit_prod':	
  
		echo unit_prod();
		break;
	case 'regProd_unitFrm':
		 regProd_unitFrm();
		break;
	case 'regunit_prod':		
		 regunit_prod();
	echo unit_prod();
		break;
	case 'unit_prodEditFrm':
		unit_prodEditFrm();
		break;
	case 'unit_prod_update':
		
		unit_prod_update();
	echo unit_prod();
		break;
	case 'unit_prodDelete':
		unit_prodDelete();
		echo unit_prod();
		break;
//doc type
case 'doc_type':	
		echo doc_type();
		break;
case 'ebtalreasonlist':
	echo ebtalreasonlist();
	break;
case 'regebreason':
	regebreason();
	echo ebtalreasonlist();
	break;
case 'ebreasonDelete':
	ebreasonDelete();
	ebtalreasonlist();
	break;
case 'ebreason_update':
	ebreason_update();
	ebtalreasonlist();
	break;
case 'createmojavezFrm':
	createmojavezFrm();
	break;
case 'editmojavejk':
	editmojavejk();
	break;
case 'createmojavezFrm_yeki':
	createmojavezFrm_yeki();
	break;
case 'ebreasonEditFrm':
	ebreasonEditFrm();
	break;
case 'regebreasonFrm':
	   regebreasonFrm();
	   break;
	case 'regdoc_typeFrm':
		 regdoc_typeFrm();
		break;
	case 'regdoc_type':		
		 regdoc_type();
	echo doc_type();
		break;
	case 'doc_typeEditFrm':
		doc_typeEditFrm();
		break;
	case 'doc_type_update':
		
		doc_type_update();
	echo doc_type();
		break;
	case 'doc_typeDelete':
		doc_typeDelete();
		echo doc_type();
		break;
		
//bank
case 'doc_typeb':	
		echo doc_typeb();
		break;
	case 'regdoc_typebFrm':
		 regdoc_typebFrm();
		break;
	case 'regdoc_typeb':		
		 regdoc_typeb();
	echo doc_typeb();
		break;
	case 'doc_typebEditFrm':
		doc_typebEditFrm();
		break;
	case 'doc_typeb_update':		
		doc_typeb_update();
	   echo doc_typeb();
		break;
	case 'doc_typebDelete':
		doc_typebDelete();
		  echo doc_typeb();
		  break;
		//cus act

	case 'cus_act':
	    echo cus_act();
		break;
    case 'regcus_actFrm':
	   echo regcus_actFrm();
		break;
	case 'regcus_act':
		echo regcus_act();
		echo cus_act();
		break;
	case 'cus_activeEditFrm':
		cus_activeEditFrm();
		break;
   case 'cus_act_update':
		cus_act_update();
	echo cus_act();
		break;	
	case 'cus_activeDelete':
     	cus_activeDelete();
    	echo cus_act();
//cus pay
	case 'cus_pay':
	    echo cus_pay();
		break;
    case 'regcus_payFrm':
	   echo regcus_payFrm();
		break;
	case 'regcus_pay':
		echo regcus_pay();
		echo cus_pay();
		break;
	case 'cus_payEditFrm':
		cus_payEditFrm();
		break;
   case 'cus_pay_update':
		cus_pay_update();
		echo cus_pay();
        break;
   case 'cus_payDelete':
   	cus_payDelete();
     	echo cus_pay();
    	break;
   
//cus person
   case 'cus_person':	  
	    echo cus_person();
		break;
   case  'cus_personEditFrm':
   	    echo cus_personEditFrm(); 	   
     	break;
   case 'cus_person_update':
   	    cus_person_update();
       echo cus_person();
       break;
   case 'regcus_personFrm':
   	   echo regcus_personFrm();
   	break;
   case 'regcus_person':
     	regcus_person();
   	 echo cus_person(); 
   	 break;
     case 'cus_personDelete':
     	cus_personDelete();
     	 echo cus_person();
     	 break;
 //cus type  	
 case 'cus_type':	  
	    echo cus_type();
		break;
   case  'cus_typeEditFrm':
   	    echo cus_typeEditFrm(); 	   
     	break;
   case 'cus_type_update':
   	    cus_type_update();
       echo cus_type();
       break;
   case 'regcus_typeFrm':
   	   echo regcus_typeFrm();
   	break;
   case 'regcus_type':
     	regcus_type();
   	 echo cus_type();
   	  break;
   case 'cus_typeDelete':
    	cus_typeDelete();
   	echo cus_type();
   	break;
  
   	 //cus status  	
 case 'cus_status':	  
	    echo cus_status();
		break;
   case  'cus_statusEditFrm':
   	    echo cus_statusEditFrm(); 	   
     	break;
   case 'cus_status_update':
   	    cus_status_update();
       echo cus_status();
       break;
   case 'regcus_statusFrm':
   	   echo regcus_statusFrm();
   	break;
   case 'regcus_status':
     	regcus_status();
   	 echo cus_status();
   	 break;
   case 'status_typeDelete':
    	status_typeDelete();
   	 echo cus_status();
   	 break;
   	 //status_s
   	  case 'cus_status_s':	  
	    echo cus_status_s();
		break;
   case  'status_s_typeEditFrm':
   	    echo status_s_typeEditFrm(); 	   
     	break;
   case 'cus_status_s_update':
   	    cus_status_s_update();
       echo cus_status_s();
       break;
   case 'regcus_status_sFrm':
   	   echo regcus_status_sFrm();
   	 
   	break;
   case 'regcus_status_s':
     	regcus_status_s();
   	 echo cus_status_s();
   	 break;
   case 'status_s_typeDelete':
    	status_s_typeDelete();
   	 echo cus_status_s();
   	 break;
   	 	 //charge type
  	  case 'charge_type':  	  		  
	    echo charge_type();
		break;
   case  'charge_tEditFrm':
   	    echo charge_tEditFrm(); 	   
     	break;
   case 'charge_t_update':
   	    charge_t_update();
       echo charge_type();
      break;
   case 'regcharge_tFrm':
   	   echo regcharge_tFrm();
  	break;
   case 'regcharge_t':
     	regcharge_t();
   	 echo charge_type();
     break;
   case 'charge_tDelete':
     	charge_tDelete();
   		 echo charge_type();
   		 break;
  //account doc
   case 'Create_docFrm':
	   	Create_docFrm();
	   	break;
   case 'docFrmEdit':
	   	docFrmEdit();
	   	break;   
    case'UpDoc':
        UpDoc();
        echo Create_docFrm();          
      break;
    case 'createFileFrm':
    	 echo createFileFrm();
      break;
      case 'createFileFrmjari':
    	 echo createFileFrmjari();
      break;
       case 'createFileFrm1':
    	 echo createFileFrm1();
      break;
       case 'createFileFrm2':
    	 echo createFileFrm2();
      break;
       case 'createFileFrmfrig':
    	 echo createFileFrmfrig();
      break;
      case 'createFileFrmfrigeb':
    	 echo createFileFrmfrigeb();
      break;
      case 'createFileFrmstore':
    	 echo createFileFrmstore();
      break;
      case 'createFilefrig':
    	 echo createFilefrig();
      break;
      case 'createFilestore':
    	 echo createFilestore();
      break;
    case 'createFile':
        createFile();
      break;
 //change province
    case 'changeProvinceFrm':
    	changeProvinceFrm();
    	break;
    case 'changeProvince':
    	changeProvince();
    	break;
   
}
?>
