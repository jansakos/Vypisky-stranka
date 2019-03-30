<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
if(($_SESSION['permission']) == "n"){
	header("location: index.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
    <?php
     include("parts/head.php");
	?>
    <title>Chatroom | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	
	<script src="assets/js/jquery-3.3.1.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="assets/css/chat.css" />

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
					
						
					
						<div id="drop" class="btn-group dropup">
							<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Obrázek
								<span class="caret"></span>
							</button>
							<ul id="imgmenu" class="dropdown-menu dropdown-menu-center">
								<div class="centered">
									<li>Je povoleno nahrávat obrázky do velikosti<br> 5 MB typu jpg, png a gif.<br><br></li>
									<li><input type="file" id="file" name="obrazky" required data-keepOpenOnClick class="btn btn-default"><br></li>
									<li><button id='process-file-button' class="btn btn-primary mb-2">Nahrát</button></li>
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
				LoadChat();
				setInterval(function(){
					LoadChat();
				}, 1000);
				function LoadChat(){
					$.post('messages.php?action=getMessages', function(response){
					 if(res!=(response)){
						var scrollpos = $('#chatbox').scrollTop();
						var scrollpos = parseInt(scrollpos) + 320;
						var scrollHeight = $('#chatbox').prop('scrollHeight');
						$('#chatbox').html(response);
						res = (response);
						if( scrollpos < scrollHeight ){	
						}else{
						$('#chatbox').scrollTop( $('#chatbox').prop('scrollHeight') ); }
						}
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
					document.getElementById("file").value = "";
				});
						
			</script>
			<script>
				$(function() {
					$("ul.dropdown-menu").on("click", "[data-keepOpenOnClick]", function(g) {
						g.stopPropagation();
					});
				});
			</script>
  </body>
</html>