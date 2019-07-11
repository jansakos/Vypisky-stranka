<?php
	// User logged in?
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}
	
	// adminset.php redirection
	if(($_SESSION['permission']) == "o"){
		header("location: adminset.php");
		exit;
	}

	// Vars empty setting 
	$passold_err = $passnew_err = $passcon_err = '';
	$user = $_SESSION['username'];
	include ('config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		// Set variables
		$oldpassword = $_POST['oldpassword'];
		$newpassword = $_POST['newpassword'];
		$confpassword = $_POST['confpassword'];
		
		// Old password checking
		$queryget = mysqli_query($link, "SELECT password FROM login WHERE username='$user'") or die("Neprobehlo uspesne pripojeni k databazi.");
		$row = mysqli_fetch_assoc($queryget);
		$oldpassworddb = $row['password'];
		
		// Old password verifying
		if (!password_verify($oldpassword, $oldpassworddb)){
				$passold_err = "Napsané heslo se neshoduje se starým!";
			}else{
		
			// New password not empty
			if ($newpassword == ""){
				$passnew_err = "Nenapsali jste nové heslo!";
			}else{
		
				// New password confirm
				if ($newpassword != $confpassword){
					$passcon_err = "Nové heslo a jeho kontrola se neshodují!";
				}else{
					
					// Difference between new and old paswords
					if ($newpassword == $oldpassword){
						$passnew_err = "Nové heslo a staré heslo jsou stejné!";
					}else{
				
						// Crypt new password
						$hashed_password = password_hash($newpassword, PASSWORD_BCRYPT);
						
						// Change password in MySQL
						$querychange = mysqli_query($link, "UPDATE login SET password='$hashed_password' WHERE username='$user'");
						session_destroy();
						header("location: login.php");
						exit;
					}
				}
			}
		}
	}

	// Design changer
	$design = array('dark', 'default');
	$newdesign= "default";
	
	// Array confirm
	if (isset($_GET['design']) && in_array($_GET['design'], $design)) {
			$newdesign = $_GET['design'];
			$_SESSION['design'] = $newdesign;
			
			$sql = "UPDATE login SET design='$newdesign' WHERE username='$user'";
			 
			if($stmt = mysqli_prepare($link, $sql)){
				if(mysqli_stmt_execute($stmt)){
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
	// Close connection
	mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
	 	if (isset($_SESSION['design'])){
			echo "<link href='assets/css/bootstrap-". $_SESSION['design']. ".css' rel='stylesheet'>";
		}else{
			echo "<link href='assets/css/bootstrap-default.css' rel='stylesheet'>";
		}
	?>
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<title>Nastavení | Výpisky</title>
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
		
		<div class="container">
			<div class="form-group">
				<?php
					if($_SESSION["design"]!="dark"){
						echo "<label for='switch'>Tmavý režim:</label> <a href='?design=dark' title='Tmavý režim' id='switch' class='btn btn-primary btn-lg'><i class='fa big-icon fa-moon-o'></i></a>";
					}else{
						echo "<label for='switch'>Světlý režim:</label> <a href='?design=default' title='Světlý režim' id='switch' class='btn btn-primary btn-lg'><i class='fa big-icon fa-eye'></i></a>";
					}
				?>
			</div>
		</div>
		
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
