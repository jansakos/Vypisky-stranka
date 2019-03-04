<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
if(($_SESSION['permission']) == "n"){
	header("location: index.php");
	exit;
}

	//Funkce pro vytváření miniatur
class SimpleImage {

   var $image;
   var $image_type;

   function load($filename) {

      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {

         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {

         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {

         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image,$filename);
      }
      if( $permissions != null) {

         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image);
      }
   }
   function getWidth() {

      return imagesx($this->image);
   }
   function getHeight() {

      return imagesy($this->image);
   }
   function resizeToHeight($height) {

      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }

   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }

   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }

   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }      

}
?>
<?php
	include("config.php");
 
 //case posílání obrázků
if (isset($_FILES) && !empty($_FILES)) {

    $image = $_FILES['fileName'];
    // kontrola INI chyb
    if ($image['error'] !== 0) {
        if ($image['error'] === 1) 
            throw new Exception('Převýšena max. velikost obrázku.');
        throw new Exception('INI error.');
    }
    // existence souboru
    if (!file_exists($image['tmp_name']))
        throw new Exception('Obrázek nebyl umístěn na server.');
    $maxFileSize = 5000000; // v bytech
    if ($image['size'] > $maxFileSize)
        throw new Exception('Převýšena max. velikost obrázku (5MB).'); 
    // je soubor obrázek
    $imageData = getimagesize($image['tmp_name']);
    if (!$imageData) 
        throw new Exception('Neplatný obrázek.');
    $mimeType = $imageData['mime'];
    // ověření MIME
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mimeType, $allowedMimeTypes)) 
        throw new Exception('Je povoleno nahrávat pouze JPG, PNG a GIF.');
    
    // získání přípony souboru
    $fileExtention = strtolower(pathinfo($image['name'] ,PATHINFO_EXTENSION));
    // výroba náhodného jména
    $fileName = round(microtime(true)) . mt_rand() . '.' . $fileExtention; // anyfilename.jpg
	
	//MOŽNÁ CHYBA - MÁ BÝT Z ROOTU
    $path = $root . $fileName;
    // kam uložit na serveru
    $destination = $_SERVER['DOCUMENT_ROOT'] . $path;

    if (!move_uploaded_file($image['tmp_name'], $destination))
        throw new Exception('Nastala chyba při přesouvání souboru.');
	
	//Vytvoření miniatury
	$target_dir = $_SERVER['DOCUMENT_ROOT'] . $root;
    $target_file = $target_dir . $fileName . '.min';

    $image = new SimpleImage();
    $image->load($destination);
    $image->resize(100, 100);
    $image->save($target_file);
			
    // vytvoření odkazu + vložení do databáze
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
    $domain = $protocol . $_SERVER['SERVER_NAME'];
    $url = $domain . $path;	
	$query = "INSERT INTO chat (user, message, type) VALUES (?,?,?)";
	$stmt= $pdo->prepare($query);
	$run = $stmt->execute([$_SESSION['username'], $fileName, "2"]);
			if( $run ){
				echo 1;
				exit;
			};
} 

if(isset($_REQUEST['action'])){
	switch( $_REQUEST['action'] ) {
		
		//poslání zprávy
		case "sendMessage":
		
			$text = stripslashes(htmlspecialchars($_REQUEST['message']));
			
				//DETEKCE URL
				$reg_exUrl = "/(http|https|ftp|ftps|sftp|gopher|mailto|telnet)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
				if(preg_match($reg_exUrl, $text, $url)) {
					$text = preg_replace($reg_exUrl, "<u><a href=".$url[0].">".$url[0]."</a></u> ", $text);
				}
				
			$query = "INSERT INTO chat (user, message) VALUES (?,?)";
			$stmt= $pdo->prepare($query);
			$run = $stmt->execute([$_SESSION['username'], $text]);
			if( $run ){
				echo 1;
				exit;
			};
		break;
		
		//získání zpráv z db
		case "getMessages":
			$query = "SELECT * FROM chat ORDER BY id";
			$stmt= $pdo->prepare($query);
			$run = $stmt->execute();
			
			$rs = $stmt->fetchAll(PDO::FETCH_OBJ);
			
			$chat="";
			$date="";
			
			foreach( $rs as $message ){
				if ($date == date('d.m.Y', strtotime($message->date))){
				}else{
					$date=date('d.m.Y', strtotime($message->date));
					$chat .= '<div class="strike"><span>'.date('d. M', strtotime($message->date)).'</span></div>';
				}
				//listování textu
				if (($message->type)== "1"){
				$chat .= '<div class="single-message '.(($_SESSION['username']==$message->user)?'right':'left').'">
				<strong>'.$message->user.':</strong> <span>'.date('G:i', strtotime($message->date)).'</span>'.(($_SESSION['permission']=="o")?"<a href='messages.php?action=delMessage&id=".$message->id."'<i class='fa fa-trash-o'></i></a>":"").'<br> '.$message->message.'
							</div><div class="clear"></div>';
				}
				//listování obrázků
				if (($message->type)== "2"){
				$chat .= '<div class="single-picture '.(($_SESSION['username']==$message->user)?'right':'left').'">
				<strong>'.$message->user.':</strong> <span>'.date('G:i', strtotime($message->date)).'</span>'.(($_SESSION['permission']=="o")?"<a href='messages.php?action=delMessage&id=".$message->id."'<i class='fa fa-trash-o'></i></a>":"").'<br> <a href="assets/files/obrazky/'.$message->message.'"  target="_blank"><img src="assets/files/obrazky/'.$message->message.'.min" alt="Obrázek se nepovedlo načíst"></a>
							</div><div class="clear"></div>';
				}
				
			}
			echo $chat;
		break;
		
		//mazání zpráv
		case "delMessage":
		
			if (($_SESSION['permission']) == "o"){
				
				$query = "SELECT * FROM chat WHERE id =  :id";
				$stmt= $pdo->prepare($query);
				$stmt->bindParam(':id', $_REQUEST['id'], PDO::PARAM_INT);   
				$run = $stmt->execute();
				$rs = $stmt->fetchAll(PDO::FETCH_OBJ);
				
				//mazání obrázků z úložiště
				foreach( $rs as $message ){
					if (($message->type) == "2"){
						unlink ("assets/files/obrazky/".($message->message));
						unlink ("assets/files/obrazky/".($message->message).'.min');
					}
				}
				
				$sql = "DELETE FROM chat WHERE id =  :id";
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':id', $_REQUEST['id'], PDO::PARAM_INT);   
				$stmt->execute();
				if( $stmt ){
					header("location: chat.php");
					exit;
				}
			}else{
				header("location: chat.php");
				exit;
			}
			
		break;
	}
}
?>