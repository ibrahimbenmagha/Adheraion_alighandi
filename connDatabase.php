<?php
try{ 
	$server="localhost";
	$usename="root";
	$mdp="";
	$conn= new PDO("mysql:host=$server;dbname=far3_3alighandi", $usename, $mdp);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	echo "filed ". $e->getMessage();	
}
	
