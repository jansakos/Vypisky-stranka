<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
if (isset($_SESSION['first'])){
	if ($_SESSION['first'] == '1') {
	header("location: first.php");
	}
}

switch ($_SESSION['permission']) {
    case "o":
        $diarpermlevel = 2;
        break;
    case "w":
        $diarpermlevel = 1;
        break;
    default:
        $diarpermlevel = 0;
        break;
}
//pg select
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 0;
}

//db config
include('config.php');

//rm event
if($diarpermlevel >= 2){
    if(isset($_GET['rmid'])){
        mysqli_query($link, "DELETE from diar WHERE id=".$_GET['rmid']);
        if(mysqli_affected_rows($link) == 1){
            $diarmsg = "Událost úspěšně odebrána";
            $diarmsgc = "lightgreen";
        }else{
            $diarmsg = "Událost nelze odebrat";
            $diarmsgc = "lightcoral";
        }
    }
}

//add event
if(isset($_POST['addevent'])){
    if(isset($_POST['addevent']) && isset($_POST['date']) && isset($_POST['subj']) && isset($_POST['type']) && isset($_POST['name'])){
        $name = $_POST['name'];
        $subj = $_POST['subj'];
        $type = $_POST['type'];
        $date = $_POST['date'];
        $namet = htmlspecialchars(substr($name, 0, 30));
        if(is_numeric($type)){
            $typet = substr($type, 0, 1);
            if(strlen($date) == 10){
                //$dateyear = substr($date, 0, 4);
                $datemon = substr($date, 5, 2);
                $dateday = substr($date, 8, 2);
                $datepar = intval($dateday).". ".intval($datemon).".";
                if($subj == "c" || $subj == "m" || $subj == "a" || $subj == "d" || $subj == "hv" || $subj == "vv" || $subj == "f" || $subj == "in" || $subj == "n" || $subj == "s" || $subj == "fr" || $subj == "tv" || $subj == "bi" || $subj == "z" || $subj == "ch" || $subj == "sv"){
                    if(!empty($_POST['othtype'])){
                        $othtypet = htmlspecialchars(substr($_POST['othtype'], 0, 20));
                        if(mysqli_num_rows(mysqli_query($link, "SELECT * FROM `diar` WHERE date='".$datepar."' AND subj='".$subj."' AND type='".$typet."' AND name='".$namet."' AND othtype='".$othtypet."'")) != 0){
                            $diarmsg = "Událost již existuje";
                            $diarmsgc = "lightcoral";
                        }else{
                            mysqli_query($link, "INSERT into diar (date, subj, type, name, othtype) VALUES ('".$datepar."', '".$subj."', '".$typet."', '".$namet."', '".$othtypet."')");
                            $diarmsg = "Událost přidána";
                            $diarmsgc = "lightgreen";
                        }
                    }else{
                        if(mysqli_num_rows(mysqli_query($link, "SELECT * FROM `diar` WHERE date='".$datepar."' AND subj='".$subj."' AND type='".$typet."' AND name='".$namet."'")) != 0){
                            $diarmsg = "Událost již existuje";
                            $diarmsgc = "lightcoral";
                        }else{
                            mysqli_query($link, "INSERT into diar (date, subj, type, name) VALUES ('".$datepar."', '".$subj."', '".$typet."', '".$namet."')");
                            $diarmsg = "Událost přidána";
                            $diarmsgc = "lightgreen";
                        }
                    }
                }else{
                    $diarmsg = "Nelze zpracovat předmět";
                    $diarmsgc = "lightcoral";
                }
            }else{
                $diarmsg = "Nelze zpracovat datum";
                $diarmsgc = "lightcoral";
            }
        }else{
            $diarmsg = "Nelze zpracovat typ";
            $diarmsgc = "lightcoral";
        }
    }else{
        $diarmsg = "Nebyly přijaty požadované informace";
        $diarmsgc = "lightcoral";
    }
}

//predmety na realname
function subjname($subjdbname){
    switch($subjdbname){
        case "c":
            return "Čeština";
            break;
        case "m":
            return "Matematika";
            break;
        case "a":
            return "Angličtina";
            break;
        case "d":
            return "Dějepis";
            break;
        case "hv":
            return "Hudebka";
            break;
        case "vv":
            return "Výtvarka";
            break;
        case "f":
            return "Fyzika";
            break;
        case "in":
            return "Informatika";
            break;
        case "n":
            return "Němčina";
            break;
        case "s":
            return "Španělština";
            break;
        case "fr":
            return "Francouzština";
            break;
        case "tv":
            return "Tělocvik";
            break;
        case "bi":
            return "Biologie";
            break;
        case "z":
            return "Zeměpis";
            break;
        case "ch":
            return "Chemie";
            break;
        case "sv":
            return "Společenské vědy";
            break;
        default:
            return "Neznámý předmět (".$subjdbname.")";
            break;
    }
}

