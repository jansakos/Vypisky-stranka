<?php
	// User logged in
	include ('config.php');
	session_start();
	$user = $_SESSION['username'];
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}

	// Admin veritification
	if(($_SESSION['permission']) != "o"){
		header("location: set.php");
		exit;
	}
	
	// Connect to MySQL - accounts
	$sql = 'SELECT * 
			FROM login';
			
	$accounts = mysqli_query($link, $sql);

	if (!$accounts) {
		die ('SQL chyba: ' . mysqli_error($link));
	}
	
	// Connect to MySQL - notifications
	$sql = 'SELECT * 
			FROM notif';
			
	$notifications = mysqli_query($link, $sql);

	if (!$notifications) {
		die ('SQL chyba: ' . mysqli_error($link));
	}
	
	// Connect to MySQL - diary
	$sql = 'SELECT * 
			FROM diar';
			
	$diary = mysqli_query($link, $sql);

	if (!$diary) {
		die ('SQL chyba: ' . mysqli_error($link));
	}

	// Add new user
	$username = $password = $permission = "";
	$username_err = $password_err = $permission_err = "";
	if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['username'])&& !empty($_POST['permission']) && !empty($_POST['password'])){
	 
		// Validate username
		if(empty(trim($_POST["username"]))){
			$username_err = "Nezadáno už. jméno.";
		}elseif(strlen(trim($_POST['username'])) != 6){
			$username_err = "Špatně zadané už. jméno (šest písmen).";
		}else{
			// Prepare a select statement
			$sql = "SELECT id FROM login WHERE username = ?";
			
			if($stmt = mysqli_prepare($link, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				
				// Set parameters
				$param_username = trim($_POST["username"]);
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					// Store results
					mysqli_stmt_store_result($stmt);
					
					if(mysqli_stmt_num_rows($stmt) == 1){
						$username_err = "Použité už. jméno.";
					} else{
						$username = trim($_POST["username"]);
					}
				} else{
					echo "Něco se pokazilo.";
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
		// Validate password
		if(empty(trim($_POST['password']))){
			$password_err = "Nezadáno heslo.";     
		}else{
			$password = trim($_POST['password']);
		}
		
		//bcrypt
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);
		
		//Permission
		if(empty(trim($_POST['permission']))){
			$permission_err = "Nezadána oprávnění.";     
		}elseif(strlen(trim($_POST['permission'])) > 1){
			$permission_err = "Špatně zadaná oprávnění (jen jedno písmeno).";
		}else{
			$permission = trim($_POST['permission']);
		}
		
		// Check input errors before inserting in database
		if(empty($username_err) && empty($password_err) && empty($permission_err)){
			
			// Prepare an insert statement
			$sql = "INSERT INTO login (username, password, permission) VALUES (?, ?, ?)";
			 
			if($stmt = mysqli_prepare($link, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_permission);
				
				// Set parameters
				$param_username = $username;
				$param_password = $hashed_password;
				$param_permission = $permission;
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					// Redirect to login page
					header("location: login.php");
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
		// Close connection
		mysqli_close($link);
	}

	// Add notification
	$exp = $text = $type = $for = "";
	if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['exp']) && !empty($_POST['text']) && !empty($_POST['type'])){
 
        // Prepare a select statement
        $sql = "SELECT id FROM notif WHERE text = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_text);
            
            // Set parameters
            $param_text = trim($_POST['text']);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                   echo "Již řečená zpráva!";
                } else{
                    $text = stripslashes(htmlspecialchars($_POST['text']));
                }
            } else{
                echo "Něco se pokazilo.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
		
		$type = trim($_POST['type']);
    
        $exp = trim($_POST['exp']);
		
		if(!empty($_POST['forwhom'])){
			$for = trim($_POST['forwhom']);
		}
        
        // Prepare an insert statement
        $query = "INSERT INTO notif (text, tothe, exp, type) VALUES (?, ?, ?, ?)";
		$stmt= $pdo->prepare($query);
		$run = $stmt->execute([$text, $for, $exp, $type]);
			if( $run ){
				header("location: adminset.php");
			}else{
				echo("Něco se pokazilo!");
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
    }
	
	// Design change
	$design = array('dark', 'default');
	$newdesign= "default";
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
	mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
		echo "<link href='assets/css/bootstrap-". $_SESSION['design']. ".css' rel='stylesheet'>";
	?>
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<title>Nastavení stránky | Výpisky</title>
  </head>

  <body>
	
	  <?php
		include("header.php")
	  ?>
	  <div class="content">
		<div class="container wb">
			<div class="row_centered">
				<h2>Nové oznámení</h2>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<label>Oznámení</label>
						<input type="text" name="text" class="form-control" required autocomplete="off">   
						<label>Určeno pro?</label>
						<input type="text" name="forwhom" class="form-control" autocomplete="off">
						<label>Expirace</label>
						<input type="date" name="exp" class="form-control" required>
						<label>Typ</label>
						<select name="type" class="form-control">
							<option value="1" default>Oznámení</option>
							<option value="2">Upozornění</option>
							<option value="3">Varování</option>
							<option value="4">Výpadek</option>
							<option value="5">Úspěch</option>
							<option value="6">BAN</option>
						</select> 
						<span class="help-block"><?php ?></span>
					
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Přidat">
						<input type="reset" class="btn btn-default" value="Reset">
					</div>
				</form>
			</div>
		</div>
	  
		<div class="container wb">
			<div class="row_centered">
				<h2>Nový účet</h2>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
						<label>Už. jméno</label>
						<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
						<span class="help-block"><?php echo $username_err; ?></span>
					</div>    
					<div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
						<label>Heslo</label>
						<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
						<span class="help-block"><?php echo $password_err; ?></span>
					</div>
					<div <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
						<label>Oprávnění</label>
						<select name="permission" class="form-control">
							<option value="r" default>Čtenář</option>
							<option value="m">Moderátor</option>
							<option value="w">Pisatel</option>
							<option value="u">Neověřený pisatel</option>
							<option value="n">Spammer</option>
							<option value="p">Pozastaven</option>
						</select> 
						<span class="help-block"><?php echo $permission_err; ?></span>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Přidat">
						<input type="reset" class="btn btn-default" value="Reset">
					</div>
				</form>
			</div>
		</div>
		
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
		
		<div class="container-w">
			<h2>Úpravy účtů</h2>
			<div class="table-responsive">
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>ID</th>
							<th>USERNAME</th>
							<th>HESLO</th>
							<th>OPR.</th>
							<th>1.</th>
							<th>DESIGN</th>
						</tr>
					</thead>
					<tbody>
						<?php
							while ($row = mysqli_fetch_array($accounts))
							{
								echo '<tr>
										<td>'.$row['id'].'</td>
										<td>'.$row['username'].'</td>
										<td>'.$row['password'].'</td>
										<td>'.$row['permission'].'</td>
										<td>'.$row['first'].'</td>
										<td>'.$row['design'].'</td>
									</tr>';
						}?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="container-w">
			<h2>Správa oznámení</h2>
			<div class="table-responsive">
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>ID</th>
							<th>TEXT</th>
							<th>PRO</th>
							<th>EXPIRACE</th>
							<th>TYP</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($row = mysqli_fetch_array($notifications))
						{
							echo '<tr>
									<td>'.$row['id'].'</td>
									<td>'.$row['text'].'</td>
									<td>'.$row['tothe'].'</td>
									<td>'.$row['exp'].'</td>
									<td>'.$row['type'].'</td>	
								</tr>';
						}?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="container-w">
			<h2>Správa diáře</h2>
			<div class="table-responsive">
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>ID</th>
							<th>DATUM</th>
							<th>PŘ.</th>
							<th>TYP</th>
							<th>NÁZEV</th>
							<th>OTH.</th>
							<th>AUTOR</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($row = mysqli_fetch_array($diary))
						{
							echo '<tr>
									<td>'.$row['id'].'</td>
									<td>'.$row['date'].'</td>
									<td>'.$row['subj'].'</td>
									<td>'.$row['type'].'</td>
									<td>'.$row['name'].'</td>
									<td>'.$row['othtype'].'</td>
									<td>'.$row['owner'].'</td>										
								</tr>';
						}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
		include("footer.php");
	?>
  </body>
</html>