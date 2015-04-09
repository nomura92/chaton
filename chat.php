<?php
error_reporting(0);
session_start();
require"./koneksi.php";
$pdo=koneksi::conn(); //buka koneksi
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TES CHAT ONLINE</title>
<link rel="stylesheet" href="./css/style.css">
<script src="./js/jquery.js"></script>
<script>
function send(id){
	var data=$("#"+id).find(".pesan").val();
	if(data!=""){
		$.ajax({
			type: "POST", //definisikan aksinya (POST/GET)
			url: "./cek.pesan.php", //definisikan urlnya
			data: {"pesan":data,"tujuan":"send","kepada":id}, //data yang akan dikirim
			beforeSend: function(){}, //event yang akan dieksekusi sebelum pengiriman data
			complete: function(){}, //event yang akan dieksekusi setelah pengiriman data
			cache: false, //cache
			success: function(html){ //event yang akan dieksekusi setelah data berhasil dikirim
				$("#"+id).find(".last-chat").before(html);
				$("#"+id).find(".pesan").val("");
				$("#"+id).find(".last-chat").scrollBottom();
				refresh();
			},
			error: function(error){} //event yang akan diseksekusi pada saat error berlangsung
		});
	}
}
function load(id){
	$.ajax({
		type: "POST", //definisikan aksinya (POST/GET)
		url: "./cek.pesan.php", //definisikan urlnya
		data: {"tujuan":"load","user":id}, //data yang akan dikirim
		beforeSend: function(){}, //event yang akan dieksekusi sebelum pengiriman data
		complete: function(){}, //event yang akan dieksekusi setelah pengiriman data
		cache: false, //cache
		success: function(html){ //event yang akan dieksekusi setelah data berhasil dikirim
			$("#"+id).find(".last-chat").before(html);
			$("#"+id).find(".last-chat").scrollTop($(".box-chat").height());
		},
		error: function(error){} //event yang akan diseksekusi pada saat error berlangsung
	});
}
function cek(id){
	if($(".kotak-bawah").find(".box#"+id).hasClass("tampil")==true){ //box tampil
		if($("#"+id).hasClass("buka")==false){ // tidak terbuka
			$.ajax({
				type: "POST", //definisikan aksinya (POST/GET)
				url: "./cek.pesan.php", //definisikan urlnya
				data: {"tujuan":"cek2","user":id}, //data yang akan dikirim
				beforeSend: function(){}, //event yang akan dieksekusi sebelum pengiriman data
				complete: function(){}, //event yang akan dieksekusi setelah pengiriman data
				cache: false, //cache
				success: function(html){ //event yang akan dieksekusi setelah data berhasil dikirim
					if(html>0){
						$("#"+id).find(".alert-chat").css("display","block");
						$("#"+id).find(".alert-chat").text(html);
					}
					//alert(id);
				},
				error: function(error){} //event yang akan diseksekusi pada saat error berlangsung
			});
		}else{ //box terbuka
			$.ajax({
				type: "POST", //definisikan aksinya (POST/GET)
				url: "./cek.pesan.php", //definisikan urlnya
				data: {"tujuan":"autocek","user":id}, //data yang akan dikirim
				beforeSend: function(){}, //event yang akan dieksekusi sebelum pengiriman data
				complete: function(){}, //event yang akan dieksekusi setelah pengiriman data
				cache: false, //cache
				success: function(html){ //event yang akan dieksekusi setelah data berhasil dikirim
					$("#"+id).find(".last-chat").before(html);
					$("#"+id).find(".last-chat").scrollTop($(".box-chat").height());
				},
				error: function(error){} //event yang akan diseksekusi pada saat error berlangsung
			});
		}
	}
}

function chat(event,id){
	var x = event.keyCode;
	if((x==13)&&(event.altKey==true)){
		
	}
	if((x==13)&&(event.altKey==false)){
		send(id);
	}
}
function hide(id){
	if($("#"+id).hasClass("tampil")==true){ //kotak tampil
		if($("#"+id).hasClass("buka")==true){ //kotak terbuka
			$.ajax({
				type: "POST", //definisikan aksinya (POST/GET)
				url: "./box.pesan.php", //definisikan urlnya
				data: {"tipe":"buka","buka":"0","user":id}, //data yang akan dikirim
				beforeSend: function(){}, //event yang akan dieksekusi sebelum pengiriman data
				complete: function(){}, //event yang akan dieksekusi setelah pengiriman data
				cache: false, //cache
				success: function(){ //event yang akan dieksekusi setelah data berhasil dikirim
					$("#"+id).find(".box-chat").css("display","none");
					$("#"+id).find(".box-send").css("display","none");
					$("#"+id).removeClass("buka");
				},
				error: function(error){} //event yang akan diseksekusi pada saat error berlangsung
			});
		}else{ //kotak tertutup
			$.ajax({
				type: "POST", //definisikan aksinya (POST/GET)
				url: "./box.pesan.php", //definisikan urlnya
				data: {"tipe":"buka","buka":"1","user":id}, //data yang akan dikirim
				beforeSend: function(){}, //event yang akan dieksekusi sebelum pengiriman data
				complete: function(){}, //event yang akan dieksekusi setelah pengiriman data
				cache: false, //cache
				success: function(){ //event yang akan dieksekusi setelah data berhasil dikirim
					$("#"+id).find(".box-chat").css("display","block");
					$("#"+id).find(".box-send").css("display","block");
					$("#"+id).find(".alert-chat").css("display","none");
					$("#"+id).addClass("buka");
					cek(id);
					$("#"+id).find(".last-chat").scrollTop($(".box-chat").height());
				},
				error: function(error){} //event yang akan diseksekusi pada saat error berlangsung
			});
		}
	}
}
function tutup(id){
	$.ajax({
		type: "POST", //definisikan aksinya (POST/GET)
		url: "./box.pesan.php", //definisikan urlnya
		data: {"u":id,"tipe":"tutup"}, //data yang akan dikirim
		beforeSend: function(){}, //event yang akan dieksekusi sebelum pengiriman data
		complete: function(){}, //event yang akan dieksekusi setelah pengiriman data
		cache: false, //cache
		success: function(html){ //event yang akan dieksekusi setelah data berhasil dikirim
			$("#"+id).remove();
		},
		error: function(error){} //event yang akan diseksekusi pada saat error berlangsung
	});
}

