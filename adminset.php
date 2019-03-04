<?php
include ('config.php');
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
if(($_SESSION['permission']) != "o"){
	header("location: set.php");
	exit;
}
$sql = 'SELECT * 
		FROM login';
		
$query = mysqli_query($link, $sql);

if (!$query) {
	die ('SQL chyba: ' . mysqli_error($link));
}

//PŘIDÁNÍ UŽIVATELE
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
                /* store result */
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
            $param_password = $password;
			$param_permission = $permission;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Nečekaná chyba.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}

//PŘIDÁNÍ UDÁLOSTI
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
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
	?>
    <title>Nastavení stránky | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body>
  
  <?php
	include("header.php")
  ?>
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
					<input type="text" name="permission" class="form-control" value="<?php echo $permission; ?>">
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
					</tr>
				</thead>
				<tbody>
					<?php
					$id 	= 1;
					while ($row = mysqli_fetch_array($query))
					{
						echo '<tr>
								<td>'.$id.'</td>
								<td>'.$row['username'].'</td>
								<td>'.$row['password'].'</td>
								<td>'.$row['permission'].'</td>';	
							echo '</tr>';
						$id++;
					}?>
				</tbody>
			</table>
		</div>
	</div>
	
	<?php
     include("footer.php");
	?>
	
  </body>
</html>