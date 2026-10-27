// JavaScript Document
$(document).ready(function(e) {	
	$(".tblview [data-type]:not(a)").click(function(e) {
		$(".formview").css("display","block");
		$("[data-type='Submit']").removeAttr("class");
		$('[data-toggle="tooltip"]').tooltip("hide");
		ClearForm()				
    });			  
    $("[data-type='Add']").click(function(e) {
        EnabledForm()				
		$('[name="BoType"]').val(0)				
		$("[data-type='Submit']").css("visibility","visible");
		$("[data-type='Submit']").html("ارسال <span class='far fa-paper-plane'></span>")
		$("[data-type='Submit']").attr("class","btn btn-primary");				
    });
	$("[data-type='View']").click(function(e) {
        FillField($(this));
		DisabledForm()
		$('[name="BoType"]').val(-1)
		$("[data-type='Submit']").css("visibility","hidden")
		$("[data-type='Reply']").css("visibility","visible")
    });
	$("[data-type='UpdateOneRow']").click(function(e) {
        FillField($(this));
		DisabledForm()				 
		$('[name="BoType"]').val(5)
		$("[data-type='Submit']").css("visibility","hidden");
		$("[data-type='Reply']").css("visibility","visible");				
		$(this).closest("tr.unread").removeClass("unread");
		$("[data-type='Reply']").click(function(e) {
			$(".formview form").submit();
             //OpenReply();	
			setTimeout(function(){OpenReply();}, 100); 
		});
		$("[data-type='Cancel']").click(function(e) {
			$(".formview form").submit(); 
			$(".confirmmodal").css("display","none");
            $(".formview").css("display","none");								    
			$(".tblview").css("display","block");               				
        });				 
		$(".formview .close").click(function(e) {
			$(".formview form").submit()
            $(".formview").css("display","none");
			$(".tblview").css("display","block");                
        });
    });
	$("[data-type='Edit']").click(function(e) {
        FillField($(this));
		EnabledForm()
		$('[name="BoType"]').val(1)
		$("[data-type='Submit']").css("visibility","visible")			
		$("[data-type='Submit']").html("ویرایش <span class='fas fa-edit'></span>")
		$("[data-type='Submit']").attr("class","btn btn-warning ");
		$("[data-type='Submit']").click(function(e) { 				
			$(".formview form").submit();					  				   					
		});				                 
	});	          						
	$("[data-type='DeleteLogReciever']").click(function(e) {
        FillField($(this));
		DisabledForm()
		$('[name="BoType"]').val(6)
		$("[data-type='Submit']").css("visibility","visible")
		$("[data-type='Reply']").css("visibility","hidden")				
		//$(".confirmmodal h5 ").css("color","#ffd633").css("border-bottom","2px solid #00b3b3");
		//$(".confirmmodal .confirmbody ").css("color","#00b3b3");
		//$(".confirmmodal div .confirmfooter").css("borderColor","#00b3b3");
		$(".confirmmodal div .confirmfooter").mouseover(function() {
            $(this).css("background-color","#00b3b3");
        }).mouseout(function() {
            $(this).css("background-color","transparent");
        });				
		$("[data-type='Submit']").html("<span class='fas fa-trash-alt '></span>");
		$("[data-type='Submit']").attr("class","btn btn-danger ");
		$("[data-type='Submit']").click(function(e) {				
			$(".confirmmodal").css("display","block");
			$(".tblview").addClass("disabletblview");
			$(".formview").addClass("disabletblview");
			$(".confirmmodal [data-type='Confirm']").click(function(e){
				$(".formview form").submit();
				$(".confirmmodal").css("display","none");
				$(".formview").css("display","none");
				$(".tblview").css("display","block");
				$(".tblview").removeClass("disabletblview");
				$(".formview").removeClass("disabletblview");
			});				                  
		});					
    });
	$("[data-type='DeleteLogSender']").click(function(e) {
        FillField($(this));
		DisabledForm()
		$('[name="BoType"]').val(7)
		$("[data-type='Submit']").css("visibility","visible")
		//$(".confirmmodal h5 ").css("color","#ffd633").css("border-bottom","2px solid #00b3b3");
		//$(".confirmmodal .confirmbody ").css("color","#00b3b3");
		//$(".confirmmodal div .confirmfooter").css("borderColor","#00b3b3");
		$(".confirmmodal div .confirmfooter").mouseover(function() {
            $(this).css("background-color","#00b3b3");
        }).mouseout(function() {
            $(this).css("background-color","transparent");
        });				
		$("[data-type='Submit']").html("<span class='fas fa-trash-alt '></span>");
		$("[data-type='Submit']").attr("class","btn btn-danger ");
		$("[data-type='Submit']").click(function(e) {				
			$(".confirmmodal").css("display","block");
			$(".tblview").addClass("disabletblview");
			$(".formview").addClass("disabletblview");
			$(".confirmmodal [data-type='Confirm']").click(function(e){
				$(".formview form").submit();
				$(".confirmmodal").css("display","none");
				$(".formview").css("display","none");
				$(".tblview").css("display","block");
				$(".tblview").removeClass("disabletblview");
				$(".formview").removeClass("disabletblview");
			});				                  
		});
    });	
	$("[data-type='Submit']").click(function(e) {				                 
		//$(".formview form").submit()                 			  
    });
	$("[data-type='Cancel']").click(function(e) {
		$(".confirmmodal").css("display","none");
        $(".formview").css("display","none");				
		$(".attachview").css("display","none");
		$(".tblview").css("display","block");				
    });
	$("[data-type='CancelConfirm']").click(function(e) {				
		$(".confirmmodal").css("display","none");
		$(".formview").css("display","none");				
		$(".attachview").css("display","none");
		$(".tblview").css("display","block");
		$(".tblview").removeClass("disabletblview");
		$(".formview").removeClass("disabletblview");				
	});	
	$(".formview .close").click(function(e) {
        $(".formview").css("display","none");
		$(".attachview").css("display","none");
		$(".tblview").css("display","block");				
    });
	function FillField(Items){
		CurrentRow=$(Items).parent().parent();
		$(CurrentRow).children("td[data-name]").each(function(index, element) {
			$("input[name='"+$(element).attr("data-name")+"']").val($(element).text())
			$("textarea[name='"+$(element).attr("data-name")+"']").val($(element).text())
			$("select[name='"+$(element).attr("data-name")+"'] option[value='"+$(element).text()+"']").attr("selected","selected")                   
        });
		$("[name='BoKeyValue']").val($(CurrentRow).children("td[data-key]").attr("data-key"))
	}
	function DisabledForm(){
		$(".formview input").attr("readonly","readonly");
		$(".formview select").attr("readonly","readonly");
		$(".formview textarea").attr("readonly","readonly");							
	}
	function EnabledForm(){
		$(".formview input").removeAttr("readonly");
		$(".formview select").removeAttr("readonly");
		$(".formview textarea").removeAttr("readonly");
	}
	function ClearForm(){
		$(".formview input:not([type='hidden'])").val("");
		$(".formview textarea:not([type='hidden'])").val("");
		$("select option[selected]").removeAttr("selected");
		$("select option[value='-1']").attr("selected","selected")
	}
	$('[data-toggle="tooltip"]').tooltip();   			
});