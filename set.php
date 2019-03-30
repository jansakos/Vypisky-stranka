<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
if(($_SESSION['permission']) == "o"){
	header("location: adminset.php");
	exit;
}

$passold_err = $passnew_err = $passcon_err = '';
$user = $_SESSION['username'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	//checking fields
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	$confpassword = $_POST['confpassword'];
	
	//check old password
	include ('config.php');
	$queryget = mysqli_query($link, "SELECT password FROM login WHERE username='$user'") or die("Neprobehlo uspesne pripojeni k databazi.");
	$row = mysqli_fetch_assoc($queryget);
	$oldpassworddb = $row['password'];
	
	if (!password_verify($oldpassword, $oldpassworddb)){
			$passold_err = "Napsané heslo se neshoduje se starým!";
		}else{
	
		if ($newpassword == ""){
			$passnew_err = "Nenapsali jste nové heslo!";
		}else{
	
			//check newpassword and confpassword
			if ($newpassword != $confpassword){
				$passcon_err = "Nové heslo a jeho kontrola se neshodují!";
			}else{
				
				if ($newpassword == $oldpassword){
					$passnew_err = "Nové heslo a staré heslo jsou stejné!";
				}else{
			
					//bcrypt
					$hashed_password = password_hash($newpassword, PASSWORD_BCRYPT);
					
					//change password
					$querychange = mysqli_query($link, "
					UPDATE login SET password='$hashed_password' WHERE username='$user'
					");
					session_destroy();
					header("location: login.php");
					exit;
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
     include("parts/head.php");
	?>
    <title>Nastavení účtu | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body class="x-body">
	
		<?php
			include("header.php")
		?>
		<div class="content">
		<form method="post" action="set.php" autocomplete="off">
			<div class="container">   
				<div class="form-group <?php echo (!empty($passold_err)) ? 'has-error' : ''; ?>">
					<label>Staré heslo:</label>
						<input type="text" name="oldpassword" class="form-control">
					<span class="help-block"><?php echo $passold_err; ?></span>
				</div>
			
				<div class="form-group <?php echo (!empty($passnew_err)) ? 'has-error' : ''; ?>">
					<label>Nové heslo:</label>
						<input type="password" name="newpassword" class="form-control">
					<span class="help-block"><?php echo $passnew_err; ?></span>
				</div>
			
				<div class="form-group <?php echo (!empty($passcon_err)) ? 'has-error' : ''; ?>">
					<label>Potvrzení nového hesla:</label>
						<input type="password" name="confpassword" class="form-control">
					<span class="help-block"><?php echo $passcon_err; ?></span>
				</div>
				
				<div class="form-group">
					<input type="submit" name="submit" class="btn btn-primary" value="Změnit heslo">
				</div>
			</div>
		</form>
		
		<hr>
		
		<!--<div class="form-group">
			<label for="switch">Dark mode:</label>
		</div>-->
		
		<div class="container">
			<a href="first.php" class="btn btn-primary btn-lg btn-block">Zobrazit nápovědu</a>
		</div>
		<br>
	</div>
	<?php
		include("footer.php");
	?>
  </body>
</html>
