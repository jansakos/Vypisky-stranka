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