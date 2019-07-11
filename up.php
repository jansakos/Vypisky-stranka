<?php
	// User logged in
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}
	
	// Veritification of user
	if(($_SESSION['permission'])!="o" && ($_SESSION['permission'])!="w" && ($_SESSION['permission'])!="u"){
		header("location: download.php");
		exit;
	}
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <?php
		include('parts/head.php');
	?>
	<title>Nahrávám...</title>
  </head>
  
  <body>
	<?php
		include('config.php');
	
		// Set directory
		$slozka = 'assets/files/vypisky/';
		$uploadOk = 1;
		
		// Define maximal size
		if(($_SESSION['permission'])=="o") {
			$maxsize = 10000000;
		}else{
			if(($_SESSION['permission'])=="w") {
				$maxsize = 2000000;
			}else{
				if(($_SESSION['permission'])=="u") {
					$maxsize = 250000;
				}else{
					
					// Strange error
					header("location: download.php");
				}
			}
			
		}
		

		// Check maximal file size
		if ($_FILES ["fileToUpload"]["size"] > $maxsize) {
			echo "Pardon, velikost souboru nesmí přesáhnout ".$maxsize." bytů.";
			$uploadOk = 0;
		}
		
		// Check empty file
		if ($_FILES ["fileToUpload"]["size"] == "0") {
			echo "Pardon, soubor nesmí být prázdný.";
			$uploadOk = 0;
		}
		
		// Confirm name
		if(empty(trim($_POST['name']))){ 
			$uploadOk = 0;
		}else{
			$name = trim(stripslashes(htmlspecialchars($_POST['name'])));
				
			// Make filename
			$filename = basename($_FILES['fileToUpload']['name']);
			$nazev    = pathinfo($filename, PATHINFO_FILENAME);
			$nazev    = iconv("utf-8", "us-ascii//TRANSLIT", $nazev);  // Remove nonASCII
			$nazev    = strtolower($nazev); 
			$nazev    = preg_replace('~[^-a-z0-9_]+~', '', $nazev);  // Remove transcription
			$pripona  = pathinfo($filename, PATHINFO_EXTENSION);
			$pripona  = strtolower($pripona); 
	 
			// If file exists, add number
			$increment = '';
			while(file_exists( $slozka . $nazev . $increment . '.' . $pripona )) {
				$increment++;
				if( $increment > 100 ) {
					
					// Too much of the same file
					die("Počet pokusů o vytvoření stejného názvu souboru překročil limit (100).");            	
				}
			}
			
			$filename  = $slozka . $nazev. $increment . '.' . $pripona;
			}
			
		// No errors?
		if ($uploadOk == 0){
			echo "Pardon, Váš soubor nesplňuje všechny podmínky. ";
		} else {
			if( move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $filename) ) {
				
				// Set up MySQL
				require_once 'config.php';
				$author = $subject = $address = "";
				
				// Select SQL
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					
				// Subject confirm
				if(empty(trim($_POST['subject']))){ 		
				}else{
					$subject = trim(stripslashes(htmlspecialchars($_POST['subject'])));
				}
				
				// Description confirm
				if(empty(trim($_POST['popis']))){ 		
				}else{
					$descript = trim(stripslashes(htmlspecialchars($_POST['popis'])));
				}
			
				// Insert into MySQL
					$sql = "INSERT INTO files (subject, name, address, author, descript) VALUES (?, ?, ?, ?, ?)";
					
					if($stmt = mysqli_prepare($link, $sql)){
						
						// Bind variables to the prepared statement as parameters
						mysqli_stmt_bind_param($stmt, "sssss", $param_subject, $param_name, $param_address, $param_author, $param_descript);
						
						// Set parameters
						$param_name = $name;
						$param_subject = $subject;
						$param_author = ($_SESSION['username']);
						$param_address = $filename;
						$param_descript = $descript;
						
						// Attempt to execute the prepared statement
						if(mysqli_stmt_execute($stmt)){
							// Redirect to download page
							header("location: download.php");
						}else{
							echo "Neočekávaná chyba.";
						}
					}
				 
					// Close statement
					mysqli_stmt_close($stmt);
				}
			
				// Close connection
				mysqli_close($link);
				
				} else {
					echo "Během ukládání došlo k chybě";
					if(!file_exists($slozka)) {
						echo ": Složka pro uložení neexistuje.<br />";
					} else if(!is_writable($slozka)) {
						echo ": Ke složce nejsou nastavena přístupová práva.<br />";
					} elseif(!is_writable($name)) {
						echo": Soubor není zapisovatelný.<br />";
					}
				}    
		}	
	?>
  </body>
</html>