<?php
	// User loged in
	include ('config.php');
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}		

	// Ordering by
	$orderedBy = array('subject', 'name', 'author', 'id', 'subject desc', 'name desc', 'author desc', 'id desc');
	$order = 'subject';
	if (isset($_GET['orderedBy']) && in_array($_GET['orderedBy'], $orderedBy)) {
		$order = $_GET['orderedBy'];
	}	
	$sql = 'SELECT * FROM files ORDER BY '.$order;		
	$query = mysqli_query($link, $sql);
	if (!$query) {
		die ('SQL chyba: ' . mysqli_error($link));
	}
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		// Set design
		include("parts/head.php");
		if (isset($_SESSION['design'])){
			echo "<link href='assets/css/bootstrap-". $_SESSION['design']. ".css' rel='stylesheet'>";
		}else{
			echo "<link href='assets/css/bootstrap-default.css' rel='stylesheet'>";
		}
	?>
	<title>Ke stažení | Výpisky</title>
	
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body>
	
	<?php
		include("header.php");
	?>
	<div class="content">
		<div class="centered">
			<h3>VÝPISKY KE STAŽENÍ</h3><br>
		</div>
	  
		<?php
			// Include ordered by
			if (mysqli_num_rows($query)!=0){
				echo "<div class='container'>
						<div class='form-group col-md-2'>
							<label for='Order'>Seřadit dle:</label>
							<select id='Order' name='OrderBy' class='form-control'>
								<option default value='?orderedBy=subject'>Předmětu &#9661;</option>
								<option value='?orderedBy=id'>Stáří &#9661;</option>
								<option value='?orderedBy=name'>Názvu &#9661;</option>
								<option value='?orderedBy=author'>Autora &#9661;</option>
								<option value='?orderedBy=subject desc'>Předmětu &#9651;</option>
								<option value='?orderedBy=id desc'>Stáří &#9651;</option>
								<option value='?orderedBy=name desc'>Názvu &#9651;</option>
								<option value='?orderedBy=author desc'>Autora &#9651;</option>
							</select>
						</div>
					</div>";
			}
		?>
		<script>
		 $(function(){
			  $('#Order').on('change', function () {
				  var url = $(this).val();
				  if (url) {
					  window.location = url;
				  }
				  return false;
			  });
			});
		</script>
		<br>
		<div class="container-w">
			<div class="table-responsive">
				<table class='table table-hover'>
					<?php
						// Any record?
						if (mysqli_num_rows($query)!=0){
							
							// Owners view
							if(($_SESSION['permission'])=="o"){
								echo "<thead>
										  <tr>
											<th>PŘ.</th>
											<th>NÁZEV</th>
											<th><i class='fa fa-download'></i></th>
										  </tr>
									</thead>";
								while ($row = mysqli_fetch_array($query)){
								
									$datestr = strtotime($row['date']);
									$findate = date('d. m. Y H:i:s', $datestr);
									
									echo "<tr data-toggle='collapse' data-target='.order".$row['id']."'>
											<td>".$row['subject']."</td>
											<td>".$row['name']."</td>";	
									if(file_exists($row['address'])){
										echo "<td><a href='file.php?action=down&file=".$root.$row['address']."' target='_blank'><i class='fa fa-download'></i></a>";
									}else{
										echo "<td><a href='".$row['address']."' target='_blank'><i class='fa fa-download'></i></a></td>";
									}
									echo "</tr>
									<tr class='collapse order".$row['id']."'>
									  <td colspan='3'><b>Autor:</b> ".$row['author']."<br>
									  <b>Nahráno:</b> ".$findate."<br>
									  <b>Popis:</b> ".$row['descript']."<br>
									  <a href='file.php?action=del&id=".$row['id']."' class='btn btn-default'>Smazat</a>  <a href='file.php?action=arch&id=".$row['id']."' class='btn btn-default'>Archivovat</a>  ";
										if(file_exists($row['address'])){
											echo "<a href='file.php?action=down&file=".$row['address']."' target='_blank' class='btn btn-default'>Stáhnout</a>  <a href='".$row['address']."' target='_blank' class='btn btn-default'>Otevřít</a>";
										}else{
											echo "<a href='".$row['address']."' target='_blank' class='btn btn-default'>Navštívit</a>";
										}
									  echo "
									  </td>
									</tr>";
								}
								
							// Writers view
							}elseif(($_SESSION['permission'])=="w"){
								echo "<thead>
										  <tr>
											<th>PŘ.</th>
											<th>NÁZEV</th>
											<th><i class='fa fa-download'></i></th>
										  </tr>
									</thead>";
								while ($row = mysqli_fetch_array($query)){
									
									$datestr = strtotime($row['date']);
									$findate = date('d. m. Y H:i:s', $datestr);
									
									echo "<tr data-toggle='collapse' data-target='.order".$row['id']."'>
											<td>".$row['subject']."</td>
											<td>".$row['name']."</td>";	
									if(file_exists($row['address'])){
										echo "<td><a href='file.php?action=down&file=".$root.$row['address']."' target='_blank'><i class='fa fa-download'></i></a>";
									}else{
										echo "<td><a href='".$row['address']."' target='_blank'><i class='fa fa-download'></i></a></td>";
									}
									echo "</tr>
									<tr class='collapse order".$row['id']."'>
									  <td colspan='3'><b>Autor:</b> ".$row['author']."<br>
									  <b>Nahráno:</b> ".$findate."<br>
									  <b>Popis:</b> ".$row['descript']."<br>";
									
									if (($row['author'])==($_SESSION['username']))
									  echo "<a href='file.php?action=arch&id=".$row['id']."' class='btn btn-default'>Archivovat</a>";
									  if(file_exists($row['address'])){
											echo "<a href='file.php?action=down&file=".$root.$row['address']."' target='_blank' class='btn btn-default'>Stáhnout</a> <a href='".$root.$row['address']."' target='_blank' class='btn btn-default'>Otevřít</a>";
										}else{
											echo " <a href='".$row['address']."' target='_blank' class='btn btn-default'>Navštívit</a>";
										}
									  echo "</td>
									</tr>";
									}	
							}else{
								
							// View for everybody
								echo "<thead>
										  <tr>
											<th>PŘ.</th>
											<th>NÁZEV</th>
											<th><i class='fa fa-download'></i></th>
										  </tr>
									</thead>";
								while ($row = mysqli_fetch_array($query)){
									
									$datestr = strtotime($row['date']);
									$findate = date('d. m. Y H:i:s', $datestr);
									
									echo "<tr data-toggle='collapse' data-target='.order".$row['id']."'>
											<td>".$row['subject']."</td>
											<td>".$row['name']."</td>";	
									if(file_exists($row['address'])){
										echo "<td><a href='file.php?action=down&file=".$root.$row['address']."' target='_blank'><i class='fa fa-download'></i></a>";
									}else{
										echo "<td><a href='".$row['address']."' target='_blank'><i class='fa fa-download'></i></a></td>";
									}
									echo "</tr>
									<tr class='collapse order".$row['id']."'>
									  <td colspan='3'><b>Autor:</b> ".$row['author']."<br>
									  <b>Nahráno:</b> ".$findate."<br>
									  <b>Popis:</b> ".$row['descript']."<br>";
									  if(file_exists($row['address'])){
											echo "<a href='file.php?action=down&file=".$root.$row['address']."' target='_blank' class='btn btn-default'>Stáhnout</a> <a href='".$root.$row['address']."' target='_blank' class='btn btn-default'>Otevřít</a>";
										}else{
											echo " <a href='".$row['address']."' target='_blank' class='btn btn-default'>Navštívit</a>";
										}
									  echo "</td>
									</tr>";
								}
							}
						}else{
							// No records
							echo"</table><div class='centered'><h3>Nejsou k dispozici žádné výpisky</h3></div><table>";
						}
					?>
				</table>
			</div>
			<br>

			<?php
				// Upload option
				if(($_SESSION['permission']) == "o" || ($_SESSION['permission']) == "w" || ($_SESSION['permission']) == "u"){
					echo "<div class='centered'><a class='btn btn-default' href='upload.php'>Nahrát výpisky</a><br></div>";
				}
			?>
		</div>
		<br>
		<br>
		<div id="r">
			<div class="container">
				<div class="centered">
					<div class="col-lg-8 col-md-offset-2">
						<h4>POUZE AKTIVNÍ</h4>
						<p>Na této stránce se nachází pouze aktuální výpisky. Pokud nemůžete Vámi hledané výpisky najít zde, přejděte do sekce Archiv. Zde se nachází všechny starší výpisky. Pokud zde Váš soubor chybí, dejte nám vědět a my se pokusíme jej zde nahrát.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
		include("footer.php");
	 
		// Close connection
		mysqli_close($link);
	?>
  </body>
</html>