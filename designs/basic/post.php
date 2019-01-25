<?php
session_start();
if(isset($_SESSION['username'])){
    $text = $_POST['text'];
     
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'><b>".$_SESSION['username']."</b> <i>(".date("H:i").")</i>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($fp);
}
?>