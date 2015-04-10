<?php
error_reporting(0);
session_start();
require"./koneksi.php";
$pdo=koneksi::conn(); //buka koneksi
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($_POST[tujuan]=="send"){
	$qt="insert into isi_pesan values(null,'$_SESSION[username]','$_POST[kepada]','$_POST[pesan]',CURRENT_TIMESTAMP,0,0)";$tmp=$pdo->prepare($qt);$tmp->execute();
	echo"<div class='lchat'>$_POST[pesan]</div><div class='clear'></div>";
	
}elseif($_POST[tujuan]=="cek"){
	$qt="select * from isi_pesan where penerima='$_SESSION[username]' and pengirim='$_POST[id]' and dibaca=0";$tmp=$pdo->prepare($qt);$tmp->execute();$cek=$tmp->fetch(PDO::FETCH_NUM);
	if($cek>0){
		$qt="select * from isi_pesan where penerima='$_SESSION[username]' pengirim='$_POST[id]' and dibaca=0";$tmp=$pdo->prepare($qt);$tmp->execute();$r=$tmp->fetch(PDO::FETCH_ASSOC);
		echo"<div class='rchat'>$r[isi_pesan]</div><div class='clear'></div>";
		$qt="update isi_pesan set dibaca=1 where id_pesan='$r[id_pesan]'";$tmp2=$pdo->prepare($qt);$tmp2->execute();
	}else{
		
	}
}elseif($_POST[tujuan]=="cek2"){
	$qt="select * from isi_pesan where penerima='$_SESSION[username]' and pengirim='$_POST[user]' and dibaca=0";$tmp=$pdo->prepare($qt);$tmp->execute();$cek=$tmp->fetch(PDO::FETCH_NUM);
	if($cek>0){
		$qt="select count(id_pesan) jml from isi_pesan where penerima='$_SESSION[username]' and pengirim='$_POST[user]' and dibaca=0";$tmp=$pdo->prepare($qt);$tmp->execute();$r=$tmp->fetch(PDO::FETCH_ASSOC);
		echo"$r[jml]";
	}
}elseif($_POST[tujuan]=="load"){
	$load="select isi_pesan,penerima,pengirim,id_pesan from isi_pesan";
	foreach($pdo->query($load) as $r){
		if(($r[pengirim]=="$_SESSION[username]")&&($r[penerima]=="$_POST[user]")){
			echo"<div class='lchat'>$r[isi_pesan]</div><div class='clear'></div>";
			$bc="update isi_pesan set dibaca=1,tampil=1 where id_pesan='$r[id_pesan]'";$ekse=$pdo->prepare($bc);$ekse->execute();
		}elseif(($r[pengirim]=="$_POST[user]")&&($r[penerima]=="$_SESSION[username]")){
			echo"<div class='rchat'>$r[isi_pesan]</div><div class='clear'></div>";
			$bc="update isi_pesan set dibaca=1,tampil=1 where id_pesan='$r[id_pesan]'";$ekse=$pdo->prepare($bc);$ekse->execute();
		}
	}
	
}elseif($_POST[tujuan]=="autocek"){
	$load="select isi_pesan,penerima,pengirim,id_pesan from isi_pesan where dibaca=0 group by id_pesan";
	foreach($pdo->query($load) as $r){
		if(($r[pengirim]=="$_POST[user]")&&($r[penerima]=="$_SESSION[username]")){
			echo"<div class='rchat'>$r[isi_pesan]</div><div class='clear'></div>";
			$bc="update isi_pesan set dibaca=1,tampil=1 where id_pesan='$r[id_pesan]'";$ekse=$pdo->prepare($bc);$ekse->execute();
		}
	}
}elseif($_POST[tujuan]=="cek3"){ //cek jika ada pesan belum dibaca
	$query="select a.pengirim from isi_pesan a,pesan b where a.penerima='$_SESSION[username]' and a.penerima=b.user1 and b.tampil=0 and a.dibaca=0 group by a.id_pesan";$pre=$pdo->prepare($query);$pre->execute();$cek=(int) $pre->fetch(PDO::FETCH_NUM);
	if($cek>0){
		$query="select a.pengirim from isi_pesan a,pesan b where a.penerima='$_SESSION[username]' and a.penerima=b.user1 and b.tampil=0 and a.dibaca=0 group by a.id_pesan";$pre=$pdo->prepare($query);$pre->execute();$r=$pre->fetch(PDO::FETCH_ASSOC);
		echo"$r[pengirim]";
	}else{
		echo 0;
	}
}
?>
