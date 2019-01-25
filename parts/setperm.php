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
$password_err = '';
$user = $_SESSION['username'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	//checking fields
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	$confpassword = $_POST['confpassword'];
	
	//check old password
	include ('config.php');
	$queryget = mysqli_query($link, "SELECT password FROM login WHERE username='$user'") or die("Něco se nepovedlo.");
	$row = mysqli_fetch_assoc($queryget);
	$oldpassworddb = $row['password'];
	
	if ($oldpassword != $oldpassworddb){
		$password_err = "Napsané heslo se neshoduje se starým!";
	}else{
		
		//check newpassword and confpassword
		if ($newpassword != $confpassword){
			$password_err = "Nové heslo a jeho kontrola se neshodují!";
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

?>