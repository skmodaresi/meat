<?php
session_start();
?>
<!doctype html>
<html lang="fa" >
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>پیام های دریافتی</title>
<link rel="stylesheet" type="text/css" href="Assets/Css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="Assets/Css/comments.css">
<link rel="stylesheet" type="text/css" href="Assets/fontawesome/css/all.min.css">
<style></style>
</head>
<body>
<?php
//$Path = realpath(dirname(__FILE__));
//$Path=$_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['PHP_SELF'])[1].'/'.explode('/',$_SERVER['PHP_SELF'])[2];
$Path="../Message";
include_once $Path."/Inc/GeneralClass/Ui.php";
if (isset($_SESSION['mt_user_id'])&&isset($_SESSION['mt_userName'])){	 	
	$Ui= new Ui("comments",$Path);
	$Ui->CreateBo();	
	if(isset($_GET['no_of_records_per_page'])) {
		$no_of_records_per_page =$_GET['no_of_records_per_page'];				 
	}else{				   
		$no_of_records_per_page = 8;					
	} 
	if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    }else {
        $pageno = 1;
    }	
    if(isset($_POST["BoType"]) && $_POST["BoType"]!=-1){		
        $UiNew= new Ui("compose_comment",$Path);
	    $UiNew->CreateBo();
	    $UiNew->FillBo($_POST);
	    $Result=$UiNew->Send();	  
	    if($Result==1){			
		    if (isset($_GET['pageno'])) {
		        header("location:".$_SERVER['PHP_SELF']."? pageno=". $pageno."&no_of_records_per_page=".  $no_of_records_per_page);
		    }else {
				header("location:".$_SERVER['PHP_SELF']."? pageno=1"."&no_of_records_per_page=". $no_of_records_per_page);
		    }
	    }else{echo "ثبت نشد";}
    }else{	
		$Ui->SetQuery("SELECT comment_id,comment_text,comment_type,user_id_sender,user_id_reciever,
			comment_date_send_shamsi,comment_date_send_miladi,comment_time_send,comment_read,
			(SELECT CONCAT(first_name,' ',last_name)FROM users WHERE `comments`.user_id_sender=`users`.user_id )as user_sender,
			(SELECT CONCAT(first_name,' ',last_name)FROM users WHERE `comments`.user_id_reciever=`users`.user_id )as user_reciever 
			FROM `comments` where user_id_reciever =".$_SESSION['mt_user_id']." AND delete_reciever=0");
		$Ui->Send();
		$countofrow=$Ui->BoObj->RecordCount;	
		if($countofrow>0){		   
			$offset = ($pageno-1) * $no_of_records_per_page; 
		    $total_pages = ceil($countofrow / $no_of_records_per_page);			
			$Ui= new Ui("comments",$Path);
	        $Ui->CreateBo();
		    $Ui->SetQuery ("SELECT comment_id,comment_text,comment_type,user_id_sender,user_id_reciever,
				comment_date_send_shamsi,comment_date_send_miladi,comment_time_send,comment_read,
				(SELECT CONCAT(first_name,' ',last_name)FROM users WHERE `comments`.user_id_sender=`users`.user_id )as user_sender,
				(SELECT CONCAT(first_name,' ',last_name)FROM users WHERE `comments`.user_id_reciever=`users`.user_id )as user_reciever 
				FROM `comments` where user_id_reciever =".$_SESSION['mt_user_id']." AND delete_reciever=0 order by comment_id DESC  LIMIT $offset, $no_of_records_per_page");
			$Ui->Send();
		}else{
			$countofrow=0;
			$offset=0;
			$pageno=1;
			$total_pages=1;
			$no_of_records_per_page = 0;
		}		
    }
}else{header("location:../mainpage.php");}   
?>
<div class="container col-11 col-sm-10 col-md-10 col-lg-10 pt-2">
    <section class="row"> 
        <div class="row col-12 head d-flex justify-content-start m-0 p-2">
			<div class="col-12 col-sm-11">	
                <p><i class="far fa-user"></i>
					<?php if(isset($_SESSION['mt_user_id'])){echo $_SESSION['mt_first_name'].' '.$_SESSION['mt_last_name'] ;} ?> عزیز، خوش آمدید.
		        </p>
			</div>
			<div class="col-12 col-sm-1 text-left">	
				<a href="../index.php" data-toggle='tooltip' data-placement='bottom' title='خانه'><i class="fas fa-home"></i>
				</a>
			</div>
        </div>  
    </section> 
    <!--***********************enf of section*************************-->
    <article class="row">                           
		<nav class="navbar navbar-expand  col-12 justify-content-start rightcontent">
		    <ul class="navbar-nav col-11">
			    <li class="nav-item">
				    <a class="nav-link active" href="CommentInbox_Frm.php"><i class="fas fa-cloud-download-alt"></i> دریافتی </a>
			    </li>
			    <li class="nav-item">
			        <a class="nav-link" href="CommentSend_Frm.php"><i class="fas fa-cloud-upload-alt"></i> ارسالی </a>
			    </li>
			    <li class="nav-item">
			        <a class="nav-link" href="ComposeComment_Frm.php"><i class="fas fa-marker"></i> جدید </a>
			    </li>
		    </ul>
		</nav>	 
    </article>   
    <article class="row justify-content-center">
        <div class="tblview container-fluid">
            <div class="table-responsive">
                <table class="table table-sm">
	                <tr class="nameview">
						<td colspan='6'>						
							<div class="col-12 col-sm-6 float-right text-right"><i class="fas fa-cloud-download-alt"></i> پیام های دریافت شده</div>
							<div class="col-12 col-sm-6 float-right text-right text-sm-center"><?php echo '[صفحه:&nbsp '.$pageno.' از '. $total_pages.']';?></div>
						</td>					
					</tr>
    	            <tr>
        	            <th></th>
						<th>نوع پیام</th>
                        <th>نام فرستنده</th>			
			            <th>تاریخ دریافت</th>
			            <th>مشاهده</th>
                        <th>حذف</th>
                    </tr>
					<?php
					if($Ui->BoObj->ResultList!="هیچ موردی یافت نشد"){
						for($ItemNo=0;$ItemNo<count($Ui->BoObj->ResultList);$ItemNo++){
							$Radif=$ItemNo+1;
							/*****************if message unread*****************/
							if(($Ui->BoObj->ResultList[$ItemNo]->comment_read) == 0){
								echo"<tr class='unread'>";									
									echo "<td data-Key='".$Ui->BoObj->ResultList[$ItemNo]->comment_id."'>"."<i class='fas fa-level-down-alt'></i> <i class='fas fa-envelope'></i></td>";
									echo "<td data-name='comment_id' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_id . "</td>";
									echo "<td data-name='user_id_sender' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->user_id_sender."</td>";
									echo "<td data-name='comment_type'>".$Ui->BoObj->ResultList[$ItemNo]->comment_type."</td>";				    
									echo "<td data-name='user_sender'>".$Ui->BoObj->ResultList[$ItemNo]->user_sender."</td>";
									echo "<td data-name='user_reciever' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->user_reciever."</td>";				
									echo "<td data-Name='comment_text' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_text."</td>";								
									echo "<td data-Name='comment_date_send_shamsi'>".$Ui->BoObj->ResultList[$ItemNo]->comment_date_send_shamsi."</td>";
									echo "<td data-Name='comment_date_send_miladi' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_date_send_miladi."</td>";
									echo "<td data-Name='comment_time_send' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_time_send."</td>";
									echo "<td data-Name='comment_read' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_read."</td>";								
									echo "<td><button class='btn btn-success btn-sm' data-type='UpdateOneRow' data-toggle='tooltip' data-placement='top' title='مشاهده'><i class='fas fa-eye'></i></button></td>";
									// echo "<td><a href='ComposeComment_Frm.php?user_id_reciever=".$Ui->BoObj->ResultList[$ItemNo]->user_id_sender."&user_reciever=". $Ui->BoObj->ResultList[$ItemNo]-> user_sender 
										//."&comment_type=".$Ui->BoObj->ResultList[$ItemNo]-> comment_type ."&no_of_records_per_page=". $no_of_records_per_page."&pageno=" .$pageno."'
										//class='btn btn-warning' data-type='Reply' data-toggle='tooltip' data-placement='top' title='پاسخ'><span class='fas fa-reply'></span></a></td>";
									echo"<td><button class='btn btn-danger btn-sm' data-type='DeleteLogReciever' data-toggle='tooltip' data-placement='top' title='حذف'><span class='fas fa-trash-alt '></span> </button></td>";
								echo "</tr>";
							}
							/*****************if the message is read*****************/
							elseif(($Ui->BoObj->ResultList[$ItemNo]->comment_read) == 1){
								echo "<tr>";								
									echo "<td data-Key='".$Ui->BoObj->ResultList[$ItemNo]->comment_id."'>"."<i class='fas fa-level-down-alt'></i> <i class='far fa-envelope-open'></i></td>";
									echo "<td data-name='comment_id' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_id . "</td>";				  					
									echo "<td data-name='user_id_sender' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->user_id_sender."</td>";
									echo "<td data-name='comment_type'>".$Ui->BoObj->ResultList[$ItemNo]->comment_type."</td>";
									echo "<td data-name='user_sender'>".$Ui->BoObj->ResultList[$ItemNo]->user_sender."</td>";
									echo "<td data-name='user_reciever' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->user_reciever."</td>";				
									echo "<td data-Name='comment_text' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_text."</td>";								
									echo "<td data-Name='comment_date_send_shamsi'>".$Ui->BoObj->ResultList[$ItemNo]->comment_date_send_shamsi."</td>";
									echo "<td data-Name='comment_date_send_miladi' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_date_send_miladi."</td>";
									echo "<td data-Name='comment_time_send' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_time_send."</td>";
									echo "<td data-Name='comment_read' style='display:none'>".$Ui->BoObj->ResultList[$ItemNo]->comment_read."</td>";
									echo "<td><button class='btn btn-success btn-sm' data-type='View'data-toggle='tooltip' data-placement='top' title='مشاهده'><i class='fas fa-eye'></i></button></td>";
									//echo "<td><a href='ComposeComment_Frm.php?user_id_reciever=".$Ui->BoObj->ResultList[$ItemNo]->user_id_sender."&user_reciever=". $Ui->BoObj->ResultList[$ItemNo]-> user_sender 
										//."&comment_type=".$Ui->BoObj->ResultList[$ItemNo]-> comment_type ."&no_of_records_per_page=". $no_of_records_per_page."&pageno=" .$pageno."' 
										//class='btn btn-warning' data-type='Reply'  data-toggle='tooltip' data-placement='top' title='پاسخ'><span class='fas fa-reply'></span></a></td>";
									echo "<td><button class='btn btn-danger btn-sm' data-type='DeleteLogReciever' data-toggle='tooltip' data-placement='top' title='حذف'><span class='fas fa-trash-alt '></span> </button></td>";
								echo "</tr>";
							}
						}
					}else{
						echo "<tr>";
							echo "<td colspan='6'>";
							echo $Ui->BoObj->ResultList;
							echo "</td>";
						echo "</tr>";
					}
					?>
					<tr><td colspan="6" class="p-0">
						<div class="row col-12 m-0 my-2 d-flex justify-content-between">
							<div class="col-11 col-sm-4 col-md-3 float-right d-flex justify-content-center">
								<ul class="pagination">
									<li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>" data-toggle='tooltip' data-placement='right' title='صفحه اول'>
										<a class="page-link" href="?pageno=1 <?php echo "&no_of_records_per_page=" . $no_of_records_per_page?>"><i class="fas fa-angle-double-right"></i></a>
									</li>
									<li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>" data-toggle='tooltip' data-placement='right' title='صفحه قبلی'>
										<a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1)."&no_of_records_per_page=" . $no_of_records_per_page; } ?>">
									<i class="fas fa-angle-right"></i></a></li>
									<li class="page-item" >
										<a class="page-link" href="#"><?php echo $pageno; ?></a>
									</li>
									<li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" data-toggle='tooltip' data-placement='left' title='صفحه بعدی'>
										<a class="page-link" href=" <?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1)."&no_of_records_per_page=" . $no_of_records_per_page; } ?>"><i class="fas fa-angle-left"></i></a>
									</li>
									<li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" data-toggle='tooltip' data-placement='left' title='صفحه آخر'>
										<a class="page-link" href=" ?pageno= <?php echo $total_pages ."&no_of_records_per_page=" . $no_of_records_per_page ?>"><i class="fas fa-angle-double-left"></i></a>
									</li>
								</ul> 
							</div>	
							<div class="RowPerPage col-11 col-sm-4 col-md-3 float-right d-flex justify-content-center">                
								<input type="text" class="form-control text-center" name="RowPerPage" id="RowPerPage" value="<?php $no_of_records_per_page ?>"  placeholder="تعداد ردیف : <?php echo $no_of_records_per_page ?>">	
							</div>	
		                    <div class='RowPerPage  col-11 col-sm-4 col-md-3 float-right d-flex justify-content-center'> 		    
                                <input type="text" class="form-control text-center" disabled value="<?php echo'تعداد کل : ' . $countofrow ?> ">
                            </div>           		
		                </div>
		            </td></tr>		
                </table>
			</div> 
		</div>
		<!---------end of tblview--------->		
        <div class="formview container col-11 col-sm-10">
	        <div class="modalheader d-flex justify-content-between">
		        <p><i class="fas fa-level-down-alt"></i> پیام دریافتی </p>
	            <span class="close"><i class="far fa-times-circle"></i></span>		   
            </div>
		    <div class="modalbody">
        	    <form method="post" class="form" name="form">			
			        <input type="hidden" name="comment_id">
			        <input type="hidden" class="form-control" name="user_reciever">
					<input type="hidden" class="form-control" name="user_id_sender">
			        <div class="row d-flex justify-content-start m-0">			
			            <div class="form-group col-12 col-md-6 col-lg-3">
                	        <label>نام فرستنده:</label>
							<input type="text" class="form-control" name="user_sender">
						</div>
						<div class="form-group col-12 col-md-6 col-lg-3">
							<label>نوع پیام:</label>
							<input type="text" class="form-control" name="comment_type">
						</div>
						<div class="form-group col-12 col-md-6 col-lg-3">
							<label>تاریخ:</label>
							<input type="text" class="form-control" name="comment_date_send_shamsi">
						</div>
	                    <div class="form-group col-12 col-md-6 col-lg-3">
							<label>ساعت:</label>
							<input type="text" class="form-control" name="comment_time_send">
						</div>					
					</div>
					<hr>
					<div class="row d-flex justify-content-start m-0">
						<div class="form-group col-12">
							<label>متن پیام:</label>
							<textarea class="form-control" name="comment_text" rows="6"></textarea>
						</div>   			                           
					</div>                   
					<input type="hidden" name="BoType" value="-1">
					<input type="hidden" name="BoKeyValue" value="">
					<div class=" d-flex justify-content-center modalfooter">
						<!--<?php 
							//echo '<a  class="btn btn-warning" data-type="Reply"  data-toggle="tooltip" data-placement="top" title="پاسخ"  
							//onclick="OpenReply(\'ComposeComment_Frm.php?no_of_records_per_page='. $no_of_records_per_page. '&pageno=' . $pageno . 
							//'&user_id_reciever=\'+ document.form.user_id_sender.value +\'&user_reciever=\' + document.form.user_sender.value +\'&comment_type=\' + document.form.comment_type.value+\'\')" >
							//<span class="fas fa-reply"></span></a>';
						?>-->
						<?php 
						echo '<a class="btn btn-warning" data-type="Reply" data-toggle="tooltip" data-placement="top" title="پاسخ" onclick="OpenReply()">
							<span class="fas fa-reply"></span></a>';
						?>
						<a class="btn btn-danger" data-type='Submit' id='Submit' data-toggle='tooltip' data-placement='top' title='حذف'></a>
						<a class="btn btn-primary" data-type='Cancel'data-toggle='tooltip' data-placement='top' title='بازگشت'><i class="fas fa-undo-alt"></i></a>
					</div>
				</form>
            </div><!-------end of modalbodey----->
	    </div><!-------end of formview----->	  
	   <!--*********************confirmmodal*************************-->
		<div class="confirmmodal col-9 col-sm-5 col-md-3">	   
			<h5><i class="fas fa-exclamation-triangle"></i> توجه</h5>
			<p>حذف شود؟</p>
			<div class="confirmbody"><i class="far fa-question-circle fa-5x"></i>
			</div>	    
			<div class="row confirmfooter d-flex justify-content-center">
				<button class="btn btn-info RowPerPage" data-type="Confirm">&nbspبله&nbsp </button>
				<button class="btn btn-info RowPerPage" data-type="CancelConfirm">خیر</button>
			</div>
		</div>			
	</article>  
</div>	<!-------end of container-fluid------->
<script src="Assets/JS/jquery-3.2.1.min.js"></script>
<script src="Assets/JS/bootstrap.bundle.min.js"></script>
<script src="Assets/JS/comments.js"></script>			
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();	
		$('#RowPerPage').change(function() {
			window.location = "CommentInbox_Frm.php?no_of_records_per_page="+ $(this).val() ;
		});	
	});
</script>
<script>
	function OpenReply() {
		var no_of_records_per_page = "<?php echo $no_of_records_per_page ?>";
		var pageno = "<?php echo $pageno ?>";
		url= 'ComposeComment_Frm.php?no_of_records_per_page='+ no_of_records_per_page + '&pageno='+ pageno  + '&user_id_reciever=' + document.form.user_id_sender.value +'&user_reciever=' + document.form.user_sender.value +'&comment_type=' + document.form.comment_type.value;		
		window.open(url,'_self');
	}
</script>		
</body>
</html>