<?php
	// User logged in
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}
	
	// User not spammer nor teacher
	if(($_SESSION['permission']) == "n" || ($_SESSION['permission']) == "t"){
		header("location: index.php");
		exit;
	}
	
	require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
    <?php
		// Set design
		include("parts/head.php");
		if (isset($_SESSION['design'])){
			echo "<link href='assets/css/bootstrap-". $_SESSION['design']. ".css' rel='stylesheet'>";
			echo "<link href='assets/css/chat-". $_SESSION['design']. ".css' rel='stylesheet'>
			<link href='assets/css/main-".$_SESSION['design'].".css' rel='stylesheet'>";
		}else{
			echo "<link href='assets/css/bootstrap-default.css' rel='stylesheet'>";
			echo "<link href='assets/css/chat-default.css' rel='stylesheet'>
			<link href='assets/css/main-default.css' rel='stylesheet'>";
		}
	?>
    <title>Chatroom | Výpisky</title>
	
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body class="s-body">
	<?php
		include("header.php");
	?>
	<div class="content">
		<div id="chat">
			<div id="wrapper">
				<div id="menu">
					<h4>Vítejte, <b> <?php echo $_SESSION['username']; ?>. </b></h4>
				</div>
			 
				<div id="chat_wrapper">
					<div id="chatbox">
					
					</div>

					<div class="form-inline">
						<form method="POST" id="messform">
							<div class="form-group">
								<input type="text" autofocus required name="message" autocomplete="off" id="usermsg" class="form-control"></input>
							</div>
							<input type="submit" value=">>>" class="btn btn-primary mb-2"></input>
						</form>
					
						<div id="drop" class="btn-group dropup septop">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Obrázek
								<span class="caret"></span>
							</button>
							<ul id="imgmenu" class="dropdown-menu dropdown-menu-center">
								<div class="centered">
									<li><span class="info">Je povoleno nahrávat obrázky do velikosti<br> 5 MB typu jpg, png a gif.<span><br><br></li>
									<li><input type="file" id="file" name="obrazky" required data-keepOpenOnClick class="btn btn-block btn-default"><br></li>
									<li><button id='process-file-button' class="btn btn-primary mb-2">Nahrát</button></li>
									<!--<div class="progress">
										<div class="progress-bar" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:0%">
											WIP
										</div>
									</div> -->
								</div>
							</ul>						
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div id="r">
			<div class="container">
				<div class="row centered">
					<div class="col-lg-8 col-lg-offset-2">
						<h4>PRAVIDLA</h4>
						<p>Na Výpiscích (jejichž součástí je i Chatroom) je zakázáno zveřejňovat obsah posměšný, urážlivý, pornografický, propagující drogy či obsah, který není v souladu s platnými zákony ČR. Taktéž je zakázáno prostřednictvím obrázků/odkazů sledovat aktivitu uživatelů, využívat je jako zdroj příjmů a taktéž je zakázáno spamovat. Při porušení tohoto pravidla může být uživatel bez varování vyhoštěn z Chatroom, čímž si znemožní i možnost nahrávat výpisky. Při opakovaném porušování pravidel může být uživateli znemožněn přístup na Výpisky.</p> 
						<div id="sound"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
			
	<?php
		include("footer.php");
	?>
			
	<script>
		var res = "";
		var mm = "";
		
		// Chat refresh
		LoadChat();
		setInterval(function(){
			LoadChat();
		}, 1000);
				
		// Load chat client
		function LoadChat(){
			$.post('messages.php?action=getMessages', function(response){
				if(res!=(response)){
					if (res!="" && res<response && mm==""){
						playSound('bam');
					}
					var scrollpos = $('#chatbox').scrollTop();
					var scrollpos = parseInt(scrollpos) + 320;
					var scrollHeight = $('#chatbox').prop('scrollHeight');
					$('#chatbox').html(response);
					res = (response);
					mm = "";
					if( scrollpos < scrollHeight ){	
					}else{
						$('#chatbox').scrollTop( $('#chatbox').prop('scrollHeight') ); 
					}
				}
			});
					
		}
				
		// Pressed enter > Send message
		$('.input').keyup(function(e){
			if(e.which == 13){
				$('form').submit();
			}
		});
		
		// Message submition
		$('form').submit(function(){
			var message = $(document.getElementById('usermsg')).val();
			
			// Special characters fix
			message = message.replace(/\+/g, "%2b");
			message = message.replace(/\&/g, "%26");
			message = message.replace(/\\/g, "%5c%5c%5c");

			$.post('messages.php?action=sendMessage&message='+message, function(response){
				if( response ==1 ){
					mm = "1";
					LoadChat();
					document.getElementById('messform').reset();
				}
			});
			return false;
		});
				
		// Image sending
		$('#process-file-button').on('click', function (f) {
			let files = new FormData(), // you can consider this as 'data bag'
				url = 'messages.php';
			files.append('fileName', $('#file')[0].files[0]); // append selected file to the bag named 'file'
			$.ajax({
				type: 'post',
				url: url,
				processData: false,
				contentType: false,
				data: files,
				success: function (response) {
					console.log(response);
				},
				error: function (err) {
					console.log(err);
				}
			});
			mm = "1";
			document.getElementById("file").value = "";
		});				
	</script>
	
	<script>
		// Image dropup not close
		$(function() {
			$("ul.dropdown-menu").on("click", "[data-keepOpenOnClick]", function(g) {
				g.stopPropagation();
			});
		});
	</script>
  </body>
</html>