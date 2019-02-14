<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
if(($_SESSION['permission']) == "o"){
	header("location: adminset.php");
	exit;
} ?>

<?php
$passold_err = $passnew_err = $passcon_err = '';
$user = $_SESSION['username'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	//checking fields
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	$confpassword = $_POST['confpassword'];
	
	//check old password
	include ('config.php');
	$queryget = mysqli_query($link, "SELECT password FROM login WHERE username='$user'") or die("Neprobehlo uspesne pripojeni k databazi.");
	$row = mysqli_fetch_assoc($queryget);
	$oldpassworddb = $row['password'];
	
	if ($oldpassword != $oldpassworddb){
			$passold_err = "Napsané heslo se neshoduje se starým!";
		}else{
	
		if ($newpassword == ""){
			$passnew_err = "Nenapsali jste nové heslo!";
		}else{
	
			//check newpassword and confpassword
			if ($newpassword != $confpassword){
				$passcon_err = "Nové heslo a jeho kontrola se neshodují!";
			}else{
				
				if ($newpassword == $oldpassword){
					$passnew_err = "Nové heslo a staré heslo se shodují!";
				}else{
			
					//change password
					$querychange = mysqli_query($link, "
					UPDATE login SET password='$newpassword' WHERE username='$user'
					");
					session_destroy();
					header("location: login.php");
					exit;
				}
			}
		}
	}
}

?>