//typy na realname
function typename($typedbnum){
    switch($typedbnum){
        case 0:
            return "Písemka";
            break;
        case 1:
            return "Dopisování";
            break;
        case 2:
            return "Dozkušování";
            break;
        case 3:
            return "Jiné";
            break;
        case 4:
            return "Státní svátek";
            break;
        case 5:
            return "Prázdniny";
            break;
        case 6:
            return "Olympiáda";
            break;
        case 7:
            return "Exkurze";
            break;
        case 8:
            return "Úkol";
            break;
        default:
            return "Neznámý typ (".$typedbnum.")";
            break;
    }
}

//compute week, page listing
$today = date("j. n.");
$weekday = date("N");
switch($page){
    case 0:
        switch($weekday){
            case 1:
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+1 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+2 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+3 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+4 day');
                
                $mondate = $today;
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 2:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-1 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+1 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+2 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+3 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $today;
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 3:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-2 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-1 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+1 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+2 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $today;
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 4:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-3 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-2 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('-1 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+1 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $today;
                $fridate = $fridateseek->format('j. n.');
                break;
            case 5:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-4 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-3 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('-2 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('-1 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $today;
                break;
            case 6:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('+2 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+3 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+4 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+5 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+6 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                
                $todayseek = new DateTime('tomorrow');
                $todayseek->modify('+1 day');
                $today = $todayseek->format('j. n.');
                $weekday = 1;
                break;
            case 7:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('+1 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+2 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+3 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+4 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+5 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                
                $todayseek = new DateTime('tomorrow');
                $today = $todayseek->format('j. n.');
                $weekday = 1;
                break;
            default:
                break;
        }
        break;
    case -1:
        switch($weekday){
            case 1:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-7 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-6 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('-5 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('-4 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('-3 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 2:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-8 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-7 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('-6 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('-5 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('-4 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 3:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-9 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-8 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('-7 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('-6 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('-5 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 4:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-10 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-9 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('-8 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('-7 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('-6 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 5:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-11 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-10 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('-9 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('-8 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('-7 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 6:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-5 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-4 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('-3 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('-2 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('-1 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                
                $todayseek = new DateTime('tomorrow');
                $todayseek->modify('+1 day');
                $today = $todayseek->format('j. n.');
                $weekday = 1;
                break;
            case 7:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('-6 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('-5 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('-4 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('-3 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('-2 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                
                $todayseek = new DateTime('tomorrow');
                $today = $todayseek->format('j. n.');
                $weekday = 1;
                break;
            default:
                break;
        }
        break;
    case 1:
        switch($weekday){
            case 1:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('+7 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+8 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+9 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+10 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+11 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 2:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('+6 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+7 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+8 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+9 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+10 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 3:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('+5 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+6 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+7 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+8 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+9 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 4:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('+4 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+5 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+6 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+7 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+8 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 5:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('+3 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+4 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+5 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+6 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+7 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                break;
            case 6:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('+9 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+10 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+11 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+12 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+13 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                
                $todayseek = new DateTime('tomorrow');
                $todayseek->modify('+1 day');
                $today = $todayseek->format('j. n.');
                $weekday = 1;
                break;
            case 7:
                $mondateseek = new DateTime('today');
                $mondateseek->modify('+8 day');
                $tuedateseek = new DateTime('today');
                $tuedateseek->modify('+9 day');
                $weddateseek = new DateTime('today');
                $weddateseek->modify('+10 day');
                $thudateseek = new DateTime('today');
                $thudateseek->modify('+11 day');
                $fridateseek = new DateTime('today');
                $fridateseek->modify('+12 day');
                
                $mondate = $mondateseek->format('j. n.');
                $tuedate = $tuedateseek->format('j. n.');
                $weddate = $weddateseek->format('j. n.');
                $thudate = $thudateseek->format('j. n.');
                $fridate = $fridateseek->format('j. n.');
                
                $todayseek = new DateTime('tomorrow');
                $today = $todayseek->format('j. n.');
                $weekday = 1;
                break;
            default:
                break;
        }
        break;
    default:
        header('Location: ?page=0');
        break;
}

//select all days
$monevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$mondate."'");
$tueevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$tuedate."'");
$wedevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$weddate."'");
$thuevents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$thudate."'");
$frievents = mysqli_query($link, "SELECT * FROM diar WHERE date='".$fridate."'");
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
	?>
    <title>Úvod | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="assets/css/index.css" rel="stylesheet">
	<link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/notif.js"></script>
	<script>
            function tothtype(){
                if(document.getElementById('type')[document.getElementById('type').selectedIndex].value == 3){
                    document.getElementById('othtype').removeAttribute('hidden');
                }else{
                    document.getElementById('othtype').setAttribute('hidden', '');
                }
            }
    </script>
  </head>

	  <body class="x-body">
		<?php
		 include("header.php");
		?>	
			<div class="content">
		<?php 
			include("config.php");
			
			$query = "DELETE FROM notif WHERE exp < CURDATE()";
				$stmt= $pdo->prepare($query);
				$run = $stmt->execute();
			
			$query = "SELECT * FROM notif ORDER BY id";
				$stmt= $pdo->prepare($query);
				$run = $stmt->execute();
				
				$rs = $stmt->fetchAll(PDO::FETCH_OBJ);
				
				$notifall="";
				
				foreach( $rs as $notif ){
					
					if(($_SESSION['username']) == $notif->tothe || $notif->tothe == ""){

						if (($notif->type)== "1"){
							$notifall .= '<div class="alert alert-info">'.$notif->text.'</div>';
						}
						if (($notif->type)== "2"){
							$notifall .= '<div class="alert alert-warning">'.$notif->text.'</div>';
						}
						if (($notif->type)== "3"){
							$notifall .= '<div class="alert alert-danger">'.$notif->text.'</div>';
						}
						if (($notif->type)== "4"){
							$expdate = strtotime($notif->exp);
							$formdate = date( 'd. m. Y', $expdate );
							$notifall .= '<div class="alert alert-danger"><strong>Plánovaný výpadek:</strong> Dne '.$formdate.' z důvodu: '.$notif->text.' </div>';
						}
						if (($notif->type)== "5"){
							$notifall .= '<div class="alert alert-success">'.$notif->text.'</div>';
						}
						if (($notif->type)== "6"){
							$bandate = strtotime($notif->exp);
							$formban = date( 'd. m. Y', $bandate );
							$notifall .= '<div class="alert alert-danger"><strong>Ban:</strong> do dne '.$formban.' z důvodu: '.$notif->text.' </div>';
						}
					}
				}
			echo $notifall;
		?>
		
		<div class="container">
		<fieldset style="margin: 0 auto;">
				<legend>Diář</legend>
				<?php if($diarpermlevel >= 0){ ?>
				<div class="diar">
					<div class="dbody">
						<div class="dframe">
							<?php if($page-1 >= -1){ ?><a class="leftarrow" href="?page=<?php echo $page-1; ?>"><i class="fa fa-chevron-left"></i></a><?php } ?>
							<?php if($page+1 <= 1){ ?><a class="rightarrow" href="?page=<?php echo $page+1; ?>"><i class="fa fa-chevron-right"></i></a><?php } ?>
							<?php if(isset($diarmsg)){ echo "<p class=\"diarmsg\" style=\"background-color: ".$diarmsgc.";\">".$diarmsg."</p>"; } ?>
							<noscript><p class="diarmsg" style="background-color: lightblue;">Pro všechny funkce je požadován JavaScript</p></noscript>
							<div class="dtable">
								<div class="day">
									<div class="head">
										<p><?php echo $mondate; ?></p><p>Po</p>
									</div>
									<?php for($i = 1;$i <= 5;$i++){ 
											while($monrow = mysqli_fetch_array($monevents)){ ?>
											<div class="event event<?php echo $monrow['type']; ?>">
												<?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $monrow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
												<div><p><?php echo subjname($monrow['subj']); ?></p><p><?php if($monrow['type'] == 3){ if(empty($monrow['othtype'])){ echo "Nespecifikováno"; }else{ echo $monrow['othtype']; } }else{ echo typename($monrow['type']); } ?></p><p><?php echo $monrow['name']; ?></p></div>
											</div>
									<?php }} ?>
								</div>
								<div class="day">
									<div class="head">
										<p><?php echo $tuedate; ?></p><p>Út</p>
									</div>
									<?php for($i = 1;$i <= 5;$i++){ 
											while($tuerow = mysqli_fetch_array($tueevents)){ ?>
											<div class="event event<?php echo $tuerow['type']; ?>">
												<?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $tuerow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
												<div><p><?php echo subjname($tuerow['subj']); ?></p><p><?php if($tuerow['type'] == 3){ if(empty($tuerow['othtype'])){ echo "Nespecifikováno"; }else{ echo $tuerow['othtype']; } }else{ echo typename($tuerow['type']); } ?></p><p><?php echo $tuerow['name']; ?></p></div>
											</div>
									<?php }} ?>
								</div>
								<div class="day">
									<div class="head">
										<p><?php echo $weddate; ?></p><p>St</p>
									</div>
									<?php for($i = 1;$i <= 5;$i++){ 
											while($wedrow = mysqli_fetch_array($wedevents)){ ?>
											<div class="event event<?php echo $wedrow['type']; ?>">
												<?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $wedrow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
												<div><p><?php echo subjname($wedrow['subj']); ?></p><p><?php if($wedrow['type'] == 3){ if(empty($wedrow['othtype'])){ echo "Nespecifikováno"; }else{ echo $wedrow['othtype']; } }else{ echo typename($wedrow['type']); } ?></p><p><?php echo $wedrow['name']; ?></p></div>
											</div>
									<?php }} ?>
								</div>
								<div class="day">
									<div class="head">
										<p><?php echo $thudate; ?></p><p>Čt</p>
									</div>
									<?php for($i = 1;$i <= 5;$i++){ 
											while($thurow = mysqli_fetch_array($thuevents)){ ?>
											<div class="event event<?php echo $thurow['type']; ?>">
												<?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $thurow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
												<div><p><?php echo subjname($thurow['subj']); ?></p><p><?php if($thurow['type'] == 3){ if(empty($thurow['othtype'])){ echo "Nespecifikováno"; }else{ echo $thurow['othtype']; } }else{ echo typename($thurow['type']); } ?></p><p><?php echo $thurow['name']; ?></p></div>
											</div>
									<?php }} ?>
								</div>
								<div class="day">
									<div class="head">
										<p><?php echo $fridate; ?></p><p>Pá</p>
									</div>
									<?php for($i = 1;$i <= 5;$i++){ 
											while($frirow = mysqli_fetch_array($frievents)){ ?>
											<div class="event event<?php echo $frirow['type']; ?>">
												<?php if($diarpermlevel >= 2){ ?><a class="remove" href="?rmid=<?php echo $frirow['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a><?php } ?>
												<div><p><?php echo subjname($frirow['subj']); ?></p><p><?php if($frirow['type'] == 3){ if(empty($frirow['othtype'])){ echo "Nespecifikováno"; }else{ echo $frirow['othtype']; } }else{ echo typename($frirow['type']); } ?></p><p><?php echo $frirow['name']; ?></p></div>
											</div>
									<?php }} ?>
								</div>
							</div>
						</div>
						<div class="legend">
							<p>Legenda</p>
							<div class="event0"><p>Písemka</p></div>
							<div class="event1"><p>Dopisování</p></div>
							<div class="event2"><p>Dozkušování</p></div>
							<div class="event8"><p>Úkol</p></div>
							<!--div class="event4"><p>Státní svátek</p></div>
							<div class="event5"><p>Prázdniny</p></div-->
							<div class="event6"><p>Olympiáda</p></div>
							<div class="event7"><p>Exkurze</p></div>
							<div class="event3"><p>Jiné</p></div>
						</div>
					</div>
					<?php if($diarpermlevel >= 1){ ?>
					<fieldset class="addevent">
						<legend>Přidat událost</legend>
						<form method="post" action="#">
							<p><label for="date">Datum</label> <input class="form-control" type="date" name="date" id="date" required /></p>
							<p><label for="subj">Předmět</label> 
								<select class="form-control" name="subj" id="subj" required>
									<option value="c">Č / Čcv</option>
									<option value="m">M / Mcv</option>
									<option value="a">A</option>
									<option value="d">D</option>
									<option value="f">F</option>
									<option value="hv">Hv</option>
									<option value="vv">Vv</option>
									<option value="in">In</option>
									<option value="n">N</option>
									<option value="s">Š</option>
									<option value="fr">Fr</option>
									<option value="tv">Tv</option>
									<option value="bi">Bi / Bicv</option>
									<option value="z">Z</option>
									<option value="ch">Ch / Chcv</option>
									<option value="sv">Sv</option>
								</select></p>
							<p><label for="type">Typ</label> 
								<select class="form-control" name="type" id="type" onchange="tothtype()" required>
									<option value="0">Písemka</option>
									<option value="1">Dopisování</option>
									<option value="2">Dozkušování</option>
									<option value="8">Úkol  </option>
									<!--option value="4">Státní svátek</option>
									<option value="5">Prázdniny</option-->
									<option value="6">Olympiáda</option>
									<option value="7">Exkurze</option>
									<option value="3">Jiné</option>
								</select> <input type="text" name="othtype" id="othtype" hidden maxlength="20" /></p>
							<p><label for="name">Téma</label> <input class="form-control" type="text" name="name" id="name" required maxlength="30" autocomplete="off" /></p>
							<p><input class="btn btn-primary" type="submit" name="addevent" value="Přidat událost" /></p>
						</form>
					</fieldset>
					<?php } ?>
				</div>
				<?php }else{ ?>
				<p>Na zobrazení diáře nemáte dostatečná práva</p>
				<?php } ?>
			</fieldset>
			</div>
		</div>
		<?php
     include("footer.php");
	?>

  </body>
</html>
<?php mysqli_close($link); ?>