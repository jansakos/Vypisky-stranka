<?php
	// User loged in
	require_once 'config.php';
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}		
	
	// User is teacher or owner
	if(($_SESSION['permission']) != "t" && ($_SESSION['permission']) != "o"){
		header("location: index.php");
		exit;
	}
	
	// Add notification
	$exp = $text = $type = $for = "";
	if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['exp']) && !empty($_POST['text']) && !empty($_POST['type'])){
 
    $text = stripslashes(htmlspecialchars($_POST['text']));
         
        // Close statement
        mysqli_stmt_close($stmt);
		
		$type = trim($_POST['type']);
    
        $exp = trim($_POST['exp']);
		
		if(!empty($_POST['forwhom'])){
			$for = trim($_POST['forwhom']);
		}else{
			$sql = "INSERT INTO rss (title, description) VALUES (?, ?)";
					
			if($stmt = mysqli_prepare($link, $sql)){
						
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "ss", $param_title, $param_description);
									
				// Set parameters
				$param_title = 'Nové upozornění!';
				$param_description = 'Uživatel '.$_SESSION['username'].' oznamuje všem: '.$text.'.';
									
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					header("location: addnotif.php");
				}else{
					echo "Neočekávaná chyba.";
				}
			}
		}
        
        // Prepare an insert statement
        $query = "INSERT INTO notif (text, tothe, exp, type) VALUES (?, ?, ?, ?)";
		$stmt= $pdo->prepare($query);
		$run = $stmt->execute([$text, $for, $exp, $type]);
		if( $run ){
			header("location: addnotif.php");
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
		// Set design
		include("parts/head.php");
		if (isset($_SESSION['design'])){
			echo "<link href='assets/css/bootstrap-".$_SESSION['design'].".css' rel='stylesheet'>
			<link href='assets/css/main-".$_SESSION['design'].".css' rel='stylesheet'>";
		}else{
			echo "<link href='assets/css/bootstrap-default.css' rel='stylesheet'>
			<link href='assets/css/main-default.css' rel='stylesheet'>";
		}
	?>
	<title>Oznámení | Výpisky</title>
	
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body>
	<?php
		include("header.php")
	?>
	  <div class="content">
		<div class="container">
			<div class="row_centered">
				<h2>Nové oznámení</h2>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<label>Text oznámení</label>
						<input type="text" name="text" class="form-control" required autocomplete="off">   
						<label>Příjemce</label>
						<input type="text" name="forwhom" class="form-control" autocomplete="off">
						<label>Datum vypršení</label>
						<input type="date" name="exp" class="form-control" required>
						<label>Typ</label>
						<select name="type" class="form-control">
							<option value="1" default>Oznámení</option>
							<option value="2">Upozornění</option>
							<option value="3">Varování</option>
							<option value="5">Úspěch</option>
						</select> 
						<span class="help-block"><?php ?></span>
					
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Přidat">
						<input type="reset" class="btn btn-default" value="Reset">
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="r">
		<div class="container">
			<div class="centered">
				<div class="col-lg-8 col-md-offset-2">
					<h4>RYCHLÁ NÁPOVĚDA</h4>
					<p>Do kolonky <i>oznámení</i> patří text samotného sdělení. Kolonka <i>příjemce</i> je nepovinná, patří do ní username příjemce, pokud zpráva není určena pro všechny (pokud je vyplněn username v této kolonce, zobrazí se upozornění pouze této jedné osobě). Username sestává z prvního písmene z křestního jména a prvních pěti písmen z příjmení, je psáno bez diakritiky a malými písmeny (např. <u>J</u>an <u>Nová</u>k -> jnovak). Pokud má účet méně než 5 písmen v příjmení, použije se místo pouze prvního písmena ze jména tolik písmen, aby byl username dlouhý 6 znaků (např. <u>Ja</u>kub <u>Klíč</u> -> jaklic). <i>Expirace</i> je datum, do kterého se má upozornění zobrazovat. <i>Typ</i> určuje vzhled zprávy.</p>
				</div>
			</div>
		</div>
	</div>
	<?php
		include("footer.php");
	?>
  </body>
</html>