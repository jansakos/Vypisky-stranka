<?php
$filename = basename($_GET['file']);

// Define downloaded file
$path = "./assets/files/vypisky/";
$download_file = $path.$filename;

// Download force
if(!empty($filename)){
	if(file_exists($download_file))
	{
		header("Content-Type: application/octet-stream"); 
		header("Content-Disposition: attachment; filename=".$filename);
		readfile($download_file);
		exit;
	}
	else
	{
		echo 'Nelze stahovat webové odkazy. Pokud se jedná o soubor, došlo k chybě.';
	}
}
?>