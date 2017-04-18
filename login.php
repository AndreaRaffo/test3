<?php
session_start();
if(isset($_POST["name"]) && isset($_POST["password"])){
	
   $file = fopen('data.txt', 'r');
    $good=false;
    while(!feof($file)){
			$line = fgets($file);
			list($user, $pass) = explode(';', $line);
			if(trim($user) == $_POST['name'] && trim($pass) == $_POST['password']){
        	$good=true;
			break;
		}
	}

    if($good){
		if($_POST['autologin'] == 1){
		$hashed_password = password_hash(trim($pass), PASSWORD_DEFAULT);
		setcookie(trim($user),$hashed_password, time() + (3600 * 24 * 30),"Cookies"); //30 days
		}
		$_SESSION['name'] = $_POST["name"];
		header("Location: private.php");
		
    }else{
        $message="Try again";
		echo "<script> alert('$message'); </script>";
		include 'index.php';
    }
fclose($file);
}else{
    header("Location: index.php");
}
?>