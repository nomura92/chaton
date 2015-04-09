<?php
class koneksi{
	private static $servername = "localhost";
	private static $username = "root";
	private static $password = "";
	private static $nmdb="chats";
	
	private static $cont=null;
	
	public function __construct(){
		die('Init function is not allowed');
	}
	public static function conn(){
		if(null==self::$cont){
			try {
				self::$cont=new PDO("mysql:host=".self::$servername.";"."dbname=".self::$nmdb, self::$username, self::$password);
				}
			catch(PDOException $e)
				{
				die($e->getMessage());
				}
		}
		return self::$cont;
	}
	
	public static function dc(){
		self::$cont=null;
	}
}

?> 
