<?php
session_start();
?>
<!doctype html>
<html lang="fa" >
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>نوشتن پیام</title>
<link rel="stylesheet" type="text/css" href="Assets/Css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="Assets/Css/comments.css">
<link rel="stylesheet" type="text/css" href="Assets/Css/chosen.css">
<link rel="stylesheet" type="text/css" href="Assets/fontawesome/css/all.min.css">
<style>
.formview{
top:110px;border-radius:0px;
box-shadow: 0 0px 0px 0 rgba(0, 0, 0, 0), 0 0px 0px 0 rgba(0, 0, 0, 0);
}
</style>
</head>
<body>
<?php
   // $Path=$_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['PHP_SELF'])[1];
	//$Path=$_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['PHP_SELF'])[1].'/'.explode('/',$_SERVER['PHP_SELF'])[2];
	$Path="../Message";
	include_once $Path."/Inc/GeneralClass/Ui.php";
	include_once $Path ."/Inc/Function/GeneralFnc.php";
	if (!isset($_SESSION['mt_user_id'])&& !isset($_SESSION['mt_userName'])){
		header("location:../mainpage.php");	
	}else{
		date_default_timezone_set('Iran');
		$logtime=date('H:i:s');//ساعت فعلی	
		$DateE=date("Y.m.d");	 
		$d=substr($DateE,8,2);
		$m=substr($DateE,5,2);
		$y=substr($DateE,0,4);
		$DateF=gregorian_to_jalali($y,$m,$d);
		$yy=$DateF[0];
		$mm=$DateF[1];
		$dd=$DateF[2];
		$yymmdd=$yy.$mm.$dd;	 
		$today=AsLDate($yymmdd);//تاریخ فعلی شمسی
     	
		$Ui= new Ui("compose_comment",$Path);
		$Ui->CreateBo();	
		if(isset($_POST["comment_text"]) ){	 
			if(isset($_GET['user_id_reciever'])){
				$Ui->FillBo($_POST);
				$Ui->SetQueryinsert ("insert into comments (comment_text,comment_type,user_id_sender,user_id_reciever,comment_date_send_shamsi,comment_date_send_miladi,comment_time_send) values (N'".$_POST['comment_text']."',N'".$_POST['comment_type']."',N'".$_POST['user_id_sender']."',N'".$_GET['user_id_reciever']."',N'".$_POST['comment_date_send_shamsi']."',N'".$_POST['comment_date_send_miladi']."',N'".$_POST['comment_time_send']."')");		    			 
				//var_dump($Ui->SetQueryinsert);
				$Result=$Ui->Send();
			}else{
				$user_id_recievers=$_POST['user_id_reciever'];			
				foreach($user_id_recievers  as $user_id_reciever) {
					$user_id_reciever=(int)$user_id_reciever;
					$Ui->FillBo($_POST);
					$Ui->SetQueryinsert ("insert into comments (comment_text,comment_type,user_id_sender,user_id_reciever,comment_date_send_shamsi,comment_date_send_miladi,comment_time_send) values (N'".$_POST['comment_text']."',N'".$_POST['comment_type']."',N'".$_POST['user_id_sender']."',N'".$user_id_reciever."',N'".$_POST['comment_date_send_shamsi']."',N'".$_POST['comment_date_send_miladi']."',N'".$_POST['comment_time_send']."')");		    			 
					$Result=$Ui->Send();	
				}	
			}	  	   	  
			if($Result==1){	                 		
				if(isset($_GET['no_of_records_per_page'])) {
					$no_of_records_per_page=$_GET['no_of_records_per_page'];	
					$pageno=$_GET['pageno'];
					header("location:CommentInbox_Frm.php?no_of_records_per_page=".$no_of_records_per_page."&pageno=" .$pageno);		   
				}else{
					header("location:CommentInbox_Frm.php");  
				}		  		
			}else{echo "ثبت نشد";}
		}
	}	