function show(id){
	if($("#"+id).hasClass("tampil")==true){
		if($("#"+id).hasClass("buka")==true){
			event.preventDefault();
		}else{
			$("#"+id).find(".box-chat").css("display","block");
			$("#"+id).find(".box-send").css("display","block");
			$("#"+id).addClass("buka");
		}
	}else{
		$.ajax({
			type: "POST", //definisikan aksinya (POST/GET)
			url: "./box.pesan.php", //definisikan urlnya
			data: {"user":id,"tipe":"show"}, //data yang akan dikirim
			beforeSend: function(){}, //event yang akan dieksekusi sebelum pengiriman data
			complete: function(){}, //event yang akan dieksekusi setelah pengiriman data
			cache: false, //cache
			success: function(html){ //event yang akan dieksekusi setelah data berhasil dikirim
				$(".last-box").before(html);
				load(id);
				$("#"+id).find(".last-chat").scrollTop($(".box-chat").height());
			},
			error: function(error){} //event yang akan diseksekusi pada saat error berlangsung
		});
	}
}

function refresh(){
	$(".box").each(function(){
		var id=$(this).attr("id");
		cek(id);
	});
	$.ajax({
		type: "POST", //definisikan aksinya (POST/GET)
		url: "./box.pesan.php", //definisikan urlnya
		data: {"tipe":"cek"}, //data yang akan dikirim
		beforeSend: function(){}, //event yang akan dieksekusi sebelum pengiriman data
		complete: function(){}, //event yang akan dieksekusi setelah pengiriman data
		cache: false, //cache
		success: function(html){ //event yang akan dieksekusi setelah data berhasil dikirim
			$(".last-box").before(html);
		},
		error: function(error){} //event yang akan diseksekusi pada saat error berlangsung
	});
	setTimeout("refresh()",1000);
}
refresh();
</script>
</head>
<body>
	<div class="bungkus">
		<div class="kiri">
			<div class="pd10">
			</div>
		</div>
		<div class="kanan">
			<div class="bl">
				<ul class="teman"><b>LIST TEMAN</b>
			<?php
				$teman="select * from user where username!='$_SESSION[username]'";
				foreach($pdo->query($teman) as $rt){
			?>
					<li><a onclick="show('<?php echo $rt[username]; ?>')"><img src="" width=30 /><span><?php echo $rt[username]; ?></span></a><div class="clear"></div></li>
			<?php
				}
			?>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
		<div class="kotak-bawah">
		<?php
			$chat="select * from pesan where user1='$_SESSION[username]' and tampil=1";
			foreach($pdo->query($chat) as $rc){
		?>
			<div class="box tampil <?php if($rc[buka]==1){?>buka<?php } ?>" id="<?php echo"$rc[user2]"; ?>">
				<div class="box-atas">
					<h4 class="nama" onclick="hide('<?php echo"$rc[user2]"; ?>')"><?php echo"$rc[user2]"; ?></h4>
					<div class="pilihan">
						<span onclick="hide('<?php echo"$rc[user2]"; ?>')">-</span>
						<span onclick="tutup('<?php echo"$rc[user2]"; ?>')">x</span>
					</div>
					<div class="alert-chat" style="display:none;"></div>
				</div>
		<?php
			if($rc[buka]==1){
		?>
				<div class="box-chat">
					<div class="last-chat"></div>
				</div>
				<div class="box-send">
					<form action="" id="form<?php echo $rc[user2]; ?>" method="POST" onsubmit="return send()">
						<textarea class="pesan _552m" onkeydown="chat(event,'<?php echo $rc[user2]; ?>')" name="pesan" style="height: 15px;"></textarea>
					</form>
				</div>
			</div>
			<script>load("<?php echo $rc[user2]; ?>");</script>
		<?php
				}else{
		?>
				<div class="box-chat" style="display:none">
					<div class="last-chat"></div>
				</div>
				<div class="box-send" style="display:none">
					<form action="" id="form<?php echo $rc[user2]; ?>" method="POST" onsubmit="return send()">
						<textarea class="pesan _552m" onkeydown="chat(event,'<?php echo $rc[user2]; ?>')" name="pesan" style="height: 15px;"></textarea>
					</form>
				</div>
			</div>
		<?php
				}
			}
		?>
			<div class="last-box"></div>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>
