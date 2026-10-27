
<?php
    //$Path=$_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['PHP_SELF'])[1].'/'.explode('/',$_SERVER['PHP_SELF'])[2];
	$Path="../Message";
	include_once $Path."/Inc/GeneralClass/Ui.php";
	$Ui= new Ui("roles",$Path);
	$Ui->CreateBo();
	$Ui->SetQuery("select role_id,role_description from roles order by role_description asc" );
	$Ui->Send();
?>
<select  name=<?php echo $RoleCombo_Name ?> class="form-control chosen-select required" id="user_role" >
	<?php
	echo "<option value='-1'>انتخاب کنید...</option>";
	echo "<option value='0'>لیست تمام اعضا</option>";
	for($ItemNo=0;$ItemNo<count($Ui->BoObj->ResultList);$ItemNo++){	
		echo "<option value='".$Ui->BoObj->ResultList[$ItemNo]->role_id."'>".$Ui->BoObj->ResultList[$ItemNo]->role_description."</option>";
	}
	?>
</select>