?> 
<!-- <article class="row  justify-content-center">-->
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
    <article class="row">                           
		<nav class="navbar navbar-expand  col-12 justify-content-start rightcontent">
		    <ul class="navbar-nav col-11">
			    <li class="nav-item">
				    <a class="nav-link" href="CommentInbox_Frm.php"><i class="fas fa-cloud-download-alt"></i> دریافتی </a>
			    </li>
			    <li class="nav-item">
			        <a class="nav-link " href="CommentSend_Frm.php"><i class="fas fa-cloud-upload-alt"></i> ارسالی </a>
			    </li>
			    <li class="nav-item">
			        <a class="nav-link active" href="ComposeComment_Frm.php"><i class="fas fa-marker"></i> جدید </a>
			    </li>
		    </ul>
		</nav>        
	</article>
	<article class="row justify-content-center">
		<div class="formview continer col-12 pb-0">
			<div class="modalheader d-flex justify-content-between" >
				<p><i class="fas fa-marker"></i> نوشتن پیام جدید </p>
				<a class="close" href="<?php
					if(isset($_GET['no_of_records_per_page'])) {
		                $no_of_records_per_page=$_GET['no_of_records_per_page'];	
		                $pageno=$_GET['pageno'];
                        echo("CommentInbox_Frm.php?no_of_records_per_page=".$no_of_records_per_page."&pageno=" .$pageno);		   
					}else{
			            echo("CommentInbox_Frm.php");  
		            }?>"><i class="far fa-times-circle"></i>
				</a>
			</div>
			<div class="modalbody">				
				<div class="d-flex justify-content-center">
					<?php if(!isset($_GET['user_id_reciever'])){
							echo'<p class="font-weight-normal text-danger my-0">لطفا نوع پیام، نقش گیرنده، گیرنده و متن پیام را وارد نمائید.</p> ';
						}else{
							echo'<p class="font-weight-normal text-danger my-0">لطفا متن پیام را وارد نمائید.</p> ';	
						}
					?>
				</div>
				<form method="post" class="form">
					<input type="hidden" name="user_id_sender" value="<?php echo $_SESSION['mt_user_id']; ?>">
					<input type="hidden" name="comment_date_send_shamsi" value="<?php echo $today?>">
					<input type="hidden" name="comment_date_send_miladi" value="<?php echo $DateE?>">
					<input type="hidden" name="comment_time_send" value="<?php echo $logtime?>">
					<div class="row col-12 d-flex justify-content-start m-0">
						<div class=" form-group col-8 col-md-4 col-lg-3">
							<label>نوع پیام:</label>						
							<select class="form-control chosen-select" name="comment_type" data-placeholder="نوع پیام را انتخاب کنید." >	
							<?php if(isset($_GET['comment_type'])){echo "<option value='".$_GET['comment_type']."'>".$_GET['comment_type']."</option>";}
								else{echo"								
									<option value='عادی'> عادی </option>
									<option value='مهم'> مهم</option>
									<option value='فوری'> فوری</option>
									<option value='اطلاع رسانی'> اطلاع رسانی</option>
								";} ?>
							</select>
						</div>
						<?php if(!isset($_GET['user_id_reciever'])){
							echo '<div class="form-group col-8 col-md-4 col-lg-3">
								<label>نقش گیرنده:</label>';												
								$RoleCombo_Name="role_id";
								include "Inc/Module/RoleCombo.php";
							echo '</div>';}
						?>
						<div class=" form-group col-8 col-md-4 col-lg-3">
							<label> گیرنده:</label>
                            <?php
					        if(isset($_GET['user_id_reciever'])){
	                            $user_id_reciever=$_GET['user_id_reciever'];
					            $user_reciever=$_GET['user_reciever'];
					            echo "<select class='form-control chosen-select' name='user_id_reciever[]'><option value='".$user_id_reciever."'>".$user_reciever ."</option></select>";
	               	        }else{
								//$UserCombo_Name="user_id_reciever[]";								
								//include "Inc/Module/UserCombo.php";
								echo'<select class="form-control chosen-select" required name="user_id_reciever[]" id="user_id_reciever" multiple data-placeholder="پس از انتخاب نقش، اینجا را کلیک کنید.">';
								echo'</select>';						   
					        }?>
						</div>
					</div>
					<hr>
					<div class="row d-flex justify-content-start m-0">
						<div class="form-group col-12">
							<label>متن پیام:</label>
							<textarea class="form-control mt-2" required name="comment_text" rows="6"></textarea>
						</div>           	            
					</div>               
					<input type="hidden" name="BoType" value="0">
					<input type="hidden" name="BoKeyValue" value="">
					<div class="col-10 text-danger font-weight-normal" id="message">
					</div>					
					<div class=" d-flex justify-content-center modalfooter">
						<a class="btn btn-warning" data-type='Add' id='Submit' >ایجاد</a>
						<a class="btn btn-primary" data-type='Cancel'href="<?php
     						if(isset($_GET['no_of_records_per_page'])) {
		                        $no_of_records_per_page=$_GET['no_of_records_per_page'];	
		                        $pageno=$_GET['pageno'];
                                echo("CommentInbox_Frm.php?no_of_records_per_page=".$no_of_records_per_page."&pageno=" .$pageno);		   
		                    }else{
			                    echo("CommentInbox_Frm.php");  
		                    }?>">انصراف <i class="fas fa-undo-alt"></i>
						</a>
					</div>
					<?php 
						if(!isset($_GET['user_id_reciever'])&&($_SESSION['mt_role']==16)){						   
						echo'<div class="d-flex justify-content-center">
							<button class="btn btn-warning" id="select_all" name="select_all" data-toggle="tooltip" data-placement="left" title="کاربر گرامی در صورت تمایل برای ارسال پیام به تمامی  کاربران یک نقش، کافیست نقش مورد نظر را انتخاب نمائید." value="Select All" > ارسال پیام  به  تمام  کاربران</button>
						</div>';
						}	
					?>
				</form>
			</div><!------end of modalbody---->  
		</div><!------end formview---->  
        <!--*********************confirmmodal*************************-->
		<div class="confirmmodal col-9 col-sm-5 col-md-3">	   	         		    
			<div class="confirmbody"><i class="far fa-smile fa-5x"></i>			
			</div>	
			<div class="d-flex justify-content-center align-content-center">
				<p>پیام شما با موفقیت ارسال شد.</p>
			</div>	        
		</div>
	</article> 
</div><!------end of formview---->	 
<script src="Assets/JS/jquery-3.2.1.min.js"></script>
<script src="Assets/JS/bootstrap.bundle.min.js"></script>
<script src="Assets/JS/comments.js"></script>
<script src="Assets/JS/chosen.jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".formview").css("display","block");       	
	$('[data-toggle="tooltip"]').tooltip();
	$("[data-type='Add']").html("ارسال <span class='far fa-paper-plane'></span>")	
		
	$(".chosen-select").chosen();
	//resize width of chosen dinamically
	resizeChosen();
	jQuery(window).on('resize', resizeChosen);
	function resizeChosen() {
		$(".chosen-container").each(function(){
			$(this).attr('style', 'width: 100%');
		});          
	}
	//end	
	$("[name='role_id']").change(function(){
		var CodeRole = $(this).val()			
		var user_id = "<?php echo $_SESSION['mt_user_id']; ?>"
		if(CodeRole== 0){
			$.ajax({
				//url: "Inc/Module/AllUserCombo.php?user_id=" + user_id , 
				url: "AllUserCombo.php?user_id=" + user_id ,
				success: function(result){							
					$("#user_id_reciever").html(result);
					$('#user_id_reciever').attr("data-placeholder","گیرنده یا گیرندگان را انتخاب نمائید.");
					$('#user_id_reciever').trigger("chosen:updated");
				}
			});	
		}
		else {
			$.ajax({
				//url: "Inc/Module/UserCombo.php?role_id="+CodeRole+"&user_id=" + user_id ,
				url: "UserCombo.php?role_id="+CodeRole+"&user_id=" + user_id , 
				success: function(result){							
					$("#user_id_reciever").html(result);
					$('#user_id_reciever').attr("data-placeholder","گیرنده یا گیرندگان را انتخاب نمائید.");
					$('#user_id_reciever').trigger("chosen:updated"); 
				}
			});
		}
	})
    // $("[name='user_id_reciever']").change(function(){
		//   user_id_reciever=$(this).val()
	//});

	$('#select_all').click(function(){
		//$('#user_id_reciever option').prop('selected', true);
		a = 1;
		b = 1; 	 
		if( $.trim( $('#user_role option:selected').val() ) == "-1" ){	
		    $("#message").html("لطفا نقش گیرنده را انتخاب نمائید."); 
		    a = 0;
		}	
		if( $.trim( $("[name='comment_text']").val() ) == '' ){
			$("#message").html("لطفا متن پیام را وارد نمائید.");	
			b = 0;
		}		
		if(  a == 1 && b==1  ) {
			//$('#user_id_reciever option').prop('selected', true);				
			$(".confirmmodal .confirmbody ").css("color","#00b300").css("margin-top","20px");
			$(".confirmmodal p ").css("margin-top","0px").css("color","#00b300");
			$(".confirmmodal").css("display","block");	
			setTimeout(function(){$(".confirmmodal").css("display","none");}, 1000);
			setTimeout(function(){ $('#user_id_reciever option').prop('selected', true);$(".formview form").submit(); }, 1000);
		}	
	});

	$("[data-type='Add']").click(function(e){
		x = 1;
		y = 1; 	
		if( $.trim( $("[name='user_id_reciever[]']").val() ) == '' ){	
		    $("#message").html("لطفا گیرنده را انتخاب نمائید."); 
		    x = 0;
		}
		if( $.trim( $("[name='comment_text']").val() ) == '' ){
			$("#message").html("لطفا متن پیام را وارد نمائید.");	
			y = 0;
		}		
		if( x == 1 && y==1  ) {
			$(".confirmmodal .confirmbody ").css("color","#00b300").css("margin-top","20px");
			$(".confirmmodal p ").css("margin-top","0px").css("color","#00b300");
			$(".confirmmodal").css("display","block");			
			setTimeout(function(){ $(".formview form").submit(); }, 1000);								
		}             
	});	
});
</script>	
</body>
</html>