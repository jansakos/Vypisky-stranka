<?php
	// Veritification of logging
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}
	
	require_once 'config.php';
	
	if(isset($_REQUEST['action'])){
		switch($_REQUEST['action']){
			
			// Download file
			case "down":
				$filename = basename(stripslashes(htmlspecialchars($_REQUEST['file'])));
				
				// Define downloaded file
				$path = "./assets/files/vypisky/";
				$downloadfile = $path.$filename;

				// Download force
				if(!empty($filename)){
					if(file_exists($downloadfile))
					{
						header("Content-Type: application/octet-stream"); 
						header("Content-Disposition: attachment; filename=".$filename);
						readfile($downloadfile);
						exit;
					}else{
						echo 'Tento soubor nebyl nalezen!';
					}
				}
			break;
			
			// Delete file
			case "del":
				if(($_SESSION['permission'])!="o" && ($_SESSION['permission'])!="w"){
					header("location: download.php");
					exit;
				}else{
					
					// Select file
					$id = ($_GET['id']);
					$sql = 'SELECT * FROM files WHERE id="'.$id.'"';
					$query = mysqli_query($link, $sql);
					if (!$query) {
						die ('SQL chyba: ' . mysqli_error($link));
					}else{
						while ($row = mysqli_fetch_array($query)){
							$author = $row['author'];
							$address = $row['address'];
						}
					}
					
					// Deleting file record
					if(($author == $_SESSION['username'])||($_SESSION['permission'])=="o"){
						$sql = 'DELETE FROM files WHERE id="'.$id.'"';
						if ($link->query($sql) === TRUE) {
							echo "Úspěšně smazáno";
						} else {
							echo "Nastala chyba při mazání: " . $link->error;
						}
					}else{
						echo "Nesmíte mazat cizí výpisky.";
					}
					$link->close();
					
					// Delete file
					$finaddress = ($_SERVER['DOCUMENT_ROOT'].$root.$address);
					if(file_exists($finaddress)){		
						unlink($finaddress);
						header("location: download.php");
						exit;
					}else{
						header("location: download.php");
					}
				}
			break;
			
			// Archive file
			case "arch":
			if(($_SESSION['permission'])!="o" && ($_SESSION['permission'])!="w" && ($_SESSION['permission'])!="t"){
					header("location: download.php");
					exit;
				}else{
					
					// Select file
					$id = ($_GET['id']);
					$sql = 'SELECT * FROM files WHERE id="'.$id.'"';
					$query = mysqli_query($link, $sql);
					if (!$query) {
						die ('SQL chyba: ' . mysqli_error($link));
					}else{
						while ($row = mysqli_fetch_array($query)){
							$name = $row['name'];
							$author = $row['author'];
							$address = $row['address'];
							$subject = $row['subject'];
						}
					}
					// Deleting old file record
					if(($author == $_SESSION['username'])||($_SESSION['permission'])=="o"){
						$sql = 'DELETE FROM files WHERE id="'.$id.'"';
						if ($link->query($sql) === TRUE) {
							echo "Úspěšně smazáno";
						} else {
							echo "Nastala chyba při mazání: " . $link->error;
						}
					}else{
						echo "Nesmíte mazat cizí výpisky.";
					}
					
					// Insert file record to archive
					$sql = "INSERT INTO archiv (subject, name, address, author) VALUES (?, ?, ?, ?)";
					
					if($stmt = mysqli_prepare($link, $sql)){
						
						// Bind variables to the prepared statement as parameters
						mysqli_stmt_bind_param($stmt, "ssss", $param_subject, $param_name, $param_address, $param_author);
						
						// Set parameters
						$param_name = $name;
						$param_subject = $subject;
						$param_author = $author;
						$param_address = $address;
						
						// Attempt to execute the prepared statement
						if(mysqli_stmt_execute($stmt)){
							// Redirect to download page
							header("location: download.php");
						} else{
							echo "Neočekávaná chyba.";
						}
					}
					mysqli_stmt_close($stmt);
					mysqli_close($link);
				}
					
			break;
			
			// Delete archived file
			case "archdel":
				if(($_SESSION['permission'])!="o" && ($_SESSION['permission'])!="w"){
					header("location: download.php");
					exit;
				}else{
					
					// Select file
					$id = ($_GET['id']);
					$sql = 'SELECT * FROM archiv WHERE id="'.$id.'"';
					$query = mysqli_query($link, $sql);
					if (!$query) {
						die ('SQL chyba: ' . mysqli_error($link));
					}else{
						while ($row = mysqli_fetch_array($query)){
							$author = $row['author'];
							$address = $row['address'];
						}
					}
					
					// Deleting file record
					if(($author == $_SESSION['username'])||($_SESSION['permission'])=="o"){
						$sql = 'DELETE FROM archiv WHERE id="'.$id.'"';
						if ($link->query($sql) === TRUE) {
							echo "Úspěšně smazáno";
						} else {
							echo "Nastala chyba při mazání: " . $link->error;
						}
					}else{
						echo "Nesmíte mazat cizí výpisky.";
					}
					$link->close();
					
					// Delete file
					$finaddress = ($_SERVER['DOCUMENT_ROOT'].$root.$address);
					if(file_exists($finaddress)){		
						unlink($finaddress);
						header("location: archive.php");
						exit;
					}else{
						header("location: archive.php");
					}
				}
			break;
			
			
			// Dearchive file
			case "dearch":
			if(($_SESSION['permission'])!="o"){
					header("location: download.php");
					exit;
				}else{
					
					// Select file
					$id = ($_GET['id']);
					$sql = 'SELECT * FROM archiv WHERE id="'.$id.'"';
					$query = mysqli_query($link, $sql);
					if (!$query) {
						die ('SQL chyba: ' . mysqli_error($link));
					}else{
						while ($row = mysqli_fetch_array($query)){
							$name = $row['name'];
							$author = $row['author'];
							$address = $row['address'];
							$subject = $row['subject'];
						}
					}
					// Deleting old file record
					if(($author == $_SESSION['username'])||($_SESSION['permission'])=="o"){
						$sql = 'DELETE FROM archiv WHERE id="'.$id.'"';
						if ($link->query($sql) === TRUE) {
							echo "Úspěšně smazáno";
						} else {
							echo "Nastala chyba při mazání: " . $link->error;
						}
					}else{
						echo "Nesmíte mazat cizí výpisky.";
					}
					
					// Insert file record to archive
					$sql = "INSERT INTO files (subject, name, address, author) VALUES (?, ?, ?, ?)";
					
					if($stmt = mysqli_prepare($link, $sql)){
						
						// Bind variables to the prepared statement as parameters
						mysqli_stmt_bind_param($stmt, "ssss", $param_subject, $param_name, $param_address, $param_author);
						
						// Set parameters
						$param_name = $name;
						$param_subject = $subject;
						$param_author = $author;
						$param_address = $address;
						
						// Attempt to execute the prepared statement
						if(mysqli_stmt_execute($stmt)){
							// Redirect to download page
							header("location: download.php");
						} else{
							echo "Neočekávaná chyba.";
						}
					}
					mysqli_stmt_close($stmt);
					mysqli_close($link);
				}
					
			break;
			
		}
	}else{
		header("location: download.php");
	}
?>