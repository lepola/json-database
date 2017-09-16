<?php
// -----------------------
// Created by lepola, 14/09/2017. 
// http://lepola.co.nf
// -----------------------
if(!isset($_SESSION)){
	session_start();
}


// Configure your username and password for database

$json_db_username = "user"; 		// Database username
$json_db_password = "password";		// Database password




// Don't edit here...
// Enable you to read protected files and write files

function json_db_login($user, $pass){
	global $json_db_username, $json_db_password;
	if(isset($_SESSION["json-db-username"])){
		if($_SESSION["json-db-username"] != $json_db_username || $_SESSION["json-db-password"] != md5($json_db_password) || $user != $json_db_username || $pass != $json_db_password){

			unset($_SESSION["json-db-username"]);
			unset($_SESSION["json-db-password"]);
			return false;

		}else{
			return true;
		}
	}else{
		if($user != $json_db_username || $pass != $json_db_password){
			return false;
		}else{
			$_SESSION["json-db-username"] = $user;
			$_SESSION["json-db-password"] = md5($pass);
			return true;
		}
	}
}


function json_db_logged_in(){
	global $json_db_username, $json_db_password;
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION["json-db-username"])){
		if($_SESSION["json-db-username"] == $json_db_username && $_SESSION["json-db-password"] == md5($json_db_password)){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function json_db_logout(){
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION["json-db-username"])){
		unset($_SESSION["json-db-username"]);
		unset($_SESSION["json-db-password"]);
	}
}


?>