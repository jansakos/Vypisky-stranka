<?php
	// Include config file
	require_once 'config.php';
	 
	// Define variables and initialize with empty values
	$username = $password = $permission = $first = $design = "";
	$username_err = $password_err = "";
	 
	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		// Check if username is empty
		if(empty(trim($_POST["username"]))){
			$username_err = 'Zadejte svoje uživatelské jméno.';
		} else{
			$username = trim(stripslashes(htmlspecialchars($_POST["username"])));
		}
		
		// Check if password is empty
		if(empty(trim($_POST['password']))){
			$password_err = 'Zadejte svoje heslo.';
		} else{
			$password = trim(htmlspecialchars($_POST['password']));
		}
		
		// Any error?
		if(empty($username_err) && empty($password_err)){
			// Prepare a select statement
			$sql = "SELECT username, password, permission, first, design FROM login WHERE username = ?";
			
			if($stmt = mysqli_prepare($link, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				
				// Set parameters
				$param_username = $username;
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					// Store result
					mysqli_stmt_store_result($stmt);
					
					// Check if username exists, if yes then verify password
					if(mysqli_stmt_num_rows($stmt) == 1){   
					
						// Bind result variables
						mysqli_stmt_bind_result($stmt, $username, $hashed_password, $permission, $first, $design);
						if(mysqli_stmt_fetch($stmt)){
							if(password_verify($password, $hashed_password)){
								
								//Check if user is not paused
									if($permission!="p"){
										
									/* Password is correct, so start a new session and
									save the username to the session */
									session_start();
									$_SESSION['username'] = $username;
									$_SESSION['permission'] = $permission;  
									$_SESSION['first'] = $first; 
									$_SESSION['design'] = $design; 
									header("location: index.php");
									}else{
										
										// User is paused
										$username_err = 'Váš účet je zablokován. Pokud si myslíte, že se jedná o omyl, neprodleně mě kontaktujte.';
									}
							} else{
								
								// Display an error message if password is not valid
								$password_err = 'Vaše heslo není správné. Napište jej znovu, příp. si zažádejte o heslo nové.';
							}
						}
					} else{
						
						// Display an error message if username doesn't exist
						$username_err = 'Překontrolujte své uživatelské jméno.';
					}
				} else{
					
					// Unexpected error
					echo "Vznikla nečekaná chyba. Zkuste se, prosím, znovu připojit trochu později.";
				}
			}
			
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
		// Close connection
		mysqli_close($link);
	}

	// Login design selection
	$design = array('dark', 'default', 'black');
	if (isset($_GET['design']) && in_array($_GET['design'], $design)) {
			$_COOKIE['design'] = $_GET['design'];
	}
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
		
		// Set cookie?
		if(isset($_COOKIE["design"])){
			 echo "<link href='assets/css/bootstrap-". $_COOKIE['design']. ".css' rel='stylesheet'>";
			 // Extend it
			 setcookie("design", $_COOKIE["design"], time()+60*60*24*30*6, "/", 1, 1);
		}else{
			// Set new cookie with default
			 setcookie("design", "default", time()+60*60*24*30*6, "/", 1, 1);
			 echo "<link href='assets/css/bootstrap-default.css' rel='stylesheet'>";
		}
		 
	?>	
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<title>Přihlášení | Výpisky</title>
  </head>

  <body class="n-body">
	<div class="content-log">
		<div class="container">
			<?php
				// Design switch
				if(isset($_COOKIE["design"])){
					if($_COOKIE["design"]!="dark"){
						echo "<a href='?design=dark' title='Tmavý režim'><i class='fa pull-right big-icon fa-moon-o'></i></a>";
					}else{
						echo "<a href='?design=default' title='Světlý režim'><i class='fa pull-right big-icon fa-eye'></i></a>";
					}
				}else{
					echo "<a href='?design=dark'><i class='fa fa-moon-o'></i></a>";
				}
			?>
					
			<h2>Přihlášení</h2>
			<p>Přihlašte se, prosím, abyste mohli pokračovat na stránku Výpisků.</p>
		   
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<label>Uživatelské jméno:</label>
						<input type="text" autofocus name="username" class="form-control" value="<?php echo $username; ?>" required>
					<span class="help-block"><?php echo $username_err; ?></span>
				</div> 
				
				<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					<label>Heslo:</label>
						<input type="password" name="password" class="form-control" required>
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Přihlásit se">
				</div>
			</form>
		</div>
	</div>
	<?php
		include("footer.php");
	?>
  </body>
</html>