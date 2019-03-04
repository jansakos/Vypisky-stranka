<?php
include ('config.php');
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}		

$orderedBy = array('subject', 'name', 'author', 'id');
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
	include("parts/head.php");
  ?>
  <title>Ke stažení | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body>

    <?php
     include("header.php");
	?>
			<div class="centered">
				<h3>VÝPISKY KE STAŽENÍ</h3><br>
		</div>
  
	<?php
		if (mysqli_num_rows($query)!=0){
			echo '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" style="margin-left:20px" type="button" data-toggle="dropdown" >Seřadit dle
				<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<li><a class="dropdown-item" href="?orderedBy=subject">Předmětu</a></li>
				<li><a class="dropdown-item" href="?orderedBy=name">Názvu</a></li>
				<li><a class="dropdown-item" href="?orderedBy=id">Stáří</a></li>
				<li><a class="dropdown-item" href="?orderedBy=author">Autora</a></li>
			  </ul>
			</div>';
			}
	?>
  <br>
	<div class="container-w">
	
	<div class="table-responsive">
	<table class='table table-hover'>
		<?php
		if (mysqli_num_rows($query)!=0){
			$dir = "assets/files/vypisky/";
			$nofile = 0;
		
			$allFiles = scandir($dir);
			$files = array_diff($allFiles, array('.','..'));
			
			foreach($files as $file){$nofile = $nofile+1;}
			
			if(($_SESSION['permission'])=="o"){
				echo "<thead>
      <tr>
		<th>PŘ.</th>
        <th>NÁZEV</th>
		<th>AUTOR</th>
        <th><i class='fa fa-download'></i></th>
		<th><i class='fa fa-trash-o'></i></th>
      </tr>
    </thead>";
					while ($row = mysqli_fetch_array($query))
		{
			echo "<tr>
					<td>".$row['subject']."</td>
					<td>".$row['name']."</td>
					<td>".$row['author']."</td>	
					<td><a href='".$row['address']."'><i class='fa fa-download'></i></a></td>	
					<td><a href='delete.php?address=".$row['address']."'><i class='fa fa-trash-o'></i></a></td>";		
				echo '</tr>';
		}
				}
			else{
				echo "<thead>
      <tr>
        <th>PŘ.</th>
        <th>NÁZEV</th>
		<th>AUTOR</th>
        <th><i class='fa fa-download'></i></th>
      </tr>
    </thead>";
	
		while ($row = mysqli_fetch_array($query))
		{
			echo "<tr>
					<td>".$row['subject']."</td>
					<td>".$row['name']."</td>
					<td>".$row['author']."</td>	
					<td><a href='".$row['address']."'><i class='fa fa-download'></i></a></td>";	
				echo '</tr>';
		}
			}
		}else{
			echo"</table><div class='centered'><h3>Nejsou k dispozici žádné výpisky</h3></div><table>";
			}
		?>
		</table></div>
		<br>

		<?php
			if(($_SESSION['permission']) == "o" || ($_SESSION['permission']) == "w" || ($_SESSION['permission']) == "u"){
		echo "<div class='centered'><a class='btn btn-default' href='upload.php'>Nahrát výpisky</a><br></div>";
			}
?>
		<div class="centered">
		<h3><a href="http://archiv-vypisky.chytrak.cz">Archiv starších výpisků</a></h3><br>
		</div>
	</div>
	
	
	<div id="r">
		<div class="container">
			<div class="centered">
				<div class="col-lg-8 col-md-offset-2">
					<h4>POUZE AKTIVNÍ</h4>
					<p>Na této stránce se nachází pouze aktuální výpisky. Pokud nemůžete Vámi hledané výpisky najít zde, jděte na <a href="http://archiv-vypisky.chytrak.cz">Archiv Výpisků Jarošky</a>. Zde se nachází všechny starší výpisky. Pokud zde Váš soubor chybí, dejte nám vědět a my se pokusíme jej zde nahrát.</p>
				</div>
			</div>
		</div>
	</div>
	

	<?php
     include("footer.php");
	?>
	
  </body>
</html>