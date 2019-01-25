<script src="assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
//jQuery Document
$(document).ready(function(){
	
 //If user submits the form
	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		var msgtype = $("#select").val();
		$.post("post.php", {text: clientmsg, type: msgtype});		
		$("#usermsg").val('');
		return false;
	});
});

//Load the file containing the chat log
	function loadLog(){		
		$.ajax({
			url: "log.html",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				//Autoscroll		
		  	},
		});
	}
	setInterval (loadLog, 1000);
	textBoxScroll();
</script>