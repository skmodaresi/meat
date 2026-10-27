<?php
	session_start();
	//$Path=$_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['PHP_SELF'])[1].'/'.explode('/',$_SERVER['PHP_SELF'])[2];	
	$Path="../Message";	
	include_once $Path."/Inc/GeneralClass/BoMain.php";
	include_once $Path."/Inc/GeneralClass/Ui.php";
	$Ui= new Ui("comments",$Path);
	$Ui->CreateBo();
    if(isset($_SESSION['mt_user_id'])){	
		$Ui->SetQuery("SELECT (comment_read) as c FROM `comments` where comment_read = 0 AND delete_reciever=0 AND user_id_reciever =".$_SESSION['mt_user_id']);	
		$Ui->Send();
		$countofrow=$Ui->BoObj->RecordCount;
		if($Ui->BoObj->ResultList!="هیچ موردی یافت نشد"){
			echo $countofrow;
		}else{
			echo 0;
		}	
	}	
?>