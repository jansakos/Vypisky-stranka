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
?>

<?php
$diarpermlevel = $_SESSION['permission'];

//pg select
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 0;
}

//db config
include('config.php');

//rm event
if($diarpermlevel == "o"){
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
        $namet = substr($name, 0, 30);
        if(is_numeric($type)){
            $typet = substr($type, 0, 1);
            if(strlen($date) == 10){
                //$dateyear = substr($date, 0, 4);
                $datemon = substr($date, 5, 2);
                $dateday = substr($date, 8, 2);
                $datepar = intval($dateday).". ".intval($datemon).".";
                if($subj == "c" || $subj == "m" || $subj == "a" || $subj == "d" || $subj == "hv" || $subj == "vv" || $subj == "f" || $subj == "in" || $subj == "n" || $subj == "s" || $subj == "fr" || $subj == "tv" || $subj == "bi" || $subj == "z" || $subj == "ch" || $subj == "sv"){
                    if(!empty($_POST['othtype'])){
                        $othtype = $_POST['othtype'];
                        if(mysqli_num_rows(mysqli_query($link, "SELECT * FROM `diar` WHERE date='".$datepar."' AND subj='".$subj."' AND type='".$typet."' AND name='".$namet."' AND othtype='".$othtype."'")) != 0){
                            $diarmsg = "Událost již existuje";
                            $diarmsgc = "lightcoral";
                        }else{
                            mysqli_query($link, "INSERT into diar (date, subj, type, name, othtype) VALUES ('".$datepar."', '".$subj."', '".$typet."', '".$namet."', '".$othtype."')");
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
            return "SubjErr";
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
        default:
            return "TypeErr";
            break;
    }
}

//compute week, page listing
$today = date("j.n.");
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