<?php
	include("/parts/doperm.php");
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
  <?php
	include("/parts/head.php");
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
	
	<div class="container wb">
		<div class="centered">
			<br><br>
				<h3>VÝPISKY KE STAŽENÍ</h3><br>
		</div>
	</div>
  
	<?php
		if (mysqli_num_rows($query)!=0){
			echo '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" style="margin-left:20px" type="button" data-toggle="dropdown" >Seřadit dle
				<span class="caret"></span></button>';
			include("/parts/dorder.php");
			echo '</div>';
			}
	?>
  
	<div class="container-w">
	
	<div class="table-responsive">
		<table class="table table-hover">
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
		<th>PŘ</th>
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
        <th>PŘ</th>
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
			echo"<div class='centered'><h3>Nejsou k dispozici žádné výpisky</h3></div>";
			}
		?>
		</table><br>

		<?php
			if(($_SESSION['permission']) == "o" || ($_SESSION['permission']) == "w" || ($_SESSION['permission']) == "u"){
		echo "<div class='centered'><a type='button' class='btn btn-primary btn-sm' href='upload.php'>Nahrát výpisky</a><br></div>";
			}
?>
		<div class="centered">
		<h3><a href="http://archiv-vypisky.chytrak.cz">Archiv starších výpisků</a><h3><br>
		</div></div>
	</div>
	
	
	<div id="r">
		<div class="container">
			<div class="centered">
				<div class="col-lg-8 col-md-offset-2">
					<?php
						include("/parts/dofoot.php");
					?>
				</div>
			</div>
		</div>
	</div>
	

	<?php
     include("footer.php");
	?>
	
  </body>
</html>