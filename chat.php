<?php
	include("/parts/crperm.php");
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <?php
     include("/parts/head.php");
	?>
    <title>Chatroom | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	
	<script src="assets/js/jquery-3.3.1.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="assets/css/chat.css" />

  </head>

  <body>

    <?php
     include("header.php");
	?>
	
<br><br><br>
	
<div id="chat">
	<div id="wrapper">
		<div id="menu">
			<h4>Vítejte, <b> <?php echo $_SESSION['username']; ?>. </b></h4>
		</div>
     
		<div id="chat_wrapper">
			<div id="chatbox">
			
			</div>
			
			<form method="POST" id="messform">
				<input type="text" name="message" autocomplete="off" id="usermsg" class="form-control"></input>
			</form>
			
		</div>
	</div>
</div>
		
	<div id="r">
		<div class="container">
			<div class="row centered">
				<div class="col-lg-8 col-lg-offset-2">
					<?php
						include("/parts/crfoot.php");
					?>
				</div>
			</div>
		</div>
	</div>
		
		<?php
			include("footer.php");
		?>
		
		<script>
			
			setInterval(function(){
				LoadChat();
			}, 1000);
			
			function LoadChat(){
				$.post('messages.php?action=getMessages', function(response){
					
					var scrollpos = $('#chatbox').scrollTop();
					var scrollpos = parseInt(scrollpos) + 320;
					var scrollHeight = $('#chatbox').prop('scrollHeight');
					
					$('#chatbox').html(response);
					
					if( scrollpos < scrollHeight ){
						
					}else{
					$('#chatbox').scrollTop( $('#chatbox').prop('scrollHeight') ); }
				});
			}
		
			$('.input').keyup(function(e){
				if(e.which == 13){
					$('form').submit();
				}
			});
			
			$('form').submit(function(){
				
				var message = $(document.getElementById('usermsg')).val();
				$.post('messages.php?action=sendMessage&message='+message, function(response){
					
					if( response ==1 ){
						LoadChat();
						document.getElementById('messform').reset();
					}
					
				});
				return false;
				
			});
		
		</script>
	
  </body>
</html>