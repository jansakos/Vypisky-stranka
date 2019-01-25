<?php
		if (mysqli_num_rows($query)!=0){
			$dir = "../../assets/files/vypisky/";
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
					<td><a href='".$row['address']."'>STÁHNOUT</a></td>	
					<td><a href='delete.php?address=".$row['address']."'>SMAZAT</a></td>";		
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
					<td><a href='".$row['address']."'>STÁHNOUT</a></td>";	
				echo '</tr>';
		}
			}
		}else{
			echo"<div class='centered'><h3>Nejsou k dispozici žádné Výpisky</h3></div>";
			}
		?>
		</table><br>

		<?php
			if(($_SESSION['permission']) == "o" || ($_SESSION['permission']) == "w" || ($_SESSION['permission']) == "u"){
		echo "<div class='centered'><a href='upload.php'>Nahrát výpisky</a><br></div>";
			}
?>