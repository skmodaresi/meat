<?php
    //$Path=$_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['PHP_SELF'])[1].'/'.explode('/',$_SERVER['PHP_SELF'])[2];
	$Path="../Message";
	include_once $Path."/Inc/GeneralClass/Ui.php";
	$Ui= new Ui("users",$Path);
	$Ui->CreateBo();
	$user=$_GET['user_id'];	
	$Ui->SetQuery("select user_id,CONCAT(first_name,' ',last_name)as user_reciever from users WHERE user_id != " . $user . " order by user_reciever asc");
	$Ui->Send();
?>
<?php
	if($Ui->BoObj->ResultList!="هیچ موردی یافت نشد"){
		for($ItemNo=0;$ItemNo<count($Ui->BoObj->ResultList);$ItemNo++){				
			echo "<option  value='".$Ui->BoObj->ResultList[$ItemNo]->user_id . "'>" . $Ui->BoObj->ResultList[$ItemNo]->user_reciever . "</option>";
		}
	}	
?>   