<?php
session_start();

$filename = 'log.html';
if (file_exists($filename)) {
    if (date ("d.m.Y", filemtime($filename))!=date ("d.m.Y")){
		$fp = fopen("log.html", 'a');
		fwrite($fp, "<div class='strike'><span>".date ('d. M')."</span></div>");
		fclose($fp);
	}
}

if(isset($_SESSION['username'])){
	$type = $_POST['type'];
    $text = $_POST['text'];
	
	if($type == "txt"){     
		$fp = fopen("log.html", 'a');
		fwrite($fp, "<div class='msgln'><b>".$_SESSION['username']."</b> <i>(".date("H:i").")</i>: ".stripslashes(htmlspecialchars($text))."<br></div>");
		fclose($fp);}
		
	if($type == "href"){     
		$fp = fopen("log.html", 'a');
		fwrite($fp, "<div class='msgln'><b>".$_SESSION['username']."</b> <i>(".date("H:i").")</i>:<a href='".stripslashes(htmlspecialchars($text))."'> ".stripslashes(htmlspecialchars($text))."</a><br></div>");
		fclose($fp);}
		
	if($type == "img"){     
		$fp = fopen("log.html", 'a');
		fwrite($fp, "<div class='msgln'><b>".$_SESSION['username']."</b> <i>(".date("H:i").")</i>:<img width='200px' alt=' Obrázek se nepodařilo zobrazit.' src='".stripslashes(htmlspecialchars($text))."' /> <br></div>");
		fclose($fp);}
}
?>