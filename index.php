<?php
/*
#Copyright by Hendra Randy Nomura
#09 Apr 2015
*/
	error_reporting(0);
	session_start();
	require"./koneksi.php";
	$pdo=koneksi::conn(); //buka koneksi
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if(isset($_POST[login])){
		$gb="select username from user where username='$_POST[username]' and password=md5('$_POST[password]')";$glob=$pdo->prepare($gb);$glob->execute();$cek=$glob->fetch(PDO::FETCH_NUM);
		if($cek>0){
			echo"<script>alert('Berhasil login')</script>";
			$gb="select username from user where username='$_POST[username]' and password=md5('$_POST[password]')";$glob=$pdo->prepare($gb);$glob->execute();$r=$glob->fetch(PDO::FETCH_ASSOC);
			$_SESSION[username]=$r[username];
			echo"<meta http-equiv='refresh' content='0; url=./chat.php'>";
		}else{
			echo"<script>alert('Gagal login')</script>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TES CHAT ONLINE</title>
</head>
<body>
	<form action="" method="POST">
		<table cellpadding=5>
			<tr>
				<td>Username</td><td>:</td><td><input type="text" name="username" /></td>
			</tr>
			<tr>
				<td>Password</td><td>:</td><td><input type="password" name="password" /></td>
			</tr>
			<tr>
				<td><input type="submit" name="login" value="Login"/></td>
			</tr>
		</table>
	</form>
</body>
</html>
