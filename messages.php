<?php
	include("/parts/crperm.php");
?>
<?php
	include("config.php");

	switch( $_REQUEST['action'] ) {
		
		case "sendMessage":
			$query = "INSERT INTO chat (user, message) VALUES (?,?)";
			$stmt= $pdo->prepare($query);
			$run = $stmt->execute([$_SESSION['username'], $_REQUEST['message']]);
			if( $run ){
				echo 1;
				exit;
			};
		break;
		
		case "getMessages":
			$query = "SELECT * FROM chat";
			$stmt= $pdo->prepare($query);
			$run = $stmt->execute();
			
			$rs = $stmt->fetchAll(PDO::FETCH_OBJ);
			
			$chat="";
			foreach( $rs as $message ){
				$chat .= '<div class="single-message '.(($_SESSION['username']==$message->user)?'right':'left').'">
				<br><strong>'.$message->user.':</strong><br> '.stripslashes(htmlspecialchars($message->message)).'
				<br><span>'.date('G:i', strtotime($message->date)).'</span>
							</div><div class="clear"></div>';
			}
			echo $chat;
			
		break;
	}

?>