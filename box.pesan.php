<?php
error_reporting(0);
session_start();
require"./koneksi.php";
$pdo=koneksi::conn(); //buka koneksi
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($_POST[tipe]=="tutup"){
	$update="update pesan set tampil=0 where user1='$_SESSION[username]' and user2='$_POST[u]'";$ekse=$pdo->prepare($update);$ekse->execute();
}elseif($_POST[tipe]=="cek"){ //cek pesan masuk..

$query="select pengirim from isi_pesan where penerima='$_SESSION[username]' and dibaca=0";$pre=$pdo->prepare($query);$pre->execute();$cek=(int) $pre->fetch(PDO::FETCH_NUM);
if($cek>0){ //jika pesan masuk box belum ditampilkan
	$load="select a.pengirim,a.penerima,b.id_pesan from isi_pesan a,pesan b where a.penerima='$_SESSION[username]' and a.penerima=b.user1  and a.dibaca=0 and b.tampil=0 and b.buka=0 group by a.penerima";
	foreach($pdo->query($load) as $r){
		$q="select count(a.id_pesan) jml from isi_pesan a where a.penerima='$_SESSION[username]' and a.pengirim='$r[pengirim]' and a.dibaca=0";$pra=$pdo->prepare($q);$pra->execute();$jml=$pra->fetch(PDO::FETCH_ASSOC);
?>
			<div class="box tampil" id="<?php echo"$r[pengirim]"; ?>">
				<div class="box-atas">
					<h4 class="nama" onclick="hide('<?php echo"$r[pengirim]"; ?>')"><?php echo"$r[pengirim]"; ?></h4>
					<div class="pilihan">
						<span onclick="hide('<?php echo"$r[pengirim]"; ?>')">-</span>
						<span onclick="tutup('<?php echo"$r[pengirim]"; ?>')">x</span>
					</div>
					<div class="alert-chat"><?php echo $jml[jml]; ?></div>
				</div>
				<div class="box-chat" style="display:none">
					<div class="last-chat"></div>
				</div>
				<div class="box-send" style="display:none">
					<form action="" method="POST" onsubmit="return send()">
						<textarea class="pesan _552m" onkeydown="chat(event,'<?php echo $r[pengirim]; ?>')" name="pesan" style="height: 15px;"></textarea>
					</form>
				</div>
			</div>
			<script>load("<?php echo $r[pengirim]; ?>");</script>
<?php
	$update="update pesan set tampil=1 where user1='$_SESSION[username]' and user2='$r[pengirim]'";$ekse=$pdo->prepare($update);$ekse->execute();
	}
}

}elseif($_POST[tipe]=="buka"){ //membuka box
	$update="update pesan set buka='$_POST[buka]' where user1='$_SESSION[username]' and user2='$_POST[user]'";$ekse=$pdo->prepare($update);$ekse->execute();
	
}else{
$query="select * from pesan where user2='$_POST[u]' and user1='$_SESSION[username]'";$pre=$pdo->prepare($query);$pre->execute();$cek=$pre->fetch(PDO::FETCH_NUM);
if($cek>0){
	if($_POST[buka]==0){
?>
			<div class="box tampil" id="<?php echo"$_POST[u]"; ?>">
				<div class="box-atas">
					<h4 class="nama" onclick="hide('<?php echo"$_POST[u]"; ?>')"><?php echo"$_POST[u]"; ?></h4>
					<div class="pilihan">
						<span onclick="hide('<?php echo"$_POST[u]"; ?>')">-</span>
						<span onclick="tutup('<?php echo"$_POST[u]"; ?>')">x</span>
					</div>
					<div class="alert-chat" style="display:none"></div>
				</div>
				<div class="box-chat">
					<div class="last-chat"></div>
				</div>
				<div class="box-send">
					<form action="" method="POST" onsubmit="return send()">
						<textarea class="pesan _552m" onkeydown="chat(event,'<?php echo $_POST[u]; ?>')" name="pesan" style="height: 15px;"></textarea>
					</form>
				</div>
			</div>
			<script>load("<?php echo $_POST[u]; ?>");</script>
<?php
	$update="update pesan set tampil=1,buka=1 where user1='$_SESSION[username]' and user2='$_POST[u]'";$ekse=$pdo->prepare($update);$ekse->execute();
	}elseif($_POST[buka]==0){
?>
				<div class="box-chat">
					<div class="last-chat"></div>
				</div>
				<div class="box-send">
					<form action="" method="POST" onsubmit="return send()">
						<textarea class="pesan _552m" onkeydown="chat(event,'<?php echo $_POST[u]; ?>')" name="pesan" style="height: 15px;"></textarea>
					</form>
				</div>
				<script>load("<?php echo $_POST[u]; ?>");</script>
<?php
	}
}elseif($_POST[tipe]=="show"){
$q="select user1,user2,id_pesan from pesan where user1='$_SESSION[username]' and user2='$_POST[user]'";$pra=$pdo->prepare($q);$pra->execute();$r=$pra->fetch(PDO::FETCH_ASSOC);	
?>
			<div class="box tampil buka" id="<?php echo"$r[user2]"; ?>">
				<div class="box-atas">
					<h4 class="nama" onclick="hide('<?php echo"$r[user2]"; ?>')"><?php echo"$r[user2]"; ?></h4>
					<div class="pilihan">
						<span onclick="hide('<?php echo"$r[user2]"; ?>')">-</span>
						<span onclick="tutup('<?php echo"$r[user2]"; ?>')">x</span>
					</div>
					<div class="alert-chat" style="display:none"></div>
				</div>
				<div class="box-chat">
					<div class="last-chat"></div>
				</div>
				<div class="box-send">
					<form action="" method="POST" onsubmit="return send()">
						<textarea class="pesan _552m" onkeydown="chat(event,'<?php echo $r[user2]; ?>')" name="pesan" style="height: 15px;"></textarea>
					</form>
				</div>
			</div>
<?php
	$query="update pesan set tampil=1,buka=1 where id_pesan='$r[id_pesan]'";$pre=$pdo->prepare($query);$pre->execute();
}else{
$query="insert into pesan values(null,'$_SESSION[username]','$_POST[u]',0,0),(null,'$_POST[u]','$_SESSION[username]',0,0)";$pre=$pdo->prepare($query);$pre->execute();
?>
			<div class="box tampil" id="<?php echo"$_POST[u]"; ?>">
				<div class="box-atas">
					<h4 class="nama" onclick="hide('<?php echo"$_POST[u]"; ?>')"><?php echo"$_POST[u]"; ?></h4>
					<div class="pilihan">
						<span onclick="hide('<?php echo"$_POST[u]"; ?>')">-</span>
						<span onclick="tutup('<?php echo"$_POST[u]"; ?>')">x</span>
					</div>
					<div class="alert-chat" style="display:none"></div>
				</div>
				<div class="box-chat">
					<div class="last-chat"></div>
				</div>
				<div class="box-send">
					<form action="" method="POST" onsubmit="return send()">
						<textarea class="pesan _552m" onkeydown="chat(event,'<?php echo $_POST[u]; ?>')" name="pesan" style="height: 15px;"></textarea>
					</form>
				</div>
			</div>
			<script>load("<?php echo $_POST[u]; ?>");</script>
<?php
	$update="update pesan set tampil=1,buka=1 where user1='$_SESSION[username]' and user2='$_POST[u]'";$ekse=$pdo->prepare($update);$ekse->execute();
}
}
?>
